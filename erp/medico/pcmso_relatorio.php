<?php
//include "../sessao.php";
include "../config/connect.php";

if(isset($_GET['y'])){
    $ano = $_GET['y'];
}else{
    $ano = date("Y");
}

$height = 1050;
$hei = 570;

$pcmso = "SELECT c.*, cn.*, cs.*
		FROM cliente c, cnae cn, cliente_setor cs
		WHERE c.cnae_id = cn.cnae_id
		AND c.cliente_id = cs.cod_cliente
		AND cs.id_ppra = $_GET[id_ppra]";
$res = pg_query($connect, $pcmso);
$rr = pg_fetch_array($res);

/*************QUANTIDADE DE FUNCIONÁRIOS MASCULINOS************/
$masc = "SELECT sexo_func, f.cod_cliente 
		FROM funcionarios f, cgrt_func_list l
		WHERE f.cod_cliente = $cliente
		AND f.cod_func = l.cod_func
		AND l.cod_cgrt = $_GET[id_ppra]
		AND sexo_func = 'Masculino'";
$result = pg_query($masc);
$nmasc = pg_num_rows($result);

/*************QUANTIDADE DE FUNCIONÁRIOS FEMININOS************/
$fem = "SELECT sexo_func, f.cod_cliente 
		FROM funcionarios f, cgrt_func_list l
		WHERE f.cod_cliente = $cliente
		AND f.cod_func = l.cod_func
		AND l.cod_cgrt = $_GET[id_ppra]
		AND sexo_func = 'Feminino'";
$result = pg_query($fem);
$nfem = pg_num_rows($result);

/*************QUANTIDADE DE FUNCIONÁRIOS************/
$maior = "SELECT f.* 
		FROM funcionarios f, cgrt_func_list l
		WHERE f.cod_cliente = $cliente
		AND f.cod_func = l.cod_func
		AND cod_cgrt = $_GET[id_ppra]";
$result = pg_query($maior);
$flist = pg_fetch_all($result);
$m18 = 0;
$m45 = 0;
for($x=0;$x<pg_num_rows($result);$x++){
	if((date("Y")-date("Y",strtotime($flist[$x][data_nasc_func])))<18){
	    $m18++;
	}
	if((date("Y")-date("Y",strtotime($flist[$x][data_nasc_func])))>45){
	    $m45++;
	}
}

/*************NÚMERO DE FUNCIONÁRIOS DA TABELA CGRT*****************/
$num = "select f.cod_func, nome_func 
		from funcionarios f, cgrt_func_list l
		where f.cod_cliente = $cliente
		and f.cod_func = l.cod_func
		and cod_cgrt = $_GET[id_ppra]";
$res = pg_query($num);
$sm = pg_num_rows($res);

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
<form name="frm_pcmso_relatorio" action="pcmso_relatorio.php" method="post">
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
	<div id="div_position" style="position:relative;left:-30px;"><img src="../img/uno_top.jpg" width="154" height="219"></div>
		<table align="center" width="500" height="<?php echo $hei; ?>" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
		<td align="center"><p><h1><b><?php echo $rr[razao_social]; ?></b></h1><p><br></p>
		<h1>PROGRAMA DE CONTROLE MÉDICO E DE SAÚDE OCUPACIONAL</h1>
		<p><br><p><br><p><br></p><b>ANO BASE <br> <?php if($rr[data_criacao]){ echo date("Y", strtotime($rr[data_criacao])); } ?></b>
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
		<table align="center" width="698" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td width="199" class="tabela"><b>EMPRESA:</b></td>
		</tr>
		<tr>
			<td width="199" class="tabela">Razão Social:</td>
			<td class="tabela"><?php echo $rr[razao_social]; ?></td>
		</tr>
		<tr>
			<td width="199" class="tabela">Endereço:</td>
			<td class="tabela"><?php echo $rr[endereco]; ?></td>
		</tr>
		<tr>
			<td width="199" class="tabela">Bairro:</td>
			<td class="tabela"><?php echo $rr[bairro]; ?></td>
		</tr>
		<tr>
			<td width="199" class="tabela">Estado:</td>
			<td class="tabela"><?php echo $rr[estado]; ?></td>
		</tr>
		<tr>
			<td width="199" class="tabela">Cidade:</td>
			<td class="tabela"><?php echo $rr[municipio]; ?></td>
		</tr>
		<tr>
			<td width="199" class="tabela">CEP:</td>
			<td class="tabela"><?php echo $rr[cep]; ?></td>
		</tr>
		<tr>
			<td width="199" class="tabela">Telefone:</td>
			<td class="tabela"><?php echo $rr[telefone]; ?></td>
		</tr>
		<tr>
			<td width="199" class="tabela">FAX:</td>
			<td class="tabela"><?php echo $rr[fax]; ?></td>
		</tr>
		<tr>
			<td width="199" class="tabela">CNPJ / CEI:</td>
			<td class="tabela"><?php echo $rr[cnpj]; ?></td>
		</tr>
		<tr>
			<td width="199" class="tabela">Ramo de Atividade:</td>
			<td class="tabela"><?php echo $rr[descricao_atividade]; ?></td>
		</tr>
		<tr>
			<td width="199" class="tabela">CNAE:</td>
			<td class="tabela"><?php echo $rr[cnae]; ?></td>
		</tr>
		<tr>
			<td width="199" class="tabela">Grau de Risco:</td>
			<td class="tabela"><?php echo $rr[grau_de_risco]; ?></td>
		</tr>
		<tr>
			<td width="199" class="tabela">Responsável:</td>
			<td class="tabela"><?php echo $rr[nome_contato_dir]; ?></td>
		</tr>
		<tr>
			<td width="199" class="tabela">Contador:</td>
			<td class="tabela"><?php echo $rr[nome_contador]; ?></td>
		</tr>
		<tr>
			<td width="199" class="tabela">Telefone:</td>
			<td class="tabela"><?php echo $rr[tel_contador]; ?></td>
		</tr>
		<tr>
			<td width="199" class="tabela">Efetivo Geral:</td>
			<td class="tabela"><?php echo coloca_zeros($sm); ?></td>
		</tr>
		<tr>
			<td width="199" class="tabela">Efetivo Masculino:</td>
			<td class="tabela"><?php echo coloca_zeros($nmasc); ?></td>
		</tr>
		<tr>
			<td width="199" class="tabela">Efetivo Feminino:</td>
			<td class="tabela"><?php echo coloca_zeros($nfem); ?></td>
		</tr>
		<tr>
			<td width="199" class="tabela">Efetivo Menor de 18 Anos:</td>
			<td class="tabela"><?php echo coloca_zeros($m18); ?></td>
		</tr>
		<tr>
			<td width="199" class="tabela">Efetivo Maior de 45 Anos:</td>
			<td class="tabela"><?php echo coloca_zeros($m45); ?></td>
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
		<table align="center" width="500" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center"><h1>APRESENTAÇÃO</h1></td>
			</tr>
			<tr>
				<td align="justify" class="fontepreta14">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O presente trabalho tem como objetivo Sistematizar as Ações desenvolvidas na empresa, atendendo as Exigências da nova NR-7 criada pela Secretaria de Segurança e Medicina do Trabalho, em vigor desde 30/12/1994 que vem estabelecer um controle da saúde de todos os Empregados. O caráter preventivo permeia todo o texto, o que demonstra a preocupação da Empresa com a qualidade de vida dos seus empregados.
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
		<table align="center" width="698" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="justify" class="fontepreta12">
				<b>SUMÁRIO</b><p>
				1. CONSIDERAÇÕES INICIAIS<br>2. OBJETIVOS – GERAIS E/OU ESPECÍFICOS<br>3. DEFINIÇÕES E COMPOSIÇÃO DO PCMSO<br>4. DIRETRIZES<br>5. METODOLOGIA<br>6. PROCEDIMENTO – EXAMES COMPLEMENTARES<br>7. ESTRATÉGIA<br>8. RESPONSABILIDADE E ATRIBUIÇÕES<br>9. DESCRIÇÃO SETORIAL DAS INSTALAÇÕES DA EMPRESA<br>10. SISTEMATIZAÇÃO SETORIAL<br>11. DADOS CADASTRAIS DOS FUNCIONÁRIOS E CRONOGRAMA DE EXAMES<br>12. CONSIDERAÇÕES FINAIS
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
		<table align="center" width="698" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="left" class="fontepreta12">
				<b>1.	CONSIDERAÇÕES INICIAIS</b><p align="justify">
				
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No momento em que o mundo passa por profundas transformações, que trazem em seu rastro novas formas de produção, que remodelam as estruturas organizacionais, o interesse com a qualidade de vida se torna indispensável.<p align="justify">
				
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O homem neste contexto se constitui em objeto de preocupação para as empresas, que buscam através de diversos programas atender suas necessidades de bem estar físico e mental.<p align="justify">
				
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dentre esses programas encontra-se o Programa de Controle Médico da Saúde Ocupacional – PCMSO, que vem resgatar o compromisso com a saúde do trabalho, com relação a definição de condutas de preservação da saúde trazendo em seu bojo o compromisso com a melhoria da qualidade de vida do empregado.
				<p>
				</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">
				<b>2.	OBJETIVOS</b><p>
				<table align="left" width="350" border="1" bordercolor="#000000">
					<tr>
						<td align="center" width="170" class="fontepreta14">GERAIS</td>
						<td align="center" width="170" class="fontepreta14">ESPECÍFICOS</td>
					</tr>
					<tr>
						<td align="left" valign="top" class="fontepreta12">a- Prevenir, controlar, avaliar e conhecer as condições de saúde dos trabalhadores.<p>b- Atender a política, princípios e valores de qualidade da empresa.</td>
						<td align="left" class="fontepreta12">a- Desenvolver ações que contribuam para a melhoria da qualidade de vida do empregado;<p>b- Promover campanhas educativas voltadas para o investimento na saúde;<p>c- Atender as exigências do Ministério do Trabalho através da NR-07, publicada em 30.12.94 no D.O.U.<p>d-  Acatar o estabelecido, na portaria 3.214/78 do MTb e da portaria 24/94 do SST, NR7.</td>
					</tr>
				</table>
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
				<b>3.	DEFINIÇÕES E COMPOSIÇÃO DO PCMSO</b><p>
				<b>EXAMES MÉDICOS OCUPACIONAIS (EMO)</b> – são exames médicos a que são submetidos os trabalhadores, a fim de serem avaliadas suas condições de saúde e compreendem em Exame Básico (Avaliação Clínica) e Exames Complementares, tendo em vista o exercício das atividades laborativas.<p>
				<b>EXAME MÉDICO ADMISSIONAL (EMA)</b> – exame a que são submetidos todos os candidatos, aprovados nas demais etapas do processo seletivo, a fim de serem avaliadas as suas condições de saúde, conhecidas também como pré-admissional devido à visão da avaliação do candidato antes da sua contratação como medida preventiva e de controle da boa saúde do quadro funcional.<p>
				<b>EXAMES MÉDICOS DE MUDANÇA DE FUNÇÃO (EMMF)</b> – exame a que são submetidos, os empregados candidatos à reclassificação para cargo ou posto de trabalho que exija do ocupante característica somato-psíquicas distintas das do cargo que ocupam, bem como antes de qualquer alteração de atividade, posto de trabalho ou de área, que implique na exposição do empregado a risco diferente daquele a que estava exposto anteriormente, o que caracteriza mudança de função. Entende-se ainda a promoção como mudança de função, cabe à gerência de coordenação informar ao serviço médico antes da efetivação da mudança.<p>
				<b>EXAME MÉDICO PERIÓDICO (EMP)</b> - exame a que são submetidos, em prazos regulares e previamente programados, todos os empregados da empresa ao completarem o ciclo de doze meses do último exame submetido, podendo ser admissional ou periódico.<p>
				<b>EXAME DE RETORNO AO TRABALHO (EMRT)</b> – exame a que são submetidos todos os empregados afastados por período igual ou superior a 30 dias, por motivo de doenças, acidentes, partos e fim de férias, no primeiro dia de retorno à atividade submeter-se-á a reavaliação pelo médico do trabalho e recebera o ASO de liberação ao serviço.<p>
				<b>EXAME MÉDICO DEMISSIONAL (EMD)</b> – exame a que são submetidos os empregados, por ocasião da cessação do contrato de trabalho. É realizado, obrigatoriamente, em todos os casos de demissão, desde que o último Exame Médico Ocupacional tenha sido realizado há mais de 90 (Noventa) dias, visa também o cumprimento da IN 84 de 17.12.2002, anexo XV do INSS/DC. – perfil profissiográfico previdenciário.<p>
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
				<b>4.	DIRETRIZES</b><p>
				1º A critério do médico examinador, em função da avaliação clínica, qualquer outro exame complementar poderá ser solicitado além daqueles estabelecidos, somente para esclarecimento de diagnóstico e não para acompanhamento de tratamento, sendo neste caso, integralmente custeado pela Empresa.
				2º EMMF compreende avaliação clínica e exames complementares previstos para o novo cargo/posto de trabalho que não tenham sido realizados no EMP de acordo com a TABELA DE EXAMES MÉDICOS OCUPACIONAIS.<p>
				3º Quando o EMMF estiver programado para o período de 90 (noventa) dias antes daquele previsto para o EMP, deve ser feita com antecipação deste, dentro da modalidade correspondente observando o disposto acima.<p>
				4º Ao deixar o trabalho em atividade que desenvolve risco, o empregado deve ser submetido a exame(s) específico(s) para verificação de possível doença decorrente do trabalho.<p>
				5º EMP corresponde avaliação clínica e exames complementares conforme a TABELA DE EXAMES MÉDICOS OCUPACIONAIS, com periodicidade e abrangências definidas na TABELA PERIOCIDADE DE EXAMES.<p>
				6º EMRT compreende avaliação clínica, a critério do médico examinador, se necessários exames complementares, exclusivamente para fins de diagnóstico.<p>
				7º Na realização do EMRT, quando o prazo para o EMP estiver vencido ou previsto para os próximos 60 dias, este deverá ser realizado juntamente com o de EMRT obedecendo aos critérios próprios, devendo o médico examinador assinalar os dois exames, não só na Ficha Médica de Exame Ocupacional como no ASO.<p>
				8º No caso de EMD de empregados que executam atividades que envolvam riscos ocupacionais, é obrigatória a realização de exames complementares específicos, em função do agente agressor.<p>
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
				<b>5.	METODOLOGIA</b><p>
				1º Ao realizar o EMO, o médico examinador preencherá o Prontuário Médico Ocupacional e fará constar no ASO as seguintes conclusões:<p>
       			•	TIPO I - APTO<p>
  				•	TIPO II – INAPTO<p>
				A.	No caso de conclusão do tipo II, deverão ser detalhadas as razões que determinam inaptidão.<p>
				B.	No caso do tipo I, se houver restrições, com base no estabelecido no item anterior, o Médico de Trabalho Coordenador do PCMSO deverá avaliar o caso, definir as atividades que o empregado poderá exercer e, se for o caso, encaminhar para reaproveitamento funcional.<p>
				2º. O médico examinador, ao término do exame, deverá, também, assinar o ASO.<p>
				3º. O Atestado de Saúde Ocupacional – ASO será emitido em duas vias.<p>
				4º. A primeira via do ASO ficará arquivada na Empresa, devendo conter a assinatura do empregado, atestando o recebimento da segunda  via.<p>
				5º. A segunda via do ASO será, obrigatoriamente, entregue ao empregado.<p>
				6º. O Prontuário Médico Ocupacional deverá ser arquivado pelo prazo de 20 (vinte) anos. Após o desligamento do empregado.<p>
				7º. Somente o médico e o empregado poderão ter acesso às informações do Prontuário Médico Ocupacional; habitualmente, e excepcionalmente o fiscal, no caso de se tratar de fiscal médico, caso contrário vale a primeira recomendação.
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

<!---------------------8ª PÁGINA--------------->
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
		<td align="center">
		<p><b><h1>Programa de Controle Médico de Saúde Ocupacional <p> PCMSO – <?php if($rr[data_criacao]){ echo date("Y", strtotime($rr[data_criacao])); } ?> <p> EXAMES MÉDICOS OCUPACIONAIS E PROCEDIMENTOS</b></h1>
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
				<b>6.	PROCEDIMENTO – EXAMES COMPLEMENTARES</b><p>
				O médico examinador de acordo com a avaliação clínica solicitará no ASO os exames complementares a serem realizados, nos casos cabíveis para diagnósticos, pelas rotinas previamente estabelecidas de acordo com os Quadros I e II da NR-7.<p>
				- O ASO só será emitido após aprovação da empresa para realização dos exames solicitados e o retorno do candidato/ empregado para a avaliação dos resultados e parecer final do médico examinador.<p>
				- Os resultados dos exames serão avaliados e anotados no Prontuário Médico Ocupacional do empregado, pelo médico examinador, após isto será entregue ao candidato/ empregado.<p>
				OBSERVAÇÕES:<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. A responsabilidade do encaminhamento dos candidatos a empregos e/ ou empregados para a realização dos exames complementares solicitados, é exclusivamente da Empresa.<p>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. A NR-7 torna obrigatória a realização dos Exames Médicos Ocupacionais, que compreendem avaliação clínica e exames complementares solicitados, inviabiliza a monitorizarão dos indicadores biológicos.<p>
				<b>7.	ESTRATÉGIA</b><p>
				Sendo verificada, através do Exame Médico Ocupacional, exposição excessiva a agentes de risco, mesmo sem qualquer sintomatologia ou sinal clínico, o trabalhador deverá ser afastado do local de trabalho, ou do risco, até que seja normalizada a situação e as medidas de controle nos ambientes de trabalho tenham sido adotadas.<p>
				Sendo constatada a ocorrência ou agravamento de doença profissional, ou verificadas alterações que revelem qualquer tipo de disfunção de órgão ou sistema biológico, mesmo sem sintomatologia, adotar as seguintes condutas:<br>
				1º Afastar, imediatamente o empregado da exposição ao agente causador de risco;<p>
				2º Emitir Comunicação de Acidente do Trabalho – CAT, em 6 (seis) vias, de acordo com  a  ordem de serviço 329 – INSS – DSS 26/10/93 – LTPS /94;<p>
				3º Encaminhar o empregado a Previdência Social, para estabelecimento de anexo causal de definição de conduta;<p>
				4º Adotar medidas de correção e controle no ambiente de trabalho.
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
				<b>8. RESPONSABILIDADE E ATRIBUIÇÕES</b><p>
				<b>EMPREGADOR</b><p>
				&bull; Garantir a elaboração e efetiva implementação, bem como zelar pela sua eficácia;<br>&bull; Custear todos os procedimentos relativos a implantação do  PCMSO;<br>&bull; Indicar o médico coordenador como responsável pela execução do PCMSO.<p>
				<b>SUPERVISORES</b><p>
				&bull; Fornecer as informações necessárias à elaboração e execução do PCMSO;<br>&bull; Garantir a liberação, durante a execução do serviço, dos funcionários para os Procedimentos previstos no PCMSO junto ao médico do trabalho examinador;<br>&bull; Exigir dos funcionários a execução e o cumprimento dos pedidos dos médicos do trabalho, referente ao PCMSO.<br>&bull; Advertir os funcionários que não cumprirem as normas de convocação para exames periódicos.<p>
				<b>EMPREGADOS</b><p>
				&bull; Submeter-se aos exames clínicos e complementares, quando convocado;<br>&bull; Seguir as orientações expedidas pelo médico coordenador;<br>&bull; Levantar e dar ciência ao serviço médico e a segurança do trabalho de situações que possam provocar doenças profissionais.<p>
				<b>MÉDICO COORDENADOR</b><p>
				&bull; Realizar os exames necessários previstos na NR-7;<br>&bull; Indicar entidades capacitadas, equipadas e qualificadas a realizarem os exames complementares;<br>&bull; Manter o arquivo de prontuários clínicos e análise ocupacional;<br>&bull; Solicitar à empresa, quando necessário a emissão da CAT Comunicação de Acidentes do Trabalho.<p>
				<b>DEPARTAMENTO DE RECURSOS HUMANOS / Depto. PESSOAL.</b><p>
				&bull; Dar ciência ao serviço médico dos procedimentos organizacionais necessários à execução do PCMSO;<br>&bull; Aplicar as seções disciplinares cabíveis quando não forem cumpridos os procedimentos previstos neste PCMSO e nas Normas de Procedimentos de Saúde Ocupacional pelos funcionários.
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
		AND cs.id_ppra = $_GET[id_ppra]";
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
			AND cs.id_ppra = $_GET[id_ppra]";

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
					AND cs.id_ppra = rs.id_ppra
					AND cs.cod_setor = {$row_s[$x][cod]}
					AND cs.id_ppra = $_GET[id_ppra]";
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
						$efetivo = "SELECT cod_cgrt, f.* FROM funcionarios f, cgrt_func_list l
									WHERE (f.setor_adicional like '{$row_s[$x]['cod']}|%' AND f.cod_cliente = $cliente AND l.cod_cgrt = $_GET[id_ppra] AND f.cod_func = l.cod_func)
									OR (f.setor_adicional like '%|{$row_s[$x]['cod']}|%' AND f.cod_cliente = $cliente AND l.cod_cgrt = $_GET[id_ppra] AND f.cod_func = l.cod_func)
									OR (f.cod_setor = {$row_s[$x]['cod']} AND f.cod_cliente = $cliente AND l.cod_cgrt = $_GET[id_ppra] AND f.cod_func = l.cod_func)";
						
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
								AND cs.cod_setor = {$row_s[$x][cod]}
								AND cs.id_ppra = $_GET[id_ppra]";
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
								AND cs.cod_setor = {$row_s[$x][cod]}
								AND cs.id_ppra = $_GET[id_ppra]";
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
$relacao = "SELECT f.*, fu.nome_funcao
			FROM funcionarios f, funcao fu, cgrt_func_list l
			WHERE f.cod_funcao = fu.cod_funcao
			AND f.cod_func = l.cod_func
			AND l.cod_cgrt = {$_GET[id_ppra]}
			AND f.cod_cliente = $cliente
			ORDER BY nome_func";
$rela = pg_query($connect, $relacao);

$tem = array();
while($real = pg_fetch_array($rela)){
$asos = "SELECT * FROM aso WHERE cod_cliente = $real[cod_cliente] AND cod_func = $real[cod_func] order by aso_data desc";
$r_aso = pg_query($connect, $asos);
$ra = pg_fetch_array($r_aso);

	if(pg_num_rows($r_aso) > 0){
		$fuc = "<tr>
			<td align=left class=fontepreta12> {$real[nome_func]}&nbsp;</td>
			<td align=left class=fontepreta12> {$real[nome_funcao]}&nbsp;</td>
			<td align=center class=fontepreta12> {$real[data_admissao_func]}&nbsp;</td>
			<td align=center class=fontepreta12>"; 
			$fuc .= date("d/m/Y", strtotime($ra[aso_data]))."&nbsp;</td>
		</tr>";
	}else{
		$fuc = "<tr>
			<td align=left class=fontepreta12> {$real[nome_func]}&nbsp;</td>
			<td align=left class=fontepreta12> {$real[nome_funcao]}&nbsp;</td>
			<td align=center class=fontepreta12> {$real[data_admissao_func]}&nbsp;</td>
			<td align=center class=fontepreta12> {$real[data_ultimo_exame]}&nbsp;</td>
		</tr>";
	}

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
		<table align="center" width="694" border="0">
		<tr>
			<td align="justify" class="fontepreta12">OBS: Recomenda-se que a lista nominal, documento de identificação e data do último exame  dos colaboradores por setor, conste nos mesmos de acordo com suas funções e dinâmica da função.</td>
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
					$sql = "select data_criacao from cliente_setor where cod_cliente = $cliente and id_ppra = $_GET[id_ppra]";
					$res = pg_query($connect, $sql);
					$row_d = pg_fetch_array($res);
					echo date("d", strtotime($row_d[data_criacao]))." de ".$meses[date("n", strtotime($row_d[data_criacao]))]." de ".date("Y", strtotime($row_d[data_criacao]));
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
			FROM funcionarios f, funcao fu, cgrt_func_list l
			WHERE f.cod_funcao = fu.cod_funcao
			AND f.cod_func = l.cod_func
			AND l.cod_cgrt = {$_GET[id_ppra]}
			AND f.cod_cliente = {$cliente}
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
				AND fu.cod_funcao = {$row_qnt[$e][cod_funcao]}
				AND cs.id_ppra = $_GET[id_ppra]";
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
					AND rs.id_ppra = $_GET[id_ppra]
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
				for($e=$i;$e<$i+5;$e++){
				    if($row_qnt[$e][cod_funcao]){
					$comp = "SELECT distinct(fe.descricao), fu.nome_funcao
							FROM funcionarios f, funcao fu, funcao_exame fe
							WHERE f.cod_funcao = fu.cod_funcao
							AND fu.cod_funcao = fe.cod_exame
							AND f.cod_cliente = $cliente
							AND fu.cod_funcao = {$row_qnt[$e][cod_funcao]}";
					$cp = pg_query($connect, $comp);
					$ex = pg_fetch_all($cp);

					echo "<b>".$ex[0][nome_funcao]."</b>-";
					for($r=0;$r<pg_num_rows($cp);$r++){
						echo $ex[$r][descricao].",&nbsp;";
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
			FROM funcionarios f, funcao fu, cgrt_func_list l
			WHERE f.cod_funcao = fu.cod_funcao
			AND f.cod_func = l.cod_func
			AND l.cod_cgrt = {$_GET[id_ppra]}
			AND f.cod_cliente = {$cliente}
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
				AND fu.cod_funcao = {$row_qnt[$e][cod_funcao]}
				AND cs.id_ppra = $_GET[id_ppra]";
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
					AND rs.id_ppra = $_GET[id_ppra]
					AND fu.cod_funcao = {$row_qnt[$e][cod_funcao]}";
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
				for($e=$i;$e<$i+5;$e++){
				    if($row_qnt[$e][cod_funcao]){
					$comp = "SELECT distinct(fe.descricao), fu.nome_funcao
							FROM funcionarios f, funcao fu, funcao_exame fe
							WHERE f.cod_funcao = fu.cod_funcao
							AND fu.cod_funcao = fe.cod_exame
							AND f.cod_cliente = $cliente
							AND fu.cod_funcao = {$row_qnt[$e][cod_funcao]}";
					$cp = pg_query($connect, $comp);
					$ex = pg_fetch_all($cp);
					
					for($q=0;$q<pg_num_rows($cp);$q++){
						$dentro[] = $ex[$q][descricao];
					}	

					echo "<b>".$ex[0][nome_funcao]."</b>-";
					for($r=0;$r<pg_num_rows($cp);$r++){
						echo $ex[$r][descricao].",&nbsp;";
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
					$sql = "select data_criacao from cliente_setor where cod_cliente = $cliente AND id_ppra = $_GET[id_ppra]";
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
			$sql = "select data_criacao from cliente_setor where cod_cliente = $cliente AND id_ppra = $_GET[id_ppra]";
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
					$sql = "select data_criacao from cliente_setor where cod_cliente = $cliente AND id_ppra = $_GET[id_ppra]";
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
			  $dt = "SELECT data_criacao FROM cliente_setor WHERE cod_cliente = $cliente AND id_ppra = $_GET[id_ppra]";
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
<?php
$rela = "SELECT nome_func, nome_funcao, data_admissao_func, num_ctps_func, serie_ctps_func, data_nasc_func, f.cbo 
		FROM funcionarios f, funcao fu, cgrt_func_list l
		WHERE f.cod_funcao = fu.cod_funcao
		AND f.cod_func = l.cod_func
		AND l.cod_cgrt = $_GET[id_ppra]
		AND f.cod_cliente = $cliente
		ORDER BY nome_func";
$rel = pg_query($connect, $rela);

$te = array();
while($rl = pg_fetch_array($rel)){

	$fc = "<tr>
		<td width=200 align=left class=fontepreta12> {$rl[nome_func]}&nbsp;</td>
		<td width=190 align=left class=fontepreta12> {$rl[nome_funcao]}&nbsp;</td>
		<td width=90 align=center class=fontepreta12> {$rl[data_admissao_func]}&nbsp;</td>
		<td width=80 align=center class=fontepreta12> {$rl[num_ctps_func]}&nbsp;</td>
		<td width=90 align=center class=fontepreta12> {$rl[data_nasc_func]}&nbsp;</td>
		<td width=60 align=center class=fontepreta12> {$rl[cbo]}&nbsp;</td>
	</tr>";
	
$te[] = addslashes($fc);
} 
//LOOP PARA COLOCAR O MÁXIMO DE RESULTADO NA TELA
for ($y=0;$y<ceil(count($te)/20);$y++) { ?>
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
		</table>
		<table align="center" width="695" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="250" align="center" bgcolor="#999999" class="fontepreta12bold">Nome</td>
				<td width="200" align="center" bgcolor="#999999" class="fontepreta12bold">Função</td>
				<td width="60" align="center" bgcolor="#999999" class="fontepreta12bold">Admissão</td>
				<td width="60" align="center" bgcolor="#999999" class="fontepreta12bold">Documento</td>
				<td width="60" align="center" bgcolor="#999999" class="fontepreta12bold">Dt. Nasc.</td>
				<td width="60" align="center" bgcolor="#999999" class="fontepreta12bold">CBO</td>
			</tr>
		<?php
			$i = $y*20;
			for($x=$i;$x<$i+20;$x++){ 
			   echo $te[$x];			
			}
		?>
		</table>
		<table align="center" width="694" border="0">
		<tr>
			<td align="justify" class="fontepreta12">OBS: Recomenda-se que a lista nominal, documento de identificação e data do último exame  dos colaboradores por setor, conste nos mesmos de acordo com suas funções e dinâmica da função.</td>
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
<!---------------------RELATÓRIO ANUAL FINAL--------------->
<?php
$xi = array();
//BUSCA FUNÇÕES
$tim = "SELECT distinct(nome_funcao), fu.cod_funcao
		FROM funcionarios f, funcao fu, cgrt_func_list l
		WHERE f.cod_funcao = fu.cod_funcao
		and f.cod_func = l.cod_func
		and f.cod_cliente = l.cod_cliente
		AND l.cod_cgrt = $_GET[id_ppra]";
$result = pg_query($connect, $tim);
$rr = pg_fetch_all($result);
for($x=0;$x<pg_num_rows($result);$x++){

//BUSCA OS EXAMES
$exa = "SELECT distinct(fe.descricao)
				FROM funcionarios f, aso a, funcao_exame fe
				WHERE f.cod_funcao = fe.cod_exame
				AND f.cod_cliente = $cliente
				AND f.cod_funcao = {$rr[$x][cod_funcao]}";
		$r_exa = pg_query($connect, $exa);
		$row_exa = pg_fetch_all($r_exa);
	
if(pg_num_rows($r_exa)){

	$tx = "<tr>
		<td width=100 align=left class=fontepreta12> {$rr[$x][nome_funcao]}&nbsp; </td>
		<td width=250 align=left class=fontepreta12>";
		
		for($w=0;$w<pg_num_rows($r_exa);$w++){
			$tx .= $row_exa[$w][descricao]; 
			if($w<pg_num_rows($r_exa)-1) $tx .= " + ";
		}
		$tx .= "&nbsp;
		
		</td>
		<td width=85 align=center class=fontepreta12>";
		
		$fcn = "SELECT f.cod_func, aso_data
				FROM funcionarios f, aso a
				WHERE f.cod_setor = a.cod_setor
				AND f.cod_func = a.cod_func
				AND f.cod_cliente = a.cod_cliente
				AND f.cod_cliente = $cliente
				AND f.cod_funcao = {$rr[$x][cod_funcao]}
				AND (a.aso_resultado = 'Apto' 
				OR a.aso_resultado = 'Apto à manipular alimentos'
				OR a.aso_resultado = 'Apto para trabalhar em altura' 
				OR a.aso_resultado = 'Apto para operar empilhadeira' 
				OR a.aso_resultado = 'Apto para trabalhar em espaço confinado' 
				OR a.aso_resultado = 'Apto com Restrição'
				OR a.aso_resultado = '__________')";
		$r_fcn = pg_query($connect, $fcn);
		$row_fcn = pg_fetch_all($r_fcn);
		
		if(pg_num_rows($r_fcn) <= 0){
			$ner = "SELECT count(f.cod_func) as cod_func
					FROM funcionarios f, funcao fu, cgrt_func_list l
					WHERE f.cod_funcao = fu.cod_funcao
					AND f.cod_func = l.cod_func
					AND f.cod_cliente = l.cod_cliente
					AND f.cod_funcao = {$rr[$x][cod_funcao]}
					AND l.cod_cgrt = $_GET[id_ppra]
					AND f.data_ultimo_exame != '' ";
			$r_ner = pg_query($connect, $ner);
			$row_ner = pg_fetch_all($r_ner);
			for($sm=0;$sm<pg_num_rows($r_ner);$sm++){
				$normal = $row_ner[$sm][cod_func];
				$tx .= "{$normal}";
			}
		}else{
			//$aso = "SELECT * FROM aso WHERE cod_cliente = $cliente and $row_fcn[cod_func]";
			//$ass = pg_query($connect, $aso);
			//$r_aso = pg_fetch_all($ass);
			/*
			for($q=0;$q<pg_num_rows($r_fcn);$q++){
				$normal = $row_fcn[$q][cod_func];
				$tx .= "{$normal}";
			}*/
			$normal= pg_num_rows($r_fcn);
			$tx .= $normal;
		}
				
		$tx .= "</td>
		<td width=85 align=center class=fontepreta12>";
		
		$anm = "SELECT count(f.cod_func) as fi
				FROM funcionarios f, aso a
				WHERE f.cod_setor = a.cod_setor
				AND f.cod_func = a.cod_func
				AND f.cod_cliente = a.cod_cliente
				AND f.cod_cliente = $cliente
				AND f.cod_funcao = {$rr[$x][cod_funcao]}
				AND a.aso_resultado = 'Inapto'";
		$r_anm = pg_query($connect, $anm);
		$row_anm = pg_fetch_all($r_anm);

		for($i=0;$i<pg_num_rows($r_anm);$i++){
			$anormal = $row_anm[$i][fi];
			$tx .= "{$anormal}"; 
		}
		
		$tx .= "</td>
		<td width=85 align=center class=fontepreta12>";
		
		$tt = $normal - $anormal;
		$tot = @((($tt * 100)/$normal));
		$tx .= $tot."%";
		
		$tx .= "</td>
		<td width=85 align=center class=fontepreta12>";
		
		$tx .= "{$normal}
		</td>
	</tr>";	
$xi[] = addslashes($tx);
	}
}
//LOOP PARA COLOCAR O MÁXIMO DE RESULTADO NA TELA
for ($b=0;$b<ceil(count($xi)/7);$b++) { ?>
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
				<td align="center" class="fontepreta12"><h2>Relatório Anual <?php echo date("Y", strtotime($row[data_criacao]))." / ".(date("Y", strtotime($row[data_criacao]))+1); ?> </h2></td>
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
			$z = $b*7;
			for($k=$z;$k<$z+7;$k++){ 
			   echo $xi[$k];			
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
<?php } ?>
</form>
</body>
</html>
