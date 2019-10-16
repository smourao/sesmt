<?PHP
/*****************************************************************************************************************/
// -> INCLUDES / DEFINES
/*****************************************************************************************************************/
define('_MPDF_PATH', '../2.0/common/MPDF45/');
define('_IMG_PATH', '../2.0/images/');
include(_MPDF_PATH.'mpdf.php');
include("../2.0/common/database/conn.php");
/*****************************************************************************************************************/
// -> VARS
/*****************************************************************************************************************/


//    print_r($_POST);
if(isset($_GET['m'])){
    $mes = $_GET['m'];
}else{
    $mes = date("m");
}

if(isset($_GET['y'])){
    $ano = $_GET['y'];
}else{
    $ano = date("Y");
}

$meses = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
$code        = "";
$header_h    = 140;//header height;
$footer_h    = 170;//footer height;





if(($mes == 1) OR ($mes == 3) OR ($mes == 5) OR ($mes == 7) OR ($mes == 8) OR ($mes == 10) OR ($mes == 12)){
	
	$dia = 31;
	
}elseif(($mes == 4) OR ($mes == 6) OR ($mes == 9) OR ($mes == 11)){
	
	$dia = 30;
	
}else{
	
	if(($ano % 4)==0){
	
		$dia = 29;
		
	}else{
	
		$dia = 28;	
		
	}
	
	
}



$nome_relatorio = $ano."_".$mes."_".$dia;


$sql = "
SELECT
   i.id, i.valor_total, i.n_parcelas, i,forma_pagamento, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.data_lancamento, f.status, f.pago, f.id as rec_id, f.numero_doc as n_doc
FROM
   financeiro_info i, financeiro_fatura f
WHERE
   f.data_lancamento >= '{$ano}-{$mes}-01' AND f.data_lancamento <= '{$ano}-{$mes}-{$dia}' AND
   i.id = f.cod_fatura AND
   i.status = 0
   ORDER BY
   f.vencimento
";
$result = pg_query($sql);
$data = pg_fetch_all($result);

$sql = "
SELECT
   i.id, i.valor_total, i.n_parcelas, i,forma_pagamento, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.data_lancamento, f.status, f.pago, f.id as rec_id, f.numero_doc as n_doc
FROM
   financeiro_info i, financeiro_fatura f
WHERE
   f.data_lancamento >= '{$ano}-{$mes}-01' AND f.data_lancamento <= '{$ano}-{$mes}-{$dia}' AND
   i.id = f.cod_fatura AND
   i.status = 1
   ORDER BY
   f.vencimento
";
$result2 = pg_query($sql);
$data2 = pg_fetch_all($result2);



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
            <b>Controle Financeiro</b>
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
    $code .= '<link href="style.css" rel="stylesheet" type="text/css"/>';
    $code .= "</head>";
    $code .= "<body style=\"display: inline\">";
	
	$code .= "<table border=1 width=100% align=center>
	<tr>
	<td>
	<b>Receitas</b>
	</td>
	</tr>
	</table>
	<p>
	<P>";

if($_POST){

}

$code .= "<table border=1 width=100% align=center>
<tr>
   <td width=80 align=center><b>Vencimento</b></td>
   <td align=center><b>Título</b></td>
   <td align=center width=20><b>Forma de Pag.</b></td>
   <td align=center width=100><b>Valor</b></td>
   <!--<td align=center width=50><b>Pagamento</b></td>-->
</tr>";



$code .= "<input type=hidden name=hmes id=hmes value='{$mes}'>";
$code .= "<input type=hidden name=hano id=hano value='{$ano}'>";
$total_mes = 0;

$bg_color = array("#ffffff","#ffffff");
for($x=0;$x<pg_num_rows($result);$x++){


$code .= "
<tr>
   <td bgcolor='".$bg_color[($x%2)]."' width=10 align=center><font color=black>".date("d/m/Y", strtotime($data[$x]['vencimento']))."</td>
   <td bgcolor='".$bg_color[($x%2)]."' align=><font color=black>{$data[$x]['titulo']}</td>

   <td bgcolor='".$bg_color[($x%2)]."' align=center width=100>
   <font color=black>{$data[$x]['forma_pagamento']}</td>
   
   <td bgcolor='".$bg_color[($x%2)]."' align=right width=100><font color=black>R$ ".number_format($data[$x]['valor'], 2, ",",".")."</td>


</tr>";


if($data[$x]['pago'] > 0){
   $total_mes += $data[$x]['valor'];
}

}
$code .="
<tr>
   <td align=center colspan=2>&nbsp;</td>
   <td align=right width=100><b>Total</b></td>
   <td align=right><div id='soma_receita'><b>R$ ".number_format($total_mes, 2, ",",".")."</b></div></td>
</tr>


</table><p>";





$code .= "<div class='pagebreak'></div>";








$code .= "<table border=1 width=100% align=center>
	<tr>
	<td>
	<b>Despesas</b>
	</td>
	</tr>
	</table>
	<p>
	<P>";

if($_POST){

}

$code .= "<table border=1 width=100% align=center>
<tr>
   <td width=80 align=center><b>Vencimento</b></td>
   <td align=center><b>Título</b></td>
   <td align=center width=20><b>Forma de Pag.</b></td>
   <td align=center width=100><b>Valor</b></td>
   <!--<td align=center width=50><b>Pagamento</b></td>-->
</tr>";



$code .= "<input type=hidden name=hmes id=hmes value='{$mes}'>";
$code .= "<input type=hidden name=hano id=hano value='{$ano}'>";
$total_mes2 = 0;

$bg_color = array("#ffffff","#ffffff");
for($x=0;$x<pg_num_rows($result2);$x++){


$code .= "
<tr>
   <td bgcolor='".$bg_color[($x%2)]."' width=10 align=center><font color=black>".date("d/m/Y", strtotime($data2[$x]['vencimento']))."</td>
   <td bgcolor='".$bg_color[($x%2)]."' align=><font color=black>{$data2[$x]['titulo']}</td>

   <td bgcolor='".$bg_color[($x%2)]."' align=center width=100>
   <font color=black>{$data2[$x]['forma_pagamento']}</td>
   
   <td bgcolor='".$bg_color[($x%2)]."' align=right width=100><font color=black>R$ ".number_format($data2[$x]['valor'], 2, ",",".")."</td>


</tr>";


if($data2[$x]['pago'] > 0){
   $total_mes2 += $data2[$x]['valor'];
}

}


$total = $total_mes - $total_mes2;

if($total>=0){

$escrita = "Lucro";

}else{
	
$escrita = "Prejuízo";
	
}


$code .="
<tr>
   <td align=center colspan=2>&nbsp;</td>
   <td align=right width=100><b>Total</b></td>
   <td align=right><div id='soma_receita'><b>R$ ".number_format($total_mes2, 2, ",",".")."</b></div></td>
</tr>

<tr>
   <td align=center colspan=2>&nbsp;</td>
   <td align=right width=100><b>".$escrita."</b></td>
   <td align=right><div id='soma_receita'><b>R$ ".number_format($total, 2, ",",".")."</b></div></td>
</tr>


</table><p>";







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
	if(!is_dir("financeiro_pdf/$nome_relatorio")){  
	mkdir("financeiro_pdf/$nome_relatorio", 0700 );
	}	
    //nome do arquivo de saida PDF
    $arquivo = "REP_".$dia."_".$mes.'_'.$ano.'.pdf';
    //gera o relatorio
	//if(file_exists("repasse_pdf/$cod_clinica/$arquivo")){ 
    //unlink("repasse_pdf/$cod_clinica/$arquivo");
	//$mpdf->Output("repasse_pdf/$cod_clinica/$arquivo",'F');
	//}else{
    $mpdf->Output("financeiro_pdf/$nome_relatorio/$arquivo",'F');
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
