<html>
	<Head>
	<title>BibliUM</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="CSS/blackandwhite/style.css"/>	
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="jquery.rating.js"></script>
<script type="text/javascript">
jQuery(function(){
    jQuery('form.rating').rating();
});
</script>
	</Head>
<body align="center">
<?php
	require_once "header.php";
	require_once "connection.php";
	echo "<h1 align=left>Arquivo <font color=#00009C><u>".$_GET['id']."</u></font></h1><hr>";
	$_SESSION['id']=$_GET['id'];

	$stid2 = oci_parse($conn,"SELECT rating FROM ratingdoc WHERE cod_doc=:b1 and username=:b2");
	oci_bind_by_name($stid2,":b1",$_GET['id']);
	oci_bind_by_name($stid2,":b2",$_SESSION['nome']);
	oci_execute($stid2, OCI_DEFAULT);
	$rate=oci_fetch_array($stid2);
	oci_free_statement($stid2);
			
	$stid = oci_parse($conn,"SELECT * FROM documents WHERE cod_doc=:doc");
	oci_bind_by_name($stid,":doc",$_GET['id']);
	oci_execute($stid, OCI_DEFAULT);
	$docsS=oci_fetch_array($stid);
	oci_free_statement($stid);
	
	$stid2 = oci_parse($conn,"SELECT * FROM authors WHERE author_name=:b1");
	oci_bind_by_name($stid2,":b1",$docsS['AUTHOR_NAME']);
	oci_execute($stid2, OCI_DEFAULT);
	$authorS=oci_fetch_array($stid2);
	oci_free_statement($stid2);
	
	$author= ($authorS['AUTHOR_NAME']) ? $authorS['AUTHOR_NAME']." nascido em: ".$authorS['BIRTH_DATE'].", ".$authorS['COUNTRY_NAME'] : $vazio;
	echo "<h1 align=center>".$docsS['DOC_NAME']."<h1>";
	echo "<table align=center width=400 bgcolor=#C3D9FF>";
		echo "<tr><td><font color=#8C1717><b>Nome: </b></font>".$docsS['DOC_NAME']."</td></tr>";
		echo "<tr><td><font color=#8C1717><b>Descrição: </b></font>".$docsS['DESCRIPTION']."</td></tr>";
		echo "<tr><td><font color=#8C1717><b>Data upload: </b></font>".$docsS['UPLOAD_DATE']."</td></tr>";
		echo "<tr><td><font color=#8C1717><b>Tipo de documento: </b></font>".$docsS['NAME_DOC']."</td></tr>";
		echo "<tr><td><font color=#8C1717><b>Categoria: </b></font>".$docsS['AREA_NAME']."</td></tr>";
		echo "<tr><td><font color=#8C1717><b>Sub-Categoria: </b></font>".$docsS['NAME_SPECIFIC']."</td></tr>";
		echo "<tr><td><font color=#8C1717><b>Instituição: </b></font>".$docsS['UNIV_NAME']."</td></tr>";
		echo "<tr><td><font color=#8C1717><b>Autor: </b></font>".$author."</td></tr>";
		echo "<tr><td><font color=#8C1717><b>Votação: </b></font>".$docsS['RATING']."</td></tr>";
		echo "<tr><td><font color=#8C1717><b>Numero de downloads: </b></font>".$docsS['NDOWNLOADS']."</td></tr>";
		echo "<tr><td><font color=#8C1717><b>Utilizador: </b></font>".$docsS['FIRST_NAME']." ".$docsS['LAST_NAME']."</td></tr>";
				?>
				<tr><td><font size="1">O seu voto</font><form style="display:none" title="Average Rating: <?=$rate['RATING']?>" class="rating" action="rate.php">
    <input type="hidden" name="valor" value="1" />
    <select id="r1">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
</form></td></tr>
		<?php
	echo "</table>";
	echo "<h3 align=center><a href=download.php?id=".$docsS['COD_DOC'].">Download</a></h3>";
	echo "<h1 align=center>";
	echo "<form action=coments.php method=GET >";
	echo "<Textarea cols=50 rows=5 name=comment maxlength=500 ></textarea>";
	echo "<input type=hidden name=codigo value=".$docsS['COD_DOC'].">";
	echo "<br><input type=submit value=Comentar>";
	echo "</form></h1>";
	
	$sql="SELECT username,comment_user,post_date FROM  comments where cod_doc=".$_GET['id']." order by post_date DESC";

	$stid = oci_parse($conn,$sql);
	oci_execute($stid, OCI_DEFAULT);
	$i=0;
	while (($commentS=oci_fetch_array($stid)) ) {  
		if ($i % 2)  echo "<table  bgcolor=#C3D9FF align=center width=410>"; else echo "<table bgcolor=#C0C0C0 align=center width=410>";
		echo "<tr><td><font face=verdana size=1 >".$commentS['POST_DATE']." | por ".$commentS['USERNAME']."</font></td></tr>";
		echo "<tr><td>".$commentS['COMMENT_USER']."</td></tr>";
		echo "</table><br>";
		$i++;
	}
	oci_free_statement($stid);


oci_close($conn);
require_once "foot.php"; 
?>
</body>
</html>
