<?php
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
$title    = "PERFIL PROFISSIOGRÁFICO PREVIDENCIÁRIO AVULSO";
$id = $_GET["id"];

//BUSCAR DADOS DO PPP AVULSO

	$pppsql = "SELECT * FROM ppp_avulso
			  WHERE id = $id";
	$pppquery = pg_query($pppsql);
	$ppp = pg_fetch_array($pppquery);
	$pppnum = pg_num_rows($pppquery);


//BUSCA DADOS DA EXAMINADORA

	$busca = "SELECT admissao, nome, ctps, email, demissao
			  FROM funcionario
			  WHERE funcionario_id = 21";
	$r = pg_query($connect, $busca);
	$rr = pg_fetch_array($r);



/*****************************************************************************************************************/
// -> BEGIN DOCUMENT
/*****************************************************************************************************************/
ob_start();
    $code .= "<html>";
    $code .= "<head>";
	$code .= "<title>$title</title>";
	$code .= "<meta charset='utf-8'>";
    $code .= '<link href="../style.css" rel="stylesheet" type="text/css"/>';
    $code .= "</head>";
    $code .= "<body>";
/****************************************************************************************************************/
// -> PAGE [1]
/****************************************************************************************************************/

	$code .= '<br><br><table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
	<td align="center" valign=center><img src="'._IMG_PATH.'previdencia.jpg" width="200" height="120"></td>
	</tr>
</table><p>';

	$code .= '<br><br><table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
	<td align="center"><font size=7>ANEXO XV</font><P><font size=5>INSTRUÇÃO NORMATIVA Nº 27/INSSPRES, DE 30  DE ABRIL DE 2008<P>INSTRUÇÃO NORMATIVA Nº 20/INSSPRES, DE 10 DE OUTUBRO DE 2007</font><P><font size=6>PERFIL PROFISSIOGRÁFICO PREVIDENCIÁRIO – PPP</font></td>
	</tr>
</table><p>';

	$code .= '<br><table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="center" width="20" class="fontepreta12bold">I</td>
		<td align="left" width="679" class="fontepreta12bold">&nbsp;Seção de Dados Administrativos</td>
	</tr>
</table><p>';

	$code .= '<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" width="250" class="fontepreta12">&nbsp;1-CNPJ do Domicílio Tributário/CEI<br>&nbsp;'.$ppp[cnpj].'</td>
		<td align="left" width="350" class="fontepreta12">&nbsp;2-Nome Empresarial<br>&nbsp;'.$ppp[razao_social].'</td>
		<td align="left" width="99" class="fontepreta12">&nbsp;3-CNAE<br>&nbsp;'.$ppp[cnae].'</td>
	</tr>
</table><p>';

	$code .= '<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" width="500" class="fontepreta12">&nbsp;4-Nome do Trabalhador<br>&nbsp;'.$ppp[nome_func].'</td>
		<td align="left" width="99" class="fontepreta12">&nbsp;5-BR/PDH<br>&nbsp;'.$ppp[pdh].'</td>
		<td align="left" width="100" class="fontepreta12">&nbsp;6-NIT<br>&nbsp;'.$ppp[nit].'</td>
	</tr>
</table><p>';
	$code .= '<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" width="150" class="fontepreta12">&nbsp;7-Data de Nascimento<br>&nbsp;'.$ppp[data_nascimento].'</td>
		<td align="left" width="90" class="fontepreta12">&nbsp;8-Sexo (M/F)<br>&nbsp;'.$ppp[sexo].'</td>
		<td align="left" width="150" class="fontepreta12">&nbsp;9-CTPS (Nº, Série e UF)<br>&nbsp;'.$ppp[ctps].'-Série '.$ppp[ctps_serie].'-UF '.$ppp[ctps_uf].'</td>
		<td align="left" width="145" class="fontepreta12">&nbsp;10-Data de Admissão<br>&nbsp;'.$ppp[data_admissao].'</td>
		<td align="left" width="164" class="fontepreta12">&nbsp;11-Regime de Revezamento<br>&nbsp;'.$ppp[revezamento].'</td>
	</tr>
</table><p>';

	$code .= '<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="4" width="699" class="fontepreta12">&nbsp;12-CAT Registrada</td>
	</tr>
	<tr>
		<td align="left" width="175" class="fontepreta12">&nbsp;12.1-Data de Registro</td>
		<td align="left" width="175" class="fontepreta12">&nbsp;12.2-Número da CAT</td>
		<td align="left" width="174" class="fontepreta12">&nbsp;12.1-Data do Registro</td>
		<td align="left" width="174" class="fontepreta12">&nbsp;12.2-Número da CAT</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;'.$ppp[data_registro_cat].'</td>
		<td align="left" class="fontepreta12">&nbsp;'.$ppp[num_cat].'</td>
		<td align="left" class="fontepreta12">&nbsp;'.$ppp[data_registro_cat2].'</td>
		<td align="left" class="fontepreta12">&nbsp;'.$ppp[num_cat2].'</td>
	</tr>
</table><p>';

	$code .= '<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="7" width="699" class="fontepreta12">&nbsp;13-Lotação e Atribuição</td>
	</tr>
	<tr>
		<td align="left" width="90" class="fontepreta12">&nbsp;13.1-Período</td>
		<td align="left" width="100" class="fontepreta12">&nbsp;13.2-CNPJ/CEI</td>
		<td align="left" width="100" class="fontepreta12">&nbsp;13.3-Setor</td>
		<td align="left" width="117" class="fontepreta12">&nbsp;13.4-Cargo</td>
		<td align="left" width="117" class="fontepreta12">&nbsp;13.5-Função</td>
		<td align="left" width="80" class="fontepreta12">&nbsp;13.6-CBO</td>
		<td align="left" width="95" class="fontepreta12">&nbsp;13.7-Cód. GFIP</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">';
		if($ppp[data_desligamento] != ''){
			$dat = explode('/', $ppp[data_admissao]);
			$code .= $ppp[data_admissao].' à '.$ppp[data_desligamento];
		}else{
			$dat = explode('/', $ppp[data_admissao]);
			$code .= $ppp[data_admissao];
		}
		
	$code .= '</td>
		<td align="left" class="fontepreta12">&nbsp;'.$ppp[cnpj].'</td>
		<td align="left" class="fontepreta12">&nbsp;'.$ppp[setor].'</td>
		<td align="left" class="fontepreta12">&nbsp;'.$ppp[cargo].'</td>
		<td align="left" class="fontepreta12">&nbsp;'.$ppp[funcao].'</td>
		<td align="center" class="fontepreta12">&nbsp;'.$ppp[cbo].'</td>
		<td align="center" class="fontepreta12">&nbsp;'.$ppp[grau_de_risco].'</td>
	</tr>
</table><p>';

	$code .= '<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="2" width="699" class="fontepreta12">&nbsp;14-Profissiografia</td>
	</tr>
	<tr>
		<td align="left" width="90" class="fontepreta12">&nbsp;14.1-Período</td>
		<td align="left" width="608" class="fontepreta12">&nbsp;14.2-Descrição das Atividades</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">';
		
		if($ppp[data_desligamento] != ''){
			$dat = explode('/', $ppp[data_admissao]);
			$code .= $ppp[data_admissao].' à '.$ppp[data_desligamento];
		}else{
			$dat = explode('/', $ppp[data_admissao]);
			$code .= $ppp[data_admissao];
		}
		
	$code .= '</td>
		<td align="justify" class="fontepreta12">&nbsp;'.$ppp[dsc_funcao].'</td>
	</tr>
</table><p>';

	$code .= '<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="8" width="699" class="fontepreta12">&nbsp;15-Exposição a Fatores de Riscos</td>
	</tr>

	<tr>
		<td align="left" width="90" class="fontepreta12">&nbsp;15.1-Período</td>
		<td align="left" width="80" class="fontepreta12">&nbsp;15.2-Tipo</td>
		<td align="left" width="115" class="fontepreta12">&nbsp;15.3-Fator de Risco</td>
		<td align="left" width="85" class="fontepreta12">&nbsp;15.4-Itens./Conc.</td>
		<td align="left" width="80" class="fontepreta12">&nbsp;15.5-Téc. Utilizada</td>
		<td align="left" width="80" class="fontepreta12">&nbsp;15.6-EPC Eficaz(S/N)</td>
		<td align="left" width="80" class="fontepreta12">&nbsp;15.7-EPI Eficaz(S/N)</td>
		<td align="left" width="80" class="fontepreta12">&nbsp;15.8-CA EPI</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">';

		
		if($ppp[data_desligamento] != ''){
			$dat = explode('/', $ppp[data_admissao]);
			$code .= $ppp[data_admissao].' à '.$ppp[data_desligamento];
		}else{
			$dat = explode('/', $ppp[data_admissao]);
			$code .= $ppp[data_admissao];
		}

		$code .= '</td>
		<td align="center" class="fontepreta12">' ;

		
			$code .= $ppp[tipo_fator_risco]; 
		

		$code .= '</td>
		<td align="center" class="fontepreta12">';

		$code .= $ppp[nome_fator_risco];

		$code .= '</td>
		<td align="left" class="fontepreta12">&nbsp;'.$ppp[itensidade].'</td>
		<td align="left" class="fontepreta12">&nbsp;Avaliado por aparelhos de medição</td>
		<td align="center" class="fontepreta12">&nbsp;'.$ppp[epc_eficaz].'</td>
		<td align="center" class="fontepreta12">&nbsp;'.$ppp[epi_eficaz];
		
		$code .= '</td>
		<td align="center" class="fontepreta12">&nbsp;'.$ppp[ca_epi].'</td>
	</tr>
</table><p>';

	$code .= '<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="4" width="699" class="fontepreta12">&nbsp;16-Responsável Pelos Registros Ambientais</td>
	</tr>
	<tr>
		<td align="left" width="90" class="fontepreta12">&nbsp;16.1-Período</td>
		<td align="left" width="97" class="fontepreta12">&nbsp;16.2-NIT</td>
		<td align="left" width="225" class="fontepreta12">&nbsp;16.3-Registro de Conselho de Classe</td>
		<td align="left" width="285" class="fontepreta12">&nbsp;16.4-Nome do Profissional Legalmente Habilitado</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">';

		
		if($ppp[data_desligamento] != ''){
			$dat = explode('/', $ppp[data_admissao]);
			$code .= $ppp[data_admissao].' à '.$ppp[data_desligamento];
		}else{
			$dat = explode('/', $ppp[data_admissao]);
			$code .= $ppp[data_admissao];
		}

        $code .= '</td>
		<td align="left" class="fontepreta12">&nbsp;'.$rr[ctps].'</td>
		<td align="left" class="fontepreta12">&nbsp;'.$rr[email].'</td>
		<td align="left" class="fontepreta12">&nbsp;'.$rr[nome].'</td>
	</tr>
</table><p>';

   $code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [3]
/****************************************************************************************************************/
	$code .= '<br><br><table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="center" width="30" class="fontepreta12bold">III</td>
		<td align="left" width="669" class="fontepreta12bold">&nbsp;Seção de Resultados de Monitoração Biológica</td>	
	</tr>
</table><p>';

	$code .= '<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="5" width="100%" class="fontepreta12">&nbsp;17-Exames Médicos Clínicos e Complementares(Quadros I e II da NR-07)</td>
	</tr>
	<tr>
		<td align="left" width="13%" class="fontepreta12">&nbsp;17.1-Data</td>
		<td align="left" width="13%" class="fontepreta12">&nbsp;17.3-Natureza</td>
		<td align="left" width="52%" class="fontepreta12">&nbsp;17.4-Exame(R/S)</td>
		<td align="left" width="22%" class="fontepreta12">&nbsp;17.5-Indicação de Resultados</td>
	</tr>
	<tr>
		<td align="center" class="fontepreta12">';

		$code .= $ppp[data_exame]."<br>";

		$code .= '<p></td> 

		<td align="center" class="fontepreta12">';

		
		$code .= $ppp[tipo_exame]."<br>"; 
			
		$code .= '</td>
		<td align="left" class="fontepreta12">';
		
		
		$code .= $ppp[nome_exame].". "; 
		
		
		$code .= '</td>
		<td align="left" class="fontepreta12">&nbsp;(x) Normal<br>&nbsp;( ) Alterado<br>&nbsp;( ) Estável<br>&nbsp;( ) Agravamento<br>&nbsp;( ) Ocupacional<br>&nbsp;( ) Não Ocupacional</td>
	</tr>
</table><p>';

	$code .= '<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="4" width="699" class="fontepreta12">&nbsp;18-Responsável Pela Monitoração Biológica</td>
	</tr>
	<tr>
		<td align="left" width="90" class="fontepreta12">&nbsp;18.1-Peródo</td>
		<td align="left" width="97" class="fontepreta12">&nbsp;18.2-NIT</td>
		<td align="left" width="225" class="fontepreta12">&nbsp;18.3-Registo de Conselho de Classe</td>
		<td align="left" width="285" class="fontepreta12">&nbsp;18.4-Nome do Profissional Legalmente Habilitado</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">';

		if($ppp[data_desligamento] != ''){
			$dat = explode('/', $ppp[data_admissao]);
			$code .= $ppp[data_admissao].' à '.$ppp[data_desligamento];
		}else{
			$dat = explode('/', $ppp[data_admissao]);
			$code .= $ppp[data_admissao];
		}

		$code .='</td>
		<td align="left" class="fontepreta12">&nbsp;'.$rr[ctps].'</td>
		<td align="left" class="fontepreta12">&nbsp;'.$rr[email].'</td>
		<td align="left" class="fontepreta12">&nbsp;'.$rr[nome].'</td>
	</tr>
</table><p>';

	$code .= '<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="center" width="30" class="fontepreta12bold">IV</td>
		<td align="left" width="669" class="fontepreta12bold">&nbsp;Seção de Resultados de Monitoração Biológica</td>	
	</tr>
</table><p>';

	$code .= '<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="justify" width="698" class="fontepreta12">&nbsp;Declaramos, para todos os fins de direitos, que as informações prestadas nesse documento são verídicas e foram transcritas fielmente dos registros administrativos, das demonstrações ambientais e dos programas médicos de responsabilidade da empresa. É de nosso conhecimento que a prestação de informações falsas nesse documento constitui crime de falsificação de documento público, nos termos do art.297 do Código Penal e, também, que tais informações são de caráter privativo do trabalhador, constituindo crime, nos termos da Lei nº 9.029/95, práticas discriminatórias decorrentes de sua exigibilidade por outrem, bem como de sua divulgação para terceiros, ressalvando quando exigida pelos órgãos públicos competentes.</td>
	</tr>
</table><p>';

	$code .= '<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" width="164" class="fontepreta12">&nbsp;19-Data da Emissão do PPP</td>
		<td align="left" colspan="2" width="530" class="fontepreta12">&nbsp;20-Representante Legal da Empresa</td>
	</tr>
	<tr>
		<td align="center" rowspan="2" class="fontepreta12">'.$ppp[data_ppp].'</td>
		<td align="left" class="fontepreta12">&nbsp;20.1-NIT:'.$ppp[nit_empresa].'</td>
		<td align="left" class="fontepreta12">&nbsp;20.2-Nome:'.$ppp[nome_contato_dir].'</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;(carimbo)</td>
		<td align="left" class="fontepreta12">&nbsp;(assinatura)</td>
	</tr>
</table><p>';

/****************************************************************************************************************/
// -> PAGE [X]
/****************************************************************************************************************/
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
$mpdf->ignore_invalid_utf8 = true;
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
$arquivo = $id.'_'.date("ymdhis").'.pdf';
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