<?php
include "../sessao.php";
include "../config/connect.php";

if(isset($_GET['y'])){
    $ano = $_GET['y'];
}else{
    $ano = date("Y");
}

$height = 1050;
$hei = 570;

$cli = "SELECT c.*, cs.* 
		FROM cliente c, cliente_setor cs
		WHERE c.cliente_id = cs.cod_cliente
		AND c.cliente_id = $cliente";
		
$cl = pg_query($connect, $cli);
$clt = pg_fetch_array($cl);

/*************SETOR ADMINISTRATIVO************/
$adm = "SELECT cod_func, tipo_setor FROM cliente_setor cs, funcionarios f 
		WHERE cs.cod_cliente = $cliente
		and cs.cod_cliente = f.cod_cliente
		and cs.cod_setor = f.cod_setor
		AND	tipo_setor = 'Administrativo'";
$result = pg_query($adm);
$nadm = pg_num_rows($result);

/*************SETOR OPERACIONAL************/
$ope = "SELECT cod_func, tipo_setor FROM cliente_setor cs, funcionarios f 
		WHERE cs.cod_cliente = $cliente
		and cs.cod_cliente = f.cod_cliente
		and cs.cod_setor = f.cod_setor
		AND	tipo_setor = 'Operacional'";
$result = pg_query($ope);
$nope = pg_num_rows($result);

function coloca_zeros($numero){
echo str_pad($numero, 2, "0", STR_PAD_LEFT);
}

function zeros($num){
echo str_pad($num, 3, "0", STR_PAD_LEFT);
}
?>
<html>
<head>
<title>..:: SESMT ::..</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>
<body>
<form name="frm_ltcat_relatorio" action="ltcat_relatorio.php" method="post">
<!---------------------CAPA--------------->
<table align="center" width="700" height="<?php echo $height; ?>" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td class="tabela" valign="top">
			<?php 
			if(!$_GET[sem_timbre]){
				include "header.php"; 
			}else{
				include "head.php";
			}	
			?>
		</td>
	</tr>
	<tr>
	<td class="tabela" valign="top" id="fod">
	
		<table align="center" width="690" height="<?php echo $hei; ?>" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center"><h2>LAUDO TÉCNICO DE CONDIÇÕES <p> AMBIENTAIS DE TRABALHO</h2>
			<div id="div_position" style="position:relative;left:-40px;"><img src="../img/uno_top.jpg" width="154" height="219"></div></td>
		</tr>
		<tr>
			<td align="center"><h2><?php echo $clt[razao_social]; ?></h2></td>
		</tr>
		<tr>
			<td align="center" class="fontepreta14bold"><?php echo $clt[endereco].", ".$clt[num_end]."<br>".$clt[bairro]."-".$clt[municipio]."<p>".$clt[estado]; ?></td>
		</tr>
		</table>
		<div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>
		<table width="600" align="center" border="0">
		<tr>
			<td align="center" class="fontepreta12"><b>ANO <?php if($clt[data_criacao]){ echo date("Y", strtotime($clt[data_criacao])); } ?></b></td>
		</tr>
		</table>
	  <tr>
			<td class="tabela" valign="bottom">
				<?php
				if(!$_GET[sem_timbre]){
					include "footer.php";
				}else{
					include "foot.php";
				}
				?>
			</td>
		</tr>
	</td>
	</tr>
</table>
<!---------------------DADOS DA EMPRESA--------------->
<table align="center" width="700" height="<?php echo $height; ?>" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td class="tabela" valign="top">
			<?php 
			if(!$_GET[sem_timbre]){
				include "header.php"; 
			}else{
				include "head.php";
			}	
			?>
		</td>
	</tr>
	<tr>
	<td class="tabela" valign="top">
		<table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center"><h2>LAUDO TÉCNICO DAS CONDIÇÕES AMBIENTAIS DE TRABALHO<p>DADOS CADASTRAIS DA EMPRESA</h2></td>
		</tr>
		</table><p>
		<table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td width="200" align="left" class="fontepreta12"><b>Número do Contrato:</b></td>
			<td width="380" align="left" class="fontepreta12">&nbsp;<?php echo $clt[ano_contrato]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>Número do Programa:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $clt[cod_ppra]."/".date("Y", strtotime($clt[data_criacao])); ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>Razão Social:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $clt[razao_social]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>Endereço:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $clt[endereco].", ".$clt[num_end]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>Bairro:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $clt[bairro]." - ".$clt[municipio]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>Cidade:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $clt[estado]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>CEP:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $clt[cep]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>Telefone:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $clt[telefone]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>FAX:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $clt[fax]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>CNPJ/CEI:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $clt[cnpj]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>Número de Colaboradores:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $clt[numero_funcionarios]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>Nº de Efetivo Setor Administrativo:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo coloca_zeros($nadm); ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>Nº de Efetivo Setor Operacional:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo coloca_zeros($nope); ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>Jornada de Trabalho:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $clt[jornada]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>CNAE:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $clt[cnae]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>Grau de Risco:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $clt[grau_de_risco]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>Ramo da Atividade:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $clt[descricao_atividade]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>Escritório de Contabilidade:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $clt[escritorio_contador]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>Contador:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $clt[nome_contador]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>Telefone Contador:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $clt[tel_contador]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>Área Total(Aprox.):</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $clt[comprimento]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>Área Construida:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $clt[frente]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>Pé Direito da Área Construida:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $clt[altura]; ?></td>
		</tr>
		</table>
		<div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>
		<tr>
			<td class="tabela" valign="bottom">
				<?php
				if(!$_GET[sem_timbre]){
					include "footer.php";
				}else{
					include "foot.php";
				}
				?>
			</td>
		</tr>
    </td> </tr>
</table>
<!---------------------INTRODUÇÃO--------------->
<table align="center" width="700" height="<?php echo $height; ?>" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td class="tabela" valign="top">
			<?php 
			if(!$_GET[sem_timbre]){
				include "header.php"; 
			}else{
				include "head.php";
			}	
			?>
		</td>
	</tr>
	<tr>
	<td class="tabela" valign="top">
		<table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center"><h2>INTRODUÇÃO<p>AO<p>LTCAT<p>LAUDO TÉCNICO DE<p>CONDIÇÕES AMBIENTAIS DE TRABALHO</h2></td>
		</tr>
		</table><p>
		<table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="justify" class="fontepreta12">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O laudo técnico das condições ambientais de trabalho visa avaliar, analisar e relatar os níveis de ruídos quer sejam contínuo ou intermitente; e os níveis de exposição por parte dos trabalhadores aos agentes nocivos prejudiciais a saúde e/ou a integridade física do ser humano.<p>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A avaliação Quantitativa de ruídos deverá estar sempre de acordo com o estabelecido pela Portaria 3.214 de 08 de junho de 1978 na NR - Norma Regulamentadora de número 15 (NR 15) Anexo I, contida no Decreto Lei 6.514, de 22 de dezembro de 1977, no seu cap. V do titulo II da CLT Consolidação das Leis Trabalhistas.<p>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A avaliação Quantitativa das atividades será de acordo com a mesma Portaria 3.214 de 08 de Junho de 1978, na NR Norma Regulamentadora de número 15 (NR 15) nos Anexos 11 e 13, onde são estabelecidos procedimentos aos Agentes Químicos e ACGIH.
			</td>
		</tr>
		</table>
		<div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>
		<tr>
			<td class="tabela" valign="bottom">
				<?php
				if(!$_GET[sem_timbre]){
					include "footer.php";
				}else{
					include "foot.php";
				}
				?>
			</td>
		</tr>
    </td> </tr>
</table>
<!---------------------QUADRO I--------------->
<?php
$quadro = "SELECT p.nome_piso, pa.nome_parede, pa.decicao_parede, co.nome_cobertura, va.nome_vent_art, vn.nome_vent_nat,
			la.nome_luz_art, ln.nome_luz_nat, s.nome_setor, cs.tipo_setor, cs.jornada, cs.cod_setor, s.desc_setor
			FROM cliente_setor cs, piso p, parede pa, cobertura co, ventilacao_artificial va, ventilacao_natural vn,
			luz_artificial la, luz_natural ln, setor s
			WHERE cs.cod_piso = p.cod_piso
			AND cs.cod_parede = pa.cod_parede
			AND cs.cod_cobertura = co.cod_cobertura
			AND cs.cod_vent_art = va.cod_vent_art
			AND cs.cod_vent_nat = vn.cod_vent_nat
			AND cs.cod_luz_art = la.cod_luz_art
			AND cs.cod_luz_nat = ln.cod_luz_nat
			AND cs.cod_setor = s.cod_setor
			AND cs.cod_cliente = $cliente
			AND extract(year from cs.data_criacao) = {$ano}";
$qd = pg_query($connect, $quadro);
$qdo = pg_fetch_all($qd);
for($x=0;$x<pg_num_rows($qd);$x++){
?>
<table align="center" width="700" height="<?php echo $height; ?>" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td class="tabela" valign="top">
			<?php 
			if(!$_GET[sem_timbre]){
				include "header.php"; 
			}else{
				include "head.php";
			}	
			?>
		</td>
	</tr>
	<tr>
	<td class="tabela" valign="top">
		<table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center" class="fontepreta14bold">QUADRO I DE AVALIAÇÕES QUANTITATIVAS<br>&nbsp;</td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12">O local onde estamos avaliando trata-se de uma área constituída de:</td>
		</tr>
		</table>
		<table align="center" width="690" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="left" class="fontepreta12" width="250">&nbsp;<b>Revestimesnto do Solo:</b></td>
			<td align="left" class="fontepreta12" width="430">&nbsp;<?php echo $qdo[$x][nome_piso]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12">&nbsp;<b>Parede:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $qdo[$x][nome_parede]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12">&nbsp;<b>Revestimesnto das Paredes:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $qdo[$x][decicao_parede]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12">&nbsp;<b>Cobertura:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $qdo[$x][nome_cobertura]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12">&nbsp;<b>Tipo de Ventilação:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $qdo[$x][nome_vent_art]."/".$qdo[$x][nome_vent_nat]; ?></td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12">&nbsp;<b>Tipo de Iluminação:</b></td>
			<td align="left" class="fontepreta12">&nbsp;<?php echo $qdo[$x][nome_luz_art]."/".$qdo[$x][nome_luz_nat]; ?></td>
		</tr>
		</table><p>
		<table align="center" width="690" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center" class="fontepreta12bold" width="160">Setor</td>
			<td align="center" class="fontepreta12bold" width="90">Rotina</td>
			<td align="center" class="fontepreta12bold" width="90">Carga Horária</td>
			<td align="center" class="fontepreta12bold" width="170">Agente</td>
			<td align="center" class="fontepreta12bold" width="170">Atividades Desenvolvidas</td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><?php echo $qdo[$x][nome_setor]; ?></td>
			<td align="left" class="fontepreta12"><?php echo $qdo[$x][tipo_setor]; ?></td>
			<td align="left" class="fontepreta12"><?php echo $qdo[$x][jornada]; ?>&nbsp;</td>
			<td align="left" class="fontepreta12">
			<?php
			$bat = "SELECT distinct(ag.nome_agente_risco)
					FROM cliente_setor cs, agente_risco ag, risco_setor rs
					WHERE cs.cod_setor = {$qdo[$x][cod_setor]}
					AND cs.cod_cliente = rs.cod_cliente
					AND rs.cod_agente_risco = ag.cod_agente_risco
					AND cs.cod_cliente = $cliente
					AND extract(year from cs.data_criacao) = {$ano}";
			$cel = pg_query($connect, $bat);
			$bc = pg_fetch_all($cel);
			for($w=0;$w<pg_num_rows($cel);$w++){
				echo $bc[$w][nome_agente_risco];
				if($w<pg_num_rows($cel)-1) echo "; ";
			}
			?>
			</td>
			<td align="left" class="fontepreta12"><?php echo $qdo[$x][desc_setor]; ?></td>
		</tr>
		</table><p>
		<?php
		/*************QUANTIDADE DE FUNCIONÁRIOS NO SETOR************/
		$set = "SELECT cod_func
				FROM funcionarios f, setor s
				WHERE cod_cliente = '$cliente'
				AND s.cod_setor = {$qdo[$x][cod_setor]}
				AND f.cod_setor = s.cod_setor";
		$rset = pg_query($set);
		$et = pg_num_rows($rset);

		/*************QUANTIDADE DE FUNCIONÁRIOS MASCULINOS************/
		$masc = "SELECT sexo_func, cod_cliente
				FROM funcionarios f, setor s
				WHERE cod_cliente = '$cliente'
				AND s.cod_setor = {$qdo[$x][cod_setor]}
				AND f.cod_setor = s.cod_setor
				AND	sexo_func = 'Masculino'";
		$result = pg_query($masc);
		$nmasc = pg_num_rows($result);
		
		/*************QUANTIDADE DE FUNCIONÁRIOS FEMININOS************/
		$fem = "SELECT sexo_func, cod_cliente
				FROM funcionarios f, setor s
				WHERE cod_cliente = '$cliente'
				AND s.cod_setor = {$qdo[$x][cod_setor]}
				AND f.cod_setor = s.cod_setor
				AND	sexo_func = 'Feminino'";
		$result = pg_query($fem);
		$nfem = pg_num_rows($result);
		?>
		<table align="center" width="690" border="0">
		<tr>
			<td align="center" class="fontepreta12" width="200"><b>Efetivo Setor</b></td>
			<td align="center" class="fontepreta12" width="200"><b>Efetivo Masculino</b></td>
			<td align="center" class="fontepreta12" width="200"><b>Efetivo Feminino</b></td>
		</tr>
		<tr>
			<td style="border: 1px solid #000000;" align="center" class="fontepreta12"><?php echo coloca_zeros($et); ?></td>
			<td style="border: 1px solid #000000;" align="center" class="fontepreta12"><?php echo coloca_zeros($nmasc); ?></td>
			<td style="border: 1px solid #000000;" align="center" class="fontepreta12"><?php echo coloca_zeros($nfem); ?></td>
		</tr>
		</table>
		<div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>
		<tr>
			<td class="tabela" valign="bottom">
				<?php
				if(!$_GET[sem_timbre]){
					include "footer.php";
				}else{
					include "foot.php";
				}
				?>
			</td>
		</tr>
    </td> </tr>
</table>
<?php } ?>
<!---------------------QUADRO II--------------->
<?php
$quadro2 = "select a.nome_agente_risco, r.fonte_geradora, r.diagnostico, r.acao_necessaria, r.corretiva
			from setor s, risco_setor r, cliente_setor c, agente_risco a
			where r.cod_cliente = c.cod_cliente
			AND r.cod_setor = c.cod_setor
			and r.cod_setor = s.cod_setor
			and r.cod_agente_risco = a.cod_agente_risco
			AND EXTRACT(year FROM data_criacao) = EXTRACT(year FROM data)
			and r.cod_cliente = $cliente
			AND EXTRACT(year FROM c.data_criacao) = {$ano}";
$qua = pg_query($connect, $quadro2);
$quad = pg_fetch_all($qua);

$dim = array();
for($x=0;$x<pg_num_rows($qua);$x++){
		$di = "<tr>
			<td align=left class=fontepreta12>{$quad[$x][nome_agente_risco]}&nbsp;</td>
			<td align=left class=fontepreta12>{$quad[$x][fonte_geradora]}&nbsp;</td>
			<td align=left class=fontepreta12>{$quad[$x][diagnostico]}&nbsp;</td>
			<td align=left class=fontepreta12>{$quad[$x][acao_necessaria]}&nbsp;</td>
			<td align=left class=fontepreta12>{$quad[$x][corretiva]}&nbsp;</td>
		</tr>";
$dim[] = addslashes($di);
}
for ($y=0;$y<ceil(count($dim)/5);$y++) { ?>
<table align="center" width="700" height="<?php echo $height; ?>" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td class="tabela" valign="top">
			<?php 
			if(!$_GET[sem_timbre]){
				include "header.php"; 
			}else{
				include "head.php";
			}	
			?>
		</td>
	</tr>
	<tr>
	<td class="tabela" valign="top">
		<table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center" class="fontepreta14bold">QUADRO II DE DESCRIÇÕES QUALITATIVAS</td>
		</tr>
		</table><p>
		<table align="center" width="690" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center" class="fontepreta12" width="90"><b>Agentes Nocivos</b></td>
			<td align="center" class="fontepreta12" width="95"><b>Causas</b></td>
			<td align="center" class="fontepreta12" width="200"><b>Possiveis Danos a Saúde</b></td>
			<td align="center" class="fontepreta12" width="100"><b>Medidas de Controle</b></td>
			<td align="center" class="fontepreta12" width="200"><b>Primeiros Socorros</b></td>
		</tr>
		<?php
		$i = $y*5;
			for($x=$i;$x<$i+5;$x++){ 
			   echo $dim[$x];			
			}
		?>
		</table>
		<div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>
		<tr>
			<td class="tabela" valign="bottom">
				<?php
				if(!$_GET[sem_timbre]){
					include "footer.php";
				}else{
					include "foot.php";
				}
				?>
			</td>
		</tr>
    </td> </tr>
</table>
<?php } ?>
<!---------------------METODOLOGIA--------------->
<table align="center" width="700" height="<?php echo $height; ?>" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td class="tabela" valign="top">
			<?php 
			if(!$_GET[sem_timbre]){
				include "header.php"; 
			}else{
				include "head.php";
			}	
			?>
		</td>
	</tr>
	<tr>
	<td class="tabela" valign="top">
		<table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
		<td align="center"><h2>METODOLOGIA APLICADA NA AVALIAÇÃO DOS NÍVEIS DE RUÍDOS</h2></td>
		</tr>
		</table><p>
		<?php
		$apa = "SELECT nome_aparelho, modelo_aparelho, marca_aparelho
				FROM cliente_setor cs, setor s, aparelhos a
				WHERE cs.ruido = a.cod_aparelho
				AND cs.cod_setor = s.cod_setor
				AND cs.cod_cliente = $cliente
				AND EXTRACT(year FROM data_criacao) = {$ano}";
		$par = pg_query($connect, $apa);
		$ap = pg_fetch_array($par);
		?>
		<table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="justify" class="fontepreta12">
				<b>RUÍDO</b><P>
				&bull; Medições em decibéis(dB), com o instrumento operado no circuito de compensação “A” e circuito de resposta lento (SLOW), à leitura e feita próximo ao ouvido do trabalhador e nos locais considerados como de maior permanência do mesmo.<p>
				<b>CONFORMIDADE</b><p>
				&bull; Anexo 1, item 2 da NR 15 Portaria 3214  de 08/06/78 – MTB.<br>
				&bull; NHT – 06 R/E – Norma para avaliação de exposição ocupacional ao ruído da Fundacentro.<p>
				<b>APARELHOS UTILIZADOS</b><p>
				&bull; Medidor de nível de pressão sonora(<?php echo $ap[nome_aparelho]; ?>)  marca <?php echo $ap[marca_aparelho]; ?> – modelo <?php echo $ap[modelo_aparelho]; ?> – tipo 2 escalas. 80-130, db (ANSI) e 50-100 db (IEC).<p>
				<b>METODOLOGIA</b><p>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Com base no cronograma da empresa. Foram subdivididos os postos de trabalho e as funções, em cada posto de trabalho foi feitos os reconhecimentos das medidas de controles existentes, o número de empregados expostos, o turno de trabalho, a jornada de trabalho e a fonte gerada entre outros.<p>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Após o reconhecimento foi realizada a avaliação quantitativa de níveis de pressão sonora, de acordo com a necessidade de comprovação da exposição dos trabalhadores. As avaliações foram realizadas em dias selecionados aleatoriamente, em empregados e turnos de trabalhos diferentes. Em seguida foi realizada a média das doses obtidas e calculados os níveis equivalentes médios de ruídos LEQ db (A) para exposição diária.
				</td>
			</tr>
		</table>
		<div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>
		<tr>
			<td class="tabela" valign="bottom">
				<?php
				if(!$_GET[sem_timbre]){
					include "footer.php";
				}else{
					include "foot.php";
				}
				?>
			</td>
		</tr>
    </td> </tr>
</table>
<!---------------------PRESSÃO SONORA--------------->
<?php
$ruido = "SELECT nome_setor, ruido_fundo_setor, ruido_operacao_setor
		FROM cliente_setor cs, setor s
		WHERE cs.cod_setor = s.cod_setor
		AND cs.cod_cliente = $cliente
		AND EXTRACT(year FROM data_criacao) = {$ano}";
$rui = pg_query($connect, $ruido);
$ruid = pg_fetch_all($rui);

$rud = array();
for($x=0;$x<pg_num_rows($rui);$x++){
$rd = "<tr>
			<td align=center class=fontepreta12>{$ruid[$x][nome_setor]}&nbsp;</td>
			<td align=center class=fontepreta12>{$ruid[$x][ruido_operacao_setor]}&nbsp;</td>
			<td align=center class=fontepreta12>{$ruid[$x][ruido_fundo_setor]}&nbsp;</td>
			<td align=center class=fontepreta12>{$ruid[$x][ruido_fundo_setor]}&nbsp;</td>
			<td align=center class=fontepreta12>{$ruid[$x][ruido_operacao_setor]}&nbsp;</td>
		</tr>";
$rud[] = addslashes($rd);
}
for ($y=0;$y<ceil(count($rud)/20);$y++) { ?>
<table align="center" width="700" height="<?php echo $height; ?>" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td class="tabela" valign="top">
			<?php 
			if(!$_GET[sem_timbre]){
				include "header.php"; 
			}else{
				include "head.php";
			}	
			?>
		</td>
	</tr>
	<tr>
	<td class="tabela" valign="top">
		<table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center" class="fontepreta14bold">VALORIZAÇÃO DE PRESSÃO SONORA ENCONTRADAS</td>
		</tr>
		</table><p>
		<table align="center" width="690" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center" class="fontepreta12" width="185"><b>Setor/Posto de Trabalho</b></td>
			<td align="center" class="fontepreta12" width="100"><b>Ruído db (A)</b></td>
			<td align="center" class="fontepreta12" width="100"><b>Ruído de Fundo</b></td>
			<td align="center" class="fontepreta12" width="100"><b>Ruído Mecânico</b></td>
			<td align="center" class="fontepreta12" width="100"><b>Ruído Motor</b></td>
		</tr>
		<?php 
			$i = $y*20;
			for($x=$i;$x<$i+20;$x++){ 
			   echo $rud[$x];			
			}
		?>
		</table>
		<div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>
		<tr>
			<td class="tabela" valign="bottom">
				<?php
				if(!$_GET[sem_timbre]){
					include "footer.php";
				}else{
					include "foot.php";
				}
				?>
			</td>
		</tr>
    </td> </tr>
</table>
<?php } ?>
<!---------------TEXTO------------->
<table align="center" width="700" height="<?php echo $height; ?>" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td class="tabela" valign="top">
			<?php 
			if(!$_GET[sem_timbre]){
				include "header.php"; 
			}else{
				include "head.php";
			}	
			?>
		</td>
	</tr>
	<tr>
	<td class="tabela" valign="top">
		<table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="justify" class="fontepreta12">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Observa-se para as condições anteriores a tabela existente na legislação especifica na Lei 6.514 de 22 de Dezembro de 1977, incluída na CLT em seu CAP.V. e regulamentada pela Portaria 3.214 de 08 de Junho de 1978, na norma regulamentadora NR 15 em seu anexo I, que o (limite de tolerância para ruídos contínuos ou intermitentes). A legislação previdenciária definiu o limite de tolerância em 90 db.<p>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Durante visita técnica em quanto entrevista a empresa: <b><?php echo $clt[razao_social]; ?></b>, a saúde por parte dos funcionários. De acordo com a Portaria 3.751 de 23 de Novembro de 1990, NR 15 Anexo I, o limite de tolerância para ruídos contínuos e ou intermitentes para uma jornada de 08:00 horas diária é de 85 db (A). A legislação previdenciária definiu o limite de tolerância em 90 db.<p>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Não é permitida exposição a níveis de ruídos acima de 115 db (A) para indivíduos que não estejam adequadamente protegidos.<p>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Os maquinários e equipamentos utilizados pelas empresas produzem ruídos que podem atingir níveis excessivos provocados a curto, médio e longo prazo que podem acarretar em sérios prejuízos a saúde.<p>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dependendo do tempo da exposição ao nível sonoro e da sensibilidade individual, as alterações auditivas poderão manifestar-se imediatamente ou se começará a perder a audição gradualmente.<p>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quanto maior o nível de ruído, menor deverá ser o tempo de exposição ocupacional, a seguir os principais efeitos prejudiciais do ruído excessivo sobre o funcionário.
			</td>
		</tr>
		</table><p>
		<table align="center" width="690" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="left" class="fontepreta12" width="200"><b>&nbsp;Sobre o Sistema Nervoso</b></td>
			<td align="left" class="fontepreta12" width="485">&nbsp;Modificações das ondas eletroencefalográficas, fadigas, nervoso.</td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>&nbsp;Aparelho Cardiovascular</b></td>
			<td align="left" class="fontepreta12">&nbsp;Hipertensão, Modificação do ritmo cardíaco, Modificação do calibre dos vasos sanguíneos.</td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>&nbsp;Outros Efeitos</b></td>
			<td align="left" class="fontepreta12">&nbsp;Modificação do ritmo respiratório; Perturbações gastrintestinais; Diminuição da visão noturna; Dificuldade na percepção das cores; Perda temporária da capacidade auditiva.</td>
		</tr>
		</table>
		<div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>
		<tr>
			<td class="tabela" valign="bottom">
				<?php
				if(!$_GET[sem_timbre]){
					include "footer.php";
				}else{
					include "foot.php";
				}
				?>
			</td>
		</tr>
    </td> </tr>
</table>
<table align="center" width="700" height="<?php echo $height; ?>" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td class="tabela" valign="top">
			<?php 
			if(!$_GET[sem_timbre]){
				include "header.php"; 
			}else{
				include "head.php";
			}	
			?>
		</td>
	</tr>
	<tr>
	<td class="tabela" valign="top">
		<table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center" class="fontepreta14bold">ATIVIDADES E OPERAÇÕES COM EXPOSIÇÃO A AGENTES NOCIVOS</td>
		</tr>
		</table><p>
		<table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="left" class="fontepreta12"><b>Temperaturas Extremas – Calor</b><br>&nbsp;</td>
		</tr>
		<tr>
			<td align="justify" class="fontepreta12">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O critério para avaliação da exposição ocupacional ao calor consiste no uso de uma bateria de termômetros e no calculo do índice de bulbo úmido termômetro de globo (IBUTG), recomendado pela legislação brasileira no anexo 3 da NR 15, as medidas foram realizadas de acordo com a norma para avaliação da exposição ocupacional ao calor NHT-01 C / E elaborada pela Fundacentro.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Os valores de IBUTG encontrados serão então comparados com os limites de tolerância estabelecidos pelo anexo 3 da NR 15, depois de serem caracterizadas a carga solar do ambiente e a taxa do metabolismo desprendida de acordo com o tipo de atividade estudada.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A avaliação quantitativa de calor será efetuada apenas onde existe fonte de calor e exposição dos funcionários (setor operacional). Será utilizado nessa medição um termômetro de globo digital marca instrutherm, modelo TGD 200, com três ondas de temperatura: sonda de bulbo seco; sonda de bulbo úmido; e sonda de globo.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As medidas serão efetuadas no local onde permanece o trabalho, a altura da região do corpo mais atingida.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O cálculo do índice de bulbo úmido termômetro de globo (Ibutg) será definido pelas equações abaixo:<p>
			Ambiente interno ou externo sem carga solar:<br>Ibutg + 0,7 tbn + 0,2 tg<p>
			Ambientes externos com carga solar:<br>ibutg = 0,7 tbn + 0,1 tbs + 0,2 tg<p>
			onde:<br>tbn (temperatura de bulbo úmido natural).<br>tg  (temperatura de globo).<br>tbs (temperatura de bulbo seco).
			</td>
		</tr>
		</table><p>
		<table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center" class="fontepreta14bold">MEDIDAS PREVENTIVAS EXISTENTES</td>
		</tr>
		</table><p>
		<table align="center" width="690" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center" class="fontepreta12bold" colspan="4">Tabela de Tolerância de Exposição ao Calor em Regime de Trabalho</td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12" width="300">Trabalho intermitente com períodos de descanso no próprio local de trabalho(por hora).</td>
			<td align="center" class="fontepreta12" width="385" colspan="3">Tipo de Atividade<p>Leve&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Moderada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pesada</td>
		</tr>
		<tr>
			<td align="center" class="fontepreta12"><b>Trabalho Contínuo</b></td>
			<td align="center" class="fontepreta12" width="125"><b>Até 30,0</b></td>
			<td align="center" class="fontepreta12" width="125"><b>Até 26,7</b></td>
			<td align="center" class="fontepreta12" width="125"><b>Até 25,0</b></td>
		</tr>
		<tr>
			<td align="center" class="fontepreta12">45 min. De trabalho. e 15 minutos de descanso</td>
			<td align="center" class="fontepreta12">Até 30,1 à 30,6</td>
			<td align="center" class="fontepreta12">Até 26,8 à 28,0</td>
			<td align="center" class="fontepreta12">Até 25,1 à 25,9</td>
		</tr>
		<tr>
			<td align="center" class="fontepreta12">30 minutos de trabalho e 30 minutos de descanso</td>
			<td align="center" class="fontepreta12">Até 37,1 à 31,4</td>
			<td align="center" class="fontepreta12">Até 28,1 à 29,4</td>
			<td align="center" class="fontepreta12">Até 26,0 à 27,9</td>
		</tr>
		<tr>
			<td align="center" class="fontepreta12">15 minutos de trabalho e 45 minutos de descanso</td>
			<td align="center" class="fontepreta12">Até 31,5 à 32,2</td>
			<td align="center" class="fontepreta12">Até 29,5 à 31,1</td>
			<td align="center" class="fontepreta12">Até 28,0 à 30,0</td>
		</tr>
		<tr>
			<td align="center" class="fontepreta12">Não é permitido o trabalho, sem a adoção de medidas adequadas de controle.</td>
			<td align="center" class="fontepreta12">Acima de 32,2</td>
			<td align="center" class="fontepreta12">Acima de 31,1</td>
			<td align="center" class="fontepreta12">Acime de 30,0</td>
		</tr>
		</table>
		<div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>
		<tr>
			<td class="tabela" valign="bottom">
				<?php
				if(!$_GET[sem_timbre]){
					include "footer.php";
				}else{
					include "foot.php";
				}
				?>
			</td>
		</tr>
    </td> </tr>
</table>
<table align="center" width="700" height="<?php echo $height; ?>" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td class="tabela" valign="top">
			<?php 
			if(!$_GET[sem_timbre]){
				include "header.php"; 
			}else{
				include "head.php";
			}	
			?>
		</td>
	</tr>
	<tr>
	<td class="tabela" valign="top">
		<table align="center" width="690" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center" class="fontepreta12" width="135"><b>Setor/Posto de Trabalho</b></td>
			<td align="center" class="fontepreta12" width="135"><b>Ponto de Medição do Equip.</b></td>
			<td align="center" class="fontepreta12" width="135"><b>IBUTG Medido</b></td>
			<td align="center" class="fontepreta12" width="135"><b>IBUTG Permitido</b></td>
			<td align="center" class="fontepreta12" width="135"><b>Classificação das Atividades</b></td>
		</tr>
		</table>
		<div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>
		<tr>
			<td class="tabela" valign="bottom">
				<?php
				if(!$_GET[sem_timbre]){
					include "footer.php";
				}else{
					include "foot.php";
				}
				?>
			</td>
		</tr>
    </td> </tr>
</table>
</form>
</body>
</html>