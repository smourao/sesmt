<?PHP


echo "
<script>
function verificaCombo(obj){

  opcao = obj.value;
  
  if (opcao == 'promocional')
  {
     document.save.valor.disabled = false;
     document.save.preco.disabled = false;
  }
  else
  {
     if (obj.name != 'valor')
     {
       document.save.valor.disabled = true;
       document.save.preco.disabled = false;
     }
       else
     {
       document.save.valor.disabled = false;
       document.save.preco.disabled = true;
     }
  }
}
</script>
";


//VERIFICAR SE TODOS OS CAMPOS FORAM PREENCHIDOS
echo '
<html><head>
<script type="text/javascript">	
	function validar(formulario){
	
		if(formulario.razao_social.value == \'\'){
			alert("O campo Razão Social é obrigatório.");
			return false;
		}
		
		if(formulario.cnpj.value == \'\'){
			alert("O campo CNPJ é obrigatório.");
			return false;
		}
		
		if(formulario.endereco.value == \'\'){
			alert("O campo Endereço é obrigatório.");
			return false;
		}
		
		if(formulario.bairro.value == \'\'){
			alert("O campo Bairro é obrigatório.");
			return false;
		}
		
		if(formulario.cnae.value == \'\'){
			alert("O campo CNAE é obrigatório.");
			return false;
		}
						
		if(formulario.nome.value == \'\'){
			alert("O campo Nome é obrigatório.");
			return false;
		}
		
		if(formulario.cbo.value == \'\'){
			alert("O campo CBO é obrigatório.");
			return false;
		}
		
		if(formulario.ctps.value == \'\'){
			alert("O campo CTPS é obrigatório.");
			return false;
		}
				
		if(formulario.funcao.value == \'\'){
			alert("O campo Função é obrigatório.");
			return false;
		}
		
		if(formulario.setor.value == \'\'){
			alert("O campo Setor é obrigatório.");
			return false;
		}
		
		if(formulario.class_atividade.value == \'\'){
			alert("O campo Classificação da Atividade é obrigatório.");
			return false;
		}
		
		if(formulario.tolerancia.value == \'\'){
			alert("O campo Tolerancia é obrigatório.");
			return false;
		}
		
		if(formulario.tipo_exame.value == \'\'){
			alert("O campo Tipo de exame é obrigatório.");
			return false;
		}
		
		if(formulario.aso_data.value == \'\'){
			alert("O campo Data é obrigatório.");
			return false;
		}
		if(formulario.aso_resultado.value == \'\'){
			alert("O campo Resultado é obrigatório.");
			return false;
		}
		
		if(formulario.grau_risco.value == \'\'){
			alert("O campo Grau de risco é obrigatório.");
			return false;
		}
		
		return true;
	}
</script></head>';

//DADOS CLIENTE
$razao_social		=	$_POST[razao_social];
$cnpj				=	$_POST[cnpj];
$endereco			=	$_POST[endereco];
$bairro				=	$_POST[bairro];
$cnae				=	$_POST[cnae];

if($_POST[preco] != '35.0'){
	$valp		=	$_POST[preco]."0";
}else{
	$valp		=	'35.00';
}

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
$cbo				=	$_POST[cbo];
$ctps				=	$_POST[ctps];

if($_POST[serie]){
	$serie				=	$_POST[serie];
}else{
	$serie				=	' - ';
}
$funcao				=	$_POST[funcao];
$setor				=	$_POST[setor];
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

//BUSCA ULTIMO FUNCIONARIO
$slist7 = "SELECT cod_func FROM funcionarios ORDER BY cod_func DESC";
$qlist7 = pg_query($slist7);
$alist7 = pg_fetch_all($qlist7);
$func_idd = $alist7[0][cliente_id] + 1;

//BUSCA ULTIMO ASO
$slist8 = "SELECT cod_aso FROM aso ORDER BY cod_aso DESC";
$qlist8 = pg_query($slist8);
$alist8 = pg_fetch_all($qlist8);
$cod_aso = $alist8[0][cod_aso] + 1;
$erro = 0;

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
}else{

//BUSCA  CLIENTE EXISTENTE
$slistx = "SELECT cliente_id FROM cliente WHERE cnpj = '$cnpj'";
$qlistx = pg_query($slistx);
$alistx = pg_fetch_all($qlistx);
$cliente_ide = $alistx[0][cliente_id];

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
	$novo3 = "INSERT INTO aso(cod_aso, cod_cliente, cod_func, aso_resultado, classificacao_atividade_id, tipo_exame, cod_setor, aso_data, obs, cod_clinica, tipo, tolerancia) VALUES('$cod_aso', '$cliente_idd', '$func_idd', '$aso_resultado', '$class_atividade', '$tipo_exame', '$setor', '$aso_data1', '$obs', '11', '2', '$tolerancia')";
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

if($erro == 0){
	$novo4 = "INSERT INTO aso_exame(cod_aso, cod_exame, data, confirma) VALUES('$cod_aso', '22', '$aso_data1', '1')";
	if($new4 = pg_query($novo4)){
		$erro = 0;
	}else{
		$erro = 1;
		//echo "<p>" . pg_last_error();
	}
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
	$fin = "INSERT INTO financeiro_info(titulo, cod_cliente, valor_total, n_parcelas, forma_pagamento, status, data, dia, mes, ano, data_lancamento, data_entrada_saida, tipo_lancamento, historico, funcionario_id, pc) VALUES('ASO Avulso - ".$cod_aso." - ".$razao_social."', '$cc', '$valp', '1', 'Dinheiro', '0', '".date('Y-m-d')."', '".date('d')."', '".date('m')."', '".date('Y')."', '".date('Y-m-d')."', '".date('Y-m-d')."', '24', 'Emissão de ASO - ".$nome." - ".$razao_social."', '0', '0')";
	if(pg_query($fin)){
		$erro = 0;
	}else{
		$erro = 1;
	}
}

$sql = "SELECT MAX(id) FROM financeiro_info WHERE valor_total = '$valp'";
$result = pg_query($sql);
$max = pg_fetch_array($result);


if($_POST[cnpj] && $erro == 0){
	$fin = "INSERT INTO financeiro_fatura(cod_fatura, cod_cliente, titulo, valor, parcela_atual, vencimento, status, pago, data_lancamento) VALUES('{$max[0]}', '$cc', 'ASO Avulso - ".$cod_aso." - ".$razao_social."', '$valp', '1', '".date('Y-m-d')."', '0', '1', '".date('Y-m-d')."')";
	if(pg_query($fin)){
		$erro = 0;
	}else{
		$erro = 1;
		echo pg_last_error();
	}
}

if($_POST[cnpj] && $erro == 0){
	showMessage('ASO cadastrado com sucesso!');
}



echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Dados da empresa:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    //FORM - SAVE DATA
    echo "<form method=post name=save action=?dir=enc_avulso&p=index&sp=new_enc_med onsubmit=\"return validar(this);\">";
    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";

    echo "<tr>";
    echo "<td align=left class=text width='15%'>Razão Social:</td>";
    echo "<td align=left class=text width='35%'><input type='text' class='inputTextobr' size=35 name=razao_social id=razao_social></td>";
    echo "<td align=left class=text width='15%'>CNPJ:</td>";
    echo "<td align=left class=text width='25%'><input type='text' class='inputTextobr' size=25 name=cnpj id=cnpj OnKeyPress=\"formatar(this, '##.###.###/####-##');\" maxlength='18' onkeydown=\"return only_number(event);\"></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class=text width='15%'>Endereço:</td>";
    echo "<td align=left class=text width='35%'><input type='text' class='inputTextobr' size=35 name=endereco id=endereco></td>";
    echo "<td align=left class=text width='15%'>Bairro:</td>";
    echo "<td align=left class=text width='25%'><input type='text' class='inputTextobr' size=25 name=bairro id=bairro></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class=text width='15%'>Resposável:</td>";
    echo "<td align=left class=text width='35%'><input type='text' size=35 name=responsavel id=responsavel></td>";
    echo "<td align=left class=text width='15%'>CNAE:</td>";
    echo "<td align=left class=text width='25%'><input type='text' class='inputTextobr' size=25 name=cnae id=cnae OnKeyPress=\"formatar(this, '##.##-#');\" maxlength='7' onkeydown=\"return only_number(event);\" ></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class=text width='15%'>Email:</td>";
    echo "<td align=left class=text width='35%'><input type='text' size=35 name=email id=email ></td>";
    echo "<td align=left class=text width='15%'>Telefone:</td>";
    echo "<td align=left class=text width='25%'><input type='text' size=25 name=telefone id=telefone OnKeyPress=\"formatar(this, '## ####-####');\" maxlength='12' onkeydown=\"return only_number(event);\" ></td>";
    echo "</tr>";
	
    echo "</table>";
	
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<BR>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Dados do funcionário:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";

    echo "<tr>";
    echo "<td align=left class=text width='15%'>Nome:</td>";
    echo "<td align=left class=text width='35%'><input type='text' class='inputTextobr' size=35 name=nome id=nome></td>";
    echo "<td align=left class=text width='15%'>CBO:</td>";
    echo "<td align=left class=text width='25%'><input type='text' class='inputTextobr' size=25 name=cbo id=cbo></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class=text width='100'>Função:</td>";
    echo "<td align=left class=text width='220'>
		<select class='inputTextobr' name='funcao' id='funcao' style=\"width: 245px;\">";
			echo "<option></option>";
		for($b=0;$b<pg_num_rows($qlist4);$b++){
			echo "<option value='".$alist4[$b][cod_funcao]."'>".$alist4[$b][nome_funcao]."</option>";
		}
	echo "</select></td>";
    echo "<td align=left class=text width='100'>Setor:</td>";
    echo "<td align=left class=text width='220'>
		<select class='inputTextobr' name='setor' id='setor' style=\"width: 185px;\">";
			echo "<option></option>";
		for($c=0;$c<pg_num_rows($qlist5);$c++){
			echo "<option value='".$alist5[$c][cod_setor]."'>".$alist5[$c][nome_setor]."</option>";
		}
	echo "</select></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>CTPS/RG:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=ctps id=ctps></td>";
    echo "<td align=left class=text width='100'>Série:</td>";
    echo "<td align=left class=text width='220'><input type='text' size=25 name=serie id=serie></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Classificação Atividade:</td>";
    echo "<td align=left class=text width='220'>
		<select class='inputTextobr' name='class_atividade' id='class_atividade' style=\"width: 245px;\">";
		echo "<option value='0'></option>";
		echo "<option value='1'>Penosa</option>";
		echo "<option value='2'>Insalubre</option>";
		echo "<option value='3'>Periculosa</option>";
		echo "<option value='4'>Nenhuma das Situações</option>";
		echo "</select></td>";
		
    echo "<td align=left class=text width='100'>Nível Tolerância:</td>";
    echo "<td align=left class=text width='220'>
		<select class='inputTextobr' name='tolerancia' id='tolerancia' style=\"width: 185px;\">";
		echo "<option value=''></option>";
		echo "<option value='Pequeno'>Pequeno</option>";
		echo "<option value='Médio'>Médio</option>";
		echo "<option value='Grande'>Grande</option>";
		echo "</select></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Tipo Exame:</td>";
    echo "<td align=left class=text width='220'>
    	<select class='inputTextobr' name='tipo_exame' id='tipo_exame' style=\"width: 245px;\">";
		echo "<option value=''></option>";
		echo "<option value='Admissional'>Admissional</option>";
		echo "<option value='Demissional'>Demissional</option>";
		echo "<option value='Periódico'>Periódico</option>";
		echo "<option value='Mudança de Função'>Mudança de Função</option>";
		echo "<option value='Retorno ao trabalho'>Retorno ao trabalho</option>";
	echo "</select></td>";
	
    echo "<td align=left class=text width='100'>Data:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=25 name=aso_data id=aso_data OnKeyPress=\"formatar(this, '##/##/####');\" maxlength='10' onkeydown=\"return only_number(event);\"></td>";
    echo "</tr>";
		
    echo "<tr>";
    echo "<td align=left class=text width='100'>Agente Risco:</td>";
    echo "<td align=left class=text width='220'>
		<select class='inputTextobr' name='agente_risco[]' multiple='multiple' id='agente_risco_risco' style=\"width: 245px;\"  size='5'>";
		for($a=0;$a<pg_num_rows($qlist2);$a++){
			echo "<option value='".$alist2[$a][cod_agente_risco]."'>".$alist2[$a][nome_agente_risco]."</option>";
		}
	echo "</select></td>";
	
    echo "<td align=left class=text width='100'>Tipo Risco:</td>";
    echo "<td align=left class=text width='220'>
    	<select class='inputTextobr' name='tipo_risco[]' id='tipo_risco' multiple='multiple' style=\"width: 185px;\" size='5'>";
		for($b=0;$b<pg_num_rows($qlist1);$b++){
			echo "<option value='".$alist1[$b][cod_tipo_risco]."'";
			$slist11 = "SELECT * FROM avulso_tipo_risco WHERE cod_aso = ".$aso." AND cod_tipo_risco = ".$alist1[$b][cod_tipo_risco]." ";
			if(pg_num_rows(pg_query($slist11))>=1){
				echo "selected";
			}
			echo ">".$alist1[$b][nome_tipo_risco]."</option>";
		}
	echo "</select></td>";
    echo "</tr>";	
	
    echo "<tr>";
    echo "<td align=left class=text width='100'>Grau de Risco:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=grau_risco id=grau_risco></td>";
    echo "<td align=left class=text width='100'>Resultado:</td>";
    echo "<td align=left class=text width='220'>
    	<select class='inputTextobr' name='aso_resultado' id='aso_resultado' style=\"width: 185px;\">";
		echo "<option value=''></option>";
		echo "<option value='Apto'>Apto</option>";
		echo "<option value='Inapto'>Inapto</option>";
		echo "<option value='Apto com restrição'>Apto com restrição</option>";
		echo "<option value='Apto a manipular alimentos'>Apto a manipular alimentos</option>";
		echo "<option value='Apto para operar empilhadeira'>Apto para operar empilhadeira</option>";
		echo "<option value='Apto para trabalhar em altura'>Apto para trabalhar em altura</option>";
		echo "<option value='Apto para trabalhar em espaço confinado'>Apto para trabalhar em espaço confinado</option>";
	echo "</select></td>";
    echo "</tr>";	
	
    echo "<tr>";
    echo "<td align=left class=text width='100'>Observações:</td>";
    echo "<td align=left colspan='3' class=text width='220'><input type='text' size=91 name=obs id=obs></td>";
    echo "</tr>";	
	
    echo "<tr>";
    echo "<td align=left class=text width='100'>Valor:</td>";
    echo "<td align=left class=text width='220'>
    	<select class='inputTextobr' name='valor' id='valor' style=\"width: 180px;\" onchange=\"verificaCombo(this);\">";
		echo "<option value='normal'>Valor Padão</option>";
		echo "<option value='promocional'>Valor Promocional</option>";
	echo "</select>";
	echo "<input type='text' class='inputTextobr' size=5 name=preco id=preco disabled='true' onkeydown=\"return only_number(event);\" value='".number_format("35", 1, ".", "")."' onkeypress=\"return lastdot(this, event);\"></td>";
    echo "</tr>";	
	
    echo "</table>";
	
echo "</td>";
echo "</tr>";
echo "</table>";
	echo "<br /><center>
	
	<input name=confirmar type=submit value='Gerar ASO' width='250' class='btn' onmouseover=\"showtip('tipbox', '- Confirmar ASO.');\" onmouseout=\"hidetip('tipbox');\">
	
		
</center><br /></html>
";
?>
