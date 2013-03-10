<?php
function check($value){
	if($value[0]>0) return true;else false;
}

function checkE($value){
	
$conn = oci_connect('pimz', 'pimz53', 'localhost/XE');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

	$stid = oci_parse($conn, "SELECT email FROM usersB WHERE email=:b3");
	oci_bind_by_name($stid, ':b3',$value);
	oci_execute($stid);
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {  
		foreach ($row as $item) {
			$bd[0]=$item;    
		}
	}
	oci_free_statement($stid);
	oci_close($conn);

	$flag = ($bd[0] == NULL ) ? true : false;

return $flag;
}



function checkU($value){
	
	$conn = oci_connect('pimz', 'pimz53', 'localhost/XE');
/*if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}*/

	$stid = oci_parse($conn, "SELECT username FROM usersB WHERE username=:b3");
	oci_bind_by_name($stid, ':b3',$value);
	oci_execute($stid);

	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {  
    
    foreach ($row as $item) {
        $bd[0]=$item;    
		}
	}

$flag = ($bd[0] == NULL ) ? true : false;
oci_free_statement($stid);
oci_close($conn);
    return $flag;
}
?>
