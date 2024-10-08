<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function varcomlat24(){
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
                $response = $conection->select("SELECT T0.nombre as name_user, T0.rango as rank_user, T0.pais as countrie_user 
                                                FROM nikkenla_marketing.control_ci T0 
                                                WHERE T0.codigo = $codeUser AND T0.estatus = 1 AND T0.b1 = 1;");
            \DB::disconnect('nikkenla_office');

            if(sizeof($response) > 0){
                $nameUser = $response[0]->name_user;
                $rankUser = $response[0]->rank_user;
                $countrieUser = $response[0]->countrie_user;
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
}
