<?PHP
if($_POST[nome] != ""){
	$query_max = "SELECT max(cod_aparelho) as cod_aparelho FROM aparelhos";
	$result_max = pg_query($connect, $query_max);
	$row_max = pg_fetch_array($result_max);
	
	$cod_aparelho = $row_max[cod_aparelho] + 1;
	
	$query_incluir="INSERT into aparelhos (cod_aparelho, nome_aparelho, modelo_aparelho, fabricante, tipo_aparelho, marca_aparelho)
					values
					($cod_aparelho, '$_POST[nome]', '$modelo_aparelho', '$fabricante', $tipo_aparelho, '$marca_aparelho')";
	
	if(pg_query($connect, $query_incluir)){	
	     showmessage('Aparelho de Medi��o Inclu�do com Sucesso!');
	}
}



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
                    echo "<b>&nbsp;</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='text' height=30 align=left>";
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
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'><b>Incluir Aparelho de Medi��o</b></td>";
        echo "</tr>";
        echo "</table>";
        
		echo "<form name=form1 method=post>";
	    echo "<table width=100% border=0 cellspacing=0 cellpadding=0 height=300>";
        echo "<tr class='text roundbordermix'>";
        echo "<td height=50 align=left class='text' width=100><b>Nome:</b></td>";
        echo "<td align=left width=200><input id='nome' type='text' name='nome' size='30' >
			  <input name=cod_aparelho type=hidden id=cod_aparelho value=$row_max[cod_aparelho]></td>";
        echo "</tr>";

		echo "<tr class='text roundbordermix'>";
		echo "<td height=50 align=left class='text'><b>Marca:</b></td>";
		echo "<td align=left><input id='marca_aparelho' type='text' name='marca_aparelho' size='30' ></td>";
		echo "</tr>";
		
		echo "<tr class='text roundbordermix'>";
		echo "<td height=50 align=left class='text'><b>Modelo:</b></td>";
		echo "<td align=left><input id='modelo_aparelho' type='text' name='modelo_aparelho' size='30' ></td>";
		echo "</tr>";
		
		echo "<tr class='text roundbordermix'>";
		echo "<td height=50 align=left class='text'><b>Fabricante:</b></td>";
		echo "<td align=left><input id='fabricante' type='text' name='fabricante' size='30' ></td>";
		echo "</tr>";
		
		echo "<tr class='text roundbordermix'>";
		echo "<td height=50 align=left class='text'><b>Tipo de Aparelho:</b></td>";
		echo "<td align=left><select name=tipo_aparelho id=tipo_aparelho style=\"width: 210px\">
			 <option>Selecione...</option>
			 <option value=1 >1 - Verificar Conforto T�rmico</option>
			 <option value=2 >2 - Verificar Metragem Linear</option>
			 <option value=3 >3 - Verificar Ru�do</option>
			 <option value=4 >4 - Verificar Ilumin�ncia</option>
			 <option value=5 >5 - Verificar Poeiras</option>
			 <option value=6 >6 - Verificar Vapores Org�nicos</option>
			 </select></td>";
		echo "</tr>";

		echo "<tr class='text '>";
		echo "<td height=200 align=left class='text'></td>";
		echo "<td align=left></td>";
		echo "</tr>";

        echo "</table>";
		
		echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
			echo "<tr>";
			echo "<td align=left class='text'>";
				echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
				echo "<tr>";
					echo "<td align=center class='text roundbordermix'>";
					echo "<input type='submit' class='btn' name='btnSave' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenar� todos os dados selecionados at� o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";//onclick=\"return confirm('Todos os dados ser�o salvos, tem certeza que deseja continuar?','');\"
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