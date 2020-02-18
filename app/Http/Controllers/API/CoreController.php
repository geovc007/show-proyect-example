<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CoreController extends Controller
{
    public function obtener_vin($vin)
    {
        $response  = DB::table('vin')
            ->where('vin', $vin)
            ->get();
        return response()->json($response);
    }

    public function ciudades_repuestos($estado)
    {
        $response = DB::table('ciudad')
            ->select('CIU_CODIGO', 'CIU_NOMBRE')
            ->where('CIU_ESTADO', $estado)
            ->orderBy('CIU_NOMBRE')
            ->get();
        $response_unicos = $response->unique('CIU_NOMBRE')->values()->all();
        return response()->json($response_unicos);
    }

    public function modelos_repuestos($estado)
    {
        $response = DB::table('modelo')
            ->select('MOD_CODIGO', 'MOD_NOMBRE')
            ->where('MOD_ESTADO', $estado)
            ->orderBy('MOD_NOMBRE')
            ->get();

        return response()->json($response);
    }

    public function versiones_cotizador($estado, $modelo)
    {
        $anio = DB::table('version')->select('version_anio.VEA_ANIO')
            ->join('version_anio', 'version.VER_CODIGO', '=', 'version_anio.VEA_VERSION')
            ->where('version.VER_ESTADO', $estado)->where('version.VER_MODELO', $modelo)->max('VEA_ANIO');
        // Versiones
        $versiones = DB::table('version')
            ->select('version.VER_CODIGO', 'version.VER_NOMBRE', 'version_anio.VEA_ANIO', 'version_anio.VEA_PRECIO_PVP')
            ->join('version_anio', 'version.VER_CODIGO', '=', 'version_anio.VEA_VERSION')
            ->where('version.VER_ESTADO', $estado)->where('version.VER_MODELO', $modelo)
            ->where('version_anio.VEA_ANIO', $anio)->get();
        //->where('VEA_ANIO', function ($query) {$query->select(DB::raw('MAX(VEA_ANIO)'))->from('version_anio')->whereRaw('version_anio.VER_CODIGO = version.VER_CODIGO'); })->get();
        return $versiones;
    }

    public function ciudades_cotizador($estado, $tipos)
    {
        $tipo_almacen = explode('-', $tipos);
        $ciudades = DB::table('almacen')
            ->select('CIU_CODIGO', 'CIU_NOMBRE')
            ->join('ciudad', 'ciudad.CIU_CODIGO', '=', 'almacen.ALM_CIUDAD')
            ->where('ALM_ESTADO', $estado)
            ->whereIn('ALM_TIPO', $tipo_almacen)
            ->orderBy('CIU_NOMBRE')
            ->get();

        $ciudades_unicas = $ciudades->unique('CIU_CODIGO')->values()->all();
        return response()->json($ciudades_unicas);
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

    public function concesionarios_cotizador($estado, $tipos, $ciudad)
    {
        $tipo_almacen = explode('-', $tipos);
         $concesionarios = DB::table('almacen')
            ->select('ALM_EMPRESA', 'ALM_NOMBRE', 'ALM_CODIGO', 'ALM_TIPO')
            ->where('ALM_ESTADO', $estado)
            ->where('ALM_CIUDAD', $ciudad)
            ->whereIn('ALM_TIPO', $tipo_almacen)->get();
         return $concesionarios;
    }

    public function concesionarios_cotizador_empresa($estado, $tipos, $ciudad, $empresa)
    {
        $tipo_almacen = explode('-', $tipos);
         $concesionarios = DB::table('almacen')
            ->select('ALM_EMPRESA', 'ALM_NOMBRE', 'ALM_CODIGO', 'ALM_TIPO')
            ->where('ALM_ESTADO', $estado)
            ->where('ALM_CIUDAD', $ciudad)
            ->where('ALM_EMPRESA', $empresa)
            ->whereIn('ALM_TIPO', $tipo_almacen)->get();
         return $concesionarios;
    }

    public function modelo_colores_cotizador($modelo, $version)
    {
        // Anio Mayor
        $anio = DB::table('version_anio_color')->select('VAC_ANIO')
            ->where('VAC_VERSION', $version)->max('VAC_ANIO');
        // Colores
        $colores = DB::table('version_anio_color')
            ->select('VAC_COLOR', 'COL_REF_HEX', 'COL_NOMBRE')
            ->join('color', 'color.COL_CODIGO', '=', 'version_anio_color.VAC_COLOR')
            ->where('VAC_VERSION', $version)
            ->where('VAC_ANIO', $anio)->get();

        $colores_unico = $colores->unique('VAC_COLOR')->values()->all();
        return $colores_unico;
    }

    public function concesionario_informacion_cotizador($tipo, $empresa, $almacen)
    {
        $concesionario_informacion = DB::table('contacto_almacen')
            ->select('COA_EMAIL_CONTACTO', 'COA_CONTACTO')
            ->where('COA_ALM_TIPO', $tipo)
            ->where('COA_ALM_EMPRESA', $empresa)
            ->where('COA_ALM_CODIGO', $almacen)
            ->get();
        return response()->json($concesionario_informacion);
    }

    /////////////////////////////////////////////////////////
    /////////////////////////DEFAULT/////////////////////////
    /////////////////////////////////////////////////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
