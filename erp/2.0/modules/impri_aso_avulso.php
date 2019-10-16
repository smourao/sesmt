<?PHP
/*****************************************************************************************************************/
// -> INCLUDES / DEFINES
/*****************************************************************************************************************/
define('_MPDF_PATH', '../../../../common/MPDF45/');
define('_IMG_PATH', '../../../../images/');
include(_MPDF_PATH.'mpdf.php');
include("../../../../common/database/conn.php");

/*****************************************************************************************************************/
// -> VARS
/*****************************************************************************************************************/
$code     = "";
$header_h = 130;//header height; 175
$footer_h = 170;//footer height;
$meses    = array('', 'Janeiro',  'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$m        = array(" ", "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");
$title    = "PROGRAMA DE PREVENÇÃO DE RISCOS AMBIENTAIS";

if($_GET[color]){
    $green = '#00FF00';
    $red   = '#FF0000';
    $blue  = '#0000FF';
    $yellow= '#FFF000';
    $brown = '#8D5A00';
}else{
    $green = '#FFFFFF';
    $red   = '#FFFFFF';
    $blue  = '#FFFFFF';
    $yellow= '#FFFFFF';
    $brown = '#FFFFFF';
}
ob_start();
/*****************************************************************************************************************/
// -> ASO / CLIENTE INFO
/*****************************************************************************************************************/

function coloca_zeros($numero){
echo str_pad($numero, 4, "0", STR_PAD_LEFT);
}


$asos_num = $_POST['botao_aso'];
$quanto = count($asos_num);


for($i=0;$i<$quanto;$i++){



$cod_aso = $asos_num[$i];



$dados_aso_avulso_sql = "SELECT * FROM aso_avulso WHERE cod_aso = $cod_aso";
$dados_aso_avulso_query = pg_query($dados_aso_avulso_sql);
$row = pg_fetch_array($dados_aso_avulso_query);


$numero_aso = coloca_zeros($cod_aso);








/*****************************************************************************************************************/
// -> BEGIN DOCUMENT
/*****************************************************************************************************************/

    /*************************************************************************************************************/
    // -> HEADER
    /*************************************************************************************************************/
    if($_GET[sem*timbre]){
		$cabecalho	 = "<br><br><br>";
        $cabecalho  .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
        $cabecalho .= "<tr>";
        $cabecalho .= "<td valign=top align=left height=$header_h> </td>";
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }else{
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
            <b>Atestado de Saúde Ocupacional</b>
            </td>';
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
        $rodape .= "<td align=left width=88%><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Telefone: +55 (21) 3014 4304   Fax: Ramal 7</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Nextel: +55 (21) 9703 64932 - Id 35*8*16700</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=3 >faleprimeirocomagente@sesmt-rio.com / medicotrab@sesmt-rio.com</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >www.sesmt-rio.com</font></td><td width=12%><font face=\"Verdana, Arial, Helvetica, sans-serif\"><b>
     Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
     <br></td>";
        $rodape .= "</tr>";
        $rodape .= "</table>";
    }
    $code .= "<html>";
    $code .= "<head>";
    $code .= '<link href="../style.css" rel="stylesheet" type="text/css"/>';
    $code .= "</head>";
    $code .= "<body style=\"display: inline\">";

/****************************************************************************************************************/
// -> PAGE [2]
/****************************************************************************************************************/
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
		<td class="fontepreta12" align="left"><input type="text" name="codaso" size="5" value="'.$numero_aso.'" readonly="true" ></td>
		<td class="fontepreta12" align="left"><input type="text" name="razao_social_cliente" id="razao_social_cliente" size="90" value="'.$row[razao_social_cliente].'"></td>		
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
		<td width="70%" align="left" class="fontepreta12 style2">End. &nbsp;<input type="text" name="endereco_cliente" id="endereco_cliente" size="60" value="'.$row[endereco_cliente].'" /></td>
		<td width="30%" align="left" class="fontepreta12 style2">CEP &nbsp;<input type="text" name="cep_cliente" id="cep_cliente" size="15" value="'.$row[cep_cliente].'" /></td>
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
		<td class="fontepreta12" align="left"><input type="text" name="cnpj_cliente" id="cnpj_cliente" size="20" value="'.$row[cnpj_cliente].'" maxlength="18" /></td>
		<td class="fontepreta12" align="left"><input type="text" name="cnae" id="cnae" size="10" value="'.$row[cnae].'"  /></td>
		<td class="fontepreta12" align="left"><input type="text" name="grau_risco" id="grau_risco" size="5" value="'.$row[grau_risco].' /></td>
		<td class="fontepreta12" align="left"><input type="text" name="tipo_exame" id="tipo_exame" size="21" value="'.$row[tipo_exame].'" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table></div>';
	//linha 3
	$code .= '<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="100%" align="left" class="fontepreta12 style2">Nome do Funcionário</td>
	</tr>
	<tr>
		<td class="fontepreta12" align="left"><input type="text" name="nome_func" size="100" value="'.$row[nome_func].'"  /></td>
	</tr>
</table></div>';
	//linha 4
	$code .= '<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
<br />
	<tr>
		<td width="15%" align="left" class="fontepreta12 style2">CTPS &nbsp;<input type="text" name="num_ctps_func" size="5" value="'.$row[num_ctps_func].'"  /></td>
		<td width="15%" align="left" class="fontepreta12 style2">Série &nbsp;<input type="text" name="serie_ctps_func" size="5" value="'.$row[serie_ctps_func].'/></td>
		<td width="15%" align="left" class="fontepreta12 style2">CBO &nbsp;<input type="text" name="cbo" size="5" value="'.$row[cbo].'/></td>
		<td width="65%" align="left" class="fontepreta12 style2">Função &nbsp;<input type="text" name="nome_funcao" size="50" value="'.$row[nome_funcao].'/></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table></div>';
	//linha 5	
	$code .= '<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="100%" align="left" class="fontepreta12 style2">Atividade Laborativa&nbsp;<input type="text" name="dinamica_funcao" size="95" value="'.$row[dinamica_funcao].'/></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table></div>';
	//linha 6	
	$code .= '<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="50%" align="left" class="fontepreta12 style2">Classificação da Atividade&nbsp;<input type="text" name="nome_atividade" size="20" value="'.$row[nome_atividade].'" /></td>
		<td width="50%" align="left" class="fontepreta12 style2">Nível de Tolerância&nbsp;<input type="text" name="nivel_tolerancia" size="20" value="'.$row[nivel_tolerancia].'"  /></td>
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
		if( !empty($funcionario) and !empty($aso) ){
			if($a[tipo] != 1){
				
				
				$code .= "<td valign=top class='text'>";			
				
					$code .= "$row_risco[nome_tipo_risco] <br> ";
				
				$code .= "</td>";
			}
		}//Fim da Seleção
		
		
		
		//ESPECIFICAR OS RISCOS DA FUNÇÃO.
		if( !empty($funcionario) and !empty($aso) ){
			if($a[tipo] != 1){
				
		
				$code .= "<td valign=top class='text'>";
				while($row_agente=pg_fetch_array($result_agente)){ 
					
				}
				$code .= "</td>";
			}
		} //FIM DA SELEÇÃO
		
		//SELEÇÃO DOS EXAMES COMPLEMENTARES.
		if(!empty($aso) ){
		
		$code .= "<td valign=top class='text'>";
			$code .= "<Table border=0 width=100%>";			
			
				$code .= "<tr><td valign=top class='text'>";
				$code .= "</td></tr>";
		
					$code .= "$row_exame[especialidade]";
				$code .= "</td>";
				$code .= "</tr>";
			$code .= "</table>";
		$code .= "</td>";
		} //Fim da Seleção
    $code .= "</tr>";
	$code .= "</table>";
	
	
	
	//ESTA CONSULTA SÓ ACONTECERÁ PARA UM CLIENTE ESPECÍFICO
	$sc = "SELECT * FROM aso_exame WHERE cod_aso = {$aso}";
	$rsc = pg_query($sc);
	$ce = pg_fetch_array($rsc);
	
	$code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";	
	$code .= "<td valign=top align=justify class='text'>Atesto para os fins do artigo 168 da lei 6.514/77 e port. 3.214/78 SSMT Nº24 de 29/12/94 e despacho SSMT nº8 de 01/10/96, NR7 - PCMSO, que: o funcionário como acima qualificado, encontra-se <b>$fdp[aso_resultado]</b> mediante ter sido aprovado nos exames físicos e psicológicos.";
	/*
		if(pg_num_rows($rsc) == 1 and $ce[cod_exame] == 22){
			$code .= "Dependendo apenas dos exames complementares acima quando solicitados, para diagnosticação do médico coordenador dos programas de PCMSO - NR7, de responsabilidade do empregador realizá-los e remeter ao médico examinador o(s) original(is), em até o 10º dia útil da avaliação física. Este ASO(atestado de saúde ocupacional) só será válido para efeito de fiscalização e ou judicialmente se acompanhado dos exames complementares sempre que for solicitado pelo médico examinador.";
		}else{
		
		}*/
	$code .= "</td>";
    $code .= "</tr>";
	$sl = "SELECT * FROM aso WHERE cod_aso = ".$aso." ";
	$qy = pg_query($sl);
	$cee = pg_fetch_array($qy);
	if($cee[aso_resultado] == "Inapto" || $cee[aso_resultado] == "Apto com Restricao"){
		$code .= "<tr><td valign=top align=left class='text'> ".$cee[obs]." </td></tr>";
	}
	$code .= "<tr>";
	$code .= "<td valign=top class='text'><b>Data de Realização:&nbsp;</b>".date("d/m/Y", strtotime($fdp[aso_data]))."</td>";
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
	
    $code .= "<div class='pagebreak'></div>";
}
ob_end_clean();

/*****************************************************************************************************************/
// -> OUTPUT
/*****************************************************************************************************************/
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
?>