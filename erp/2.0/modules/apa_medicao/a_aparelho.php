<?PHP
if($_POST[nome] != ""){
	$query_alterar = "UPDATE aparelhos SET 
						nome_aparelho 	   = '$nome'
						, modelo_aparelho  = '$modelo_aparelho'
						, fabricante 	   = '$fabricante'
						, tipo_aparelho    = $tipo_aparelho
						, marca_aparelho   = '$marca_aparelho'
						WHERE cod_aparelho = ".$cod_aparelho;
	if(pg_query($connect, $query_alterar)){	
	     showmessage('Aparelho de Medição Alterado com Sucesso!');
	}
}

$query="select * from aparelhos where cod_aparelho = ".$cod_aparelho;
$result=pg_query($connect, $query);
$row=pg_fetch_array($result);

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
        echo "<td align=center class='text roundborderselected'><b>Alterar Aparelho de Medição</b></td>";
        echo "</tr>";
        echo "</table>";
        
		echo "<form name=form1 method=post>";
	    echo "<table width=100% border=0 cellspacing=0 cellpadding=0 height=300>";
        echo "<tr class='text roundbordermix'>";
        echo "<td height=50 align=left class='text' width=100><b>Nome:</b></td>";
        echo "<td align=left width=200><input id='nome' type='text' name='nome' value='{$row[nome_aparelho]}' size='30' ></td>";
        echo "</tr>";

		echo "<tr class='text roundbordermix'>";
		echo "<td height=50 align=left class='text'><b>Marca:</b></td>";
		echo "<td align=left><input id='marca_aparelho' type='text' name='marca_aparelho' value='{$row[marca_aparelho]}' size='30' ></td>";
		echo "</tr>";
		
		echo "<tr class='text roundbordermix'>";
		echo "<td height=50 align=left class='text'><b>Modelo:</b></td>";
		echo "<td align=left><input id='modelo_aparelho' type='text' name='modelo_aparelho' value='{$row[modelo_aparelho]}' size='30' ></td>";
		echo "</tr>";
		
		echo "<tr class='text roundbordermix'>";
		echo "<td height=50 align=left class='text'><b>Fabricante:</b></td>";
		echo "<td align=left><input id='febricante' type='text' name='fabricante' value='{$row[fabricante]}' size='30' ></td>";
		echo "</tr>";
		
		echo "<tr class='text roundbordermix'>";
		echo "<td height=50 align=left class='text'><b>Tipo de Aparelho:</b></td>";
		echo "<td align=left width=200><select name=tipo_aparelho id=tipo_aparelho style=\"width: 210px\">
			 <option>Selecione...</option>
             <option value=1"; if($row[tipo_aparelho]==1){echo " selected ";} echo">1 - Verificar Conforto Térmico</option>
			 <option value=2"; if($row[tipo_aparelho]==2){echo " selected ";} echo">2 - Verificar Metragem Linear</option>
			 <option value=3"; if($row[tipo_aparelho]==3){echo " selected ";} echo">3 - Verificar Ruído</option>
			 <option value=4"; if($row[tipo_aparelho]==4){echo " selected ";} echo">4 - Verificar Iluminância</option>
			 <option value=5"; if($row[tipo_aparelho]==5){echo " selected ";} echo">5 - Verificar Poeiras</option>
			 <option value=6"; if($row[tipo_aparelho]==6){echo " selected ";} echo">6 - Verificar Vapores Orgânicos</option>
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
					echo "<input type='submit' class='btn' name='btnSave' value='Alterar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
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