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
$meses = array(" ", "Janeiro", "Fevereiro", "Mar�o", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

//CONSULTA PARA BUSCAR AS INFORMA��ES DO CLIENTE
$apgre = "SELECT c.*, cn.*, cs.*
		FROM cliente c, cnae cn, cliente_setor cs
		WHERE c.cnae_id = cn.cnae_id
		AND c.cliente_id = cs.cod_cliente
		AND cs.cod_cliente = $cliente
		AND EXTRACT(year FROM cs.data_criacao) = {$ano}";
$res = pg_query($connect, $apgre);
$rr = pg_fetch_array($res);

/*************QUANTIDADE DE FUNCION�RIOS MASCULINOS************/
$masc = "SELECT sexo_func, cod_cliente FROM funcionarios
		WHERE cod_cliente = '$cliente'
		AND	sexo_func = 'Masculino'";
$result = pg_query($masc);
$nmasc = pg_num_rows($result);

/*************QUANTIDADE DE FUNCION�RIOS FEMININOS************/
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
	echo "<td width=100% align=left><b>Data da Vistoria T�cnica:</b></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td align=justify >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A vistoria ocorreu no dia ".date("d", strtotime($info[data_avaliacao]))." de ".$meses[date("n", strtotime($info[data_criacao]))]." de {$info[ano]}, no interior da empresa: <b> {$info[razao_social]}</b>. Devidamente classificada, setores administrativos bem como setores operacionais.</td>";
	echo "</tr>";
	echo "</table>";
	
	echo "<p>";
	
	echo "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	echo "<tr>";
echo "<td align=center ><b>Setor:</b> {$avl[$x][nome_setor]}</td>";
	echo "<td align=center ><b>N� de Colaboradores:</b>".str_pad($ttl[cod], 2, "0", 0)."</td>";
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
		<td><center><h1>AVALIA��O<p>PRELIMINAR<p>E<p>GERENCIAMENTO<p>DE<p>RISCOS<p>ERGON�MICOS</h1></center>
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
<!---------------------APROVA��O--------------->
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
			<td width="199" class="tabela"><B>ELABORA��O:</B><br>&nbsp;</td>
		</tr>
		<tr>
			<td width="199" class="tabela">SESMT Servi�os Especializados em Seguran�a e Monitoramentos de Atividades no Trabalho Ltda<br>
			Rua: Marechal Ant�nio de Souza, 92 � Jardim Am�rica � Rio de Janeiro � RJ<br>CNPJ: 04.722.248/0001-17<br>&nbsp;</td>
		</tr>
		<tr>
			<td width="199" class="tabela"><b>ELABORADOR:</b><br>&nbsp;</td>
		</tr>
		<tr>
			<td width="199" class="tabela"><?php echo $flis[nome]; ?><br>T�cnico(a) em Seguran�a do Trabalho<br>Reg. <?php echo $flis[registro]; ?><br>&nbsp;</td>
		</tr>
		<tr>
			<td width="199" class="tabela"><b>REVISOR:</b><br>&nbsp;</td>
		</tr>
		<tr>
			<td width="199" class="tabela"><?php echo $flist[nome]; ?><BR>T�cnico em Seguran�a do Trabalho<br>Reg. <?php echo $flist[registro]; ?><br>&nbsp;</td>
		</tr>
		<tr>
			<td width="199" class="tabela"><b>APROVA��O:</b><br>&nbsp;</td>
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
<!---------------------4� P�GINA--------------->
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
				<td align="left"><b>APRESENTA��O</b></td>
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
		echo"<td align=center>Ilumin�ncia</td>";
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
    echo "<div class='mediumTitle'><b>CRONOGRAMA E PLANO DE A��O DO CURSO BASE/ANO ".$info[ano]."</b></div>";
    echo "<BR>";
    echo "<p align='justify'>";
    echo "<b>Empresa:</b> ".$info[razao_social];
    echo "<BR>";
    echo "";

    echo "<table border=1 width=100% cellspacig=0 cellpadding=0>";
    echo "<tr>";
    echo "<td class='bgtitle' align=center width=365><b>Quadro de Planejamento e A��es</b></td>";
    echo "<td class='bgtitle' align=center width=365><b>Metas e Prioridades Ano ".(int)($info[ano])." � ".((int)($info[ano])+1)."</b></td>";
   echo "</tr>";
    echo "<tr>";
    echo "<td align=center width=365><b>Descri��o das Necessidades</b></td>";
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
	
	//Descri��o do Cursos
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
			
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A palavra Ergonomia � um neologismo criado a partir da uni�o dos termos gregos Ergon, que significa trabalho e Nomos, cujo significado refere-se a normas ou regras e leis. Ergonomia como fatores humanos � a disciplina cientifica que diz respeito ao discernimento do relacionamento entre homens e outros elementos de um sistema de gest�o em exerc�cio de sua profiss�o.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A profiss�o que implica teorias, princ�pios, informa��es, m�todos e dados para projetar, de modo a otimizar o bem estar do ser humano em uma jornada laborativa objetivando assim a efici�ncia plena do sistema. Utilizando-se de formas e maneiras mais simples e nesse complexo de a��es e informa��es temos a ergonomia como o estudo de adapta��o de uma jornada de trabalho e o ser humano.
				</td>
			</tr>
			<tr>
				<td align="left"><BR><b>OBJETIVO</b></td>
			</tr>
			<tr>
				<td align="justify" class="fontepreta12"><br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O objetivo do presente trabalho � o de realizar a avalia��o preliminar e o gerenciamento dos riscos ergon�micos das atividades desenvolvidas por cada um dos colaboradores em seus postos de trabalho da empresa: <b><?php echo $rr[razao_social]; ?></b> Situada no Endere�o: <b><?php echo $rr[endereco]; ?>, <?php echo $rr[num_end]; ?></b> Inscrita no CNPJ: <b><?php echo $rr[cnpj]; ?></b> em conformidade com as exig�ncias pertinentes buscando sempre expor de forma clara, objetiva e t�cnica os par�metros estabelecidos que permitam adapta��es das condi��es dos postos de trabalho �s caracter�sticas psico-fisiol�gicas dos trabalhadores de modo a proporcionar o m�ximo de conforto, seguran�a e desempenho.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O estudo inclui aspectos relacionados � ergonomia f�sica, cognitiva e organizacional dentre os quais est�o � adapta��o a superf�cies, apoios e alcances da interface m�quina versus ser humano; seja por motivos de posturas inadequadas, exerc�cio de tarefas sentado; semi-sentado; em p�; empurrando; puxando; praticando levantamentos; transportando ou no exerc�cio de descarga de materiais; estruturas arquitet�nicas; mobili�rios; maquin�rios e equipamentos. �s condi��es ambientais de ilumina��o, ru�dos, stress t�rmicos e umidade relativa do ar; aspectos cognitivos, carga mental � Psican�lise Ocupacional, psicol�gica, emocional e � pr�pria organiza��o do trabalho, cargo e a metodologia do trabalho.
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
<!---------------------5� P�GINA--------------->
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
				<h2>SUM�RIO</h2><p>
				<b>Empresa<p>Local de Trabalho<p>Fundamenta��o<p>Metodologia<p>Instrumentos Utilizados<p>Levantamento e An�lise<p></b>Identifica��o da An�lise<br>Descri��o F�sica e Historica<br>Descri��o do M�todo de Trabalho<br>Descri��o da Popula��o Funcional<br>An�lise Pr�-ativa de Riscos Ergon�micos<br>Considera��es<p><b>Conclus�o<p>Bibliografia</b>
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
<!---------------------6� P�GINA--------------->
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
				<h2>Descri��o da Empresa</h2><p>
				<b>Raz�o Social:</b> <?php echo $rr[razao_social]; ?><br>
				<b>Endere�o:</b> <?php echo $rr[endereco]; ?>, <?php echo $rr[num_end];?><br>
				<b>CEP:</b> <?php echo $rr[cep]; ?><br>
				<b>Bairro:</b> <?php echo $rr[bairro]; ?><br>
				<b>Munic�pio:</b> <?php echo $rr[municipio]; ?><br>
				<b>Estado:</b> <?php echo $rr[estado]; ?><br>
				<b>CNPJ:</b> <?php echo $rr[cnpj]; ?><br>
				<b>C.N.A.E.:</b> <?php echo $rr[cnae]; ?><br>
				<b>Grau de Risco:</b> <?php echo $rr[grau_de_risco]; ?><br>
				<b>Respons�vel Pelas Informa��es:</b> <?php echo $rr[nome_contato_dir]; ?><br>
				<b>Telefone:</b> <?php echo $rr[tel_contato_dir]; ?><br>
				<b>FAX:</b> <?php echo $rr[fax]; ?><br>
				<b>E-mail:</b> <?php echo $rr[email_contato_dir]; ?><p>
				<b>Escrit�rio Cont�bil:</b> <?php echo $rr[escritorio_contador]; ?><br>
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
<!---------------------7� P�GINA--------------->
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
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Os assentos utilizados nos postos de trabalho devem atender aos seguintes requisitos m�nimos de conforto:<br>
				a-	Altura ajust�vel � estatura do trabalhador e � natureza da fun��o exercida.<br>
				b-	Caracter�sticas de pouca ou nenhuma conforma��o na base do assento.<br>
				c-	Borda frontal arredondada.<br>
				d-	Encosto com forma levemente adaptada ao corpo para prote��o da regi�o lombar.<p>
				<b>ATIVIDADES OPERACIONAIS</b><p>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nos setores operacionais h� uma carga de movimentos repetitivos consider�veis e movimentos cont�nuos dos membros superiores e membros inferiores.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Destacamos o n�vel de aten��o que as tarefas necessitam para serem executadas com seguran�a.<p>
				<b>FUNDAMENTA��O</b><p>
				Fundamenta��o legal: Este trabalho baseia-se nas disposi��es da CLT � Consolida��es das Leis Trabalhistas, regulamenta��o do minist�rio do trabalho e do emprego e documentos abaixo descritos;<br>
				Cap�tulo V, t�tulo II da CLT em especial no art. 198 e 199<br>
				Lei 6.514 de 22 de Dezembro de 1977<br>
				Normas Regulamentadoras do Minist�rio do Trabalho e Emprego aprovadas pela Portaria n� 3.214/78, com suas altera��es posteriores;<br>
				NR � 17 Ergonomia.<p>
				<b>DOCUMENTOS COMPLEMENTARES</b><p>
				Portaria 3.751 de 23 de Novembro de 1990 � Revoga o Anexo IV � Ilumin�ncia da NR � 15 transferido para a NR � 17 (Ergonomia); ABNT NBR 10.152 � N�veis de ru�dos para conforto ac�stico; ABNT NBR 5.413 � Ilumin�ncia de interiores.<p>
				<b>FUNDAMENTA��O T�CNICA</b><p>
				Para caracteriza��o dos fatores de risco ambiental, foram utilizadas as metodologias de avalia��o ambiental da Fundacentro.<br>
				ABNT NBR 5.413 � Ilumin�ncia de interiores;<br>
				FUNDACENTRO NHT 09 R/E � 1986 � Norma para avalia��o da exposi��o ocupacional ao ru�do continuo ou intermitente.
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
<!---------------------7� P�GINA--------------->
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
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nas abordagens das avalia��es preliminares ergon�micas foram utilizadas v�rias ferramentas cient�ficas, observa��o dos postos de trabalho, check-list, planilha question�rio � ordem de servi�o e entrevista nos postos de trabalho junto aos funcion�rios. Objetivando assim implementar o trabalho na utiliza��o das duas t�cnicas, a saber, a t�cnica objetiva (direta) e a t�cnica subjetiva (indireta).<p>
				<b>T�CNICAS OBJETIVAS</b><p>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quanto �s t�cnicas objetivas, foram realizadas observa��es de campo, com o registro de imagens, avalia��o ambiental de stress t�rmico, ru�dos, vibra��es, medidas a incid�ncia de ilumin�ncia, altura de mobili�rios, coloriza��o arquitet�nica, permitindo uma abordagem de maneira global das atividades praticadas em cada posto de trabalho a partir da avalia��o ergon�mica, para identifica��o dos problemas, necessidades ou defini��es de demandas feitas com a participa��o direta (verbaliza��o) do efetivo populacional da empresa.<p>
				<b>T�CNICAS SUBJETIVAS</b><p>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As t�cnicas subjetivas (check-list, question�rio e entrevistas) permitem levantar as opini�es dos entrevistados para a melhor complementa��o do trabalho garantindo que a observa��o realizada aproxime-se da realidade efetiva. Permitindo que a pesquisa de todos os itens previamente levantados possam propor as concep��es de ambiente, carga fisiol�gica, carga mental e aspectos psicossociais. A caracteriza��o da exposi��o aos agentes ilumin�ncia, ru�do e stress t�rmico considerou a observa��o dos postos de trabalho como alvo das medi��es, ou seja, a utiliza��o desses equipamentos proporcionou a defini��o das condi��es ambientais de cada posto de trabalho.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As medi��es de n�veis de ilumin�ncia foram realizadas no posto de trabalho onde se realizam as tarefas de predomin�ncia visual, utilizando-se de lux�metro com fotoc�lula corrigida para a sensibilidade do olho humano e em fun��o do �ngulo de incid�ncia. Quando n�o se p�de definir o campo de trabalho, considerou-se um plano horizontal a 0,75 cm do piso para efetuar a medi��o, considerando-se a colora��o das paredes (arquitetura) a voltagem de cada lumin�ria.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quanto ao n�vel de press�o sonora, especificadamente, a medi��o foi realizada com o microfone junto � zona auditiva do trabalhador, altura do plano horizontal que cont�m o canal auditivo, a uma dist�ncia, aproximada, de 150 mm do ouvido e em raz�o das fontes de ru�dos, emitirem ru�dos cont�nuos estacion�rios (com varia��o de n�vel desprez�vel) o per�odo de observa��o foi de 5 minutos aproximadamente para cada ponto de medi��o.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Na avalia��o de stress t�rmico, consideramos alguns par�metros que influem na sobrecarga t�rmica a que est�o submetidos os trabalhadores (temperatura do ar e umidade relativa do ar; tipo de atividade e gasto energ�tico). O posicionamento do aparelho de medi��o foi o local onde permanece o trabalhador, � dist�ncia e altura da regi�o do corpo mais atingida.
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
<!---------------------7� P�GINA--------------->
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
				<b>Data de Calibra��o:</b> <?php echo date("d/m/Y", strtotime($db[data_criacao])); ?><p>
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
				<b>Data de Calibra��o:</b> <?php echo date("d/m/Y", strtotime($temp[data_criacao])); ?><p>
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
				<b>Data de Calibra��o:</b> <?php echo date("d/m/Y", strtotime($ilu[data])); ?><p>
				</td>
			</tr>

			<tr>
				<td align="justify" class="fontepreta12">
				<b>CONCLUS�O</b><p>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Num aspecto global, os postos de trabalho apresentam boas condi��es; n�o obstante com uma an�lise mais detalhada, foi poss�vel detectar diversas situa��es que exigem interven��es ergon�micas e melhorias sistem�ticas que, se bem gerenciadas, trar�o melhor n�vel de conforto, seguran�a, preven��o de doen�as ocupacionais e desempenho eficiente no dia a dia dos trabalhadores.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A principio, este � o objetivo deste documento, j� que haver� uma mudan�a significativa das condi��es de trabalho, em face de nova vis�o do ambiente que nos propomos a ofertar a esta administra��o.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O presente trabalho abordar� as tr�s �reas da ergonomia: ergonomia f�sica; cognitiva e organizacional; envolvendo diversos t�picos dos cincos itens que ser�o apresentados mais a frente.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Em virtude da n�o observa��o da adapta��o das instala��es este item n�o foi apreciado nos quesitos de concep��o e ambiente, num primeiro momento da ocupa��o.<p>
				
				<b>CONCEP��O</b><p>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Foram identificadas situa��es de riscos exigindo que a��es sejam implantadas e implementadas nos postos de trabalhos, tanto de OEM como de SMS, relacionados com incongru�ncia de posturas inadequadas, ferramentas impr�prias ou inseguras.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tais fatores de riscos, conforme caracterizados e classificados nas planilhas de an�lise pr�-ativa de riscos apresentam efeitos tanto humanos como organizacionais, podendo acarretar o desconforto f�sico, afastamentos e impactos no �ndice de absente�smo (pequenas perdas de produtividades) at� efeitos como sequelas e limita��es funcionais (distens�o muscular, lombalgias, tor��es articulares, DORT � Dist�rbios Osteomusculares Relacionados ao Trabalho), consequ�ncia � produtividade implicando em atrasos no campo previsto de produ��o ou em redu��o do trabalho planejado, custos em aten��o ao problema ou redu��o de m�o de obra e ainda complica��es com regula��es governamentais ou em n�o atendimento � legisla��o. Neste cen�rio a aten��o especial por parte da administra��o da empresa deve ser dada nas an�lises coletadas (resultado do levantamento t�cnico de campo) e relatadas neste trabalho.<br>

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

<!---------------------9� P�GINA--------------->
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
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Obedecendo aos crit�rios as instala��es el�tricas, mec�nicas, automa��o e qu�mica, vistos que estes envolvem atividades de maior esfor�o f�sico e exposi��o por parte dos trabalhadores.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Conforme recomendado nas an�lises pr�-ativa de risco, al�m das outras recomenda��es descritas neste trabalho deve-se considerar a implanta��o e implementa��o do Programa de Cinesioterapia Laboral, com atividades programadas para fortalecimento muscular dos membros mais exigidos em uma jornada de trabalho (membros superiores e membros inferiores) e ado��o de atividades aer�bicas para manuten��o do condicionamento f�sico e mental. Um programa bem elaborado e aplicado por profissional especializado, com o conhecimento pr�vio da situa��o de trabalho de cada setor da empresa � um instrumento eficaz para preven��o da DORT, contribuindo ainda para a integra��o dos trabalhadores da empresa, causando assim melhoria na disposi��o f�sica e rendimento da execu��o de tarefas �Produtividade� causando assim melhora na autoestima e satisfa��o profissional.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Outro fator a ser considerado em todos os setores � a postura e mobili�rios inadequados principalmente no trabalho sentado. A postura est�tica, sentado por longos per�odos com uso de computador, influi na ocorr�ncia de posturas durante uma jornada de trabalho, portanto torna-se necess�rio a orienta��o dos trabalhadores estimulada pela administra��o da empresa. Para a boa educa��o ergon�mica adotar uma postura correta e nas atividades e nos casos de trabalho sentado com uso de computadores promover pequenos per�odos de pausas para exerc�cios e relaxamento com objetivo de interromper a rotina e estimular as articula��es. Esses per�odos podem ser de dez (10) ou cinco (05) minutos antes de cada hora cheia.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;� importante que esses per�odos de pausa sejam formalizados para que, a simples orienta��o dos exerc�cios, n�o caiam no esquecimento em meio � rotina di�ria.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Os mobili�rios utilizados s�o adequados, com exce��o dos casos de cadeiras danificadas, j� relatados na planilha de an�lise pr�-ativa, e o uso de monitor sem regulagem de altura. Conforme estudos realizados por Grandjean, as dimens�es recomendadas para altura da tela (Ponto M�dio) a partir do piso, s�o de 78 cm a 106 cm. Embora as medidas realizadas estejam dentro da faixa recomendada, em v�rias mesas foram encontradas adapta��es improvisadas para eleva��o da altura dos monitores, indicados um desconto no uso dos mesmos. Isso ocorre devido �s varia��es de medidas antropom�tricas de cada pessoa, que determina as faixas de ajustes confort�veis no posto de trabalho. Sendo assim recomendamos a substitui��o destes monitores por outros que tenham regulagem de altura. Da mesma forma o uso de Notebook induz a inclina��o do pesco�o para baixo, j� que o equipamento � concebido em um conjunto de teclado-monitor, permitindo a regulagem da inclina��o da tela, mas n�o da altura. 
				Recomenda-se sua substitui��o por micros comuns ou o uso de adaptadores ergon�micos para os casos em que seja imprescind�vel o seu uso.<p>
				<b>AMBIENTE</b><p>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Foram identificados riscos de exposi��o ao ru�do, ao calor e ilumina��o deficiente na produ��o e em alguns postos de trabalho na �rea administrativa. Por�m, o par�metro t�cnico estabelecido na NR 17, para temperatura, ru�do e ilumin�ncia adequados, refere-se apenas as atividades que exijam solicita��o intelectual, apresentando apenas um aspecto de desconforto e n�o de risco, podendo interferir no trabalho, mas n�o sendo causa principal de uma procura ambiental ou afastamento, por exemplo. Sendo assim, no que diz respeito aos riscos � sa�de dos trabalhadores provenientes desses agentes, devem ser observadas as medidas de controle adequadas conforme o PPRA � Programa de Preven��o de Riscos Ambientais e do PCMSO � Programa de Controle M�dico de Sa�de Ocupacional na empresa.
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
<!---------------------10� P�GINA--------------->
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
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No que tange ao calor, <?php print $dadoscompl[temperatura];print $dadoscompl[temp_elevada]." ". $dadoscompl[ceu_aberto];?>. As medi��es foram realizadas <?php print $dadoscompl[p_medicao];?>, e as varia��es de temperatura e umidade relativa do ar apresentadas neste documento sofreram influ�ncia do clima, visto que as mudan�as clim�ticas das esta��es do ano e tamb�m, de um dia para o outro, alteram a intensidade do calor e sensa��o t�rmica no homem. Por�m, deve-se diferenciar desconforto t�rmico �Stress T�rmico� de sobrecarga t�rmica, uma vez que o primeiro � um conceito que, entre outros fatores, depende principalmente da sensibilidade das pessoas, podendo variar de pessoa para pessoa ou de uma regi�o para outra. A sobrecarga t�rmica, no entanto, � um problema para qualquer pessoa em qualquer regi�o, visto que a natureza humana � a mesma. Embora o par�metro t�rmico estabelecido na NR 17 refira-se as atividades que exijam solicita��o intelectual sabe-se que o calor excessiv				o � extremamente desconfort�vel para o corpo humano, portanto, recomenda-se, sempre que poss�vel, o uso de ventila��o for�ada nos ambientes quentes e a reposi��o de �gua e sais minerais durante a exposi��o.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recomenda-se aten��o quanto � orienta��o nos cuidados com a possibilidade de choque t�rmico, devido o deslocamento constante entre as �reas operacionais e setores climatizados da �rea administrativa, sobretudo no per�odo do ver�o, quando as diferen�as de temperaturas s�o acentuadas, podendo agravar sintomas de gripes; resfriados; infec��es de garganta e sistema respirat�rio. Deve-se fazer uma regulagem adequada dos condicionadores de ar, evitando o direcionamento do vento frio direto no corpo humano, o que pode acarretar um desconforto t�rmico por frio excessivo.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A umidade relativa do ar pode ficar baixa no per�odo de inverno, e os aparelhos de ar-condicionado tradicionais ir�o ressecar ainda mais os ambientes, portando recomenda-se o monitoramento da umidade relativa do ar neste per�odo, preferindo apenas ventilar o ambiente e manter as janelas abertas, o que auxilia tamb�m a troca do ar.<br>
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
<!---------------------11� P�GINA--------------->
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
//LOOP PARA COLOCAR O M�XIMO DE RESULTADO NA TELA
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
				<td align="left" class="fontepreta14"><b>9. DESCRI��O SETORIAL DAS INSTALA��ES DA EMPRESA</b><br>A empresa situa-se em endere�o j� citado, assim dividido:</td>
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
<!---------------------P�GINA DE SISTEMATIZA��O SETORIAL--------------->
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
				<td align="left" class="fontepreta14"><b>10. SISTEMATIZA��O SETORIAL</b><br>
				A fim de dinamizarmos o estudo sistem�tico NR7 (PCMSO) dividiremos a empresa por setores:</td>
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
						<td align=left class=fontepreta12><b>Din�mica:&nbsp;</b>".$r_resu[0][desc_setor]."</td>
						<td align=left class=fontepreta12><b>Riscos:</b>&nbsp;";
						for($y=0;$y<pg_num_rows($resu);$y++){
						    echo "<b>".$r_resu[$y][nome_tipo_risco]."-></b>&nbsp;".$r_resu[$y][nome_agente_risco].";&nbsp;";
						}
						echo "</td>
					</tr>
					<tr>
						<td colspan=2 align=left class=fontepreta10><b>Possibilidade de Doen�as Ocupacionais:&nbsp;</b>";
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
<!---------------------13� P�GINA--------------->
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
//LOOP PARA COLOCAR O M�XIMO DE RESULTADO NA TELA
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
				<td align="left" class="fontepreta14"><b>11. DADOS CADASTRAIS DOS FUNCION�RIOS e CRONOGRAMA DE EXAMES:</b><br>
				Independente da faixa et�ria, a coordena��o do PCMSO determina exames anuais personalizados, conforme tabela abaixo. O encaminhamento do funcion�rio para o peri�dico � de fundamental import�ncia para futura elabora��o do PPP, tendo como data base o per�odo de 12 meses entre a realiza��o dos exames.
				</td>
			</tr>
		</table><br>
		<table align="center" width="695" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="left" class="fontepreta12" width="250">&nbsp;NOME</td>
				<td align="left" class="fontepreta12" width="270">&nbsp;FUN��O</td>
				<td align="center" class="fontepreta12" width="80">ADMISS�O</td>
				<td align="center" class="fontepreta12" width="90">�LTIMO EXAME</td>
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
<!---------------------14� P�GINA--------------->
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
			$meses = array(" ", "Janeiro", "Fevereiro", "Mar�o", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
			?>
		</td>
	</tr>
	<tr>
	<td class="tabela" valign="top">
		<table align="center" width="698" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="left" class="fontepreta14"><b>12. CONSIDERA��ES FINAIS</b><br>&nbsp;</td>
			</tr>
			<tr>
				<td align="justify" class="fontepreta12">
				1� No caso de epidemias ou endemias de doen�as de controle previs�veis por vacina��o, o m�dico examinador, por ocasi�o dos Exames M�dicos Ocupacional, poder� solicitar a imuniza��o e/ ou o atestado de vacina��o.<p>
				2� Os casos de doen�as de notifica��o compuls�ria, verificados durante os Exames M�dicos Ocupacional, ser�o comunicados �s autoridades sanit�rias correspondentes e ao candidato/ empregado ou aos seus familiares.<p>
				3� O n�o comparecimento ao Exame M�dico Ocupacional acarretar� as seguintes medidas:<p>
				&bull; EMA -  elimina��o do processo admissional;<br>
				&bull; EMMF � retardamento da mudan�a at� a realiza��o do exame;<br>
				&bull; EMRT � o empregado s� poder� reassumir suas atividades ap�s se submeter a esta modalidade de exame;<br>
				&bull; EMD � o desligamento de empregado ficar� condicionado � realiza��o do exame dentro do prazo de 15 dias que antecedem o desligamento definitivo do empregado;<br>
				&bull; EMP �  san��es administrativas disciplinares, a crit�rio do empregador.<p>
				Rio de Janeiro, 
				<?PHP 
					$sql = "select data_criacao from cliente_setor where cod_cliente = $cliente";
					$res = pg_query($connect, $sql);
					$row = pg_fetch_array($res);
					echo date("d", strtotime($row[data_criacao]))." de ".$meses[date("n", strtotime($row[data_criacao]))]." de ".date("Y", strtotime($row[data_criacao]));
				?>
		<div id="grfg"></div><div id="div_position"><img src="../img/ass_medica.png" width="180" height="110"></div>	
		<b><hr>Dr�. Maria de Lourdes F. de Magalh�es</b><br>M�dica do Trabalho � Coordenadora do PCMSO<br>CRM 52.33471-0 Reg. MTE 13.320

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
<!---------------------15� P�GINA--------------->
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
				<td align="center"><h1>Programa de Controle M�dico de Sa�de Ocupacional<p>PCMSO � <?php if($rr[data_criacao]){ echo date("Y", strtotime($rr[data_criacao])); } ?> <p>EXAMES M�DICOS OCUPACIONAIS PROCEDIMENTOS</h1></td>
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
<!---------------------P�GINA ADMISSIONAL--------------->
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
//LOOP PARA COLOCAR O M�XIMO DE RESULTADO NA TELA
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
				<td colspan="5" align="center" class="fontepreta12"><h1>EXAME M�DICO ADMISSIONAL (EMA)</h1></td>
			</tr>
			<tr>
				<td width="210" align="left" class="fontepreta12">Candidatos a:</td>
				<td width="120" align="left" class="fontepreta12">Descri��o da Atividade</td>
				<td width="150" align="left" class="fontepreta12">Agente de Risco</td>
				<td width="100" align="left" class="fontepreta12">Rotina<br><center>AC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EC</center></td>
				<td width="110" align="left" class="fontepreta12">Observa��o</td>
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
				<td width="490" align="center" class="fontepreta12">Descri��o</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">AC = Avalia��o Cl�nica</td>
				<td align="left" class="fontepreta12">An�lise ocupacional, exame f�sico e mental.</td>
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
				<td colspan="2" align="left" class="fontepreta12"><b>PERIODICIDADE:</b> Os procedimentos dever�o ser adotados at� 5 (cinco) dias antes da admiss�o</td>
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
<!---------------------P�GINA PERI�DICO--------------->
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
//LOOP PARA COLOCAR O M�XIMO DE RESULTADO NA TELA
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
				<td colspan="5" align="center" class="fontepreta12"><h1>EXAME M�DICO PERI�DICO (EMP)</h1></td>
			</tr>
			<tr>
				<td width="210" align="left" class="fontepreta12">Candidatos a:</td>
				<td width="120" align="left" class="fontepreta12">Descri��o da Atividade</td>
				<td width="150" align="left" class="fontepreta12">Agente de Risco</td>
				<td width="100" align="left" class="fontepreta12">Rotina<br><center>AC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EC</center></td>
				<td width="110" align="left" class="fontepreta12">Observa��o</td>
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
				<td width="490" align="center" class="fontepreta12">Descri��o</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">AC = Avalia��o Cl�nica</td>
				<td align="left" class="fontepreta12">An�lise ocupacional, exame f�sico e mental.</td>
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
				<td colspan="2" align="left" class="fontepreta12"><b>PERIODICIDADE:</b> Os procedimentos dever�o ser adotados at� 5 (cinco) dias antes da admiss�o</td>
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
<!---------------------P�GINA DEMISSIONAL--------------->
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
				<td colspan="5" align="center" class="fontepreta12"><h1>EXAME M�DICO DEMISSIONAL (EMD)</h1></td>
			</tr>
			<tr>
				<td width="210" align="left" class="fontepreta12">Candidatos a:</td>
				<td width="120" align="left" class="fontepreta12">Descri��o da Atividade</td>
				<td width="150" align="left" class="fontepreta12">Agente de Risco</td>
				<td width="100" align="left" class="fontepreta12">Rotina<br><center>AC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EC</center></td>
				<td width="110" align="left" class="fontepreta12">Observa��o</td>
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
				<td width="490" align="center" class="fontepreta12">Descri��o</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">AC = Avalia��o Cl�nica</td>
				<td align="left" class="fontepreta12">An�lise ocupacional, exame f�sico e mental.</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">EC = Exames Complementares</td>
				<td align="left" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" align="left" class="fontepreta12"><b>PERIODICIDADE:</b> Os procedimentos dever�o ser adotados at� 10 (cinco) dias ap�s a demiss�o.</td>
			</tr>
		</table><p>
		<table align="center" width="695" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td colspan="5" align="center" class="fontepreta12"><h1>EXAME M�DICO RETORNO DE TRABALHO (EMRT)</h1></td>
			</tr>
			<tr>
				<td align="justify" class="fontepreta12">Dever�o ser realizadas avalia��es cl�nicas e exames complementares, se necess�rio, para esclarecimento de diagn�stico, no primeiro dia da volta ao trabalho, de todos trabalhadores ausentes no per�odo igual ou superior a 30 (trinta) dias por motivo de doen�a ou acidente de natureza ocupacional ou n�o e parto.</td>
			</tr>
		</table><p>
		<table align="center" width="695" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td colspan="5" align="center" class="fontepreta12"><h1>EXAME M�DICO DE MUDAN�A DE FUN��O (EMMF)</h1></td>
			</tr>
			<tr>
				<td align="justify" class="fontepreta12">Dever� ser realizado em at� 5 (cinco) dias da mudan�a, desde que as altera��es na atividade no posto de trabalho ou setor impliquem na exposi��o do trabalhador a riscos diferentes daqueles a que estava exposto.</td>
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
<!---------------------P�GINA REALIZA��O--------------->
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
				<td align="center" class="fontepreta12"><h1>PROGRAMA DE CONTROLE M�DICO DE SA�DE OCUPACIONAL</h1><br><b>PCMSO</b><hr></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">
				<i>Realiza��o:</i><br>
				Rio de Janeiro, 
				<?PHP 
					$sql = "select data_criacao from cliente_setor where cod_cliente = $cliente AND EXTRACT(year FROM data_criacao) = {$ano}";
					$res = pg_query($connect, $sql);
					$row = pg_fetch_array($res);
					echo date("d", strtotime($row[data_criacao]))." de ".$meses[date("n", strtotime($row[data_criacao]))]." de ".date("Y", strtotime($row[data_criacao]));
				?><p>
				<i>Per�odo:</i><br>
				<?php echo $meses[date("n", strtotime($row[data_criacao]))]." / ".date("Y", strtotime($row[data_criacao]))." � ".$meses[date("n", strtotime($row[data_criacao]))-1]." / ".(date("Y", strtotime($row[data_criacao]))+1); ?><p>
				<i>Elabora��o:</i><br>
				SESMT � SERVI�OS ESPECIALIZADOS DE SEGURAN�A E MONITORAMENTO DE ATIVIDADE NO TRABALHO LTDA.<br>RUA MARECHAL ANT�NIO DE SOUZA, 92 � JARDIM AM�RICA.<br>CNPJ 04.722.248/0001-17<p>
				<img align="middle" src="../img/assin_medica0.png" width="210" height="85"><br>Dr�. Maria de Lourdes F. de Magalh�es<br>M�dica do Trabalho<br>Coordenadora do PCMSO<br>CRM /RJ � 52.33.471-0 - MTE 13320<p>
				<i>Fundamenta��o Legal:</i><br>
				Constitui��o federal, cap�tulo II (Dos Direitos Sociais), artigo 6� e 7�, incisos XXII, XXIII, XXVIII E XXXIII;<br>Consolida��o das leis do trabalho � CLT, Cap�tulo V, artigos 168 e 1669; Lei 6.514, de 22 de dezembro de 1977;<br>Portaria do MTE n� 24, de 29/12/94, aprova o novo texto da NR-7.<p>
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
<!---------------------CAPA REALIZA��O--------------->
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
				<td align="center"><h1><b>PROGRAMA DE CONTROLE M�DICO DE SA�DE OCUPACIONAL<p>
				PCMSO - <?php echo date("Y", strtotime($row[data_criacao]))." / ".(date("Y", strtotime($row[data_criacao]))+1); ?><p>
				ANEXOS; CONSIDERA��ES GERAIS; INFORMA��ES COMPLEMENTARES; PLANEJAMENTO ANUAL E RELA��O DE EMPREGADOS<p>
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
				Para cada exame realizado dever� ser emitido um atestado de sa�de ocupacional em tr�s vias, devendo a primeira via ficar arquivada na empresa para controle e eventual apresenta��o � fiscaliza��o, a segunda dever� ser entregue aos funcion�rios, o qual dever� protocolar, a primeira e terceira via com o m�dico coordenador para seu controle.<p>
				Todo o funcion�rio dever� possuir um prontu�rio cl�nico individual que dever� ficar sob responsabilidade do coordenador durante um per�odo m�nimo de 20 anos ap�s o desligamento do funcion�rio. No prontu�rio dever� constar todo o dado obtido nos exames m�dicos, avalia��es cl�nicas e exames complementares, bem como as conclus�es e eventuais medidas aplicadas: em caso de substitui��o do coordenador os arquivos dever�o ser transferidos para seu sucessor; o coordenador dever� emitir relat�rio anual dos objetivos alcan�ados, que dever� ser anexado ao final do ano vigente do per�odo referido no PCMSO.<p>
				Todos os estabelecimentos comerciais e ou institucionais, devem possuir um kit de primeiros socorros, composto, por exemplo, dos seguintes itens por setor ou fun��o:<p>
				�gua oxigenada; �lcool 70%; Algod�o em bolinha; Atadura; Cotonete; Curativo adesivo (band-aid); Esparadrapo; Ficha de controle de retirada; Gaze esterelizada; Luva descart�vel; Pin�a; Rela��o de material e quantidade contida no arm�rio; Reparil gel; Repelente; Solu��o antiss�ptica; Soro fisiol�gico; Term�metro; Vaselina l�quida ou Dersani.<p>
				O PCMSO poder� sofrer altera��es a qualquer momento, em algumas partes ou at� mesmo no seu todo, quando o m�dico detectar mudan�as nos riscos ocupacionais decorrentes de altera��es nos processos de trabalho, novas descobertas da ci�ncia m�dica em rela��o a efeitos de riscos existentes, mudan�a de crit�rios e interpreta��o de exames ou ainda a reavalia��o do reconhecimento dos riscos por compet�ncia da legisla��o NR.<p>
				O PCMSO dever� ter car�ter de preven��o, rastreamento e diagn�stico precoce dos agravos � sa�de relacionados ao trabalho, inclusive de natureza sub-cl�nica, al�m da constata��o da exist�ncia de casos de doen�as profissionais ou danos irrevers�veis � sa�de dos trabalhadores. Em face ao despacho de 1� de outubro de 96 da Secretaria de Seguran�a e Sa�de do Trabalho.<p>
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
				<b><h2>INFORMA��ES COMPLEMENTARES</h2></b><p>
				<b><h3>RECOMENDA��ES � EMPRESA</h3></b><p>
				Este cap�tulo tem como objetivo principal orientar a administra��o desta empresa como se pode minimizar os problemas decorrentes de incid�ncia e imper�cia no �mbito da empresa, ele visa trazer uma oportunidade com um custo baixo, e n�o s� orientar os colaboradores de sua empresa, mas, salvar e guardar a qualidade dos produtos e servi�os prestados aos seus clientes sem contar o bom nome da empresa que deve ser sempre protegido de esc�ndalos e de investidas das fiscaliza��es.<p>
				Recomenda-se que todos os colaboradores devam receber orienta��es sobre seguran�a do trabalho e preven��o de acidentes, objetivando cumprir com a NR 5.6.4 lei 6.514/77 que diz n�o haver obrigatoriedade da CIPA institu�da atrav�s do voto por falta de contingente, dever� ter um colaborador treinado, funcionando como um multiplicador aos demais companheiros.<p>
				Recomenda-se que todos os colaboradores devam receber orienta��es sobre alcoolismo, objetivando desmotivar o uso de tal subst�ncia o que acarretaria em poss�veis danos a sa�de e na produtividade da empresa.<p>
				Recomenda-se que todos os colaboradores devam receber orienta��es sobre tabagismo, objetivando desmotivar o uso de tal subst�ncia o que acarretaria em poss�veis danos a sa�de do fumante, dos que os rodeiam e na produtividade da empresa, podendo ainda provocar princ�pios de inc�ndios.<p>
				Recomenda-se que todos os colaboradores devam receber orienta��es sobre doen�as sexualmente transmiss�veis (DST), doen�as ostenculares relacionadas ao trabalho (DORT), objetivando a conscientiza��o e preven��o das mesmas.<p>
				Recomenda-se que todos os colaboradores devam receber orienta��es sobre o uso dos equipamentos de preven��o individual (EPI), objetivando a conscientiza��o e preven��o da sa�de e integridade f�sica dos colaboradores e isen��o de a��es jur�dicas.
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
<!---------------------TEXTO SOBRE RISCOS BIOL�GICOS--------------->
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
				<b><h3>RECOMENDA��ES DE RISCOS BIOL�GICOS CONSIDERADOS LEVES PARA MONITORAMENTO DO PCMSO</h3></b><p>
				Cobrir com capas pl�sticas os teclados dos micros computadores ou virar as teclas para baixo no final de cada expediente, proporcionando assim que as particulas de poeiras suspensas no ambiente n�o sedimente nos mesmos.<p>
				<b>Possiveis Sintomas:</b> Dor de cabe�a, problemas al�rgicos e respirat�rios.<p>
				Subistituir vasos de plantas naturais por artificiais em ambientes refrigerados mecanicamente �Ar Condicionado�.<p>
				<b>Possiveis Sintomas:</b> Problemas Al�rgicos e dermatol�gicos, gerado dos excrementos de anel�deos que em contato com ar refrigerado e respirado pelo ser humano em ambiente enclausurado.<p>
				<b><h3>CAMPANHA DE VACINA��O</h3></b><p>
				Recomenda-se Divulgar, insentivar e promover a pol�tica de vacina��o prevencionista como:<p>
				<b>Antigripal</b> � Recomendada para todas as idades e sendo administrada anualmente, pr�ximo aos meses de inverno, preferencialmente no m�s de Abril.<p>
				<b>Antitet�nica</b> � Recomendada a tomar as 03 doses e depois a cada 10 anos.<p>
				<b>Hepatite</b> � Recomendada na fase adulta a tomar as 03 doses sendo que a 2� depois com 30 dias e a 3� dose com 180 dias.<p>
				<b>Vacina contra Rub�ola</b> - Dever�o ser vacinadas nas campanhas realizadas pela Secretaria de Estado da Sa�de: com aplica��o da vacina dupla viral (sarampo e rub�ola) em homens e mulheres de 20 a 39 anos de idade mesmo aquelas que j� tomaram a vacina anteriormente ou que referem j� ter tido a doen�a e pessoas com idade at� 19 anos a tr�plice viral (sarampo, caxumba e rub�ola).
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
				<b><h3>RECOMENDA��ES DE CONTROLES EPIDEMIOLOGIA</h3></b><p>
				<b>MOSQUITO DA DENGUE (AEDES AEGYPT):</b> A �nica maneira de evitar a dengue ( Aedes Aegypt) � n�o deixar o mosquito nascer. Combater a larva � mais f�cil que combater o mosquito adulto.<p>
				� a� que voc� pode ajudar! Lembre-se:<p>
				&bull; Designar um grupo de trabalho em sua Unidade/�rg�o com a participa��o da Cipa, sob a Coordena��o do ATU/ATD;<br>
				&bull; Eliminar os criadouros internos como: vasos, pratos de xaxim, enfeites e todo tipo de situa��o que possa acumular �gua limpa;<br>
				&bull; Providenciar a limpeza de calhas, lajes, caixas d'�gua juntamente com o apoio do Estec;<br>
				&bull; Remover entulhos provenientes de restos de constru��o, sucata de descarte e lixos em geral;<br>
				&bull; Fiscalizar o cumprimento das medidas adotadas;<br>
				&bull; Divulgar aos funcion�rios e convenc�-los que essa proibi��o � para o bem comum.<p>
				<b>GRIPE H1N1(Influenza A)</b><p>
				Considerando de que o v�rus da gripe H1N1 est� confirmado a multiplica��o e sua plorifera��o, a melhor forma de combater a doen�a � a preven��o.<br>
				Lista com alguns h�bitos que ser� muito �til manter, s�o recomenda��es do Centro de controle e preven��o de doen�as dos Estados Unidos.<p>
				1. Evite contato direto com pessoas doentes;<br>
				2. Cubra seu nariz e boca se por a caso for tossir ou espirrar;<br>
				3. Evite ao m�ximo tocar no nariz, boca e olhos, se for mesmo necess�rio lave as m�os antes;<br>
				4. Se voc� ficar doente, procure ficar em casa e restringir o contato com outras pessoas, para evitar o contagio;<br>
				5. Lave as m�os sempre com �gua e sab�o, �lcool tamb�m � �timo para higienizar as m�os.<p>
				Fique atento, pois  os sintomas da gripe H1N1 s�o muito parecidos com  o da gripe comum, voc� pode ter: febre, letargia, falta de apetite e tosse.<br>
				Em algumas pessoas esta gripe pode provocar: coriza, garganta seca, n�usea, v�mito e diarr�ia.<br>
				Se voc� ou algum familiar tiver com estes sintomas procure um m�dico.
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
				<h2><b>PLANEJAMENTO ANUAL DE: <?php echo date("Y", strtotime($row[data_criacao]))." � ".(date("Y", strtotime($row[data_criacao]))+1); ?></b></h2>
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
				<td width="90" align="center" class="fontepreta12">Elabora��o do PCMSO</td>
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
				<td width="90" align="center" class="fontepreta12">Realiza��o dos Exames Peri�dicos</td>
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
				<td width="90" align="center" class="fontepreta12">Avalia��o Global da Efic�cia do Programa</td>
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
				<td width="90" align="center" class="fontepreta12">Elabora��o do Relat�rio Anual</td>
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
				<td width="90" align="center" class="fontepreta12">Renova��o do Programa</td>
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
				Em Execu��o no Ano de <?php echo date("Y", strtotime($row[data_criacao]))." / ".(date("Y", strtotime($row[data_criacao]))+1); ?> X<p>
				Em Execu��o no Ano de <?php echo date("Y", strtotime($row[data_criacao]))+1; ?> X X<p>
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
<!---------------------RELA��O DE FUNCION�RIOS--------------->
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
				<td align="center" class="fontepreta12"><h2>Rela��o de Funcion�rios</h2></td>
			</tr>
		</table><br>
		<table align="center" width="695" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="200" align="center" bgcolor="#999999" class="fontepreta12bold">Nome</td>
				<td width="190" align="center" bgcolor="#999999" class="fontepreta12bold">Fun��o</td>
				<td width="80" align="center" bgcolor="#999999" class="fontepreta12bold">Admiss�o</td>
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
<!---------------------RELAT�RIO ANUAL FINAL--------------->
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
				<td align="center" class="fontepreta12"><h2>Relat�rio Anual <?php echo date("Y", strtotime($row[data_criacao]))." / ".(date("Y", strtotime($row[data_criacao]))+1); ?> </h2><br>&nbsp;</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12"><b>Coordenador(a): Dr&ordf; Maria de Lourdes Fernandes de Magalh�es</b></td>
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
				<td width="100" align="left" class="fontepreta12">Fun��o</td>
				<td width="250" align="left" class="fontepreta12">Natureza do Exame</td>
				<td width="85" align="left" class="fontepreta12">N&ordm; Anual de Exames Realizados</td>
				<td width="85" align="left" class="fontepreta12">N&ordm; de Resultados Anormais</td>
				<td width="85" align="left" class="fontepreta12">N&ordm; de Resul. Normais, N&ordm; Anual de Exames (%)</td>
				<td width="85" align="left" class="fontepreta12">N&ordm; de Exames Para o Ano Seguinte</td>
			</tr>
		<?php
		//BUSCA FUN��ES
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
						OR a.aso_resultado = 'Apto � manipular alimentos'
						OR a.aso_resultado = 'Apto para trabalhar em altura' 
						OR a.aso_resultado = 'Apto para operar empilhadeira' 
						OR a.aso_resultado = 'Apto para trabalhar em espa�o confinado' 
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
						OR a.aso_resultado = 'Apto com Restri��o')";
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
