<?
function getEstrelas($numero_estrelas, $nome_hidden_estrelas){
	$retorno = "";
	$i=0;
	if ($nome_hidden_estrelas == ""){
		for ($i=0;$i<=4;$i++){
			if ($numero_estrelas<=$i){$retorno .= "<img src=\"imagens/estrela2.gif\" width=\"16\" height=\"16\">";}
			else{$retorno .= "<img src=\"imagens/estrela1.gif\" width=\"16\" height=\"16\">";}
		}
	}
	else{
		if ($numero_estrelas == 0){
			$retorno .= "<img src=\"imagens/estrela2.gif\" aceso=\"0\" alt=\"1 estrela\" id=\"star1\" onclick=\"changeStar(this, 1, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela2.gif\" aceso=\"0\" alt=\"2 estrelas\" id=\"star2\" onclick=\"changeStar(this, 2, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela2.gif\" aceso=\"0\" alt=\"3 estrelas\" id=\"star3\" onclick=\"changeStar(this, 3, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela2.gif\" aceso=\"0\" alt=\"4 estrelas\" id=\"star4\" onclick=\"changeStar(this, 4, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela2.gif\" aceso=\"0\" alt=\"5 estrelas\" id=\"star5\" onclick=\"changeStar(this, 5, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
		}
		elseif ($numero_estrelas == 1){
			$retorno .= "<img src=\"imagens/estrela1.gif\" aceso=\"1\" alt=\"1 estrela\" id=\"star1\" onclick=\"changeStar(this, 1, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela2.gif\" aceso=\"0\" alt=\"2 estrelas\" id=\"star2\" onclick=\"changeStar(this, 2, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela2.gif\" aceso=\"0\" alt=\"3 estrelas\" id=\"star3\" onclick=\"changeStar(this, 3, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela2.gif\" aceso=\"0\" alt=\"4 estrelas\" id=\"star4\" onclick=\"changeStar(this, 4, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela2.gif\" aceso=\"0\" alt=\"5 estrelas\" id=\"star5\" onclick=\"changeStar(this, 5, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
		}
		elseif ($numero_estrelas == 2){
			$retorno .= "<img src=\"imagens/estrela1.gif\" aceso=\"1\" alt=\"1 estrela\" id=\"star1\" onclick=\"changeStar(this, 1, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela1.gif\" aceso=\"1\" alt=\"2 estrelas\" id=\"star2\" onclick=\"changeStar(this, 2, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela2.gif\" aceso=\"0\" alt=\"3 estrelas\" id=\"star3\" onclick=\"changeStar(this, 3, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela2.gif\" aceso=\"0\" alt=\"4 estrelas\" id=\"star4\" onclick=\"changeStar(this, 4, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela2.gif\" aceso=\"0\" alt=\"5 estrelas\" id=\"star5\" onclick=\"changeStar(this, 5, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
		}
		elseif ($numero_estrelas == 3){
			$retorno .= "<img src=\"imagens/estrela1.gif\" aceso=\"1\" alt=\"1 estrela\" id=\"star1\" onclick=\"changeStar(this, 1, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela1.gif\" aceso=\"1\" alt=\"2 estrelas\" id=\"star2\" onclick=\"changeStar(this, 2, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela1.gif\" aceso=\"1\" alt=\"3 estrelas\" id=\"star3\" onclick=\"changeStar(this, 3, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela2.gif\" aceso=\"0\" alt=\"4 estrelas\" id=\"star4\" onclick=\"changeStar(this, 4, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela2.gif\" aceso=\"0\" alt=\"5 estrelas\" id=\"star5\" onclick=\"changeStar(this, 5, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
		}
		elseif ($numero_estrelas == 4){
			$retorno .= "<img src=\"imagens/estrela1.gif\" aceso=\"1\" alt=\"1 estrela\" id=\"star1\" onclick=\"changeStar(this, 1, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela1.gif\" aceso=\"1\" alt=\"2 estrelas\" id=\"star2\" onclick=\"changeStar(this, 2, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela1.gif\" aceso=\"1\" alt=\"3 estrelas\" id=\"star3\" onclick=\"changeStar(this, 3, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela1.gif\" aceso=\"1\" alt=\"4 estrelas\" id=\"star4\" onclick=\"changeStar(this, 4, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela2.gif\" aceso=\"0\" alt=\"5 estrelas\" id=\"star5\" onclick=\"changeStar(this, 5, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
		}
		elseif ($numero_estrelas == 5){
			$retorno .= "<img src=\"imagens/estrela1.gif\" aceso=\"1\" alt=\"1 estrela\" id=\"star1\" onclick=\"changeStar(this, 1, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela1.gif\" aceso=\"1\" alt=\"2 estrelas\" id=\"star2\" onclick=\"changeStar(this, 2, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela1.gif\" aceso=\"1\" alt=\"3 estrelas\" id=\"star3\" onclick=\"changeStar(this, 3, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela1.gif\" aceso=\"1\" alt=\"4 estrelas\" id=\"star4\" onclick=\"changeStar(this, 4, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
			$retorno .= "<img src=\"imagens/estrela1.gif\" aceso=\"1\" alt=\"5 estrelas\" id=\"star5\" onclick=\"changeStar(this, 5, 'estrelas')\" style=\"cursor:hand\" width=\"16\" height=\"16\">";
		}
		$retorno .= "<input type=\"hidden\" id=\"estrelas\" name=\"$nome_hidden_estrelas\" value=\"$numero_estrelas\">";
	}		
	return $retorno;
}
?>
