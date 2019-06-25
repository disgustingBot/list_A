<?php





$color1 = '#ec407a';
$color2 = '#424242';
$color3 = '#FAFAFA';
$color4 = '#C7C7C7';
$aacento = chr(225);
$eacento = chr(233);
$iacento = chr(237);
$oacento = chr(243);
$uacento = chr(250);
$enie    = chr(241);
$pregunta= chr(63);





//_____________________________________________________________________________Esto guarda los datos del formulario en variables____________________________________________________________




include 'includes/dbh.inc.php';

$sql = "SELECT * FROM formData2";
$result = mysqli_query($conn, $sql);
$datas = array();
if (mysqli_num_rows($result) > 0) {
  // echo '<div class="col-6 my-3 px-4 text-left">';
  while ($row = mysqli_fetch_assoc($result)) {
    if ($row['name'] == $_GET['client']) {
      $dat['servicio'  ] = $row['webType'    ].'</p>';
      $dat['autoAdmin' ] = $row['autoAdmin'  ].'</p>';
      $dat['rubro'     ] = $row['business'   ].'</p>';
      $dat['adwords'   ] = $row['adwords'    ].'</p>';
      $dat['hosting'   ] = $row['hosting'    ].'</p>';
      $dat['contenido' ] = $row['content'    ].'</p>';
      $dat['redes'     ] = $row['socialMedia'].'</p>';
      $dat['email'     ] = $row['email'      ].'</p>';
      $dat['nombre'    ] = $row['name'       ].'</p>';
      $dat['tel'       ] = $row['phoneNumber'].'</p>';
      $dat['comentario'] = $row['comments'   ].'</p>';
    }
  }
  // echo '</div>';
}












$precioHost = 2000;
$precioContenido = 1000;
$precioComu = 5000;




     


$comments      = $dat['comentario'];
$email_address = $dat['email'];       
$first_name    = $dat['nombre'];       
$rubro         = $dat['rubro'];        
$phone_number  = $dat['tel'];         
$servicio      = $dat['servicio'];
$adwords   = $dat['adwords'];
$hosting   = $dat['hosting'];
$contenido = $dat['contenido'];
$redes     = $dat['redes'];
$autoAdmin = $dat['autoAdmin'];




$adwords   = substr($adwords,   0, 2);
$hosting   = substr($hosting,   0, 2);
$contenido = substr($contenido, 0, 2);
$redes     = substr($redes,     0, 2);
$servicio  = substr($servicio,  0,12);
//___________________________________________________________________________________________Datos guardados en variables___________________________________________________________________



//_____________________________________________________________________________________________Armo el mail del cliente_____________________________________________________________________

//_____________________________________________________________________________________________Esto arma la Descripcion_____________________________________________________________________




$descripcionHost = '
  
      <div>
        
      
      <!--[if mso | IE]>
      <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:600px;" width="600">
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->
    
      
      <div style="background:'.$color3.';background-color:'.$color3.';Margin:0px auto;max-width:600px;">
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:'.$color3.';background-color:'.$color3.';width:100%;">
          <tbody>
            <tr>
              <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;">
                <!--[if mso | IE]>
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                
        <tr>
      
            <td style="vertical-align:top;width:300px;">
          <![endif]-->
            
      <div class="mj-column-per-50 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
              <tr>
                <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:13px;letter-spacing:1px;line-height:1;text-align:center;color:'.$color2.';">
                    <h2>Que es Hosting y por que lo necesito'.$pregunta.'</h2>
                  </div>
                </td>
              </tr>
              <tr>
                <td align="justify" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:15px;font-weight:light;letter-spacing:1px;line-height:20px;text-align:justify;color:'.$color2.';">
                    <p>El Web Hosting es el servicio que provee a los usuarios de Internet un sistema para poder almacenar informacion, paginas web, imagenes, videos, sistemas, correos electronicos, o cualquier contenido accesible en internet.</p>
                  </div>
                </td>
              </tr>
        </table>
      </div>
    
          <!--[if mso | IE]>
            </td>
          
            <td style="vertical-align:top;width:300px;">
          <![endif]-->
            
      <div class="mj-column-per-50 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
              <tr>
                <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:13px;letter-spacing:1px;line-height:1;text-align:center;color:'.$color2.';">
                    <h2>Como se paga por servicio de Hosting?</h2>
                  </div>
                </td>
              </tr>
              <tr>
                <td align="justify" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:15px;font-weight:light;letter-spacing:1px;line-height:20px;text-align:justify;color:'.$color2.';">
                    <p>Desde Latte ofrecemos el servicio de hosting gratuito por 6 meses. Pasado ese tiempo, el precio es de 90 € EUR anuales</p>
                  </div>
                </td>
              </tr>
        </table>
      </div>
    
          <!--[if mso | IE]>
            </td>
          
        </tr>
      
                  </table>
                <![endif]-->
              </td>
            </tr>
          </tbody>
        </table>
        
      </div>
    
';



$descripcionCont = '

      
      <div>
        
      
      <!--[if mso | IE]>
      <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:600px;" width="600">
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->
    
      
      <div style="background:'.$color3.';background-color:'.$color3.';Margin:0px auto;max-width:600px;">
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:'.$color3.';background-color:'.$color3.';width:100%;">
          <tbody>
            <tr>
              <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;">
                <!--[if mso | IE]>
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                
        <tr>
      
            <td style="vertical-align:top;width:300px;">
          <![endif]-->
            
      <div class="mj-column-per-50 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
              <tr>
                <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:13px;letter-spacing:1px;line-height:1;text-align:center;color:'.$color2.';">
                    <h2>No tienes contenido suficiente, o la información que quieres subir a tu web bien organizada?</h2>
                  </div>
                </td>
              </tr>
              <tr>
                <td align="justify" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:15px;font-weight:light;letter-spacing:1px;line-height:20px;text-align:justify;color:'.$color2.';">
                    <p>Nosotros nos encargamos de analizar inteligentemente tu caso, y generamos contenido para tu pagina web, ya sea que quieras vender tu producto o servicio, o transmitir un mensaje.</p>
                  </div>
                </td>
              </tr>
        </table>
      </div>
    
          <!--[if mso | IE]>
            </td>
          
            <td style="vertical-align:top;width:300px;">
          <![endif]-->
            
      <div class="mj-column-per-50 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
              <tr>
                <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:13px;letter-spacing:1px;line-height:1;text-align:center;color:'.$color2.';">
                    <h2>Como se paga por el Contenido?</h2>
                  </div>
                </td>
              </tr>
              <tr>
                <td align="justify" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:15px;font-weight:light;letter-spacing:1px;line-height:20px;text-align:justify;color:'.$color2.';">
                    <p>En este caso no tenemos un precio fijo y dependera de cuanto contenido, ya se en forma de imagenes, video, texto, etc., ya tengas y del tipo de contenido a generar. El precio inicial es de $'.$precioContenido.'</p>
                  </div>
                </td>
              </tr>
        </table>
      </div>
    
          <!--[if mso | IE]>
            </td>
          
        </tr>
      
                  </table>
                <![endif]-->
              </td>
            </tr>
          </tbody>
        </table>
        
      </div>
    


';


$descripcionComu = '

      <div>
        
      
      <!--[if mso | IE]>
      <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:600px;" width="600">
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->
    
      
      <div style="background:'.$color3.';background-color:'.$color3.';Margin:0px auto;max-width:600px;">
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:'.$color3.';background-color:'.$color3.';width:100%;">
          <tbody>
            <tr>
              <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;">
                <!--[if mso | IE]>
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                
        <tr>
      
            <td style="vertical-align:top;width:300px;">
          <![endif]-->
            
      <div class="mj-column-per-50 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
              <tr>
                <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:13px;letter-spacing:1px;line-height:1;text-align:center;color:'.$color2.';">
                    <h2>Que es un Community Manager'.$pregunta.'</h2>
                  </div>
                </td>
              </tr>
              <tr>
                <td align="justify" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:15px;font-weight:light;letter-spacing:1px;line-height:20px;text-align:justify;color:'.$color2.';">
                    <p>Es quien act'.$uacento.'a como auditor de la marca en los medios sociales. Se encarga de sostener, acrecentar y defender las relaciones de la empresa con sus clientes, gracias al saber de las necesidades y los planes de la organizaci'.$oacento.'n y los intereses de los clientes.</p>
                  </div>
                </td>
              </tr>
        </table>
      </div>
    
          <!--[if mso | IE]>
            </td>
          
            <td style="vertical-align:top;width:300px;">
          <![endif]-->
            
      <div class="mj-column-per-50 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
              <tr>
                <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:13px;letter-spacing:1px;line-height:1;text-align:center;color:'.$color2.';">
                    <h2>Como se paga por este servicio'.$pregunta.'</h2>
                  </div>
                </td>
              </tr>
              <tr>
                <td align="justify" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:15px;font-weight:light;letter-spacing:1px;line-height:20px;text-align:justify;color:'.$color2.';">
                    <p>Este es un servicio que se realiza a diario por parte del Community Manager, por eso se abona mensualmente con precios que varian dependiendo de las necesidades del cliente. Los precios arrancan en $'.$precioComu.' por mes.</p>
                  </div>
                </td>
              </tr>
        </table>
      </div>
    
          <!--[if mso | IE]>
            </td>
          
        </tr>
      
                  </table>
                <![endif]-->
              </td>
            </tr>
          </tbody>
        </table>
        
      </div>
    

';


$descripcionAds = '

      <div>
        
      
      <!--[if mso | IE]>
      <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:600px;" width="600">
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->
    
      
      <div style="background:'.$color3.';background-color:'.$color3.';Margin:0px auto;max-width:600px;">
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:'.$color3.';background-color:'.$color3.';width:100%;">
          <tbody>
            <tr>
              <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;">
                <!--[if mso | IE]>
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                
        <tr>
      
            <td style="vertical-align:top;width:300px;">
          <![endif]-->
            
      <div class="mj-column-per-50 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
              <tr>
                <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:13px;letter-spacing:1px;line-height:1;text-align:center;color:'.$color2.';">
                    <h2>Que es Google Ads y como funciona?</h2>
                  </div>
                </td>
              </tr>
              <tr>
                <td align="justify" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:15px;font-weight:light;letter-spacing:1px;line-height:20px;text-align:justify;color:'.$color2.';">
                    <p>Google Ads es un servicio y un programa de la empresa Google que se utiliza para ofrecer publicidad patrocinada a potenciales clientes. Dicha publidicad puede anunciarse tanto en los resultados de busqueda de Google como en sitios asociados a Google, Youtube, Google Market y mas.</p>
                  </div>
                </td>
              </tr>
        </table>
      </div>
    
          <!--[if mso | IE]>
            </td>
          
            <td style="vertical-align:top;width:300px;">
          <![endif]-->
            
      <div class="mj-column-per-50 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
              <tr>
                <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:13px;letter-spacing:1px;line-height:1;text-align:center;color:'.$color2.';">
                    <h2>Como se paga por Google Adwords?</h2>
                  </div>
                </td>
              </tr>
              <tr>
                <td align="justify" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:15px;font-weight:light;letter-spacing:1px;line-height:20px;text-align:justify;color:'.$color2.';">
                    <p>Google cobra un monto determinado por cada vez que una persona clica en tu anuncio. El costo del clic dependera de las palabras claves que se le asignen, que a su vez dependen de tu rubro. No dudes en pedirnos un presupuesto personalizado</p>
                  </div>
                </td>
              </tr>
        </table>
      </div>
    
          <!--[if mso | IE]>
            </td>
          
        </tr>
      
                  </table>
                <![endif]-->
              </td>
            </tr>
          </tbody>
        </table>
        
      </div>
    
      
      <!--[if mso | IE]>
          </td>
        </tr>
      </table>
      
      <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:600px;" width="600">
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->
    
      
      <div  style="background:'.$color3.';background-color:'.$color3.';Margin:0px auto;max-width:600px;">
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:'.$color3.';background-color:'.$color3.';width:100%;">
          <tbody>
            <tr>
              <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;">
                <!--[if mso | IE]>
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                
        <tr>
      
            <td style="vertical-align:top;width:300px;">
          <![endif]-->
            
      <div class="mj-column-per-50 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
              <tr>
                <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:13px;letter-spacing:1px;line-height:1;text-align:center;color:'.$color2.';">
                    <h2>Que te podemos ofrecer desde Latte?</h2>
                  </div>
                </td>
              </tr>
              <tr>
                <td align="justify" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:15px;font-weight:light;letter-spacing:1px;line-height:20px;text-align:justify;color:'.$color2.';">
                    <p>Nosotros estudiamos cual es la demanda de tu publicidad y armamos el plan de publicidad en Google, segmentando al publico por edad, posicion geografica, intereses, etc, para asegurarnos de que tu anuncio llegue al publico adecuado. De esta forma nos aseguramos de que los fondos que tu confias a adwords se inviertan unicamente en usuarios interesados en lo que ofreces.</p>
                  </div>
                </td>
              </tr>
        </table>
      </div>
    
          <!--[if mso | IE]>
            </td>
          
            <td style="vertical-align:top;width:300px;">
          <![endif]-->
            
      <div class="mj-column-per-50 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
              <tr>
                <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:13px;letter-spacing:1px;line-height:1;text-align:center;color:'.$color2.';">
                    <h2>Cuales son nuestros honorarios?</h2>
                  </div>
                </td>
              </tr>
              <tr>
                <td align="justify" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:15px;font-weight:light;letter-spacing:1px;line-height:20px;text-align:justify;color:'.$color2.';">
                    <p>Te recomendaremos una inversion minima y maxima para tu publicidad, pero el presupuesto lo fijas tu. Nuestros honorarios son iguales al 20% de lo que tu quieras invertir en Google, con un minimo de 20EUR como honorarios. Ejemplo: si inviertes 50EUR mensuales, nuestros honorarios serian de 20EUR. Si inviertes 200EUR, nuestros honorarios serian de 40EUR.</p>
                  </div>
                </td>
              </tr>
        </table>
      </div>
    
          <!--[if mso | IE]>
            </td>
          
        </tr>
      
                  </table>
                <![endif]-->
              </td>
            </tr>
          </tbody>
        </table>
        
      </div>
    
      
';


if ($adwords  =='si') {$descripcion.=$descripcionAds ;}
if ($hosting  =='si') {$descripcion.=$descripcionHost;}
if ($contenido=='si') {$descripcion.=$descripcionCont;}
if ($redes    =='si') {$descripcion.=$descripcionComu;}

//_________________________________________________________________________________________________Fin de la Descripcion_________________________________________________________________________


//_____________________________________________________________________________________________Esto arma la tabla de valores_____________________________________________________________________


//______________________________________________________DEFINO $precio y $total________________________________________________

$precio = 1000;
$tiempoDesarrollo = 'dos semanas';

if ($servicio == "Landing page") {
  $precio = 300;

} elseif ($servicio == "One Page Scroll") {
  $precio = 400;

} elseif ($servicio == "Sitio Institucional") {
  $precio = 600;
  $tiempoDesarrollo = 'tres semanas';

} else {
  $precio = 700;
  $tiempoDesarrollo = 'un mes';
}

$total = $precio + 40;

//________________________________________________________$precio y $total DEFINIDAS________________________________________________

//_____________________________________________________________________________________________Fin de Tabla de Valores_____________________________________________________________________



//_________________________________________________________________________________________EENVIO el $mail a $email_address____________________________________________________________________

$fontFamily = "'Ubuntu'";

$mailToShow    = '

    <!doctype html>
    <html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
      <head>
        <title>
          
        </title>
        <!--[if !mso]><!-- -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--<![endif]-->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style type="text/css">
          #outlook a { padding:0; }
          .ReadMsgBody { width:100%; }
          .ExternalClass { width:100%; }
          .ExternalClass * { line-height:100%; }
          body { margin:0;padding:0;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%; }
          table, td { border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt; }
          img { border:0;height:auto;line-height:100%; outline:none;text-decoration:none;-ms-interpolation-mode:bicubic; }
          p { display:block;margin:13px 0; }
        </style>
        <!--[if !mso]><!-->
        <style type="text/css">
          @media only screen and (max-width:480px) {
            @-ms-viewport { width:320px; }
            @viewport { width:320px; }
          }
        </style>
        <!--<![endif]-->
        <!--[if mso]>
        <xml>
        <o:OfficeDocumentSettings>
          <o:AllowPNG/>
          <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
        </xml>
        <![endif]-->
        <!--[if lte mso 11]>
        <style type="text/css">
          .outlook-group-fix { width:100% !important; }
        </style>
        <![endif]-->
        
      <!--[if !mso]><!-->
        <link href="https://fonts.googleapis.com/css'.$pregunta.'family=Roboto:300,400,500,700" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css'.$pregunta.'family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css'.$pregunta.'family=Ubuntu|Oxygen:300" rel="stylesheet">
        <style type="text/css">
          @import url(https://fonts.googleapis.com/css'.$pregunta.'family=Roboto:300,400,500,700);
          @import url(https://fonts.googleapis.com/css'.$pregunta.'family=Ubuntu:300,400,500,700);
        </style>
      <!--<![endif]-->

    
        
    <style type="text/css">
      @media only screen and (min-width:480px) {
        .mj-column-per-25 { width:25% !important; }
        .mj-column-per-100 { width:100% !important; }
        .mj-column-per-50 { width:50% !important; }
        .mj-column-per-33 { width:33.333333333333336% !important; }
      }
    </style>
    
  
        <style type="text/css">
        
        
        </style>
        
      </head>




















      <body style="background-color:'.$color4.';">
        
        
      <div style="background-color:'.$color4.';">
        
      
      <!--[if mso | IE]>
      <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:600px;" width="600">
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->
    
      
      <div  style="background:'.$color2.';background-color:'.$color2.';Margin:0px auto;max-width:600px;">
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:'.$color2.';background-color:'.$color2.';width:100%;">
          <tbody>
            <tr>
              <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top; padding:10px 0px 10px 0px!important;">
                <!--[if mso | IE]>
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                
        <tr>
      
            <td style="vertical-align:top;width:150px;">
          <![endif]-->
            
      <div class="mj-column-per-25 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
              
              <tr>
                <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word; padding:0px;">
                  <div style="font-family:Ubuntu, sans-serif;font-size:20px;line-height:1;text-align:center;color:white;">
                    <h2 style="margin-bottom:2px!important; margin-top: 10px!important;">Latte</h2>
                  </div>
                </td>
              </tr>
        </table>
      </div>
    
          <!--[if mso | IE]>
            </td>
          
        </tr>
      
                  </table>
                <![endif]-->
              </td>
            </tr>
          </tbody>
        </table>
        
      </div>
    
      
      <!--[if mso | IE]>
          </td>
        </tr>
      </table>
      
      <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:600px;" width="600">
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->
    
      
      <div  style="background:'.$color3.';background-color:'.$color3.';Margin:0px auto;max-width:600px;">
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:'.$color3.';background-color:'.$color3.';width:100%;">
          <tbody>
            <tr>
              <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;">
                <!--[if mso | IE]>
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                
        <tr>
      
            <td style="vertical-align:top;width:600px;">
          <![endif]-->
            
      <div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        
        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
          
              <tr>
                <td align="justify" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:18px;font-weight:bolder;line-height:1;text-align:justify;text-decoration:underline;color:'.$color1.';">
                    <p>'.$first_name.'</p>
                  </div>
                </td>
              </tr>
            
              <tr>
                <td align="justify" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:16px;line-height:1;text-align:justify;color:'.$color2.';">
                    <p>Gracias por contactarte con nosotros.</p>
                    <p>Te envio el presupuesto que nos pediste en nuestra Landing Page.</p>
                  </div>
                </td>
              </tr>
            
        </table>
    
      </div>
    
          <!--[if mso | IE]>
            </td>
          
        </tr>
      
                  </table>
                <![endif]-->
              </td>
            </tr>
          </tbody>
        </table>
        
      </div>
    
      
      <!--[if mso | IE]>
          </td>
        </tr>
      </table>
      <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:600px;" width="600">
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->
      
      

'.$descripcion .'





      
      <!--[if mso | IE]>
          </td>
        </tr>
      </table>
      <![endif]-->





      
      <div  style="background:'.$color3.';background-color:'.$color3.';Margin:0px auto;max-width:600px;">
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:'.$color3.';background-color:'.$color3.';width:100%;">
          <tbody>
            <tr>
              <td style="direction:ltr;font-size:0px;padding:0;text-align:center;vertical-align:top;">
                <!--[if mso | IE]>
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                
        <tr>
      
            <td style="vertical-align:top;width:600px;">
          <![endif]-->
            
      <div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        
      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
        
            <tr>
              <td align="left" style="font-size:0px; padding:0;">
                
                <table 0="[object Object]" 1="[object Object]" 2="[object Object]" border="0" style="cellspacing:0;color:'.$color2.';font-family:Ubuntu, Helvetica, Arial, sans-serif; font-size:13px; line-height:22px; table-layout:fixed; width:100%; padding: 0 8px;">
                    <tr style="border-bottom:2px solid '.$color2.'; text-align:center; background-color:'.$color2.'; color:'.$color3.'; font-size:12px;">
                      <th style="font-size:10px; padding-top:10px; padding-right:5px; padding-bottom:10px; text-align: center; ">Servicio</th>
                      <th style="font-size:10px; padding-top:10px; padding-right:5px; padding-bottom:10px; text-align: center; ">Concepto</th>
                      <th style="font-size:10px; padding-top:10px; padding-right:5px; padding-bottom:10px; text-align: center; min-width: 33%;">Precio</th>
                    </tr>
                    <tr style="border-bottom: solid 1px '.$color2.'">
                      <td style="font-size:10px; padding-top:10px; padding-right:5px; padding-bottom:10px; text-align: center; ">Sitio web</td>
                      <td style="font-size:10px; padding-top:10px; padding-right:5px; padding-bottom:10px; text-align: center; ">'.$servicio.'</td>
                      <td style="font-size:10px; padding-top:10px; padding-right:5px; padding-bottom:10px; text-align: center; ">'.$precio.'€</td>
                    </tr>
                    <tr style=" border-bottom: solid 1px '.$color2.'">
                      <td style="font-size:10px; padding-top:10px; padding-right:5px; padding-bottom:10px; text-align: center; ">Hosting</td>
                      <td style="font-size:10px; padding-top:10px; padding-right:5px; padding-bottom:10px; text-align: center; ">6 meses gratuitos</td>
                      <td style="font-size:10px; padding-top:10px; padding-right:5px; padding-bottom:10px; text-align: center; ">0€</td>
                    </tr>
                    <tr style=" border-bottom: solid 1px '.$color2.'">
                      <td style="font-size:10px; padding-top:10px; padding-right:5px; padding-bottom:10px; text-align: center; ">Dominio</td>
                      <td style="font-size:10px; padding-top:10px; padding-right:5px; padding-bottom:10px; text-align: center; ">Gestion del nombre</br> unico del Sitio </br> Web</td>
                      <td style="font-size:10px; padding-top:10px; padding-right:5px; padding-bottom:10px; text-align: center; ">40€</td>
                    </tr>
                    <tr style=" border-bottom: solid 1px '.$color2.'">
                      <td style="font-size:10px; padding-top:10px; padding-right: 5px; padding-bottom:10px; text-align: center; ">Asesoramiento Comercial</td>
                      <td style="font-size:10px; padding-top:10px; padding-right: 5px; padding-bottom:10px; text-align: center; ">Pre y post venta</td>
                      <td style="font-size:10px; padding-top:10px; padding-right: 5px; padding-bottom:10px; text-align: center; ">0€</td>
                    </tr>
                    <tr style="background-color:'.$color1.' ; color:'.$color3.';">
                      <td style="font-size:12px; padding-top:10px; padding-right: 5px; padding-bottom:10px; text-align: center;">Total</td>
                      <td style="font-size:12px; padding-top:10px; padding-right: 5px; padding-bottom:10px; text-align: center">-</td>
                      <td style="font-size:12px; padding-top:10px; padding-right: 5px; padding-bottom:10px; text-align: center">'.$total.'€</td>
                    </tr>
                </table>
    
              </td>
            </tr>
          
      </table>
    
      </div>
    
          <!--[if mso | IE]>
            </td>
          
        </tr>
      
                  </table>
                <![endif]-->
              </td>
            </tr>
          </tbody>
        </table>
        
      </div>
    





      
      <!--[if mso | IE]>
          </td>
        </tr>
      </table>
      <table align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->
    












      <table align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->
    
      
      <div  style="background:'.$color3.';background-color:'.$color3.';Margin:0px auto;max-width:600px;">
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:'.$color3.';background-color:'.$color3.';width:100%;">
          <tbody>
            <tr>
              <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;">
                <!--[if mso | IE]>
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                
        <tr>
      
            <td
               style="vertical-align:top;width:600px;"
            >
          <![endif]-->
            
      <div class="mj-column-per-100 outlook-group-fix" style="text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
              <tr>
                <td align="justify" style="padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:15px;font-weight:light;letter-spacing:1px;line-height:20px;text-align:justify;color:'.$color2.';">
                    <p>Para comenzar a trabajar, necesitamos que nos envies alguna informacion. Una vez tengamos el contenido necesario, el tiempo de desarrollo de tu sitio es de aproximidamente '.$tiempoDesarrollo.'. Nuestro servicio se abona en dos pagos: 50% para comenzar el trabajo y el 50% restante una vez terminado el mismo.</p>
                  </div>
                </td>
              </tr>
        </table>
      </div>
    
          <!--[if mso | IE]>
            </td>
          
        </tr>
      
                  </table>
                <![endif]-->
              </td>
            </tr>
          </tbody>
        </table>
        
      </div>
    
      
      <!--[if mso | IE]>
          </td>
        </tr>
      </table>
      
      <table
         align="center" border="0" cellpadding="0" cellspacing="0" style="width:600px;" width="600"
      >
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->
    
      
      <div  style="background:'.$color3.';background-color:'.$color3.';Margin:0px auto;max-width:600px;">
        
        <table
           align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:'.$color3.';background-color:'.$color3.';width:100%;"
        >
          <tbody>
            <tr>
              <td
                 style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;"
              >
                <!--[if mso | IE]>
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                
        <tr>
      
            <td
               style="vertical-align:top;width:600px;"
            >
          <![endif]-->
            
      <div
         class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:center;direction:ltr;display:inline-block;vertical-align:top;width:100%;"
      >
        
      <table
         border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"
      >
        
            <tr>
              <td
                 style="font-size:0px;padding:10px 25px;word-break:break-word;"
              >
                
      <p
         style="border-top:solid 3px '.$color1.';font-size:1;margin:0px auto;width:100%;"
      >
      </p>
      
      <!--[if mso | IE]>
        <table
           align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 3px '.$color1.';font-size:1;margin:0px auto;width:550px;" role="presentation" width="550px"
        >
          <tr>
            <td style="height:0;line-height:0;">
              &nbsp;
            </td>
          </tr>
        </table>
      <![endif]-->
    
    
              </td>
            </tr>
          
      </table>
    
      </div>
    
          <!--[if mso | IE]>
            </td>
          
        </tr>
      
                  </table>
                <![endif]-->
              </td>
            </tr>
          </tbody>
        </table>
        
      </div>
    
      
      
      <div style="background:'.$color3.';background-color:'.$color3.';Margin:0px auto;max-width:600px;">
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:'.$color3.';background-color:'.$color3.';width:100%;">
          <tbody>
            <tr>
              <td style="direction:ltr;font-size:0px;padding:20px 0 0 0;text-align:center;vertical-align:top;">
                <!--[if mso | IE]>
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                
        <tr>
      
            <td style="vertical-align:top;width:600px;">
          <![endif]-->
            
      <div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
              <tr>
                <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Roboto;font-size:17px;line-height:1;text-align:center;color:'.$color2.';">
                    <p>Ante cualquier duda o consulta, no dudes en contactarnos.</p>
                    <p>Atte</p>
                  </div>
                </td>
              </tr>
        </table>

        <table class="mj-column-per-100 outlook-group-fix" border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;background: '.$color2.';" width="100%">
              <tr>
                <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                  <div style="font-family:Ubuntu, sans-serif;font-size:20px;line-height:1;text-align:center;color: '.$color3.';background: '.$color2.';">
                    <p>Latte</p>
                  </div>
                </td>
              </tr>
        </table>
      </div>
    
              </td>
            </tr>
          </tbody>
        </table>
        
      </div>
              </td>
            </tr>
          </tbody>
        </table>
        
      </div>
    
    
    
      </div>
    
      </body>
    </html>
  
';


//_________________________________________________________________________________________________$mail ENVIADO__________________________________________________________________________________
//_____________________________________________________________________________________________________GL_HF________________________________________________________________________________________?>