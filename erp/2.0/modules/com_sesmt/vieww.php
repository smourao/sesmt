<?PHP
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Selecione uma opção</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
				
				echo "<table border=0 cellpadding=2 cellspacing=3 width=100%><tbody>";
				echo "<tr><td class=roundbordermix text align=left height=30>";
				
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnCad' value='Voltar' onclick=\"location.href='?dir=com_sesmt&p=index';\"  onmouseover=\"showtip('tipbox', '- Voltar para lista de colaboradores.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                    echo "<td class='text' height=30 align=center><input type='button' class='btn' name='btnReg' value='Repasse CGRT' onclick=\"location.href='?dir=com_sesmt&p=cgrt';\"  onmouseover=\"showtip('tipbox', '- Permite alterar o registro do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
					echo "<td class='text' align=center></td>";

                echo "</tr>";
								
                echo "</table>";
				echo "</td></tr></tbody></table><br />";
				
				
				$query_func = "SELECT f.*, u.* FROM funcionario f, usuario u WHERE f.funcionario_id = u.funcionario_id AND f.funcionario_id <> 18 AND u.funcionario_id <> 18 AND f.status = 1 ORDER BY f.nome";
				$result_func = pg_query($connect, $query_func);
				$list = pg_fetch_all($result_func);
			
				echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
				echo "<tr>";
				echo "<td align=left class='text'><b>Lista de funcionários:</b></td>";
				echo "</tr>";
				for($i=0;$i<pg_num_rows($result_func);$i++){
					if($list[$i][funcionario_id] == $_GET[funcionario_id]){
						$bg = "bgcolor=#228B22'";				
					}else{
						$bg = "";
					}
					echo "<tr class='text roundbordermix'>";
					echo "<td align=left $bg class='text roundborder curhand' onclick=\"location.href='?dir=com_sesmt&p=view&funcionario_id={$list[$i]['funcionario_id']}';\" alt='Clique aqui para editar' title='Clique aqui para editar'>{$list[$i]['nome']}&nbsp;</td>";
					echo "</tr>";
				}
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

$sql = "SELECT * FROM cliente c, site_orc_info i WHERE c.vendedor_id = '".$_GET[funcionario_id]."' AND i.vendedor_id = '".$_GET[funcionario_id]."' AND c.vendedor_id = i.vendedor_id AND c.cliente_id = i.cod_cliente";
$query = pg_query($sql);
$array = pg_fetch_all($query);

$sq = "SELECT * FROM funcionario WHERE funcionario_id='".$_GET[funcionario_id]."'";
$que = pg_query($sq);
$fun = pg_fetch_array($que);

    echo "<td class='text roundborder' valign=top>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'><b>Relatório de repasse</b></td>";
        echo "</tr>";
        echo "</table>";
		
		echo "<table border=0 cellpadding=2 cellspacing=3 width=100%>";
		
        echo "<tr>";
        echo "<td align=left width='70%'><b>Empresa:</b></td>";
        echo "<td align=left width='15%'><b>Orçamento:</b></td>";
        echo "<td align=left width='15%'><b>Comissão:</b></td>";
        echo "</tr>";
		
		$t = 0;
		
		for($x=0;$x<pg_num_rows($query);$x++){
			$t = 0;
			$s = "SELECT * FROM site_orc_produto WHERE cod_orcamento = '".$array[$x][cod_orcamento]."'";
			$q = pg_query($s);
			$o = pg_fetch_all($q);
			for($y=0;$y<pg_num_rows($q);$y++){
				$t += $o[$y][preco_aprovado];
			}
			$c = $t * $fun[comissao] / 100;
			echo "<tr>";
			echo "<td class='text roundborder' align='left' onclick=\"location.href='?dir=com_sesmt&amp;p=view&funcionario_id=".$_GET[funcionario_id]."';\">".$array[$x][razao_social]."</td>";
			echo "<td align=center class='text roundborder'>".$array[$x][cod_orcamento]."</td>";
			echo "<td align=center class='text roundborder'>R$".number_format($c, 2, ',', ' ')."</td>";
			echo "</tr>";
		}
        echo "</table>";
		
/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>
