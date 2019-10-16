<?php 
/*****************************************************************************************************************/
// -> INCLUDES / DEFINES
/*****************************************************************************************************************/
define('_MPDF_PATH', '../../common/MPDF45/');
define('_IMG_PATH', '../../images/');
include(_MPDF_PATH.'mpdf.php');
//include("file:///C|/Users/common/database/conn.php");
/*****************************************************************************************************************/
// -> VARS
/*****************************************************************************************************************/
$header_h    = 140;//header height;
$footer_h    = 170;//footer height;
/******************** DADOS **********************/


/*****************************************************************************************************************/
// -> BEGIN DOCUMENT
/*****************************************************************************************************************/
ob_start();
    /*************************************************************************************************************/
    // -> HEADER
    /*************************************************************************************************************/
        $cabecalho  = "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
        $cabecalho .= "<tr>";
        $cabecalho .= "<td valign=top align=left height=$header_h valign=top width=270><img src='"._IMG_PATH."logo_novo_sesmt.png' width='800' height='135'></td>";
		$cabecalho .= "</tr>";
		$cabecalho .= "</table>";
		$cabecalho .= "<div align=center><b>Médico Coordenador do PCMSO:<br>Maria de Lourdes Fernandes Magalhães<br>CREMERJ 52.33.471-0 Reg. MTE 13.320</b></div>";
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
       
    /************************************************************************************************************/
    // -> FOOTER
    /************************************************************************************************************/		
        $rodape  = "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$footer_h>";
        $rodape .= "<tr>";
        $rodape .= "<td valign=top align=left height=$footer_h valign=bottom class='medText'>Telefone: +55 (21) 3014 4304      Fax: Ramal 7<br>Nextel: +55 (21) 97003 1385 / Id 55*23*31641 <br>medicotrab@sesmt-rio.com/www.sesmt-rio.com</td>";
        $rodape .= "<td valign=top align=right height=$footer_h width=207 valign=bottom><img src='"._IMG_PATH."logo_novo_sesmt2.png' width=207 height=135></td>";
        $rodape .= "</tr>";
        $rodape .= "</table>";
	
	/****************************************************************************************************************/
	// -> BODY
	/****************************************************************************************************************/
	
		
    $code = "<html>";
    $code .= "<head>";
	$code .= "<html>";
    $code .= "<head>";
    $code .= '<link href="../style.css" rel="stylesheet" type="text/css"/>';
    $code .= "</head>";
    $code .= "<body style=\"display: inline\">";
	$code .= "</body>";
	$code .= "</html>";	

ob_end_clean();
/*****************************************************************************************************************/
// -> OUTPUT
/*****************************************************************************************************************/


    $mpdf = new mPDF('pt', 'A4', 12, 'verdana', 8, 8, 0, 0, 0, 0, 'P');
	
    $mpdf->charset_in='iso-8859-1';
    $mpdf->SetDisplayMode('fullpage');
	
    $mpdf->SetHTMLHeader($cabecalho);
    $mpdf->SetHTMLFooter($rodape);
	
    $mpdf->WriteHTML($code);
	
	//if(!is_dir("repasse_pdf/$cod_clinica")){  
	//mkdir("repasse_pdf/$cod_clinica", 0700 );
	//}
	
   // $arquivo = "REP_".$mes.'_'.$ano.'.pdf';
    
    //$mpdf->Output("repasse_pdf/$cod_clinica/$arquivo",'F');
	
	//$mpdf->Output("$arquivo",'I');

   
    exit();
	
    echo $code;

mail("suporte@ti-seg.com", "Assunto", "Texto", "suporte@sesmt-rio.com"); 
?> 