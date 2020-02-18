<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Mail\PesadosMail;
use Mail;

class FormularioController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pesados(Request $request)
    {
        //
        try {
            $pesados = DB::table('formulario_pesados')->insert(
                [
                    'codigo_secundario' => $request->id,
                    'nombre'=> $request->nombre,
                    'apellido' => $request->apellido,
                    'celular' => $request->celular,
                    'email' => $request->email,
                    'modelo' => $request->vehiculo_modelo_nombre,
                    'comentarios' => $request->comentarios,
                    'fecha_creacion' => date("Y-m-d H:i:s") 
                ]
            );
            // Verificacion
            if($pesados == true)
            {
                $data = [
                    'subject'   => 'Informacion de Contacto - '.strtoupper($request->vehiculo_modelo_nombre),
                    'from'      => 'hyundai@curbe.com.ec',
                    'from_name' => 'Hyundai Ecuador',
                    'contacto' => 'Juan Crespo',
                    'nombre'=> $request->nombre,
                    'apellido' => $request->apellido,
                    'celular' => $request->celular,
                    'email' => $request->email,
                    'modelo' => $request->vehiculo_modelo_nombre,
                    'comentarios' => $request->comentarios,
                    'fecha_creacion' => date("Y-m-d H:i:s")
                ];
                // Obtener Remitentes
                Mail::to($request->email, "Juan Crespo")->send(new PesadosMail($data));
                $json = [ 'status'=> 'Ok', 'respuesta'=> 'Formulario Ingresado Correctamente'];
                return $json;
            }
            else
            {
                $json = [ 'status'=> 'Error', 'respuesta'=> 'Error al Ingresar Formulario'];
                return $json;
            }

        } catch (Throwable $th) {
            //throw $th;
            $json = [ 'status'=> 'Error', 'respuesta'=> 'Error al Ingresar Formulario Pesados, catch'];
            return $json;
        }
    }

    public function repuestos(Request $request)
    {
        //
        try {
            $repuestos = DB::table('formulario_repuestos')->insert(
                [
                    'codigo_secundario' => $request->id,
                    'nombre'=> $request->nombre,
                    'apellido' => $request->apellido,
                    'celular' => $request->celular,
                    'email' => $request->email,
                    'ciudad' => $request->ciudad,
                    'modelo' => $request->vehiculo_modelo_nombre,
                    'anio' => $request->vehiculo_anio,
                    'chasis' => $request->vehiculo_chasis,
                    'comentarios' => $request->comentarios,
                    'fecha_creacion' => date("Y-m-d H:i:s") 
                ]
            );
            // Verificacion
            if($repuestos == true)
            {
                $data = [
                    'subject'   => 'Informacion de Contacto - '.strtoupper($request->vehiculo_modelo_nombre),
                    'from'      => 'hyundai@curbe.com.ec',
                    'from_name' => 'Hyundai Ecuador',
                    'contacto' => 'Juan Crespo',
                    'nombre'=> $request->nombre,
                    'apellido' => $request->apellido,
                    'celular' => $request->celular,
                    'email' => $request->email,
                    'ciudad' => $request->ciudad,
                    'modelo' => $request->vehiculo_modelo_nombre,
                    'anio' => $request->vehiculo_anio,
                    'chasis' => $request->vehiculo_chasis,
                    'comentarios' => $request->comentarios,
                    'fecha_creacion' => date("Y-m-d H:i:s") 
                ];
                // Obtener Remitentes
                Mail::to($request->email, "Juan Crespo")->send(new PesadosMail($data));
                $json = [ 'status'=> 'Ok', 'respuesta'=> 'Formulario Repuestos Ingresado Correctamente'];
                return $json;
            }
            else
            {
                $json = [ 'status'=> 'Error', 'respuesta'=> 'Error al Ingresar Formulario Repuestos'];
                return $json;
            }

        } catch (Throwable $th) {
            //throw $th;
            $json = [ 'status'=> 'Error', 'respuesta'=> 'Error al Ingresar Formulario Repuestos, catch'];
            return $json;
        }
    }
}
