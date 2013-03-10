<html>
<Head>
	<title>BibliUM</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="CSS/blackandwhite/style.css"/>	
</Head>
<body>	
	<?php require_once "header.php";
	require_once "connection.php";
	
	$ordem = ($_GET['order'] == 'upload_date') ? 'upload_date' : 'doc_name';
	$ordem2 = ($_GET['order2'] == 'DESC') ? 'DESC' : 'ASC';
	
	echo "<h1 align=center>A minha biblioteca</h1><hr>";
	echo "<h5>Ordenado por: <a href=mybibliON.php?order=name_doc&order2=".$ordem2.">( Nome</a> | <a href=mybibliON.php?order=upload_date&order2=".$ordem2.">Data de uplaod )</a> <a href=mybibliON.php?order=".$ordem."&order2=ASC>ASC</a> <a href=mybibliON.php?order=".$ordem."&order2=DESC>DESC</a></h5>";	


	$stid = oci_parse($conn, "SELECT * FROM doctype where deleted is null ORDER BY name_doc");
	oci_execute($stid, OCI_DEFAULT);
	$i=0;
	$docs_type;
	$cods_type;

	while ($docs=oci_fetch_array($stid)) {  
		$docs_type[$i]=$docs['NAME_DOC'];
		$cods_type[$i]=$docs['COD_TYPE'];
		$i++;	
	}
	oci_free_statement($stid);

	$sql="SELECT doc_name,cod_doc,upload_date FROM docs WHERE username=:b1 AND cod_type=:b2 AND deleted is null ORDER BY $ordem $ordem2";

	$i=0;
	while($cods_type[$i]){
		$stid = oci_parse($conn,$sql);
		oci_bind_by_name($stid,":b1",$_SESSION['nome']);	
		oci_bind_by_name($stid,":b2",$cods_type[$i]);
		oci_bind_by_name($stid,":b3",$ordem);	
		oci_execute($stid, OCI_DEFAULT);
		$j=0;
		while ($docs=oci_fetch_array($stid)) {  
			$documento[$i][$j]=$docs['DOC_NAME'];		
			$id[$i][$j]=$docs['COD_DOC'];
			$data[$i][$j]=$docs['UPLOAD_DATE'];	
			$j++;	
		}
		oci_free_statement($stid);	
		$i++;
	}
	
		
	echo "<table border=0  align=center >";
	echo "<tr>";

$i=0;
	while($docs_type[$i]){ echo "<th valign=top bgcolor=#C3D9FF><font color=#8C1717> $docs_type[$i] (".count($documento[$i]). ")"; 
		echo"<table  align=center width=260 >";		
		$j=0;		
		while($documento[$i][$j] && $id[$i][$j])
			{echo "<tr><td align=center ><a href=view_doc.php?id=".$id[$i][$j]."><font face=verdana size=3 >".$documento[$i][$j]."</a><br><font face=verdana size=1 >Data upload: ".$data[$i][$j]."<br><a href=delete_doc.php?id=".$id[$i][$j]."> <img width=12 height=12 src=CSS/delete-icon.png></a></td></tr>";
			$j++;}
		echo "</table>";
		echo "</th>";
		$i++;
	}
	oci_close($conn);
echo "</tr>";
echo "</table>";
?>

</body>
</html>
