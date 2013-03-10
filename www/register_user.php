<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
	<title>Contas BibliUM</title>
	<link rel="stylesheet" type="text/css" href="CSS/blackandwhite/style.css"/>
</head>
<body>
	<h5 align="right"><a href="index.php"> Login</a></h5>
	<h1>BibliUM</h1><hr>
<?php
	require_once "HTML/QuickForm.php";
	require_once "connection.php";	
	require_once "functions/date.php";	
	require_once "functions/log.php";
	

	$stid = oci_parse($conn, 'SELECT * FROM COUNTRY order by country_name ');
	oci_execute($stid, OCI_DEFAULT);
	$i=1;
	$country_name[0]="Escolha um pais";
	$cods_country[0]=NULL;
	while ($countrys=oci_fetch_array($stid)) {  
		$country_name[$i]=$countrys['COUNTRY_NAME'];
		$cods_country[$i]=$countrys['COD_COUNTRY'];
		$i++;	
	}
	oci_free_statement($stid);
	
	echo"<table>";
	echo "<tr><th align=center><h2>Criar conta</h2></th></tr>";
	echo "<tr>";
	echo "<td>";

	$form = new HTML_QuickForm('modifyAccount','POST');
	$form->addElement('text', 'username', 'username:');
 	$form->addElement('text', 'firstname', 'Primeiro nome:');
 	$form->addElement('text', 'lastname', 'Ultimo nome');
 	$form->addElement('password', 'password', 'Password:');
 	$form->addElement('password','Vpassword', 'Confirmar password:');   
 	$form->addElement('text','email', 'Email:');
 	$form->addElement('text','phoneN', 'Numero de telefone');
	$form->addElement('radio', 'sex', 'Sexo:', 'Masculino', 'm');
	$form->addElement('radio', 'sex', '', 'Feminino', 'f');
	$form->addElement('select','country','Localidade: ',$country_name);	
	$form->addElement('date','date', 'Data de nascimento',array('minYear'=> 1900));	
	$form->addElement('submit','save','Registar');
	$form->addElement('reset', 'btnClear', 'Limpar');  

		
	
	$form->addRule('username','<font face=verdana size=1 color=red>Só pode ter no maximo 10 caracteres','maxlength',10);
	$form->addRule('username', '<font face=verdana size=1 color=red>Este username já se encontra associado á outra conta', 'callback', 'checkU');
	$form->addRule('username', '<font face=verdana size=1 color=red>Não preencheu o username', 'required',null);
	$form->addRule('password', '<font face=verdana size=1 color=red>Password deve ter entre 5 a 15 caracteres', 'rangelength', array(5,15));
	$form->addRule(array('password', 'Vpassword'), "<font face=verdana size=1 color=red>Passwords não coincidêm", 'compare', 'eq');	
	$form->addRule('password', '<font face=verdana size=1 color=red>Não preencheu o seu priemeiro nome', 'required',null);
	$form->addRule('email','<font face=verdana size=1 color=red>Só pode ter no maximo 30 caracteres','maxlength',30);
	$form->addRule('firstname','<font face=verdana size=1 color=red>Só pode ter no maximo 25 caracteres','maxlength',25);
	$form->addRule('lastname','<font face=verdana size=1 color=red>Só pode ter no maximo 25 caracteres','maxlength',25);
	$form->addRule('phoneN','<font face=verdana size=1 color=red>Só pode ter no maximo 20 digitos','maxlength',20); 
	$form->addRule('phoneN', '<font face=verdana size=1 color=red>Numero de telefone tem de ser correcto', 'rangelength', array(8,20));	
	$form->addRule('email', '<font face=verdana size=1 color=red>Este mail já se encontra associado á outra conta', 'callback', 'checkE');
	$form->addRule('country', '<font face=verdana size=1 color=red>Escolha o seu pais', 'callback', 'check');
	$form->addRule('email', '<font face=verdana size=1 color=red>Email invalido', 'email'); 
	$form->addRule('firstname', '<font face=verdana size=1 color=red>Não preencheu o seu priemeiro nome', 'required',null);  
	$form->addRule('lastname', '<font face=verdana size=1 color=red>Não preencheu o seu ultimo nome', 'required',null);
	$form->addRule('email', '<font face=verdana size=1 color=red>Não preencheu o seu mail', 'required',null);	
	$form->setRequiredNote('<font face=verdana size=1 color=red>* Campos obrigatorios</font>');
	$form->setDefaults(array('sex' => 'm'));


	  
if ($form->validate()) { 
	session_start();
	$_SESSION['nome']=$form->exportValue('username');

	$s = oci_parse($conn,"INSERT into usersB values  (:b1,:b2,:b3 ,TO_DATE(:b4,'YYYY/MM/DD') ,:b5,:b6,:b7,:b8,:b9)");
	oci_bind_by_name($s, ":b1",($form->exportValue('username')));
	oci_bind_by_name($s, ":b2",($form->exportValue('firstname')));
	oci_bind_by_name($s,":b3",($form->exportValue('lastname')));
	oci_bind_by_name($s, ":b4",dataS($form->exportValue('date')));	
	oci_bind_by_name($s, ":b5",($form->exportValue('phoneN')));
	oci_bind_by_name($s,":b6",($form->exportValue('sex')));
	oci_bind_by_name($s,":b7",($form->exportValue('email')));
	oci_bind_by_name($s, ":b8",md5($form->exportValue('password'))); 	
	oci_bind_by_name($s,":b9",$cods_country[($form->exportValue('country'))]);
	oci_execute($s, OCI_DEFAULT);
	oci_commit($conn);
	oci_free_statement($s);
	oci_close($conn);
	
	Header("Location: home.php");   
	exit();

}	 
else {$form->display();}	
echo "</td>";
echo "</tr>";
echo "</table>";

oci_close($conn);
echo "<br><br>";
require_once "foot.php"; 
?>

</body>
</html>
