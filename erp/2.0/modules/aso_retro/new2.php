<?php

//DADOS CLIENTE
$razao_social		=	$_POST[razao_social];
$cnpj				=	$_POST[cnpj];
$endereco			=	$_POST[endereco];
$bairro				=	$_POST[bairro];
$cnae				=	$_POST[cnae];

if($_POST[responsavel] != ''){
	$responsavel		=	$_POST[responsavel];
}else{
	$responsavel		=	' - ';
}
	
if($_POST[email] != ''){
	$email		=	$_POST[email];
}else{
	$email		=	' - ';
}

if($_POST[telefone] != ''){
	$telefone		=	$_POST[telefone];
}else{
	$telefone		=	' - ';
}

//DADOS FUNCIONARIO/ASO
$nome				=	$_POST[nome];

if($_POST[cbo] != ''){
	$cbo				=	$_POST[cbo];
}else{
	$cbo				=	' - ';
}
$ctps				=	$_POST[ctps];

if($_POST[serie]){
	$serie				=	$_POST[serie];
}else{
	$serie				=	' - ';
}
$funcao				=	$_POST[funcao];

if($_POST[setor]){
	$setor				=	$_POST[setor];
}else{
	$setor				=	0;
}

$class_atividade	=	$_POST[class_atividade];
$tolerancia			=	$_POST[tolerancia];
$tipo_exame			=	$_POST[tipo_exame];
$aso_data			=	$_POST[aso_data];
$aso_resultado		=	$_POST[aso_resultado];
$grau_risco			=	$_POST[grau_risco];

if($_POST[obs] != ''){
	$obs		=	$_POST[obs];
}else{
	$obs		=	' - ';
}

$tipo_risco			=	$_POST[tipo_risco];
$agente_risco		=	$_POST[agente_risco];

//CONVERTER FORMATO DATA
$aso_data0 = explode('/',$aso_data);
$aso_data1 = $aso_data0[2].'-'.$aso_data0[1].'-'.$aso_data0[0];

//BUSCA RISCOS
$slist1 = "SELECT * FROM tipo_risco ORDER BY nome_tipo_risco ";
$qlist1 = pg_query($slist1);
$alist1 = pg_fetch_all($qlist1);

$slist2 = "SELECT * FROM agente_risco ORDER BY nome_agente_risco";
$qlist2 = pg_query($slist2);
$alist2 = pg_fetch_all($qlist2);

//BUSCA CNAE
$slist3 = "SELECT * FROM cnae WHERE cnae = '$cnae'";
$qlist3 = pg_query($slist3);
$alist3 = pg_fetch_array($qlist3);
$cnae_idd = $alist3[cnae_id];

//BUSCA FUNCAO
$slist4 = "SELECT * FROM funcao ORDER BY nome_funcao";
$qlist4 = pg_query($slist4);
$alist4 = pg_fetch_all($qlist4);

//BUSCA SETOR
$slist5 = "SELECT * FROM setor ORDER BY nome_setor";
$qlist5 = pg_query($slist5);
$alist5 = pg_fetch_all($qlist5);

//BUSCA ULTIMO CLIENTE
$slist6 = "SELECT cliente_id FROM cliente ORDER BY cliente_id DESC";
$qlist6 = pg_query($slist6);
$alist6 = pg_fetch_all($qlist6);
$cliente_idd = $alist6[0][cliente_id] + 1;

//BUSCA ULTIMO ASO
$slist8 = "SELECT cod_aso FROM aso ORDER BY cod_aso DESC";
$qlist8 = pg_query($slist8);
$alist8 = pg_fetch_all($qlist8);
$cod_aso = $alist8[0][cod_aso] + 1;
$erro = 0;
/*
//VERIFICA SE EXISTE O CLIENTE CADASTRADO PELO CNPJ
$sql = "SELECT * FROM cliente WHERE cnpj = '$cnpj'";
$query = pg_query($sql);
if($_POST[cnpj] && pg_num_rows($query) == 0){
	$novo1 = "INSERT INTO cliente(cliente_id, razao_social, cnpj, endereco, bairro, email, telefone, cnae_id, nome_contato_dir, grau_de_risco, status, filial_id) VALUES('$cliente_idd', '$razao_social', '$cnpj', '$endereco', '$bairro', '$email', '$telefone', '$cnae_idd', '$responsavel', '$grau_risco', 'comercial', '0')";
	if($new1 = pg_query($novo1)){
		$erro = 0;
	}else{
		//echo "<p>" . pg_last_error();
		$erro = 1;
	}
	
//BUSCA ULTIMO FUNCIONARIO
$func_idd = 1;

}else{

//BUSCA  CLIENTE EXISTENTE
$slistx = "SELECT cliente_id FROM cliente WHERE cnpj = '$cnpj'";
$qlistx = pg_query($slistx);
$alistx = pg_fetch_all($qlistx);
$cliente_ide = $alistx[0][cliente_id];

$slist7 = "SELECT cod_func FROM funcionarios WHERE cod_cliente = '$cliente_ide' ORDER BY cod_func DESC";
$qlist7 = pg_query($slist7);
$alist7 = pg_fetch_all($qlist7);
$func_idd = $alist7[0][cod_func] + 1;

}

if($erro == 0 && $cliente_ide != ''){
	$novo2 = "INSERT INTO funcionarios(cod_func, nome_func, endereco_func, bairro_func, num_ctps_func, serie_ctps_func, cbo, cod_status, cod_setor, cod_cliente, cod_funcao) VALUES('$func_idd ', '$nome', '$endereco', '$bairro', '$ctps', '$serie', '$cbo', '1', '$setor', '$cliente_ide', '$funcao')";
	if($new2 = pg_query($novo2)){
		$erro = 0;
	}else{
		//echo "<p>" . pg_last_error();
		$erro = 1;
	}
}else{
	$novo2 = "INSERT INTO funcionarios(cod_func, nome_func, endereco_func, bairro_func, num_ctps_func, serie_ctps_func, cbo, cod_status, cod_setor, cod_cliente, cod_funcao) VALUES('$func_idd', '$nome', '$endereco', '$bairro', '$ctps', '$serie', '$cbo', '1', '$setor', '$cliente_idd', '$funcao')";
	if($new2 = pg_query($novo2)){
		$erro = 0;
	}else{
		//echo "<p>" . pg_last_error();
		$erro = 1;
	}
}


if($erro == 0 && $cliente_ide != ''){
	$novo3 = "INSERT INTO aso(cod_aso, cod_cliente, cod_func, aso_resultado, classificacao_atividade_id, tipo_exame, cod_setor, aso_data, obs, cod_clinica, tipo, tolerancia) VALUES('$cod_aso', '$cliente_ide', '$func_idd', '$aso_resultado', '$class_atividade', '$tipo_exame', '$setor', '$aso_data1', '$obs', '11', '2', '$tolerancia')";
	if($new3 = pg_query($novo3)){
		$erro = 0;
	}else{
		$erro = 1;
		//echo "<p>" . pg_last_error();
	}
}else{
	$novo3 = "INSERT INTO aso(cod_aso, cod_cliente, cod_func, aso_resultado, classificacao_atividade_id, tipo_exame, cod_setor, aso_data, obs, cod_clinica, tipo, tolerancia) VALUES('$cod_aso', '$cliente_idd', '$func_idd', '$aso_resultado', '$class_atividade', '$tipo_exame', '$setor', '$aso_data1', '$obs', '11', '3', '$tolerancia')";
	if($new3 = pg_query($novo3)){
		$erro = 0;
	}else{
		$erro = 1;
		//echo "<p>" . pg_last_error();
	}

}

if($cliente_ide){
	$cc = $cliente_ide;
}else{
	$cc = $cliente_idd;
}

if($erro == 0 && $_POST['tipo_risco']){
	$dl1 = "DELETE FROM avulso_tipo_risco WHERE cod_aso = '$_POST[aso1]'";
	$dll1 = pg_query($dl1);
	for($y=0;$y<count($tipo_risco);$y++){
		if($tipo_risco[$y] != 0){
			$novo5 = "INSERT INTO avulso_tipo_risco(cod_aso, cod_tipo_risco) VALUES('$cod_aso', '$tipo_risco[$y]')";
			if($new5 = pg_query($novo5)){
				$erro = 0;
			}else{
				$erro = 1;
				//echo "<p>" . pg_last_error();
			}
		}
	}
}

if($erro == 0 && $_POST['agente_risco']){
	$dl2 = "DELETE FROM avulso_agente_risco WHERE cod_aso = '$_POST[aso1]'";
	$dll2 = pg_query($dl2);
	for($z=0;$z<count($agente_risco);$z++){
		if($agente_risco[$z] != 0){
			$novo6 = "INSERT INTO avulso_agente_risco(cod_aso, cod_agente_risco) VALUES('$cod_aso', '$agente_risco[$z]')";
			if($new6 = pg_query($novo6)){
				$erro = 0;
			}else{
				$erro = 1;
				//echo "<p>" . pg_last_error();
			}
		}
	}
}

if($_POST[cnpj] && $erro == 0){
	showMessage('ASO cadastrado com sucesso, cadastre agora os exames.');
}
*/

echo "<form method='post' action='?dir=aso_retro&p=index&sp=new3&aso=$cod_aso'>";

$sql = "SELECT * FROM exame";
$result_ex=@pg_query($sql);

echo "<table width=100% border=0>";
		
for($x=0;$x<@pg_num_rows($result_ex);$x++){
	$row_ex[$x] = @pg_fetch_array($result_ex);
	
	echo "<tr>";
	echo "<td align=left class='text' width=100%>";
	echo "<input name=confirma[] type=checkbox value={$row_ex[$x][cod_exame]}>";
	echo $row_ex[$x][especialidade];
	echo "<input name=aso1 type=hidden value={$row[cod_aso]}>";
	echo "</td>";	
	echo "</tr>";
	
}

echo "</table><br><center>";

	echo"<input name=confirmar type=submit value='Confirmar' width='250' class='btn' onmouseover=\"showtip('tipbox', '- Confirmar ASO.');\" onmouseout=\"hidetip('tipbox');\">";
echo "</form><br>";

?>