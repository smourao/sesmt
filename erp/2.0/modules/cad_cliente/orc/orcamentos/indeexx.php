<?PHP
/*****************************************************************************************************************/
// -> INCLUDES / DEFINES
/*****************************************************************************************************************/
define('_MPDF_PATH', '../../../../common/MPDF45/');
define('_IMG_PATH', '../../../../images/');
include(_MPDF_PATH.'mpdf.php');
include("../../../../common/database/conn.php");
/*************************************************************************************************/
// ID'S TREINAMENTOS
/*************************************************************************************************/
$_CIPA = array(840, 897);
$_BRIGADA = array(982, 983, 772, 69985, 70246);//69840;"Palestra
$_CONFINADO = array(69832);//69842;"Palestra
$_SOCORROS = array(429, 430);//69838;"Palestra
$_ELETRICIDADE = array(426);//69835;"Palestra
$_EMPILHADEIRA = array(7300);
$_EPI = array(431);

/*****************************************************************************************************************/
// -> VARS
/*****************************************************************************************************************/
$cod_orcamento = (int)(base64_decode($_GET[cod_orcamento]));
$code     = "";
$header_h = 175;//header height;
$footer_h = 170;//footer height;
$meses    = array('', 'Janeiro',  'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$m        = array(" ", "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");
/*****************************************************************************************************************/
// -> CLIENTE INFO
/*****************************************************************************************************************/
$sql = "SELECT c.*, cnae.*, s.* FROM cliente c, cnae cnae, site_orc_info s WHERE c.cliente_id = s.cod_cliente AND c.cnae_id = cnae.cnae_id AND s.cod_orcamento = $cod_orcamento";
$rci = pg_query($sql);
$info = pg_fetch_array($rci);

/*****************************************************************************************************************/
// -> VENDEDOR INFO
/*****************************************************************************************************************/
$sql = "SELECT * FROM funcionario WHERE funcionario_id = $info[vendedor_id]";
$res = pg_query($sql);
$vendedor = pg_fetch_array($res);

/*****************************************************************************************************************/
// -> PRODUTO INFO
/*****************************************************************************************************************/
$sql = "SELECT op.*, p.* FROM site_orc_produto op, produto p WHERE op.cod_orcamento = $cod_orcamento 
AND (p.cod_prod = op.cod_produto) ORDER BY (p.preco_prod*op.quantidade) DESC";
$result = pg_query($sql);
$produtos = pg_fetch_all($result);


/*****************************************************************************************************************/
// -> CARGO INFO
/*****************************************************************************************************************/
$sql = "SELECT nome FROM cargo WHERE cargo_id = $vendedor[cargo_id]";
$cargoquery = pg_query($sql);
$cargoarray = pg_fetch_array($cargoquery);

/*****************************************************************************************************************/
// -> BEGIN DOCUMENT
/*****************************************************************************************************************/
ob_start();
    /*************************************************************************************************************/
    // -> HEADER
    /*************************************************************************************************************/
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
       // $cabecalho .= "<td align=center height=$header_h width=130 valign=top class='medText'><br><br><h2>Orçamento</h2></td>";
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
        $rodape .= "<td align=left height=$footer_h valign=bottom class='medText'><h3>Telefone: +55 (21) 3014 4304      Fax: Ramal 7<br>Nextel: +55 (21) 9700 31385 / Id 55*23*31641<br>comercial@sesmt-rio.com<br>www.sesmt-rio.com</h3></td>";
        $rodape .= "<td align=left height=$footer_h width=130 valign=bottom><h2>Pensando em<br>
renovar seus<br>
programas?<br>
Fale primeiro<br>
com a gente!</h2></td>";
        $rodape .= "</tr>";
        $rodape .= "</table>";
    }
    $code .= "<html>";
    $code .= "<head>";
    $code .= '<link href="../style.css" rel="stylesheet" type="text/css"/>';
    $code .= "</head>";
    $code .= "<body>";

/****************************************************************************************************************/
// -> PAGE [1]
/****************************************************************************************************************/
    $code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$code .= "<tr>";
	$code .= "<td align=right><b>Orçamento:</b> {$info[cod_orcamento]}/".date("Y", strtotime($info[data_criacao]))."</td>";
	$code .= "</tr>";
	$code .= "</table>";
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
    $code .= "<tr>";
	$code .= "<td align=left width=25%><b>Cód.Cliente:</b> {$info[cliente_id]}</td>";
	$code .= "<td align=left><b>Nome:</b> {$info[razao_social]}</td>";
	$code .= "</tr>";
	$code .= "</table>";
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$code .= "<tr>";
	$code .= "<td align=left><b>Endereço:</b> {$info[endereco]}&nbsp;<b>Nº:</b> {$info[num_end]}</td>";
	$code .= "<td align=left><b>Bairro:</b> {$info[bairro]}</td>";
	$code .= "<td align=left><b>Município:</b> {$info[municipio]}</td>";
	$code .= "<td align=left width=15%><b>CEP:</b> {$info[cep]}</td>";
	$code .= "</tr>";
	$code .= "</table>";
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$code .= "<tr>";
	$code .= "<td align=left width=25%><b>CNPJ:</b> {$info[cnpj]}</td>";
	$code .= "<td align=left width=25%><b>I.M:</b> {$info[insc_municipal]}</td>";
	$code .= "<td align=left><b>Grau de Risco:</b> {$info[grau_de_risco]}/{$info[numero_funcionarios]}</td>";
	$code .= "</tr>";
	$code .= "</table>";
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$code .= "<tr>";
	$code .= "<td align=left width=25%><b>Att:</b> {$info[nome_contato_dir]}</td>";
	$code .= "<td align=left width=25%><b>Telefone:</b> {$info[telefone]}</td>";
	$code .= "<td align=left><b>E-mail:</b> {$info[email]}</td>";
	$code .= "</tr>";
	$code .= "</table>";
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$code .= "<tr>";
	$code .= "<td align=left>Conforme contato estabelecido com V. Sa., estamos apresentando proposta de prestação de serviços, como segue abaixo:</td>";
	$code .= "</tr>";
	$code .= "</table>";
	
	$code .= "<br>";
	
	$code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
	$code .= "<tr>";
	$code .= "<td align=center width=5% bgcolor='#EEEEEE'><b>Item</b></td>";
	$code .= "<td align=center width=64% bgcolor='#EEEEEE'><b>Descrição do(s) Serviço(s)</b></td>";
	$code .= "<td align=center width=5% bgcolor='#EEEEEE'><b>Qtd</b></td>";
	$code .= "<td align=center width=13% bgcolor='#EEEEEE'><b>Preço Unitário</b></td>";
	$code .= "<td align=center width=13% bgcolor='#EEEEEE'><b>Preço Total</b></td>";
	$code .= "</tr>";
	
	$total = 0;
    $have_aso = 0;
	$pl = array();

	for($x=0;$x<pg_num_rows($result);$x++){
	$pl[] = $produtos[$x][cod_produto];
       if(!empty($produtos[$x]['preco_aprovado'])){
           $produtos[$x]['preco_prod'] = $produtos[$x]['preco_aprovado'];
       }
       	$code .= "<tr>";
    	$code .= "	<td align=center>".STR_PAD(($x+1), 2, "0", STR_PAD_LEFT)."</td>";
    	$code .= "	<td align=justify>".$produtos[$x]['desc_detalhada_prod']."</td>";
    	$code .= "	<td align=center>".STR_PAD($produtos[$x]['quantidade'], 3 ,"0", STR_PAD_LEFT)."</td>";
    	$code .= "	<td align=right>R$ ".number_format($produtos[$x]['preco_prod'],2,",",".")."</td>";
    	$code .= "	<td align=right>R$ ".number_format(($produtos[$x]['quantidade']*$produtos[$x]['preco_prod']),2,",",".")."</td>";
    	$code .= "</tr>";
    	$total+=($produtos[$x]['quantidade']*$produtos[$x]['preco_prod']);
		
		if($produtos[$x]['cod_produto'] == 891 || $produtos[$x]['cod_produto'] == 893 || $produtos[$x]['cod_produto'] == 895 || $produtos[$x]['cod_produto'] == 928 || $produtos[$x]['cod_produto'] == 929 || $produtos[$x]['cod_produto'] == 930 || $produtos[$x]['cod_produto'] == 931 || $produtos[$x]['cod_produto'] == 932 ){
            $have_aso = 1;
        }
	}
	
	$code .= "</table>";
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$code .= "<tr>";
	if($vendedor[assinatura]==""){
		$code .= "<td align=center>
		<br>
		<br>
		<br>
		<br>
		<b>____________________________________<br>
        {$vendedor['nome']}<br />
        Departamento Comercial<br>";
	}else{
	$code .= "<td align=center><b>
		<br>
		<br>
		<br>
		<br>
	<img src='{$vendedor[assinatura]}' border=0 width=100 height=50><br>
        {$vendedor['nome']}<br />
        Departamento Comercial<br>";
	}
        if($vendedor['celular']!= ""){
		   if($vendedor['grupo_id']== "7"){
              $code .= $vendedor['celular']."<br>";
		   }else{
		      if($vendedor['funcionario_id']== "23"){
			     $code .= "(21) 7844-9394<br>";
			  }else{
                 $code .= $vendedor['celular']."<br>";
			  }
		   }
        }
        if($vendedor['grupo_id']!= "7"){
           $code .= "(21) 3014-4304<br>";
        } 
	$code .= "</b></td>";
	$code .= "<td align=right width=22%><b>TOTAL:&nbsp;&nbsp;</b></td>";
	$code .= "<td width=18% align=right><b>R$ ".number_format($total,2,",",".")."</b></td>";
	$code .= "</tr>";
	$code .= "</table>";
	
	$code .= "<br>";
	
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$code .= "<tr>";
	$code .= "<td align=left><b>Prazo de Entrega:</b>&nbsp;{$info['prazo_entrega']} DIAS.<br>
          <b>Data de Geração:</b>&nbsp;".date("d/m/Y", strtotime($info['data_criacao'])).".<br>
          <b>Validade da Proposta:</b>&nbsp;90 DIAS.</td>";
	$code .= "</tr>";
    $code .= "</table>";
	
	$code .= "<br>";
	
	if($_GET['cod_orcamento']==860){
	$code .="	<b>Forma de pagamento:</b> 10 dias à partir da entrega.";
}else{
    if($info['condicao_de_pagamento'] == 0){
    	$code .="	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."&nbsp;Divididos em 03 parcelas iguais de R$ ".number_format(($total/3),2,",",".")."&nbsp; ou &nbsp;R$ ".number_format($total,2,",",".")."&nbsp; acrescidos de 18% R$ ".number_format(($total+((18.0 / 100.0)*$total)),2,",",".")." dividos em 12 parcelas iguais de R$ ".number_format((($total+((18.0 / 100.0)*$total))/12),2,",",".").".";
    }elseif($info['condicao_de_pagamento'] == 1){
    	$code .="	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; À vista.";
    }elseif($info['condicao_de_pagamento'] == 2){
    	$code .="	<b>Forma de pagamento:</b>&nbsp;50% (R$ ".number_format(($total/2),2,",",".").") na aprovação do orçamento e 50% (R$ ".number_format(($total/2),2,",",".").") na entrega do documento.";
		
		
	}elseif($info['condicao_de_pagamento'] == 5){
    	$code .="	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; Divididos em 02 parcelas iguais de R$ ".number_format(($total/2),2,",",".").".";		
		
		
    }elseif($info['condicao_de_pagamento'] == 3){
    	$code .="	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; Divididos em 03 parcelas iguais de R$ ".number_format(($total/3),2,",",".").".";
    }elseif($info['condicao_de_pagamento'] == 4){
    	$code .="	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; Divididos em 04 parcelas iguais de R$ ".number_format(($total/4),2,",",".").".";
    }elseif($info['condicao_de_pagamento'] == 10){
    	$code .="	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; Acrescidos de 18% R$ ".number_format(($total+((18.0 / 100.0)*$total)),2,",",".")." divididos em 10 parcelas iguais de R$ ".number_format((($total+((18.0 / 100.0)*$total))/10),2,",",".").".";
    }elseif($info['condicao_de_pagamento'] == 12){
    	$code .="	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; Acrescidos de 18% R$ ".number_format(($total+((18.0 / 100.0)*$total)),2,",",".")." divididos em 12 parcelas iguais de R$ ".number_format((($total+((18.0 / 100.0)*$total))/12),2,",",".").".";
    }elseif($info['condicao_de_pagamento'] == 120){
    	$code .="	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; divididos em 12 parcelas iguais de R$ ".number_format(($total/12),2,",",".").".";
		
		}elseif($info['condicao_de_pagamento'] == 6){
    	$code .="	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; Divididos em 06 parcelas iguais de R$ ".number_format(($total/6),2,",",".").".";
		
		
		}elseif($info['condicao_de_pagamento'] == 7){
    	$code .="	<b>Forma de pagamento:</b>&nbsp;21 dias corridos sem juros de R$ ".number_format($total,2,",",".").".";
		
		
		}elseif($info['condicao_de_pagamento'] == 8){
    	$code .="	<b>Forma de pagamento:</b>&nbsp;28 dias corridos sem juros de R$ ".number_format($total,2,",",".").".";
		
		
		}elseif($info['condicao_de_pagamento'] == 9){
    	$code .="	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; em 40% de sinal R$ ".number_format(($total*0.4),2,",",".")."&nbsp;, 30% depois de 30 dias R$ ".number_format(($total*0.3),2,",",".")."&nbsp;, mais 30% depois de 30 dias R$ ".number_format(($total*0.3),2,",",".").".";
		
		
		
    }else{
    	$code .="	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."&nbsp;Divididos em 03 parcelas iguais de R$ ".number_format(($total/3),2,",",".")."&nbsp; ou &nbsp;R$ ".number_format($total,2,",",".")."&nbsp; acrescidos de 18% R$ ".number_format(($total+((18.0 / 100.0)*$total)),2,",",".")." divididos em 12 parcelas iguais de R$ ".number_format((($total+((18.0 / 100.0)*$total))/12),2,",",".").".";
    }
}

$code .= "<P align=justify>";

if($have_aso)
    $code .= "<b>OBS: Os exames complementares ao ASO serão solicitados automaticamente, no momento do atendimento médico de acordo com a função exercida por cada trabalhador e seu pagamento deverá ser efetuado separadamente.</b>";

$code .= "<p>";
/***********************************************************************************************/
$tc = 0;
for($w=0;$w<count($pl);$w++){
    if(in_array($pl[$w], $_BRIGADA)){
        $tc = 1;
    }
    if(in_array($pl[$w], $_CIPA)){
        $tc = 1;
    }
    if(in_array($pl[$w], $_EPI)){
        $tc = 1;
    }
    if(in_array($pl[$w], $_CONFINADO)){
        $tc = 1;
    }
    if(in_array($pl[$w], $_SOCORROS)){
        $tc = 1;
    }
    if(in_array($pl[$w], $_ELETRICIDADE)){
        $tc = 1;
    }
    if(in_array($pl[$w], $_EMPILHADEIRA)){
        $tc = 1;
    }
}
if($tc){
    $code .= "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    $code .= "<tr>";
    $code .= "<td colspan=4 align=center><b>EXIGÊNCIAS POR TREINAMENTO</b></td>";
    $code .= "</tr>";
	for($q=0;$q<count($pl);$q++){
        if(in_array($pl[$q], $_BRIGADA)){
            $code .= "<tr>";
            $code .= "<td width=100 colspan=2 align=center bgcolor='#EEEEEE'><b>Treinamento de Prevenção de Brigada Contra Incêndio</b></td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td width=100 align=center bgcolor='#EEEEEE'><b>SESMT</b></td>";
            $code .= "<td align=justify bgcolor='#EEEEEE'>&nbsp;Apostila; Certificados da empresa e participantes; Slide; Protótipo de extintores \"vista em corte\"; Protótipo de cilindro GLP \"vista em corte\".</td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td width=100 align=center bgcolor='#EEEEEE'><b>Cliente</b></td>";
            $code .= "<td align=justify bgcolor='#EEEEEE'>&nbsp;Auditório para aula teórica; 03 Extintores de água (AP 10L); 02 Extintores CO2 (6Kg); 02 Extintores PQS (6Kg); Combustível - Óleo diesel e gasolina; 01 Cilindro de gás GLP (13Kg); Stand e instrutor para treinamento prático (Corpo de Bombeiros do Estado do Rio de Janeiro); Botom para participantes.</td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td width=100 colspan=2 align=center bgcolor='#FFFFFF'><b>&nbsp;</b></td>";
            $code .= "</tr>";
        }
        if(in_array($pl[$q], $_CIPA)){
            $code .= "<tr>";
            $code .= "<td width=100 colspan=2 align=center bgcolor='#EEEEEE'><b>Ministração de Curso da CIPA</b></td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td width=100 align=center bgcolor='#EEEEEE'><b>SESMT</b></td>";
            $code .= "<td align=justify bgcolor='#EEEEEE'>&nbsp;Apostila; Certificados da empresa e participantes; Slide.</td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td width=100 align=center bgcolor='#EEEEEE'><b>Cliente</b></td>";
            $code .= "<td align=justify bgcolor='#EEEEEE'>&nbsp;Auditório para aula teórica; Microcomputador; Retroprojetor USB; Caixa amplificada; Televisão; Botom para participantes.</td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td width=100 colspan=2 align=center bgcolor='#FFFFFF'><b>&nbsp;</b></td>";
            $code .= "</tr>";
        }
        if(in_array($pl[$q], $_EPI)){
            $code .= "<tr>";
            $code .= "<td width=100 colspan=2 align=center bgcolor='#EEEEEE'><b>Treinamento Sobre o Uso do EPI</b></td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td width=100 align=center bgcolor='#EEEEEE'><b>SESMT</b></td>";
            $code .= "<td align=justify bgcolor='#EEEEEE'>&nbsp;Apostila; Certificados da empresa e participantes; Slide.</td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td width=100 align=center bgcolor='#EEEEEE'><b>Cliente</b></td>";
            $code .= "<td align=justify bgcolor='#EEEEEE'>&nbsp;Auditório para aula teórica; Microcomputador; Retroprojetor USB; Caixa amplificada; Televisão.</td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td width=100 colspan=2 align=center bgcolor='#FFFFFF'><b>&nbsp;</b></td>";
            $code .= "</tr>";
        }
        if(in_array($pl[$q], $_CONFINADO)){
            $code .= "<tr>";
            $code .= "<td width=100 colspan=2 align=center bgcolor='#EEEEEE'><b>Treinamento de Prevenção em Segurança para Serviços em Espaço Confinado</b></td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td width=100 align=center bgcolor='#EEEEEE'><b>SESMT</b></td>";
            $code .= "<td align=justify bgcolor='#EEEEEE'>&nbsp;Apostila; Certificados da empresa e participantes; Slide.</td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td width=100 align=center bgcolor='#EEEEEE'><b>Cliente</b></td>";
            $code .= "<td align=justify bgcolor='#EEEEEE'>&nbsp;Auditório para aula teórica; Microcomputador; Retroprojetor USB; Caixa amplificada; Televisão; Stand para treinamento prático equipado; Botom para participantes.</td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td width=100 colspan=2 align=center bgcolor='#FFFFFF'><b>&nbsp;</b></td>";
            $code .= "</tr>";
        }
        if(in_array($pl[$q], $_SOCORROS)){
            $code .= "<tr>";
            $code .= "<td width=100 colspan=2 align=center bgcolor='#EEEEEE'><b>Treinamento da Pratica de Primeiros Socorros</b></td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td width=100 align=center bgcolor='#EEEEEE'><b>SESMT</b></td>";
            $code .= "<td align=justify bgcolor='#EEEEEE'>&nbsp;Apostila; Certificados da empresa e participantes; Slide.</td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td width=100 align=center bgcolor='#EEEEEE'><b>Cliente</b></td>";
            $code .= "<td align=justify bgcolor='#EEEEEE'>&nbsp;Auditório para aula teórica; Microcomputador; Retroprojetor USB; Caixa amplificada; Televisão; Manequim para treinamento prático; Botom para participantes.</td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td width=100 colspan=2 align=center bgcolor='#FFFFFF'><b>&nbsp;</b></td>";
            $code .= "</tr>";
        }
        if(in_array($pl[$q], $_ELETRICIDADE)){
            $code .= "<tr>";
            $code .= "<td width=100 colspan=2 align=center bgcolor='#EEEEEE'><b> Treinamento de Prevenção de Segurança em Instalações e Serviços em Eletricidade</b></td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td width=100 align=center bgcolor='#EEEEEE'><b>SESMT</b></td>";
            $code .= "<td align=justify bgcolor='#EEEEEE'>&nbsp;Apostila; Certificados da empresa e participantes; Slide.</td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td width=100 align=center bgcolor='#EEEEEE'><b>Cliente</b></td>";
            $code .= "<td align=justify bgcolor='#EEEEEE'>&nbsp;Auditório para aula teórica; Microcomputador; Retroprojetor USB; Caixa amplificada; Televisão; Botom para participantes.</td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td width=100 colspan=2 align=center bgcolor='#FFFFFF'><b>&nbsp;</b></td>";
            $code .= "</tr>";
        }
        if(in_array($pl[$q], $_EMPILHADEIRA)){
            $code .= "<tr>";
            $code .= "<td width=100 colspan=2 align=center bgcolor='#EEEEEE'><b>Treimanto de Prevenção em Equipamento de Empilhadeira</b></td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td width=100 align=center bgcolor='#EEEEEE'><b>SESMT</b></td>";
            $code .= "<td align=justify bgcolor='#EEEEEE'>&nbsp;Apostila; Certificados da empresa e participantes; Slide.</td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td width=100 align=center bgcolor='#EEEEEE'><b>Cliente</b></td>";
            $code .= "<td align=justify bgcolor='#EEEEEE'>&nbsp;Auditório para aula teórica; Microcomputador; Retroprojetor USB; Caixa amplificada; Televisão; Equipamento de empilhadeira; Sinalização de trânsito de empilhadeira; 04 Cones; Equipamentos de proteção individual; Botom para participantes.</td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td width=100 colspan=2 align=center bgcolor='#FFFFFF'><b>&nbsp;</b></td>";
            $code .= "</tr>";
        }
	}
    $code .= "</table>";
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
		
		if(!is_dir("PDF/".$info[cliente_id]."")){  
			mkdir("PDF/".$info[cliente_id]."", 0700 );
		}
		
		//nome do arquivo de saida PDF
		$arquivo = "ORC_".$cod_orcamento.'.pdf';
		
		
		
			//gera o relatorio
			if($info[orc_request_time_sended] != 0 || $info[aprovado] != 0){
				if(file_exists("PDF/".$info[cliente_id]."/$arquivo")){
					$mpdf->Output("$arquivo",'I');
				}else{
					$mpdf->Output("PDF/".$info[cliente_id]."/$arquivo",'F');
					$mpdf->Output("PDF/".$info[cliente_id]."/$arquivo",'I');
				}
			}else{
				$mpdf->Output("PDF/".$info[cliente_id]."/$arquivo",'F');
				$mpdf->Output("PDF/".$info[cliente_id]."/$arquivo",'I');
			}
		
	/*
	
	
				//gera o relatorio
			if($info[orc_request_time_sended] != 0 || $info[aprovado] != 0){
				$mpdf->Output("PDF/".$info[cliente_id]."/$arquivo",'I');
			}else{
				$mpdf->Output("PDF/".$info[cliente_id]."/$arquivo",'F');
				$mpdf->Output("$arquivo",'I');
			}



	
    $arquivo = $cod_orcamento.'_'.date("ymdhis").'.pdf';
    //gera o relatorio
    if($_GET[out] == 'D'){
        $mpdf->Output($arquivo,'D');
    }else{
        $mpdf->Output($arquivo,'I');
    }
    
    I: send the file inline to the browser. The plug-in is used if available. The name given by filename is used when one selects the "Save as" option on the link generating the PDF.
    D: send to the browser and force a file download with the name given by filename.
    F: save to a local file with the name given by filename (may include a path).
    S: return the document as a string. filename is ignored.
    */
    exit();
?>