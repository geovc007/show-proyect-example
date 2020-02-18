<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\PosventaMail;
use Mail;

class EmailController extends Controller
{
    //
    public function posventaEmail()
    {
        $data = [
            'subject'   => 'Tiene una Nueva Solicitud de Repuesto',
            'from'      => 'hyundai@curbe.com.co',
            'from_name' => 'Hyundai Colombia',
            'contacto' => 'Usuario Hyundai'
        ];

        Mail::to('gcordova@ad-a.com.ec', 'Geovanny Cordova')->send(new PosventaMail($data));

        return "HTML Email Sent. Check your inbox.";
    }

}
