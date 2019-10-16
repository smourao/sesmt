<?PHP
/*****************************************************************************************************************/
// -> INCLUDES / DEFINES
/*****************************************************************************************************************/
define('_MPDF_PATH', '../../../../common/MPDF45/');
define('_IMG_PATH', '../../../../images/');
include(_MPDF_PATH.'mpdf.php');
include("../../../../common/database/conn.php");
//define('_IMG_PATH_', '../../../../images/relatorios/');
/*****************************************************************************************************************/
// -> VARS
/*****************************************************************************************************************/
//$cod_cgrt = (int)(base64_decode($_GET[cod_cgrt]));
$code     = "";
$header_h = 175;//header height;
$footer_h = 350;//footer height;
$meses    = array('', 'Janeiro',  'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$m        = array(" ", "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");
/*****************************************************************************************************************/
// -> CGRT / CLIENTE INFO
/*****************************************************************************************************************/
$sql = "SELECT * FROM cliente WHERE cliente_id = {$_GET[cod_cliente]}";
$rci = pg_query($sql);
$info = pg_fetch_all($rci);

/*****************************************************************************************************************/
// -> BEGIN DOCUMENT
/*****************************************************************************************************************/
ob_start();
    /*************************************************************************************************************/
    // -> HEADER
    /*************************************************************************************************************/
    /*if($_GET[sem_timbre]){
        $cabecalho  = "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
        $cabecalho .= "<tr>";
        $cabecalho .= "<td align=left height=$header_h>&nbsp; </td>";
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }else{
        $cabecalho  = "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
        $cabecalho .= "<tr>";
        $cabecalho .= "<td align=left height=$header_h valign=top width=270><img src='"._IMG_PATH."logo_sesmt.png' width='270' height='135'></td>";
        $cabecalho .= "<td align=center height=$header_h valign=top class='medText'>Serviços Especializados de Segurança e<br>Monitoramento de Atividades no Trabalho<p>Assistência em Segurança e Higiene no Trabalho</td>";
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }*/
    /************************************************************************************************************/
    // -> FOOTER
    /************************************************************************************************************/
    //assinatura
    /*if($_GET[sem_assinatura])
        $rodape  = "";
    else
        $rodape  = "<div style=\"position: relative; text-align: right; width: 100%\"><img src='"._IMG_PATH."ass_medica.png' border=0 width='180' height='110'></div>";

    if($_GET[sem_timbre]){
        $rodape .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$footer_h>";
        $rodape .= "<tr>";
		$rodape .= "<td align=left height=$footer_h valign=bottom class='medText'>Telefone: +55 (21) 3014 4304      Fax: Ramal 7<br>Nextel: +55 (21) 7844 6095 / Id 55*23*31641<br>medicotrab@sesmt-rio.com<br>www.sesmt-rio.com / www.shoppingsesmt.com</td>";
        $rodape .= "<td align=left height=$footer_h>&nbsp; </td>";
        $rodape .= "</tr>";
        $rodape .= "</table>";
    }else{
        $rodape .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$footer_h>";
        $rodape .= "<tr>";
        $rodape .= "<td align=left height=$footer_h valign=bottom class='medText'>Telefone: +55 (21) 3014 4304      Fax: Ramal 7<br>Nextel: +55 (21) 7844 6095 / Id 55*23*31641<br>medicotrab@sesmt-rio.com<br>www.sesmt-rio.com / www.shoppingsesmt.com</td>";
        $rodape .= "<td align=right height=$footer_h width=207 valign=bottom><img src='"._IMG_PATH."logo_sesmt2.png' width=207 height=135></td>";
        $rodape .= "</tr>";
        $rodape .= "</table>";
    }
    if($_GET[html]){
        $code .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
    }*/
    $code .= "<html>";
    $code .= "<head>";
    $code .= '<link href="../style.css" rel="stylesheet" type="text/css"/>';
    $code .= "</head>";
    $code .= "<body style=\"display: inline\">";

/****************************************************************************************************************/
// -> PAGE [1]
/****************************************************************************************************************/
	for($x=0;$x<pg_num_rows($rci);$x++){
	$tmp = explode("/", $info[$x][ano_contrato]);
	
	$code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
	$code .= "<tr>";
    $code .= "<td align=center colspan=2><div class='bigTitle'><b>CERTIFICADO</b></div></td>";
    $code .= "</tr><tr>";
    $code .= "<td align=center colspan=2><div class='mainTitle'><b>CONTRATO: ".str_pad($tmp[1], 4, "0", 0)."</b></div></td>";
    $code .= "</tr><tr>";
    $code .= "<td align=justify colspan=2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Certificamos que a empresa <b>".ltrim(rtrim($info[$x][razao_social]))."</b>, sob <b>CNPJ:</b> <b>".$info[$x][cnpj]."</b>, está cumprindo a legislação 6.514/77, conforme sua Port. 3.214/78 e suas Nrs 7 e 9. Mantendo os Programas e Relatórios atualizados, em arquivo físico a disposição das autoridades por manter contrato com a empresa SESMT - Serviços Especializados de Segurança e Monitoramento de Atividades no Trabalho Ltda, sob o CNPJ 04.722.248/0001-17.</td>";
    $code .= "</tr><tr>";
	$code .= "<td align=center valign=bottom width=50%><img src='"._IMG_PATH."ass_pedro3.png' width=215 height=90></td><td align=right ></td>";
	$code .= "</tr><tr>";
	$code .= "<td align=center width=50%>_______________________________________________</td><td align=center>_______________________________________________</td>";
	$code .= "</tr><tr>";
	$code .= "<td align=center width=50%>SESMT - Serviços Especializados de Segurança e Monitoramento de Atividades no Trabalho Ltda</td><td align=center>{$info[$x][razao_social]}</td>";
	$code .= "</tr><tr>";
	$code .= "<td align=center width=50%>CNPJ: 04.722.348/0001-17</td><td align=center>CNPJ: {$info[$x][cnpj]}</td>";
	$code .= "</tr>";
    $code .= "</table>";
	}
    //$code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [2]
/****************************************************************************************************************/

ob_end_clean();

/*****************************************************************************************************************/
// -> OUTPUT
/*****************************************************************************************************************/
if(!$_GET[html]){
    //$html = ob_get_clean();
    //$html = utf8_encode($html);
    //$mpdf = new mPDF('pt','A4',3,'',8,8,5,14,9,9,'P');
    //class mPDF ([ string $codepage [, mixed $format [, float $default_font_size [, string $default_font [, float $margin_left , float $margin_right , float $margin_top , float $margin_bottom , float $margin_header , float $margin_footer [, string $orientation ]]]]]])
    $mpdf = new mPDF('pt', 'Letter', 12, 'verdana', 8, 8, 0, 0, 0, 0, 'L'); //P: DEFAULT Portrait L: Landscape
    //$mpdf = new mPDF('', 'Letter', 0, 'verdana', 8, 8, 0, 0, 0, 0); //P: DEFAULT Portrait L: Landscape
	//$mpdf->allow_charset_conversion=true;
    $mpdf->charset_in='iso-8859-1';
    $mpdf->SetDisplayMode('fullpage');
    //$mpdf->SetFooter('{DATE j/m/Y&nbsp; H:i}|{PAGENO}/{nb}|SEDUC / SIGETI');
    $mpdf->SetHTMLHeader($cabecalho);
    $mpdf->SetHTMLFooter($rodape);
    //carregar folha de estilos
    //$stylesheet = file_get_contents('./pcmso.css');
    $stylesheet = file_get_contents('../style.css');
    //incorporar folha de estilos ao documento
    $mpdf->WriteHTML($stylesheet,1);
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
}else{
    echo $code;
}
?>