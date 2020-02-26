<div style='width:100%; background-color:rgb(246,243,241); padding: 50px 0'>
    <div style='width:78%; padding:15px; background-color:rgb(255,255,255); margin-left: auto; margin-right: auto'>
        <div style='text-align:left;'>
            <img src="{{ asset('public/images/header/repuestos.png') }}" alt="Hyundai" style='width:100%;'/>
        </div>
        <div style='font-size:1.3em;  padding: 0 15px'>Estimado(a) <strong>{{$data['contacto']}}</strong>, la Solicitud de Repuesto a continuación:</div><br>
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
            <tr><td width='150px'><strong>Nombre:</strong> </td><td>{{$data['nombre']}}</td></tr>
            <tr><td width='150px'><strong>Apellido:</strong> </td><td>{{$data['apellido']}}</td></tr>
            <tr><td width='150px'><strong>Celular:</strong> </td><td>{{$data['celular']}}</td></tr>
            <tr><td width='150px'><strong>Email:</strong> </td><td>{{$data['email']}}</td></tr>
            <tr><td width='150px'><strong>Ciudad:</strong> </td><td>{{$data['ciudad']}}</td></tr>
        </table><br/>
        <table rules='all' style='border-color:#666;' border='1' cellpadding='10' width='100%'>
            <tr>
                <td align='center' bgcolor='#002c5f' colspan='2'>
                    <font color='white'>
                        <font face='arial' size='4'
                            <b>Información del Vehiculo</b>
                        </font>
                    </font>
                </td>
            </tr>
            <tr><td width='150px'><strong>Modelo:</strong> </td><td>{{$data['modelo']}}</td></tr>
            <tr><td width='150px'><strong>Año:</strong> </td><td>{{$data['anio']}}</td></tr>
            <tr><td width='150px'><strong>Repuesto:</strong> </td><td>{{$data['repuesto']}}</td></tr>
            <tr><td width='150px'><strong>Chasis:</strong> </td><td>{{$data['chasis']}}</td></tr>
            <tr><td width='150px'><strong>Fecha:</strong> </td><td>{{$data['fecha_creacion']}}</td></tr>
        </table>
        
    </div>
</div>