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

//ARRAY PARA ARMAZENAR OS MESES POR EXTENSO	
$meses = array(" ", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

//CONSULTA PARA BUSCAR AS INFORMAÇÕES DO CLIENTE
$apgre = "SELECT c.*, cn.*, cs.*
		FROM cliente c, cnae cn, cliente_setor cs
		WHERE c.cnae_id = cn.cnae_id
		AND c.cliente_id = cs.cod_cliente
		AND cs.cod_cliente = $cliente
		AND EXTRACT(year FROM cs.data_criacao) = {$ano}";
$res = pg_query($connect, $apgre);
$rr = pg_fetch_array($res);

/*************QUANTIDADE DE FUNCIONÁRIOS MASCULINOS************/
$masc = "SELECT sexo_func, cod_cliente FROM funcionarios
		WHERE cod_cliente = '$cliente'
		AND	sexo_func = 'Masculino'";
$result = pg_query($masc);
$nmasc = pg_num_rows($result);

/*************QUANTIDADE DE FUNCIONÁRIOS FEMININOS************/
$fem = "SELECT sexo_func, cod_cliente FROM funcionarios
		WHERE cod_cliente = '$cliente'
		AND	sexo_func = 'Feminino'";
$result = pg_query($fem);
$nfem = pg_num_rows($result);

/*************MTB DO REVISOR************/
$maior = "SELECT * FROM funcionario
		WHERE funcionario_id = 3";
$result = pg_query($maior);
$flist = pg_fetch_array($result);

/*************MTB DO ELABORADOR************/
$menor = "SELECT f.* FROM funcionario f, cliente_setor cs
		WHERE f.funcionario_id = cs.funcionario_id
		AND cs.cod_cliente = $cliente";
$result = pg_query($menor);
$flis = pg_fetch_array($result);

/*****************BUSCAR DADOS DE TEMPERATURAS********************/
$sql = "SELECT * FROM cgrt_info WHERE cod_cliente = $cliente and cod_cgrt = ".(int)($_GET[cod_cgrt]);
$dadoscompl = pg_fetch_array(pg_query($sql));

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
<form name="frm_apgre_relatorio" action="apgre_relatorio.php" method="post">
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
			$t_func = "select count(cod_func) as cod from cgrt_func_list where cod_cgrt = $_GET[cod_cgrt] and cod_setor = 394";
	$ttal = pg_query($t_func);
	$ttl = pg_fetch_all($ttal);
	echo ">>>"; print empty($dadoscompl[data_avaliacao]) ? "" : date("d/m/Y", strtotime($dadoscompl[data_avaliacao]));
	echo "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	echo "<tr>";
	echo "<td width=100% align=left><b>Data da Vistoria Técnica:</b></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td align=justify >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A vistoria ocorreu no dia ".date("d", strtotime($info[data_avaliacao]))." de ".$meses[date("n", strtotime($info[data_criacao]))]." de {$info[ano]}, no interior da empresa: <b> {$info[razao_social]}</b>. Devidamente classificada, setores administrativos bem como setores operacionais.</td>";
	echo "</tr>";
	echo "</table>";
	
	echo "<p>";
	
	echo "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	echo "<tr>";
echo "<td align=center ><b>Setor:</b> {$avl[$x][nome_setor]}</td>";
	echo "<td align=center ><b>Nº de Colaboradores:</b>".str_pad($ttl[cod], 2, "0", 0)."</td>";
	echo "<td align=center ><b>Atividade:</b> {$avl[$x][tipo_setor]}</td>";
	echo "</tr>";
echo "</table>";

			?>
		</td>
	</tr>
	<tr>
	<td class="tabela" valign="top" id="fod">
	<div id="div_position" style="position:relative;left:-30px;"><img src="../img/uno_top.jpg" width="154" height="219"></div>
		<table align="center" width="500" height="<?php echo $hei; ?>" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
		<td><center><h1>AVALIAÇÃO<p>PRELIMINAR<p>E<p>GERENCIAMENTO<p>DE<p>RISCOS<p>ERGONÔMICOS</h1></center>
		<p align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>NR 17<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Portaria 3.214/78<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lei 6.514/77</b>
		<p align="center"><br><b>ANO BASE <br> <?php if($rr[data_criacao]){ echo date("Y", strtotime($rr[data_criacao])); } ?></b>
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>
		</td>
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
<!---------------------APROVAÇÃO--------------->
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
		<table align="center" width="698" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td width="199" class="tabela"><b>REALIZADO:</b><br>&nbsp;</td>
		</tr>
		<tr>
			<td width="199" class="tabela">Rio de Janeiro,
			<?php 
		echo date("d", strtotime($rr[data_criacao]))." de ".$meses[date("n", strtotime($rr[data_criacao]))]." de ".date("Y", strtotime($rr[data_criacao]));
			?><br>&nbsp;</td>
		</tr>
		<tr>
			<td width="199" class="tabela"><B>ELABORAÇÃO:</B><br>&nbsp;</td>
		</tr>
		<tr>
			<td width="199" class="tabela">SESMT Serviços Especializados em Segurança e Monitoramentos de Atividades no Trabalho Ltda<br>
			Rua: Marechal Antônio de Souza, 92 – Jardim América – Rio de Janeiro – RJ<br>CNPJ: 04.722.248/0001-17<br>&nbsp;</td>
		</tr>
		<tr>
			<td width="199" class="tabela"><b>ELABORADOR:</b><br>&nbsp;</td>
		</tr>
		<tr>
			<td width="199" class="tabela"><?php echo $flis[nome]; ?><br>Técnico(a) em Segurança do Trabalho<br>Reg. <?php echo $flis[registro]; ?><br>&nbsp;</td>
		</tr>
		<tr>
			<td width="199" class="tabela"><b>REVISOR:</b><br>&nbsp;</td>
		</tr>
		<tr>
			<td width="199" class="tabela"><?php echo $flist[nome]; ?><BR>Técnico em Segurança do Trabalho<br>Reg. <?php echo $flist[registro]; ?><br>&nbsp;</td>
		</tr>
		<tr>
			<td width="199" class="tabela"><b>APROVAÇÃO:</b><br>&nbsp;</td>
		</tr>
		<tr>
			<td width="199" class="tabela">xxxxxxxxxxxxxxxxxx<br>&nbsp;</td>
		</tr>
		<tr>
			<td width="199" class="tabela"><b>CARGO:</b><br>&nbsp;</td>
		</tr>
		<tr>
			<td width="199" class="tabela">xxxxxxxxxxxxx<br>&nbsp;</td>
		</tr>
	</table>
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>
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
<!---------------------4ª PÁGINA--------------->
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
		<table align="center" width="698" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="left"><b>APRESENTAÇÃO</b></td>
			</tr>
			<tr>
				<td align="justify" class="fontepreta12"><br>
			<?php
			$sql = "select lux_recomendado, (sum( cast( cast(lux_atual as text) as integer) ) / 
			(select count(*) from iluminacao_ppra where id_ppra = $cod_cgrt and cod_setor = 391) ) as t
			from iluminacao_ppra where id_ppra = $cod_cgrt and cod_setor = 391 group by lux_recomendado";
	$r_ag = pg_query($sql);
	$s_agent = pg_fetch_array($r_ag);
	echo $sql;
	
		echo "<tr>";
		echo"<td align=center>Iluminância</td>";
		echo ">>>".$s_agent[t];
		echo"<td align=center>";
			if($s_agent[bigint] < $s_agente[lux_recomendado])
				echo"Abaixo do limite permitido";
			elseif ($s_agent[bigint] >= $s_agent[lux_recomendado] && $s_agent[bigint] <=1000)
				echo "Desprezivel";
			elseif($s_agent[bigint] > 1000)
				echo"Acima do limite permitido";
			else
				echo"&nbsp;";
        echo"</td>";
		echo"<td align=center>&nbsp;</td>";
		echo"<td align=center>&nbsp;</td>";
		echo"<td align=center>&nbsp;</td>";
		echo"<td align=center>&nbsp;</td>";
		echo"</tr>";
			
			
			$spx = "SELECT s.*, p.desc_resumida_prod FROM sugestao s, produto p 
		WHERE s.id_ppra = {$cod_cgrt} and s.plano_acao = 1 and s.tipo_med_prev = 2 and s.cod_produto = p.cod_prod";
$lpx = pg_query($connect, $spx);
$px = pg_fetch_array($lpx);
if($px[plano_acao] == 1){
	echo "<br><p>";
    echo "<div class='mediumTitle'><b>CRONOGRAMA E PLANO DE AÇÃO DO CURSO BASE/ANO ".$info[ano]."</b></div>";
    echo "<BR>";
    echo "<p align='justify'>";
    echo "<b>Empresa:</b> ".$info[razao_social];
    echo "<BR>";
    echo "";

    echo "<table border=1 width=100% cellspacig=0 cellpadding=0>";
    echo "<tr>";
    echo "<td class='bgtitle' align=center width=365><b>Quadro de Planejamento e Ações</b></td>";
    echo "<td class='bgtitle' align=center width=365><b>Metas e Prioridades Ano ".(int)($info[ano])." à ".((int)($info[ano])+1)."</b></td>";
   echo "</tr>";
    echo "<tr>";
    echo "<td align=center width=365><b>Descrição das Necessidades</b></td>";
    echo "<td align=center width=365>";
        $mesref = date("n", strtotime($info[data_criacao]));
        echo "<table border=0 width=365 cellspacig=0 cellpadding=0>";
        echo "<tr>";
        for($i=1;$i<=12;$i++){
   	            echo "<td width=30 align=center class='dez'><b>{$smes[$mesref]}</b></td>";
				$mesref++;
				if($mesref >= 13) $mesref = 1;
		    }
        echo "</tr>";
        echo "</table>";
    echo"</td>";
    echo "</tr>";
	
	//Descrição do Cursos
	$puls = "SELECT s.*, p.desc_resumida_prod FROM sugestao s, produto p 
		WHERE s.id_ppra = {$cod_cgrt} and s.plano_acao = 1 and s.tipo_med_prev = 2 and s.cod_produto = p.cod_prod";
$xos = pg_query($connect, $puls);
$sux = pg_fetch_all($xos);
	for($y=0;$y<pg_num_rows($xos);$y++){
		echo "<tr>";
		echo "<td class='dez' align=left width=365>{$sux[$y][desc_resumida_prod]}</td>";
		echo "<td class='dez' align=center width=365>";
			$data_sugestao = date("n", strtotime($px[$y][data]));
			$mesref = date("n", strtotime($info[data_criacao]));
			echo "<table border=1 width=365 cellspacig=0 cellpadding=0>";
			echo "<tr>";
			for($i=1;$i<=12;$i++){
				if($mesref == $data_sugestao)
				   echo "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
				else
				   echo "<td width=30 align=center class='dez'>&nbsp;</td>";
				$mesref++;
				if($mesref >= 13) $mesref=1;
			}
			echo "</tr>";
			echo "</table>";
		echo "</td>";
		echo "</tr>";
	}
   echo "</table>";
}else{

}
			?>
			
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A palavra Ergonomia é um neologismo criado a partir da união dos termos gregos Ergon, que significa trabalho e Nomos, cujo significado refere-se a normas ou regras e leis. Ergonomia como fatores humanos é a disciplina cientifica que diz respeito ao discernimento do relacionamento entre homens e outros elementos de um sistema de gestão em exercício de sua profissão.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A profissão que implica teorias, princípios, informações, métodos e dados para projetar, de modo a otimizar o bem estar do ser humano em uma jornada laborativa objetivando assim a eficiência plena do sistema. Utilizando-se de formas e maneiras mais simples e nesse complexo de ações e informações temos a ergonomia como o estudo de adaptação de uma jornada de trabalho e o ser humano.
				</td>
			</tr>
			<tr>
				<td align="left"><BR><b>OBJETIVO</b></td>
			</tr>
			<tr>
				<td align="justify" class="fontepreta12"><br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O objetivo do presente trabalho é o de realizar a avaliação preliminar e o gerenciamento dos riscos ergonômicos das atividades desenvolvidas por cada um dos colaboradores em seus postos de trabalho da empresa: <b><?php echo $rr[razao_social]; ?></b> Situada no Endereço: <b><?php echo $rr[endereco]; ?>, <?php echo $rr[num_end]; ?></b> Inscrita no CNPJ: <b><?php echo $rr[cnpj]; ?></b> em conformidade com as exigências pertinentes buscando sempre expor de forma clara, objetiva e técnica os parâmetros estabelecidos que permitam adaptações das condições dos postos de trabalho às características psico-fisiológicas dos trabalhadores de modo a proporcionar o máximo de conforto, segurança e desempenho.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O estudo inclui aspectos relacionados à ergonomia física, cognitiva e organizacional dentre os quais estão à adaptação a superfícies, apoios e alcances da interface máquina versus ser humano; seja por motivos de posturas inadequadas, exercício de tarefas sentado; semi-sentado; em pé; empurrando; puxando; praticando levantamentos; transportando ou no exercício de descarga de materiais; estruturas arquitetônicas; mobiliários; maquinários e equipamentos. Às condições ambientais de iluminação, ruídos, stress térmicos e umidade relativa do ar; aspectos cognitivos, carga mental – Psicanálise Ocupacional, psicológica, emocional e à própria organização do trabalho, cargo e a metodologia do trabalho.
				</td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>
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
<!---------------------5ª PÁGINA--------------->
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
		<table align="center" width="698" border="0" cellpadding="2" cellspacing="2" bordercolor="#000000">
			<tr>
				<td align="justify" class="fontepreta14">
				<h2>SUMÁRIO</h2><p>
				<b>Empresa<p>Local de Trabalho<p>Fundamentação<p>Metodologia<p>Instrumentos Utilizados<p>Levantamento e Análise<p></b>Identificação da Análise<br>Descrição Física e Historica<br>Descrição do Método de Trabalho<br>Descrição da População Funcional<br>Análise Pró-ativa de Riscos Ergonômicos<br>Considerações<p><b>Conclusão<p>Bibliografia</b>
				</td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>
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
<!---------------------6ª PÁGINA--------------->
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
		<table align="center" width="698" border="0" cellpadding="2" cellspacing="2" bordercolor="#000000">
			<tr>
				<td align="left" class="fontepreta14">
				<h2>Descrição da Empresa</h2><p>
				<b>Razão Social:</b> <?php echo $rr[razao_social]; ?><br>
				<b>Endereço:</b> <?php echo $rr[endereco]; ?>, <?php echo $rr[num_end];?><br>
				<b>CEP:</b> <?php echo $rr[cep]; ?><br>
				<b>Bairro:</b> <?php echo $rr[bairro]; ?><br>
				<b>Município:</b> <?php echo $rr[municipio]; ?><br>
				<b>Estado:</b> <?php echo $rr[estado]; ?><br>
				<b>CNPJ:</b> <?php echo $rr[cnpj]; ?><br>
				<b>C.N.A.E.:</b> <?php echo $rr[cnae]; ?><br>
				<b>Grau de Risco:</b> <?php echo $rr[grau_de_risco]; ?><br>
				<b>Responsável Pelas Informações:</b> <?php echo $rr[nome_contato_dir]; ?><br>
				<b>Telefone:</b> <?php echo $rr[tel_contato_dir]; ?><br>
				<b>FAX:</b> <?php echo $rr[fax]; ?><br>
				<b>E-mail:</b> <?php echo $rr[email_contato_dir]; ?><p>
				<b>Escritório Contábil:</b> <?php echo $rr[escritorio_contador]; ?><br>
				<b>Contador:</b> <?php echo $rr[nome_contador]; ?><br>
				<b>Telefone:</b> <?php echo $rr[tel_contador]; ?><br>
				<b>E-mail:</b> <?php echo $rr[email_contador]; ?><br>
				</td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>	
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
<!---------------------7ª PÁGINA--------------->
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
		<table align="center" width="698" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="justify" class="fontepreta12">
				<h2>Local de Trabalho</h2><p>
				<b>ATIVIDADES ADMINISTRATIVAS</b><p>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Os assentos utilizados nos postos de trabalho devem atender aos seguintes requisitos mínimos de conforto:<br>
				a-	Altura ajustável à estatura do trabalhador e à natureza da função exercida.<br>
				b-	Características de pouca ou nenhuma conformação na base do assento.<br>
				c-	Borda frontal arredondada.<br>
				d-	Encosto com forma levemente adaptada ao corpo para proteção da região lombar.<p>
				<b>ATIVIDADES OPERACIONAIS</b><p>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nos setores operacionais há uma carga de movimentos repetitivos consideráveis e movimentos contínuos dos membros superiores e membros inferiores.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Destacamos o nível de atenção que as tarefas necessitam para serem executadas com segurança.<p>
				<b>FUNDAMENTAÇÃO</b><p>
				Fundamentação legal: Este trabalho baseia-se nas disposições da CLT – Consolidações das Leis Trabalhistas, regulamentação do ministério do trabalho e do emprego e documentos abaixo descritos;<br>
				Capítulo V, título II da CLT em especial no art. 198 e 199<br>
				Lei 6.514 de 22 de Dezembro de 1977<br>
				Normas Regulamentadoras do Ministério do Trabalho e Emprego aprovadas pela Portaria nº 3.214/78, com suas alterações posteriores;<br>
				NR – 17 Ergonomia.<p>
				<b>DOCUMENTOS COMPLEMENTARES</b><p>
				Portaria 3.751 de 23 de Novembro de 1990 – Revoga o Anexo IV – Iluminância da NR – 15 transferido para a NR – 17 (Ergonomia); ABNT NBR 10.152 – Níveis de ruídos para conforto acústico; ABNT NBR 5.413 – Iluminância de interiores.<p>
				<b>FUNDAMENTAÇÃO TÉCNICA</b><p>
				Para caracterização dos fatores de risco ambiental, foram utilizadas as metodologias de avaliação ambiental da Fundacentro.<br>
				ABNT NBR 5.413 – Iluminância de interiores;<br>
				FUNDACENTRO NHT 09 R/E – 1986 – Norma para avaliação da exposição ocupacional ao ruído continuo ou intermitente.
				</td>
			</tr>
		</table>	
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>
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
<!---------------------7ª PÁGINA--------------->
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
		<table align="center" width="698" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="justify" class="fontepreta12">
				<b>METODOLOGIA</b><p>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nas abordagens das avaliações preliminares ergonômicas foram utilizadas várias ferramentas científicas, observação dos postos de trabalho, check-list, planilha questionário – ordem de serviço e entrevista nos postos de trabalho junto aos funcionários. Objetivando assim implementar o trabalho na utilização das duas técnicas, a saber, a técnica objetiva (direta) e a técnica subjetiva (indireta).<p>
				<b>TÉCNICAS OBJETIVAS</b><p>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quanto às técnicas objetivas, foram realizadas observações de campo, com o registro de imagens, avaliação ambiental de stress térmico, ruídos, vibrações, medidas a incidência de iluminância, altura de mobiliários, colorização arquitetônica, permitindo uma abordagem de maneira global das atividades praticadas em cada posto de trabalho a partir da avaliação ergonômica, para identificação dos problemas, necessidades ou definições de demandas feitas com a participação direta (verbalização) do efetivo populacional da empresa.<p>
				<b>TÉCNICAS SUBJETIVAS</b><p>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As técnicas subjetivas (check-list, questionário e entrevistas) permitem levantar as opiniões dos entrevistados para a melhor complementação do trabalho garantindo que a observação realizada aproxime-se da realidade efetiva. Permitindo que a pesquisa de todos os itens previamente levantados possam propor as concepções de ambiente, carga fisiológica, carga mental e aspectos psicossociais. A caracterização da exposição aos agentes iluminância, ruído e stress térmico considerou a observação dos postos de trabalho como alvo das medições, ou seja, a utilização desses equipamentos proporcionou a definição das condições ambientais de cada posto de trabalho.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As medições de níveis de iluminância foram realizadas no posto de trabalho onde se realizam as tarefas de predominância visual, utilizando-se de luxímetro com fotocélula corrigida para a sensibilidade do olho humano e em função do ângulo de incidência. Quando não se pôde definir o campo de trabalho, considerou-se um plano horizontal a 0,75 cm do piso para efetuar a medição, considerando-se a coloração das paredes (arquitetura) a voltagem de cada luminária.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quanto ao nível de pressão sonora, especificadamente, a medição foi realizada com o microfone junto à zona auditiva do trabalhador, altura do plano horizontal que contém o canal auditivo, a uma distância, aproximada, de 150 mm do ouvido e em razão das fontes de ruídos, emitirem ruídos contínuos estacionários (com variação de nível desprezível) o período de observação foi de 5 minutos aproximadamente para cada ponto de medição.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Na avaliação de stress térmico, consideramos alguns parâmetros que influem na sobrecarga térmica a que estão submetidos os trabalhadores (temperatura do ar e umidade relativa do ar; tipo de atividade e gasto energético). O posicionamento do aparelho de medição foi o local onde permanece o trabalhador, à distância e altura da região do corpo mais atingida.
				</td>
			</tr>
		</table>	
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>
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
<!---------------------7ª PÁGINA--------------->
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
		<table align="center" width="698" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<?php
			$deci = "SELECT a.*, c.data_criacao 
					FROM aparelhos a, cliente_setor c
					WHERE a.cod_aparelho = c.ruido
					AND c.cod_cliente = $cliente";
			$dec = pg_query($connect, $deci);
			$db = pg_fetch_array($dec);
			?>
			<tr>
				<td align="left" class="fontepreta12">
				<br><h2>Instrumentos Utilizados:</h2><p>
				<b>Nome:</b> <?php echo $db[nome_aparelho]; ?> <br>
				<b>Marca:</b> <?php echo $db[marca_aparelho]; ?> <br>
				<b>Data de Calibração:</b> <?php echo date("d/m/Y", strtotime($db[data_criacao])); ?><p>
				</td>
			</tr>
			
			<?php
			$term = "SELECT a.*, c.data_criacao 
					FROM aparelhos a, cliente_setor c
					WHERE a.cod_aparelho = c.termico
					AND c.cod_cliente = $cliente";
			$ter = pg_query($connect, $term);
			$temp = pg_fetch_array($ter);
			?>
			<tr>
				<td align="left" class="fontepreta12">
				<b>Nome:</b> <?php echo $temp[nome_aparelho]; ?> <br>
				<b>Marca:</b> <?php echo $temp[marca_aparelho]; ?> <br>
				<b>Data de Calibração:</b> <?php echo date("d/m/Y", strtotime($temp[data_criacao])); ?><p>
				</td>
			</tr>

			<?php
			$luz = "SELECT a.*, i.data
					FROM aparelhos a, iluminacao_ppra i
					WHERE a.cod_aparelho = i.lux
					AND i.cod_cliente = $cliente";
			$lux = pg_query($connect, $luz);
			$ilu = pg_fetch_array($lux);
			?>
			<tr>
				<td align="left" class="fontepreta12">
				<b>Nome:</b> <?php echo $ilu[nome_aparelho]; ?> <br>
				<b>Marca:</b> <?php echo $ilu[marca_aparelho]; ?> <br>
				<b>Data de Calibração:</b> <?php echo date("d/m/Y", strtotime($ilu[data])); ?><p>
				</td>
			</tr>

			<tr>
				<td align="justify" class="fontepreta12">
				<b>CONCLUSÃO</b><p>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Num aspecto global, os postos de trabalho apresentam boas condições; não obstante com uma análise mais detalhada, foi possível detectar diversas situações que exigem intervenções ergonômicas e melhorias sistemáticas que, se bem gerenciadas, trarão melhor nível de conforto, segurança, prevenção de doenças ocupacionais e desempenho eficiente no dia a dia dos trabalhadores.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A principio, este é o objetivo deste documento, já que haverá uma mudança significativa das condições de trabalho, em face de nova visão do ambiente que nos propomos a ofertar a esta administração.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O presente trabalho abordará as três áreas da ergonomia: ergonomia física; cognitiva e organizacional; envolvendo diversos tópicos dos cincos itens que serão apresentados mais a frente.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Em virtude da não observação da adaptação das instalações este item não foi apreciado nos quesitos de concepção e ambiente, num primeiro momento da ocupação.<p>
				
				<b>CONCEPÇÃO</b><p>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Foram identificadas situações de riscos exigindo que ações sejam implantadas e implementadas nos postos de trabalhos, tanto de OEM como de SMS, relacionados com incongruência de posturas inadequadas, ferramentas impróprias ou inseguras.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tais fatores de riscos, conforme caracterizados e classificados nas planilhas de análise pró-ativa de riscos apresentam efeitos tanto humanos como organizacionais, podendo acarretar o desconforto físico, afastamentos e impactos no índice de absenteísmo (pequenas perdas de produtividades) até efeitos como sequelas e limitações funcionais (distensão muscular, lombalgias, torções articulares, DORT – Distúrbios Osteomusculares Relacionados ao Trabalho), consequência à produtividade implicando em atrasos no campo previsto de produção ou em redução do trabalho planejado, custos em atenção ao problema ou redução de mão de obra e ainda complicações com regulações governamentais ou em não atendimento à legislação. Neste cenário a atenção especial por parte da administração da empresa deve ser dada nas análises coletadas (resultado do levantamento técnico de campo) e relatadas neste trabalho.<br>

				</td>
			</tr>

		</table>	
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>
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

<!---------------------9ª PÁGINA--------------->
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
		<table align="center" width="698" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="justify" class="fontepreta12">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Obedecendo aos critérios as instalações elétricas, mecânicas, automação e química, vistos que estes envolvem atividades de maior esforço físico e exposição por parte dos trabalhadores.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Conforme recomendado nas análises pró-ativa de risco, além das outras recomendações descritas neste trabalho deve-se considerar a implantação e implementação do Programa de Cinesioterapia Laboral, com atividades programadas para fortalecimento muscular dos membros mais exigidos em uma jornada de trabalho (membros superiores e membros inferiores) e adoção de atividades aeróbicas para manutenção do condicionamento físico e mental. Um programa bem elaborado e aplicado por profissional especializado, com o conhecimento prévio da situação de trabalho de cada setor da empresa é um instrumento eficaz para prevenção da DORT, contribuindo ainda para a integração dos trabalhadores da empresa, causando assim melhoria na disposição física e rendimento da execução de tarefas “Produtividade” causando assim melhora na autoestima e satisfação profissional.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Outro fator a ser considerado em todos os setores é a postura e mobiliários inadequados principalmente no trabalho sentado. A postura estática, sentado por longos períodos com uso de computador, influi na ocorrência de posturas durante uma jornada de trabalho, portanto torna-se necessário a orientação dos trabalhadores estimulada pela administração da empresa. Para a boa educação ergonômica adotar uma postura correta e nas atividades e nos casos de trabalho sentado com uso de computadores promover pequenos períodos de pausas para exercícios e relaxamento com objetivo de interromper a rotina e estimular as articulações. Esses períodos podem ser de dez (10) ou cinco (05) minutos antes de cada hora cheia.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;É importante que esses períodos de pausa sejam formalizados para que, a simples orientação dos exercícios, não caiam no esquecimento em meio à rotina diária.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Os mobiliários utilizados são adequados, com exceção dos casos de cadeiras danificadas, já relatados na planilha de análise pró-ativa, e o uso de monitor sem regulagem de altura. Conforme estudos realizados por Grandjean, as dimensões recomendadas para altura da tela (Ponto Médio) a partir do piso, são de 78 cm a 106 cm. Embora as medidas realizadas estejam dentro da faixa recomendada, em várias mesas foram encontradas adaptações improvisadas para elevação da altura dos monitores, indicados um desconto no uso dos mesmos. Isso ocorre devido às variações de medidas antropométricas de cada pessoa, que determina as faixas de ajustes confortáveis no posto de trabalho. Sendo assim recomendamos a substituição destes monitores por outros que tenham regulagem de altura. Da mesma forma o uso de Notebook induz a inclinação do pescoço para baixo, já que o equipamento é concebido em um conjunto de teclado-monitor, permitindo a regulagem da inclinação da tela, mas não da altura. 
				Recomenda-se sua substituição por micros comuns ou o uso de adaptadores ergonômicos para os casos em que seja imprescindível o seu uso.<p>
				<b>AMBIENTE</b><p>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Foram identificados riscos de exposição ao ruído, ao calor e iluminação deficiente na produção e em alguns postos de trabalho na área administrativa. Porém, o parâmetro técnico estabelecido na NR 17, para temperatura, ruído e iluminância adequados, refere-se apenas as atividades que exijam solicitação intelectual, apresentando apenas um aspecto de desconforto e não de risco, podendo interferir no trabalho, mas não sendo causa principal de uma procura ambiental ou afastamento, por exemplo. Sendo assim, no que diz respeito aos riscos à saúde dos trabalhadores provenientes desses agentes, devem ser observadas as medidas de controle adequadas conforme o PPRA – Programa de Prevenção de Riscos Ambientais e do PCMSO – Programa de Controle Médico de Saúde Ocupacional na empresa.
				</td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>
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
<!---------------------10ª PÁGINA--------------->
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
		<table align="center" width="698" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="justify" class="fontepreta12">
				<b>TEMPERATURA</b><p>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No que tange ao calor, <?php print $dadoscompl[temperatura];print $dadoscompl[temp_elevada]." ". $dadoscompl[ceu_aberto];?>. As medições foram realizadas <?php print $dadoscompl[p_medicao];?>, e as variações de temperatura e umidade relativa do ar apresentadas neste documento sofreram influência do clima, visto que as mudanças climáticas das estações do ano e também, de um dia para o outro, alteram a intensidade do calor e sensação térmica no homem. Porém, deve-se diferenciar desconforto térmico “Stress Térmico” de sobrecarga térmica, uma vez que o primeiro é um conceito que, entre outros fatores, depende principalmente da sensibilidade das pessoas, podendo variar de pessoa para pessoa ou de uma região para outra. A sobrecarga térmica, no entanto, é um problema para qualquer pessoa em qualquer região, visto que a natureza humana é a mesma. Embora o parâmetro térmico estabelecido na NR 17 refira-se as atividades que exijam solicitação intelectual sabe-se que o calor excessiv				o é extremamente desconfortável para o corpo humano, portanto, recomenda-se, sempre que possível, o uso de ventilação forçada nos ambientes quentes e a reposição de água e sais minerais durante a exposição.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recomenda-se atenção quanto à orientação nos cuidados com a possibilidade de choque térmico, devido o deslocamento constante entre as áreas operacionais e setores climatizados da área administrativa, sobretudo no período do verão, quando as diferenças de temperaturas são acentuadas, podendo agravar sintomas de gripes; resfriados; infecções de garganta e sistema respiratório. Deve-se fazer uma regulagem adequada dos condicionadores de ar, evitando o direcionamento do vento frio direto no corpo humano, o que pode acarretar um desconforto térmico por frio excessivo.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A umidade relativa do ar pode ficar baixa no período de inverno, e os aparelhos de ar-condicionado tradicionais irão ressecar ainda mais os ambientes, portando recomenda-se o monitoramento da umidade relativa do ar neste período, preferindo apenas ventilar o ambiente e manter as janelas abertas, o que auxilia também a troca do ar.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recomenda-se ainda, adotar o uso de telas de naylon para prevenir o acesso de insetos e poeira no ambiente de trabalho.
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>	
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
<!---------------------11ª PÁGINA--------------->
<?php
$setor = "SELECT s.*
		FROM cliente_setor cs, setor s
		WHERE cs.cod_setor = s.cod_setor
		AND cs.cod_cliente = $cliente
		AND EXTRACT(year FROM data_criacao) = {$ano}";
$res = pg_query($connect, $setor);
$row = pg_fetch_all($res);
$contem = array();

for($z=0;$z<pg_num_rows($res);$z++){
	$fc = "<tr>
			<td width=210 align=center class=fontepreta12> {$row[$z][nome_setor]} </td>
			<td width=380 align=center class=fontepreta12> {$row[$z][desc_setor]} </td>
		</tr>";

$contem[] = addslashes($fc);
}
//LOOP PARA COLOCAR O MÁXIMO DE RESULTADO NA TELA
for ($y=0;$y<ceil(count($contem)/20);$y++) { ?>
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
		<table align="center" width="600" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="left" class="fontepreta14"><b>9. DESCRIÇÃO SETORIAL DAS INSTALAÇÕES DA EMPRESA</b><br>A empresa situa-se em endereço já citado, assim dividido:</td>
			</tr>
		</table><p>
		<table align="center" width="600" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td bgcolor="#999999" align="center" class="fontepreta14bold" colspan="2">SETOR</td>
			</tr>
		<?php
			$i = $y*20;
			for($x=$i;$x<$i+20;$x++){ 
			   echo $contem[$x];			
			}
		?>
		</table>
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>	
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
<!---------------------PÁGINA DE SISTEMATIZAÇÃO SETORIAL--------------->
<?php
//PEGAR O SETOR E ARMAZENAR NUM ARRAY
$setorial = "SELECT distinct(s.cod_setor) as cod
			FROM setor s, cliente_setor cs
			WHERE s.cod_setor = cs.cod_setor
			AND cs.cod_cliente = $cliente
			AND EXTRACT(year FROM data_criacao) = {$ano}";

$re_s = pg_query($connect, $setorial);
$row_s = pg_fetch_all($re_s);

		for($x=0;$x<pg_num_rows($re_s);$x++){
		
			$setores="SELECT s.*, rs.*, ag.nome_agente_risco, tr.nome_tipo_risco
					FROM cliente_setor cs, setor s, risco_setor rs, agente_risco ag, tipo_risco tr
					WHERE cs.cod_setor = s.cod_setor
					AND rs.cod_cliente = cs.cod_cliente
					AND rs.cod_setor = cs.cod_setor
					AND rs.cod_agente_risco = ag.cod_agente_risco
					AND ag.cod_tipo_risco = tr.cod_tipo_risco
					AND EXTRACT(year FROM cs.data_criacao) = EXTRACT(year FROM rs.data)
					AND cs.cod_cliente = $cliente
					AND cs.cod_setor = {$row_s[$x][cod]}
					AND EXTRACT(year FROM data_criacao) = {$ano}";
			$resu = pg_query($connect, $setores);
			$r_resu = pg_fetch_all($resu);
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
		<table align="center" width="600" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="left" class="fontepreta14"><b>10. SISTEMATIZAÇÃO SETORIAL</b><br>
				A fim de dinamizarmos o estudo sistemático NR7 (PCMSO) dividiremos a empresa por setores:</td>
			</tr>
		</table><p>
		<?php
			echo"
				<table align=center width=650 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>
					<tr>
						<td width=323 align=left class=fontepreta12><b>Setor:&nbsp;</b>".$r_resu[0][nome_setor]."</td>
						<td width=323 align=left class=fontepreta12><b>Efetivo:&nbsp;</b>";
						//PEGAR O EFETIVO DOS FUNCIONARIOS NO SETOR
						$efetivo = "SELECT f.cod_func
									FROM funcionarios f, cliente_setor cs
									WHERE cs.cod_cliente = f.cod_cliente
									AND cs.cod_setor = f.cod_setor
									AND cs.cod_cliente = $cliente
									AND cs.cod_setor = {$row_s[$x][cod]}
									AND EXTRACT(year FROM cs.data_criacao) = {$ano}";
						$efet = pg_query($connect, $efetivo);
						$efe = pg_fetch_all($efet);

							echo pg_num_rows($efet);
						echo "</td>
					</tr>
					<tr>
						<td align=left class=fontepreta12><b>Dinâmica:&nbsp;</b>".$r_resu[0][desc_setor]."</td>
						<td align=left class=fontepreta12><b>Riscos:</b>&nbsp;";
						for($y=0;$y<pg_num_rows($resu);$y++){
						    echo "<b>".$r_resu[$y][nome_tipo_risco]."-></b>&nbsp;".$r_resu[$y][nome_agente_risco].";&nbsp;";
						}
						echo "</td>
					</tr>
					<tr>
						<td colspan=2 align=left class=fontepreta10><b>Possibilidade de Doenças Ocupacionais:&nbsp;</b>";
						for($y=0;$y<pg_num_rows($resu);$y++){
						    echo $r_resu[$y][diagnostico];
						}						
						echo "</td>
					</tr>
					<tr>
						<td colspan=2 align=left class=fontepreta10><b>Medidas Preventivas:&nbsp;</b>";
						for($y=0;$y<pg_num_rows($resu);$y++){
						    echo $r_resu[$y][acao_necessaria];
						}						
						echo "</td>
					</tr>
					<tr>
						<td colspan=2 align=left class=fontepreta10><b>Possibilidades de Acidentes:&nbsp;</b>";
						$aci = "SELECT DISTINCT(acidente)
								FROM cliente_setor cs, risco_setor rs
								WHERE rs.cod_cliente = cs.cod_cliente
								AND rs.cod_setor = cs.cod_setor
								AND cs.cod_cliente = $cliente
								AND cs.cod_setor = {$row_s[$x][cod]}
								AND EXTRACT(year FROM data_criacao) = {$ano}";
						$r_aci = pg_query($connect, $aci);
						$row_aci = pg_fetch_all($r_aci);
						
						for($a=0;$a<pg_num_rows($r_aci);$a++){
						    echo $row_aci[$a][acidente]."&nbsp;";
						}						
						echo "</td>
					</tr>
					<tr>
						<td colspan=2 align=left class=fontepreta10><b>Medidas Corretivas:&nbsp;</b>";
						$cor = "SELECT DISTINCT(corretiva)
								FROM cliente_setor cs, risco_setor rs
								WHERE rs.cod_cliente = cs.cod_cliente
								AND rs.cod_setor = cs.cod_setor
								AND cs.cod_cliente = $cliente
								AND cs.cod_setor = {$row_s[$x][cod]}
								AND EXTRACT(year FROM data_criacao) = {$ano}";
						$r_cor = pg_query($connect, $cor);
						$row_cor = pg_fetch_all($r_cor);
						
						for($b=0;$b<pg_num_rows($r_cor);$b++){
						    echo $row_cor[$b][corretiva]."&nbsp;";
						}						
						echo "</td>
					</tr>
				</table>";
		?>
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>	
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
<!---------------------13ª PÁGINA--------------->
<?php
$relacao = "SELECT f.cod_func, f.nome_func, f.data_admissao_func, fu.nome_funcao, f.data_ultimo_exame
			FROM funcionarios f, cliente_setor cs, funcao fu
			WHERE cs.cod_cliente = f.cod_cliente
			AND cs.cod_setor = f.cod_setor
			AND f.cod_funcao = fu.cod_funcao
			AND cs.cod_cliente = $cliente
			AND EXTRACT(year FROM data_criacao) = {$ano}
			ORDER BY nome_func";
$rela = pg_query($connect, $relacao);

$tem = array();
while($real = pg_fetch_array($rela)){

	$fuc = "<tr>
		<td align=left class=fontepreta12> {$real[nome_func]}&nbsp;</td>
		<td align=left class=fontepreta12> {$real[nome_funcao]}&nbsp;</td>
		<td align=center class=fontepreta12> {$real[data_admissao_func]}&nbsp;</td>
		<td align=center class=fontepreta12> {$real[data_ultimo_exame]}&nbsp;</td>
	</tr>";
	
$tem[] = addslashes($fuc);
} 
//LOOP PARA COLOCAR O MÁXIMO DE RESULTADO NA TELA
for ($y=0;$y<ceil(count($tem)/20);$y++) { ?>
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
		<table align="center" width="698" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="left" class="fontepreta14"><b>11. DADOS CADASTRAIS DOS FUNCIONÁRIOS e CRONOGRAMA DE EXAMES:</b><br>
				Independente da faixa etária, a coordenação do PCMSO determina exames anuais personalizados, conforme tabela abaixo. O encaminhamento do funcionário para o periódico é de fundamental importância para futura elaboração do PPP, tendo como data base o período de 12 meses entre a realização dos exames.
				</td>
			</tr>
		</table><br>
		<table align="center" width="695" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="left" class="fontepreta12" width="250">&nbsp;NOME</td>
				<td align="left" class="fontepreta12" width="270">&nbsp;FUNÇÃO</td>
				<td align="center" class="fontepreta12" width="80">ADMISSÃO</td>
				<td align="center" class="fontepreta12" width="90">ÚLTIMO EXAME</td>
			</tr>
		<?php
			$i = $y*20;
			for($x=$i;$x<$i+20;$x++){ 
			   echo $tem[$x];			
			}
		?>
		</table>
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>	
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
<!---------------------14ª PÁGINA--------------->
<table align="center" width="700" height="<?php echo $height; ?>" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td class="tabela" valign="top">
			<?php 
			if(!$_GET[sem_timbre]){
				include "header.php"; 
			}else{
				include "head.php";
			}
			//ARRAY PARA ARMAZENAR OS MESES POR EXTENSO	
			$meses = array(" ", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
			?>
		</td>
	</tr>
	<tr>
	<td class="tabela" valign="top">
		<table align="center" width="698" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="left" class="fontepreta14"><b>12. CONSIDERAÇÕES FINAIS</b><br>&nbsp;</td>
			</tr>
			<tr>
				<td align="justify" class="fontepreta12">
				1º No caso de epidemias ou endemias de doenças de controle previsíveis por vacinação, o médico examinador, por ocasião dos Exames Médicos Ocupacional, poderá solicitar a imunização e/ ou o atestado de vacinação.<p>
				2º Os casos de doenças de notificação compulsória, verificados durante os Exames Médicos Ocupacional, serão comunicados às autoridades sanitárias correspondentes e ao candidato/ empregado ou aos seus familiares.<p>
				3º O não comparecimento ao Exame Médico Ocupacional acarretará as seguintes medidas:<p>
				&bull; EMA -  eliminação do processo admissional;<br>
				&bull; EMMF – retardamento da mudança até a realização do exame;<br>
				&bull; EMRT – o empregado só poderá reassumir suas atividades após se submeter a esta modalidade de exame;<br>
				&bull; EMD – o desligamento de empregado ficará condicionado à realização do exame dentro do prazo de 15 dias que antecedem o desligamento definitivo do empregado;<br>
				&bull; EMP –  sanções administrativas disciplinares, a critério do empregador.<p>
				Rio de Janeiro, 
				<?PHP 
					$sql = "select data_criacao from cliente_setor where cod_cliente = $cliente";
					$res = pg_query($connect, $sql);
					$row = pg_fetch_array($res);
					echo date("d", strtotime($row[data_criacao]))." de ".$meses[date("n", strtotime($row[data_criacao]))]." de ".date("Y", strtotime($row[data_criacao]));
				?>
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>	
		<b><hr>Drª. Maria de Lourdes F. de Magalhães</b><br>Médica do Trabalho – Coordenadora do PCMSO<br>CRM 52.33471-0 Reg. MTE 13.320

				</td>
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
    </td> </tr>
</table>
<!---------------------15ª PÁGINA--------------->
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
		<table align="center" width="500" height="<?php echo $hei; ?>" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center"><h1>Programa de Controle Médico de Saúde Ocupacional<p>PCMSO – <?php if($rr[data_criacao]){ echo date("Y", strtotime($rr[data_criacao])); } ?> <p>EXAMES MÉDICOS OCUPACIONAIS PROCEDIMENTOS</h1></td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>	
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
<!---------------------PÁGINA ADMISSIONAL--------------->
<?php 
$quant = "SELECT count(f.cod_func) as n, fu.nome_funcao, fu.cod_funcao
		FROM funcionarios f, funcao fu
		WHERE f.cod_funcao = fu.cod_funcao 
		AND f.cod_cliente = $cliente
		AND substr(f.data_admissao_func, 7, 4) = {$ano}
		group by fu.nome_funcao, fu.cod_funcao";
$r_qnt = pg_query($connect, $quant);
$row_qnt = pg_fetch_all($r_qnt);

$cont = array();
for($e=0;$e<pg_num_rows($r_qnt);$e++){

	$ad = "<tr>
		<td width=210 align=left class=fontepreta12> {$row_qnt[$e][n]} - {$row_qnt[$e][nome_funcao]}</td>
		<td width=120 align=left class=fontepreta12>";
		
		$ativ = "SELECT distinct(cs.tipo_setor)
				FROM cliente_setor cs, funcionarios f, funcao fu
				WHERE cs.cod_cliente = f.cod_cliente
				AND cs.cod_setor = f.cod_setor
				AND f.cod_funcao = fu.cod_funcao
				AND cs.cod_cliente = $cliente
				AND fu.cod_funcao = {$row_qnt[$e][cod_funcao]}
				AND EXTRACT(year FROM data_criacao) = {$ano}";
		$at = pg_query($connect, $ativ);
		$att = pg_fetch_all($at);
		
		for($z=0;$z<pg_num_rows($at);$z++){
			$ad .= $att[$z][tipo_setor];
		}
		
		$ad .= "</td>
		<td width=150 align=left class=fontepreta12>";
		
		$agente = "SELECT distinct(tr.nome_tipo_risco)
					FROM risco_setor rs, agente_risco ag, tipo_risco tr, funcionarios f, funcao fu
					WHERE f.cod_funcao = fu.cod_funcao
					AND f.cod_cliente = rs.cod_cliente
					AND f.cod_setor = rs.cod_setor
					AND rs.cod_agente_risco = ag.cod_agente_risco
					AND ag.cod_tipo_risco = tr.cod_tipo_risco
					AND f.cod_cliente = $cliente
					AND fu.cod_funcao = {$row_qnt[$e][cod_funcao]}
					AND substr(f.data_admissao_func, 7, 4) = {$ano}";
		$age = pg_query($connect, $agente);
		$agg = pg_fetch_all($age);
		
		for($w=0;$w<pg_num_rows($age);$w++){
			$ad .= $agg[$w][nome_tipo_risco]; $ad .= "<br>";
		}
		
		$ad .= "</td>
		<td width=100 align=left class=fontepreta12><center>Sim&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sim</center></td>
		<td width=110 align=left class=fontepreta12>&nbsp;</td>
	</tr>";
$cont[] = addslashes($ad);
}
//LOOP PARA COLOCAR O MÁXIMO DE RESULTADO NA TELA
for ($y=0;$y<ceil(count($cont)/5);$y++) { ?>
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
		<table align="center" width="695" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td colspan="5" align="center" class="fontepreta12"><h1>EXAME MÉDICO ADMISSIONAL (EMA)</h1></td>
			</tr>
			<tr>
				<td width="210" align="left" class="fontepreta12">Candidatos a:</td>
				<td width="120" align="left" class="fontepreta12">Descrição da Atividade</td>
				<td width="150" align="left" class="fontepreta12">Agente de Risco</td>
				<td width="100" align="left" class="fontepreta12">Rotina<br><center>AC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EC</center></td>
				<td width="110" align="left" class="fontepreta12">Observação</td>
			</tr>
		<?php
			$i = $y*5;
			for($x=$i;$x<$i+5;$x++){ 
			   echo $cont[$x];			
			}
		?>
		</table>
		<table align="center" width="695" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td colspan="2" align="center" class="fontepreta14bold">PROCEDIMENTOS</td>
			</tr>
			<tr>
				<td width="250" align="center" class="fontepreta12">Tipo de Exame</td>
				<td width="490" align="center" class="fontepreta12">Descrição</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">AC = Avaliação Clínica</td>
				<td align="left" class="fontepreta12">Análise ocupacional, exame físico e mental.</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">EC = Exames Complementares</td>
				<td align="left" class="fontepreta12">
				<?php
				$tudodentro = array();
				for($e=0;$e<pg_num_rows($r_qnt);$e++){
					$comp = "SELECT distinct(fe.descricao)
							FROM funcionarios f, funcao fu, funcao_exame fe
							WHERE f.cod_funcao = fu.cod_funcao
							AND fu.cod_funcao = fe.cod_exame
							AND f.cod_cliente = $cliente
							AND fu.cod_funcao = {$row_qnt[$e][cod_funcao]}
							--AND substr(f.data_admissao_func, 7, 4) = {$ano}";
					$cp = pg_query($connect, $comp);
					$ex = pg_fetch_all($cp);
					
					for($q=0;$q<pg_num_rows($cp);$q++){
						$tudodentro[] = $ex[$q][descricao];
					}
					$tudodentro = array_flip($tudodentro);
					$tudodentro = array_flip($tudodentro);
					for($o=0;$o<count($tudodentro);$o++){
						if($tudodentro[$o] != ""){ 
							echo $tudodentro[$o].",&nbsp;";
						}else{
							echo "&nbsp;";
						}
					}	
				}
				?>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="left" class="fontepreta12"><b>PERIODICIDADE:</b> Os procedimentos deverão ser adotados até 5 (cinco) dias antes da admissão</td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>	
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
<!---------------------PÁGINA PERIÓDICO--------------->
<?php 
$quant = "SELECT count(f.cod_func) as n, fu.nome_funcao, fu.cod_funcao
		FROM funcionarios f, funcao fu
		WHERE f.cod_funcao = fu.cod_funcao 
		AND f.cod_cliente = $cliente
		AND substr(f.data_admissao_func, 7, 4) < {$ano}
		group by fu.nome_funcao, fu.cod_funcao";
$r_qnt = pg_query($connect, $quant);
$row_qnt = pg_fetch_all($r_qnt);

$content = array();

for($e=0;$e<pg_num_rows($r_qnt);$e++){

$tmp = "
	<tr>
		<td width=210 align=left class=fontepreta12> {$row_qnt[$e][n]} - {$row_qnt[$e][nome_funcao]}</td>
		<td width=120 align=left class=fontepreta12>";
		
		$ativ = "SELECT distinct(cs.tipo_setor)
				FROM cliente_setor cs, funcionarios f, funcao fu
				WHERE cs.cod_cliente = f.cod_cliente
				AND cs.cod_setor = f.cod_setor
				AND f.cod_funcao = fu.cod_funcao
				AND cs.cod_cliente = $cliente
				AND fu.cod_funcao = {$row_qnt[$e][cod_funcao]}
				AND EXTRACT(year FROM data_criacao) = {$ano}";
		$at = pg_query($connect, $ativ);
		$att = pg_fetch_all($at);
		
		for($z=0;$z<pg_num_rows($at);$z++){
			$tmp .= $att[$z][tipo_setor];
		}
		
		$tmp .= "</td>
		<td width=150 align=left class=fontepreta12>";
		
		$agente = "SELECT distinct(tr.nome_tipo_risco)
					FROM risco_setor rs, agente_risco ag, tipo_risco tr, funcionarios f, funcao fu
					WHERE f.cod_funcao = fu.cod_funcao
					AND f.cod_cliente = rs.cod_cliente
					AND f.cod_setor = rs.cod_setor
					AND rs.cod_agente_risco = ag.cod_agente_risco
					AND ag.cod_tipo_risco = tr.cod_tipo_risco
					AND f.cod_cliente = $cliente
					AND fu.cod_funcao = {$row_qnt[$e][cod_funcao]}
					--AND substr(f.data_admissao_func, 7, 4) = {$ano}";
		$age = pg_query($connect, $agente);
		$agg = pg_fetch_all($age);
		
		for($w=0;$w<pg_num_rows($age);$w++){
			$tmp .= $agg[$w][nome_tipo_risco]; $tmp .= "<br>";
		}
		
		$tmp .= "</td>
		<td width=100 align=left class=fontepreta12><center>Sim&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sim</center></td>
		<td width=110 align=left class=fontepreta12>&nbsp;</td>
	</tr>
	";

$content[] = addslashes($tmp);

} 
//LOOP PARA COLOCAR O MÁXIMO DE RESULTADO NA TELA
for ($y=0;$y<ceil(count($content)/5);$y++) { ?>
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
		<table align="center" width="695" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td colspan="5" align="center" class="fontepreta12"><h1>EXAME MÉDICO PERIÓDICO (EMP)</h1></td>
			</tr>
			<tr>
				<td width="210" align="left" class="fontepreta12">Candidatos a:</td>
				<td width="120" align="left" class="fontepreta12">Descrição da Atividade</td>
				<td width="150" align="left" class="fontepreta12">Agente de Risco</td>
				<td width="100" align="left" class="fontepreta12">Rotina<br><center>AC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EC</center></td>
				<td width="110" align="left" class="fontepreta12">Observação</td>
			</tr>
			<?php
			$i = $y*5;
			for($x=$i;$x<$i+5;$x++){ 
			   echo $content[$x];			
			}
			?>
		</table>
		<table align="center" width="695" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td colspan="2" align="center" class="fontepreta14bold">PROCEDIMENTOS</td>
			</tr>
			<tr>
				<td width="250" align="center" class="fontepreta12">Tipo de Exame</td>
				<td width="490" align="center" class="fontepreta12">Descrição</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">AC = Avaliação Clínica</td>
				<td align="left" class="fontepreta12">Análise ocupacional, exame físico e mental.</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">EC = Exames Complementares</td>
				<td align="left" class="fontepreta12">
				<?php
				$dentro = array();
				for($e=0;$e<pg_num_rows($r_qnt);$e++){
					$comp = "SELECT distinct(fe.descricao)
							FROM funcionarios f, funcao fu, funcao_exame fe
							WHERE f.cod_funcao = fu.cod_funcao
							AND fu.cod_funcao = fe.cod_exame
							AND f.cod_cliente = $cliente
							AND fu.cod_funcao = {$row_qnt[$e][cod_funcao]}
							--AND substr(f.data_admissao_func, 7, 4) = {$ano}";
					$cp = pg_query($connect, $comp);
					$ex = pg_fetch_all($cp);
					
					for($q=0;$q<pg_num_rows($cp);$q++){
						$dentro[] = $ex[$q][descricao];
					}											
				}
				$toloop = count($dentro);
				$dentro = array_flip($dentro);
				$dentro = array_flip($dentro);

				for($t=0;$t<$toloop;$t++){
					if($dentro[$t] != ""){ 
						echo $dentro[$t].",&nbsp;";
					}else{
						echo "&nbsp;";
					}
				}
				?>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="left" class="fontepreta12"><b>PERIODICIDADE:</b> Os procedimentos deverão ser adotados até 5 (cinco) dias antes da admissão</td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>	
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
<!---------------------PÁGINA DEMISSIONAL--------------->
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
		<table align="center" width="695" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td colspan="5" align="center" class="fontepreta12"><h1>EXAME MÉDICO DEMISSIONAL (EMD)</h1></td>
			</tr>
			<tr>
				<td width="210" align="left" class="fontepreta12">Candidatos a:</td>
				<td width="120" align="left" class="fontepreta12">Descrição da Atividade</td>
				<td width="150" align="left" class="fontepreta12">Agente de Risco</td>
				<td width="100" align="left" class="fontepreta12">Rotina<br><center>AC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EC</center></td>
				<td width="110" align="left" class="fontepreta12">Observação</td>
			</tr>
		</table>
		<table align="center" width="695" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="210" align="left" class="fontepreta12">&nbsp;</td>
				<td width="120" align="left" class="fontepreta12">&nbsp;</td>
				<td width="150" align="left" class="fontepreta12">&nbsp;</td>
				<td width="100" align="left" class="fontepreta12"><center>|</center></td>
				<td width="110" align="left" class="fontepreta12">&nbsp;</td>
			</tr>
		</table>
		<table align="center" width="695" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td colspan="2" align="center" class="fontepreta14bold">PROCEDIMENTOS</td>
			</tr>
			<tr>
				<td width="250" align="center" class="fontepreta12">Tipo de Exame</td>
				<td width="490" align="center" class="fontepreta12">Descrição</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">AC = Avaliação Clínica</td>
				<td align="left" class="fontepreta12">Análise ocupacional, exame físico e mental.</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">EC = Exames Complementares</td>
				<td align="left" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" align="left" class="fontepreta12"><b>PERIODICIDADE:</b> Os procedimentos deverão ser adotados até 10 (cinco) dias após a demissão.</td>
			</tr>
		</table><p>
		<table align="center" width="695" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td colspan="5" align="center" class="fontepreta12"><h1>EXAME MÉDICO RETORNO DE TRABALHO (EMRT)</h1></td>
			</tr>
			<tr>
				<td align="justify" class="fontepreta12">Deverão ser realizadas avaliações clínicas e exames complementares, se necessário, para esclarecimento de diagnóstico, no primeiro dia da volta ao trabalho, de todos trabalhadores ausentes no período igual ou superior a 30 (trinta) dias por motivo de doença ou acidente de natureza ocupacional ou não e parto.</td>
			</tr>
		</table><p>
		<table align="center" width="695" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td colspan="5" align="center" class="fontepreta12"><h1>EXAME MÉDICO DE MUDANÇA DE FUNÇÃO (EMMF)</h1></td>
			</tr>
			<tr>
				<td align="justify" class="fontepreta12">Deverá ser realizado em até 5 (cinco) dias da mudança, desde que as alterações na atividade no posto de trabalho ou setor impliquem na exposição do trabalhador a riscos diferentes daqueles a que estava exposto.</td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>	
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
<!---------------------PÁGINA REALIZAÇÃO--------------->
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
		<table align="center" width="695" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center" class="fontepreta12"><h1>PROGRAMA DE CONTROLE MÉDICO DE SAÚDE OCUPACIONAL</h1><br><b>PCMSO</b><hr></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">
				<i>Realização:</i><br>
				Rio de Janeiro, 
				<?PHP 
					$sql = "select data_criacao from cliente_setor where cod_cliente = $cliente AND EXTRACT(year FROM data_criacao) = {$ano}";
					$res = pg_query($connect, $sql);
					$row = pg_fetch_array($res);
					echo date("d", strtotime($row[data_criacao]))." de ".$meses[date("n", strtotime($row[data_criacao]))]." de ".date("Y", strtotime($row[data_criacao]));
				?><p>
				<i>Período:</i><br>
				<?php echo $meses[date("n", strtotime($row[data_criacao]))]." / ".date("Y", strtotime($row[data_criacao]))." à ".$meses[date("n", strtotime($row[data_criacao]))-1]." / ".(date("Y", strtotime($row[data_criacao]))+1); ?><p>
				<i>Elaboração:</i><br>
				SESMT – SERVIÇOS ESPECIALIZADOS DE SEGURANÇA E MONITORAMENTO DE ATIVIDADE NO TRABALHO LTDA.<br>RUA MARECHAL ANTÔNIO DE SOUZA, 92 – JARDIM AMÉRICA.<br>CNPJ 04.722.248/0001-17<p>
				<img align="middle" src="../img/assin_medica0.png" width="210" height="85"><br>Drª. Maria de Lourdes F. de Magalhães<br>Médica do Trabalho<br>Coordenadora do PCMSO<br>CRM /RJ – 52.33.471-0 - MTE 13320<p>
				<i>Fundamentação Legal:</i><br>
				Constituição federal, capítulo II (Dos Direitos Sociais), artigo 6º e 7º, incisos XXII, XXIII, XXVIII E XXXIII;<br>Consolidação das leis do trabalho – CLT, Capítulo V, artigos 168 e 1669; Lei 6.514, de 22 de dezembro de 1977;<br>Portaria do MTE nº 24, de 29/12/94, aprova o novo texto da NR-7.<p>
				<hr><p>
				<h2><?php echo $rr[razao_social]; ?></h2>
				</td>
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
        </td> </tr>
</table>
<!---------------------CAPA REALIZAÇÃO--------------->
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
		<?PHP 
			$sql = "select data_criacao from cliente_setor where cod_cliente = $cliente AND EXTRACT(year FROM data_criacao) = {$ano}";
			$res = pg_query($connect, $sql);
			$row = pg_fetch_array($res);
		?>
		<table align="center" width="695" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center"><h1><b>PROGRAMA DE CONTROLE MÉDICO DE SAÚDE OCUPACIONAL<p>
				PCMSO - <?php echo date("Y", strtotime($row[data_criacao]))." / ".(date("Y", strtotime($row[data_criacao]))+1); ?><p>
				ANEXOS; CONSIDERAÇÕES GERAIS; INFORMAÇÕES COMPLEMENTARES; PLANEJAMENTO ANUAL E RELAÇÃO DE EMPREGADOS<p>
				PCMSO - <?php echo date("Y", strtotime($row[data_criacao]))." / ".(date("Y", strtotime($row[data_criacao]))+1); ?></b></h1>
				</td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>	
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
<!---------------------TEXTO SOBRE ATESTADO--------------->
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
		<table align="center" width="695" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="justify" class="fontepreta12">
				Para cada exame realizado deverá ser emitido um atestado de saúde ocupacional em três vias, devendo a primeira via ficar arquivada na empresa para controle e eventual apresentação à fiscalização, a segunda deverá ser entregue aos funcionários, o qual deverá protocolar, a primeira e terceira via com o médico coordenador para seu controle.<p>
				Todo o funcionário deverá possuir um prontuário clínico individual que deverá ficar sob responsabilidade do coordenador durante um período mínimo de 20 anos após o desligamento do funcionário. No prontuário deverá constar todo o dado obtido nos exames médicos, avaliações clínicas e exames complementares, bem como as conclusões e eventuais medidas aplicadas: em caso de substituição do coordenador os arquivos deverão ser transferidos para seu sucessor; o coordenador deverá emitir relatório anual dos objetivos alcançados, que deverá ser anexado ao final do ano vigente do período referido no PCMSO.<p>
				Todos os estabelecimentos comerciais e ou institucionais, devem possuir um kit de primeiros socorros, composto, por exemplo, dos seguintes itens por setor ou função:<p>
				Água oxigenada; Álcool 70%; Algodão em bolinha; Atadura; Cotonete; Curativo adesivo (band-aid); Esparadrapo; Ficha de controle de retirada; Gaze esterelizada; Luva descartável; Pinça; Relação de material e quantidade contida no armário; Reparil gel; Repelente; Solução antisséptica; Soro fisiológico; Termômetro; Vaselina líquida ou Dersani.<p>
				O PCMSO poderá sofrer alterações a qualquer momento, em algumas partes ou até mesmo no seu todo, quando o médico detectar mudanças nos riscos ocupacionais decorrentes de alterações nos processos de trabalho, novas descobertas da ciência médica em relação a efeitos de riscos existentes, mudança de critérios e interpretação de exames ou ainda a reavaliação do reconhecimento dos riscos por competência da legislação NR.<p>
				O PCMSO deverá ter caráter de prevenção, rastreamento e diagnóstico precoce dos agravos à saúde relacionados ao trabalho, inclusive de natureza sub-clínica, além da constatação da existência de casos de doenças profissionais ou danos irreversíveis à saúde dos trabalhadores. Em face ao despacho de 1º de outubro de 96 da Secretaria de Segurança e Saúde do Trabalho.<p>
				</td>
			</tr>
			<tr>
				<td align="right" class="fontepreta12">Rio de Janeiro, 
				<?PHP 
					$sql = "select data_criacao from cliente_setor where cod_cliente = $cliente AND EXTRACT(year FROM data_criacao) = {$ano}";
					$res = pg_query($connect, $sql);
					$row = pg_fetch_array($res);
					echo date("d", strtotime($row[data_criacao]))." de ".$meses[date("n", strtotime($row[data_criacao]))]." de ".date("Y", strtotime($row[data_criacao]));
				?>
				</td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>	
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
<!---------------------TEXTO SOBRE ATESTADO--------------->
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
		<table align="center" width="695" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="justify" class="fontepreta12">
				<b><h2>INFORMAÇÕES COMPLEMENTARES</h2></b><p>
				<b><h3>RECOMENDAÇÕES À EMPRESA</h3></b><p>
				Este capítulo tem como objetivo principal orientar a administração desta empresa como se pode minimizar os problemas decorrentes de incidência e imperícia no âmbito da empresa, ele visa trazer uma oportunidade com um custo baixo, e não só orientar os colaboradores de sua empresa, mas, salvar e guardar a qualidade dos produtos e serviços prestados aos seus clientes sem contar o bom nome da empresa que deve ser sempre protegido de escândalos e de investidas das fiscalizações.<p>
				Recomenda-se que todos os colaboradores devam receber orientações sobre segurança do trabalho e prevenção de acidentes, objetivando cumprir com a NR 5.6.4 lei 6.514/77 que diz não haver obrigatoriedade da CIPA instituída através do voto por falta de contingente, deverá ter um colaborador treinado, funcionando como um multiplicador aos demais companheiros.<p>
				Recomenda-se que todos os colaboradores devam receber orientações sobre alcoolismo, objetivando desmotivar o uso de tal substância o que acarretaria em possíveis danos a saúde e na produtividade da empresa.<p>
				Recomenda-se que todos os colaboradores devam receber orientações sobre tabagismo, objetivando desmotivar o uso de tal substância o que acarretaria em possíveis danos a saúde do fumante, dos que os rodeiam e na produtividade da empresa, podendo ainda provocar princípios de incêndios.<p>
				Recomenda-se que todos os colaboradores devam receber orientações sobre doenças sexualmente transmissíveis (DST), doenças ostenculares relacionadas ao trabalho (DORT), objetivando a conscientização e prevenção das mesmas.<p>
				Recomenda-se que todos os colaboradores devam receber orientações sobre o uso dos equipamentos de prevenção individual (EPI), objetivando a conscientização e prevenção da saúde e integridade física dos colaboradores e isenção de ações jurídicas.
				</td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>	
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
<!---------------------TEXTO SOBRE RISCOS BIOLÓGICOS--------------->
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
		<table align="center" width="695" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="justify" class="fontepreta12">
				<b><h3>RECOMENDAÇÕES DE RISCOS BIOLÓGICOS CONSIDERADOS LEVES PARA MONITORAMENTO DO PCMSO</h3></b><p>
				Cobrir com capas plásticas os teclados dos micros computadores ou virar as teclas para baixo no final de cada expediente, proporcionando assim que as particulas de poeiras suspensas no ambiente não sedimente nos mesmos.<p>
				<b>Possiveis Sintomas:</b> Dor de cabeça, problemas alérgicos e respiratórios.<p>
				Subistituir vasos de plantas naturais por artificiais em ambientes refrigerados mecanicamente “Ar Condicionado”.<p>
				<b>Possiveis Sintomas:</b> Problemas Alérgicos e dermatológicos, gerado dos excrementos de anelídeos que em contato com ar refrigerado e respirado pelo ser humano em ambiente enclausurado.<p>
				<b><h3>CAMPANHA DE VACINAÇÃO</h3></b><p>
				Recomenda-se Divulgar, insentivar e promover a política de vacinação prevencionista como:<p>
				<b>Antigripal</b> – Recomendada para todas as idades e sendo administrada anualmente, próximo aos meses de inverno, preferencialmente no mês de Abril.<p>
				<b>Antitetânica</b> – Recomendada a tomar as 03 doses e depois a cada 10 anos.<p>
				<b>Hepatite</b> – Recomendada na fase adulta a tomar as 03 doses sendo que a 2º depois com 30 dias e a 3º dose com 180 dias.<p>
				<b>Vacina contra Rubéola</b> - Deverão ser vacinadas nas campanhas realizadas pela Secretaria de Estado da Saúde: com aplicação da vacina dupla viral (sarampo e rubéola) em homens e mulheres de 20 a 39 anos de idade mesmo aquelas que já tomaram a vacina anteriormente ou que referem já ter tido a doença e pessoas com idade até 19 anos a tríplice viral (sarampo, caxumba e rubéola).
				</td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>	
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
<!---------------------TEXTO SOBRE EPIDEMIOLOGIA--------------->
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
		<table align="center" width="695" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="justify" class="fontepreta12">
				<b><h3>RECOMENDAÇÕES DE CONTROLES EPIDEMIOLOGIA</h3></b><p>
				<b>MOSQUITO DA DENGUE (AEDES AEGYPT):</b> A única maneira de evitar a dengue ( Aedes Aegypt) é não deixar o mosquito nascer. Combater a larva é mais fácil que combater o mosquito adulto.<p>
				É aí que você pode ajudar! Lembre-se:<p>
				&bull; Designar um grupo de trabalho em sua Unidade/Órgão com a participação da Cipa, sob a Coordenação do ATU/ATD;<br>
				&bull; Eliminar os criadouros internos como: vasos, pratos de xaxim, enfeites e todo tipo de situação que possa acumular água limpa;<br>
				&bull; Providenciar a limpeza de calhas, lajes, caixas d'água juntamente com o apoio do Estec;<br>
				&bull; Remover entulhos provenientes de restos de construção, sucata de descarte e lixos em geral;<br>
				&bull; Fiscalizar o cumprimento das medidas adotadas;<br>
				&bull; Divulgar aos funcionários e convencê-los que essa proibição é para o bem comum.<p>
				<b>GRIPE H1N1(Influenza A)</b><p>
				Considerando de que o vírus da gripe H1N1 está confirmado a multiplicação e sua ploriferação, a melhor forma de combater a doença é a prevenção.<br>
				Lista com alguns hábitos que será muito útil manter, são recomendações do Centro de controle e prevenção de doenças dos Estados Unidos.<p>
				1. Evite contato direto com pessoas doentes;<br>
				2. Cubra seu nariz e boca se por a caso for tossir ou espirrar;<br>
				3. Evite ao máximo tocar no nariz, boca e olhos, se for mesmo necessário lave as mãos antes;<br>
				4. Se você ficar doente, procure ficar em casa e restringir o contato com outras pessoas, para evitar o contagio;<br>
				5. Lave as mãos sempre com água e sabão, álcool também é ótimo para higienizar as mãos.<p>
				Fique atento, pois  os sintomas da gripe H1N1 são muito parecidos com  o da gripe comum, você pode ter: febre, letargia, falta de apetite e tosse.<br>
				Em algumas pessoas esta gripe pode provocar: coriza, garganta seca, náusea, vômito e diarréia.<br>
				Se você ou algum familiar tiver com estes sintomas procure um médico.
				</td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>	
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

<!---------------------PLANEJAMENTO ANUAL--------------->
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
		<table align="center" width="695" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center" class="fontepreta12">
				<h2><b>PLANEJAMENTO ANUAL DE: <?php echo date("Y", strtotime($row[data_criacao]))." à ".(date("Y", strtotime($row[data_criacao]))+1); ?></b></h2>
				</td>
			</tr>
		</table>
		<table align="center" width="695" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="90" bgcolor="#999999" align="center" class="fontepreta12">ATIVIDADE</td>
			<?PHP
			  $m = array(" ", "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");
			  for($x=1;$x<=12;$x++){
				 echo "<td width=50 bgcolor=#999999 align=center class=fontepreta12>{$m[$x]}</td>";
			  }
			?>
			</tr>
			<tr>
				<td width="90" align="center" class="fontepreta12">Elaboração do PCMSO</td>
			<?PHP
			  $dt = "SELECT data_criacao FROM cliente_setor WHERE cod_cliente = $cliente AND EXTRACT(year FROM data_criacao) = {$ano}";
			  $dat = pg_query($connect, $dt);
			  $re = pg_fetch_array($dat);
			  for($x=1;$x<=12;$x++){
			  	if($x==date("n", strtotime($re[data_criacao]))){
				 echo "<td width=50 align=center class=fontepreta12>X X X</td>";
			    }else{
				 echo "<td width=50 align=center class=fontepreta12>&nbsp;</td>";
				}
			  }
			?>
			</tr>
			<tr>
				<td width="90" align="center" class="fontepreta12">Realização dos Exames Periódicos</td>
			<?PHP
			  for($x=1;$x<=12;$x++){
			  	if($x==date("n", strtotime($re[data_criacao]))){
				 echo "<td width=50 align=center class=fontepreta12>X X X</td>";
			    }else{
				 echo "<td width=50 align=center class=fontepreta12>&nbsp;</td>";
				}
			  }
			?>
			</tr>
			<tr>
				<td width="90" align="center" class="fontepreta12">Avaliação Global da Eficácia do Programa</td>
			<?PHP
			  for($x=1;$x<=12;$x++){
			  	if($x==date("n", mktime(0, 0, 0, date("n", strtotime($re[data_criacao]))+6, 1, 2009))){
				 echo "<td width=50 align=center class=fontepreta12>X</td>";
			    }else{
				 echo "<td width=50 align=center class=fontepreta12>&nbsp;</td>";
				}
			  }
			?>
			</tr>
			<tr>
				<td width="90" align="center" class="fontepreta12">Elaboração do Relatório Anual</td>
			<?PHP
			  for($x=1;$x<=12;$x++){
			  	if($x==date("n", mktime(0, 0, 0, date("n", strtotime($re[data_criacao]))+11, 1, 2009))){
				 echo "<td width=50 align=center class=fontepreta12>X&nbsp;X</td>";
			    }else{
				 echo "<td width=50 align=center class=fontepreta12>&nbsp;</td>";
				}
			  }
			?>
			</tr>
			<tr>
				<td width="90" align="center" class="fontepreta12">Renovação do Programa</td>
			<?PHP
			  for($x=1;$x<=12;$x++){
			  	if($x==date("n", mktime(0, 0, 0, date("n", strtotime($re[data_criacao]))+11, 1, 2009))){
				 echo "<td width=50 align=center class=fontepreta12>X&nbsp;X</td>";
			    }else{
				 echo "<td width=50 align=center class=fontepreta12>&nbsp;</td>";
				}
			  }
			?>
			</tr>
		</table><p>
		<table align="center" width="695" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="left" class="fontepreta12">
				<b>Legenda:</b><p>
				Em Execução no Ano de <?php echo date("Y", strtotime($row[data_criacao]))." / ".(date("Y", strtotime($row[data_criacao]))+1); ?> X<p>
				Em Execução no Ano de <?php echo date("Y", strtotime($row[data_criacao]))+1; ?> X X<p>
				Executado X X X
				</td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>	
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
<!---------------------RELAÇÃO DE FUNCIONÁRIOS--------------->
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
		<table align="center" width="695" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center" class="fontepreta12"><h2>Relação de Funcionários</h2></td>
			</tr>
		</table><br>
		<table align="center" width="695" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="200" align="center" bgcolor="#999999" class="fontepreta12bold">Nome</td>
				<td width="190" align="center" bgcolor="#999999" class="fontepreta12bold">Função</td>
				<td width="80" align="center" bgcolor="#999999" class="fontepreta12bold">Admissão</td>
				<td width="80" align="center" bgcolor="#999999" class="fontepreta12bold">Documento</td>
				<td width="80" align="center" bgcolor="#999999" class="fontepreta12bold">Dt. Nasc.</td>
				<td width="60" align="center" bgcolor="#999999" class="fontepreta12bold">CBO</td>
			</tr>
<?php
$rela = "SELECT nome_func, nome_funcao, data_admissao_func, num_ctps_func, serie_ctps_func, data_nasc_func, cbo 
		FROM funcionarios f, funcao fu
		WHERE f.cod_funcao = fu.cod_funcao
		AND f.cod_cliente = $cliente ORDER BY nome_func";
$rel = pg_query($connect, $rela);
$rl = pg_fetch_all($rel);

for($q=0;$q<pg_num_rows($rel);$q++){
?>
			<tr>
				<td width="200" align="left" class="fontepreta12">&nbsp;<?php echo $rl[$q][nome_func]; ?></td>
				<td width="190" align="left" class="fontepreta12">&nbsp;<?php echo $rl[$q][nome_funcao]; ?></td>
				<td width="90" align="left" class="fontepreta12">&nbsp;<?php echo $rl[$q][data_admissao_func]; ?></td>
				<td width="80" align="left" class="fontepreta12">&nbsp;<?php echo $rl[$q][num_ctps_func]."/".$rl[$q][serie_ctps_func]; ?></td>
				<td width="90" align="left" class="fontepreta12">&nbsp;<?php echo $rl[$q][data_nasc_func]; ?></td>
				<td width="60" align="left" class="fontepreta12">&nbsp;<?php echo $rl[$q][cbo]; ?></td>
			</tr>
<?php } ?>
		</table>
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>	
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
<!---------------------RELATÓRIO ANUAL FINAL--------------->
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
		<table align="center" width="695" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center" class="fontepreta12"><h2>Relatório Anual <?php echo date("Y", strtotime($row[data_criacao]))." / ".(date("Y", strtotime($row[data_criacao]))+1); ?> </h2><br>&nbsp;</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12"><b>Coordenador(a): Dr&ordf; Maria de Lourdes Fernandes de Magalhães</b></td>
			</tr>
		</table><br>
		<table align="center" width="695" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td valign="top" width="150" align="left" class="fontepreta12"><b>Data: </b><?php echo $meses[date("n", strtotime($row[data_criacao]))]." de ".date("Y", strtotime($row[data_criacao])); ?></td>
				<td width="540" align="left" class="fontepreta12"><b>Assinatura: </b><img align="middle" src="../img/ass_medica2.png" width="210" height="100"></td>
			</tr>
		</table>
		<table align="center" width="695" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="100" align="left" class="fontepreta12">Função</td>
				<td width="250" align="left" class="fontepreta12">Natureza do Exame</td>
				<td width="85" align="left" class="fontepreta12">N&ordm; Anual de Exames Realizados</td>
				<td width="85" align="left" class="fontepreta12">N&ordm; de Resultados Anormais</td>
				<td width="85" align="left" class="fontepreta12">N&ordm; de Resul. Normais, N&ordm; Anual de Exames (%)</td>
				<td width="85" align="left" class="fontepreta12">N&ordm; de Exames Para o Ano Seguinte</td>
			</tr>
		<?php
		//BUSCA FUNÇÕES
		$tim = "SELECT distinct(nome_funcao), f.cod_funcao
				FROM funcionarios f, funcao fu, cliente_setor c
				WHERE f.cod_funcao = fu.cod_funcao
				and f.cod_cliente = c.cod_cliente
				and f.cod_setor = c.cod_setor
				AND f.cod_cliente = $cliente
				AND EXTRACT(year FROM data_criacao) = {$ano}";
		$result = pg_query($connect, $tim);
		$rr = pg_fetch_all($result);
		for($x=0;$x<pg_num_rows($result);$x++){
		
		//BUSCA OS EXAMES
		$exa = "SELECT distinct(fe.descricao)
						FROM funcionarios f, aso a, funcao_exame fe
						WHERE f.cod_funcao = fe.cod_exame
						AND f.cod_func = a.cod_func
						AND f.cod_cliente = $cliente
						AND f.cod_funcao = {$rr[$x][cod_funcao]}
						--AND substr(f.data_admissao_func, 7, 4) = {$ano}";
				$r_exa = pg_query($connect, $exa);
				$row_exa = pg_fetch_all($r_exa);
				
		if(pg_num_rows($r_exa)){
		?>
			<tr>
				<td width="100" align="left" class="fontepreta12"><?php echo $rr[$x][nome_funcao]; ?></td>
				<td width="250" align="left" class="fontepreta12">
				<?php
				for($w=0;$w<pg_num_rows($r_exa);$w++){
					echo $row_exa[$w][descricao]; 
					if($w<pg_num_rows($r_exa)-1) echo " + ";
				}
				echo "&nbsp;";
				?>
				</td>
				<td width="85" align="center" class="fontepreta12">
				<?php
				$fcn = "SELECT count(f.cod_func) as f
						FROM funcionarios f, aso a
						WHERE f.cod_setor = a.cod_setor
						AND f.cod_func = a.cod_func
						AND f.cod_cliente = $cliente
						AND f.cod_funcao = {$rr[$x][cod_funcao]}
						AND (a.aso_resultado = 'Apto' 
						OR a.aso_resultado = 'Apto à manipular alimentos'
						OR a.aso_resultado = 'Apto para trabalhar em altura' 
						OR a.aso_resultado = 'Apto para operar empilhadeira' 
						OR a.aso_resultado = 'Apto para trabalhar em espaço confinado' 
						OR a.aso_resultado = '__________')";
				$r_fcn = pg_query($connect, $fcn);
				$row_fcn = pg_fetch_all($r_fcn);
		
				for($q=0;$q<pg_num_rows($r_fcn);$q++){
					$normal = $row_fcn[$q][f];
					echo $normal; 
				}
				?>
				</td>
				<td width="85" align="center" class="fontepreta12">
				<?php
				$anm = "SELECT count(f.cod_func) as fi
						FROM funcionarios f, aso a
						WHERE f.cod_setor = a.cod_setor
						AND f.cod_func = a.cod_func
						AND f.cod_cliente = $cliente
						AND f.cod_funcao = {$rr[$x][cod_funcao]}
						AND (a.aso_resultado = 'Inapto' 
						OR a.aso_resultado = 'Apto com Restrição')";
				$r_anm = pg_query($connect, $anm);
				$row_anm = pg_fetch_all($r_anm);
		
				for($i=0;$i<pg_num_rows($r_anm);$i++){
					$anormal = $row_anm[$i][fi];
					echo $anormal; 
				}
				?>
				</td>
				<td width="85" align="center" class="fontepreta12">
				<?php
				$tt = $normal + $anormal;
				$tot = ($normal * 100)/$tt;
				echo zeros($tot)."%";
				?>
				</td>
				<td width="85" align="center" class="fontepreta12">
				<?php
				echo $tt;
				?></td>
			</tr>
			<?php
			}
		}
		?>
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
        </td> </tr>
</table>
</form>
</body>
</html>
