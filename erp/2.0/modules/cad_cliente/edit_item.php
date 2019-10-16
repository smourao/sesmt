<?PHP
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
if($_POST){

	if(!empty($_POST[valor])){
		$_POST['valor'] = str_replace(".", "", $_POST['valor']);
		$_POST['valor'] = str_replace(",", ".", $_POST['valor']);
	}else{
		$_POST[valor] = "NULL";
	}

   $sql = "UPDATE site_orc_produto SET
   		  quantidade 	 = '{$_POST['quantidade']}',
		  preco_aprovado = {$_POST['valor']}
   		  WHERE id 		 = {$_GET['id']}";
   
   if(pg_query($sql)){
      showMessage('<p align=justify>Item do orçamento atualizado com sucesso.</p>');
   }else{
      showMessage('<p align=justify>Erro ao atualizar dados.</p>');
   }
}

$orc = "SELECT sop.*, p.* FROM site_orc_produto sop, produto p 
		WHERE sop.cod_produto = p.cod_prod AND sop.cod_cliente = {$_GET[cod_cliente]} AND sop.cod_orcamento = {$_GET[cod_orcamento]}
		AND sop.id = {$_GET[id]}";
$res = pg_query($orc);
$rorc = pg_fetch_array($res);

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
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Voltar' onclick=\"location.href='?dir=cad_cliente&p=edit_orc&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$_GET[cod_orcamento]}';\"  onmouseover=\"showtip('tipbox', '- Voltar, permite voltar para a edição de orçamento.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr>";
                        echo "</table>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";

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
		echo "<form method=post id='frmedititem' name='frmedititem'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'>";
        echo "<b>Editar Item do Orçamento</b>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        
        echo "<p>";
        
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr class='text roundbordermix'>";
		echo "<td align=left class='text roundborder' width=110><b>Código</b></td><td align=left class='text roundborder'>{$rorc[cod_prod]}</td>";
		echo "</tr>";
		echo "<tr class='text roundbordermix'>";
        echo "<td align=left class='text roundborder' ><b>Descrição</b></td><td align=justify class='text roundborder'><textarea style=\"width:98%;\" rows=4 readonly>{$rorc[desc_detalhada_prod]}</textarea></td>";
		echo "</tr>";
		echo "<tr class='text roundbordermix'>";
        echo "<td align=left class='text roundborder' width=20><b>Quantidade</b></td><td align=left class='text roundborder'><input type=text name=quantidade value={$rorc[quantidade]}></td>";
		echo "</tr>";
		echo "<tr class='text roundbordermix'>";
        echo "<td align=left class='text roundborder' width=60><b>Valor Padrão</b></td><td align=left class='text roundborder'><input type=text name=preco value={$rorc[preco_prod]} readonly></td>";
		echo "</tr>";
		echo "<tr class='text roundbordermix'>";
		echo "<td align=left class='text roundborder' width=60><b>Valor Alterado</b></td><td align=left class='text roundborder'><input type=text name=valor onKeyPress=\"return FormataReais(this, '.', ',', event);\" value=";
			if(!empty($rorc[preco_aprovado])){
				echo number_format($rorc[preco_aprovado], 2, ',','.');
			}else{
				echo number_format($rorc['preco_prod'], 2, ',','.');
			}
		echo "></td>";
        echo "</tr>";
        echo "</table>";
		
		echo "<p>";
		
		echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
			echo "<tr>";
			echo "<td align=left class='text'>";
				echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
				echo "<tr>";
					echo "<td align=center class='text roundbordermix'>";
					echo "<input type='submit' class='btn' name='btnSave' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
					echo "</td>";
				echo "</tr>";
				echo "</table>";
			echo "</tr>";
		echo "</table>";
		
		echo "</form>";
/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>