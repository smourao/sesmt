<?PHP
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
$code     = "";
$header_h = 130;//header height; 175
$footer_h = 170;//footer height;
$meses    = array('', 'Janeiro',  'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$m        = array(" ", "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");

ob_start();
/*************************************************************************************************************/
    // -> HEADER
    /*************************************************************************************************************/
    /*if($_GET[sem*timbre]){
		$cabecalho	 = "<br><br><br>";
        $cabecalho  .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
        $cabecalho .= "<tr>";
        $cabecalho .= "<td valign=top align=left height=$header_h> </td>";
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }else{
        $cabecalho  = "<br><br><table width=100% border=0>";
        $cabecalho .= "<tr>";
        $cabecalho .= '<td align="left">
            <p><strong>
            <font size="7" face="Verdana, Arial, Helvetica, sans-serif">SESMT<sup><font size=3>®</font></sup></font>&nbsp;&nbsp;
			<font size="1" face="Verdana, Arial, Helvetica, sans-serif">SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
			CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></strong>
            </td>';
        $cabecalho .= ' <td width=40% align="right">
            <font face="Verdana, Arial, Helvetica, sans-serif" size="4">
            <b>Atestado de Saúde Ocupacional</b>
            </td>';
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }*/
    if($_GET[sem_timbre]){
        $cabecalho  = "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
        $cabecalho .= "<tr>";
        $cabecalho .= "<td align=left height=$header_h>&nbsp; </td>";
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }else{
        $cabecalho  = "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h style='margin-top:20'>";
        $cabecalho .= "<tr>";
        $cabecalho .= "<td align=left height=$header_h valign=top width=400><img src='logonovo.png' width='400' height='80'></td>";
        $cabecalho .= "<td align=right height=$header_h valign=top width=240><img src='main-logo.png' width='240' height='80'></td>";
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }
    /************************************************************************************************************/
    // -> FOOTER
    /************************************************************************************************************/
    if($_GET[sem*timbre]){
        $rodape  = "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$footer_h>";
        $rodape .= "<tr>";
        $rodape .= "<td valign=top align=left height=$footer_h> </td>";
        $rodape .= "</tr>";
        $rodape .= "</table>";
    }else{
        $rodape .= "<table width=100% border=0>";
        $rodape .= "<tr>";
        $rodape .= "<td align=left width=88%><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Telefone: +55 (21) 3014 4304   Fax: Ramal 7</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Nextel: +55 (21) 9700 31385 - Id 55*23*31641</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=3 >faleprimeirocomagente@sesmt-rio.com / medicotrab@sesmt-rio.com</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >www.sesmt-rio.com</font></td><td width=12%><font face=\"Verdana, Arial, Helvetica, sans-serif\"><b>
     Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
     <br></td>";
        $rodape .= "</tr>";
        $rodape .= "</table>
		<br>
		<br>";
    }

/*****************************************************************************************************************/
// -> ASO / CLIENTE INFO
/*****************************************************************************************************************/

$asos_num = $_POST[botao_aso];
$quanto = count($asos_num);

for($c=0;$c<$quanto;$c++){

for($r=0;$r<2;$r++){

$cod_aso = $asos_num[$c];

$dados_aso_avulso_sql = "SELECT * FROM aso_avulso WHERE cod_aso = ".$cod_aso."";
$dados_aso_avulso_query = pg_query($dados_aso_avulso_sql);
$row = pg_fetch_array($dados_aso_avulso_query);

$numero_aso = str_pad($cod_aso, 4, "0", STR_PAD_LEFT);

$preco_aso = 35;

		$precoespecifico_sql = "SELECT preco_aso FROM preco_aso_cnpj WHERE cnpj_cliente = '{$row[cnpj_cliente]}' AND status = 0";
		$precoespecifico_query = pg_query($precoespecifico_sql);
		$precoespecifico = pg_fetch_array($precoespecifico_query);
		$precoespecificonum = pg_num_rows($precoespecifico_query);
		
		if($precoespecificonum >= 1){
			$preco_aso = $precoespecifico[preco_aso];
		}

/*****************************************************************************************************************/
// -> BEGIN DOCUMENT
/*****************************************************************************************************************/

    $code .= "<html>";
    $code .= "<head>";
    $code .= '<link href="../style.css" rel="stylesheet" type="text/css"/>';
    $code .= "</head>";
    $code .= "<body style=\"display: inline\">";

/****************************************************************************************************************/
// -> PAGE [2]
/****************************************************************************************************************/
	
	/*$code .= '<div class="mainTitle" align=center><font face="Verdana, Arial, Helvetica, sans-serif">
			 <p><font face="Verdana, Arial, Helvetica, sans-serif"><small><small><small><small>Médico Coordenador do PCMSO:<br />
			  Maria de Lourdes Fernandes Magalhães<br />
			  CREMERJ 52.33.471-0 Reg. MTE 13.320 </small></small></small></small></p></font></div><br>';*/
	
	$code .= "<div class='mainTitle' align=center><b>ASO - Atestado de Saúde Ocupacional</b></div>";
	$code .= "<div align=center><b>Conforme NR 7.4.1</b></div>";
	$code .= "<p align=justify>";
	
	$code .= '<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="14%" align="left" class="fontepreta12 style5">Nº ASO</td>
		<td width="86%" align="left" class="fontepreta12 style2">Razão Social</td>
	</tr>
	<tr>
		<td class="fontepreta12" align="left"><b>'.$numero_aso.'</b></td>
		<td class="fontepreta12" align="left"><b>'.utf8_encode($row['razao_social_cliente']).'</b></td>		
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table></div>
<div align="center">';
	//linha 1
	$code .= '<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="70%" align="left" class="fontepreta12 style2">End. &nbsp;<b>'.utf8_encode($row["endereco_cliente"]).'</b></td>
		<td width="30%" align="left" class="fontepreta12 style2">CEP &nbsp;<b>'.utf8_encode($row["cep_cliente"]).'</b></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table></div>';
	//linha 2
	$code .= '<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="25%" align="left" class="fontepreta12 style2">CNPJ</td>
		<td width="20%" align="left" class="fontepreta12 style2">CNAE</td>
		<td width="20%" align="left" class="fontepreta12 style2">Grau de Risco</td>
		<td width="35%" align="left" class="fontepreta12 style2">Tipo de Exame</td>
	</tr>
	<tr>
		<td class="fontepreta12" align="left"><b>'.utf8_encode($row["cnpj_cliente"]).'</b></td>
		<td class="fontepreta12" align="left"><b>'.utf8_encode($row["cnae"]).'</b></td>
		<td class="fontepreta12" align="left"><b>'.utf8_encode($row["grau_risco"]).'</b></td>
		<td class="fontepreta12" align="left"><b>'.utf8_encode($row["tipo_exame"]).'</b></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table></div>';
	//linha 3
	$code .= '<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="70%" align="left" class="fontepreta12 style2">Nome do Funcionário</td>
        <td width="30%" align="left" class="fontepreta12 style2">RG</td>
	</tr>
	<tr>
		<td class="fontepreta12" align="left"><b>'.utf8_encode($row["nome_func"]).'</b></td>
		<td class="fontepreta12" align="left"><b>'.utf8_encode($row["rg"]).'</b></td>
	</tr>
</table></div><br>';
	//linha 4
	$code .= '<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
<br />
	<tr>
		<td width="15%" align="left" class="fontepreta12 style2">CTPS &nbsp;<b>'.utf8_encode($row["num_ctps_func"]).'</b></td>
		<td width="15%" align="left" class="fontepreta12 style2">Série &nbsp;<b>'.utf8_encode($row["serie_ctps_func"]).'</b></td>
		<td width="15%" align="left" class="fontepreta12 style2">CBO &nbsp;<b>'.utf8_encode($row["cbo"]).'</b></td>
		<td width="65%" align="left" class="fontepreta12 style2">Função &nbsp;<b>'.utf8_encode($row["nome_funcao"]).'</b></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table></div>';
	//linha 5	
	$code .= '<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="100%" align="left" class="fontepreta12 style2">Atividade Laborativa&nbsp;<b>'.utf8_encode($row["dinamica_funcao"]).'</b></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table></div>';
	//linha 6	
	$code .= '<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="50%" align="left" class="fontepreta12 style2">Classificação da Atividade&nbsp;<b>'.utf8_encode($row["nome_atividade"]).'</b></td>
		<td width="50%" align="left" class="fontepreta12 style2">Nível de Tolerância&nbsp;<b>'.utf8_encode($row["nivel_tolerancia"]).'</b></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table></div>';

//linha 7	
	$code .= "</table>";
	$code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";	
	$code .= "<td valign=top width=30% class='text'><b>Risco da Função:</b></td>";
    $code .= "<td valign=top width=30% class='text'><b>Riscos Específicados:</b></td>";
	$code .= "<td valign=top class='text'><b>Exames Realizados:</b></td>";
    $code .= "</tr>";
	$code .= "<tr>";
		
		// SELEÇÃO DOS RISCOS DA FUNÇÃO.
			
			$riscoarray = explode("|", $row["cod_tipo_risco"]);
			$juntarrisco = "";
			
			for($v=0;$v<count($riscoarray);$v++){
				
				$numrisco = $riscoarray[$v];
				
				$row_riscosql = "SELECT nome_tipo_risco FROM tipo_risco WHERE cod_tipo_risco = ".$numrisco."";
				$row_riscoquery = pg_query($row_riscosql);
				$row_risco = pg_fetch_array($row_riscoquery);
				
				$juntarrisco .= $row_risco["nome_tipo_risco"]."<br>";
			}
				$code .= "<td valign=top class='text'>";			
				
					$code .= "<b>".utf8_encode($juntarrisco)."</b>";
				
				$code .= "</td>";
		
		//ESPECIFICAR OS RISCOS DA FUNÇÃO.
			$agentearray = explode("|", $row["cod_agente_risco"]);
			$juntaragente = "";
		
				for($v=0;$v<count($agentearray);$v++){
				
					$numagente = $agentearray[$v];
					
					$row_agentesql = "SELECT nome_agente_risco FROM agente_risco WHERE cod_agente_risco = ".$numagente."";
					$row_agentequery = pg_query($row_agentesql);
					$row_agente = pg_fetch_array($row_agentequery);
					
					$juntaragente .= $row_agente["nome_agente_risco"]."<br>";
				}
				$code .= "<td valign=top class='text'>";			
				
					$code .= "<b>".utf8_encode($juntaragente)."</b>";
				
				$code .= "</td>";
		
		//SELEÇÃO DOS EXAMES COMPLEMENTARES.
			$examearray = explode("|", $row["cod_exame"]);
			$juntarexame = "";
		
				for($v=0;$v<count($examearray);$v++){
				
					$numexame = $examearray[$v];
					
					$row_examesql = "SELECT especialidade FROM exame WHERE cod_exame =  ".$numexame."";
					$row_examequery = pg_query($row_examesql);
					$row_exame = pg_fetch_array($row_examequery);
					
					$juntarexame .= $row_exame[especialidade]."<br>";
				}
				$code .= "<td valign=top class='text'>";			
				
					$code .= "<b>".utf8_encode($juntarexame)."</b>";
				
				$code .= "</td>";
		
    $code .= "</tr>";
	$code .= "</table><br><br>";
	
	$code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";	
	$code .= "<td valign=top align=justify class='text'>Atesto para os fins do artigo 168 da lei 6.514/77 e port. 3.214/78 SSMT Nº24 de 29/12/94 e despacho SSMT nº8 de 01/10/96, NR7 - PCMSO, que: o funcionário como acima qualificado, encontra-se <b>".utf8_encode($row['resultado'])."</b> mediante ter sido aprovado nos exames físicos e psicológicos.";
	
	$code .= "</td>";
    $code .= "</tr>";
	if($row["resultado"] == "INAPTO" || $row["resultado"] == "* APTO COM RESTRIÇÃO"){
		$code .= "<tr><td valign=top align=left class='text'> ".utf8_encode($row['texto_r'])." </td></tr>";
	}
	$code .= "<tr>";
	$code .= "<td valign=top class='text'><b>Data de Realização:&nbsp;</b>".$row['data']."</td>";
    $code .= "</tr>";
	$code .= "</table><br><br>";
	$code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";	
	$code .= "<td valign=top align=center width=50% class='text' valign='bottom'>______________________________________</td>";
    $code .= "<td valign=top align=center width=50% class='text'>";
	$code .= "<br><br><br><br>______________________________________";	
	$code .= "</td>";
    $code .= "</tr>";
	$code .= "<tr>";	
	$code .= "<td valign=top align=center class='text'>Assinatura do Examinado</td>";
    $code .= "<td valign=top align=center class='text'>Assinatura do Examinador</td>";
    $code .= "</tr>";
	$code .= "</table>";
	//if(($c + 1) != $quanto){
    $code .= "<div class='pagebreak'></div>";
	//}
}
}

$code.='<div align="center">
	<br>
  <table width="100%" border="0" style="border: 1px solid black;" cellspacing="0" bordercolor="#000000">
    <tr>
      <td width="50%" height="16"><font face="Verdana, Arial, Helvetica, sans-serif"><strong>Resumo de Fatura de Serviço</strong></font></td>
	  
	</tr>
  </table>
  <div align="right">
    <table width="63%" border="0"cellspacing="0" bordercolor="#000000">
      <tr>
        <td width="30%"><div align="left">
        <font face="Verdana, Arial, Helvetica, sans-serif">
        <strong>Cliente: </strong></div></td><td><div align="left">'.utf8_encode($row['razao_social_cliente']).'</font></div></td>
      </tr>
      <tr>
        <td width="30%"><div align="left"><font face="Arial, Helvetica, sans-serif"><strong>
        <font face="Verdana, Arial, Helvetica, sans-serif">CNPJ: </strong></div></td><td><div align="left">'.utf8_encode($row["cnpj_cliente"]).'</font></div></td>
      </tr>
      <tr>
        <td width="30%"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif"><strong>
        Tipo de Contrato: </strong></div></td><td><div align="left"> Avulso </font></div></td>
      </tr>
      <tr>
        <td width="30%"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif"><strong>
        Data da Emissão:</strong></div></td><td><div align="left"> '.date("d/m/Y").'</font></div></td>
      </tr>
     <tr>
        <td width="30%"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif"><strong>
        Período de Cobrança:</strong></div></td><td><div align="left">
        '.date("d/m/Y").'
        </font></div></td>
      </tr>
    </table>
  </div>
  <table width="100%" height="263"  border="0" style="border: 1px solid black;" cellspacing="0" bordercolor="#000000">
    <tr>
      <td width="52%" height="42" style="border-right: 1px solid black;border-bottom: 1px solid black;"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif"> Natureza dos Serviços</font></div></td>
      <td width="8%" style="border-right: 1px solid black;border-bottom: 1px solid black;"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif">Nº de<br> ASO</font></div></td>
      <td width="8%" style="border-right: 1px solid black;border-bottom: 1px solid black;"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif">Cód. Usuário</font></div></td>
      <td width="17%" style="border-right: 1px solid black;border-bottom: 1px solid black;"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif">Valor Unitário<br> (R$)</font></div></td>
      <td width="15%" style="border-bottom: 1px solid black;"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif">Valor Total<br> (R$)</font></div></td>
    </tr>
    <tr>
      <td valign=top style="border-right: 1px solid black;"><font face="Arial, Helvetica, sans-serif"><br>Atestado de Saúde Ocupacional – ASO<br><br><br><br><br><br><br><br><br></font></td>
      <td valign=top style="border-right: 1px solid black;" align=center><font face="Arial, Helvetica, sans-serif"><br><br>'.$quanto.'<br><br><br><br><br><br><br><br><br></font></td>
      <td valign=top style="border-right: 1px solid black;" align=center><font face="Arial, Helvetica, sans-serif"><br><br>&nbsp;<br><br><br><br><br><br><br><br><br></font></td>
      <td valign=top style="border-right: 1px solid black;" align=right><font face="Arial, Helvetica, sans-serif"><br><br>'.number_format($preco_aso, 2, ",",".").'<br><br><br><br><br><br><br><br><br></font></td>
      <td valign=top align=right><font face="Arial, Helvetica, sans-serif"><br><br>'.number_format(($preco_aso*$quanto), 2, ",",".").'<br><br><br><br><br><br><br><br><br></font></td>
    </tr>
    <tr>
      <td height="23"  style="border-top: 1px solid black;">
      <strong>
      <font face="Verdana, Arial, Helvetica, sans-serif">Total a Pagar**</font></strong></td>
      <td colspan=3  style="border-top: 1px solid black;">&nbsp;</td>
      <td align=right  style="border-top: 1px solid black;">
      <strong>
      <font face="Verdana, Arial, Helvetica, sans-serif">
      R$&nbsp;'.number_format(($preco_aso*$quanto), 2, ",",".").'
      </font></strong>
      </td>
    </tr>
  </table>
</div>';
//}
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
    $mpdf->charset_in='latin-1';
	$mpdf->ignore_invalid_utf8 = true;
    $mpdf->SetDisplayMode('fullpage');
    //$mpdf->SetFooter('{DATE j/m/Y&nbsp; H:i}|{PAGENO}/{nb}|SEDUC / SIGETI');
    $mpdf->SetHTMLHeader($cabecalho);
    $mpdf->SetHTMLFooter($rodape);
    //carregar folha de estilos
    //$stylesheet = file_get_contents('./pcmso.css');
    $stylesheet = file_get_contents('style.css');
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
	if(!is_dir("aso_pdf/$cod_aso")){  
	mkdir("aso_pdf/$cod_aso", 0700 );
	}	
    //nome do arquivo de saida PDF
    $arquivo = "ASO_".$cod_aso.'.pdf';
    //gera o relatorio
	if(file_exists("aso_pdf/$cod_aso/$arquivo")){ 
    unlink("aso_pdf/$cod_aso/$arquivo");
	$mpdf->Output("aso_pdf/$cod_aso/$arquivo",'F');
	}else{
    $mpdf->Output("aso_pdf/$cod_aso/$arquivo",'F');
	}
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