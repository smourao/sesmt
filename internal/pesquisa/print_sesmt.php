<?php
session_start();
/*****************************************************************************************************************/
// -> INCLUDES / DEFINES
/*****************************************************************************************************************/
include('../../common/MPDF45/mpdf.php');
include("../../common/includes/database.php");

$rr = unserialize(urldecode($_POST['tec']));
$sql = "SELECT c.*, cn.*
		FROM cliente c, cnae cn
		WHERE c.cliente_id = {$_SESSION[cod_cliente]}
		AND cn.cnae_id = c.cnae_id";
$result = pg_query($sql);
$row = pg_fetch_array($result);

/*****************************************************************************************************************/
// -> BEGIN DOCUMENT
/*****************************************************************************************************************/
ob_start();

$code = "";
//$code .= "<form name=\"form1\" id=\"form1\" method=\"post\" >";
$code .= "Ao<br>";
$code .= "Ilmo. Ilustríssimo: Delegado Regional do Trabalho<p align=justify>";		
$code .= "De: {$row[razao_social]}<br>";
$code .= "Sob CNPJ nº {$row[cnpj]}<br>";
$code .= "Situada à: {$row[endereco]}, {$row[num_end]} - Bairro: {$row[bairro]}<br>";
$code .= "Estado: {$row[estado]} – Cep {$row[cep]}<br>";
$code .= "C.N.A.E: {$row[cnae]} - Grau de Risco: {$row[grau_de_risco]}<br>";
$code .= "<p>";

$code .= "<b>Solicitação faz: </b><p align=justify>";
$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$code .= "Venho respeitosamente solicitar a este órgão, registro do SESMT – Serviço Especializado de Segurança e Medicina do Trabalho.<p align=justify>";
if($_POST != ""){ 
	for($x=0;$x<count($_POST['tecnico']);$x++){
	$code .= "{$rr[$x]}<p>";
		$code .= "Nome do Profissional:&nbsp;<b>{$_POST['tecnico'][$x]}</b><br> ";
		$code .= "Habilitação do Profissional:&nbsp;<b>{$_POST['habilitacao'][$x]}</b><br> ";
		$code .= "Regime de Horário do Profissional:&nbsp;<b>{$_POST['horario'][$x]}</b><p>";
	}
}
$code .= "<p align=justify>";

$code .= "A <b>{$row[razao_social]}</b>, declara manter em seu quadro funcional o efetivo populacional de <b>{$row[numero_funcionarios]}</b> colaboradores.";
				
//$code .= "</form>";

ob_end_clean();

/*****************************************************************************************************************/
// -> OUTPUT
/*****************************************************************************************************************/

$mpdf = new mPDF('pt', 'A4', 12, 'verdana', 8, 8, 0, 0, 0, 0, 'P'); //P: DEFAULT Portrait L: Landscape
$mpdf->charset_in='iso-8859-1';
$mpdf->SetDisplayMode('fullpage');
$mpdf->SetHTMLHeader($cabecalho);
$mpdf->SetHTMLFooter($rodape);

//carregar folha de estilos
//$stylesheet = file_get_contents('./pcmso.css');
//incorporar folha de estilos ao documento
//$mpdf->WriteHTML($stylesheet,1);

// incorpora o corpo ao PDF na posição 2 e deverá ser interpretado como footage. Todo footage é posicao 2 ou 0(padrão).
$mpdf->WriteHTML($code);
//void WriteHTML ( string $html [, int $mode [, boolean $initialise  [, boolean $close ]]])
//MODE Values
//0 - Parses a whole html document
//1 - Parses the html as styles and stylesheets only
//2 - Parses the html as output elements only
//3 - (For internal use only - parses the html code without writing to document)
//4 - (For internal use only - writes the html code to a buffer)
//DEFAULT: 0

//nome do arquivo de saida PDF
$arquivo = $cod_cgrt.'_'.date("ymdhis").'.pdf';

//gera o relatorio
if($_GET[out] == 'D'){
    $mpdf->Output($arquivo,'D');
}else{
    $mpdf->Output($arquivo,'I');
}
/*
I: send the file inline to the browser. The plug-in is used if available. The name given by filename is used when one selects the "Save as" option on the link generating the PDF.
D: send to the browser and force a file download with the name given by filename.
F: save to a local file with the name given by filename (may include a path).
S: return the document as a string. filename is ignored.
*/
exit();
?>