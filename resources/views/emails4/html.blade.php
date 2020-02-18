<div style='width:100%; background-color:rgb(246,243,241); padding: 50px 0'>
    <div style='width:78%; background-color:rgb(255,255,255); margin-left: auto; margin-right: auto'>
        <div style='text-align:left;'>
            <img src="{{ asset('public/images/header/pesados.png') }}" alt="Hyundai" style='width:100%;'/>
        </div>
        <!-- <div style='font-size:1.3em;  padding: 0 15px'>Estimado(a) <strong>{{$data['contacto']}}</strong>, la información de la Solicitud a continuación:</div><br> -->
        <table rules='all' style='border-color:#666;' border='1' cellpadding='10' width='100%'>
            <tr>
                <td align='center' bgcolor='#002c5f' colspan='2'>
                    <font color='white'>
                        <font face='arial' size='4'
                            <b>Información del Cliente</b>
                        </font>
                    </font>
                </td>
            </tr>
            <tr><td width='150px'><strong>Nombre:</strong> </td><td>{{$data['cliente']}}</td></tr>
            <tr><td width='150px'><strong>Celular:</strong> </td><td>{{$data['celular']}}</td></tr>
            <tr><td width='150px'><strong>Email:</strong> </td><td>{{$data['email']}}</td></tr>
            <!-- <tr><td width='150px'><strong>Ciudad más cercana:</strong> </td><td>{{$data['ciudad']}}</td></tr>
            <tr><td width='150px'><strong>Hora llamada:</strong> </td><td>{{$data['hora']}}</td></tr> -->
            
        </table><br>
        
    </div>
</div>