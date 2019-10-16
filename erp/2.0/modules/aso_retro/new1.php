<?PHP



//VERIFICAR SE TODOS OS CAMPOS FORAM PREENCHIDOS
echo '
<html><head>
<script type="text/javascript">	
	function validar(formulario){
	
		if(formulario.razao_social.value == \'\'){
			alert("O campo Raz�o Social � obrigat�rio.");
			return false;
		}
		
		if(formulario.cnpj.value == \'\'){
			alert("O campo CNPJ � obrigat�rio.");
			return false;
		}
		
		if(formulario.endereco.value == \'\'){
			alert("O campo Endere�o � obrigat�rio.");
			return false;
		}
		
		if(formulario.bairro.value == \'\'){
			alert("O campo Bairro � obrigat�rio.");
			return false;
		}
		
		if(formulario.cnae.value == \'\'){
			alert("O campo CNAE � obrigat�rio.");
			return false;
		}
						
		if(formulario.nome.value == \'\'){
			alert("O campo Nome � obrigat�rio.");
			return false;
		}
				
		if(formulario.ctps.value == \'\'){
			alert("O campo CTPS � obrigat�rio.");
			return false;
		}
				
		if(formulario.funcao.value == \'\'){
			alert("O campo Fun��o � obrigat�rio.");
			return false;
		}
		
		if(formulario.class_atividade.value == \'\'){
			alert("O campo Classifica��o da Atividade � obrigat�rio.");
			return false;
		}
		
		if(formulario.tolerancia.value == \'\'){
			alert("O campo Tolerancia � obrigat�rio.");
			return false;
		}
		
		if(formulario.tipo_exame.value == \'\'){
			alert("O campo Tipo de exame � obrigat�rio.");
			return false;
		}
		
		if(formulario.aso_data.value == \'\'){
			alert("O campo Data � obrigat�rio.");
			return false;
		}
		if(formulario.aso_resultado.value == \'\'){
			alert("O campo Resultado � obrigat�rio.");
			return false;
		}
		
		if(formulario.grau_risco.value == \'\'){
			alert("O campo Grau de risco � obrigat�rio.");
			return false;
		}
		
		return true;
	}
</script></head>';

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
    echo "<form method=post name=save action=?dir=aso_retro&p=index&sp=new2 onsubmit=\"return validar(this);\">";
    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";

    echo "<tr>";
    echo "<td align=left class=text width='15%'>Raz�o Social:</td>";
    echo "<td align=left class=text width='35%'><input type='text' class='inputTextobr' size=35 name=razao_social id=razao_social></td>";
    echo "<td align=left class=text width='15%'>CNPJ:</td>";
    echo "<td align=left class=text width='25%'><input type='text' class='inputTextobr' size=25 name=cnpj id=cnpj OnKeyPress=\"formatar(this, '##.###.###/####-##');\" maxlength='18' onkeydown=\"return only_number(event);\"></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class=text width='15%'>Endere�o:</td>";
    echo "<td align=left class=text width='35%'><input type='text' class='inputTextobr' size=35 name=endereco id=endereco></td>";
    echo "<td align=left class=text width='15%'>Bairro:</td>";
    echo "<td align=left class=text width='25%'><input type='text' class='inputTextobr' size=25 name=bairro id=bairro></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class=text width='15%'>Respos�vel:</td>";
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
echo "<b>Dados do funcion�rio:</b>";
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
    echo "<td align=left class=text width='25%'><input type='text' size=25 name=cbo id=cbo></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class=text width='100'>Fun��o:</td>";
    echo "<td align=left class=text width='220'>
		<select class='inputTextobr' name='funcao' id='funcao' style=\"width: 245px;\">";
			echo "<option></option>";
		for($b=0;$b<pg_num_rows($qlist4);$b++){
			echo "<option value='".$alist4[$b][cod_funcao]."'>".$alist4[$b][nome_funcao]."</option>";
		}
	echo "</select></td>";
    echo "<td align=left class=text width='100'>Setor:</td>";
    echo "<td align=left class=text width='220'>
		<select name='setor' id='setor' style=\"width: 185px;\">";
			echo "<option></option>";
		for($c=0;$c<pg_num_rows($qlist5);$c++){
			echo "<option value='".$alist5[$c][cod_setor]."'>".$alist5[$c][nome_setor]."</option>";
		}
	echo "</select></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>CTPS/RG:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=ctps id=ctps></td>";
    echo "<td align=left class=text width='100'>S�rie:</td>";
    echo "<td align=left class=text width='220'><input type='text' size=25 name=serie id=serie></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Classifica��o Atividade:</td>";
    echo "<td align=left class=text width='220'>
		<select class='inputTextobr' name='class_atividade' id='class_atividade' style=\"width: 245px;\">";
		echo "<option value='0'></option>";
		echo "<option value='1'>Penosa</option>";
		echo "<option value='2'>Insalubre</option>";
		echo "<option value='3'>Periculosa</option>";
		echo "<option value='4'>Nenhuma das Situa��es</option>";
		echo "</select></td>";
		
    echo "<td align=left class=text width='100'>N�vel Toler�ncia:</td>";
    echo "<td align=left class=text width='220'>
		<select class='inputTextobr' name='tolerancia' id='tolerancia' style=\"width: 185px;\">";
		echo "<option value=''></option>";
		echo "<option value='Pequeno'>Pequeno</option>";
		echo "<option value='M�dio'>M�dio</option>";
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
		echo "<option value='Peri�dico'>Peri�dico</option>";
		echo "<option value='Mudan�a de Fun��o'>Mudan�a de Fun��o</option>";
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
		echo "<option value='Apto com restri��o'>Apto com restri��o</option>";
		echo "<option value='Apto a manipular alimentos'>Apto a manipular alimentos</option>";
		echo "<option value='Apto para operar empilhadeira'>Apto para operar empilhadeira</option>";
		echo "<option value='Apto para trabalhar em altura'>Apto para trabalhar em altura</option>";
		echo "<option value='Apto para trabalhar em espa�o confinado'>Apto para trabalhar em espa�o confinado</option>";
	echo "</select></td>";
    echo "</tr>";	
	
    echo "<tr>";
    echo "<td align=left class=text width='100'>Observa��es:</td>";
    echo "<td align=left colspan='3' class=text width='220'><input type='text' size=91 name=obs id=obs></td>";
    echo "</tr>";	
		
    echo "</table>";
	
echo "</td>";
echo "</tr>";
echo "</table>";
	echo "<br /><center>
	
	<input name=confirmar type=submit value='Avan�ar >>' width='250' class='btn' onmouseover=\"showtip('tipbox', '- Confirmar ASO.');\" onmouseout=\"hidetip('tipbox');\">
	
		
</center><br /></html>
";
?>
