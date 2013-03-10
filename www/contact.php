<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
	<title>Contactar administração</title>
	<link rel="stylesheet" type="text/css" href="CSS/blackandwhite/style.css"/>
</head>
<body>
	<h5 align="right"><a href="home.php">Home</a></h5>
	<h1>Contactar administração</h1>
	<hr>
	<br>

<?php
	echo "<br>";
	require_once "HTML/QuickForm.php";
	$form = new HTML_QuickForm('register', 'post');
	$form->addElement('text','email', 'Assunto:');
	$form->addElement('textarea','description','Descrição: ','rows="20" cols="90"');
	$form->addElement('submit','send','enviar');
	$form->addRule('email', '<font face=verdana size=1 color=red>Não preencheu o seu mail', 'required',null);
	$form->setRequiredNote('<font face=verdana size=1 color=red>* Campos obrigatorios</font>');

if ($form->validate()) {


$mensagem=$form->exportValue('mail')."/".$form->exportValue('description');
// O remetente deve ser um e-mail do seu domínio conforme determina a RFC 822.
// O return-path deve ser ser o mesmo e-mail do remetente.
$headers = "MIME-Version: 1.1\n";
$headers .= "Content-type: text/plain; charset=iso-8859-1\n";
$headers .= "From: 53.andre.pimenta@gmail.com"."\n"; // remetente
$headers .= "Return-Path: 53.andre.pimenta@gmail.com"."\n"; // return-path
$envio = mail("53.andre.pimenta@gmail.com", "Recuperar pass",$mensagem, $headers);
 

Header("Location: index.php");   

}
else {$form->display();}
require_once "foot.php";
?>
</body>
</html>
