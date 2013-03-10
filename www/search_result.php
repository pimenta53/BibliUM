<html>
<Head>
	<title>Pesquisa BibliUM</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="CSS/blackandwhite/style.css"/>	
</Head>
<body>	
	<?php
	 require_once "header.php";
	 require_once "connection.php";
	require_once "functions/estrelas.php";
	
	$words="%".$_GET["words"]."%";
	$words2=$_GET["words"];
	
	$stid = oci_parse($conn, "SELECT count(*) FROM documents  where deleted is null and (doc_name LIKE :b1 OR description LIKE :b1) ");
	oci_bind_by_name($stid,":b1",$words);
	oci_execute($stid, OCI_DEFAULT);
	$total=oci_fetch_array($stid);
	oci_free_statement($stid);
		
	echo "<form action=search_result.php method=GET>";	
			echo "<input type=text name=words />";		
			echo "<input type=submit value=Pesquisar><a href=advanced_search.php> Pesquisa avançada</a>";		
	echo "</form>";
	echo "<h1>Resultados para <font color=#00009C><u>".$words2."</u></font></h1>";
	echo "<h4>".$total[0]." resultados</h4><hr>";

	echo "<h5>Ordenado por: <a href=search_result.php?order=doc_name&order2=ASC&words=".$_GET["words"]."> Nome</a> | <a href=search_result.php?order=upload_date&order2=DESC&words=".$_GET["words"].">Data de uplaod </a> | <a href=search_result.php?order=rating&order2=DESC&words=".$_GET["words"]."> Ranking</a> | <a href=search_result.php?order=ndownloads&order2=DESC&words=".$_GET["words"]."> Downloads</a></h5>";
	 


	if(!$_GET['order']) $sql="SELECT * FROM documents  where deleted is null and (doc_name LIKE :b1 OR description LIKE :b1) order by doc_name ASC";
	else
	 $sql="SELECT * FROM documents  where deleted is null and (doc_name LIKE :b1 OR description LIKE :b1) order by ".$_GET['order']." ".$_GET['order2'];
	 
	$stid = oci_parse($conn,$sql);
	oci_bind_by_name($stid,":b1",$words);
	oci_execute($stid, OCI_DEFAULT);
	while (($docsR=oci_fetch_array($stid))) {  
		echo "<table  width=500 align=center bgcolor=#C3D9FF>";
		echo "<tr><td><font color=#8C1717><b>Nome: </b></font>".$docsR['DOC_NAME']."</td></tr>";
		echo "<tr><td><font color=#8C1717><b>Descrição: </b></font>".$docsR['DESCRIPTION']."</td></tr>";
		echo "<tr><td><font color=#8C1717><b>Tipo: </b></font>".$docsR['NAME_DOC']."</td></tr>";
		echo "<tr><td><font color=#8C1717><b>Categoria: </b></font>".$docsR['AREA_NAME']."</td></tr>";
		echo "<tr><td><font face=verdana size=1 >por ".$docsR['FIRST_NAME']." ".$docsR['LAST_NAME']." | em ".$docsR['UPLOAD_DATE']." | ".$docsR['NDOWNLOADS']." visitas</font></td></tr>";
		echo "<tr><td>".getEstrelas(round($docsR['RATING']), "estrelas")."</td></tr>";
		echo "</table>";
		echo "<h3 align=center><a href=view_doc.php?id=".$docsR['COD_DOC'].">Ver documento</a></h3>";
	}
	oci_free_statement($stid);
	oci_close($conn);	 
	 ?> 
		
</body>
</html>
