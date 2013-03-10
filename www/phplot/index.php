<?php
//incluindo a classe phplot
include('phplot-5.0.4/phplot.php');
//Matriz utilizada para gerar os graficos 
$data = array(
  array('Jan', 40), array('Fev', 30), array('Mar', 20),
  array('Abr', 10), array('Mai',  3), array('Jun',  7),
  array('Jul', 10), array('Ago', 15), array('Set', 20),
  array('Out', 18), array('Nov', 16), array('Dez', 14),
);
#Instancia o objeto e setando o tamanho do grafico na tela
$plot = new PHPlot(600,400);
#Tipo de borda, consulte a documentacao para ver opcoes
$plot->SetImageBorderType('plain');
#Tipo de grafico, nesse caso barras, existem diversos(pizza...)
//bars, stackedbars, lines, linepoints, area, points, pie, thinbarline, squared, stackedarea',
$plot->SetPlotType('lines');
#Tipo de dados, nesse caso texto que esta no array
$plot->SetDataType('text-data');
#Setando os valores com os dados do array
$plot->SetDataValues($data);
#Titulo do grafico
$plot->SetTitle('Cadastro de usuários no Site');
# Legenda, nesse caso serao tres pq o array possui 3 valores que serao apresentados
$plot->SetLegend(array('Estudantes'));
# Metodos utilizados para marcar labes, necessario mas nao se aplica neste ex. (manual) :
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');
#Gera o grafico na tela
$plot->DrawGraph();
?>
