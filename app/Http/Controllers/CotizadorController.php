<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Mail\PosventaMail;
use App\Mail\CotizacionMail;
use App\Mail\CotizacionAsesorMail;
use Mail;

class CotizadorController extends Controller 
{
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            // $data = $request;
            // Validacion
            $cotizacion = DB::table('prospecto_cabecera')
                ->where('PRC_TIPO_VEHICULO', $request->tipo_vehiculo)
                ->where('PRC_CLIENTE_CEDULA', $request->cedula)
                ->where('PRC_EMPRESA_ASIGNADA', $request->empresa)
                ->where('PRC_ALMACEN_ASIGNADO', $request->almacen)
                ->where('PRC_EXONERADO', 0)
                ->where('PRC_FECHA_INGRESO', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 1 WEEK)'))
                ->where([['PRC_ESTADO_LEAD', '<>', 9], ['PRC_ESTADO_LEAD', '<>', 4]])->count();
            if($cotizacion == 0)
            {
                // Nueva Cotizacion
                // Insert Cabecera
                $insert_cab = DB::table('prospecto_cabecera')->insert(
                    [
                        'PRC_LEADGEN_ID' => $request->id,
                        'PRC_FECHA_INGRESO' => date("Y-m-d H:i:s"), 
                        'PRC_CIUDAD_ASIGNADA'=> $request->ciudad,
                        'PRC_EMPRESA_ASIGNADA'=> $request->empresa,
                        'PRC_ALMACEN_ASIGNADO' => $request->almacen,
                        'PRC_CLIENTE_CEDULA' => $request->cedula,
                        'PRC_CLIENTE_NOMBRE' => $request->nombre,
                        'PRC_CLIENTE_APELLIDO' => $request->apellido,
                        'PRC_CLIENTE_EMAIL' => $request->email,
                        'PRC_CLIENTE_DIRECCION' => $request->direccion,
                        'PRC_CLIENTE_TELEFONO' => $request->telefono,
                        'PRC_TOKEN' => $request->token,
                        'PRC_TIPO_VEHICULO' => $request->tipo_vehiculo,
                    ]
                );
                if($insert_cab == true)
                {
                    $insert_det = DB::table('prospecto_detalle')->insert(
                        [
                            'PRC_LEADGEN_ID' => $request->id, 
                            'PRD_EMPRESA_ASIGNADA' => $request->empresa, 
                            'PRD_ALMACEN_ASIGNADO' => $request->almacen,
                            'PRD_MODELO' => $request->vehiculo_modelo, 
                            'PRD_VERSION' => $request->vehiculo_version, 
                            'PRD_ANIO' => $request->vehiculo_color, 
                            'PRD_COLOR' => $request->vehiculo_anio, 
                            'PRD_PRECIO' => $request->vehiculo_precio, 
                            'PRD_TOTAL' => $request->vehiculo_precio, 
                            'PRD_FECHA' => date("Y-m-d H:i:s"), 
                            'PRD_ID_MAIL' => $request->id
                        ]
                    );
                    if($insert_det == true)
                    {
                        $data = [
                            'subject'   => 'Cotizacion Hyundai - '.strtoupper($request->vehiculo_modelo_nombre),
                            'from'      => 'hyundai@curbe.com.ec',
                            'from_name' => 'Hyundai Ecuador',
                            'modelo' => $request->vehiculo_modelo_nombre,
                            'cliente' => $request->nombre." ".$request->apellido,
                            'mod' => $request->vehiculo_modelo
                        ];
                        Mail::to($request->email, $request->nombre)->send(new CotizacionMail($data));
                        $data = [
                            'subject'   => 'Cotizacion Hyundai - '.strtoupper($request->vehiculo_modelo_nombre),
                            'from'      => 'hyundai@curbe.com.ec',
                            'from_name' => 'Hyundai Ecuador',
                            'contacto' => $request->contacto_nombre,
                            'empresa' => $request->empresa,
                            'modelo' => strtoupper($request->vehiculo_modelo_nombre),
                            'cliente' => $request->nombre." ".$request->apellido,
                            'cedula' => $request->cedula,
                            'nombre' => $request->nombre,
                            'apellido' => $request->apellido,
                            'email' => $request->email,
                            'direccion' => $request->direccion,
                            'telefono' => $request->telefono,
                            'ciudad' => $request->ciudad_nombre,
                            'concesionario' => $request->concesionario_nombre,
                            'color' => $request->color_nombre,
                            'version' => strtoupper($request->version_nombre),
                            'anio' => $request->vehiculo_anio,
                            'precio' => $request->vehiculo_precio
                        ];
                        Mail::to($request->contacto_email, $request->contacto_nombre)->send(new CotizacionAsesorMail($data));
                        $json = [ 'status'=> 'Ok', 'respuesta'=> 'Cotizacion Ingresada Correctamente', 'cotizacion'=> $request->id, "estado"=> $cotizacion];
                        return $json;
                    }
                    else
                    {
                        $json = [ 'status'=> 'Error', 'respuesta'=> 'Error al Ingresar Cotizacion', 'cotizacion'=> 0, "estado"=> $cotizacion];
                        return $json;
                    }
                }
                else
                {
                    $json = [ 'status'=> 'Error', 'respuesta'=> 'Error al Ingresar Cotizacion', 'cotizacion'=> 0, "estado"=> $cotizacion];
                    return $json;
                }
            }
            else
            {
                // Nuevo Detalle
                $info_cab = DB::table('prospecto_cabecera')
                    ->select('PRC_LEADGEN_ID')
                    ->where('PRC_TIPO_VEHICULO', $request->tipo_vehiculo)
                    ->where('PRC_CLIENTE_CEDULA', $request->cedula)
                    ->where('PRC_EMPRESA_ASIGNADA', $request->empresa)
                    ->where('PRC_ALMACEN_ASIGNADO', $request->almacen)
                    ->where('PRC_EXONERADO', 0)
                    ->where('PRC_FECHA_INGRESO', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 1 WEEK)'))
                    ->where([['PRC_ESTADO_LEAD', '<>', 9], ['PRC_ESTADO_LEAD', '<>', 4]])
                    ->orderBy('PRC_FECHA_INGRESO', 'desc')->limit(1)->get();
                $cod_cab = '';
                foreach($info_cab as $t){
                    $cod_cab = $t->PRC_LEADGEN_ID;
                }
                $modelo_ver = '';
                $version_ver = '';
                $anio_ver = '';
                $color_ver = '';
                $verifica_detalle = DB::table('prospecto_detalle')
                    ->select('PRD_SECUENCIA', 'PRD_MODELO', 'PRD_VERSION', 'PRD_ANIO', 'PRD_COLOR')
                    ->where('PRC_LEADGEN_ID', $cod_cab)->get();
                $secuencia = 0;
                foreach($verifica_detalle as $t){
                    $secuencia = $t->PRD_SECUENCIA;
                    $modelo_ver = $t->PRD_MODELO;
                    $version_ver = $t->PRD_VERSION;
                    $anio_ver = $t->PRD_ANIO;
                    $color_ver = $t->PRD_COLOR;
                }
                if($modelo_ver == $request->vehiculo_modelo && $version_ver == $request->vehiculo_version && $anio_ver == $request->vehiculo_color)
                {
                    $data = [
                        'subject'   => 'Cotizacion Hyundai - '.strtoupper($request->vehiculo_modelo_nombre),
                        'from'      => 'hyundai@curbe.com.ec',
                        'from_name' => 'Hyundai Ecuador',
                        'modelo' => $request->vehiculo_modelo_nombre,
                        'cliente' => $request->nombre." ".$request->apellido,
                        'mod' => $request->vehiculo_modelo
                    ];
                    Mail::to($request->email, $request->nombre)->send(new CotizacionMail($data));
                    $data = [
                        'subject'   => 'Cotizacion Hyundai - '.strtoupper($request->vehiculo_modelo_nombre),
                        'from'      => 'hyundai@curbe.com.ec',
                        'from_name' => 'Hyundai Ecuador',
                        'contacto' => "Usuario Hyundai",
                        'empresa' => $request->empresa,
                        'modelo' => strtoupper($request->vehiculo_modelo_nombre),
                        'cliente' => $request->nombre." ".$request->apellido,
                        'cedula' => $request->cedula,
                        'nombre' => $request->nombre,
                        'apellido' => $request->apellido,
                        'email' => $request->email,
                        'direccion' => $request->direccion,
                        'telefono' => $request->telefono,
                        'ciudad' => $request->ciudad_nombre,
                        'concesionario' => $request->concesionario_nombre,
                        'color' => $request->color_nombre,
                        'version' => strtoupper($request->version_nombre),
                        'anio' => $request->vehiculo_anio,
                        'precio' => $request->vehiculo_precio
                    ];
                    Mail::to($request->email, $request->nombre)->send(new CotizacionAsesorMail($data));
                    // Ya existe modelo-detalle-anio repetido solo envio ok
                    $json = [ 'status'=> 'Ok', 'respuesta'=> 'Cotizacion Ingresada Correctamente', 'cotizacion'=> $cod_cab, "estado"=> $cotizacion];
                    return $json;
                }
                else
                {
                    // Creo cotizacion detalle nuevo
                    
                    $insert_det2 = DB::table('prospecto_detalle')->insert(
                        [
                            'PRC_LEADGEN_ID' => $request->id,
                            'PRD_SECUENCIA' => $secuencia + 1,
                            'PRD_EMPRESA_ASIGNADA' => $request->empresa, 
                            'PRD_ALMACEN_ASIGNADO' => $request->almacen,
                            'PRD_MODELO' => $request->vehiculo_modelo, 
                            'PRD_VERSION' => $request->vehiculo_version, 
                            'PRD_ANIO' => $request->vehiculo_color, 
                            'PRD_COLOR' => $request->vehiculo_anio, 
                            'PRD_PRECIO' => $request->vehiculo_precio, 
                            'PRD_TOTAL' => $request->vehiculo_precio, 
                            'PRD_FECHA' => date("Y-m-d H:i:s"), 
                            'PRD_ID_MAIL' => $request->id
                        ]
                    );
                    if($insert_det2 == true)
                    {
                        $data = [
                            'subject'   => 'Cotizacion Hyundai, '.strtoupper($request->vehiculo_modelo_nombre),
                            'from'      => 'hyundai@curbe.com.ec',
                            'from_name' => 'Hyundai Ecuador',
                            'modelo' => $request->vehiculo_modelo_nombre,
                            'cliente' => $request->nombre." ".$request->apellido,
                            'mod' => $request->vehiculo_modelo
                        ];
                        Mail::to($request->email, $request->nombre)->send(new CotizacionMail($data));
                        $data = [
                            'subject'   => 'Cotizacion Hyundai - '.strtoupper($request->vehiculo_modelo_nombre),
                            'from'      => 'hyundai@curbe.com.ec',
                            'from_name' => 'Hyundai Ecuador',
                            'contacto' => "Usuario Hyundai",
                            'empresa' => $request->empresa,
                            'modelo' => strtoupper($request->vehiculo_modelo_nombre),
                            'cliente' => $request->nombre." ".$request->apellido,
                            'cedula' => $request->cedula,
                            'nombre' => $request->nombre,
                            'apellido' => $request->apellido,
                            'email' => $request->email,
                            'direccion' => $request->direccion,
                            'telefono' => $request->telefono,
                            'ciudad' => $request->ciudad_nombre,
                            'concesionario' => $request->concesionario_nombre,
                            'color' => $request->color_nombre,
                            'version' => strtoupper($request->version_nombre),
                            'anio' => $request->vehiculo_anio,
                            'precio' => $request->vehiculo_precio
                        ];
                        Mail::to($request->email, $request->nombre)->send(new CotizacionAsesorMail($data));
                        $json = [ 'status'=> 'Ok', 'respuesta'=> 'Cotizacion Ingresada Correctamente', 'cotizacion'=> $cod_cab, "estado"=> $cotizacion];
                        return $json;
                    }
                    else
                    {
                        $json = [ 'status'=> 'Error', 'respuesta'=> 'Error al Ingresar Cotizacion', 'cotizacion'=> 0, "estado"=> $cotizacion];
                        return $json;
                    }
                }
            }
        } catch (Throwable $th) {
            //throw $th;
            $json = [ 'status'=> 'Error', 'respuesta'=> 'Error al Ingresar Cotizacion, catch', 'cotizacion'=> 0];
            return $json;
        }
    }
}
