<?php

function stars($id){

$conn = oci_connect('pimz', 'pimz53', 'localhost/XE');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$stid = oci_parse($conn, "SELECT rating FROM docs where cod_doc=:b1");
oci_define_by_name($stid,':b1',$id);
oci_execute($stid, OCI_DEFAULT);

if($rating=oci_fetch_all($stid)) $r =$rating['RATING']; else $r=0;


echo "<form style=display:none title=Average Rating:=".$r."class=rating action=rate.php>";
    echo "<input type=hidden name=valor value=1 />";
    echo "<select id=r1>";
    echo "<option value=1>1</option>";
    echo  "<option value=2>2</option>";
    echo "<option value=3>3</option>";
    echo "<option value=4>4</option>";
    echo "<option value=5>5</option>";
    echo "</select>";
	echo "</form>";
oci_free_statement($stid);
oci_close($conn);

}
?>
