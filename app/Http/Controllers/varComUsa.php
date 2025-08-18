<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use App\Http\Controllers\coreCms;
use GuzzleHttp\Client;

class varComUsa extends Controller{
    public function varcomusa(){
        $core = new coreCms();
        // return request();
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

            return view('varcomusa.index', compact(
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
        $core = new coreCms();
        $jwt_token = $core->getJWTToken();
        $decrypted = $core->JWTDecrypt($jwt_token, request());
        if(empty($decrypted['consultant_id'])){
            return "Informes Seminario Diamante MyNIKKEN";
        }
        try{
            $code = $decrypted['consultant_id'];
            $period = $decrypted['start_period'];
            $codeUser = $code;
            $lang = $decrypted['lang'];
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
            # obtener pwp del usuario segun Exigo
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
            # obtener el token para poder extraer la foto del usuario
            $EXIGO_SRV_USER = config('app.EXIGO_SRV_USER');
            $EXIGO_SRV_PASS = config('app.EXIGO_SRV_PASS');
            $body = [
                "username" => $EXIGO_SRV_USER,
                "password" => $EXIGO_SRV_PASS,
            ];
            $login_pwp = $client->post('https://store.nikken.com/api/auth/login', [
                'json' => $body
            ]);
            $login_pwp = $login_pwp->getBody();
            $login_pwp = json_decode($login_pwp);
            $login_pwp = $login_pwp->token;
            # Obtener la foto del usuario
            $user_picture = $client->get("https://store.nikken.com/api/user/$pwp", [
                'headers' => [
                    'NikkenExigo-Signature' => "$login_pwp",
                ],
            ]);
            $user_picture = $user_picture->getBody();
            $user_picture = json_decode($user_picture);
            $user_picture = $user_picture->data;
            $user_picture = $user_picture->user_picture;
            if(trim($user_picture) == ''){
                $user_picture = "https://daea.ulpgc.es/wp-content/themes/daea-child/images/avatar.png";
            }
            $data_gral['pwp'] = "https://$pwp.devlivenikken.net/$pwp/Shopping/ItemList";
            if(sizeof($response) > 0){
                $nameUser = $response[0]->name_user;
                $rankUser = $response[0]->rank_user;
                $countrieUser = $response[0]->countrie_user;
                if($codeUser == "28162400"){ $rankUser = "Diamante Real"; }
            }
            else{
                return "lo sentimos, el cógigo $codeUser no existe o se encuentra inactivo"; 
            }
            return view('varcomusa12.index', compact('code', 'nameUser', 'rankUser', 'countrieUser', 'codeUser', 'period', 'data_gral', 'portada', 'lang', 'user_picture'));
        }
        catch (Exception $e){
            return "Informes Seminario Diamante MyNIKKEN";
        }
    }
}
