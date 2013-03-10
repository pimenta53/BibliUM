<html>
	<Head>
	<title>Pesquisa avançada</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="CSS/blackandwhite/style.css"/>	
	</Head>
<body>	
<?php 
	require_once "header.php";
	require_once "functions/date.php";
	require_once "HTML/QuickForm.php";
	require_once "connection.php";
	require_once "functions/estrelas.php";
	
	echo "<h1><a href=advanced_search.php><font color=#8C1717>Pesquisa avançada</font></a></h1><hr>";

  
	// para documentos
	$stid = oci_parse($conn, "SELECT * FROM doctype where deleted is null");
	oci_execute($stid, OCI_DEFAULT);
	$i=1;
	$docs_type[0]="Escolher Tipo de documento";
	$cods_type[0]=NULL;

	while ($docs=oci_fetch_array($stid)) {  
		$docs_type[$i]=$docs['NAME_DOC'];
		$cods_type[$i]=$docs['COD_TYPE'];
		$i++;	
	}
	oci_free_statement($stid);

	$stid = oci_parse($conn, "SELECT * FROM area where deleted is null");
	oci_execute($stid, OCI_DEFAULT);
	$i=1;
	$areas_name[0]="Escolha uma area";
	$cods_area[0]=NULL;
	while ($docs=oci_fetch_array($stid)) {  
		$areas_name[$i]=$docs['AREA_NAME'];
		$cods_area[$i]=$docs['COD_AREA'];
		$i++;	
	}
	oci_free_statement($stid);

	$i=1;
	while($cods_area[$i]){
		$stid = oci_parse($conn, "SELECT * FROM specific WHERE cod_area=:b1 where deleted is null");
		oci_bind_by_name($stid, ":b1",$cods_area[$i]);
		oci_execute($stid, OCI_DEFAULT);
		$j=1;
		$specific_name[$i][0]="Escolha";
		$cods_specific[$i][0]=NULL;
		while ($docs=oci_fetch_array($stid)) {  
			$specific_name[$i][$j]=$docs['NAME_SPECIFIC']; 
			$cods_specific[$i][$j]=$docs['COD_SPECIFIC'];
			$j++;	
		}
		oci_free_statement($stid);
		$i++;
	}

	$stid = oci_parse($conn, "SELECT * FROM univ where deleted is null");
	oci_execute($stid, OCI_DEFAULT);
	$i=1;
	$univ_name[0]="Escolha uma Universidade";
	$cods_univ[0]=NULL;
	while ($docs=oci_fetch_array($stid)) {  
		$univ_name[$i]=$docs['UNIV_NAME'];
		$cods_univ[$i]=$docs['COD_UNIV'];
		$i++;	
	}
	oci_free_statement($stid);
	
	$form = new HTML_QuickForm('pesquisa', 'get');
	$form->addElement('text', 'whith', 'Com as palavras');
	$form->addElement('text', 'whithout', 'Sem as palavras');
	$form->addElement('text', 'name', 'Nome ficheiro');
	$form->addElement('text', 'author', 'Autor');
	$select = $form->addElement('hierselect', 'area', 'Categoria:');
	$select->setOptions(array($areas_name, $specific_name));
	$form->addElement('select','univ','Universidade',$univ_name);
	$form->addElement('date', 'date1', 'Data upload entre');
	$form->addElement('date', 'date2','e',array('maxYear' => date('Y')+1));
	$form->addElement('select','doc_type','Tipo de documento',$docs_type);
	$form->addElement('submit','sb','Pesquisar');
	$form->addElement('reset','reset','Limpar');

	$form->setDefaults(array('date2' => date("Y/m/d")));

	$areA=($form->exportValue('area'));
	$a=$areA[0];$e=$areA[1];


$with_words="'%".$form->exportValue('whith')."%'";
$without="'%".$form->exportValue('whithout')."%'";
$name="'%".$form->exportValue('name')."%'";
$author="'%".$form->exportValue('author')."%'";
$doc_type="'%".$docs_type[$form->exportValue('doc_type')]."%'";
$area="'%".$areas_name[$a]."%'";
$sub_area="'%".$specific_name[$a][$e]."%'";
$data1 ="'".dataS($form->exportValue('date1'))."'";
$data2 ="'".dataS($form->exportValue('date2'))."'";
$univ="'%".$univ_name[$form->exportValue('univ')]."%'";

if($form->exportValue('whith')){
	if(!$form->exportValue('whithout')) $sql="SELECT * FROM documents where (deleted is null) and (description  like $with_words or doc_name  like $with_words)";
	else $sql="SELECT * FROM documents where (deleted is null) and (description  like $with_words or doc_name  like $with_words) and (description  not like $without and doc_name not like $without)";
}
else {
	if($form->exportValue('whithout')) $sql="SELECT * FROM documents where (deleted is null) and (description  not like $without or doc_name not like $without)";
	else{ $sql="SELECT * FROM documents where (deleted is null)"; }
}

if($cods_univ[$form->exportValue('univ')]) {
	 $sql.=" and univ_name LIKE $univ";
}
if($form->exportValue('name')) {
	$sql.=" and doc_name LIKE $name"; 

}
if($form->exportValue('author')){
	 $sql.=" and author_name LIKE $author";

}
if($form->exportValue('doc_type')){
	 $sql.=" and name_doc LIKE $doc_type";
	 
}
if($cods_area[$a]){
	$sql.=" and area_name LIKE $area";

}
if($cods_specific[$a][$e]){ 
	$sql.=" and NAME_SPECIFIC LIKE $sub_area";

}
$sql.=" and ( upload_date between TO_DATE($data1,'YYYY/MM/DD') and TO_DATE($data2,'YYYY/MM/DD'))";

 if ($form->validate()) {
	 
	 echo $sql;

	$stid = oci_parse($conn,$sql);
	oci_execute($stid, OCI_DEFAULT);
	$total=oci_fetch_all($stid,$t);
	oci_free_statement($stid);
	unset($t);
	
	echo "<h4>".$total." resultados</h4><hr>";
	 $stid = oci_parse($conn,$sql);
	oci_execute($stid, OCI_DEFAULT);
	while (($docsR=oci_fetch_array($stid))) {  
		echo "<table  width=500 align=center bgcolor=#C3D9FF>";
		echo "<tr><td><font color=#8C1717><b>Nome: </b></font>".$docsR['DOC_NAME']."</td></tr>";
		echo "<tr><td><font color=#8C1717><b>Descrição: </b></font>".$docsR['DESCRIPTION']."</td></tr>";
		echo "<tr><td><font color=#8C1717><b>Tipo: </b></font>".$docsR['NAME_DOC']."</td></tr>";
		echo "<tr><td><font color=#8C1717><b>Categoria: </b></font>".$docsR['AREA_NAME']."</td></tr>";
		echo "<tr><td><font face=verdana size=1 >por ".$docsR['FIRST_NAME']." ".$docsR['LAST_NAME']." | em ".$docsR['UPLOAD_DATE']." | ".$docsR['NDOWNLOADS']." visitas</font></td></tr>";
		echo "<tr><td>".getEstrelas($docsR['RATING'], "estrelas")."</td></tr>";
		echo "</table>";
		echo "<h3 align=center><a href=view_doc.php?id=".$docsR['COD_DOC'].">Ver documento</a></h3>";
	}
	oci_free_statement($stid);
	oci_close($conn);
	
}

  else {
    $form->display();
  }
oci_close($conn); ?>
</body>
</html>
