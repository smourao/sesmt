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




function valorPorExtenso($valor=0) {
	$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
	$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");

	$c = array("", "cem", "duzentos", "trezentos", "quatrocentos",
"quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
	$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta",
"sessenta", "setenta", "oitenta", "noventa");
	$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze",
"dezesseis", "dezesete", "dezoito", "dezenove");
	$u = array("", "um", "dois", "três", "quatro", "cinco", "seis",
"sete", "oito", "nove");

	$z=0;

	$valor = number_format($valor, 2, ".", ".");
	$inteiro = explode(".", $valor);
	for($i=0;$i<count($inteiro);$i++)
		for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
			$inteiro[$i] = "0".$inteiro[$i];

	// $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
	$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
	for ($i=0;$i<count($inteiro);$i++) {
		$valor = $inteiro[$i];
		$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
		$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
		$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

		$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd &&
$ru) ? " e " : "").$ru;
		$t = count($inteiro)-1-$i;
		$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
		if ($valor == "000")$z++; elseif ($z > 0) $z--;
		if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
		if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) &&
($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
	}

	return($rt ? $rt : "zero");
}














$cod_cliente = $_GET['cod_cliente'];
$code        = "";
$header_h    = 140;//header height;
$footer_h    = 170;//footer height;
$meses       = array('', 'Janeiro',  'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$m           = array(" ", "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");










/******************** DADOS **********************/

$sqlentrada_cliente = "SELECT c.razao_social, c.nome_fantasia, c.endereco, c.bairro, c.cep, c.municipio, c.estado, c.telefone, c.email, c.cnpj, c.nome_contato_dir, c.ano_contrato, c.num_end, sg.cod_orcamento, sg.tipo_contrato, sg.n_parcelas, sg.valor_contrato, sg.ano_orcamento, sg.data_criacao, sg.ultima_alteracao FROM cliente c, site_gerar_contrato sg WHERE c.cliente_id = sg.cod_cliente AND cliente_id = ".$cod_cliente."";
$queryentrada_cliente = pg_query($sqlentrada_cliente);
$entrada_cliente = pg_fetch_array($queryentrada_cliente);

$dadosdestratosql = "SELECT * FROM site_gerar_destrato WHERE cod_cliente = ".$cod_cliente;
$dadosdestratoquery = pg_query($dadosdestratosql);
$dadosdestrato = pg_fetch_array($dadosdestratoquery);


$sqlentrada_fatura = "SELECT cod_fatura, data_criacao FROM site_fatura_info WHERE cod_cliente = ".$cod_cliente." AND data_criacao > '1991-01-01' ORDER BY cod_fatura";
$queryentrada_fatura = pg_query($sqlentrada_fatura);
$entrada_fatura = pg_fetch_all($queryentrada_fatura);
$numentrada_fatura = pg_num_rows($queryentrada_fatura);
$numentrada_fatura = $numentrada_fatura - 1;

$primeira_fatura_num = $entrada_fatura[0][cod_fatura];
$ultima_fatura_num = $entrada_fatura[$numentrada_fatura][cod_fatura];


$valor_ultima_faturasql = "SELECT SUM(valor*quantidade) AS total FROM site_fatura_produto WHERE cod_fatura = ".$ultima_fatura_num;
$valor_ultima_faturaquery = pg_query($valor_ultima_faturasql);
$valor_ultima_faturaarray = pg_fetch_array($valor_ultima_faturaquery);
$valor_ultima_fatura = $valor_ultima_faturaarray[total];


$mesprimeirafatura = date('n', strtotime($entrada_fatura[0]["data_criacao"]));
$anoprimeirafatura = date('Y', strtotime($entrada_fatura[0]["data_criacao"]));
$diaprimeirafatura = date('d', strtotime($entrada_fatura[0]["data_criacao"]));
$mesprimeirafaturaextenso = $meses[$mesprimeirafatura];

$mesultimafatura = date('n', strtotime($entrada_fatura[$numentrada_fatura]["data_criacao"]));
$anoultimafatura = date('Y', strtotime($entrada_fatura[$numentrada_fatura]["data_criacao"]));
$diaultimafatura = date('d', strtotime($entrada_fatura[$numentrada_fatura]["data_criacao"]));
$mesultimafaturaextenso = $meses[$mesultimafatura];


$razao_social = $entrada_cliente["razao_social"];
$endereco = $entrada_cliente["endereco"];
$bairro = $entrada_cliente["bairro"];
$num_end = $entrada_cliente["num_end"];
$cep = $entrada_cliente["cep"];
$municipio = $entrada_cliente["municipio"];
$estado = $entrada_cliente["estado"];
$telefone = $entrada_cliente["telefone"];
$email_cliente = $entrada_cliente["email"];
$cnpj = $entrada_cliente["cnpj"];
$nome_contato_dir = $entrada_cliente["nome_contato_dir"];
$ano_contrato = $entrada_cliente["ano_contrato"];
$cod_orcamento = $entrada_cliente["cod_orcamento"];
$tipo_contrato = $entrada_cliente["tipo_contrato"];
$n_parcelas = $entrada_cliente["n_parcelas"];
$valor_contrato = $entrada_cliente["valor_contrato"];
$ano_orcamento = $entrada_cliente["ano_orcamento"];
$data_criacao = $entrada_cliente["data_criacao"];
$ultima_alteracao = $entrada_cliente["ultima_alteracao"];


$mescontratocriacao = date('n', strtotime($data_criacao));
$anocontratocriacao = date('Y', strtotime($data_criacao));
$diacontratocriacao = date('d', strtotime($data_criacao));
$mescontratoextenso = $meses[$mescontratocriacao];

$mespedidorescisao = date('n', strtotime($dadosdestrato["data_pedido_rescisao"]));
$anopedidorescisao = date('Y', strtotime($dadosdestrato["data_pedido_rescisao"]));
$diapedidorescisao = date('d', strtotime($dadosdestrato["data_pedido_rescisao"]));
$mespedidorescisaoextenso = $meses[$mespedidorescisao];

$mesfimrelacao = date('n', strtotime($dadosdestrato["data_fim_relacao"]));
$anofimrelacao = date('Y', strtotime($dadosdestrato["data_fim_relacao"]));
$diafimrelacao = date('d', strtotime($dadosdestrato["data_fim_relacao"]));
$mesfimrelacaoextenso = $meses[$mesfimrelacao];

$mesdestrato = date('n', strtotime($dadosdestrato["data_destrato"]));
$anodestrato = date('Y', strtotime($dadosdestrato["data_destrato"]));
$diadestrato = date('d', strtotime($dadosdestrato["data_destrato"]));
$mesdestratoextenso = $meses[$mesdestrato];


$datacontratoextenso = $diacontratocriacao." de ".$mescontratoextenso." de ".$anocontratocriacao;
$datapedidorescisao = $diapedidorescisao." de ".$mespedidorescisaoextenso." de ".$anopedidorescisao;
$datafimrelacao = $diafimrelacao." de ".$mesfimrelacaoextenso." de ".$anofimrelacao;
$dataprimeirafatura = $diaprimeirafatura." de ".$mesprimeirafaturaextenso." de ".$anoprimeirafatura;
$valorultimafatura = number_format($valor_ultima_fatura, 2, ',','.');
$valorultimafaturaextenso = ltrim(valorPorExtenso($valor_ultima_fatura));
$dataultimafatura = $diaultimafatura." de ".$mesultimafaturaextenso." de ".$anoultimafatura;
$datadestratocomexteso = $diadestrato." de ".$mesdestratoextenso." de ".$anodestrato;

$descabeca = 'DESTRATO nº.: '.$entrada_cliente['ano_contrato'].'.'.str_pad($cod_cliente, 4,"0",STR_PAD_LEFT).'';

$iddestrato = $dadosdestrato["cod_destrato"];
$numdoc = "".$iddestrato."/".$anodestrato."";
$nomedoc = "".$iddestrato."_".$anodestrato."";


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
            <b>'.$descabeca.'</b>
            </td>';
        $cabecalho .= "</tr>";
        $cabecalho .= "</table><br><br><br>";
    /************************************************************************************************************/
    // -> FOOTER
    /************************************************************************************************************/		
        $rodape .= "<table width=100% border=0>";
        $rodape .= "<tr>";
        $rodape .= "<td align=left><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Telefone: +55 (21) 3014 4304   Fax: Ramal 7</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Nextel: +55 (21) 9703 64932 - Id 35*8*16700</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=3 >faleprimeirocomagente@sesmt-rio.com / juridico@sesmt-rio.com</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >www.sesmt-rio.com</font></td><td width=15%><font face=\"Verdana, Arial, Helvetica, sans-serif\"><b>
     Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
     </td>";
        $rodape .= "</tr>";
        $rodape .= "</table>";
	
	
/*****************************************************************************************************************/
// -> CORPO
/*****************************************************************************************************************/	
	
	
	$code .= "<!DOCTYPE HTML>";	
    $code .= "<html>";
    $code .= "<head>";
	$code .= "<meta charset='utf-8'>";
    $code .= '<link href="../style.css" rel="stylesheet" type="text/css"/>';
    $code .= "</head>";
    $code .= "<body style=\"display: inline\">";

	$code .= "<div align='center'><b>DESTRATO DE PRESTAÇÃO DE SERVIÇO</b></div>";
	$code .= "<br><br>";
	
	$code .= "<p><b>".$razao_social."</b> sociedade devidamente constituída e validamente existente de acordo com as leis do Brasil, com sede na ".$endereco." ".$num_end.", ".$bairro.", ".$estado.", Tel. ".$telefone.", inscrito no CNPJ sob nº ".$cnpj.", neste ato representado em conformidade com seu contrato Social / Estatuto, daqui por diante denominada <b>CONTRATANTE</b>; e.</p>";
	
	$code .= "<p><b>SESMT – Serviços Especializados de Segurança e Monitoramento de Atividades no Trabalho Ltda</b>, sociedade devidamente constituída e validamente existente de acordo com as leis do Brasil; Inscrita no CNPJ sob nº. 04.722.248/0001-17; situada na Rua. George Bizet, 92 Jardim América; Cidade do rio de Janeiro; Estado do Rio de janeiro; neste ato representado pelo seu sócio: Pedro Henrique da Silva, doravante denominado simplesmente “<b>SESMT</b>”.</p>";

	$code .= "<p>Cada uma individualmente denominada “Parte”, e conjuntamente denominadas “Partes”.</p>";
	
	$code .= "<p><b>CONSIDERANDO QUE</b> as partes celebraram um contrato de prestação de serviços em ".$diacontratocriacao." de ".$mescontratoextenso." de ".$anocontratocriacao." (“Contrato”)</p>";
	
	$code .= "<p><b>CONSIDERANDO QUE</b> o contrato prevê na sua cláusula 6.1 e 6.2, que este contrato poderá ser rescindido de pleno direito por qualquer uma das partes, a qualquer tempo, mediante prévia notificação 30 (trinta) dias, sem pagamento de quaisquer multas ou indenizações excetos sobre parcelas vencidas e vincendas.</p>";
	
	$code .= "<p><b>CONSIDERANDO QUE</b> em ".$datapedidorescisao.", a <b>".$razao_social."</b>, contactou a SESMT e Manifestou interesse em rescindir o referido contrato a SESMT e notificou a intenção sobre a rescisão do Contrato na mesma data.</p>";
	
	$code .= "<p>As partes têm entre si, justas e acertadas celebrar o presente destrato do Contrato (Destrato), que se regerá pelas seguintes cláusulas e condições:</p>";
	
	$code .= "<p><b>CLÁUSULA PRIMEIRA</b> – As partes resolvem, em comum acordo e na melhor forma de direito, encerrar a relação contratual oriunda do contrato, tornando o mesmo sem efeito a partir de ".$datafimrelacao." (exclusive).</p>";
	
	$code .= "<p><b>CLÁUSULA SEGUNDA</b> – Não caberá á <b>".$razao_social."</b>, efetuar quaisquer pagamentos decorrentes de serviços prestados posteriormente á ".$dataprimeirafatura.", denominado de parcela(s): 1/12 e ou 1/1 a SESMT, exceto os serviços prestados anterior a esta data e não quitados ainda, devido data própria para vencimento de seus débitos conforme cláusula 4.6.</p>";
	
	$code .= "<p><b>CLÁUSULA TERCEIRA</b> – Não caberá á <b>".$razao_social."</b>, efetuar quaisquer solicitações de serviços a ser prestado pela SESMT, sem que a base desses serviços seja feita através de novo um contrato mesmo que por período de tempo pré-definido.</p>";
	
	$code .= "<p><b>PARÁGRAFO ÚNICO</b>: Fica a <b>".$razao_social."</b> notificada a designar a empresa que prestará a consultoria por força deste destrato, na pessoa do coordenador do PCMSO que assumira a responsabilidades vigentes da NR 7. A solicitar por escrito o arquivo físico a Médica coordenadora da SESMT, Drª. Maria de Lourdes Fernandes de Magalhães, CRM 52.33.471-0 Reg. MTE 13.320</p>";
	
	$code .= "<p><b>CLÁUSULA QUARTA</b> – As partes concordam que não serão realizados quaisquer pagamentos em decorrência da rescisão contratual oriunda do Contrato, renunciando expressa e irrevogavelmente a qualquer multa e/ou indenização porventura decorrente da rescisão contratual, exceto a que envolvam serviços prestados e parcelados mensalmente, conforme cláusula 4.1.</p>";
	
	$code .= "<p><b>PARÁGRAFO ÚNICO</b>: Fica acordado entre as “partes” que as parcelas referentes a cláusula 4.1 são: 12/12 em que encerra a cobrança da referida cláusula 4.1. Da boa forma desse destrato fica a CONTRATANTE que é a parte que desejou o destrato a pagalas em uma única vez a contar do trigésimo dia do comunicado de intenção do cancelamento do contrato.</p>";
	
	$code .= "<div class='pagebreak'></div>";
	
	$code .= "<p><b>CLÁUSULA QUINTA</b> – A <b>CONTRATANTE</b> pagar ou a últimas parcelas vincedas denominada 12/12 por motivo do encerramento do contrato como forma de quitação dos serviços solicitados e servidos a mesma o valor R$ ".$valorultimafatura." (".$valorultimafaturaextenso.") dia ".$dataultimafatura." através de transferência bancário.</p>";

	$code .= "<p><b>CLÁUSULA SEXTA</b> – As “Partes” neste ato, dão reciprocamente plena, rasa, irretratável e irrevogável de seus direitos e obrigações decorrentes da relação contratual oriunda do contrato, sendo que também aceitam e declaram que nada têm a reclamar quanto ao Contrato, a qualquer título e a qualquer tempo.</p>";
	
	$code .= "<p><b>CLÁUSULA SÉTIMA</b> – As Partes elegem o foro da comarca da Capital do Estado do Rio de Janeiro, para dirimir as questões decorrentes do presente Destrato, renunciando a qualquer outro, por mais privilegiado que seja.</p>";
	
	$code .= "<p>E, por estarem justas e acertadas, as Partes assinam o presente Destrato em 02 (duas) vias, de igual teor e forma, na presença das testemunhas indicadas abaixo.</p>";
	
	$code .= "<p><div align='center'>Rio de Janeiro, ".$datadestratocomexteso."</p>";
	
	$code .= "<br><br><br>";
	
	$code .= "<p><div align='center'>___________________________________________________<br><b>".$razao_social."</b></div></p>";
	$code .= "<p></p>";
	$code .= "<p><div align='center'><b>CNPJ ".$cnpj."</b><br></div></p>";
	$code .= "<p></p>";
	$code .= "<p></p>";
	$code .= "<p></p>";
	$code .= "<p><div align='center'>___________________________________________________<br><b>SESMT - Serviços Especializados de Segurança e<br> Monitoramento de Atividades no Trabalho Ltda.</b></div></p>";
	$code .= "<p></p>";
	$code .= "<p><div align='center'><b>CNPJ 04.722.248/0001-17</b><br></div></p>";
	$code .= "<p>&nbsp;</p>";
	$code .= "<p>&nbsp;</p>";
	$code .= "<p>&nbsp;</p>";
	$code .= "<p>&nbsp;</p>";
	$code .= "<p>&nbsp;</p>";
	$code .= "<table width='90%'><tr><td width='47%'>";
	$code .= "1-___________________________________________________________<br>Nome:<br>CPF:</td><td width='6%'>&nbsp;</td><td width='47%'>";
	$code .= "2-___________________________________________________________<br>Nome:<br>CPF:</td></tr></table>";
	
		

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
    $arquivo = "REP_".$iddestrato.'_'.$anodestrato.'.pdf';
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