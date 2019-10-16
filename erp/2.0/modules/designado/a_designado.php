<?PHP
if($_POST[funcionario] != ""){
	$query_alterar = "UPDATE agenda_cipa_part SET 
						cod_funcionario = $funcionario,
						data_realizacao = '$data_realizacao'
						WHERE id 	    = ".$_GET[id];
	if(pg_query($connect, $query_alterar)){	
	     showmessage('Funcionário alterado no curso com sucesso!');
	}
}

/*$query="select * from tipo_edificacao where tipo_edificacao_id=".$tipo_edificacao_id;
$result=pg_query($connect, $query);
$row=pg_fetch_array($result);*/

$sql = "SELECT f.* FROM agenda_cipa_part a, funcionarios f WHERE a.cod_cliente = f.cod_cliente";
$result = pg_query($sql);
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
        echo "<td align=center class='text roundborderselected'><b>Alterar Funcionário do Curso de Designado</b></td>";
        echo "</tr>";
        echo "</table>";
        
		echo "<form name=form1 method=post>";
	    echo "<table width=100% border=0 cellspacing=0 cellpadding=2 height=300>";
        echo "<tr class='text roundbordermix'>";
		echo "<td width=100>Selecione o Candidato: </td>";
        echo "<td align=left class='text' width=100><select name=funcionario id=funcionario class=required onchange=\"check_funcionario(this.options[this.selectedIndex].text);\">
        	 <option></option>";
                while($buffer = pg_fetch_array($result)){
                	echo "<option value='$buffer[cod_func]'>{$buffer[nome_func]}</option>";
                }
            
             echo "</select>
			 <span id=load></span></td>";
        echo "</tr>";

		echo "<tr class='text roundbordermix'>
			<td >Função:</td>
			<td align=left><input type=text name=nome_funcao id=nome_funcao size=20 class=required value=''></td>
		</tr>
		<tr class='text roundbordermix'>
			<td >CTPS:</td>
			<td align=left><input type=text name=ctps id=ctps size=10 class=required value=''></td>
		</tr>
		<tr class='text roundbordermix'>
			<td >Série:</td>
			<td align=left><input type=text name=serie id=serie size=10 class=required value=''></td>
		</tr>
		<tr class='text roundbordermix'>
			<td >Data de Realização: </td>
			<td align=left>
				<select name=data_realizacao id=data_realizacao class=required>";
				
					$datas = next_days(10);
					for($x=0;$x<10;$x++){
						echo "<option value='".date("Y-m-d", strtotime($datas[$x]))."'>".date("d/m/Y", strtotime($datas[$x]))."</option>";
					}
			   
				echo "</select>
			</td>
		</tr>";

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