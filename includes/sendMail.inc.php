<?php


// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require '../vendor/autoload.php';
include_once 'dbh.inc.php';
// require '../vendor/autoload.php';

/*
This bit sets the URLs of the supporting pages.
If you change the names of any of the pages, you will need to change the values here.
*/
$feedback_page = "../login.php";
// $error_page = "../error_message.html";
$thankyou_page = "thank_you.html";



function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}

//Usage:

// console_log( $_POST );
// echo var_dump($_POST);

// $nma = "Zack";
// $mla = "molinerozadkiel@gmail.com";

$mts = $_POST['hiddenMail'];
$nma = $_POST['nma'];
$mla = $_POST['mla'];
$mlf = $_POST['mlf'];
// $mlf = 'info@lattedev.com';

// pky = primary key
// tsp = time stamp
// nma = name adress
// mla = mail adress
// mts = mail to send
// mlf = mail from


  // Error handlers
  // Check for empty fields
if (empty($nma) || empty($mla) || empty($mts) || empty($mlf)) {

  if (empty($nma)) {
    header("Location: ../client.php?client=".$_GET['client']."&nma=empty");
  } elseif (empty($mla)) {
    header("Location: ../client.php?client=".$_GET['client']."&mla=empty");
  } elseif (empty($mts)) {
    header("Location: ../client.php?client=".$_GET['client']."&mts=empty");
  } elseif (empty($mlf)) {
    header("Location: ../client.php?client=".$_GET['client']."&mlf=empty");
  }
  exit();

} else {
    // Check if imput characters are valid
    // Explorar como mejorar la seguridad en este caso, porque se mandan caracteres de html
  if (!preg_match("/^[0-9a-zA-Z\ \!\?\.\,]*$/", $nma)) {

    header("Location: ../client.php?client=".$_GET['client']."&mail=invalid");
    exit();

  } else {
          // Insert the user into the database
    $sql = "INSERT INTO mails (nma, mla, mts, mlf) VALUES ('$nma', '$mla', '$mts', '$mlf');";
    mysqli_query($conn, $sql);


  }
}





  //__________________________________________________________ENVIO el $mailToSend a $mailAddress_____________________________________

  $fontFamily = "'Ubuntu'";


  $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
  try {
      //Server settings

      $mail->SMTPDebug = 4;                                 // Enable verbose debug output
      $mail->isSMTP();                                      // Set mailer to use SMTP
      // $mail->Host = 'smtp.lattedev.com';                    // Specify main and backup SMTP servers
      $mail->Host = gethostbyname('main.wave-host.net');
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'info@lattedev.com';                // SMTP username
      $mail->Password = 'NoaziX1gVC';                       // SMTP password
      $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 465;                                    // TCP port to connect to

      $mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ));


      //Recipients
      $mail->setFrom('info@lattedev.com', 'Presupuesto Pagina Web');
      $mail->addAddress($mla, "");     // Add a recipient
      // $mail->addAddress($email_address, $first_name);     // Add a recipient



      // $mail->addAddress('ellen@example.com');               // Name is optional
      $mail->addReplyTo($mlf, $nma);
      // $mail->addCC('cc@example.com');
      // $mail->addBCC('bcc@example.com');

      //Attachments
      // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
      // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

      //Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = 'Gracias por tu consulta';
      $mail->Body    = $mts;


      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


      header("Location: ../client.php?client=".$_GET['client']."&mail=success");
      $mail->send();
      // echo 'Message has been sent';
  } catch (Exception $e) {
      echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
      header("Location: ../client.php?client=".$_GET['client']."&mail=error");

  }


// header( "Location: $feedback_page" );




//______________________________________________________________$mail ENVIADO_________________________________________________
//__________________________________________________________________GL_HF_____________________________________________________