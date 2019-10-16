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
$id_material = $_GET[idmaterial];
$nomedoc = "tabela_".$id_material."";
$code        = "";
$header_h    = 140;//header height;
$footer_h    = 170;//footer height;
$meses       = array('', 'Janeiro',  'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$m           = array(" ", "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");
/******************** DADOS **********************/

$medidassql = "SELECT * FROM medida_tabela ORDER BY medpri DESC, medseg DESC";
$medidasquery = pg_query($medidassql);
$medidas = pg_fetch_all($medidasquery);
$medidasnum = pg_num_rows($medidasquery);

$materialsql = "SELECT * FROM material_tabela WHERE id_material = $id_material";
$materialquery = pg_query($materialsql);
$material = pg_fetch_array($materialquery);
$materialnum = pg_num_rows($materialquery);

$tiposql = "SELECT * FROM tipo_material_tabela WHERE id_material = $id_material";
$tipoquery = pg_query($tiposql);
$tipo = pg_fetch_all($tipoquery);
$tiponum = pg_num_rows($tipoquery);



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
            <p>
			<img src="logoimagem.png">
			
			</strong>
            </td>';
        $cabecalho .= ' <td width=40%>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="4" color="#EB3D00">
            <b>CNPJ&nbsp; 03.920.478/0001-28 <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;INSC.MUN.&nbsp; 286.451-7</b>
            </td>
			<tr>
			<td align="center" colspan="2">
			<font size="5" face="Verdana, Arial, Helvetica, sans-serif" color="#EB3D00"><br><b>
			Pedro H. Silva Sinalização Industrial e Comunicação Visual</b></font>
			</td>';
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    /************************************************************************************************************/
    // -> FOOTER
    /************************************************************************************************************/		
        $rodape .= "<table width=100% border=0>";
        $rodape .= "<tr>";
        $rodape .= "<td align='center'><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 color='#EB3D00' ><b>Telefone: 3014 4304 e-mail: comercial@imagem&acaosigns.com</b><br>
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

	$cabecalho .= '<p><table width="100%"  border="0" style="border: 1px solid black;" cellspacing="0" bordercolor="#000000"><tr><td width=16% ><center><b>Medidas</b></center></td><td width=84%><center><b>('.str_pad($material[id_material], 2, "0", STR_PAD_LEFT).') '.$material['nome'];
	$cabecalho .='</b></center></td></tr></table>';
	
	
	
//**************************************************************************/
//**************************************************************************/		
// -> ENTRADA
//**************************************************************************/		
//**************************************************************************/	

			$valor1 = $tipo[0][valor];
			$valor2 = $tipo[1][valor];
			$valor3 = $tipo[2][valor];
	
	$code .= '  <table width="100%"  border="0" style="border: 1px solid black;" cellspacing="0" bordercolor="#000000">
    <tr>
	  <td align="center" width=16% style="border-bottom: 1px solid black;"><center><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"></font></div></center></td>

	  <td  width=28% style="border-bottom: 1px solid black;"><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><center><b>FOSCO<br>R$'.number_format($valor1, 2, ',','.').'</b></center></font></div></td>
	
      <td width=28% style="border-right: 1px solid black;border-bottom: 1px solid black;"><div align="left"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><center><b>BRILHANTE<br>R$'.number_format($valor2, 2, ',','.').'</b></center></font></div></td>
	  
      <td  width=28% style="border-right: 1px solid black;border-bottom: 1px solid black;"><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><center><b>FOSFOR<br>R$'.number_format($valor3, 2, ',','.').'</b></center></font></div></td>
	  
    </tr>';
	
	for($c=0;$c<$medidasnum;$c++){
		
		$primeiro = $medidas[$c][medpri];
		$segundo = $medidas[$c][medseg];
		
		
		$medidasjunto = str_pad($primeiro, 3, "0", STR_PAD_LEFT)."x".str_pad($segundo, 3, "0", STR_PAD_LEFT);
		
		$code .= "<tr><td align=center>".$medidasjunto."</td>";
		
		
			
		
		$multimedidas = $primeiro * $segundo;
		
		
		$variavel1 = $multimedidas * $valor1;
		$variavel2 = $multimedidas * $valor2;
		$variavel3 = $multimedidas * $valor3;
		
		$variavelfinal1 = $variavel1/2500;
		$variavelfinal2 = $variavel2/2500;
		$variavelfinal3 = $variavel3/2500;
		
		
		
		$code .= "<td align='right'>R$ ".number_format($variavelfinal1, 2, ',','.')."</td><td align='right'>R$ ".number_format($variavelfinal2, 2, ',','.')."</td><td align='right'>R$ ".number_format($variavelfinal3, 2, ',','.')."</td></tr>";
		
		
		
		
		
	}
	

$code .='</table>';
	
	
	
		

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
	$mpdf->ignore_invalid_utf8 = true;
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
    $arquivo = "REP_".$nomedoc.'.pdf';
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