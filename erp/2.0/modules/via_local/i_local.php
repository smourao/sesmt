<?PHP
if($_POST){
	$query_incluir="INSERT into viabilidade_localidade (bairro, rua, cep, status, cidade, estado, lado)
					values
					('".addslashes($_POST['bairro'])."', '".addslashes($_POST['endereco'])."', '00000-000', 0, '".addslashes($_POST['municipio'])."', 
					'".addslashes($_POST['estado'])."', '{$_POST['lado']}')";
	
	if(pg_query($connect, $query_incluir)){
		showmessage('Localidade Incluído com Sucesso!');
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
        echo "<td align=center class='text roundborderselected'><b>Viabilidade de Localidade</b></td>";
        echo "</tr>";
        echo "</table>";
        
		echo "<form name=form1 method=post>";
	    echo "<table width=100% border=0 cellspacing=0 cellpadding=0 height=300>";
        echo "<tr class='text roundbordermix'>";
        echo "<td height=50 align=left class='text' width=50><b>Bairro:</b></td>";
        echo "<td align=left width=200><input id='bairro' type='text' name='bairro' size=40></td>";
        echo "</tr>";

		echo "<tr class='text roundbordermix'>";
		echo "<td align=left class='text'><b>Rua:</b></td>";
		echo "<td align=left><input id='endereco' type='text' name='endereco' size=40></td>";
		echo "</tr>";
		
		echo "<tr class='text roundbordermix'>";
		echo "<td align=left class='text'><b>Cidade:</b></td>";
		echo "<td align=left><input id='municipio' type='text' name='municipio' size=40></td>";
		echo "</tr>";
		
		echo "<tr class='text roundbordermix'>";
		echo "<td align=left class='text'><b>Estado:</b></td>";
		echo "<td align=left><input id='estado' type='text' name='estado' size=40></td>";
		echo "</tr>";
		
		echo "<tr class='text roundbordermix'>";
		echo "<td align=left class='text'><b>Lado:</b></td>";
		echo "<td align=left><select name=lado id=lado>
			 <option value='0'>Lado A</option>
			 <option value='1'>Lado B</option>
			 </select></td>";
		echo "</tr>";

		echo "<tr class='text'>";
		echo "<td align=left class='text'></td>";
		echo "<td align=left></td>";
		echo "</tr>";

        echo "</table>";
		
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