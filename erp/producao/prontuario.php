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

//BUSCA OS FATORES DE RISCO REALIZADOS DA II SEÇÃO
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
	
//BUSCA A MONITORAÇÃO BIOLÓGICA DA III SEÇÃO
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

//CONSULTA PARA VERIFICAR SE O EPI É EFICAZ
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
<title>..:: SESMT ::.. Prontuário Médico</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../scripts.js"></script>
</head>
<body>
<form name="frm_prontuario" action="prontuario.php" method="post">
<table align="center" width="701" height="1040" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
<tr><td valign="top"><br>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="center" class="fontepreta12bold">SESMT - Serviço Especializado de Segurança e Monit. de Ativ. no Trab. LTDA<br>Prontuário Médico</td>
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
		<td align="left" width="290" class="fontepreta12">&nbsp;Função:&nbsp;</td>
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
		<td align="left" width="300" class="fontepreta12">&nbsp;&bull;&nbsp;Tuberculose/Diabete/Câncer</td>
		<td align="left" width="300" class="fontepreta12">&nbsp;&bull;&nbsp;Doença Coração/Pressão Alta</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Asma /Alergias/Urticária</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Doença Mental/Nervosa</td>
	</tr>
	<tr>
		<td align="left" colspan="2" class="fontepreta12">&nbsp;&bull;&nbsp;Outras</td>
	</tr>
</table>
<table align="center" width="700" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="3" width="699" class="fontepreta12bold">&nbsp;Antecedentes Pessoais</td>
	</tr>
	<tr>
		<td align="left" width="238" class="fontepreta12">&nbsp;&bull;&nbsp;Doença do Coração/Pressão Alta ( )</td>
		<td align="left" width="230" class="fontepreta12">&nbsp;&bull;&nbsp;Enxerga bem ( )</td>
		<td align="left" width="230" class="fontepreta12">&nbsp;&bull;&nbsp;Varizes/Varicocele/Hérnias ( )</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Dor no Peito/Palpitação ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Ouve bem/Otite/Zumbido ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Hemorróidas/Diarréia Frequente ( )</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Bronquite/Asma/Rinite ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Já Esteve Internado ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Sofreu Doença Não Mencionada ( )</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Doença na Coluna/Dor nas Costas ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Encontra-se Grávida ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Pode Executar Tarefas Pesadas ( )</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Doenças Renais (Rins) ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Doença Mental/Nervosa ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Tem Algum Defeito Físico ( )</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Doença do Fígado/Diabetes ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Dor de Cabeça/Tontura/Convulsões ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Sofreu Alguma Cirurgia ( )</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Úlcera/Gastrite ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Alergia/Doença de Pele ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Tabagismo(fumo)/Etilismo(bebe) ( )</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Resfriado/Tosse Crônica/Sinusite ( )</td>
		<td align="left" class="fontepreta12">&nbsp;&bull;&nbsp;Reumatismo/Dor nas Juntas ( )</td>
		<td align="left" class="fontepreta12">&nbsp;</td>
	</tr>
	<tr>
		<td align="left" colspan="3" class="fontepreta12">&nbsp;&bull;&nbsp;Obs:</td>
	</tr>

</table>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="center" width="20" class="fontepreta12bold">II</td>
		<td align="left" width="679" class="fontepreta12bold">&nbsp;Seção de Registros Ambientais</td>
	</tr>
</table>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="8" width="699" class="fontepreta12">&nbsp;15-Exposição a Fatores de Riscos</td>
	</tr>
	<tr>
		<td align="left" width="90" class="fontepreta12">&nbsp;15.1-Período</td>
		<td align="left" width="80" class="fontepreta12">&nbsp;15.2-Tipo</td>
		<td align="left" width="115" class="fontepreta12">&nbsp;15.3-Fator de Risco</td>
		<td align="left" width="85" class="fontepreta12">&nbsp;15.4-Itens./Conc.</td>
		<td align="left" width="80" class="fontepreta12">&nbsp;15.5-Téc. Utilizada</td>
		<td align="left" width="80" class="fontepreta12">&nbsp;15.6-EPC Eficaz(S/N)</td>
		<td align="left" width="80" class="fontepreta12">&nbsp;15.7-EPI Eficaz(S/N)</td>
		<td align="left" width="80" class="fontepreta12">&nbsp;15.8-CA EPI</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;<?php $dat = explode("/", $row[data_admissao_func]); echo date("d/m/Y", strtotime($dat[2]."/".$dat[1]."/".$dat[0])); ?> à &nbsp;<?php $dt = explode("/", $row[data_demissao_func]); echo date("d/m/Y", strtotime($dt[2]."/".$dt[1]."/".$dt[0])); ?></td>
		<td align="center" class="fontepreta12">&nbsp;<?php for($x=0; $x<pg_num_rows($result); $x++){ echo substr($r_res[$x][nome],0,1)."&nbsp;"; } ?></td>
		<td align="center" class="fontepreta12">&nbsp;<?php for($y=0; $y<pg_num_rows($result); $y++){ echo $r_res[$y][nome]."<br>"; } ?></td>
		<td align="left" class="fontepreta12">&nbsp;<?php echo $r_res[0][itensidade]; ?></td>
		<td align="left" class="fontepreta12">&nbsp;Avaliado por aparelhos de medição</td>
		<td align="center" class="fontepreta12">&nbsp;<?php echo $r_res[0][epc_eficaz]; ?></td>
		<td align="center" class="fontepreta12">&nbsp;<?php if($row_epi[plano_acao] == 1){ echo "Sim"; }else{ echo "Não";} ?></td>
		<td align="center" class="fontepreta12">&nbsp;<?php echo $r_res[0][ca]; ?></td>
	</tr>
</table>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="4" width="699" class="fontepreta12">&nbsp;16-Responsável Pelos Registros Ambientais</td>
	</tr>
	<tr>
		<td align="left" width="100" class="fontepreta12">&nbsp;16.1-Período</td>
		<td align="left" width="97" class="fontepreta12">&nbsp;16.2-NIT</td>
		<td align="left" width="215" class="fontepreta12">&nbsp;16.3-Registro de Conselho de Classe</td>
		<td align="left" width="285" class="fontepreta12">&nbsp;16.4-Nome do Profissional Legalmente Habilitado</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;<?php $dat = explode("/", $row[data_admissao_func]); echo date("d/m/Y", strtotime($dat[2]."/".$dat[1]."/".$dat[0])); ?> à &nbsp;<?php $dt = explode("/", $row[data_demissao_func]); echo date("d/m/Y", strtotime($dt[2]."/".$dt[1]."/".$dt[0])); ?></td>
		<td align="left" class="fontepreta12">&nbsp;<?php echo $rr[ctps]; ?></td>
		<td align="left" class="fontepreta12">&nbsp;<?php echo $rr[email]; ?></td>
		<td align="left" class="fontepreta12">&nbsp;<?php echo $rr[nome]; ?></td>
	</tr>
</table>
</td></tr>
</table>
<table align="center" width="701" height="1040" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
<tr><td valign="top">
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="center" width="30" class="fontepreta12bold">III</td>
		<td align="left" width="669" class="fontepreta12bold">&nbsp;Seção de Resultados de Monitoração Biológica</td>	
	</tr>
</table>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="5" width="699" class="fontepreta12">&nbsp;17-Exames Médicos Clínicos e Complementares(Quadros I e II da NR-07)</td>
	</tr>
	<tr>
		<td align="left" width="100" class="fontepreta12">&nbsp;17.1-Data</td>
		<td align="left" width="150" class="fontepreta12">&nbsp;17.2-Tipo</td>
		<td align="left" width="150" class="fontepreta12">&nbsp;17.3-Natureza</td>
		<td align="left" width="150" class="fontepreta12">&nbsp;17.4-Exame(R/S)</td>
		<td align="left" width="148" class="fontepreta12">&nbsp;17.5-Indicação de Resultados</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;<?php echo date("d/m/Y", strtotime($r_resu[aso_data])); ?></td>
		<td align="left" class="fontepreta12">&nbsp;<?php echo $r_resu[tipo_exame]; ?></td>
		<td align="left" class="fontepreta12">&nbsp;<?php echo $r_resu[especialidade]; ?></td>
		<td align="left" class="fontepreta12">&nbsp;</td>
		<td align="left" class="fontepreta12">&nbsp;( ) Normal<br>&nbsp;( ) Alterado<br>&nbsp;( ) Estável<br>&nbsp;( ) Agravamento<br>&nbsp;( ) Ocupacional<br>&nbsp;( ) Não Ocupacional</td>
	</tr>
</table>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="4" width="699" class="fontepreta12">&nbsp;18-Responsável Pela Monitoração Biológica</td>
	</tr>
	<tr>
		<td align="left" width="100" class="fontepreta12">&nbsp;18.1-Peródo</td>
		<td align="left" width="97" class="fontepreta12">&nbsp;18.2-NIT</td>
		<td align="left" width="215" class="fontepreta12">&nbsp;18.3-Registo de Conselho de Classe</td>
		<td align="left" width="285" class="fontepreta12">&nbsp;18.4-Nome do Profissional Legalmente Habilitado</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;<?php $dat = explode("/", $row[data_admissao_func]); echo date("d/m/Y", strtotime($dat[2]."/".$dat[1]."/".$dat[0])); ?> à &nbsp;<?php $dt = explode("/", $row[data_demissao_func]); echo date("d/m/Y", strtotime($dt[2]."/".$dt[1]."/".$dt[0])); ?></td>
		<td align="left" class="fontepreta12">&nbsp;<?php echo $rr[ctps]; ?></td>
		<td align="left" class="fontepreta12">&nbsp;<?php echo $rr[email]; ?></td>
		<td align="left" class="fontepreta12">&nbsp;<?php echo $rr[nome]; ?></td>
	</tr>
</table>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="center" width="30" class="fontepreta12bold">IV</td>
		<td align="left" width="669" class="fontepreta12bold">&nbsp;Seção de Resultados de Monitoração Biológica</td>	
	</tr>
</table>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="justify" width="698" class="fontepreta12">&nbsp;Declaramos, para todos os fins de direitos, que as informações prestadas nesse documento são verídicas e foram transcritas fielmente dos registros administrativos, das demonstrações ambientais e dos programas médicos de responsabilidade da empresa. É de nosso conhecimento que a prestação de informações falsas nesse documento constitui crime de falsificação de documento público, nos termos do art.297 do Código Penal e, também, que tais informações são de caráter privativo do trabalhador, constituindo crime, nos termos da Lei nº 9.029/95, práticas discriminatórias decorrentes de sua exigibilidade por outrem, bem como de sua divulgação para terceiros, ressalvando quando exigida pelos órgãos públicos competentes.</td>
	</tr>
</table>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" width="164" class="fontepreta12">&nbsp;19-Data da Emissão do PPP</td>
		<td align="left" colspan="2" width="530" class="fontepreta12">&nbsp;20-Representante Legal da Empresa</td>
	</tr>
	<tr>
		<td align="left" rowspan="2" class="fontepreta12">&nbsp;</td>
		<td align="left" class="fontepreta12">&nbsp;20.1-NIT</td>
		<td align="left" class="fontepreta12">&nbsp;20.2-Nome</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;(carimbo)</td>
		<td align="left" class="fontepreta12">&nbsp;(assinatura)</td>
	</tr>
</table>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" width="698" class="fontepreta12bold">&nbsp;Observações:</td>
	</tr>
	<tr>
		<td align="justify" class="fontepreta12">&nbsp;</td>
	</tr>
</table>
</td></tr>
</table>
</form>
</body>
</html>