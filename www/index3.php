<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="CSS/blackandwhite/style.css"/>
  <title>BibliUM</title>
</head>
<body>
	<h1> <br>	BibliUM </h1><br>	
	<table border="0"  valign="center" align="center">
		<tr>
		<td >
			<div>
				<h2>BibliUM permite a partilha e armazenamento dos seus documentos</h2>
				<br>
				<ul>
					<li><b>Partilha de documentos : colaboração em tempo real.</b></li>
					<br>
					<li><b>Pesquisa de documentos : permite a procura de documentos que pretende ver.</b></li>
					<br>
					<li><b>Espaço de armazenamento : permite armazenar os seus documentos online.</b></li>
					<br>
				</ul>
			</div>
		</td>
		<td width =28%  bgcolor=#C3D9FF>
			<div class="caixa1" align="center">
			<p>Acesse com a sua <br>Conta BibliUM</p>
<?php
  require_once "HTML/QuickForm.php";
  require_once "connection.php";

  $form = new HTML_QuickForm('register', 'post');
  $form->addElement('text', 'username', 'username');
  $form->addElement('password','password', 'password');
  $form->addElement('submit','sb','Login');
  
$form->addRule('username', '<font face=verdana size=1 color=red>Não preencheu o seu o username', 'required',null);
	$form->addRule('password', '<font face=verdana size=1 color=red>Não preencheu a sua passwor', 'required',null);
	$form->addRule('username', '<font face=verdana size=1 color=red>não está registado', 'callback', 'checkU');
	$form->addRule('password', '<font face=verdana size=1 color=red>Passowrd errada ou user não registado', 'callback', 'loginU'); 
	 
 
 
 $form->setRequiredNote('<font face=verdana size=1 color=red>*Login obrigatório</font>');
  $form->setJsWarnings('Erro(s):','Preencha corretamente os campos acima');
  

function checkU($value){
	
$c = oci_connect('pimz', 'pimz53', 'localhost/XE');

$stid = oci_parse($c, "SELECT username FROM usersB WHERE username=:b3");
oci_bind_by_name($stid, ':b3',$value);
oci_execute($stid);


$nrows = oci_fetch_all($stid, $res);

$flag = ($nrows>0 ) ? true : false;
oci_free_statement($stid);
oci_close($c);
    return $flag;
}

function loginU($pass) {
$c = oci_connect('pimz', 'pimz53', 'localhost/XE');
global $form;
$user=$form->exportValue('username');
$stid = oci_parse($c, "SELECT username FROM usersB WHERE username=:b1 AND user_password=:b2");
oci_bind_by_name($stid, ':b1',$user);
oci_bind_by_name($stid, ':b2',md5($pass));
oci_execute($stid);


$nrows = oci_fetch_all($stid, $res);
$flag = ($nrows>0 ) ? true : false;
oci_free_statement($stid);
oci_close($c);
    return $flag;

 }


 if ($form->validate()) {
session_start();
$_SESSION['nome']=$form->exportValue('username');


$s = oci_parse($conn,"insert into logg values (new_logg.NEXTVAL,:b1,TO_DATE(:b2,'YYYY/MM/DD'),'l',null)");
oci_bind_by_name($s, ":b1",($form->exportValue('username')));
oci_bind_by_name($s, ":b2",date("Y/m/d"));
oci_execute($s, OCI_DEFAULT);
oci_commit($conn);
oci_free_statement($s);
oci_close($conn);


Header("Location: home.php");   
exit();

}

  else {
    $form->display();
  }
oci_close($conn);
?>  

			<a href="recover.php">Não consegue aceder a sua conta?</a>
			</div>
			<div class="caixa1" align="center">
			<p><br><br>Ainda não tem conta? Registe-se aqui</p>
			<form action="register_user.php" target="_self" method="POST">
				<input type="submit" value="Registar">
			</form>
			</div>
		</td>
		</tr>
	</table>
	<br><br>
<?php require_once "foot.php";?>
</body>
</html>

