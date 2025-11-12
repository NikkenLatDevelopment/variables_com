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
                'lang'
            ));
        }
        catch (Exception $e){
            //Guardar mensaje de error
            $this->aveLogError($e, "Informes Seminario Diamante MyNIKKEN");
            //Guardar mensaje de error
        
            return $e;
        }
    }

    public function pwp_login(){
        $JWT_USER = config('app.EXIGO_SRV_USER');
        $JWT_PSWD = config('app.EXIGO_SRV_PASS');
        
        $body = [
            "email" => "$JWT_USER",
            "password" => "$JWT_PSWD"
        ];
        $client = new Client();
        $data = $client->post('https://apijwt.mynikken.com/api/v1/login', [
            'json' => $body 
        ]);
        $data = $data->getBody();
        $data = json_decode($data, true);
        $jwt_token = $data['token'];
        return $jwt_token;
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
            
            // $jwt_token = $this->pwp_login();
            // return $jwt_token;

            # obtener pwp del usuario segun Exigo
            // $client = new Client();
            // $autorization_exigo = base64_encode(config('app.API_EXIGO_USER') . '@nikken:' . config('app.API_EXIGO_PASS'));
            // $data = $client->get(config('app.API_EXIGO_ENV') . "3.0/customers/site?customerID=$code", [
            //     'headers' => [
            //         'Authorization' => "Basic $autorization_exigo",
            //     ],
            // ]);
            // $result = $data->getBody();
            // $result = json_decode($result);
            // $pwp = $result->webAlias;
            $pwp = "";

            
            # Obtener la foto del usuario
            // $user_picture = $client->get("https://store.nikken.com/api/user/$pwp", [
            //     'headers' => [
            //         'NikkenExigo-Signature' => "$login_pwp",
            //     ],
            // ]);
            // $user_picture = $user_picture->getBody();
            // $user_picture = json_decode($user_picture);
            // $user_picture = $user_picture->data;
            // $user_picture = $user_picture->user_picture;
            // if(trim($user_picture) == ''){
            //     $user_picture = "https://daea.ulpgc.es/wp-content/themes/daea-child/images/avatar.png";
            // }
            // $data_gral['pwp'] = "https://$pwp.devlivenikken.net/$pwp/Shopping/ItemList";
            $user_picture = "https://daea.ulpgc.es/wp-content/themes/daea-child/images/avatar.png";
            $data_gral['pwp'] = "";
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

    public function varcomusa_impresiones(){
        if(empty(request()->code)){
            return "Informes Seminario Diamante MyNIKKEN";
        }
        try{
            $code = request()->code;
            $period = request()->period;
            if(!is_numeric($code)){
                $code = base64_decode($code);
            }
            $codeUser = $code;

            $conection = \DB::connection('SQL73');
                $response = $conection->select("SELECT 
                                                    AssociateName as name_user, 
                                                    Country as countrie_user, 
                                                    MAX(b.Rango) as rank_user 
                                                FROM LAT_MyNIKKEN.dbo.Distributors_MD a WITH(NOLOCK) 
                                                JOIN LAT_MyNIKKEN_TEST.dbo.Rangos_Avance_USA b WITH(NOLOCK) ON 
                                                    a.AssociateID = b.numci 
                                                WHERE Distributor_Status='D' 
                                                AND AssociateID = $codeUser
                                                GROUP BY AssociateName, Country;");
            \DB::disconnect('SQL73');

            if(sizeof($response) < 1){
                $conection = \DB::connection('nikkenla_office');
                    $response = $conection->select("SELECT T0.nombre as name_user, T0.rango as rank_user, T0.pais as countrie_user FROM nikkenla_marketing.control_ci T0 WHERE T0.codigo = $codeUser AND T0.estatus = 1 AND T0.b1 = 1;");
                \DB::disconnect('nikkenla_office');
            }

            if(sizeof($response) > 0){
                $nameUser = $response[0]->name_user;
                $rankUser = $response[0]->rank_user;
                $countrieUser = $response[0]->countrie_user;

                if($codeUser == "28162400"){ $rankUser = "Diamante Real"; }
            }
            else{
                return "lo sentimos, el código $codeUser no existe o se encuentra inactivo"; 
            }
            return view('varcomusa_impresiones.index', compact('code', 'nameUser', 'rankUser', 'countrieUser', 'codeUser', 'period'));
        }
        catch (Exception $e){
            //Guardar mensaje de error
            $this->aveLogError($e, "Informes Seminario Diamante MyNIKKEN");
            //Guardar mensaje de error
        
            return $e;
        }
    }
}
