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

//BUSCA DADOS CADASTRADOS
$sql = "SELECT a.*, c.*, f.*, fu.*, se.*, ff.*, cn.* FROM aso a, cliente c, funcionarios f, funcao fu, setor se, financeiro_fatura ff, cnae cn
		WHERE a.cod_aso = '".$_GET[aso]."'
		  AND a.cod_cliente = c.cliente_id
		  AND a.cod_func = f.cod_func
		  AND f.cod_cliente = c.cliente_id
		  AND f.cod_funcao = fu.cod_funcao
		  AND f.cod_setor = se.cod_setor
		  AND ff.numero_doc = '".$_GET[aso]."'
		  AND a.cod_cliente = ff.cod_cliente
		  AND cn.cnae_id = c.cnae_id";
$query = pg_query($sql);
$array = pg_fetch_array($query);

$stipo = "SELECT * FROM avulso_tipo_risco WHERE cod_aso = '".$_GET[aso]."'";
$qtipo = pg_query($stipo);
$atipo = pg_fetch_all($qtipo);

$sagente = "SELECT * FROM avulso_agente_risco WHERE cod_aso = '".$_GET[aso]."'";
$qagente = pg_query($sagente);
$aagente = pg_fetch_all($qagente);


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

$aso_data2 = explode('-',$array[aso_data]);
$aso_data3 = $aso_data2[2].'/'.$aso_data2[1].'/'.$aso_data2[0];


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

//ATUALIZAR DADOS

if(!empty($_GET[a])){

$sup1 = "UPDATE cliente SET razao_social = '$razao_social', endereco = '$endereco', bairro = '$bairro', nome_contato_dir = '$responsavel', email = '$email', telefone = '$telefone', cnae_id = '$cnae_idd', grau_de_risco = '$grau_risco' WHERE cliente_id = '$array[cod_cliente]'";
$qup1 = pg_query($sup1);

$sup2 = "UPDATE funcionarios SET nome_func = '$nome', cbo = '$cbo', num_ctps_func = '$ctps', serie_ctps_func = '$serie', cod_funcao = '$funcao', cod_setor = '$setor' WHERE cod_func = '$array[cod_func]' AND cod_cliente = '$array[cod_cliente]'";
$qup2 = pg_query($sup2);
print pg_last_error();
}

$sup3 = "UPDATE aso SET aso_resultado = '$aso_resultado', classificacao_atividade_id = '$class_atividade', tipo_exame = '$tipo_exame', cod_setor = '$setor', aso_data = '$aso_data1', obs = '$obs', cod_clinica = '11', tipo='2', tolerancia = '$tolerancia' WHERE cod_func = '$array[cod_func]' AND cod_cliente = '$array[cod_cliente]' AND cod_aso = '".$_GET[aso]."'";
$qup3 = pg_query($sup3);

/*
$sup4 = "UPDATE financeiro_fatura SET ";
$qup4 = pg_query($sup4);

$sup5 = "UPDATE avulso_agente_risco SET ";
$qup5 = pg_query($sup5);

$sup6 = "UPDATE avulso_tipo_risco SET ";
$qup6 = pg_query($sup6);
*/

if(!empty($_GET[a])){
	echo "<script type=\"text/javascript\">
	setTimeout(\"location.href = '?dir=aso_retro&p=index&sp=edit&aso=$_GET[aso]';\",0);
	</script>";
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
    echo "<form method=post name=save action=?dir=aso_retro&p=index&sp=edit&aso=$_GET[aso]&a=1 onsubmit=\"return validar(this);\">";
    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";

    echo "<tr>";
    echo "<td align=left class=text width='15%'>Razão Social:</td>";
    echo "<td align=left class=text width='35%'><input type='text' class='inputTextobr' size=35 name=razao_social id=razao_social value='".$array[razao_social]."'></td>";
    echo "<td align=left class=text width='15%'>CNPJ:</td>";
    echo "<td align=left class=text width='25%'><input type='text' class='inputTextobr' size=25 name=cnpj id=cnpj OnKeyPress=\"formatar(this, '##.###.###/####-##');\" maxlength='18' onkeydown=\"return only_number(event);\" value='".$array[cnpj]."' disabled='true'></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class=text width='15%'>Endereço:</td>";
    echo "<td align=left class=text width='35%'><input type='text' class='inputTextobr' size=35 name=endereco id=endereco value='".$array[endereco]."'></td>";
    echo "<td align=left class=text width='15%'>Bairro:</td>";
    echo "<td align=left class=text width='25%'><input type='text' class='inputTextobr' size=25 name=bairro id=bairro value='".$array[bairro]."'></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class=text width='15%'>Resposável:</td>";
    echo "<td align=left class=text width='35%'><input type='text' size=35 name=responsavel id=responsavel value='".$array[nome_contato_dir]."'></td>";
    echo "<td align=left class=text width='15%'>CNAE:</td>";
    echo "<td align=left class=text width='25%'><input type='text' class='inputTextobr' size=25 name=cnae id=cnae OnKeyPress=\"formatar(this, '##.##-#');\" maxlength='7' onkeydown=\"return only_number(event);\" value='".$array[cnae]."'></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class=text width='15%'>Email:</td>";
    echo "<td align=left class=text width='35%'><input type='text' size=35 name=email id=email value='".$array[email]."'></td>";
    echo "<td align=left class=text width='15%'>Telefone:</td>";
    echo "<td align=left class=text width='25%'><input type='text' size=25 name=telefone id=telefone OnKeyPress=\"formatar(this, '## ####-####');\" maxlength='12' onkeydown=\"return only_number(event);\" value='".$array[telefone]."'></td>";
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
    echo "<td align=left class=text width='35%'><input type='text' class='inputTextobr' size=35 name=nome id=nome value='".$array[nome_func]."'></td>";
    echo "<td align=left class=text width='15%'>CBO:</td>";
    echo "<td align=left class=text width='25%'><input type='text' class='inputTextobr' size=25 name=cbo id=cbo value='".$array[cbo]."'></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class=text width='100'>Função:</td>";
    echo "<td align=left class=text width='220'>
		<select class='inputTextobr' name='funcao' id='funcao' style=\"width: 245px;\">";
			echo "<option></option>";
		for($b=0;$b<pg_num_rows($qlist4);$b++){
			echo "<option value='".$alist4[$b][cod_funcao]."'";
			if($alist4[$b][cod_funcao] == $array[cod_funcao]){
				echo "selected";
			}
			echo ">".$alist4[$b][nome_funcao]."</option>";
		}
	echo "</select></td>";
    echo "<td align=left class=text width='100'>Setor:</td>";
    echo "<td align=left class=text width='220'>
		<select class='inputTextobr' name='setor' id='setor' style=\"width: 185px;\">";
			echo "<option></option>";
		for($c=0;$c<pg_num_rows($qlist5);$c++){
			echo "<option value='".$alist5[$c][cod_setor]."'";
			if($alist5[$c][cod_setor] == $array[cod_setor]){
				echo "selected";
			}
			echo ">".$alist5[$c][nome_setor]."</option>";
		}
	echo "</select></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>CTPS/RG:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=ctps id=ctps value='".$array[num_ctps_func]."'></td>";
    echo "<td align=left class=text width='100'>Série:</td>";
    echo "<td align=left class=text width='220'><input type='text' size=25 name=serie id=serie value='".$array[serie_ctps_func]."'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Classificação Atividade:</td>";
    echo "<td align=left class=text width='220'>
		<select class='inputTextobr' name='class_atividade' id='class_atividade' style=\"width: 245px;\">";
		echo "<option value='0'></option>";
		echo "<option value='1'";
		if($array[classificacao_atividade_id] == 1){
			echo "selected";
		}
		echo ">Penosa</option>";
		echo "<option value='2'";
		if($array[classificacao_atividade_id] == 2){
			echo "selected";
		}
		echo ">Insalubre</option>";
		echo "<option value='3'";
		if($array[classificacao_atividade_id] == 3){
			echo "selected";
		}
		echo ">Periculosa</option>";
		echo "<option value='4'";
		if($array[classificacao_atividade_id] == 4){
			echo "selected";
		}
		echo ">Nenhuma das Situações</option>";
		echo "</select></td>";
		
    echo "<td align=left class=text width='100'>Nível Tolerância:</td>";
    echo "<td align=left class=text width='220'>
		<select class='inputTextobr' name='tolerancia' id='tolerancia' style=\"width: 185px;\">";
		echo "<option value=''></option>";
		echo "<option value='Pequeno'";
		if($array[tolerancia] == "Pequeno"){
			echo "selected";
		}
		echo ">Pequeno</option>";
		echo "<option value='Médio'";
		if($array[tolerancia] == "Médio"){
			echo "selected";
		}
		echo ">Médio</option>";
		echo "<option value='Grande'";
		if($array[tolerancia] == "Grande"){
			echo "selected";
		}
		echo ">Grande</option>";
		echo "</select></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Tipo Exame:</td>";
    echo "<td align=left class=text width='220'>
    	<select class='inputTextobr' name='tipo_exame' id='tipo_exame' style=\"width: 245px;\">";
		echo "<option value=''></option>";
		echo "<option value='Admissional'";
		if($array[tipo_exame] == "Admissional"){
			echo "selected";
		}
		echo ">Admissional</option>";
		echo "<option value='Demissional'";
		if($array[tipo_exame] == "Demissional"){
			echo "selected";
		}
		echo ">Demissional</option>";
		echo "<option value='Periódico'";
		if($array[tipo_exame] == "Periódico"){
			echo "selected";
		}
		echo ">Periódico</option>";
		echo "<option value='Mudança de Função'";
		if($array[tipo_exame] == "Mudança de Função"){
			echo "selected";
		}
		echo ">Mudança de Função</option>";
		echo "<option value='Retorno ao trabalho'";
		if($array[tipo_exame] == "Retorno ao trabalho"){
			echo "selected";
		}
		echo ">Retorno ao trabalho</option>";
	echo "</select></td>";
	
    echo "<td align=left class=text width='100'>Data:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=25 name=aso_data id=aso_data OnKeyPress=\"formatar(this, '##/##/####');\" maxlength='10' onkeydown=\"return only_number(event);\" value='".$aso_data3."'></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class=text width='100'>Agente Risco:</td>";
    echo "<td align=left class=text width='220'>
		<select class='inputTextobr' name='agente_risco[]' multiple='multiple' id='agente_risco' style=\"width: 245px;\"  size='5'>";
		for($a=0;$a<pg_num_rows($qlist2);$a++){
			echo "<option value='".$alist2[$a][cod_agente_risco]."'";
			for($aa=0;$aa<pg_num_rows($qagente);$aa++){
				if($alist2[$a][cod_agente_risco] == $aagente[$aa][cod_agente_risco]){
					echo "selected";
				}
			}
			echo ">".$alist2[$a][nome_agente_risco]."</option>";
		}
	echo "</select></td>";
	
    echo "<td align=left class=text width='100'>Tipo Risco:</td>";
    echo "<td align=left class=text width='220'>
    	<select class='inputTextobr' name='tipo_risco[]' id='tipo_risco' multiple='multiple' style=\"width: 185px;\" size='5'>";
		for($b=0;$b<pg_num_rows($qlist1);$b++){
			echo "<option value='".$alist1[$b][cod_tipo_risco]."'";
			for($bb=0;$bb<pg_num_rows($qtipo);$bb++){
				if($alist1[$b][cod_tipo_risco] == $atipo[$bb][cod_tipo_risco]){
					echo "selected";
				}
			}
		echo ">".$alist1[$b][nome_tipo_risco]."</option>";
		}
	echo "</select></td>";
    echo "</tr>";	
	
    echo "<tr>";
    echo "<td align=left class=text width='100'>Grau de Risco:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=grau_risco id=grau_risco value='".$array[grau_de_risco]."'></td>";
    echo "<td align=left class=text width='100'>Resultado:</td>";
    echo "<td align=left class=text width='220'>
    	<select class='inputTextobr' name='aso_resultado' id='aso_resultado' style=\"width: 185px;\">";
		echo "<option value=''></option>";
		echo "<option value='Apto'";
		if($array[aso_resultado] == "Apto"){
			echo "selected";
		}
		echo ">Apto</option>";
		echo "<option value='Inapto'";
		if($array[aso_resultado] == "Inapto"){
			echo "selected";
		}
		echo ">Inapto</option>";
		echo "<option value='Apto com restrição'";
		if($array[aso_resultado] == "Apto com restrição"){
			echo "selected";
		}
		echo ">Apto com restrição</option>";
		echo "<option value='Apto a manipular alimentos'";
		if($array[aso_resultado] == "Apto a manipular alimentos"){
			echo "selected";
		}
		echo ">Apto a manipular alimentos</option>";
		echo "<option value='Apto para operar empilhadeira'";
		if($array[aso_resultado] == "Apto para operar empilhadeira"){
			echo "selected";
		}
		echo ">Apto para operar empilhadeira</option>";
		echo "<option value='Apto para trabalhar em altura'";
		if($array[aso_resultado] == "Apto para trabalhar em altura"){
			echo "selected";
		}
		echo ">Apto para trabalhar em altura</option>";
		echo "<option value='Apto para trabalhar em espaço confinado'";
		if($array[aso_resultado] == "Apto para trabalhar em espaço confinado"){
			echo "selected";
		}
		echo ">Apto para trabalhar em espaço confinado</option>";
	echo "</select></td>";
    echo "</tr>";	
	
    echo "<tr>";
    echo "<td align=left class=text width='100'>Observações:</td>";
    echo "<td align=left colspan='3' class=text width='220'><input type='text' size=91 name=obs id=obs  value='".$array[obs]."'></td>";
    echo "</tr>";	
	
    echo "<tr>";
    echo "<td align=left class=text width='100'>Valor:</td>";
    echo "<td align=left class=text width='220'>
    	<select class='inputTextobr' name='valor' id='valor' style=\"width: 180px;\" onchange=\"verificaCombo(this);\">";
		echo "<option value='normal'>Valor Padão</option>";
		echo "<option value='promocional'>Valor Promocional</option>";
	echo "</select>";
	echo "<input type='text' class='inputTextobr' size=5 name=preco id=preco disabled='true' onkeydown=\"return only_number(event);\" value='".number_format($array[valor], 1, '.', '')."' onkeypress=\"return lastdot(this, event);\"></td>";
    echo "</tr>";	
	
    echo "</table>";
	
echo "</td>";
echo "</tr>";
echo "</table>";
	echo "<br /><center>
	
	<input name=confirmar type=submit value='Salvar ASO' width='250' class='btn' onmouseover=\"showtip('tipbox', '- Confirmar ASO.');\" onmouseout=\"hidetip('tipbox');\">
	
		
</center><br /></html>
";
?>
