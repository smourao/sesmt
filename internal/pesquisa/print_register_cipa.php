<?php
session_start();
print_r($_POST);
/*****************************************************************************************************************/
// -> INCLUDES / DEFINES
/*****************************************************************************************************************/
include('../../common/MPDF45/mpdf.php');
include("../../common/includes/database.php");

/*****************************************************************************************************************/
// -> BEGIN DOCUMENT
/*****************************************************************************************************************/
ob_start();

// INSERE INFORMAÇÕES NA TABELA
if($_POST['imprimir'] ){
	for($x=0;$x<count($_POST[titular]);$x++){

	$djan = $_POST[djan];//explode("/", $_POST[djan]);
	$hjan = explode(":", $_POST[hjan]);
	
	$dfev = $_POST[dfev];
	$hfev = explode(":", $_POST[hfev]);
	
	$dmar = $_POST[dmar];
	$hmar = explode(":", $_POST[hmar]);
	
	$dabr = $_POST[dabr];
	$habr = explode(":", $_POST[habr]);
	
	$dmai = $_POST[dmai];
	$hmai = explode(":", $_POST[hmai]);
	
	$djun = $_POST[djun];
	$hjun = explode(":", $_POST[hjun]);
	
	$djul = $_POST[djul];
	$hjul = explode(":", $_POST[hjul]);
	
	$dago = $_POST[dago];
	$hago = explode(":", $_POST[hago]);
	
	$dset = $_POST[dset];
	$hset = explode(":", $_POST[hset]);
	
	$dout = $_POST[dout];
	$hout = explode(":", $_POST[hout]);
	
	$dnov = $_POST[dnov];
	$hnov = explode(":", $_POST[hnov]);
	
	$ddez = $_POST[ddez];
	$hdez = explode(":", $_POST[hdez]);
	
	if($_POST[data]){
		$tmp = explode("/", $_POST[data]);
		$data = $tmp[2]."/".$tmp[1]."/".$tmp[0];
	}

	$inclui = "INSERT INTO ata_posse(cod_cliente, data, hora, gerente, secretario, presidente, titular, suplente, presidente_vice, titular_vice, suplente_vice, secre, janeiro, fevereiro, marco, abril, maio, junho, julho, agosto, setembro, outubro, novembro, dezembro)
			  VALUE(".$_SESSION['cod_cliente'].", $data, $_POST[hora], $_POST[gerente], $_POST[secretario], $_POST[presidente], {$_POST[titular][$x]}, $_POST[suplente], $_POST[presidente_vice], $_POST[titular_vice], $_POST[suplente_vice], $_POST[secre], 
				".date("c", mktime($hjan[0],$hjan[1],0,1,$djan,date("Y")+1)).", ".date("c", mktime($hfev[0],$hfev[1],0,2,$dfev,date("Y")+1)).", ".date("c", mktime($hmar[0],$hmar[1],0,3,$dmar,date("Y")+1)).", 
				".date("c", mktime($habr[0],$habr[1],0,4,$dabr,date("Y")+1)).", ".date("c", mktime($hmai[0],$hmai[1],0,5,$dmai,date("Y")+1)).", ".date("c", mktime($hjun[0],$hjun[1],0,6,$djun,date("Y")+1)).", 
				".date("c", mktime($hjul[0],$hjul[1],0,7,$djul,date("Y")+1)).", ".date("c", mktime($hago[0],$hago[1],0,8,$dago,date("Y")+1)).", ".date("c", mktime($hset[0],$hset[1],0,9,$dset,date("Y")+1)).", 
				".date("c", mktime($hout[0],$hout[1],0,10,$dout,date("Y")+1)).", ".date("c", mktime($hnov[0],$hnov[1],0,11,$dnov,date("Y")+1)).", ".date("c", mktime($hdez[0],$hdez[1],0,12,$ddez,date("Y")+1))." )";
	$inc = pg_query($inclui);
	}
}
/********************************************************************/

$code = "";
//$code.= ">>".$inclui;
$code .= "<p>";
$code .= "<center><div style=\"width:500px; margin:0 auto;\"><p align=justify>";
$code .= "<b>Ilmo Sr.<br>";
$code .= "Delegado Regional do Trabalho</b><p><p><p align=justify>";
$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$code .= "Solicitação de registro da CIPA - Comissão Interna de Prevenção a Acidentes da Empresa <b>{$_POST['razao_social']}</b>, CNAE <B>{$_POST['cnae']}</B>, grau de risco <b>{$_POST['grau']}</b>, situada à <b>{$_POST['endereco']}, {$_POST['numero']}</b>, Bairro <b>{$_POST['bairro']}</b>, inscrita no CNPJ <b>{$_POST['cnpj']}</b>, em conformidade com o Art 163 da CLT e com a NR 5, portaria 3.214/78.";

$code .= "<p align=center>";
$code .= "Vem requerer respeitosamente o registro junto a este órgão.";

$code .= "<p><p><p align=center>";

$code .= "<b>Carimbo do CNPJ e assinatura</b>";

$code .= "</div></center>";

ob_end_clean();

echo $code;

/*****************************************************************************************************************/
// -> OUTPUT
/*****************************************************************************************************************/
/*
$mpdf = new mPDF('pt', 'A4', 12, 'verdana', 8, 8, 0, 0, 0, 0, 'P'); //P: DEFAULT Portrait L: Landscape
$mpdf->charset_in='iso-8859-1';
$mpdf->SetDisplayMode('fullpage');
$mpdf->SetHTMLHeader($cabecalho);
$mpdf->SetHTMLFooter($rodape);
*/
//carregar folha de estilos
//$stylesheet = file_get_contents('./pcmso.css');
//incorporar folha de estilos ao documento
//$mpdf->WriteHTML($stylesheet,1);

// incorpora o corpo ao PDF na posição 2 e deverá ser interpretado como footage. Todo footage é posicao 2 ou 0(padrão).
//$mpdf->WriteHTML($code);
//void WriteHTML ( string $html [, int $mode [, boolean $initialise  [, boolean $close ]]])
//MODE Values
//0 - Parses a whole html document
//1 - Parses the html as styles and stylesheets only
//2 - Parses the html as output elements only
//3 - (For internal use only - parses the html code without writing to document)
//4 - (For internal use only - writes the html code to a buffer)
//DEFAULT: 0

//nome do arquivo de saida PDF
//$arquivo = $cod_cgrt.'_'.date("ymdhis").'.pdf';

//gera o relatorio
/*
if($_GET[out] == 'D'){
    $mpdf->Output($arquivo,'D');
}else{
    $mpdf->Output($arquivo,'I');
}*/
/*
I: send the file inline to the browser. The plug-in is used if available. The name given by filename is used when one selects the "Save as" option on the link generating the PDF.
D: send to the browser and force a file download with the name given by filename.
F: save to a local file with the name given by filename (may include a path).
S: return the document as a string. filename is ignored.
*/
//exit();
?>