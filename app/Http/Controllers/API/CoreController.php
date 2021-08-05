<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CoreController extends Controller
{
    //////////////////////////////////////////////////////////////////////////////
    /////////////////////////////CIUDADES HYUNDAI/////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////

    public function ciudades_repuestos_hyundai($estado)
    {
        $response = DB::table('ciudad')
            ->select('CIU_CODIGO', 'CIU_NOMBRE')
            ->where('CIU_ESTADO_HYUNDAI', $estado)
            ->orderBy('CIU_NOMBRE')
            ->get();
        $response_unicos = $response->unique('CIU_NOMBRE')->values()->all();
        return response()->json($response_unicos);
    }

    public function ciudades($estado, $tipo, $marca)
    {
        $tipo_almacen = explode('-', $tipo);
        $ciudades = DB::table('almacen')
            ->select('CIU_CODIGO', 'CIU_NOMBRE')
            ->join('empresa1', 'empresa1.EMP_CODIGO', '=', 'almacen.ALM_EMPRESA')
            ->join('ciudad', 'ciudad.CIU_CODIGO', '=', 'almacen.ALM_CIUDAD')
            ->where('ALM_ESTADO', $estado)
            ->whereIn('ALM_TIPO', $tipo_almacen)
            ->where('EMP_MARCA', $marca)
            ->orderBy('CIU_NOMBRE')
            ->get();

        $ciudades_unicas = $ciudades->unique('CIU_CODIGO')->values()->all();
        return response()->json($ciudades_unicas);
    }

    public function concesionarios($estado, $tipo, $marca, $ciudad)
    {
        $tipo_almacen = explode('-', $tipo);
         $concesionarios = DB::table('almacen')
            ->select('ALM_EMPRESA', 'EMP_NOMBRE_COMERCIAL', 'ALM_NOMBRE', 'ALM_CODIGO', 'ALM_TIPO')
            ->join('empresa1', 'empresa1.EMP_CODIGO', '=', 'almacen.ALM_EMPRESA')
            ->where('ALM_ESTADO', $estado)
            ->where('ALM_CIUDAD', $ciudad)
            ->where('EMP_MARCA', $marca)
            ->whereIn('ALM_TIPO', $tipo_almacen)->get();
         return $concesionarios;
    }

    public function concesionario_informacion($tipo, $empresa, $almacen)
    {
        $concesionario_informacion = DB::table('contacto_almacen')
            ->select('COA_EMAIL_CONTACTO', 'COA_CONTACTO')
            ->where('COA_ALM_TIPO', $tipo)
            ->where('COA_ALM_EMPRESA', $empresa)
            ->where('COA_ALM_CODIGO', $almacen)
            ->get();
        return response()->json($concesionario_informacion);
    }

    public function ciudades_cotizador_empresa($estado, $tipos, $empresa)
    {
        $tipo_almacen = explode('-', $tipos);
        $ciudades = DB::table('ciudad')
            ->select('CIU_CODIGO', 'CIU_NOMBRE')
            ->join('almacen', 'ciudad.CIU_CODIGO', '=', 'almacen.ALM_CIUDAD')
            ->where('ALM_ESTADO', $estado)
            ->where('ALM_EMPRESA', $empresa)
            ->whereIn('ALM_TIPO', $tipo_almacen)
            ->orderBy('CIU_NOMBRE')
            ->get();

        $ciudades_unicas = $ciudades->unique('CIU_CODIGO')->values()->all();
        return response()->json($ciudades_unicas);
    }

}
