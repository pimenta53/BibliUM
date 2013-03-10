<html>
<Head>
	<title>Minha conta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
	<link rel="stylesheet" type="text/css" href="CSS/blackandwhite/style.css"/>
</Head>
<body>	
	<?php require_once "header.php";
	require_once "HTML/QuickForm.php";
	require_once "connection.php";	
	require_once "functions/date.php";	
	
	echo "<h1>Minha conta</h1><hr>";
	echo "<h2>Alterar password</h2>";
	
	// dados do utilizador
	$stid = oci_parse($conn,"SELECT first_name,last_name,birth_date,email,sex,phone_number,country_name FROM usersB u,country ct WHERE username=:b1 and ct.cod_country=u.cod_country");
	oci_bind_by_name($stid,":b1",$_SESSION['nome']);
	oci_execute($stid, OCI_DEFAULT);
	$user=oci_fetch_array($stid);
	oci_free_statement($stid);
	
	$stid = oci_parse($conn, 'SELECT * FROM COUNTRY order by country_name ');
	oci_execute($stid, OCI_DEFAULT);
	$i=1;
	$country_name[0]=$user['COUNTRY_NAME'];
	$cods_country[0]=0;
	while ($countrys=oci_fetch_array($stid)) {  
		if(($countrys['COUNTRY_NAME'])==($user['COUNTRY_NAME'])) {$cods_country[0]=$countrys['COD_COUNTRY'];}
		else {$country_name[$i]=$countrys['COUNTRY_NAME'];
		$cods_country[$i]=$countrys['COD_COUNTRY'];
		$i++;}	
	}
	oci_free_statement($stid);
	
	$form2 = new HTML_QuickForm('modifyPassword','POST');	
	$form2->addElement('password', 'old_password', 'Password actual:');	
	$form2->addElement('password', 'password', 'Nova password:');
 	$form2->addElement('password','Vpassword', 'Confirmar nova password:');   
	$form2->addElement('submit','new_pass','Alterar');  
  
	$form2->addRule('password', '<font face=verdana size=1 color=red>Não preencheu a sua password', 'required',null);
	$form2->addRule('old_password', '<font face=verdana size=1 color=red>Não preencheu a sua nova password', 'required',null);	
	$form2->addRule('password', '<font face=verdana size=1 color=red>Password deve ter entre 5 a 15 caracteres', 'rangelength', array(5,15));	
	$form2->addRule(array('password', 'Vpassword'), "<font face=verdana size=1 color=red>Passwords não coincidêm", 'compare', 'eq');	
	$form2->addRule('old_password', '<font face=verdana size=1 color=red>Password errada', 'callback', 'checkP');	
	$form2->setRequiredNote('<font face=verdana size=1 color=red>* Campos obrigatorios</font>');

function checkP($value){

	$c = oci_connect('pimz', 'pimz53', 'localhost/XE');
	$stid = oci_parse($c, "SELECT user_password FROM usersB WHERE username=:b1 AND user_password=:b2");
	oci_bind_by_name($stid, ':b1',$_SESSION['nome']);	
	oci_bind_by_name($stid, ':b2',md5($value));
	oci_execute($stid);
	$nrows = oci_fetch_all($stid, $res);

	$flag = ($nrows>0 ) ? true : false;
	oci_free_statement($stid);
	oci_close($c);

return $flag;
}
	  
if ($form2->validate()) { 

	$s = oci_parse($conn,"UPDATE usersB SET user_password =:b1 WHERE username=:b2 ");
	oci_bind_by_name($s, ":b1",(md5($form2->exportValue('password'))));
	oci_bind_by_name($s,":b2",$_SESSION['nome']);
	oci_execute($s, OCI_DEFAULT);
	oci_commit($conn);
	oci_free_statement($s);
	oci_close($conn);
	Header("Location: home.php");   
	exit();

}
else {$form2->display();}	
	
	echo "<hr>";
	echo "<h2>Editar informações pessoais</h2>";
	$form = new HTML_QuickForm('modifyAccount','GET');
 	$form->addElement('text', 'firstname', 'Primeiro nome:');
 	$form->addElement('text', 'lastname', 'Ultimo nome');
 	$form->addElement('text','email', 'Email:');
 	$form->addElement('text','phoneN', 'Numero de telefone');
	$form->addElement('radio', 'sex', 'Sexo:', 'Masculino', 'm');
	$form->addElement('radio', 'sex', '', 'Feminino', 'f');
	$form->addElement('select','country','Localidade: ',$country_name);	
	$form->addElement('date','date', 'Data de nascimento',array('minYear'=> 1900));	
	$form->addElement('submit','save','Alterar');
	$form->addElement('reset', 'btnClear', 'Limpar');  

	$form->addRule('email','<font face=verdana size=1 color=red>Só pode ter no maximo 30 caracteres','maxlength',30);
	$form->addRule('firstname','<font face=verdana size=1 color=red>Só pode ter no maximo 25 caracteres','maxlength',25);
	$form->addRule('lastname','<font face=verdana size=1 color=red>Só pode ter no maximo 25 caracteres','maxlength',25);
	$form->addRule('phoneN','<font face=verdana size=1 color=red>Só pode ter no maximo 20 digitos','maxlength',20); 
	$form->addRule('phoneN', '<font face=verdana size=1 color=red>Numero de telefone tem de ser correcto', 'rangelength', array(8,20));	
	$form->addRule('email', '<font face=verdana size=1 color=red>Este mail já se encontra associado á outra conta', 'callback', 'checkE2');
	$form->addRule('email', '<font face=verdana size=1 color=red>Email invalido', 'email'); 
	$form->addRule('firstname', '<font face=verdana size=1 color=red>Não preencheu o seu priemeiro nome', 'required',null);  
	$form->addRule('lastname', '<font face=verdana size=1 color=red>Não preencheu o seu ultimo nome', 'required',null);
	$form->addRule('email', '<font face=verdana size=1 color=red>Não preencheu o seu mail', 'required',null);	
	$form->setRequiredNote('<font face=verdana size=1 color=red>* Campos obrigatorios</font>');
  
  $form->setDefaults(array(
    'firstname' => $user['FIRST_NAME'],
    'lastname' => $user['LAST_NAME'],
    'email' => $user['EMAIL'],
    'phoneN' => $user['PHONE_NUMBER'],
    'sex' => $user['SEX'],
    'date' => $user['BIRTH_DATE']));

function checkE($value){
		
	$c = oci_connect('pimz', 'pimz53', 'localhost/XE');
	$stid = oci_parse($c, "SELECT username FROM usersB WHERE email=:b1 AND email!=(select email from usersB WHERE username=:b2)");
	oci_bind_by_name($stid, ':b1',$value);
	oci_bind_by_name($stid, ':b2',$_SESSION['nome']);
	oci_execute($stid);
	$nrows = oci_fetch_all($stid, $res);

	$flag = ($nrows>0 ) ? false : true;
	oci_free_statement($stid);
	oci_close($c);

return $flag;
}
	  
if ($form->validate()) { 

	$s = oci_parse($conn,"UPDATE usersB SET first_name =:b1,last_name=:b2,email=:b3,sex=:b4,cod_country=:b5 ,birth_date=TO_DATE(:b6,'YYYY/MM/DD'), phone_number=:b7 WHERE username=:b8");
	oci_bind_by_name($s, ":b1",($form->exportValue('firstname')));
	oci_bind_by_name($s,":b2",($form->exportValue('lastname')));
	oci_bind_by_name($s,":b3",($form->exportValue('email')));
	oci_bind_by_name($s,":b4",($form->exportValue('sex')));
	oci_bind_by_name($s,":b5",$cods_country[($form->exportValue('country'))]);
	oci_bind_by_name($s, ":b6",dataS($form->exportValue('date')));	
	oci_bind_by_name($s, ":b7",($form->exportValue('phoneN')));
	oci_bind_by_name($s, ":b8",$_SESSION['nome']);	
	oci_execute($s, OCI_DEFAULT);
	oci_commit($conn);
	oci_free_statement($s);
	oci_close($conn);
	Header("Location: home.php");   
	exit();

}
else {$form->display();}	
require_once "foot.php"; 
oci_close($conn);
?>

</body>
</html>
