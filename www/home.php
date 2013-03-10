
<html>
	<Head>
	<title>BibliUM</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="CSS/blackandwhite/style.css"/>	
	</Head>
<body>	
	<?php 
	require_once "header.php";
	require_once "connection.php";
	require_once "functions/estrelas.php";
	
	$type=$_GET['doc'];
	$area=$_GET['area'];
	$N=5;// numero de documentos que aparecem
	
	
	?>
	<form action="search_result.php" method="GET">	
			<p><font color=#8C1717><b>BibliUM</b></font> <input type="text" name="words" />		
			<input type="submit" value="Pesquisar"><a href="advanced_search.php"> Pesquisa avançada</a> </p>		
	</form>
	<hr>
<table border="0" align="center" COLSPAN="3" WIDTH=100%>
		<tr>
		<td valign="top" width=10%><a href=mybibliON.php><font size=2>A minha Biblioteca</font></a>
		<hr>		
		<ul>
	<?php
	
	$stid = oci_parse($conn, "SELECT cod_type,name_doc FROM doctype where deleted is null order by name_doc");
	oci_execute($stid, OCI_DEFAULT);
	while (($docS=oci_fetch_array($stid))) {  
		$stid2 = oci_parse($conn, "SELECT count(*) FROM docs where cod_type=:b1");
		oci_bind_by_name($stid2,":b1",($docS['COD_TYPE']));
		oci_execute($stid2, OCI_DEFAULT);
		$t=oci_fetch_array($stid2);
		oci_free_statement($stid2);
		echo "<li align=left>".$docS['NAME_DOC']."(".$t[0].")</li>";
	}
	oci_free_statement($stid);	
	?>
		</ul>
		<hr>
		<p align="left"><font size="4"><b>Areas</b></font></p>		
<table border="0" align="left">
		
<?php 
	echo "<tr><td><a href=home.php?area=".NULL.">Todas</a></td></tr>";
	$stid = oci_parse($conn, "SELECT area_name FROM  area where deleted is null order by area_name ASC");
	oci_execute($stid, OCI_DEFAULT);

	while (($areaS=oci_fetch_array($stid)) ) {  
		echo "<tr><td><a href=home.php?area=".$areaS['AREA_NAME'].">".$areaS['AREA_NAME']."</a></td></tr>";
	}
	oci_free_statement($stid);			
?>
		 </table border="0">

		</ul>
		</td>
		<td align="center"  valign='top' align=center width=27%><b>Mais populares</b>
<?php 
	if(!$type){
		if(!$area) $sqlN="SELECT * FROM documents where deleted is null ORDER BY nDownloads DESC";
		else $sqlN="SELECT * FROM documents WHERE deleted is null and area_name=:area ORDER BY nDownloads DESC";}
	else{
		if(!$area) $sqlN="SELECT * FROM documents WHERE deleted is null and name_doc=:doc ORDER BY nDownloads DESC";
		else $sqlN="SELECT * FROM documents WHERE deleted is null and name_doc=:doc AND area_name=:area ORDER BY nDownloads DESC";
	}
	
	$stid = oci_parse($conn,$sqlN);
	oci_bind_by_name($stid,":area",$area);
	oci_bind_by_name($stid,":doc",$type);
	oci_execute($stid, OCI_DEFAULT);

	$i=0;
	while (($docsS=oci_fetch_array($stid)) && $i<$N) {  
		echo "<table bgcolor=#C3D9FF width=100% HEIGHT=105>";
		echo "<tr><td><font color=#8C1717><b>Nome: </b></font>".$docsS['DOC_NAME']."</td></tr>";
		echo "<tr><td><font face=verdana size=1 >por ".$docsS['FIRST_NAME']." ".$docsS['LAST_NAME']." | em ".$docsS['UPLOAD_DATE']." | ".$docsS['NDOWNLOADS']." visitas</font></td></tr>";
		echo "<tr><td align=center><a href=view_doc.php?id=".$docsS['COD_DOC'].">Ver documento</a></td></tr>";
		echo "<tr><td>".getEstrelas(round($docsS['RATING']), "estrelas")."</td></tr>";
		echo "</table><hr>";
		$i++;
	}
	oci_free_statement($stid);			
?>
		 </td>
		<td align="center" valign='top' width=27%><b>Recentes</b>
<?php 
	if(!$type){
		if(!$area) $sqlD="SELECT * FROM documents where deleted is null ORDER BY upload_date DESC";
		else $sqlD="SELECT * FROM documents WHERE deleted is null and area_name=:area ORDER BY upload_date DESC";}
	else{
		if(!$area) $sqlD="SELECT * FROM documents WHERE where deleted is null and name_doc=:doc ORDER BY upload_date DESC";
		else $sqlD="SELECT * FROM documents WHERE deleted is null and name_doc=:doc AND area_name=:area ORDER BY upload_date DESC";
	}
	
	$stid = oci_parse($conn,$sqlD);
	oci_bind_by_name($stid,":area",$area);
	oci_bind_by_name($stid,":doc",$type);
	oci_execute($stid, OCI_DEFAULT);

	$i=0;
	while (($docsD=oci_fetch_array($stid)) && $i<$N) {  
		echo "<table bgcolor=#C3D9FF width=100% HEIGHT=105>";
		echo "<tr><td><font color=#8C1717><b>Nome: </b></font>".$docsD['DOC_NAME']."</td></tr>";
		echo "<tr><td><font face=verdana size=1 >por ".$docsD['FIRST_NAME']." ".$docsD['LAST_NAME']." | em ".$docsD['UPLOAD_DATE']." | ".$docsD['NDOWNLOADS']." visitas</font></td></tr>";
		echo "<tr><td align=center><a href=view_doc.php?id=".$docsD['COD_DOC'].">Ver documento</a></td></tr>";
		echo "<tr><td>".getEstrelas(round($docsD['RATING']), "estrelas")."</td></tr>";
		echo "</table><hr>";
		$i++;	
	}
	oci_free_statement($stid);			
?>
		</td>
		<td align="center" valign='top' width=27%><b>Ranking</b>
	
<?php 
	if(!$type){
		if(!$area) $sqlR="SELECT * FROM documents where deleted is null ORDER BY rating DESC";
		else $sqlR="SELECT * FROM documents WHERE deleted is null and area_name=:area ORDER BY rating DESC";}
	else{
		if(!$area) $sqlR="SELECT * FROM documents WHERE where deleted is null and name_doc=:doc ORDER BY rating DESC";
		else $sqlR="SELECT * FROM documents WHERE deleted is null and name_doc=:doc AND area_name=:area ORDER BY rating DESC";
	}
	
	$stid = oci_parse($conn,$sqlR);
	oci_bind_by_name($stid,":area",$area);
	oci_bind_by_name($stid,":doc",$type);
	oci_execute($stid, OCI_DEFAULT);

	$i=0;
	while (($docsR=oci_fetch_array($stid)) && $i<$N) {  
		echo "<table bgcolor=#C3D9FF width=100% HEIGHT=105>";
		echo "<tr><td><font color=#8C1717><b>Nome: </b></font>".$docsR['DOC_NAME']."</td></tr>";
		echo "<tr><td><font face=verdana size=1 >por ".$docsR['FIRST_NAME']." ".$docsR['LAST_NAME']." | em ".$docsR['UPLOAD_DATE']." | ".$docsR['NDOWNLOADS']." visitas</font></td></tr>";
		echo "<tr><td align=center><a href=view_doc.php?id=".$docsR['COD_DOC'].">Ver documento</a></td></tr>";
		echo "<tr><td>".getEstrelas(round($docsR['RATING']), "estrelas")."</td></tr>";
		echo "</table><hr>";
		$i++;
	}
	oci_free_statement($stid);			
?>			
		</td>
		<td valign="top" width=9%>
		<p align="right"><font size="4"><b>Formatos</b></font></p>		
		<hr>		
		<table border="0" align="right" >
<?php
	echo "<tr><td><a href=home.php?doc=".NULL."&area=".$area.">Todos</a></td></tr>";
	$stid = oci_parse($conn, "SELECT name_doc FROM  doctype where deleted is null order by name_doc ASC");
	oci_execute($stid, OCI_DEFAULT);

	while (($docS=oci_fetch_array($stid)) ) {  
		echo "<tr><td><a href=home.php?doc=".$docS['NAME_DOC']."&area=".$area.">".$docS['NAME_DOC']."</a></td></tr>";
	}
	oci_free_statement($stid);	
    echo "</tr>\n";
?>
		</table>


		
		</tr>	
</table>
</body>	
</html>
