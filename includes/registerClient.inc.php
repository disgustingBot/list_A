<?php

include_once 'dbh.inc.php';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require '../vendor/autoload.php';

/*
This bit sets the URLs of the supporting pages.
If you change the names of any of the pages, you will need to change the values here.
*/
$feedback_page = "../index.php";
// $error_page = "error_message.html";
$thankyou_page = "../thank_you.html";



function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}

//Usage:

// console_log( $comments );


$color1 = '#C62828';
$color2 = '#00796b';
$color3 = '#FAFAFA';
$color4 = '#C7C7C7';







//_____________________________________________________________________________Esto guarda los datos del formulario en variables____________________________________________________________

     
$adwords       = 'no';
$hosting       = 'no';
$contenido     = 'no';

/*This next bit loads the form field data into variables.
If you add a form field, you will need to add it here.*/

$comments      = $_POST['comentario'];
$email_address = $_POST['email'];       
$first_name    = $_POST['nombre'];       
$rubro         = $_POST['rubro'];        
$phone_number  = $_POST['tel'];         
$servicio      = $_POST['servicio'];

if (isset($_POST['adwords']))   {$adwords   = 'si';}
if (isset($_POST['hosting']))   {$hosting   = 'si';}
if (isset($_POST['contenido'])) {$contenido = 'si';}
if (isset($_POST['autoAdmin'])) {$autoAdmin = 1;} else {$autoAdmin = 0;}


$timestamp     = date("Y-m-d H:i:s");

if ($first_name=="El testeador" ||
    $first_name=="El Testeador" ||
    $first_name=="el Testeador" ||
    $first_name=="el testeador" ||
    $first_name=="Tester"       ||
    $first_name=="tester"       ||
    $first_name=="El Tester"    ||
    $first_name=="El tester"    ||
    $first_name=="el Tester"    ||
    $first_name=="el tester")    {$test = 1;} 
else                             {$test = 0;}



//___________________________________________________________________________________________Datos guardados en variables___________________________________________________________________

//_____________________________________________________________________________Esto guarda los datos del formulario en la base de datos_____________________________________________________
//____________________________________________________https://stackoverflow.com/questions/24245012/canonical-how-to-save-html-form-data-into-mysql-database_________________________________


// Check that user sent some data to begin with. 
// if (isset($_REQUEST['nombre'])) {

    /* Sanitize input. Trust *nothing* sent by the client.
     * When possible use whitelisting, only allow characters that you know
     * are needed. If username must contain only alphanumeric characters,
     * without puntation, then you should not accept anything else.
     * For more details, see: https://stackoverflow.com/a/10094315
     */
    // $first_name=preg_replace('/[^a-zA-Z0-9\ ]/','',$_REQUEST['nombre']);

    /* Escape your input: use htmlspecialchars to avoid most obvious XSS attacks.
     * Note: Your application may still be vulnerable to XSS if you use $yourfield
     *       in an attribute without proper quoting.
     * For more details, see: https://stackoverflow.com/a/130323
     */
    // $first_name=htmlspecialchars($first_name);


// } else {
    // die('User did not send any data to be saved!');
// }
// if (isset($_REQUEST['rubro'])) { $rubro=preg_replace('/[^a-zA-Z0-9\ ]/','',$_REQUEST['rubro']); $rubro=htmlspecialchars($rubro); }
// if (isset($_REQUEST['comentario'])) { $comments=preg_replace('/[^a-zA-Z0-9\ ]/','',$_REQUEST['comentario']); $comments=htmlspecialchars($comments); }

// Define MySQL connection and credentials










      // $sql = "INSERT INTO formData2 (webType, autoAdmin, business, adwords, hosting, content, socialMedia, name,  email, phoneNumber, comments,  test)  VALUES ('$servicio', '$autoAdmin', '$rubro', '$adwords', '$hosting', '$contenido', 'no', '$first_name', '$email_address', '$phone_number', '$comments', '$test');";
      // mysqli_query($conn, $sql);
      // header("Location: ../client.php?client=".$clt."&todo=success");



// $pdo_dsn='mysql:dbname=loginSystem;host=localhost'; $pdo_user='loginUser'; $pdo_password='test123';  

// $pdo_dsn='mysql:dbname=lattedev_db;host=localhost'; $pdo_user='lattedev_db'; $pdo_password='hSpFx6SXmo';  

try {
    // Establish connection to database
    $conn = new PDO($pdo_dsn, $pdo_user, $pdo_password);
    // Throw exceptions in case of error.
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Use prepared statements to mitigate SQL injection attacks.
    // See https://stackoverflow.com/questions/60174/how-can-i-prevent-sql-injection-in-php for more details

    $qry=$conn->prepare("INSERT INTO formData2 (webType, autoAdmin, business, adwords, hosting, content, socialMedia, name,  email, phoneNumber, comments,  test)  VALUES ('$servicio', '$autoAdmin', '$rubro', '$adwords', '$hosting', '$contenido', 'no', '$first_name', '$email_address', '$phone_number', '$comments', '$test')");

    // Execute the prepared statement using user supplied data.
    // $qry->execute(Array(":nombre" => $first_name));

    $qry->execute(Array(":dateTime" => $timestamp, ":webType" => $servicio, ":autoAdmin" => $autoAdmin, ":business" => $rubro, ":adwords" => $adwords, ":hosting" => $hosting, ":content" => $contenido, ":socialMedia" => $redes, "no" => $first_name,":email" => $email_address,":phoneNumber" => $phone_number, ":comments" => $comments, ":test" => $test));

} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage() . " file: " . $e->getFile() . " line: " . $e->getLine();
    exit;
}

// header("Location: ../thank_you.html");




//______________________________________________Datos guardados en database_______________________________________________





  //______________________________________________ENVIO el mail a Latteros_____________________________________

  $fuente = "Ubuntu";
// $fuente = "Arial Black";

  $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
  try {
      //Server settings

      $mail->SMTPDebug = 4;                                 // Enable verbose debug output
      $mail->isSMTP();                                      // Set mailer to use SMTP
      // $mail->Host = 'smtp.lattedev.com';                    // Specify main and backup SMTP servers
      $mail->Host = gethostbyname('main.wave-host.net');
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'consultas@lattedev.com';           // SMTP username
      $mail->Password = 'thi7zgLB5D';                       // SMTP password
      $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 465;                                    // TCP port to connect to

      $mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ));


      //Recipients
    $mail->setFrom('consultas@lattedev.com', 'Consulta Latte');
    $mail->addAddress('molinerozadkiel@gmail.com', 'Zack');          // Add a recipient
    $mail->addAddress('tomas.moralparra@gmail.com', 'Tomm');         // Name is optional
    // $mail->addAddress('paula@lattedev.com.com', 'Mauli');         // Name is optional

      // $mail->addAddress($email_address, $first_name);     // Add a recipient



      // $mail->addAddress('ellen@example.com');               // Name is optional
      $mail->addReplyTo('tomasmparra@lattedev.com', 'Tomm');
      // $mail->addCC('cc@example.com');
      // $mail->addBCC('bcc@example.com');

      //Attachments
      // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
      // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

      //Content
      $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Nueva consulta de '.$first_name;
    $mail->Body    = 
                    '<style>.test{background-color: #d7d7d7; font-family:Arial, sans-serif;font-size:14px;padding:9px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; border-right: none; border-left: none;}</style>
                    <div class="tg-wrap"><table style="border-collapse:collapse;border-spacing:0; border:none;">
                      <tr>
                        <th style="background-color: #ff2124; font-family:'.$fuente.', Gadget, sans-serif; vertical-align:top; font-size:2em;">Input</th>
                        <th style="background-color: #ff2124; font-family:'.$fuente.', Gadget, sans-serif; vertical-align:top; font-size:2em;">Respuesta</th>
                      </tr>
                      <tr>
                        <td style="background-color: #d7d7d7; font-family:Arial, sans-serif;font-size:14px;padding:9px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; border-right: none; border-left: none;">Que necesita:</td>
                        <td style="background-color: #d7d7d7; font-family:Arial, sans-serif;font-size:14px;padding:9px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; border-right: none; border-left: none; text-align: right; ">'.$servicio.'</td>
                      </tr>
                      <tr>
                        <td style="background-color: #d7d7d7; font-family:Arial, sans-serif;font-size:14px;padding:9px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; border-right: none; border-left: none; ">Empresa de:</td>
                        <td style="background-color: #d7d7d7; font-family:Arial, sans-serif;font-size:14px;padding:9px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; border-right: none; border-left: none; text-align: right; ">'.$rubro.'</td>
                      </tr>
                      <tr>
                        <td style="background-color: #d7d7d7; font-family:Arial, sans-serif;font-size:14px;padding:9px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; border-right: none; border-left: none; ">Adwords:</td>
                        <td style="background-color: #d7d7d7; font-family:Arial, sans-serif;font-size:14px;padding:9px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; border-right: none; border-left: none; text-align: right; ">'.$adwords.'</td>
                      </tr>
                      <tr>
                        <td style="background-color: #d7d7d7; font-family:Arial, sans-serif;font-size:14px;padding:9px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; border-right: none; border-left: none; ">Hosting:</td>
                        <td style="background-color: #d7d7d7; font-family:Arial, sans-serif;font-size:14px;padding:9px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; border-right: none; border-left: none; text-align: right; ">'.$hosting.'</td>
                      </tr>
                      <tr>
                        <td style="background-color: #d7d7d7; font-family:Arial, sans-serif;font-size:14px;padding:9px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; border-right: none; border-left: none; ">Contenido:</td>
                        <td style="background-color: #d7d7d7; font-family:Arial, sans-serif;font-size:14px;padding:9px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; border-right: none; border-left: none; text-align: right; ">'.$contenido.'</td>
                      </tr>
                      <tr>
                        <td style="background-color: #d7d7d7; font-family:Arial, sans-serif;font-size:14px;padding:9px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; border-right: none; border-left: none; ">Auto Administrable:</td>
                        <td style="background-color: #d7d7d7; font-family:Arial, sans-serif;font-size:14px;padding:9px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; border-right: none; border-left: none; text-align: right; ">'.$autoAdmin.'</td>
                      </tr>
                      <tr>
                        <td style="background-color: #d7d7d7; font-family:Arial, sans-serif;font-size:14px;padding:9px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; border-right: none; border-left: none; ">Nombre</td>
                        <td style="background-color: #d7d7d7; font-family:Arial, sans-serif;font-size:14px;padding:9px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; border-right: none; border-left: none; text-align: right; ">'.$first_name.'</td>
                      </tr>
                      <tr>
                        <td style="background-color: #d7d7d7; font-family:Arial, sans-serif;font-size:14px;padding:9px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; border-right: none; border-left: none; ">Email</td>
                        <td style="background-color: #d7d7d7; font-family:Arial, sans-serif;font-size:14px;padding:9px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; border-right: none; border-left: none; text-align: right; ">'.$email_address.'</td>
                      </tr>
                      <tr>
                        <td style="background-color: #d7d7d7; font-family:Arial, sans-serif;font-size:14px;padding:9px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; border-right: none; border-left: none; "><a style="display: block; width: 115px; height: 25px; background: #ff2124; padding: 10px; text-align: center; border-radius: 5px; color: white; font-weight: bold;" target="_blanc" href="https://api.whatsapp.com/send?phone=549'.$phone_number.'&text=Hola!%20una%20consulta"><h4 style="margin: 0;">Telefono</h4></a></td>
                        <td style="background-color: #d7d7d7; font-family:Arial, sans-serif;font-size:14px;padding:9px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; border-right: none; border-left: none; text-align: right; ">'.$phone_number.'</td>
                      </tr>
                      <tr>
                        <td style="background-color: #d7d7d7; font-family:Arial, sans-serif;font-size:14px;padding:9px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; border-right: none; border-left: none; ">Comentarios</td>
                        <td style="background-color: #d7d7d7; font-family:Arial, sans-serif;font-size:14px;padding:9px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; border-right: none; border-left: none; text-align: right; ">'.$comments.'</td>
                      </tr>
                    </table></div>';



      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


      header( "Location: $thankyou_page" );
      $mail->send();
      // echo 'Message has been sent';
  } catch (Exception $e) {
      echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
      // header( "Location: ../login.php?mail=error" );
  }


      // header( "Location: ../login.php?mail=success" );
// header( "Location: $feedback_page" );




//______________________________________________________________$mail ENVIADO_________________________________________________




//_____________________________________________________________________________________________________GL_HF________________________________________________________________________________________?>