<?php
if($_SESSION[cod_cliente]){
	$ses = "SELECT * FROM cliente WHERE cliente_id = {$_SESSION[cod_cliente]}";
	$ss = pg_query($ses);
	$row = pg_fetch_array($ss);
}
?>
<table align="center" border="0">
	<tr>
		<td align="center" class="fontebranca22bold"><p><br>CONTINGENTE DA BRIGADA</td>
	</tr>
</table><br />
<form method="post">
Todos os campos são de preenchimento obrigatório.
<table align="center" width="500" border="0" bordercolor="#FFFFFF">
    <tr>
    	<td width="50%" align="right">Escolha o grupo de sua empresa:</td>
    	<td width="50%">
			<?php
			$sql = "SELECT DISTINCT(grupo) as g FROM site_comp_brigada";
			$res = pg_query($sql);
			$grp = pg_fetch_all($res);
			?>
        <select name="class" id="grp" class="required" onchange="select_brigada_grupo(this);">
        	<option></option>
			<?php
			for($x=0;$x<pg_num_rows($res);$x++){
				echo "<option value='{$grp[$x]['g']}'>{$grp[$x]['g']}</option>";
			}
			?>
		</select>
    	</td>
    </tr>
    <tr>
    	<td width="50%" align="right">Escolha o grau de risco:</td>
    	<td width="50%">
        <select name="gr" id="gr" class="required" onchange="select_brigada_grupo(document.getElementById('grp'));">
            <option value="Baixo">Baixo</option>
            <option value="Médio">Médio</option>
            <option value="Alto">Alto</option>
        </select>
    	</td>
    </tr>
    <tr>
    	<td width="50%" align="right">Escolha uma descrição:</td>
    	<td width="50%">
        <select name="descricao" id="descricao" class="required" onchange="exemplo_brigada(this);">
        	<option value=""></option>
        </select>
    	</td>
    </tr>
    <tr>
		<td width="50%" align="right">Exemplo:</td>
		<td width="50%">
		<div id='exemplo'></div>
		</td>
    </tr>
    <tr>
    	<td width="50%" align="right">Nº de Colaboradores:</td>
    	<td width="50%"><input type="text" class="required" name="quantidade" id="quantidade" size="5" ></td>
    </tr>
    <tr>
    	<th colspan="2"><input type="submit" class="button" value="Buscar" onclick="return check_brig_form();" name="btn_enviar"></th>
    </tr>
</table>
</form>
<?php
if($_POST['class']!="" && $_POST['quantidade']!=""){
	switch($_POST[gr]){
		case 'Baixo':
			$vgrupo = 20;
		break;
		case 'Médio':
			$vgrupo = 15;
		break;
		case 'Alto':
			$vgrupo = 10;
		break;
	}
	$sql = "SELECT * FROM site_comp_brigada WHERE id = '{$_POST[descricao]}'";
	$res = pg_query($sql);
	$bri = pg_fetch_array($res);
	$nminimo = 0;
	if($_POST[quantidade] > 0 && $_POST[quantidade] <=2){
		$nminimo = $bri[ate_2];
	}elseif($_POST[quantidade] > 2 && $_POST[quantidade] <=4){
		$nminimo = $bri[ate_4];
	}elseif($_POST[quantidade] > 4 && $_POST[quantidade] <=6){
		$nminimo = $bri[ate_6];
	}elseif($_POST[quantidade] > 6 && $_POST[quantidade] <=8){
		$nminimo = $bri[ate_8];
	}elseif($_POST[quantidade] > 8 && $_POST[quantidade] <=10){
		$nminimo = $bri[ate_10];
	}elseif($_POST[quantidade] > 10){
		$nminimo = $bri[acima_10];
	}
	
	if($nminimo >0){
		if($_POST[quantidade] > 10){
			$total = $bri[ate_10] + (ceil(($_POST[quantidade]-10)/$vgrupo));
		}else{
			$total = $nminimo;
		}
		if($total >0){
			echo "<p>
			<center>
			<table border=0 cellpadding=5 cellspacing=2>
			<tr>
				<td align=center colspan=2 class=bgTitle>São necessários como participantes da Brigada de Incêndio</td>
			</tr>
			<tr>
				<td class=bgContent1>Chefe de Brigada</td>
				<td class=bgContent1 width=50 align=center>1</td>
			</tr>";
			if($total>1){
			echo "<tr>
				  <td class=bgContent2>Líder de Equipe</td>
				  <td class=bgContent2 width=50 align=center>1</td>
				  </tr>";
			}
			if($total>2){
			echo "<tr>
				  <td class=bgContent1>Membro Participante da Brigada</td>
				  <td class=bgContent1 width=50 align=center>".($total-2)."</td>
				  </tr>";
			}
			echo "</table>
			<p>
			No caso de sua empresa estar instalada em prédio, deverá sempre ter um chefe da Brigada e sub dividir os grupos
			por andares com um líder no comando, subordinado ao líder da brigada.
			</center>";
		}else{
			echo "<p><center><table border=0 cellpadding=\"1\" cellspacing=\"1\">
			<tr>
			<td class=\"fontebranca12\" bgcolor=\"#009966\">Não há necessidade de formação de Brigada de Incêndio.</td>";
			echo"</td></tr></table></center>";
		}
	}elseif($nminimo == 0){
			echo "<p><center><table border=0 cellpadding=\"1\" cellspacing=\"1\">
			<tr>
			<td class=\"fontebranca12\" bgcolor=\"#009966\">Não há necessidade de formação de Brigada de Incêndio.</td>";
			echo"</td></tr></table></center>";
	}else{
			echo "<p>
			<center>
			<table border=0 cellpadding=5 cellspacing=2>
			<tr>
				<td align=center colspan=2 class=bgTitle>São necessários como participantes da Brigada de Incêndio</td>
			</tr>
			<tr>
				<td class=bgContent1>Chefe de Brigada</td>
				<td class=bgContent1 width=50 align=center>1</td>
			</tr>";
			if($_POST[quantidade]>1){
			echo "<tr>
				  <td class=bgContent2>Líder de Equipe</td>
				  <td class=bgContent2 width=50 align=center>1</td>
				 </tr>";
			}
			if($_POST[quantidade]>2){
			echo "<tr>
				<td class=bgContent1>Membro Participante da Brigada</td>
				<td class=bgContent1 width=50 align=center>".($_POST[quantidade]-2)."</td>
			</tr>";
			}
			echo "</table>
			<p>
			No caso de sua empresa estar instalada em prédio, deverá sempre ter um chefe da Brigada e sub dividir os grupos
			por andares com um líder no comando, subordinado ao líder da brigada.
			</center>";
	}
}
?>