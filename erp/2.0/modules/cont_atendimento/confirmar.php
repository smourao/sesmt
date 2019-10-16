<?php
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
if($_GET[ch] == "marcar"){
	$sql = "UPDATE site_aso_agendamento SET
			status = 1
			WHERE cod_aso = {$_GET[aso]} AND cod_cliente = {$_GET[cod]} AND id = {$_GET[id]}";
	$re = pg_query($sql);
}elseif($_GET[ch] == "desmarcar"){
	$sql = "UPDATE site_aso_agendamento SET
			status = 0
			WHERE cod_aso = {$_GET[aso]} AND cod_cliente = {$_GET[cod]} AND id = {$_GET[id]}";
	$re = pg_query($sql);
}

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
    echo "<td width=250 class='text roundborder' valign=top>";
	echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
	echo "<tr>";
	echo "<td align=center class='text roundborderselected'><b>Busca por cliente</b></td>";
	echo "</tr>";
	echo "</table>";
	
	echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
	echo "<tr>";
	echo "<form method=POST name='frmAgeFindCli'>";
		echo "<td class='roundbordermix text' height=30 align=center onmouseover=\"showtip('tipbox', '- Digite o nome da empresa no campo e clique em Busca.');\" onmouseout=\"hidetip('tipbox');\">";
			echo "<input type='text' class='inputText' name='search' id='search' value='{$_POST[search]}' size=18 maxlength=500>";
			echo "&nbsp;";
			echo "<input type='submit' class='btn' name='btnSearch' value='Busca' onclick=\"if(document.getElementById('search').value==''){return false;}\">";
		echo "</td>";
	echo "</form>";
	echo "</tr>";
	echo "</table>";
	
	// --> TIPBOX
	echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
	echo "<tr>";
		echo "<td class=text height=30 valign=top align=justify><div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div></td>";
	echo "</tr>";
	echo "</table>";
	
	echo "</td>";

/**************************************************************************************************/
// -->  RIGHT SIDE!!!
/**************************************************************************************************/
    echo "<td class='text roundborder' valign=top>";

	if($_POST[search]){
		if(is_numeric($_POST['search'])){
			$sql = "SELECT * FROM cliente WHERE cliente_id = {$_POST['search']}";
		}else{
			$sql = "SELECT * FROM cliente WHERE UPPER(razao_social) like '%".strtoupper($_POST['search'])."%' ";
		}

		$result = pg_query($sql);
		$buffer = pg_fetch_array($result);
		
		if(pg_num_rows($result) == 0){
			showmessage('Cliente não existe em nosso cadastro.');
		}else{
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborderselected' colspan=2><b>Resultado da Busca:</b></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td align=center class='text roundborder curhand' onclick=\"location.href='?dir=cont_atendimento&p=confirmar&cod={$buffer['cliente_id']}';\">".str_pad($buffer[cliente_id], 4, '0', 0)."</td>";
		echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir=cont_atendimento&p=confirmar&cod={$buffer['cliente_id']}';\">{$buffer[razao_social]}</td>";
		echo "</tr>";
		echo "</table>";
		}
	}
	
	if($_GET[cod] and !$_GET[aso]){
		$tbl = "SELECT distinct(nome_func), s.cod_aso, s.data_agendamento, f.cod_cliente, f.cod_setor, f.cod_func FROM funcionarios f, site_aso_agendamento s, aso a
		WHERE f.cod_cliente = {$_GET[cod]} AND f.cod_func = s.cod_funcionario AND a.cod_aso = s.cod_aso
		GROUP BY f.nome_func, s.cod_aso, s.data_agendamento, f.cod_cliente, f.cod_setor, f.cod_func";
		$res = pg_query($tbl);
		$row = pg_fetch_all($res);
		
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborderselected' colspan=3><b>Resultado da Busca:</b></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td align=center class='text' width=5% ><b>Cód.</b></td>";
		echo "<td align=left class='text' ><b>Funcionário</b></td>";
		echo "<td align=left class='text' width=15%><b>Data</b></td>";
		echo "</tr>";
		for($x=0;$x<pg_num_rows($res);$x++){
		echo "<tr class='text roundbordermix'>";
		echo "<td align=center class='text roundborder curhand' onclick=\"location.href='?dir=cont_atendimento&p=confirmar&cod={$_GET[cod]}&aso={$row[$x][cod_aso]}&funcionario={$row[$x][cod_func]}&setor={$row[$x][cod_setor]}';\">".str_pad($row[$x][cod_aso], 4, '0', 0)."</td>";
		echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir=cont_atendimento&p=confirmar&cod={$_GET[cod]}&aso={$row[$x][cod_aso]}&funcionario={$row[$x][cod_func]}&setor={$row[$x][cod_setor]}';\">{$row[$x][nome_func]}</td>";
		echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir=cont_atendimento&p=confirmar&cod={$_GET[cod]}&aso={$row[$x][cod_aso]}&funcionario={$row[$x][cod_func]}&setor={$row[$x][cod_setor]}';\">".date('d/m/Y', strtotime($row[$x][data_agendamento]))."</td>";
		echo "</tr>";
		}
		echo "</table>";
	}	
	
	if($_GET[cod] and $_GET[aso]){
		$fun = "SELECT f.nome_func FROM funcionarios f, aso a WHERE a.cod_func = f.cod_func AND a.cod_aso = {$_GET[aso]} AND f.cod_cliente = {$_GET[cod]}";
		$fuu = pg_query($fun);
		$ff = pg_fetch_array($fuu);
		
		$sql = "SELECT s.*, e.*, f.cod_func, f.cod_setor FROM site_aso_agendamento s, exame e, funcionarios f
				WHERE f.cod_cliente = {$_GET[cod]} AND cod_aso = {$_GET[aso]} AND exames = cod_exame AND s.cod_funcionario = f.cod_func";
		$exa = pg_query($sql);
		$r = pg_fetch_all($exa);
		
		echo "<form name=form1 method=post>";
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborderselected' colspan=4><b>Resultado da Busca:</b> {$ff[nome_func]}</td>";
		echo "</tr>";
		
		for($x=0;$x<pg_num_rows($exa);$x++){
		echo "<tr>";
		if($r[$x][status] == '1'){
			echo "<td align=left class='text roundbordermix curhand' width=10% onclick=\"location.href='?dir=cont_atendimento&p=confirmar&cod={$_GET[cod]}&aso={$_GET[aso]}&setor={$r[$x][cod_setor]}&funcionario={$r[$x][cod_func]}&ch=marcar&id={$r[$x][id]}';\">Marcar</td>";
			echo "<td align=left class='text roundbordermix curhand' width=10% onclick=\"location.href='?dir=cont_atendimento&p=confirmar&cod={$_GET[cod]}&aso={$_GET[aso]}&setor={$r[$x][cod_setor]}&funcionario={$r[$x][cod_func]}&ch=desmarcar&id={$r[$x][id]}';\">Desmarcar</td>";
			echo "<td align=center class='text roundborder' width=5% ><input type=checkbox name=chkbx[] value={$r[$x][id]} checked></td>";
			echo "<td align=left class='text roundborder' >{$r[$x][especialidade]}</td>";
		}else{
			echo "<td align=left class='text roundbordermix curhand' width=10% onclick=\"location.href='?dir=cont_atendimento&p=confirmar&cod={$_GET[cod]}&aso={$_GET[aso]}&setor={$r[$x][cod_setor]}&funcionario={$r[$x][cod_func]}&ch=marcar&id={$r[$x][id]}';\">Marcar</td>";
			echo "<td align=left class='text roundbordermix curhand' width=10% onclick=\"location.href='?dir=cont_atendimento&p=confirmar&cod={$_GET[cod]}&aso={$_GET[aso]}&setor={$r[$x][cod_setor]}&funcionario={$r[$x][cod_func]}&ch=desmarcar&id={$r[$x][id]}';\">Desmarcar</td>";
			echo "<td align=center class='text roundborder' width=5% ><input type=checkbox name=chkbx[] value={$r[$x][id]} ></td>";
			echo "<td align=left class='text roundborder' >{$r[$x][especialidade]}</td>";
		}
		echo "</tr>";
		}

		echo "</table>";
		
		echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
		echo "<tr>";
		echo "<td align=left class='text'>";
			echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			echo "<tr>";
				echo "<td align=center class='text roundbordermix curhand' onclick=\"location.href='?dir=gerar_aso&p=editar_aso&cod_cliente={$_GET[cod]}&aso={$_GET[aso]}&setor={$_GET[setor]}&funcionario={$_GET[funcionario]}';\"><b>Editar ASO</b></td>";
			echo "</tr>";
			echo "</table>";
		echo "</tr>";
		echo "</table>";
		echo "</form>";
	}	
/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>