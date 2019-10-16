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

/*************QUANTIDADE DE FUNCION�RIOS MASCULINOS************/
$masc = "SELECT sexo_func, f.cod_cliente 
		FROM funcionarios f, cgrt_func_list l
		WHERE f.cod_cliente = $cliente
		AND f.cod_func = l.cod_func
		AND l.cod_cgrt = $_GET[id_ppra]
		AND sexo_func = 'Masculino'";
$result = pg_query($masc);
$nmasc = pg_num_rows($result);

/*************QUANTIDADE DE FUNCION�RIOS FEMININOS************/
$fem = "SELECT sexo_func, f.cod_cliente 
		FROM funcionarios f, cgrt_func_list l
		WHERE f.cod_cliente = $cliente
		AND f.cod_func = l.cod_func
		AND l.cod_cgrt = $_GET[id_ppra]
		AND sexo_func = 'Feminino'";
$result = pg_query($fem);
$nfem = pg_num_rows($result);

/*************QUANTIDADE DE FUNCION�RIOS************/
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

/*************N�MERO DE FUNCION�RIOS DA TABELA CGRT*****************/
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
<!---------------------1� P�GINA--------------->
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
		<h1>PROGRAMA DE CONTROLE M�DICO E DE SA�DE OCUPACIONAL</h1>
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
<!---------------------3� P�GINA--------------->
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
			<td width="199" class="tabela">Raz�o Social:</td>
			<td class="tabela"><?php echo $rr[razao_social]; ?></td>
		</tr>
		<tr>
			<td width="199" class="tabela">Endere�o:</td>
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
			<td width="199" class="tabela">Respons�vel:</td>
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
		<table align="center" width="500" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="center"><h1>APRESENTA��O</h1></td>
			</tr>
			<tr>
				<td align="justify" class="fontepreta14">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O presente trabalho tem como objetivo Sistematizar as A��es desenvolvidas na empresa, atendendo as Exig�ncias da nova NR-7 criada pela Secretaria de Seguran�a e Medicina do Trabalho, em vigor desde 30/12/1994 que vem estabelecer um controle da sa�de de todos os Empregados. O car�ter preventivo permeia todo o texto, o que demonstra a preocupa��o da Empresa com a qualidade de vida dos seus empregados.
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
		<table align="center" width="698" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="justify" class="fontepreta12">
				<b>SUM�RIO</b><p>
				1. CONSIDERA��ES INICIAIS<br>2. OBJETIVOS � GERAIS E/OU ESPEC�FICOS<br>3. DEFINI��ES E COMPOSI��O DO PCMSO<br>4. DIRETRIZES<br>5. METODOLOGIA<br>6. PROCEDIMENTO � EXAMES COMPLEMENTARES<br>7. ESTRAT�GIA<br>8. RESPONSABILIDADE E ATRIBUI��ES<br>9. DESCRI��O SETORIAL DAS INSTALA��ES DA EMPRESA<br>10. SISTEMATIZA��O SETORIAL<br>11. DADOS CADASTRAIS DOS FUNCION�RIOS E CRONOGRAMA DE EXAMES<br>12. CONSIDERA��ES FINAIS
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
		<table align="center" width="698" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="left" class="fontepreta12">
				<b>1.	CONSIDERA��ES INICIAIS</b><p align="justify">
				
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No momento em que o mundo passa por profundas transforma��es, que trazem em seu rastro novas formas de produ��o, que remodelam as estruturas organizacionais, o interesse com a qualidade de vida se torna indispens�vel.<p align="justify">
				
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O homem neste contexto se constitui em objeto de preocupa��o para as empresas, que buscam atrav�s de diversos programas atender suas necessidades de bem estar f�sico e mental.<p align="justify">
				
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dentre esses programas encontra-se o Programa de Controle M�dico da Sa�de Ocupacional � PCMSO, que vem resgatar o compromisso com a sa�de do trabalho, com rela��o a defini��o de condutas de preserva��o da sa�de trazendo em seu bojo o compromisso com a melhoria da qualidade de vida do empregado.
				<p>
				</td>
			</tr>
			<tr>
				<td align="left" class="fontepreta12">
				<b>2.	OBJETIVOS</b><p>
				<table align="left" width="350" border="1" bordercolor="#000000">
					<tr>
						<td align="center" width="170" class="fontepreta14">GERAIS</td>
						<td align="center" width="170" class="fontepreta14">ESPEC�FICOS</td>
					</tr>
					<tr>
						<td align="left" valign="top" class="fontepreta12">a- Prevenir, controlar, avaliar e conhecer as condi��es de sa�de dos trabalhadores.<p>b- Atender a pol�tica, princ�pios e valores de qualidade da empresa.</td>
						<td align="left" class="fontepreta12">a- Desenvolver a��es que contribuam para a melhoria da qualidade de vida do empregado;<p>b- Promover campanhas educativas voltadas para o investimento na sa�de;<p>c- Atender as exig�ncias do Minist�rio do Trabalho atrav�s da NR-07, publicada em 30.12.94 no D.O.U.<p>d-  Acatar o estabelecido, na portaria 3.214/78 do MTb e da portaria 24/94 do SST, NR7.</td>
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
				<b>3.	DEFINI��ES E COMPOSI��O DO PCMSO</b><p>
				<b>EXAMES M�DICOS OCUPACIONAIS (EMO)</b> � s�o exames m�dicos a que s�o submetidos os trabalhadores, a fim de serem avaliadas suas condi��es de sa�de e compreendem em Exame B�sico (Avalia��o Cl�nica) e Exames Complementares, tendo em vista o exerc�cio das atividades laborativas.<p>
				<b>EXAME M�DICO ADMISSIONAL (EMA)</b> � exame a que s�o submetidos todos os candidatos, aprovados nas demais etapas do processo seletivo, a fim de serem avaliadas as suas condi��es de sa�de, conhecidas tamb�m como pr�-admissional devido � vis�o da avalia��o do candidato antes da sua contrata��o como medida preventiva e de controle da boa sa�de do quadro funcional.<p>
				<b>EXAMES M�DICOS DE MUDAN�A DE FUN��O (EMMF)</b> � exame a que s�o submetidos, os empregados candidatos � reclassifica��o para cargo ou posto de trabalho que exija do ocupante caracter�stica somato-ps�quicas distintas das do cargo que ocupam, bem como antes de qualquer altera��o de atividade, posto de trabalho ou de �rea, que implique na exposi��o do empregado a risco diferente daquele a que estava exposto anteriormente, o que caracteriza mudan�a de fun��o. Entende-se ainda a promo��o como mudan�a de fun��o, cabe � ger�ncia de coordena��o informar ao servi�o m�dico antes da efetiva��o da mudan�a.<p>
				<b>EXAME M�DICO PERI�DICO (EMP)</b> - exame a que s�o submetidos, em prazos regulares e previamente programados, todos os empregados da empresa ao completarem o ciclo de doze meses do �ltimo exame submetido, podendo ser admissional ou peri�dico.<p>
				<b>EXAME DE RETORNO AO TRABALHO (EMRT)</b> � exame a que s�o submetidos todos os empregados afastados por per�odo igual ou superior a 30 dias, por motivo de doen�as, acidentes, partos e fim de f�rias, no primeiro dia de retorno � atividade submeter-se-� a reavalia��o pelo m�dico do trabalho e recebera o ASO de libera��o ao servi�o.<p>
				<b>EXAME M�DICO DEMISSIONAL (EMD)</b> � exame a que s�o submetidos os empregados, por ocasi�o da cessa��o do contrato de trabalho. � realizado, obrigatoriamente, em todos os casos de demiss�o, desde que o �ltimo Exame M�dico Ocupacional tenha sido realizado h� mais de 90 (Noventa) dias, visa tamb�m o cumprimento da IN 84 de 17.12.2002, anexo XV do INSS/DC. � perfil profissiogr�fico previdenci�rio.<p>
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
				<b>4.	DIRETRIZES</b><p>
				1� A crit�rio do m�dico examinador, em fun��o da avalia��o cl�nica, qualquer outro exame complementar poder� ser solicitado al�m daqueles estabelecidos, somente para esclarecimento de diagn�stico e n�o para acompanhamento de tratamento, sendo neste caso, integralmente custeado pela Empresa.
				2� EMMF compreende avalia��o cl�nica e exames complementares previstos para o novo cargo/posto de trabalho que n�o tenham sido realizados no EMP de acordo com a TABELA DE EXAMES M�DICOS OCUPACIONAIS.<p>
				3� Quando o EMMF estiver programado para o per�odo de 90 (noventa) dias antes daquele previsto para o EMP, deve ser feita com antecipa��o deste, dentro da modalidade correspondente observando o disposto acima.<p>
				4� Ao deixar o trabalho em atividade que desenvolve risco, o empregado deve ser submetido a exame(s) espec�fico(s) para verifica��o de poss�vel doen�a decorrente do trabalho.<p>
				5� EMP corresponde avalia��o cl�nica e exames complementares conforme a TABELA DE EXAMES M�DICOS OCUPACIONAIS, com periodicidade e abrang�ncias definidas na TABELA PERIOCIDADE DE EXAMES.<p>
				6� EMRT compreende avalia��o cl�nica, a crit�rio do m�dico examinador, se necess�rios exames complementares, exclusivamente para fins de diagn�stico.<p>
				7� Na realiza��o do EMRT, quando o prazo para o EMP estiver vencido ou previsto para os pr�ximos 60 dias, este dever� ser realizado juntamente com o de EMRT obedecendo aos crit�rios pr�prios, devendo o m�dico examinador assinalar os dois exames, n�o s� na Ficha M�dica de Exame Ocupacional como no ASO.<p>
				8� No caso de EMD de empregados que executam atividades que envolvam riscos ocupacionais, � obrigat�ria a realiza��o de exames complementares espec�ficos, em fun��o do agente agressor.<p>
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
				<b>5.	METODOLOGIA</b><p>
				1� Ao realizar o EMO, o m�dico examinador preencher� o Prontu�rio M�dico Ocupacional e far� constar no ASO as seguintes conclus�es:<p>
       			�	TIPO I - APTO<p>
  				�	TIPO II � INAPTO<p>
				A.	No caso de conclus�o do tipo II, dever�o ser detalhadas as raz�es que determinam inaptid�o.<p>
				B.	No caso do tipo I, se houver restri��es, com base no estabelecido no item anterior, o M�dico de Trabalho Coordenador do PCMSO dever� avaliar o caso, definir as atividades que o empregado poder� exercer e, se for o caso, encaminhar para reaproveitamento funcional.<p>
				2�. O m�dico examinador, ao t�rmino do exame, dever�, tamb�m, assinar o ASO.<p>
				3�. O Atestado de Sa�de Ocupacional � ASO ser� emitido em duas vias.<p>
				4�. A primeira via do ASO ficar� arquivada na Empresa, devendo conter a assinatura do empregado, atestando o recebimento da segunda  via.<p>
				5�. A segunda via do ASO ser�, obrigatoriamente, entregue ao empregado.<p>
				6�. O Prontu�rio M�dico Ocupacional dever� ser arquivado pelo prazo de 20 (vinte) anos. Ap�s o desligamento do empregado.<p>
				7�. Somente o m�dico e o empregado poder�o ter acesso �s informa��es do Prontu�rio M�dico Ocupacional; habitualmente, e excepcionalmente o fiscal, no caso de se tratar de fiscal m�dico, caso contr�rio vale a primeira recomenda��o.
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

<!---------------------8� P�GINA--------------->
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
		<p><b><h1>Programa de Controle M�dico de Sa�de Ocupacional <p> PCMSO � <?php if($rr[data_criacao]){ echo date("Y", strtotime($rr[data_criacao])); } ?> <p> EXAMES M�DICOS OCUPACIONAIS E PROCEDIMENTOS</b></h1>
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
				<b>6.	PROCEDIMENTO � EXAMES COMPLEMENTARES</b><p>
				O m�dico examinador de acordo com a avalia��o cl�nica solicitar� no ASO os exames complementares a serem realizados, nos casos cab�veis para diagn�sticos, pelas rotinas previamente estabelecidas de acordo com os Quadros I e II da NR-7.<p>
				- O ASO s� ser� emitido ap�s aprova��o da empresa para realiza��o dos exames solicitados e o retorno do candidato/ empregado para a avalia��o dos resultados e parecer final do m�dico examinador.<p>
				- Os resultados dos exames ser�o avaliados e anotados no Prontu�rio M�dico Ocupacional do empregado, pelo m�dico examinador, ap�s isto ser� entregue ao candidato/ empregado.<p>
				OBSERVA��ES:<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. A responsabilidade do encaminhamento dos candidatos a empregos e/ ou empregados para a realiza��o dos exames complementares solicitados, � exclusivamente da Empresa.<p>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. A NR-7 torna obrigat�ria a realiza��o dos Exames M�dicos Ocupacionais, que compreendem avalia��o cl�nica e exames complementares solicitados, inviabiliza a monitorizar�o dos indicadores biol�gicos.<p>
				<b>7.	ESTRAT�GIA</b><p>
				Sendo verificada, atrav�s do Exame M�dico Ocupacional, exposi��o excessiva a agentes de risco, mesmo sem qualquer sintomatologia ou sinal cl�nico, o trabalhador dever� ser afastado do local de trabalho, ou do risco, at� que seja normalizada a situa��o e as medidas de controle nos ambientes de trabalho tenham sido adotadas.<p>
				Sendo constatada a ocorr�ncia ou agravamento de doen�a profissional, ou verificadas altera��es que revelem qualquer tipo de disfun��o de �rg�o ou sistema biol�gico, mesmo sem sintomatologia, adotar as seguintes condutas:<br>
				1� Afastar, imediatamente o empregado da exposi��o ao agente causador de risco;<p>
				2� Emitir Comunica��o de Acidente do Trabalho � CAT, em 6 (seis) vias, de acordo com  a  ordem de servi�o 329 � INSS � DSS 26/10/93 � LTPS /94;<p>
				3� Encaminhar o empregado a Previd�ncia Social, para estabelecimento de anexo causal de defini��o de conduta;<p>
				4� Adotar medidas de corre��o e controle no ambiente de trabalho.
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
				<b>8. RESPONSABILIDADE E ATRIBUI��ES</b><p>
				<b>EMPREGADOR</b><p>
				&bull; Garantir a elabora��o e efetiva implementa��o, bem como zelar pela sua efic�cia;<br>&bull; Custear todos os procedimentos relativos a implanta��o do  PCMSO;<br>&bull; Indicar o m�dico coordenador como respons�vel pela execu��o do PCMSO.<p>
				<b>SUPERVISORES</b><p>
				&bull; Fornecer as informa��es necess�rias � elabora��o e execu��o do PCMSO;<br>&bull; Garantir a libera��o, durante a execu��o do servi�o, dos funcion�rios para os Procedimentos previstos no PCMSO junto ao m�dico do trabalho examinador;<br>&bull; Exigir dos funcion�rios a execu��o e o cumprimento dos pedidos dos m�dicos do trabalho, referente ao PCMSO.<br>&bull; Advertir os funcion�rios que n�o cumprirem as normas de convoca��o para exames peri�dicos.<p>
				<b>EMPREGADOS</b><p>
				&bull; Submeter-se aos exames cl�nicos e complementares, quando convocado;<br>&bull; Seguir as orienta��es expedidas pelo m�dico coordenador;<br>&bull; Levantar e dar ci�ncia ao servi�o m�dico e a seguran�a do trabalho de situa��es que possam provocar doen�as profissionais.<p>
				<b>M�DICO COORDENADOR</b><p>
				&bull; Realizar os exames necess�rios previstos na NR-7;<br>&bull; Indicar entidades capacitadas, equipadas e qualificadas a realizarem os exames complementares;<br>&bull; Manter o arquivo de prontu�rios cl�nicos e an�lise ocupacional;<br>&bull; Solicitar � empresa, quando necess�rio a emiss�o da CAT Comunica��o de Acidentes do Trabalho.<p>
				<b>DEPARTAMENTO DE RECURSOS HUMANOS / Depto. PESSOAL.</b><p>
				&bull; Dar ci�ncia ao servi�o m�dico dos procedimentos organizacionais necess�rios � execu��o do PCMSO;<br>&bull; Aplicar as se��es disciplinares cab�veis quando n�o forem cumpridos os procedimentos previstos neste PCMSO e nas Normas de Procedimentos de Sa�de Ocupacional pelos funcion�rios.
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
<!---------------------13� P�GINA--------------->
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
		<table align="center" width="694" border="0">
		<tr>
			<td align="justify" class="fontepreta12">OBS: Recomenda-se que a lista nominal, documento de identifica��o e data do �ltimo exame  dos colaboradores por setor, conste nos mesmos de acordo com suas fun��es e din�mica da fun��o.</td>
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
					$sql = "select data_criacao from cliente_setor where cod_cliente = $cliente and id_ppra = $_GET[id_ppra]";
					$res = pg_query($connect, $sql);
					$row_d = pg_fetch_array($res);
					echo date("d", strtotime($row_d[data_criacao]))." de ".$meses[date("n", strtotime($row_d[data_criacao]))]." de ".date("Y", strtotime($row_d[data_criacao]));
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
					$sql = "select data_criacao from cliente_setor where cod_cliente = $cliente AND id_ppra = $_GET[id_ppra]";
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
			$sql = "select data_criacao from cliente_setor where cod_cliente = $cliente AND id_ppra = $_GET[id_ppra]";
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
//LOOP PARA COLOCAR O M�XIMO DE RESULTADO NA TELA
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
				<td align="center" class="fontepreta12"><h2>Rela��o de Funcion�rios</h2></td>
			</tr>
		</table>
		<table align="center" width="695" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td width="250" align="center" bgcolor="#999999" class="fontepreta12bold">Nome</td>
				<td width="200" align="center" bgcolor="#999999" class="fontepreta12bold">Fun��o</td>
				<td width="60" align="center" bgcolor="#999999" class="fontepreta12bold">Admiss�o</td>
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
			<td align="justify" class="fontepreta12">OBS: Recomenda-se que a lista nominal, documento de identifica��o e data do �ltimo exame  dos colaboradores por setor, conste nos mesmos de acordo com suas fun��es e din�mica da fun��o.</td>
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
<!---------------------RELAT�RIO ANUAL FINAL--------------->
<?php
$xi = array();
//BUSCA FUN��ES
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
				OR a.aso_resultado = 'Apto � manipular alimentos'
				OR a.aso_resultado = 'Apto para trabalhar em altura' 
				OR a.aso_resultado = 'Apto para operar empilhadeira' 
				OR a.aso_resultado = 'Apto para trabalhar em espa�o confinado' 
				OR a.aso_resultado = 'Apto com Restri��o'
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
//LOOP PARA COLOCAR O M�XIMO DE RESULTADO NA TELA
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
				<td align="center" class="fontepreta12"><h2>Relat�rio Anual <?php echo date("Y", strtotime($row[data_criacao]))." / ".(date("Y", strtotime($row[data_criacao]))+1); ?> </h2></td>
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
