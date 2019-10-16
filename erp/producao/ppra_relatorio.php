<?php
//include "../sessao.php";
include "../config/connect.php";
include "ppra_codigo.php";

$height = 1050;
$hei = 570;

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
<form name="frm_ppra_relatorio" action="ppra_relatorio.php" method="post">
<!---------------------1ª PÁGINA--------------->
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
	<div id="div_position" style="position:relative;left:-40px;"><img src="../img/uno_top.jpg" width="154" height="219"></div>
		<table align="center" width="500" height="<?php echo $hei; ?>" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
		<td align="center"><p><h1><b>Programa<p>e<p>Prevenção<p>de<p>Riscos<p>Ambientais</b></h1><p><p>
			<table align="center" width="400" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
			<td align="left"><font class="fontepreta12">
				<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LEI 6.514 Dez / 77<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PORTARIA 3.214 Jul / 78<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NR 9 - MTE</b></font>
				<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
			</td>
			</tr>
			</table>
		<p><br><p><br><p><br><b>ANO <?php if($row[data_criacao]){ echo date("Y", strtotime($row[data_criacao])); } ?></b>
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
<!---------------------2ª PÁGINA--------------->
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
		<p align="left">
		<b>INTRODUÇÃO</b><p align="justify">
		&nbsp;&nbsp;&nbsp;O Programa de Prevenção de Riscos Ambientais – PPRA da <b><?php echo $row[razao_social]; ?></b> em conjunto com o Programa de Controle Médico de Saúde Ocupacional (PCMSO) tem como objetivo assegurar a preservação da saúde e da integridade física dos empregados, através da antecipação, do reconhecimento, da avaliação e conseqüente controle da ocorrência de riscos ambientais existentes ou que venham a existir no ambiente de trabalho.<br>
		&nbsp;&nbsp;&nbsp;Esse documento estabelece os procedimentos mínimos, e as diretrizes gerais a serem observados na execução do PPRA, exigindo definições e compromissos para a eliminação ou minimização dos riscos ambientais, devendo estar articulados com o disposto nas demais. Normas Regulamentadora constantes da Portaria nº 3.214 do Ministério do Trabalho e Emprego, de 08/06/1978, em especial com o Programa de Controle Médico de Saúde Ocupacional – PCMSO, previsto na NR-7.<p>
		
		<b>2 - POLÍTICA</b><p align="justify">
		&nbsp;&nbsp;&nbsp;A preservação da saúde deve abranger a prevenção de acidentes e de doenças profissionais, bem como de doenças transmissíveis e outras, baseando-se em estudos do achados dos Exames Médicos Ocupacionais e dos riscos envolvidos com a exposição a riscos ocupacionais, conforme indicados pelo Programa de Prevenção de Riscos Ambientais – PPRA, e propondo medidas profiláticas e /ou corretivas.<br>
		&nbsp;&nbsp;&nbsp;As medidas para a preservação da saúde devem buscar a adaptação das condições de trabalho às características “biopsicossocias” dos empregados, de modo a proporcionar o máximo de conforto, segurança e desempenho.<p>
		
		<b>3 - RESPONSABILIDADES</b><p align="justify">
		&nbsp;&nbsp;&nbsp;I – Responsabilidade técnica pela elaboração do Programa e assessoramentos técnicos necessários: SESMT;<br>
		&nbsp;&nbsp;&nbsp;II – Responsabilidade pela garantia do cumprimento das ações necessárias previstas no Programa: Diretoria da Empresa <b><?php echo $row[razao_social]; ?></b>;<br>
		&nbsp;&nbsp;&nbsp;III – Responsabilidade pelo fiel cumprimento, em nível de execução, das recomendações de Saúde Ocupacional propostas no Programa: Os empregados ou trabalhadores envolvidos.<p>
		
		<b>4 - DEFINIÇÃO / CONCEITOS BÁSICOS</b><p align="justify">
		&nbsp;&nbsp;&nbsp;<b>RISCOS AMBIENTAIS:</b> Consideram-se riscos ambientais os agentes físicos, químicos, biológicos, existentes no ambiente de trabalho que, em função de sua natureza, concentração, intensidade, tempo de exposição, organização e processo de trabalho, são capazes de causar danos à saúde e à integridade física do trabalhador.
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
<!---------------------3ª PÁGINA--------------->
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
		<table align="center" width="699" height="<?php echo $hei; ?>" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td width="250" class="tabela">Número de Contrato:</td>
			<td class="tabela"><?php echo $row[ano_contrato]; ?>/<?php echo $row[cliente_id]; ?></td>
		</tr>
		<tr>
			<td class="tabela">Número do Programa:</td>
			<td class="tabela">
			<?php 
			$dt = explode("/", $row[data_avaliacao]);
			echo zeros($row[cod_ppra])."/".date("y", strtotime($dt[2]."/".$dt[1]."/".$dt[0])); 
			?></td>
		</tr>
		<tr>
			<td class="tabela">Razão Social:</td>
			<td class="tabela"><?php echo $row[razao_social]; ?></td>
		</tr>
		<tr>
			<td class="tabela">Endereço:</td>
			<td class="tabela"><?php echo $row[endereco]; ?>,&nbsp;<?php echo $row[num_end]; ?></td>
		</tr>
		<tr>
			<td class="tabela">Bairro:</td>
			<td class="tabela"><?php echo $row[bairro]; ?></td>
		</tr>
		<tr>
			<td class="tabela">Cidade:</td>
			<td class="tabela"><?php echo $row[municipio]; ?></td>
		</tr>
		<tr>
			<td class="tabela">CEP:</td>
			<td class="tabela"><?php echo $row[cep]; ?></td>
		</tr>
		<tr>
			<td class="tabela">Telefone:</td>
			<td class="tabela"><?php echo $row[telefone]; ?></td>
		</tr>
		<tr>
			<td class="tabela">FAX:</td>
			<td class="tabela"><?php echo $row[fax]; ?></td>
		</tr>
		<tr>
			<td class="tabela">CNPJ / CEI:</td>
			<td class="tabela"><?php echo $row[cnpj]; ?></td>
		</tr>
		<tr>
			<td class="tabela">Número de Colaboradores:</td>
			<td class="tabela"><?php echo coloca_zeros($sm); ?></td>
		</tr>
		<tr>
			<td class="tabela">Nº de Efetivo no Setor Administrativo:</td>
			<td class="tabela"><?php echo coloca_zeros($nadm); ?></td>
		</tr>
		<tr>
			<td class="tabela">Nº de Efetivo no Setor Operacional:</td>
			<td class="tabela"><?php echo coloca_zeros($nope); ?></td>
		</tr>
		<tr>
			<td class="tabela">Jornada de Trabalho:</td>
			<td class="tabela"><?php echo $row[jornada]; ?></td>
		</tr>
		<tr>
			<td class="tabela">CNAE:</td>
			<td class="tabela"><?php echo $row[cnae]; ?></td>
		</tr>
		<tr>
			<td class="tabela">Ramo de Atividade:</td>
			<td class="tabela"><?php echo $row[descricao_atividade]; ?></td>
		</tr>
		<tr>
			<td class="tabela">Grau de Risco:</td>
			<td class="tabela"><?php echo coloca_zeros($row[grau_de_risco]); ?></td>
		</tr>
		<tr>
			<td class="tabela">Escritório de Contabilidade:</td>
			<td class="tabela"><?php echo $row[escritorio_contador]; ?></td>
		</tr>
		<tr>
			<td class="tabela">Contador:</td>
			<td class="tabela"><?php echo $row[nome_contador]; ?></td>
		</tr>
		<tr>
			<td class="tabela">Telefone Contador:</td>
			<td class="tabela"><?php echo $row[tel_contador]; ?></td>
		</tr>
		<tr>
			<td class="tabela">Área Total(Aproximadamente):</td>
			<td class="tabela"><?php echo $row[comprimento]; ?></td>
		</tr>
		<tr>
			<td class="tabela">Área Construída:</td>
			<td class="tabela"><?php echo $row[frente]; ?></td>
		</tr>
		<tr>
			<td class="tabela">Pé Direito da Área Construída:</td>
			<td class="tabela"><?php echo $row[altura]; ?></td>
		</tr>
	</table>
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
		<table align="center" width="699" height="<?php echo $hei; ?>" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="justify" class="fontepreta12">
				<b>AGENTES FÍSICOS</b><p align="justify">
				&nbsp;&nbsp;&nbsp;As diversas formas de energia a que possam estar expostos os trabalhadores, tais como: Ruído, Vibrações, Pressões anormais, Temperaturas extremas, Radiações ionizantes e Não ionizantes, Frio, Calor e Umidade, que podem ocasionar alterações no organismo humano.<p>

				<b>AGENTES QUÍMICOS</b><p align="justify">
				&nbsp;&nbsp;&nbsp;As substâncias, compostas ou produtos que possam penetrar no organismo pelas vias respiratória, cutânea e digestiva, tais como Poeira, Névoas, Neblinas, Gases, Vapores e Solventes em geral, podendo ocasionar efeitos nocivos à saúde.<p>	

				<b>AGENTES BIOLÓGICOS</b><p align="justify">
				&nbsp;&nbsp;&nbsp;Aqueles que compreendem diversos microorganismos patogênicos, tais como: Vírus, Bactérias, Protozoários, Fungos, Parasitas e Bacilos, presentes em determinadas atividades profissionais relacionadas com exposição ocupacional aos microorganismos patológicos.<p>
				
				<b>NÍVEL DE AÇÃO</b><p align="justify">
				&nbsp;&nbsp;&nbsp;Valor acima do qual devem ser iniciadas as ações preventivas, de forma a minimizar a probabilidade de que as exposições a agentes ambientais ultrapassem os limites de tolerância (LT).<p>
				
				<b>5 - PLANEJAMENTO DAS ATIVIDADES</b><p align="justify">
				&nbsp;&nbsp;&nbsp;Na implantação do PPRA é necessário realizar um planejamento, com elaboração de cronogramas, contemplando todas as atividades necessárias ao desenvolvimento do programa, e outro específico para o monitoramento dos riscos, contendo, no mínimo, a seguinte estrutura: Característica de Construção das Instalações a serem avaliados; Tipos de riscos a serem monitorados; Estabelecimento de prioridades para cada riscos e responsabilidade pela execução do PPRA.<p>
				
				<b>6 - ESTRATÉGIA</b><p align="justify">
				&nbsp;&nbsp;&nbsp;Eliminar todo risco para a saúde dos empregados, bem como promover a melhoria da qualidade de vida dos mesmos.<br>
				&nbsp;&nbsp;&nbsp;Os riscos relativos à saúde e à segurança dos empregados devem ser analisados e controlados desde a elaboração de projeto até a operação de equipamentos, instalações e processo de trabalho.<p>
				
				<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
		<table align="center" width="699" height="<?php echo $hei; ?>" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="justify" class="fontepreta12">
				<b>7 - METODOLOGIA</b><p align="justify">
				&nbsp;&nbsp;&nbsp;Consiste na realização de monitoramentos periódicos das instalações e postos de trabalho, bem como de estudos preliminares e de análises de projetos de engenharia, nas fases de antecipação e reconhecimento de riscos, sempre que ocorrer construção, ampliação, ocupação e reforma no estabelecimento, observando-se as características da edificação, equipamentos a serem instalados, riscos prováveis, possíveis tipos e espécies de acidentes e medidas preventivas a serem adotadas.<br>
				&nbsp;&nbsp;&nbsp;Havendo constatação de riscos à saúde, se ficar caracterizado o nexo causal entre os  danos observados na saúde dos trabalhadores e a situação de trabalho a que eles ficam expostos, devem ser adotadas as medidas necessárias e suficientes para a eliminação, minimização ou o controle dos riscos.<p>	

				<b>8 - FORMA DE REGISTRO DOS DADOS</b><p align="justify">
				&nbsp;&nbsp;&nbsp;Os dados obtidos serão registrados e arquivados em formulários específicos. Estes documentos deverão ficar arquivados, em pasta única, no setor administrativo responsável por recursos humanos da empresa. O reconhecimento dos riscos, que consiste na avaliação ocupacional quantitativa e qualitativa das instalações e áreas da empresa, de forma sistemática e repetitiva, deverá ser registrado no formulário: Ficha de Reconhecimento da Qualificação dos Riscos e Quantificação dos Riscos, contendo os seguintes itens: a identificação dos agentes nocivos; suas possíveis fontes geradoras; suas possíveis trajetórias e meios de propagação; o número de trabalhadores expostos; seus cargos; as atividades desenvolvidas; o tipo de exposição a que estão sujeitos; os possíveis danos à saúde e a criticidade dos agentes.<p>
				
				<b>9 - MANUTENÇÃO E DIVULGAÇÃO DOS DADOS</b><p align="justify">
				&nbsp;&nbsp;&nbsp;Os dados obtidos deverão ser mantidos arquivados por um período mínimo de 20 anos, ficando disponível aos trabalhadores interessados ou seus representantes e para as autoridades competentes.<p>
				
				<b>10 - PERIODICIDADE</b><p align="justify">
				&nbsp;&nbsp;&nbsp;O planejamento das atividades necessárias à execução do PPRA será anual. O monitoramento e o controle dos riscos terá a freqüência determinada pela classe de criticidade do agente nocivo, constante da Ficha de Quantificação dos Riscos, anexo a este documento.<p>
				
				<b>11 - AVALIAÇÃO DO DESENVOLVIMENTO</b><p align="justify">
				&nbsp;&nbsp;&nbsp;A eficácia do PPRA deve ser avaliada, com frequência, de forma a verificar seus resultados, que devem estar em conformidade com os exames médicos de saúde previstos nas normas da empresa, preconizadas na NR-7 – PROGRAMA DE CONTROLE MÉDICO DE SAÚDE OCUPACIONAL – PCMSO.<p>	
				<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
		<table align="center" width="550" height="<?php echo $hei; ?>" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center">
				<h1>1ª FASE<p><br><p>RECONHECIMENTO<p><br><p>E<p><br><P>AVALIAÇÕES AMBIENTAIS</h1>
				</td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
		<b>Legenda de Riscos Coleta de Dados:</b><p>
		<table align="center" width="699" height="<?php echo $hei; ?>" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="99" align="center" class="fontepreta12" rowspan="2">Especificação de Tipo de Riscos</td>
				<td width="110" align="center" class="fontepreta12">01 Físico</td>
				<td width="120" align="center" class="fontepreta12">02 Químico</td>
				<td width="90" align="center" class="fontepreta12">03 Biológico</td>
				<td width="140" align="center" class="fontepreta12">04 Ergonômico</td>
				<td width="140" align="center" class="fontepreta12">05 Acidentes</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">Verde</td>
				<td align="center" class="fontepreta12">Vermelho</td>
				<td align="center" class="fontepreta12">Marrom</td>
				<td align="center" class="fontepreta12">Amarelo</td>
				<td align="center" class="fontepreta12">Azul</td>
			</tr>
			<tr>
				<td align="center" valign="top" class="fontepreta12">1</td>
				<td align="center" valign="top" class="fontepreta10">Ruídos</td>
				<td align="center" valign="top" class="fontepreta10">Poeiras</td>
				<td align="center" valign="top" class="fontepreta10">Vírus</td>
				<td align="center" valign="top" class="fontepreta10">Esforço Intenso</td>
				<td align="center" valign="top" class="fontepreta10">Arranjo Inadequado</td>
			</tr>
			<tr>
				<td align="center" valign="top" class="fontepreta12">2</td>
				<td align="center" valign="top" class="fontepreta10">Vibrações</td>
				<td align="center" valign="top" class="fontepreta10">Fumos</td>
				<td align="center" valign="top" class="fontepreta10">Bactérias</td>
				<td align="center" valign="top" class="fontepreta10">Levantamento e Transporte Manual de Peso</td>
				<td align="center" valign="top" class="fontepreta10">Máquinas e Equipamentos sem Proteção</td>
			</tr>
			<tr>
				<td align="center" valign="top" class="fontepreta12">3</td>
				<td align="center" valign="top" class="fontepreta10">Radiação Ionizantes</td>
				<td align="center" valign="top" class="fontepreta10">Nevoas</td>
				<td align="center" valign="top" class="fontepreta10">Protozoários</td>
				<td align="center" valign="top" class="fontepreta10">Exigência de Postura Inadequada</td>
				<td align="center" valign="top" class="fontepreta10">Ferramenta Inadequada ou Defeituosa</td>
			</tr>
			<tr>
				<td align="center" valign="top" class="fontepreta12">4</td>
				<td align="center" valign="top" class="fontepreta10">Radiação não Ionizantes</td>
				<td align="center" valign="top" class="fontepreta10">Neblina</td>
				<td align="center" valign="top" class="fontepreta10">Fungos</td>
				<td align="center" valign="top" class="fontepreta10">Controle Rígido de Produtividade</td>
				<td align="center" valign="top" class="fontepreta10">Iluminação Inadequada</td>
			</tr>
			<tr>
				<td align="center" valign="top" class="fontepreta12">5</td>
				<td align="center" valign="top" class="fontepreta10">Frio</td>
				<td align="center" valign="top" class="fontepreta10">Gases</td>
				<td align="center" valign="top" class="fontepreta10">Parasitas</td>
				<td align="center" valign="top" class="fontepreta10">Imposição de Ritmos Excessivos</td>
				<td align="center" valign="top" class="fontepreta10">Eletricidade</td>
			</tr>
			<tr>
				<td align="center" valign="top" class="fontepreta12">6</td>
				<td align="center" valign="top" class="fontepreta10">Calor</td>
				<td align="center" valign="top" class="fontepreta10">Vapores</td>
				<td align="center" valign="top" class="fontepreta10">Bacilos</td>
				<td align="center" valign="top" class="fontepreta10">Trabalho em Turno e Noturno</td>
				<td align="center" valign="top" class="fontepreta10">Probabilidade de Incêndio ou Explosão</td>
			</tr>
			<tr>
				<td align="center" valign="top" class="fontepreta12">7</td>
				<td align="center" valign="top" class="fontepreta10">Pressões Anormais</td>
				<td align="center" valign="top" class="fontepreta10">Substâncias, Composto, Produto Químico em Geral</td>
				<td align="center" valign="top" class="fontepreta10">&nbsp;</td>
				<td align="center" valign="top" class="fontepreta10">Jornada de Trabalho Prolongada</td>
				<td align="center" valign="top" class="fontepreta10">Armazenamento Inadequado</td>
			</tr>
			<tr>
				<td align="center" valign="top" class="fontepreta12">8</td>
				<td align="center" valign="top" class="fontepreta10">Umidade</td>
				<td align="center" valign="top" class="fontepreta10">&nbsp;</td>
				<td align="center" valign="top" class="fontepreta10">&nbsp;</td>
				<td align="center" valign="top" class="fontepreta10">Monotonia e Repetitividade</td>
				<td align="center" valign="top" class="fontepreta10">Animais Peçonhentos</td>
			</tr>
			<tr>
				<td align="center" valign="top" class="fontepreta12">9</td>
				<td align="center" valign="top" class="fontepreta10">&nbsp;</td>
				<td align="center" valign="top" class="fontepreta10">&nbsp;</td>
				<td align="center" valign="top" class="fontepreta10">&nbsp;</td>
				<td align="center" valign="top" class="fontepreta10">Outras Situações Causadoras de Stress Físico e/ou Psíquico</td>
				<td align="center" valign="top" class="fontepreta10">Outras Situações de Risco que Poderão Contribuir para a Ocorrência de Acidentes</td>
			</tr>
		</table>	
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
<!---------------------8ª PÁGINA--------------->
<?php 	
for($x=0;$x<pg_num_rows($r_ativ);$x++){
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
	<b>PRIMEIRA FASE DO RECONHECIMENTO</b><br>
	<b>1 - COLETA DE DADOS DA EXPOSIÇÃO DO TRABALHADOR AOS AGENTES:</b><br>
	<table align="center" width="699" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td valign="top">
		<table align="left" width="230" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="left" class="fontepreta10"><b>Local:</b> <?php echo $row_ativ[$x][nome_setor]; ?></td>
			</tr>
		</table>
		</td>
		<td>
		<table align="right" width="469" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="left" class="fontepreta10"><b>Atividade:</b> <?php echo $row_ativ[$x][desc_setor]; ?></td>
			</tr>
		</table>
		</td>
	</tr>
	</table>
	<table align="center" width="699" border="0" cellpadding="1" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" valign="top" width="230" class="fontepreta12"><b>CARACTERÍSTICAS:</b><br>
		<table align="left" width="230" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="left" class="fontepreta10"><b>Edificação:</b> <?php echo $row_ativ[$x][descricao]; ?></td>
			</tr>
			<tr>
				<td align="left" class="fontepreta10"><b>Piso:</b> <?php echo $row_ativ[$x][descricao_piso]; ?></td>
			</tr>
			<tr>
				<td align="left" class="fontepreta10"><b>Parede:</b> <?php echo $row_ativ[$x][decicao_parede]; ?></td>
			</tr>
			<tr>
				<td align="left" class="fontepreta10"><b>Cobertura:</b> <?php echo $row_ativ[$x][decicao_cobertura]; ?></td>
			</tr>
			<tr>
				<td align="left" class="fontepreta10"><b>Luz Natural:</b> <?php echo $row_ativ[$x][descricao_luz_nat]; ?></td>
			</tr>
			<tr>
				<td align="left" class="fontepreta10"><b>Luz Artificial:</b> <?php echo $row_ativ[$x][decricao_luz_art]; ?></td>
			</tr>
			<tr>
				<td align="left" class="fontepreta10"><b>Vento Natural:</b> <?php echo $row_ativ[$x][decricao_vent_nat]; ?></td>
			</tr>
			<tr>
				<td align="left" class="fontepreta10"><b>Vento Artificial:</b> <?php echo $row_ativ[$x][decricao_vent_art]; ?></td>
			</tr>
		</table>
		</td>
		<td align="left" valign="top" width="469" class="fontepreta12"><b>IDENTIFICAÇÃO QUALITATIVA DE AGENTE NOCIVO:</b><br>
<?php
$agente = "SELECT ag.*, rs.fonte_geradora, tr.nome_tipo_risco
		  FROM agente_risco ag, risco_setor rs, tipo_risco tr, cliente_setor cs
		  WHERE cs.cod_cliente = rs.cod_cliente
		  AND cs.cod_setor = rs.cod_setor
		  AND rs.cod_agente_risco = ag.cod_agente_risco
		  AND ag.cod_tipo_risco = tr.cod_tipo_risco
		  AND cs.cod_setor = {$row_ativ[$x]['cod_setor']}
		  AND cs.id_ppra = rs.id_ppra
		  AND cs.id_ppra = $_GET[id_ppra]";
$resul_agente = pg_query($connect, $agente) or die
	("erro na query:$agente==>".pg_last_error($connect));
$row_agente = pg_fetch_all($resul_agente);

for($y=0;$y<pg_num_rows($resul_agente);$y++){
?>
		<table align="right" width="469" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="left" width="150" class="fontepreta10"><b>Cod:</b> <?php echo $row_agente[$y][num_agente_risco]; ?></td>
				<td align="left" class="fontepreta10"><b>Grupo:</b> <?php echo $row_agente[$y][nome_tipo_risco]; ?></td>
			</tr>
			<tr>
				<td colspan="2" align="left" class="fontepreta10"><b>Agente:</b> <?php echo $row_agente[$y][nome_agente_risco]; ?></td>
			</tr>
			<tr>
				<td colspan="2" align="left" class="fontepreta10"><b>Fonte Geradora:</b> <?php echo $row_agente[$y][fonte_geradora]; ?></td>
			</tr>
		</table><br>
<?php } ?>
		</td>
	</tr>
	</table>
	<b>MEDIDAS PREVENTIVAS EXISTENTES:</b><br>
<?php
/********BUSCA OS EPI'S EXISTENTES DE SUGESTÃO*********/
$epi = "select distinct(se.descricao)
from sugestao s, setor_epi se 
where (s.cod_setor = se.cod_setor
AND s.med_prev = se.id
AND s.cod_setor = {$row_ativ[$x]['cod_setor']})
and s.plano_acao = 1 
AND s.id_ppra = $_GET[id_ppra]";

$result_epi = pg_query($connect, $epi) or die
	("erro na query:$epi==>".pg_last_error($connect));

/********BUSCA OS CURSOS EXISTENTES DE SUGESTÃO*****/
$curso = "select distinct(fc.descricao)
from sugestao s, funcao_curso fc 
where s.med_prev = fc.id
and s.cod_funcao = fc.cod_curso
AND s.cod_setor = {$row_ativ[$x]['cod_setor']}
and s.plano_acao = 1
AND s.id_ppra = $_GET[id_ppra]";

$result_curso = pg_query($connect, $curso) or die
	("erro na query:$curso==>".pg_last_error($connect));

/********BUSCA AS AVALIAÇÕES AMBIENTAIS EXISTENTES DA SUGESTÃO*****/
$ambiente = "select distinct(sa.descricao)
from sugestao s, setor_ambiental sa 
where (s.cod_setor = sa.cod_setor
and s.med_prev = sa.id
AND s.cod_setor = {$row_ativ[$x]['cod_setor']})
and s.plano_acao = 1
AND s.id_ppra = $_GET[id_ppra]";

$result_ambiente = pg_query($connect, $ambiente) or die
	("erro na query:$ambiente==>".pg_last_error($connect));

/********BUSCA OS PROGRAMAS EXISTENTES DA SUGESTÃO*****/
$prog = "select distinct(sp.descricao)
from sugestao s, setor_programas sp 
where s.med_prev = sp.id
and s.cod_setor = sp.cod_setor
AND s.cod_setor = {$row_ativ[$x]['cod_setor']}
and s.plano_acao = 1
AND s.id_ppra = $_GET[id_ppra]";

$result_prog = pg_query($connect, $prog) or die
	("erro na query:$prog==>".pg_last_error($connect));
?>
	<table align="center" width="699" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center">
			<table align="left" width="698" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="justify" class="fontepreta10">No Homem: 
				<?php 
				while($row_epi = pg_fetch_array($result_epi)){
					echo $row_epi[descricao]."; ";
				}
				
				while($row_curso = pg_fetch_array($result_curso)){
					echo $row_curso[descricao]."; ";
				}
				
				while($row_ambiente = pg_fetch_array($result_ambiente)){
					echo $row_ambiente[descricao]."; ";
				}

				while($row_prog = pg_fetch_array($result_prog)){
					echo $row_prog[descricao]."; ";
				}

				?>
				</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta10">No Ambiente: <?php echo $row_ativ[$x][epc_existente]; ?></td>
			</tr>
			</table>
			</td>
		</tr>
	</table>
	
	<b>MEDIDAS PREVENTIVAS SUGERIDAS:</b><br>
<?php
/********BUSCA OS EPI'S SUGERIDOS DE SUGESTÃO*********/
$epi = "select distinct(se.descricao)
from sugestao s, setor_epi se 
where (s.cod_setor = se.cod_setor
and s.med_prev = se.id
AND s.cod_setor = {$row_ativ[$x]['cod_setor']})
and s.plano_acao = 0
AND s.id_ppra = $_GET[id_ppra]";

$result_epi = pg_query($connect, $epi) or die
	("erro na query:$epi==>".pg_last_error($connect));

/********BUSCA OS CURSOS SUGERIDOS DE SUGESTÃO*****/
$curso = "select Distinct(fc.descricao)
from sugestao s, funcao_curso fc 
where s.med_prev = fc.id
and s.cod_funcao = fc.cod_curso
AND s.cod_setor = {$row_ativ[$x]['cod_setor']}
and s.plano_acao = 0
AND s.id_ppra = $_GET[id_ppra]";

$result_curso = pg_query($connect, $curso) or die
	("erro na query:$curso==>".pg_last_error($connect));

/********BUSCA AS AVALIAÇÕES AMBIENTAIS DA SUGESTÃO*****/
$ambiente = "select distinct(sa.descricao)
from sugestao s, setor_ambiental sa 
where (s.cod_setor = sa.cod_setor
and s.med_prev = sa.id
AND s.cod_setor = {$row_ativ[$x]['cod_setor']})
and s.plano_acao = 0
AND s.id_ppra = $_GET[id_ppra]";

$result_ambiente = pg_query($connect, $ambiente) or die
	("erro na query:$ambiente==>".pg_last_error($connect));

/********BUSCA OS PROGRAMAS SUGERIDOS DA SUGESTÃO*****/
$sql = "select distinct(sp.descricao)
from sugestao s, setor_programas sp 
where s.med_prev = sp.id
and s.cod_setor = sp.cod_setor
AND s.cod_setor = {$row_ativ[$x]['cod_setor']}
and s.plano_acao = 0
AND s.id_ppra = $_GET[id_ppra]";

$rprog = pg_query($connect, $sql) or die
	("erro na query:$sql==>".pg_last_error($connect));
?>
	<table align="center" width="699" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center">
			<table align="left" width="698" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="justify" class="fontepreta10">No Homem: 
				<?php 
				while($row_epi = pg_fetch_array($result_epi)){
					echo $row_epi[descricao]."; ";
				}
				
				while($row_curso = pg_fetch_array($result_curso)){
					echo $row_curso[descricao]."; ";
				}
				
				while($row_ambiente = pg_fetch_array($result_ambiente)){
					echo $row_ambiente[descricao]."; ";
				}

				while($prog_math = pg_fetch_array($rprog)){
					echo $prog_math[descricao]."; ";
				}

				?>
				</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta10">No Ambiente: <?php echo $row_ativ[$x][epc_sugerido]; ?></td>
			</tr>
			</table>
			</td>
		</tr>
	</table>
	<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="100"></div>
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
<!---------------------9ª PÁGINA--------------->
<?php
/****************EXPOSIÇÃO DOS AGENTES*****************/
$sql_dados = "select t.nome, ca.nome as nome1
			 from setor s, risco_setor r, cliente_setor c, tipo_contato t, contato_com_agente ca
			 where r.cod_cliente = c.cod_cliente
					and r.cod_setor = c.cod_setor
					and r.cod_setor = s.cod_setor
					and r.cod_tipo_contato = t.tipo_contato_id
					and r.cod_agente_contato = ca.contato_com_agente_id
					AND c.id_ppra = r.id_ppra
					AND c.id_ppra = $_GET[id_ppra]";
$result_dados = pg_query($connect, $sql_dados) 
or die ("Erro na query: $sql_dados <p> " . pg_last_error($connect) );
$r_dados = pg_fetch_array($result_dados);

/*************** INFORMAÇÕES DO PCMSO ******************/
$info = "SELECT ag.*, tr.nome_tipo_risco
		  FROM agente_risco ag, tipo_risco tr, cliente_setor cs, risco_setor rs
		  WHERE cs.cod_cliente = rs.cod_cliente
		  AND cs.cod_setor = rs.cod_setor
		  AND rs.cod_agente_risco = ag.cod_agente_risco
		  AND ag.cod_tipo_risco = tr.cod_tipo_risco
		  AND cs.id_ppra = rs.id_ppra
		  AND cs.id_ppra = $_GET[id_ppra]

		  GROUP BY ag.cod_agente_risco, ag.descricao_agente_risco, ag.nome_agente_risco,
		  ag.cod_tipo_risco, ag.num_agente_risco, tr.nome_tipo_risco";
$res_info = pg_query($connect, $info) or die
	("erro na query:$info==>".pg_last_error($connect));
$row_info = pg_fetch_all($res_info);

$contem = array();
for($k=0;$k<pg_num_rows($res_info);$k++){
	$sql = "SELECT diagnostico FROM risco_setor WHERE cod_agente_risco = {$row_info[$k][cod_agente_risco]} AND id_ppra = $_GET[id_ppra]";
	$r = pg_query($sql);
	$diag = pg_fetch_array($r);

$contem[] = "<table align=\"center\" width=\"600\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#000000\">
	<tr>
		<td width=\"50\" align=\"left\" class=\"fontepreta12\"><b>Cód:</b><br>". $row_info[$k][num_agente_risco]."</td>
		<td width=\"150\" align=\"left\" class=\"fontepreta12\"><b>Agente:</b><br>". $row_info[$k][nome_tipo_risco]."</td>
		<td width=\"400\" valign=\"top\" rowspan=\"2\" align=\"left\" class=\"fontepreta12\"><b>Diagnóstico:</b><br>". $diag[diagnostico]."</td>
	</tr>
	<tr>
		<td width=\"200\" colspan=\"2\" align=\"left\" class=\"fontepreta12\"><b>Fonte:</b><br>". $row_info[$k][nome_agente_risco]."</td>
	</tr>
</table>";
}

for ($y=0;$y<ceil(count($contem)/5);$y++) { ?>
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
		<b>PRIMEIRA FASE DO RECONHECIMENTO</b><p>
		<table align="center" width="600" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center"><b><font size="2">CARACTERIZAÇÃO DA EXPOSIÇÃO DO TRABALHADOR AOS AGENTES NOCIVOS</font></b></td>
			</tr>
		</table><p>
		<table align="center" width="600" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center" class="fontepreta12"><b>Masculino</b></td>
				<td align="center" class="fontepreta12"><b>Feminino</b></td>
				<td align="center" class="fontepreta12"><b>Jornada</b></td>
				<td align="center" class="fontepreta12"><b>Tipo de Exposição</b></td>
				<td align="center" class="fontepreta12"><b>Contato com o Agente</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><?php echo coloca_zeros($nmasc); ?></td>
				<td align="center" class="fontepreta12"><?php echo coloca_zeros($nfem); ?></td>
				<td align="center" class="fontepreta12"><?php echo $row[jornada]; ?></td>
				<td align="center" class="fontepreta12"><?php echo $r_dados[nome]; ?></td>
				<td align="center" class="fontepreta12"><?php echo $r_dados[nome1]; ?></td>
			</tr>
		</table><p align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<b>Com Base as Informações Ora Obtidas Pela Coordenação do PCMSO.<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Diagnósticos de Possíveis Danos a Saúde do Trabalhador.</b><p>
		
		<?php 
			$i = $y*5;
			for($x=$i;$x<$i+5;$x++){ 
			   echo $contem[$x];			
			}
		?>
			
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
		<table align="center" width="550" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center">
					<h1>2ª FASE<p>EFEITOS CAUSADOS<p>NO HOMEM<p>E<p>ANÁLISE DA<p>FONTE GERADORA</h1>
				</td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
		<table align="center" width="550" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center"><img src="../img/boneco_ppra.jpg" border="0" width="500" height="700" /></td>
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
<!---------------------12ª PÁGINA--------------->
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
		<b>TABELA DE LIMITE DE TOLERÂNCIA PARA EXPOSIÇÃO DE RÚIDOS CONTINUO E INTERMITENTE</b><p>
		<table align="center" width="550" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center" class="fontepreta12"><b>NÍVEL DE RUÍDO – db (A) MÁXIMA EXPOSIÇÃO DIÁRIA PERMISSÍVEL</b></td>
			</tr>
		</table><br>
		<table align="center" width="550" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center" class="fontepreta12"><b>85</b></td>
				<td align="left" class="fontepreta12">&nbsp;<b>8 HORAS</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>86</b></td>
				<td align="left" class="fontepreta12"><b>&nbsp;7 HORAS</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>87</b></td>
				<td align="left" class="fontepreta12"><b>&nbsp;6 HORAS</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>88</b></td>
				<td align="left" class="fontepreta12"><b>&nbsp;5 HORAS</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>89</b></td>
				<td align="left" class="fontepreta12"><b>&nbsp;4 HORAS</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>90</b></td>
				<td align="left" class="fontepreta12"><b>&nbsp;4 HORAS</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>91</b></td>
				<td align="left" class="fontepreta12"><b>&nbsp;3 HORAS E 30 MINUTOS</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>92</b></td>
				<td align="left" class="fontepreta12"><b>&nbsp;3 HORAS</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>93</b></td>
				<td align="left" class="fontepreta12"><b>&nbsp;2 HORAS E 40 MINUTOS</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>94</b></td>
				<td align="left" class="fontepreta12"><b>&nbsp;2 HORAS E 15 MINUTOS</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>95</b></td>
				<td align="left" class="fontepreta12"><b>&nbsp;2 HORAS</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>96</b></td>
				<td align="left" class="fontepreta12"><b>&nbsp;1 HORA E 45 MINUTOS</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>98</b></td>
				<td align="left" class="fontepreta12"><b>&nbsp;1 HORA E 15 MINUTOS</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>100</b></td>
				<td align="left" class="fontepreta12"><b>&nbsp;1 HORA</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>102</b></td>
				<td align="left" class="fontepreta12"><b>&nbsp;45 MINUTOS</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>102</b></td>
				<td align="left" class="fontepreta12"><b>&nbsp;45 MINUTOS</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>104</b></td>
				<td align="left" class="fontepreta12"><b>&nbsp;35 MINUTOS</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>105</b></td>
				<td align="left" class="fontepreta12"><b>&nbsp;30 MINUTOS</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>106</b></td>
				<td align="left" class="fontepreta12"><b>&nbsp;25 MINUTOS</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>107</b></td>
				<td align="left" class="fontepreta12"><b>&nbsp;20 MINUTOS</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>110</b></td>
				<td align="left" class="fontepreta12"><b>&nbsp;15 MINUTOS</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>112</b></td>
				<td align="left" class="fontepreta12"><b>&nbsp;10 MINUTOS</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>114</b></td>
				<td align="left" class="fontepreta12"><b>&nbsp;8 MINUTOS</b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>115</b></td>
				<td align="left" class="fontepreta12"><b>&nbsp;7 MINUTOS</b></td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
<!---------------------13ª PÁGINA--------------->
<?php
for($x=0;$x<count($row_ativ);$x++){
$s_fase = "SELECT Distinct(s.nome_setor) as nome, cs.data_avaliacao, cs.hora_avaliacao, cs.ruido_fundo_setor,
		  cs.ruido_operacao_setor, a.nome_aparelho, s.desc_setor
		  FROM setor s, agente_risco ar, risco_setor rs, cliente_setor cs, aparelhos a, cliente c
		  WHERE cs.cod_cliente = c.cliente_id
		  AND cs.cod_setor = s.cod_setor
		  AND cs.cod_cliente = rs.cod_cliente
		  AND cs.cod_setor = rs.cod_setor
		  AND ar.cod_agente_risco = rs.cod_agente_risco
		  AND a.cod_aparelho = cs.ruido
		  AND cs.cod_setor = {$row_ativ[$x]['cod_setor']}
		  AND cs.id_ppra = rs.id_ppra
		  AND cs.id_ppra = $_GET[id_ppra]";
		  
$result_fase = pg_query($connect, $s_fase);
$row_fase = pg_fetch_all($result_fase);
for($w=0;$w<pg_num_rows($result_fase);$w++){
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
		<b>SEGUNDA FASE - AVALIAÇÃO AMBIENTAL</b><p>
		<table align="center" width="550" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="left" class="fontepreta12bold">PLANILHA DE QUANTIFICAÇÃO DE RISCO – PQR - MEDIÇÕES</td>
			</tr>
		</table><p>
		<b>AVALIAÇÕES QUANTITATIVAS</b><p>
		<table align="center" width="600" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center">
				<table align="center" width="600" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
					<tr>
						<td align="center">
						<table align="center" width="300" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
							<tr>
								<td align="left" class="fontepreta12bold">SETOR / POSTO</td>
								<td style="border:1px solid #000000" align="center" class="fontepreta12"><?php echo $row_fase[$w][nome]; ?></td>
							</tr>
							<tr>
								<td align="left" class="fontepreta12bold">AGENTE</td>
								<td style="border:1px solid #000000" align="center" class="fontepreta12">Ruídos</td>
							</tr>
							<tr>
								<td align="left" class="fontepreta12bold">DATA</td>
								<td style="border:1px solid #000000" align="center" class="fontepreta12"><?php echo $row_fase[$w][data_avaliacao]; ?></td>
							</tr>
							<tr>
								<td align="left" class="fontepreta12bold">HORA</td>
								<td style="border:1px solid #000000" align="center" class="fontepreta12"><?php echo $row_fase[$w][hora_avaliacao]; ?></td>
							</tr>
						</table>
						</td>
						<td align="center">
						<table align="center" width="300" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
							<tr>
								<td align="left" class="fontepreta12bold">EFETIVO</td>
								<td style="border:1px solid #000000" align="center" class="fontepreta12">
								<?php
								/*************QUANTIDADE DE FUNCIONÁRIOS NO SETOR************/
								$qtd = "SELECT cod_cgrt, f.* FROM funcionarios f, cgrt_func_list l
										WHERE (f.setor_adicional like '{$row_ativ[$x]['cod_setor']}|%' AND f.cod_cliente = $cliente AND l.cod_cgrt = $_GET[id_ppra] AND f.cod_func = l.cod_func)
										OR (f.setor_adicional like '%|{$row_ativ[$x]['cod_setor']}|%' AND f.cod_cliente = $cliente AND l.cod_cgrt = $_GET[id_ppra] AND f.cod_func = l.cod_func)
										OR (f.cod_setor = {$row_ativ[$x]['cod_setor']} AND f.cod_cliente = $cliente AND l.cod_cgrt = $_GET[id_ppra] AND f.cod_func = l.cod_func)";

								/*SELECT f.* FROM funcionarios f
										WHERE (f.setor_adicional like '{$row_ativ[$x]['cod_setor']}|%' AND f.cod_cliente = $cliente)
										OR (f.setor_adicional like '%|{$row_ativ[$x]['cod_setor']}|%' AND f.cod_cliente = $cliente)
										OR (f.cod_setor = {$row_ativ[$x]['cod_setor']} AND f.cod_cliente = $cliente)";*/
								$res_qtd = pg_query($qtd);
								$r_qtd = pg_num_rows($res_qtd);
								
								echo coloca_zeros($r_qtd); ?>
								</td>
							</tr>
							<tr>
								<td align="left" class="fontepreta12bold">EQUIPAMENTO</td>
								<td style="border:1px solid #000000" align="center" class="fontepreta12"><?php echo $row_fase[$w][nome_aparelho]; ?></td>
							</tr>
							<tr>
								<td align="left" class="fontepreta12bold">RUÍDO DE FUNDO</td>
								<td style="border:1px solid #000000" align="center" class="fontepreta12"><?php echo number_format($row_fase[$w][ruido_fundo_setor], 1,'.', ''); ?></td>
							</tr>
							<tr>
								<td align="left" class="fontepreta12bold">RUÍDO DE OPERAÇÃO</td>
								<td style="border:1px solid #000000" align="center" class="fontepreta12"><?php echo number_format($row_fase[$w][ruido_operacao_setor], 1,'.', ''); ?></td>
							</tr>
						</table>
						</td>
					</tr>
				</table>
				</td>
			</tr>
		</table><p><br>
		<table align="center" width="699" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center" class="fontepreta14bold">RELAÇÃO NOMINAL DO(S) TRABALHADOR(ES) NO SETOR</td>
				<!--td align="center" class="fontepreta14bold">RELAÇÃO DE FUNÇÕES DO(S) TRABALHADOR(ES) NO SETOR</td-->
			</tr>
			<tr>
				<td align="center" class="fontepreta12">
				<?php /***************BUSCA OS FUNCIONÁRIOS DO SETOR************************/
				while($row_func=pg_fetch_array($res_qtd)){
				echo $row_func[nome_func].",&nbsp;" ;
				}
				/*$qtda = "SELECT distinct(fu.nome_funcao) FROM funcionarios f, funcao fu
						WHERE fu.cod_funcao = f.cod_funcao
						AND ((f.setor_adicional like '{$row_ativ[$x]['cod_setor']}|%' AND f.cod_cliente = $cliente)
						OR (f.setor_adicional like '%|{$row_ativ[$x]['cod_setor']}|%' AND f.cod_cliente = $cliente)
						OR (f.cod_setor = {$row_ativ[$x]['cod_setor']} AND f.cod_cliente = $cliente))";
				$res_qtda = pg_query($qtda);
				$r_qtda = pg_num_rows($res_qtda);
				
				while($row_func=pg_fetch_array($res_qtda)){
				echo $row_func[nome_funcao].",&nbsp;" ;
				}*/
				?>&nbsp;
				</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta14bold">MEDIDAS DE CONTROLE IMPLEMENTADAS</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">A empresa <b><?php echo $row[razao_social]; ?></b>  Adota a medida de alternação de atividades nos setores.<br>&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta14bold">DINÂMICA DA FUNÇÃO</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><?php echo $row_fase[$w][desc_setor]; ?><br>&nbsp;</td>
			</tr>
		</table>
		<table align="center" width="699" border="0">
		<tr>
			<td align="justify" class="fontepreta12">OBS: Recomenda-se que a lista nominal dos colaboradores por setor conste nos mesmos de acordo com suas funções e dinâmica da função.</td>
		</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
<?php } } ?>
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
			?>
		</td>
	</tr>
	<tr>
	<td class="tabela" valign="top">
		<table align="center" width="550" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center"><h1>3ª FASE<p><br>EFEITOS<p><br>DA<p><br>ILUMINÂNCIA</h1></td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
		<table align="center" width="550" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="left" class="fontepreta12bold">Avaliação de Iluminação do PPRA<br>&nbsp;</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12bold">1 - VALORAÇÃO DE ILUMINAÇÃO<br>&nbsp;</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12bold">TABELA 1 - VALORAÇÃO QUANTITATIVA DE EXPOSIÇÃO PARA ILUMINAÇÃO<br>&nbsp;</td>
			</tr>
		</table><p>
		<table align="center" width="550" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="350" align="center" class="fontepreta12">Parâmetros de Classificação</td>
				<td width="200" align="center" class="fontepreta12">Prioridade de Monitoramento e Medidas de Controle</td>
			</tr>
		</table>
		<table align="center" width="550" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="350" align="left" class="fontepreta12">Ict = VR ou Im = VR, > 0,7 Im ou qualquer Ifct > 1/10 ict</td>
				<td width="200" align="center" class="fontepreta12">(0) Desprezível</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">Ict < VR ou Im < VR, > 0,7 Im ou qualquer Ifct > 1/10 ict</td>
				<td align="center" class="fontepreta12">(1) De Atenção</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">Ict < 0,7 Im ou qualquer Ifct < 1/10 ict</td>
				<td align="center" class="fontepreta12">(2) Crítica</td>
			</tr>
		</table><p>
		<table align="center" width="550" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="left" class="fontepreta12bold">VR – valor recomendado por tarefa e ou atividade; Ict – iluminação do campo de trabalho; Ifct – iluminação fora do campo de trabalho.<p></td>
			</tr>
			<tr>
				<td align="left" class="fontepreta14bold">TABELA 2 – VALORAÇÃO QUANTITATIVA PARA AGENTES SEM NÍVEL DE AÇÃO.</td>
			</tr>
		</table><p>
		<table align="center" width="550" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="350" align="center" class="fontepreta12">Parâmetros de Classificação</td>
				<td width="200" align="center" class="fontepreta12">Prioridade de Monitoramento e Medidas de Controle.</td>
			</tr>
		</table>
		<table align="center" width="550" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="385" align="left" class="fontepreta12">Fonte < limite de tolerância com exposição habitual e permanente</td>
				<td width="165" align="center" class="fontepreta12">(0) - Desprezível</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">Fonte < limite de tolerância com exposição ocasional e intermitente</td>
				<td align="center" class="fontepreta12">(1) – De atenção</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">Fonte >= limite de tolerância com exposição ocasional e intermitente</td>
				<td align="center" class="fontepreta12">(2) - Crítica</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">Fonte > limite de tolerância com exposição habitual e permanente</td>
				<td align="center" class="fontepreta12">(3) - Emergencial</td>
			</tr>
		</table><p><br>
		<table align="center" width="550" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="left" class="fontepreta14bold">TABELA 3 – VALORAÇÃO PRIORIZAÇÃO DE MONITORIZAÇÃO E DE MEDIDAS DE CONTROLE</td>
			</tr>
		</table><p>
		<table align="center" width="550" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="250" align="center" class="fontepreta12">Somar (tab. 1 + tab. 2) de Controle</td>
				<td width="300" align="center" class="fontepreta12">Prioridade de Monitoramento e Medidas </td>
			</tr>
		</table>
		<table align="center" width="550" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="250" align="center" class="fontepreta12">&nbsp;</td>
				<td width="300" align="center" class="fontepreta12">(0) - Desprezível</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">1 + 2</td>
				<td align="center" class="fontepreta12">(1) – De Atenção</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">2 + 3</td>
				<td align="center" class="fontepreta12">(2) – Crítica</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">3 + 3</td>
				<td align="center" class="fontepreta12">(3) - Emergencial</td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
<!---------------------16ª PÁGINA--------------->
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
		<table align="center" width="550" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="350" align="center" class="fontepreta14">Local de Atividade</td>
				<td width="100" align="center" class="fontepreta14">Lux: Máxima</td>
				<td width="100" align="center" class="fontepreta14">Lux: mínima</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12"><b>Escolas:</b> Salas de Aulas a Biblioteca</td>
				<td align="center" class="fontepreta12">1.000</td>
				<td align="center" class="fontepreta12">250</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12"><b>Escritório:</b> Recepção, Adm, Financeira, etc...</td>
				<td align="center" class="fontepreta12">1.000</td>
				<td align="center" class="fontepreta12">200</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12"><b>Fundições:</b> Áreas de Carregamentos e acabamentos</td>
				<td align="center" class="fontepreta12">1.000</td>
				<td align="center" class="fontepreta12">150</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12"><b>Industriais:</b> Produção, montagem, Instrumentos Carregamentos e Acabamentos.</td>
				<td align="center" class="fontepreta12">1.000</td>
				<td align="center" class="fontepreta12">150</td>
			</tr>
		</table><br><p align="justify">&nbsp;&nbsp;&nbsp;
		<b>Lux</b> – (iluminação) pode ser: natural gerada dos raios solares ou claridade do dia; artificial gerada de fonte de energia elétrica; e /ou natural e artificial, as áreas que se compreendem como postos de trabalho devem ser iluminadas de forma homogênea, não devendo ser permitida a constituição de sobras nas áreas de atuação do funcionário / colaborador. Recomenda-se avaliar nas suas medições qualquer superfície apropriada ao trabalho visual, bem como avaliar também os piores níveis de condições de iluminamento e a melhor, afim de considerações necessárias ao bom desempenho das atividades a ser exercida e a preservação da saúde do trabalhador que podem ser desde a redução de luminárias a ampliação ou substituição das lâmpadas ou calhas.
		<p align="justify">&nbsp;&nbsp;&nbsp;
		<b>Temperatura</b> – Se realiza uma estimativa através de verificação da temperatura umidade relativa do Ar, tendo seu controle feito por intermédio de avaliações de fonte e trajetória, são aplicadas ao meio de trabalho ou na ação da trajetória que for implantada a carga térmica.
		<p align="justify">&nbsp;&nbsp;&nbsp;
		<b>Medidas a tomar-se nesses casos:</b><br>Insuflação de ar fresco no local de posto de trabalho;<br>Temperatura do Ar.<br>Maior circulação do ar no local de posto de trabalho velocidade do ar;<br>Diminuir a temperatura Exaustão dos vapores de água emanada de um processo Umidade relativa do ar.
		<p align="justify">&nbsp;&nbsp;&nbsp;
		Utilização de barreira refletora (alumínio polido, aço inox) ou absorvente, ferro, aço, de radiação colocada entre as fontes e o trabalhador.<br>Calor irradiante.
		<p align="justify">&nbsp;&nbsp;&nbsp;
		Automação do processo produtivo ex: mudança do transporte manual de carga por esteiras ou ponte rolante.<br>Calor irritante.	
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
<!---------------------16ª PÁGINA--------------->
<?php 
$content = array();
for($x=0;$x<pg_num_rows($res_vr);$x++) {
$tmp = "			
<tr>
	<td align=center class=fontepreta12> {$row_vr[$x][nome_setor]}<br>{$row_vr[$x][nome_func]}<br>{$row_vr[$x][movel]}&nbsp;{$row_vr[$x][numero]}</td>
	<td align=center class=fontepreta12> {$row_vr[$x][descricao_luz_nat]}&nbsp;+&nbsp;{$row_vr[$x][decricao_luz_art]}</td>
	<td align=center class=fontepreta12> {$row_vr[$x][data_avaliacao]}</td>
	<td align=center class=fontepreta12> {$row_vr[$x][exposicao]}</td>
	<td align=center class=fontepreta12> {$row_vr[$x][lux_atual]}</td>
	<td align=center class=fontepreta12> {$row_vr[$x][lux_recomendado]}</td>
	<td align=center class=fontepreta12>
";	
	if($row_vr[$x][lux_atual] < $row_vr[$x][lux_recomendado]) {
	$lux = 'Abaixo do Limite Permitido';
	}elseif ($row_vr[$x][lux_atual] >= $row_vr[$x][lux_recomendado] and $row_vr[$x][lux_atual] <=1000) {
	$lux = 'Desprezivel';
	}elseif($row_vr[$x][lux_atual] > 1000) {
	$lux = 'Acima do Limite Permitido';
	}
$tmp .= "	
	$lux
	</td>
</tr>
";

$content[] = addslashes($tmp);
}

for ($y=0;$y<ceil(count($content)/4);$y++) { ?>
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
		<table align="center" width="699" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center" class="fontepreta14bold">QUADRO DE AVALIAÇÃO DE PRIORIDADES (AGENTE X SITUAÇÃO DE RISCO)</td>
			</tr>
		</table><p>
		<table align="center" width="699" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="250" align="center" class="fontepreta12bold">Setor</td>
				<td width="107" align="center" class="fontepreta12bold">Fonte de Iluminação</td>
				<td width="70" align="center" class="fontepreta12bold">Data Avaliação</td>
				<td width="55" align="center" class="fontepreta12bold">Tempo Exp./dia</td>
				<td width="65" align="center" class="fontepreta12bold">Avaliação Pontual</td>
				<td width="65" align="center" class="fontepreta12bold">VR* por Atividade</td>
				<td width="80" align="center" class="fontepreta12bold">Quadro da Priorização</td>
			</tr>
			<?php 
			$i = $y*4;
			for($x=$i;$x<$i+4;$x++){ 
			   echo $content[$x];			
			}
			?>
		</table>
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
<!---------------------17ª PÁGINA--------------->
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
		<table align="center" width="550" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center"><h1>4ª FASE<p><br>AVALIAÇÃO DO AGENTE<p><br>E<p><br>DAS SOLUÇÕES</h1></td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
<!---------------------18ª PÁGINA--------------->
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
		<table align="center" width="699" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="left" class="fontepreta14bold">ESTABELECIMENTO DE PRIORIDADES E METAS DE AVALIAÇÃO E CONTROLE</td>
				<td align="left" class="fontepreta14bold">Categoria de Riscos:</td>
			</tr>
		</table>
		<table align="center" width="699" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="149" align="center" class="fontepreta14bold">Categorias</td>
				<td width="300" align="center" class="fontepreta14bold">Situações Não Avaliadas</td>
				<td width="250" align="center" class="fontepreta14bold">Situações Avaliadas</td>
			</tr>
			<tr>
				<td align="justify" valign="top" class="fontepreta12">1 - Irrelevante(Controle de Rotinas)</td>
				<td align="justify" valign="top" class="fontepreta12">Quando o agente não representa risco potencial de dano à saúde nas condições usuais industriais, escritas em literatura, ou pode representar, apenas um aspecto de desconforto e não de risco.</td>
				<td align="justify" valign="top" class="fontepreta12">Quando o agente se encontra sob controle técnico e abaixo do nível de ação, ou seja, metade do limite tolerante.</td>
			</tr>
			<tr>
				<td align="justify" valign="top" class="fontepreta12">2– De Atenção (Controle Preferencial/Monitoramento)</td>
				<td align="justify" valign="top" class="fontepreta12">Quando o agente representa o risco moderado a saúde, nas condições usuais industriais descritas na literatura, não causando efeitos agudos. Quando o agente pode causar efeitos agudos ou possuem LT valor teto ou valores de LT  muito baixo (alguns PPM).</td>
				<td align="justify" valign="top" class="fontepreta12">Quando a exposição se encontra sob controle técnico e acima do nível de ação, porém abaixo do LT.</td>
			</tr>
			<tr>
				<td align="justify" valign="top" class="fontepreta12">3 - Crítica (Controle Prioritário)</td>
				<td align="justify" valign="top" class="fontepreta12">Quando as práticas operacionais / condições ambientais indicam aparente descontrole de Exposição. Quando há possibilidade de deficiência de oxigênio. Quando não há proteção cutânea especifica. No manuseio de substâncias com notação dele. Quando há queixas especificas / indicadores  biológicos de exposição excedidos.</td>
				<td align="justify" valign="top" class="fontepreta12">Quando a exposição não se encontra sob controle técnico esta acima do LT média ponderada, porém abaixo do valor máximo ou valor teto.</td>
			</tr>
			<tr>
				<td align="justify" valign="top" class="fontepreta12">4 - Emergencial (Controle de Urgência)</td>
				<td align="justify" valign="top" class="fontepreta12">Quando envolve exposição a carcinogênicos nas situações aparentes de riscos grave e Iminente. Quando há risco aparente de deficiência de oxigênio. Quando o agente possui efeitos agudos, baixos, LT e IDLH concentrações imediatamente. Perigosas à vida /  saúde e as práticas operacionais situações ambientais indicam aparentes descontroles de exposição. Quando há exposição cutânea severa a substâncias com notação na pele.</td>
				<td align="justify" valign="top" class="fontepreta12">Quando a exposição não se encontra sob controle técnico esta acima do valor teto/valor máximo – IDLH.</td>
			</tr>			
		</table>
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
<!---------------------19ª PÁGINA--------------->
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
		<table align="center" width="699" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="left" class="fontepreta12bold">Avaliação de Riscos do PPRA</td>
				<td align="left" class="fontepreta12bold">VALORAÇÃO DE PRIORIDADES</td>
				<td align="left" class="fontepreta12bold">Tabela 1 - Graduação Qualitativa de Exposição</td>
			</tr>
		</table>
		<table align="center" width="699" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="200" align="left" class="fontepreta12bold">Categoria</td>
				<td width="350" align="left" class="fontepreta12bold">Descrição</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">0 - Não há exposição</td>
				<td align="left" class="fontepreta12">Nenhum contato com o agente</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">1 - Baixos níveis</td>
				<td align="left" class="fontepreta12">Contato ocasional e intermitente com o agente</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">2 - Exposição moderada</td>
				<td align="left" class="fontepreta12">Contato ocasional e permanente ou habitual e intermitente</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">3 - Exposição elevada</td>
				<td align="left" class="fontepreta12">Contato habitual e permanente com o agente</td>
			</tr>
		</table><p align="left">		
		<b>Tabela 2 - Graduação Qualitativa dos Efeitos ao Organismo Humano</b><p>		
		<table align="center" width="699" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="200" align="left" class="fontepreta12bold">Categoria</td>
				<td width="350" align="left" class="fontepreta12bold">Descrição</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">0 - Inócuo</td>
				<td align="left" class="fontepreta12">Efeitos reversíveis de pouca importância, não conhecidos</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">1 - Reversível</td>
				<td align="left" class="fontepreta12">Efeitos reversíveis preocupantes</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">2 - Irreversível</td>
				<td align="left" class="fontepreta12">Efeitos irreversíveis preocupantes</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">3 - Incapacitante</td>
				<td align="left" class="fontepreta12">Ameaça à vida ou à saúde / lesão incapacitaste</td>
			</tr>
		</table><p align="left">
		<b>Tabela 3 - Valoração Qualitativa</b><p>		
		<table align="center" width="699" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="200" align="left" class="fontepreta12bold">Somar(tab.1 + tab.2)</td>
				<td width="350" align="left" class="fontepreta12bold">Prioridade de monitorizarão e medidas de controle</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">0 + 1</td>
				<td align="left" class="fontepreta12">(0) - Desprezível</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">1 + 2</td>
				<td align="left" class="fontepreta12">(1) - De Atenção</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">2 + 3</td>
				<td align="left" class="fontepreta12">(2) - Crítica</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">3 + 3</td>
				<td align="left" class="fontepreta12">(3) - Emergencial</td>
			</tr>
		</table><p align="left">
		<b>Tabela 4 - Valoração Qualitativa Para Agentes com Nível de Ação</b><p>		
		<table align="center" width="699" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="200" align="left" class="fontepreta12bold">Parâmetro de Classificação</td>
				<td width="350" align="left" class="fontepreta12bold">Prioridade de monitorizarão e medidas de controle</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">Agente < Nível de Ação</td>
				<td align="left" class="fontepreta12">(0) - Desprezível</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">Agente > Nível de Ação</td>
				<td align="left" class="fontepreta12">(1) - De Atenção</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">Agente = Limite de Tolerância</td>
				<td align="left" class="fontepreta12">(2) - Crítica</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">Agente > Limite de Tolerância</td>
				<td align="left" class="fontepreta12">(3) - Emergencial</td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
<!---------------------20ª PÁGINA--------------->
<?php
$contem = array();

for($x=0;$x<count($row_ativ);$x++){
$sql = "select s.nome_setor 
		from setor s, cliente_setor cs
		where cs.cod_setor = s.cod_setor
		and cs.cod_setor = {$row_ativ[$x]['cod_setor']}
		AND cs.id_ppra = $_GET[id_ppra]";
$r_sql = pg_query($connect, $sql);
$row_sql = pg_fetch_array($r_sql);

$sql_dados = "select s.nome_setor, r.nivel, r.itensidade, r.danos_saude, r.escala_acao, r.acao_necessaria, tp.nome_tipo_risco
			from setor s, risco_setor r, cliente_setor c, agente_risco a, tipo_risco tp
			where r.cod_cliente = c.cod_cliente
			and r.cod_setor = c.cod_setor
			and r.cod_setor = s.cod_setor
			and r.cod_agente_risco = a.cod_agente_risco
			and a.cod_tipo_risco = tp.cod_tipo_risco
			and r.cod_setor = {$row_ativ[$x]['cod_setor']}
			AND c.id_ppra = r.id_ppra
			AND c.id_ppra = $_GET[id_ppra]";
$result_dados = pg_query($connect, $sql_dados) 
or die ("Erro na query: $sql_dados <p> " . pg_last_error($connect) );
$row_dados = pg_fetch_all($result_dados);

$ttmp = "";
for($y=0;$y<pg_num_rows($result_dados);$y++){
$tmp = "<tr>";
if($y==0){
$tmp .= "
	<td width=78 rowspan=".pg_num_rows($result_dados)." align=center class=fontepreta12> {$row_sql[nome_setor]}</td>
";
}
$tmp .= "	<td width=78 align=center class=fontepreta12> {$row_dados[$y][nome_tipo_risco]}</td>
	<td width=78 align=center class=fontepreta12>
	<table align=center width=78 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>
";
		$x1="&nbsp;";
		$x2="&nbsp;";
		$x3="&nbsp;";
		
		if($row_dados[$y][nivel] == "I") {
		$x1 = "x";
		}elseif($row_dados[$y][nivel] == "II") {
		$x2 = "x";
		}elseif($row_dados[$y][nivel] == "III") {
		$x3 = "x";
		}

$tmp .= "		<tr>
			<td width=25 align=center class=fontepreta12> $x1</td>
			<td width=25 align=center class=fontepreta12> $x2</td>
			<td width=25 align=center class=fontepreta12> $x3</td>
		</tr>
	</table>
	</td>
	<td width=90 align=center class=fontepreta12> {$row_dados[$y][itensidade]}</td>
	<td width=90 align=center class=fontepreta12> {$row_dados[$y][danos_saude]}</td>
	<td width=78 align=center class=fontepreta12>
	<table align=center width=78 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>
";
		$y1="&nbsp;";
		$y2="&nbsp;";
		$y3="&nbsp;";
		
		if($row_dados[$y][escala_acao] == "I") {
		$y1 = "x";
		}elseif($row_dados[$y][escala_acao] == "II") {
		$y2 = "x";
		}elseif($row_dados[$y][escala_acao] == "III") {
		$y3 = "x";
		}
$tmp .= "
		<tr>
			<td width=26 align=center class=fontepreta12> $y1</td>
			<td width=26 align=center class=fontepreta12> $y2</td>
			<td width=26 align=center class=fontepreta12> $y3</td>
		</tr>
	</table>
	</td>
	<td width=205 align=center class=fontepreta10> {$row_dados[$y][acao_necessaria]}</td>
</tr>
";
$ttmp .= $tmp;
 } 
 $contem[]= $ttmp;
 } ?>

<?php

$fm = 4; //original = 4 -> Fator de multiplicação

for ($p=0;$p<ceil(count($contem)/$fm);$p++) { ?>
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
		<table align="center" width="550" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center" class="fontepreta12bold">QUADRO DE AVALIAÇÃO DE PRIORIDADES (AGENTE X SITUAÇÃO DE RISCO)</td>
			</tr>
		</table><p>
		<table align="center" width="699" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="90" align="center" class="fontepreta12">Setor&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td width="70" align="center" class="fontepreta12">Agente</td>
				<td width="78" align="center" class="fontepreta12">Nível&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td width="80" align="center" class="fontepreta12">Grau de Intensidade e efeitos</td>
				<td width="70" align="center" class="fontepreta12">Danos à Saúde</td>
				<td width="78" align="center" class="fontepreta12">Escala de Ação</td>
				<td width="230" align="center" class="fontepreta12">Ações Necessárias</td>
			</tr>
			<tr>
				<td width="78" align="center" class="fontepreta12">&nbsp;</td>
				<td width="78" align="center" class="fontepreta12">&nbsp;</td>
				<td width="78" align="center" class="fontepreta12">
				<table align="center" width="78" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
					<tr>
						<td width="25" align="center" class="fontepreta12">I</td>
						<td width="25" align="center" class="fontepreta12">II</td>
						<td width="25" align="center" class="fontepreta12">III</td>
					</tr>
				</table>
				</td>
				<td width="90" align="center" class="fontepreta12">&nbsp;</td>
				<td width="90" align="center" class="fontepreta12">&nbsp;</td>
				<td width="78" align="center" class="fontepreta12">
				<table align="center" width="78" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
					<tr>
						<td width="26" align="center" class="fontepreta12">I</td>
						<td width="26" align="center" class="fontepreta12">II</td>
						<td width="26" align="center" class="fontepreta12">III</td>
					</tr>
				</table>
				</td>
				<td width="205" align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<?php
			$i = $p*$fm;
			for($x=$i;$x<$i+$fm;$x++){
			   echo $contem[$x];			
			}
			?>
		</table><p align="left">
		<b>Grau de Intensidade e de Efeitos:</b> Curto Prazo, Médio Prazo, Longo Prazo.<br>
		<b>Danos à Saúde:</b> Não Grave, Grave, Gravíssimo.	
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="100"></div>
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
<!---------------------21ª PÁGINA--------------->
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
		<table align="center" width="550" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center"><h1>5ª FASE<p><br>ANÁLISE<p><br>EM<p><br>ÂMBITO GERAL</h1></td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
<!---------------------22ª PÁGINA--------------->
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
		<p align="left">
		<b>MAPA DE RISCO AMBIENTAL</b><p align="justify">
		&nbsp;&nbsp;&nbsp;PORTARIA 33 de Outubro de 1983, em que determina a adoção de todas as empresas que possuam ou não a CIPA (Comissão Interna de Prevenção de Acidentes), deverá elaborar um MAPA DE RISCOS AMBIENTAIS, que será executado pela CIPA (quando houver), ou por profissionais qualificados.<br>
		&nbsp;&nbsp;&nbsp;A cada nova gestão o MAPA DE RISCOS AMBIENTAIS, será feito visando indicar áreas com riscos a fim de controlar e eliminar as incidências de riscos dos locais assim determinados por ele.<br>
		&nbsp;&nbsp;&nbsp;O mapeamento será feito através do laudo, com apresentação gráfica do reconhecimento dos riscos dos locais assim determinados.<br>
		&nbsp;&nbsp;&nbsp;RISCOS PEQUENOS: 2,5 cm de Diâmetro; RISCOS MÉDIOS:      5,0  cm de Diâmetro; RISCOS GRANDES: 10,0 cm de Diâmetro.<br>
		&nbsp;&nbsp;&nbsp;Será a área de risco determinada, conforme sua gravidade e em cores, de acordo com riscos encontrados e relacionados na tabela.<br>
		&nbsp;&nbsp;&nbsp;Após identificação dos riscos, os resultados serão encaminhados á direção da empresa para avaliação e retornem com as medidas de providencias a serem tomadas nos prazos máximos de acordo com a cumplicidade e cronograma de solução que lhe forem informados para o cumprimento, não devendo ser superior a trinta dias como base, a contar do recebimento de relatório.<br>
		&nbsp;&nbsp;&nbsp;Constatada as necessidades e adoção de medidas preventivas, caberá a diretoria definir o prazo e realizar tais alterações sugeridas em relatório e anotações.<p align="left">
		
		<b>METODOLOGIA DE AVALIAÇÃO DOS RISCOS E CARACTERIZAÇÃO DE EXPOSIÇÃO</b><p align="justify">
		
		<b>RUÍDO</b><p align="justify">
		• Medições em decibéis (db), com o instrumento operado no circuito de compensação “A” e circuito de resposta lente (SLOW), à leitura e feita próximo ao ouvido do trabalhador e nos locais considerados como de maior permanência do mesmo.<p align="justify">
		
		<b>CONFORMIDADE</b><p align="justify">
		• Anexo 1, item 2 da NR 15 Portaria 3214  de 08/06/78 – MTB.<br>
		• NHT – 06 R/E – Norma para avaliação de exposição ocupacional ao ruído da Funda centro.<p align="justify">
		
		<b>APARELHOS UTILIZADOS</b><p align="justify">
		• Medidor de nível de pressão sonora (decibelímetro), marca SIMPSON – modelo 886 – tipo 2 n. 2G-2888, fabricado pela MSA do Brasil  e aferido em 114db (A), com calibrador modelo 890 da MAS do Brasil n. 26-3128 (freqüência 1Hz).<p align="justify">
		
		<b>ILUMINÂNCIA</b><p align="justify">
		• Medições em luxes, ressaltando algumas observações para melhor interpretação.<p align="justify">
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
<!---------------------23ª PÁGINA--------------->
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
		<p align="left">
		<b>LUXES</b><p align="justify">
		• Níveis de Iluminância obtidos através da iluminação local.(ambiente).<p align="justify">
		A superfície da fotocélula dave ficar plano horizontal, a uma distância de 0,75cm do piso.<p align="justify">

		<b>COMFORMIDADE</b><p align="justify">
		• NR-17 Portaria 3214 de 08/06/78 – MTE.<br>
		• NBR 5413 – Verificação de Iluminação de Interiores – ABNT.<p align="justify">
		
		<b>APARELHOS UTILIZADOS</b><p align="justify">
		• Luxímetro SPER SCIENTIFIC TIPO METER LUX / FC 840020 – Fabricado pela SPER SCIENTIFIC LTDA.<p align="left">

		<b>ANEXO 1</b><p align="left">
		<b>Recomendações Finais</b><p align="justify">
		&nbsp;&nbsp;&nbsp;Com base na análise dos dados obtidos nas instalações técnicas de segurança e nas avaliações decorrentes das medições realizadas, apresentamos as orientações e os procedimentos a serem adotados para a melhoria do nível das condições a saúde e de segurança no ambiente de trabalho:<p align="justify">
		<b>1 - Iluminação</b> - Aumentar o nível de iluminação dos ambientes de trabalho de forma a adequá-los conforme NBR 5413 da ABNT, objetivando atender o laudo ergonômico se o tiver.<p align="justify">
		<b>2 - Ergonomia</b><br>a) Melhorar iluminação para atividade de digitação;<br>B) Colocação de Tela anti-reflexiva;<br>C) Descanso para os Pés, onde o funcionário passa a maior parte da sua jornada de trabalho sentado.<p align="justify">
		<b>3 - Condições sanitárias e de conforto nos locais de trabalho:</b><p align="justify">
		a) Limpeza e Ordem também fazem parte da segurança. Um bom serviço de conservação constitui uma parte importante de um programa eficiente de proteção contra acidentes e incêndio. Para tanto, é necessário evitar o acumulo de materiais combustíveis;<p align="justify">
		b) A empresa deverá ter água, em condição higiênica, fornecida por meio de copos individuais, ou bebedouros de jato inclinado e guarda - protetora, proibindo-se sua instalação em pias e lavatórios, e o uso de copos coletivos;<p align="justify">
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
<!---------------------23ª PÁGINA--------------->
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
		<p align="left">
		c) A limpeza do filtro do aparelho de ar condicionado deve ser periódica, em espaço de tempo equivalente há noventa dias, para assegurar boa qualidade do ar circulante;<p align="justify">
		d) Os gabinetes sanitários deverão possuir recipientes com tampa, para guarda de papéis servidos;<p align="justify">
		e) Os locais onde se encontrarem instalações sanitárias, deverão ser submetidos a processo permanente de higienização de sorte que sejam mantidos limpos e desprovidos de quaisquer odores, durante toda a jornada de trabalho.<p align="left">	

		<b>ANEXO 2</b><p align="left">
		<b>4 - Extintores de Incêndio</b><p align="justify">
		a) Redimensionar unidades extintoras, de forma que todas as dependências do estabelecimento sejam cobertas, em nível de raio de ação de 20m raio para empresas de grau de risco pequeno e 15m raio para empresas de riscos médio e grande, quanto do emprego de extintores em possíveis princípios de incêndio utilizar os de sua classe; sólidos extintores de Água; eletricidade Co² e inflamáveis Pós-químico.<p align="justify">
		b) Instalar unidade extintora, de tal forma que, permita o fácil acesso e seu pronto emprego, posicionando em local visível e em altura não superior à recomendada (altura máxima de 1,60m do piso), bem como desobstruindo e sinalizando adequadamente, quando for o caso, nunca colocá-los em passagem de acesso e debaixo de escadas, nem em vão de escadas, a mesma recomendação para os hidrantes.<p align="justify">
		c) As sinalizações para as unidades extintoras deveram obedecer ao que diz na NR 23.17.2 quanto às setas de sinalização e NR 23.17.4 da demarcação do piso.<p align="justify">
		d) As unidades extintoras deverão ter seus cartões de inspeção sempre em dia, e as suas recargas não poderão sofrer atrasos, bem como não efetuar recargas com empresas que não tenham registros junto aos órgãos competentes INMETRO, como vistoriado para efetuar testes hidrostáticos (re-teste do cilindro) e CONSERVADORA, pelo CBMERJ para efetuar recargas (manutenções periódicas anualmente).<p align="justify">
		e) Manter as fichas de inspeção de extintor atualizada, para quando solicitada pelo fiscal conforme exigência da NR 23.14.1 e inspecionado periodicamente conforme a NR 23.14.2.	
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
<!---------------------24ª PÁGINA--------------->
<?php 
for($a=0;$a<pg_num_rows($r_ativ);$a++){ // 1º LOOP
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
		<b>QUADRO DE PLANEJAMENTO E AÇÕES PARA A EXECUÇÃO DAS PENDÊNCIAS LEVANTADAS</b><br>
		<table align="center" width="699" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="435" align="center" class="fontepreta12">Quadro de Planejamento e Ações</td>
				<td width="264" align="center" class="fontepreta12">Metas e Prioridades Ano <b><?PHP echo date("Y", strtotime($row['data_criacao']));?></b> à <b><?PHP echo date("Y", strtotime($row['data_criacao']))+1;?></b></td>
			</tr>
<?PHP
      $epi = "select s.*, se.descricao, st.nome_setor
      from sugestao s, setor_epi se, setor st
      where (s.med_prev = se.id
	  AND s.cod_setor = st.cod_setor
	  AND se.cod_setor = s.cod_setor
      AND s.cod_setor = {$row_ativ[$a]['cod_setor']})
      AND s.plano_acao = 0
	  AND s.id_ppra = $_GET[id_ppra]";

      $result_epi = pg_query($epi);
      $epi_list = pg_fetch_all($result_epi);
	  
	  //CONSULTA PARA BUSCAR OS SETORES
	  $setor = "select nome_setor
      from setor
      where cod_setor = {$row_ativ[$a]['cod_setor']}";
	  $re = pg_query($connect, $setor);
	  $row_setor = pg_fetch_all($re);
?>
<tr>
	<td bgcolor="#CCCCCC" align="center" class="fontepreta14bold" colspan="2">Setor <?php echo $row_setor[0][nome_setor]; ?></td>
</tr>
<tr>
	<td align="center" class="fontepreta12">Descrição das Necessidades</td>
	<td align="center" class="fontepreta10">
		<table align="center" width="264" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
			<?PHP
			  $meses = array(" ", "J", "F", "M", "A", "M", "J", "J", "A", "S", "O", "N", "D");
			  //$sql = "SELECT * FROM cliente_setor";
			  $mesa = date("n", strtotime($row['data_criacao']));

			  for($x=1;$x<=12;$x++){
				 echo "<td width=22 align=center class=fontepreta10>{$meses[$mesa]}</td>";
				 $mesa++;
				 if($mesa >= 13)$mesa=1;
			  }
			?>
			</tr>
		</table>
	</td>
</tr>
<?PHP				  
      for($i=0;$i<pg_num_rows($result_epi);$i++){
            echo "<tr>";
			echo "	<td align=left class=fontepreta10>{$epi_list[$i][descricao]}</td>";
			echo "	<td align=center class=fontepreta12>";
			echo "		<table align=center width=262 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>";
			echo "			<tr>";

            $mesa = date("n", strtotime($row['data_criacao']));
            $mms = date("n", strtotime($epi_list[$i]['data']));
			
			for($y=1;$y<=12;$y++){
               if($mesa == $mms){
                  echo "<td width=20 align=center bgcolor=#000000 class=fontepreta10>X</td>";
               }else{
                  echo "<td width=20 align=center class=fontepreta10>&nbsp;</td>";
               }
               $mesa++;
               if($mesa >= 13)$mesa=1;
            }
			echo "			</tr>";
			echo "		</table>";
			echo "	</td>";
			echo "</tr>";
    }

$curso = "select Distinct(fc.descricao)
from sugestao s, funcao_curso fc, setor st
where s.med_prev = fc.id
AND fc.cod_curso = s.cod_funcao
AND s.cod_setor = st.cod_setor
AND s.cod_setor = {$row_ativ[$a]['cod_setor']}
and s.plano_acao = 0
AND s.id_ppra = $_GET[id_ppra]";

$result_curso = pg_query($curso);

      $curso_list = pg_fetch_all($result_curso);

      for($i=0;$i<pg_num_rows($result_curso);$i++){
            echo "<tr>";
			echo "	<td align=left class=fontepreta10>{$curso_list[$i][descricao]}</td>";
			echo "	<td align=center class=fontepreta12>";
			echo "		<table align=center width=262 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>";
			echo "			<tr>";

            $mesa = date("n", strtotime($row['data_criacao']));
            $mms = date("n", strtotime($curso_list[$i]['data']));

			for($y=1;$y<=12;$y++){
               if($mesa == $mms){
                  echo "<td width=20 align=center bgcolor=black class=fontepreta10>X</td>";
               }else{
                  echo "<td width=20 align=center class=fontepreta10>&nbsp;</td>";
               }
               $mesa++;
               if($mesa >= 13)$mesa=1;
            }
   			echo "			</tr>";
			echo "		</table>";
			echo "	</td>";
			echo "</tr>";
      }

$prog = "select s.*, sp.descricao, st.nome_setor
from sugestao s, setor_programas sp, setor st
where s.med_prev = sp.id
AND sp.cod_setor = s.cod_setor
AND s.cod_setor = st.cod_setor
AND s.cod_setor = {$row_ativ[$a]['cod_setor']}
and s.plano_acao = 0
AND s.id_ppra = $_GET[id_ppra]";

$result_prog = pg_query($prog);

      $prog_list = pg_fetch_all($result_prog);

      for($i=0;$i<pg_num_rows($result_prog);$i++){
            echo "<tr>";
			echo "	<td align=left class=fontepreta10>{$prog_list[$i][descricao]}</td>";
			echo "	<td align=center class=fontepreta12>";
			echo "		<table align=center width=262 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>";
			echo "			<tr>";

            $mesa = date("n", strtotime($row['data_criacao']));
            $mms = date("n", strtotime($prog_list[$i]['data']));

			for($y=1;$y<=12;$y++){
               if($mesa == $mms){
                  echo "<td width=20 align=center bgcolor=black class=fontepreta10>X</td>";
               }else{
                  echo "<td width=20 align=center class=fontepreta10>&nbsp;</td>";
               }
               $mesa++;
               if($mesa >= 13)$mesa=1;
            }
   			echo "			</tr>";
			echo "		</table>";
			echo "	</td>";
			echo "</tr>";
      }

$praio = "select c.*, t.*, st.nome_setor
from cliente_setor c, tipo_para_raio t, setor st
WHERE c.cod_setor = st.cod_setor
AND c.cod_setor = {$row_ativ[$a]['cod_setor']}
and c.tipo_para_raio_id = t.tipo_para_raio_id
and (t.tipo_para_raio_id = 2 or t.tipo_para_raio_id = 3)
AND c.id_ppra = $_GET[id_ppra]";

$result_praio = pg_query($praio);

      $praio_list = pg_fetch_all($result_praio);

      for($i=0;$i<pg_num_rows($result_praio);$i++){
			echo "<tr>";
			echo "	<td align=left class=fontepreta10>Manutenção no Para Raio Tipo {$praio_list[$i][tipo_para_raio]}</td>";
			echo "	<td align=center class=fontepreta12>";
			echo "		<table align=center width=262 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>";
			echo "			<tr>";

            $mesa = date("n", strtotime($row['data_criacao']));
            $mms = date("n", strtotime($praio_list[$i]['data_criacao']));

			for($y=1;$y<=12;$y++){
               if($mesa == $mms){
                  echo "<td width=20 align=center bgcolor=black class=fontepreta10>X</td>";
               }else{
                  echo "<td width=20 align=center class=fontepreta10>&nbsp;</td>";
               }
               $mesa++;
               if($mesa >= 13)$mesa=1;
            }
   			echo "			</tr>";
			echo "		</table>";
			echo "	</td>";
			echo "</tr>";
      }

$epc = "select epc_sugerido, nome_setor
from cliente_setor cs, setor s
where cs.cod_setor = s.cod_setor
AND cs.cod_setor = {$row_ativ[$a]['cod_setor']}
AND cs.id_ppra = $_GET[id_ppra]";

$result_epc = pg_query($epc);

      $epc_list = pg_fetch_all($result_epc);

      for($i=0;$i<pg_num_rows($result_epc);$i++){
	  	if($epc_list[$i][epc_sugerido] != ""){
			echo "<tr>";
			echo "	<td align=left class=fontepreta10>{$epc_list[$i][epc_sugerido]}</td>";
			echo "	<td align=center class=fontepreta12>";
			echo "		<table align=center width=262 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>";
			echo "			<tr>";

            $mesa = date("n", strtotime($row['data_criacao']));
            $mms = date("n", strtotime($epc_list['data_criacao']));

			for($y=1;$y<=12;$y++){
               if($mesa == $mms){
                  echo "<td width=20 align=center bgcolor=black class=fontepreta10>X</td>";
               }else{
                  echo "<td width=20 align=center class=fontepreta10>&nbsp;</td>";
               }
               $mesa++;
               if($mesa >= 13)$mesa=1;
            }
   			echo "			</tr>";
			echo "		</table>";
			echo "	</td>";
			echo "</tr>";
		}
	 }

$vistoria = "select cs.*, t.*, s.nome_setor
from cliente_setor cs, tipo_hidrante t, setor s
where cs.tipo_hidrante_id = t.tipo_hidrante_id
AND cs.cod_setor = s.cod_setor
AND cs.cod_setor = {$row_ativ[$a]['cod_setor']}
AND cs.tipo_hidrante_id <> 1
AND cs.id_ppra = $_GET[id_ppra]";

$result_vistoria = pg_query($vistoria);

      $vistoria_list = pg_fetch_all($result_vistoria);

      for($i=0;$i<pg_num_rows($result_vistoria);$i++){
			echo "<tr>";
			echo "	<td align=left class=fontepreta10>{$vistoria_list[$i][tipo_hidrante]}</td>";
			echo "	<td align=center class=fontepreta12>";
			echo "		<table align=center width=262 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>";
			echo "			<tr>";
            
			if(empty($vistoria_list[$i]['vistoria'])){
			   $d = explode("/", date("d/m/Y", strtotime($row['data_criacao']))); 
			   $vistoria_list[$i]['vistoria'] = date("Y-m-d", mktime(0,0,0,$d[1]+2,$d[0],$d[2]));
			}else{
			
			}
			
			$mesa = date("n", strtotime($row['data_criacao']));
            $mms = date("n", strtotime($vistoria_list[$i]['vistoria']));
			
			for($y=1;$y<=12;$y++){
               if($mesa == $mms){
                  echo "<td width=20 align=center bgcolor=black class=fontepreta10>X</td>";
               }else{
                  echo "<td width=20 align=center class=fontepreta10>&nbsp;</td>";
               }
               $mesa++;
               if($mesa >= 13)$mesa=1;
            }
   			echo "			</tr>";
			echo "		</table>";
			echo "	</td>";
			echo "</tr>";
      }
if($po == ""){	  
  $po = 0;
}

$portatil = "select cs.*, va.*, s.nome_setor
from cliente_setor cs, ventilacao_artificial va, setor s
where cs.cod_vent_art = va.cod_vent_art
AND cs.cod_setor = s.cod_setor
AND cs.cod_setor = {$row_ativ[$a]['cod_setor']}
and cs.dt_ventilacao is not null
AND cs.id_ppra = $_GET[id_ppra]";

$result_portatil = pg_query($portatil);

      $portatil_list = pg_fetch_all($result_portatil);
if(pg_num_rows($result_portatil) > 0){
      for($i=0;$i<pg_num_rows($result_portatil);$i++){
			echo "<tr>";
			echo "	<td align=left class=fontepreta10>Fazer a Higienização do {$portatil_list[$i][nome_vent_art]} e Fixar o Cartão de Controle</td>";
			echo "	<td align=center class=fontepreta12>";
			echo "		<table align=center width=262 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>";
			echo "			<tr>";

			$mesa = date("n", strtotime($row['data_criacao']));
            $mms = date("n", strtotime($portatil_list[$i]['dt_ventilacao']));
			
			$datas[0] = $mms;
			$datas[1] = $datas[0];
			for($i=0;$i<3;$i++){
			$datas[1]++;
			   if($datas[1] >12){
				  $datas[1] = 1;
			   }
			}
			$datas[2] = $datas[1];
			for($i=0;$i<3;$i++){
			$datas[2]++;
			   if($datas[2] >12){
				  $datas[2] = 1;
			   }
			}
			$datas[3] = $datas[2];
			for($i=0;$i<3;$i++){
			$datas[3]++;
			   if($datas[3] >12){
				  $datas[3] = 1;
			   }
			}

			for($y=1;$y<=12;$y++){
               if(in_array ($mesa, $datas)){
                  echo "<td width=20 align=center bgcolor=black class=fontepreta10>X</td>";
               }else{
                  echo "<td width=20 align=center class=fontepreta10>&nbsp;</td>";
               }
               $mesa++;
               if($mesa >= 13)$mesa=1;
            }
   			echo "			</tr>";
			echo "		</table>";
			echo "	</td>";
			echo "</tr>";
      }
	  
}

	/*$quimico = "select rs.*, ar.*, s.nome_setor
	from cliente_setor cs, risco_setor rs, agente_risco ar, setor s
	where cs.cod_cliente = rs.cod_cliente
	AND cs.cod_setor = rs.cod_setor
	AND rs.cod_setor = s.cod_setor
	AND rs.cod_agente_risco = ar.cod_agente_risco
	AND cs.cod_setor = {$row_ativ[$a]['cod_setor']}
	AND (rs.cod_agente_risco = 22 or rs.cod_agente_risco = 32)
	AND cs.id_ppra = rs.id_ppra
	AND cs.id_ppra = $_GET[id_ppra]";
	
	$result_quimico = pg_query($quimico);
	
	$quimico_list = pg_fetch_all($result_quimico);

      for($i=0;$i<pg_num_rows($result_quimico);$i++){
			echo "<tr>";
			echo "	<td align=left class=fontepreta10>Colocar Lava Olhos</td>";
			echo "	<td align=center class=fontepreta12>";
			echo "		<table align=center width=262 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>";
			echo "			<tr>";

			$mesa = date("n", strtotime($row['data_criacao']));
            $mms = date("n", strtotime($portatil_list[$i]['data_criacao']));
			
			for($y=1;$y<=12;$y++){
               if($mesa == $mms){
                  echo "<td width=20 align=center bgcolor=black class=fontepreta10>&nbsp;</td>";
               }else{
                  echo "<td width=20 align=center class=fontepreta10>&nbsp;</td>";
               }
               $mesa++;
               if($mesa >= 13)$mesa=1;
            }
   			echo "			</tr>";
			echo "		</table>";
			echo "	</td>";
			echo "</tr>";
      }*/

/*if($al == $po){
$gripal = "select *
from cliente_setor
where cod_cliente = $cliente
AND cod_setor = {$row_ativ[$a]['cod_setor']}
and gripal = '' 
AND EXTRACT(year FROM data_criacao) = {$ano}";

$result_gripal = pg_query($gripal);

      $gripal_list = pg_fetch_all($result_gripal);

      for($i=0;$i<pg_num_rows($result_gripal);$i++){
			echo "<tr>";
			echo "	<td align=left class=fontepreta10>Campanha de Vacinação Antigripal</td>";
			echo "	<td align=center class=fontepreta12>";
			echo "		<table align=center width=262 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>";
			echo "			<tr>";

            $mesa = date("n", strtotime($row['data_criacao']));
            $mms = date("n", strtotime($gripal_list[$i]['data_criacao']));

			for($y=1;$y<=12;$y++){
                             //echo "<td width=25 align=center class=fontepreta12>{$meses[$mesa]}</td>";
               if($mesa == $mms){
                  echo "<td width=20 align=center bgcolor=black class=fontepreta10>&nbsp;</td>";
               }else{
                  echo "<td width=20 align=center class=fontepreta10>&nbsp;</td>";
               }
               $mesa++;
               if($mesa >= 13)$mesa=1;
            }
   			echo "			</tr>";
			echo "		</table>";
			echo "	</td>";
			echo "</tr>";
      }

$rabica = "select *
from cliente_setor
where cod_cliente = $cliente
AND cod_setor = {$row_ativ[$a]['cod_setor']}
and rabica = '' 
AND EXTRACT(year FROM data_criacao) = {$ano}";

$result_rabica = pg_query($rabica);
      $rabica_list = pg_fetch_all($result_rabica);

      for($i=0;$i<pg_num_rows($result_rabica);$i++){
			echo "<tr>";
			echo "	<td align=left class=fontepreta10>Campanha de Vacinação Antirabica</td>";
			echo "	<td align=center class=fontepreta12>";
			echo "		<table align=center width=262 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>";
			echo "			<tr>";

            $mesa = date("n", strtotime($row['data_criacao']));
            $mms = date("n", strtotime($rabica_list[$i]['data_criacao']));

			for($y=1;$y<=12;$y++){
                             //echo "<td width=25 align=center class=fontepreta12>{$meses[$mesa]}</td>";
               if($mesa == $mms){
                  echo "<td width=20 align=center bgcolor=black class=fontepreta10>&nbsp;</td>";
               }else{
                  echo "<td width=20 align=center class=fontepreta10>&nbsp;</td>";
               }
               $mesa++;
               if($mesa >= 13)$mesa=1;
            }
   			echo "			</tr>";
			echo "		</table>";
			echo "	</td>";
			echo "</tr>";
      }
	
$tanica = "select *
from cliente_setor
where cod_cliente = $cliente
AND cod_setor = {$row_ativ[$a]['cod_setor']}
and tanica = '' 
AND EXTRACT(year FROM data_criacao) = {$ano}";

$result_tanica = pg_query($tanica);

      $tanica_list = pg_fetch_all($result_tanica);

      for($i=0;$i<pg_num_rows($result_tanica);$i++){
			echo "<tr>";
			echo "	<td align=left class=fontepreta10>Campanha de Vacinação Antitetânica</td>";
			echo "	<td align=center class=fontepreta12>";
			echo "		<table align=center width=262 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>";
			echo "			<tr>";

            $mesa = date("n", strtotime($row['data_criacao']));
            $mms = date("n", strtotime($tanica_list[$i]['data_criacao']));

			for($y=1;$y<=12;$y++){
                             //echo "<td width=25 align=center class=fontepreta12>{$meses[$mesa]}</td>";
               if($mesa == $mms){
                  echo "<td width=20 align=center bgcolor=black class=fontepreta10>&nbsp;</td>";
               }else{
                  echo "<td width=20 align=center class=fontepreta10>&nbsp;</td>";
               }
               $mesa++;
               if($mesa >= 13)$mesa=1;
            }
   			echo "			</tr>";
			echo "		</table>";
			echo "	</td>";
			echo "</tr>";
      }

	}

$po = 1;*/

$ventilador = "select cs.*, t.*, s.nome_setor
from cliente_setor cs, ventilacao_artificial t, setor s
where cs.cod_vent_art = t.cod_vent_art
AND cs.cod_setor = s.cod_setor
AND cs.cod_setor = {$row_ativ[$a]['cod_setor']}
and (t.cod_vent_art = 7 or t.cod_vent_art = 8 or t.cod_vent_art = 9 or t.cod_vent_art = 10)
AND cs.id_ppra = $_GET[id_ppra]";

$result_ventilador = pg_query($ventilador);

      $ventilador_list = pg_fetch_all($result_ventilador);

      for($i=0;$i<pg_num_rows($result_ventilador);$i++){
	  
            echo "<tr>";
			echo "	<td align=left class=fontepreta10>Fazer Limpeza Mecânica e Fixar Cartão de Higienização no {$ventilador_list[$i][nome_vent_art]}</td>";
			echo "	<td align=center class=fontepreta12>";
			echo "		<table align=center width=262 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>";
			echo "			<tr>";

            $mesa = date("n", strtotime($row['data_criacao']));
            $mms = date("n", strtotime($ventilador_list[$i]['data_criacao']));

			$datas[0] = $mms;
			$datas[1] = $datas[0];
			for($i=0;$i<3;$i++){
			$datas[1]++;
			   if($datas[1] >12){
				  $datas[1] = 1;
			   }
			}
			$datas[2] = $datas[1];
			for($i=0;$i<3;$i++){
			$datas[2]++;
			   if($datas[2] >12){
				  $datas[2] = 1;
			   }
			}
			$datas[3] = $datas[2];
			for($i=0;$i<3;$i++){
			$datas[3]++;
			   if($datas[3] >12){
				  $datas[3] = 1;
			   }
			}

			for($y=1;$y<=12;$y++){
                             //echo "<td width=25 align=center class=fontepreta12>{$meses[$mesa]}</td>";
               if(in_array ($mesa, $datas)){
                  echo "<td width=20 align=center bgcolor=black class=fontepreta10>X</td>";
               }else{
                  echo "<td width=20 align=center class=fontepreta10>&nbsp;</td>";
               }
               $mesa++;
               if($mesa >= 13)$mesa=1;
            }
   			echo "			</tr>";
			echo "		</table>";
			echo "	</td>";
			echo "</tr>";
      }

$clima = "select cs.*, t.*
from cliente_setor cs, ventilacao_artificial t
where cs.cod_vent_art = t.cod_vent_art
AND cs.cod_setor = {$row_ativ[$a]['cod_setor']}
and t.cod_vent_art = 12
AND cs.id_ppra = $_GET[id_ppra]";

$result_clima = pg_query($clima);

      $clima_list = pg_fetch_all($result_clima);

      for($i=0;$i<pg_num_rows($result_clima);$i++){
	  
            echo "<tr>";
			echo "	<td align=left class=fontepreta10>Fazer Limpeza do {$clima_list[$i][nome_vent_art]} e Deixar Arquivado Cartão de Higienização</td>";
			echo "	<td align=center class=fontepreta12>";
			echo "		<table align=center width=262 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>";
			echo "			<tr>";

            $mesa = date("n", strtotime($row['data_criacao']));
            $mms = date("n", strtotime($clima_list[$i]['data_criacao']));

			$datas[0] = $mms;
			$datas[1] = $datas[0];
			for($i=0;$i<3;$i++){
			$datas[1]++;
			   if($datas[1] >12){
				  $datas[1] = 1;
			   }
			}
			$datas[2] = $datas[1];
			for($i=0;$i<3;$i++){
			$datas[2]++;
			   if($datas[2] >12){
				  $datas[2] = 1;
			   }
			}
			$datas[3] = $datas[2];
			for($i=0;$i<3;$i++){
			$datas[3]++;
			   if($datas[3] >12){
				  $datas[3] = 1;
			   }
			}

			for($y=1;$y<=12;$y++){
                             //echo "<td width=25 align=center class=fontepreta12>{$meses[$mesa]}</td>";
               if(in_array ($mesa, $datas)){
                  echo "<td width=20 align=center bgcolor=black class=fontepreta10>X</td>";
               }else{
                  echo "<td width=20 align=center class=fontepreta10>&nbsp;</td>";
               }
               $mesa++;
               if($mesa >= 13)$mesa=1;
            }
   			echo "			</tr>";
			echo "		</table>";
			echo "	</td>";
			echo "</tr>";
      }

$carpete = "select cs.*, p.*, s.nome_setor
from cliente_setor cs, piso p, setor s
where cs.cod_piso = p.cod_piso
AND cs.cod_setor = s.cod_setor
AND cs.cod_setor = {$row_ativ[$a]['cod_setor']}
AND p.cod_piso = '17'
AND cs.id_ppra = $_GET[id_ppra]";

$result_carpete = pg_query($connect, $carpete) or die
	("erro na query:$carpete==>".pg_last_error($connect));

      $carpete_list = pg_fetch_all($result_carpete);

      for($i=0;$i<pg_num_rows($result_carpete);$i++){
	  
            echo "<tr>";
			echo "	<td align=left class=fontepreta10>Aplicar Hignifugação nos {$carpete_list[$i][nome_piso]}s</td>";
			echo "	<td align=center class=fontepreta12>";
			echo "		<table align=center width=262 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>";
			echo "			<tr>";

            $mesa = date("n", strtotime($row['data_criacao']));
            $mms = date("n", strtotime($carpete_list[$i]['data_criacao']));

			for($y=1;$y<=12;$y++){
                             //echo "<td width=25 align=center class=fontepreta12>{$meses[$mesa]}</td>";
               if($mesa == $mms){
                  echo "<td width=20 align=center bgcolor=black class=fontepreta10>X</td>";
               }else{
                  echo "<td width=20 align=center class=fontepreta10>&nbsp;</td>";
               }
               $mesa++;
               if($mesa >= 13)$mesa=1;
            }
   			echo "			</tr>";
			echo "		</table>";
			echo "	</td>";
			echo "</tr>";
      }

$extintor = "select cs.*, e.*, s.nome_setor
from cliente_setor cs, extintor e, setor s
where cs.cod_cliente = e.cod_cliente
AND cs.cod_setor =  s.cod_setor
AND s.cod_setor = e.cod_setor
AND cs.id_ppra = e.id_ppra
AND cs.cod_setor = {$row_ativ[$a]['cod_setor']}
AND e.extintor = 'sugerido'
AND cs.id_ppra = $_GET[id_ppra]";

$result_extintor = pg_query($connect, $extintor) or die
	("erro na query:$extintor==>".pg_last_error($connect));

      $extintor_list = pg_fetch_all($result_extintor);

      for($i=0;$i<pg_num_rows($result_extintor);$i++){
	  
            echo "<tr>";
			echo "	<td align=left class=fontepreta10>Instalar {$extintor_list[$i][tipo_extintor]}</td>";
			echo "	<td align=center class=fontepreta12>";
			echo "		<table align=center width=262 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>";
			echo "			<tr>";

            $mesa = date("n", strtotime($row['data_criacao']));
            $mms = date("n", strtotime($extintor_list[$i]['data_criacao']));

			for($y=1;$y<=12;$y++){
                             //echo "<td width=25 align=center class=fontepreta12>{$meses[$mesa]}</td>";
               if($mesa == $mms){
                  echo "<td width=20 align=center bgcolor=black class=fontepreta10>X</td>";
               }else{
                  echo "<td width=20 align=center class=fontepreta10>&nbsp;</td>";
               }
               $mesa++;
               if($mesa >= 13)$mesa=1;
            }
   			echo "			</tr>";
			echo "		</table>";
			echo "	</td>";
			echo "</tr>";
      }
	  
$portatil2 = "select cs.*, tv.*, s.nome_setor
from cliente_setor cs, ventilacao_artificial tv, setor s
where cs.cod_vent_art = tv.cod_vent_art
AND cs.cod_setor = s.cod_setor
AND (cs.higiene = 'não' or cs.higiene = 'nao')
AND cs.id_ppra = $_GET[id_ppra]";

$result_portatil2 = pg_query($connect, $portatil2) or die
	("erro na query:$portatil2==>".pg_last_error($connect));

      $portatil2_list = pg_fetch_all($result_portatil2);

      for($i=0;$i<pg_num_rows($result_portatil2);$i++){
			echo "<tr>";
			echo "	<td align=left class=fontepreta10>Sinalizar as Partes Baixas do {$portatil2_list[$i][nome_vent_art]} (Zebrado em Alerta)</td>";
			echo "	<td align=center class=fontepreta12>";
			echo "		<table align=center width=262 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>";
			echo "			<tr>";

			$mesa = date("n", strtotime($row['data_criacao']));
            $mms = date("n", strtotime($portatil2_list[$i]['dt_ventilacao']));
			
			for($y=1;$y<=12;$y++){
               if($mesa == $mms){
                  echo "<td width=20 align=center bgcolor=black class=fontepreta10>X</td>";
               }else{
                  echo "<td width=20 align=center class=fontepreta10>&nbsp;</td>";
               }
               $mesa++;
               if($mesa >= 13)$mesa=1;
            }
   			echo "			</tr>";
			echo "		</table>";
			echo "	</td>";
			echo "</tr>";
      }

$primaria = "select cs.*, t.*
from cliente_setor cs, ventilacao_artificial t
where cs.cod_vent_art = t.cod_vent_art
and t.cod_vent_art = 5
AND cs.cod_setor = {$row_ativ[$a]['cod_setor']}
AND cs.id_ppra = $_GET[id_ppra]";

$result_primaria = pg_query($connect, $primaria) or die
	("erro na query:$primaria==>".pg_last_error($connect));

      $primaria_list = pg_fetch_all($result_primaria);

      for($i=0;$i<pg_num_rows($result_primaria);$i++){
	  
            echo "<tr>";
			echo "	<td align=left class=fontepreta10>Fazer Higienização da Casa de Máquina(Primária)</td>";
			echo "	<td align=center class=fontepreta12>";
			echo "		<table align=center width=262 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>";
			echo "			<tr>";

            $mesa = date("n", strtotime($row['data_criacao']));
            $mms = date("n", strtotime($primaria_list[$i]['dt_ventilacao']));

			$datas = array();
			$datas[0] = $mms;
			$datas[1] = $datas[0];
			for($i=0;$i<6;$i++){
			$datas[1]++;
			   if($datas[1] >12){
				  $datas[1] = 1;
			   }
			}

			for($y=1;$y<=12;$y++){
               if(in_array ($mesa, $datas)){
                  echo "<td width=20 align=center bgcolor=black class=fontepreta10>X</td>";
               }else{
                  echo "<td width=20 align=center class=fontepreta10>&nbsp;</td>";
               }
               $mesa++;
               if($mesa >= 13)$mesa=1;
            }
   			echo "			</tr>";
			echo "		</table>";
			echo "	</td>";
			echo "</tr>";
      }

$secundaria = "select cs.*, t.*
from cliente_setor cs, ventilacao_artificial t
where cs.cod_vent_art = t.cod_vent_art
and t.cod_vent_art = 5
AND cs.cod_setor = {$row_ativ[$a]['cod_setor']}
AND cs.id_ppra = $_GET[id_ppra]";

$result_secundaria = pg_query($connect, $secundaria) or die
	("erro na query:$secundaria==>".pg_last_error($connect));

      $secundaria_list = pg_fetch_all($result_secundaria);

      for($i=0;$i<pg_num_rows($result_secundaria);$i++){
	  
            echo "<tr>";
			echo "	<td align=left class=fontepreta10>Fazer Higienização Mecânica do Duto de Distribuição de Ar(Secundária)</td>";
			echo "	<td align=center class=fontepreta12>";
			echo "		<table align=center width=262 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>";
			echo "			<tr>";

            $mesa = date("n", strtotime($row['data_criacao']));
            $mms = date("n", strtotime($secundaria_list[$i]['dt_ventilacao']));

			for($y=1;$y<=12;$y++){
               if($mesa == $mms){
                  echo "<td width=20 align=center bgcolor=black class=fontepreta10>X</td>";
               }else{
                  echo "<td width=20 align=center class=fontepreta10>&nbsp;</td>";
               }
               $mesa++;
               if($mesa >= 13)$mesa=1;
            }
   			echo "			</tr>";
			echo "		</table>";
			echo "	</td>";
			echo "</tr>";
      }

$tercearia = "select cs.*, t.*
from cliente_setor cs, ventilacao_artificial t
where cs.cod_vent_art = t.cod_vent_art
and t.cod_vent_art = 5
AND cs.cod_setor = {$row_ativ[$a]['cod_setor']}
AND cs.id_ppra = $_GET[id_ppra]";

$result_tercearia = pg_query($connect, $tercearia) or die
	("erro na query:$primaria==>".pg_last_error($connect));

      $tercearia_list = pg_fetch_all($result_tercearia);

      for($i=0;$i<pg_num_rows($result_tercearia);$i++){
	  
            echo "<tr>";
			echo "	<td align=left class=fontepreta10>Fazer Higienização dos Terminais de Duto de Ventilação(Terceária)</td>";
			echo "	<td align=center class=fontepreta12>";
			echo "		<table align=center width=262 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>";
			echo "			<tr>";

            $mesa = date("n", strtotime($row['data_criacao']));
            $mms = date("n", strtotime($tercearia_list[$i]['dt_ventilacao']));

			$datas[0] = $mms;
			$datas[1] = $datas[0];
			for($i=0;$i<3;$i++){
			$datas[1]++;
			   if($datas[1] >12){
				  $datas[1] = 1;
			   }
			}
			$datas[2] = $datas[1];
			for($i=0;$i<3;$i++){
			$datas[2]++;
			   if($datas[2] >12){
				  $datas[2] = 1;
			   }
			}
			$datas[3] = $datas[2];
			for($i=0;$i<3;$i++){
			$datas[3]++;
			   if($datas[3] >12){
				  $datas[3] = 1;
			   }
			}

			for($y=1;$y<=12;$y++){
               if(in_array ($mesa, $datas)){
                  echo "<td width=20 align=center bgcolor=black class=fontepreta10>X</td>";
               }else{
                  echo "<td width=20 align=center class=fontepreta10>&nbsp;</td>";
               }
               $mesa++;
               if($mesa >= 13)$mesa=1;
            }
   			echo "			</tr>";
			echo "		</table>";
			echo "	</td>";
			echo "</tr>";
      }

$s_dutos = "select cs.*, t.*
from cliente_setor cs, ventilacao_artificial t
where cs.cod_vent_art = t.cod_vent_art
and t.cod_vent_art = 6
AND cs.id_ppra = $_GET[id_ppra]";

$result_s_dutos = pg_query($connect, $s_dutos) or die
	("erro na query:$s_dutos==>".pg_last_error($connect));

      $s_dutos_list = pg_fetch_all($result_s_dutos);

      for($i=0;$i<pg_num_rows($result_s_dutos);$i++){
	  
            echo "<tr>";
			echo "	<td align=left class=fontepreta10>Fazer Higienização da Casa de Máquina(Primária)</td>";
			echo "	<td align=center class=fontepreta12>";
			echo "		<table align=center width=262 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>";
			echo "			<tr>";

            $mesa = date("n", strtotime($row['data_criacao']));
            $mms = date("n", strtotime($s_dutos_list[$i]['dt_ventilacao']));

			$datas = array();
			$datas[0] = $mms;
			$datas[1] = $datas[0];
			for($i=0;$i<6;$i++){
			$datas[1]++;
			   if($datas[1] >12){
				  $datas[1] = 1;
			   }
			}

			for($y=1;$y<=12;$y++){
               if(in_array ($mesa, $datas)){
                  echo "<td width=20 align=center bgcolor=black class=fontepreta10>X</td>";
               }else{
                  echo "<td width=20 align=center class=fontepreta10>&nbsp;</td>";
               }
               $mesa++;
               if($mesa >= 13)$mesa=1;
            }
   			echo "			</tr>";
			echo "		</table>";
			echo "	</td>";
			echo "</tr>";
      }
	  
$placas = "select pp.descricao, pp.cod_cliente, pp.cod_setor
      from cliente_setor c, setor s, ppra_placas pp
      where pp.cod_cliente = c.cod_cliente
	  AND c.cod_setor = pp.cod_setor
	  AND s.cod_setor = pp.cod_setor
	  AND pp.cod_setor = {$row_ativ[$a]['cod_setor']}
	  AND pp.id_ppra = c.id_ppra
	  AND c.id_ppra = $_GET[id_ppra]";

$result_placas = pg_query($placas);

      $placas_list = pg_fetch_all($result_placas);

      for($i=0;$i<pg_num_rows($result_placas);$i++){
			echo "<tr>";
			echo "	<td align=left class=fontepreta10>{$placas_list[$i][descricao]}</td>";
			echo "	<td align=center class=fontepreta12>";
			echo "		<table align=center width=262 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>";
			echo "			<tr>";

            $mesa = date("n", strtotime($row['data_criacao']));
            $mms = date("n", strtotime($placas_list[$i]['data_criacao']));

			for($y=1;$y<=12;$y++){
               if($mesa == $mms){
                  echo "<td width=20 align=center bgcolor=black class=fontepreta10>X</td>";
               }else{
                  echo "<td width=20 align=center class=fontepreta10>&nbsp;</td>";
               }
               $mesa++;
               if($mesa >= 13)$mesa=1;
            }
   			echo "			</tr>";
			echo "		</table>";
			echo "	</td>";
			echo "</tr>";
      }

?>
		</table>
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
<!---------------------24ª PÁGINA--------------->
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
		<b>CRONOGRAMA E PLANO DE AÇÃO DO DOCUMENTO BASE/ANO <?php if($row[data_criacao]){
																	 echo date("Y", strtotime($row[data_criacao]));
																	 } ?></b><p>
		<b>EMPRESA: <?php echo $row[razao_social]; ?></b><p>
		<table align="center" width="699" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="399" align="center" class="fontepreta12">Quadro de Planejamento e Ações</td>
				<td width="300" align="center" class="fontepreta12">Metas e Prioridades Ano <b><?PHP echo date("Y", strtotime($row['data_criacao']));?></b> à <b><?PHP echo date("Y", strtotime($row['data_criacao']))+1;?></b></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">Descrição das Necessidades</td>
				<td align="center" class="fontepreta12">
					<table align="center" width="300" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
						<tr>
						<?PHP
                          $meses1 = array(" ", "J", "F", "M", "A", "M", "J", "J", "A", "S", "O", "N", "D");
                          $mesa1 = date("n", strtotime($row['data_criacao']));

                          for($x=1;$x<=12;$x++){
                             echo "<td width=25 align=center class=fontepreta12>{$meses1[$mesa1]}</td>";
                             $mesa1++;
                             if($mesa1 >= 13)$mesa1=1;
                          }
                        ?>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">Inspeção tecnica preliminar</td>
				<td align="center" class="fontepreta12">
					<table align="center" width="298" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
<?php
$inspecao = "select *
from cliente_setor
where cod_setor = {$row_ativ[0]['cod_setor']}
AND id_ppra = $_GET[id_ppra]";

$result_inspecao = pg_query($connect, $inspecao) or die
	("erro na query:$inspecao==>".pg_last_error($connect));

$row_inspecao = pg_fetch_array($result_inspecao);

$mesa1 = date("n", strtotime($row['data_criacao']));
$mms1 = date("n", strtotime($row_inspecao['data_criacao']));

$datas[0] = $mms1;
$datas[3] = $mms1;
$datas[1] = $datas[0];
for($i=0;$i<4;$i++){
$datas[1]++;
   if($datas[1] >12){
      $datas[1] = 1;
   }
}
$datas[2] = $datas[1];
for($i=0;$i<4;$i++){
$datas[2]++;
   if($datas[2] >12){
      $datas[2] = 1;
   }
}

echo "<tr>";
	for($y=1;$y<=12;$y++){
	   if(in_array($mesa1, $datas)){
		  echo "<td width=20 align=center bgcolor=black class=fontepreta12>X</td>";
	   }else{
		  echo "<td width=20 align=center class=fontepreta12>&nbsp;</td>";
	   }
	   $mesa1++;
	   if($mesa1 >= 13)$mesa1=1;
	}
	echo "</tr>";
?>
					</table>
				</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">Elaboração do programa</td>
				<td align="center" class="fontepreta12">
					<table align="center" width="298" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
<?php
$elaboracao = "select *
from cliente_setor
where cod_setor = {$row_ativ[0]['cod_setor']}
AND id_ppra = $_GET[id_ppra]";

$result_elaboracao = pg_query($connect, $elaboracao) or die
	("erro na query:$elaboracao==>".pg_last_error($connect));

$row_elaboracao = pg_fetch_array($result_elaboracao);

$mesa1 = date("n", strtotime($row['data_criacao']));
$mms1 = date("n", strtotime($row_elaboracao['data_criacao']));

echo "<tr>";
	for($y=1;$y<=12;$y++){
	   if($mesa1 == $mms1){
		  echo "<td width=20 align=center bgcolor=black class=fontepreta12>X</td>";
	   }else{
		  echo "<td width=20 align=center class=fontepreta12>&nbsp;</td>";
	   }
	   $mesa1++;
	   if($mesa1 >= 13)$mesa1=1;
	}
	echo "</tr>";
?>
					</table>
				</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">Inspeção dos postos de trabalho</td>
				<td align="center" class="fontepreta12">
					<table align="center" width="298" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
<?php
$posto = "select *
from cliente_setor
where cod_setor = {$row_ativ[0]['cod_setor']}
AND id_ppra = $_GET[id_ppra]";

$result_posto = pg_query($connect, $posto) or die
	("erro na query:$posto==>".pg_last_error($connect));

$row_posto = pg_fetch_array($result_posto);

$mesa1 = date("n", strtotime($row['data_criacao']));
$mms1 = date("n", strtotime($row_posto['data_criacao']));

$datas[0] = $mms1;
$datas[1] = $datas[0];
for($i=0;$i<4;$i++){
$datas[1]++;
   if($datas[1] >12){
      $datas[1] = 1;
   }
}
$datas[2] = $datas[1];
for($i=0;$i<4;$i++){
$datas[2]++;
   if($datas[2] >12){
      $datas[2] = 1;
   }
}

echo "<tr>";
	for($y=1;$y<=12;$y++){
	   if(in_array($mesa1, $datas)){
		  echo "<td width=20 align=center bgcolor=black class=fontepreta12>X</td>";
	   }else{
		  echo "<td width=20 align=center class=fontepreta12>&nbsp;</td>";
	   }
	   $mesa1++;
	   if($mesa1 >= 13)$mesa1=1;
	}
	echo "</tr>";
?>
					</table>
				</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">Avaliação do programa</td>
				<td align="center" class="fontepreta12">
					<table align="center" width="298" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
<?php
$avaliacao = "select *
from cliente_setor
where cod_setor = {$row_ativ[0]['cod_setor']}
AND id_ppra = $_GET[id_ppra]";

$result_avaliacao = pg_query($connect, $avaliacao) or die
	("erro na query:$avaliacao==>".pg_last_error($connect));

$row_avaliacao = pg_fetch_array($result_avaliacao);

$mesa1 = date("n", strtotime($row['data_criacao']));
$mms1 = date("n", strtotime($row_avaliacao['data_criacao']));

echo "<tr>";
	for($y=1;$y<=12;$y++){
	   if($mesa1 == $mms1){
		  echo "<td width=20 align=center bgcolor=black class=fontepreta12>X</td>";
	   }else{
		  echo "<td width=20 align=center class=fontepreta12>&nbsp;</td>";
	   }
	   $mesa1++;
	   if($mesa1 >= 13)$mesa1=1;
	}
	echo "</tr>";
?>
					</table>
				</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">Inspeção quanto a higiene da água</td>
				<td align="center" class="fontepreta12">
					<table align="center" width="298" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
<?php
$agua = "select *
from cliente_setor
where cod_setor = {$row_ativ[0]['cod_setor']}
AND id_ppra = $_GET[id_ppra]";

$result_agua = pg_query($connect, $agua) or die
	("erro na query:$agua==>".pg_last_error($connect));

$row_agua = pg_fetch_array($result_agua);

$mesa1 = date("n", strtotime($row['data_criacao']));
$mms1 = date("n", strtotime($row_agua['data_criacao']));

$datas = array();
$datas[0] = $mms1;
$datas[1] = $datas[0];
for($i=0;$i<6;$i++){
$datas[1]++;
   if($datas[1] >12){
      $datas[1] = 1;
   }
}

echo "<tr>";
	for($y=1;$y<=12;$y++){
	   if(in_array($mesa1, $datas)){
		  echo "<td width=20 align=center bgcolor=black class=fontepreta12>X</td>";
	   }else{
		  echo "<td width=20 align=center class=fontepreta12>&nbsp;</td>";
	   }
	   $mesa1++;
	   if($mesa1 >= 13)$mesa1=1;
	}
	echo "</tr>";
?>
					</table>
				</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">Qualificação do agente</td>
				<td align="center" class="fontepreta12">
					<table align="center" width="298" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
<?php
$agente = "select *
from cliente_setor
where cod_setor = {$row_ativ[0]['cod_setor']}
AND id_ppra = $_GET[id_ppra]";

$result_agente = pg_query($connect, $agente) or die
	("erro na query:$agente==>".pg_last_error($connect));

$row_agente = pg_fetch_array($result_agente);

$mesa1 = date("n", strtotime($row['data_criacao']));
$mms1 = date("n", strtotime($row_agente['data_criacao']));

$datas = array();
$datas[0] = $mms1;
for($i=0;$i<7;$i++){
$datas[0]++;
   if($datas[0] >12){
      $datas[0] = 1;
   }
}

echo "<tr>";
	for($y=1;$y<=12;$y++){
	   if(in_array($mesa1, $datas)){
		  echo "<td width=20 align=center bgcolor=black class=fontepreta12>X</td>";
	   }else{
		  echo "<td width=20 align=center class=fontepreta12>&nbsp;</td>";
	   }
	   $mesa1++;
	   if($mesa1 >= 13)$mesa1=1;
	}
	echo "</tr>";
?>
					</table>
				</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">Insp. dos equip. contra incêndio</td>
				<td align="center" class="fontepreta12">
					<table align="center" width="298" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
<?php
$incendio = "select *
from cliente_setor
where cod_setor = {$row_ativ[0]['cod_setor']}
AND id_ppra = $_GET[id_ppra]";

$result_incendio = pg_query($connect, $incendio) or die
	("erro na query:$incendio==>".pg_last_error($connect));

$row_incendio = pg_fetch_array($result_incendio);

$mesa1 = date("n", strtotime($row['data_criacao']));
$mms1 = date("n", strtotime($row_incendio['data_criacao']));

$datas[0] = $mms1;
$datas[1] = $datas[0];
for($i=0;$i<4;$i++){
$datas[1]++;
   if($datas[1] >12){
      $datas[1] = 1;
   }
}
$datas[2] = $datas[1];
for($i=0;$i<4;$i++){
$datas[2]++;
   if($datas[2] >12){
      $datas[2] = 1;
   }
}

echo "<tr>";
	for($y=1;$y<=12;$y++){
	   if(in_array($mesa1, $datas)){
		  echo "<td width=20 align=center bgcolor=black class=fontepreta12>X</td>";
	   }else{
		  echo "<td width=20 align=center class=fontepreta12>&nbsp;</td>";
	   }
	   $mesa1++;
	   if($mesa1 >= 13)$mesa1=1;
	}
	echo "</tr>";
?>
					</table>
				</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">Implantação das recomendações</td>
				<td align="center" class="fontepreta12">
					<table align="center" width="298" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
<?php
$reco = "select *
from cliente_setor
where cod_setor = {$row_ativ[0]['cod_setor']}
AND id_ppra = $_GET[id_ppra]";

$result_reco = pg_query($connect, $reco) or die
	("erro na query:$reco==>".pg_last_error($connect));

$row_reco = pg_fetch_array($result_reco);

$mesa1 = date("n", strtotime($row['data_criacao']));
$mms1 = date("n", strtotime($row_reco['data_criacao']));

$datas = array();
$datas[0] = $mms1;
for($i=0;$i<4;$i++){
$datas[0]++;
   if($datas[0] >12){
      $datas[0] = 1;
   }
}

echo "<tr>";
	for($y=1;$y<=12;$y++){
	   if(in_array($mesa1, $datas)){
		  echo "<td width=20 align=center bgcolor=black class=fontepreta12>X</td>";
	   }else{
		  echo "<td width=20 align=center class=fontepreta12>&nbsp;</td>";
	   }
	   $mesa1++;
	   if($mesa1 >= 13)$mesa1=1;
	}
	echo "</tr>";
?>
					</table>
				</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">Renovação do programa</td>
				<td align="center" class="fontepreta12">
					<table align="center" width="298" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
<?php
$programa = "select *
from cliente_setor
where cod_setor = {$row_ativ[0]['cod_setor']}
AND id_ppra = $_GET[id_ppra]";

$result_programa = pg_query($connect, $programa) or die
	("erro na query:$programa==>".pg_last_error($connect));

$row_programa = pg_fetch_array($result_programa);

$mesa1 = date("n", strtotime($row['data_criacao']));
$mms1 = date("n", strtotime($row_programa['data_avaliacao']));

$datas = array();
$datas[0] = $mms1;

$datas[0] = date("n", mktime(0,0,0,$mmsl+12,1,2009));

echo "<tr>";
	for($y=1;$y<=12;$y++){
	   if(in_array($mesa1, $datas)){
		  echo "<td width=20 align=center bgcolor=black class=fontepreta12>X</td>";
	   }else{
		  echo "<td width=20 align=center class=fontepreta12>&nbsp;</td>";
	   }
	   $mesa1++;
	   if($mesa1 >= 13)$mesa1=1;
	}
	echo "</tr>";
?>
					</table>
				</td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
<!---------------------25ª PÁGINA--------------->
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
		<table align="center" width="550" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center"><h1>6ª FASE<p><br>A<p>N<p>E<p>X<P>O<P>S</h1></td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
<!---------------------26ª PÁGINA--------------->
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
				<td align="left" class="fontepreta12bold">MODELO DE FICHA DE INSPEÇÃO DE EXTINTOR</td>
			</tr>
		</table>
		<table align="center" width="600" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="200" align="left" class="fontepreta12">Marca:</td>
				<td width="200" align="left" class="fontepreta12">Tipo:</td>
				<td width="200" align="left" class="fontepreta12">Extintor Nº:</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">Ativo Fixo:</td>
				<td align="left" class="fontepreta12">Local:</td>
				<td align="left" class="fontepreta12">ABNT Nº:</td>
			</tr>
			<tr>
				<td colspan="2" align="center" class="fontepreta12">&nbsp;</td>
				<td rowspan="15" align="left" class="fontepreta12"><br>1. Substituição de gatilho<p>2. Substituição de difusor<p>3. Mangote<p>4. Válvula de segurança<p>5. Válvula completa<p>6. Válvula cilindro adicional<p>7. Pintura<p>8. Manômetro<p>9. Teste hidrostático<p>10. Recarregado<p>11. Usado em incêndio<p>12. Usado em instrução<p>13. Diversos</td>
			</tr>
			<tr>
				<td colspan="2">
					<table align="center" width="400" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
						<tr>
							<td width="39" align="center" class="fontepreta12">Data</td>
							<td width="39" align="center" class="fontepreta12">Recebido</td>
							<td width="39" align="center" class="fontepreta12">Inspecionado</td>
							<td width="39" align="center" class="fontepreta12">Reparado</td>
							<td width="39" align="center" class="fontepreta12">Instrução</td>
							<td width="39" align="center" class="fontepreta12">Incêndio</td>
						</tr>
						<tr>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
							<td align="center" class="fontepreta12">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
<!---------------------27ª PÁGINA--------------->
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
				<td align="center" class="fontepreta12bold">ANEXO 3 - FICHA DE RECEBIMENTO DE MATERIAL</td>
			</tr>
		</table>
		<table align="center" width="600" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td colspan="4" align="left" class="fontepreta12">Razão Social:</td>
			</tr>
			<tr>
				<td colspan="2" align="left" class="fontepreta12">Endereço:</td>
				<td colspan="2" align="left" class="fontepreta12">Bairro:</td>
			</tr>
			<tr>
				<td colspan="4" align="left" class="fontepreta12">Nome do Colaborador:</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">CTPS:</td>
				<td align="left" class="fontepreta12">Série:</td>
				<td align="left" class="fontepreta12">Função:</td>
				<td align="left" class="fontepreta12">REG. Nº:</td>
			</tr>
		</table><br>
		<table align="center" width="600" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="50" align="center" class="fontepreta12">QTD</td>
				<td width="220" align="center" class="fontepreta12">Acessório</td>
				<td width="70" align="center" class="fontepreta12">Vida Útil</td>
				<td width="70" align="center" class="fontepreta12">Dt. Rec.</td>
				<td width="70" align="center" class="fontepreta12">Fabricado</td>
				<td width="50" align="center" class="fontepreta12">Nº C.A.</td>
				<td width="70" align="center" class="fontepreta12">Cód. Rec.</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Abafador auricular tipo concha</td>
				<td align="center" class="fontepreta12">2 anos</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Avental de couro de raspa</td>
				<td align="center" class="fontepreta12">3 anos</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Avental de PVC</td>
				<td align="center" class="fontepreta12">1 ano</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Bermuda tipo brim</td>
				<td align="center" class="fontepreta12">1 ano</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Braseira de couro de raspa</td>
				<td align="center" class="fontepreta12">3 anos</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Bota de segurança</td>
				<td align="center" class="fontepreta12">1 ano</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Bota de borracha</td>
				<td align="center" class="fontepreta12">1 ano</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Bota de segurança c/ biqueira</td>
				<td align="center" class="fontepreta12">1 ano</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Camisa tipo brim c/ manga</td>
				<td align="center" class="fontepreta12">1 ano</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Camisa tipo brim s/ manga</td>
				<td align="center" class="fontepreta12">1 ano</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Capacete plástico PVC c/ acarneira</td>
				<td align="center" class="fontepreta12">3 anos</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Capacete plástico PVC s/ acarneira</td>
				<td align="center" class="fontepreta12">3 anos</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Capa de chuva plástico transp.</td>
				<td align="center" class="fontepreta12">3 anos</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Camisa tipo polo</td>
				<td align="center" class="fontepreta12">6 meses</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Calça tipo brim</td>
				<td align="center" class="fontepreta12">1 ano</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Casaco de brim</td>
				<td align="center" class="fontepreta12">1 ano</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Crachá funcional</td>
				<td align="center" class="fontepreta12">3 anos</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Camisa de malha</td>
				<td align="center" class="fontepreta12">3 anos</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Cinto de segurança abdominal</td>
				<td align="center" class="fontepreta12">5 anos</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Cinto de segurança paraquedista</td>
				<td align="center" class="fontepreta12">5 anos</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Filtro de máscara contra gás</td>
				<td align="center" class="fontepreta12">3 anos</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Guarda pó</td>
				<td align="center" class="fontepreta12">1 ano</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Luva de couro de raspa</td>
				<td align="center" class="fontepreta12">1 ano</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Luva de PVC cano longo</td>
				<td align="center" class="fontepreta12">6 meses</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Luva de PVC cano curto</td>
				<td align="center" class="fontepreta12">6 meses</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Máscara descartável</td>
				<td align="center" class="fontepreta12">1 dia</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Óculos de proteção s/ grau</td>
				<td align="center" class="fontepreta12">3 anos</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Óculos de proteção c/ grau</td>
				<td align="center" class="fontepreta12">3 anos</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">Óculos de proteção soldador</td>
				<td align="center" class="fontepreta12">3 anos</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
				<td align="center" class="fontepreta12">&nbsp;</td>
			</tr>
		</table>
		<b>*01- Recebido pela 1ª vez/02– Desgaste Natural/03– Desgaste Irregular/04– Perda/Roubo/Extravio.</b>	
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
<!---------------------28ª PÁGINA--------------->
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
		<p align="justify">
		<b>DECLARAÇÃO DE RESPONSABILIDADE</b><p><br><p align="justify">
		&nbsp;&nbsp;&nbsp;Declaro para os devido fins que, conforme determina a NR-6 da Portaria 3.214/78 do Ministério do trabalho, recebi gratuitamente os Equipamentos de Proteção Individual acima discriminados, em perfeito estado de conservação e funcionamento, declaro ainda que, fui treinado quanto ao uso correto dos EPI’s, bem como, quanto aos procedimentos corretos de conservação, guarda e higienização, e que recebendo atendimento de avaliações físicas decorrentes dos atestados admissional e periódicos, recebi também orientações quanto a necessidade, a forma de utilizar e a guarda dos mesmos pela coordenação do PCMSO, conforme declaração anexada a ficha médica e ao prontuário médico.<p align="justify">
		&nbsp;&nbsp;&nbsp;Eu _____________________________________________________, Portador da CTPS _____________ série __________ comprometo-me a fazer uso dos EPI’s durante a realização das minhas atividades laborativas, submeter-me a treinamento sempre que sugerido por parte da gerencia e a manter os EPI’s sempre em condições de higiene ciente de que a falta da mesma poderá acarretar em riscos a minha própria saúde, e comunicar qualquer dano ao EPI que o torne impróprio ao uso, solicitando sua substituição.<p><br><p align="justify">
		&nbsp;&nbsp;&nbsp;Assinatura do Funcionário: _____________________________________	
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
<!---------------------29ª PÁGINA--------------->
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
				<td align="center" class="fontepreta12bold">ANEXO 4 – FICHA DE INSPEÇÃO DE ACIDENTE</td>
			</tr>
		</table>
		<table align="center" width="600" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="510" align="left" class="fontepreta12">Ficha de registro de investigação e ou acidente com danos materiais, ou danos ao meio ambiente</td>
				<td width="90" align="left" class="fontepreta12" valign="top">Ficha Nº</td>
			</tr>
		</table>
		<table align="center" width="600" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="296" align="left" class="fontepreta12">Unidade:</td>
				<td width="304" align="left" class="fontepreta12">Classificação:</td>
			</tr>
		</table>
		<table align="center" width="600" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="300" colspan="2" align="left" class="fontepreta12">Local da ocorrência:</td>
				<td width="50" align="left" class="fontepreta12">&nbsp;</td>
				<td width="250" align="left" class="fontepreta12">Quase acidente (incidente)</td>
			</tr>
			<tr>
				<td width="150" align="left" class="fontepreta12">Data:</td>
				<td width="150" align="left" class="fontepreta12">Hora:</td>
				<td width="50" align="left" class="fontepreta12">&nbsp;</td>
				<td width="250" align="left" class="fontepreta12">Acidente com danos</td>
			</tr>
		</table>
		<table align="center" width="600" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="297" align="left" class="fontepreta12">&nbsp;</td>
				<td width="50" align="left" class="fontepreta12">&nbsp;</td>
				<td width="253" align="left" class="fontepreta12">Com danos ao meio ambiente</td>
			</tr>
		</table>
		<table align="center" width="600" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="100" align="center" class="fontepreta12" rowspan="6">Ocorrências<p>causas</td>
				<td width="494" align="left" class="fontepreta12">Causas da ocorrência:</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">Testemunhas:</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td width="100" align="center" class="fontepreta12" rowspan="7">Providências<p>a serem<p>tomadas</td>
				<td width="494" align="left" class="fontepreta12">Cite a(s) providência(s) que deve(m) ser adotada(s) para evitar repetição(ões):</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">Nome do responsável:</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">&nbsp;</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">Data para solução: ___/___/___ &nbsp;&nbsp;&nbsp;Providências atendidas em: ___/___/___</td>
			</tr>
		</table>
		<table align="center" width="600" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="100" align="center" class="fontepreta12" rowspan="8">Danos<p>prejuízos</td>
				<td width="494" align="left" class="fontepreta12" colspan="2">Informe o valor aproximado dos danos (consulte a chefia de manutenção, produção, etc):</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12"> Interrupção da produção</td>
				<td align="left" class="fontepreta12"> R$ ____________________</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12"> Equipamento ou ferramentas danificadas</td>
				<td align="left" class="fontepreta12"> R$ ____________________</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">Quebra de produtos</td>
				<td align="left" class="fontepreta12"> R$ ____________________</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">Mão-de-obra</td>
				<td align="left" class="fontepreta12"> R$ ____________________</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12"> Outros (citar) 1</td>
				<td align="left" class="fontepreta12"> R$ ____________________</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12"> Outros (citar) 2</td>
				<td align="left" class="fontepreta12"> R$ ____________________</td>
			</tr>
			
			<tr>
				<td align="left" class="fontepreta12"> Total de despesas(aproximado)</td>
				<td align="left" class="fontepreta12"> R$ ____________________</td>
			</tr>
		</table><p>
		<table align="center" width="600" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center" class="fontepreta12">____________________________<br>Encarregado do setor</td>
				<td align="center" class="fontepreta12">____________________________<br>Chefe de equipe</td>
				<td align="center" class="fontepreta12">Emitir cópia para:<br>Gerência da unidade ( )<br>Presidente da CIPA ( )<br>Gerente compras ( )</td>
			</tr>
		</table>
		<div id="grfg"></div><div id="div_position"><!--img src="../img/bruna_carimbo.jpg" width="180" height="110"--><img src="../img/carimbo_assin.PNG" width="180" height="110"></div>
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
<?php
/*$mes = array(" ", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
//$sql = "SELECT * FROM cliente_setor";
$wek = date("n", strtotime($row['data_criacao']));
						  
$qualiar = "SELECT cs.*, t.*
			FROM cliente_setor cs, tipo_ventilacao_artificial t
			WHERE cs.cod_vent_art = t.tipo_ventilacao_artificial_id
			AND cs.cod_cliente = $cliente
			AND (cs.cod_vent_art = 5 OR cs.cod_vent_art = 6)";
$res_qualiar = pg_query($connect, $qualiar);
$row_qualiar = pg_fetch_all($res_qualiar);

for($y=0;$y<pg_num_rows($res_qualiar);$y++){
/******************CAPA DO ANEXO 7******************
echo "<table align=center width=700 height=800 border=0 cellpadding=0 cellspacing=0 bordercolor=#FFFFFF>
	<tr>
	<td class=tabela valign=top>";
	 include "header.php";
	 	/*echo "<table align=center width=550 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>
		<tr>
		<td align=center><font size=4>Programa de Prevenção de Riscos Ambientais";
		 if($row[data_criacao]){ echo date("Y", strtotime($row[data_criacao])); }
		 echo" </font></td>
		</tr>
		</table>*/
		/*echo"<p><br><p>
		<table align=center width=550 border=0 cellpadding=0 cellspacing=0 bordercolor=#000000>
			<tr>
				<td align=center><h1>7ª FASE<p><br><p>QUALIDADE<p>DO<p>AR<p>NA<p>EMPRESA</h1></td>
			</tr>
		</table>
		<p align=right><i>Legislação Sobre Qualidade do Ar</i>&nbsp;&nbsp;&nbsp;
	</td>";
	include "footer.php";
	echo "</tr>
</table>";
/****************PÁGINA 1 DO ANEXO 7***************/
/*echo "<table align=center width=700 height=800 border=0 cellpadding=0 cellspacing=0 bordercolor=#FFFFFF>
	<tr>
	<td class=tabela valign=top>";
	 include "header.php";
	 	/*echo "<table align=center width=550 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>
		<tr>
		<td align=center><font size=4>Programa de Prevenção de Riscos Ambientais";
		 if($row[data_criacao]){ echo date("Y", strtotime($row[data_criacao])); }
		 echo" </font></td>
		</tr>
		</table>*/
		/*echo "<p><br>
		<p align=right><b>Diretiva-Quadro 96/62/CE</b>&nbsp;&nbsp;&nbsp;<p><br><p><br>
		<table align=center width=550 border=0 cellpadding=0 cellspacing=0 bordercolor=#000000>
			<tr>
				<td align=center class=fontepreta14><b>"; 
				 echo "{$mes[$wek]}";
				 $wek++;
				 if($wek >= 13)$wek=1;
				echo" de ";
				if($row[data_criacao]){ echo date("Y", strtotime($row[data_criacao])); }
				echo"</b><p>
				<div align=justify>Este documento destina-se as autoridades locais, principalmente autarquias, e organizações governamentais. O seu objetivo é informar a estas entidades sobre a legislação existente na área da qualidade do ar, tanto a nível nacional como a nível comunitário. Esta fase é complementar ao PPRA geral sobre a melhoria da qualidade do ar nas cidades.<br>
				É feito um resumo dos documentos legais julgados mais relevantes para esta matéria, ao mesmo tempo em que se tenta dar uma visão de conjunto das ações preventivas e corretivas com ênfase à legislação na área da poluição atmosférica. Para cumprimento de algumas exigências.<br>
				Para um maior conforto do trabalhador e maior funcionalidade das atividades laborais, foi elaborada uma tabela que reúne praticamente todos os documentos legais abordados no texto, e respectivas referências de publicação. Essa tabela está no fim desta fase do programa.
				</div></td>
			</tr>
		</table>
	</td>";
	include "footer.php";
	echo "</tr>
</table>";
/****************PÁGINA 2 DO ANEXO 7***************/
/*echo "<table align=center width=700 height=800 border=0 cellpadding=0 cellspacing=0 bordercolor=#FFFFFF>
	<tr>
	<td class=tabela valign=top>";
	 include "header.php";
	 	/*echo "<table align=center width=550 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>
		<tr>
		<td align=center><font size=4>Programa de Prevenção de Riscos Ambientais";
		 if($row[data_criacao]){ echo date("Y", strtotime($row[data_criacao])); }
		 echo" </font></td>
		</tr>
		</table>*/
		/*echo "<p><br>
		<table align=center width=699 border=0 cellpadding=0 cellspacing=0 bordercolor=#000000>
			<tr>
				<td align=center><img src=../img/organograma.PNG width=447 height=133 border=0></td>
			</tr>
		</table><p>
		<b>Objetivo:</b> Programa de Sensibilização para a Melhoria da Qualidade do Ar.<p>
		<b>Co-Monitorado por:</b> SESMT - Serviços Especializados em Segurança e Medicina do Trabalho Ltda.
		<p>";
		$fase_sete = "SELECT cs.*, ag.*, rs.*, tr.* 
					  FROM cliente_setor cs, agente_risco ag, risco_setor rs, tipo_risco tr
					  WHERE cs.cod_cliente = $cliente
					  AND cs.cod_cliente = rs.cod_cliente
					  AND rs.cod_agente_risco = ag.cod_agente_risco
					  AND ag.cod_tipo_risco = tr.cod_tipo_risco
					  AND cs.cod_setor = rs.cod_setor
					  AND (cs.cod_vent_art = 5 or cs.cod_vent_art = 6)";
		$res_fase_sete = pg_query($connect, $fase_sete);
		$row_fase_sete = pg_fetch_array($res_fase_sete);
		echo"<table align=center width=698 border=1 cellpadding=0 cellspacing=0>
			<tr>
				<td width=200 align=center class=fontepreta12><b>Nº de Aparelhos</b><br>". $row_fase_sete[num_aparelhos] ."</td>
				<td width=249 align=center class=fontepreta12><b>Última Limpeza dos Filtros</b><br>". date("d/m/Y", strtotime($row_fase_sete[dt_ventilacao])) ."</td>
				<td width=249 align=center class=fontepreta12><b>Próxima Limpeza Mecânica</b><br>". date("d/m/Y", strtotime($row_fase_sete[proxima_limpeza_mecanica])) ."</td>
			</tr>
			<tr>
				<td align=center class=fontepreta12><b>Marca</b><br>". $row_fase_sete[marca] ."</td>
				<td align=center class=fontepreta12><b>Última Limpeza dos Dutos</b><br>". date("d/m/Y", strtotime($row_fase_sete[ultima_limpeza_duto])) ."</td>
				<td align=center class=fontepreta12><b>Próxima Limpeza dos Dutos</b><br>". date("d/m/Y", strtotime($row_fase_sete[proxima_limpeza_duto])) ."</td>
			</tr>
			<tr>
				<td align=center class=fontepreta12><b>Modelo</b><br>". $row_fase_sete[modelo] ."</td>
				<td align=center class=fontepreta12><b>Capacidade</b><br>". $row_fase_sete[capacidade] ."</td>
				<td align=center class=fontepreta12><b>Empresa Prestadora dos Serviços</b><br>". $row_fase_sete[empresa_servico] ."</td>
			</tr>
			<tr>
				<td align=center class=fontepreta12><b>Risco</b><br>". $row_fase_sete[nome_tipo_risco] ."</td>
				<td align=center class=fontepreta12><b>Agente</b><br>". $row_fase_sete[nome_agente_risco] ."</td>
				<td align=center class=fontepreta12><b>Fonte</b><br>". $row_fase_sete[fonte_geradora] ."</td>
			</tr>
			<tr>
				<td align=left colspan=3 class=fontepreta12><b>Diagnóstico:</b>&nbsp;". $row_fase_sete[diagnostico] ."</td>
			</tr>
		</table>
		<p align=justify>
		Índice máximo de poluentes de contaminação biológica, química e parâmetros físicos do ar são dados fornecidos no documento. Bactérias, fungos, protozoários, vírus, algas e animais como: roedores, morcegos e aves são possíveis fontes de poluentes biológicos encontrados nas avaliações do ar de interiores. Já os principais poluentes químicos são produzidos por máquinas copiadoras, impressoras a laser, pesticidas, produtos de limpeza e combustão como: queima de cigarro e uso de veículos automotores.
	</td>";
	include "footer.php";
	echo "</tr>
</table>";
/****************PÁGINA 3 DO ANEXO 7***************/
/*echo "<table align=center width=700 height=800 border=0 cellpadding=0 cellspacing=0 bordercolor=#FFFFFF>
	<tr>
	<td class=tabela valign=top>";
	 include "header.php";
	 	/*echo "<table align=center width=550 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>
		<tr>
		<td align=center><font size=4>Programa de Prevenção de Riscos Ambientais";
		 if($row[data_criacao]){ echo date("Y", strtotime($row[data_criacao])); }
		 echo" </font></td>
		</tr>
		</table>*/
		/*echo "<br><p justify>
		<b>Legislação da União Européia</b><p align=justify>
		Em termos hierárquicos, à imagem duma constituição nacional, toda a legislação da União Européia (UE) se baseia nos princípios do tratado que institui a Comunidade Européia. Em termos de preservação do ambiente, o documento quadro que se segue é o programa de ação em matéria de ambiente. Estes programas têm sido revistos periodicamente, tendo o mais recente sido criado em 1992, aprovado pela Resolução do Conselho de 1/ Fev / 93.<p align=justify>
		O <b>5º programa de ação em matéria de ambiente</b>, que surgiu após a Conferência do Rio (Jun / 92) e as suas inúmeras declarações e convenções, assenta de forma concreta no princípio da subsidiariedade, ou da responsabilidade partilhada. Este programa foi concebido de modo à “refletir os objetivos e princípios do desenvolvimento sustentável, das ações preventivas, cautelares e da partilha de responsabilidades”.<p align=justify>
		O documento em si tem 100 páginas e constitui uma excelente fonte de informação sobre todas as áreas da proteção do ambiente, desde a mudança climática à gestão de recursos hídricos, passando pelos custos e benefícios financeiros. Nele, podem ser encontrados inúmeros fatos concretos, sobre a forma de tabelas, mapas, gráficos e diagramas, com dados recentes e referenciados. Por estas razões, a sua leitura e referência permitem obter argumentos bem fundamentados sobre uma variedade enorme de questões.<p align=justify>
		Em particular, em relação à qualidade do ar (QA), a estratégia legislativa da UE desenvolve-se a partir de quatro vetores fundamentais, como está patente no diagrama seguinte:<p align=left>
		<b>Emissões:</b><p align=justify>
		<b>Fontes Móveis</b>(Mobile Sources): Legislação através da qual se impõem limites de emissão a veículos.<p align=justify>
		<b>Fontes Fixas</b>(Stationary Sources): Legislação através da qual se impõem limites de emissões a instalações industriais, sobretudo aquelas onde ocorrem queimas, como por exemplo, as incineradoras.<p align=justify>
		<b>Qualidade de Produtos</b>(Product Control): Legislação que regula a qualidade de materiais cuja utilização e/ou consumo produz poluição atmosférica, como por exemplo, os combustíveis para automóveis.<p align=justify>
		Como pano de fundo a este esquema deve estar sempre uma população participativa e informada. Neste sentido, a UE possui a Diretiva 90/313/CEE relativa à liberdade de acesso à informação em matéria de ambiente. Portugal possui um documento semelhante, mas referente a todos os documentos da administração (ver mais à frente).<p align=justify>
		Em termos de estratégia global, e em concreto com relação a padrões de QA, a referência incontornável é a Diretiva 96/62/CE, aprovada a 27/Set / 96. A este respeito, deve ler-se também o guia complementar a este, que dedica uma grande parte a esta diretiva.<p align=justify>
		O texto desta diretiva está reproduzido integralmente neste guia. É considerada uma diretiva-quadro (Air Quality Framework Directive), relativa à avaliação e gestão da qualidade do ar ambiente. Pretende criar o enquadramento legal que possibilite sobre tudo dois fins essenciais: a imposição de limites de concentração de poluentes e sua vigilância de forma uniformizada em toda a UE (avaliação) e, sempre que se justifique a criação de planos para controlar a QA (gestão). Estas ações, por si só, não serão novidades em termos legais, mas antes existiam de forma desconexa, para lá da evidente atualização de procedimentos que a diretiva encerra.<p align=justyfy>
		Deve salientar-se a grande ênfase posta na defesa da saúde humana. Trata-se dum documento legal que reflete de forma concreta os resultados das investigações mais recentes que relacionam de forma inequívoca poluição do ar com morte e doença nas populações humanas, em proporções verdadeiramente preocupantes. É sabido que, mesmo cumprindo os atuais valores-limite, continuam a haver elevados prejuízos para a saúde humana em toda a UE. Por outro lado, a consagração de proteção do ambiente por si só, veste de forma não antropocêntrica (ecossistemas e vegetação), constitui uma grande novidade desta diretiva.
	</td>";
	include "footer.php";
	echo "</tr>
</table>";
/****************PÁGINA 4 DO ANEXO 7***************/
/*echo "<table align=center width=700 height=800 border=0 cellpadding=0 cellspacing=0 bordercolor=#FFFFFF>
	<tr>
	<td class=tabela valign=top>";
	 include "header.php";
	 	/*echo "<table align=center width=550 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>
		<tr>
		<td align=center><font size=4>Programa de Prevenção de Riscos Ambientais";
		 if($row[data_criacao]){ echo date("Y", strtotime($row[data_criacao])); }
		 echo" </font></td>
		</tr>
		</table>*/
		/*echo "<br><p justify>
		Os seus principais objetivos são providenciar um elevado grau de proteção da saúde pública em toda a UE e pela primeira vez definir valores-limite de QA destinados propositadamente a proteger o ambiente. Espera-se que esta proposta traga enormes benefícios em termos de saúde pública: milhares de mortes serão evitados; as admissões nas emergências hospitalares serão reduzidas; a população em geral, e os cidadãos mais sensíveis em particular, terão graus inferiores de doenças respiratórias; a qualidade de vida para muitos melhorará.<p align=justify>
		A definição dos novos valores-limite destinados a proteger a saúde baseou-se em valores que a Organização Mundial de Saúde (OMS) adaptou em 1996, como parte do seu programa “Orientações sobre qualidade do ar para a Europa” (Air Quality Guidelines for Europe). Os valores-limite destinados a proteger o ambiente têm como objetivo essencial à salvaguarda do ambiente rural e ecossistemas.<p align=justify>
		<b>Proposta de Diretiva COM (97) 500 (Nova Diretiva-filha)</b><p align=justify>
		A primeira das diretivas-filhas a ser proposta foi apresentada pela Comissão de 1 a 8 / Out / 97, tendo sido aprovada a 22 /Abr / 99. Refere-se a valores-limite para o dióxido de enxofre (SO<sub>2</sub>), óxidos de azoto (NO<sub>x</sub>), partículas em suspensão (PS) e chumbo (Pb) no ar ambiente. Os Quadros 1 a 4 exibem os valores-limite preconizados pela proposta, objeto de alterações na diretiva aprovada, bem como os prazos para o seu cumprimento.<p>
		<table align=center width=600 border=1 cellpadding=0 cellspacing=0>
			<tr>
				<td align=center colspan=4 class=fontepreta=14><b>Quadro 1</b> - Valores-limite para Dióxido de Enxofre</td>
			</tr>
			<tr>
				<td width=150 align=center class=fontepreta12><b>Tipo de Valor-limite</b></td>
				<td width=150 align=center class=fontepreta12><b>Período Considerado</b></td>
				<td width=150 align=center class=fontepreta12><b>Valor-limite (mg/m&sup3;)</b></td>
				<td width=150 align=center class=fontepreta12><b>Data para Cumprimento</b></td>
			</tr>
			<tr>
				<td rowspan=2 align=center class=fontepreta12>Proteção da Saúde Humana</td>
				<td align=center class=fontepreta12>1 Hora</td>
				<td align=center class=fontepreta12>350 Não exceder mais de 24 vezes por ano civil</td>
				<td align=center class=fontepreta12>jan/2005 </td>
			</tr>
			<tr>
				<td align=center class=fontepreta12>24 Horas</td>
				<td align=center class=fontepreta12>125 Não exceder mais de 3 vezes por ano civil</td>
				<td align=center class=fontepreta12>125 Não exceder mais de 3 vezes por ano civil</td>
			</tr>
			<tr>
				<td align=center class=fontepreta12>Proteção de Ecossistema</td>
				<td align=center class=fontepreta12>Ano civil e inverno</td>
				<td align=center class=fontepreta12>20</td>
				<td align=center class=fontepreta12>dois anos apos entrada</td>
			</tr>
		</table>
	</td>";
	include "footer.php";
	echo "</tr>
</table>";
/****************PÁGINA 5 DO ANEXO 7***************/
/*echo "<table align=center width=700 height=800 border=0 cellpadding=0 cellspacing=0 bordercolor=#FFFFFF>
	<tr>
	<td class=tabela valign=top>";
	 include "header.php";
	 	/*echo "<table align=center width=550 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>
		<tr>
		<td align=center><font size=4>Programa de Prevenção de Riscos Ambientais";
		 if($row[data_criacao]){ echo date("Y", strtotime($row[data_criacao])); }
		 echo" </font></td>
		</tr>
		</table>*/
		/*echo "<br><p>
		<table align=center width=600 border=1 cellpadding=0 cellspacing=0>
			<tr>
				<td align=center colspan=4 class=fontepreta=14><b>Quadro 2</b> - Valores-limite para os Óxidos de Azoto</td>
			</tr>
			<tr>
				<td width=150 align=center class=fontepreta12><b>Tipo de Valor-limite</b></td>
				<td width=150 align=center class=fontepreta12><b>Período Considerado</b></td>
				<td width=150 align=center class=fontepreta12><b>Valor-limite (mg/m&sup3;)<br>(a 293º K e 101,3 Kpa)</b></td>
				<td width=150 align=center class=fontepreta12><b>Data para Cumprimento</b></td>
			</tr>
			<tr>
				<td rowspan=2 align=center class=fontepreta12>Proteção da Saúde Humana</td>
				<td align=center class=fontepreta12>1 Hora</td>
				<td align=center class=fontepreta12>200 de NO<sub>2</sub> não exceder mais de 8 vezes</td>
				<td align=center class=fontepreta12>jan/2010 </td>
			</tr>
			<tr>
				<td align=center class=fontepreta12>ano civil</td>
				<td align=center class=fontepreta12>40 de NO<sub>2</sub></td>
				<td align=center class=fontepreta12>jan/2010</td>
			</tr>
			<tr>
				<td align=center class=fontepreta12>Proteção de Ecossistema</td>
				<td align=center class=fontepreta12>Ano civil e inverno</td>
				<td align=center class=fontepreta12>30 de NO + NO<sub>2</sub></td>
				<td align=center class=fontepreta12>dois anos apos entrada</td>
			</tr>
		</table>
		<br><p>
		<table align=center width=600 border=1 cellpadding=0 cellspacing=0>
			<tr>
				<td align=center colspan=5 class=fontepreta=14><b>Quadro 3</b> - Valores-limite para as Partículas em Suspensão</td>
			</tr>
			<tr>
				<td width=150 colspan=2 align=center class=fontepreta12><b>Tipo de Valor-limite</b></td>
				<td width=150 align=center class=fontepreta12><b>Período Considerado</b></td>
				<td width=150 align=center class=fontepreta12><b>Valor-limite (mg/m&sup3; PM<sub>10</sub>)</b></td>
				<td width=150 align=center class=fontepreta12><b>Data para Cumprimento</b></td>
			</tr>
			<tr>
				<td rowspan=2 align=center class=fontepreta12>1&ordf;<p>F<br>a<br>s<br>e</td>
				<td rowspan=2 align=center class=fontepreta12>Proteção da Saúde Humana</td>
				<td align=center class=fontepreta12>24 Hora</td>
				<td align=center class=fontepreta12>50 Não exceder mais de 25 vezes por ano civil</td>
				<td align=center class=fontepreta12>jan/2005 </td>
			</tr>
			<tr>
				<td align=center class=fontepreta12>ano civil</td>
				<td align=center class=fontepreta12>30</td>
				<td align=center class=fontepreta12>jan/2010</td>
			</tr>
			<tr>
				<td rowspan=2 align=center class=fontepreta12>2&ordf;<p>F<br>a<br>s<br>e</td>
				<td rowspan=2 align=center class=fontepreta12>Proteção da Saúde Humana</td>
				<td align=center class=fontepreta12>24 Hora</td>
				<td align=center class=fontepreta12>50 Não exceder mais de 7 vezes por ano civil</td>
				<td align=center class=fontepreta12>jan/2010 </td>
			</tr>
			<tr>
				<td align=center class=fontepreta12>ano civil</td>
				<td align=center class=fontepreta12>20</td>
				<td align=center class=fontepreta12>jan/2010</td>
			</tr>
		</table>
		<br><p>
		<table align=center width=600 border=1 cellpadding=0 cellspacing=0>
			<tr>
				<td align=center colspan=4 class=fontepreta=14><b>Quadro 4</b> - Valores-limite para Chumbo</td>
			</tr>
			<tr>
				<td width=150 align=center class=fontepreta12><b>Tipo de Valor-limite</b></td>
				<td width=150 align=center class=fontepreta12><b>Período Considerado</b></td>
				<td width=150 align=center class=fontepreta12><b>Valor-limite (mg/m&sup3;)</b></td>
				<td width=150 align=center class=fontepreta12><b>Data para Cumprimento</b></td>
			</tr>
			<tr>
				<td align=center class=fontepreta12>Proteção da Saúde Humana</td>
				<td align=center class=fontepreta12>Ano civil</td>
				<td align=center class=fontepreta12>0,5</td>
				<td align=center class=fontepreta12>jan/2005 </td>
			</tr>
		</table>		
	</td>";
	include "footer.php";
	echo "</tr>
</table>";
/****************PÁGINA 6 DO ANEXO 7***************/
/*echo "<table align=center width=700 height=800 border=0 cellpadding=0 cellspacing=0 bordercolor=#FFFFFF>
	<tr>
	<td class=tabela valign=top>";
	 include "header.php";
	 	/*echo "<table align=center width=550 border=1 cellpadding=0 cellspacing=0 bordercolor=#000000>
		<tr>
		<td align=center><font size=4>Programa de Prevenção de Riscos Ambientais";
		 if($row[data_criacao]){ echo date("Y", strtotime($row[data_criacao])); }
		 echo" </font></td>
		</tr>
		</table>*/
		/*echo "<br><p align=justify>
		O documento do qual consta esta proposta, já aprovada, designa-se por COM (97) 500, e constitui um bom texto de referência (ver contatos no fim do guia para saber como obter documentos COM). Isto porque, para além da proposta em si, possui uma extensa exposição de motivos (60 páginas onde se apresentam inúmeros fatos sobre os poluentes em causa) e uma ficha de avaliação de impacto (uma série de perguntas e respostas sobre “impacto da proposta sobre as empresas e, em especial, as pequenas e médias empresas”).<p align=justify>
		Na elaboração desta proposta foram tidas em conta todas as outras medidas em atuação na área da QA, designadas no seu conjunto por cenário de referência. Segundo estes cenários, descritos para cada poluente num anexo da exposição de motivos, independentemente da ação da proposta da diretiva, existirão elevadas reduções de emissões dos poluentes no conjunto dos 15 países da comunidade, entre 1990 e 2010:<p align=justify>
		&nbsp;&nbsp;&bull; 66% para o SO<sub>2</sub> (de 16.497.000 t para 5.619.000 t);<p>
		&nbsp;&nbsp;&bull; 48% para os NO<sub>x</sub> (de 13.370.000 t para 6.921.000);<p>
		&nbsp;&nbsp;&bull; ±50% para as partículas (de 2.884.700 t para 1.365.400 t)&sup1;;<p align=justify>
		&nbsp;&nbsp;&bull; Em grande parte devido à generalização da gasolina sem chumbo, só se verificam concentrações mais elevadas deste poluente junto de certas instalações industriais, nomeadamente fundições.<p align=justify>
		Assim, em relação a estes cenários, estimou-se que para fazer cumprir os valores-limite propostos, até 2010, será necessário reduzir as emissões adicionalmente em:<p>
		&nbsp;&nbsp;&bull; 10% para o SO<sub>2</sub> (- 46.000 t);<p>
		&nbsp;&nbsp;&bull; 10% para os NO<sub>x</sub> (- 76.000 t);<p>
		&nbsp;&nbsp;&bull; ±50% para as partículas (- 15.000 t).<p align=justify>
		Em torno dos valores-limite, a diretiva estabelece outro tipo de níveis: <b>margem de tolerância</b> (destina-se a identificar zonas mais problemáticas para as quais é preciso elaborar planos de ação pormenorizados); <b>limites inferior e superior de avaliação</b> (de modo a estabelecer diferentes requisitos, ou grau de exigência, de avaliação da QA) e <b>limiar de alerta</b> (com o objetivo de proteger os grupos mais sensíveis da população).<p align=justify>
		Esta diretiva, quando publicada, revogará em prazos definidos as diretivas atuais: 80/779/CEE e 89/427/CEE (dióxido de enxofre e partículas); 82/884/CEE (chumbo) e 85/203/CEE (dióxido de azoto). Em termos processuais, a diretiva agora aprovada resultou dum longo processo de discussão. A primeira leitura da proposta por parte do Parlamento&sup2; ocorreu a 13/ Maio / 98. Como conseqüência, a Comissão apresentou uma proposta alterada&sup3; a 8/Jul /98 e o conselho adaptou a sua posição comum<sup>4</sup> a 24/Set / 98. O parlamento fez a sua segunda leitura<sup>5</sup> a 13/Jan /99 e finalmente a 22/Abr/ 99 foi aprovada a nova diretiva-filha.<p align=justify>
		___________________________________________<br>
		<sup>1</sup> Estes valores devem ser considerados com extrema cautela, uma vez que possuem uma elevada margem de incerteza. Isto se deve ao fato do inventário de emissões em que se baseiam não ser completo e de nem todos o países terem dados representativos sobre as partículas.<br>
		<sup>2</sup> JO C167 1/6/98 p.103.<br>
		<sup>3</sup> COM(98)386, JO C259 18/8/98 p.10 (apenas texto da proposta).<br>
		<sup>4</sup> Posição Comum n.º 57/98, JO C360 23/11/98 p.99.<br>
		<sup>5</sup> Este texto ainda não foi publicado no JO.
	</td>";
	include "footer.php";
	echo "</tr>
</table>";

}*/
?>
<!---------------------30ª PÁGINA--------------->
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
		$meses = array(" ", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
		?>
		<p align="left">
		<b>METAS E PRIORIDADES</b><p align="justify">
		- As metas e prioridades serão definidas na avaliação anual do PPRA e deverão contemplar não apenas os riscos físicos, químicos e biológicos como também os demais riscos.<p align="justify">
		- Na avaliação anual será determinado a <b><?php echo $row[razao_social]; ?></b>. e passa a ser uma atividade permanente. O Conteúdo deste documento poderá ser revisado e alterado, quando necessário, pelo seu coordenador o <b>Sr. Pedro Henrique da Silva</b>. Um cronograma de ações a serem realizado no decorrer do ano seguinte e atualizado mensalmente.<p align="justify">
		- Este documento serve como base e guia para o desenvolvimento do Programa de Prevenção de Riscos Ambientais – PPRA da <b><?php echo $row[razao_social]; ?></b>.<p><br><p align="center">
		Rio de Janeiro, 
		<?PHP 
		$sql = "select data_criacao from cliente_setor where cod_cliente = $cliente AND EXTRACT(year FROM data_criacao) = {$ano}";
		$res = pg_query($connect, $sql);
		$row = pg_fetch_array($res);
		echo date("d", strtotime($row[data_criacao]))." de ".$meses[date("n", strtotime($row[data_criacao]))]." de ".date("Y", strtotime($row[data_criacao]));
		?>
		<p><br>
		<table align="center" width="600" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center"><!--img src="../img/diuliane_carimbo.jpg" border="0"--><img src="../img/diuliane_assinatura_carimbo.jpg" border="0"></td>
				<td align="center"><!--img src="../img/bruna_carimbo2.jpg" border="0"--><img src="../img/ass_pedro3.png" border="0"></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>Elaborador Responsável</b></td>
				<td align="center" class="fontepreta12"><b>Técnico Responsável</b></td>
			</tr>
		</table>
		<!--table align="center" width="600" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center"><img src="../img/ass_everaldo.PNG" border="0"></td>
			</tr>
			<tr>
				<td align="center" class="fontepreta12"><b>Egenheiro Responsável</b></td>
			</tr>
		</table-->
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
</form>
</body>
</html>
