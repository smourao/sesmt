<?PHP
$_CIPA = array(840, 897);
$_BRIGADA = array(982, 983, 772, 69985);//69840;"Palestra
$_CONFINADO = array(69832);//69842;"Palestra
$_SOCORROS = array(429, 430);//69838;"Palestra
$_ELETRICIDADE = array(426);//69835;"Palestra
$_EMPILHADEIRA = array(7300);
$_EPI = array(431);
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/



if($_POST[butInc]){
	$sql = "SELECT MAX(cod_orcamento) + 1 as cod_orcamento FROM site_orc_info";
	$r = pg_query($sql);
	$max = pg_fetch_array($r);
	
	//INSERE O ORCAMENTO NA TABELA DO SITE
	$sql = "INSERT INTO site_orc_info
	(cod_orcamento, cod_cliente, cod_filial, num_itens, data_criacao, data_aprovacao, aprovado, orc_request_time, orc_request_time_sended, vendedor_id)
	VALUES
	({$max[cod_orcamento]}, {$_GET[cod_cliente]}, 1, '0', '".date("Y/m/d")."', '".date("Y/m/d")."', '0', '".date("h:i:s")."', '0', '{$_SESSION['usuario_id']}')";
	if($result_in = pg_query($sql)){
		echo "<script>location.href='?dir={$_GET[dir]}&p={$_GET[p]}&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$max[cod_orcamento]}';</script>";
	}
}

if($_GET[del] == 1){
	$sql = "DELETE FROM site_orc_info WHERE cod_orcamento = {$_GET[orcamento]}";
	$query = pg_query($sql);
	$sql = "DELETE FROM site_orc_produto WHERE cod_orcamento = {$_GET[orcamento]}";
	$query = pg_query($sql);
}

if($_GET[orcedit] && $_POST[datacria]){
	
	$orcedit = $_GET[orcedit];
	
	
	function inverteData($novadata){
    if(count(explode("/",$novadata)) > 1){
        return implode("-",array_reverse(explode("/",$novadata)));
    }elseif(count(explode("-",$novadata)) > 1){
        return implode("/",array_reverse(explode("-",$novadata)));
    }
	}

	//$novadata = $_GET[dataedit];
	$novadata = $_POST[datacria];

	$datanova = inverteData($novadata);
	
	
	$sqldatacria = "UPDATE site_orc_info SET data_criacao='$datanova' WHERE cod_orcamento=$orcedit";
	$querydatacria = pg_query($sqldatacria);
	
	}
	
	

/***************************************************************************************************/
// --> BUSCA PELA EMPRESA PARA GERAR O CGRT E LISTA DE CGRT's
/***************************************************************************************************/
$orcamento = "SELECT * FROM site_orc_info where cod_cliente = {$_GET[cod_cliente]}";
$result = pg_query($orcamento);
$orc = pg_fetch_all($result);

//Get client
$sql = "SELECT * FROM cliente WHERE cliente_id = '{$_GET[cod_cliente]}'";
$res = pg_query($sql);
$buffer = pg_fetch_array($res);

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
    echo "<td width=250 class='text roundborder' valign=top>";
		// RESUMO DO CLIENTE
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborderselected'>";
			echo "<b>Clique em um or?amento para poder edit?-lo</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<p>";
		
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=left class='text'><b>Respons?vel:</b>&nbsp;{$buffer[nome_contato_dir]}</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td align=left class='text'><b>Telefone:</b>&nbsp;{$buffer[telefone]}</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td align=left class='text'><b>Grau de Risco:</b>&nbsp;{$buffer[grau_de_risco]}</td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<p>";
		
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
			echo "<td align=center class='text roundborderselected'><b>Op??es</b></td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
			echo "<td class='roundbordermix text' height=30 align=left>";
				echo "<form method=post>";
				echo "<table width=100% border=0>";
				echo "<tr>";
				echo "<td class='text' align=center><input type='submit' class='btn' name='butInc' value='Novo' onmouseover=\"showtip('tipbox', '- Novo, permite criar um novo or?amento.');\" onmouseout=\"hidetip('tipbox');\"></td>";
				echo "<td class='text' align=center><input type='button' class='btn' name='butVtr' value='Voltar' onclick=\"location.href='?dir=cad_cliente&p=detalhe_cliente&cod_cliente={$_GET[cod_cliente]}';\" onmouseover=\"showtip('tipbox', '- Voltar, permite voltar para o cadastro de clientes.');\" onmouseout=\"hidetip('tipbox');\"></td>";
				echo "</tr>";
				echo "</table>"; 
				echo "</form>";
			echo "</td>";
		echo "</tr>";
		echo "</table>";
	
		// --> TIPBOX
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
			echo "<td class=text height=30 valign=top align=justify>";
				echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";
			echo "</td>";
		echo "</tr>";
		echo "</table>";
    echo "</td>";

/**************************************************************************************************/
// -->  RIGHT SIDE!!!
/**************************************************************************************************/
    echo "<td class='text roundborder' valign=top>";
    	echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'>";
            echo "<b>{$buffer[razao_social]}</b>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";

		echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
		echo "<tr>";
		echo "<td align=left class='text'>";
		if(pg_num_rows($result)>0){
			echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
				echo "<tr>";
					echo "<td width=30 align=left class='text'><b>or?amento</b></td>";
					echo "<td width=40 align=left class='text'><b>Valor</b></td>";
					echo "<td width=30 align=left class='text'><b>Data Cria??o</b></td>";
					echo "<td width=40 align=left class='text'><b>Status</b></td>";
					echo "<td width=30 align=left class='text'><b>Visualizar</b></td>";
					echo "<td width=40 align=left class='text'><b>E-mail</b></td>";
					echo "<td width=30 align=left class='text'><b>Excluir</b></td>";
				echo "</tr>";
			for($x=0;$x<pg_num_rows($result);$x++){
			//BUSCA INFORMA??ES DO PRODUTO
			$sql = "SELECT op.*, p.preco_prod, p.desc_detalhada_prod, p.desc_resumida_prod, p.cod_atividade
				  FROM site_orc_produto op, produto p
				  WHERE op.cod_orcamento={$orc[$x]['cod_orcamento']} AND (p.cod_prod = op.cod_produto)";
			$r = pg_query($sql);
			$items = pg_fetch_all($r);
			$in = pg_num_rows($r);
			$total=0;
			
			for($q=0;$q<$in;$q++){
			
			if(!empty($items[$q][preco_aprovado])){
				$items[$q]['preco_prod'] = $items[$q][preco_aprovado];
			}
				$total = $total + ($items[$q]['quantidade']*$items[$q]['preco_prod']);
		    }
			
			//for($q=0;$q<$in;$q++){
				//$total = $total + ($items[$q]['quantidade']*$items[$q]['preco_aprovado']);
			//}
			
			$orcamentovaria = $orc[$x][cod_orcamento];
			$codcliente = $_GET[cod_cliente];
			
			$orccontratosql = "SELECT * FROM site_gerar_contrato WHERE cod_orcamento = $orcamentovaria AND cod_cliente = $codcliente";
			$orccontratoquery = pg_query($orccontratosql);
			$orccontratonum = pg_num_rows($orccontratoquery);
			
			
			if($orccontratonum >= 1){
				$corbg = "bgcolor='#2B8A30'" ;
			}else{
				$corbg = "bgcolor='#006633'" ;
			}
			
				echo "<tr>";
				echo "<td align=left $corbg class='text roundbordermix curhand' onclick=\"location.href='?dir=cad_cliente&p=edit_orc&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$orc[$x]['cod_orcamento']}';\">";
				echo str_pad($orc[$x][cod_orcamento], 3, '0', 0)."/".substr($orc[$x]['data_criacao'], 0, 4);
				echo "</td>";
				echo "<td align=left $corbg class='text roundbordermix curhand' onclick=\"location.href='?dir=cad_cliente&p=edit_orc&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$orc[$x]['cod_orcamento']}';\">";
				echo "R$ ".number_format($total,2,",",".");
				echo "</td>";
				
				if($_SESSION[grupo] == 'administrador'){
					
				echo "<td align=left $corbg class='text roundbordermix curhand'>";
				echo "<form action='?dir=cad_cliente&p=list_orc&cod_cliente={$_GET[cod_cliente]}&orcedit={$orc[$x][cod_orcamento]}&dataedit=$_POST[datacria]' method='post'>";
				echo "<input type='text' name='datacria' id='datacria' maxlength='10' size='6' value='".date('d/m/Y', strtotime($orc[$x]['data_criacao']))."'>";
				echo "<br><input type='submit' value='Alterar'>";
				echo "</form>";
				echo "</td>";
				
				}else{
					
				echo "<td align=left $corbg class='text roundbordermix curhand' onclick=\"location.href='?dir=cad_cliente&p=edit_orc&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$orc[$x]['cod_orcamento']}';\">";
				echo date("d/m/Y", strtotime($orc[$x]['data_criacao']));
				echo "</td>";
					
				}
				

				
				echo "<td align=left $corbg class='text roundborder'>";
					if($orc[$x]['aprovado'] != '1' && $orc[$x]['aprovado'] != '5'){
						echo "Aguardando";
						
						if($_SESSION[grupo] == 'administrador'){
						
						$numorc = $orc[$x][cod_orcamento];
						
						echo"&nbsp;<a href='?dir=cad_cliente&p=update_aprovar&cod_orc=$numorc&cod_cliente=$_GET[cod_cliente]'>";
						echo"<input type='button' name='upaprovado' id='upaprovado' value='Aprovar' onmouseover=\"showtip('tipbox', '- Aprovar o or?amento.');\" onmouseout=\"hidetip('tipbox');\">";
						echo"</a>";
						}
						
						
						
					}elseif($orc[$x]['aprovado'] == '1'){
						echo "Aprovado";
					}else{
						echo "Cancelado";
					}
				echo "</td>";
				echo "<td $corbg align=left class='text roundbordermix curhand' onmouseover=\"showtip('tipbox', 'Or?amento - Exibe o or?amento do cliente.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."orc/orcamentos/?cod_orcamento=".base64_encode((int)($orc[$x][cod_orcamento]))."')\">";
				echo "View";
				echo "</td>";
				echo "<td align=left $corbg class='text roundbordermix curhand' onmouseover=\"showtip('tipbox', 'E-mail - Envia o or?amento do cliente por e-mail.');\" onmouseout=\"hidetip('tipbox');\" onClick=\" if(mail = prompt('Digite o E-Mail que receber? o or?amento:','$buffer[email]')) { location.href='?dir=cad_cliente&p=list_orc&cod_cliente={$_GET[cod_cliente]}&orcamento={$orc[$x][cod_orcamento]}&en=1&mail='+mail+'';}\">";
					if($orc[$x][orc_request_time_sended] == '1'){
						echo "Enviado";
					}else{
						echo "Enviar";
					}
				echo "</td>";
				if($orc[$x]['aprovado'] == '0'){
				echo "<td align=left $corbg class='text roundbordermix curhand' onmouseover=\"showtip('tipbox', 'Excluir or?amento.');\" onmouseout=\"hidetip('tipbox');\" onClick=\" location.href='?dir=cad_cliente&p=list_orc&cod_cliente={$_GET[cod_cliente]}&orcamento={$orc[$x][cod_orcamento]}&del=1'\">";
						echo "Excluir";
				echo "</td>";
				}else{
				echo "<td class='text roundbordermix'></td>";
				}
				echo "</tr>";
			}
			echo "</table>";
		}
		echo "<td>";
		echo "</tr>";
		echo "</table>";

	echo "</td>";
echo "</tr>";
echo "</table>";

//***********************************************************************************************
//                                 ***  MAIL  ***
//***********************************************************************************************
if($_GET['mail']){

$orc_n = $_GET['orcamento'];

$sql = "SELECT op.*, p.*
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
    $r = @pg_query($query_cli);
    $row = @pg_fetch_array($r);

    $sql = "SELECT * FROM site_orc_info WHERE cod_orcamento = '$orc_n'";
    $resu = pg_query($sql);
    $orc_info = pg_fetch_array($resu);

    $sql = "SELECT * FROM funcionario WHERE funcionario_id = '{$orc_info['vendedor_id']}'";
    $ress = pg_query($sql);
    $vendedor = pg_fetch_array($ress);

    $headers = "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html;charset=iso-8859-1\n";//"Content-type: multipart/mixed;";
    $headers .= 'From: SESMT - Comercial <comercial@sesmt-rio.com> ' . "\n" .
    'Bcc: comercial@sesmt-rio.com' . "\n" .
    'X-Mailer: PHP/' . phpversion();
	
	
$msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
               <HTML>
               <HEAD>
                  <TITLE>Comunicado sobre o vencimento da Fatura</TITLE>
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
			   
			   
			   <table width=100% border=0>
        <tr>
        <td align='left'>
            <p><strong>
            <font size='7' face='Verdana, Arial, Helvetica, sans-serif'>SESMT<sup><font size=3>?</font></sup></font>&nbsp;&nbsp;
			<font size='1' face='Verdana, Arial, Helvetica, sans-serif'>SERVI?OS ESPECIALIZADOS DE SEGURAN?A<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
			CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></strong>
            </td>
			 <td width=40% align='right'>
            <font face='Verdana, Arial, Helvetica, sans-serif' size='4'>
            <b>&nbsp;</b>
            </td>
       
        </tr>
        </table>
		<br>
		<br>
		<br>
		<br>
		
		<div align=\"right\"><span class=\"style13\"><strong>Or?amento:</strong>&nbsp; </span>";
        if($produtos[0]['cod_orcamento']!=""){$msg.= str_pad($produtos[0]['cod_orcamento'], 3, "0", STR_PAD_LEFT);}
        $msg.= "/".date("Y", strtotime($orc_info[data_criacao]))."</div></td>
		
		<br>";
		
$msg .= "<div align=center>
<table width=100% border=0 cellpadding=0 cellspacing=0 >
	<tr>
		<td width=100% class=fontepreta12><span class=style15><strong>Cod. Cliente:</strong>&nbsp;".STR_PAD($row[cliente_id], 4, "0", STR_PAD_LEFT)."&nbsp;&nbsp;&nbsp;
		    <strong>Nome:</strong>&nbsp;$row[razao_social]</span></td>
	</tr>
</table></div>
<div align=center>
<table width=100% border=0 cellpadding=0 cellspacing=0 >
	<tr>
		<td width=100% class=fontepreta12><span class=style15><strong>Endere?o:</strong>&nbsp;$row[endereco]  $row[num_end]&nbsp;&nbsp;
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
		<td><span class=style16><font face=\"Verdana, Arial, Helvetica, sans-serif\">Conforme contato estabelecido com V. Sas., estamos apresentando proposta de presta??o de servi?os, como segue abaixo:</font></span></td>
	</tr>
</table></div><br>
<div align=\"center\">
<table width=\"100%\" border=\"0\" cellpadding=\"4\" cellspacing=\"0\" bordercolor=\"#000000\">
	<tr>
		<td width=\"4%\" align=\"center\" class=\"fontepreta12 style2\">Item</td>
		<td width=\"56%\" align=\"center\" class=\"fontepreta12 style2\">Descri??o do(s) Servi?o(s):</td>
		<td width=\"4%\" align=\"center\" class=\"fontepreta12 style2\">Qtd</td>
		<td width=\"18%\" align=\"right\" class=\"fontepreta12 style2\">Pre?o Unit?rio</td>
		<td width=\"18%\" align=\"right\" class=\"fontepreta12 style2\">Pre?o Total</td>
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
    	$msg.= "	<td bgcolor='{$bg}' style=\"font-size:12px;\" width=\"4%\" align=center class=\"fontepreta12 style2\" valign=top><font face='Verdana, Arial, Helvetica, sans-serif'>".STR_PAD(($x+1), 2, "0", STR_PAD_LEFT)."</font></td>";
    	$msg.= "	<td bgcolor=\"{$bg}\" style=\"font-size:12px;\" width=\"56%\" align=left class=\"fontepreta12 style2\" valign=top><font face='Verdana, Arial, Helvetica, sans-serif'>".$produtos[$x]['desc_detalhada_prod']."</font></td>";
    	$msg.= "	<td bgcolor=\"{$bg}\" style=\"font-size:12px;\" width=\"4%\" align=center class=\"fontepreta12 style2\" valign=top><font face='Verdana, Arial, Helvetica, sans-serif'>".STR_PAD($produtos[$x]['quantidade'], 3 ,"0", STR_PAD_LEFT)."</font></td>";
    	$msg.= "	<td bgcolor=\"{$bg}\" style=\"font-size:12px;\" width=\"18%\" align=right class=\"fontepreta12 style2\" valign=top><font face='Verdana, Arial, Helvetica, sans-serif'>R$ ".number_format($produtos[$x]['preco_prod'],2,",",".")."</font></td>";
    	$msg.= "	<td bgcolor=\"{$bg}\" style=\"font-size:12px;\" width=\"18%\" align=right class=\"fontepreta12 style2\" valign=top><font face='Verdana, Arial, Helvetica, sans-serif'>R$ ".number_format(($produtos[$x]['quantidade']*$produtos[$x]['preco_prod']),2,",",".")."</font></td>";
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
        <font face='Verdana, Arial, Helvetica, sans-serif'>{$vendedor['nome']}</font><br />
        Departamento Comercial<br>";

        if($vendedor['celular']!= ""){
           $msg .= $vendedor['celular']."<br>";
        }
        if($vendedor['grupo_id']!= "7"){
           $msg .= "(21) 3014 4304<br>";
        }

$msg.="</span></strong></th>
		<td align=\"right\" width=\"22%\" class=\"fontepreta12 style2\"><strong>TOTAL:&nbsp;&nbsp;</strong></td>
		<td width=\"18%\" align=\"right\" class=\"fontepreta12 style2\"><strong><font face='Verdana, Arial, Helvetica, sans-serif'>R$ ".number_format($total,2,",",".")."</font></strong></td>
	</tr>
</table></div>
<div align=\"center\">
<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	<tr>
		<td width=\"70%\" align=\"justify\" class=\"fontepreta12\" style=\"font-size:12px;\"><br />
		  <span class=\"style2\" style=\"font-size:12px;\">
          <font face='Verdana, Arial, Helvetica, sans-serif'><b>Prazo de Entrega:</b>&nbsp;{$orc_info['prazo_entrega']} DIAS.<BR>
          <b>Data de Gera??o:</b>&nbsp;".date("d/m/Y", strtotime($orc_info['data_criacao'])).".<BR>
          <b>Validade da Proposta:</b>&nbsp;90 DIAS.
          </font></span>
		  <p class=\"style2\" style=\"font-size:12px;\">
";
if($_GET['orcamento']==860){
	$msg .="<font face='Verdana, Arial, Helvetica, sans-serif'>	<b>Forma de pagamento:</b> 10 dias ? partir da entrega.</font>";
}else{
//	$msg .="	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."&nbsp;Divididos em 03 parcelas iguais de R$ ".number_format(($total/3),2,",",".")."&nbsp; ou &nbsp;R$ ".number_format($total,2,",",".")."&nbsp; acrescidos de 18% R$ ".number_format(($total+((18.0 / 100.0)*$total)),2,",",".")." dividos em 12 parcelas iguais de R$ ".number_format((($total+((18.0 / 100.0)*$total))/12),2,",",".").".";
    if($orc_info['condicao_de_pagamento'] == 0){
    	$msg .="<font face='Verdana, Arial, Helvetica, sans-serif'>	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."&nbsp;Divididos em 03 parcelas iguais de R$ ".number_format(($total/3),2,",",".")."&nbsp; ou &nbsp;R$ ".number_format($total,2,",",".")."&nbsp; acrescidos de 18% R$ ".number_format(($total+((18.0 / 100.0)*$total)),2,",",".")." dividos em 12 parcelas iguais de R$ ".number_format((($total+((18.0 / 100.0)*$total))/12),2,",",".").".</font>";

    }elseif($orc_info['condicao_de_pagamento'] == 1){
    	$msg .="<font face='Verdana, Arial, Helvetica, sans-serif'>	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; ? vista.</font>";

    }elseif($orc_info['condicao_de_pagamento'] == 2){
    	$msg .="<font face='Verdana, Arial, Helvetica, sans-serif'>	<b>Forma de pagamento:</b>&nbsp;50% (R$ ".number_format(($total/2),2,",",".").") na aprova??o do or?amento e 50% (R$ ".number_format(($total/2),2,",",".").") na entrega do documento.</font>";

    }elseif($orc_info['condicao_de_pagamento'] == 3){
    	$msg .="<font face='Verdana, Arial, Helvetica, sans-serif'>	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; Divididos em 03 parcelas iguais de R$ ".number_format(($total/3),2,",",".").".</font>";

    }elseif($orc_info['condicao_de_pagamento'] == 4){
    	$msg .="<font face='Verdana, Arial, Helvetica, sans-serif'>	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; Divididos em 04 parcelas iguais de R$ ".number_format(($total/4),2,",",".").".</font>";

    }elseif($orc_info['condicao_de_pagamento'] == 5){
    	$msg .="<font face='Verdana, Arial, Helvetica, sans-serif'>	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; Divididos em 02 parcelas iguais de R$ ".number_format(($total/2),2,",",".").".</font>";		
		
    }elseif($orc_info['condicao_de_pagamento'] == 6){
    	$msg .="<font face='Verdana, Arial, Helvetica, sans-serif'>	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; Divididos em 06 parcelas iguais de R$ ".number_format(($total/6),2,",",".").".</font>";

    }elseif($orc_info['condicao_de_pagamento'] == 7){
    	$msg .="<font face='Verdana, Arial, Helvetica, sans-serif'>	<b><b>Forma de pagamento:</b>&nbsp;21 dias corridos sem juros de R$ ".number_format($total,2,",",".").".</font>";

    }elseif($orc_info['condicao_de_pagamento'] == 8){
    	$msg .="<font face='Verdana, Arial, Helvetica, sans-serif'>	<b>Forma de pagamento:</b>&nbsp;28 dias corridos sem juros de R$ ".number_format($total,2,",",".").".</font>";
			
	}elseif($orc_info['condicao_de_pagamento'] == 9){
    	$msg .="<font face='Verdana, Arial, Helvetica, sans-serif'>	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; em 40% de sinal R$ ".number_format(($total*0.4),2,",",".")."&nbsp;, 30% depois de 30 dias R$ ".number_format(($total*0.3),2,",",".")."&nbsp;, mais 30% depois de 30 dias R$ ".number_format(($total*0.3),2,",",".").".</font>";
		
    }elseif($orc_info['condicao_de_pagamento'] == 10){
    	$msg .="<font face='Verdana, Arial, Helvetica, sans-serif'>	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; Acrescidos de 18% R$ ".number_format(($total+((18.0 / 100.0)*$total)),2,",",".")." divididos em 10 parcelas iguais de R$ ".number_format((($total+((18.0 / 100.0)*$total))/10),2,",",".").".</font>";

    }elseif($orc_info['condicao_de_pagamento'] == 12){
    	$msg .="<font face='Verdana, Arial, Helvetica, sans-serif'>	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; Acrescidos de 18% R$ ".number_format(($total+((18.0 / 100.0)*$total)),2,",",".")." divididos em 12 parcelas iguais de R$ ".number_format((($total+((18.0 / 100.0)*$total))/12),2,",",".").".</font>";

    }elseif($orc_info['condicao_de_pagamento'] == 120){
    	$msg .="<font face='Verdana, Arial, Helvetica, sans-serif'>	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."; divididos em 12 parcelas iguais de R$ ".number_format(($total/12),2,",",".").".</font>";

    }else{
    	$msg .="<font face='Verdana, Arial, Helvetica, sans-serif'>	<b>Forma de pagamento:</b>&nbsp;R$ ".number_format($total,2,",",".")."&nbsp;Divididos em 03 parcelas iguais de R$ ".number_format(($total/3),2,",",".")."&nbsp; ou &nbsp;R$ ".number_format($total,2,",",".")."&nbsp; acrescidos de 18% R$ ".number_format(($total+((18.0 / 100.0)*$total)),2,",",".")." divididos em 12 parcelas iguais de R$ ".number_format((($total+((18.0 / 100.0)*$total))/12),2,",",".").".</font>";
    }
}

$msg .= "<p class=\"style2\" style=\"font-size:12px;\"><b>";

if($have_aso)
    $msg .= "OBS: Os exames complementares ao ASO ser?o solicitados automaticamente, no momento do atendimento m?dico de acordo com a fun??o exercida por cada trabalhador e seu pagamento dever? ser efetuado separadamente.";

$msg .= "</b></td>
		<td width=\"30%\" class=\"fontepreta12\">&nbsp;</td>
	</tr>
</table></div>
";

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
$msg .= "<BR><P><BR>";
    $msg .= "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    $msg .= "<tr>";
    $msg .= "<td colspan=4 align=center><b>EXIG?NCIAS POR TREINAMENTO</b></td>";
    $msg .= "</tr>";

    for($q=0;$q<count($pl);$q++){
        if(($q % 2) != 0){
           $bg = '#EEEEEE';
        }else{
           $bg = '#EEEEEE';
        }
        if(in_array($pl[$q], $_BRIGADA)){
            $msg .= "<tr>";
            $msg .= "<td width=100 colspan=4 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>Treinamento de Preven??o de Brigada Contra Inc?ndio</b></td>";
            $msg .= "</tr>";
            $msg .= "<tr>";
            $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>SESMT</b></td>";
            $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">Apostila; Certificados da empresa e participantes; Slide; Prot?tipo de extintores \"vista em corte\"; Prot?tipo de cilindro GLP \"vista em corte\".</td>";
            $msg .= "</tr>";
            $msg .= "<tr>";
            $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>Cliente</b></td>";
            $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">Audit?rio para aula te?rica; 03 Extintores de ?gua (AP 10L); 02 Extintores CO2 (6Kg); 02 Extintores PQS (6Kg); Combust?vel - ?leo diesel e gasolina; 01 Cilindro de g?s GLP (13Kg); Stand e instrutor para treinamento pr?tico (Corpo de Bombeiros do Estado do Rio de Janeiro); Botom para participantes.</td>";
            $msg .= "</tr>";
            $msg .= "<tr>";
            $msg .= "<td width=100 colspan=4 align=center bgcolor='#FFFFFF' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>&nbsp;</b></td>";
            $msg .= "</tr>";
        }
        if(in_array($pl[$q], $_CIPA)){
            $msg .= "<tr>";
            $msg .= "<td width=100 colspan=4 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>Ministra??o de Curso da CIPA</b></td>";
            $msg .= "</tr>";
            $msg .= "<tr>";
            $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>SESMT</b></td>";
            $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">Apostila; Certificados da empresa e participantes; Slide.</td>";
            $msg .= "</tr>";
            $msg .= "<tr>";
            $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>Cliente</b></td>";
            $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">Audit?rio para aula te?rica; Microcomputador; Retroprojetor USB; Caixa amplificada; Televis?o; Botom para participantes.</td>";
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
            $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">&nbsp;Audit?rio para aula te?rica; Microcomputador; Retroprojetor USB; Caixa amplificada; Televis?o.</td>";
            $msg .= "</tr>";
            $msg .= "<tr>";
            $msg .= "<td width=100 colspan=4 align=center bgcolor='#FFFFFF' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>&nbsp;</b></td>";
            $msg .= "</tr>";
        }
        if(in_array($pl[$q], $_CONFINADO)){
            $msg .= "<tr>";
            $msg .= "<td width=100 colspan=4 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>Treinamento de Preven??o em Seguran?a para Servi?os em Espa?o Confinado</b></td>";
            $msg .= "</tr>";
            $msg .= "<tr>";
            $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>SESMT</b></td>";
            $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">Apostila; Certificados da empresa e participantes; Slide.</td>";
            $msg .= "</tr>";
            $msg .= "<tr>";
            $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>Cliente</b></td>";
            $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">Audit?rio para aula te?rica; Microcomputador; Retroprojetor USB; Caixa amplificada; Televis?o; Stand para treinamento pr?tico equipado; Botom para participantes.</td>";
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
            $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">Audit?rio para aula te?rica; Microcomputador; Retroprojetor USB; Caixa amplificada; Televis?o; Manequim para treinamento pr?tico; Botom para participantes.</td>";
            $msg .= "</tr>";
            $msg .= "<tr>";
            $msg .= "<td width=100 colspan=4 align=center bgcolor='#FFFFFF' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>&nbsp;</b></td>";
            $msg .= "</tr>";
        }
        if(in_array($pl[$q], $_ELETRICIDADE)){
            $msg .= "<tr>";
            $msg .= "<td width=100 colspan=4 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b> Treinamento de Preven??o de Seguran?a em Instala??es e Servi?os em Eletricidade</b></td>";
            $msg .= "</tr>";
            $msg .= "<tr>";
            $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>SESMT</b></td>";
            $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">Apostila; Certificados da empresa e participantes; Slide.</td>";
            $msg .= "</tr>";
            $msg .= "<tr>";
            $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>Cliente</b></td>";
            $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">Audit?rio para aula te?rica; Microcomputador; Retroprojetor USB; Caixa amplificada; Televis?o; Botom para participantes.</td>";
            $msg .= "</tr>";
            $msg .= "<tr>";
            $msg .= "<td width=100 colspan=4 align=center bgcolor='#FFFFFF' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>&nbsp;</b></td>";
            $msg .= "</tr>";
        }
        if(in_array($pl[$q], $_EMPILHADEIRA)){
            $msg .= "<tr>";
            $msg .= "<td width=100 colspan=4 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>Treimanto de Preven??o em Equipamento de Empilhadeira</b></td>";
            $msg .= "</tr>";
            $msg .= "<tr>";
            $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>SESMT</b></td>";
            $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">Apostila; Certificados da empresa e participantes; Slide.</td>";
            $msg .= "</tr>";
            $msg .= "<tr>";
            $msg .= "<td width=100 align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>Cliente</b></td>";
            $msg .= "<td colspan=3 align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">Audit?rio para aula te?rica; Microcomputador; Retroprojetor USB; Caixa amplificada; Televis?o; Equipamento de empilhadeira; Sinaliza??o de tr?nsito de empilhadeira; 04 Cones; Equipamentos de prote??o individual; Botom para participantes.</td>";
            $msg .= "</tr>";
            $msg .= "<tr>";
            $msg .= "<td width=100 colspan=4 align=center bgcolor='#FFFFFF' class='fontepreta12 style2'  style=\"font-size:12px;\"><b>&nbsp;</b></td>";
            $msg .= "</tr>";
        }
    }
    $msg .= "</table>";
}
/***********************************************************************************************/

$msg .= "
		<br>
		<br>
		<br>
		<br>
		<br>


		<table width=100% border=0>
        <tr>
        <td align=left width=88%><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Telefone: +55 (21) 3014 4304   Fax: Ramal 7</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Nextel: +55 (21) 9700 31385 - Id 55*23*31641</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=3 >faleprimeirocomagente@sesmt-rio.com / financeiro@sesmt-rio.com</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >www.sesmt-rio.com</font></td><td width=12%><font face=\"Verdana, Arial, Helvetica, sans-serif\"><b>
     Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
     </td>
       </tr>
        </table>

               </body></html>";

//$headers .= "MIME-Version: 1.0\n";
//$headers .= "Content-type: text/html; charset=iso-8859-1\n";
//$headers .= "From: SESMT - Seguran?a do Trabalho e Higiene Ocupacional. <webmaster@sesmt-rio.com> \n";

$orc_n = str_pad($produtos[0]['cod_orcamento'], 3, "0", STR_PAD_LEFT);
//PARA -> $row[email]
$mail_list = $_GET['mail'];
$ok = "";
$er = "";

}
	if($_GET['en'] == 1){
		//for($z=0;$z<count($mail_list);$z++){
			//if($mail_list[$z] != ""){//$mail_list[$x]
			   if(mail($mail_list, "Solicita??o de Or?amento N?: {$orc_n}/".date("Y", strtotime($orc_info[data_criacao])), $msg, $headers)){
			   		$sql = "UPDATE site_orc_info SET orc_request_time_sended = 1 WHERE cod_orcamento = '".$orc_n."'";
					$resu = pg_query($sql);
				   echo "<script>alert('E-Mails enviado para".$ok."'); </script>";
				  $ok .= ", ".$mail_list;
			   }else{
				  $er .= ", ".$mail_list;
			   }
			//}
		//}
	/*	if(mail($mail_list, "Gerar Or?amento(enviado manualmente) Solicita??o de Or?amento N?: {$orc_n}/".date("Y"), $msg, $headers)){
			
			$sql = "UPDATE site_orc_info SET orc_request_time_sended = 1 WHERE cod_orcamento = '".$orc_n."'";
			$resu = pg_query($sql);
		}else{
			echo "<script>alert('Erro ao enviar E-mail para".$er."');</script>";
		} */
	}

?>