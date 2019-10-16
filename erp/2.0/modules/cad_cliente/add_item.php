<?PHP
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
if($_GET[cod]){
	$sql = "SELECT * FROM site_orc_produto WHERE cod_orcamento = {$cod_orcamento} AND cod_produto = {$cod}";
	$rr = pg_query($sql);
	$rsql = pg_fetch_array($rr);
	
	if(pg_num_rows($rr)){
    	if((int)($_POST[quantidade]) <=0) {
			
			$_POST[quantidade] = 1;
			
			}
		
		$iupdt = "UPDATE site_orc_produto SET
		quantidade = ".(int)($_POST[quantidade])."
		WHERE cod_orcamento = ".(int)($cod_orcamento)."
		AND cod_produto = ".(int)($cod);
		
		pg_query($iupdt);
		
	}else{
		$pdt = "SELECT * FROM produto WHERE cod_prod = {$cod}";
		$res = pg_query($pdt);
		$rush = pg_fetch_array($res);
		
	    if((int)($_POST[quantidade]) <=0){ 
		
		$_POST[quantidade] = 1;
		
		}
		
		$iinsert = "INSERT INTO site_orc_produto
		(cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
		VALUES
		({$_GET[cod_orcamento]}, {$_GET[cod_cliente]}, 0, {$_GET[cod]}, {$_POST[quantidade]}, 0, '', '$rush[preco_prod]')";
		
		pg_query($iinsert);
	}
}

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Pesquisa</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<form method=POST name='form1'>";
                    echo "<td class='roundbordermix text' height=30 align=center onmouseover=\"showtip('tipbox', '- Digite o nome do produto no campo e clique em Busca para iniciar a pesquisa.');\" onmouseout=\"hidetip('tipbox');\">";
                        echo "<input type='text' class='inputText' name='search' id='search' value='{$_POST[search]}' size=18 maxlength=500>";
                        echo "&nbsp;";
                        echo "<input type='submit' class='btn' name='btnSearch' value='Busca'>";
                    echo "</td>";
                echo "</form>";
                echo "</tr>";
                echo "</table>";
				
                echo "<P>";
                
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                	echo "<td align=center class='text roundborderselected'><b>Segmento</b></td>";
                echo "</tr>";
                echo "</table>";
                
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='roundbordermix text' height=30 align=left>";
                        echo "<table width=100% border=0>";
                        echo "<tr>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='butinc' value='Incêndio' onclick=\"location.href='?dir=cad_cliente&p=add_item&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$_GET[cod_orcamento]}&seg_id=1';\"  onmouseover=\"showtip('tipbox', '- Incêndio, permite visualizar equipamento contra incêndio.');\" onmouseout=\"hidetip('tipbox');\"></td>";
						echo "<td class='text' align=center><input type='button' class='btn' name='butepi' value='EPI' onclick=\"location.href='?dir=cad_cliente&p=add_item&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$_GET[cod_orcamento]}&seg_id=2';\"  onmouseover=\"showtip('tipbox', '- EPI, permite visualizar equipamento de proteção individual.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr>";

						echo "<tr>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='butcur' value='Cursos' onclick=\"location.href='?dir=cad_cliente&p=add_item&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$_GET[cod_orcamento]}&seg_id=3';\"  onmouseover=\"showtip('tipbox', '- Cursos, permite visualizar cursos, consultoria e assessoria.');\" onmouseout=\"hidetip('tipbox');\"></td>";
						echo "<td class='text' align=center><input type='button' class='btn' name='butsin' value='Sinalização' onclick=\"location.href='?dir=cad_cliente&p=sina&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$_GET[cod_orcamento]}&seg_id=4';\"  onmouseover=\"showtip('tipbox', '- Sinalização, permite visualizar placas de sinalização.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr>";

						echo "<tr>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='buttra' value='Dedetização' onclick=\"location.href='?dir=cad_cliente&p=add_item&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$_GET[cod_orcamento]}&seg_id=5';\"  onmouseover=\"showtip('tipbox', '- Dedetização, permite visualizar tratamento de água, dedetização e ignifugação.');\" onmouseout=\"hidetip('tipbox');\"></td>";
						echo "<td class='text' align=center><input type='button' class='btn' name='butman' value='Manutenção' onclick=\"location.href='?dir=cad_cliente&p=add_item&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$_GET[cod_orcamento]}&seg_id=6';\"  onmouseover=\"showtip('tipbox', '- Manutenção, permite visualizar manutenção de equipamentos de combate a incêndio.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='buttra' value='Exame Comp.' onclick=\"location.href='?dir=cad_cliente&p=add_item&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$_GET[cod_orcamento]}&seg_id=7';\"  onmouseover=\"showtip('tipbox', '- Exame Complementar, permite visualizar todos os exames.');\" onmouseout=\"hidetip('tipbox');\"></td>";
						
                        echo "</tr>";
                        echo "</table>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
				
                echo "<P>";
				
				echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                	echo "<td align=center class='text roundborderselected'><b>Opções</b></td>";
                echo "</tr>";
                echo "</table>";
                
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='roundbordermix text' height=30 align=left>";
                        echo "<table width=100% border=0>";
                        echo "<tr>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='butvol' value='Voltar' onclick=\"location.href='?dir=cad_cliente&p=edit_orc&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$_GET[cod_orcamento]}';\"  onmouseover=\"showtip('tipbox', '- Voltar, permite voltar para a tela de edição de orçamento.');\" onmouseout=\"hidetip('tipbox');\"></td>";
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
		
	//CONDIÇÃO QUANDO CLICADO EM ALGUM SEGMENTO
	if($_GET['seg_id']!="" && !$_POST && $_GET['seg_id']!="4"){

	$sql = "SELECT DISTINCT * FROM produto WHERE cod_atividade = {$_GET['seg_id']}";
	$result = pg_query($sql);
	$buffer = pg_fetch_all($result);

		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborderselected'>";
		echo "<b>".pg_num_rows($result)." produto(s) encontrado(s)</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";

		echo "<p>";
		
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td align=left class='text' width=20><b>Adicionar</b></td>";
		echo "<td align=left class='text'><b>Descrição</b></td>";
		echo "<td align=left class='text' width=5><b>Quant.</b></td>";
		echo "</tr>";
		
		for($i=0;$i<pg_num_rows($result);$i++){
			if($buffer[$i]['g_max'] != "" && $buffer[$i]['g_min'] !=""){
				$grup = "<br>[<b>Grupo:</b> {$buffer[$i]['g_min']} à {$buffer[$i]['g_max']}.]";
			}else{
				$grup = "";
			}
			
			echo "<form name=formqtd method=post action='?dir=cad_cliente&p=add_item&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$_GET[cod_orcamento]}&cod={$buffer[$i][cod_prod]}'>";
			echo "<tr class='text roundbordermix'>";
			echo "<td align=left class='text roundborder' ><input type='submit' class='btn' name='btnqtd' value='Adicionar' style=\"width: 60px;\"></td>";
			echo "<td align=justify class='text roundborder curhand'>{$buffer[$i]['desc_detalhada_prod']} {$grup}</td>";
			echo "<td align=left class='text roundborder' ><input type='text' name='quantidade' id='quantidade' size=3></td>";
			echo "</tr>";
			echo "</form>";	
		}
		echo "</table>";
	}
	
	//CONDIÇÃO SE A PESQUISA FOR FEITA
	if($_POST && $_POST['search']!= "" && $_GET['seg_id']!="4"){

		if(is_numeric($_POST['search'])){
			$sql = "SELECT DISTINCT * FROM produto WHERE cod_prod = {$_POST['search']} AND cod_prod not in (select cod_produto from site_orc_produto where cod_orcamento = {$_GET[cod_orcamento]})";
		}else{
			$sql = "SELECT DISTINCT * FROM produto WHERE UPPER(desc_detalhada_prod) like '%".strtoupper($_POST['search'])."%' ORDER BY desc_detalhada_prod";
		}

		$result = pg_query($sql);
		$buffer = pg_fetch_all($result);
	
		if(pg_num_rows($result) == 0){
			showmessage('Produto não existe ou já está cadastrado na lista de orçamentos do cliente.');
		}else{
			echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			echo "<tr>";
			echo "<td align=center class='text roundborderselected'>";
			echo "<b>".pg_num_rows($result)." produto(s) encontrado(s)</b>";
			echo "</td>";
			echo "</tr>";
			echo "</table>";
	
			echo "<p>";
			
			echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			echo "<tr>";
			echo "<td align=left class='text' width=20><b>Adicionar</b></td>";
			echo "<td align=left class='text'><b>Descrição</b></td>";
			echo "<td align=left class='text' width=5><b>Quant.</b></td>";
			echo "</tr>";
			
			for($i=0;$i<pg_num_rows($result);$i++){
				if($buffer[$i]['g_max'] != "" && $buffer[$i]['g_min'] !=""){
					$grup = "<br>[<b>Grupo:</b> {$buffer[$i]['g_min']} à {$buffer[$i]['g_max']}.]";
				}else{
					$grup = "";
				}
				
				echo "<form name=formqtd method=post action='?dir=cad_cliente&p=add_item&cod_cliente={$_GET[cod_cliente]}&cod_orcamento={$_GET[cod_orcamento]}&cod={$buffer[$i][cod_prod]}'>";
				echo "<tr class='text roundbordermix'>";
				echo "<td align=left class='text roundborder' ><input type='submit' class='btn' name='btnqtd' value='Adicionar' style=\"width: 60px;\"></td>";
				echo "<td align=justify class='text roundborder curhand'>{$buffer[$i]['desc_detalhada_prod']} {$grup}</td>";
				echo "<td align=left class='text roundborder' ><input type='text' name='quantidade' id='quantidade' size=3></td>";
				echo "</tr>";
				echo "</form>";	
        	}
        	echo "</table>";
		}
	}
 
/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>
