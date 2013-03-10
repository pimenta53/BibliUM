<?php
	
	session_start();if(!$_SESSION['nome']) {Header("Location: index.php");   exit();}
	require_once "connection.php";


	$rate = explode('#',$_POST['rating']);
	$r = $rate[1];


	$stid = oci_parse($conn, "insert into ratingdoc values (new_rating.NEXTVAL,:b1,:b2,:b3)");
	oci_bind_by_name($stid,":b1",$r);
	oci_bind_by_name($stid,":b2",$_SESSION['id']);
	oci_bind_by_name($stid,":b3",$_SESSION['nome']);
	oci_execute($stid, OCI_DEFAULT);
	oci_free_statement($stid);
	oci_commit($conn);
	oci_close($conn);
	unset($_SESSION['id']);
?>
