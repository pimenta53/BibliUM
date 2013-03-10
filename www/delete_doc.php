<?php
	require_once "connection.php";	
	
	$stid=oci_parse($conn,"UPDATE docs SET deleted=TO_DATE(:data,'YYYY/MM/DD') WHERE cod_doc=:id");
	oci_bind_by_name($stid, ":data",date("Y/m/d"));
	oci_bind_by_name($stid, ":id",$_GET['id']);
	oci_execute($stid);
	oci_free_statement($stid);
	oci_commit($conn);
	oci_close($conn);
	
	
	Header("Location: mybibliON.php");   
	exit();

?>
