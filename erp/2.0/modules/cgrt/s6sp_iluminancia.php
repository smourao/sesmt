<?php
if($_GET[remove]){
	$del = "DELETE FROM iluminacao_ppra WHERE id = {$_GET[remove]}";
	if(pg_query($connect, $del)){
		showmessage('Funcion�rio excluido com sucesso!');
	}
}

/**********************************************************************************************/
// --> QUERY - ARMAZENA DADOS DA ILUMINA��O
/**********************************************************************************************/
if($_POST && $_POST['btnSaveIlum']){//1�
$_POST[cod_func] = '0';
	if(is_numeric($_GET[cod_cgrt]) && is_numeric($_GET[cod_setor])){//2�
		$sql = "SELECT * FROM iluminacao_ppra WHERE id_ppra = $_GET[cod_cgrt] and cod_setor = $_GET[cod_setor] and cod_func = $_POST[cod_func]";
		$res = @pg_query($sql);
		$buffer = @pg_fetch_all($res); 
		if(!empty($_GET["cod_cliente"]) && !empty($_GET["cod_setor"])){ //3�
			if($_POST[cod_func] == '0'){//(@pg_num_rows($res)<=0){//4�
				if($_POST[terc] == 'sim'){//5�
					$luz = "INSERT INTO iluminacao_ppra(cod_cliente, cod_setor, cod_func, lux_atual, lux_recomendado, exposicao, movel, numero, lux, data,
									id_ppra, homo, monitor, terceirizado)
							VALUES($_GET[cod_cliente], $_GET[cod_setor], {$_POST[cod_func]}, '$luz_atual', '$recomendado', '$exposicao', '$movel', '$numero',
									$aparelho_luz, '".date('Y-m-d')."', $_GET[cod_cgrt], '$homo', '$monitor', '$_POST[terc]')";
				}else{
					$sql = "SELECT * FROM iluminacao_ppra WHERE id_ppra = $_GET[cod_cgrt] and cod_setor = $_GET[cod_setor] and cod_func = {$cod_func}";
					$res = @pg_query($sql);
					$buffer = @pg_fetch_all($res);
					$luz = "INSERT INTO iluminacao_ppra(cod_cliente, cod_setor, cod_func, lux_atual, lux_recomendado, exposicao, movel, numero, lux, data,
									id_ppra, homo, monitor, terceirizado)
							VALUES($_GET[cod_cliente], $_GET[cod_setor], {$cod_func}, '$luz_atual', '$recomendado', '$exposicao', '$movel', '$numero',
									$aparelho_luz, '".date('Y-m-d')."', $_GET[cod_cgrt], '$homo', '$monitor', '$_POST[terc]')";
				} //5�
				if(pg_query($luz)){
					showmessage('Informa��es cadastradas com sucesso!');
				}else{
					showMessage('Houve um problema ao armazenar as informa��es. Por favor, entre em contato com o setor de suporte!',1);
				}
			}else{
				$luz = "UPDATE iluminacao_ppra
						SET lux_atual 		  = '$luz_atual',
							lux_recomendado   = '$recomendado',
							exposicao 		  = '$exposicao',
							movel 			  = '$movel',
							numero			  = '$numero',
							lux 			  = $aparelho_luz,
							homo			  = '$homo',
							monitor			  = '$monitor',
							terceirizado   	  = '$_POST[terc]'
						WHERE id_ppra 	= $_GET[cod_cgrt] AND cod_setor = $_GET[cod_setor] AND cod_func = $_POST[cod_func]";
				if(@pg_query($luz)){
					showmessage('Informa��es alteradas com sucesso!');
				}else{
					showMessage('Houve um problema ao armazenar as informa��es. Por favor, entre em contato com o setor de suporte!',1);
				}
			}//4�
		}//3�
	}else{
        showMessage('Houve um problema ao armazenar as informa��es por inconsist�ncia dos dados [cod_cgrt/cod_setor]. Por favor, entre em contato com o setor de suporte!',1);
    }//2�
}//1�

/**********************************************************************************************/
// --> ILUMINA��O
/**********************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Ilumin�ncia:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
	echo "<form method=post name=frmIluminacao id=frmIluminacao action='?dir=$_GET[dir]&p=$_GET[p]&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&cod_setor=$_GET[cod_setor]&sp=s6sp_iluminancia' onSubmit=\"return ilumi(this);\">";
		echo "<td align=center class='text roundborderselected'>";

		    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
			echo "<tr>";
				echo "<td align=left class='text' width=150>";
					echo "Luz Atual:";
				echo "</td>";
				echo "<td class='text' width=490>";
					echo "<input type=text class='text' name='luz_atual' id='luz_atual' value='' size=5 >";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' width=150>";
					echo "Luz Recomendado:";
				echo "</td>";
				echo "<td class='text' width=490>";
					echo "<input type=text class='text' name='recomendado' id='recomendado' value='' size=5 >";
					echo "  <input type='button' class='btn' value='Tabela Lux' alt='tabela de lux recomendado: Industriais e Fundi��es - 150; Escrit�rios - 200 e Escolas - 250' title='tabela de lux recomendado: Industriais e Fundi��es - 150; Escrit�rios - 200 e Escolas - 250'>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' width=150>";
					echo "Tempo de Exposi��o:";
				echo "</td>";
				echo "<td class='text' width=490>";
					echo "<input type=text class='text' name='exposicao' id='exposicao' value='' size=5 maxlength='5' OnKeyPress=\"formatar(this, '##:##');\">";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' width=150>";
					echo "Funcion�rio:";
				echo "</td>";
				$sql = "SELECT * FROM funcionarios f, cgrt_func_list l
						WHERE l.cod_cgrt = $_GET[cod_cgrt]
						AND l.cod_cliente = f.cod_cliente
						AND	f.cod_func = l.cod_func
						AND	(l.cod_setor = $_GET[cod_setor]
						OR f.setor_adicional LIKE '%$_GET[cod_setor]%')
						ORDER BY nome_func";
				$func = pg_query($sql);
				$r_func = pg_fetch_all($func);
				echo "<td class='text' width=490>";
					echo "<select class='text' name='cod_func' id='cod_func' style=\"width: 400px;\">";
						echo "<option value=''></option>";
						for($x=0;$x<pg_num_rows($func);$x++){
							echo "<option value='{$r_func[$x][cod_func]}'"; print $edifdata[ruido] == $r_func[$x][cod_func] ? " selected ":""; echo ">{$r_func[$x][nome_func]}</option>";
						}
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' width=150>";
					echo "M�vel:";
				echo "</td>";
				echo "<td class='text' width=490>";
					echo "<select class='text' name='movel' id='movel' style=\"width: 340px;\">";
					echo "<option value=''></option>";
					echo "<option value='mesa'>Mesa</option>";
					echo "<option value='bancada'>Bancada</option>";
					echo "<option value='maquinario'>Maquin�rio</option>";
					echo "<option value='ponto'>Ponto</option>";
					echo "</select>&nbsp;";
					echo "N&ordm;&nbsp;";
					echo "<input type='text' class='text' name='numero' id='numero' value='' size=2 maxlength='5'>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' width=150>";
					echo "Aparelho de Medi��o:";
				echo "</td>";
				$sql = "SELECT * FROM aparelhos WHERE cod_aparelho <> 0 AND tipo_aparelho = 4 ORDER BY nome_aparelho";
				$rapr = pg_query($sql);
				$r_ap_luz = pg_fetch_all($rapr);
				echo "<td class='text' width=490>";
					echo "<select class='text' name='aparelho_luz' id='aparelho_luz' style=\"width: 400px;\">";
						echo "<option value=''></option>";
						for($x=0;$x<pg_num_rows($rapr);$x++){
							echo "<option value='{$r_ap_luz[$x][cod_aparelho]}'"; print $edifdata[ruido] == $r_ap_luz[$x][cod_aparelho] ? " selected ":""; echo ">{$r_ap_luz[$x][nome_aparelho]}</option>";
						}
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' width=150>";
					echo "Luz � Homog�nea:";
				echo "</td>";
				echo "<td class='text' width=490>";
					echo "<select class='text' name='homo' id='homo' style=\"width: 50px;\">";
					echo "<option value=''></option>";
					echo "<option value='sim'>Sim</option>";
					echo "<option value='n�o'>N�o</option>";
					echo "</select>&nbsp;";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' width=150>";
					echo "Tipo de Monitor:";
				echo "</td>";
				echo "<td class='text' width=490>";
					echo "<select class='text' name='monitor' id='monitor' style=\"width: 50px;\">";
					echo "<option value=''></option>";
					echo "<option value='crt'>CRT</option>";
					echo "<option value='lcd'>LCD</option>";
					echo "</select>&nbsp;";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' width=150>";
				echo "Funcion�rio terceirizado:";
				echo "</td>";
				echo "<td class='text' width=490>";
					echo "<select name='terc' id='terc' style=\"width: 50px;\" class='text'>";
					echo "<option value=''></option>";
					echo "<option value='nao'>N�o</option>";
					echo "<option value='sim'>Sim</option>";
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			echo "</table>";

		echo "</td>";
echo "</tr>";
echo "</table>";

echo "<p>";

echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
echo "<tr>";
echo "<td align=left class='text'>";
	echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
	echo "<tr>";
		echo "<td align=center class='text roundbordermix'>";
		echo "<input type='submit' class='btn' name='btnSaveIlum' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenar� todos os dados selecionados at� o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" ></td>";//onclick=\"return confirm('Todos os dados ser�o salvos, tem certeza que deseja continuar?','');\"
echo "</td>";
echo "</tr>";
echo "</table>";
		
echo "<p>";
	
/**************************************************************************************/
// - > ILUMINA��O CADASTRADA
/**************************************************************************************/
$sql = "SELECT i.*, f.nome_func
FROM cgrt_func_list l, iluminacao_ppra i, funcionarios f
WHERE i.cod_cliente = l.cod_cliente
AND f.cod_cliente = l.cod_cliente
AND i.cod_cliente = f.cod_cliente
AND i.id_ppra = l.cod_cgrt
AND (l.cod_setor = $_GET[cod_setor] OR f.setor_adicional LIKE '%$_GET[cod_setor]%')
AND i.cod_func = f.cod_func
and i.cod_func = l.cod_func
and f.cod_func = l.cod_func
AND l.cod_cgrt = $_GET[cod_cgrt]
AND i.cod_setor = $_GET[cod_setor]
and l.cod_cliente = $_GET[cod_cliente]";
$result_func = pg_query($connect, $sql);
$r = pg_fetch_all($result_func);
if($r != ""){
	echo "<table width=100% border=0 cellpadding=2 cellspacing=2 >
	<tr>
		<td align=center class='text'><b>Ilumina��o Cadastrada</b></td>
	</tr>";
	echo "</table>";
	echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
	echo "<tr>";
	echo "<td align=left class='text'>";

	echo "<table width=100% border=0 cellpadding=2 cellspacing=2 >";
	for($i=0;$i<pg_num_rows($result_func);$i++){
		echo "<tr>
			<td class='text roundborderselected'>Funcion�rio:<b> {$r[$i][nome_func]}</b></td>
			<td class='text roundborderselected'>M�vel:<b> {$r[$i][movel]} {$r[$i][numero]}</b></td>
			<td class='text roundborderselected'>Luz Atual:<b> {$r[$i][lux_atual]}</b></td>
			<td align=center class='text roundborderselectedred '><a href='?dir=cgrt&p=index&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&cod_setor=$_GET[cod_setor]&sp=s6sp_iluminancia&remove={$r[$i]['id']}' alt='Excluir este funcion�rio' title='Excluir este funcion�rio'><span style=\"font-size: 8px;\">X</span></a></td>
			</tr>";
	}
}

//FUNCION�RIOS TERCEIRIZADOS
$sql = "SELECT * FROM iluminacao_ppra WHERE id_ppra = $_GET[cod_cgrt] AND cod_setor = $_GET[cod_setor]
and cod_cliente = $_GET[cod_cliente] and terceirizado = 'sim'";
$result_terc = pg_query($connect, $sql);
$t = pg_fetch_all($result_terc);
if($t != ""){
	for($q=0;$q<pg_num_rows($result_terc);$q++){
		echo "<tr>
			<td class='text roundborderselected'>Funcion�rio:<b> Terceirizado</b></td>
			<td class='text roundborderselected'>M�vel:<b> {$t[$q][movel]} {$t[$q][numero]}</b></td>
			<td class='text roundborderselected'>Luz Atual:<b> {$t[$q][lux_atual]}</b></td>
			<td align=center class='text roundborderselectedred '><a href='?dir=cgrt&p=index&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&cod_setor=$_GET[cod_setor]&sp=s6sp_iluminancia&remove={$t[$q]['id']}' alt='Excluir este funcion�rio' title='Excluir este funcion�rio'><span style=\"font-size: 8px;\">X</span></a></td>
			</tr>";
	}
}
echo "</table>";
	
echo "</td>";
echo "</tr>";
echo "</table>";
    
echo "</td>";
echo "</form>";
echo "</tr>";
echo "</table>";

?>