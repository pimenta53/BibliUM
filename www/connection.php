<?php
$conn = oci_connect('pimz', 'pimz53', 'localhost/XE');
	if (!$conn) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	} 
?>
