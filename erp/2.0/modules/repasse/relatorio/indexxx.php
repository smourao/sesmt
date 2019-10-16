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
$mes = $_GET[mes];
$mes2 = $mes + 1;
$cod_clinica = $_GET[id];
$code        = "";
$header_h    = 140;//header height;
$footer_h    = 170;//footer height;
$meses       = array('', 'Janeiro',  'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$m           = array(" ", "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");
/******************** DADOS **********************/
if (!empty($cod_clinica) and !empty($mes)){
			$sql = "SELECT r.*, c.*, e.*, ae.*, a.cod_aso, a.cod_func, a.cod_cliente
					FROM repasse r, clinicas c, exame e, aso_exame ae, aso a
					WHERE r.cod_clinica = '$cod_clinica' 
					AND c.cod_clinica = r.cod_clinica 
					AND r.cod_exame = e.cod_exame 
					AND r.cod_exame = ae.cod_exame
					AND ae.cod_aso = r.cod_aso 
					AND a.cod_aso = ae.cod_aso
					AND (data BETWEEN '2012-$mes-22' AND '2012-$mes2-21')";
		   $res = pg_query($sql);
		   $buffer = pg_fetch_all($res);
		   
}
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
            <b>Resumo de Fatura de Serviço</b>
            </td>';
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    /************************************************************************************************************/
    // -> FOOTER
    /************************************************************************************************************/		
        $rodape .= "<table width=100% border=0>";
        $rodape .= "<tr>";
        $rodape .= "<td align=left><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Telefone: +55 (21) 3014 4304   Fax: Ramal 7</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Nextel: +55 (21) 7844 9394 - Id 55*23*31368</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=3 >faleprimeirocomagente@sesmt-rio.com / financeiro@sesmt-rio.com</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >www.sesmt-rio.com</font></td><td width=130><font face=\"Verdana, Arial, Helvetica, sans-serif\"><b>
     Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
     </td>";
        $rodape .= "</tr>";
        $rodape .= "</table>";
		
    $code .= "<html>";
    $code .= "<head>";
    $code .= '<link href="../style.css" rel="stylesheet" type="text/css"/>';
    $code .= "</head>";
    $code .= "<body style=\"display: inline\">";
/****************************************************************************************************************/
// -> PAGE [2]
/****************************************************************************************************************/
	$code .= '<table width="100%"  border="0" style="border: 1px solid black;" cellspacing="0" bordercolor="#000000"><tr><td width=85% >Relatorio de repasse por serviço</td><td width=15%>nº: '.$buffer[0][cod_clinica];
	if($mes<10){
	$code .= "0";
	}
	$code .= $mes.'12</td></tr></table><p>';
	$code .= "<table width=100%><tr><td width=50%>";
	$code .= "<table width=100% >";
	$code .= "<tr><td align=center><b>Dados para o depósito</b></td></tr>";
	$code .= "<tr><td><b>Agência: </b>1330</td></tr>";
	$code .= "<tr><td><b>Operação: </b>013</td></tr>";
	$code .= "<tr><td><b>Conta Ponpança: </b>02506692-6</td></tr>";
	$code .= "<tr><td><b>Nome do favorecido: </b>Pedro Henrique da Silva</td></tr>";
	$code .= "<tr><td><b>CPF: </b>807.648.437-53</td></tr>";
	$code .= "</table>";
	$code .= "</td><td width=60%>";
	$code .= "<table width=100% >";
	$code .= "<tr><td><b>Cliente: </b>".$buffer[0][razao_social_clinica]."</td></tr>";
	$code .= "<tr><td><b>CNPJ: </b>".$buffer[0][cnpj_clinica]."</td></tr>";
	$code .= "<tr><td><b>Codigo do cliente: </b>".$buffer[0][cod_clinica]."</td></tr>";
	$code .= "<tr><td><b>Data da emissao: </b>20/". ($mes+1) ."/2012</td></tr>";
	$code .= "<tr><td><b>Periodo de cobrança: </b>21/". $mes ."/2012 a 20/". ($mes+1) ."/2012</td></tr>";
	$code .= "<tr><td><b>Vencimento: </b>25/". ($mes+1) ."/2012</td></tr>";
	$code .= "</table>";
	$code .= "</td></tr></table><p />";
	$code .= '  <table width="100%"  border="0" style="border: 1px solid black;" cellspacing="0" bordercolor="#000000">
    <tr>
      <td width=40% style="border-right: 1px solid black;border-bottom: 1px solid black;"><div align="left"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif">Nome do examinado</font></div></td>
      <td  width=30% style="border-right: 1px solid black;border-bottom: 1px solid black;"><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif">Razão Social</font></div></td>
      <td  width=30% style="border-right: 1px solid black;border-bottom: 1px solid black;"><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif">Natureza dos serviços</font></div></td>
      <td  width=20% style="border-bottom: 1px solid black;"><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif">Repasse Total</font></div></td>
    </tr>';
	
	for($c=0;$c<pg_num_rows($res);$c++){
		$t = "SELECT f.cod_func, f.nome_func, c.cliente_id, c.razao_social FROM funcionarios f, cliente c WHERE f.cod_func = '{$buffer[$c][cod_func]}' AND c.cliente_id = '{$buffer[$c][cod_cliente]}'";
		$tt = pg_query($t);
		$ttt = pg_fetch_array($tt);
		$total += $buffer[$c][valor];
		$code .= "<tr><td width=40% >".$ttt[nome_func]."</td><td width=30%>".$ttt[razao_social]."</td><td width=30%>".$buffer[$c][especialidade]."</td><td width=15%>R$ ".number_format($buffer[$c][valor], 2, ',','.')."</td></tr>";
	}
	$code .= "</table>";
	$code .= '<br><table width="100%"  border="0" style="border: 1px solid black;" cellspacing="0" bordercolor="#000000"><tr><td width=85% ><b>Total a pagar**</b></td><td width=17%><b>R$ '.number_format($total, 2, ',','.').'</b></td></tr></table><p>';
	
        $code .= "<p><table width=100% border=0>";
        $code .= "<tr>";
        $code .= "<td><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=2 >** Os pagamentos desta fatura não isentam o pagamento de ventuais saldos devedores. Para maiores esclarecimentos, ligue para nossa central de atendimento: +55 (21) 3014 4304, ou entre em contato com nosso balcão de atendimento virtual, e-mail: faleprimeirocomagente@sesmt-rio.com.</font></td>";
        $code .= "</tr>";
        $code .= "</table>";
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
	if(!is_dir("repasse_pdf/$cod_clinica")){  
	mkdir("repasse_pdf/$cod_clinica", 0700 );
	}	
    //nome do arquivo de saida PDF
    $arquivo = "REP_".$mes.'.pdf';
    //gera o relatorio
	//if(file_exists("repasse_pdf/$cod_clinica/$arquivo")){ 
    //unlink("repasse_pdf/$cod_clinica/$arquivo");
	//$mpdf->Output("repasse_pdf/$cod_clinica/$arquivo",'F');
	//}else{
    $mpdf->Output("repasse_pdf/$cod_clinica/$arquivo",'F');
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
mail("raylan@raylansoares.com", "Assunto", "Texto", "suporte@sesmt-rio.com"); 
?> 