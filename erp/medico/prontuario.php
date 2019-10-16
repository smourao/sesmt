<?php
include "../config/connect.php";

$cliente = $_GET["cliente"];
$setor	 = $_GET["setor"];
$func	 = $_GET["funcionario"];

if($cliente != "" and $func != "" ){
	$ppp = "SELECT c.razao_social, c.cnpj, cn.cnae, f.nome_func, f.data_nasc_func, f.sexo_func, f.num_ctps_func, f.serie_ctps_func, f.estado,
			f.data_admissao_func, f.cbo, s.nome_setor, fu.nome_funcao, fu.dsc_funcao, f.pis, f.pdh, f.revezamento
			FROM cliente c, cnae cn, funcionarios f, setor s, funcao fu
			WHERE c.cliente_id = f.cod_cliente
			AND s.cod_setor = f.cod_setor
			AND f.cod_funcao = fu.cod_funcao
			AND cn.cnae_id = c.cnae_id
			AND f.cod_func = $func
			AND c.cliente_id = $cliente";
	$res = pg_query($connect, $ppp);
	$row = pg_fetch_array($res);
}

//BUSCA DADOS DA EXAMINADORA
if($cliente != ""){
	$busca = "SELECT nome, ctps, email
			  FROM funcionario
			  WHERE funcionario_id = 21";
	$r = pg_query($connect, $busca);
	$rr = pg_fetch_array($r);
}

//BUSCA OS FATORES DE RISCO REALIZADOS DA II SE��O
if($cliente != "" and $func != "" ){
	$exame = "SELECT Distinct(nome_tipo_risco) as nome, itensidade, epc_eficaz, ca
			FROM tipo_risco tp, agente_risco ar, risco_setor rs, funcionarios f, cliente_setor cs
			WHERE rs.cod_cliente = f.cod_cliente
			AND rs.cod_setor = f.cod_setor
			AND tp.cod_tipo_risco = ar.cod_tipo_risco
			AND ar.cod_agente_risco = rs.cod_agente_risco
			AND rs.cod_cliente = cs.cod_cliente
			AND rs.cod_setor = cs.cod_setor
			AND rs.cod_cliente = $cliente
			AND f.cod_func = $func";
	$result = pg_query($connect, $exame);
	$r_res = pg_fetch_all($result);
}
	
//BUSCA A MONITORA��O BIOL�GICA DA III SE��O
if($cliente != "" and $func != "" ){
	$risco = "SELECT e.especialidade, a.tipo_exame, a.aso_data
			   FROM aso_exame ae, aso a, exame e, cliente c, funcionarios f
			   WHERE ae.cod_exame = e.cod_exame
			   AND a.cod_func = f.cod_func
			   AND c.cliente_id = f.cod_cliente
			   AND a.cod_cliente = c.cliente_id
			   AND ae.cod_aso = a.cod_aso
			   AND c.cliente_id = $cliente
			   AND a.cod_func = $func";
	$resu = pg_query($connect, $risco);
	$r_resu = pg_fetch_array($resu);
}

//CONSULTA PARA VERIFICAR SE O EPI � EFICAZ
if($cliente != "" and $setor != "" ){
	$epi = "select s.* 
			from setor_epi se, sugestao s, cliente_setor cs
			where cs.cod_cliente = s.cod_cliente
			and cs.cod_setor = s.cod_setor
			and s.cod_setor = se.cod_setor
			and s.med_prev = se.id
			and s.cod_cliente = $cliente
			and s.cod_setor = $setor";
	$res_epi = pg_query($connect, $epi);
	$row_epi = pg_fetch_array($res_epi);
}
?>

<html>
<head>
<title>..:: SESMT ::.. Prontu�rio M�dico</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../scripts.js"></script>
</head>
<body>
<form name="frm_prontuario" action="prontuario.php" method="post">
<table align="center" width="701" height="1040" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
<tr><td valign="top"><br>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="center" class="fontepreta12bold">SESMT - Servi�o Especializado de Seguran�a e Monit. de Ativ. no Trab. LTDA<br>Prontu�rio M�dico</td>
	</tr>
</table>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" class="fontepreta12">&nbsp;Empresa:&nbsp;</td>
	</tr>
</table>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" class="fontepreta12">&nbsp;Nome:&nbsp;</td>
	</tr>
</table>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" width="290" class="fontepreta12">&nbsp;Fun��o:&nbsp;</td>
		<td align="left" width="90" class="fontepreta12">&nbsp;RG:&nbsp;</td>
		<td align="left" width="150" class="fontepreta12">&nbsp;Sexo:&nbsp;</td>
	</tr>
</table>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" width="175" class="fontepreta12">&nbsp;Est. Civil:&nbsp;</td>
		<td align="left" width="175" class="fontepreta12">&nbsp;Cor:&nbsp;</td>
		<td align="left" width="174" class="fontepreta12">&nbsp;Nasc.:&nbsp;</td>
		<td align="left" width="174" class="fontepreta12">&nbsp;Natural:&nbsp;</td>
	</tr>
</table><br>
<table align="center" width="700" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="7" width="699" class="fontepreta12bold">&nbsp;Antecedendes Familiares: 
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Parentesco</td>
	</tr>
	<tr>
		<td align="left" width="300" class="fontepreta12">&nbsp;&bull;&nbsp;Tuberculose/Diabete/C�ncer</td>
		<td align="left" width="300" class="fontepreta12">&nbsp;&bull;&nbsp;Doen�a Cora��o/Press�o Alta</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Asma /Alergias/Urtic�ria</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Doen�a Mental/Nervosa</td>
	</tr>
	<tr>
		<td align="left" colspan="2" class="fontepreta12">&nbsp;&bull;&nbsp;Outras</td>
	</tr>
</table><br>
<table align="center" width="700" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="3" width="699" class="fontepreta12bold">&nbsp;Antecedentes Pessoais</td>
	</tr>
	<tr>
		<td align="left" width="238" class="fontepreta12">&nbsp;&bull;&nbsp;Doen�a do Cora��o/Press�o Alta ( )</td>
		<td align="left" width="230" class="fontepreta12">&nbsp;&bull;&nbsp;Enxerga bem ( )</td>
		<td align="left" width="230" class="fontepreta12">&nbsp;&bull;&nbsp;Varizes/Varicocele/H�rnias ( )</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Dor no Peito/Palpita��o ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Ouve bem/Otite/Zumbido ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Hemorr�idas/Diarr�ia Frequente ( )</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Bronquite/Asma/Rinite ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;J� Esteve Internado ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Sofreu Doen�a N�o Mencionada ( )</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Doen�a na Coluna/Dor nas Costas ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Encontra-se Gr�vida ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Pode Executar Tarefas Pesadas ( )</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Doen�as Renais (Rins) ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Doen�a Mental/Nervosa ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Tem Algum Defeito F�sico ( )</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Doen�a do F�gado/Diabetes ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Dor de Cabe�a/Tontura/Convuls�es ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Sofreu Alguma Cirurgia ( )</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;�lcera/Gastrite ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Alergia/Doen�a de Pele ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Tabagismo(fumo)/Etilismo(bebe) ( )</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Resfriado/Tosse Cr�nica/Sinusite ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Reumatismo/Dor nas Juntas ( )</td>
		<td align="left" class="fontepreta12">&nbsp;</td>
	</tr>
	<tr>
		<td align="left" colspan="3" class="fontepreta12">&nbsp;&bull;&nbsp;Obs:???</td>
	</tr>
</table>
<table align="center" width="700" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="2" width="699" class="fontepreta12bold">&nbsp;Antecedentes Ocupacionais</td>
	</tr>
	<tr>
		<td align="left" width="345" class="fontepreta12">&nbsp;&bull;&nbsp;Suas condi��es de sa�de exige trabalho especial ( )</td>
		<td align="left" width="345" class="fontepreta12">&nbsp;&bull;&nbsp;Recebeu indeniza��o por acidente de trabalho ( )</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Perdeu dias de trabalho por motivo de sa�de ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Esteve doente devido seu trabalho ( )</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Esteve afastado pelo I.N.P.S. ( )</td>
		<td align="left" class="fontepreta12">&nbsp;</td>
	</tr>
	<tr>
		<td align="left" colspan="2" class="fontepreta12">&nbsp;Anota��es(tratamento-rem�dios):???</td>
	</tr>
	<tr>
		<td align="left" colspan="2" class="fontepreta12bold">&nbsp;OBS:???</td>
	</tr>
</table><br>
<table align="center" width="700" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="4" width="699" class="fontepreta12bold">&nbsp;Exame F�sico</td>
	</tr>
	<tr>
		<td align="left" width="90" class="fontepreta12bold">&nbsp;Cabe�a:</td>
		<td align="left" width="80" class="fontepreta12bold">&nbsp;Pesco�o:</td>
		<td align="left" width="115" class="fontepreta12bold">&nbsp;T�rax:</td>
		<td align="left" width="85" class="fontepreta12bold">&nbsp;Abdomen:</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;Boca/Dente:</td>
		<td align="left" class="fontepreta12">&nbsp;Faringe:</td>
		<td align="left" class="fontepreta12">&nbsp;Cora��o:</td>
		<td align="left" class="fontepreta12">&nbsp;H�rnias:</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;Nariz:</td>
		<td align="left" class="fontepreta12">&nbsp;Amigdalas:</td>
		<td align="left" class="fontepreta12">&nbsp;Pulm�es:</td>
		<td align="left" class="fontepreta12">&nbsp;An�is:</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;L�ngua:</td>
		<td align="left" class="fontepreta12">&nbsp;Laringe:</td>
		<td align="left" class="fontepreta12">&nbsp;</td>
		<td align="left" class="fontepreta12">&nbsp;</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;Ouvidos:</td>
		<td align="left" class="fontepreta12">&nbsp;Tire�ide:</td>
		<td align="left" class="fontepreta12">&nbsp;</td>
		<td align="left" class="fontepreta12">&nbsp;</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12bold">&nbsp;Genital:</td>
		<td align="left" class="fontepreta12bold">&nbsp;Membros:</td>
		<td align="left" class="fontepreta12bold">&nbsp;</td>
		<td align="left" class="fontepreta12bold">&nbsp;</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;Varicocele:</td>
		<td align="left" class="fontepreta12">&nbsp;Isquemia:</td>
		<td align="left" class="fontepreta12">&nbsp;P� Plano:</td>
		<td align="left" class="fontepreta12">&nbsp;Press�o Arterial:</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;Hidroxila:</td>
		<td align="left" class="fontepreta12">&nbsp;Edemas:</td>
		<td align="left" class="fontepreta12">&nbsp;Pele/Mucosa:</td>
		<td align="left" class="fontepreta12">&nbsp;Pulso:</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;D.U.M.:</td>
		<td align="left" class="fontepreta12">&nbsp;M� Forma��o:</td>
		<td align="left" class="fontepreta12">&nbsp;Coluna Vertebral:</td>
		<td align="left" class="fontepreta12">&nbsp;Altura:</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;Corrimentos:</td>
		<td align="left" class="fontepreta12">&nbsp;Calos:</td>
		<td align="left" class="fontepreta12">&nbsp;Varizes:</td>
		<td align="left" class="fontepreta12">&nbsp;Peso:</td>
	</tr>
	<tr>
		<td align="left" colspan="4" class="fontepreta12bold">&nbsp;OBS:</td>
	</tr>
</table><br>
<table align="center" width="700" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" class="fontepreta12bold">&nbsp;Exames Complementares:</td>
	</tr>
</table>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" width="200" class="fontepreta12">&nbsp;Exames</td>
		<td align="left" width="150" class="fontepreta12">&nbsp;Datas</td>
		<td align="left" width="345" class="fontepreta12">&nbsp;Resultados</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;<?php $dat = explode("/", $row[data_admissao_func]); echo date("d/m/Y", strtotime($dat[2]."/".$dat[1]."/".$dat[0])); ?> � &nbsp;<?php $dt = explode("/", $row[data_demissao_func]); echo date("d/m/Y", strtotime($dt[2]."/".$dt[1]."/".$dt[0])); ?></td>
		<td align="left" class="fontepreta12">&nbsp;<?php echo $rr[ctps]; ?></td>
		<td align="left" class="fontepreta12">&nbsp;<?php echo $rr[email]; ?></td>
	</tr>
</table><p><br>
<table align="center" width="700" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" width="669" class="fontepreta12">Assino como prova de ter declarado a verdade:<p>Rio de Janeiro, dia/m�s/ano</td>	
	</tr>
</table><p><br>
<table align="center" width="700" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="center" width="340" class="fontepreta12">&nbsp;________________________<br>Assinatura do Candidato</td>
		<td align="center" width="340" class="fontepreta12">&nbsp;________________________<br>Assinatura do Examinador</td>
	</tr>
</table>
</td></tr>
</table>
</form>
</body>
</html>