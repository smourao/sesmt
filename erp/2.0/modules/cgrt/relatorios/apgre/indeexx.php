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
$header_h = 170;//header height; 175
$footer_h = 170;//footer height;
$meses    = array('', 'Janeiro',  'Fevereiro', 'Mar�o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$m        = array(" ", "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");
$title    = "AVALIA��O PRELIMINAR E GERENCIAMENTO DE RISCOS ERGON�MICOS";

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
$sql = "SELECT cgrt.*, c.*, cnae.* FROM cgrt_info cgrt, cliente c, cnae cnae WHERE cgrt.cod_cgrt = $cod_cgrt AND cgrt.cod_cliente = c.cliente_id AND c.cnae_id = cnae.cnae_id";
$rci = pg_query($sql);
$info = pg_fetch_array($rci);
$p = $info[ano] + 1;

//Func list
$sql = "SELECT cfl.*,f.*, fun.* FROM cgrt_func_list cfl, funcionarios f, funcao fun WHERE cfl.cod_cgrt = $cod_cgrt AND f.cod_cliente = cfl.cod_cliente AND f.cod_func = cfl.cod_func AND fun.cod_funcao = f.cod_funcao AND f.cod_status = 1 ORDER BY f.nome_func";
$rfl = pg_query($sql);
$funclist = pg_fetch_all($rfl);

//Efetivo masculino
$sql = "SELECT count(*) as nfuncmasc FROM funcionarios f, cgrt_func_list l WHERE f.cod_cliente = ".(int)($info[cliente_id])." AND l.cod_cgrt = ".(int)($cod_cgrt)." AND f.cod_func = l.cod_func AND f.sexo_func = 'Masculino'";
$efetivo_masc = pg_fetch_array(pg_query($sql));
$efetivo_masc = (int)($efetivo_masc[nfuncmasc]);

//Efetivo feminino
$efetivo_fem = ((int)(pg_num_rows($rfl))-$efetivo_masc);

//MTB DO ELABORADOR
$menor = "SELECT * FROM funcionario
		WHERE funcionario_id = 21";
$result = pg_query($menor);
$flist = pg_fetch_array($result);

//MTB DO REVISOR
$maior = "SELECT ca.nome as n, f.* FROM funcionario f, cgrt_info c, cargo ca
		WHERE f.funcionario_id = c.id_resp_ppra
		AND c.cod_cgrt = $cod_cgrt and f.cargo_id = ca.cargo_id";
$result = pg_query($maior);
$flis = pg_fetch_array($result);

if($_GET[sem_assinatura]){
    $ass_elaborador  = "<BR><BR><BR><BR><BR><BR><BR>";
    $ass_responsavel = "<BR><BR><BR><BR><BR><BR><BR>";
}else{
    $ass_elaborador  = "<img src='../../../../images/ass_medica2.png' border='0'>";
    $ass_responsavel = "<img src='../../../../images/ass_pedro3.png' border='0'>";
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
        $cabecalho .= "<td align=left height=$header_h>&nbsp; </td>";
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
            <b>Avalia��o Preliminar e
Gerenciamento de Riscos
Ergon�micos</b>
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
        $rodape  = "<div style=\"position: relative; text-align: right; width: 100%\"><img src='"._IMG_PATH."ass_medica.png' border=0 width='180' height='110'></div>";

    if($_GET[sem_timbre]){
        $rodape .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$footer_h>";
        $rodape .= "<tr>";
		$rodape .= "<td align=left height=$footer_h valign=bottom class='medText'>Telefone: +55 (21) 3014 4304      Fax: Ramal 7<br>Nextel: +55 (21) 7844 6095 / Id 55*23*31641<br>medicotrab@sesmt-rio.com<br>www.sesmt-rio.com / www.shoppingsesmt.com</td>";
        $rodape .= "<td align=left height=$footer_h>&nbsp; </td>";
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
    $code .= "<p>";
    $code .= "<center><div class='mainTitle'><b>".$info[razao_social]."</b></div></center>";
    $code .= "<BR><p>";
    $code .= "<table align=center width=100% border=0><tr><td align=center><img src='"._IMG_PATH."uno_top.jpg' border=0></td></tr></table>";
    $code .= "<BR><p>";
    $code .= "<center><div class='bigTitle'><b>$title</b></div></center>";
    $code .= "<BR><p><BR>";
    $code .= "<center><div class='mainTitle'>$ano / $ano2</div></center>";
    $code .= "<center><b>LEI 6.514 Dez / 77<BR>PORTARIA 3.214 Jul / 78<BR>NR 17 - MTE</b></center>";
    $code .= "";
    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [2]
/****************************************************************************************************************/
    $code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";
    $code .= "<td><b>REALIZADO:</b></td>";
    $code .= "</tr><tr>";
    $code .= "<td>Rio de Janeiro, ".date("d", strtotime($info[data_avaliacao]))." de ".$meses[date("n", strtotime($info[data_criacao]))]." de {$info[ano]}<br>&nbsp;</td>";
    $code .= "</tr><tr>";
    $code .= "<td><b>ELABORA��O:</b></td>";
    $code .= "</tr><tr>";
    $code .= "<td>SESMT Servi�os Especializados em Seguran�a e Monitoramentos de Atividades no Trabalho Ltda<br>Rua: Marechal Ant�nio de Souza, 92 � Jardim Am�rica � Rio de Janeiro � RJ<br>CNPJ: 04.722.248/0001-17<br>&nbsp;</td>";
    $code .= "</tr><tr>";
    $code .= "<td><b>ELABORADOR:</b></td>";
    $code .= "</tr><tr>";
    $code .= "<td>$flist[nome]<br>M�dica do Trabalho<br>Reg. $flist[registro]<br>&nbsp;</td>";
    $code .= "</tr><tr>";
    $code .= "<td><b>REVISOR:</b></td>";
    $code .= "</tr><tr>";
    $code .= "<td>$flis[nome]<br>$flis[n]<br>Reg. $flis[registro]<br>&nbsp;</td>";
    $code .= "</tr><tr>";
    $code .= "<td><b>APROVA��O:</b></td>";
    $code .= "</tr><tr>";
    $code .= "<td>$info[nome_contato_dir]<br>$info[cargo_contato_dir]</td>";
    $code .= "</tr>";
   
    $code .= "</table>";

    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [3]
/****************************************************************************************************************/
    $code .= "<div class='mainTitle'><b>APRESENTA��O</b></div>";
    $code .= "<BR><p align=justify>";

    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A palavra Ergonomia � um neologismo criado a partir da uni�o dos termos gregos Ergon, que significa trabalho e Nomos, cujo significado refere-se a normas ou regras e leis. Ergonomia como fatores humanos � a disciplina cientifica que diz respeito ao discernimento do relacionamento entre homens e outros elementos de um sistema de gest�o em exerc�cio de sua profiss�o.<br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A profiss�o que implica teorias, princ�pios, informa��es, m�todos e dados para projetar, de modo a otimizar o bem estar do ser humano em uma jornada laborativa objetivando assim a efici�ncia plena do sistema. Utilizando-se de formas e maneiras mais simples e nesse complexo de a��es e informa��es temos a ergonomia como o estudo de adapta��o de uma jornada de trabalho e o ser humano.";

    $code .= "<div class='mainTitle'><b>OBJETIVO</b></div>";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O objetivo do presente trabalho � o de realizar a avalia��o preliminar e o gerenciamento dos riscos ergon�micos das atividades desenvolvidas por cada um dos colaboradores em seus postos de trabalho da empresa: <b>{$info[razao_social]}</b> Situada no Endere�o: <b>{$info[endereco]}, {$info[num_end]}</b> Inscrita no CNPJ: <b>{$info[cnpj]}</b> em conformidade com as exig�ncias pertinentes buscando sempre expor de forma clara, objetiva e t�cnica os par�metros estabelecidos que permitam adapta��es das condi��es dos postos de trabalho �s caracter�sticas psico-fisiol�gicas dos trabalhadores de modo a proporcionar o m�ximo de conforto, seguran�a e desempenho.<BR>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O estudo inclui aspectos relacionados � ergonomia f�sica, cognitiva e organizacional dentre os quais est�o � adapta��o a superf�cies, apoios e alcances da interface m�quina versus ser humano; seja por motivos de posturas inadequadas, exerc�cio de tarefas sentado; semi-sentado; em p�; empurrando; puxando; praticando levantamentos; transportando ou no exerc�cio de descarga de materiais; estruturas arquitet�nicas; mobili�rios; maquin�rios e equipamentos. �s condi��es ambientais de ilumina��o, ru�dos, stress t�rmicos e umidade relativa do ar; aspectos cognitivos, carga mental � Psican�lise Ocupacional, psicol�gica, emocional e � pr�pria organiza��o do trabalho, cargo e a metodologia do trabalho.";

    $code .= "<div class='pagebreak'></div>";


/****************************************************************************************************************/
// -> PAGE [4] 
/****************************************************************************************************************/
    $code .= "<center><div class='mainTitle'><b>SUM�RIO</b></div></center>";
    
	$code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";
    $code .= "<td><b>Empresa</b></td>";
    $code .= "</tr><tr>";
    $code .= "<td><b>Local de Trabalho</b></td>";
    $code .= "</tr><tr>";
    $code .= "<td><b>Fundamenta��o</b></td>";
    $code .= "</tr><tr>";
    $code .= "<td><b>Metodologia</b></td>";
    $code .= "</tr><tr>";
    $code .= "<td><b>Instrumentos Utilizados</b></td>";
    $code .= "</tr><tr>";
    $code .= "<td><b>Levantamento e An�lise</b></td>";
    $code .= "</tr><tr>";
    $code .= "<td>Identifica��o da an�lise<br>Descri��o f�sica e historica<br>Descri��o do m�todo de trabalho<br>Descri��o da popula��ofuncional<br>An�lise pr�-ativa de riscos ergon�micos<br>Considera��es</td>";
    $code .= "</tr><tr>";
    $code .= "<td><b>Conclus�o</b></td>";
    $code .= "</tr><tr>";
    $code .= "<td><b>Bibliografia</b></td>";
    $code .= "</tr>";
   
    $code .= "</table>";

    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [5] 
/****************************************************************************************************************/
    $code .= "<div class='mediumTitle'><b>DESCRI��O DA EMPRESA</b></div>";
    $code .= "<p align=justify>";
    
    $code .= "<table width=100% cellspacig=2 cellpadding=2 border=0>";
    $code .= "<tr>";
    $code .= "<td align=left width=150><b>Raz�o Social:</b></td>";
    $code .= "<td align=left>{$info[razao_social]}</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td><b>Endere�o:</b></td>";
    $code .= "<td>{$info[endereco]}, {$info[num_end]}</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td><b>CEP:</b></td>";
    $code .= "<td>{$info[cep]}</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td><b>Bairro:</b></td>";
    $code .= "<td>{$info[bairro]}</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td><b>Munic�pio:</b></td>";
    $code .= "<td>{$info[municipio]}</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td><b>Estado:</b></td>";
    $code .= "<td>{$info[estado]}</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td><b>CNPJ:</b></td>";
    $code .= "<td>{$info[cnpj]}</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td><b>C.N.A.E:</b></td>";
    $code .= "<td>{$info[cnae]}</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td><b>Grau de Risco:</b></td>";
    $code .= "<td>".str_pad($info[grau_de_risco], 2, "0", 0)."</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td><b>Res. Pelas Informa��es:</b></td>";
    $code .= "<td>{$info[nome_contato_dir]}</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td><b>Telefone:</b></td>";
    $code .= "<td>{$info[tel_contato_dir]}</td>";
    $code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td><b>Fax:</b></td>";
    $code .= "<td>{$info[fax]}</td>";
    $code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td><b>E-mail:</b></td>";
    $code .= "<td>{$info[email_contato_dir]}</td>";
    $code .= "</tr>";
	
	$code .= "<br>&nbsp;";
	
	$code .= "<tr>";
    $code .= "<td><b>Escrit�rio Cont�bil:</b></td>";
    $code .= "<td>{$info[escritorio_contador]}</td>";
    $code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td><b>Contador:</b></td>";
    $code .= "<td>{$info[nome_contador]}</td>";
    $code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td><b>Telefone:</b></td>";
    $code .= "<td>{$info[tel_contador]}</td>";
    $code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td><b>E-mail:</b></td>";
    $code .= "<td>{$info[email_contador]}</td>";
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
// -> PAGE [6] 
/****************************************************************************************************************/
	$code .= "<div class='mediumTitle'><b>LOCAL DE TRABALHO</b></div>";
    $code .= "<p align=justify>";

	$code .= "<b>Atividades Administrativas</b><br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Os assentos utilizados nos postos de trabalho devem atender aos seguintes requisitos m�nimos de conforto:<br>";
    $code .= "a- Altura ajust�vel � estatura do trabalhador e � natureza da fun��o exercida.<br>";
	$code .= "b- Caracter�sticas de pouca ou nenhuma conforma��o na base do assento.<br>";
	$code .= "c- Borda frontal arredondada.<br>";
	$code .= "d- Encosto com forma levemente adaptada ao corpo para prote��o da regi�o lombar.<p align=justify>";

    $code .= "<b>Atividades Operacionais</b><br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nos setores operacionais h� uma carga de movimentos repetitivos consider�veis e movimentos cont�nuos dos membros superiores e membros inferiores.<BR>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Destacamos o n�vel de aten��o que as tarefas necessitam para serem executadas com seguran�a.<p align=justify>";
   
    $code .= "<b>Fundamenta��o</b><br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fundamenta��o legal: Este trabalho baseia-se nas disposi��es da CLT � Consolida��es das Leis Trabalhistas, regulamenta��o do minist�rio do trabalho e do emprego e documentos abaixo descritos; Cap�tulo V, t�tulo II da CLT em especial no art. 198 e 199 Lei 6.514 de 22 de Dezembro de 1977; Normas Regulamentadoras do Minist�rio do Trabalho e Emprego aprovadas pela Portaria n� 3.214/78, com suas altera��es posteriores; NR � 17 Ergonomia.<p align=justify>";

	$code .= "<b>Documentos Complementares</b><br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Portaria 3.751 de 23 de Novembro de 1990 � Revoga o Anexo IV � Ilumin�ncia da NR � 15 transferido para a NR � 17 (Ergonomia); ABNT NBR 10.152 � N�veis de ru�dos para conforto ac�stico; ABNT NBR 5.413 � Ilumin�ncia de interiores.<p align=justify>";

	$code .= "<b>Fundamenta��o T�cnica</b><br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Para caracteriza��o dos fatores de risco ambiental, foram utilizadas as metodologias de avalia��o ambiental da Fundacentro.<br> ABNT NBR 5.413 � Ilumin�ncia de interiores;	FUNDACENTRO NHT 09 R/E � 1986 � Norma para avalia��o da exposi��o ocupacional ao ru�do continuo ou intermitente.<p align=justify>";

	$code .= "<b>Metodologia</b><br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nas abordagens das avalia��es preliminares ergon�micas foram utilizadas v�rias ferramentas cient�ficas, observa��o dos postos de trabalho, check-list, planilha question�rio � ordem de servi�o e entrevista nos postos de trabalho junto aos funcion�rios. Objetivando assim implementar o trabalho na utiliza��o das duas t�cnicas, a saber, a t�cnica objetiva (direta) e a t�cnica subjetiva (indireta).<p align=justify>";

	$code .= "<b>T�cnicas Objetivas</b><br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quanto �s t�cnicas objetivas, foram realizadas observa��es de campo, com o registro de imagens, avalia��o ambiental de stress t�rmico, ru�dos, vibra��es, medidas a incid�ncia de ilumin�ncia, altura de mobili�rios, coloriza��o arquitet�nica, permitindo uma abordagem de maneira global das atividades praticadas em cada posto de trabalho a partir da avalia��o ergon�mica, para identifica��o dos problemas, necessidades ou defini��es de demandas feitas com a participa��o direta (verbaliza��o) do efetivo populacional da empresa.";
	   
    //$code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [7] 
/****************************************************************************************************************/
	$code .="<p align=justify>";
   	$code .= "<b>T�cnicas Subjetivas</b><br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As t�cnicas subjetivas (check-list, question�rio e entrevistas) permitem levantar as opini�es dos entrevistados para a melhor complementa��o do trabalho garantindo que a observa��o realizada aproxime-se da realidade efetiva. Permitindo que a pesquisa de todos os itens previamente levantados possam propor as concep��es de ambiente, carga fisiol�gica, carga mental e aspectos psicossociais. A caracteriza��o da exposi��o aos agentes ilumin�ncia, ru�do e stress t�rmico considerou a observa��o dos postos de trabalho como alvo das medi��es, ou seja, a utiliza��o desses equipamentos proporcionou a defini��o das condi��es ambientais de cada posto de trabalho.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As medi��es de n�veis de ilumin�ncia foram realizadas no posto de trabalho onde se realizam as tarefas de predomin�ncia visual, utilizando-se de lux�metro com fotoc�lula corrigida para a sensibilidade do olho humano e em fun��o do �ngulo de incid�ncia. Quando n�o se p�de definir o campo de trabalho, considerou-se um plano horizontal a 0,75 cm do piso para efetuar a medi��o, considerando-se a colora��o das paredes (arquitetura) a voltagem de cada lumin�ria.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quanto ao n�vel de press�o sonora, especificadamente, a medi��o foi realizada com o microfone junto � zona auditiva do trabalhador, altura do plano horizontal que cont�m o canal auditivo, a uma dist�ncia, aproximada, de 150 mm do ouvido e em raz�o das fontes de ru�dos, emitirem ru�dos cont�nuos estacion�rios (com varia��o de n�vel desprez�vel) o per�odo de observa��o foi de 5 minutos aproximadamente para cada ponto de medi��o.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Na avalia��o de stress t�rmico, consideramos alguns par�metros que influem na sobrecarga t�rmica a que est�o submetidos os trabalhadores (temperatura do ar e umidade relativa do ar; tipo de atividade e gasto energ�tico). O posicionamento do aparelho de medi��o foi o local onde permanece o trabalhador, � dist�ncia e altura da regi�o do corpo mais atingida.<p align=justify>";
	
	//RU�DOS
	$deci = "SELECT a.*, c.data_criacao 
			FROM aparelhos a, cliente_setor c
			WHERE a.cod_aparelho = c.ruido
			AND c.id_ppra = $cod_cgrt";
	$dec = pg_query($connect, $deci);
	$db = pg_fetch_array($dec);

	$code .= "<b>Instrumentos Utilizados</b><br>";
	
	if($db[nome_aparelho] != ""){
		$code .= "<b>Nome:</b> $db[nome_aparelho]<br>";
		$code .= "<b>Marca:</b> $db[marca_aparelho]<br>";
		$code .= "<b>Data de Calibra��o:</b> ".date("d/m/Y", strtotime($db[data_calibracao]))."<p>";
    }else{
		$code .= "<br>";
	}
	
	//CALOR
	$term = "SELECT a.*, c.data_criacao 
			FROM aparelhos a, cliente_setor c
			WHERE a.cod_aparelho = c.termico
			AND c.id_ppra = $cod_cgrt";
	$ter = pg_query($connect, $term);
	$temp = pg_fetch_array($ter);
	
	if($temp[nome_aparelho] != ""){
		$code .= "<b>Nome:</b> $temp[nome_aparelho]<br>";
		$code .= "<b>Marca:</b> $temp[marca_aparelho]<br>";
		$code .= "<b>Data de Calibra��o:</b> ".date("d/m/Y", strtotime($temp[data_calibracao]))."<p>";
    }else{
		$code .= "<br>";
	}
	
	//ILUMINA��O
	$luz = "SELECT a.*, i.data
			FROM aparelhos a, iluminacao_ppra i
			WHERE a.cod_aparelho = i.lux
			AND i.id_ppra = $cod_cgrt";
	$lux = pg_query($connect, $luz);
	$ilu = pg_fetch_array($lux);

	if($ilu[nome_aparelho] != ""){
		$code .= "<b>Nome:</b> $ilu[nome_aparelho]<br>";
		$code .= "<b>Marca:</b> $ilu[marca_aparelho]<br>";
		$code .= "<b>Data de Calibra��o:</b> ".date("d/m/Y", strtotime($ilu[data_calibracao]))."<p align=justify>";
    }else{
		$code .= "<br>";
	}
	
	$code .= "<b>Conclus�o</b><br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Num aspecto global, os postos de trabalho apresentam boas condi��es; n�o obstante com uma an�lise mais detalhada, foi poss�vel detectar diversas situa��es que exigem interven��es ergon�micas e melhorias sistem�ticas que, se bem gerenciadas, trar�o melhor n�vel de conforto, seguran�a, preven��o de doen�as ocupacionais e desempenho eficiente no dia a dia dos trabalhadores.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A principio, este � o objetivo deste documento, j� que haver� uma mudan�a significativa das condi��es de trabalho, em face de nova vis�o do ambiente que nos propomos a ofertar a esta administra��o.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O presente trabalho abordar� as tr�s �reas da ergonomia: ergonomia f�sica; cognitiva e organizacional; envolvendo diversos t�picos dos cincos itens que ser�o apresentados mais a frente.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Em virtude da n�o observa��o da adapta��o das instala��es este item n�o foi apreciado nos quesitos de concep��o e ambiente, num primeiro momento da ocupa��o.";

    //$code .= "<div class='pagebreak'></div>";
    
/****************************************************************************************************************/
// -> PAGE [8] 
/****************************************************************************************************************/
	$code .="<p align=justify>";
   	$code .= "<b>Concep��o</b><br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Foram identificadas situa��es de riscos exigindo que a��es sejam implantadas e implementadas nos postos de trabalhos, tanto de OEM como de SMS, relacionados com incongru�ncia de posturas inadequadas, ferramentas impr�prias ou inseguras.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tais fatores de riscos, conforme caracterizados e classificados nas planilhas de an�lise pr�-ativa de riscos apresentam efeitos tanto humanos como organizacionais, podendo acarretar o desconforto f�sico, afastamentos e impactos no �ndice de absente�smo (pequenas perdas de produtividades) at� efeitos como sequelas e limita��es funcionais (distens�o muscular, lombalgias, tor��es articulares, DORT � Dist�rbios Osteomusculares Relacionados ao Trabalho), consequ�ncia � produtividade implicando em atrasos no campo previsto de produ��o ou em redu��o do trabalho planejado, custos em aten��o ao problema ou redu��o de m�o de obra e ainda complica��es com regula��es governamentais ou em n�o atendimento � legisla��o. Neste cen�rio a aten��o especial por parte da administra��o da empresa deve ser dada nas an�lises coletadas (resultado do levantamento t�cnico de campo) e relatadas neste trabalho.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Obedecendo aos crit�rios as instala��es el�tricas, mec�nicas, automa��o e qu�mica, vistos que estes envolvem atividades de maior esfor�o f�sico e exposi��o por parte dos trabalhadores.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Conforme recomendado nas an�lises pr�-ativa de risco, al�m das outras recomenda��es descritas neste trabalho deve-se considerar a implanta��o e implementa��o do Programa de Cinesioterapia Laboral, com atividades programadas para fortalecimento muscular dos membros mais exigidos em uma jornada de trabalho (membros superiores e membros inferiores) e ado��o de atividades aer�bicas para manuten��o do condicionamento f�sico e mental. Um programa bem elaborado e aplicado por profissional especializado, com o conhecimento pr�vio da situa��o de trabalho de cada setor da empresa � um instrumento eficaz para preven��o da DORT, contribuindo ainda para a integra��o dos trabalhadores da empresa, causando assim melhoria na disposi��o f�sica e rendimento da execu��o de tarefas �Produtividade� causando assim melhora na autoestima e satisfa��o profissional.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Outro fator a ser considerado em todos os setores � a postura e mobili�rios inadequados principalmente no trabalho sentado. A postura est�tica, sentado por longos per�odos com uso de computador, influi na ocorr�ncia de posturas durante uma jornada de trabalho, portanto torna-se necess�rio a orienta��o dos trabalhadores estimulada pela administra��o da empresa. Para a boa educa��o ergon�mica adotar uma postura correta e nas atividades e nos casos de trabalho sentado com uso de computadores promover pequenos per�odos de pausas para exerc�cios e relaxamento com objetivo de interromper a rotina e estimular as articula��es. Esses per�odos podem ser de dez (10) ou cinco (05) minutos antes de cada hora cheia.<br>";
	
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Os mobili�rios utilizados s�o adequados, com exce��o dos casos de cadeiras danificadas, j� relatados na planilha de an�lise pr�-ativa, e o uso de monitor sem regulagem de altura. Conforme estudos realizados por Grandjean, as dimens�es recomendadas para altura da tela (Ponto M�dio) a partir do piso, s�o de 78 cm a 106 cm. Embora as medidas realizadas estejam dentro da faixa recomendada, em v�rias mesas foram encontradas adapta��es improvisadas para eleva��o da altura dos monitores, indicados um desconto no uso dos mesmos. Isso ocorre devido �s varia��es de medidas antropom�tricas de cada pessoa, que determina as faixas de ajustes confort�veis no posto de trabalho. Sendo assim recomendamos a substitui��o destes monitores por outros que tenham regulagem de altura. Da mesma forma o uso de Notebook induz a inclina��o do pesco�o para baixo, j� que o equipamento � concebido em um conjunto de teclado-monitor, permitindo a regulagem da inclina��o 	da tela, mas n�o da altura. Recomenda-se sua substitui��o por micros comuns ou o uso de adaptadores ergon�micos para os casos em que seja imprescind�vel o seu uso.<p align=justify>";
	
    $code .= "<div class='pagebreak'></div>";
    
/****************************************************************************************************************/
// -> PAGE [9] 
/****************************************************************************************************************/
	$code .="<p align=justify>";
	$code .= "<b>Ambiente</b><br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Foram identificados riscos de exposi��o ao ru�do, ao calor e ilumina��o deficiente na produ��o e em alguns postos de trabalho na �rea administrativa. Por�m, o par�metro t�cnico estabelecido na NR 17, para temperatura, ru�do e ilumin�ncia adequados, refere-se apenas as atividades que exijam solicita��o intelectual, apresentando apenas um aspecto de desconforto e n�o de risco, podendo interferir no trabalho, mas n�o sendo causa principal de uma procura ambiental ou afastamento, por exemplo. Sendo assim, no que diz respeito aos riscos � sa�de dos trabalhadores provenientes desses agentes, devem ser observadas as medidas de controle adequadas conforme o PPRA � Programa de Preven��o de Riscos Ambientais e do PCMSO � Programa de Controle M�dico de Sa�de Ocupacional na empresa.<p align=justify>";

	$code .= "<b>Temperatura</b><br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No que tange ao calor, {$info[temperatura]} {$info[temp_elevada]} {$info[ceu_aberto]}. As medi��es foram realizadas {$info[p_medicao]}, e as varia��es de temperatura e umidade relativa do ar apresentadas neste documento sofreram influ�ncia do clima, visto que as mudan�as clim�ticas das esta��es do ano e tamb�m, de um dia para o outro, alteram a intensidade do calor e sensa��o t�rmica no homem. Por�m, deve-se diferenciar desconforto t�rmico �Stress T�rmico� de sobrecarga t�rmica, uma vez que o primeiro � um conceito que, entre outros fatores, depende principalmente da sensibilidade das pessoas, podendo variar de pessoa para pessoa ou de uma regi�o para outra. A sobrecarga t�rmica, no entanto, � um problema para qualquer pessoa em qualquer regi�o, visto que a natureza humana � a mesma. Embora o par�metro t�rmico estabelecido na NR 17 refira-se as atividades que exijam solicita��o intelectual sabe-se que o calor excessivo � extremamente 
	desconfort�vel para o corpo humano, portanto, recomenda-se, sempre que poss�vel, o uso de ventila��o for�ada nos ambientes quentes e a reposi��o de �gua e sais minerais durante a exposi��o.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recomenda-se aten��o quanto � orienta��o nos cuidados com a possibilidade de choque t�rmico, devido o deslocamento constante entre as �reas operacionais e setores climatizados da �rea administrativa, sobretudo no per�odo do ver�o, quando as diferen�as de temperaturas s�o acentuadas, podendo agravar sintomas de gripes; resfriados; infec��es de garganta e sistema respirat�rio. Deve-se fazer uma regulagem adequada dos condicionadores de ar, evitando o direcionamento do vento frio direto no corpo humano, o que pode acarretar um desconforto t�rmico por frio excessivo.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A umidade relativa do ar pode ficar baixa no per�odo de inverno, e os aparelhos de ar-condicionado tradicionais ir�o ressecar ainda mais os ambientes, portando recomenda-se o monitoramento da umidade relativa do ar neste per�odo, preferindo apenas ventilar o ambiente e manter as janelas abertas, o que auxilia tamb�m a troca do ar.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recomenda-se ainda, adotar o uso de telas de naylon para prevenir o acesso de insetos e poeira no ambiente de trabalho.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quanto ao ru�do no setor, embora n�o seja um fator de risco relevante a sa�de, sabemos que o ru�do acima de 65 dB (A) em postos de trabalho que se exige a solicita��o intelectual, pode causar irritabilidade, dificuldade de concentra��o e interferem no rendimento das tarefas e na incid�ncia de erros humanos. Recomenda-se  a corre��o no �mbito de redu��o ou elimina��o para uma adequa��o ergon�mica.<p align=justify>";
	
	$code .= "<b>Ilumin�ncia</b><br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A ilumin�ncia tamb�m � um fator importante nos ambientes de trabalho, assim como os agentes concomitantes, tais como: reflexos (em telas, displays e superf�cies de trabalho) e ofuscamentos. Quando a ilumin�ncia por classe de tarefas visuais de acordo com as avalia��es apresentam n�veis de ilumin�ncia abaixo do m�nimo recomendado para o ambiente, necessita-se uma corre��o com amplia��o da quantidade de lumin�rias ou da intensidade das l�mpadas (Voltagem).";
	
    //$code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [10] 
/****************************************************************************************************************/
	$code .= "<p align=justify>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quando os postos de trabalhos em ambientes administrativos verificar-se que uma ilumina��o n�o � homog�nea, apresentando defici�ncia nas superf�cies das mesas. Em alguns casos, apenas um dos lados das mesas acarretando problemas, devido apenas a localiza��o, quer seja da lumin�ria ou das mesas. Todos os casos devem ser relatados na planilha de identifica��o e an�lises e planilha de avalia��o pr�-ativa de riscos, com recomenda��o para interven��o no ambiente.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Uma orienta��o recomend�vel � o uso de lumin�rias individuais nas mesas, que proporcionam o conforto da utiliza��o de mais ou menos, luz pelo pr�prio usu�rio, conforme a necessidade.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nos casos de uso de monitores tipo CRT, com incid�ncia de reflexo. Recomendamos a substitui��o dos mesmos por modelos atuais do tipo LCD em que os reflexos s�o m�nimos ou ado��o de prote��o de telas.<p align=justify>";
	
	$code .= "<b>Carga Fisiol�gica</b><br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nas atividades dos setores administrativos onde a carga de trabalho � leve e sem transmiss�o de calor radiante, n�o h� gastos energ�ticos excessivos ao contr�rio dos setores operacionais em que ocorrem desgastes energ�ticos moderados / excessivos por ventura da necessidade de acompanhamento das atividades em operacionais, permanecendo em p� por muito tempo, ou inspe��es de itens de seguran�a com movimenta��o por toda a �rea operacional. As atividades foram observadas e acompanhadas com as taxas de metabolismo por tipo de atividade, expressos no quadro III do anexo III da NR 15.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As atividades que merecem aten��o s�o aquelas realizadas nas �reas operacionais com deslocamento por toda a produ��o, movimenta��o de cargas, subida e descida de escadas, abertura e fechamento de v�lvulas, manuseio de cargas puxadas em carrinho manualmente, entre outras. Essas atividades quando realizadas com exposi��o � carga solar ou calor artificial nos enclausuramentos, aumentam a carga fisiol�gica podendo provocar a fadiga em menos tempo. A propor��o em que a carga de trabalho f�sico aumenta, necessita-se de uma temperatura mais amena a fim de proporcionar e manter um conforto, devido os m�sculos em movimento produzirem calor durante o trabalho bra�al �f�sico�, � recomendado manter a temperatura abaixo de 20� C. (Recomenda-se a avalia��o das poss�veis melhorias j� sugeridas na planilha pr�-ativa de riscos). Com as interven��es ergon�micas de modifica��o de projetos cab�veis como: carrinhos para transporte de cargas de materiais com 	for�a motriz; carro de transporte de carga vertical �elevador de carga� para transporte de cargas, pe�as para fabrica��o, reposi��o e ferramentas em subida e descida, evitando assim esfor�os nos degraus das escadas diversas vezes.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Realizar manuten��o do condicionamento f�sico com gin�stica laboral e avalia��o m�dica espec�fica. Recomenda-se, para colaboradores com idade igual ou superior a 45 anos e lotados em �reas de produ��o e operacionais, exames de avalia��o cardiorrespirat�ria; Eletrocardiograma; Teste Ergom�trico.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O t�pico relacionado a �LER� se aplica em n�vel de ocorr�ncia intermitente, nas atividades de uso do computador por longo per�odo, principalmente nas atividades de planejamento, cargos de coordena��o e ger�ncia, em todo o setor administrativo recomendam-se a orienta��o para a pr�tica de exerc�cios de alongamento e relaxamento por ocasi�o das pausas e procura m�dica imediata ao perceber incid�ncia de dores nos punhos, cotovelos e ombros.";
		
    //$code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [11] 
/****************************************************************************************************************/
	
	$query_l = "select * from cliente_setor where id_ppra = $cod_cgrt and tipo_setor = 'Administrativo'";
	$result_l = pg_query($query_l);
	$r_l = pg_fetch_all($result_l);
				
	$code .= "<p align=justify>";
	$code .= "<b>Carga Mental</b><br>";
	$code .= "Analisando os setores administrativos, observou-se as seguintes considera��es:<br>";
	
	for($x=0;$x<count($r_l);$x++){
		$list .= $r_l[$x][c_mental];
    }
        $arcm = explode("|", $list);
        $arcm = array_flip($arcm);
        $arcm = array_flip($arcm);
        $pt = "";
        
        foreach($arcm as $val)
            if(!empty($val))
                $pt .= $val.",";
        $pt = substr($pt, 0, strlen($pt)-1);
	    $sql = "SELECT DISTINCT(cm.nome) FROM carga_mental cm, cliente_setor c where cm.c_mental in ($pt) and id_ppra = $cod_cgrt and c.tipo_setor = 'Administrativo'";
        $ap = pg_query($sql);
		while($row_ap = pg_fetch_array($ap)){
			$code .= "- $row_ap[nome];<br>";
		}
		
	$query_l = "select * from cliente_setor where id_ppra = $cod_cgrt and tipo_setor = 'Operacional'";
	$result_l = pg_query($query_l);
	$r_l = pg_fetch_all($result_l);
				
	$code .= "<p align=justify>";
	$code .= "Analisando os setores operacionais, observou-se as seguintes considera��es:<br>";
	
	for($x=0;$x<count($r_l);$x++){
		$list .= $r_l[$x][c_mental];
    }
        $arcm = explode("|", $list);
        $arcm = array_flip($arcm);
        $arcm = array_flip($arcm);
        $pt = "";
        
        foreach($arcm as $val)
            if(!empty($val))
                $pt .= $val.",";
        $pt = substr($pt, 0, strlen($pt)-1);
	    $sql = "SELECT DISTINCT(cm.nome) FROM carga_mental cm, cliente_setor c where cm.c_mental in ($pt) and id_ppra = $cod_cgrt and c.tipo_setor = 'Operacional'";
        $ap = pg_query($sql);
		while($row_ap = pg_fetch_array($ap)){
			$code .= "- $row_ap[nome];<br>";
		}
						
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Caracterizadas as ocorr�ncias consideramos a verbaliza��o de relatos espec�ficos e frequentes, buscando assim auxiliar a administra��o da empresa ".$info[razao_social]." na ado��o de medidas preventivas e corretivas quando couber.  A coleta de informa��es do quadro populacional serviu-nos tamb�m como indicador demonstrativo destas anomalias, por exemplo, vale dizer que mesmo no momento da entrevista percebe-se a incid�ncia de resist�ncia e hostilidade por ocasi�o da mesma, devido a interrup��o ao trabalho e ou o alto �ndice de stress, a carga mental excessiva pode desencadear um quadro de stress f�sico e mental (doen�a gastrointestinais, desordens do sono, dores nas costas, tens�o muscular, cansa�o excessivo, dor de cabe�a, fadiga ou estafa, irritabilidade, problemas familiares), insatisfa��o profissional e a incid�ncia de erros humanos, tida no aspecto ocupacional como �Falha Humana�  ou �Ato Inseguro� podendo os mesmos serem 
	provenientes de um desses fatores relacionados.<br>";

	if($info[terceirizado] == "sim"){
		$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Em meio aos riscos caracterizados na an�lise pr�-ativa de riscos, destaca-se um fator espec�fico relacionado a exist�ncia de profissionais lotados por empresas  na condi��o de terceirizadas para presta��o de servi�os, com pol�tica diferenciada em v�rios aspectos como, plano de cargos e sal�rios, acesso a treinamento, embora executem uma mesma fun��o. A indefini��o relacionada quanto ao pessoal registrado na ".$info[rezao_social]." assim como o fato de um outro profissional da empresa terceirizada, estar subordinado a outro de mesmo n�vel ou at� de menor n�vel constitui-se um entrave a ser gerenciado.<br>";
	}else{
		$code .= "&nbsp;<br>";
	}
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nos casos de identifica��o desse tipo de ocorr�ncia requer uma interven��o da administra��o da ".$info[razao_social]." buscando priorizar uma pol�tica igualit�ria causando assim um efeito de minimiza��o do impacto de diferen�as que afetam diretamente a sa�de ocupacional ou indiretamente trazendo efeitos na qualidade de vida e bem estar.<br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;� importante ressaltar a relev�ncia do assunto, pois mal gerenciado pode afetar diretamente no rendimento operacional e organizacional da empresa.  A lentid�o e burocracia do sistema de gest�o, nesses casos, cria uma atmosfera de desmotiva��o, incerteza ocasionando gargalos e emperro na administra��o dos recursos humanos, atravancando a performance da empresa e acarretando a perda de pessoal qualificado para a boa gest�o do processo.<br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Outro fator que merece a aten��o especial � o trabalho produzido por m�o de obra terceirizada. Quando a empresa contratada para o servi�o n�o institui a mesma equival�ncia da pol�tica de seguran�a, sa�de ocupacional e de meio ambiente deve-se exigir, na contrata��o da empresa, c�pias dos documentos pertinentes a essas medidas, caso contr�rio pode ocasionar acidentes por parte de prestadores terceirizados desatentos as determina��es da administra��o contratante e desmotiva��o da equipe populacional da ".$info[razao_social]." por submeterem-se a uma pol�tica que n�o � exigida ao efetivo da empresa terceirizada.<BR>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;H� outro fator relevante a se abordar, quando a equipe administrativa adentra a �rea operacional e muda-se a metodologia de trabalho, onde h� a necessidade de observar manuais, c�digos etc, quando em paradas e partidas exigindo uma aten��o maior do que a habitual exposi��o �Direta Eventual� a atividade principal exige monotonia em sua maior parte do tempo com tarefas repetitivas todos os dias, especialmente depois de certo tempo ocupada a fun��o.<br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nesses casos recomenda-se a implanta��o de a��es que promovam a descontra��o e o al�vio da tens�o acumulado durante o trabalho, bem como a discuss�o de formas de trabalho com combina��o de tarefas que torne o trabalho mais interessante.<p align='justify'>";
	
	$code .= "<b>Aspectos Psicossociais</b><br>";
	
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Neste t�pico procuramos avaliar os aspectos relacionados com autonomia se as atividades limitam o trabalhador e n�o d�o possibilidade de escolher quando e como fizer o trabalho.<br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A falta do trabalho em equipe resulta na escassez de consulta aos trabalhadores sobre mudan�as, integra��o ou exist�ncia de conflitos entre n�veis hier�rquicos, indiv�duos, grupos e setores. Treinamento, oportunidade, apoio, incentivo e financiamento de treinamento e aprendizagem de novas t�cnicas.<BR>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fator potencial a valoriza��o e reconhecimento, oportunidade de crescimento e premia��o por colabora��o nas melhorias de processo.<br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Trabalho em turnos que proporcionam desajuste e perturba��es funcionais.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Esses fatores podem causar diversos problemas relacionados � insatisfa��o profissional e erros humanos, al�m de contribuir para o aumento do stress, muitas vezes um profissional permanece no emprego e guarda ang�stia por estar naquela empresa ou por exercer aquela fun��o. Quem trabalha desmotivado tem o rendimento prejudicado e atravanca o desempenho da equipe e da empresa ou busca oportunidades em outras empresas acarretando alta rotatividade, perda de tempo e custos de recoloca��o de profissional.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Existe certa restri��o de autonomia no �mbito gerencial, que impede a tomada de decis�es de quem conhece melhor o ambiente de trabalho e as necessidades de mudan�a, ficando a crit�rio da diretoria que n�o est� no mesmo ambiente de trabalho diariamente, arbitrar sobre quest�es do exerc�cio operacional, at� mesmo pelo advento de novas t�cnicas que surgem com frequ�ncia e a administra��o toma conhecimento muito tempo ap�s elas serem implantadas no mercado e s�o grandes facilitadores de produtividade em uma empresa.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No t�pico �Equipe� podemos evidenciar a incid�ncia de gargalo do processo produtividade, por falta de treinamento, integra��o e comunica��o constante, ficando a pr�pria chefia a cargo disso. � importante que sejam efetivadas a��es concretas com pol�ticas direcionadas para a gest�o participativa, com a pr�tica de consultar a equipe sobre mudan�as e melhorias a serem feitas no setor. Da mesma forma a empresa carece de espa�o e atividades espec�ficas de descontra��o e lazer, que promovam a intera��o entre equipes e setores, bem como propiciem ocasi�es para facilitar a comunica��o e o apoio m�tuo. Este problema � acentuado pela pr�pria localiza��o da empresa em uma �rea isolada dos centros urbanos e a frieza intr�nseca de uma estrutura industrial. Em outras palavras, � importante humanizar cada vez mais o ambiente de trabalho valorizando assim a import�ncia dos relacionamentos e dos pr�prios indiv�duos, em meio �s m�quinas.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Segundo a teoria de motiva��o de Abraham Maslow, as pessoas s�o motivadas por uma s�rie de necessidades, desde as b�sicas ou prim�rias como: comer, beber e vestir-se, at� as mais sofisticadas como: Autorrealiza��o, autoestima, reconhecimento, import�ncia, apre�o aos demais, desejo de prest�gio e status. Quando cada pessoa alcan�a satisfa��o razo�vel de uma dada necessidade, movimenta-se para satisfazer outra necessidade maior.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Desta forma recomendamos aumentar a motiva��o atrav�s de uma reestrutura��o do trabalho com envolvimento dos l�deres, tornar o trabalho interessante e compensador para o trabalhador �Ajudar o trabalhador a fazer mais planejamento do trabalho; Fazer o trabalhador participar mais das decis�es de trabalho; Dar feedback regular no desempenho; N�o intervir excessivamente; Estar dispon�vel a ajudar e ser entusiasta a respeito da organiza��o, do trabalho e das pessoas�.";

    $code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [12] --> AVALIA��O PRELIMINAR 1� PARTE
/****************************************************************************************************************/
	$avali = "SELECT s.cod_setor, s.nome_setor, ed.descricao, cs.tipo_setor, info.jornada, cs.epc_existente, cs.h_melhoria, cs.h_acidente,
	cs.foto, cs.equip_util, cs.fer_util, cs.carga_manu, cs.ativ_rotina, cs.verba
	FROM cliente_setor cs, setor s, tipo_edificacao ed, cgrt_info info 
	WHERE id_ppra = $cod_cgrt AND cs.cod_setor = s.cod_setor AND cod_edificacao = ed.tipo_edificacao_id 
	AND id_ppra = cod_cgrt AND cs.is_posto_trabalho = 0";
	$ava = pg_query($avali);
	$avl = pg_fetch_all($ava);
	
	for($x=0;$x<pg_num_rows($ava);$x++){
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
    $code .= "<tr>";
    $code .= "<td class='bgtitle' align=center colspan=2><b>Avalia��o Preliminar e Gerenciamento de Riscos Ergon�micos $info[ano]</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=center colspan=2><b>Identifica��o e An�lise</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Instala��o:</b></td>";
	$code .= "<td align=left width=75%>{$avl[$x][descricao]}</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Setor:</b></td>";
	$code .= "<td align=left width=75%>{$avl[$x][nome_setor]}</td>";
	$code .= "</tr>";
	$code .= "<tr>";
	
	$funcao = "SELECT fu.nome_funcao, fu.dsc_funcao, f.*
		FROM funcao fu, funcionarios f, cgrt_func_list cgrt
		WHERE fu.cod_funcao = f.cod_funcao AND f.cod_func = cgrt.cod_func AND cod_cgrt = $cod_cgrt 
		AND f.cod_setor = {$avl[$x][cod_setor]} AND f.cod_cliente = cgrt.cod_cliente ";
	$func = pg_query($funcao);
	$fff = pg_fetch_all($func);
	
    $code .= "<td align=left width=25%><b>Fun��o:</b></td>";
	$code .= "<td align=left width=75%>"; 
		for($w=0;$w<pg_num_rows($func);$w++){
			$code .= "{$fff[$w][nome_funcao]}; ";
		}
	$code .= "</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>N� de Funcion�rios:</b></td>";
	$code .= "<td align=left width=75%>".str_pad(pg_num_rows($func), 2, "0", 0)."</td>";
	$code .= "</tr>";
	
	$habil = "SELECT DISTINCT(habilidade) 
		FROM funcionarios f, cgrt_func_list cl 
		WHERE f.cod_func = cl.cod_func AND cl.cod_cgrt = $cod_cgrt AND f.cod_setor = {$avl[$x][cod_setor]}
		AND f.cod_cliente = cl.cod_cliente";
	$habilit = pg_query($habil);
	$hab = pg_fetch_array($habilit);
	
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Exig�ncias/Habilidades Necess�rias:</b></td>";
	$code .= "<td align=left width=75%>{$hab[habilidade]}</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Tipo de Atividade:</b></td>";
	$code .= "<td align=left width=75%>{$avl[$x][tipo_setor]}</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Din�mica da Atividade:</b></td>";
	$code .= "<td align=justify width=75%>"; 
		for($w=0;$w<pg_num_rows($func);$w++){
			$code .= "{$fff[$w][dsc_funcao]}";
		}
	$code .= "</td>";
	$code .= "</tr>";
	
	$sql = "SELECT se.descricao FROM sugestao s, setor_epi se, setor st
        WHERE (s.med_prev = se.id AND s.cod_setor = st.cod_setor AND se.cod_setor = s.cod_setor
        AND s.cod_setor = {$avl[$x][cod_setor]})
        AND s.tipo_med_prev = 0 AND s.plano_acao = 0 AND s.id_ppra = $cod_cgrt";
        $r_s_e = pg_query($sql);
        $sugestao_setor_epi = pg_fetch_all($r_s_e);
		
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>EPI/EPC Utilizados:</b></td>";
	$code .= "<td align=justify width=75%>{$avl[$x][epc_existente]}; ";
		for($y=0;$y<pg_num_rows($r_s_e);$y++){
			$code .= "{$sugestao_setor_epi[$y][descricao]}; ";
		}
	$code .= "</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Alvo da Avalia��o:</b></td>";
	$code .= "<td align=left width=75%>{$avl[$x][descricao]}</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Historico de Melhoria:</b></td>";
	$code .= "<td align=left width=75%>{$avl[$x][h_melhoria]}</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Historico de Acidentes:</b></td>";
	$code .= "<td align=left width=75%>{$avl[$x][h_acidente]}</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Jornada de Trabalho:</b></td>";
	$code .= "<td align=left width=75%>{$avl[$x][jornada]}</td>";
	$code .= "</tr>";
	$code .= "</table>";
	
	$sql = "SELECT ag.nome_agente_risco, r.dsc_agente, r.diagnostico, r.fonte_geradora, r.preventiva, tr.cod_tipo_risco
			FROM setor s, risco_setor r, cliente_setor c, agente_risco ag, tipo_risco tr
			WHERE r.cod_cliente = c.cod_cliente AND r.cod_setor = c.cod_setor AND r.cod_setor = s.cod_setor
			AND c.id_ppra = r.id_ppra AND c.id_ppra = $cod_cgrt AND c.cod_setor = {$avl[$x][cod_setor]}
			AND ag.cod_tipo_risco = tr.cod_tipo_risco AND r.cod_agente_risco = ag.cod_agente_risco AND tr.cod_tipo_risco = 4";
	$rag = pg_query($sql);
	$sagent = pg_fetch_all($rag);
		
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
    $code .= "<tr>";
    $code .= "<td class='bgtitle' align=center colspan=2><b>Mem�ria Fotogr�fica</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=center width=30% rowspan=2>";
		$code .= "<div id=foto><img src='../../../../{$avl[$x][foto]}' border=0 width=200 height=200></div>";
	$code .= "</td>";
	$code .= "<td align=left width=70%><b>Agente: </b>";
		for($z=0;$z<pg_num_rows($rag);$z++){
			$code .= "{$sagent[$z][nome_agente_risco]}; ";
		}
	$code .= "</td>";
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=left><b>Descri��o: </b>";
		for($z=0;$z<pg_num_rows($rag);$z++){
			$code .= "{$sagent[$z][fonte_geradora]}; ";
		}
	$code .= "</td>";
	$code .= "</tr>";
	$code .= "</table>";
	
	$code .= "<div class='pagebreak'></div>";
	
	/************************************************************************************************************/
	// -> AVALIA��O PRELIMINAR 2� PARTE
	/************************************************************************************************************/
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$code .= "<tr>";
    $code .= "<td class='bgtitle' align=center colspan=2><b>Hist�rico</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Instala��o:</b></td>";
	$code .= "<td align=left width=75%>{$avl[$x][descricao]}</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>M�quina e Equip. Utilizados:</b></td>";
	$code .= "<td align=left width=75%>{$avl[$x][equip_util]}</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Ferramentas Utilizadas:</b></td>";
	$code .= "<td align=left width=75%>{$avl[$x][fer_util]}</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Materiais e Cargas Manuseadas:</b></td>";
	$code .= "<td align=left width=75%>{$avl[$x][carga_manu]}</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Atividade Rotineira:</b></td>";
	$code .= "<td align=left width=75%>{$avl[$x][ativ_rotina]}</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Verbaliza��o Principal:</b></td>";
	$code .= "<td align=left width=75%>{$avl[$x][verba]}</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Objetivo da Avalia��o:</b></td>";
	$code .= "<td align=left width=75%>Possibilitar a corre��o do ambiente de trabalho e melhorar as condi��es de trabalho</td>";
	$code .= "</tr>";
	
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Data da Avalia��o:</b></td>";
	$code .= "<td align=left width=75%>".date("d/m/Y", strtotime($info[data_avaliacao]))."</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Data da Pr�xima Revis�o:</b></td>";
	$code .= "<td align=left width=75%>".date("d", strtotime($info[data_avaliacao]))."/".date("m", strtotime($info[data_avaliacao]))."/{$p}</td>";
	$code .= "</tr>";
	$code .= "</table>";
	
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$code .= "<tr>";
    $code .= "<td class='bgtitle' align=center colspan=6><b>An�lise Pr�-Ativa de Riscos Ergon�micos</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=center width=15%><b>Agente</b></td>";
	$code .= "<td align=center width=17%><b>Caracteriza��o</b></td>";
	$code .= "<td align=center width=17%><b>Risco</b></td>";
	$code .= "<td align=center width=17%><b>Prioriza��o do Risco</b></td>";
	$code .= "<td align=center width=17%><b>Provid�ncias</b></td>";
	$code .= "<td align=center width=17%><b>Provid�ncia Ergon�mica</b></td>";
	$code .= "</tr>";
	for($z=0;$z<pg_num_rows($rag);$z++){
		if($sagent[$z][cod_tipo_risco] == 4){
			$code .= "<tr>";
			$code .= "<td align=center>{$sagent[$z][nome_agente_risco]}&nbsp;</td>";
			$code .= "<td align=center>{$sagent[$z][fonte_geradora]}&nbsp;</td>";
			$code .= "<td align=center>{$sagent[$z][diagnostico]}&nbsp;</td>";
			$code .= "<td align=center>{$sagent[$z][diagnostico]}&nbsp;</td>";
			$code .= "<td align=center>{$sagent[$z][preventiva]}&nbsp;</td>";
			$code .= "<td align=center>{$sagent[$z][preventiva]}&nbsp;</td>";
			$code .= "</tr>";
		}else{
			$code .= "<tr>";
			$code .= "<td align=center>&nbsp;</td>";
			$code .= "<td align=center>&nbsp;</td>";
			$code .= "<td align=center>&nbsp;</td>";
			$code .= "<td align=center>&nbsp;</td>";
			$code .= "<td align=center>&nbsp;</td>";
			$code .= "<td align=center>&nbsp;</td>";
			$code .= "</tr>";
		}
	}
	$code .= "</table>";

	$code .= "<div class='pagebreak'></div>";

	/************************************************************************************************************/
	// -> AVALIA��O PRELIMINAR 3� PARTE
	/************************************************************************************************************/
	//---------ERGON�MIA
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$code .= "<tr>";
    $code .= "<td class='text' align=left><b>Ergon�mia Risco Analisado</b></td>";
	$code .= "</tr>";
	$code .= "</table>";
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$code .= "<tr>";
    $code .= "<td align=left width=10%><b>&nbsp;</b></td>";
	$code .= "<td align=center colspan=2 width=40%><b>Antecipa��o do Risco</b></td>";
	$code .= "<td align=center width=25%><b>Prioriza��o do Risco</b></td>";
	$code .= "<td align=center colspan=2 width=25%><b>Conduta Ergon�mica</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=center >Agente</td>";
	$code .= "<td align=center width=13%>Causa</td>";
	$code .= "<td align=center width=27%>Sintomas</td>";
	$code .= "<td align=center >A��es e Medidas</td>";
	$code .= "<td align=center width=12%>Provid�ncias</td>";
	$code .= "<td align=center width=13%>Medidas Adicionais</td>";
	$code .= "</tr>";
	
	$sql = "SELECT c.*, r.dsc_agente, r.diagnostico, r.fonte_geradora as fonte, r.preventiva, tr.cod_tipo_risco, tr.nome_tipo_risco
			FROM setor s, risco_setor r, cliente_setor c, agente_risco ag, tipo_risco tr
			WHERE r.cod_cliente = c.cod_cliente AND r.cod_setor = c.cod_setor AND r.cod_setor = s.cod_setor
			AND c.id_ppra = r.id_ppra AND c.id_ppra = $cod_cgrt AND c.cod_setor = {$avl[$x][cod_setor]}
			AND ag.cod_tipo_risco = tr.cod_tipo_risco AND r.cod_agente_risco = ag.cod_agente_risco ";
	$r_ag = pg_query($sql);
	$s_agent = pg_fetch_all($r_ag);
	
	for($z=0;$z<pg_num_rows($r_ag);$z++){
		$code .= "<tr>";
		$code .= "<td align=center>{$s_agent[$z][nome_tipo_risco]}&nbsp;</td>";
		$code .= "<td align=center>{$s_agent[$z][fonte]}&nbsp;</td>";
		$code .= "<td align=center>{$s_agent[$z][diagnostico]}&nbsp;</td>";
		$code .= "<td align=center>{$s_agent[$z][diagnostico]}&nbsp;</td>";
		$code .= "<td align=center>{$s_agent[$z][preventiva]}&nbsp;</td>";
		$code .= "<td align=center>{$s_agent[$z][preventiva]}&nbsp;</td>";
		$code .= "</tr>";
	}
	$code .= "</table>";
	
	$code .= "<p>";
	
	//-----AMBIENTE
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$code .= "<tr>";
    $code .= "<td class='text' align=left><b>Ambiente</b></td>";
	$code .= "</tr>";
	$code .= "</table>";
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$code .= "<tr>";
    $code .= "<td align=left width=10%><b>&nbsp;</b></td>";
	$code .= "<td align=center colspan=2 width=40%><b>Antecipa��o do Risco</b></td>";
	$code .= "<td align=center width=25%><b>Prioriza��o do Risco</b></td>";
	$code .= "<td align=center colspan=2 width=25%><b>Conduta Ergon�mica</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=center >Agente</td>";
	$code .= "<td align=center width=13%>Caracteriza��o</td>";
	$code .= "<td align=center width=27%>Sintomas</td>";
	$code .= "<td align=center >Meio de Controle Existente</td>";
	$code .= "<td align=center width=12%>Fonte Geradora</td>";
	$code .= "<td align=center width=13%>Medida de Controle no Trabalhador</td>";
	$code .= "</tr>";
	
	$sql = "select lux_recomendado, (sum( cast( cast(lux_atual as text) as integer) ) / 
			(select count(*) from iluminacao_ppra where id_ppra = $cod_cgrt and cod_setor = {$avl[$x][cod_setor]}) ) as t
			from iluminacao_ppra where id_ppra = $cod_cgrt and cod_setor = {$avl[$x][cod_setor]} group by lux_recomendado";
	$ilu = pg_query($sql);
	$alu = pg_fetch_array($ilu);
	
	$code .= "<tr>";
	$code .= "<td align=center>Ilumin�ncia</td>";
		if($alu[t] < $alu[lux_recomendado]){
			$code .= "<td align=center>Abaixo do limite permitido</td>";
			$code .= "<td align=center>Dores de cabe�a</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>Pouca ilumina��o</td>";
			$code .= "<td align=center>Fazer o dimensionamento da ilumina��o</td>";
		}elseif ($alu[t] >= $alu[lux_recomendado] && $alu[t] <=1000){
			$code .= "<td align=center>Desprezivel</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
		}elseif($alu[t] > 1000){
			$code .= "<td align=center>Acima do limite permitido</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
		}else{
			$code .= "&nbsp;";
		}
	$code .= "</tr>";
		
	$sql = "SELECT c.*, r.dsc_agente, r.diagnostico, r.fonte_geradora as geradora, r.acao_necessaria, ag.cod_tipo_risco, tr.nome_tipo_risco, ag.cod_agente_risco
			FROM setor s, risco_setor r, cliente_setor c, agente_risco ag, tipo_risco tr
			WHERE r.cod_cliente = c.cod_cliente AND r.cod_setor = c.cod_setor AND r.cod_setor = s.cod_setor
			AND c.id_ppra = r.id_ppra AND c.id_ppra = $cod_cgrt AND c.cod_setor = {$avl[$x][cod_setor]}
			AND ag.cod_tipo_risco = tr.cod_tipo_risco AND r.cod_agente_risco = ag.cod_agente_risco ";
	$tcl = pg_query($sql);
	$ctrl = pg_fetch_array($tcl);
		
	$code .= "<tr>";
	$code .= "<td align=center>Temperatura</td>";
	if($ctrl[caracterizacao] != ''){
		$code .= "<td align=center>{$ctrl[caracterizacao]}</td>";
		$code .= "<td align=center>{$ctrl[sintoma]}</td>";
		$code .= "<td align=center>{$ctrl[m_ctr_existente]}</td>";
		$code .= "<td align=center>{$ctrl[fonte_geradora]}</td>";
		$code .= "<td align=center>{$ctrl[m_ctr_trabalhador]}</td>";
	}else{
		$code .= "<td align=center>Desprez�vel</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
	}
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=center>Ru�do</td>";
	if($ctrl[ruido_operacao_setor] > '85.00' && $ctrl[cod_tipo_risco] == 1){
		$code .= "<td align=center>Acima do Limite</td>";
		$code .= "<td align=center>{$ctrl[diagnostico]}&nbsp;</td>";
		$code .= "<td align=center>{$ctrl[diagnostico]}&nbsp;</td>";
		$code .= "<td align=center>{$ctrl[geradora]}&nbsp;</td>";
		$code .= "<td align=center>Uso de Protetor Auricular</td>";
	}else{
		$code .= "<td align=center>Desprez�vel</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
	}
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=center>Ventila��o</td>";
	if($ctrl[cod_vent_art] == 3 and $ctrl[cod_parede] == 1){
		$code .= "<td align=center>Ambiente abafado</td>";
		$code .= "<td align=center>Mal estar</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>Ambiente abafado</td>";
		$code .= "<td align=center>Instalar ar-condicionado ou circulador de ar</td>";
	}else{
		$code .= "<td align=center>Desprez�vel</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
	}
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=center>Presen�a Qu�mica</td>";
	$quimica = "SELECT c.*, r.dsc_agente, r.diagnostico, r.fonte_geradora as fonte, r.acao_necessaria, ag.cod_agente_risco, tr.cod_tipo_risco, tr.nome_tipo_risco
			FROM setor s, risco_setor r, cliente_setor c, agente_risco ag, tipo_risco tr
			WHERE r.cod_cliente = c.cod_cliente AND r.cod_setor = c.cod_setor AND r.cod_setor = s.cod_setor
			AND c.id_ppra = r.id_ppra AND c.id_ppra = $cod_cgrt AND c.cod_setor = {$avl[$x][cod_setor]}
			AND ag.cod_tipo_risco = tr.cod_tipo_risco AND r.cod_agente_risco = ag.cod_agente_risco and tr.cod_tipo_risco = 2";
	$quimi = pg_query($quimica);
	$qmc = pg_fetch_array($quimi);
	
	if($qmc[cod_tipo_risco] == 2){
		$code .= "<td align=center>Sim</td>";
		$code .= "<td align=center>{$qmc[diagnostico]}&nbsp;</td>";
		$code .= "<td align=center>EPI</td>";
		$code .= "<td align=center>{$qmc[fonte]}&nbsp;</td>";
		$code .= "<td align=center>{$qmc[acao_necessaria]}&nbsp;</td>";
	}else{
		$code .= "<td align=center>N�o</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
	}
	$code .= "</tr>";
	
	$code .= "<tr>";
	$code .= "<td align=center>Vibra��o</td>";
	$vibracao = "SELECT c.*, r.dsc_agente, r.diagnostico, r.fonte_geradora as fonte, r.acao_necessaria, ag.cod_agente_risco, tr.cod_tipo_risco, tr.nome_tipo_risco
			FROM setor s, risco_setor r, cliente_setor c, agente_risco ag, tipo_risco tr
			WHERE r.cod_cliente = c.cod_cliente AND r.cod_setor = c.cod_setor AND r.cod_setor = s.cod_setor
			AND c.id_ppra = r.id_ppra AND c.id_ppra = $cod_cgrt AND c.cod_setor = {$avl[$x][cod_setor]}
			AND ag.cod_tipo_risco = tr.cod_tipo_risco AND r.cod_agente_risco = ag.cod_agente_risco and ag.cod_agente_risco = 6";
	$vibra = pg_query($vibracao);
	$vbd = pg_fetch_array($vibra);
	
	if($vbd[cod_agente_risco] == 6){
		$code .= "<td align=center>Sim</td>";
		$code .= "<td align=center>{$vbd[diagnostico]}&nbsp;</td>";
		$code .= "<td align=center>EPI</td>";
		$code .= "<td align=center>{$vbd[fonte]}&nbsp;</td>";
		$code .= "<td align=center>{$vbd[acao_necessaria]}&nbsp;</td>";
	}else{
		$code .= "<td align=center>N�o</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
	}
	$code .= "</tr>";
	
	$code .= "<tr>";
	$code .= "<td align=center>Radia��o Ionizante</td>";
	$radiacao_io = "SELECT c.*, r.dsc_agente, r.diagnostico, r.fonte_geradora as fonte, r.acao_necessaria, ag.cod_agente_risco, tr.cod_tipo_risco, tr.nome_tipo_risco
			FROM setor s, risco_setor r, cliente_setor c, agente_risco ag, tipo_risco tr
			WHERE r.cod_cliente = c.cod_cliente AND r.cod_setor = c.cod_setor AND r.cod_setor = s.cod_setor
			AND c.id_ppra = r.id_ppra AND c.id_ppra = $cod_cgrt AND c.cod_setor = {$avl[$x][cod_setor]}
			AND ag.cod_tipo_risco = tr.cod_tipo_risco AND r.cod_agente_risco = ag.cod_agente_risco and ag.cod_agente_risco = 11";
	$radiacao = pg_query($radiacao_io);
	$ionizante = pg_fetch_array($radiacao);
	
	if($ionizante[cod_agente_risco] == 11){
		$code .= "<td align=center>Sim</td>";
		$code .= "<td align=center>{$ionizante[diagnostico]}&nbsp;</td>";
		$code .= "<td align=center>EPI</td>";
		$code .= "<td align=center>{$ionizante[fonte]}&nbsp;</td>";
		$code .= "<td align=center>{$ionizante[acao_necessaria]}&nbsp;</td>";
	}else{
		$code .= "<td align=center>N�o</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
	}
	$code .= "</tr>";
	
	$code .= "<tr>";
	$code .= "<td align=center>Radia��o n�o Ionizante</td>";
	$radiacao_n = "SELECT c.*, r.dsc_agente, r.diagnostico, r.fonte_geradora as fonte, r.acao_necessaria, ag.cod_agente_risco, tr.cod_tipo_risco, tr.nome_tipo_risco
			FROM setor s, risco_setor r, cliente_setor c, agente_risco ag, tipo_risco tr
			WHERE r.cod_cliente = c.cod_cliente AND r.cod_setor = c.cod_setor AND r.cod_setor = s.cod_setor
			AND c.id_ppra = r.id_ppra AND c.id_ppra = $cod_cgrt AND c.cod_setor = {$avl[$x][cod_setor]}
			AND ag.cod_tipo_risco = tr.cod_tipo_risco AND r.cod_agente_risco = ag.cod_agente_risco and ag.cod_agente_risco = 16";
	$n_radi = pg_query($radiacao_n);
	$nao = pg_fetch_array($n_radi);
	
	if($nao[cod_agente_risco] == 16){
		$code .= "<td align=center>Sim</td>";
		$code .= "<td align=center>{$nao[diagnostico]}&nbsp;</td>";
		$code .= "<td align=center>EPI</td>";
		$code .= "<td align=center>{$nao[fonte]}&nbsp;</td>";
		$code .= "<td align=center>{$nao[acao_necessaria]}&nbsp;</td>";
	}else{
		$code .= "<td align=center>N�o</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
	}
	$code .= "</tr>";
	
	$code .= "</table>";
	
	$code .= "<p>";
	
	//-----CARGA FISIOL�GICA
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$code .= "<tr>";
    $code .= "<td class='text' align=left><b>Carga Fisiol�gica</b></td>";
	$code .= "</tr>";
	$code .= "</table>";
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$code .= "<tr>";
    $code .= "<td align=left width=10%><b>&nbsp;</b></td>";
	$code .= "<td align=center colspan=2 width=40%><b>Antecipa��o do Risco</b></td>";
	$code .= "<td align=center width=25%><b>Prioriza��o do Risco</b></td>";
	$code .= "<td align=center colspan=2 width=25%><b>Conduta Ergon�mica</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=center >Gasto Energ�tico</td>";
	$code .= "<td align=center width=13%>Caracteriza��o</td>";
	$code .= "<td align=center width=27%>Fonte Geradora</td>";
	$code .= "<td align=center >Meio de Controle Existente</td>";
	$code .= "<td align=center width=12%>Sintoma</td>";
	$code .= "<td align=center width=13%>Medida de Controle no Trabalhador</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=center >Manuseio de Carga</td>";
	if($ctrl[m_carga] == '' || $ctrl[m_carga] == 'n�o'){
		$code .= "<td align=center >N�o</td>";
		$code .= "<td align=center >N/H</td>";
		$code .= "<td align=center >N/H</td>";
		$code .= "<td align=center >N/H</td>";
		$code .= "<td align=center >N/H</td>";
	}else{
		$code .= "<td align=center >Sim</td>";
		$code .= "<td align=center >Queda</td>";
		$code .= "<td align=center >EPI/EPC</td>";
		$code .= "<td align=center >Traumas</td>";
		$code .= "<td align=center >EPI/EPC</td>";
	}
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=center >Deslocamento</td>";
	if($ctrl[desloc] == '' || $ctrl[desloc] == 'n�o'){
		$code .= "<td align=center >N�o</td>";
		$code .= "<td align=center >N/H</td>";
		$code .= "<td align=center >N/H</td>";
		$code .= "<td align=center >N/H</td>";
		$code .= "<td align=center >N/H</td>";
	}else{
		$code .= "<td align=center >Sim</td>";
		$code .= "<td align=center >Queda</td>";
		$code .= "<td align=center >EPI/EPC</td>";
		$code .= "<td align=center >Traumas</td>";
		$code .= "<td align=center >EPI/EPC</td>";
	}
	$code .= "</tr>";
	
	$pavi = "select n_pavimentos from cgrt_info where cod_cgrt = $cod_cgrt ";
	$pav = pg_query($pavi);
	$pvm = pg_fetch_array($pav);
	
	$code .= "<tr>";
    $code .= "<td align=center >Uso de Escadas</td>";
	if($pvm[n_pavimentos] > 1){
		$code .= "<td align=center >Sim</td>";
		$code .= "<td align=center >Queda</td>";
		$code .= "<td align=center >EPI/EPC</td>";
		$code .= "<td align=center >Traumas</td>";
		$code .= "<td align=center >EPI/EPC</td>";
	}else{
		$code .= "<td align=center >N�o</td>";
		$code .= "<td align=center >N/H</td>";
		$code .= "<td align=center >N/H</td>";
		$code .= "<td align=center >N/H</td>";
		$code .= "<td align=center >N/H</td>";
	}
	$code .= "</tr>";
	
	$code .= "</table>";
	
	$code .= "<p>";
	
	//-----CARGA MENTAL
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$code .= "<tr>";
    $code .= "<td class='text' align=left><b>Carga Mental</b></td>";
	$code .= "</tr>";
	$code .= "</table>";
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$code .= "<tr>";
    $code .= "<td align=left width=10%><b>&nbsp;</b></td>";
	$code .= "<td align=center colspan=2 width=40%><b>Antecipa��o do Risco</b></td>";
	$code .= "<td align=center width=25%><b>Prioriza��o do Risco</b></td>";
	$code .= "<td align=center colspan=2 width=25%><b>Conduta Ergon�mica</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=center >Organiza��o</td>";
	$code .= "<td align=center width=13%>Caracteriza��o</td>";
	$code .= "<td align=center width=27%>Fonte Geradora</td>";
	$code .= "<td align=center >Meio de Controle Existente</td>";
	$code .= "<td align=center width=12%>Sintoma</td>";
	$code .= "<td align=center width=13%>Medida de Controle no Trabalhador</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=center > </td>";
	$code .= "<td align=center >Ritmo da produtividade</td>";
	$code .= "<td align=center >Atividade realizada</td>";
	$code .= "<td align=center >Altern�ncia do quadro de hor�rio</td>";
	$code .= "<td align=center >Stress mental</td>";
	$code .= "<td align=center >Altern�ncia do quadro de hor�rio</td>";
	$code .= "</tr>";
	
	$code .= "</table>";
	
	$code .= "<p>";
	
	//-----ASPECTOS PSICOSSOCIAIS
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$code .= "<tr>";
    $code .= "<td class='text' align=left><b>Aspectos Psicissociais</b></td>";
	$code .= "</tr>";
	$code .= "</table>";
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$code .= "<tr>";
    $code .= "<td align=left width=10%><b>&nbsp;</b></td>";
	$code .= "<td align=center colspan=2 width=40%><b>Antecipa��o do Risco</b></td>";
	$code .= "<td align=center width=25%><b>Prioriza��o do Risco</b></td>";
	$code .= "<td align=center colspan=2 width=25%><b>Conduta Ergon�mica</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=center >Equipe</td>";
	$code .= "<td align=center width=13%>Caracteriza��o</td>";
	$code .= "<td align=center width=27%>Fonte Geradora</td>";
	$code .= "<td align=center >Meio de Controle Existente</td>";
	$code .= "<td align=center width=12%>Sintoma</td>";
	$code .= "<td align=center width=13%>Medida de Controle no Trabalhador</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=center >Treinamento</td>";
	$code .= "<td align=center >N/H</td>";
	$code .= "<td align=center >N/H</td>";
	$code .= "<td align=center >N/H</td>";
	$code .= "<td align=center >N/H</td>";
	$code .= "<td align=center >N/H</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=center >Potencial</td>";
	$code .= "<td align=center >N/H</td>";
	$code .= "<td align=center >N/H</td>";
	$code .= "<td align=center >N/H</td>";
	$code .= "<td align=center >N/H</td>";
	$code .= "<td align=center >N/H</td>";
	$code .= "</tr>";
	
	$code .= "</table>";
	
	$code .= "<p align='justify'>";
	
	$code .= "<b>Conclus�o e Considera��es:</b> A avalia��o classificou como moderado o risco caracterizando assim toler�vel em todos os t�picos.<br>";
	$code .= "<b>Concep��o:</b> Recomenda-se que se fa�am as implementa��es para redu��o dos riscos.";

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
        
		$code .= "<br><p>";
        $code .= "<div class='mainTitle' align=center><center><b>ANEXO<BR>POSTO DE SERVI�O</b></center></div>";
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
        $code .= "<td>Fax: </td><td>$ptinfo[fax]</td>";
        $code .= "</tr><tr>";
        $code .= "<td>CNPJ/CEI: </td><td>$ptinfo[cnpj]</td>";
        $code .= "</tr>";
        $code .= "</table>";

        $code .= "<div class='pagebreak'></div>";
		
		$avali = "SELECT s.cod_setor, s.nome_setor, ed.descricao, cs.tipo_setor, info.jornada, cs.epc_existente, cs.h_melhoria, cs.h_acidente,
		cs.foto, cs.equip_util, cs.fer_util, cs.carga_manu, cs.ativ_rotina, cs.verba
		FROM cliente_setor cs, setor s, tipo_edificacao ed, cgrt_info info 
		WHERE id_ppra = $cod_cgrt AND cs.cod_setor = s.cod_setor AND cod_edificacao = ed.tipo_edificacao_id 
		AND id_ppra = cod_cgrt AND cs.is_posto_trabalho = 1";
		$ava = pg_query($avali);
		$avl = pg_fetch_all($ava);
		
		for($x=0;$x<pg_num_rows($ava);$x++){
		$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
		$code .= "<tr>";
		$code .= "<td class='bgtitle' align=center colspan=2><b>Avalia��o Preliminar e Gerenciamento de Riscos Ergon�micos $info[ano]</b></td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center colspan=2><b>Identifica��o e An�lise</b></td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Instala��o:</b></td>";
		$code .= "<td align=left width=75%>{$avl[$x][descricao]}</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Setor:</b></td>";
		$code .= "<td align=left width=75%>{$avl[$x][nome_setor]}</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		
		$funcao = "SELECT fu.*, f.*
			FROM funcao fu, funcionarios f, cgrt_func_list cgrt
			WHERE fu.cod_funcao = f.cod_funcao AND f.cod_func = cgrt.cod_func AND cod_cgrt = $cod_cgrt 
			AND f.cod_setor = {$avl[$x][cod_setor]} AND f.cod_cliente = cgrt.cod_cliente";
		$func = pg_query($funcao);
		$fff = pg_fetch_all($func);
		
		$code .= "<td align=left width=25%><b>Fun��o:</b></td>";
		$code .= "<td align=left width=75%>"; 
			for($w=0;$w<pg_num_rows($func);$w++){
				$code .= "{$fff[$w][nome_funcao]}; ";
			}
		$code .= "</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>N� de Funcion�rios:</b></td>";
		$code .= "<td align=left width=75%>".str_pad(pg_num_rows($func), 2, "0", 0)."</td>";
		$code .= "</tr>";
		
		$habil = "SELECT DISTINCT(habilidade) 
			FROM funcionarios f, cgrt_func_list cl 
			WHERE f.cod_func = cl.cod_func AND cl.cod_cgrt = $cod_cgrt AND f.cod_setor = {$avl[$x][cod_setor]}
			AND f.cod_cliente = cl.cod_cliente";
		$habilit = pg_query($habil);
		$hab = pg_fetch_array($habilit);
		
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Exig�ncias/Habilidades Necess�rias:</b></td>";
		$code .= "<td align=left width=75%>{$hab[habilidade]}</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Tipo de Atividade:</b></td>";
		$code .= "<td align=left width=75%>{$avl[$x][tipo_setor]}</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Din�mica da Atividade:</b></td>";
		$code .= "<td align=justify width=75%>"; 
			for($w=0;$w<pg_num_rows($func);$w++){
				$code .= "{$fff[$w][dsc_funcao]}";
			}
		$code .= "</td>";
		$code .= "</tr>";
		
		$sql = "SELECT se.descricao FROM sugestao s, setor_epi se, setor st
			WHERE (s.med_prev = se.id AND s.cod_setor = st.cod_setor AND se.cod_setor = s.cod_setor
			AND s.cod_setor = {$avl[$x][cod_setor]})
			AND s.tipo_med_prev = 0 AND s.plano_acao = 0 AND s.id_ppra = $cod_cgrt";
			$r_s_e = pg_query($sql);
			$sugestao_setor_epi = pg_fetch_all($r_s_e);
			
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>EPI/EPC Utilizados:</b></td>";
		$code .= "<td align=justify width=75%>{$avl[$x][epc_existente]}; ";
			for($y=0;$y<pg_num_rows($r_s_e);$y++){
				$code .= "{$sugestao_setor_epi[$y][descricao]}; ";
			}
		$code .= "</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Alvo da Avalia��o:</b></td>";
		$code .= "<td align=left width=75%>{$avl[$x][descricao]}</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Historico de Melhoria:</b></td>";
		$code .= "<td align=left width=75%>{$avl[$x][h_melhoria]}</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Historico de Acidentes:</b></td>";
		$code .= "<td align=left width=75%>{$avl[$x][h_acidente]}</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Jornada de Trabalho:</b></td>";
		$code .= "<td align=left width=75%>{$avl[$x][jornada]}</td>";
		$code .= "</tr>";
		$code .= "</table>";
		
		$sql = "SELECT ag.nome_agente_risco, r.dsc_agente, r.diagnostico, r.fonte_geradora, r.preventiva, tr.cod_tipo_risco
				FROM setor s, risco_setor r, cliente_setor c, agente_risco ag, tipo_risco tr
				WHERE r.cod_cliente = c.cod_cliente AND r.cod_setor = c.cod_setor AND r.cod_setor = s.cod_setor
				AND c.id_ppra = r.id_ppra AND c.id_ppra = $cod_cgrt AND c.cod_setor = {$avl[$x][cod_setor]}
				AND ag.cod_tipo_risco = tr.cod_tipo_risco AND r.cod_agente_risco = ag.cod_agente_risco AND tr.cod_tipo_risco = 4";
		$rag = pg_query($sql);
		$sagent = pg_fetch_all($rag);
			
		$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
		$code .= "<tr>";
		$code .= "<td class='bgtitle' align=center colspan=2><b>Mem�ria Fotogr�fica</b></td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center width=30% rowspan=2>";
			$code .= "<div id=foto><img src='../../../../{$avl[$x][foto]}' border=0 width=200 height=200></div>";
		$code .= "</td>";
		$code .= "<td align=left width=70%><b>Agente: </b>";
			for($z=0;$z<pg_num_rows($rag);$z++){
				$code .= "{$sagent[$z][nome_agente_risco]}; ";
			}
		$code .= "</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left><b>Descri��o: </b>";
			for($z=0;$z<pg_num_rows($rag);$z++){
				$code .= "{$sagent[$z][dsc_agente]}; ";
			}
		$code .= "</td>";
		$code .= "</tr>";
		$code .= "</table>";
		
		$code .= "<div class='pagebreak'></div>";
		
		/************************************************************************************************************/
		// -> AVALIA��O PRELIMINAR 2� PARTE
		/************************************************************************************************************/
		$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
		$code .= "<tr>";
		$code .= "<td class='bgtitle' align=center colspan=2><b>Hist�rico</b></td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Instala��o:</b></td>";
		$code .= "<td align=left width=75%>{$avl[$x][descricao]}</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>M�quina e Equip. Utilizados:</b></td>";
		$code .= "<td align=left width=75%>{$avl[$x][equip_util]}</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Ferramentas Utilizadas:</b></td>";
		$code .= "<td align=left width=75%>{$avl[$x][fer_util]}</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Materiais e Cargas Manuseadas:</b></td>";
		$code .= "<td align=left width=75%>{$avl[$x][carga_manu]}</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Atividade Rotineira:</b></td>";
		$code .= "<td align=left width=75%>{$avl[$x][ativ_rotina]}</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Verbaliza��o Principal:</b></td>";
		$code .= "<td align=left width=75%>{$avl[$x][verba]}</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Objetivo da Avalia��o:</b></td>";
		$code .= "<td align=left width=75%>Possibilitar a corre��o do ambiente de trabalho e melhorar as condi��es de trabalho</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Data da Avalia��o:</b></td>";
		$code .= "<td align=left width=75%>&nbsp;</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Data da Pr�xima Revis�o:</b></td>";
		$code .= "<td align=left width=75%>&nbsp;</td>";
		$code .= "</tr>";
		$code .= "</table>";
		
		$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
		$code .= "<tr>";
		$code .= "<td class='bgtitle' align=center colspan=6><b>An�lise Pr�-Ativa de Riscos Ergon�micos</b></td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center width=15%><b>Agente</b></td>";
		$code .= "<td align=center width=17%><b>Caracteriza��o</b></td>";
		$code .= "<td align=center width=17%><b>Risco</b></td>";
		$code .= "<td align=center width=17%><b>Prioriza��o do Risco</b></td>";
		$code .= "<td align=center width=17%><b>Provid�ncias</b></td>";
		$code .= "<td align=center width=17%><b>Provid�ncia Ergon�mica</b></td>";
		$code .= "</tr>";
		for($z=0;$z<pg_num_rows($rag);$z++){
			if($sagent[$z][cod_tipo_risco] == 4){
				$code .= "<tr>";
				$code .= "<td align=center>{$sagent[$z][nome_agente_risco]}&nbsp;</td>";
				$code .= "<td align=center>{$sagent[$z][fonte_geradora]}&nbsp;</td>";
				$code .= "<td align=center>{$sagent[$z][diagnostico]}&nbsp;</td>";
				$code .= "<td align=center>{$sagent[$z][diagnostico]}&nbsp;</td>";
				$code .= "<td align=center>{$sagent[$z][preventiva]}&nbsp;</td>";
				$code .= "<td align=center>{$sagent[$z][preventiva]}&nbsp;</td>";
				$code .= "</tr>";
			}else{
				$code .= "<tr>";
				$code .= "<td align=center>&nbsp;</td>";
				$code .= "<td align=center>&nbsp;</td>";
				$code .= "<td align=center>&nbsp;</td>";
				$code .= "<td align=center>&nbsp;</td>";
				$code .= "<td align=center>&nbsp;</td>";
				$code .= "<td align=center>&nbsp;</td>";
				$code .= "</tr>";
			}
		}
		$code .= "</table>";
	
		$code .= "<div class='pagebreak'></div>";
	
		/************************************************************************************************************/
		// -> AVALIA��O PRELIMINAR 3� PARTE
		/************************************************************************************************************/
		//---------ERGON�MIA
		$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
		$code .= "<tr>";
		$code .= "<td class='text' align=left><b>Ergon�mia Risco Analisado</b></td>";
		$code .= "</tr>";
		$code .= "</table>";
		$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
		$code .= "<tr>";
		$code .= "<td align=left width=10%><b>&nbsp;</b></td>";
		$code .= "<td align=center colspan=2 width=40%><b>Antecipa��o do Risco</b></td>";
		$code .= "<td align=center width=25%><b>Prioriza��o do Risco</b></td>";
		$code .= "<td align=center colspan=2 width=25%><b>Conduta Ergon�mica</b></td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center >Agente</td>";
		$code .= "<td align=center width=13%>Causa</td>";
		$code .= "<td align=center width=27%>Sintomas</td>";
		$code .= "<td align=center >A��es e Medidas</td>";
		$code .= "<td align=center width=12%>Provid�ncias</td>";
		$code .= "<td align=center width=13%>Medidas Adicionais</td>";
		$code .= "</tr>";
		
		$sql = "SELECT c.*, r.dsc_agente, r.diagnostico, r.fonte_geradora as fonte, r.preventiva, tr.cod_tipo_risco, tr.nome_tipo_risco
				FROM setor s, risco_setor r, cliente_setor c, agente_risco ag, tipo_risco tr
				WHERE r.cod_cliente = c.cod_cliente AND r.cod_setor = c.cod_setor AND r.cod_setor = s.cod_setor
				AND c.id_ppra = r.id_ppra AND c.id_ppra = $cod_cgrt AND c.cod_setor = {$avl[$x][cod_setor]}
				AND ag.cod_tipo_risco = tr.cod_tipo_risco AND r.cod_agente_risco = ag.cod_agente_risco ";
		$r_ag = pg_query($sql);
		$s_agent = pg_fetch_all($r_ag);
		
		for($z=0;$z<pg_num_rows($r_ag);$z++){
			$code .= "<tr>";
			$code .= "<td align=center>{$s_agent[$z][nome_tipo_risco]}&nbsp;</td>";
			$code .= "<td align=center>{$s_agent[$z][fonte]}&nbsp;</td>";
			$code .= "<td align=center>{$s_agent[$z][diagnostico]}&nbsp;</td>";
			$code .= "<td align=center>{$s_agent[$z][diagnostico]}&nbsp;</td>";
			$code .= "<td align=center>{$s_agent[$z][preventiva]}&nbsp;</td>";
			$code .= "<td align=center>{$s_agent[$z][preventiva]}&nbsp;</td>";
			$code .= "</tr>";
		}
		$code .= "</table>";
		
		$code .= "<p>";
		
		//-----AMBIENTE
		$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
		$code .= "<tr>";
		$code .= "<td class='text' align=left><b>Ambiente</b></td>";
		$code .= "</tr>";
		$code .= "</table>";
		$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
		$code .= "<tr>";
		$code .= "<td align=left width=10%><b>&nbsp;</b></td>";
		$code .= "<td align=center colspan=2 width=40%><b>Antecipa��o do Risco</b></td>";
		$code .= "<td align=center width=25%><b>Prioriza��o do Risco</b></td>";
		$code .= "<td align=center colspan=2 width=25%><b>Conduta Ergon�mica</b></td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center >Agente</td>";
		$code .= "<td align=center width=13%>Caracteriza��o</td>";
		$code .= "<td align=center width=27%>Sintomas</td>";
		$code .= "<td align=center >Meio de Controle Existente</td>";
		$code .= "<td align=center width=12%>Fonte Geradora</td>";
		$code .= "<td align=center width=13%>Medida de Controle no Trabalhador</td>";
		$code .= "</tr>";
		
		$sql = "select lux_recomendado, (sum( cast( cast(lux_atual as text) as integer) ) / 
				(select count(*) from iluminacao_ppra where id_ppra = $cod_cgrt and cod_setor = {$avl[$x][cod_setor]}) ) as t
				from iluminacao_ppra where id_ppra = $cod_cgrt and cod_setor = {$avl[$x][cod_setor]} group by lux_recomendado";
		$ilu = pg_query($sql);
		$alu = pg_fetch_array($ilu);
		
		$code .= "<tr>";
		$code .= "<td align=center>Ilumin�ncia</td>";
			if($alu[t] < $alu[lux_recomendado]){
				$code .= "<td align=center>Abaixo do limite permitido</td>";
				$code .= "<td align=center>Dores de cabe�a</td>";
				$code .= "<td align=center>N/H</td>";
				$code .= "<td align=center>Pouca ilumina��o</td>";
				$code .= "<td align=center>Fazer o dimensionamento da ilumina��o</td>";
			}elseif ($alu[t] >= $alu[lux_recomendado] && $alu[t] <=1000){
				$code .= "<td align=center>Desprezivel</td>";
				$code .= "<td align=center>N/H</td>";
				$code .= "<td align=center>N/H</td>";
				$code .= "<td align=center>N/H</td>";
				$code .= "<td align=center>N/H</td>";
			}elseif($alu[t] > 1000){
				$code .= "<td align=center>Acima do limite permitido</td>";
				$code .= "<td align=center>N/H</td>";
				$code .= "<td align=center>N/H</td>";
				$code .= "<td align=center>N/H</td>";
				$code .= "<td align=center>N/H</td>";
			}else{
				$code .= "&nbsp;";
			}
		$code .= "</tr>";
			
		$sql = "SELECT c.*, r.dsc_agente, r.diagnostico, r.fonte_geradora as geradora, r.acao_necessaria, ag.cod_tipo_risco, tr.nome_tipo_risco, ag.cod_agente_risco
				FROM setor s, risco_setor r, cliente_setor c, agente_risco ag, tipo_risco tr
				WHERE r.cod_cliente = c.cod_cliente AND r.cod_setor = c.cod_setor AND r.cod_setor = s.cod_setor
				AND c.id_ppra = r.id_ppra AND c.id_ppra = $cod_cgrt AND c.cod_setor = {$avl[$x][cod_setor]}
				AND ag.cod_tipo_risco = tr.cod_tipo_risco AND r.cod_agente_risco = ag.cod_agente_risco ";
		$tcl = pg_query($sql);
		$ctrl = pg_fetch_array($tcl);
			
		$code .= "<tr>";
		$code .= "<td align=center>Temperatura</td>";
		if($ctrl[caracterizacao] != ''){
			$code .= "<td align=center>{$ctrl[caracterizacao]}</td>";
			$code .= "<td align=center>{$ctrl[sintoma]}</td>";
			$code .= "<td align=center>{$ctrl[m_ctr_existente]}</td>";
			$code .= "<td align=center>{$ctrl[fonte_geradora]}</td>";
			$code .= "<td align=center>{$ctrl[m_ctr_trabalhador]}</td>";
		}else{
			$code .= "<td align=center>Desprez�vel</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
		}
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center>Ru�do</td>";
		if($ctrl[ruido_operacao_setor] > '85.00' && $ctrl[cod_tipo_risco] == 1){
			$code .= "<td align=center>Acima do Limite</td>";
			$code .= "<td align=center>{$ctrl[diagnostico]}&nbsp;</td>";
			$code .= "<td align=center>{$ctrl[diagnostico]}&nbsp;</td>";
			$code .= "<td align=center>{$ctrl[geradora]}&nbsp;</td>";
			$code .= "<td align=center>Uso de Protetor Auricular</td>";
		}else{
			$code .= "<td align=center>Desprez�vel</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
		}
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center>Ventila��o</td>";
		if($ctrl[cod_vent_art] == 3 and $ctrl[cod_parede] == 1){
			$code .= "<td align=center>Ambiente abafado</td>";
			$code .= "<td align=center>Mal estar</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>Ambiente abafado</td>";
			$code .= "<td align=center>Instalar ar-condicionado ou circulador de ar</td>";
		}else{
			$code .= "<td align=center>Desprez�vel</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
		}
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center>Presen�a Qu�mica</td>";
		$quimica = "SELECT c.*, r.dsc_agente, r.diagnostico, r.fonte_geradora as fonte, r.acao_necessaria, ag.cod_agente_risco, tr.cod_tipo_risco, tr.nome_tipo_risco
				FROM setor s, risco_setor r, cliente_setor c, agente_risco ag, tipo_risco tr
				WHERE r.cod_cliente = c.cod_cliente AND r.cod_setor = c.cod_setor AND r.cod_setor = s.cod_setor
				AND c.id_ppra = r.id_ppra AND c.id_ppra = $cod_cgrt AND c.cod_setor = {$avl[$x][cod_setor]}
				AND ag.cod_tipo_risco = tr.cod_tipo_risco AND r.cod_agente_risco = ag.cod_agente_risco and tr.cod_tipo_risco = 2";
		$quimi = pg_query($quimica);
		$qmc = pg_fetch_array($quimi);
		
		if($qmc[cod_tipo_risco] == 2){
			$code .= "<td align=center>Sim</td>";
			$code .= "<td align=center>{$qmc[diagnostico]}&nbsp;</td>";
			$code .= "<td align=center>EPI</td>";
			$code .= "<td align=center>{$qmc[fonte]}&nbsp;</td>";
			$code .= "<td align=center>{$qmc[acao_necessaria]}&nbsp;</td>";
		}else{
			$code .= "<td align=center>N�o</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
		}
		$code .= "</tr>";
		
		$code .= "<tr>";
		$code .= "<td align=center>Vibra��o</td>";
		$vibracao = "SELECT c.*, r.dsc_agente, r.diagnostico, r.fonte_geradora as fonte, r.acao_necessaria, ag.cod_agente_risco, tr.cod_tipo_risco, tr.nome_tipo_risco
				FROM setor s, risco_setor r, cliente_setor c, agente_risco ag, tipo_risco tr
				WHERE r.cod_cliente = c.cod_cliente AND r.cod_setor = c.cod_setor AND r.cod_setor = s.cod_setor
				AND c.id_ppra = r.id_ppra AND c.id_ppra = $cod_cgrt AND c.cod_setor = {$avl[$x][cod_setor]}
				AND ag.cod_tipo_risco = tr.cod_tipo_risco AND r.cod_agente_risco = ag.cod_agente_risco and ag.cod_agente_risco = 6";
		$vibra = pg_query($vibracao);
		$vbd = pg_fetch_array($vibra);
		
		if($vbd[cod_agente_risco] == 6){
			$code .= "<td align=center>Sim</td>";
			$code .= "<td align=center>{$vbd[diagnostico]}&nbsp;</td>";
			$code .= "<td align=center>EPI</td>";
			$code .= "<td align=center>{$vbd[fonte]}&nbsp;</td>";
			$code .= "<td align=center>{$vbd[acao_necessaria]}&nbsp;</td>";
		}else{
			$code .= "<td align=center>N�o</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
		}
		$code .= "</tr>";
		
		$code .= "<tr>";
		$code .= "<td align=center>Radia��o Ionizante</td>";
		$radiacao_io = "SELECT c.*, r.dsc_agente, r.diagnostico, r.fonte_geradora as fonte, r.acao_necessaria, ag.cod_agente_risco, tr.cod_tipo_risco, tr.nome_tipo_risco
				FROM setor s, risco_setor r, cliente_setor c, agente_risco ag, tipo_risco tr
				WHERE r.cod_cliente = c.cod_cliente AND r.cod_setor = c.cod_setor AND r.cod_setor = s.cod_setor
				AND c.id_ppra = r.id_ppra AND c.id_ppra = $cod_cgrt AND c.cod_setor = {$avl[$x][cod_setor]}
				AND ag.cod_tipo_risco = tr.cod_tipo_risco AND r.cod_agente_risco = ag.cod_agente_risco and ag.cod_agente_risco = 11";
		$radiacao = pg_query($radiacao_io);
		$ionizante = pg_fetch_array($radiacao);
		
		if($ionizante[cod_agente_risco] == 11){
			$code .= "<td align=center>Sim</td>";
			$code .= "<td align=center>{$ionizante[diagnostico]}&nbsp;</td>";
			$code .= "<td align=center>EPI</td>";
			$code .= "<td align=center>{$ionizante[fonte]}&nbsp;</td>";
			$code .= "<td align=center>{$ionizante[acao_necessaria]}&nbsp;</td>";
		}else{
			$code .= "<td align=center>N�o</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
		}
		$code .= "</tr>";
		
		$code .= "<tr>";
		$code .= "<td align=center>Radia��o n�o Ionizante</td>";
		$radiacao_n = "SELECT c.*, r.dsc_agente, r.diagnostico, r.fonte_geradora as fonte, r.acao_necessaria, ag.cod_agente_risco, tr.cod_tipo_risco, tr.nome_tipo_risco
				FROM setor s, risco_setor r, cliente_setor c, agente_risco ag, tipo_risco tr
				WHERE r.cod_cliente = c.cod_cliente AND r.cod_setor = c.cod_setor AND r.cod_setor = s.cod_setor
				AND c.id_ppra = r.id_ppra AND c.id_ppra = $cod_cgrt AND c.cod_setor = {$avl[$x][cod_setor]}
				AND ag.cod_tipo_risco = tr.cod_tipo_risco AND r.cod_agente_risco = ag.cod_agente_risco and ag.cod_agente_risco = 16";
		$n_radi = pg_query($radiacao_n);
		$nao = pg_fetch_array($n_radi);
		
		if($nao[cod_agente_risco] == 16){
			$code .= "<td align=center>Sim</td>";
			$code .= "<td align=center>{$nao[diagnostico]}&nbsp;</td>";
			$code .= "<td align=center>EPI</td>";
			$code .= "<td align=center>{$nao[fonte]}&nbsp;</td>";
			$code .= "<td align=center>{$nao[acao_necessaria]}&nbsp;</td>";
		}else{
			$code .= "<td align=center>N�o</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
		}
		$code .= "</tr>";
		
		$code .= "</table>";
		
		$code .= "<p>";
		
		//-----CARGA FISIOL�GICA
		$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
		$code .= "<tr>";
		$code .= "<td class='text' align=left><b>Carga Fisiol�gica</b></td>";
		$code .= "</tr>";
		$code .= "</table>";
		$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
		$code .= "<tr>";
		$code .= "<td align=left width=10%><b>&nbsp;</b></td>";
		$code .= "<td align=center colspan=2 width=40%><b>Antecipa��o do Risco</b></td>";
		$code .= "<td align=center width=25%><b>Prioriza��o do Risco</b></td>";
		$code .= "<td align=center colspan=2 width=25%><b>Conduta Ergon�mica</b></td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center >Gasto Energ�tico</td>";
		$code .= "<td align=center width=13%>Caracteriza��o</td>";
		$code .= "<td align=center width=27%>Fonte Geradora</td>";
		$code .= "<td align=center >Meio de Controle Existente</td>";
		$code .= "<td align=center width=12%>Sintoma</td>";
		$code .= "<td align=center width=13%>Medida de Controle no Trabalhador</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center >Manuseio de Carga</td>";
		if($ctrl[m_carga] == '' || $ctrl[m_carga] == 'n�o'){
			$code .= "<td align=center >N�o</td>";
			$code .= "<td align=center >N/H</td>";
			$code .= "<td align=center >N/H</td>";
			$code .= "<td align=center >N/H</td>";
			$code .= "<td align=center >N/H</td>";
		}else{
			$code .= "<td align=center >Sim</td>";
			$code .= "<td align=center >Queda</td>";
			$code .= "<td align=center >EPI/EPC</td>";
			$code .= "<td align=center >Traumas</td>";
			$code .= "<td align=center >EPI/EPC</td>";
		}
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center >Deslocamento</td>";
		if($ctrl[desloc] == '' || $ctrl[desloc] == 'n�o'){
			$code .= "<td align=center >N�o</td>";
			$code .= "<td align=center >N/H</td>";
			$code .= "<td align=center >N/H</td>";
			$code .= "<td align=center >N/H</td>";
			$code .= "<td align=center >N/H</td>";
		}else{
			$code .= "<td align=center >Sim</td>";
			$code .= "<td align=center >Queda</td>";
			$code .= "<td align=center >EPI/EPC</td>";
			$code .= "<td align=center >Traumas</td>";
			$code .= "<td align=center >EPI/EPC</td>";
		}
		$code .= "</tr>";
		
		$pavi = "select n_pavimentos from cgrt_info where cod_cgrt = $cod_cgrt ";
		$pav = pg_query($pavi);
		$pvm = pg_fetch_array($pav);
		
		$code .= "<tr>";
		$code .= "<td align=center >Uso de Escadas</td>";
		if($pvm[n_pavimentos] > 1){
			$code .= "<td align=center >Sim</td>";
			$code .= "<td align=center >Queda</td>";
			$code .= "<td align=center >EPI/EPC</td>";
			$code .= "<td align=center >Traumas</td>";
			$code .= "<td align=center >EPI/EPC</td>";
		}else{
			$code .= "<td align=center >N�o</td>";
			$code .= "<td align=center >N/H</td>";
			$code .= "<td align=center >N/H</td>";
			$code .= "<td align=center >N/H</td>";
			$code .= "<td align=center >N/H</td>";
		}
		$code .= "</tr>";
		
		$code .= "</table>";
		
		$code .= "<p>";
		
		//-----CARGA MENTAL
		$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
		$code .= "<tr>";
		$code .= "<td class='text' align=left><b>Carga Mental</b></td>";
		$code .= "</tr>";
		$code .= "</table>";
		$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
		$code .= "<tr>";
		$code .= "<td align=left width=10%><b>&nbsp;</b></td>";
		$code .= "<td align=center colspan=2 width=40%><b>Antecipa��o do Risco</b></td>";
		$code .= "<td align=center width=25%><b>Prioriza��o do Risco</b></td>";
		$code .= "<td align=center colspan=2 width=25%><b>Conduta Ergon�mica</b></td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center >Organiza��o</td>";
		$code .= "<td align=center width=13%>Caracteriza��o</td>";
		$code .= "<td align=center width=27%>Fonte Geradora</td>";
		$code .= "<td align=center >Meio de Controle Existente</td>";
		$code .= "<td align=center width=12%>Sintoma</td>";
		$code .= "<td align=center width=13%>Medida de Controle no Trabalhador</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center > </td>";
		$code .= "<td align=center >Ritmo da produtividade</td>";
		$code .= "<td align=center >Atividade realizada</td>";
		$code .= "<td align=center >Altern�ncia do quadro de hor�rio</td>";
		$code .= "<td align=center >Stress mental</td>";
		$code .= "<td align=center >Altern�ncia do quadro de hor�rio</td>";
		$code .= "</tr>";
		
		$code .= "</table>";
		
		$code .= "<p>";
		
		//-----ASPECTOS PSICOSSOCIAIS
		$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
		$code .= "<tr>";
		$code .= "<td class='text' align=left><b>Aspectos Psicissociais</b></td>";
		$code .= "</tr>";
		$code .= "</table>";
		$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
		$code .= "<tr>";
		$code .= "<td align=left width=10%><b>&nbsp;</b></td>";
		$code .= "<td align=center colspan=2 width=40%><b>Antecipa��o do Risco</b></td>";
		$code .= "<td align=center width=25%><b>Prioriza��o do Risco</b></td>";
		$code .= "<td align=center colspan=2 width=25%><b>Conduta Ergon�mica</b></td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center >Equipe</td>";
		$code .= "<td align=center width=13%>Caracteriza��o</td>";
		$code .= "<td align=center width=27%>Fonte Geradora</td>";
		$code .= "<td align=center >Meio de Controle Existente</td>";
		$code .= "<td align=center width=12%>Sintoma</td>";
		$code .= "<td align=center width=13%>Medida de Controle no Trabalhador</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center >Treinamento</td>";
		$code .= "<td align=center >N/H</td>";
		$code .= "<td align=center >N/H</td>";
		$code .= "<td align=center >N/H</td>";
		$code .= "<td align=center >N/H</td>";
		$code .= "<td align=center >N/H</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center >Potencial</td>";
		$code .= "<td align=center >N/H</td>";
		$code .= "<td align=center >N/H</td>";
		$code .= "<td align=center >N/H</td>";
		$code .= "<td align=center >N/H</td>";
		$code .= "<td align=center >N/H</td>";
		$code .= "</tr>";
		
		$code .= "</table>";
		
		$code .= "<p align='justify'>";
		
		$code .= "<b>Conclus�o e Considera��es:</b> A avalia��o classificou como moderado o risco caracterizando assim toler�vel em todos os t�picos.<br>";
		$code .= "<b>Concep��o:</b> Recomenda-se que se fa�am as implementa��es para redu��o dos riscos.";
	
		$code .= "<div class='pagebreak'></div>";
		
		}
	}
/****************************************************************************************************************/
// -> PAGE [13] --> HISTOGRAMA
/****************************************************************************************************************/
	$histo = "SELECT * FROM histograma WHERE cod_cgrt = $cod_cgrt";
	$hist = pg_query($histo);
	$hh = pg_fetch_array($hist);
	
	$code .= "<table align=center width=98% cellspacing=0 cellpadding=0 border=0 >";
	$code .= "<tr>";
	if($hh[dimensoes] == 1){ $code .= "<td align=center height=350 valign=bottom >100%<table border=0><tr><td width=25 height=320 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[dimensoes] == 2){ $code .= "<td align=center height=350 valign=bottom >85%<table border=0><tr><td width=25 height=282 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[dimensoes] == 3){ $code .= "<td align=center height=350 valign=bottom >55%<table border=0><tr><td width=25 height=180 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[dimensoes] == 4){ $code .= "<td align=center height=350 valign=bottom >35%<table border=0><tr><td width=25 height=112 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[dimensoes] == 5){ $code .= "<td align=center height=350 valign=bottom >15%<table border=0><tr><td width=25 height=50 bgcolor=#000000></td></tr></table></td>";}
	if($hh[postura] == 1){ $code .= "<td align=center valign=bottom >100%<table border=0><tr><td width=25 height=320 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[postura] == 2){ $code .= "<td align=center valign=bottom >80%<table border=0><tr><td width=25 height=265 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[postura] == 3){ $code .= "<td align=center valign=bottom >60%<table border=0><tr><td width=25 height=195 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[postura] == 4){ $code .= "<td align=center valign=bottom >40%<table border=0><tr><td width=25 height=130 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[postura] == 5){ $code .= "<td align=center valign=bottom >25%<table border=0><tr><td width=25 height=82 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[postura] == 6){ $code .= "<td align=center valign=bottom >5%<table border=0><tr><td width=25 height=18 bgcolor=#000000></td></tr></table></td>";}
	if($hh[ferramenta] == 1){ $code .= "<td align=center valign=bottom >100%<table border=0><tr><td width=25 height=320 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[ferramenta] == 2){ $code .= "<td align=center valign=bottom >80%<table border=0><tr><td width=25 height=265 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[ferramenta] == 3){ $code .= "<td align=center valign=bottom >60%<table border=0><tr><td width=25 height=195 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[ferramenta] == 4){ $code .= "<td align=center valign=bottom >40%<table border=0><tr><td width=25 height=130 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[ferramenta] == 5){ $code .= "<td align=center valign=bottom >25%<table border=0><tr><td width=25 height=82 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[ferramenta] == 6){ $code .= "<td align=center valign=bottom >5%<table border=0><tr><td width=25 height=18 bgcolor=#000000></td></tr></table></td>";}
	if($hh[maquina] == 1){ $code .= "<td align=center valign=bottom >100%<table border=0><tr><td width=25 height=320 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[maquina] == 2){ $code .= "<td align=center valign=bottom >80%<table border=0><tr><td width=25 height=265 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[maquina] == 3){ $code .= "<td align=center valign=bottom >60%<table border=0><tr><td width=25 height=195 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[maquina] == 4){ $code .= "<td align=center valign=bottom >40%<table border=0><tr><td width=25 height=130 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[maquina] == 5){ $code .= "<td align=center valign=bottom >25%<table border=0><tr><td width=25 height=82 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[maquina] == 6){ $code .= "<td align=center valign=bottom >5%<table border=0><tr><td width=25 height=18 bgcolor=#000000></td></tr></table></td>";}
	if($hh[prevencao] == 1){ $code .= "<td align=center valign=bottom >100%<table border=0><tr><td width=25 height=320 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[prevencao] == 2){ $code .= "<td align=center valign=bottom >90%<table border=0><tr><td width=25 height=300 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[prevencao] == 3){ $code .= "<td align=center valign=bottom >75%<table border=0><tr><td width=25 height=247 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[prevencao] == 4){ $code .= "<td align=center valign=bottom >50%<table border=0><tr><td width=25 height=165 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[prevencao] == 5){ $code .= "<td align=center valign=bottom >35%<table border=0><tr><td width=25 height=112 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[prevencao] == 6){ $code .= "<td align=center valign=bottom >25%<table border=0><tr><td width=25 height=82 bgcolor=#000000></td></tr></table></td>";}
	
	if($hh[ventilacao] == 1){ $code .= "<td align=center valign=bottom >100%<table border=0><tr><td width=25 height=320 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[ventilacao] == 2){ $code .= "<td align=center valign=bottom >85%<table border=0><tr><td width=25 height=282 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[ventilacao] == 3){ $code .= "<td align=center valign=bottom >65%<table border=0><tr><td width=25 height=212 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[ventilacao] == 4){ $code .= "<td align=center valign=bottom >40%<table border=0><tr><td width=25 height=130 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[ventilacao] == 5){ $code .= "<td align=center valign=bottom >25%<table border=0><tr><td width=25 height=82 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[ventilacao] == 6){ $code .= "<td align=center valign=bottom >15%<table border=0><tr><td width=25 height=50 bgcolor=#000000></td></tr></table></td>";}
	if($hh[temperatura] == 1){ $code .= "<td align=center valign=bottom >100%<table border=0><tr><td width=25 height=320 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[temperatura] == 2){ $code .= "<td align=center valign=bottom >85%<table border=0><tr><td width=25 height=282 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[temperatura] == 3){ $code .= "<td align=center valign=bottom >65%<table border=0><tr><td width=25 height=212 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[temperatura] == 4){ $code .= "<td align=center valign=bottom >40%<table border=0><tr><td width=25 height=130 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[temperatura] == 5){ $code .= "<td align=center valign=bottom >25%<table border=0><tr><td width=25 height=82 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[temperatura] == 6){ $code .= "<td align=center valign=bottom >15%<table border=0><tr><td width=25 height=50 bgcolor=#000000></td></tr></table></td>";}
	if($hh[ruido] == 1){ $code .= "<td align=center valign=bottom >100%<table border=0><tr><td width=25 height=320 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[ruido] == 2){ $code .= "<td align=center valign=bottom >85%<table border=0><tr><td width=25 height=282 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[ruido] == 3){ $code .= "<td align=center valign=bottom >65%<table border=0><tr><td width=25 height=212 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[ruido] == 4){ $code .= "<td align=center valign=bottom >40%<table border=0><tr><td width=25 height=130 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[ruido] == 5){ $code .= "<td align=center valign=bottom >25%<table border=0><tr><td width=25 height=82 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[ruido] == 6){ $code .= "<td align=center valign=bottom >15%<table border=0><tr><td width=25 height=50 bgcolor=#000000></td></tr></table></td>";}
	if($hh[higiene] == 1){ $code .= "<td align=center valign=bottom >100%<table border=0><tr><td width=25 height=320 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[higiene] == 2){ $code .= "<td align=center valign=bottom >85%<table border=0><tr><td width=25 height=282 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[higiene] == 3){ $code .= "<td align=center valign=bottom >65%<table border=0><tr><td width=25 height=212 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[higiene] == 4){ $code .= "<td align=center valign=bottom >40%<table border=0><tr><td width=25 height=130 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[higiene] == 5){ $code .= "<td align=center valign=bottom >25%<table border=0><tr><td width=25 height=82 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[higiene] == 6){ $code .= "<td align=center valign=bottom >15%<table border=0><tr><td width=25 height=50 bgcolor=#000000></td></tr></table></td>";}
	if($hh[agentes] == 1){ $code .= "<td align=center valign=bottom >100%<table border=0><tr><td width=25 height=320 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[agentes] == 2){ $code .= "<td align=center valign=bottom >85%<table border=0><tr><td width=25 height=282 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[agentes] == 3){ $code .= "<td align=center valign=bottom >65%<table border=0><tr><td width=25 height=212 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[agentes] == 4){ $code .= "<td align=center valign=bottom >40%<table border=0><tr><td width=25 height=130 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[agentes] == 5){ $code .= "<td align=center valign=bottom >25%<table border=0><tr><td width=25 height=82 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[agentes] == 6){ $code .= "<td align=center valign=bottom >15%<table border=0><tr><td width=25 height=50 bgcolor=#000000></td></tr></table></td>";}
	
	if($hh[energetico] == 1){ $code .= "<td align=center valign=bottom >100%<table border=0><tr><td width=25 height=320 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[energetico] == 2){ $code .= "<td align=center valign=bottom >75%<table border=0><tr><td width=25 height=247 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[energetico] == 3){ $code .= "<td align=center valign=bottom >65%<table border=0><tr><td width=25 height=212 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[energetico] == 4){ $code .= "<td align=center valign=bottom >45%<table border=0><tr><td width=25 height=147 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[energetico] == 5){ $code .= "<td align=center valign=bottom >15%<table border=0><tr><td width=25 height=50 bgcolor=#000000></td></tr></table></td>";}
	if($hh[transporte] == 1){ $code .= "<td align=center valign=bottom >100%<table border=0><tr><td width=25 height=320 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[transporte] == 2){ $code .= "<td align=center valign=bottom >75%<table border=0><tr><td width=25 height=247 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[transporte] == 3){ $code .= "<td align=center valign=bottom >65%<table border=0><tr><td width=25 height=212 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[transporte] == 4){ $code .= "<td align=center valign=bottom >45%<table border=0><tr><td width=25 height=147 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[transporte] == 5){ $code .= "<td align=center valign=bottom >15%<table border=0><tr><td width=25 height=50 bgcolor=#000000></td></tr></table></td>";}
	if($hh[escada] == 1){ $code .= "<td align=center valign=bottom >100%<table border=0><tr><td width=25 height=320 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[escada] == 2){ $code .= "<td align=center valign=bottom >75%<table border=0><tr><td width=25 height=247 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[escada] == 3){ $code .= "<td align=center valign=bottom >65%<table border=0><tr><td width=25 height=212 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[escada] == 4){ $code .= "<td align=center valign=bottom >45%<table border=0><tr><td width=25 height=147 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[escada] == 5){ $code .= "<td align=center valign=bottom >15%<table border=0><tr><td width=25 height=50 bgcolor=#000000></td></tr></table></td>";}
	if($hh[esforco] == 1){ $code .= "<td align=center valign=bottom >100%<table border=0><tr><td width=25 height=320 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[esforco] == 2){ $code .= "<td align=center valign=bottom >75%<table border=0><tr><td width=25 height=247 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[esforco] == 3){ $code .= "<td align=center valign=bottom >65%<table border=0><tr><td width=25 height=212 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[esforco] == 4){ $code .= "<td align=center valign=bottom >45%<table border=0><tr><td width=25 height=147 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[esforco] == 5){ $code .= "<td align=center valign=bottom >15%<table border=0><tr><td width=25 height=50 bgcolor=#000000></td></tr></table></td>";}
	
	if($hh[exigencia] == 1){ $code .= "<td align=center valign=bottom >100%<table border=0><tr><td width=25 height=320 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[exigencia] == 2){ $code .= "<td align=center valign=bottom >80%<table border=0><tr><td width=25 height=265 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[exigencia] == 3){ $code .= "<td align=center valign=bottom >65%<table border=0><tr><td width=25 height=212 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[exigencia] == 4){ $code .= "<td align=center valign=bottom >35%<table border=0><tr><td width=25 height=112 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[exigencia] == 5){ $code .= "<td align=center valign=bottom >10%<table border=0><tr><td width=25 height=33 bgcolor=#000000></td></tr></table></td>";}
	if($hh[tarefa] == 1){ $code .= "<td align=center valign=bottom >100%<table border=0><tr><td width=25 height=320 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[tarefa] == 2){ $code .= "<td align=center valign=bottom >70%<table border=0><tr><td width=25 height=230 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[tarefa] == 3){ $code .= "<td align=center valign=bottom >55%<table border=0><tr><td width=25 height=180 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[tarefa] == 4){ $code .= "<td align=center valign=bottom >25%<table border=0><tr><td width=25 height=82 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[tarefa] == 5){ $code .= "<td align=center valign=bottom >5%<table border=0><tr><td width=25 height=18 bgcolor=#000000></td></tr></table></td>";}
	if($hh[atencao] == 1){ $code .= "<td align=center valign=bottom >100%<table border=0><tr><td width=25 height=320 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[atencao] == 2){ $code .= "<td align=center valign=bottom >70%<table border=0><tr><td width=25 height=230 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[atencao] == 3){ $code .= "<td align=center valign=bottom >55%<table border=0><tr><td width=25 height=180 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[atencao] == 4){ $code .= "<td align=center valign=bottom >25%<table border=0><tr><td width=25 height=82 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[atencao] == 5){ $code .= "<td align=center valign=bottom >5%<table border=0><tr><td width=25 height=18 bgcolor=#000000></td></tr></table></td>";}
	if($hh[isolada] == 1){ $code .= "<td align=center valign=bottom >100%<table border=0><tr><td width=25 height=320 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[isolada] == 2){ $code .= "<td align=center valign=bottom >75%<table border=0><tr><td width=25 height=247 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[isolada] == 3){ $code .= "<td align=center valign=bottom >60%<table border=0><tr><td width=25 height=195 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[isolada] == 4){ $code .= "<td align=center valign=bottom >35%<table border=0><tr><td width=25 height=112 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[isolada] == 5){ $code .= "<td align=center valign=bottom >15%<table border=0><tr><td width=25 height=50 bgcolor=#000000></td></tr></table></td>";}
	if($hh[necessidade] == 1){ $code .= "<td align=center valign=bottom >100%<table border=0><tr><td width=25 height=320 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[necessidade] == 2){ $code .= "<td align=center valign=bottom >75%<table border=0><tr><td width=25 height=247 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[necessidade] == 3){ $code .= "<td align=center valign=bottom >60%<table border=0><tr><td width=25 height=195 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[necessidade] == 4){ $code .= "<td align=center valign=bottom >35%<table border=0><tr><td width=25 height=112 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[necessidade] == 5){ $code .= "<td align=center valign=bottom >15%<table border=0><tr><td width=25 height=50 bgcolor=#000000></td></tr></table></td>";}
	if($hh[requisito] == 1){ $code .= "<td align=center valign=bottom >100%<table border=0><tr><td width=25 height=320 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[requisito] == 2){ $code .= "<td align=center valign=bottom >75%<table border=0><tr><td width=25 height=247 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[requisito] == 3){ $code .= "<td align=center valign=bottom >35%<table border=0><tr><td width=25 height=112 bgcolor=#000000></td></tr></table></td>";}else
	if($hh[requisito] == 4){ $code .= "<td align=center valign=bottom >15%<table border=0><tr><td width=25 height=50 bgcolor=#000000></td></tr></table></td>";}
	$code .= "</tr>";
	$code .= "</table>";
	
	$code .= "<table border=0 width=100% cellspacig=0 cellpadding=0>";
    $code .= "<tr>";
    $code .= "<td align=center>";
    $code .= "<center><img src='../../../../images/histograma.png' border=0 width=100% height=290></center>";
    $code .= "</tr>";
    $code .= "</table>";
	
	$code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [13]
/****************************************************************************************************************/
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$code .= "<tr>";
	$code .= "<td align=left width=40%><b>Agente:</b></td>";
	$code .= "<td align=left width=40%><b>Risco da Fun��o:</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=left width=40%>Em p�</td>";
	$code .= "<td align=left width=40%>P�s e pernas (varizes)</td>";
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=left width=40%>Sentado sem encosto</td>";
	$code .= "<td align=left width=40%>M�sculos extensores do dorso</td>";
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=left width=40%>Assento muito alto</td>";
	$code .= "<td align=left width=40%>Parte inferior das pernas, joelhos e p�s</td>";
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=left width=40%>Assento muito baixo</td>";
	$code .= "<td align=left width=40%>Dorso e pesco�o</td>";
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=left width=40%>Bra�os esticado</td>";
	$code .= "<td align=left width=40%>Ombros e bra�os</td>";
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=left width=40%>Pegas inadequadas em ferramentas</td>";
	$code .= "<td align=left width=40%>Antebra�os</td>";
	$code .= "</tr>";
	$code .= "</table>";
	
	$code .= "<p align=justify>";
	
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As atividades quando desenvolvidas na empresa pelos funcion�rios do setor administrativo caracterizarem-se por trabalho em p� e eventualmente sentado, de natureza moderada, com movimentos sequenciais, repetitivos em rela��o ao uso das m�os, pulsos e bra�os, com jornada de trabalho diurna.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recomenda��es oficiais normatizadoras emitidas pelo Minist�rio do Trabalho e do Emprego, a respeito dos riscos ocupacionais em geral (portaria SSST/ MTE N� 24 de 29/12/94, portaria SSST / MTE N� 08 de 08/05/96 e N� 17 de 25/06/96, estabelecem crit�rios limitados e restringem o discernimento do m�dico examinador para a caracteriza��o dos mesmos).<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Assim, algumas condi��es incidentes nos setores operacionais, como por exemplo, os dist�rbios circulat�rios nos membros inferiores (possivelmente determinados por posturas prolongadas na posi��o de p�), embora se constituam em fatores de interesse no desencadeamento de desordens org�nicas relacionadas ao trabalho, n�o s�o legalmente considerados como condi��es de risco ocupacional.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;De acordo com a NR17 item 17.3.5 para as atividades em que os funcion�rios devam ser realizados de p�, devem ser colocados assentos para descanso em locais em que possam ser utilizados por todos os funcion�rios durante as pausas.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nas atividades de servi�os gerais do tipo faxina, por exemplo, afec��es articulares, sobretudo nos cotovelos e ombros, podem ocorrer em fun��o dos esfor�os repetitivos sobre tais juntas durante a execu��o de servi�os com demanda de vassouras, rodos, etc. Bem como naqueles de esfrega��o de vidra�as, pisos e janelas em tais opera��es, os membros superiores s�o mobilizados estendidos para a realiza��o de movimentos circulares acima do plano da cabe�a e tamb�m com extens�o da mesma, postura empregada para a limpeza da parte superior de paredes, portas, janelas, etc. Por outro lado, a postura com flex�o prolongada dos membros inferiores e o contato com superf�cies �midas, predisp�em ao desencadeamento/ agravamento de desordens circulat�rias(micro-varizes, varizes e estase).<p align=justify>";
	
	$code .= "<b>Limpeza e Ordem:</b>";
	$code .= "&nbsp;&nbsp;O local de trabalho apresentar � se organizado, limpo e desimpedido, notadamente nas vias de circula��o, passagens e escadarias.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O entulho e quaisquer sobras de materiais devem ser regularmente coletados e removidos. Por ocasi�o de sua remo��o, devem ser tomados cuidados especiais, de forma a evitar poeira excessiva e eventuais riscos.<p align=justify>";
	
	$code .= "<b>Ac�o Prevencionista:</b>";
	$code .= "&nbsp;&nbsp;A nossa a��o prevencionista � composta de palestra para conscientiza��o sobre a preven��o aos riscos eminente no ambiente onde estar� desenvolvendo suas tarefas. O treinamento � fundamental para que o trabalhador conhe�a todo o procedimento a ser tomado e com isso ele possa estar apto a sua fun��o.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O EPI � um dos fatores principais para essa a��o, porque ser� com ele que evitar� poss�veis les�es oriundas do acidente e possibilitar� que a jornada laborativa torne sua rotina de trabalho mais segura.";
				
	$code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [14] --> AVALIA��ES AMBIENTAIS
/****************************************************************************************************************/
	$code .= "<b>Avalia��es Ambientais:</b><br>";
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$code .= "<tr>";
	$code .= "<td width=25% align=center colspan=2><b>Setor/Quantidade</b></td>";
	$code .= "<td width=15% align=center ><b>Agente Risco</b></td>";
	$code .= "<td width=18% align=center ><b>Fonte Geradora</b></td>";
	$code .= "<td width=9% align=center ><b>N�vel</b></td>";
	$code .= "<td width=15% align=center ><b>Gravidade</b></td>";
	$code .= "<td width=18% align=center ><b>Categoria</b></td>";
	$code .= "</tr>";
	$code .= "</table>";
	
	$asd = "select count(cod_func) as func, s.nome_setor, s.cod_setor
			from cgrt_func_list cgrt, setor s 
			where cod_cgrt = $cod_cgrt and cgrt.cod_setor = s.cod_setor
			group by s.cod_setor, s.nome_setor";
	$lpx = pg_query($asd);
	
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	while($lost = pg_fetch_array($lpx)){
	$nob = "select ag.num_agente_risco, tp.nome_tipo_risco, rs.fonte_geradora, rs.nivel
			from cgrt_func_list cgrt, agente_risco ag, tipo_risco tp, risco_setor rs
			where cod_cgrt = $cod_cgrt and cgrt.cod_setor = rs.cod_setor and rs.cod_agente_risco = ag.cod_agente_risco 
			and tp.cod_tipo_risco = ag.cod_tipo_risco and cgrt.cod_cgrt = rs.id_ppra and cgrt.cod_setor = $lost[cod_setor]
			group by ag.num_agente_risco, tp.nome_tipo_risco, rs.fonte_geradora, rs.nivel order by num_agente_risco";
	$mob = pg_query($nob);
	$staf = pg_fetch_all($mob);
	$code .= "<tr>";
		$code .= "<td width=20% align=center >{$lost[nome_setor]}</td>";
		$code .= "<td width=5% align=center >{$lost[func]}</td>";
		$code .= "<td width=15% align=left >";
			for($x=0;$x<pg_num_rows($mob);$x++){
				$code .= $staf[$x][num_agente_risco]." ".$staf[$x][nome_tipo_risco]."<br>";
			}
		$code .= "</td>";
		$code .= "<td width=18% align=left >";
			for($x=0;$x<pg_num_rows($mob);$x++){
				$code .= $staf[$x][fonte_geradora]."<br>";
			}
		$code .= "</td>";
		$code .= "<td width=9% align=center >";
			for($x=0;$x<pg_num_rows($mob);$x++){
				$code .= $staf[$x][nivel]."<br>";
			}
		$code .= "</td>";
		$code .= "<td width=15% align=center >Control�vel</td>";
		$code .= "<td width=18% align=left >";
			for($x=0;$x<pg_num_rows($mob);$x++){
				$code .= $staf[$x][fonte_geradora]."<br>";
			}
		$code .= "</td>";
	$code .= "</tr>";
	}
	$code .= "</table>";
		
	$code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [15] 
/****************************************************************************************************************/
	for($x=0;$x<pg_num_rows($ava);$x++){
	$t_func = "select cg.cod_func, f.* from cgrt_func_list cg, funcionarios f 
			where cod_cgrt = $cod_cgrt and cg.cod_setor = {$avl[$x][cod_setor]} and f.cod_func = cg.cod_func and cg.cod_cliente = f.cod_cliente";
	$ttal = pg_query($t_func);
	$ttl = pg_fetch_all($ttal);
	
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$code .= "<tr>";
	$code .= "<td width=100% align=left><b>Data da Vistoria T�cnica:</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=justify >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A vistoria ocorreu no dia ".date("d", strtotime($info[data_avaliacao]))." de ".$meses[date("n", strtotime($info[data_criacao]))]." de {$info[ano]}, no interior da empresa: <b> {$info[razao_social]}</b>. Devidamente classificada, setores administrativos bem como setores operacionais.</td>";
	$code .= "</tr>";
	$code .= "</table>";
	
	$code .= "<p>";
	
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$code .= "<tr>";
	$code .= "<td align=center ><b>Setor:</b> {$avl[$x][nome_setor]}</td>";
	$code .= "<td align=center ><b>N� de Colaboradores:</b> ".str_pad(pg_num_rows($ttal), 2, "0", 0)."</td>";
	$code .= "<td align=center ><b>Atividade:</b> {$avl[$x][tipo_setor]}</td>";
	$code .= "</tr>";
	$code .= "</table>";
	
	$code .= "<p>";
	
	$code .= "<b>Din�mica da Fun��o:</b>";
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$code .= "<tr>";
	$code .= "<td align=justify >";
	for($w=0;$w<pg_num_rows($ttal);$w++){
		$code .= $ttl[$w][dinamica_funcao].";";
	}
	$code .= "</td>";
	$code .= "</tr>";
	$code .= "</table>";
	
	$code .= "<p>";
	
	$sql = "SELECT distinct(tr.nome_tipo_risco)
			FROM setor s, risco_setor r, cliente_setor c, agente_risco ag, tipo_risco tr
			WHERE r.cod_cliente = c.cod_cliente AND r.cod_setor = c.cod_setor AND r.cod_setor = s.cod_setor
			AND c.id_ppra = r.id_ppra AND c.id_ppra = $cod_cgrt AND c.cod_setor = {$avl[$x][cod_setor]}
			AND ag.cod_tipo_risco = tr.cod_tipo_risco AND r.cod_agente_risco = ag.cod_agente_risco ";
	$dif = pg_query($sql);
	$s_dif = pg_fetch_all($dif);
	
	$code .= "<b>Riscos Existentes:</b>";
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$code .= "<tr>";
	$code .= "<td align=justify >";
	for($w=0;$w<pg_num_rows($dif);$w++){
		$code .= $s_dif[$w][nome_tipo_risco].";";
	}
	$code .= "</td>";
	$code .= "</tr>";
	$code .= "</table>";
	
	$code .= "<p>";
	
	$sql = "SELECT r.diagnostico, r.acao_necessaria
			FROM setor s, risco_setor r, cliente_setor c, agente_risco ag, tipo_risco tr
			WHERE r.cod_cliente = c.cod_cliente AND r.cod_setor = c.cod_setor AND r.cod_setor = s.cod_setor
			AND c.id_ppra = r.id_ppra AND c.id_ppra = $cod_cgrt AND c.cod_setor = {$avl[$x][cod_setor]}
			AND ag.cod_tipo_risco = tr.cod_tipo_risco AND r.cod_agente_risco = ag.cod_agente_risco ";
	$dia = pg_query($sql);
	$diag = pg_fetch_all($dia);
	
	$code .= "<b>Diagn�stico dos Riscos:</b>";
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$code .= "<tr>";
	$code .= "<td align=justify >";
	for($w=0;$w<pg_num_rows($dia);$w++){
		$code .= $diag[$w][diagnostico].";";
	}
	$code .= "</td>";
	$code .= "</tr>";
	$code .= "</table>";
	
	$code .= "<p>";
	
	$code .= "<b>Sugest�o:</b>";
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$code .= "<tr>";
	$code .= "<td align=justify >";
	for($w=0;$w<pg_num_rows($dia);$w++){
		$code .= $diag[$w][acao_necessaria].";";
	}
	$code .= "</td>";
	$code .= "</tr>";
	$code .= "</table>";

	$code .= "<div class='pagebreak'></div>";
	}
	
/****************************************************************************************************************/
// -> PAGE [16] 
/****************************************************************************************************************/
	$code .= "<b>Recomenda��es / Conclus�o</b><p align=justify>";
	$code .= "&nbsp;Considerados que os dados obtidos devem ser adequadamente observados as seguintes recomenda��es:<p align=justify>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O resultado da avalia��o m�dica e/ou relat�rio anual do PCMSO, dever� ser discutido em reuni�o com presen�a do m�dico examinador.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Programas de gin�stica laboral preventiva e/ou exerc�cios f�sicos corretivos de postura devem ser estabelecidos, sob orienta��o e supervis�o t�cnica e compatibilizando idade, sexo e limita��es individuais.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Desenvolvimento de campanhas peri�dicas de conscientiza��o e combate ao fumo, �lcool, drogas e sedentarismo.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Iniciativas de combate ao stress, com incentivo �s atividades de lazer e outras inerentes ao aprimoramento das rela��es humanas.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Divulga��o de recomenda��es e exerc�cios para prevenir e/ou atenuar os dist�rbios circulat�rios dos membros inferiores, inclusive para realiza��o dom�stica.<p>";
	
	$code .= "Rio de Janeiro, ".date("d", strtotime($info[data_avaliacao]))." de ".$meses[date("n", strtotime($info[data_criacao]))]." de {$info[ano]}";
	
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$code .= "<tr>";
	$code .= "<td align=center width=50%><b>Revisado por</b></td>";
	$code .= "<td align=center width=50%><b>Aprovado por</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=center >$flist[nome]<br>M�dica do Trabalho<br>Reg. $flist[registro]<br>&nbsp;</td>";
	$code .= "<td align=center >$info[nome_contato_dir]<br>$info[cargo_contato_dir]</td>";
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=center >$ass_elaborador</td>";
	$code .= "<td align=center >&nbsp;</td>";
	$code .= "</tr>";
	$code .= "</table>";

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