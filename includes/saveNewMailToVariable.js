
var url = 'includes/sendMail.inc.php';


// $.post("hola, hola, hola... me escuchan los del fondo?");
//chequear el envio a cliente correspondiente a: ------------------------------- esta variable
$('#mailToSend').bind("DOMSubtreeModified",function(){saveMailToVariable("rgonzalezespanon@gmail.com");});
// $('#sendMail').click(function(){sendMail(url, mailToSend);});

function saveMailToVariable (client){
	mailToSend =  document.getElementById('mailToSend').innerHTML;
	document.getElementById("hiddenMail").value = mailToSend;
}