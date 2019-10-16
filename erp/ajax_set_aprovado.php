<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");
$id = $_GET[id];
$val = $_GET[value];

$sql = "UPDATE site_orc_info SET aprovado = '{$val}' WHERE cod_orcamento = $id";

if(pg_query($sql)){
    echo "1";
}else{
    echo "0";
}

/*************************************************************************************************/
// ID'S TREINAMENTOS
/*************************************************************************************************/
/*
$_CIPA = array(840, 897);
$_BRIGADA = array(982, 983, 772, 69985);//69840;"Palestra
$_CONFINADO = array(69832);//69842;"Palestra
$_SOCORROS = array(429, 430);//69838;"Palestra
$_ELETRICIDADE = array(426);//69835;"Palestra
$_EMPILHADEIRA = array(7300);
//431 - cod prod EPI
$_EPI = array(431);

$orc_n = (int)($id);


//SEND MAIL TO CLIENTE -> ORC CANCELADO
if($val == 5){
    $sql = "SELECT op.*, p.preco_prod, p.desc_detalhada_prod, p.desc_resumida_prod, p.cod_atividade
    FROM site_orc_produto op, produto p
    WHERE op.cod_orcamento={$orc_n} AND (p.cod_prod = op.cod_produto)
    ORDER BY (p.preco_prod*op.quantidade) DESC";
    $result = pg_query($sql);
    $produtos = pg_fetch_all($result);

    	$query_cli = "select
    					cliente_id
    					, razao_social
    					, endereco
    					, bairro
    					, cep
    					, cnpj
    					, insc_municipal
    					, grau_de_risco
    					, nome_contato_dir
    					, telefone
    					, email
    					, cnae_id
    					, numero_funcionarios
    					, classe
    					, num_end
    				  FROM cliente
    				  WHERE cliente_id = {$produtos[0]['cod_cliente']}";
        $r = pg_query($query_cli);
        $row = pg_fetch_array($r);

        $sql = "SELECT * FROM site_orc_info WHERE cod_orcamento = '$orc_n'";
        $resu = pg_query($sql);
        $orc_info = pg_fetch_array($resu);

        $sql = "SELECT * FROM funcionario WHERE funcionario_id = '{$orc_info['vendedor_id']}'";
        $ress = pg_query($sql);
        $vendedor = pg_fetch_array($ress);

        $headers = "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html;charset=iso-8859-1\n";//"Content-type: multipart/mixed;";
        $headers .= 'From: SESMT - Comercial <comercial@sesmt-rio.com>' . "\n" .
        'Reply-To: comercial@sesmt-rio.com' . "\n" .
        'X-Mailer: PHP/' . phpversion();

    $msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
       <HTML>
       <HEAD>
          <TITLE>Proposta Comercial</TITLE>
    <META http-equiv=Content-Type content=\"text/html; charset=iso-8859-1\">
    <META content=\"MSHTML 6.00.2900.3157\" name=GENERATOR>
    <style type=\"text/css\">
    td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
    .style2 {font-family: Verdana, Arial, Helvetica, sans-serif}
    .style13 {font-size: 14px}
    .style15 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10; }
    .style16 {font-size: 9px}
    .style17 {font-family: Arial, Helvetica, sans-serif}
    .style18 {font-size: 12px}
    </style>
       </HEAD>
       <BODY>
    <div align=\"center\">
    <table width=\"100%\" border=\"0\" cellpadding=0 cellspacing=0>
    	<tr>
    		<td align=left><img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt.png\" width=\"333\" height=\"180\" /></td>
    		<td align=\"left\"><font color=\"#006633\" face=\"Verdana, Arial, Helvetica, sans-serif\"><span class=style18>Serviços Especializados de Segurança e <br>
    		  Monitoramento de Atividades no Trabalho ltda.</span>
    		  </font><br><br>
    		  <p class=\"style18\">
    		  <p class=\"style18\"><font color=\"#006633\" face=\"Verdana, Arial, Helvetica, sans-serif\">Segurança do Trabalho e Higiene Ocupacional.</font><br><br><br><br>
    		  <p>
    		<div align=\"right\"><span class=\"style13\"><strong>Orçamento:</strong>&nbsp; </span>";
            if($produtos[0]['cod_orcamento']!=""){$msg.= str_pad($produtos[0]['cod_orcamento'], 3, "0", STR_PAD_LEFT);}
            $msg.= "/".date("Y", strtotime($orc_info[data_criacao]))."</div></td>
    	</tr>
    </table></div>
    <div align=center>
    <table width=100% border=0 cellpadding=0 cellspacing=0 >
    	<tr>
    		<td width=100% class=fontepreta12><span class=style15><strong>Cod. Cliente:</strong>&nbsp;".STR_PAD($row[cliente_id], 4, "0", STR_PAD_LEFT)."&nbsp;&nbsp;&nbsp;
    		    <strong>Nome:</strong>&nbsp;$row[razao_social]</span></td>
    	</tr>
    </table></div>
    <div align=center>
    <table width=100% border=0 cellpadding=0 cellspacing=0 >
    	<tr>
    		<td width=100% class=fontepreta12><span class=style15><strong>Endereço:</strong>&nbsp;$row[endereco]  $row[num_end]&nbsp;&nbsp;
    		    <strong>Bairro:</strong>&nbsp;$row[bairro]&nbsp;&nbsp;
    		    <strong>Cep:</strong>&nbsp;$row[cep]</span></td>
    	</tr>
    </table></div>
    <div align=center>
    <table width=100% border=0 cellpadding=0 cellspacing=0>
    	<tr>
    		<td width=100% class=fontepreta12><span class=style15><strong>CNPJ:</strong>&nbsp;$row[cnpj]&nbsp;&nbsp;
    		    <strong>I.M:</strong>&nbsp;&nbsp;$row[insc_municipal]&nbsp;&nbsp;
    		    <strong>Grau de Risco:</strong>&nbsp;$row[grau_de_risco]/$row[numero_funcionarios]</span></td>
    	</tr>
    </table></div>
    <div align=center>
    <table width=100% border=0 cellpadding=0 cellspacing=0>
    	<tr>
    		<td width=100% class=fontepreta12><span class=style15><strong>ATT:</strong> &nbsp;$row[nome_contato_dir]&nbsp;&nbsp;
    		    <strong>Telefone:</strong>&nbsp;$row[telefone]&nbsp;&nbsp;
    		    <strong>E-mail:</strong>&nbsp;$row[email]</span></td>
    	</tr>
    </table></div><br>
    <div align=center>
    <table width=100% border=1 cellpadding=0 cellspacing=0 bordercolor=\"#000000\">
    	<tr>
    		<td><span class=style16><font face=\"Verdana, Arial, Helvetica, sans-serif\">Conforme contato estabelecido com V. Sas., estamos apresentando proposta de prestação de serviços, como segue abaixo:</font></span></td>
    	</tr>
    </table></div><br>
    <div align=\"center\">
    <table width=\"100%\" border=\"0\" cellpadding=\"4\" cellspacing=\"0\" bordercolor=\"#000000\">
    	<tr>
    		<td width=\"4%\" align=\"center\" class=\"fontepreta12 style2\">Item</td>
    		<td width=\"56%\" align=\"center\" class=\"fontepreta12 style2\">Descrição do(s) Serviço(s):</td>
    		<td width=\"4%\" align=\"center\" class=\"fontepreta12 style2\">Qtd</td>
    		<td width=\"18%\" align=\"right\" class=\"fontepreta12 style2\">Preço Unitário</td>
    		<td width=\"18%\" align=\"right\" class=\"fontepreta12 style2\">Preço Total</td>
    	</tr>
       ";
          $total = 0;
          $have_aso = 0;
          $pl = array();
       for($x=0;$x<pg_num_rows($result);$x++){
           $pl[] = $produtos[$x][cod_produto];
           if(($x % 2) != 0){
              $bg = '#FFFFFF';
           }else{
              $bg = '#EEEEEE';
           }
           if(!empty($produtos[$x]['preco_aprovado'])){
               $produtos[$x]['preco_prod'] = $produtos[$x]['preco_aprovado'];
           }
           	$msg.= "<tr>";
        	$msg.= "	<td bgcolor='{$bg}' style=\"font-size:12px;\" width=\"4%\" align=center class=\"fontepreta12 style2\" valign=top>".STR_PAD(($x+1), 2, "0", STR_PAD_LEFT)."</td>";
        	$msg.= "	<td bgcolor=\"{$bg}\" style=\"font-size:12px;\" width=\"56%\" align=left class=\"fontepreta12 style2\" valign=top>".$produtos[$x]['desc_detalhada_prod']."</td>";
        	$msg.= "	<td bgcolor=\"{$bg}\" style=\"font-size:12px;\" width=\"4%\" align=center class=\"fontepreta12 style2\" valign=top>".STR_PAD($produtos[$x]['quantidade'], 3 ,"0", STR_PAD_LEFT)."</td>";
        	$msg.= "	<td bgcolor=\"{$bg}\" style=\"font-size:12px;\" width=\"18%\" align=right class=\"fontepreta12 style2\" valign=top>R$ ".number_format($produtos[$x]['preco_prod'],2,",",".")."</td>";
        	$msg.= "	<td bgcolor=\"{$bg}\" style=\"font-size:12px;\" width=\"18%\" align=right class=\"fontepreta12 style2\" valign=top>R$ ".number_format(($produtos[$x]['quantidade']*$produtos[$x]['preco_prod']),2,",",".")."</td>";
        	$msg.= "</tr>";
        	$total+=($produtos[$x]['quantidade']*$produtos[$x]['preco_prod']);

            if(@in_array($produtos[$x]['cod_produto'], $aso_id)){
                $have_aso = 1;
            }
       }

      if($x<6){
          for($y=$x;$y<=6;$y++){
           	$msg.= "<tr>";
    	    $msg.= "	<td style=\"font-size:12px;\" width=\"4%\" align=center class=\"fontepreta12 style2\" valign=top>&nbsp;</td>";
    	    $msg.= "	<td style=\"font-size:12px;\" width=\"56%\" align=center class=\"fontepreta12 style2\" valign=top>&nbsp;</td>";
    	    $msg.= "	<td style=\"font-size:12px;\" width=\"4%\" align=center class=\"fontepreta12 style2\" valign=top>&nbsp;</td>";
    	    $msg.= "	<td style=\"font-size:12px;\" width=\"18%\" align=center class=\"fontepreta12 style2\" valign=top>&nbsp;</td>";
    	    $msg.= "	<td style=\"font-size:12px;\" width=\"18%\" align=center class=\"fontepreta12 style2\" valign=top>&nbsp;</td>";
    	    $msg.= "</tr>";
          }
       }


    $msg.="	</table></div>
    <div align=\"center\">
    <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#000000\">
    	<tr>
    		<th width=\"60%\" class=\"fontepreta12\"><strong><br><br>
            <span class=\"style2\">
            {$vendedor['nome']}<br />
            Departamento Comercial<br>";

            if($vendedor['celular']!= ""){
               $msg .= $vendedor['celular']."<br>";
            }
            if($vendedor['grupo_id']!= "7"){
               $msg .= "(21) 3014 4304<br>";
            }

    $msg.="</span></strong></th>
    		<td align=\"right\" width=\"22%\" class=\"fontepreta12 style2\"><strong>TOTAL:&nbsp;&nbsp;</strong></td>
    		<td width=\"18%\" align=\"right\" class=\"fontepreta12 style2\"><strong>R$ ".number_format($total,2,",",".")."</strong></td>
    	</tr>
    </table></div>
    <div align=\"center\">
    <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
    	<tr>
    		<td width=\"70%\" align=\"justify\" class=\"fontepreta12\" style=\"font-size:12px;\"><br />
    		  <span class=\"style2\" style=\"font-size:12px;\">
              <b>Prazo de Entrega:</b>&nbsp;{$orc_info['prazo_entrega']} DIAS.<BR>
              <b>Data de Geração:</b>&nbsp;".date("d/m/Y", strtotime($orc_info['data_criacao'])).".<BR>
              <b>Validade da Proposta:</b>&nbsp;90 DIAS.
              </span>
    		  <p class=\"style2\" style=\"font-size:12px;\">
    ";
    if($_GET['orcamento']==860){
    	$msg .="	<b>Forma de pagamento:</b> 10 dias à partir da entrega.";
    }else{
    //	$msg .="	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."&nbsp;Divididos em 03 parcelas iguais de R$ ".number_format(($total/3),2,",",".")."&nbsp; ou &nbsp;R$ ".number_format($total,2,",",".")."&nbsp; acrescidos de 18% R$ ".number_format(($total+((18.0 / 100.0)*$total)),2,",",".")." dividos em 12 parcelas iguais de R$ ".number_format((($total+((18.0 / 100.0)*$total))/12),2,",",".").".";
        if($orc_info['condicao_de_pagamento'] == 0){
        	$msg .="	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."&nbsp;Divididos em 03 parcelas iguais de R$ ".number_format(($total/3),2,",",".")."&nbsp; ou &nbsp;R$ ".number_format($total,2,",",".")."&nbsp; acrescidos de 18% R$ ".number_format(($total+((18.0 / 100.0)*$total)),2,",",".")." dividos em 12 parcelas iguais de R$ ".number_format((($total+((18.0 / 100.0)*$total))/12),2,",",".").".";
        }elseif($orc_info['condicao_de_pagamento'] == 1){
        	$msg .="	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; À vista.";
        }elseif($orc_info['condicao_de_pagamento'] == 2){
        	$msg .="	<b>Forma de pagamento:</b>&nbsp;50% (R$ ".number_format(($total/2),2,",",".").") na aprovação do orçamento e 50% (R$ ".number_format(($total/2),2,",",".").") na entrega do documento.";
        }elseif($orc_info['condicao_de_pagamento'] == 3){
        	$msg .="	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; Divididos em 03 parcelas iguais de R$ ".number_format(($total/3),2,",",".").".";
        }elseif($orc_info['condicao_de_pagamento'] == 4){
        	$msg .="	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; Divididos em 04 parcelas iguais de R$ ".number_format(($total/4),2,",",".").".";
        }elseif($orc_info['condicao_de_pagamento'] == 10){
        	$msg .="	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; Acrescidos de 18% R$ ".number_format(($total+((18.0 / 100.0)*$total)),2,",",".")." divididos em 10 parcelas iguais de R$ ".number_format((($total+((18.0 / 100.0)*$total))/10),2,",",".").".";
        }elseif($orc_info['condicao_de_pagamento'] == 12){
        	$msg .="	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; Acrescidos de 18% R$ ".number_format(($total+((18.0 / 100.0)*$total)),2,",",".")." divididos em 12 parcelas iguais de R$ ".number_format((($total+((18.0 / 100.0)*$total))/12),2,",",".").".";
        }elseif($orc_info['condicao_de_pagamento'] == 120){
        	$msg .="	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; divididos em 12 parcelas iguais de R$ ".number_format(($total/12),2,",",".").".";
        }else{
        	$msg .="	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."&nbsp;Divididos em 03 parcelas iguais de R$ ".number_format(($total/3),2,",",".")."&nbsp; ou &nbsp;R$ ".number_format($total,2,",",".")."&nbsp; acrescidos de 18% R$ ".number_format(($total+((18.0 / 100.0)*$total)),2,",",".")." divididos em 12 parcelas iguais de R$ ".number_format((($total+((18.0 / 100.0)*$total))/12),2,",",".").".";
        }
    }

    $msg .= "<p class=\"style2\" style=\"font-size:12px;\"><b>";

    if($have_aso)
        $msg .= "OBS: Os exames complementares ao ASO serão solicitados automaticamente, no momento do atendimento médico de acordo com a função exercida por cada trabalhador e seu pagamento deverá ser efetuado separadamente.";

    $msg .= "</b></td>
    		<td width=\"30%\" class=\"fontepreta12\">&nbsp;</td>
    	</tr>
    </table></div>
    ";

    //***********************************************************************************************
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
    $msg .= "<BR><P><BR>";
        $msg .= "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        $msg .= "<tr>";
        $msg .= "<td colspan=4 align=center><b>EXIGÊNCIAS POR TREINAMENTO</b></td>";
        $msg .= "</tr>";

        for($q=0;$q<count($pl);$q++){
            if(($q % 2) != 0){
               $bg = '#EEEEEE';
            }else{
               $bg = '#EEEEEE';
            }
            if(in_array($pl[$q], $_BRIGADA)){
                $msg .= "<tr>";
                $msg .= "<td width=100 colspan=4 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>Treinamento de Prevenção de Brigada Contra Incêndio</b></td>";
                $msg .= "</tr>";
                $msg .= "<tr>";
                $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>SESMT</b></td>";
                $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">Apostila; Certificados da empresa e participantes; Slide; Protótipo de extintores \"vista em corte\"; Protótipo de cilindro GLP \"vista em corte\".</td>";
                $msg .= "</tr>";
                $msg .= "<tr>";
                $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>Cliente</b></td>";
                $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">Auditório para aula teórica; 03 Extintores de água (AP 10L); 02 Extintores CO2 (6Kg); 02 Extintores PQS (6Kg); Combustível - Óleo diesel e gasolina; 01 Cilindro de gás GLP (13Kg); Stand e instrutor para treinamento prático (Corpo de Bombeiros do Estado do Rio de Janeiro); Botom para participantes.</td>";
                $msg .= "</tr>";
                $msg .= "<tr>";
                $msg .= "<td width=100 colspan=4 align=center bgcolor='#FFFFFF' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>&nbsp;</b></td>";
                $msg .= "</tr>";
            }
            if(in_array($pl[$q], $_CIPA)){
                $msg .= "<tr>";
                $msg .= "<td width=100 colspan=4 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>Ministração de Curso da CIPA</b></td>";
                $msg .= "</tr>";
                $msg .= "<tr>";
                $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>SESMT</b></td>";
                $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">Apostila; Certificados da empresa e participantes; Slide.</td>";
                $msg .= "</tr>";
                $msg .= "<tr>";
                $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>Cliente</b></td>";
                $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">Auditório para aula teórica; Microcomputador; Retroprojetor USB; Caixa amplificada; Televisão; Botom para participantes.</td>";
                $msg .= "</tr>";
                $msg .= "<tr>";
                $msg .= "<td width=100 colspan=4 align=center bgcolor='#FFFFFF' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>&nbsp;</b></td>";
                $msg .= "</tr>";
            }
            if(in_array($pl[$q], $_EPI)){
                $msg .= "<tr>";
                $msg .= "<td width=100 colspan=4 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>Treinamento Sobre o Uso do EPI</b></td>";
                $msg .= "</tr>";
                $msg .= "<tr>";
                $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>SESMT</b></td>";
                $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">&nbsp;Apostila; Certificados da empresa e participantes; Slide.</td>";
                $msg .= "</tr>";
                $msg .= "<tr>";
                $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>Cliente</b></td>";
                $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">&nbsp;Auditório para aula teórica; Microcomputador; Retroprojetor USB; Caixa amplificada; Televisão.</td>";
                $msg .= "</tr>";
                $msg .= "<tr>";
                $msg .= "<td width=100 colspan=4 align=center bgcolor='#FFFFFF' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>&nbsp;</b></td>";
                $msg .= "</tr>";
            }
            if(in_array($pl[$q], $_CONFINADO)){
                $msg .= "<tr>";
                $msg .= "<td width=100 colspan=4 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>Treinamento de Prevenção em Segurança para Serviços em Espaço Confinado</b></td>";
                $msg .= "</tr>";
                $msg .= "<tr>";
                $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>SESMT</b></td>";
                $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">Apostila; Certificados da empresa e participantes; Slide.</td>";
                $msg .= "</tr>";
                $msg .= "<tr>";
                $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>Cliente</b></td>";
                $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">Auditório para aula teórica; Microcomputador; Retroprojetor USB; Caixa amplificada; Televisão; Stand para treinamento prático equipado; Botom para participantes.</td>";
                $msg .= "</tr>";
                $msg .= "<tr>";
                $msg .= "<td width=100 colspan=4 align=center bgcolor='#FFFFFF' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>&nbsp;</b></td>";
                $msg .= "</tr>";
            }
            if(in_array($pl[$q], $_SOCORROS)){
                $msg .= "<tr>";
                $msg .= "<td width=100 colspan=4 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>Treinamento da Pratica de Primeiros Socorros</b></td>";
                $msg .= "</tr>";
                $msg .= "<tr>";
                $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>SESMT</b></td>";
                $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">Apostila; Certificados da empresa e participantes; Slide.</td>";
                $msg .= "</tr>";
                $msg .= "<tr>";
                $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>Cliente</b></td>";
                $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">Auditório para aula teórica; Microcomputador; Retroprojetor USB; Caixa amplificada; Televisão; Manequim para treinamento prático; Botom para participantes.</td>";
                $msg .= "</tr>";
                $msg .= "<tr>";
                $msg .= "<td width=100 colspan=4 align=center bgcolor='#FFFFFF' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>&nbsp;</b></td>";
                $msg .= "</tr>";
            }
            if(in_array($pl[$q], $_ELETRICIDADE)){
                $msg .= "<tr>";
                $msg .= "<td width=100 colspan=4 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b> Treinamento de Prevenção de Segurança em Instalações e Serviços em Eletricidade</b></td>";
                $msg .= "</tr>";
                $msg .= "<tr>";
                $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>SESMT</b></td>";
                $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">Apostila; Certificados da empresa e participantes; Slide.</td>";
                $msg .= "</tr>";
                $msg .= "<tr>";
                $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>Cliente</b></td>";
                $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">Auditório para aula teórica; Microcomputador; Retroprojetor USB; Caixa amplificada; Televisão; Botom para participantes.</td>";
                $msg .= "</tr>";
                $msg .= "<tr>";
                $msg .= "<td width=100 colspan=4 align=center bgcolor='#FFFFFF' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>&nbsp;</b></td>";
                $msg .= "</tr>";
            }
            if(in_array($pl[$q], $_EMPILHADEIRA)){
                $msg .= "<tr>";
                $msg .= "<td width=100 colspan=4 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>Treimanto de Prevenção em Equipamento de Empilhadeira</b></td>";
                $msg .= "</tr>";
                $msg .= "<tr>";
                $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>SESMT</b></td>";
                $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">Apostila; Certificados da empresa e participantes; Slide.</td>";
                $msg .= "</tr>";
                $msg .= "<tr>";
                $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>Cliente</b></td>";
                $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">Auditório para aula teórica; Microcomputador; Retroprojetor USB; Caixa amplificada; Televisão; Equipamento de empilhadeira; Sinalização de trânsito de empilhadeira; 04 Cones; Equipamentos de proteção individual; Botom para participantes.</td>";
                $msg .= "</tr>";
                $msg .= "<tr>";
                $msg .= "<td width=100 colspan=4 align=center bgcolor='#FFFFFF' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>&nbsp;</b></td>";
                $msg .= "</tr>";
            }
        }
        $msg .= "</table>";
    }
    //***********************************************************************************************

    $msg .= "<div align=\"center\">
    <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#000000\">
    	<p>
    		<tr>
    		<td width=\"65%\" align=\"center\" class=\"fontepreta12 style2\">
    		<br /><br /><br /><br /><br /><br />
    		  <span class=\"style17\">Telefone: +55 (21) 3014-4304 &nbsp;&nbsp;Fax: Ramal 7<br />
    		  Nextel: +55 (21) 7844-9394 &nbsp;&nbsp;ID:55*23*31368 </span>
              <p class=\"style17\">
    		  faleprimeirocomagente@sesmt-rio.com / comercial@sesmt-rio.com<br />
              www.sesmt-rio.com / www.shoppingsesmt.com<br />

    	    </td>
    		<td width=\"35%\" align=\"right\">
            <img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt2.png\" width=\"280\" height=\"200\" /></td>
    	</tr>
    </table></div>
       </BODY>
    </HTML>  ";

    $headers = "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
    $headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <comercial@sesmt-rio.com> \n";

    $orc_n = str_pad($produtos[0]['cod_orcamento'], 3, "0", STR_PAD_LEFT);

    //$mail_list = explode(";", 'celso.leo@gmail.com'$_GET['mail'] $row[email]);
    $mail_list = explode(";", 'celso.leo@gmail.com');
    $ok = "";
    $er = "";

    for($x=0;$x<count($mail_list);$x++){
        if($mail_list[$x] != ""){//$mail_list[$x]
           if(mail($mail_list[$x], "Cancelamento de Orçamento Nº: {$orc_n}/".date("Y", strtotime($orc_info[data_criacao])), $msg, $headers)){
              $ok .= ", ".$mail_list[$x];
           }else{
              $er .= ", ".$mail_list[$x];
           }
        }
    }
    //mail($mail_list[$x], "Gerar Orçamento(enviado manualmente) Solicitação de Orçamento Nº: {$orc_n}/".date("Y"), $msg, $headers);
}
*/
?>
