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
$mes1 = $_GET[mes];




if($mes1 == 1 || $mes1 == 3 || $mes1 == 5 || $mes1 == 7 || $mes1 == 8 || $mes1 == 10 || $mes1 == 12){
			
			$dia1 = 31;
			
			
		}elseif($mes1 == 2){
			
			$bisexto = $ano;
			if ((($bisexto % 4) == 0 and ($bisexto % 100)!=0) or ($bisexto % 400)==0){
				
				$dia1 = 29;
				
			}else{
			
				$dia1 = 28;
				
			}
		}else{
		
			$dia1 = 30;	
			
		}









$mes2 = $mes1 + 1;
if($mes2 == 13) $mes2 = 1 ;
$ano2 = $ano;
if($mes2 == 1) $ano2 = $ano+1;
$cod_clinica = $_GET[id];
$code        = "";
$header_h    = 140;//header height;
$footer_h    = 170;//footer height;
$meses       = array('', 'Janeiro',  'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$m           = array(" ", "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");
/******************** DADOS **********************/
if (!empty($cod_clinica) and !empty($mes1)){
		$consulta = "SELECT r.*, c.*
					FROM repasse r, clinicas c  
					WHERE (r.confirma_data BETWEEN '".$ano."-".$mes1."-01' AND '".$ano."-".$mes1."-".$dia1."') 
					AND r.cod_clinica = $cod_clinica 
					AND c.cod_clinica = $cod_clinica
					ORDER BY r.confirma_data, r.cod_aso, r.nome_cliente, r.nome_func";
					
		$res = pg_query($consulta);
		$buffer = pg_fetch_all($res);	   
		
		
		
}

/*
elseif (!empty($cod_clinica) and !empty($mes1) and $mes!=12 and date("Y") != 2014){
		$consulta = "SELECT r.*, c.*
					FROM repasse r, clinicas c  
					WHERE (r.confirma_data BETWEEN '2012-12-01' AND '2013-01-20') 
					AND r.cod_clinica = $cod_clinica 
					AND c.cod_clinica = $cod_clinica
					ORDER BY r.confirma_data";
					
		$res = pg_query($consulta);
		$buffer = pg_fetch_all($res);
		
}elseif (!empty($cod_clinica) and !empty($mes1) and $mes!=12 and date("Y") != 2015){
		$consulta = "SELECT r.*, c.*
					FROM repasse r, clinicas c  
					WHERE (r.confirma_data BETWEEN '2013-12-01' AND '2014-01-20') 
					AND r.cod_clinica = $cod_clinica 
					AND c.cod_clinica = $cod_clinica
					ORDER BY r.confirma_data";
					
		$res = pg_query($consulta);
		$buffer = pg_fetch_all($res);		   

}else{
		$consulta = "SELECT r.*, c.*
					FROM repasse r, clinicas c  
					WHERE (r.confirma_data BETWEEN '2015-12-01' AND '2016-01-20') 
					AND r.cod_clinica = $cod_clinica 
					AND c.cod_clinica = $cod_clinica
					ORDER BY r.confirma_data";
					
		$res = pg_query($consulta);
		$buffer = pg_fetch_all($res);	   

} */
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
        $rodape .= "<td align=left><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Telefone: +55 (21) 3014 4304   Fax: Ramal 7</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Nextel: +55 (21) 9703 64932</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=3 >faleprimeirocomagente@sesmt-rio.com / financeiro@sesmt-rio.com</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >www.sesmt-rio.com</font></td><td width=130><font face=\"Verdana, Arial, Helvetica, sans-serif\"><b>
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
//if($mes!=12){
	$code .= '<table width="100%"  border="0" style="border: 1px solid black;" cellspacing="0" bordercolor="#000000"><tr><td width=85% >Relatorio de repasse por serviço</td><td width=15%>nº: '.$buffer[0][cod_clinica];
	if($mes1<10){
	$code .= "0";
	}
	$code .= $mes1.'12</td></tr></table><p>';
	$code .= "<table width=100%><tr><td width=50%>";
	$code .= "<table width=100% >";
	$code .= "<tr><td align=center><b>Dados para o depósito</b></td></tr>";
	$code .= "<tr><td><b>Bco: </b>104</td></tr>";
	$code .= "<tr><td><b>Agência: </b>1330</td></tr>";
	$code .= "<tr><td><b>Conta: </b>02506692-6</td></tr>";
	$code .= "<tr><td><b>Operação: </b>013</td></tr>";
	$code .= "<tr><td><b>Nome do favorecido: </b>Pedro Henrique da Silva</td></tr>";
	$code .= "<tr><td><b>CPF: </b>807.648.437-53</td></tr>";
	$code .= "</table>";
	$code .= "</td><td width=60%>";
	$code .= "<table width=100% >";
	$code .= "<tr><td><b>Cliente: </b>".$buffer[0][razao_social_clinica]."</td></tr>";
	$code .= "<tr><td><b>CNPJ: </b>".$buffer[0][cnpj_clinica]."</td></tr>";
	$code .= "<tr><td><b>Codigo do cliente: </b>".$buffer[0][cod_clinica]."</td></tr>";
	$code .= "<tr><td><b>Data da emissao: </b>".$dia1."/". $mes1 ."/".$ano."</td></tr>";
	$code .= "<tr><td><b>Periodo de cobrança: </b>01/". $mes1 ."/".$ano." a ".$dia1."/". $mes1 ."/".$ano."</td></tr>";
	$code .= "<tr><td><b>Vencimento: </b>15/". $mes2 ."/".$ano2."</td></tr>";
	$code .= "</table>";
	$code .= "</td></tr></table><p />";
	$code .= '  <table width="100%"  border="0" style="border: 1px solid black;" cellspacing="0" bordercolor="#000000">
    <tr>
	  <td align="center" width=8% style="border-bottom: 1px solid black;"><center><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><b>Código</b></font></div></center></td>

	  <td  width=12% style="border-bottom: 1px solid black;"><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><b>Data</b></font></div></td>
	
      <td width=30% style="border-right: 1px solid black;border-bottom: 1px solid black;"><div align="left"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><b>Exame</b></font></div></td>
	  
      <td  width=30% style="border-right: 1px solid black;border-bottom: 1px solid black;"><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><b>Cliente</b></font></div></td>
	  
      <td  width=30% style="border-right: 1px solid black;border-bottom: 1px solid black;"><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><b>Funcionário</b></font></div></td>
	  
      <td  width=10% style="border-bottom: 1px solid black;"><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><b>Valor</b></font></div></td>
	  
    </tr>';
	
	for($c=0;$c<pg_num_rows($res);$c++){
		//$t = "SELECT f.cod_func, f.nome_func, c.cliente_id, c.razao_social FROM funcionarios f, cliente c WHERE f.cod_func = '{$buffer[$c][cod_func]}' AND c.cliente_id = '{$buffer[$c][cod_cliente]}'";
		//$tt = pg_query($t);
		//$ttt = pg_fetch_array($tt);
		$total += $buffer[$c][valor];
		$br_data1 = explode('-',($buffer[$c][confirma_data]));
		$br_data2 = $br_data1[2].'-'.$br_data1[1].'-'.$br_data1[0];
		$code .= "<tr><td align=center>".$buffer[$c][cod_aso]."</td><td>".$br_data2."</td><td>".$buffer[$c][nome_exame]."</td><td>".$buffer[$c][nome_cliente]."</td><td>".$buffer[$c][nome_func]."</td><td>R$ ".number_format($buffer[$c][valor], 2, ',','.')."</td></tr>";
	}
	$code .= "</table>";
	$code .= '<br><table width="100%"  border="0" style="border: 1px solid black;" cellspacing="0" bordercolor="#000000"><tr><td width=85% ><b>Total a pagar**</b></td><td width=17%><b>R$ '.number_format($total, 2, ',','.').'</b></td></tr></table><p>';
	
        $code .= "<p><table width=100% border=0>";
        $code .= "<tr>";
        $code .= "<td><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=2 >** Os pagamentos desta fatura não isentam o pagamento de ventuais saldos devedores. Para maiores esclarecimentos, ligue para nossa central de atendimento: +55 (21) 3014 4304, ou entre em contato com nosso balcão de atendimento virtual, e-mail: faleprimeirocomagente@sesmt-rio.com.</font></td>";
        $code .= "</tr>";
        $code .= "</table>";
		
/*}else{
	$code .= '<table width="100%"  border="0" style="border: 1px solid black;" cellspacing="0" bordercolor="#000000"><tr><td width=85% >Relatorio de repasse por serviço</td><td width=15%>nº: '.$buffer[0][cod_clinica];
	if($mes1<10){
	$code .= "0";
	}
	$code .= $mes1.'12</td></tr></table><p>';
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
	$code .= "<tr><td><b>Data da emissao: </b>".$dia1."/01/2016</td></tr>";
	$code .= "<tr><td><b>Periodo de cobrança: </b>01/12/2015 a ".$dia1."/01/2016</td></tr>";
	$code .= "<tr><td><b>Vencimento: </b>25/01/2016</td></tr>";
	$code .= "</table>";
	$code .= "</td></tr></table><p />";
	$code .= '  <table width="100%"  border="0" style="border: 1px solid black;" cellspacing="0" bordercolor="#000000">
    <tr>
	  <td align="center" width=8% style="border-bottom: 1px solid black;"><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><center><b>Código</b></center></font></div></td>

	  <td  width=12% style="border-bottom: 1px solid black;"><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><b>Data</b></font></div></td>
	
      <td width=30% style="border-right: 1px solid black;border-bottom: 1px solid black;"><div align="left"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><b>Exame</b></font></div></td>
	  
      <td  width=30% style="border-right: 1px solid black;border-bottom: 1px solid black;"><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><b>Cliente</b></font></div></td>
	  
      <td  width=30% style="border-right: 1px solid black;border-bottom: 1px solid black;"><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><b>Funcionário</b></font></div></td>
	  
      <td  width=10% style="border-bottom: 1px solid black;"><div align="center"><font face=\"Verdana, Arial, Helvetica, sans-serif\"face="Verdana, Arial, Helvetica, sans-serif"><b>Valor</b></font></div></td>
	  
    </tr>';
	
	for($c=0;$c<pg_num_rows($res);$c++){
	
		//$t = "SELECT f.cod_func, f.nome_func, c.cliente_id, c.razao_social FROM funcionarios f, cliente c WHERE f.cod_func = '{$buffer[$c][cod_func]}' AND c.cliente_id = '{$buffer[$c][cod_cliente]}'";
		//$tt = pg_query($t);
		//$ttt = pg_fetch_array($tt);
		$total += $buffer[$c][valor];
		$br_data1 = explode('-',($buffer[$c][confirma_data]));
		$br_data2 = $br_data1[2].'-'.$br_data1[1].'-'.$br_data1[0];
		$code .= "<tr><td align=center>".$buffer[$c][cod_aso]."</td><td>".$br_data2."</td><td>".$buffer[$c][nome_exame]."</td><td>".$buffer[$c][nome_cliente]."</td><td>".$buffer[$c][nome_func]."</td><td>R$ ".number_format($buffer[$c][valor], 2, ',','.')."</td></tr>";
	}
	$code .= "</table>";
	$code .= '<br><table width="100%"  border="0" style="border: 1px solid black;" cellspacing="0" bordercolor="#000000"><tr><td width=85% ><b>Total a pagar**</b></td><td width=17%><b>R$ '.number_format($total, 2, ',','.').'</b></td></tr></table><p>';
	
        $code .= "<p><table width=100% border=0>";
        $code .= "<tr>";
        $code .= "<td><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=2 >** Os pagamentos desta fatura não isentam o pagamento de ventuais saldos devedores. Para maiores esclarecimentos, ligue para nossa central de atendimento: +55 (21) 3014 4304, ou entre em contato com nosso balcão de atendimento virtual, e-mail: faleprimeirocomagente@sesmt-rio.com.</font></td>";
        $code .= "</tr>";
        $code .= "</table>";
}*/
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
    $arquivo = "REP_".$mes.'_'.$ano.'.pdf';
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
mail("suporte@ti-seg.com", "Assunto", "Texto", "suporte@sesmt-rio.com"); 
?> 