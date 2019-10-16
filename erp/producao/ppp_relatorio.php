<?php
include "../config/connect.php";

$cliente = $_GET["cliente"];
$setor	 = $_GET["setor"];
$func	 = $_GET["funcionario"];

$height = 1050;

if($cliente != "" and $func != "" ){
	$ppp = "SELECT c.*, f.*, s.nome_setor, fu.nome_funcao, fu.dsc_funcao, cn.cnae
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
	$busca = "SELECT admissao, nome, ctps, email, demissao
			  FROM funcionario
			  WHERE funcionario_id = 21";
	$r = pg_query($connect, $busca);
	$rr = pg_fetch_array($r);
}

//BUSCA OS FATORES DE RISCO REALIZADOS DA II SEÇÃO 1ª PARTE
if($cliente != "" and $func != "" ){
	$exames = "SELECT Distinct(nome_tipo_risco) as nome
			FROM tipo_risco tp, agente_risco ar, risco_setor rs, funcionarios f, cliente_setor cs
			WHERE rs.cod_cliente = f.cod_cliente
			AND rs.cod_setor = f.cod_setor
			AND tp.cod_tipo_risco = ar.cod_tipo_risco
			AND ar.cod_agente_risco = rs.cod_agente_risco
			AND rs.cod_cliente = cs.cod_cliente
			AND rs.cod_setor = cs.cod_setor
			AND rs.cod_cliente = $cliente
			AND f.cod_func = $func";
	$resul = pg_query($connect, $exames);
	$r_resul = pg_fetch_all($resul);
}

//BUSCA OS FATORES DE RISCO REALIZADOS DA II SEÇÃO 2ª PARTE
if($cliente != "" and $func != "" ){
	$exame = "SELECT itensidade, epc_eficaz, ca
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
	$risco = "SELECT e.especialidade, a.tipo_exame, ae.data
			   FROM aso_exame ae, aso a, exame e, cliente c, funcionarios f
			   WHERE ae.cod_exame = e.cod_exame
			   AND a.cod_func = f.cod_func
			   AND c.cliente_id = f.cod_cliente
			   AND a.cod_cliente = c.cliente_id
			   AND ae.cod_aso = a.cod_aso
			   AND c.cliente_id = $cliente
			   AND a.cod_func = $func
			   ORDER BY ae.data";
	$resu = pg_query($connect, $risco);
	$r_resu = pg_fetch_all($resu);
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
<title>..:: SESMT ::..</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../scripts.js"></script>
</head>
<body>
<form name="frm_ppp_relatorio" action="ppp_relatorio.php" method="post">
<table align="center" width="701" height="<?php echo $height; ?>" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
<tr>
	<td align="center" class="fontepreta14bold">ANEXO XV<P>INSTRUÇÃO NORMATIVA Nº 27/INSSPRES, DE 30  DE ABRIL DE 2008<P>INSTRUÇÃO NORMATIVA Nº 20/INSSPRES, DE 10 DE OUTUBRO DE 2007<P>PERFIL PROFISSIOGRÁFICO PREVIDENCIÁRIO – PPP</td>
</tr>
<tr><td valign="top">
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="center" width="20" class="fontepreta12bold">I</td>
		<td align="left" width="679" class="fontepreta12bold">&nbsp;Seção de Dados Administrativos</td>
	</tr>
</table>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" width="250" class="fontepreta12">&nbsp;1-CNPJ do Domicílio Tributário/CEI<br>&nbsp;<?php echo $row[cnpj]; ?></td>
		<td align="left" width="350" class="fontepreta12">&nbsp;2-Nome Empresarial<br>&nbsp;<?php echo $row[razao_social]; ?></td>
		<td align="left" width="99" class="fontepreta12">&nbsp;3-CNAE<br>&nbsp;<?php echo $row[cnae]; ?></td>
	</tr>
</table>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" width="500" class="fontepreta12">&nbsp;4-Nome do Trabalhador<br>&nbsp;<?php echo $row[nome_func]; ?></td>
		<td align="left" width="99" class="fontepreta12">&nbsp;5-BR/PDH<br>&nbsp;<?php echo $row[pdh]; ?></td>
		<td align="left" width="100" class="fontepreta12">&nbsp;6-NIT<br>&nbsp;<?php echo $row[pis]; ?></td>
	</tr>
</table>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" width="150" class="fontepreta12">&nbsp;7-Data de Nascimento<br>&nbsp;<?php $dt = explode("/", $row[data_nasc_func]); echo date("d/m/Y", strtotime($dt[2]."/".$dt[1]."/".$dt[0])); ?></td>
		<td align="left" width="90" class="fontepreta12">&nbsp;8-Sexo (M/F)<br>&nbsp;<?php echo $row[sexo_func]; ?></td>
		<td align="left" width="150" class="fontepreta12">&nbsp;9-CTPS (Nº, Série e UF)<br>&nbsp;<?php echo "Nº ".$row[num_ctps_func]."-Série ".$row[serie_ctps_func]."-UF ".$row[estado]; ?></td>
		<td align="left" width="145" class="fontepreta12">&nbsp;10-Data de Admissão<br>&nbsp;<?php $dat = explode("/", $row[data_admissao_func]); echo date("d/m/Y", strtotime($dat[2]."/".$dat[1]."/".$dat[0])); ?></td>
		<td align="left" width="164" class="fontepreta12">&nbsp;11-Regime de Revezamento<br>&nbsp;<?php echo $row[revezamento]; ?></td>
	</tr>
</table>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="4" width="699" class="fontepreta12">&nbsp;12-CAT Registrada</td>
	</tr>
	<tr>
		<td align="left" width="175" class="fontepreta12">&nbsp;12.1-Data de Registro</td>
		<td align="left" width="175" class="fontepreta12">&nbsp;12.2-Número da CAT</td>
		<td align="left" width="174" class="fontepreta12">&nbsp;12.1-Data do Registro</td>
		<td align="left" width="174" class="fontepreta12">&nbsp;12.2-Número da CAT</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;</td>
		<td align="left" class="fontepreta12">&nbsp;</td>
		<td align="left" class="fontepreta12">&nbsp;</td>
		<td align="left" class="fontepreta12">&nbsp;</td>
	</tr>
</table>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="7" width="699" class="fontepreta12">&nbsp;13-Lotação e Atribuição</td>
	</tr>
	<tr>
		<td align="left" width="90" class="fontepreta12">&nbsp;13.1-Período</td>
		<td align="left" width="100" class="fontepreta12">&nbsp;13.2-CNPJ/CEI</td>
		<td align="left" width="100" class="fontepreta12">&nbsp;13.3-Setor</td>
		<td align="left" width="117" class="fontepreta12">&nbsp;13.4-Cargo</td>
		<td align="left" width="117" class="fontepreta12">&nbsp;13.5-Função</td>
		<td align="left" width="80" class="fontepreta12">&nbsp;13.6-CBO</td>
		<td align="left" width="95" class="fontepreta12">&nbsp;13.7-Cód. GFIP</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;
		<?php if($row[cod_status] == "0"){
			$dat = explode("/", $row[data_admissao_func]);
				echo $row[data_admissao_func]." à ".$row[data_desligamento_func];
		}else{
			$dat = explode("/", $row[data_admissao_func]);
				echo $row[data_admissao_func];
		}?></td>
		<td align="left" class="fontepreta12">&nbsp;<?php echo $row[cnpj]; ?></td>
		<td align="left" class="fontepreta12">&nbsp;<?php echo $row[nome_setor]; ?></td>
		<td align="left" class="fontepreta12">&nbsp;<?php echo $row[nome_funcao]; ?></td>
		<td align="left" class="fontepreta12">&nbsp;<?php echo $row[nome_funcao]; ?></td>
		<td align="center" class="fontepreta12">&nbsp;<?php echo $row[cbo]; ?></td>
		<td align="center" class="fontepreta12">&nbsp;<?php echo $row[grau_de_risco]; ?></td>
	</tr>
</table>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="2" width="699" class="fontepreta12">&nbsp;14-Profissiografia</td>
	</tr>
	<tr>
		<td align="left" width="90" class="fontepreta12">&nbsp;14.1-Período</td>
		<td align="left" width="608" class="fontepreta12">&nbsp;14.2-Descrção das Atividades</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;
		<?php if($row[cod_status] == "0"){
			$dat = explode("/", $row[data_admissao_func]);
				echo $row[data_admissao_func]." à ".$row[data_desligamento_func];
		}else{
			$dat = explode("/", $row[data_admissao_func]);
				echo $row[data_admissao_func];
		}?></td>
		<td align="justify" class="fontepreta12">&nbsp;<?php echo $row[dsc_funcao]; ?></td>
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
		<td align="left" class="fontepreta12">&nbsp;
		<?php if($row[cod_status] == "0"){
			$dat = explode("/", $row[data_admissao_func]);
				echo $row[data_admissao_func]." à ".$row[data_desligamento_func];
		}else{
			$dat = explode("/", $row[data_admissao_func]);
				echo $row[data_admissao_func];
		}?></td>
		<td align="center" class="fontepreta12">&nbsp;<?php for($x=0; $x<pg_num_rows($resul); $x++){ echo substr($r_resul[$x][nome],0,1)."&nbsp;"; } ?></td>
		<td align="center" class="fontepreta12">&nbsp;<?php for($y=0; $y<pg_num_rows($resul); $y++){ echo $r_resul[$y][nome]."<br>"; } ?></td>
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
		<td align="left" width="90" class="fontepreta12">&nbsp;16.1-Período</td>
		<td align="left" width="97" class="fontepreta12">&nbsp;16.2-NIT</td>
		<td align="left" width="225" class="fontepreta12">&nbsp;16.3-Registro de Conselho de Classe</td>
		<td align="left" width="285" class="fontepreta12">&nbsp;16.4-Nome do Profissional Legalmente Habilitado</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;
		<?php if($rr[demissao] != ""){
			echo date("d/m/Y", strtotime($rr[admissao]))." à &nbsp;". date("d/m/Y", strtotime($rr[demissao]));
		}else{
			echo date("d/m/Y", strtotime($rr[admissao]));
		}?></td>
		<td align="left" class="fontepreta12">&nbsp;<?php echo $rr[ctps]; ?></td>
		<td align="left" class="fontepreta12">&nbsp;<?php echo $rr[email]; ?></td>
		<td align="left" class="fontepreta12">&nbsp;<?php echo $rr[nome]; ?></td>
	</tr>
</table>
</td></tr>
</table>
<table align="center" width="701" height="<?php echo $height; ?>" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
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
		<td align="left" width="90" class="fontepreta12">&nbsp;17.1-Data</td>
		<td align="left" width="150" class="fontepreta12">&nbsp;17.2-Tipo</td>
		<td align="left" width="160" class="fontepreta12">&nbsp;17.3-Natureza</td>
		<td align="left" width="150" class="fontepreta12">&nbsp;17.4-Exame(R/S)</td>
		<td align="left" width="148" class="fontepreta12">&nbsp;17.5-Indicação de Resultados</td>
	</tr>
	<tr>
		<td align="center" class="fontepreta12">&nbsp;<?php for($w=0; $w<pg_num_rows($resu); $w++){ echo date("d/m/Y", strtotime($r_resu[$w][data]))."<br>"; } ?></td>
		<td align="center" class="fontepreta12">&nbsp;<?php for($w=0; $w<pg_num_rows($resu); $w++){ echo $r_resu[$w][tipo_exame]."<br>"; } ?></td>
		<td align="center" class="fontepreta12">&nbsp;<?php for($w=0; $w<pg_num_rows($resu); $w++){ echo $r_resu[$w][especialidade]."<br>"; } ?></td>
		<td align="left" class="fontepreta12">&nbsp;</td>
		<td align="left" class="fontepreta12">&nbsp;(x) Normal<br>&nbsp;( ) Alterado<br>&nbsp;( ) Estável<br>&nbsp;( ) Agravamento<br>&nbsp;( ) Ocupacional<br>&nbsp;( ) Não Ocupacional</td>
	</tr>
</table>
<table align="center" width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="4" width="699" class="fontepreta12">&nbsp;18-Responsável Pela Monitoração Biológica</td>
	</tr>
	<tr>
		<td align="left" width="90" class="fontepreta12">&nbsp;18.1-Peródo</td>
		<td align="left" width="97" class="fontepreta12">&nbsp;18.2-NIT</td>
		<td align="left" width="225" class="fontepreta12">&nbsp;18.3-Registo de Conselho de Classe</td>
		<td align="left" width="285" class="fontepreta12">&nbsp;18.4-Nome do Profissional Legalmente Habilitado</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;
		<?php if($rr[demissao] != ""){
			echo date("d/m/Y", strtotime($rr[admissao]))." à &nbsp;". date("d/m/Y", strtotime($rr[demissao]));
		}else{
			echo date("d/m/Y", strtotime($rr[admissao]));
		}?></td>
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
		<td align="left" class="fontepreta12">&nbsp;20.2-Nome: <?php echo $row[nome_contato_dir]; ?></td>
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