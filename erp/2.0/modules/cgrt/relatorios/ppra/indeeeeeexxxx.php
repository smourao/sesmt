<?PHP
/*****************************************************************************************************************/
// -> INCLUDES / DEFINES
/*****************************************************************************************************************/
define('_MPDF_PATH', '../../../../common/MPDF45/');
define('_IMG_PATH', '../../../../images/');
include(_MPDF_PATH.'mpdf.php');
include("../../../../common/database/conn.php");

/*****************************************************************************************************************/
// -> VARS
/*****************************************************************************************************************/
$cod_cgrt = (int)(base64_decode($_GET[cod_cgrt]));
$code     = "";
$header_h = 130;//header height; 175
$footer_h = 170;//footer height;
$meses    = array('', 'Janeiro',  'Fevereiro', 'Mar�o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$m        = array(" ", "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");
$title    = "PROGRAMA DE PREVEN��O DE RISCOS AMBIENTAIS";

if($_GET[color]){
    $green = '#00FF00';
    $red   = '#FF0000';
    $blue  = '#0000FF';
    $yellow= '#FFF000';
    $brown = '#8D5A00';
}else{
    $green = '#FFFFFF';
    $red   = '#FFFFFF';
    $blue  = '#FFFFFF';
    $yellow= '#FFFFFF';
    $brown = '#FFFFFF';
}

/*****************************************************************************************************************/
// -> CGRT / CLIENTE INFO
/*****************************************************************************************************************/
//Cliente info
$sql = "SELECT cgrt.*, c.*, cnae.* FROM cgrt_info cgrt, cliente c, cnae cnae 
		WHERE cgrt.cod_cgrt = $cod_cgrt AND cgrt.cod_cliente = c.cliente_id AND c.cnae_id = cnae.cnae_id";
$rci = pg_query($sql);
$info = pg_fetch_array($rci);

//Func list
$sql = "SELECT cfl.*,f.*, fun.* FROM cgrt_func_list cfl, funcionarios f, funcao fun
		WHERE cfl.cod_cgrt = $cod_cgrt AND f.cod_cliente = cfl.cod_cliente AND f.cod_func = cfl.cod_func
		AND fun.cod_funcao = cfl.cod_funcao AND cfl.status = 1 AND f.cod_status = 1 ORDER BY f.nome_func";
$rfl = pg_query($sql);
$funclist = pg_fetch_all($rfl);

//Efetivo masculino
$sql = "SELECT count(*) as nfuncmasc FROM funcionarios f, cgrt_func_list l 
		WHERE f.cod_cliente = ".(int)($info[cliente_id])." AND l.cod_cgrt = ".(int)($cod_cgrt)." AND f.cod_func = l.cod_func 
		AND f.sexo_func = 'Masculino' AND l.status = 1";
$efetivo_masc = pg_fetch_array(pg_query($sql));
$efetivo_masc = (int)($efetivo_masc[nfuncmasc]);

//Efetivo feminino
$efetivo_fem = ((int)(pg_num_rows($rfl))-$efetivo_masc);

if($_GET[sem_assinatura]){
    $ass_elaborador  = "<BR><BR><BR><BR><BR><BR><BR>";
    $ass_responsavel = "<BR><BR><BR><BR><BR><BR><BR>";
}else{
    $ass_elaborador  = "<img src='../../../../images/diuliane_assinatura_carimbo.jpg' border='0'>";
	$ass_responsavel = "<img src='http://www.sesmt-rio.com/erp/2.0/images/assinaturas/4048135020_assrenatapb.png' border='0' width='300' height='130'>";
    //$ass_responsavel = "<img src='../../../../images/ass_pedro3.png' border='0'>";
    //$ass_elaborador = "<img src='../../../../images/ass_pedro3.png' border='0'>";
	//$ass_responsavel = "<img src='http://sesmt-rio.com/erp/img/ass_everaldo.PNG' border='0'>";
}

/*****************************************************************************************************************/
// -> BEGIN DOCUMENT
/*****************************************************************************************************************/
ob_start();
    /*************************************************************************************************************/
    // -> HEADER
    /*************************************************************************************************************/
    if($_GET[sem_timbre]){
        $cabecalho  = "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
        $cabecalho .= "<tr>";
        $cabecalho .= "<td align=left height=$header_h valign=top width=270>&nbsp;</td>";
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }else{
        $cabecalho  = "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
        $cabecalho .= "<tr>";
         $cabecalho .= '<td align="left" height=$header_h>
            <p><strong>
            <font size="7" face="Verdana, Arial, Helvetica, sans-serif">SESMT<sup><font size=3>�</font></sup></font>&nbsp;&nbsp;
			<font size="1" face="Verdana, Arial, Helvetica, sans-serif">SERVI�OS ESPECIALIZADOS DE SEGURAN�A<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
			CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></strong>
            </td>';
        $cabecalho .= ' <td width=40% align="right" height=$header_h>
            <font face="Verdana, Arial, Helvetica, sans-serif" size="4">
            <b>Programa de Preven��o de
Riscos Ambientais</b>
            </td>';
        
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }
    /************************************************************************************************************/
    // -> FOOTER
    /************************************************************************************************************/
    //assinatura
    if($_GET[sem_assinatura])
        $rodape  = "";
    else
        $rodape  = "<div style=\"position: relative; text-align: right; width: 100%\"><img src='"._IMG_PATH."renatasite.jpg' border=0 width='180' height='100'></div>";
        //$rodape  = "<div style=\"position: relative; text-align: right; width: 100%\"><img src='http://sesmt-rio.com/erp/img/ass_everaldo.PNG' border=0 width='180' height='110'></div>";
        

    if($_GET[sem_timbre]){
        $rodape .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$footer_h>";
        $rodape .= "<tr>";
		$rodape .= "<td align=left height=$footer_h valign=bottom class='medText'>Telefone: +55 (21) 3014 4304 Fax: Ramal 7<br>Nextel: +55 (21) 7844 6095 / Id 55*23*31641<br>segtrab@sesmt-rio.com<br>www.sesmt-rio.com / www.shoppingsesmt.com</td>";
        $rodape .= "<td align=left height=$footer_h width=207 valign=bottom>&nbsp;</td>";
        $rodape .= "</tr>";
        $rodape .= "</table>";
    }else{
        $rodape .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$footer_h>";
        $rodape .= "<tr>";
        $rodape .= "<td align=left height=$header_h><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Telefone: +55 (21) 3014 4304   Fax: Ramal 7</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Nextel: +55 (21) 9700 31385 - Id 55*23*31641</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=3 >segtrab@sesmt-rio.com</font> / <font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >www.sesmt-rio.com</font></td><td width=130 height=$header_h><font face=\"Verdana, Arial, Helvetica, sans-serif\"><b>
     Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
     </td>";
        $rodape .= "</tr>";
        $rodape .= "</table>";
    }
	$ano = $info[ano];
	$ano2 = $ano+1;
    $code .= "<html>";
    $code .= "<head>";
    $code .= '<link href="../style.css" rel="stylesheet" type="text/css"/>';
    $code .= "</head>";
    $code .= "<body>";

/****************************************************************************************************************/
// -> PAGE [1]
/****************************************************************************************************************/
    $code .= "<BR><p><BR>";
    $code .= "<center><div class='mainTitle'><b>".$info[razao_social]."</b></div></center>";
    $code .= "<BR><p>";
    $code .= "<table align=center width=100% border=0><tr><td align=center><img src='"._IMG_PATH."uno_top.jpg' border=0></td></tr></table>";
    $code .= "<BR><p>";
    $code .= "<center><div class='bigTitle'><b>$title</b></div></center>";
    $code .= "<BR><p><BR>";
    $code .= "<center><div class='mainTitle'>$ano / $ano2</div></center>";
    $code .= "<center><b>LEI 6.514 Dez / 77<BR>PORTARIA 3.214 Jul / 78<BR>NR 9 - MTE</b></center>";
    $code .= "";
    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [2]
/****************************************************************************************************************/
    $code .= "<br><p>";
	$code .= "<div class='mainTitle'><b>EMPRESA</b></div>";
    $code .= "<BR><p align=justify>";
    $code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";
    $code .= "<td>N�mero do contrato:</td><td>{$info[ano_contrato]}/".str_pad($info[cliente_id], 4, "0",0)."</td>";
    $code .= "</tr><tr>";
    $dt = explode("/", $info[data_avaliacao]);
    $code .= "<td>N�mero do programa:</td><td>{$info[cod_ppra]}/{$info[ano]}</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Raz�o social:</td><td>$info[razao_social]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Endere�o: </td><td>$info[endereco], $info[num_end]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Bairro: </td><td>$info[bairro]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Estado: </td><td>$info[estado]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Cidade: </td><td>$info[municipio]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>CEP: </td><td>$info[cep]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Telefone: </td><td>$info[telefone]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Fax: </td><td>$info[fax]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>CNPJ/CEI: </td><td>$info[cnpj]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Ramo de Atividade: </td><td>$info[descricao]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>CNAE: </td><td>$info[cnae]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Grau de risco: </td><td>$info[grau_risco]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Respons�vel: </td><td>$info[nome_contato_dir]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Contador: </td><td>$info[nome_contador]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Telefone: </td><td>$info[tel_contador]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Efetivo geral: </td><td>".str_pad(pg_num_rows($rfl), 2, "0", 0)."</td>";
    $code .= "</tr><tr>";
    $sql = "SELECT count(*) as n, tipo_setor FROM cliente_setor cs, cgrt_func_list l
            WHERE cs.id_ppra = ".(int)($cod_cgrt)." AND cs.id_ppra = l.cod_cgrt AND cs.cod_setor = l.cod_setor AND l.status = 1
            GROUP BY tipo_setor ORDER BY tipo_setor";
    $rne = pg_query($sql);
    $efetivo_por_setor = pg_fetch_all($rne);
    $ef_admn = 0;
    $ef_oper = 0;
    for($i=0;$i<pg_num_rows($rne);$i++){
        if(strtolower($efetivo_por_setor[$i][tipo_setor]) == 'operacional')
            $ef_oper = (int)($efetivo_por_setor[$i][n]);
        elseif(strtolower($efetivo_por_setor[$i][tipo_setor]) == 'administrativo')
            $ef_admn = (int)($efetivo_por_setor[$i][n]);
    }
    $code .= "<td>Efetivo no setor administrativo: </td><td>".str_pad($ef_admn, 2, "0", 0)."</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Efetivo no setor operacional: </td><td>".str_pad($ef_oper, 2, "0", 0)."</td>";
    $code .= "</tr><tr>";
	
	$efemas = 0;//efetivo masculino
    $efefem = 0;//efetivo feminino
    for($x=0;$x<pg_num_rows($rfl);$x++){
        if(strtolower($funclist[$x][sexo_func]) == 'masculino')
            $efemas++;
        else
            $efefem++;
        
    }
		$efetivo_masc = $efemas;
		$efetivo_fem = $efefem;
		
     $code .= "<td>Efetivo Masculino: </td><td>".str_pad($efetivo_masc, 2, "0", 0)."</td>";
    $code .= "</tr><tr>";
     $code .= "<td>Efetivo Feminino: </td><td>".str_pad($efetivo_fem, 2, "0", 0)."</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Jornada de trabalho: </td><td>{$info[jornada]} horas</td>";
    $code .= "</tr><tr>";
    $code .= "<td>�rea total(aproximadamente): </td><td>{$info[comprimento]}</td>";
    $code .= "</tr><tr>";
    $code .= "<td>�rea constru�da: </td><td>{$info[frente]}</td>";
    $code .= "</tr><tr>";
    $code .= "<td>P� direito da �rea constru�da: </td><td>{$info[pe_direito]}</td>";
    $code .= "</tr>";
    $code .= "</table>";

    $code .= "<div class='pagebreak'></div>";
	
	/****************************************************************************************************************/
// -> PAGE [TESTE]
/****************************************************************************************************************/
    $sql = "SELECT id_pt FROM cliente_setor WHERE id_ppra = ".(int)($cod_cgrt)." AND is_posto_trabalho = 1 AND id_pt > 0 GROUP BY id_pt";
    $ridpt = pg_query($sql);
    while($posto_trabalho = pg_fetch_array($ridpt)){
        $sql = "SELECT * FROM posto_trabalho WHERE id = ".(int)($posto_trabalho[id_pt]);
        $ptinfo = pg_fetch_array(pg_query($sql));
        
    	$code .= "<BR><p><BR>";
        $code .= "<div class='mainTitle' align=center><center><b>EMPRESA CONTRATANTE</b></center></div>";
        $code .= "<BR><p align=justify>";
        $code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
        $code .= "<tr>";
        $code .= "<td>Raz�o social:</td><td>$ptinfo[razao_social]</td>";
        $code .= "</tr><tr>";
        $code .= "<td>Endere�o: </td><td>$ptinfo[endereco], $ptinfo[num_end]</td>";
        $code .= "</tr><tr>";
        $code .= "<td>Bairro: </td><td>$ptinfo[bairro]</td>";
        $code .= "</tr><tr>";
        $code .= "<td>Estado: </td><td>$ptinfo[estado]</td>";
        $code .= "</tr><tr>";
        $code .= "<td>Cidade: </td><td>$ptinfo[municipio]</td>";
        $code .= "</tr><tr>";
        $code .= "<td>CEP: </td><td>$ptinfo[cep]</td>";
        $code .= "</tr><tr>";
        $code .= "<td>Telefone: </td><td>$ptinfo[telefone]</td>";
        $code .= "</tr><tr>";
        if($ptinfo[telefone] != ''){
        $code .= "<td>Telefone: </td><td>$ptinfo[telefone]</td>";
        $code .= "</tr><tr>";
		}
		if($ptinfo[fax] != ''){
        $code .= "<td>Fax: </td><td>$ptinfo[fax]</td>";
        $code .= "</tr><tr>";
		}
        $code .= "<td>CNPJ/CEI: </td><td>$ptinfo[cnpj]</td>";
		$code .= "</tr><tr>";
		if($ptinfo[cnae] != ''){
		$code .= "<td>CNAE: </td><td>$ptinfo[cnae]</td>";
        $code .= "</tr><tr>";
		}
		if($ptinfo[grau_de_risco] != ''){
		$code .= "<td>Grau de Risco: </td><td>$ptinfo[grau_de_risco]</td>";
        $code .= "</tr>";
		}
        $code .= "</table>";
    $code .= "";
    $code .= "<div class='pagebreak'></div>";}
		
/****************************************************************************************************************/
// -> PAGE [3]
/****************************************************************************************************************/
    $code .= "<BR><p><BR>";
	$code .= "<div class='mainTitle'><b>INTRODU��O</b></div>";
    $code .= "<p align=justify>";

    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O Programa de Preven��o de Riscos Ambientais � PPRA da empresa &nbsp; <b>".$info[razao_social]."</b> em conjunto com o Programa de Controle M�dico de Sa�de Ocupacional (PCMSO) tem como objetivo assegurar a preserva��o da sa�de e da integridade f�sica dos empregados, atrav�s da antecipa��o, do reconhecimento, da avalia��o e consequente controle da ocorr�ncia de riscos ambientais existentes ou que venham a existir no ambiente de trabalho.";
    $code .= "<BR>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    Este documento estabelece os procedimentos m�nimos, e as diretrizes gerais a serem observados na execu��o do PPRA, exigindo defini��es e compromissos para a elimina��o ou minimiza��o dos riscos ambientais, devendo estar articulados com o disposto nas demais. Normas Regulamentadora constantes da Portaria n� 3.214 do Minist�rio do Trabalho e Emprego, de 08/06/1978, em especial com o Programa de Controle M�dico de Sa�de Ocupacional � PCMSO, previsto na NR-7.";

    $code .= "<div class='mediumTitle'><b>2 - POL�TICA</b></div>";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A preserva��o da sa�de deve abranger a preven��o de acidentes e de doen�as profissionais, bem como de doen�as transmiss�veis e outras, baseando-se em estudos do achados dos Exames M�dicos Ocupacionais e dos riscos envolvidos com a exposi��o a riscos ocupacionais, conforme indicados pelo Programa de Preven��o de Riscos Ambientais � PPRA, e propondo medidas profil�ticas e /ou corretivas.<BR>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As medidas para a preserva��o da sa�de devem buscar a adapta��o das condi��es de trabalho �s caracter�sticas �biopsicossociais� dos empregados, de modo a proporcionar o m�ximo de conforto, seguran�a e desempenho.<BR>";

    $code .= "<div class='mediumTitle'><b>3 - RESPONSABILIDADES</b></div>";
    $code .= "<p align=justify>";
    $code .= "I � Responsabilidade t�cnica pela elabora��o do Programa e assessoramentos t�cnicos necess�rios: SESMT;<BR>";
    $code .= "II � Responsabilidade pela garantia do cumprimento das a��es necess�rias previstas no Programa: Diretoria da Empresa <b>".$info[razao_social]."</b>;<BR>";
    $code .= "III � Responsabilidade pelo fiel cumprimento, em n�vel de execu��o, das recomenda��es de Sa�de Ocupacional propostas no Programa: Os empregados ou trabalhadores envolvidos.";

    $code .= "<div class='mediumTitle'><b>4 - DEFINI��O / CONCEITOS B�SICOS</b></div>";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>RISCOS AMBIENTAIS</b>: Consideram-se riscos ambientais os agentes f�sicos, qu�micos, biol�gicos, existentes no ambiente de trabalho que, em fun��o de sua natureza, concentra��o, intensidade, tempo de exposi��o, organiza��o e processo de trabalho, s�o capazes de causar danos � sa�de e � integridade f�sica do trabalhador.";

    $code .= "<div class='pagebreak'></div>";
	
	$code .= "<BR><p><BR>";
    $code .= "<div class='mediumTitle'><b>AGENTES F�SICOS</b></div>";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As diversas formas de energia a que possam estar expostos os trabalhadores, tais como: Ru�do, Vibra��es, Press�es anormais, Temperaturas extremas, Radia��es ionizantes e N�o ionizantes, Frio, Calor e Umidade, que podem ocasionar altera��es no organismo humano.";

    $code .= "<div class='mediumTitle'><b>AGENTES QU�MICOS</b></div>";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As subst�ncias, compostas ou produtos que possam penetrar no organismo pelas vias respirat�ria, cut�nea e digestiva, tais como Poeira, N�voas, Neblinas, Gases, Vapores e Solventes em geral, podendo ocasionar efeitos nocivos � sa�de.";

    $code .= "<div class='mediumTitle'><b>AGENTES BIOL�GICOS</b></div>";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aqueles que compreendem diversos micro-organismo patog�nicos, tais como: V�rus, Bact�rias, Protozo�rios, Fungos, Parasitas e Bacilos, presentes em determinadas atividades profissionais relacionadas com exposi��o ocupacional aos micro-organismo patol�gicos.";

    $code .= "<div class='mediumTitle'><b>N�VEL DE A��O</b></div>";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor acima do qual devem ser iniciadas as a��es preventivas, de forma a minimizar a probabilidade de que as exposi��es a agentes ambientais ultrapassem os limites de toler�ncia (LT).";

    $code .= "<div class='mediumTitle'><b>5 - PLANEJAMENTO DAS ATIVIDADES</b></div>";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Na implanta��o do PPRA � necess�rio realizar um planejamento, com elabora��o de cronogramas, contemplando todas as atividades necess�rias ao desenvolvimento do programa, e outro espec�fico para o monitoramento dos riscos, contendo, no m�nimo, a seguinte estrutura: Caracter�stica de Constru��o das Instala��es a serem avaliados; Tipos de riscos a serem monitorados; Estabelecimento de prioridades para cada riscos e responsabilidade pela execu��o do PPRA.";

    $code .= "<div class='mediumTitle'><b>6 - ESTRAT�GIA</b></div>";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Eliminar todo risco para a sa�de dos empregados, bem como promover a melhoria da qualidade de vida dos mesmos.";
    $code .= "<BR>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Os riscos relativos � sa�de e � seguran�a dos empregados devem ser analisados e controlados desde a elabora��o de projeto at� a opera��o de equipamentos, instala��es e processo de trabalho.";

    $code .= "<div class='pagebreak'></div>";
	
    $code .= "<BR><p><BR>";
	$code .= "<div class='mediumTitle'><b>7 - METODOLOGIA</b></div>";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Consiste na realiza��o de monitoramentos peri�dicos das instala��es e postos de trabalho, bem como de estudos preliminares e de an�lises de projetos de engenharia, nas fases de antecipa��o e reconhecimento de riscos, sempre que ocorrer constru��o, amplia��o, ocupa��o e reforma no estabelecimento, observando-se as caracter�sticas da edifica��o, equipamentos a serem instalados, riscos prov�veis, poss�veis tipos e esp�cies de acidentes e medidas preventivas a serem adotadas.";
    $code .= "<BR>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Havendo constata��o de riscos � sa�de, se ficar caracterizado o anexo casual entre os danos observados na sa�de dos trabalhadores e a situa��o de trabalho a que eles ficam expostos, devem ser adotadas as medidas necess�rias e suficientes para a elimina��o, minimiza��o ou o controle dos riscos.";

    $code .= "<div class='mediumTitle'><b>8 - FORMA DE REGISTRO DOS DADOS</b></div>";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Os dados obtidos ser�o registrados e arquivados em formul�rios espec�ficos. Estes documentos dever�o ficar arquivados, em pasta �nica, no setor administrativo respons�vel por recursos humanos da empresa. O reconhecimento dos riscos, que consiste na";
	$code .= "avalia��o ocupacional quantitativa e qualitativa das instala��es e �reas da empresa, de forma sistem�tica e repetitiva, dever� ser registrado no formul�rio: Ficha de Reconhecimento da Qualifica��o dos Riscos e Quantifica��o dos Riscos, contendo os seguintes itens: a identifica��o dos agentes nocivos; suas poss�veis fontes geradoras; suas poss�veis trajet�rias e meios de propaga��o; o n�mero de trabalhadores expostos; seus cargos; as atividades desenvolvidas; o tipo de exposi��o a que est�o sujeitos; os poss�veis danos � sa�de e a criticidade dos agentes.";

    $code .= "<div class='mediumTitle'><b>9 - MANUTEN��O E DIVULGA��O DOS DADOS</b></div>";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Os dados obtidos dever�o ser mantidos arquivados por um per�odo m�nimo de 20 anos, ficando dispon�vel aos trabalhadores interessados ou seus representantes e para as autoridades competentes.";

    $code .= "<div class='mediumTitle'><b>10 - PERIODICIDADE</b></div>";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O planejamento das atividades necess�rias � execu��o do PPRA ser� anual. O monitoramento e o controle dos riscos ter� a frequ�ncia determinada pela classe de criticidade do agente nocivo, constante da Ficha de Quantifica��o dos Riscos, anexo a este documento.";

    $code .= "<div class='mediumTitle'><b>11 - AVALIA��O DO DESENVOLVIMENTO</b></div>";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A efic�cia do PPRA deve ser avaliada, com frequ�ncia, de forma a verificar seus resultados, que devem estar em conformidade com os exames m�dicos de sa�de previstos nas normas da empresa, preconizadas na NR-7 � PROGRAMA DE CONTROLE M�DICO DE SA�DE OCUPACIONAL � PCMSO.";

    $code .= "<div class='pagebreak'></div>";


/****************************************************************************************************************/
// -> PAGE [4] - 1� fase, reconhecimento
/****************************************************************************************************************/
    $code .= "<BR><p><BR>";
    $code .= "<BR><p><BR>";
    $code .= "<BR><p><BR>";
    $code .= "<center><div class='bigTitle'><b>1� FASE<BR><BR>RECONHECIMENTO<BR><BR>E<BR><BR>AVALIA��ES AMBIENTAIS<BR></b></div></center>";
    $code .= "";
    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [5] - Legenda de Riscos Coleta de Dados
/****************************************************************************************************************/
    $code .= "<BR><p><BR>";
	$code .= "<div class='mediumTitle'><b>LEGENDA DE RISCOS COLETA DE DADOS</b></div>";
    $code .= "<p align=justify>";
    
    $code .= "<table width=100% cellspacig=2 cellpadding=2 border=1>";
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' width=100 rowspan=2><b>Especifica��o de tipos de riscos</b></td>";
    $code .= "<td align=center class='bgtitle' width=100><b>01 F�sico</b></td>";
    $code .= "<td align=center class='bgtitle' width=100><b>02 Qu�mico</b></td>";
    $code .= "<td align=center class='bgtitle' width=100><b>03 Biol�gico</b></td>";
    $code .= "<td align=center class='bgtitle' width=100><b>04 Ergon�mico</b></td>";
    $code .= "<td align=center class='bgtitle' width=100><b>05 Acidentes</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=center bgcolor='$green'><b>Verde</b></td>";
    $code .= "<td align=center bgcolor='$red'><b>Vermelho</b></td>";
    $code .= "<td align=center bgcolor='$brown'><b>Marrom</b></td>";
    $code .= "<td align=center bgcolor='$yellow'><b>Amarelo</b></td>";
    $code .= "<td align=center bgcolor='$blue'><b>Azul</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' height=50><b>1</b></td>";
    $code .= "<td align=center class='dez'><b>Ru�dos</b></td>";
    $code .= "<td align=center class='dez'><b>Poeiras</b></td>";
    $code .= "<td align=center class='dez'><b>V�rus</b></td>";
    $code .= "<td align=center class='dez'><b>Esfor�o intenso</b></td>";
    $code .= "<td align=center class='dez'><b>Arranjo Inadequado</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' height=50><b>2</b></td>";
    $code .= "<td align=center class='dez'><b>Vibra��es</b></td>";
    $code .= "<td align=center class='dez'><b>Fumos</b></td>";
    $code .= "<td align=center class='dez'><b>Bact�rias</b></td>";
    $code .= "<td align=center class='dez'><b>Levantamento e Transporte Manual de Peso</b></td>";
    $code .= "<td align=center class='dez'><b>M�quinas e Equipamentos sem Prote��o</b></td>";
    $code .= "</tr>";
    
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' height=50><b>3</b></td>";
    $code .= "<td align=center class='dez'><b>Radia��o ionizante</b></td>";
    $code .= "<td align=center class='dez'><b>N�voas</b></td>";
    $code .= "<td align=center class='dez'><b>Protozo�rios</b></td>";
    $code .= "<td align=center class='dez'><b>Exig�ncia de postura inadequada</b></td>";
    $code .= "<td align=center class='dez'><b>Ferramenta inadequada ou defeituosa</b></td>";
    $code .= "</tr>";
    
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' height=50><b>4</b></td>";
    $code .= "<td align=center class='dez'><b>Radia��o n�o ionizante</b></td>";
    $code .= "<td align=center class='dez'><b>Neblina</b></td>";
    $code .= "<td align=center class='dez'><b>Fungos</b></td>";
    $code .= "<td align=center class='dez'><b>Controle r�gido de produtividade</b></td>";
    $code .= "<td align=center class='dez'><b>Ilumina��o inadequada</b></td>";
    $code .= "</tr>";
    
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' height=50><b>5</b></td>";
    $code .= "<td align=center class='dez'><b>Frio</b></td>";
    $code .= "<td align=center class='dez'><b>Gases</b></td>";
    $code .= "<td align=center class='dez'><b>Parasitas</b></td>";
    $code .= "<td align=center class='dez'><b>Imposi��o de ritmos excessivos</b></td>";
    $code .= "<td align=center class='dez'><b>Eletricidade</b></td>";
    $code .= "</tr>";
    
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' height=50><b>6</b></td>";
    $code .= "<td align=center class='dez'><b>Calor</b></td>";
    $code .= "<td align=center class='dez'><b>Vapores</b></td>";
    $code .= "<td align=center class='dez'><b>Bacilos</b></td>";
    $code .= "<td align=center class='dez'><b>Trabalho em turno e noturno</b></td>";
    $code .= "<td align=center class='dez'><b>Probabilidade de inc�ndio ou explos�o</b></td>";
    $code .= "</tr>";
    
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' height=50><b>7</b></td>";
    $code .= "<td align=center class='dez'><b>Press�es anormais</b></td>";
    $code .= "<td align=center class='dez'><b>Subst�ncias, composto, produto qu�mico em geral</b></td>";
    $code .= "<td align=center class='dez'><b></b></td>";
    $code .= "<td align=center class='dez'><b>Jornada de trabalho prolongada</b></td>";
    $code .= "<td align=center class='dez'><b>Armazenamento inadequado</b></td>";
    $code .= "</tr>";
    
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' height=50><b>8</b></td>";
    $code .= "<td align=center class='dez'><b>Umidade</b></td>";
    $code .= "<td align=center class='dez'><b></b></td>";
    $code .= "<td align=center class='dez'><b></b></td>";
    $code .= "<td align=center class='dez'><b>Monotonia e repetividade</b></td>";
    $code .= "<td align=center class='dez'><b>Animais pe�onhentos</b></td>";
    $code .= "</tr>";
    
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' height=50><b>9</b></td>";
    $code .= "<td align=center class='dez'><b></b></td>";
    $code .= "<td align=center class='dez'><b></b></td>";
    $code .= "<td align=center class='dez'><b></b></td>";
    $code .= "<td align=center class='dez'><b>Outras situa��es causadoras de stress f�sico e/ou ps�quico</b></td>";
    $code .= "<td align=center class='dez'><b>Outras Situa��es de risco que poder�o contribuir para a ocorr�ncia de acidentes</b></td>";
    $code .= "</tr>";
    
    $code .= "</table>";
    
    $code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [6] - Primeira fase - Reconhecimento
/****************************************************************************************************************/
    $sql = "SELECT cs.data_avaliacao, cs.hora_avaliacao, cs.ruido_fundo_setor, cs.ruido_operacao_setor, cs.ruido, cs.cod_ppra,
			cs.cod_cliente, cs.cod_setor, s.nome_setor, s.desc_setor, tp.descricao, p.descricao_piso, pa.decicao_parede,
			co.decicao_cobertura, ln.descricao_luz_nat, la.decricao_luz_art, vn.decricao_vent_nat, va.decricao_vent_art,
			cs.epc_existente, cs.epc_sugerido, cs.turno
            FROM cliente_setor cs, setor s, cliente c, tipo_edificacao tp, piso p, parede pa, cobertura co,
            luz_natural ln, luz_artificial la, ventilacao_natural vn, ventilacao_artificial va
            WHERE cs.cod_cliente = c.cliente_id
            AND cs.cod_setor = s.cod_setor
            AND tp.tipo_edificacao_id = cs.cod_edificacao
            AND p.cod_piso = cs.cod_piso
            AND pa.cod_parede = cs.cod_parede
            AND co.cod_cobertura = cs.cod_cobertura
            AND ln.cod_luz_nat = cs.cod_luz_nat
            AND la.cod_luz_art = cs.cod_luz_art
            AND vn.cod_vent_nat = cs.cod_vent_nat
            AND va.cod_vent_art = cs.cod_vent_art
            AND cs.id_ppra = ".(int)($cod_cgrt)." ORDER BY s.nome_setor";
    $rca = pg_query($sql);
    $srec = pg_fetch_all($rca);
    
    
    $sql = "SELECT cs.data_avaliacao, cs.hora_avaliacao, cs.ruido_fundo_setor,
		  cs.ruido_operacao_setor, cs.ruido, cs.cod_ppra, cs.cod_cliente, cs.cod_setor, s.nome_setor, s.desc_setor, tp.descricao, p.descricao_piso,
            pa.decicao_parede, co.decicao_cobertura, ln.descricao_luz_nat, la.decricao_luz_art, vn.decricao_vent_nat,
            va.decricao_vent_art, cs.epc_existente, cs.epc_sugerido
            FROM cliente_setor cs, setor s, cliente c, tipo_edificacao tp, piso p, parede pa, cobertura co,
            luz_natural ln, luz_artificial la, ventilacao_natural vn, ventilacao_artificial va
            WHERE cs.cod_cliente = c.cliente_id
            AND cs.cod_setor = s.cod_setor
            AND tp.tipo_edificacao_id = cs.cod_edificacao
            AND p.cod_piso = cs.cod_piso
            AND pa.cod_parede = cs.cod_parede
            AND co.cod_cobertura = cs.cod_cobertura
            AND ln.cod_luz_nat = cs.cod_luz_nat
            AND la.cod_luz_art = cs.cod_luz_art
            AND vn.cod_vent_nat = cs.cod_vent_nat
            AND va.cod_vent_art = cs.cod_vent_art
            AND cs.id_ppra = ".(int)($cod_cgrt)."
            AND cs.is_posto_trabalho = 0
            ORDER BY s.nome_setor";
    $rcb = pg_query($sql);
    $srecb = pg_fetch_all($rcb);

    
    for($x=0;$x<pg_num_rows($rcb);$x++){
    $code .= "<BR><p><BR>";
	$code .= "<div class='mediumTitle'><b>PRIMEIRA FASE DO RECONHECIMENTO</b></div>";

        $code .= "<div class='dez'><b>1 - COLETA DE DADOS DA EXPOSI��O DO TRABALHADOR AOS AGENTES:</b></div>";
        $code .= "<table width=100% cellspacig=2 cellpadding=2 border=1>";
        $code .= "<tr>";
        $code .= "<td width=180 class='bgtitle'><b>Local:</b></td><td class='dez'>{$srecb[$x][nome_setor]}</td>";
        $code .= "</tr>";
        $code .= "<tr>";
        $code .= "<td width=180 class='bgtitle'><b>Atividade:</b></td><td class='dez'>{$srecb[$x][desc_setor]}</td>";
        $code .= "</tr>";
        $code .= "</table>";
        $code .= "<table width=100% cellspacig=2 cellpadding=2 border=0>";
        $code .= "<tr>";
        $code .= "<td width=180 class='dez'><b>CARACTER�STICAS:</b></td>";//<td class='dez'><b>IDENTIFICA��O QUALITATIVA DE AGENTE NOCIVO:</b></td>";
        $code .= "</tr>";
        $code .= "</table>";
            $code .= "<table border=1 width=100% cellspacig=2 cellpadding=2>";
            $code .= "<tr>";
            $code .= "<td class='dez bgtitle' width=180><b>Edifica��o:</b></td><td class='dez'>{$srecb[$x][descricao]}</td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td class='dez bgtitle'><b>Parede:</b></td><td class='dez'>{$srecb[$x][decicao_parede]}</td>";
            $code .= "</tr>";
			$code .= "<tr>";
            $code .= "<td class='dez bgtitle'><b>Piso:</b></td><td class='dez'>{$srecb[$x][descricao_piso]}</td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td class='dez bgtitle'><b>Cobertura:</b></td><td class='dez'>{$srecb[$x][decicao_cobertura]}</td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td class='dez bgtitle'><b>Luz natural:</b></td><td class='dez'>{$srecb[$x][descricao_luz_nat]}</td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td class='dez bgtitle'><b>Luz artificial:</b></td><td class='dez'>{$srecb[$x][decricao_luz_art]}</td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td class='dez bgtitle'><b>Vento natural:</b></td><td class='dez'>{$srecb[$x][decricao_vent_nat]}</td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td class='dez bgtitle'><b>Vento artificial:</b></td><td class='dez'>{$srecb[$x][decricao_vent_art]}</td>";
            $code .= "</tr>";
            $code .= "</table>";
        $code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
        $code .= "<tr>";
        $code .= "<td class='dez'><b>MEDIDAS PREVENTIVAS EXISTENTES:</b></td>";
        $code .= "</tr>";
        $code .= "</table>";
        // --> Query: EPI Existente:
        $sql = "SELECT DISTINCT(se.descricao) FROM sugestao s, setor_epi se
                WHERE (s.cod_setor = se.cod_setor
                AND s.med_prev = se.id
                AND s.cod_setor = ".(int)($srecb[$x][cod_setor]).")
                AND s.plano_acao = 0
                AND s.id_ppra = ".(int)($cod_cgrt);
        $repi = pg_query($sql);
        // --> Query: Ambiente Existente:
        $sql = "SELECT DISTINCT(sa.descricao) FROM sugestao s, setor_ambiental sa
                WHERE (s.cod_setor = sa.cod_setor
                AND s.med_prev = sa.id
                AND s.cod_setor = ".(int)($srecb[$x][cod_setor]).")
                AND s.plano_acao = 0
                AND s.id_ppra = ".(int)($cod_cgrt);
        $ramb = pg_query($sql);
        // --> Query: Programa Existente:
        $prog = "SELECT DISTINCT(sp.descricao) FROM sugestao s, setor_programas sp
                WHERE s.med_prev = sp.id
                AND s.cod_setor = sp.cod_setor
                AND s.cod_setor = ".(int)($srecb[$x][cod_setor])."
                AND s.plano_acao = 0
				AND s.tipo_med_prev = 4
                AND s.id_ppra = ".(int)($cod_cgrt);
        $rpro = pg_query($prog);
        $code .= "<table width=100% cellspacing=2 cellpadding=2 border=1>";
        $code .= "<tr>";
        $code .= "<td class='dez'><b>No homem:</b> ";
            while($value = pg_fetch_array($repi))
                $code .= $value[descricao]."; ";
            $code .= "<br>";
            $code .= "<b>No ambiente:</b> ";
            while($value = pg_fetch_array($ramb))
                $code .= $value[descricao]."; ";
            while($value = pg_fetch_array($rpro))
                $code .= $value[descricao]."; ";
			if(!empty($srecb[$x][epc_existente])) $code .= $srecb[$x][epc_existente].";";
        $code .= "</td>";
        $code .= "</tr>";
        $code .= "</table>";
        $code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
        $code .= "<tr>";
        $code .= "<td class='dez'><b>MEDIDAS PREVENTIVAS SUGERIDAS:</b></td>";
        $code .= "</tr>";
        $code .= "</table>";
        // --> Query: EPI Sugerido:
        $sql = "SELECT DISTINCT(se.descricao) FROM sugestao s, setor_epi se
                WHERE (s.cod_setor = se.cod_setor
                AND s.med_prev = se.id
                AND s.cod_setor = ".(int)($srecb[$x][cod_setor]).")
                AND s.plano_acao = 1
                AND s.id_ppra = ".(int)($cod_cgrt);
        $repi = pg_query($sql);
        // --> Query: Ambiente Sugerido:
        $sql = "SELECT DISTINCT(sa.descricao) FROM sugestao s, setor_ambiental sa
                WHERE (s.cod_setor = sa.cod_setor
                AND s.med_prev = sa.id
                AND s.cod_setor = ".(int)($srecb[$x][cod_setor]).")
                AND s.plano_acao = 1
                AND s.id_ppra = ".(int)($cod_cgrt);
        $ramb = pg_query($sql);
        // --> Query: Programa Sugerido:
        $prog = "SELECT DISTINCT(sp.descricao) FROM sugestao s, setor_programas sp
                WHERE s.med_prev = sp.id
                AND s.cod_setor = sp.cod_setor
                AND s.cod_setor = ".(int)($srecb[$x][cod_setor])."
                AND s.plano_acao = 1
				AND s.tipo_med_prev = 4
                AND s.id_ppra = ".(int)($cod_cgrt);
        $rpro = pg_query($prog);
        $code .= "<table width=100% cellspacing=2 cellpadding=2 border=1>";
        $code .= "<tr>";
        $code .= "<td class='dez'><b>No homem:</b> ";
            while($value = pg_fetch_array($repi))
                $code .= $value[descricao]."; ";
            $code .= "<BR>";
            $code .= "<b>No ambiente:</b> ";
			while($value = pg_fetch_array($ramb))
                $code .= $value[descricao]."; ";
            while($value = pg_fetch_array($rpro))
                $code .= $value[descricao]."; ";
            if(!empty($srecb[$x][epc_sugerido])) $code .= $srecb[$x][epc_sugerido].";";
        $code .= "</td>";
        $code .= "</tr>";
        $code .= "</table>";
        
        $code .= "<div class='pagebreak'></div>";
    }
    
    //--------------------------------------------------------------------------------------------------------
    // --> LISTA DE POSTOS DE TRABALHO AQUI!
    //--------------------------------------------------------------------------------------------------------
    $sql = "SELECT id_pt FROM cliente_setor WHERE id_ppra = ".(int)($cod_cgrt)." AND is_posto_trabalho = 1 AND id_pt > 0 GROUP BY id_pt";
    $ridpt = pg_query($sql);
    while($posto_trabalho = pg_fetch_array($ridpt)){
        $sql = "SELECT * FROM posto_trabalho WHERE id = ".(int)($posto_trabalho[id_pt]);
        $ptinfo = pg_fetch_array(pg_query($sql));
        
    	$code .= "<BR><p><BR>";
        $code .= "<div class='mainTitle' align=center><center><b>POSTO DE SERVI�O</b></center></div>";
        $code .= "<BR><p align=justify>";
        $code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
        $code .= "<tr>";
        $code .= "<td>Raz�o social:</td><td>$ptinfo[razao_social]</td>";
        $code .= "</tr><tr>";
        $code .= "<td>Endere�o: </td><td>$ptinfo[endereco], $ptinfo[num_end]</td>";
        $code .= "</tr><tr>";
        $code .= "<td>Bairro: </td><td>$ptinfo[bairro]</td>";
        $code .= "</tr><tr>";
        $code .= "<td>Estado: </td><td>$ptinfo[estado]</td>";
        $code .= "</tr><tr>";
        $code .= "<td>Cidade: </td><td>$ptinfo[municipio]</td>";
        $code .= "</tr><tr>";
        $code .= "<td>CEP: </td><td>$ptinfo[cep]</td>";
        $code .= "</tr><tr>";
        if($ptinfo[telefone] != ''){
        $code .= "<td>Telefone: </td><td>$ptinfo[telefone]</td>";
        $code .= "</tr><tr>";
		}
		if($ptinfo[fax] != ''){
        $code .= "<td>Fax: </td><td>$ptinfo[fax]</td>";
        $code .= "</tr><tr>";
		}
        $code .= "<td>CNPJ/CEI: </td><td>$ptinfo[cnpj]</td>";
		$code .= "</tr><tr>";
		if($ptinfo[cnae] != ''){
		$code .= "<td>CNAE: </td><td>$ptinfo[cnae]</td>";
        $code .= "</tr><tr>";
		}
		if($ptinfo[grau_de_risco] != ''){
		$code .= "<td>Grau de Risco: </td><td>$ptinfo[grau_de_risco]</td>";
        $code .= "</tr>";
		}
        $code .= "</table>";

        $code .= "<div class='pagebreak'></div>";
    
        $sql = "SELECT cs.data_avaliacao, cs.hora_avaliacao, cs.ruido_fundo_setor,
    		    cs.ruido_operacao_setor, cs.ruido, cs.cod_ppra, cs.cod_cliente, s.cod_setor, s.nome_setor, s.desc_setor, tp.descricao, p.descricao_piso,
                pa.decicao_parede, co.decicao_cobertura, ln.descricao_luz_nat, la.decricao_luz_art, vn.decricao_vent_nat,
                va.decricao_vent_art, cs.epc_existente, cs.epc_sugerido
                FROM cliente_setor cs, setor s, cliente c, tipo_edificacao tp, piso p, parede pa, cobertura co,
                luz_natural ln, luz_artificial la, ventilacao_natural vn, ventilacao_artificial va
                WHERE cs.cod_cliente = c.cliente_id
                AND cs.cod_setor = s.cod_setor
                AND tp.tipo_edificacao_id = cs.cod_edificacao
                AND p.cod_piso = cs.cod_piso
                AND pa.cod_parede = cs.cod_parede
                AND co.cod_cobertura = cs.cod_cobertura
                AND ln.cod_luz_nat = cs.cod_luz_nat
                AND la.cod_luz_art = cs.cod_luz_art
                AND vn.cod_vent_nat = cs.cod_vent_nat
                AND va.cod_vent_art = cs.cod_vent_art
                AND cs.id_ppra = ".(int)($cod_cgrt)."
                AND cs.is_posto_trabalho = 1
                AND cs.id_pt = ".(int)($posto_trabalho[id_pt])."
                ORDER BY s.nome_setor";
        $rcc = pg_query($sql);
        $srecc = pg_fetch_all($rcc);

    	$code .= "<BR><p><BR>";
		$code .= "<div class='mediumTitle'><b>PRIMEIRA FASE DO RECONHECIMENTO</b></div>";

        for($x=0;$x<pg_num_rows($rcc);$x++){
            $code .= "<div class='dez'><b>1 - COLETA DE DADOS DA EXPOSI��O DO TRABALHADOR AOS AGENTES:</b></div>";
            $code .= "<table width=100% cellspacig=2 cellpadding=2 border=1>";
            $code .= "<tr>";
            $code .= "<td width=180 class='bgtitle'><b>Local:</b></td><td class='dez'>{$srecc[$x][nome_setor]}</td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td width=180 class='bgtitle'><b>Atividade:</b></td><td class='dez'>{$srecc[$x][desc_setor]}</td>";
            $code .= "</tr>";
            $code .= "</table>";
            $code .= "<table width=100% cellspacig=2 cellpadding=2 border=0>";
            $code .= "<tr>";
            $code .= "<td width=180 class='dez'><b>CARACTER�STICAS:</b></td>";//<td class='dez'><b>IDENTIFICA��O QUALITATIVA DE AGENTE NOCIVO:</b></td>";
            $code .= "</tr>";
            $code .= "</table>";
                $code .= "<table border=1 width=100% cellspacig=2 cellpadding=2>";
                $code .= "<tr>";
                $code .= "<td class='dez bgtitle' width=180><b>Edifica��o:</b></td><td class='dez'>{$srecc[$x][descricao]}</td>";
                $code .= "</tr>";
				$code .= "<tr>";
				$code .= "<td class='dez bgtitle'><b>Parede:</b></td><td class='dez'>{$srecc[$x][decicao_parede]}</td>";
				$code .= "</tr>";
                $code .= "<tr>";
                $code .= "<td class='dez bgtitle'><b>Piso:</b></td><td class='dez'>{$srecc[$x][descricao_piso]}</td>";
                $code .= "</tr>";
                $code .= "<tr>";
                $code .= "<td class='dez bgtitle'><b>Cobertura:</b></td><td class='dez'>{$srecc[$x][decicao_cobertura]}</td>";
                $code .= "</tr>";
                $code .= "<tr>";
                $code .= "<td class='dez bgtitle'><b>Luz natural:</b></td><td class='dez'>{$srecc[$x][descricao_luz_nat]}</td>";
                $code .= "</tr>";
                $code .= "<tr>";
                $code .= "<td class='dez bgtitle'><b>Luz artificial:</b></td><td class='dez'>{$srecc[$x][decricao_luz_art]}</td>";
                $code .= "</tr>";
                $code .= "<tr>";
                $code .= "<td class='dez bgtitle'><b>Vento natural:</b></td><td class='dez'>{$srecc[$x][decricao_vent_nat]}</td>";
                $code .= "</tr>";
                $code .= "<tr>";
                $code .= "<td class='dez bgtitle'><b>Vento artificial:</b></td><td class='dez'>{$srecc[$x][decricao_vent_art]}</td>";
                $code .= "</tr>";
                $code .= "</table>";
            $code .= "<table width=100% cellspacig=2 cellpadding=2 border=0>";
            $code .= "<tr>";
            $code .= "<td class='dez'><b>MEDIDAS PREVENTIVAS EXISTENTES:</b></td>";
            $code .= "</tr>";
            $code .= "</table>";
            // --> Query: EPI Existente:
            $sql = "SELECT DISTINCT(se.descricao) FROM sugestao s, setor_epi se
                    WHERE (s.cod_setor = se.cod_setor
                    AND s.med_prev = se.id
                    AND s.cod_setor = ".(int)($srecc[$x][cod_setor]).")
                    AND s.plano_acao = 0
                    AND s.id_ppra = ".(int)($cod_cgrt);
            $repi = pg_query($sql);
            // --> Query: Ambiente Existente:
            $sql = "SELECT DISTINCT(sa.descricao) FROM sugestao s, setor_ambiental sa
                    WHERE (s.cod_setor = sa.cod_setor
                    AND s.med_prev = sa.id
                    AND s.cod_setor = ".(int)($srecc[$x][cod_setor]).")
                    AND s.plano_acao = 0
                    AND s.id_ppra = ".(int)($cod_cgrt);
            $ramb = pg_query($sql);
            // --> Query: Programa Existente:
            $prog = "SELECT DISTINCT(sp.descricao) FROM sugestao s, setor_programas sp
                    WHERE s.med_prev = sp.id
                    AND s.cod_setor = sp.cod_setor
                    AND s.cod_setor = ".(int)($srecc[$x][cod_setor])."
                    AND s.plano_acao = 0
                    AND s.id_ppra = ".(int)($cod_cgrt);
            $rpro = pg_query($prog);
			
            $code .= "<table width=100% cellspacig=2 cellpadding=2 border=1>";
            $code .= "<tr>";
            $code .= "<td class='dez'><b>No homem:</b> ";
                while($value = pg_fetch_array($repi))
                    $code .= $value[descricao]."; ";
                $code .= "<br>";
                $code .= "<b>No ambiente:</b> ";
				while($value = pg_fetch_array($ramb))
                    $code .= $value[descricao]."; ";
                while($value = pg_fetch_array($rpro))
                    $code .= $value[descricao]."; ";
                if(!empty($srecc[$x][epc_existente])) $code .= $srecc[$x][epc_existente].";";
            $code .= "</td>";
            $code .= "</tr>";
            $code .= "</table>";
            $code .= "<table width=100% cellspacig=2 cellpadding=2 border=0>";
            $code .= "<tr>";
            $code .= "<td class='dez'><b>MEDIDAS PREVENTIVAS SUGERIDAS:</b></td>";
            $code .= "</tr>";
            $code .= "</table>";
            // --> Query: EPI Existente:
            $sql = "SELECT DISTINCT(se.descricao) FROM sugestao s, setor_epi se
                    WHERE (s.cod_setor = se.cod_setor
                    AND s.med_prev = se.id
                    AND s.cod_setor = ".(int)($srecc[$x][cod_setor]).")
                    AND s.plano_acao = 1
                    AND s.id_ppra = ".(int)($cod_cgrt);
            $repi = pg_query($sql);
            // --> Query: Ambiente Existente:
            $sql = "SELECT DISTINCT(sa.descricao) FROM sugestao s, setor_ambiental sa
                    WHERE (s.cod_setor = sa.cod_setor
                    AND s.med_prev = sa.id
                    AND s.cod_setor = ".(int)($srecc[$x][cod_setor]).")
                    AND s.plano_acao = 1
					AND s.tipo_med_prev = 3
                    AND s.id_ppra = ".(int)($cod_cgrt);
            $ramb = pg_query($sql);
            // --> Query: Programa Existente:
            $prog = "SELECT DISTINCT(sp.descricao) FROM sugestao s, setor_programas sp
                    WHERE (s.med_prev = sp.id
                    AND s.cod_setor = sp.cod_setor
                    AND s.cod_setor = ".(int)($srecc[$x][cod_setor]).")
                    AND s.plano_acao = 1
					AND s.tipo_med_prev = 4
                    AND s.id_ppra = ".(int)($cod_cgrt);
            $rpro = pg_query($prog);
			
            $code .= "<table width=100% cellspacing=2 cellpadding=2 border=1>";
            $code .= "<tr>";
            $code .= "<td class='dez'><b>No homem:</b> ";
                while($value = pg_fetch_array($repi))
                    $code .= $value[descricao]."; ";
                $code .= "<BR>";
                $code .= "<b>No ambiente:</b> ";
				while($value = pg_fetch_array($ramb))
                    $code .= $value[descricao]."; ";
                while($value = pg_fetch_array($rpro))
                    $code .= $value[descricao]."; ";
                if(!empty($srecc[$x][epc_sugerido])) $code .= $srecc[$x][epc_sugerido].";";
            $code .= "</td>";
            $code .= "</tr>";
            $code .= "</table>";

            $code .= "<div class='pagebreak'></div>";
        }
    }
      
    for($x=0;$x<pg_num_rows($rca);$x++){
    $code .= "<BR><p><BR>";
    $code .= "<div class='mediumTitle'><b>PRIMEIRA FASE DO RECONHECIMENTO</b></div>";
    $code .= "Com base nas informa��es ora obtidas pela coordena��o do PCMSO.";
    $code .= "<BR>";
    $code .= "Diagn�sticos de poss�veis danos a sa�de do trabalhador.";
    $code .= "<BR>";
	
        $code .= "<div class='dez'><b>CARACTERIZA��O SETORIAL DA EXPOSI��O DO TRABALHADOR AOS AGENTES NOCIVOS</b></div>";
        $code .= "<BR>";
        $sql = "SELECT t.nome, ca.nome as nome1, ag.*, r.fonte_geradora, tr.nome_tipo_risco
                FROM setor s, risco_setor r, cliente_setor c, tipo_contato t, contato_com_agente ca, agente_risco ag, tipo_risco tr
                WHERE r.cod_cliente = c.cod_cliente
       		    AND r.cod_setor = c.cod_setor
    			AND r.cod_setor = s.cod_setor
    			AND r.cod_tipo_contato = t.tipo_contato_id
    			AND r.cod_agente_contato = ca.contato_com_agente_id
    			AND c.id_ppra = r.id_ppra
    			AND c.id_ppra = ".(int)($cod_cgrt)."
    			AND c.cod_setor = ".(int)($srec[$x][cod_setor])."
    			AND ag.cod_tipo_risco = tr.cod_tipo_risco
    			AND r.cod_agente_risco = ag.cod_agente_risco";
        $rag = pg_query($sql);
        $sagent = pg_fetch_all($rag);

        $sql = "SELECT count(fl.cod_func) as nfunc FROM cgrt_func_list fl, funcionarios f 
			WHERE (f.setor_adicional like '{$srec[$x]['cod_setor']}|%' AND f.cod_cliente = fl.cod_cliente AND fl.cod_cgrt = $cod_cgrt AND f.cod_func = fl.cod_func)
			OR (f.setor_adicional like '%|{$srec[$x]['cod_setor']}|%' AND f.cod_cliente = fl.cod_cliente AND fl.cod_cgrt = $cod_cgrt AND f.cod_func = fl.cod_func)
			OR (f.cod_setor = {$srec[$x]['cod_setor']} AND f.cod_cliente = fl.cod_cliente AND fl.cod_cgrt = $cod_cgrt AND f.cod_func = fl.cod_func)";
        $nfuncbysetor = pg_fetch_array(pg_query($sql));
        $nfuncbysetor = (int)($nfuncbysetor[nfunc]);
        $code .= "<table border=1 width=100% cellspacig=0 cellpadding=0>";
        $code .= "<tr>";
        $code .= "<td colspan=2 class='bgtitle medText' align=center><b>{$srec[$x][nome_setor]}</b></td>";
        $code .= "</tr>";
        $code .= "<tr>";
        $code .= "<td width=50% align=left><b>Efetivo:</b> $nfuncbysetor</td><td align=left><b>Turno:</b> ";
		//APARECER APENAS O NOME DAS FUN��ES AO INV�S DE EFETIVOS
		/*$tim = "SELECT distinct(nome_funcao), fu.cod_funcao
				FROM funcionarios f, funcao fu, cgrt_func_list l
				WHERE f.cod_funcao = fu.cod_funcao
				AND f.cod_func = l.cod_func
				AND f.cod_cliente = l.cod_cliente
				AND l.cod_cgrt = $cod_cgrt
				AND f.cod_setor = {$srec[$x][cod_setor]} and f.cod_setor = l.cod_setor";
		$resultis = pg_query($tim);
		$rr = pg_fetch_all($resultis);
		$code .= "<td width=70% align=left><b>Fun��o:</b>"; 
		for($p=0;$p<pg_num_rows($resultis);$p++){ 
		$code .= $rr[$p][nome_funcao].";"; 
		} 
		$code .= "</td><td align=left><b>Turno:</b> ";*/
		
		if($srec[$x][turno] == '1'){
			$code .= "Diurno";
		}elseif($srec[$x][turno] == '2'){
			$code .= "Noturno";
		}else{
			$code .= "Diurno e Noturno";
		}
		$code .= "</td>";
        $code .= "</tr>";
        $code .= "</table>";
        $code .= "<BR>";

        for($y=0;$y<pg_num_rows($rag);$y++){
            $sql = "SELECT diagnostico FROM risco_setor WHERE cod_agente_risco = ".(int)($sagent[$y][cod_agente_risco])." AND id_ppra = ".(int)($cod_cgrt);
        	$r = pg_query($sql);
        	$diag = pg_fetch_array($r);
            $code .= "<table border=1 width=100% cellspacig=0 cellpadding=0>";
            $code .= "<tr>";
            $code .= "<td width=150><b>Cod:</b> 0{$sagent[$y][num_agente_risco]}</td>";
            $code .= "<td width=250><b>Grupo:</b> {$sagent[$y][nome_tipo_risco]}</td>";
            $code .= "<td rowspan=3 valign=top><b>Diagn�stico:</b><p align=justify>{$diag[diagnostico]}</td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td><b>Agente:</b></td><td>{$sagent[$y][nome_agente_risco]}</td>";
            $code .= "</tr>";
            $code .= "<tr>";
            $code .= "<td><b>Fonte Geradora:</b></td><td>{$sagent[$y][fonte_geradora]}</td>";
            $code .= "</tr>";
            $code .= "</table>";
            $code .= "<BR>";
        }

        $code .= "</table>";

        $code .= "<BR>";
        
        $code .= "<div class='pagebreak'></div>";
    }
/****************************************************************************************************************/
// -> PAGE [7] - Segunda fase - Efeitos causados no homem e an�lise da fonte geradora
/****************************************************************************************************************/
    $code .= "<BR><p><BR>";
    $code .= "<center><div class='bigTitle'><b>2� FASE<BR><BR>EFEITOS CAUSADOS<BR><BR>NO HOMEM<BR><BR>E<BR><BR>AN�LISE DA<BR><BR>FONTE GERADORA<BR></b></div></center>";

    $code .= "<div class='pagebreak'></div>";
    
	$code .= "<br>";
    $code .= "<table border=0 width=100% cellspacig=0 cellpadding=0>";
    $code .= "<tr>";
    $code .= "<td align=center>";
    $code .= "<center><img src='../../../../images/boneco_ppra.jpg' border=0 width=450 height=650></center>";
    $code .= "</tr>";
    $code .= "</table>";
    
    $code .= "<div class='pagebreak'></div>";
    
    //TABELA DE LIMITE DE TOLER�NCIA PARA EXPOSI��O DE R�IDOS CONTINUO E INTERMITENTE
    $code .= "<BR><p><BR>";
    $code .= "<div class='mediumTitle'><b>TABELA DE LIMITE DE TOLER�NCIA PARA EXPOSI��O DE R�IDO CONT�NUO E INTERMITENTE</b></div>";
    $code .= "<BR>";
    $code .= "<table align='center' width='550' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>";
    $code .= "<tr>";
    $code .= "<td align='center' class='bgtitle'><b>N�vel de ru�do - db(A)</b></td>";
    $code .= "<td align='center' class='bgtitle'><b>M�xima exposi��o di�ria premiss�vel</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center' >85</td>";
    $code .= "<td align='left' >8 HORAS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center' >86</td>";
    $code .= "<td align='left' >7 HORAS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center' >87</td>";
    $code .= "<td align='left' >6 HORAS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center' >88</td>";
    $code .= "<td align='left' >5 HORAS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center' >89</td>";
    $code .= "<td align='left' >4 HORAS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center' >90</td>";
    $code .= "<td align='left' >4 HORAS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center' >91</td>";
    $code .= "<td align='left' >3 HORAS E 30 MINUTOS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center' >92</td>";
    $code .= "<td align='left' >3 HORAS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center' >93</td>";
    $code .= "<td align='left' >2 HORAS E 40 MINUTOS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center' >94</td>";
    $code .= "<td align='left' >2 HORAS E 15 MINUTOS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center' >95</td>";
    $code .= "<td align='left' >2 HORAS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center' >96</td>";
    $code .= "<td align='left' >1 HORA E 45 MINUTOS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center' >98</td>";
    $code .= "<td align='left' >1 HORA E 15 MINUTOS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center' >100</td>";
    $code .= "<td align='left' >1 HORA</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center' >102</td>";
    $code .= "<td align='left' >45 MINUTOS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center' >102</td>";
    $code .= "<td align='left' >45 MINUTOS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center' >104</td>";
    $code .= "<td align='left' >35 MINUTOS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center' >105</td>";
    $code .= "<td align='left' >30 MINUTOS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center' >106</td>";
    $code .= "<td align='left' >25 MINUTOS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center' >107</td>";
    $code .= "<td align='left' >20 MINUTOS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center'>110</td>";
    $code .= "<td align='left'>15 MINUTOS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center'>112</td>";
    $code .= "<td align='left'>10 MINUTOS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center'>114</td>";
    $code .= "<td align='left'>8 MINUTOS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align='center'>115</td>";
    $code .= "<td align='left'>7 MINUTOS</td>";
    $code .= "</tr>";
    $code .= "</table>";

    $code .= "<div class='pagebreak'></div>";
    
    /*******************************************************************/
    // - Segunda fase, avalia��o ambiental
    /*******************************************************************/
    for($x=0;$x<pg_num_rows($rca);$x++){
    	$code .= "<BR><p><BR>";
        $code .= "<div class='mediumTitle'><b>SEGUNDA FASE - AVALIA��O AMBIENTAL</b></div>";
        $code .= "<BR>";
        $code .= "<div class='dez'><b>PLANILHA DE QUANTIFICA��O DE RISCO � PQR - MEDI��ES</b></div>";
        $code .= "<BR>";
        $code .= "<div class='dez'><b>AVALIA��ES QUANTITATIVAS</b></div>";
        $code .= "<BR>";
        $sql = "SELECT t.nome, ca.nome as nome1, ag.*, r.fonte_geradora, tr.nome_tipo_risco
                FROM setor s, risco_setor r, cliente_setor c, tipo_contato t, contato_com_agente ca, agente_risco ag, tipo_risco tr
                WHERE r.cod_cliente = c.cod_cliente
       		    AND r.cod_setor = c.cod_setor
    			AND r.cod_setor = s.cod_setor
    			AND r.cod_tipo_contato = t.tipo_contato_id
    			AND r.cod_agente_contato = ca.contato_com_agente_id
    			AND c.id_ppra = r.id_ppra
    			AND c.id_ppra = ".(int)($cod_cgrt)."
    			AND c.cod_setor = ".(int)($srec[$x][cod_setor])."
    			AND ag.cod_tipo_risco = tr.cod_tipo_risco
    			AND r.cod_agente_risco = ag.cod_agente_risco";
        $rag = pg_query($sql);
        $sagent = pg_fetch_all($rag);
        
        $sql = "SELECT a.nome_aparelho FROM aparelhos a WHERE a.cod_aparelho = {$srec[$x][ruido]}";
        $aparelho = pg_fetch_array(pg_query($sql));
        $aparelho = $aparelho[nome_aparelho];
        
        //$sql = "SELECT * FROM cgrt_func_list WHERE cod_cgrt = ".(int)($cod_cgrt)." AND cod_setor = ".(int)($srec[$x][cod_setor]);
        $sql = "SELECT fl.*, f.* FROM cgrt_func_list fl, funcionarios f,   
			WHERE (f.setor_adicional like '{$srec[$x]['cod_setor']}|%' AND f.cod_cliente = fl.cod_cliente AND fl.cod_cgrt = $cod_cgrt AND f.cod_func = fl.cod_func AND fl.status = 1)
			OR (f.setor_adicional like '%|{$srec[$x]['cod_setor']}|%' AND f.cod_cliente = fl.cod_cliente AND fl.cod_cgrt = $cod_cgrt AND f.cod_func = fl.cod_func AND fl.status = 1)
			OR (f.cod_setor = {$srec[$x]['cod_setor']} AND f.cod_cliente = fl.cod_cliente AND fl.cod_cgrt = $cod_cgrt AND f.cod_func = fl.cod_func AND fl.status = 1)";
        $rfs = pg_query($sql);
        $funcbysetor = pg_fetch_all($rfs);
		
		$sql = "SELECT * FROM cgrt_func_list c, funcionarios f WHERE c.cod_setor = '".$srec[$x][cod_setor]."' AND c.cod_cgrt = '".$cod_cgrt."' AND c.cod_func = f.cod_func AND f.cod_cliente = c.cod_cliente AND c.cod_cliente = '".$info[cliente_id]."' AND c.status = '1'";
		$query = pg_query($sql);
		$fun = pg_fetch_all($query);
        
        $code .= "<table border=1 width=100% cellspacing=0 cellpadding=0>";
        $code .= "<tr>";
        $code .= "<td class='bgtitle' width=150><b>Setor/Posto</b></td>";
        $code .= "<td class='dez' width=280>{$srec[$x][nome_setor]}</td>";
        $code .= "<td class='bgtitle' width=150><b>Efetivo</b></td>";
        $code .= "<td class='dez' width=150>".str_pad(pg_num_rows($query), 2, "0", 0)."</td>";
        $code .= "</tr>";
        $code .= "<tr>";
        $code .= "<td class='bgtitle' width=150><b>Agente</b></td>";
        $code .= "<td class='dez' width=280>Ru�dos</td>";
        $code .= "<td class='bgtitle' width=150><b>Equipamento</b></td>";
        $code .= "<td class='dez' width=150>{$aparelho}</td>";
        $code .= "</tr>";
        $code .= "<tr>";
        $code .= "<td class='bgtitle' width=150><b>Data</b></td>";
        $code .= "<td class='dez' width=280>".date("d/m/Y", strtotime($info[data_avaliacao]))."</td>";
        $code .= "<td class='bgtitle' width=150><b>Ru�do de fundo</b></td>";
        $code .= "<td class='dez' width=150>{$srec[$x][ruido_fundo_setor]}</td>";
        $code .= "</tr>";
        $code .= "<tr>";
        $code .= "<td class='bgtitle' width=150><b>Hora</b></td>";
        $code .= "<td class='dez' width=280>".date("H:i", strtotime($info[data_avaliacao]))."</td>";//{$srec[$x][hora_avaliacao]}
        $code .= "<td class='bgtitle' width=150><b>Ru�do de opera��o</b></td>";
        $code .= "<td class='dez' width=150>{$srec[$x][ruido_operacao_setor]}</td>";
        $code .= "</tr>";
        
        $code .= "<tr>";
        $code .= "<td class='bgtitle' colspan=4 align=center><b>RELA��O NOMINAL DOS TRABALHADORES NO SETOR</b></td>";
        $code .= "</tr>";
        $code .= "<tr>";
        $code .= "<td class='dez' colspan=4 align=left>";
		/*
            for($y=0;$y<pg_num_rows($rfs);$y++){
                if(!empty($funcbysetor[$y][nome_func]))
                    $code .= str_replace('"', '�', $funcbysetor[$y][nome_func]);
                if($y<pg_num_rows($rfs)-1)
                    $code .= "; ";
                else
                    $code .= ".";
            }
		*/
		for($y=0;$y<pg_num_rows($query);$y++){
			$code.= $fun[$y][nome_func]."; <br />";
			
		}
		
        $code .= "&nbsp;";
        $code .= "</td>";
        $code .= "</tr>";
        
        $code .= "<tr>";
        $code .= "<td class='bgtitle' colspan=4 align=center><b>MEDIDAS DE CONTROLE IMPLEMENTADAS</b></td>";
        $code .= "</tr>";
        $code .= "<tr>";
        $code .= "<td class='dez' colspan=4 align=left>A empresa <b>$info[razao_social]</b> adota a medida de alterna��o de atividades nos setores.</td>";
        $code .= "</tr>";
        
        $code .= "<tr>";
        $code .= "<td class='bgtitle' colspan=4 align=center><b>DIN�MICA DA FUN��O</b></td>";
        $code .= "</tr>";
        $code .= "<tr>";
        $code .= "<td class='dez' colspan=4 align=left>{$srec[$x][desc_setor]}&nbsp;</td>";
        $code .= "</tr>";
        
        $code .= "</table>";
        
        $code .= "OBS: Recomenda-se que a lista nominal dos colaboradores por setor conste nos mesmos de acordo com suas fun��es e din�mica da fun��o.";
        $code .= "<div class='pagebreak'></div>";
    }
/****************************************************************************************************************/
// -> PAGE [8] - Terceira fase - Efeitos da ilumin�ncia
/****************************************************************************************************************/
  /*  $code .= "<BR><p><BR>";
    $code .= "<BR><p><BR>";
    $code .= "<BR><p><BR>";
    $code .= "<center><div class='bigTitle'><b>3� FASE<BR><BR>EFEITOS<BR><BR>DA<BR><BR>ILUMIN�NCIA<BR></b></div></center>";

    $code .= "<div class='pagebreak'></div>";
	
    $code .= "<BR><p><BR>";
    $code .= "<div class='mediumTitle'><b>AVALIA��O DE ILUMINA��O DO PPRA</b></div>";
    $code .= "<BR>";
    $code .= "<div class='dez'><b>1 - VALORA��O DE ILUMINA��O</b></div>";
    $code .= "<BR>";
    
    $code .= "<div class='dez'><b>TABELA 1 - VALORA��O QUANTITATIVA DE EXPOSI��O PARA ILUMINA��O</b></div>";
    $code .= "<BR>";
    $code .= "<table border=1 width=100% cellspacig=0 cellpadding=0>";
    $code .= "<tr>";
    $code .= "<td class='bgtitle' width=365 align=center><b>Par�metros de Classifica��o</b></td>";
    $code .= "<td class='bgtitle' width=365 align=center><b>Prioridade de Monitoramento e Medidas de Controle</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=left>Ict = VR ou Im = VR, > 0,7 Im ou qualquer Ifct > 1/10 ict</td>";
    $code .= "<td class='dez' width=365 align=left>0 - Desprez�vel</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=left>Ict < VR ou Im < VR, > 0,7 Im ou qualquer Ifct > 1/10 ict</td>";
    $code .= "<td class='dez' width=365 align=left>1 - De aten��o</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=left>Ict < 0,7 Im ou qualquer Ifct < 1/10 ict</td>";
    $code .= "<td class='dez' width=365 align=left>2 - Cr�tica</td>";
    $code .= "</tr>";
    $code .= "</table>";
    $code .= "VR � valor recomendado por tarefa e ou atividade;";
    $code .= "<BR>";
    $code .= "Ict � ilumina��o do campo de trabalho;";
    $code .= "<BR>";
    $code .= "Ifct � ilumina��o fora do campo de trabalho.";
    $code .= "<BR>";
    $code .= "<BR>";
    
    $code .= "<div class='dez'><b>TABELA 2 � VALORA��O QUANTITATIVA PARA AGENTES SEM N�VEL DE A��O</b></div>";
    $code .= "<table border=1 width=100% cellspacig=0 cellpadding=0>";
    $code .= "<tr>";
    $code .= "<td class='bgtitle' width=365 align=center><b>Par�metros de Classifica��o</b></td>";
    $code .= "<td class='bgtitle' width=365 align=center><b>Prioridade de Monitoramento e Medidas de Controle</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=left>Fonte < limite de toler�ncia com exposi��o habitual e permanente</td>";
    $code .= "<td class='dez' width=365 align=left>0 - Desprez�vel</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=left>Fonte < limite de toler�ncia com exposi��o ocasional e intermitente</td>";
    $code .= "<td class='dez' width=365 align=left>1 - De aten��o</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=left>Fonte >= limite de toler�ncia com exposi��o ocasional e intermitente</td>";
    $code .= "<td class='dez' width=365 align=left>2 - Cr�tica</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=left>Fonte > limite de toler�ncia com exposi��o habitual e permanente</td>";
    $code .= "<td class='dez' width=365 align=left>3 - Emergencial</td>";
    $code .= "</tr>";
    $code .= "</table>";
    
    $code .= "<BR>";

    $code .= "<div class='dez'><b>TABELA 3 � VALORA��O PRIORIZA��O DE MONITORIZA��O E DE MEDIDAS DE CONTROLE</b></div>";
    $code .= "<table border=1 width=100% cellspacig=0 cellpadding=0>";
    $code .= "<tr>";
    $code .= "<td class='bgtitle' width=365 align=center><b>Somar(tab. 1 + tab. 2) de Controle</b></td>";
    $code .= "<td class='bgtitle' width=365 align=center><b>Prioridade de Monitoramento e Medidas de Controle</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=left>&nbsp;</td>";
    $code .= "<td class='dez' width=365 align=left>0 - Desprez�vel</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=center>1 + 2</td>";
    $code .= "<td class='dez' width=365 align=left>1 - De aten��o</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=center>2 + 3</td>";
    $code .= "<td class='dez' width=365 align=left>2 - Cr�tica</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=center>3 + 3</td>";
    $code .= "<td class='dez' width=365 align=left>3 - Emergencial</td>";
    $code .= "</tr>";
    $code .= "</table>";

    $code .= "<div class='pagebreak'></div>";
    
    $code .= "<BR><p><BR>";
    $code .= "<div class='mediumTitle'><b>AVALIA��O DE ILUMINA��O DO PPRA</b></div>";
    $code .= "<BR>";
    
    $code .= "<table border=1 width=100% cellspacig=0 cellpadding=0>";
    $code .= "<tr>";
    $code .= "<td class='bgtitle' width=466 align=center><b>Local de Atividade</b></td>";
    $code .= "<td class='bgtitle' width=132 align=center><b>Lux: M�xima</b></td>";
    $code .= "<td class='bgtitle' width=132 align=center><b>Lux: M�nima</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=466 align=left><b>Escolas:</b> Salas de Aulas a Biblioteca.</td>";
    $code .= "<td class='dez' width=132 align=center>1.000</td>";
    $code .= "<td class='dez' width=132 align=center>250</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=466 align=left><b>Escrit�rio:</b> Recep��o, Adm, Financeira, etc...</td>";
    $code .= "<td class='dez' width=132 align=center>1.000</td>";
    $code .= "<td class='dez' width=132 align=center>200</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=466 align=left><b>Fundi��es:</b> �reas de Carregamentos e acabamentos.</td>";
    $code .= "<td class='dez' width=132 align=center>1.000</td>";
    $code .= "<td class='dez' width=132 align=center>150</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=466 align=left><b>Industriais:</b> Produ��o, montagem, Instrumentos Carregamentos e Acabamentos.</td>";
    $code .= "<td class='dez' width=132 align=center>1.000</td>";
    $code .= "<td class='dez' width=132 align=center>150</td>";
    $code .= "</tr>";
    $code .= "</table>";
    
    $code .= "<BR>";
    $code .= "<p align='justify'>";
    $code .= "<b>Lux</b> � (ilumina��o) pode ser: natural gerada dos raios solares ou claridade do dia; artificial gerada de fonte de energia el�trica; e /ou natural e artificial, as �reas que se compreendem como postos de trabalho devem ser iluminadas de forma homog�nea, n�o devendo ser permitida a constitui��o de sobras nas �reas de atua��o do funcion�rio / colaborador. Recomenda-se avaliar nas suas medi��es qualquer superf�cie apropriada ao trabalho visual, bem como avaliar tamb�m os piores n�veis de condi��es de iluminamento e a melhor, afim de considera��es necess�rias ao bom desempenho das atividades a ser exercida e a preserva��o da sa�de do trabalhador que podem ser desde a redu��o de lumin�rias a amplia��o ou substitui��o das l�mpadas ou calhas.";
    $code .= "<BR>";
    $code .= "<BR>";
    $code .= "<b>Temperatura</b> � Se realiza uma estimativa atrav�s de verifica��o da temperatura umidade relativa do ar, tendo seu controle feito por interm�dio de avalia��es de fonte e trajet�ria, s�o aplicadas ao meio de trabalho ou na a��o da trajet�ria que for implantada a carga t�rmica.";
    $code .= "<BR>";
    $code .= "<BR>";
    $code .= "<b>Medidas a tomar-se nesses casos:</b>";
    $code .= "<BR>";
    $code .= "Insufla��o de ar fresco no local de posto de trabalho;<BR>
    Temperatura do Ar;<BR>
    Maior circula��o do ar no local de posto de trabalho velocidade do ar;<BR>
    Diminuir a temperatura Exaust�o dos vapores de �gua emanada de um processo Umidade relativa do ar.<BR>";
    $code .= "<BR>";
    $code .= "Utiliza��o de barreira refletora (alum�nio polido, a�o inox) ou absorvente, ferro, a�o, de radia��o colocada entre as fontes e o trabalhador;<BR>
    Calor irradiante.<BR>";
    $code .= "<BR>";
    $code .= "Automa��o do processo produtivo ex: mudan�a do transporte manual de carga por esteiras ou ponte rolante;<BR>
    Calor irritante.<BR>";
    $code .= "</p>";
    $code .= "<div class='pagebreak'></div>";
    
    $sql = "SELECT s.nome_setor, ln.descricao_luz_nat, la.decricao_luz_art, cs.data_avaliacao, i.lux_atual,
            i.lux_recomendado, i.exposicao, i.movel, i.numero, f.cod_func, f.nome_func, s.cod_setor
    		FROM cliente_setor cs, setor s, luz_natural ln, luz_artificial la, iluminacao_ppra i, funcionarios f, cgrt_func_list l
    		WHERE cs.cod_setor = s.cod_setor
    		AND (i.cod_setor = l.cod_setor OR l.setor_adicional like '%'||cs.cod_setor||'%')
    		AND i.cod_setor = cs.cod_setor
    		AND ln.cod_luz_nat = cs.cod_luz_nat
    		AND la.cod_luz_art = cs.cod_luz_art
    		AND i.cod_cliente = cs.cod_cliente
    		AND f.cod_func = l.cod_func
    		AND i.cod_func = f.cod_func
    		AND f.cod_cliente = i.cod_cliente
    		AND cs.id_ppra = i.id_ppra
    		AND i.id_ppra = l.cod_cgrt
    		AND l.cod_cgrt = ".(int)($cod_cgrt);
    $rvq = pg_query($sql);
    $valquan = pg_fetch_all($rvq);
    //EXIBE TABELA SE EXISTIR RESULTADOS PRA BUSCA ACIMA (ILUMIN�NCIA CADASTRADA POR SETOR)
    if($valquan != ""){//(pg_num_rows($rvq)){
    	$code .= "<BR><p><BR>";
        $code .= "<div class='mediumTitle'><b>AVALIA��O DE ILUMINA��O DO PPRA</b></div>";
        $code .= "<BR>";
        $code .= "<div class='dez'><b>QUADRO DE AVALIA��O DE PRIORIDADES (AGENTE X SITUA��O DE RISCO)</b></div>";
        $code .= "<BR>";
        $code .= "<table border=1 width=100% cellspacig=0 cellpadding=0>";
        $code .= "<tr>";
        $code .= "<td class='bgtitle' align=center width=190><b>Setor</b></td>";
        $code .= "<td class='bgtitle' align=center width=190><b>Fonte de ilumina��o</b></td>";
        $code .= "<td class='bgtitle' align=center width=70><b>Data de avalia��o</b></td>";
        $code .= "<td class='bgtitle' align=center width=70><b>Tempo exp./dia</b></td>";
        $code .= "<td class='bgtitle' align=center width=70><b>Avalia��o pontual</b></td>";
        $code .= "<td class='bgtitle' align=center width=70><b>Valor recomendado</b></td>";
        $code .= "<td class='bgtitle' align=center width=70><b>Quadro de Prioriza��o</b></td>";
        $code .= "</tr>";
        for($z=0;$z<pg_num_rows($rvq);$z++){
            $code .= "<tr>";
            $code .= "<td class='dez' align=left>{$valquan[$z][nome_setor]}<BR>{$valquan[$z][nome_func]}<BR>{$valquan[$z][movel]} {$valquan[$z][numero]}</td>";
            $code .= "<td class='dez' align=left>{$valquan[$z][descricao_luz_nat]} + {$valquan[$z][decricao_luz_art]}</td>";
            $code .= "<td class='dez' align=center>".date("d/m/Y", strtotime($info[data_avaliacao]))."</td>";
            $code .= "<td class='dez' align=center>{$valquan[$z][exposicao]}</td>";
            $code .= "<td class='dez' align=center>{$valquan[$z][lux_atual]}</td>";
            $code .= "<td class='dez' align=center>{$valquan[$z][lux_recomendado]}</td>";
            $code .= "<td class='dez' align=center>";
            if($valquan[$z][lux_atual] < $valquan[$z][lux_recomendado])
    	        $code .= "Abaixo do limite permitido";
        	elseif ($valquan[$z][lux_atual] >= $valquan[$z][lux_recomendado] && $valquan[$z][lux_atual] <=1000)
            	$code .= "Desprezivel";
        	elseif($valquan[$z][lux_atual] > 1000)
            	$code .= "Acima do limite permitido";
            else
                $code .= "&nbsp;";
            $code .= "</td>";
            $code .= "</tr>";
        }
		//$code .= "</table>";
   }
   // FUNCION�RIO TERCEIRIZADO
	$sql = "SELECT s.nome_setor, ln.descricao_luz_nat, la.decricao_luz_art, cs.data_avaliacao, i.lux_atual,
            i.lux_recomendado, i.exposicao, i.movel, i.numero, s.cod_setor
    		FROM cliente_setor cs, setor s, luz_natural ln, luz_artificial la, iluminacao_ppra i
    		WHERE cs.cod_setor = s.cod_setor
    		AND i.cod_setor = cs.cod_setor
    		AND ln.cod_luz_nat = cs.cod_luz_nat
    		AND la.cod_luz_art = cs.cod_luz_art
    		AND i.cod_cliente = cs.cod_cliente
    		AND cs.id_ppra = i.id_ppra
			AND i.terceirizado = 'sim'
    		AND cs.id_ppra = ".(int)($cod_cgrt);
    $terc = pg_query($sql);
    $tt = pg_fetch_all($terc);

	if($terc != ""){
        for($z=0;$z<pg_num_rows($terc);$z++){
            $code .= "<tr>";
            $code .= "<td class='dez' align=left>{$tt[$z][nome_setor]}<BR>Terceirizado<BR>{$tt[$z][movel]} {$tt[$z][numero]}</td>";
            $code .= "<td class='dez' align=left>{$tt[$z][descricao_luz_nat]} + {$tt[$z][decricao_luz_art]}</td>";
            $code .= "<td class='dez' align=center>".date("d/m/Y", strtotime($info[data_avaliacao]))."</td>";
            $code .= "<td class='dez' align=center>{$tt[$z][exposicao]}</td>";
            $code .= "<td class='dez' align=center>{$tt[$z][lux_atual]}</td>";
            $code .= "<td class='dez' align=center>{$tt[$z][lux_recomendado]}</td>";
            $code .= "<td class='dez' align=center>";
            if($tt[$z][lux_atual] < $tt[$z][lux_recomendado])
    	        $code .= "Abaixo do limite permitido";
        	elseif ($tt[$z][lux_atual] >= $tt[$z][lux_recomendado] && $tt[$z][lux_atual] <=1000)
            	$code .= "Desprezivel";
        	elseif($tt[$z][lux_atual] > 1000)
            	$code .= "Acima do limite permitido";
            else
                $code .= "&nbsp;";
            $code .= "</td>";
            $code .= "</tr>";
        }
        $code .= "</table>";
        $code .= "<div class='pagebreak'></div>";
	}
    */
/****************************************************************************************************************/
// -> PAGE [9] - Quarta fase - Avalia��o do agente e das solu��es
/****************************************************************************************************************/
    $code .= "<BR><p><BR>";
    $code .= "<BR><p><BR>";
    $code .= "<BR><p><BR>";
    $code .= "<center><div class='bigTitle'><b>3� FASE<BR><BR>AVALIA��O DO AGENTE<BR><BR>E<BR><BR>DAS SOLU��ES<BR></b></div></center>";

    $code .= "<div class='pagebreak'></div>";
	
    $code .= "<BR><p><BR>";
    $code .= "<div class='mediumTitle'><b>ESTABELECIMENTO DE PRIORIDADES E METAS DE AVALIA��O E CONTROLE</b></div>";
    $code .= "<BR>";
    $code .= "<div class='dez'><b>Categorias de Riscos:</b></div>";
    $code .= "<BR>";
    $code .= "<table border=1 width=100% cellspacig=0 cellpadding=0>";
    $code .= "<tr>";
    $code .= "<td class='bgtitle' width=246 align=center><b>Categorias</b></td>";
    $code .= "<td class='bgtitle' width=242 align=center><b>Situa��es n�o avaliadas</b></td>";
    $code .= "<td class='bgtitle' width=242 align=center><b>Situa��es avaliadas</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=246 align=left>1 - Irrelevante (Controle de Rotinas)</td>";
    $code .= "<td class='dez' width=242 align=left><p align=justify>Quando o agente n�o representa risco potencial de dano � sa�de nas condi��es usuais industriais, escritas em literatura, ou pode representar, apenas um aspecto de desconforto e n�o de risco.</td>";
    $code .= "<td class='dez' width=242 align=center><p align=justify>Quando o agente se encontra sob controle t�cnico e abaixo do n�vel de a��o, ou seja, metade do limite tolerante.</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=246 align=left>2 � De aten��o (Controle Preferencial/Monitoramento)</td>";
    $code .= "<td class='dez' width=242 align=center><p align=justify>Quando o agente representa o risco moderado a sa�de, nas condi��es usuais industriais descritas na literatura, n�o causando efeitos agudos. Quando o agente pode causar efeitos agudos ou possuem LT valor teto ou valores de LT  muito baixo (alguns PPM).</td>";
    $code .= "<td class='dez' width=242 align=left><p align=justify>Quando a exposi��o se encontra sob controle t�cnico e acima do n�vel de a��o, por�m abaixo do LT.</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=246 align=left>3 - Cr�tica (Controle Priorit�rio)</td>";
    $code .= "<td class='dez' width=242 align=center><p align=justify>Quando as pr�ticas operacionais / condi��es ambientais indicam aparente descontrole de Exposi��o. Quando h� possibilidade de defici�ncia de oxig�nio. Quando n�o h� prote��o cut�nea especifica. No manuseio de subst�ncias com nota��o dele. Quando h� queixas especificas / indicadores  biol�gicos de exposi��o excedidos.</td>";
    $code .= "<td class='dez' width=242 align=left><p align=justify>Quando a exposi��o n�o se encontra sob controle t�cnico esta acima do LT m�dia ponderada, por�m abaixo do valor m�ximo ou valor teto.</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=246 align=left>4 - Emergencial (Controle de Urg�ncia)</td>";
    $code .= "<td class='dez' width=242 align=center><p align=justify>Quando envolve exposi��o a carcinog�nicos nas situa��es aparentes de riscos grave e Iminente. Quando h� risco aparente de defici�ncia de oxig�nio. Quando o agente possui efeitos agudos, baixos, LT e IDLH concentra��es imediatamente. Perigosas � vida /  sa�de e as pr�ticas operacionais situa��es ambientais indicam aparentes descontroles de exposi��o. Quando h� exposi��o cut�nea severa a subst�ncias com nota��o na pele.</td>";
    $code .= "<td class='dez' width=242 align=left><p align=justify>Quando a exposi��o n�o se encontra sob controle t�cnico esta acima do valor teto/valor m�ximo � IDLH.</td>";
    $code .= "</tr>";
    $code .= "</table>";
    
    $code .= "<div class='pagebreak'></div>";
    
    $code .= "<BR><p><BR>";
    $code .= "<div class='mediumTitle'><b>AVALIA��O DE RISCOS DO PPRA</b></div>";
    $code .= "<BR>";
    $code .= "<div class='dez'><b>1 - VALORA��O DE PRIORIDADES</b></div>";
    $code .= "<BR>";
    
    $code .= "<div class='dez'><b>TABELA 1 - GRADUA��O QUALITATIVA DE EXPOSI��O</b></div>";
    $code .= "<table border=1 width=100% cellspacig=0 cellpadding=0>";
    $code .= "<tr>";
    $code .= "<td class='bgtitle' width=365 align=center><b>Categoria</b></td>";
    $code .= "<td class='bgtitle' width=365 align=center><b>Descri��o</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=left>0 - N�o h� exposi��o</td>";
    $code .= "<td class='dez' width=365 align=left>Nenhum contato com o agente.</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=left>1 - Baixos n�veis</td>";
    $code .= "<td class='dez' width=365 align=left>Contato ocasional e intermitente com o agente.</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=left>2 - Exposi��o moderada</td>";
    $code .= "<td class='dez' width=365 align=left>Contato ocasional e permanente ou habitual e intermitente.</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=left>3 - Exposi��o elevada</td>";
    $code .= "<td class='dez' width=365 align=left>Contato habitual e permanente com o agente.</td>";
    $code .= "</tr>";
    $code .= "</table>";
    $code .= "<BR>";
    
    $code .= "<div class='dez'><b>TABELA 2 - GRADUA��O QUALITATIVA DOS EFEITOS AO ORGANISMO HUMANO</b></div>";
    $code .= "<table border=1 width=100% cellspacig=0 cellpadding=0>";
    $code .= "<tr>";
    $code .= "<td class='bgtitle' width=365 align=center><b>Categoria</b></td>";
    $code .= "<td class='bgtitle' width=365 align=center><b>Descri��o</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=left>0 - In�cuo</td>";
    $code .= "<td class='dez' width=365 align=left>Efeitos revers�veis de pouca import�ncia, n�o conhecidos.</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=left>1 - Revers�vel</td>";
    $code .= "<td class='dez' width=365 align=left>Efeitos revers�veis preocupantes.</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=left>2 - Irrevers�vel</td>";
    $code .= "<td class='dez' width=365 align=left>Efeitos irrevers�veis preocupantes.</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=left>3 - Incapacitante</td>";
    $code .= "<td class='dez' width=365 align=left>Amea�a � vida ou � sa�de / les�o incapacitaste.</td>";
    $code .= "</tr>";
    $code .= "</table>";
    $code .= "<BR>";
    
    $code .= "<div class='dez'><b>TABELA 3 - VALORA��O QUALITATIVA</b></div>";
    $code .= "<table border=1 width=100% cellspacig=0 cellpadding=0>";
    $code .= "<tr>";
    $code .= "<td class='bgtitle' width=365 align=center><b>Somar(tab.1 + tab.2)</b></td>";
    $code .= "<td class='bgtitle' width=365 align=center><b>Prioridade de monitorizar�o e medidas de controle</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=center>0 + 1</td>";
    $code .= "<td class='dez' width=365 align=left>0 - Desprez�vel</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=center>1 + 2</td>";
    $code .= "<td class='dez' width=365 align=left>1 - De Aten��o</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=center>2 + 3</td>";
    $code .= "<td class='dez' width=365 align=left>2 - Cr�tica</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=center>3 + 3</td>";
    $code .= "<td class='dez' width=365 align=left>3 - Emergencial</td>";
    $code .= "</tr>";
    $code .= "</table>";
    $code .= "<BR>";
    
    $code .= "<div class='dez'><b>TABELA 4 - VALORA��O QUALITATIVA PARA AGENTES COM N�VEL DE A��O</b></div>";
    $code .= "<table border=1 width=100% cellspacig=0 cellpadding=0>";
    $code .= "<tr>";
    $code .= "<td class='bgtitle' width=365 align=center><b>Par�metro de Classifica��o</b></td>";
    $code .= "<td class='bgtitle' width=365 align=center><b>Prioridade de monitorizar�o e medidas de controle</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=left>Agente < N�vel de A��o</td>";
    $code .= "<td class='dez' width=365 align=left>0 - Desprez�vel</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=left>Agente > N�vel de A��o</td>";
    $code .= "<td class='dez' width=365 align=left>1 - De Aten��o</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=left>Agente = Limite de Toler�ncia</td>";
    $code .= "<td class='dez' width=365 align=left>2 - Cr�tica</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='dez' width=365 align=left>Agente > Limite de Toler�ncia</td>";
    $code .= "<td class='dez' width=365 align=left>3 - Emergencial</td>";
    $code .= "</tr>";
    $code .= "</table>";
    $code .= "<BR>";
    
    $code .= "<div class='pagebreak'></div>";
	
    $code .= "<BR><p><BR>";
    $code .= "<div class='mediumTitle'><b>AVALIA��O DE RISCOS DO PPRA</b></div>";
    $code .= "<BR>";
    $code .= "<BR>";
    $code .= "<div class='dez'><b>QUADRO DE AVALIA��O DE PRIORIDADES (AGENTE X SITUA��O DE RISCO)</b></div>";
    $code .= "<BR>";
    $code .= "<table border=1 width=100% cellspacig=0 cellpadding=0>";
    $code .= "<tr>";
    $code .= "<td class='bgtitle' align=center width=100><b>Setor</b></td>";
    $code .= "<td class='bgtitle' align=center width=70><b>Agente</b></td>";
    $code .= "<td class='bgtitle' align=center width=70><b>N�vel</b></td>";
    $code .= "<td class='bgtitle' align=center width=70><b>Grau de intensidade e efeitos</b></td>";
    $code .= "<td class='bgtitle' align=center width=70><b>Danos � Sa�de</b></td>";
    $code .= "<td class='bgtitle' align=center width=70><b>Escala de A��o</b></td>";
    $code .= "<td class='bgtitle' align=center width=280><b>A��es Necess�rias</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td class='bgtitle' align=center width=100>&nbsp;</td>";
    $code .= "<td class='bgtitle' align=center width=70>&nbsp;</td>";
    $code .= "<td class='bgtitle' align=center width=70>";
        $code .= "<table align=center width=70 border=0 cellpadding=0 cellspacing=0><tr><td width=23 align=center class='dez bgtitle'>I</td><td width=23 align=center class='dez bgtitle'>II</td><td width=23 align=center class='dez bgtitle'>III</td></tr></table>";
    $code .= "</td>";
    $code .= "<td class='bgtitle' align=center width=70>&nbsp;</td>";
    $code .= "<td class='bgtitle' align=center width=70>&nbsp;</td>";
    $code .= "<td class='bgtitle' align=center width=70>";
        $code .= "<table align=center width=70 border=0 cellpadding=0 cellspacing=0><tr><td width=23 align=center class='dez bgtitle'>I</td><td width=23 align=center class='dez bgtitle'>II</td><td width=23 align=center class='dez bgtitle'>III</td></tr></table>";
    $code .= "</td>";
    $code .= "<td class='bgtitle' align=center width=280>&nbsp;</td>";
    $code .= "</tr>";

    for($x=0;$x<pg_num_rows($rca);$x++){
        $sql = "SELECT s.nome_setor, r.nivel, r.itensidade, r.danos_saude, r.escala_acao, r.acao_necessaria, tp.nome_tipo_risco
      	        FROM setor s, risco_setor r, cliente_setor c, agente_risco a, tipo_risco tp
    			WHERE r.cod_cliente = c.cod_cliente
    			AND r.cod_setor = c.cod_setor
    			AND r.cod_setor = s.cod_setor
    			AND r.cod_agente_risco = a.cod_agente_risco
    			AND a.cod_tipo_risco = tp.cod_tipo_risco
    			AND r.cod_setor = ".(int)($srec[$x][cod_setor])."
    			AND c.id_ppra = r.id_ppra
    			AND c.id_ppra = ".(int)($cod_cgrt);
        $rrs = pg_query($sql);
        $arisetor = pg_fetch_all($rrs);
        for($y=0;$y<pg_num_rows($rrs);$y++){
            $code .= "<tr>";
            if(empty($y))
                $code .= "<td align=left width=100 rowspan='".(int)(pg_num_rows($rrs))."'>{$srec[$x][nome_setor]}</td>";
            $code .= "<td align=center width=70>{$arisetor[$y][nome_tipo_risco]}</td>";
            $code .= "<td align=center width=70>";
                $x1 = "&nbsp;";
    		    $x2 = "&nbsp;";
    		    $x3 = "&nbsp;";
    		    if($arisetor[$y][nivel] == "I")
                    $x1 = "I";
        		elseif($arisetor[$y][nivel] == "II")
            		$x2 = "II";
        		elseif($arisetor[$y][nivel] == "III")
            		$x3 = "III";
                $code .= "<table align=center width=70 border=0 cellpadding=0 cellspacing=0><tr><td width=23 align=center class='dez'>$x1</td><td width=23 align=center class='dez'>$x2</td><td width=23 align=center class='dez'>$x3</td></tr></table>";
            $code .= "</td>";
            $code .= "<td align=center width=70>{$arisetor[$y][itensidade]}</td>";
            $code .= "<td align=center width=70>{$arisetor[$y][danos_saude]}</td>";
            $code .= "<td align=center width=70>";
                $x1 = "&nbsp;";
    		    $x2 = "&nbsp;";
    		    $x3 = "&nbsp;";
    		    if($arisetor[$y][escala_acao] == "I")
                    $x1 = "I";
        		elseif($arisetor[$y][escala_acao] == "II")
            		$x2 = "II";
        		elseif($arisetor[$y][escala_acao] == "III")
            		$x3 = "III";
                $code .= "<table align=center width=70 border=0 cellpadding=0 cellspacing=0><tr><td width=23 align=center class='dez'>$x1</td><td width=23 align=center class='dez'>$x2</td><td width=23 align=center class='dez'>$x3</td></tr></table>";
            $code .= "</td>";
            $code .= "<td align=center width=280>{$arisetor[$y][acao_necessaria]}</td>";
            $code .= "</tr>";
        }
    }
    $code .= "</table>";
    $code .= "<b>Grau de Intensidade e de Efeitos:</b> Curto Prazo, M�dio Prazo, Longo Prazo.<BR>
    <b>Danos � Sa�de:</b> N�o Grave, Grave, Grav�ssimo. ";
    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [10] - Quinta fase - An�lise em �mbito geral
/****************************************************************************************************************/
    $code .= "<BR><p><BR>";
    $code .= "<BR><p><BR>";
    $code .= "<BR><p><BR>";
    $code .= "<center><div class='bigTitle'><b>4� FASE<BR><BR>AN�LISE<BR><BR>EM<BR><BR>�MBITO GERAL<BR></b></div></center>";

    $code .= "<div class='pagebreak'></div>";
	
    $code .= "<BR><p><BR>";
    $code .= "<div class='mediumTitle'><b>MAPA DE RISCO AMBIENTAL</b></div>";
    $code .= "<BR>";
    $code .= "<p align='justify'>";
    $code .= "
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PORTARIA 33 de Outubro de 1983, em que determina a ado��o de todas as empresas que possuam ou n�o a CIPA (Comiss�o Interna de Preven��o de Acidentes), dever� elaborar um MAPA DE RISCOS AMBIENTAIS, que ser� executado pela CIPA (quando houver), ou por profissionais qualificados.<BR>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A cada nova gest�o o MAPA DE RISCOS AMBIENTAIS, ser� feito visando indicar �reas com riscos a fim de controlar e eliminar as incid�ncias de riscos dos locais assim determinados por ele.<BR>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O mapeamento ser� feito atrav�s do laudo, com apresenta��o gr�fica do reconhecimento dos riscos dos locais assim determinados.<BR>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RISCOS PEQUENOS: 2,5 cm de Di�metro; RISCOS M�DIOS: 5,0 cm de Di�metro; RISCOS GRANDES: 10,0 cm de Di�metro.<BR>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ser� a �rea de risco determinada, conforme sua gravidade e em cores, de acordo com riscos encontrados e relacionados na tabela.<BR>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ap�s identifica��o dos riscos, os resultados ser�o encaminhados � dire��o da empresa para avalia��o e retornem com as medidas de providencias a serem tomadas nos prazos m�ximos de acordo com a cumplicidade e cronograma de solu��o que lhe forem informados para o cumprimento, n�o devendo ser superior a trinta dias como base, a contar do recebimento de relat�rio.<BR>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constatada as necessidades e ado��o de medidas preventivas, caber� a diretoria definir o prazo e realizar tais altera��es sugeridas em relat�rio e anota��es.";
    $code .= "<BR>";
    $code .= "<div class='mediumTitle'><b>METODOLOGIA DE AVALIA��O DOS RISCOS E CARACTERIZA��O DE EXPOSI��O</b></div>";
    $code .= "<BR>";
    $code .= "<div class='mediumTitle'><b>RU�DO</b></div>";
    $code .= "<p align='justify'>";
    $code .= "� Medi��es em decib�is (db), com o instrumento operado no circuito de compensa��o �A� e circuito de resposta lenta (SLOW), � leitura e feita pr�ximo ao ouvido do trabalhador e nos locais considerados como de maior perman�ncia do mesmo.";
    $code .= "<BR>";
    $code .= "<div class='dez'><b>CONFORMIDADE</b></div>";
    $code .= "<p align='justify'>";
    $code .= "
    � Anexo 1, item 2 da NR 15 Portaria 3214  de 08/06/78 � MTB.<br>
	� NHT � 06 R/E � Norma para avalia��o de exposi��o ocupacional ao ru�do da Fundacentro.";
	$code .= "<BR>";
    $code .= "<div class='dez'><b>APARELHOS UTILIZADOS</b></div>";
    $code .= "<p align='justify'>";
    $code .= "
    � Medidor de n�vel de press�o sonora (decibel�metro), marca CEM Instrumentos � modelo DT-805 � tipo 2, S�rie 12050406, fabricado pela CEM Instrumentos e aferido em 114db (A), com calibrador modelo QC-10 da Quest (USA) n. QIG010228 (frequ�ncia 1Hz).";
    $code .= "<BR>";
    $code .= "<div class='mediumTitle'><b>ILUMIN�NCIA</b></div>";
    $code .= "<p align='justify'>";
    $code .= "
    � Medi��es em luxes, ressaltando algumas observa��es para melhor interpreta��o.";
    $code .= "<BR>";
    $code .= "<div class='dez'><b>LUXES</b></div>";
    $code .= "<p align='justify'>";
    $code .= "
    � N�veis de Ilumin�ncia obtidos atrav�s da ilumina��o local(ambiente). A superf�cie da fotoc�lula dave ficar plano horizontal, a uma dist�ncia de 0,75cm do piso.";
	$code .= "<br><p>";
    $code .= "<div class='dez'><b>COMFORMIDADE</b></div>";
    $code .= "<p align='justify'>";
    $code .= "
    � NR-17 Portaria 3214 de 08/06/78 � MTE.<BR>
    � NBR 8995-1 � Verifica��o de Ilumina��o de Interiores � ABNT.";
    $code .= "<BR>";
    $code .= "<div class='dez'><b>APARELHOS UTILIZADOS</b></div>";
    $code .= "<p align='justify'>";
    $code .= "
    � Lux�metro Digital, Modelo: ICEL LD-510, S�rie: S421334 / Fabricado pela Icel Manaus.";

    $code .= "<BR>";
    $code .= "<div class='mediumTitle'><b>ANEXO 1</b></div>";
    $code .= "<BR>";
    $code .= "<div class='dez'><b>RECOMENDA��ES FINAIS</b></div>";
    $code .= "<BR>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Com base na an�lise dos dados obtidos nas instala��es t�cnicas de seguran�a e nas avalia��es decorrentes das medi��es realizadas, apresentamos as orienta��es e os procedimentos a serem adotados para a melhoria do n�vel das condi��es a sa�de e de seguran�a no ambiente de trabalho:";
    $code .= "<BR>";
    $code .= "<b>1 - Ilumina��o:</b><BR>Aumentar o n�vel de ilumina��o dos ambientes de trabalho de forma a adequ�-los conforme NBR 8995-1 da ABNT, objetivando atender o laudo ergon�mico se o tiver.";
    $code .= "<BR>";
    $code .= "<b>2 - Ergonomia:</b><BR>
    a) Melhorar ilumina��o para atividade de digita��o;<BR>
    b) Coloca��o de Tela anti-reflexiva;<BR>
    c) Descanso para os P�s, onde o funcion�rio passa a maior parte da sua jornada de trabalho sentado.";
    $code .= "<BR>";
    $code .= "<b>3 - Condi��es sanit�rias e de conforto nos locais de trabalho:</b><BR>
    a) Limpeza e Ordem tamb�m fazem parte da seguran�a. Um bom servi�o de conserva��o constitui uma parte importante de um programa eficiente de prote��o contra acidentes e inc�ndio. Para tanto, � necess�rio evitar o acumulo de materiais combust�veis;<BR>
	b) A empresa dever� ter �gua, em condi��o higi�nica, fornecida por meio de copos individuais, ou bebedouros de jato inclinado e guarda - protetora, proibindo-se sua instala��o em pias e lavat�rios, e o uso de copos coletivos;<BR>
    c) A limpeza do filtro do aparelho de ar condicionado deve ser peri�dica, em espa�o de tempo equivalente h� noventa dias, para assegurar boa qualidade do ar circulante;<BR>
    d) Os gabinetes sanit�rios dever�o possuir recipientes com tampa, para guarda de pap�is servidos;<BR>
    e) Os locais onde se encontrarem instala��es sanit�rias, dever�o ser submetidos a processo permanente de higieniza��o de sorte que sejam mantidos limpos e desprovidos de quaisquer odores, durante toda a jornada de trabalho.";
	$code .= "<BR><BR>";

    $code .= "<div class='pagebreak'></div>";
	
    $code .= "<BR><p><BR>";
    $code .= "<div class='mediumTitle'><b>ANEXO 2</b></div>";
    $code .= "<BR>";
    $code .= "<div class='dez'><b>4 - PROTE��O CONTRA INC�NDIO NR-23</b></div>";
    $code .= "<BR>";
    $code .= "<b>23.1</b> Todos os empregadores devem adotar medidas de preven��o de inc�ndios, em conformidade com a legisla��o estadual e as normas t�cnicas aplic�veis.<BR><BR>
    <b>23.1.1</b> O empregador deve providenciar para todos os trabalhadores informa��es sobre:<BR>
    A) utiliza��o dos equipamentos de combate ao inc�ndio;<BR>
    B) procedimentos para evacua��o dos locais de trabalho com seguran�a;<BR>
    C) dispositivos de alarme existentes.<BR><BR>
    <b>23.2</b> Os locais de trabalho dever�o dispor de sa�das, em n�mero suficiente e dispostas de modo que aqueles que se encontrem nesses locais possam abandon�-los com rapidez, em caso de emerg�ncia.<BR><BR>
    <b>23.3</b> As aberturas, sa�das e vias de passagem devem ser claramente assinaladas por meio de placas ou sinais luminosos, indicando a dire��o da sa�da.<BR><BR>
    <b>23.4</b> Nenhuma sa�da de emerg�ncia dever� ser fechada � chave ou presa durante a jornada de trabalho.<BR><BR>
    <b>23.5</b> As sa�das de emerg�ncia podem ser equipadas com dispositivos de travamento que permitam f�cil abertura do interior do estabelecimento.";
    $code .= "<BR>";
    
    $code .= "<div class='pagebreak'></div>";
    
    
    for($x=0;$x<pg_num_rows($rca);$x++){
        $smes = array(" ", "J", "F", "M", "A", "M", "J", "J", "A", "S", "O", "N", "D");
        // --> MEDIDAS PREVENTIVAS
        // - Tabela para armazenamento: sugestao
        // - C�d de campo tipo:
        // .0 EPI
        // .1 Medi
        // .2 Curso
        // .3 Ambiental
        // .4 Programas
        //----------------------------------------
        // --> SUGEST�O SETOR [EPI]
        //----------------------------------------
        $sql = "SELECT s.*, se.descricao, st.nome_setor FROM sugestao s, setor_epi se, setor st
        WHERE (s.med_prev = se.id AND s.cod_setor = st.cod_setor AND se.cod_setor = s.cod_setor
        AND s.cod_setor = ".(int)($srec[$x][cod_setor]).")
        AND s.tipo_med_prev = 0 AND s.plano_acao = 1 AND s.id_ppra = ".(int)($cod_cgrt);
        $r_s_e = pg_query($sql);
        $sugestao_setor_epi = pg_fetch_all($r_s_e);
        //----------------------------------------
        // --> SUGEST�O SETOR [CURSO]
        //----------------------------------------
        $sql = "SELECT DISTINCT(fc.descricao) FROM sugestao s, funcao_curso fc WHERE fc.id = s.med_prev AND s.id_ppra = ".(int)($cod_cgrt)." AND s.cod_setor = ".(int)($srec[$x][cod_setor])." AND s.tipo_med_prev = 2 ANd s.plano_acao = 1";
        $r_s_c = pg_query($sql);
        $sugestao_setor_curso = pg_fetch_all($r_s_c);
		//----------------------------------------
        // --> SUGEST�O SETOR [AMBIENTAL]
        //----------------------------------------
        $sql = "SELECT DISTINCT(sa.descricao) FROM sugestao s, setor_ambiental sa WHERE sa.id = s.med_prev AND s.id_ppra = ".(int)($cod_cgrt)." AND s.cod_setor = ".(int)($srec[$x][cod_setor])." AND s.tipo_med_prev = 3 ANd s.plano_acao = 1";
        $r_s_a = pg_query($sql);
        $sugestao_setor_ambiental = pg_fetch_all($r_s_a);
        //----------------------------------------
        // --> SUGEST�O SETOR [PROGRAMAS]
        //----------------------------------------
        $sql = "SELECT s.*, sp.* FROM sugestao s, setor_programas sp WHERE sp.id = s.med_prev AND s.id_ppra = ".(int)($cod_cgrt)." AND s.cod_setor = ".(int)($srec[$x][cod_setor])." AND s.tipo_med_prev = 4 ANd s.plano_acao = 1";
        $r_s_p = pg_query($sql);
        $sugestao_setor_prog = pg_fetch_all($r_s_p);
        //----------------------------------------
        // --> SUGEST�O SETOR [MANUTEN��O NO PARA-RAIOS]
        //----------------------------------------
        //Que porra � essa de para-raio se n�o armazena em nenhum lugar? 0.o
        //Para-raio em mangueiras -.-'''''''
        //$sql = "SELECT c.*, t.*, st.nome_setor FROM cliente_setor c, tipo_para_raio t, setor st WHERE c.cod_setor = st.cod_setor AND c.cod_setor = {$row_ativ[$a]['cod_setor']} AND c.tipo_para_raio_id = t.tipo_para_raio_id AND (t.tipo_para_raio_id = 2 or t.tipo_para_raio_id = 3) AND c.id_ppra = $_GET[id_ppra]";
        $sql = "SELECT c.data_criacao, t.tipo_para_raio FROM cliente_setor c, tipo_para_raio t WHERE c.tipo_para_raio_id = t.tipo_para_raio_id AND (t.tipo_para_raio_id = 2 or t.tipo_para_raio_id = 3) AND c.cod_setor = ".(int)($srec[$x][cod_setor])." AND c.id_ppra = ".(int)($cod_cgrt);
        $r_s_praio = pg_query($sql);
        $sugestao_setor_praio = pg_fetch_all($r_s_praio);
        //----------------------------------------
        // --> SUGEST�O SETOR [EPC SUGERIDO]
        //----------------------------------------
        $sql = "SELECT epc_sugerido, nome_setor FROM cliente_setor cs, setor s WHERE cs.cod_setor = s.cod_setor AND cs.cod_setor = ".(int)($srec[$x][cod_setor])." AND cs.id_ppra = ".(int)($cod_cgrt);
        $r_s_epc = pg_query($sql);
        $sugestao_setor_epc = pg_fetch_all($r_s_epc);
        //----------------------------------------
        // --> SUGEST�O SETOR [VISTORIA DE HIDRANTE]
        //----------------------------------------
        //$sql = "SELECT cs.*, t.*, s.nome_setor FROM cliente_setor cs, tipo_hidrante t, setor s WHERE cs.tipo_hidrante_id = t.tipo_hidrante_id AND cs.cod_setor = s.cod_setor AND cs.cod_setor = ".(int)($srec[$x][cod_setor])." AND cs.tipo_hidrante_id <> 1 AND cs.id_ppra = ".(int)($cod_cgrt);
        $sql = "SELECT cs.data_criacao, cs.vistoria, t.tipo_hidrante FROM cliente_setor cs, tipo_hidrante t WHERE cs.tipo_hidrante_id = t.tipo_hidrante_id AND cs.cod_setor = ".(int)($srec[$x][cod_setor])." AND cs.tipo_hidrante_id <> 1 AND cs.id_ppra = ".(int)($cod_cgrt);
        $r_s_hid = pg_query($sql);
        $sugestao_setor_hid = pg_fetch_all($r_s_hid);
        //----------------------------------------
        // --> SUGEST�O SETOR [FAZER HIGI. VENT ARTIFICIAL FIXAR CART�O]
        //----------------------------------------
        //$sql = "SELECT cs.*, va.*, s.nome_setor FROM cliente_setor cs, ventilacao_artificial va, setor s WHERE cs.cod_vent_art = va.cod_vent_art AND cs.cod_setor = s.cod_setor AND cs.cod_setor = ".(int)($srec[$x][cod_setor])." AND cs.dt_ventilacao is not null AND cs.id_ppra = ".(int)($cod_cgrt);
        $sql = "SELECT cs.data_criacao, va.nome_vent_art, cs.dt_ventilacao FROM cliente_setor cs, ventilacao_artificial va WHERE cs.cod_vent_art = va.cod_vent_art AND cs.cod_setor = ".(int)($srec[$x][cod_setor])." AND cs.dt_ventilacao is not null AND cs.id_ppra = ".(int)($cod_cgrt);
        $r_s_vart = pg_query($sql);
        $sugestao_setor_vart = pg_fetch_all($r_s_vart);
        //----------------------------------------
        // --> SUGEST�O SETOR [LIMPEZA MECANICA e FIXAR CARTAO NO VENTILADOR]
        //----------------------------------------
        //$sql = "SELECT cs.*, t.*, s.nome_setor FROM cliente_setor cs, ventilacao_artificial t, setor s where cs.cod_vent_art = t.cod_vent_art AND cs.cod_setor = s.cod_setor AND cs.cod_setor = ".(int)($srec[$x][cod_setor])." and (t.cod_vent_art = 7 or t.cod_vent_art = 8 or t.cod_vent_art = 9 or t.cod_vent_art = 10) AND cs.id_ppra = ".(int)($cod_cgrt);
        $sql = "SELECT cs.data_criacao, t.nome_vent_art FROM cliente_setor cs, ventilacao_artificial t where cs.cod_vent_art = t.cod_vent_art AND cs.cod_setor = ".(int)($srec[$x][cod_setor])." and (t.cod_vent_art = 7 or t.cod_vent_art = 8 or t.cod_vent_art = 9 or t.cod_vent_art = 10) AND cs.id_ppra = ".(int)($cod_cgrt);
        $r_s_vent = pg_query($sql);
        $sugestao_setor_vent = pg_fetch_all($r_s_vent);
        //----------------------------------------
        // --> SUGEST�O SETOR [FAZER LIMPEZA DO ??CLIMA?? E ARMAZENAR CART�O]
        //----------------------------------------
        //$sql = "SELECT cs.*, t.* FROM cliente_setor cs, ventilacao_artificial t WHERE cs.cod_vent_art = t.cod_vent_art AND cs.cod_setor = ".(int)($srec[$x][cod_setor])." AND t.cod_vent_art = 12 AND cs.id_ppra = ".(int)($cod_cgrt);
        $sql = "SELECT cs.data_criacao, t.nome_vent_art FROM cliente_setor cs, ventilacao_artificial t WHERE cs.cod_vent_art = t.cod_vent_art AND cs.cod_setor = ".(int)($srec[$x][cod_setor])." AND t.cod_vent_art = 12 AND cs.id_ppra = ".(int)($cod_cgrt);
        $r_s_clima = pg_query($sql);
        $sugestao_setor_clima = pg_fetch_all($r_s_clima);
        //----------------------------------------
        // --> SUGEST�O SETOR [HIGNIFUGA��O NO CARPETE]
        //----------------------------------------
        //$sql = "SELECT cs.*, p.*, s.nome_setor FROM cliente_setor cs, piso p, setor s WHERE cs.cod_piso = p.cod_piso AND cs.cod_setor = s.cod_setor AND cs.cod_setor = ".(int)($srec[$x][cod_setor])." AND p.cod_piso = 17 AND cs.id_ppra = ".(int)($cod_cgrt);
        $sql = "SELECT cs.data_criacao, p.nome_piso FROM cliente_setor cs, piso p WHERE cs.cod_piso = p.cod_piso AND cs.cod_setor = ".(int)($srec[$x][cod_setor])." AND p.cod_piso = 17 AND cs.id_ppra = ".(int)($cod_cgrt);
        $r_s_carpete = pg_query($sql);
        $sugestao_setor_carpete = pg_fetch_all($r_s_carpete);
        //----------------------------------------
        // --> SUGEST�O SETOR [INSTALAR EXTINTOR]
        //----------------------------------------
        //$sql = "SELECT cs.*, e.*, s.nome_setor FROM cliente_setor cs, extintor e, setor s WHERE cs.cod_cliente = e.cod_cliente AND cs.cod_setor =  s.cod_setor AND s.cod_setor = e.cod_setor AND cs.id_ppra = e.id_ppra AND cs.cod_setor = ".(int)($srec[$x][cod_setor])." AND e.extintor = 'sugerido' AND cs.id_ppra = ".(int)($cod_cgrt);
        $sql = "SELECT cs.data_criacao, e.tipo_extintor FROM cliente_setor cs, extintor e WHERE cs.cod_cliente = e.cod_cliente AND cs.cod_setor = e.cod_setor AND cs.cod_setor = ".(int)($srec[$x][cod_setor])." AND e.extintor = 'sugerido' AND cs.id_ppra = e.id_ppra AND cs.id_ppra = ".(int)($cod_cgrt);
        $r_s_iext = pg_query($sql);
        $sugestao_setor_iext = pg_fetch_all($r_s_iext);
        //----------------------------------------
        // --> SUGEST�O SETOR [SINALIZAR AS PARTES BAIXAS DO ????PORTATIL2???? (ALERTA EM ZEBRADO)]
        //----------------------------------------
        //$sql = "SELECT cs.*, tv.*, s.nome_setor FROM cliente_setor cs, ventilacao_artificial tv, setor s WHERE cs.cod_vent_art = tv.cod_vent_art AND cs.cod_setor = s.cod_setor AND (cs.higiene = 'n�o' or cs.higiene = 'nao') AND cs.id_ppra = ".(int)($cod_cgrt);
        $sql = "SELECT cs.dt_ventilacao, tv.nome_vent_art FROM cliente_setor cs, ventilacao_artificial tv WHERE cs.cod_vent_art = tv.cod_vent_art AND cs.cod_setor = s.cod_setor AND cs.id_ppra = ".(int)($cod_cgrt)." AND cs.cod_setor = ".(int)($srec[$x][cod_setor])." AND (cs.higiene = 'nao' OR cs.higiene = 0) ";
        $r_s_sarp = pg_query($sql);
        $sugestao_setor_sarp = pg_fetch_all($r_s_sarp);
        //----------------------------------------
        // --> SUGEST�O SETOR [HIGI. CASA DE MAQUINAS (PRIMARIA)]
        //----------------------------------------
        //$sql = "SELECT cs.*, t.* FROM cliente_setor cs, ventilacao_artificial t WHERE cs.cod_vent_art = t.cod_vent_art AND (t.cod_vent_art = 5 OR t.cod_vent_art = 6) AND cs.cod_setor = ".(int)($srec[$x][cod_setor])." AND cs.id_ppra = ".(int)($cod_cgrt);
        $sql = "SELECT cs.dt_ventilacao FROM cliente_setor cs WHERE (cs.cod_vent_art = 5 OR cs.cod_vent_art = 6) AND cs.cod_setor = ".(int)($srec[$x][cod_setor])." AND cs.id_ppra = ".(int)($cod_cgrt);
        $r_s_hcm1 = pg_query($sql);
        $sugestao_setor_hcm1 = pg_fetch_all($r_s_hcm1);
        //----------------------------------------
        // --> SUGEST�O SETOR [HIGI. DUTO DE DISTIBUI��O DE AR (SECUNDARIA)]
        //----------------------------------------
        //$sql = "SELECT cs.*, t.* FROM cliente_setor cs, ventilacao_artificial t WHERE cs.cod_vent_art = t.cod_vent_art AND t.cod_vent_art = 5 AND cs.cod_setor = ".(int)($srec[$x][cod_setor])." AND cs.id_ppra = ".(int)($cod_cgrt);
        $sql = "SELECT cs.dt_ventilacao FROM cliente_setor cs WHERE cs.cod_vent_art = 5 AND cs.cod_setor = ".(int)($srec[$x][cod_setor])." AND cs.id_ppra = ".(int)($cod_cgrt);
        $r_s_hda2 = pg_query($sql);
        $sugestao_setor_hda2 = pg_fetch_all($r_s_hda2);
        //----------------------------------------
        // --> SUGEST�O SETOR [HIGI. DOS TERMINAIS DE DUTO DE VENTILA��O (TERCIARIA)]
        //----------------------------------------
        //$sql = "SELECT cs.*, t.* FROM cliente_setor cs, ventilacao_artificial t WHERE cs.cod_vent_art = t.cod_vent_art AND t.cod_vent_art = 5 AND cs.cod_setor = ".(int)($srec[$x][cod_setor])." AND cs.id_ppra = ".(int)($cod_cgrt);
        $sql = "SELECT cs.dt_ventilacao FROM cliente_setor cs WHERE cs.cod_vent_art = 5 AND cs.cod_setor = ".(int)($srec[$x][cod_setor])." AND cs.id_ppra = ".(int)($cod_cgrt);
        $r_s_htv3 = pg_query($sql);
        $sugestao_setor_htv3 = pg_fetch_all($r_s_htv3);
        //----------------------------------------
        // --> SUGEST�O SETOR [HIGI. CASA DE MAQUINAS (PRIMARIA)]
        //----------------------------------------
        //$sql = "SELECT cs.*, t.* FROM cliente_setor cs, ventilacao_artificial t WHERE cs.cod_vent_art = t.cod_vent_art and t.cod_vent_art = 6 AND cs.id_ppra = ".(int)($cod_cgrt);
        //$r_s_hcm = pg_query($sql);
        //$sugestao_setor_prog = pg_fetch_all($r_s_p);
        //----------------------------------------
        // --> SUGEST�O SETOR [SINALIZA��O]
        //----------------------------------------
        //$sql = "SELECT pp.descricao, pp.cod_cliente, pp.cod_setor FROM cliente_setor c, setor s, ppra_placas pp WHERE pp.cod_cliente = c.cod_cliente  AND c.cod_setor = pp.cod_setor AND s.cod_setor = pp.cod_setor AND pp.cod_setor = ".(int)($srec[$x][cod_setor])." AND pp.id_ppra = c.id_ppra AND c.id_ppra = ".(int)($cod_cgrt);
        $sql = "SELECT pp.descricao, pp.cod_cliente, pp.cod_setor FROM cliente_setor c, ppra_placas pp WHERE pp.cod_cliente = c.cod_cliente  AND c.cod_setor = pp.cod_setor AND pp.cod_setor = ".(int)($srec[$x][cod_setor])." AND pp.id_ppra = c.id_ppra AND c.id_ppra = ".(int)($cod_cgrt);
        $r_s_sin = pg_query($sql);
        $sugestao_setor_sin = pg_fetch_all($r_s_sin);

    	$code .= "<BR><p><BR>";
        $code .= "<div class='dez'><b>QUADRO DE PLANEJAMENTO E A��ES PARA A EXECU��O DAS PEND�NCIAS LEVANTADAS</b></div>";
        $code .= "<BR>";
        $code .= "<table border=1 width=100% cellspacig=0 cellpadding=0>";
        $code .= "<tr>";
        $code .= "<td class='bgtitle' align=center width=730 colspan=2><b>{$srec[$x][nome_setor]}</b></td>";
        $code .= "</tr>";
        $code .= "<tr>";
        $code .= "<td class='bgtitle' align=center width=365><b>Quadro de Planejamento e A��es</b></td>";
        $code .= "<td class='bgtitle' align=center width=365><b>Metas e Prioridades Ano ".(int)($info[ano])." � ".((int)($info[ano])+1)."</b></td>";
        $code .= "</tr>";
        $code .= "<tr>";
        $code .= "<td align=center width=365><b>Descri��o das Necessidades</b></td>";
        $code .= "<td align=center width=365>";
            $mesref = date("n", strtotime($info[data_criacao]));
            $code .= "<table border=0 width=365 cellspacig=0 cellpadding=0>";
            $code .= "<tr>";
            for($i=1;$i<=12;$i++){
   	            $code .= "<td width=30 align=center class='dez'><b>{$smes[$mesref]}</b></td>";
				$mesref++;
				if($mesref >= 13) $mesref = 1;
		    }
            $code .= "</tr>";
            $code .= "</table>";
        $code .="</td>";
        $code .= "</tr>";
        
        //EPI
        for($y=0;$y<pg_num_rows($r_s_e);$y++){
            $code .= "<tr>";
            $code .= "<td class='dez' align=left width=365>{$sugestao_setor_epi[$y][descricao]}</td>";
            $code .= "<td class='dez' align=center width=365>";
                $data_sugestao = date("n", strtotime($sugestao_setor_epi[$y][data]));
                $mesref = date("n", strtotime($info[data_criacao]));
                $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
                $code .= "<tr>";
                for($i=1;$i<=12;$i++){
                    if($mesref == $data_sugestao)
                       $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
                    else
                       $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
                    $mesref++;
                    if($mesref >= 13) $mesref=1;
                }
                $code .= "</tr>";
                $code .= "</table>";
            $code .= "</td>";
            $code .= "</tr>";
        }
        
        //CURSO
        for($y=0;$y<pg_num_rows($r_s_c);$y++){
            $code .= "<tr>";
            $code .= "<td class='dez' align=left width=365>{$sugestao_setor_curso[$y][descricao]}</td>";
            $code .= "<td class='dez' align=center width=365>";
                $data_sugestao = date("n", strtotime($sugestao_setor_curso[$y][data]));
                $mesref = date("n", strtotime($info[data_criacao]));
                $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
                $code .= "<tr>";
                for($i=1;$i<=12;$i++){
                    if($mesref == $data_sugestao)
                       $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
                    else
                       $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
                    $mesref++;
                    if($mesref >= 13) $mesref=1;
                }
                $code .= "</tr>";
                $code .= "</table>";
            $code .= "</td>";
            $code .= "</tr>";
        }
		
		//AMBIENTAL
        for($y=0;$y<pg_num_rows($r_s_a);$y++){
            $code .= "<tr>";
            $code .= "<td class='dez' align=left width=365>{$sugestao_setor_ambiental[$y][descricao]}</td>";
            $code .= "<td class='dez' align=center width=365>";
                $data_sugestao = date("n", strtotime($sugestao_setor_ambiental[$y][data]));
                $mesref = date("n", strtotime($info[data_criacao]));
                $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
                $code .= "<tr>";
                for($i=1;$i<=12;$i++){
                    if($mesref == $data_sugestao)
                       $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
                    else
                       $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
                    $mesref++;
                    if($mesref >= 13) $mesref=1;
                }
                $code .= "</tr>";
                $code .= "</table>";
            $code .= "</td>";
            $code .= "</tr>";
        }
        
        //PROGRAMAS
        for($y=0;$y<pg_num_rows($r_s_p);$y++){
            $code .= "<tr>";
            $code .= "<td class='dez' align=left width=365>{$sugestao_setor_prog[$y][descricao]}</td>";
            $code .= "<td class='dez' align=center width=365>";
                $data_sugestao = date("n", strtotime($sugestao_setor_prog[$y][data]));
                $mesref = date("n", strtotime($info[data_criacao]));
                $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
                $code .= "<tr>";
                for($i=1;$i<=12;$i++){
                    if($mesref == $data_sugestao)
                       $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
                    else
                       $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
                    $mesref++;
                    if($mesref >= 13) $mesref=1;
                }
                $code .= "</tr>";
                $code .= "</table>";
            $code .= "</td>";
            $code .= "</tr>";
        }
        
        //PARA-RAIOS
        for($y=0;$y<pg_num_rows($r_s_praio);$y++){
            $code .= "<tr>";
            $code .= "<td class='dez' align=left width=365>Manuten��o no Para Raio tipo {$sugestao_setor_praio[$y][tipo_para_raio]}</td>";
            $code .= "<td class='dez' align=center width=365>";
                $data_sugestao = date("n", strtotime($sugestao_setor_praio[$y][data_criacao]));
                $mesref = date("n", strtotime($info[data_criacao]));
                $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
                $code .= "<tr>";
                for($i=1;$i<=12;$i++){
                    if($mesref == $data_sugestao)
                       $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
                    else
                       $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
                    $mesref++;
                    if($mesref >= 13) $mesref=1;
                }
                $code .= "</tr>";
                $code .= "</table>";
            $code .= "</td>";
            $code .= "</tr>";
        }
        
        //EPC
        for($y=0;$y<pg_num_rows($r_s_epc);$y++){
            if(!empty($sugestao_setor_epc[$y][epc_sugerido])){
                $code .= "<tr>";
                $code .= "<td class='dez' align=left width=365>{$sugestao_setor_epc[$y][epc_sugerido]}</td>";
                $code .= "<td class='dez' align=center width=365>";
                    $data_sugestao = date("n", strtotime($sugestao_setor_epc[$y][data_criacao]));
                    $mesref = date("n", strtotime($info[data_criacao]));
                    $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
                    $code .= "<tr>";
                    for($i=1;$i<=12;$i++){
                        if($mesref == $data_sugestao)
                           $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
                        else
                           $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
                        $mesref++;
                        if($mesref >= 13) $mesref=1;
                    }
                    $code .= "</tr>";
                    $code .= "</table>";
                $code .= "</td>";
                $code .= "</tr>";
            }
        }
        
        //VISTORIA DE HIDRANTE
        for($y=0;$y<pg_num_rows($r_s_hid);$y++){
            $code .= "<tr>";
            $code .= "<td class='dez' align=left width=365>{$sugestao_setor_hid[$y][tipo_hidrante]}</td>";
            $code .= "<td class='dez' align=center width=365>";
                if(empty($sugestao_setor_hid[$y][vistoria])){
                    $d = explode("/", date("d/m/Y", $info[data_criacao]));
                    $sugestao_setor_hid[$y][vistoria] = date("Y-m-d", mktime(0,0,0,$d[1]+2,$d[0],$d[2]));
                }
                $data_sugestao = date("n", strtotime($sugestao_setor_hid[$y][vistoria]));
                $mesref = date("n", strtotime($info[data_criacao]));
                $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
                $code .= "<tr>";
                
                for($i=1;$i<=12;$i++){
                    if($mesref == $data_sugestao)
                       $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
                    else
                       $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
                    $mesref++;
                    if($mesref >= 13) $mesref=1;
                }
                $code .= "</tr>";
                $code .= "</table>";
            $code .= "</td>";
            $code .= "</tr>";
        }
        
        //VENT PORTATIL
        for($y=0;$y<pg_num_rows($r_s_vart);$y++){
            $code .= "<tr>";
            $code .= "<td class='dez' align=left width=365>Fazer a higieniza��o do {$sugestao_setor_vart[$y][nome_vent_art]} e fixar o cart�o de controle</td>";
            $code .= "<td class='dez' align=center width=365>";
                $data_sugestao = date("n", strtotime($sugestao_setor_vart[$y][dt_ventilacao]));
                $mesref = date("n", strtotime($info[data_criacao]));
                $mdates = array();
                $mdates[0] = $data_sugestao;
                
                $mdates[1] = $mdates[0];
                for($t=0;$t<3;$t++){
                    $mdates[1]++;
                    if($mdates[1] > 12)
                        $mdates[1] = 1;
                }
                    
                $mdates[2] = $mdates[1];
                for($t=0;$t<3;$t++){
                    $mdates[2]++;
                    if($mdates[2] > 12)
                        $mdates[2] = 1;
                }
                    
                $mdates[3] = $mdates[2];
                for($t=0;$t<3;$t++){
                    $mdates[3]++;
                    if($mdates[3] > 12)
                        $mdates[3] = 1;
                }
                
                $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
                $code .= "<tr>";
                for($i=1;$i<=12;$i++){
                    if(in_array($mesref, $mdates))
                       $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
                    else
                       $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
                    $mesref++;
                    if($mesref >= 13) $mesref=1;
                }
                $code .= "</tr>";
                $code .= "</table>";
            $code .= "</td>";
            $code .= "</tr>";
        }
        
        
        //VENT LIMPEZA MECANICA
        for($y=0;$y<pg_num_rows($r_s_vent);$y++){
            $code .= "<tr>";
            $code .= "<td class='dez' align=left width=365>Fazer limpeza mec�nica e fixar cart�o de higieniza��o no {$sugestao_setor_vent[$y][nome_vent_art]}</td>";
            $code .= "<td class='dez' align=center width=365>";
                $data_sugestao = date("n", strtotime($sugestao_setor_vent[$y][data_criacao]));
                $mesref = date("n", strtotime($info[data_criacao]));
                $mdates = array();
                $mdates[0] = $data_sugestao;

                $mdates[1] = $mdates[0];
                for($t=0;$t<3;$t++){
                    $mdates[1]++;
                    if($mdates[1] > 12)
                        $mdates[1] = 1;
                }

                $mdates[2] = $mdates[1];
                for($t=0;$t<3;$t++){
                    $mdates[2]++;
                    if($mdates[2] > 12)
                        $mdates[2] = 1;
                }

                $mdates[3] = $mdates[2];
                for($t=0;$t<3;$t++){
                    $mdates[3]++;
                    if($mdates[3] > 12)
                        $mdates[3] = 1;
                }

                $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
                $code .= "<tr>";
                for($i=1;$i<=12;$i++){
                    if(in_array($mesref, $mdates))
                       $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
                    else
                       $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
                    $mesref++;
                    if($mesref >= 13) $mesref=1;
                }
                $code .= "</tr>";
                $code .= "</table>";
            $code .= "</td>";
            $code .= "</tr>";
        }
        
        
        //HIGNIFUGA��O NO CARPETE
        for($y=0;$y<pg_num_rows($r_s_carpete);$y++){
            $code .= "<tr>";
            $code .= "<td class='dez' align=left width=365>Aplicar hignifuga��o nos {$sugestao_setor_carpete[$y][nome_piso]}s</td>";
            $code .= "<td class='dez' align=center width=365>";
                $data_sugestao = date("n", strtotime($sugestao_setor_carpete[$y][data_criacao]));
                $mesref = date("n", strtotime($info[data_criacao]));
                $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
                $code .= "<tr>";
                for($i=1;$i<=12;$i++){
                    if($mesref == $data_sugestao)
                       $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
                    else
                       $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
                    $mesref++;
                    if($mesref >= 13) $mesref=1;
                }
                $code .= "</tr>";
                $code .= "</table>";
            $code .= "</td>";
            $code .= "</tr>";
        }
        
        //INSTALA��O DE EXTINTOR
        for($y=0;$y<pg_num_rows($r_s_iext);$y++){
            $code .= "<tr>";
            $code .= "<td class='dez' align=left width=365>Instalar {$sugestao_setor_iext[$y][tipo_extintor]}</td>";
            $code .= "<td class='dez' align=center width=365>";
                $data_sugestao = date("n", strtotime($sugestao_setor_iext[$y][data_criacao]));
                $mesref = date("n", strtotime($info[data_criacao]));
                $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
                $code .= "<tr>";
                for($i=1;$i<=12;$i++){
                    if($mesref == $data_sugestao)
                       $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
                    else
                       $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
                    $mesref++;
                    if($mesref >= 13) $mesref=1;
                }
                $code .= "</tr>";
                $code .= "</table>";
            $code .= "</td>";
            $code .= "</tr>";
        }
        
        //SIN AR PORTATIL
        for($y=0;$y<pg_num_rows($r_s_sarp);$y++){
            $code .= "<tr>";
            $code .= "<td class='dez' align=left width=365>Sinalizar as partes baixas do  {$sugestao_setor_sarp[$y][nome_vent_art]} (Zebrado em alerta)</td>";
            $code .= "<td class='dez' align=center width=365>";
                $data_sugestao = date("n", strtotime($sugestao_setor_sarp[$y][dt_ventilacao]));
                $mesref = date("n", strtotime($info[data_criacao]));
                $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
                $code .= "<tr>";
                for($i=1;$i<=12;$i++){
                    if($mesref == $data_sugestao)
                       $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
                    else
                       $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
                    $mesref++;
                    if($mesref >= 13) $mesref=1;
                }
                $code .= "</tr>";
                $code .= "</table>";
            $code .= "</td>";
            $code .= "</tr>";
        }
        
        //HIG. CASA DE MAQUINA (PRIMARIA)
        for($y=0;$y<pg_num_rows($r_s_hcm1);$y++){
            $code .= "<tr>";
            $code .= "<td class='dez' align=left width=365>Fazer higieniza��o da casa de m�quina (Prim�ria)</td>";
            $code .= "<td class='dez' align=center width=365>";
                $data_sugestao = date("n", strtotime($sugestao_setor_hcm1[$y][dt_ventilacao]));
                $mesref = date("n", strtotime($info[data_criacao]));
                $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
                $code .= "<tr>";
                for($i=1;$i<=12;$i++){
                    if($mesref == $data_sugestao)
                       $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
                    else
                       $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
                    $mesref++;
                    if($mesref >= 13) $mesref=1;
                }
                $code .= "</tr>";
                $code .= "</table>";
            $code .= "</td>";
            $code .= "</tr>";
        }
        
        //HIG. MECANICA DUTO DISTIBUICAO DE AR (SECUNDARIA)
        for($y=0;$y<pg_num_rows($r_s_hda2);$y++){
            $code .= "<tr>";
            $code .= "<td class='dez' align=left width=365>Fazer higieniza��o mec�nica do duto de distribui��o de ar (Secund�ria)</td>";
            $code .= "<td class='dez' align=center width=365>";
                $data_sugestao = date("n", strtotime($sugestao_setor_hda2[$y][dt_ventilacao]));
                $mesref = date("n", strtotime($info[data_criacao]));
                $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
                $code .= "<tr>";
                for($i=1;$i<=12;$i++){
                    if($mesref == $data_sugestao)
                       $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
                    else
                       $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
                    $mesref++;
                    if($mesref >= 13) $mesref=1;
                }
                $code .= "</tr>";
                $code .= "</table>";
            $code .= "</td>";
            $code .= "</tr>";
        }
        
        //VENT LIMPEZA MECANICA
        for($y=0;$y<pg_num_rows($r_s_htv3);$y++){
            $code .= "<tr>";
            $code .= "<td class='dez' align=left width=365>Fazer higieniza��o dos terminais de duto de ventila��o (Terce�ria)</td>";
            $code .= "<td class='dez' align=center width=365>";
                $data_sugestao = date("n", strtotime($sugestao_setor_htv3[$y][dt_ventilacao]));
                $mesref = date("n", strtotime($info[data_criacao]));
                $mdates = array();
                $mdates[0] = $data_sugestao;

                $mdates[1] = $mdates[0];
                for($t=0;$t<3;$t++){
                    $mdates[1]++;
                    if($mdates[1] > 12)
                        $mdates[1] = 1;
                }

                $mdates[2] = $mdates[1];
                for($t=0;$t<3;$t++){
                    $mdates[2]++;
                    if($mdates[2] > 12)
                        $mdates[2] = 1;
                }

                $mdates[3] = $mdates[2];
                for($t=0;$t<3;$t++){
                    $mdates[3]++;
                    if($mdates[3] > 12)
                        $mdates[3] = 1;
                }

                $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
                $code .= "<tr>";
                for($i=1;$i<=12;$i++){
                    if(in_array($mesref, $mdates))
                       $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
                    else
                       $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
                    $mesref++;
                    if($mesref >= 13) $mesref=1;
                }
                $code .= "</tr>";
                $code .= "</table>";
            $code .= "</td>";
            $code .= "</tr>";
        }
        
        //SINALIZA��O
        for($y=0;$y<pg_num_rows($r_s_sin);$y++){
            $code .= "<tr>";
            $code .= "<td class='dez' align=left width=365>{$sugestao_setor_sin[$y][descricao]}</td>";
            $code .= "<td class='dez' align=center width=365>";
                $data_sugestao = date("n", strtotime($sugestao_setor_sin[$y][data_criacao]));
                $mesref = date("n", strtotime($info[data_criacao]));
                $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
                $code .= "<tr>";
                for($i=1;$i<=12;$i++){
                    if($mesref == $data_sugestao)
                       $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
                    else
                       $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
                    $mesref++;
                    if($mesref >= 13) $mesref=1;
                }
                $code .= "</tr>";
                $code .= "</table>";
            $code .= "</td>";
            $code .= "</tr>";
        }
        
        
        $code .= "</table>";
        
        $code .= "<div class='pagebreak'></div>";
    }
/****************************************************************************************************************/
// -> PAGE [11] - Quinta fase - CRONOGRAMA E PLANO DE A��O DO CURSO DA EMPRESA BASE/ANO
/****************************************************************************************************************/
$spx = "SELECT s.*, p.desc_resumida_prod FROM sugestao s, produto p 
		WHERE s.id_ppra = {$cod_cgrt} and s.plano_acao = 1 and s.tipo_med_prev = 2 and s.cod_produto = p.cod_prod";
$lpx = pg_query($connect, $spx);
$px = pg_fetch_array($lpx);
if($px[plano_acao] == 1){
    $code .= "<BR><p><BR>";
    $code .= "<div class='mediumTitle'><b>CRONOGRAMA E PLANO DE A��O DO CURSO BASE/ANO ".$info[ano]."</b></div>";
    $code .= "<BR>";
    $code .= "<p align='justify'>";
    $code .= "<b>Empresa:</b> ".$info[razao_social];
    $code .= "<BR>";
    $code .= "";

    $code .= "<table border=1 width=100% cellspacig=0 cellpadding=0>";
    $code .= "<tr>";
    $code .= "<td class='bgtitle' align=center width=365><b>Quadro de Planejamento e A��es</b></td>";
    $code .= "<td class='bgtitle' align=center width=365><b>Metas e Prioridades Ano ".(int)($info[ano])." � ".((int)($info[ano])+1)."</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=center width=365><b>Descri��o das Necessidades</b></td>";
    $code .= "<td align=center width=365>";
        $mesref = date("n", strtotime($info[data_criacao]));
        $code .= "<table border=0 width=365 cellspacig=0 cellpadding=0>";
        $code .= "<tr>";
        for($i=1;$i<=12;$i++){
   	            $code .= "<td width=30 align=center class='dez'><b>{$smes[$mesref]}</b></td>";
				$mesref++;
				if($mesref >= 13) $mesref = 1;
		    }
        $code .= "</tr>";
        $code .= "</table>";
    $code .="</td>";
    $code .= "</tr>";
	
	//Descri��o do Cursos
	$puls = "SELECT s.*, p.desc_resumida_prod FROM sugestao s, produto p 
			WHERE s.id_ppra = {$cod_cgrt} and s.plano_acao = 1 and s.tipo_med_prev = 2 and s.cod_produto = p.cod_prod";
	$xos = pg_query($connect, $puls);
	$sux = pg_fetch_all($xos);
	for($y=0;$y<pg_num_rows($xos);$y++){
		$code .= "<tr>";
		$code .= "<td class='dez' align=left width=365>{$sux[$y][desc_resumida_prod]}</td>";
		$code .= "<td class='dez' align=center width=365>";
			$data_sugestao = date("n", strtotime($px[$y][data]));
			$mesref = date("n", strtotime($info[data_criacao]));
			$code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
			$code .= "<tr>";
			for($i=1;$i<=12;$i++){
				if($mesref == $data_sugestao)
				   $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
				else
				   $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
				$mesref++;
				if($mesref >= 13) $mesref=1;
			}
			$code .= "</tr>";
			$code .= "</table>";
		$code .= "</td>";
		$code .= "</tr>";
	}
    $code .= "</table>";
    
    $code .= "<div class='pagebreak'></div>";
}
/****************************************************************************************************************/
// -> PAGE [11] - Quinta fase - CRONOGRAMA E PLANO DE A��O DO DOCUMENTO BASE/ANO
/****************************************************************************************************************/
    $code .= "<BR><p><BR>";
    $code .= "<div class='mediumTitle'><b>CRONOGRAMA E PLANO DE A��O DO DOCUMENTO BASE/ANO ".$info[ano]."</b></div>";
    $code .= "<BR>";
    $code .= "<p align='justify'>";
    $code .= "<b>Empresa:</b> ".$info[razao_social];
    $code .= "<BR>";
    $code .= "";

    $code .= "<table border=1 width=100% cellspacig=0 cellpadding=0>";
    $code .= "<tr>";
    $code .= "<td class='bgtitle' align=center width=365><b>Quadro de Planejamento e A��es</b></td>";
    $code .= "<td class='bgtitle' align=center width=365><b>Metas e Prioridades Ano ".(int)($info[ano])." � ".((int)($info[ano])+1)."</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=center width=365><b>Descri��o das Necessidades</b></td>";
    $code .= "<td align=center width=365>";
        $mesref = date("n", strtotime($info[data_criacao]));
        $code .= "<table border=0 width=365 cellspacig=0 cellpadding=0>";
        $code .= "<tr>";
        for($i=1;$i<=12;$i++){
   	            $code .= "<td width=30 align=center class='dez'><b>{$smes[$mesref]}</b></td>";
				$mesref++;
				if($mesref >= 13) $mesref = 1;
		    }
        $code .= "</tr>";
        $code .= "</table>";
    $code .="</td>";
    $code .= "</tr>";

    //Inspe��o tecnica preliminar
    $code .= "<tr>";
    $code .= "<td class='dez' align=left width=365>Inspe��o tecnica preliminar</td>";
    $code .= "<td class='dez' align=center width=365>";
        $data_sugestao = date("n", strtotime($info[data_criacao]));
        $mesref = date("n", strtotime($info[data_criacao]));
        $mdates = array();
        $mdates[0] = $data_sugestao;
        $mdates[1] = $mdates[0];
        for($t=0;$t<4;$t++){
            $mdates[1]++;
            if($mdates[1] > 12)
                $mdates[1] = 1;
        }

        $mdates[2] = $mdates[1];
        for($t=0;$t<4;$t++){
            $mdates[2]++;
            if($mdates[2] > 12)
                $mdates[2] = 1;
        }

        $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
        $code .= "<tr>";
        for($i=1;$i<=12;$i++){
            if(in_array($mesref, $mdates))
               $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
            else
               $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
            $mesref++;
            if($mesref >= 13) $mesref=1;
        }
        $code .= "</tr>";
        $code .= "</table>";
    $code .= "</td>";
    $code .= "</tr>";


    //Elabora��o do programa
    $code .= "<tr>";
    $code .= "<td class='dez' align=left width=365>Elabora��o do programa</td>";
    $code .= "<td class='dez' align=center width=365>";
        $data_sugestao = date("n", strtotime($info[data_criacao]));
        $mesref = date("n", strtotime($info[data_criacao]));
        $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
        $code .= "<tr>";
        for($i=1;$i<=12;$i++){
            if($mesref == $data_sugestao)
               $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
            else
               $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
            $mesref++;
            if($mesref >= 13) $mesref=1;
        }
        $code .= "</tr>";
        $code .= "</table>";
    $code .= "</td>";
    $code .= "</tr>";
    
    
    //Inspe��o dos postos de trabalho
    $code .= "<tr>";
    $code .= "<td class='dez' align=left width=365>Inspe��o dos postos de trabalho</td>";
    $code .= "<td class='dez' align=center width=365>";
        $data_sugestao = date("n", strtotime($info[data_criacao]));
        $mesref = date("n", strtotime($info[data_criacao]));
        $mdates = array();
        $mdates[0] = $data_sugestao;
        $mdates[1] = $mdates[0];
        for($t=0;$t<4;$t++){
            $mdates[1]++;
            if($mdates[1] > 12)
                $mdates[1] = 1;
        }

        $mdates[2] = $mdates[1];
        for($t=0;$t<4;$t++){
            $mdates[2]++;
            if($mdates[2] > 12)
                $mdates[2] = 1;
        }

        $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
        $code .= "<tr>";
        for($i=1;$i<=12;$i++){
            if(in_array($mesref, $mdates))
               $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
            else
               $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
            $mesref++;
            if($mesref >= 13) $mesref=1;
        }
        $code .= "</tr>";
        $code .= "</table>";
    $code .= "</td>";
    $code .= "</tr>";
    
    
    //Avalia��o do programa
    $code .= "<tr>";
    $code .= "<td class='dez' align=left width=365>Avalia��o do programa</td>";
    $code .= "<td class='dez' align=center width=365>";
        $data_sugestao = date("n", strtotime($info[data_criacao]));
        $mesref = date("n", strtotime($info[data_criacao]));
        $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
        $code .= "<tr>";
        for($i=1;$i<=12;$i++){
            if($mesref == $data_sugestao)
               $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
            else
               $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
            $mesref++;
            if($mesref >= 13) $mesref=1;
        }
        $code .= "</tr>";
        $code .= "</table>";
    $code .= "</td>";
    $code .= "</tr>";
    
    
    //Inspe��o quanto a higiene da �gua
    $code .= "<tr>";
    $code .= "<td class='dez' align=left width=365>Inspe��o quanto a higiene da �gua</td>";
    $code .= "<td class='dez' align=center width=365>";
        $data_sugestao = date("n", strtotime($info[data_criacao]));
        $mesref = date("n", strtotime($info[data_criacao]));
        $mdates = array();
        $mdates[0] = $data_sugestao;
        $mdates[1] = $mdates[0];
        for($t=0;$t<6;$t++){
            $mdates[1]++;
            if($mdates[1] > 12)
                $mdates[1] = 1;
        }
        $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
        $code .= "<tr>";
        for($i=1;$i<=12;$i++){
            if(in_array($mesref, $mdates))
               $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
            else
               $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
            $mesref++;
            if($mesref >= 13) $mesref=1;
        }
        $code .= "</tr>";
        $code .= "</table>";
    $code .= "</td>";
    $code .= "</tr>";
    
    //Qualifica��o do agente
    $code .= "<tr>";
    $code .= "<td class='dez' align=left width=365>Qualifica��o do agente</td>";
    $code .= "<td class='dez' align=center width=365>";
        $data_sugestao = date("n", strtotime($info[data_criacao]));
        $mesref = date("n", strtotime($info[data_criacao]));
        $mdates = array();
        $mdates[0] = $data_sugestao;
        for($t=0;$t<7;$t++){
            $mdates[0]++;
            if($mdates[0] > 12)
                $mdates[0] = 1;
        }
        $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
        $code .= "<tr>";
        for($i=1;$i<=12;$i++){
            if(in_array($mesref, $mdates))
               $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
            else
               $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
            $mesref++;
            if($mesref >= 13) $mesref=1;
        }
        $code .= "</tr>";
        $code .= "</table>";
    $code .= "</td>";
    $code .= "</tr>";
    
    //Insp. dos equip. contra inc�ndio
    $code .= "<tr>";
    $code .= "<td class='dez' align=left width=365>Insp. dos equip. contra inc�ndio</td>";
    $code .= "<td class='dez' align=center width=365>";
        $data_sugestao = date("n", strtotime($info[data_criacao]));
        $mesref = date("n", strtotime($info[data_criacao]));
        $mdates = array();
        $mdates[0] = $data_sugestao;
        $mdates[1] = $mdates[0];
        for($t=0;$t<4;$t++){
            $mdates[1]++;
            if($mdates[1] > 12)
                $mdates[1] = 1;
        }

        $mdates[2] = $mdates[1];
        for($t=0;$t<4;$t++){
            $mdates[2]++;
            if($mdates[2] > 12)
                $mdates[2] = 1;
        }
        $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
        $code .= "<tr>";
        for($i=1;$i<=12;$i++){
            if(in_array($mesref, $mdates))
               $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
            else
               $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
            $mesref++;
            if($mesref >= 13) $mesref=1;
        }
        $code .= "</tr>";
        $code .= "</table>";
    $code .= "</td>";
    $code .= "</tr>";
    
    //Qualifica��o do agente
    $code .= "<tr>";
    $code .= "<td class='dez' align=left width=365>Implanta��o das recomenda��es</td>";
    $code .= "<td class='dez' align=center width=365>";
        $data_sugestao = date("n", strtotime($info[data_criacao]));
        $mesref = date("n", strtotime($info[data_criacao]));
        $mdates = array();
        $mdates[0] = $data_sugestao;
        for($t=0;$t<4;$t++){
            $mdates[0]++;
            if($mdates[0] > 12)
                $mdates[0] = 1;
        }
        $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
        $code .= "<tr>";
        for($i=1;$i<=12;$i++){
            if(in_array($mesref, $mdates))
               $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
            else
               $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
            $mesref++;
            if($mesref >= 13) $mesref=1;
        }
        $code .= "</tr>";
        $code .= "</table>";
    $code .= "</td>";
    $code .= "</tr>";
    
    
    //Renova��o do programa
    $code .= "<tr>";
    $code .= "<td class='dez' align=left width=365>Renova��o do programa</td>";
    $code .= "<td class='dez' align=center width=365>";
        $data_sugestao = date("n", strtotime($info[data_criacao]));
        $mesref = date("n", strtotime($info[data_criacao]));
        $mdates = array();
        $mdates[0] = $data_sugestao;
        for($t=0;$t<11;$t++){
            $mdates[0]++;
            if($mdates[0] > 12)
                $mdates[0] = 1;
        }
        $code .= "<table border=1 width=365 cellspacig=0 cellpadding=0>";
        $code .= "<tr>";
        for($i=1;$i<=12;$i++){
            if(in_array($mesref, $mdates))
               $code .= "<td width=30 align=center class='dez' bgcolor='#000000'><b>X</b></td>";
            else
               $code .= "<td width=30 align=center class='dez'>&nbsp;</td>";
            $mesref++;
            if($mesref >= 13) $mesref=1;
        }
        $code .= "</tr>";
        $code .= "</table>";
    $code .= "</td>";
    $code .= "</tr>";


    $code .= "</table>";
    
    $code .= "<div class='pagebreak'></div>";
    
/****************************************************************************************************************/
// -> PAGE [12] - Sexta fase - Anexos
/****************************************************************************************************************/
    $code .= "<BR><p><BR>";
    $code .= "<BR><p><BR>";
    $code .= "<center><div class='bigTitle'><b>5� FASE<BR><BR>A<BR>N<BR>E<BR>X<BR>O<BR>S<BR></b></div></center>";

    $code .= "<div class='pagebreak'></div>";
	
    $code .= "<BR><p><BR>";
    $code .= "<div class='mediumTitle'><b>MODELO DE FICHA DE INSPE��O DE EXTINTOR</b></div>";
    $code .= "<BR>";
    $code .= "<p align='justify'>";
    
    $code .= "<table border=1 width=100% cellspacig=0 cellpadding=0>";
    $code .= "<tr>";
    $code .= "<td align=left width=243>Marca:</td>";
    $code .= "<td align=left width=243>Tipo:</td>";
    $code .= "<td align=left width=243>Extintor N�:</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=243>Ativo Fixo:</td>";
    $code .= "<td align=left width=243>Local:</td>";
    $code .= "<td align=left width=243>ABNT N�:</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=center width=486 colspan=2>";
        $code .= "<table width=486 border=1 cellspacing=0 cellpadding=0>";
        $code .= "<tr>";
        $code .= "<td align=center>Data</td>";
        $code .= "<td align=center>Recebido</td>";
        $code .= "<td align=center>Inspecionado</td>";
        $code .= "<td align=center>Reparado</td>";
        $code .= "<td align=center>Instru��o</td>";
        $code .= "<td align=center>Inc�ndio</td>";
        $code .= "</tr>";
        $code .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
        $code .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
        $code .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
        $code .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
        $code .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
        $code .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
        $code .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
        $code .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
        $code .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
        $code .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
        $code .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
        $code .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
        $code .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
        $code .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
        $code .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
        $code .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
        $code .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
        $code .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
        $code .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
        $code .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
        $code .= "</table>";
    $code .= "</td>";
    $code .= "<td align=left width=243>1. Substitui��o de gatilho<BR><BR>2. Substitui��o de difusor<BR><BR>3. Mangote<BR><BR>4. V�lvula de seguran�a<BR><BR>5. V�lvula completa<BR><BR>6. V�lvula cilindro adicional<BR><BR>7. Pintura<BR><BR>8. Man�metro<BR><BR>9. Teste hidrost�tico<BR><BR>10. Recarregado<BR><BR>11. Usado em inc�ndio<BR><BR>12. Usado em instru��o<BR><BR>13. Diversos</td>";
    $code .= "</tr>";
    $code .= "</table>";

    $code .= "<div class='pagebreak'></div>";
	
    $code .= "<BR><p><BR>";
    $code .= "<div class='mediumTitle'><b>ANEXO 3 - FICHA DE RECEBIMENTO DE MATERIAL</b></div>";
    $code .= "<table border=0 width=100% cellspacig=0 cellpadding=0>";
    $code .= "<tr>";
    $code .= "<td align=left width=364 colspan=2 class='dez'>Raz�o Social:</td>";
    $code .= "<td align=left width=364 colspan=2 class='dez'>Nome do Colaborador:</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=547 colspan=3 class='dez'>Endere�o:</td>";
    $code .= "<td align=left width=182 class='dez'>Bairro:</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=182 class='dez'>CTPS:</td>";
    $code .= "<td align=left width=182 class='dez'>S�rie:</td>";
    $code .= "<td align=left width=182 class='dez'>Fun��o:</td>";
    $code .= "<td align=left width=182 class='dez'>REG N�:</td>";
    $code .= "</tr>";
    $code .= "</table>";
    
    $code .= "<table border=1 width=730 cellspacig=0 cellpadding=0>";
    $code .= "<tr>";
    $code .= "<td align=center width=54 class='dez'><b>QTD</b></td>";
    $code .= "<td align=center width=294 class='dez'><b>Acess�rio</b></td>";
    $code .= "<td align=center width=104 class='dez'><b>Vida �til</b></td>";
    $code .= "<td align=center width=74 class='dez'><b>Dt. Rec.</b></td>";
    $code .= "<td align=center width=74 class='dez'><b>Fabricado</b></td>";
    $code .= "<td align=center width=54 class='dez'><b>N� C.A.</b></td>";
    $code .= "<td align=center width=74 class='dez'><b>C�d. Rec.</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54 class='dez'>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Abafador auricular tipo concha</td>";
    $code .= "<td align=left width=104 class='dez'>2 anos</td>";
    $code .= "<td align=left width=74 class='dez'>&nbsp;</td>";
    $code .= "<td align=left width=74 class='dez'>&nbsp;</td>";
    $code .= "<td align=left width=54 class='dez'>&nbsp;</td>";
    $code .= "<td align=left width=74 class='dez'>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54 class='dez'>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Avental de couro de raspa</td>";
    $code .= "<td align=left width=104 class='dez'>3 anos</td>";
    $code .= "<td align=left width=74 class='dez'>&nbsp;</td>";
    $code .= "<td align=left width=74 class='dez'>&nbsp;</td>";
    $code .= "<td align=left width=54 class='dez'>&nbsp;</td>";
    $code .= "<td align=left width=74 class='dez'>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54 class='dez'>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Avental de PVC</td>";
    $code .= "<td align=left width=104 class='dez'>1 ano</td>";
    $code .= "<td align=left width=74 class='dez'>&nbsp;</td>";
    $code .= "<td align=left width=74 class='dez'>&nbsp;</td>";
    $code .= "<td align=left width=54 class='dez'>&nbsp;</td>";
    $code .= "<td align=left width=74 class='dez'>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54 class='dez'>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Bermuda tipo brim</td>";
    $code .= "<td align=left width=104 class='dez'>1 ano</td>";
    $code .= "<td align=left width=74 class='dez'>&nbsp;</td>";
    $code .= "<td align=left width=74 class='dez'>&nbsp;</td>";
    $code .= "<td align=left width=54 class='dez'>&nbsp;</td>";
    $code .= "<td align=left width=74 class='dez'>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Braseira de couro de raspa</td>";
    $code .= "<td align=left width=104 class='dez'>3 anos</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Bota de seguran�a</td>";
    $code .= "<td align=left width=104 class='dez'>1 ano</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Bota de borracha</td>";
    $code .= "<td align=left width=104 class='dez'>1 ano</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Bota de seguran�a c/ biqueira</td>";
    $code .= "<td align=left width=104 class='dez'>1 ano</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Camisa tipo brim c/ manga</td>";
    $code .= "<td align=left width=104 class='dez'>1 ano</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Camisa tipo brim s/ manga</td>";
    $code .= "<td align=left width=104 class='dez'>1 ano</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Capacete pl�stico PVC c/ acarneira</td>";
    $code .= "<td align=left width=104 class='dez'>3 anos</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Capacete pl�stico PVC s/ acarneira</td>";
    $code .= "<td align=left width=104 class='dez'>3 anos</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Capa de chuva pl�stico transp.</td>";
    $code .= "<td align=left width=104 class='dez'>3 anos</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Camisa tipo polo</td>";
    $code .= "<td align=left width=104 class='dez'>6 meses</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Cal�a tipo brim</td>";
    $code .= "<td align=left width=104 class='dez'>1 ano</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Casaco de brim</td>";
    $code .= "<td align=left width=104 class='dez'>1 ano</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Crach� funcional</td>";
    $code .= "<td align=left width=104 class='dez'>3 anos</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Camisa de malha</td>";
    $code .= "<td align=left width=104 class='dez'>3 anos</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Cinto de seguran�a abdominal</td>";
    $code .= "<td align=left width=104 class='dez'>5 anos</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Cinto de seguran�a paraquedista</td>";
    $code .= "<td align=left width=104 class='dez'>5 anos</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Filtro de m�scara contra g�s</td>";
    $code .= "<td align=left width=104 class='dez'>3 anos</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Guarda p�</td>";
    $code .= "<td align=left width=104 class='dez'>1 ano</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Luva de couro de raspa</td>";
    $code .= "<td align=left width=104 class='dez'>1 ano</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Luva de PVC cano longo</td>";
    $code .= "<td align=left width=104 class='dez'>6 meses</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>Luva de PVC cano curto</td>";
    $code .= "<td align=left width=104 class='dez'>6 meses</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=294 class='dez'>M�scara descart�vel</td>";
    $code .= "<td align=left width=104 class='dez'>1 dia</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "<td align=left width=54>&nbsp;</td>";
    $code .= "<td align=left width=74>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "</table>";
    $code .= "<div class='dez'><b>01- Recebido pela 1� vez / 02� Desgaste Natural / 03� Desgaste Irregular / 04� Perda/Roubo/Extravio.</b></div>";
    
    $code .= "<div class='pagebreak'></div>";
    
    $code .= "<BR><p><BR>";
    $code .= "<div class='mediumTitle'><b>DECLARA��O DE RESPONSABILIDADE</b></div>";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Declaro para os devido fins que, conforme determina a NR-6 da Portaria 3.214/78 do Minist�rio do trabalho, recebi gratuitamente os Equipamentos de Prote��o Individual acima discriminados, em perfeito estado de conserva��o e funcionamento, declaro ainda que, fui treinado quanto ao uso correto dos EPI�s, bem como, quanto aos procedimentos corretos de conserva��o, guarda e higieniza��o, e que recebendo atendimento de avalia��es f�sicas decorrentes dos atestados admissional e peri�dicos, recebi tamb�m orienta��es quanto a necessidade, a forma de utilizar e a guarda dos mesmos pela coordena��o do PCMSO, conforme declara��o anexada a ficha m�dica e ao prontu�rio m�dico.";
    $code .= "<BR><BR>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Eu _____________________________________________________, Portador da CTPS _____________ s�rie __________ comprometo-me a fazer uso dos EPI�s durante a realiza��o das minhas atividades laborativas, submeter-me a treinamento sempre que sugerido por parte da gerencia e a manter os EPI�s sempre em condi��es de higiene ciente de que a falta da mesma poder� acarretar em riscos a minha pr�pria sa�de, e comunicar qualquer dano ao EPI que o torne impr�prio ao uso, solicitando sua substitui��o.";
    $code .= "<BR><BR>";
    $code .= "Assinatura do Funcion�rio: _____________________________________ ";
    
    $code .= "<div class='pagebreak'></div>";
    
    $code .= "<BR><p><BR>";
    $code .= "<div class='mediumTitle'><b>ANEXO 4 � FICHA DE INSPE��O DE ACIDENTE</b></div>";
    $code .= "<BR>";
    $code .= "<table width=730 border=1 cellspacing=0 cellpadding=0>";
    $code .= "<tr>";
    $code .= "<td colspan=3 width=182>Ficha de registro de investiga��o e ou acidente com danos materiais, ou danos ao meio ambiente</td>";
    $code .= "<td width=182>Ficha N�</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=2 width=182>Unidade:</td>";
    $code .= "<td colspan=2 width=182>Classifica��o:</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=2 width=182>Local da ocorr�ncia:</td>";
    $code .= "<td colspan=2 width=182>[&nbsp;&nbsp;&nbsp;] Quase acidente (incidente)</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td width=182>Data:</td>";
    $code .= "<td width=182>Hora:</td>";
    $code .= "<td colspan=2 width=182>[&nbsp;&nbsp;&nbsp;] Acidente com danos</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=2 width=365>&nbsp;</td>";
    $code .= "<td colspan=2 width=365>[&nbsp;&nbsp;&nbsp;] Com danos ao meio ambiente</td>";
    $code .= "</tr>";
    
    $code .= "<tr>";
    $code .= "<td align=center rowspan=6 width=182>Ocorr�ncias<BR><BR>Causas</td>";
    $code .= "<td colspan=3 width=547>Causas da ocorr�ncia:</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=3 width=547>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=3 width=547>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=3 width=547>Testemunhas:</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=3 width=547>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=3 width=547>&nbsp;</td>";
    $code .= "</tr>";
    
    $code .= "<tr>";
    $code .= "<td align=center rowspan=7 width=182>Provid�ncias<BR><BR>a serem<BR><BR>Tomadas</td>";
    $code .= "<td colspan=3 width=547>Cite a(s) provid�ncia(s) que deve(m) ser adotada(s) para evitar repeti��o(�es):</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=3 width=547>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=3 width=547>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=3 width=547>Nome do respons�vel:</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=3 width=547>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=3 width=547>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=3 width=547>Data para solu��o: ___/___/___&nbsp;&nbsp;&nbsp;&nbsp;Provid�ncias atendidas em: ___/___/___</td>";
    $code .= "</tr>";
    
    $code .= "<tr>";
    $code .= "<td align=center rowspan=8 width=182>Danos<BR><BR>Preju�zos</td>";
    $code .= "<td colspan=3 width=547>Informe o valor aproximado dos danos (consulte a chefia de manuten��o, produ��o, etc):</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=2 width=365>Interrup��o da produ��o</td>";
    $code .= "<td width=182>R$ </td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=2 width=365>Equipamento ou ferramentas danificadas</td>";
    $code .= "<td width=182>R$ </td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=2 width=365>Quebra de produtos</td>";
    $code .= "<td width=182>R$ </td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=2 width=365>M�o-de-obra</td>";
    $code .= "<td width=182>R$ </td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=2 width=365>Outros (citar) 1</td>";
    $code .= "<td width=182>R$ </td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=2 width=365>Outros (citar) 2</td>";
    $code .= "<td width=182>R$ </td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=2 width=365>Total de despesas(aproximado)</td>";
    $code .= "<td width=182>R$ </td>";
    $code .= "</tr>";
    $code .= "</table>";
    
    $code .= "<table width=730 border=0 cellspacing=0 cellpadding=0>";
    $code .= "<tr>";
    $code .= "<td width=243 align=center>____________________________<BR>Encarregado do setor</td>";
    $code .= "<td width=243 align=center>____________________________<BR>Chefe de equipe</td>";
    $code .= "<td width=243>Emitir c�pia para:<BR>[&nbsp;&nbsp;&nbsp;] Ger�ncia da unidade<BR>[&nbsp;&nbsp;&nbsp;] Presidente da CIPA <BR>[&nbsp;&nbsp;&nbsp;] Gerente compras</td>";
    $code .= "</tr>";
    $code .= "</table>";
    
    $code .= "<div class='pagebreak'></div>";
    
    $code .= "<BR><p><BR>";
    $code .= "<div class='mediumTitle'><b>METAS E PRIORIDADES</b></div>";
    $code .= "<p align=justify>";
    $code .= "- As metas e prioridades ser�o definidas na  avalia��o anual do PPRA e dever�o contemplar n�o apenas os riscos f�sicos, qu�micos e biol�gicos como tamb�m os demais riscos.";
    $code .= "<BR><BR>";
    $code .= "- Na avalia��o anual ser� determinado a <b>{$info[razao_social]}</b>. e passa a ser uma atividade permanente. O Conte�do deste documento poder� ser revisado e alterado, quando necess�rio, pelo seu coordenador o Sr. Pedro Henrique da Silva. Um cronograma de a��es a serem realizado no decorrer do ano seguinte e atualizado mensalmente.";
    $code .= "<BR><BR>";
    $code .= "- Este documento serve como base e guia para o desenvolvimento do Programa de Preven��o de Riscos Ambientais � PPRA da {$info[razao_social]}.";
    $code .= "<BR><BR>";
    $code .= "<table width=730 border=0 cellspacing=0 cellpadding=0>";
    $code .= "<tr>";
    $code .= "<td align=center colspan=2>Rio de Janeiro, ".date("d", strtotime($info[data_criacao]))." de ".$meses[date("n", strtotime($info[data_criacao]))]." de ".date("Y", strtotime($info[data_criacao]))."</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=center colspan=2>&nbsp;</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=center>$ass_responsavel</td>";
    $code .= "<td align=center>$ass_responsavel</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=center><b>Elaborador Respons�vel</b></td>";
    $code .= "<td align=center><b>T�cnico Respons�vel</b></td>";
    $code .= "</tr>";
	
	$code .= "<tr>";
    $code .= "<td align=center>RENATA DO AMARAL CARVALHO<br><small> &nbsp; T�CNICO DE SEG. DO TRABALHO<br> &nbsp;&nbsp; REGISTRO TEM 29188/RJ<br> &nbsp;&nbsp;&nbsp; ASSD / MTE</small></td>";
    $code .= "<td align=center>RENATA DO AMARAL CARVALHO<br><small> &nbsp; T�CNICO DE SEG. DO TRABALHO<br> &nbsp;&nbsp; REGISTRO TEM 29188/RJ<br> &nbsp;&nbsp;&nbsp; ASSD / MTE</small></td>";
    $code .= "</tr>";
	
    $code .= "</table>";
    
    $sql = "SELECT * FROM cgrt_func_list WHERE cod_cgrt = ".(int)($_GET[cod_cgrt]);
    
    $res = pg_query($sql);
    
    $buffer = pg_fetch_all($res);
    
/****************************************************************************************************************/
// -> PAGE [X]
/****************************************************************************************************************/
/*    $code .= "<div class='mainTitle'><b>TITULO</b></div>";
    $code .= "<p align=justify>";

    $code .= "<div class='pagebreak'></div>";


    $code .= "</body>";
    $code .= "</html>";
*/
ob_end_clean();

/*****************************************************************************************************************/
// -> OUTPUT
/*****************************************************************************************************************/
//$html = ob_get_clean();
//$html = utf8_encode($html);
//$mpdf = new mPDF('pt','A4',3,'',8,8,5,14,9,9,'P');
//class mPDF ([ string $codepage [, mixed $format [, float $default_font_size [, string $default_font [, float $margin_left , float $margin_right , float $margin_top , float $margin_bottom , float $margin_header , float $margin_footer [, string $orientation ]]]]]])
$mpdf = new mPDF('pt', 'A4', 12, 'verdana', 8, 8, 0, 0, 0, 0, 'P'); //P: DEFAULT Portrait L: Landscape
//$mpdf->allow_charset_conversion=true;
$mpdf->charset_in='iso-8859-1';
$mpdf->SetDisplayMode('fullpage');
//$mpdf->SetFooter('{DATE j/m/Y&nbsp; H:i}|{PAGENO}/{nb}|SEDUC / SIGETI');
$mpdf->SetHTMLHeader($cabecalho);
$mpdf->SetHTMLFooter($rodape);
//carregar folha de estilos
$stylesheet = file_get_contents('../style.css');
//incorporar folha de estilos ao documento
$mpdf->WriteHTML($stylesheet,1);
// incorpora o corpo ao PDF na posi��o 2 e dever� ser interpretado como footage. Todo footage � posicao 2 ou 0(padr�o).
$mpdf->WriteHTML($code);
//void WriteHTML ( string $html [, int $mode [, boolean $initialise  [, boolean $close ]]])
//MODE Values
//0 - Parses a whole html document
//1 - Parses the html as styles and stylesheets only
//2 - Parses the html as output elements only
//3 - (For internal use only - parses the html code without writing to document)
//4 - (For internal use only - writes the html code to a buffer)
//DEFAULT: 0
//nome do arquivo de saida PDF
$arquivo = $cod_cgrt.'_'.date("ymdhis").'.pdf';
//gera o relatorio
if($_GET[out] == 'D'){
    $mpdf->Output($arquivo,'D');
}else{
    $mpdf->Output($arquivo,'I');
}
/*
I: send the file inline to the browser. The plug-in is used if available. The name given by filename is used when one selects the "Save as" option on the link generating the PDF.
D: send to the browser and force a file download with the name given by filename.
F: save to a local file with the name given by filename (may include a path).
S: return the document as a string. filename is ignored.
*/
exit();
?>