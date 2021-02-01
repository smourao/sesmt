<?PHP
/*****************************************************************************************************************/
// -> INCLUDES / DEFINES
/*****************************************************************************************************************/
define('_MPDF_PATH', '../../common/MPDF45/');
define('_IMG_PATH', '../../images/');
include(_MPDF_PATH.'mpdf.php');
include("../../common/includes/database.php");
include("../../common/includes/functions.php");

/********************************************************************************************************/
// -> VARS
/*********************************************************************************************************/
$orc = $_GET[cod_orc];

/*****************************************************************************************************/
// -> BEGIN DOCUMENT
/******************************************************************************************************/
ob_start(); /************************************************************************************************************/
    // -> HEADER /************************************************************************************************************/
    if($_GET[sem_timbre]){
        $cabecalho .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
        $cabecalho .= "<tr>";
        $cabecalho .= "<td align=left height=$header_h>&nbsp; </td>";
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }else{
        $cabecalho .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
        $cabecalho .= "<tr>";
        $cabecalho .= "<td align=left height=$header_h valign=top width=270><img src='"._IMG_PATH."logo_sesmt.png' width='270' height='135'></td>";
        $cabecalho .= "<td align=center height=$header_h valign=top class='medText'>Serviços Especializados de Segurança e<br>Monitoramento de Atividades no Trabalho<p>Assistência em Segurança e Higiene no Trabalho</td>";
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }
    /************************************************************************************************************/
    // -> FOOTER
    /************************************************************************************************************/
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
    
/****************************************************************************************************************/
// -> PAGE [1]
/****************************************************************************************************************/

$sql = "SELECT * FROM orc_aso WHERE cod_orc = '$orc' ORDER BY exame";
$query = pg_query($sql);
$array = pg_fetch_all($query);

$sql = "SELECT * FROM clinicas WHERE cod_clinica = ".$array[0][cod_clinica]." ";
$res = pg_query($sql);
$buffer = pg_fetch_array($res);

$y=0;
$exame[$y][nome] = "";
$exame[$y][valor] = 0;
$exame[$y][unitario] = 0;
$exame[$y][quantidade] = 0;

for($x=0;$x<=pg_num_rows($query);$x++){
	if( $array[$x][exame] == $array[$x-1][exame]){
		$exame[$y][nome] = $array[$x][exame];
		$exame[$y][valor] += $array[$x][valor];
		$exame[$y][quantidade] += 1;
		$exame[$y][unitario] = ($exame[$y][valor]/$exame[$y][quantidade]);
	}else{
		$y += 1;
		$exame[$y][nome] = $array[$x][exame];
		$exame[$y][valor] = $array[$x][valor];
		$exame[$y][quantidade] = 1;
		$exame[$y][unitario] = ($exame[$y][valor]/$exame[$y][quantidade]);
	}
}


$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
$msg_site .= "<tr>";
$msg_site .= "<td align=center class='medText'><b>ORÇAMENTO MÉDICO COMPLEMENTAR N° $cod_orc</b></td>";
$msg_site .= "</tr>";
$msg_site .= "</table><br><br>";


$msg_site .= '<table width=100% border=0 cellpadding=2 cellspacing=2>';
$msg_site .= '<tr>';
$msg_site .= '    <td class="text roundborder " width=20%><b>Clínica: </b></td><td class="text roundborder " >'.$buffer[razao_social_clinica].'</td>';
$msg_site .= '</tr>';
$msg_site .= '<tr>';
$msg_site .= '    <td class="text roundborder " width=20%><b>Endereço: </b></td><td class="text roundborder " >'.$buffer[endereco_clinica].' Nº'.$buffer[num_end].'&nbsp;</td>';
$msg_site .= '</tr>';
$msg_site .= '<tr>';
$msg_site .= '    <td class="text roundborder "><b>Bairro</b></td><td class="text roundborder ">'.$buffer[bairro_clinica].'&nbsp;</td>';
$msg_site .= '</tr>';
$msg_site .= '<tr>';
$msg_site .= '    <td class="text roundborder "><b>Cidade/Estado</b></td><td class="text roundborder ">'.$buffer[cidade].'/'.$buffer[estado].'&nbsp;</td>';
$msg_site .= '</tr>';
$msg_site .= '<tr>';
$msg_site .= '    <td class="text roundborder "><b>CEP</b></td><td class="text roundborder ">'.$buffer[cep_clinica].'&nbsp;</td>';
$msg_site .= '</tr>';
if(!empty($buffer[referencia_clinica])){
$msg_site .= '<tr>';
$msg_site .= '    <td class="text roundborder "><b>Ponto de Referência</b></td><td class="text roundborder ">'.$buffer[referencia_clinica].'&nbsp;</td>';
$msg_site .= '</tr>';
}
if(!empty($buffer[tel_clinica])){
$msg_site .= '<tr>';
$msg_site .= '    <td class="text roundborder "><b>Telefone</b></td><td class="text roundborder ">'.$buffer[tel_clinica].'&nbsp;</td>';
$msg_site .= '</tr>';
}
$msg_site .= '<tr>';
$msg_site .= '    <td class="text roundborder "><b>E-Mail</b></td><td class="text roundborder ">'.$buffer[email_clinica].'&nbsp;</td>';
$msg_site .= '</tr>';
$msg_site .= '</table><br /><br />';

$msg_site .='
<table width="100%" border="0" style="border: 1px solid black;" cellspacing="0" bordercolor="#000000">
  <tr>
    <td width="55%" align="center"><b>Nome do exame		</b></td>
    <td width="15%" align="center"><b>Quantidade		</b></td>
    <td width="15%" align="center"><b>Valor Unitário	</b></td>
    <td width="15%" align="center"><b>Valor Total		</b></td>
  </tr>';
$total = 0;
for($t=0;$t<=$x;$t++){
	if($exame[$t][nome]){
		$msg_site .="  
		  <tr>
			<td align='center'>".$exame[$t][nome]."</td>
			<td align='center'>".$exame[$t][quantidade]."</td>
			<td align='center'>R$".$exame[$t][unitario]."</td>
			<td align='center'>R$".$exame[$t][valor]."</td>
		  </tr>";
		$total += $exame[$t][valor];
	}
}
$msg_site .='
  <tr>
    <td colspan="3" align="right"><b>TOTAL GERAL	</b></td>
    <td >			<center>	  <b>R$'.$total.'		</b></center></td>
  </tr>';

  
$msg_site .=' 
</table><br/><br/>';

$msg_site .='
<table width="100%" border="0" style="border: 1px solid black;" cellspacing="0" bordercolor="#000000">
  <tr>
    <td width="30%" align="center"><b>Funcionário		</b></td>
    <td width="20%" align="center"><b>Função			</b></td>
    <td width="50%" align="center"><b>Exames			</b></td>
  </tr>';

$sq = "SELECT * FROM orc_aso oa, funcionarios fu, cliente cl, funcao fun WHERE 
		oa.cod_orc = '$orc' AND 
		oa.cod_cliente = '{$array[0][cod_cliente]}' AND 
		oa.cod_cliente = fu.cod_cliente AND 
		oa.cod_func = fu.cod_func AND 
		fu.cod_cliente = cl.cliente_id AND 
		cl.cliente_id = oa.cod_cliente AND
		fun.cod_funcao = fu.cod_funcao";
$quer = pg_query($sq);
$arra = pg_fetch_all($quer);

for($y=0;$y<pg_num_rows($quer);$y++){
	if($arra[$y][nome_func] !=$arra[$y-1][nome_func]){
		$msg_site .="  
		  <tr>
			<td align='center'>".$arra[$y][nome_func]."</td>
			<td align='center'>".$arra[$y][nome_funcao]."</td>";
			$msg_site .=" <td align='center'>";
				$s = "SELECT * FROM orc_aso WHERE cod_cliente = '{$array[0][cod_cliente]}' AND cod_func = '{$arra[$y][cod_func]}' AND cod_orc = '$orc'";
				$q = pg_query($s);
				$a = pg_fetch_all($q);
				for($c=0;$c<pg_num_rows($q);$c++){
					$msg_site .= $a[$c][exame]."; ";
				}
			$msg_site .=" </td>";
		    $msg_site .="</tr>";
	}
}
  
$msg_site .='</table>';















	
/*	
$headers = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <medicotrab@sesmt-rio.com> \n";

$msg = "Olá! Luciana, servimo-nos deste e-mail para informa-la que um ASO foi agendado pelo site!<br> 
		<b>Encaminhamento Nº: </b>".$cod_aso." <br>
		<b>Cliente: </b>".$cliente[razao_social]." <br> 
		<b>Funcionário: </b>".$funcionario[0][nome_func]." <br>
		<b>Tipo de ASO: </b>".$tipo_exame;
$mail_list = "medicotrab@sesmt-rio.com";
mail($mail_list, "SESMT - ASO Nº: ".$cod_aso, $msg, $headers);
*/

ob_end_clean();

/*****************************************************************************************************************/
// -> OUTPUT
/*****************************************************************************************************************/
//$html = ob_get_clean();
//$html = utf8_encode($html);

//$mpdf = new mPDF('pt','A4',3,'',8,8,5,14,9,9,'P');
//class mPDF ([ string $msg_clientepage [, mixed $format [, float $default_font_size [, string $default_font [, float $margin_left , float $margin_right , float $margin_top , float $margin_bottom , float $margin_header , float $margin_footer [, string $orientation ]]]]]])
$mpdf = new mPDF('pt', 'A4', 12, 'verdana', 8, 8, 0, 0, 0, 0, 'P'); //P: DEFAULT Portrait L: Landscape
//$mpdf->allow_charset_conversion=true;
$mpdf->charset_in='iso-8859-1';
$mpdf->SetDisplayMode('fullpage');
//$mpdf->SetFooter('{DATE j/m/Y&nbsp; H:i}|{PAGENO}/{nb}|SEDUC / SIGETI');
$mpdf->SetHTMLHeader($cabecalho);
$mpdf->SetHTMLFooter($rodape);

//carregar folha de estilos
$stylesheet = file_get_contents('../../common/css/pdf.css');
//incorporar folha de estilos ao documento
$mpdf->WriteHTML($stylesheet,1);

// incorpora o corpo ao PDF na posição 2 e deverá ser interpretado como footage. Todo footage é posicao 2 ou 0(padrão).
$mpdf->WriteHTML($msg_site);
//void WriteHTML ( string $html [, int $mode [, boolean $initialise  [, boolean $close ]]])
//MODE Values
//0 - Parses a whole html document
//1 - Parses the html as styles and stylesheets only
//2 - Parses the html as output elements only
//3 - (For internal use only - parses the html code without writing to document)
//4 - (For internal use only - writes the html code to a buffer)
//DEFAULT: 0

//nome do arquivo de saida PDF
$arquivo = "orc_aso".$orc.".pdf";

//gera o relatorio
$mpdf->Output($arquivo,'I');
/*
I: send the file inline to the browser. The plug-in is used if available. The name given by filename is used when one selects the "Save as" option on the link generating the PDF.
D: send to the browser and force a file download with the name given by filename.
F: save to a local file with the name given by filename (may include a path).
S: return the document as a string. filename is ignored.
*/
exit();
?>