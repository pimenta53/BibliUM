<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
	<title>Recuperação da conta</title>
	<link rel="stylesheet" type="text/css" href="CSS/blackandwhite/style.css"/>
</head>
<body>
	<h5 align="right"><a href="index.php"> Login</a></h5>
	<h1>BibliUM Contas</h1>
	<hr>
	<h2>Esqueceu-se da sua palavra-pass?</h2>
	<p>Para repor a palavra-passe, escreva o endereço de e-mail completo que utilizou na criação da sua Conta BibliUM.</p><br>

<?php
	echo "<br>";
	require_once "HTML/QuickForm.php";
	$form = new HTML_QuickForm('register', 'post');
	$form->addElement('text','email', 'Email:');
	$form->addElement('textarea','description','Nota: ','rows="5" cols="50"');
	$form->addRule('email', '<font face=verdana size=1 color=red>Email invalido', 'email'); $form->addElement('submit','send','enviar');
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
?>
</body>
</html>
