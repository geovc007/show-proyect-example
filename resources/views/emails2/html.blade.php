<div style='width:100%; background-color:rgb(246,243,241); padding: 50px 0'>
    <div style='width:78%; background-color:rgb(255,255,255); margin-left: auto; margin-right: auto;padding:20px;'>
        <div style='text-align:left;'>
            <img src="{{ asset('public/images/header/cotizacion.png') }}" alt="Hyundai" style='width:100%;'/>
        </div>
        <div style='font-size:1.3em;  padding: 0 15px'>Estimado(a) <strong>{{$data['cliente']}}</strong>, gracias por contactarnos, pronto nos pondremos en contacto con usted.</div><br>
        <div style='text-align:left;'>
            <img src={{asset('public/images/body/body-'.$data["mod"].'.jpg')}} alt="Hyundai" style='width:100%;'>
        </div>
        <div style='text-align:left;padding:20px'>
            <a href="{{ asset('public/fichas/'.$data["modelo"].'.pdf') }}" alt="Hyundai" style='width:100%; font-size:18px; text-decoration:none; font-weight:bold; margin: 25px; color: rgb(255,255,255); background-color: rgb(0,44,95); border: 1px solid transparent; padding: .375rem .75rem; border-radius: .25rem;'>Descargar Ficha Técnica</a>
        </div>
        <div style='text-align:left;margin:0 0 0 35px; padding:0 0 0 .75rem;'><strong>Gracias por Cotizar en Hyundai</strong></div><br>
    </div>
</div>