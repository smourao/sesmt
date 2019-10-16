<?PHP
include "../config/connect.php";
include "../sessao.php";

$cliente = $_GET["cliente"];
$setor	 = $_GET["setor"];
$func	 = $_GET["funcionario"];

if(!empty($_GET[cod_cliente]) && !empty($_GET[cod_f]) && $_POST[btn_enviar] == "Gravar"){
	$verifica = "SELECT p.*, c.razao_social
				FROM prontuario p, cliente c, funcionarios f
				WHERE p.cod_cliente = c.cliente_id
				AND p.cod_cliente = f.cod_cliente
				AND p.cod_func = f.cod_func
				AND p.cod_cliente = {$_GET[cod_cliente]}
				AND p.cod_func = {$_GET[cod_f]}";
	$consulta = pg_query($verifica);
	
	if(pg_num_rows($consulta) == 0){
		$grava = "INSERT INTO prontuario(cod_cliente, cod_func, tuberculose, d_coracao, asma, d_mental, outras, pressao_alta, palpitacao,
				 bronquite, d_coluna, rins, diabetes, gastrite, resfriado, enxerga, ouve, internado, gravida, nervosa, tontura, alergia, reumatismo,
				 varizes, diarreia, sofreu_d, tarefas_p, d_fisico, cirurgia, tabagismo, obs, t_especial, p_trabalho, inps, a_trabalho, doente_trabalho,
				 anotacao, obs2, boca, nariz, lingua, ouvido, faringe, amigdala, laringe, tireoide, coracao, pulmao, hernia, aneis, varicocele, hidroxila,
				 dum, corrimento, isquemia, edema, formacao, calos, p_plano, mucosa, c_vertebral, p_arterial, pulso, altura, peso, data, resultado, varize,
				 obs3, g_sanguinio, diab, can, alerg, urtic, press, nerv, d_cor, d_peito, asma2, renite, d_costa, d_figo, ulce, t_croni, sinu, otit, zumbi,
				 d_ment, d_cab, conv, d_pele, d_jun, vari, hemo, beb)
				 VALUES
				 ($_GET[cod_cliente], $_GET[cod_f], '$tuberculose', '$d_coracao', '$asma', '$d_mental', '$outras', '$pressao_alta', '$palpitacao', '$bronquite',
				 '$d_coluna', '$rins', '$diabetes', '$gastrite', '$resfriado', '$enxerga', '$ouve', '$internado', '$gravida', '$nervosa', '$tontura', '$alergia', '$reumatismo',
				 '$varizes', '$diarreia', '$sofreu_d', '$tarefas_p', '$d_fisico', '$cirurgia', '$tabagismo', '$obs', '$t_especial', '$p_trabalho', '$inps', '$a_trabalho',
				 '$doente_trabalho', '$anotacao', '$obs2', '$boca', '$nariz', '$lingua', '$ouvido', '$faringe', '$amigdala', '$laringe', '$tireoide', '$coracao', '$pulmao',
				 '$hernia', '$aneis', '$varicocele', '$hidroxila', '$dum', '$corrimento', '$isquemia', '$edema', '$formacao', '$calos', '$p_plano', '$mucosa', '$c_vertebral',
				 '$p_arterial', '$pulso', '$altura', '$peso', '".date('Y/m/d')."', '$resultado', '$varize', '$obs3', '$g_sanguinio', '$diab', '$can', '$alerg', '$urtic',
				 '$press', '$nerv', '$d_cor', '$d_peito', '$asma2', '$renite', '$d_costa', '$d_figo', '$ulce', '$t_croni', '$sinu', '$otit', '$zumbi', '$d_ment', '$d_cab',
				 '$conv', '$d_pele', '$d_jun', '$vari', '$hemo', '$beb')";
		$res_grava = pg_query($grava);
	}else{
		$grava = "UPDATE prontuario SET
				 tuberculose 	 = '$tuberculose',
				 d_coracao	 	 = '$d_coracao',
				 asma 		 	 = '$d_mental',
				 outras 	 	 = '$outras',
				 pressao_alta 	 = '$pressao_alta',
				 palpitacao 	 = '$palpitacao',
				 bronquite 		 = '$bronquite',
				 d_coluna 		 = '$d_coluna',
				 rins 			 = '$rins',
				 diabetes 		 = 'diabetes',
				 gastrite 		 = '$gastrite',
				 resfriado 		 = '$resfriado',
				 enxerga 		 = '$enxerga',
				 ouve 			 = '$ouve',
				 internado 		 = '$internado',
				 gravida 		 = '$gravida',
				 nervosa 		 = '$nervosa',
				 tontura 		 = '$tontura',
				 alergia 		 = '$alergia',
				 reumatismo 	 = '$reumatismo',
				 varizes 		 = '$varizes',
				 diarreia 		 = '$diarreia',
				 sofreu_d 		 = '$sofreu_d',
				 tarefas_p 		 = '$tarefas_p',
				 d_fisico 		 = '$d_fisico',
				 cirurgia 		 = '$cirurgia',
				 tabagismo 		 = '$tabagismo',
				 obs 			 = '$obs',
				 t_especial 	 = '$t_especial',
				 p_trabalho 	 = '$p_trabalho',
				 inps 			 = '$inps',
				 a_trabalho 	 = '$a_trabalho',
				 doente_trabalho = '$doente_trabalho',
				 anotacao 		 = '$anotacao',
				 obs2 			 = '$obs2',
				 boca 			 = '$boca',
				 nariz 			 = '$nariz',
				 lingua 		 = '$lingua',
				 ouvido 		 = '$ouvido',
				 faringe 		 = '$faringe',
				 amigdala 		 = '$amigdala',
				 laringe 		 = '$laringe',
				 tireoide 		 = '$tireoide',
				 coracao 		 = '$coracao',
				 pulmao 		 = '$pulmao',
				 hernia 		 = '$hernia',
				 aneis 			 = '$aneis',
				 varicocele 	 = '$varicocele',
				 hidroxila 		 = '$hidroxila',
				 dum 			 = '$dum',
				 corrimento 	 = '$corrimento',
				 isquemia 		 = '$isquemia',
				 edema 			 = 'edema',
				 formacao 		 = '$formacao',
				 calos 			 = '$calos',
				 p_plano 		 = '$p_plano',
				 mucosa 		 = '$mucosa',
				 c_vertebral 	 = '$c_vertebral',
				 p_arterial 	 = '$p_arterial',
				 pulso 			 = '$pulso',
				 altura 		 = '$altura',
				 peso 			 = '$peso',
				 resultado 		 = '$resultado',
				 varize 		 = '$varize',
				 obs3 			 = '$obs3',
				 g_sanguinio	 = '$g_sanguinio',
 				 diab	 		 = '$diab',
				 can	 		 = '$can',
				 alerg	 		 = '$alerg',
				 urtic	 		 = '$urtic',
				 press	 		 = '$press',
				 nerv	 		 = '$nerv',
				 d_cor	 		 = '$d_cor',
				 d_peito	 	 = '$d_peito',
				 asma2	 		 = '$asma2',
				 renite	 		 = '$renite',
				 d_costa	 	 = '$d_costa',
				 d_figo	 		 = '$d_figo',
				 ulce	 		 = '$ulce',
				 t_croni	 	 = '$t_croni',
				 sinu			 = '$sinu',
				 otit	 		 = '$otit',
				 zumbi	 		 = '$zumbi',
				 d_ment	 		 = '$d_ment',
				 d_cab	 		 = '$d_cab',
				 conv	 		 = '$conv',
				 d_pele	 		 = '$d_pele',
				 d_jun			 = '$d_jun',
				 vari			 = '$vari',
				 hemo			 = '$hemo',
				 beb			 = '$beb'
				 WHERE cod_cliente = $_GET[cod_cliente] AND cod_func = $_GET[cod_f]";
		$res_grava = pg_query($grava);	
	}
}

//BUSCA DO PRONTUÁRIO
if($cod_f != ""){
	$abc = "SELECT p.*
			FROM funcionarios f, prontuario p
			WHERE f.cod_func = {$_GET[cod_f]} 
			AND f.cod_cliente = {$_GET[cod_cliente]}
			AND	f.cod_cliente = p.cod_cliente
			AND f.cod_func = p.cod_func";
	$r_abc = pg_query($abc);
	$row_abc = pg_fetch_array($r_abc);
}
?>
<html>
<head>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">

<script language="javascript" type="text/javascript" src="../scripts.js"></script>
<script language="javascript" type="text/javascript">
function rrgt(v){
    location.href='?cod_f='+v.value+'&cod_cliente='+document.getElementById('cliente').value;
}
</script>
</head>
<body bgcolor="#006633" text="#FFFFFF">
<form method="post">
<table align="center" border="0">
	<tr>
		<td class="fontebranca12" align="center"><p><br><b>Prontuário Médico</b></td>
	</tr>
</table><br />
<?php 
if (!empty($_GET[cod_cliente])) {
		$sql_busca = "select cliente_id, razao_social, p.*, fu.nome_funcao
					  from cliente c, prontuario p, funcionarios f, funcao fu
					  where c.cliente_id = p.cod_cliente
					  AND c.cliente_id = f.cod_cliente
					  AND f.cod_cliente = p.cod_cliente
					  AND f.cod_func = p.cod_func
					  AND f.cod_funcao = fu.cod_funcao
					  AND c.cliente_id = $_GET[cod_cliente]";
		
		$consulta_busca = pg_query($connect, $sql_busca);
		
		$row_busca = pg_fetch_array($consulta_busca);
}
?>
<table align="center" width="750" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td width="750" align="left" class="fontebranca12">Empresa:&nbsp;<?php echo $row_busca[razao_social]; ?></td>
		<input type="hidden" name="cliente" id="cliente" value="<?php echo $row_busca[cliente_id]; ?>" />
	</tr>
	<tr>
		<td align="left" class="fontebranca12">Nome:&nbsp;<select name="cod_func" id="cod_func" onBlur="if(this.value!='')rrgt(this);">
		<option value=''></option>
			<?php
				$func = "SELECT nome_func, sexo_func, civil, cor, data_nasc_func, naturalidade, endereco_func, nome_funcao, rg, cod_func
						FROM funcionarios f, cliente c, funcao fu
						WHERE f.cod_cliente = c.cliente_id
						AND f.cod_funcao = fu.cod_funcao
						AND f.cod_cliente = {$_GET[cod_cliente]} ORDER BY nome_func";
				$res_func = pg_query($func);
				while($row_func = pg_fetch_array($res_func)) {
					echo "<option value=\"$row_func[cod_func]\" ";
					print $_GET[cod_f] == $row_func[cod_func] ? " selected " : ""; 					
					echo " >". ucwords(strtolower($row_func[nome_func]))."</option>";
				}
			?>
		</select>
		<input type="button" name="btn" value="OK" /></td>
	</tr>
</table>
<table align="center" width="750" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<?php
		if($_GET[cod_f] != ""){
		    $sql = "SELECT func.*, f.nome_funcao 
					FROM funcionarios func, funcao f, cliente c
					WHERE func.cod_func = {$_GET[cod_f]} 
					AND func.cod_cliente = {$_GET[cod_cliente]}
					AND	f.cod_funcao = func.cod_funcao
					AND func.cod_cliente = c.cliente_id";
			$res = pg_query($sql);
			$fd = pg_fetch_array($res);
	?>
	<tr>
		<td width="630" align="left" class="fontebranca12">Função:&nbsp;<?php echo $fd[nome_funcao]; ?> </td>
		<td width="115" align="left" class="fontebranca12">RG:&nbsp;<?php echo $fd[rg]; ?></td>
	</tr>
</table>
<table align="center" width="750" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td width="150" align="left" class="fontebranca12">Sexo:&nbsp;<?php echo $fd[sexo_func]; ?></td>
		<td width="150" align="left" class="fontebranca12">Est. Civil:&nbsp;<?php echo $fd[civil]; ?></td>
		<td width="95" align="left" class="fontebranca12">Cor:&nbsp;<?php echo $fd[cor]; ?></td>
		<td width="150" align="left" class="fontebranca12">Nasc.:&nbsp;<?php echo $fd[data_nasc_func]; ?></td>
		<td width="150" align="left" class="fontebranca12">Natural:&nbsp;<?php echo $fd[naturalidade]; ?></td>
	</tr>
</table>
<table align="center" width="750" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td align="left" width="750" class="fontebranca12">Endereço:&nbsp;<?php echo $fd[endereco_func]; ?></td>
	</tr>
</table><br />
<table align="center" width="750" border="0" cellpadding="2" cellspacing="2" bordercolor="#FFFFFF">
	<tr>
		<td align="left" colspan="5" width="750" class="fontebranca12"><b>Antecedentes Familiares:</b><b>Parentesco</b></td>
	</tr>
	<tr>
		<td align="left" width="144" class="fontebranca12"><input type="checkbox" name="tuberculose" value="1" <?php if($row_abc[tuberculose]=="1") echo "checked "; ?>/> Tuberculose</td>
		<td align="left" width="148" class="fontebranca12"><input type="checkbox" name="diab" value="1" <?php if($row_abc[diab]=="1") echo "checked "; ?>/> Diabete</td>
		<td align="left" width="144" class="fontebranca12"><input type="checkbox" name="can" value="1" <?php if($row_abc[can]=="1") echo "checked "; ?>/> Câncer</td>
		<td align="left" width="144" class="fontebranca12"><input type="checkbox" name="asma" value="1" <?php if($row_abc[asma]=="1") echo "checked "; ?>/> Asma</td>
		<td align="left" width="140" class="fontebranca12"><input type="checkbox" name="alerg" value="1" <?php if($row_abc[alerg]=="1") echo "checked "; ?>/> Alergia</td>
	</tr>
	<tr>
		<td align="left" class="fontebranca12"><input type="checkbox" name="urtic" value="1" <?php if($row_abc[urtic]=="1") echo "checked "; ?>/> Urticária</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="d_coracao" value="1" <?php if($row_abc[d_coracao]=="1") echo "checked "; ?>/> Doença do Coração</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="press" value="1" <?php if($row_abc[press]=="1") echo "checked "; ?>/> Pressão Alta</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="d_mental" value="1" <?php if($row_abc[d_mental]=="1") echo "checked "; ?>/> Doença Mental</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="nerv" value="1" <?php if($row_abc[nerv]=="1") echo "checked "; ?>/> Nervosa</td>
	</tr>
	<tr>
		<td align="left" colspan="5" class="fontebranca12">Outras:&nbsp;<textarea name="outras" cols="83" rows="1"><?php echo $row_abc[outras]; ?></textarea></td>
	</tr>
</table><br />
<table align="center" width="750" border="0" cellpadding="2" cellspacing="2" bordercolor="#FFFFFF">
	<tr>
		<td align="left" colspan="5" class="fontebranca12"><b>Antecedentes Pessoais:</b></td>
	</tr>
	<tr>
		<td align="left" width="149" class="fontebranca12"><input type="checkbox" name="d_cor" value="1" <?php if($row_abc[d_cor]=="1") echo "checked "; ?>/> Doença do coração</td>
		<td align="left" width="149" class="fontebranca12"><input type="checkbox" name="pressao_alta" value="1" <?php if($row_abc[pressao_alta]=="1") echo "checked "; ?>/> Pressão alta</td>
		<td align="left" width="149" class="fontebranca12"><input type="checkbox" name="d_peito" value="1" <?php if($row_abc[d_peito]=="1") echo "checked "; ?>/> Dor no Peito</td>
		<td align="left" width="149" class="fontebranca12"><input type="checkbox" name="palpitacao" value="1" <?php if($row_abc[palpitacao]=="1") echo "checked "; ?>/> Palpitação</td>
		<td align="left" width="149" class="fontebranca12"><input type="checkbox" name="bronquite" value="1" <?php if($row_abc[bronquite]=="1") echo "checked "; ?>/>Bronquite</td>
	</tr>
	<tr>
		<td align="left" class="fontebranca12"><input type="checkbox" name="asma2" value="1" <?php if($row_abc[asma2]=="1") echo "checked "; ?>/> Asma</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="renite" value="1" <?php if($row_abc[renite]=="1") echo "checked "; ?>/> Renite</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="d_coluna" value="1" <?php if($row_abc[d_coluna]=="1") echo "checked "; ?>/> Doença de Coluna</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="d_costa" value="1" <?php if($row_abc[d_costa]=="1") echo "checked "; ?>/> Dor na Costas</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="rins" value="1" <?php if($row_abc[rins]=="1") echo "checked "; ?>/> Doença Renal(Rins)</td>
	</tr>
	<tr>
		<td align="left" class="fontebranca12"><input type="checkbox" name="d_figo" value="1" <?php if($row_abc[d_figo]=="1") echo "checked "; ?>/> Doença no Fígado</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="diabetes" value="1" <?php if($row_abc[diabetes]=="1") echo "checked "; ?>/> Diabetes</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="ulce" value="1" <?php if($row_abc[ulce]=="1") echo "checked "; ?>/> Úlcera</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="gastrite" value="1" <?php if($row_abc[gastrite]=="1") echo "checked "; ?>/> Gastrite</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="resfriado" value="1" <?php if($row_abc[resfriado]=="1") echo "checked "; ?>/> Resfriado</td>
	</tr>
	<tr>
		<td align="left" class="fontebranca12"><input type="checkbox" name="t_croni" value="1" <?php if($row_abc[t_croni]=="1") echo "checked "; ?>/> Tosse Crônica</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="sinu" value="1" <?php if($row_abc[sinu]=="1") echo "checked "; ?>/> Sinusite</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="enxerga" value="1" <?php if($row_abc[enxerga]=="1") echo "checked "; ?>/> Enxerga bem</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="ouve" value="1" <?php if($row_abc[ouve]=="1") echo "checked "; ?>/> Ouve bem</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="otit" value="1" <?php if($row_abc[otit]=="1") echo "checked "; ?>/> Otite</td>
	</tr>
	<tr>
		<td align="left" class="fontebranca12"><input type="checkbox" name="zumbi" value="1" <?php if($row_abc[zumbi]=="1") echo "checked "; ?>/> Zumbido</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="internado" value="1" <?php if($row_abc[internado]=="1") echo "checked "; ?>/> Já esteve internado</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="gravida" value="1" <?php if($row_abc[gravida]=="1") echo "checked "; ?>/> Encontra-se grávida</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="d_ment" value="1" <?php if($row_abc[d_ment]=="1") echo "checked "; ?>/> Doença mental</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="nervosa" value="1" <?php if($row_abc[nervosa]=="1") echo "checked "; ?>/> Nervosa</td>
	</tr>
	<tr>
		<td align="left" class="fontebranca12"><input type="checkbox" name="d_cab" value="1" <?php if($row_abc[d_cab]=="1") echo "checked "; ?>/> Dor de cabeça</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="tontura" value="1" <?php if($row_abc[tontura]=="1") echo "checked "; ?>/> Tontura</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="conv" value="1" <?php if($row_abc[conv]=="1") echo "checked "; ?>/> Convulsões</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="alergia" value="1" <?php if($row_abc[alergia]=="1") echo "checked "; ?>/> Alergia</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="d_pele" value="1" <?php if($row_abc[d_pele]=="1") echo "checked "; ?>/> Doença de pele</td>
	</tr>
	<tr>
		<td align="left" class="fontebranca12"><input type="checkbox" name="reumatismo" value="1" <?php if($row_abc[reumatismo]=="1") echo "checked "; ?>/> Reumatismo</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="d_jun" value="1" <?php if($row_abc[d_jun]=="1") echo "checked "; ?>/> Dor nas juntas</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="varizes" value="1" <?php if($row_abc[varizes]=="1") echo "checked "; ?>/> Varizes</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="vari" value="1" <?php if($row_abc[vari]=="1") echo "checked "; ?>/> Varicocele</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="hern" value="1" <?php if($row_abc[hern]=="1") echo "checked "; ?>/> Hérnias</td>
	</tr>
	<tr>
		<td align="left" class="fontebranca12"><input type="checkbox" name="hemo" value="1" <?php if($row_abc[hemo]=="1") echo "checked "; ?>/> Hemorróidas</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="diarreia" value="1" <?php if($row_abc[diarreia]=="1") echo "checked "; ?>/> Diarréia frequente</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="sofreu_d" value="1" <?php if($row_abc[sofreu_d]=="1") echo "checked "; ?>/> Sofreu doença não mencionada</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="tarefas_p" value="1" <?php if($row_abc[tarefas_p]=="1") echo "checked "; ?>/> Pode executar tarefas pesadas</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="d_fisico" value="1" <?php if($row_abc[d_fisico]=="1") echo "checked "; ?>/> Deficiência física</td>
	</tr>
	<tr>
		<td align="left" class="fontebranca12"><input type="checkbox" name="cirurgia" value="1" <?php if($row_abc[cirurgia]=="1") echo "checked "; ?>/> Já fez cirurgia</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="tabagismo" value="1" <?php if($row_abc[tabagismo]=="1") echo "checked "; ?>/> Fuma</td>
		<td align="left" class="fontebranca12"><input type="checkbox" name="beb" value="1" <?php if($row_abc[beb]=="1") echo "checked "; ?>/> Bebe</td>
		<td align="left" colspan="2" class="fontebranca12">Grupo Sanguinio e Fator RH&nbsp;<input type="text" name="g_sanguinio" size="5" value="<?php echo $row_abc[g_sanguinio]; ?>" /></td>
	</tr>
	<tr>
		<td align="left" colspan="5" class="fontebranca12">OBS:&nbsp;<textarea name="obs" cols="85" rows="1"><?php echo $row_abc[obs]; ?></textarea></td>
	</tr>
</table><br />
<table align="center" width="750" border="0" cellpadding="2" cellspacing="2" bordercolor="#FFFFFF">
	<tr>
		<td align="left" colspan="4" width="745" class="fontebranca12"><b>Antecedentes Ocupacionais:</b></td>
	</tr>
	<tr>
		<td align="left" width="360" class="fontebranca12">Suas condições de saúde exige trabalho especial?&nbsp;</td>
		<td align="left" width="13" class="fontebranca12"><select name="t_especial">
			<option value="Sim" <?php if($row_abc[t_especial]=="Sim") echo "selected"; ?>>Sim</option>
			<option value="Não" <?php if($row_abc[t_especial]=="Não") echo "selected"; ?>>Não</option>
		</select></td>
		<td align="left" width="360" class="fontebranca12">Recebeu indenização por acidente de trabalho?&nbsp;</td>
		<td align="left" width="12" class="fontebranca12"><select name="a_trabalho">
			<option value="Sim" <?php if($row_abc[a_trabalho]=="Sim") echo "selected"; ?>>Sim</option>
			<option value="Não" <?php if($row_abc[a_trabalho]=="Não") echo "selected"; ?>>Não</option>
		</select></td>
	</tr>
	<tr>
		<td align="left" class="fontebranca12">Perdeu dias detrabalho por motivo de saúde?&nbsp;</td>
		<td align="left" class="fontebranca12"><select name="p_trabalho">
			<option value="Sim" <?php if($row_abc[p_trabalho]=="Sim") echo "selected"; ?>>Sim</option>
			<option value="Não" <?php if($row_abc[p_trabalho]=="Não") echo "selected"; ?>>Não</option>
		</select></td>
		<td align="left" class="fontebranca12">Esteve doente devido seu trabalho?&nbsp;</td>
		<td align="left" class="fontebranca12"><select name="doente_trabalho">
			<option value="Sim" <?php if($row_abc[doente_trabalho]=="Sim") echo "selected"; ?>>Sim</option>
			<option value="Não" <?php if($row_abc[doente_trabalho]=="Não") echo "selected"; ?>>Não</option>
		</select></td>
	</tr>
	<tr>
		<td align="left" class="fontebranca12">Esteve afastado pelo I.N.P.S.?&nbsp;</td>
		<td align="left" class="fontebranca12"><select name="inps">
			<option value="Sim" <?php if($row_abc[inps]=="Sim") echo "selected"; ?>>Sim</option>
			<option value="Não" <?php if($row_abc[inps]=="Não") echo "selected"; ?>>Não</option>
		</select></td>
	</tr>
	<tr>
		<td align="left" colspan="4" class="fontebranca12">Anotação(tratamentos-remédios):&nbsp;<textarea name="anotacao" cols="65" rows="1"><?php echo $row_abc[anotacao]; ?></textarea></td>
	</tr>
	<tr>
		<td align="left" colspan="4" class="fontebranca12">OBS:&nbsp;<textarea name="obs2" cols="85" rows="1"><?php echo $row_abc[obs2]; ?></textarea></td>
	</tr>
</table><br />
<table align="center" width="750" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td align="left" colspan="4" width="745" class="fontebranca12"><b>Exame Físico:</b></td>
	</tr>
	<tr>
		<td width="373" align="center" class="fontebranca12" colspan="2"><b>Cabeça:</b></td>
		<td width="372" align="center" class="fontebranca12" colspan="2"><b>Pescoço:</b></td>
	</tr>
	<tr>
		<td align="right" class="fontebranca12" width="170">Boca/Dente:&nbsp;</td>
		<td align="left" class="fontebranca12" width="200"><input type="text" name="boca" size="30" value="<?php echo $row_abc[boca]; ?>" /></td>
		<td align="right" class="fontebranca12" width="170">Faringe:&nbsp;</td>
		<td align="left" class="fontebranca12" width="200"><input type="text" name="faringe" size="30" value="<?php echo $row_abc[faringe]; ?>" /></td>
	</tr>
	<tr>
		<td align="right" class="fontebranca12">Nariz:&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="nariz" size="30" value="<?php echo $row_abc[nariz]; ?>" /></td>
		<td align="right" class="fontebranca12">Amigdalas:&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="amigdala" size="30" value="<?php echo $row_abc[amigdala]; ?>" /></td>
	</tr>
	<tr>
		<td align="right" class="fontebranca12">Língua:&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="lingua" size="30" value="<?php echo $row_abc[lingua]; ?>" /></td>
		<td align="right" class="fontebranca12">Laringe:&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="laringe" size="30" value="<?php echo $row_abc[laringe]; ?>" /></td>
	</tr>
	<tr>
		<td align="right" class="fontebranca12">Ouvidos:&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="ouvido" size="30" value="<?php echo $row_abc[ouvido]; ?>" /></td>
		<td align="right" class="fontebranca12">Tireóide:&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="tireoide" size="30" value="<?php echo $row_abc[tireoide]; ?>" /></td>
	</tr>
	<tr>
		<td align="center" class="fontebranca12" colspan="2"><b>Torax:</b></td>
		<td align="center" class="fontebranca12" colspan="2"><b>Abdomen:</b></td>
	</tr>
	<tr>
		<td align="right" class="fontebranca12">Coração:&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="coracao" size="30" value="<?php echo $row_abc[coracao]; ?>" /></td>
		<td align="right" class="fontebranca12">Hérnias:&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="hernia" size="30" value="<?php echo $row_abc[hernia]; ?>" /></td>
	</tr>
	<tr>
		<td align="right" class="fontebranca12">Pulmão:&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="pulmao" size="30" value="<?php echo $row_abc[pulmao]; ?>" /></td>
		<td align="right" class="fontebranca12">Anéis:&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="aneis" size="30" value="<?php echo $row_abc[aneis]; ?>" /></td>
	</tr>
	<tr>
		<td align="center" class="fontebranca12" colspan="2"><b>Membros:</b></td>
		<td align="center" class="fontebranca12" colspan="2"><b>Genital:</b></td>
	</tr>
	<tr>
		<td align="right" class="fontebranca12">Isquemia:&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="isquemia" size="30" value="<?php echo $row_abc[isquemia]; ?>" /></td>
		<td align="right" class="fontebranca12">Varicocele:&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="varicocele" size="30" value="<?php echo $row_abc[varicocele]; ?>" /></td>
	</tr>
	<tr>
		<td align="right" class="fontebranca12">Edemas:&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="edema" size="30" value="<?php echo $row_abc[edema]; ?>" /></td>
		<td align="right" class="fontebranca12">Hidroxila:&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="hidroxila" size="30" value="<?php echo $row_abc[hidroxila]; ?>" /></td>
	</tr>
	<tr>
		<td align="right" class="fontebranca12">Má formação:&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="formacao" size="30" value="<?php echo $row_abc[formacao]; ?>" /></td>
		<td align="right" class="fontebranca12">D.U.M.:&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="dum" size="30" value="<?php echo $row_abc[dum]; ?>" /></td>
	</tr>
	<tr>
		<td align="right" class="fontebranca12">Calos:&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="calos" size="30" value="<?php echo $row_abc[calos]; ?>" /></td>
		<td align="right" class="fontebranca12">Corrimentos:&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="corrimento" size="30" value="<?php echo $row_abc[corrimento]; ?>" /></td>
	</tr>
	<tr>
		<td align="right" class="fontebranca12">Pé plano:&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="p_plano" size="30" value="<?php echo $row_abc[p_plano]; ?>" /></td>
		<td align="right" class="fontebranca12"><b>Pressão arterial:</b>&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="p_arterial" size="30" value="<?php echo $row_abc[p_arterial]; ?>" /></td>
	</tr>
	<tr>
		<td align="right" class="fontebranca12">Pele/mucosa:&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="mucosa" size="30" value="<?php echo $row_abc[mucosa]; ?>" /></td>
		<td align="right" class="fontebranca12"><b>Pulso:</b>&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="pulso" size="30" value="<?php echo $row_abc[pulso]; ?>" /></td>
	</tr>
	<tr>
		<td align="right" class="fontebranca12">Coluna vertebral:&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="c_vertebral" size="30" value="<?php echo $row_abc[c_vertebral]; ?>" /></td>
		<td align="right" class="fontebranca12"><b>Altura:</b>&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="altura" size="30" value="<?php echo $row_abc[altura]; ?>" /></td>
	</tr>
	<tr>
		<td align="right" class="fontebranca12">varizes:&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="varize" size="30" value="<?php echo $row_abc[varize]; ?>" /></td>
		<td align="right" class="fontebranca12"><b>Peso:</b>&nbsp;</td>
		<td align="left" class="fontebranca12"><input type="text" name="peso" size="30" value="<?php echo $row_abc[peso]; ?>" /></td>
	</tr>
	<tr>
		<td align="right" class="fontebranca12">OBS:&nbsp;</td>
		<td align="left" class="fontebranca12" colspan="3"><textarea name="obs3" cols="75" rows="1"><?php echo $row_abc[obs3]; ?></textarea></td>
	</tr>
</table><br />
<?php
if(!empty($_GET['cod_cliente']) && !empty($_GET['cod_f']) && $_POST[btn_enviar] == "Enviar" ){

for($x=0;$x<count($_POST[exa]);$x++){
	$sql = "SELECT *
			  FROM pronto_exame
			  WHERE cod_cliente = {$_GET['cod_cliente']}
			  AND cod_func 	    = {$_GET['cod_f']}
			  AND cod_exame     = {$_POST[exa][$x]}";
	$consult = pg_query($sql);
	

    $dd = explode("/", $_POST[data][$x]);
    $dd = $dd[2]."-".$dd[1]."-".$dd[0];
	    if(pg_num_rows($consult) == 0 ){
            if(!empty($_POST[resultado][$x]) && !empty($_POST[data][$x])){
    		    $query_exame = "INSERT INTO pronto_exame(cod_cliente, cod_func, data, resultado, cod_exame)
        						VALUES
        						({$_GET[cod_cliente]}, {$_GET[cod_f]}, '".$dd."', {$_POST[resultado][$x]}, {$_POST[exa][$x]})";
        		$result_exame = pg_query($query_exame);
    		}
    	}else{
    		$query_exame = "UPDATE pronto_exame SET
    						data 	  = '".$dd."',
    						resultado = '{$_POST[resultado][$x]}'
    						WHERE cod_cliente = {$_GET[cod_cliente]}
    						AND cod_func = {$_GET[cod_f]}
    						AND cod_exame = {$_POST[exa][$x]}";
    		$result_exame = pg_query($query_exame);

    	}
}
}
//CONSULTA DOS EXAMES DOS FUNCIONÁRIOS
if(!empty($_GET['cod_cliente']) && !empty($_GET['cod_f']) ){
	$exa = "SELECT f.nome_func, se.descricao, fu.nome_funcao, e.especialidade, fu.cod_funcao, e.cod_exame, f.cod_func
				FROM funcionarios f, setor_exame se, funcao fu, cliente c, exame e
				WHERE c.cliente_id = f.cod_cliente
				AND f.cod_setor = se.cod_setor
				AND f.cod_funcao = fu.cod_funcao
				AND se.exame_id = e.cod_exame
				AND f.cod_cliente = {$_GET['cod_cliente']}
				AND f.cod_func = {$_GET['cod_f']}";
	$consult = pg_query($exa);
}

?>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" width="200"><div class="style2">&nbsp;<b>Exames</b></div></td>
		<td align="left" width="150"><div class="style2">&nbsp;<b>Datas</b></div></td>
		<td align="left" width="345"><div class="style2">&nbsp;<b>Resultados</b></div></td>
	</tr>
	<?php
		while($r = pg_fetch_array($consult)){
			$data = "SELECT * FROM pronto_exame
					WHERE cod_cliente = {$_GET[cod_cliente]}
					AND cod_func = {$_GET[cod_f]}
					AND cod_exame = $r[cod_exame] ";
			$res_data = pg_query($data);
			$res = pg_fetch_array($res_data);
	?>
	<tr>
		<td align="left"><div class="style2">&nbsp;<?php echo $r[especialidade]; ?></div></td>
		<td align="left"><div class="style2">&nbsp;<input type="text" size="10" name="data[]" value="<?php if($res[data] != ""){ echo date("d/m/Y", strtotime($res[data])); }else{ echo ""; }?>"></div></td>
		<td align="left"><div class="style2">&nbsp;<input type="text" name="resultado[]" value="<?php echo $res[resultado]; ?>">
		<input type="hidden" name="exa[]" value="<?php echo $r[cod_exame]; ?>"></div></td>
	</tr>
	<?php
		}//fecha os exames complementares
	}//fecha todo cadastro
	?>
	<tr>
		<th colspan="4">
		<input type="submit" value="Gravar" name="btn_enviar" class="button" >&nbsp;&nbsp;&nbsp;
		<input name="btn1" type="submit" onClick="MM_goToURL('parent','../medico/lista_prontuario.php'); return document.MM_returnValue" value="Voltar" style="width:100;">&nbsp;&nbsp;&nbsp;
		<input name="btn1" type="submit" onClick="MM_goToURL('parent','../tela_principal.php'); return document.MM_returnValue" value="Sair" style="width:100;">
		</th>
	</tr>
</table>
</form>
</body>
</head>
