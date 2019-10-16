<?php
session_start();
include "config/connect.php";
$orc = $_GET['orcamento'];

function convertwords($text){
$siglas = array("ppp", "ppra", "pcmso", "aso", "cipa", "apgre", "ltcat", "epi", "pca",//Siglas normais
				"ppp,", "ppra,", "pcmso,", "aso,", "cipa,", "apgre,", "ltcat,", "epi,", "pca,", //Siglas com vírgula
				"(ppp)", "(ppra)", "(pcmso)", "(aso)", "(cipa)", "(apgre)", "(ltcat)", "(epi)", "(pca)", //Siglas entre parênteses
				"nr", "nr.", "mr", "mr.", "in", "in.", "nbr", "nbr.", "a0", "a3", "a4", "(a4)"); //Siglas diversas
$at = explode(" ", $text);
$temp = "";
for($x=0;$x<count($at);$x++){
   $at[$x] = strtolower($at[$x]);

  if(in_array($at[$x], $siglas)){
     $at[$x] = strtoupper($at[$x]);
  }elseif(strlen($at[$x])>3){
        $at[$x] = ucwords($at[$x]);
    }

    $temp .= $at[$x]." ";
}
return $temp;
}

if($_GET['del']){
include "sessao.php";
   if($_GET['orcamento'] && $_GET['cod_cliente']){
      $sql = "DELETE FROM site_orc_pc_produto WHERE cod_orcamento = {$_GET['orcamento']}
      AND cod_cliente = {$_GET['cod_cliente']}";

      if(pg_query($sql)){

      }else{
          echo "<script>alert('Erro ao excluir produtos de orçamento.');</script>";
      }

      $sql = "DELETE FROM site_orc_pc_info WHERE cod_orcamento = {$_GET['orcamento']}
      AND cod_cliente = {$_GET['cod_cliente']}";

      if(pg_query($sql)){
          header("Location: cria_orcamento_pc_index.php");
      }else{
          echo "<script>alert('Erro ao excluir orçamento.');</script>";
      }

   }
}


if($_GET['act']=="preview"){
$orc_n = $_GET['orcamento'];

$sql = "SELECT op.*, p.preco_prod, p.desc_detalhada_prod, p.desc_resumida_prod, p.cod_atividade
FROM site_orc_pc_produto op, produto p
WHERE op.cod_orcamento={$orc_n} AND (p.cod_prod = op.cod_produto)
ORDER BY op.id
";
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
				  FROM cliente_pc
				  WHERE cliente_id = {$produtos[0]['cod_cliente']}";
    $r = pg_query($query_cli);
    $row = pg_fetch_array($r);

    $sql = "SELECT * FROM site_orc_pc_info WHERE cod_orcamento = '$orc_n'";
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
    $sql = "SELECT * FROM ";
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
        $msg.= "/2009</div></td>
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
		<td width=100% class=fontepreta12><span class=style15><strong>Endereço:</strong>&nbsp;$row[endereco] $row[num_end]&nbsp;&nbsp;
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
   for($x=0;$x<pg_num_rows($result);$x++){
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
	$msg.= "	<td bgcolor=\"{$bg}\" style=\"font-size:12px;\" width=\"56%\" align=left class=\"fontepreta12 style2\" valign=top>".convertwords($produtos[$x]['desc_detalhada_prod'])."</td>";
	$msg.= "	<td bgcolor=\"{$bg}\" style=\"font-size:12px;\" width=\"4%\" align=center class=\"fontepreta12 style2\" valign=top>".STR_PAD($produtos[$x]['quantidade'], 3 ,"0", STR_PAD_LEFT)."</td>";
	$msg.= "	<td bgcolor=\"{$bg}\" style=\"font-size:12px;\" width=\"18%\" align=right class=\"fontepreta12 style2\" valign=top>R$ ".number_format($produtos[$x]['preco_prod'],2,",",".")."</td>";
	$msg.= "	<td bgcolor=\"{$bg}\" style=\"font-size:12px;\" width=\"18%\" align=right class=\"fontepreta12 style2\" valign=top>R$ ".number_format(($produtos[$x]['quantidade']*$produtos[$x]['preco_prod']),2,",",".")."</td>";
	$msg.= "</tr>";
	$total+=($produtos[$x]['quantidade']*$produtos[$x]['preco_prod']);
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
        <img src='{$vendedor[assinatura]}' border=0 width=100 height=50><br>
        {$vendedor['nome']}<br />
        Departamento Comercial<br>";

        if($vendedor['celular']!= ""){
		   if($vendedor['grupo_id']== "7"){
              $msg .= $vendedor['celular']."<br>";
		   }else{
		      if($vendedor['funcionario_id']== "23"){
			     $msg .= "(21) 7844-9394<br>";
			  }else{
                 $msg .= $vendedor['celular']."<br>";
			  }
		   }
        }
        if($vendedor['grupo_id']!= "7"){
           $msg .= "(21) 3014-4304<br>";
        }

$msg.="</span></strong>
        </th>
		<td align=\"right\" width=\"22%\" class=\"fontepreta12 style2\"><strong>TOTAL:&nbsp;&nbsp;</strong></td>
		<td width=\"18%\" align=\"right\" class=\"fontepreta12 style2\"><strong>R$ ".number_format($total,2,",",".")."</strong></td>
	</tr>
</table></div>
<div align=\"center\">
<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	<tr>
		<td width=\"70%\" align=\"justify\" class=\"fontepreta12\"><br />
		  <span class=\"style2 fontepreta12\" style=\"font-size:12px;\">
          <b>Prazo de Entrega:</b>&nbsp;15 DIAS.<br>
          <b>Data de Geração:</b>&nbsp;".date("d/m/Y", strtotime($orc_info['data_criacao'])).".<br>
          <b>Validade da Proposta:</b>&nbsp;90 DIAS.
          </span>

		  <p class=\"style2 fontepreta12\" style=\"font-size:12px;\">
";
if($_GET['orcamento']==860){
	$msg .="	<b>Forma de pagamento:</b> 10 dias à partir da entrega.";
}else{

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
}else{
	$msg .="	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."&nbsp;Divididos em 03 parcelas iguais de R$ ".number_format(($total/3),2,",",".")."&nbsp; ou &nbsp;R$ ".number_format($total,2,",",".")."&nbsp; acrescidos de 18% R$ ".number_format(($total+((18.0 / 100.0)*$total)),2,",",".")." divididos em 12 parcelas iguais de R$ ".number_format((($total+((18.0 / 100.0)*$total))/12),2,",",".").".";
}

}

$msg .= "        <p class=\"style2 fontepreta12\" style=\"font-size:12px;\">
		<b>OBS: Os exames complementares ao ASO serão solicitados automaticamente, no momento do atendimento médico de acordo com a função exercida por cada trabalhador e seu pagamento deverá ser efetuado separadamente.</b></td>
		<td width=\"30%\" class=\"fontepreta12\">&nbsp;</td>
	</tr>
</table></div>
<div align=\"center\">
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
echo $msg;
}

//***********************************************************************************************
//                                 ***  MAIL  ***
//***********************************************************************************************
if($_GET['mail']){
include "sessao.php";
$orc_n = $_GET['orcamento'];

$sql = "SELECT op.*, p.preco_prod, p.desc_detalhada_prod, p.desc_resumida_prod, p.cod_atividade
FROM site_orc_pc_produto op, produto p
WHERE op.cod_orcamento={$orc_n} AND (p.cod_prod = op.cod_produto)";
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
				  FROM cliente_pc
				  WHERE cliente_id = {$produtos[0]['cod_cliente']}";
    $r = pg_query($query_cli);
    $row = pg_fetch_array($r);

    $sql = "SELECT * FROM site_orc_pc_info WHERE cod_orcamento = '$orc_n'";
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
        $msg.= "/2009</div></td>
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
   for($x=0;$x<pg_num_rows($result);$x++){
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
	$msg.= "	<td bgcolor=\"{$bg}\" style=\"font-size:12px;\" width=\"56%\" align=left class=\"fontepreta12 style2\" valign=top>".convertwords($produtos[$x]['desc_detalhada_prod'])."</td>";
	$msg.= "	<td bgcolor=\"{$bg}\" style=\"font-size:12px;\" width=\"4%\" align=center class=\"fontepreta12 style2\" valign=top>".STR_PAD($produtos[$x]['quantidade'], 3 ,"0", STR_PAD_LEFT)."</td>";
	$msg.= "	<td bgcolor=\"{$bg}\" style=\"font-size:12px;\" width=\"18%\" align=right class=\"fontepreta12 style2\" valign=top>R$ ".number_format($produtos[$x]['preco_prod'],2,",",".")."</td>";
	$msg.= "	<td bgcolor=\"{$bg}\" style=\"font-size:12px;\" width=\"18%\" align=right class=\"fontepreta12 style2\" valign=top>R$ ".number_format(($produtos[$x]['quantidade']*$produtos[$x]['preco_prod']),2,",",".")."</td>";
	$msg.= "</tr>";
	$total+=($produtos[$x]['quantidade']*$produtos[$x]['preco_prod']);
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
          <b>Prazo de Entrega:</b>&nbsp;15 DIAS.<BR>
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
}else{
	$msg .="	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."&nbsp;Divididos em 03 parcelas iguais de R$ ".number_format(($total/3),2,",",".")."&nbsp; ou &nbsp;R$ ".number_format($total,2,",",".")."&nbsp; acrescidos de 18% R$ ".number_format(($total+((18.0 / 100.0)*$total)),2,",",".")." divididos em 12 parcelas iguais de R$ ".number_format((($total+((18.0 / 100.0)*$total))/12),2,",",".").".";
}


}

$msg .= "               <p class=\"style2\" style=\"font-size:12px;\">
		<b>OBS: Os exames complementares ao ASO serão solicitados automaticamente, no momento do atendimento médico de acordo com a função exercida por cada trabalhador e seu pagamento deverá ser efetuado separadamente.</b></td>
		<td width=\"30%\" class=\"fontepreta12\">&nbsp;</td>
	</tr>
</table></div>
<div align=\"center\">
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
//PARA -> $row[email]
$mail_list = explode(";", $_GET['mail']);
$ok = "";
$er = "";

for($x=0;$x<count($mail_list);$x++){
if($mail_list[$x] != ""){//$mail_list[$x]
   if(mail($mail_list[$x], "Solicitação de Orçamento Nº: {$orc_n}/".date("Y"), $msg, $headers)){
      $ok .= ", ".$mail_list[$x];
   }else{
      $er .= ", ".$mail_list[$x];
   }
}
}
mail($mail_list[$x], "Gerar Orçamento(enviado manualmente) Solicitação de Orçamento Nº: {$orc_n}/".date("Y"), $msg, $headers);
echo "<script>alert('E-Mails enviado para".$ok."');</script>";
if($er != ""){
   echo "<script>alert('Erro ao enviar E-mail para".$er."');</script>";
}
 $sql = "UPDATE site_orc_pc_info SET orc_request_time_sended = 1 WHERE cod_orcamento = '$orc_n'";
 $resu = pg_query($sql);
/*
if(mail($row[email], "Solicitação de Orçamento Nº: {$orc_n}", $msg, $headers)){
   echo "<script>alert('E-mail enviado com sucesso!');</script>";
}else{
   echo "<script>alert('Erro ao enviar e-mail!');</script>";
}
*/
}
//***********************************************************************************************
//***********************************************************************************************


if($_GET['act'] == "new"){
include "sessao.php";
            //CHECA MAX ID
            $sql = "SELECT MAX(cod_orcamento)as cod_orcamento FROM site_orc_info";
		    $r = pg_query($sql);
		    $max = pg_fetch_array($r);

		    $sql = "SELECT MAX(cod_orcamento) as cod_orcamento FROM orcamento";
		    $r2 = pg_query($sql);
		    $max2 = pg_fetch_array($r2);

		    $sql = "SELECT MAX(cod_orcamento) as cod_orcamento FROM site_orc_pc_info";
		    $r3 = pg_query($sql);
		    $max3 = pg_fetch_array($r3);

            $row_cod[cod_orcamento] = 0;

		    if($max[cod_orcamento] > $max2[cod_orcamento]){
    		    $row_cod[cod_orcamento] = $max[cod_orcamento];
		    }else{
    		    $row_cod[cod_orcamento] = $max2[cod_orcamento];
		    }

		    if($max3[cod_orcamento] > $row_cod[cod_orcamento]){
                $row_cod[cod_orcamento] = $max3[cod_orcamento]+1;
		    }else{
                $row_cod[cod_orcamento] += 1;
		    }


   $sql = "INSERT INTO site_orc_pc_info
   (cod_orcamento, cod_cliente, cod_filial, num_itens, data_criacao, aprovado, vendedor_id)
   VALUES
   ('{$row_cod[cod_orcamento]}', '".$_GET['cod_cliente']."', '{$_GET['cod_filial']}', 0, '".date("Y-m-d")."',4, {$_SESSION['usuario_id']})
   ";
   $result = pg_query($sql);
  //$result=1;

   if($result){
      header("Location: ?act=edit&cod_cliente={$_GET['cod_cliente']}&cod_filial={$_GET['cod_filial']}&orcamento=".$row_cod[cod_orcamento]."");
   }else{
      echo "<script>alert('Erro ao adicionar novo orçamento! Por favor, tente novamente.');</script>";
   }

}
if($_GET['act'] != "preview"){
?>
<html>
<head>
<title>Orçamento</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="orc_pc.js"></script>
<script language="javascript" src="scripts.js"></script>
<style type="text/css" title="mystyles" media="all">
<!--
loading{
display: block;
position: relative;
left: 0px;
top: 60px;
width:0px;
height:0px;
color: #888000;
z-index:1;
}

loading_done{
position: relative;
display: none;
}
-->
</style>
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
      <input type=hidden name=orca id=orca value="<?PHP echo $_GET['orcamento'];?>">
      <input type=hidden name=cod_cliente id=cod_cliente value="<?PHP echo $_GET['cod_cliente'];?>">
      <input type=hidden name=cod_filial id=cod_filial value="<?PHP echo $_GET['cod_filial'];?>">
<p>
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="700" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="5" class="linhatopodiresq" bgcolor="#009966"><br>TELA DE CRIAÇÃO DE ORÇAMENTO<br>&nbsp;</th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="5">
			<br>&nbsp;
				<input name="btn_sair" type="button" id="btn_sair" onClick="location.href='cria_orcamento_pc_index.php'" value="Voltar" style="width:100;">
			<br>&nbsp;
			</th>
		</tr>
	</tr>
	<tr>
      <td height="26" colspan="5" class="linhatopodiresq">

<?PHP
if($_GET['act'] == "edit"){
include "sessao.php";
echo "
<script>
//CHAMAR FUNÇÃO PRA ATUALIZAR LISTAS
update_orcamento();
</script>
";
$orc_n = $_GET['orcamento'];

$sql = "SELECT op.*, p.preco_prod, p.desc_detalhada_prod, p.desc_resumida_prod, p.cod_atividade
FROM site_orc_pc_produto op, produto p
WHERE op.cod_orcamento={$orc_n} AND (p.cod_prod = op.cod_produto)";
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
				  FROM cliente_pc
				  WHERE cliente_id = {$_GET['cod_cliente']}";
    $r = pg_query($query_cli);
    $row = pg_fetch_array($r);
?>
<form name="segmentos">
<Table width=100% border=1 cellspacing=5 cellpading=2>
<tr>
   <td width=20><b>Segmento:</b> </td>
   <td valign=top align=center>
       <input type=radio id="segmento" name="segmento" onclick="window.find.location.href='find_item.php?seg_id=1'">
   <br><font size=1>Equipamento contra incêndio</font></td>
   <td valign=top align=center>
       <input type=radio id="segmento" name="segmento" onclick="window.find.location.href='find_item.php?seg_id=2'">
   <br><font size=1>Equipamento de proteção individual</font></td>
   <td valign=top align=center>
       <input type=radio id="segmento" name="segmento" onclick="window.find.location.href='find_item.php?seg_id=3'">
   <br><font size=1>Cursos, consultoria e assessoria</font></td>
   <td valign=top align=center>
       <input type=radio id="segmento" name="segmento" onclick="window.find.location.href='find_item.php?seg_id=4'">
   <br><font size=1>Sinalização</font></td>
   <td valign=top align=center>
       <input type=radio id="segmento" name="segmento" onclick="window.find.location.href='find_item.php?seg_id=5'">
   <br><font size=1>Tratamento de água, dedetização e ignifugação</font></td>
   <td valign=top align=center>
       <input type=radio id="segmento" name="segmento" onclick="window.find.location.href='find_item.php?seg_id=6'">
   <br><font size=1>Manutenção de equip. de combate a incêndio</font></td>
</tr>
</table>
</form>
<p>
<center>
<!--
<input type=button class=button value="Agendar Envio" onclick="agendar_orcamento('<?PHP echo $_GET['orcamento'];?>', prompt('Insira a data para o envio: (dd/mm/YYYY)','<?PHP echo date("d/m/Y");?>'));">
-->
<input type=button class=button value="Enviar por E-Mail" onclick="if(mail = prompt('Digite o E-Mail que receberá o orçamento:','<?PHP echo $row['email'];?>')){location.href='<?PHP echo "?mail='+mail+'&act=edit&cod_cliente={$_GET['cod_cliente']}&cod_filial={$_GET['cod_filial']}&orcamento={$_GET['orcamento']}";?>'};">
<input type=button class=button value="Excluir Orçamento" onclick="if(confirm('Tem certeza que deseja excluir este orçamento?')){location.href='<?PHP echo "?del=do&act=edit&cod_cliente={$_GET['cod_cliente']}&cod_filial={$_GET['cod_filial']}&orcamento={$_GET['orcamento']}";?>'}">
<input type=button class=button value="Visualizar Orçamento" onclick="location.href='<?PHP echo "?act=preview&cod_cliente={$_GET['cod_cliente']}&cod_filial={$_GET['cod_filial']}&orcamento={$_GET['orcamento']}";?>'">
<p>
<input type=button class=button value="Redefinir Layout" onclick="
if(1==1){
   document.getElementById('dataz').style.display = 'block';
   document.getElementById('buscaz').style.display = 'block';
   document.getElementById('maint').width = '100%';
   document.getElementById('dataz').width = '100%';
   document.getElementById('find').width = '250px';
   document.getElementById('buscaz').width = '250px';
   document.getElementById('bz').width = '100%';
}
;">

<input type=button id=sho class=button value="Exibir Pesquisa" onclick="
if(document.getElementById('dataz').style.display != 'none'){
   document.getElementById('dataz').style.display = 'none';
   document.getElementById('sho').value = 'Exibir Orçamento';
   document.getElementById('buscaz').width = '100%';
   document.getElementById('buscaz').style.display = 'block';
   document.getElementById('find').width = '100%';
}else{
   document.getElementById('sho').value = 'Exibir Pesquisa';
   document.getElementById('dataz').style.display ='block';
   document.getElementById('buscaz').width = '38%';
   document.getElementById('buscaz').style.display = 'none';
   document.getElementById('find').width = '250px';
};
">
<?PHP
    $sql = "SELECT * FROM site_orc_pc_info WHERE cod_orcamento = '$orc_n'";
    $resu = pg_query($sql);
    $orc_info = pg_fetch_array($resu);
?>

<select name=condicao_pagamento id=condicao_pagamento onchange="change_condicao(<?PHP echo $orc_n;?>, this.value);">
   <option value=0  <?PHP if($orc_info[condicao_de_pagamento] == 0){ echo " selected ";}?>>Condição de Pagamento - Padrão</option>
   <option value=1  <?PHP if($orc_info[condicao_de_pagamento] == 1){ echo " selected ";}?>>Condição de Pagamento - À vista</option>
   <option value=2  <?PHP if($orc_info[condicao_de_pagamento] == 2){ echo " selected ";}?>>Condição de Pagamento - À vista [50% na aprovação]</option>
   <option value=3  <?PHP if($orc_info[condicao_de_pagamento] == 3){ echo " selected ";}?>>Condição de Pagamento - 3 parcelas iguais</option>
   <option value=4  <?PHP if($orc_info[condicao_de_pagamento] == 4){ echo " selected ";}?>>Condição de Pagamento - 4 parcelas iguais</option>
   <option value=10 <?PHP if($orc_info[condicao_de_pagamento] == 10){ echo " selected ";}?>>Condição de Pagamento - 10 parcelas + 18%</option>
   <option value=12 <?PHP if($orc_info[condicao_de_pagamento] == 12){ echo " selected ";}?>>Condição de Pagamento - 12 parcelas + 18%</option>
</select>


<p>
<Table width=100% border=0 cellspacing=2 cellpading=5 id=maint>
<tr>
   <td valign=top id=ls>
   <!-- LEFT -->
      <table border=0 width=100% id=dataz>
         <tr>
            <td align=center style="position:static;">
          <!--  <input type=button value="Atualizar" onclick="update_orcamento();" class="button">-->
               <div id="orc_loading" class="loading" height=0>
                  <center><font size=1>
                  <!-- Atualizando dados, aguarde... -->
                  <img src="loading.gif" width=25 height=25 border=0>
                  </font></center>
               </div>
               <div id="dados">
               </div>
            </td>
         </tr>
      </table>
   </td>

   <td width=38% valign=top id=buscaz name=buscaz>
   <!-- RIGHT -->
      <table border=0 width=100% id=bz>
         <tr>
            <td width=100% height=220>
               <iframe name="find" id="find" src="find_item_pc.php" width=100% height=100% frameborder=0>erro</iframe>
            </td>
         </tr>
      </table>
   </td>

     <!-- CONTEÚDO -->
     <table width="500" border="0" align="center">
        <tr>
          <td width="100%" align=right>
              <div id="lista_orcamentos">
              </div>
          </td>
        </tr>
     </table>

<?PHP
}
}
?>
	 </td>
    </tr>
</table>
</body>
</html>

