<?PHP
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
if($_GET[remove]){
	$del = "DELETE FROM site_orc_produto WHERE id = {$_GET[remove]}";
	pg_query($connect, $del);
	
	showmessage('Produto excluido da lista com sucesso!');
}

$orc = "SELECT sop.*, p.*, soi.* FROM site_orc_produto sop, produto p, site_orc_info soi
		WHERE sop.cod_produto = p.cod_prod AND sop.cod_cliente = {$_GET[cod_cliente]} AND sop.cod_orcamento = {$_GET[cod_orcamento]} AND soi.cod_orcamento = sop.cod_orcamento";
$res = pg_query($orc);
$rorc = pg_fetch_all($res);

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
		// OPÇÕES DO CLIENTE
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborderselected'>";
			echo "<b>Opções</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";

		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
			echo "<td class='roundbordermix text' height=30 align=left>";
				echo "<table width=100% border=0>";
				echo "<tr>";
				echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Adicionar Item' onclick=\"location.href='?dir=list_orc&p=add_item&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$_GET[cod_orcamento]}';\"  onmouseover=\"showtip('tipbox', '- Adicionar, permite adicionar um novo item no orçamento do cliente.');\" onmouseout=\"hidetip('tipbox');\"></td>";
				echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Voltar' onclick=\"location.href='?dir=list_orc&p=index';\"  onmouseover=\"showtip('tipbox', '- Voltar, permite voltar para lista de orçamentos.');\" onmouseout=\"hidetip('tipbox');\"></td>";
				echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<P>";
		
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborderselected'>";
			echo "<b>Informações do Orçamento</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		$sql = "SELECT * FROM site_orc_info WHERE cod_orcamento = '$_GET[cod_orcamento]'";
		$resu = pg_query($sql);
		$orc_info = pg_fetch_array($resu);
		
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=left class='text'><b>Prazo de Entrega:</b>&nbsp;<input type=text value='$orc_info[prazo_entrega]' id=delivery name=delivery size=1> dias.
			 <input type=button class=button value='Alterar' onClick=\"change_delivery_time( $_GET[cod_orcamento], document.getElementById('delivery').value);\" style=\"width:50px;\"></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td align=left class='text'><select name=condicao_pagamento id=condicao_pagamento onChange=\"change_condicao( $_GET[cod_orcamento], this.value);\" style=\"width:250px;\">
		   <option value=0";  if($orc_info[condicao_de_pagamento] == 0){ echo " selected "; } echo ">Condição de Pagamento - Padrão</option>
		   <option value=1";  if($orc_info[condicao_de_pagamento] == 1){ echo " selected "; } echo ">Condição de Pagamento - À vista</option>
		   <option value=2";  if($orc_info[condicao_de_pagamento] == 2){ echo " selected "; } echo ">Condição de Pagamento - À vista [50% na aprovação]</option>
		   
		   <option value=7";  if($orc_info[condicao_de_pagamento] == 7){ echo " selected "; } echo ">Condição de Pagamento - 21 Dias corridos s/Juros</option>
		   
		   <option value=8";  if($orc_info[condicao_de_pagamento] == 8){ echo " selected "; } echo ">Condição de Pagamento - 28 Dias corridos s/Juros</option>
		   
		   <option value=9";  if($orc_info[condicao_de_pagamento] == 9){ echo " selected "; } echo ">Condição de Pagamento - 40% de sinal, 30% depois de 30 dias + 30% depois de 30 dias </option>
		   
		   <option value=5";  if($orc_info[condicao_de_pagamento] == 5){ echo " selected "; } echo ">Condição de Pagamento - 2 parcelas iguais</option>
		   
		   <option value=6";  if($orc_info[condicao_de_pagamento] == 6){ echo " selected "; } echo ">Condição de Pagamento - 6 parcelas iguais</option>
		   
		   <option value=3";  if($orc_info[condicao_de_pagamento] == 3){ echo " selected "; } echo ">Condição de Pagamento - 3 parcelas iguais</option>
		   <option value=4";  if($orc_info[condicao_de_pagamento] == 4){ echo " selected "; } echo ">Condição de Pagamento - 4 parcelas iguais</option>
		   <option value=10"; if($orc_info[condicao_de_pagamento] == 10){ echo " selected "; } echo ">Condição de Pagamento - 10 parcelas + 18%</option>
		   <option value=12"; if($orc_info[condicao_de_pagamento] == 12){ echo " selected "; } echo ">Condição de Pagamento - 12 parcelas + 18%</option>
		   <option value=120"; if($orc_info[condicao_de_pagamento] == 120){ echo " selected "; } echo ">Condição de Pagamento - 12 parcelas sem juros</option>
		</select></td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<p>";

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
        echo "<b>Editar Orçamento</b>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        
        echo "<p>";
        //echo "sadgsd".$_POST[cod_prod];
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
		echo "<td align=left class='text' width=20><b>Excluir</b></td>";
		echo "<td align=left class='text' width=20><b>Cód.Prod</b></td>";
        echo "<td align=left class='text' ><b>Descrição</b></td>";
        echo "<td align=left class='text' width=20><b>Quant.</b></td>";
        echo "<td align=left class='text' width=60><b>Preço</b></td>";
		echo "<td align=left class='text' width=60><b>Total</b></td>";
        echo "</tr>";
		
		$total = 0;
        for($i=0;$i<pg_num_rows($res);$i++){
			
			if(!empty($rorc[$i][preco_aprovado])){
				$rorc[$i]['preco_prod'] = $rorc[$i][preco_aprovado];
			}
				$tota = $tota + ($rorc[$i]['quantidade']*$rorc[$i]['preco_prod']);
		    //}
		    
			echo "<tr class='text roundbordermix'>";
			echo "<td align=center class='text roundborder curhand' ><a href='?dir=list_orc&p=edit_orc&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$rorc[$i]['cod_orcamento']}&remove={$rorc[$i]['id']}' >Excluir</a></td>";
			
			
			echo "<td align=justify style='text-align:center' class='text roundborder curhand' onclick=\"location.href='?dir=list_orc&p=edit_item&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$rorc[$i]['cod_orcamento']}&id={$rorc[$i][id]}';\">{$rorc[$i]['cod_produto']}</td>";
			
			
			
            echo "<td align=justify class='text roundborder curhand' onclick=\"location.href='?dir=list_orc&p=edit_item&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$rorc[$i]['cod_orcamento']}&id={$rorc[$i][id]}';\">{$rorc[$i]['desc_resumida_prod']}</td>";
            echo "<td align=center class='text roundborder curhand' onclick=\"location.href='?dir=list_orc&p=edit_item&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$rorc[$i]['cod_orcamento']}&id={$rorc[$i][id]}';\">{$rorc[$i]['quantidade']}</td>";
            echo "<td align=center class='text roundborder curhand' onclick=\"location.href='?dir=list_orc&p=edit_item&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$rorc[$i]['cod_orcamento']}&id={$rorc[$i][id]}';\">{$rorc[$i]['preco_prod']}</td>";
			echo "<td align=center class='text roundborder curhand' onclick=\"location.href='?dir=list_orc&p=edit_item&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$rorc[$i]['cod_orcamento']}&id={$rorc[$i][id]}';\">".number_format(($rorc[$i]['quantidade']*$rorc[$i]['preco_prod']), 2, ',','.')."</td>";
            echo "</tr>";
			$total+=(($rorc[$i]['quantidade']*$rorc[$i]['preco_prod']));
        }
		
        echo "</table>";
		
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=right class='text roundborderselected'>";
        echo "<b>Total:</b>&nbsp;&nbsp;R$ ".number_format($total,2,",",".")."&nbsp;&nbsp;";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>