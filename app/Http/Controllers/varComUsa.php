<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use App\Http\Controllers\coreCms;
use GuzzleHttp\Client;

class varComUsa extends Controller{
    public function varcomusa(){
        $core = new coreCms();

        if(empty(request()->code)){
            return "Informes Seminario Diamante MyNIKKEN";
        }
        try{
            $code = request()->code;
            $period = request()->period;
            $lang = request()->lang;
            App::setLocale($lang);

            $ciinfo = $core->execSQLQuery("EXEC LAT_MyNIKKEN.dbo.reporteBoss_datosGenerales $code;", "SQL73");
            $data_gral = [];
            $data_gral['name_user'] = $ciinfo[0]->name_user;
            $data_gral['code'] = $code;
            $data_gral['countrie_user'] = $core->define_country($ciinfo[0]->countrie_user);
            $data_gral['rank_user'] = $core->define_rank($ciinfo[0]->rank_user);
            $data_gral['period_i'] = $core->getMontPeriodPast($period);
            $data_gral['period_f'] = $core->getMontPeriod($period);
            
            $portada = $core->execSQLQuery("EXEC LAT_MyNIKKEN_TEST.dbo.ConteoComercialD1_usa $code, $period;", "SQL73");

            $compras_usa = $core->execSQLQuery("EXEC LAT_MyNIKKEN_TEST.dbo.Compras_usa $code, $period", 'SQL73');
            $incorporaciones_usa = $core->execSQLQuery("EXEC LAT_MyNIKKEN_TEST.dbo.Incorporaciones_usa $code, $period", 'SQL73');
            $ConteoComercial_usa = $portada;

            return view('varcomusa12.index', compact(
                'core',
                'code', 
                'period', 
                'data_gral', 
                'portada', 
                // hoja1
                'compras_usa',
                'incorporaciones_usa',
                'ConteoComercial_usa',
            ));
        }
        catch (Exception $e){
            //Guardar mensaje de error
            $this->aveLogError($e, "Informes Seminario Diamante MyNIKKEN");
            //Guardar mensaje de error
        
            return $e;
        }
    }

    public function varcomusa12(){
        if(empty(request()->code)){
            return "Informes Seminario Diamante MyNIKKEN";
        }
        try{
            $core = new coreCms();
            $code = request()->code;
            $period = request()->period;
            if(!is_numeric($code)){
                $code = base64_decode($code);
            }
            $codeUser = $code;
            $lang = request()->lang;
            App::setLocale($lang);
            
            $response = $core->execSQLQuery("EXEC LAT_MyNIKKEN.dbo.reporteBoss_datosGenerales $codeUser;", "SQL73");
            $ciinfo = $response;
            $data_gral = [];
            $data_gral['name_user'] = $ciinfo[0]->name_user;
            $data_gral['code'] = $code;
            $data_gral['countrie_user'] = $core->define_country($ciinfo[0]->countrie_user);
            $data_gral['rank_user'] = $core->define_rank($ciinfo[0]->rank_user);
            $data_gral['period_i'] = $core->getMontPeriodPast($period);
            $data_gral['period_f'] = $core->getMontPeriod($period);
            
            $portada = $core->execSQLQuery("EXEC LAT_MyNIKKEN_TEST.dbo.ConteoComercialD1_usa $code, $period;", "SQL73");
            
            $client = new Client();
            $autorization_exigo = base64_encode(config('app.API_EXIGO_USER') . '@nikken:' . config('app.API_EXIGO_PASS'));
            $data = $client->get(config('app.API_EXIGO_ENV') . "3.0/customers/site?customerID=$code", [
                'headers' => [
                    'Authorization' => "Basic $autorization_exigo",
                ],
            ]);
            $result = $data->getBody();
            $result = json_decode($result);
            $pwp = $result->webAlias;
            $data_gral['pwp'] = "https://$pwp.devlivenikken.net/$pwp/Shopping/ItemList";

            // $JWT_USER = config('app.JWT_USER');
            // $JWT_PSWD = config('app.JWT_PSWD');
            
            // $body = [
            //     "email" => "$JWT_USER",
            //     "password" => "$JWT_PSWD"
            // ];
            // $client = new Client();
            // $data = $client->post('https://apisjwtprod.nikken.com/api/v1/login', [
            //     'json' => $body 
            // ]);
            // $data = $data->getBody();
            // $data = json_decode($data, true);
            // $jwt_token = $data['token'];
            // // return $jwt_token;

            // $client = new Client();
            // $response = $client->get('https://apijwt.mynikken.com/api/v1/pwp_request', [
            //     'headers' => [
            //         'Authorization' => 'Bearer ' . $jwt_token,
            //         'Content-Type'  => 'application/json'
            //     ],
            //     'json' => [
            //         'pwp' => $pwp,
            //         'consultant_id' => $code,
            //     ],
            // ]);
            // $body = $response->getBody();
            // $data = json_decode($body, true);
            // return $data;

            if(sizeof($response) > 0){
                $nameUser = $response[0]->name_user;
                $rankUser = $response[0]->rank_user;
                $countrieUser = $response[0]->countrie_user;

                if($codeUser == "28162400"){ $rankUser = "Diamante Real"; }
            }
            else{
                return "lo sentimos, el cógigo $codeUser no existe o se encuentra inactivo"; 
            }
            return view('varcomusa12.index', compact('code', 'nameUser', 'rankUser', 'countrieUser', 'codeUser', 'period', 'data_gral', 'portada', 'lang'));
        }
        catch (Exception $e){
            return "Informes Seminario Diamante MyNIKKEN";
        }
    }
}
