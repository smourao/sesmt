<?php
/*****************************************************************************************************************/
// -> INCLUDES / DEFINES
/*****************************************************************************************************************/
include('../../common/MPDF45/mpdf.php');
include("../../common/includes/database.php");

$meses = array("", "janeiro", "Fevereiro", "Mar�o", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

/*****************************************************************************************************************/
// -> BEGIN DOCUMENT
/*****************************************************************************************************************/
ob_start();

$code = "";
$code .= "<table align='center' border='0'>";
$code .= "<tr>";
$code .= "<td align='center' class='fontebranca22bold'><p><br>PROTOCOLO DE ENTREGA DO PPP</td>";
$code .= "</tr>";
$code .= "</table><br />";

$code .= "<center><div style=\"width:500px; margin:0 auto;\"><p align=justify>";
$code .= "Raz�o Social: <b>{$_POST['razao_social']}</b>, ";
$code .= "Cep: <b>{$_POST['cep']}</b>, Endere�o: <b>{$_POST['endereco']}, {$_POST['numero']}</b>, ";
$code .= "Bairro: <b>{$_POST['bairro']}</b>, ";
$code .= "CNPJ: <b>{$_POST['cnpj']}</b>, C.N.A.E: <b>{$_POST['cnae']}</b>.<br>";
$code .= "<p align=justify>";

$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;De acordo com o cumprimento de uma determina��o da previd�ncia social, ";
$code .= "foi entregue ao funcion�rio <b>{$_POST['funcionario']}</b>, ";
$code .= "CTPS: <b>{$_POST['ctps']}</b>, S�rie: <b>{$_POST['serie']}</b>, C.B.O: <b>{$_POST['cbo']}</b>.";
$code .= "<p align=justify>";

$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Uma via do PPP - Perfil Profissiogr�fico Previdenci�rio, conforme IN - Institui��o Normativa ";
$code .= "INSS/DC N� 99/2003, devidamente protocolada e arquivada uma c�pia deste protocolo em arquivo f�sico do departamento desta empresa.";
$code .= "<br>";
$code .= "<p align=center>";
$code .= "Rio de Janeiro, ".date("d")." de ".$meses[date("n")]." de ".date("Y")."<br><p><br><P align=center>";

$code .= "_____________________________________<br>";
$code .= "<b> {$_POST['funcionario']}</b>";
$code .= "";
$code .= "</div></center>";

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

// incorpora o corpo ao PDF na posi��o 2 e dever� ser interpretado como footage. Todo footage � posicao 2 ou 0(padr�o).
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