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
                    'modelo' => $request->modelo,
                    'comentarios' => $request->comentarios,
                    'fecha_creacion' => date("Y-m-d H:i:s") 
                ]
            );
            // Verificacion
            if($pesados == true)
            {
                $data = [
                    'nombre'=> $request->nombre,
                    'apellido' => $request->apellido,
                    'celular' => $request->celular,
                    'email' => $request->email,
                    'modelo' => $request->modelo,
                    'comentarios' => $request->comentarios,
                    'fecha_creacion' => date("Y-m-d H:i:s")
                ];
                // Obtener Remitentes
                Mail::to($request->email, $request->nombre)->send(new PesadosMail($data));
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
}
