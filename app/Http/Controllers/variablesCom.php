<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Storage;

date_default_timezone_set('America/Mexico_City');

class variablesCom extends Controller{
    public function varcomusa24(){
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
            return view('varcomusa24.index', compact('code', 'nameUser', 'rankUser', 'countrieUser', 'codeUser', 'period'));
        }
        catch (Exception $e){
            //Guardar mensaje de error
            $this->aveLogError($e, "Informes Seminario Diamante MyNIKKEN");
            //Guardar mensaje de error
        
            return $e;
        }
    }

    public function varcomusa24nalat(){
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

            $conection = \DB::connection('nikkenla_office');
                $response = $conection->select("SELECT 'NIKKEN LATAM' as name_user, T0.rango as rank_user, T0.pais as countrie_user FROM nikkenla_marketing.control_ci T0 WHERE T0.codigo = $codeUser AND T0.estatus = 1 AND T0.b1 = 1;");
                //$response = $conection->select("SELECT T1.name as name_user, T0.rango as rank_user, T0.pais as countrie_user FROM nikkenla_marketing.control_ci T0 INNER JOIN nikkenla_panel.temp_seminars T1 ON T0.codigo = T1.code WHERE T0.codigo = $codeUser");
            \DB::disconnect('nikkenla_office');
            
            if(sizeof($response) > 0){
                $nameUser = $response[0]->name_user;
                $rankUser = $response[0]->rank_user;
                $countrieUser = $response[0]->countrie_user;

                if($codeUser == "28162400"){ $rankUser = "Diamante Real"; }
            }
            else{
                return "lo sentimos, el cógigo $codeUser no existe o se encuentra inactivo"; 
            }
            
            return view('varcomusa24nalat.index', compact('code', 'nameUser', 'rankUser', 'countrieUser', 'codeUser', 'period'));
        }
        catch (Exception $e){
            //Guardar mensaje de error
            $this->aveLogError($e, "Informes Seminario Diamante MyNIKKEN");
            //Guardar mensaje de error
        
            return $e;
        }
    }

    private function isValidSignature($url, $params, $providedSignature) {
        $secret = config('app.CUSTOM_API_KEY');
        unset($params['signature']);
        // ksort($params);
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
            return ['status' => 'No signature provided'];
        }
        $providedSignature = $params['signature'];
        if (isset($params['expires']) && now()->timestamp > $params['expires']) {
            return ['status' => 'La URL ha expirado'];
        }

        if (!$this->isValidSignature($url, $params, $providedSignature)) {
            return ['status' => 'Firma Incorrecta'];
        }
        return ['status' => 'success'];
    }

    public function accesVariablesCom(){
        $data = $this->verifySignedUrl(request());
        $status = $data['status'];
        if($status != "success"){
            return redirect("https://micrositiosnikken.nikkenlatam.com/error403");
        }
        $code = request()->code;
        $period = request()->period;
        session(['code' => $code]);
        session(['period' => $period]);
        return redirect('varcomlat24');
    }

    public function varcomlat24(){
        if(empty(session('code'))){
            return redirect("https://micrositiosnikken.nikkenlatam.com/error403");
        }
        try{
            $code = session('code');
            $period = session('period');
            $codeUser = $code;

            $conection = \DB::connection('nikkenla_office');
                $response = $conection->select("SELECT T0.nombre as name_user, T0.rango as rank_user, T0.pais as countrie_user, correo
                                                FROM nikkenla_marketing.control_ci T0 
                                                WHERE T0.codigo = $codeUser AND T0.estatus = 1 AND T0.b1 = 1;");
            \DB::disconnect('nikkenla_office');

            if(sizeof($response) > 0){
                $nameUser = $response[0]->name_user;
                $rankUser = $response[0]->rank_user;
                $countrieUser = $response[0]->countrie_user;
                $correo = $response[0]->correo;

                session([
                    'nameUser' => $response[0]->name_user,
                    'rankUser' => $response[0]->rank_user,
                    'countrieUser' => $response[0]->countrie_user,
                    'correo' => $response[0]->correo,
                ]);
            }
            else{
                return "lo sentimos, el cógigo $codeUser no existe o se encuentra inactivo"; 
            }
            return view('varcomlat24.index', compact('code', 'nameUser', 'rankUser', 'countrieUser', 'codeUser', 'period'));
        }
        catch (Exception $e){
            //Guardar mensaje de error
            $this->aveLogError($e, "Informes Seminario Diamante MyNIKKEN");
            //Guardar mensaje de error
        
            return $e;
        }
    }

    public function mostrarReporte($variable){
        $resultados = DB::connection('SQL73')->select("
        SELECT 
            [associateId],
            [nombre],
            [periodo],
            [VOtotal],
            [VOcomisionable],
            [Ranking],
            [pais],
            [rango],
            [%Comisionable] AS Comisionable
        FROM LAT_MyNIKKEN.dbo.seminarioDiamante_reportPDF 
        WHERE associateId = ?
        ORDER BY [periodo] ASC", [$variable]);

        // Enviar los resultados a la vista
        return view('reporte', compact('resultados'));
    }

    public function generarPDF($variable){
        // Realizar la consulta de datos
        $resultados = DB::connection('SQL73')->select("
            SELECT 
                [associateId],
                [nombre],
                [periodo],
                [VOtotal],
                [VOcomisionable],
                [Ranking],
                [pais],
                [rango],
                [%Comisionable] AS Comisionable
            FROM LAT_MyNIKKEN.dbo.seminarioDiamante_reportPDF 
            WHERE associateId = ?
            ORDER BY [periodo] ASC", [$variable]);

            if (!empty($resultados)) {
                $associateId = $resultados[0]->associateId;
                $pais = $resultados[0]->pais;
            } else {
                return response()->json(['error' => 'No se encontraron datos para este Associate ID.']);
            }    
        // Verificar si la imagen del gráfico está guardada
        $imagenGrafico = storage_path('app/public/images/vo_comisionable_chart.png');
        if (!file_exists($imagenGrafico)) {
            // Maneja el caso en que la imagen no esté disponible
            $imagenGrafico = null;
        }

        // Cargar la vista 'reporte' y pasar los datos y la imagen del gráfico
        $pdf = Pdf::loadView('reporte', compact('resultados', 'imagenGrafico'))
        ->setPaper('a4', 'portrait')
        ->setOption('dpi', 96) // Asegúrate de que no sea demasiado alta la resolución
        ->setOption('isHtml5ParserEnabled', true)
        ->setOption('isPhpEnabled', true)
        ->setOption('isRemoteEnabled', true)
        ->setOption('defaultFont', 'Arial')
        ->setOption('isFontSubsettingEnabled', true)
        ->setOption('enable_auto_scaling', true); // Permite la escala automática
        // Devolver el PDF como descarga
        $fileName = "{$associateId}_{$pais}.pdf";
        

        return $pdf->download($fileName);
    }

    private function generateSignature($url, $secret) {
        return hash_hmac('sha256', $url, $secret);
    }

    private function generateSignedUrl($baseUrl, $params) {
        $secret = config('app.CUSTOM_API_KEY');
        $expiration = now()->addMinutes(24)->timestamp;
        $params['expires'] = $expiration;
        $queryString = http_build_query($params);
        $url = $baseUrl . '?' . $queryString;
        $signature = $this->generateSignature($url, $secret);
        return $url . '&signature=' . $signature;
    }

    public function printPdf(){
        $period = session('period'); $period = substr($period, 0, 4) . '-' . substr($period, 4, 2);
        $codeUser = session('code');
        $nameUser = session('nameUser');
        $rankUser = session('rankUser');
        $countrieUser = session('countrieUser');
        $correo = session('correo');
        $paises = [
            1 => 'Colombia',
            2 => 'México',
            3 => 'Perú',
            4 => 'Ecuador',
            5 => 'Panamá',
            6 => 'Guatemala',
            7 => 'El Salvador',
            8 => 'Costa Rica',
            9 => 'Latinoamérica',
            10 => 'Chile',
        ];
        $countrieUser = $paises[$countrieUser];
        $array = [
            'code' => $codeUser,
            'country' => $countrieUser,
            'email' => $correo,
            'name' => $nameUser,
            // 'period' => $period,
            // 'rank' => $rankUser,
        ];
        
        $target = $this->generateSignedUrl('https://informescom.nikkenlatam.com/report', $array);
        return redirect($target);
    }
}