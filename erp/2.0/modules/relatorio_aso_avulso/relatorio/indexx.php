<?php 
/*****************************************************************************************************************/
// -> INCLUDES / DEFINES
/*****************************************************************************************************************/
define('_MPDF_PATH', '../../../common/MPDF45/');
define('_IMG_PATH', '../../../images/');
include(_MPDF_PATH.'mpdf.php');
include("../../../common/database/conn.php");
/*****************************************************************************************************************/
// -> VARS
/*****************************************************************************************************************/
$ano = $_GET[ano];
$semana = $_GET[semana];
$numdoc = "".$semana."/".$ano."";
$nomedoc = "".$semana."_".$ano."";
$code        = "";
$header_h    = 140;//header height;
$footer_h    = 170;//footer height;
$meses       = array('', 'Janeiro',  'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$m           = array(" ", "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");
/******************** DADOS **********************/

$sqlentrada = "SELECT * FROM financeiro_relatorio WHERE semana = '$semana' AND ano = '$ano' AND status = 0";
$queryentrada = pg_query($sqlentrada);
$entrada = pg_fetch_all($queryentrada);


$sqlsaida = "SELECT * FROM financeiro_relatorio WHERE semana = '$semana' AND ano = '$ano' AND status = 1";
$querysaida = pg_query($sqlsaida);
$saida = pg_fetch_all($querysaida);




/*****************************************************************************************************************/
// -> BEGIN DOCUMENT
/*****************************************************************************************************************/
ob_start();
    /*************************************************************************************************************/
    // -> HEADER
    /*************************************************************************************************************/
        $cabecalho  = "<table width=100% border=0>";
        $cabecalho .= "<tr>";
        $cabecalho .= '<td align="left">
            <p><strong>
            <font size="7" face="Verdana, Arial, Helvetica, sans-serif">SESMT<sup><font size=3>®</font></sup></font>&nbsp;&nbsp;
			<font size="1" face="Verdana, Arial, Helvetica, sans-serif">SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
			CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></strong>
            </td>';
        $cabecalho .= ' <td width=40% align="right">
            <font face="Verdana, Arial, Helvetica, sans-serif" size="4">
            <b>Resumo do Consumo Semanal</b>
            </td>';
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    /************************************************************************************************************/
    // -> FOOTER
    /************************************************************************************************************/		
        $rodape .= "<table width=100% border=0>";
        $rodape .= "<tr>";
        $rodape .= "<td align=left><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Telefone: +55 (21) 3014 4304   Fax: Ramal 7</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Nextel: +55 (21) 7844 9394 - Id 55*23*31368</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=3 >faleprimeirocomagente@sesmt-rio.com / adm@sesmt-rio.com</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >www.sesmt-rio.com</font></td><td width=130><font face=\"Verdana, Arial, Helvetica, sans-serif\"><b>
     Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
     </td>";
        $rodape .= "</tr>";
        $rodape .= "</table>";
	
	$code .= "<!DOCTYPE HTML>";	
    $code .= "<html>";
    $code .= "<head>";
	$code .= "<meta charset='utf-8'>";
    $code .= '<link href="../style.css" rel="stylesheet" type="text/css"/>';
    $code .= "</head>";
    $code .= "<body style=\"display: inline\">";
/****************************************************************************************************************/
// -> PAGE [2]
/****************************************************************************************************************/

	$code .= '<table width="100%"  border="0" style="border: 1px solid black;" cellspacing="0" bordercolor="#000000"><tr><td width=85% >Relatório Semanal de Entrada de ASO Avulso e Saída de Consumo</td><td width=15%>nº: '.$numdoc;
	$code .='</td></tr></table>';
	
	
	
//**************************************************************************/
//**************************************************************************/		
// -> ENTRADA
//**************************************************************************/		
//**************************************************************************/	
	
	$code .= '  <table width="100%"  border="0" style="border: 1px solid black;" cellspacing="0" bordercolor="#000000">
    <tr>
	  <td align="center" width=8% style="border-bottom: 1px solid black;"><center><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><b>Código</b></font></div></center></td>

	  <td  width=12% style="border-bottom: 1px solid black;"><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><b>Data</b></font></div></td>
	
      <td width=30% style="border-right: 1px solid black;border-bottom: 1px solid black;"><div align="left"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><b>Título</b></font></div></td>
	  
      <td  width=30% style="border-right: 1px solid black;border-bottom: 1px solid black;"><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><b>Histórico</b></font></div></td>
	  
      <td  width=10% style="border-bottom: 1px solid black;"><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><b>Entrada</b></font></div></td>
	  
    </tr>';
	
	for($c=0;$c<pg_num_rows($queryentrada);$c++){
		$totalentrada += $entrada[$c][valor];
		$br_data1 = explode('-',($entrada[$c][data_lancamento]));
		$br_data2 = $br_data1[2].'-'.$br_data1[1].'-'.$br_data1[0];
		$code .= "<tr><td align=center>".$entrada[$c][cod_fatura]."</td><td>".$br_data2."</td><td>".$entrada[$c][titulo]."</td><td>".$entrada[$c][historico]."</td><td>R$ ".number_format($entrada[$c][valor], 2, ',','.')."</td></tr>";
	}
	$code .= "<tr><td colspan='5' align=center><b>Total Entrada: R$ ".number_format($totalentrada, 2, ',','.')."</b></td></tr>";
	$code .= "</table>";
	
	
	
//**************************************************************************/
//**************************************************************************/		
// -> SAÍDA
//**************************************************************************/		
//**************************************************************************/
	
	
	
	$code .= '  <table width="100%"  border="0" style="border: 1px solid black;" cellspacing="0" bordercolor="#000000">
    <tr>
	  <td align="center" width=8% style="border-bottom: 1px solid black;"><center><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><b>Código</b></font></div></center></td>

	  <td  width=12% style="border-bottom: 1px solid black;"><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><b>Data</b></font></div></td>
	
      <td width=30% style="border-right: 1px solid black;border-bottom: 1px solid black;"><div align="left"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><b>Título</b></font></div></td>
	  
      <td  width=30% style="border-right: 1px solid black;border-bottom: 1px solid black;"><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><b>Histórico</b></font></div></td>
	  
      <td  width=10% style="border-bottom: 1px solid black;"><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><b>Saída</b></font></div></td>
	  
    </tr>';
	
	for($c=0;$c<pg_num_rows($querysaida);$c++){
		$totalsaida += $saida[$c][valor];
		$br_data1 = explode('-',($saida[$c][data_lancamento]));
		$br_data2 = $br_data1[2].'-'.$br_data1[1].'-'.$br_data1[0];
		$code .= "<tr><td align=center>".$saida[$c][cod_fatura]."</td><td>".$br_data2."</td><td>".$saida[$c][titulo]."</td><td>".$saida[$c][historico]."</td><td>R$ ".number_format($saida[$c][valor], 2, ',','.')."</td></tr>";
	}
	$code .= "<tr><td colspan='5' align=center><b>Total Saída: R$ ".number_format($totalsaida, 2, ',','.')."</b></td></tr>";
	$code .= "</table>";
	
	
	
	$total = $totalentrada - $totalsaida;
	
	

		$code .= '<table width="100%"  border="0" style="border: 1px solid black;" cellspacing="0" bordercolor="#000000">';
		$code .= "<tr><td align=center><b>Total: R$ ".number_format($total, 2, ',','.')."</b></td></tr>";
		$code .='</table>';
	
	
	$totalgeral = $total - 20;
	
	$code .= "</table>";
	$code .= '<br><table width="100%"  border="0" style="border: 1px solid black;" cellspacing="0" bordercolor="#000000"><tr><td width=85% ><b>Total Final**</b></td><td width=17%><b>R$ '.number_format($totalgeral, 2, ',','.').'</b></td></tr></table><p>';
	
       /* $code .= "<p><table width=100% border=0>";
        $code .= "<tr>";
        $code .= "<td><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=2 >** Os pagamentos desta fatura não isentam o pagamento de ventuais saldos devedores. Para maiores esclarecimentos, ligue para nossa central de atendimento: +55 (21) 3014 4304, ou entre em contato com nosso balcão de atendimento virtual, e-mail: faleprimeirocomagente@sesmt-rio.com.</font></td>";
        $code .= "</tr>";
        $code .= "</table>"; */
		

ob_end_clean();
/*****************************************************************************************************************/
// -> OUTPUT
/*****************************************************************************************************************/
//if(!$_GET[html]){
    //$html = ob_get_clean();
    //$html = utf8_encode($html);
    //$mpdf = new mPDF('pt','A4',3,'',8,8,5,14,9,9,'P');
    //class mPDF ([ string $codepage [, mixed $format [, float $default_font_size [, string $default_font [, float $margin_left , float $margin_right , float $margin_top , float $margin_bottom , float $margin_header , float $margin_footer [, string $orientation ]]]]]])
    $mpdf = new mPDF('pt', 'A4', 12, 'verdana', 8, 8, 0, 0, 0, 0, 'P'); //P: DEFAULT Portrait L: Landscape
    //$mpdf->allow_charset_conversion=true;
    $mpdf->charset_in='iso-8859-1';
    $mpdf->SetDisplayMode('fullpage');
    //$mpdf->SetFooter('{DATE j/m/Y&nbsp; H:i}|{PAGENO}/{nb}|SEDUC / SIGETI');
    $mpdf->SetHTMLHeader($cabecalho);
    $mpdf->SetHTMLFooter($rodape);
    //carregar folha de estilos
    //$stylesheet = file_get_contents('./pcmso.css');
//    $stylesheet = file_get_contents('../style.css');
    //incorporar folha de estilos ao documento
//    $mpdf->WriteHTML($stylesheet,1);
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
	if(!is_dir("relatorio_pdf/$nomedoc")){  
	mkdir("relatorio_pdf/$nomedoc", 0700 );
	}	
    //nome do arquivo de saida PDF
    $arquivo = "REP_".$semana.'_'.$ano.'.pdf';
    //gera o relatorio
	//if(file_exists("repasse_pdf/$cod_clinica/$arquivo")){ 
    //unlink("repasse_pdf/$cod_clinica/$arquivo");
	//$mpdf->Output("repasse_pdf/$cod_clinica/$arquivo",'F');
	//}else{
    $mpdf->Output("relatorio_pdf/$nomedoc/$arquivo",'F');
	//}
	$mpdf->Output("$arquivo",'I');

    /*
    I: send the file inline to the browser. The plug-in is used if available. The name given by filename is used when one selects the "Save as" option on the link generating the PDF.
    D: send to the browser and force a file download with the name given by filename.
    F: save to a local file with the name given by filename (may include a path).
    S: return the document as a string. filename is ignored.
    */
    exit();
//}else{
    echo $code;
//}
mail("suporte@ti-seg.com", "Assunto", "Texto", "suporte@sesmt-rio.com"); 
?>