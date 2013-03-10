<?php 

require_once "connection.php";
session_start();

	$s = oci_parse($conn,"insert into comments values (new_comments.NEXTVAL,:b1,:b2,:b3,TO_DATE(:data,'YYYY/MM/DD hh24:mi:ss'),null)");
	oci_bind_by_name($s, ":b1",$_SESSION['nome']);
	oci_bind_by_name($s, ":b2",$_GET['comment']);
	oci_bind_by_name($s, ":b3",$_GET['codigo']);
	oci_bind_by_name($s, ":data",date("Y/m/d  H:i:s"));
	oci_execute($s, OCI_DEFAULT);
	oci_commit($conn);
	oci_free_statement($s);
	oci_close($conn);
	$id=$_GET['codigo'];
	Header("Location: view_doc.php?id=$id");   
	exit();

?>
