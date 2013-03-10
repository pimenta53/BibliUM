<?php session_start();if(!$_SESSION['nome']) {Header("Location: index.php");   exit();}?>	
<p align="right"><b><?php echo ($_SESSION['nome']) ?></b> | <a href="home.php">BibliUM</a> | <a href="search_result.php">Pesquisar</a> | <a href="mybibliON.php"> A minha biblioteca</a> | <a href="myAccount.php">A minha conta</a> | <a href="upload.php">upload documentos</a> | <a href="logout.php">Sair</a></p>
<hr>
