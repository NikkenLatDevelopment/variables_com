<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

date_default_timezone_set('America/Mexico_City');

class coreCms extends Controller{
    public function execMySQLQuery($query, $db){
        $conexion = \DB::connection($db);
            $data = $conexion->select($query);
        \DB::disconnect($db);
        return $data;
    }

    public function execMySQLQueryUpdate($query, $db){
        $conexion = \DB::connection($db);
            $data = $conexion->update($query);
        \DB::disconnect($db);
        return $data;
    }

    public function execMySQLQueryInsert($query, $db){
        $conexion = \DB::connection($db);
            $data = $conexion->insert($query);
        \DB::disconnect($db);
        return $data;
    }

    public function execMySQLQueryDelete($query, $db){
        $conexion = \DB::connection($db);
            $data = $conexion->delete($query);
        \DB::disconnect($db);
        return $data;
    }

    public function execSQLQuery($query, $db){
        $conexion = \DB::connection($db);
            $data = $conexion->select($query);
        \DB::disconnect($db);
        return $data;
    }
    
    public function execSQLQueryInsert($query, $db){
        $conexion = \DB::connection($db);
            $data = $conexion->insert($query);
        \DB::disconnect($db);
        return $data;
    }

    public function execSQLQueryUpdate($query, $db){
        $conexion = \DB::connection($db);
            $data = $conexion->update($query);
        \DB::disconnect($db);
        return $data;
    }

    public function execSQLQueryDelete($query, $db){
        $conexion = \DB::connection($db);
            $data = $conexion->delete($query);
        \DB::disconnect($db);
        return $data;
    }
    
    public function execSQLQueryStatement($query, $db){
        $conexion = \DB::connection($db);
            $data = $conexion->statement($query);
        \DB::disconnect($db);
        return $data;
    }
    
    public function execMySQLQueryStatement($query, $db){
        $conexion = \DB::connection($db);
            $data = $conexion->statement($query);
        \DB::disconnect($db);
        return $data;
    }

    public function encrypt_php71($string) {
        $secret = "13sIS4$2013*?1nF3mPN1KK3N";
        $key = md5(utf8_encode($secret), true);
        $key .= substr($key, 0, 8);
        $data = openssl_encrypt($string, 'des-ede3', $key, OPENSSL_RAW_DATA);
        return base64_encode($data);
    }

    public function decrypt_php71($string) {
        $secret = "13sIS4$2013*?1nF3mPN1KK3N";
        $key = md5(utf8_encode($secret), true);
        $key .= substr($key, 0, 8);
        $data = base64_decode($string);
        return openssl_decrypt($data , 'des-ede3' , $key, OPENSSL_RAW_DATA); 
    }

    public function getFlag($country){
        switch($country){
            case 1:
                return "colombia.png";
                break;
            case 2:
                return "mexico.png";
                break;
            case 3:
                return "peru.png";
                break;
            case 4:
                return "ecuador.png";
                break;
            case 5:
                return "panama.png";
                break;
            case 6:
                return "guatemala.png";
                break;
            case 7:
                return "salvador.png";
                break;
            case 8:
                return "costarica.png";
                break;
            case 10:
                return "chile.png";
                break;
            default:
                return "mexico.png";
                break;
        }
    }

    public function getEncriptL(Request $request){
        $sap_code = request()->sap_code;
        return encrypt($sap_code);
    }

    public function error403(){
        return view('error.403');
    }

    // public function getMontPeriod($periodo){
    //     // $periodo = "202308";
    //     $mes = substr($periodo, -2);
    //     $anio = substr($periodo, 0, 4);

    //     $mesesLtr = [
    //         '01' => "Enero",
    //         '02' => "Febrero",
    //         '03' => "Marzo",
    //         '04' => "Abril",
    //         '05' => "Mayo",
    //         '06' => "Junio",
    //         '07' => "Julio",
    //         '08' => "Agosto",
    //         '09' => "Septiembre",
    //         '10' => "Octubre",
    //         '11' => "Noviembre",
    //         '12' => "Diciembre",
    //         '13' => "Diciembre",
    //     ];

    //     return $mesesLtr[$mes] . " " . $anio;
    // }

    public function getNuwToken() {
        $token = csrf_token();
        return $token;
    }

    public function getCountryNumber($country){
        $countries_num = [
            "COL" => 1,
            "MEX" => 2,
            "PER" => 3,
            "ECU" => 4,
            "PAN" => 5,
            "GTM" => 6,
            "SLV" => 7,
            "CRI" => 8,
            "CHL" => 10,
        ];
        return $countries_num[trim($country)];
    }

    ## funciones Exigo
    public function getJWTToken(){
        $JWT_USER = config('app.JWT_USER');
        $JWT_PSWD = config('app.JWT_PSWD');
        
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

    public function JWTEncrypt($token){
        $client = new Client();
        $data = $client->post('https://apijwt.mynikken.com/api/v1/encrypt', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);
        $data = $data->getBody();
        $data = json_decode($data, true);
        $jwt_token = $data['token'];
        return $jwt_token;
    }

    public function JWTDecrypt($token, $request){
        $consultant_id = $request['consultant_id'];
        $country = $request['country'];
        $lang = $request['lang'];
        $start_period = $request['start_period'];
        $end_period = $request['end_period'];
        $email = $request['email'];

        $client = new Client();
        $data = $client->get("https://apijwt.mynikken.com/api/v1/decrypt?consultant_id=$consultant_id&country=$country&lang=$lang&start_period=$start_period&end_period=$end_period&email=$email", [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);
        $data = $data->getBody();
        $data = json_decode($data, true);
        return $data;
    }

    private function isValidSignature($url, $params, $providedSignature) {
        $secret = config('app.CUSTOM_API_KEY');
        unset($params['signature']);
        ksort($params);
        $queryString = http_build_query($params);
        $unsignedUrl = $url . '?' . $queryString;
        $expectedSignature = hash_hmac('sha256', $unsignedUrl, $secret);
        return hash_equals($expectedSignature, $providedSignature);
    }

    public function verifySignedUrl($request) {
        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https://" : "http://";
        $url = $protocol . $_SERVER['HTTP_HOST'] . strtok($_SERVER["REQUEST_URI"], '?');

        $params = $request->query();
        if (!isset($params['signature'])) {
            return response()->json(['status' => 'No signature provided'], 400);
        }
        $providedSignature = $params['signature'];
        if (isset($params['expires']) && now()->timestamp > $params['expires']) {
            return response()->json(['status' => 'La URL ha expirado'], 400);
        }
        if (!$this->isValidSignature($url, $params, $providedSignature)) {
            return response()->json(['status' => 'Firma Incorrecta'], 403);
        }
        return ['status' => 'success'];
    }

    public function define_country($country){
        $countries = [
            "MX" => "México",
            "CL" => "Chile",
            "CO" => "Colombia",
            "CA" => "Canada",
            "BE" => "Bélgica",
            "US" => "USA",
            "PA" => "Panamá",
            "PE" => "Perú",
            "CR" => "Costa Rica",
            "DE" => "Alemania",
            "EC" => "Ecuador",
            "GT" => "Guatemala",
            "SV" => "El Salvador",
            "FR" => "Francia",
            "GB" => "Reino Unido",
            "UK" => "Reino Unido",
            "HU" => "Hungría",
            "JP" => "Japón",
            "ES" => "España",
            "AT" => "Austria",
        ];
        return $countries[$country];
    }

    public function define_rank($rank){
        $ranks = [
            "0" => ucwords(__('Customer')),
            "1" => ucwords(__('Direct')),
            "2" => ucwords(__('Senior')),
            "3" => ucwords(__('Executive')),
            "4" => ucwords(__('Bronze')),
            "5" => ucwords(__('Silver')),
            "6" => ucwords(__('Gold')),
            "7" => ucwords(__('Platinum')),
            "8" => ucwords(__('Diamond')),
            "9" => ucwords(__('Royal Diamond')),
        ];
        return $ranks[$rank];
    }

    public function getMontPeriodPast($periodo){
        $anio = substr($periodo, 0, 4);
        $mes = substr($periodo, 4, 2);
        $fecha = \DateTime::createFromFormat('Y-m', "$anio-$mes");
        $fecha->sub(new \DateInterval('P12M'));
        $nuevoPeriodo = $fecha->format('Ym');
        $mes = substr($nuevoPeriodo, -2);
        $anio = substr($nuevoPeriodo, 0, 4);
        $mesesLtr = [
            '01' => ucwords(__('January')),
            '02' => ucwords(__('February')),
            '03' => ucwords(__('March')),
            '04' => ucwords(__('April')),
            '05' => ucwords(__('May')),
            '06' => ucwords(__('June')),
            '07' => ucwords(__('July')),
            '08' => ucwords(__('August')),
            '09' => ucwords(__('September')),
            '10' => ucwords(__('October')),
            '11' => ucwords(__('November')),
            '12' => ucwords(__('December')),
        ];
        return $mesesLtr[$mes] . " " . $anio;
    }

    public function getMontPeriod($periodo){
        $anio = substr($periodo, 0, 4);
        $mes = substr($periodo, 4, 2);
        $mesesLtr = [
            '01' => ucwords(__('January')),
            '02' => ucwords(__('February')),
            '03' => ucwords(__('March')),
            '04' => ucwords(__('April')),
            '05' => ucwords(__('May')),
            '06' => ucwords(__('June')),
            '07' => ucwords(__('July')),
            '08' => ucwords(__('August')),
            '09' => ucwords(__('September')),
            '10' => ucwords(__('October')),
            '11' => ucwords(__('November')),
            '12' => ucwords(__('December')),
        ];
        return $mesesLtr[$mes] . " " . $anio;
    }

    public function getshortMonth($periodo){
        $anio = substr($periodo, 0, 4);
        $mes = substr($periodo, 4, 2);
        $mesesLtr = [
            '01' => ucwords(__('Jan')),
            '02' => ucwords(__('Feb')),
            '03' => ucwords(__('Mar')),
            '04' => ucwords(__('Apr')),
            '05' => ucwords(__('May')),
            '06' => ucwords(__('Jun')),
            '07' => ucwords(__('Jul')),
            '08' => ucwords(__('Aug')),
            '09' => ucwords(__('Sep')),
            '10' => ucwords(__('Oct')),
            '11' => ucwords(__('Nov')),
            '12' => ucwords(__('Dec')),
        ];
        return $mesesLtr[$mes] . $anio[2] . $anio[3];
    }
}
