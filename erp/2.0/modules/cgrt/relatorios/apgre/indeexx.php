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
$meses    = array('', 'Janeiro',  'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$m        = array(" ", "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");
$title    = "AVALIAÇÃO PRELIMINAR E GERENCIAMENTO DE RISCOS ERGONÔMICOS";

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
            <font size="7" face="Verdana, Arial, Helvetica, sans-serif">SESMT<sup><font size=3>®</font></sup></font>&nbsp;&nbsp;
			<font size="1" face="Verdana, Arial, Helvetica, sans-serif">SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
			CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></strong>
            </td>';
        $cabecalho .= ' <td width=40% align="right" height=$header_h>
            <font face="Verdana, Arial, Helvetica, sans-serif" size="4">
            <b>Avaliação Preliminar e
Gerenciamento de Riscos
Ergonômicos</b>
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
    $code .= "<td><b>ELABORAÇÃO:</b></td>";
    $code .= "</tr><tr>";
    $code .= "<td>SESMT Serviços Especializados em Segurança e Monitoramentos de Atividades no Trabalho Ltda<br>Rua: Marechal Antônio de Souza, 92 – Jardim América – Rio de Janeiro – RJ<br>CNPJ: 04.722.248/0001-17<br>&nbsp;</td>";
    $code .= "</tr><tr>";
    $code .= "<td><b>ELABORADOR:</b></td>";
    $code .= "</tr><tr>";
    $code .= "<td>$flist[nome]<br>Médica do Trabalho<br>Reg. $flist[registro]<br>&nbsp;</td>";
    $code .= "</tr><tr>";
    $code .= "<td><b>REVISOR:</b></td>";
    $code .= "</tr><tr>";
    $code .= "<td>$flis[nome]<br>$flis[n]<br>Reg. $flis[registro]<br>&nbsp;</td>";
    $code .= "</tr><tr>";
    $code .= "<td><b>APROVAÇÃO:</b></td>";
    $code .= "</tr><tr>";
    $code .= "<td>$info[nome_contato_dir]<br>$info[cargo_contato_dir]</td>";
    $code .= "</tr>";
   
    $code .= "</table>";

    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [3]
/****************************************************************************************************************/
    $code .= "<div class='mainTitle'><b>APRESENTAÇÃO</b></div>";
    $code .= "<BR><p align=justify>";

    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A palavra Ergonomia é um neologismo criado a partir da união dos termos gregos Ergon, que significa trabalho e Nomos, cujo significado refere-se a normas ou regras e leis. Ergonomia como fatores humanos é a disciplina cientifica que diz respeito ao discernimento do relacionamento entre homens e outros elementos de um sistema de gestão em exercício de sua profissão.<br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A profissão que implica teorias, princípios, informações, métodos e dados para projetar, de modo a otimizar o bem estar do ser humano em uma jornada laborativa objetivando assim a eficiência plena do sistema. Utilizando-se de formas e maneiras mais simples e nesse complexo de ações e informações temos a ergonomia como o estudo de adaptação de uma jornada de trabalho e o ser humano.";

    $code .= "<div class='mainTitle'><b>OBJETIVO</b></div>";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O objetivo do presente trabalho é o de realizar a avaliação preliminar e o gerenciamento dos riscos ergonômicos das atividades desenvolvidas por cada um dos colaboradores em seus postos de trabalho da empresa: <b>{$info[razao_social]}</b> Situada no Endereço: <b>{$info[endereco]}, {$info[num_end]}</b> Inscrita no CNPJ: <b>{$info[cnpj]}</b> em conformidade com as exigências pertinentes buscando sempre expor de forma clara, objetiva e técnica os parâmetros estabelecidos que permitam adaptações das condições dos postos de trabalho às características psico-fisiológicas dos trabalhadores de modo a proporcionar o máximo de conforto, segurança e desempenho.<BR>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O estudo inclui aspectos relacionados à ergonomia física, cognitiva e organizacional dentre os quais estão à adaptação a superfícies, apoios e alcances da interface máquina versus ser humano; seja por motivos de posturas inadequadas, exercício de tarefas sentado; semi-sentado; em pé; empurrando; puxando; praticando levantamentos; transportando ou no exercício de descarga de materiais; estruturas arquitetônicas; mobiliários; maquinários e equipamentos. Às condições ambientais de iluminação, ruídos, stress térmicos e umidade relativa do ar; aspectos cognitivos, carga mental – Psicanálise Ocupacional, psicológica, emocional e à própria organização do trabalho, cargo e a metodologia do trabalho.";

    $code .= "<div class='pagebreak'></div>";


/****************************************************************************************************************/
// -> PAGE [4] 
/****************************************************************************************************************/
    $code .= "<center><div class='mainTitle'><b>SUMÁRIO</b></div></center>";
    
	$code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";
    $code .= "<td><b>Empresa</b></td>";
    $code .= "</tr><tr>";
    $code .= "<td><b>Local de Trabalho</b></td>";
    $code .= "</tr><tr>";
    $code .= "<td><b>Fundamentação</b></td>";
    $code .= "</tr><tr>";
    $code .= "<td><b>Metodologia</b></td>";
    $code .= "</tr><tr>";
    $code .= "<td><b>Instrumentos Utilizados</b></td>";
    $code .= "</tr><tr>";
    $code .= "<td><b>Levantamento e Análise</b></td>";
    $code .= "</tr><tr>";
    $code .= "<td>Identificação da análise<br>Descrição física e historica<br>Descrição do método de trabalho<br>Descrição da populaçãofuncional<br>Análise pró-ativa de riscos ergonômicos<br>Considerações</td>";
    $code .= "</tr><tr>";
    $code .= "<td><b>Conclusão</b></td>";
    $code .= "</tr><tr>";
    $code .= "<td><b>Bibliografia</b></td>";
    $code .= "</tr>";
   
    $code .= "</table>";

    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [5] 
/****************************************************************************************************************/
    $code .= "<div class='mediumTitle'><b>DESCRIÇÃO DA EMPRESA</b></div>";
    $code .= "<p align=justify>";
    
    $code .= "<table width=100% cellspacig=2 cellpadding=2 border=0>";
    $code .= "<tr>";
    $code .= "<td align=left width=150><b>Razão Social:</b></td>";
    $code .= "<td align=left>{$info[razao_social]}</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td><b>Endereço:</b></td>";
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
    $code .= "<td><b>Município:</b></td>";
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
    $code .= "<td><b>Res. Pelas Informações:</b></td>";
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
    $code .= "<td><b>Escritório Contábil:</b></td>";
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
        $code .= "<td>Razão social:</td><td>$ptinfo[razao_social]</td>";
        $code .= "</tr><tr>";
        $code .= "<td>Endereço: </td><td>$ptinfo[endereco], $ptinfo[num_end]</td>";
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
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Os assentos utilizados nos postos de trabalho devem atender aos seguintes requisitos mínimos de conforto:<br>";
    $code .= "a- Altura ajustável à estatura do trabalhador e à natureza da função exercida.<br>";
	$code .= "b- Características de pouca ou nenhuma conformação na base do assento.<br>";
	$code .= "c- Borda frontal arredondada.<br>";
	$code .= "d- Encosto com forma levemente adaptada ao corpo para proteção da região lombar.<p align=justify>";

    $code .= "<b>Atividades Operacionais</b><br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nos setores operacionais há uma carga de movimentos repetitivos consideráveis e movimentos contínuos dos membros superiores e membros inferiores.<BR>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Destacamos o nível de atenção que as tarefas necessitam para serem executadas com segurança.<p align=justify>";
   
    $code .= "<b>Fundamentação</b><br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fundamentação legal: Este trabalho baseia-se nas disposições da CLT – Consolidações das Leis Trabalhistas, regulamentação do ministério do trabalho e do emprego e documentos abaixo descritos; Capítulo V, título II da CLT em especial no art. 198 e 199 Lei 6.514 de 22 de Dezembro de 1977; Normas Regulamentadoras do Ministério do Trabalho e Emprego aprovadas pela Portaria nº 3.214/78, com suas alterações posteriores; NR – 17 Ergonomia.<p align=justify>";

	$code .= "<b>Documentos Complementares</b><br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Portaria 3.751 de 23 de Novembro de 1990 – Revoga o Anexo IV – Iluminância da NR – 15 transferido para a NR – 17 (Ergonomia); ABNT NBR 10.152 – Níveis de ruídos para conforto acústico; ABNT NBR 5.413 – Iluminância de interiores.<p align=justify>";

	$code .= "<b>Fundamentação Técnica</b><br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Para caracterização dos fatores de risco ambiental, foram utilizadas as metodologias de avaliação ambiental da Fundacentro.<br> ABNT NBR 5.413 – Iluminância de interiores;	FUNDACENTRO NHT 09 R/E – 1986 – Norma para avaliação da exposição ocupacional ao ruído continuo ou intermitente.<p align=justify>";

	$code .= "<b>Metodologia</b><br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nas abordagens das avaliações preliminares ergonômicas foram utilizadas várias ferramentas científicas, observação dos postos de trabalho, check-list, planilha questionário – ordem de serviço e entrevista nos postos de trabalho junto aos funcionários. Objetivando assim implementar o trabalho na utilização das duas técnicas, a saber, a técnica objetiva (direta) e a técnica subjetiva (indireta).<p align=justify>";

	$code .= "<b>Técnicas Objetivas</b><br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quanto às técnicas objetivas, foram realizadas observações de campo, com o registro de imagens, avaliação ambiental de stress térmico, ruídos, vibrações, medidas a incidência de iluminância, altura de mobiliários, colorização arquitetônica, permitindo uma abordagem de maneira global das atividades praticadas em cada posto de trabalho a partir da avaliação ergonômica, para identificação dos problemas, necessidades ou definições de demandas feitas com a participação direta (verbalização) do efetivo populacional da empresa.";
	   
    //$code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [7] 
/****************************************************************************************************************/
	$code .="<p align=justify>";
   	$code .= "<b>Técnicas Subjetivas</b><br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As técnicas subjetivas (check-list, questionário e entrevistas) permitem levantar as opiniões dos entrevistados para a melhor complementação do trabalho garantindo que a observação realizada aproxime-se da realidade efetiva. Permitindo que a pesquisa de todos os itens previamente levantados possam propor as concepções de ambiente, carga fisiológica, carga mental e aspectos psicossociais. A caracterização da exposição aos agentes iluminância, ruído e stress térmico considerou a observação dos postos de trabalho como alvo das medições, ou seja, a utilização desses equipamentos proporcionou a definição das condições ambientais de cada posto de trabalho.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As medições de níveis de iluminância foram realizadas no posto de trabalho onde se realizam as tarefas de predominância visual, utilizando-se de luxímetro com fotocélula corrigida para a sensibilidade do olho humano e em função do ângulo de incidência. Quando não se pôde definir o campo de trabalho, considerou-se um plano horizontal a 0,75 cm do piso para efetuar a medição, considerando-se a coloração das paredes (arquitetura) a voltagem de cada luminária.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quanto ao nível de pressão sonora, especificadamente, a medição foi realizada com o microfone junto à zona auditiva do trabalhador, altura do plano horizontal que contém o canal auditivo, a uma distância, aproximada, de 150 mm do ouvido e em razão das fontes de ruídos, emitirem ruídos contínuos estacionários (com variação de nível desprezível) o período de observação foi de 5 minutos aproximadamente para cada ponto de medição.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Na avaliação de stress térmico, consideramos alguns parâmetros que influem na sobrecarga térmica a que estão submetidos os trabalhadores (temperatura do ar e umidade relativa do ar; tipo de atividade e gasto energético). O posicionamento do aparelho de medição foi o local onde permanece o trabalhador, à distância e altura da região do corpo mais atingida.<p align=justify>";
	
	//RUÍDOS
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
		$code .= "<b>Data de Calibração:</b> ".date("d/m/Y", strtotime($db[data_calibracao]))."<p>";
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
		$code .= "<b>Data de Calibração:</b> ".date("d/m/Y", strtotime($temp[data_calibracao]))."<p>";
    }else{
		$code .= "<br>";
	}
	
	//ILUMINAÇÃO
	$luz = "SELECT a.*, i.data
			FROM aparelhos a, iluminacao_ppra i
			WHERE a.cod_aparelho = i.lux
			AND i.id_ppra = $cod_cgrt";
	$lux = pg_query($connect, $luz);
	$ilu = pg_fetch_array($lux);

	if($ilu[nome_aparelho] != ""){
		$code .= "<b>Nome:</b> $ilu[nome_aparelho]<br>";
		$code .= "<b>Marca:</b> $ilu[marca_aparelho]<br>";
		$code .= "<b>Data de Calibração:</b> ".date("d/m/Y", strtotime($ilu[data_calibracao]))."<p align=justify>";
    }else{
		$code .= "<br>";
	}
	
	$code .= "<b>Conclusão</b><br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Num aspecto global, os postos de trabalho apresentam boas condições; não obstante com uma análise mais detalhada, foi possível detectar diversas situações que exigem intervenções ergonômicas e melhorias sistemáticas que, se bem gerenciadas, trarão melhor nível de conforto, segurança, prevenção de doenças ocupacionais e desempenho eficiente no dia a dia dos trabalhadores.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A principio, este é o objetivo deste documento, já que haverá uma mudança significativa das condições de trabalho, em face de nova visão do ambiente que nos propomos a ofertar a esta administração.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O presente trabalho abordará as três áreas da ergonomia: ergonomia física; cognitiva e organizacional; envolvendo diversos tópicos dos cincos itens que serão apresentados mais a frente.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Em virtude da não observação da adaptação das instalações este item não foi apreciado nos quesitos de concepção e ambiente, num primeiro momento da ocupação.";

    //$code .= "<div class='pagebreak'></div>";
    
/****************************************************************************************************************/
// -> PAGE [8] 
/****************************************************************************************************************/
	$code .="<p align=justify>";
   	$code .= "<b>Concepção</b><br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Foram identificadas situações de riscos exigindo que ações sejam implantadas e implementadas nos postos de trabalhos, tanto de OEM como de SMS, relacionados com incongruência de posturas inadequadas, ferramentas impróprias ou inseguras.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tais fatores de riscos, conforme caracterizados e classificados nas planilhas de análise pró-ativa de riscos apresentam efeitos tanto humanos como organizacionais, podendo acarretar o desconforto físico, afastamentos e impactos no índice de absenteísmo (pequenas perdas de produtividades) até efeitos como sequelas e limitações funcionais (distensão muscular, lombalgias, torções articulares, DORT – Distúrbios Osteomusculares Relacionados ao Trabalho), consequência à produtividade implicando em atrasos no campo previsto de produção ou em redução do trabalho planejado, custos em atenção ao problema ou redução de mão de obra e ainda complicações com regulações governamentais ou em não atendimento à legislação. Neste cenário a atenção especial por parte da administração da empresa deve ser dada nas análises coletadas (resultado do levantamento técnico de campo) e relatadas neste trabalho.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Obedecendo aos critérios as instalações elétricas, mecânicas, automação e química, vistos que estes envolvem atividades de maior esforço físico e exposição por parte dos trabalhadores.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Conforme recomendado nas análises pró-ativa de risco, além das outras recomendações descritas neste trabalho deve-se considerar a implantação e implementação do Programa de Cinesioterapia Laboral, com atividades programadas para fortalecimento muscular dos membros mais exigidos em uma jornada de trabalho (membros superiores e membros inferiores) e adoção de atividades aeróbicas para manutenção do condicionamento físico e mental. Um programa bem elaborado e aplicado por profissional especializado, com o conhecimento prévio da situação de trabalho de cada setor da empresa é um instrumento eficaz para prevenção da DORT, contribuindo ainda para a integração dos trabalhadores da empresa, causando assim melhoria na disposição física e rendimento da execução de tarefas “Produtividade” causando assim melhora na autoestima e satisfação profissional.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Outro fator a ser considerado em todos os setores é a postura e mobiliários inadequados principalmente no trabalho sentado. A postura estática, sentado por longos períodos com uso de computador, influi na ocorrência de posturas durante uma jornada de trabalho, portanto torna-se necessário a orientação dos trabalhadores estimulada pela administração da empresa. Para a boa educação ergonômica adotar uma postura correta e nas atividades e nos casos de trabalho sentado com uso de computadores promover pequenos períodos de pausas para exercícios e relaxamento com objetivo de interromper a rotina e estimular as articulações. Esses períodos podem ser de dez (10) ou cinco (05) minutos antes de cada hora cheia.<br>";
	
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Os mobiliários utilizados são adequados, com exceção dos casos de cadeiras danificadas, já relatados na planilha de análise pró-ativa, e o uso de monitor sem regulagem de altura. Conforme estudos realizados por Grandjean, as dimensões recomendadas para altura da tela (Ponto Médio) a partir do piso, são de 78 cm a 106 cm. Embora as medidas realizadas estejam dentro da faixa recomendada, em várias mesas foram encontradas adaptações improvisadas para elevação da altura dos monitores, indicados um desconto no uso dos mesmos. Isso ocorre devido às variações de medidas antropométricas de cada pessoa, que determina as faixas de ajustes confortáveis no posto de trabalho. Sendo assim recomendamos a substituição destes monitores por outros que tenham regulagem de altura. Da mesma forma o uso de Notebook induz a inclinação do pescoço para baixo, já que o equipamento é concebido em um conjunto de teclado-monitor, permitindo a regulagem da inclinação 	da tela, mas não da altura. Recomenda-se sua substituição por micros comuns ou o uso de adaptadores ergonômicos para os casos em que seja imprescindível o seu uso.<p align=justify>";
	
    $code .= "<div class='pagebreak'></div>";
    
/****************************************************************************************************************/
// -> PAGE [9] 
/****************************************************************************************************************/
	$code .="<p align=justify>";
	$code .= "<b>Ambiente</b><br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Foram identificados riscos de exposição ao ruído, ao calor e iluminação deficiente na produção e em alguns postos de trabalho na área administrativa. Porém, o parâmetro técnico estabelecido na NR 17, para temperatura, ruído e iluminância adequados, refere-se apenas as atividades que exijam solicitação intelectual, apresentando apenas um aspecto de desconforto e não de risco, podendo interferir no trabalho, mas não sendo causa principal de uma procura ambiental ou afastamento, por exemplo. Sendo assim, no que diz respeito aos riscos à saúde dos trabalhadores provenientes desses agentes, devem ser observadas as medidas de controle adequadas conforme o PPRA – Programa de Prevenção de Riscos Ambientais e do PCMSO – Programa de Controle Médico de Saúde Ocupacional na empresa.<p align=justify>";

	$code .= "<b>Temperatura</b><br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No que tange ao calor, {$info[temperatura]} {$info[temp_elevada]} {$info[ceu_aberto]}. As medições foram realizadas {$info[p_medicao]}, e as variações de temperatura e umidade relativa do ar apresentadas neste documento sofreram influência do clima, visto que as mudanças climáticas das estações do ano e também, de um dia para o outro, alteram a intensidade do calor e sensação térmica no homem. Porém, deve-se diferenciar desconforto térmico “Stress Térmico” de sobrecarga térmica, uma vez que o primeiro é um conceito que, entre outros fatores, depende principalmente da sensibilidade das pessoas, podendo variar de pessoa para pessoa ou de uma região para outra. A sobrecarga térmica, no entanto, é um problema para qualquer pessoa em qualquer região, visto que a natureza humana é a mesma. Embora o parâmetro térmico estabelecido na NR 17 refira-se as atividades que exijam solicitação intelectual sabe-se que o calor excessivo é extremamente 
	desconfortável para o corpo humano, portanto, recomenda-se, sempre que possível, o uso de ventilação forçada nos ambientes quentes e a reposição de água e sais minerais durante a exposição.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recomenda-se atenção quanto à orientação nos cuidados com a possibilidade de choque térmico, devido o deslocamento constante entre as áreas operacionais e setores climatizados da área administrativa, sobretudo no período do verão, quando as diferenças de temperaturas são acentuadas, podendo agravar sintomas de gripes; resfriados; infecções de garganta e sistema respiratório. Deve-se fazer uma regulagem adequada dos condicionadores de ar, evitando o direcionamento do vento frio direto no corpo humano, o que pode acarretar um desconforto térmico por frio excessivo.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A umidade relativa do ar pode ficar baixa no período de inverno, e os aparelhos de ar-condicionado tradicionais irão ressecar ainda mais os ambientes, portando recomenda-se o monitoramento da umidade relativa do ar neste período, preferindo apenas ventilar o ambiente e manter as janelas abertas, o que auxilia também a troca do ar.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recomenda-se ainda, adotar o uso de telas de naylon para prevenir o acesso de insetos e poeira no ambiente de trabalho.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quanto ao ruído no setor, embora não seja um fator de risco relevante a saúde, sabemos que o ruído acima de 65 dB (A) em postos de trabalho que se exige a solicitação intelectual, pode causar irritabilidade, dificuldade de concentração e interferem no rendimento das tarefas e na incidência de erros humanos. Recomenda-se  a correção no âmbito de redução ou eliminação para uma adequação ergonômica.<p align=justify>";
	
	$code .= "<b>Iluminância</b><br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A iluminância também é um fator importante nos ambientes de trabalho, assim como os agentes concomitantes, tais como: reflexos (em telas, displays e superfícies de trabalho) e ofuscamentos. Quando a iluminância por classe de tarefas visuais de acordo com as avaliações apresentam níveis de iluminância abaixo do mínimo recomendado para o ambiente, necessita-se uma correção com ampliação da quantidade de luminárias ou da intensidade das lâmpadas (Voltagem).";
	
    //$code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [10] 
/****************************************************************************************************************/
	$code .= "<p align=justify>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quando os postos de trabalhos em ambientes administrativos verificar-se que uma iluminação não é homogênea, apresentando deficiência nas superfícies das mesas. Em alguns casos, apenas um dos lados das mesas acarretando problemas, devido apenas a localização, quer seja da luminária ou das mesas. Todos os casos devem ser relatados na planilha de identificação e análises e planilha de avaliação pró-ativa de riscos, com recomendação para intervenção no ambiente.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Uma orientação recomendável é o uso de luminárias individuais nas mesas, que proporcionam o conforto da utilização de mais ou menos, luz pelo próprio usuário, conforme a necessidade.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nos casos de uso de monitores tipo CRT, com incidência de reflexo. Recomendamos a substituição dos mesmos por modelos atuais do tipo LCD em que os reflexos são mínimos ou adoção de proteção de telas.<p align=justify>";
	
	$code .= "<b>Carga Fisiológica</b><br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nas atividades dos setores administrativos onde a carga de trabalho é leve e sem transmissão de calor radiante, não há gastos energéticos excessivos ao contrário dos setores operacionais em que ocorrem desgastes energéticos moderados / excessivos por ventura da necessidade de acompanhamento das atividades em operacionais, permanecendo em pé por muito tempo, ou inspeções de itens de segurança com movimentação por toda a área operacional. As atividades foram observadas e acompanhadas com as taxas de metabolismo por tipo de atividade, expressos no quadro III do anexo III da NR 15.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As atividades que merecem atenção são aquelas realizadas nas áreas operacionais com deslocamento por toda a produção, movimentação de cargas, subida e descida de escadas, abertura e fechamento de válvulas, manuseio de cargas puxadas em carrinho manualmente, entre outras. Essas atividades quando realizadas com exposição à carga solar ou calor artificial nos enclausuramentos, aumentam a carga fisiológica podendo provocar a fadiga em menos tempo. A proporção em que a carga de trabalho físico aumenta, necessita-se de uma temperatura mais amena a fim de proporcionar e manter um conforto, devido os músculos em movimento produzirem calor durante o trabalho braçal “físico”, é recomendado manter a temperatura abaixo de 20º C. (Recomenda-se a avaliação das possíveis melhorias já sugeridas na planilha pró-ativa de riscos). Com as intervenções ergonômicas de modificação de projetos cabíveis como: carrinhos para transporte de cargas de materiais com 	força motriz; carro de transporte de carga vertical “elevador de carga” para transporte de cargas, peças para fabricação, reposição e ferramentas em subida e descida, evitando assim esforços nos degraus das escadas diversas vezes.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Realizar manutenção do condicionamento físico com ginástica laboral e avaliação médica específica. Recomenda-se, para colaboradores com idade igual ou superior a 45 anos e lotados em áreas de produção e operacionais, exames de avaliação cardiorrespiratória; Eletrocardiograma; Teste Ergométrico.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O tópico relacionado a “LER” se aplica em nível de ocorrência intermitente, nas atividades de uso do computador por longo período, principalmente nas atividades de planejamento, cargos de coordenação e gerência, em todo o setor administrativo recomendam-se a orientação para a prática de exercícios de alongamento e relaxamento por ocasião das pausas e procura médica imediata ao perceber incidência de dores nos punhos, cotovelos e ombros.";
		
    //$code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [11] 
/****************************************************************************************************************/
	
	$query_l = "select * from cliente_setor where id_ppra = $cod_cgrt and tipo_setor = 'Administrativo'";
	$result_l = pg_query($query_l);
	$r_l = pg_fetch_all($result_l);
				
	$code .= "<p align=justify>";
	$code .= "<b>Carga Mental</b><br>";
	$code .= "Analisando os setores administrativos, observou-se as seguintes considerações:<br>";
	
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
	$code .= "Analisando os setores operacionais, observou-se as seguintes considerações:<br>";
	
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
						
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Caracterizadas as ocorrências consideramos a verbalização de relatos específicos e frequentes, buscando assim auxiliar a administração da empresa ".$info[razao_social]." na adoção de medidas preventivas e corretivas quando couber.  A coleta de informações do quadro populacional serviu-nos também como indicador demonstrativo destas anomalias, por exemplo, vale dizer que mesmo no momento da entrevista percebe-se a incidência de resistência e hostilidade por ocasião da mesma, devido a interrupção ao trabalho e ou o alto índice de stress, a carga mental excessiva pode desencadear um quadro de stress físico e mental (doença gastrointestinais, desordens do sono, dores nas costas, tensão muscular, cansaço excessivo, dor de cabeça, fadiga ou estafa, irritabilidade, problemas familiares), insatisfação profissional e a incidência de erros humanos, tida no aspecto ocupacional como “Falha Humana”  ou “Ato Inseguro” podendo os mesmos serem 
	provenientes de um desses fatores relacionados.<br>";

	if($info[terceirizado] == "sim"){
		$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Em meio aos riscos caracterizados na análise pró-ativa de riscos, destaca-se um fator específico relacionado a existência de profissionais lotados por empresas  na condição de terceirizadas para prestação de serviços, com política diferenciada em vários aspectos como, plano de cargos e salários, acesso a treinamento, embora executem uma mesma função. A indefinição relacionada quanto ao pessoal registrado na ".$info[rezao_social]." assim como o fato de um outro profissional da empresa terceirizada, estar subordinado a outro de mesmo nível ou até de menor nível constitui-se um entrave a ser gerenciado.<br>";
	}else{
		$code .= "&nbsp;<br>";
	}
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nos casos de identificação desse tipo de ocorrência requer uma intervenção da administração da ".$info[razao_social]." buscando priorizar uma política igualitária causando assim um efeito de minimização do impacto de diferenças que afetam diretamente a saúde ocupacional ou indiretamente trazendo efeitos na qualidade de vida e bem estar.<br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;É importante ressaltar a relevância do assunto, pois mal gerenciado pode afetar diretamente no rendimento operacional e organizacional da empresa.  A lentidão e burocracia do sistema de gestão, nesses casos, cria uma atmosfera de desmotivação, incerteza ocasionando gargalos e emperro na administração dos recursos humanos, atravancando a performance da empresa e acarretando a perda de pessoal qualificado para a boa gestão do processo.<br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Outro fator que merece a atenção especial é o trabalho produzido por mão de obra terceirizada. Quando a empresa contratada para o serviço não institui a mesma equivalência da política de segurança, saúde ocupacional e de meio ambiente deve-se exigir, na contratação da empresa, cópias dos documentos pertinentes a essas medidas, caso contrário pode ocasionar acidentes por parte de prestadores terceirizados desatentos as determinações da administração contratante e desmotivação da equipe populacional da ".$info[razao_social]." por submeterem-se a uma política que não é exigida ao efetivo da empresa terceirizada.<BR>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Há outro fator relevante a se abordar, quando a equipe administrativa adentra a área operacional e muda-se a metodologia de trabalho, onde há a necessidade de observar manuais, códigos etc, quando em paradas e partidas exigindo uma atenção maior do que a habitual exposição “Direta Eventual” a atividade principal exige monotonia em sua maior parte do tempo com tarefas repetitivas todos os dias, especialmente depois de certo tempo ocupada a função.<br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nesses casos recomenda-se a implantação de ações que promovam a descontração e o alívio da tensão acumulado durante o trabalho, bem como a discussão de formas de trabalho com combinação de tarefas que torne o trabalho mais interessante.<p align='justify'>";
	
	$code .= "<b>Aspectos Psicossociais</b><br>";
	
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Neste tópico procuramos avaliar os aspectos relacionados com autonomia se as atividades limitam o trabalhador e não dão possibilidade de escolher quando e como fizer o trabalho.<br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A falta do trabalho em equipe resulta na escassez de consulta aos trabalhadores sobre mudanças, integração ou existência de conflitos entre níveis hierárquicos, indivíduos, grupos e setores. Treinamento, oportunidade, apoio, incentivo e financiamento de treinamento e aprendizagem de novas técnicas.<BR>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fator potencial a valorização e reconhecimento, oportunidade de crescimento e premiação por colaboração nas melhorias de processo.<br>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Trabalho em turnos que proporcionam desajuste e perturbações funcionais.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Esses fatores podem causar diversos problemas relacionados à insatisfação profissional e erros humanos, além de contribuir para o aumento do stress, muitas vezes um profissional permanece no emprego e guarda angústia por estar naquela empresa ou por exercer aquela função. Quem trabalha desmotivado tem o rendimento prejudicado e atravanca o desempenho da equipe e da empresa ou busca oportunidades em outras empresas acarretando alta rotatividade, perda de tempo e custos de recolocação de profissional.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Existe certa restrição de autonomia no âmbito gerencial, que impede a tomada de decisões de quem conhece melhor o ambiente de trabalho e as necessidades de mudança, ficando a critério da diretoria que não está no mesmo ambiente de trabalho diariamente, arbitrar sobre questões do exercício operacional, até mesmo pelo advento de novas técnicas que surgem com frequência e a administração toma conhecimento muito tempo após elas serem implantadas no mercado e são grandes facilitadores de produtividade em uma empresa.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No tópico “Equipe” podemos evidenciar a incidência de gargalo do processo produtividade, por falta de treinamento, integração e comunicação constante, ficando a própria chefia a cargo disso. É importante que sejam efetivadas ações concretas com políticas direcionadas para a gestão participativa, com a prática de consultar a equipe sobre mudanças e melhorias a serem feitas no setor. Da mesma forma a empresa carece de espaço e atividades específicas de descontração e lazer, que promovam a interação entre equipes e setores, bem como propiciem ocasiões para facilitar a comunicação e o apoio mútuo. Este problema é acentuado pela própria localização da empresa em uma área isolada dos centros urbanos e a frieza intrínseca de uma estrutura industrial. Em outras palavras, é importante humanizar cada vez mais o ambiente de trabalho valorizando assim a importância dos relacionamentos e dos próprios indivíduos, em meio às máquinas.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Segundo a teoria de motivação de Abraham Maslow, as pessoas são motivadas por uma série de necessidades, desde as básicas ou primárias como: comer, beber e vestir-se, até as mais sofisticadas como: Autorrealização, autoestima, reconhecimento, importância, apreço aos demais, desejo de prestígio e status. Quando cada pessoa alcança satisfação razoável de uma dada necessidade, movimenta-se para satisfazer outra necessidade maior.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Desta forma recomendamos aumentar a motivação através de uma reestruturação do trabalho com envolvimento dos líderes, tornar o trabalho interessante e compensador para o trabalhador “Ajudar o trabalhador a fazer mais planejamento do trabalho; Fazer o trabalhador participar mais das decisões de trabalho; Dar feedback regular no desempenho; Não intervir excessivamente; Estar disponível a ajudar e ser entusiasta a respeito da organização, do trabalho e das pessoas”.";

    $code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [12] --> AVALIAÇÃO PRELIMINAR 1ª PARTE
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
    $code .= "<td class='bgtitle' align=center colspan=2><b>Avaliação Preliminar e Gerenciamento de Riscos Ergonômicos $info[ano]</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=center colspan=2><b>Identificação e Análise</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Instalação:</b></td>";
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
	
    $code .= "<td align=left width=25%><b>Função:</b></td>";
	$code .= "<td align=left width=75%>"; 
		for($w=0;$w<pg_num_rows($func);$w++){
			$code .= "{$fff[$w][nome_funcao]}; ";
		}
	$code .= "</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Nº de Funcionários:</b></td>";
	$code .= "<td align=left width=75%>".str_pad(pg_num_rows($func), 2, "0", 0)."</td>";
	$code .= "</tr>";
	
	$habil = "SELECT DISTINCT(habilidade) 
		FROM funcionarios f, cgrt_func_list cl 
		WHERE f.cod_func = cl.cod_func AND cl.cod_cgrt = $cod_cgrt AND f.cod_setor = {$avl[$x][cod_setor]}
		AND f.cod_cliente = cl.cod_cliente";
	$habilit = pg_query($habil);
	$hab = pg_fetch_array($habilit);
	
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Exigências/Habilidades Necessárias:</b></td>";
	$code .= "<td align=left width=75%>{$hab[habilidade]}</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Tipo de Atividade:</b></td>";
	$code .= "<td align=left width=75%>{$avl[$x][tipo_setor]}</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Dinâmica da Atividade:</b></td>";
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
    $code .= "<td align=left width=25%><b>Alvo da Avaliação:</b></td>";
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
    $code .= "<td class='bgtitle' align=center colspan=2><b>Memória Fotográfica</b></td>";
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
	$code .= "<td align=left><b>Descrição: </b>";
		for($z=0;$z<pg_num_rows($rag);$z++){
			$code .= "{$sagent[$z][fonte_geradora]}; ";
		}
	$code .= "</td>";
	$code .= "</tr>";
	$code .= "</table>";
	
	$code .= "<div class='pagebreak'></div>";
	
	/************************************************************************************************************/
	// -> AVALIAÇÃO PRELIMINAR 2ª PARTE
	/************************************************************************************************************/
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$code .= "<tr>";
    $code .= "<td class='bgtitle' align=center colspan=2><b>Histórico</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Instalação:</b></td>";
	$code .= "<td align=left width=75%>{$avl[$x][descricao]}</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Máquina e Equip. Utilizados:</b></td>";
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
    $code .= "<td align=left width=25%><b>Verbalização Principal:</b></td>";
	$code .= "<td align=left width=75%>{$avl[$x][verba]}</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Objetivo da Avaliação:</b></td>";
	$code .= "<td align=left width=75%>Possibilitar a correção do ambiente de trabalho e melhorar as condições de trabalho</td>";
	$code .= "</tr>";
	
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Data da Avaliação:</b></td>";
	$code .= "<td align=left width=75%>".date("d/m/Y", strtotime($info[data_avaliacao]))."</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=left width=25%><b>Data da Próxima Revisão:</b></td>";
	$code .= "<td align=left width=75%>".date("d", strtotime($info[data_avaliacao]))."/".date("m", strtotime($info[data_avaliacao]))."/{$p}</td>";
	$code .= "</tr>";
	$code .= "</table>";
	
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$code .= "<tr>";
    $code .= "<td class='bgtitle' align=center colspan=6><b>Análise Pró-Ativa de Riscos Ergonômicos</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=center width=15%><b>Agente</b></td>";
	$code .= "<td align=center width=17%><b>Caracterização</b></td>";
	$code .= "<td align=center width=17%><b>Risco</b></td>";
	$code .= "<td align=center width=17%><b>Priorização do Risco</b></td>";
	$code .= "<td align=center width=17%><b>Providências</b></td>";
	$code .= "<td align=center width=17%><b>Providência Ergonômica</b></td>";
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
	// -> AVALIAÇÃO PRELIMINAR 3ª PARTE
	/************************************************************************************************************/
	//---------ERGONÔMIA
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$code .= "<tr>";
    $code .= "<td class='text' align=left><b>Ergonômia Risco Analisado</b></td>";
	$code .= "</tr>";
	$code .= "</table>";
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$code .= "<tr>";
    $code .= "<td align=left width=10%><b>&nbsp;</b></td>";
	$code .= "<td align=center colspan=2 width=40%><b>Antecipação do Risco</b></td>";
	$code .= "<td align=center width=25%><b>Priorização do Risco</b></td>";
	$code .= "<td align=center colspan=2 width=25%><b>Conduta Ergonômica</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=center >Agente</td>";
	$code .= "<td align=center width=13%>Causa</td>";
	$code .= "<td align=center width=27%>Sintomas</td>";
	$code .= "<td align=center >Ações e Medidas</td>";
	$code .= "<td align=center width=12%>Providências</td>";
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
	$code .= "<td align=center colspan=2 width=40%><b>Antecipação do Risco</b></td>";
	$code .= "<td align=center width=25%><b>Priorização do Risco</b></td>";
	$code .= "<td align=center colspan=2 width=25%><b>Conduta Ergonômica</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=center >Agente</td>";
	$code .= "<td align=center width=13%>Caracterização</td>";
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
	$code .= "<td align=center>Iluminância</td>";
		if($alu[t] < $alu[lux_recomendado]){
			$code .= "<td align=center>Abaixo do limite permitido</td>";
			$code .= "<td align=center>Dores de cabeça</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>Pouca iluminação</td>";
			$code .= "<td align=center>Fazer o dimensionamento da iluminação</td>";
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
		$code .= "<td align=center>Desprezível</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
	}
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=center>Ruído</td>";
	if($ctrl[ruido_operacao_setor] > '85.00' && $ctrl[cod_tipo_risco] == 1){
		$code .= "<td align=center>Acima do Limite</td>";
		$code .= "<td align=center>{$ctrl[diagnostico]}&nbsp;</td>";
		$code .= "<td align=center>{$ctrl[diagnostico]}&nbsp;</td>";
		$code .= "<td align=center>{$ctrl[geradora]}&nbsp;</td>";
		$code .= "<td align=center>Uso de Protetor Auricular</td>";
	}else{
		$code .= "<td align=center>Desprezível</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
	}
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=center>Ventilação</td>";
	if($ctrl[cod_vent_art] == 3 and $ctrl[cod_parede] == 1){
		$code .= "<td align=center>Ambiente abafado</td>";
		$code .= "<td align=center>Mal estar</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>Ambiente abafado</td>";
		$code .= "<td align=center>Instalar ar-condicionado ou circulador de ar</td>";
	}else{
		$code .= "<td align=center>Desprezível</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
	}
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=center>Presença Química</td>";
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
		$code .= "<td align=center>Não</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
	}
	$code .= "</tr>";
	
	$code .= "<tr>";
	$code .= "<td align=center>Vibração</td>";
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
		$code .= "<td align=center>Não</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
	}
	$code .= "</tr>";
	
	$code .= "<tr>";
	$code .= "<td align=center>Radiação Ionizante</td>";
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
		$code .= "<td align=center>Não</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
	}
	$code .= "</tr>";
	
	$code .= "<tr>";
	$code .= "<td align=center>Radiação não Ionizante</td>";
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
		$code .= "<td align=center>Não</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
		$code .= "<td align=center>N/H</td>";
	}
	$code .= "</tr>";
	
	$code .= "</table>";
	
	$code .= "<p>";
	
	//-----CARGA FISIOLÓGICA
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$code .= "<tr>";
    $code .= "<td class='text' align=left><b>Carga Fisiológica</b></td>";
	$code .= "</tr>";
	$code .= "</table>";
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$code .= "<tr>";
    $code .= "<td align=left width=10%><b>&nbsp;</b></td>";
	$code .= "<td align=center colspan=2 width=40%><b>Antecipação do Risco</b></td>";
	$code .= "<td align=center width=25%><b>Priorização do Risco</b></td>";
	$code .= "<td align=center colspan=2 width=25%><b>Conduta Ergonômica</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=center >Gasto Energético</td>";
	$code .= "<td align=center width=13%>Caracterização</td>";
	$code .= "<td align=center width=27%>Fonte Geradora</td>";
	$code .= "<td align=center >Meio de Controle Existente</td>";
	$code .= "<td align=center width=12%>Sintoma</td>";
	$code .= "<td align=center width=13%>Medida de Controle no Trabalhador</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=center >Manuseio de Carga</td>";
	if($ctrl[m_carga] == '' || $ctrl[m_carga] == 'não'){
		$code .= "<td align=center >Não</td>";
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
	if($ctrl[desloc] == '' || $ctrl[desloc] == 'não'){
		$code .= "<td align=center >Não</td>";
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
		$code .= "<td align=center >Não</td>";
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
	$code .= "<td align=center colspan=2 width=40%><b>Antecipação do Risco</b></td>";
	$code .= "<td align=center width=25%><b>Priorização do Risco</b></td>";
	$code .= "<td align=center colspan=2 width=25%><b>Conduta Ergonômica</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=center >Organização</td>";
	$code .= "<td align=center width=13%>Caracterização</td>";
	$code .= "<td align=center width=27%>Fonte Geradora</td>";
	$code .= "<td align=center >Meio de Controle Existente</td>";
	$code .= "<td align=center width=12%>Sintoma</td>";
	$code .= "<td align=center width=13%>Medida de Controle no Trabalhador</td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=center > </td>";
	$code .= "<td align=center >Ritmo da produtividade</td>";
	$code .= "<td align=center >Atividade realizada</td>";
	$code .= "<td align=center >Alternância do quadro de horário</td>";
	$code .= "<td align=center >Stress mental</td>";
	$code .= "<td align=center >Alternância do quadro de horário</td>";
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
	$code .= "<td align=center colspan=2 width=40%><b>Antecipação do Risco</b></td>";
	$code .= "<td align=center width=25%><b>Priorização do Risco</b></td>";
	$code .= "<td align=center colspan=2 width=25%><b>Conduta Ergonômica</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
    $code .= "<td align=center >Equipe</td>";
	$code .= "<td align=center width=13%>Caracterização</td>";
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
	
	$code .= "<b>Conclusão e Considerações:</b> A avaliação classificou como moderado o risco caracterizando assim tolerável em todos os tópicos.<br>";
	$code .= "<b>Concepção:</b> Recomenda-se que se façam as implementações para redução dos riscos.";

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
        $code .= "<div class='mainTitle' align=center><center><b>ANEXO<BR>POSTO DE SERVIÇO</b></center></div>";
        $code .= "<BR><p align=justify>";
        $code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
        $code .= "<tr>";
        $code .= "<td>Razão social:</td><td>$ptinfo[razao_social]</td>";
        $code .= "</tr><tr>";
        $code .= "<td>Endereço: </td><td>$ptinfo[endereco], $ptinfo[num_end]</td>";
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
		$code .= "<td class='bgtitle' align=center colspan=2><b>Avaliação Preliminar e Gerenciamento de Riscos Ergonômicos $info[ano]</b></td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center colspan=2><b>Identificação e Análise</b></td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Instalação:</b></td>";
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
		
		$code .= "<td align=left width=25%><b>Função:</b></td>";
		$code .= "<td align=left width=75%>"; 
			for($w=0;$w<pg_num_rows($func);$w++){
				$code .= "{$fff[$w][nome_funcao]}; ";
			}
		$code .= "</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Nº de Funcionários:</b></td>";
		$code .= "<td align=left width=75%>".str_pad(pg_num_rows($func), 2, "0", 0)."</td>";
		$code .= "</tr>";
		
		$habil = "SELECT DISTINCT(habilidade) 
			FROM funcionarios f, cgrt_func_list cl 
			WHERE f.cod_func = cl.cod_func AND cl.cod_cgrt = $cod_cgrt AND f.cod_setor = {$avl[$x][cod_setor]}
			AND f.cod_cliente = cl.cod_cliente";
		$habilit = pg_query($habil);
		$hab = pg_fetch_array($habilit);
		
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Exigências/Habilidades Necessárias:</b></td>";
		$code .= "<td align=left width=75%>{$hab[habilidade]}</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Tipo de Atividade:</b></td>";
		$code .= "<td align=left width=75%>{$avl[$x][tipo_setor]}</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Dinâmica da Atividade:</b></td>";
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
		$code .= "<td align=left width=25%><b>Alvo da Avaliação:</b></td>";
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
		$code .= "<td class='bgtitle' align=center colspan=2><b>Memória Fotográfica</b></td>";
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
		$code .= "<td align=left><b>Descrição: </b>";
			for($z=0;$z<pg_num_rows($rag);$z++){
				$code .= "{$sagent[$z][dsc_agente]}; ";
			}
		$code .= "</td>";
		$code .= "</tr>";
		$code .= "</table>";
		
		$code .= "<div class='pagebreak'></div>";
		
		/************************************************************************************************************/
		// -> AVALIAÇÃO PRELIMINAR 2ª PARTE
		/************************************************************************************************************/
		$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
		$code .= "<tr>";
		$code .= "<td class='bgtitle' align=center colspan=2><b>Histórico</b></td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Instalação:</b></td>";
		$code .= "<td align=left width=75%>{$avl[$x][descricao]}</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Máquina e Equip. Utilizados:</b></td>";
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
		$code .= "<td align=left width=25%><b>Verbalização Principal:</b></td>";
		$code .= "<td align=left width=75%>{$avl[$x][verba]}</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Objetivo da Avaliação:</b></td>";
		$code .= "<td align=left width=75%>Possibilitar a correção do ambiente de trabalho e melhorar as condições de trabalho</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Data da Avaliação:</b></td>";
		$code .= "<td align=left width=75%>&nbsp;</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=left width=25%><b>Data da Próxima Revisão:</b></td>";
		$code .= "<td align=left width=75%>&nbsp;</td>";
		$code .= "</tr>";
		$code .= "</table>";
		
		$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
		$code .= "<tr>";
		$code .= "<td class='bgtitle' align=center colspan=6><b>Análise Pró-Ativa de Riscos Ergonômicos</b></td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center width=15%><b>Agente</b></td>";
		$code .= "<td align=center width=17%><b>Caracterização</b></td>";
		$code .= "<td align=center width=17%><b>Risco</b></td>";
		$code .= "<td align=center width=17%><b>Priorização do Risco</b></td>";
		$code .= "<td align=center width=17%><b>Providências</b></td>";
		$code .= "<td align=center width=17%><b>Providência Ergonômica</b></td>";
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
		// -> AVALIAÇÃO PRELIMINAR 3ª PARTE
		/************************************************************************************************************/
		//---------ERGONÔMIA
		$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
		$code .= "<tr>";
		$code .= "<td class='text' align=left><b>Ergonômia Risco Analisado</b></td>";
		$code .= "</tr>";
		$code .= "</table>";
		$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
		$code .= "<tr>";
		$code .= "<td align=left width=10%><b>&nbsp;</b></td>";
		$code .= "<td align=center colspan=2 width=40%><b>Antecipação do Risco</b></td>";
		$code .= "<td align=center width=25%><b>Priorização do Risco</b></td>";
		$code .= "<td align=center colspan=2 width=25%><b>Conduta Ergonômica</b></td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center >Agente</td>";
		$code .= "<td align=center width=13%>Causa</td>";
		$code .= "<td align=center width=27%>Sintomas</td>";
		$code .= "<td align=center >Ações e Medidas</td>";
		$code .= "<td align=center width=12%>Providências</td>";
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
		$code .= "<td align=center colspan=2 width=40%><b>Antecipação do Risco</b></td>";
		$code .= "<td align=center width=25%><b>Priorização do Risco</b></td>";
		$code .= "<td align=center colspan=2 width=25%><b>Conduta Ergonômica</b></td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center >Agente</td>";
		$code .= "<td align=center width=13%>Caracterização</td>";
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
		$code .= "<td align=center>Iluminância</td>";
			if($alu[t] < $alu[lux_recomendado]){
				$code .= "<td align=center>Abaixo do limite permitido</td>";
				$code .= "<td align=center>Dores de cabeça</td>";
				$code .= "<td align=center>N/H</td>";
				$code .= "<td align=center>Pouca iluminação</td>";
				$code .= "<td align=center>Fazer o dimensionamento da iluminação</td>";
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
			$code .= "<td align=center>Desprezível</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
		}
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center>Ruído</td>";
		if($ctrl[ruido_operacao_setor] > '85.00' && $ctrl[cod_tipo_risco] == 1){
			$code .= "<td align=center>Acima do Limite</td>";
			$code .= "<td align=center>{$ctrl[diagnostico]}&nbsp;</td>";
			$code .= "<td align=center>{$ctrl[diagnostico]}&nbsp;</td>";
			$code .= "<td align=center>{$ctrl[geradora]}&nbsp;</td>";
			$code .= "<td align=center>Uso de Protetor Auricular</td>";
		}else{
			$code .= "<td align=center>Desprezível</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
		}
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center>Ventilação</td>";
		if($ctrl[cod_vent_art] == 3 and $ctrl[cod_parede] == 1){
			$code .= "<td align=center>Ambiente abafado</td>";
			$code .= "<td align=center>Mal estar</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>Ambiente abafado</td>";
			$code .= "<td align=center>Instalar ar-condicionado ou circulador de ar</td>";
		}else{
			$code .= "<td align=center>Desprezível</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
		}
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center>Presença Química</td>";
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
			$code .= "<td align=center>Não</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
		}
		$code .= "</tr>";
		
		$code .= "<tr>";
		$code .= "<td align=center>Vibração</td>";
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
			$code .= "<td align=center>Não</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
		}
		$code .= "</tr>";
		
		$code .= "<tr>";
		$code .= "<td align=center>Radiação Ionizante</td>";
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
			$code .= "<td align=center>Não</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
		}
		$code .= "</tr>";
		
		$code .= "<tr>";
		$code .= "<td align=center>Radiação não Ionizante</td>";
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
			$code .= "<td align=center>Não</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
			$code .= "<td align=center>N/H</td>";
		}
		$code .= "</tr>";
		
		$code .= "</table>";
		
		$code .= "<p>";
		
		//-----CARGA FISIOLÓGICA
		$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
		$code .= "<tr>";
		$code .= "<td class='text' align=left><b>Carga Fisiológica</b></td>";
		$code .= "</tr>";
		$code .= "</table>";
		$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
		$code .= "<tr>";
		$code .= "<td align=left width=10%><b>&nbsp;</b></td>";
		$code .= "<td align=center colspan=2 width=40%><b>Antecipação do Risco</b></td>";
		$code .= "<td align=center width=25%><b>Priorização do Risco</b></td>";
		$code .= "<td align=center colspan=2 width=25%><b>Conduta Ergonômica</b></td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center >Gasto Energético</td>";
		$code .= "<td align=center width=13%>Caracterização</td>";
		$code .= "<td align=center width=27%>Fonte Geradora</td>";
		$code .= "<td align=center >Meio de Controle Existente</td>";
		$code .= "<td align=center width=12%>Sintoma</td>";
		$code .= "<td align=center width=13%>Medida de Controle no Trabalhador</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center >Manuseio de Carga</td>";
		if($ctrl[m_carga] == '' || $ctrl[m_carga] == 'não'){
			$code .= "<td align=center >Não</td>";
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
		if($ctrl[desloc] == '' || $ctrl[desloc] == 'não'){
			$code .= "<td align=center >Não</td>";
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
			$code .= "<td align=center >Não</td>";
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
		$code .= "<td align=center colspan=2 width=40%><b>Antecipação do Risco</b></td>";
		$code .= "<td align=center width=25%><b>Priorização do Risco</b></td>";
		$code .= "<td align=center colspan=2 width=25%><b>Conduta Ergonômica</b></td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center >Organização</td>";
		$code .= "<td align=center width=13%>Caracterização</td>";
		$code .= "<td align=center width=27%>Fonte Geradora</td>";
		$code .= "<td align=center >Meio de Controle Existente</td>";
		$code .= "<td align=center width=12%>Sintoma</td>";
		$code .= "<td align=center width=13%>Medida de Controle no Trabalhador</td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center > </td>";
		$code .= "<td align=center >Ritmo da produtividade</td>";
		$code .= "<td align=center >Atividade realizada</td>";
		$code .= "<td align=center >Alternância do quadro de horário</td>";
		$code .= "<td align=center >Stress mental</td>";
		$code .= "<td align=center >Alternância do quadro de horário</td>";
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
		$code .= "<td align=center colspan=2 width=40%><b>Antecipação do Risco</b></td>";
		$code .= "<td align=center width=25%><b>Priorização do Risco</b></td>";
		$code .= "<td align=center colspan=2 width=25%><b>Conduta Ergonômica</b></td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td align=center >Equipe</td>";
		$code .= "<td align=center width=13%>Caracterização</td>";
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
		
		$code .= "<b>Conclusão e Considerações:</b> A avaliação classificou como moderado o risco caracterizando assim tolerável em todos os tópicos.<br>";
		$code .= "<b>Concepção:</b> Recomenda-se que se façam as implementações para redução dos riscos.";
	
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
	$code .= "<td align=left width=40%><b>Risco da Função:</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=left width=40%>Em pé</td>";
	$code .= "<td align=left width=40%>Pés e pernas (varizes)</td>";
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=left width=40%>Sentado sem encosto</td>";
	$code .= "<td align=left width=40%>Músculos extensores do dorso</td>";
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=left width=40%>Assento muito alto</td>";
	$code .= "<td align=left width=40%>Parte inferior das pernas, joelhos e pés</td>";
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=left width=40%>Assento muito baixo</td>";
	$code .= "<td align=left width=40%>Dorso e pescoço</td>";
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=left width=40%>Braços esticado</td>";
	$code .= "<td align=left width=40%>Ombros e braços</td>";
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=left width=40%>Pegas inadequadas em ferramentas</td>";
	$code .= "<td align=left width=40%>Antebraços</td>";
	$code .= "</tr>";
	$code .= "</table>";
	
	$code .= "<p align=justify>";
	
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As atividades quando desenvolvidas na empresa pelos funcionários do setor administrativo caracterizarem-se por trabalho em pé e eventualmente sentado, de natureza moderada, com movimentos sequenciais, repetitivos em relação ao uso das mãos, pulsos e braços, com jornada de trabalho diurna.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recomendações oficiais normatizadoras emitidas pelo Ministério do Trabalho e do Emprego, a respeito dos riscos ocupacionais em geral (portaria SSST/ MTE Nº 24 de 29/12/94, portaria SSST / MTE Nº 08 de 08/05/96 e Nº 17 de 25/06/96, estabelecem critérios limitados e restringem o discernimento do médico examinador para a caracterização dos mesmos).<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Assim, algumas condições incidentes nos setores operacionais, como por exemplo, os distúrbios circulatórios nos membros inferiores (possivelmente determinados por posturas prolongadas na posição de pé), embora se constituam em fatores de interesse no desencadeamento de desordens orgânicas relacionadas ao trabalho, não são legalmente considerados como condições de risco ocupacional.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;De acordo com a NR17 item 17.3.5 para as atividades em que os funcionários devam ser realizados de pé, devem ser colocados assentos para descanso em locais em que possam ser utilizados por todos os funcionários durante as pausas.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nas atividades de serviços gerais do tipo faxina, por exemplo, afecções articulares, sobretudo nos cotovelos e ombros, podem ocorrer em função dos esforços repetitivos sobre tais juntas durante a execução de serviços com demanda de vassouras, rodos, etc. Bem como naqueles de esfregação de vidraças, pisos e janelas em tais operações, os membros superiores são mobilizados estendidos para a realização de movimentos circulares acima do plano da cabeça e também com extensão da mesma, postura empregada para a limpeza da parte superior de paredes, portas, janelas, etc. Por outro lado, a postura com flexão prolongada dos membros inferiores e o contato com superfícies úmidas, predispõem ao desencadeamento/ agravamento de desordens circulatórias(micro-varizes, varizes e estase).<p align=justify>";
	
	$code .= "<b>Limpeza e Ordem:</b>";
	$code .= "&nbsp;&nbsp;O local de trabalho apresentar – se organizado, limpo e desimpedido, notadamente nas vias de circulação, passagens e escadarias.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O entulho e quaisquer sobras de materiais devem ser regularmente coletados e removidos. Por ocasião de sua remoção, devem ser tomados cuidados especiais, de forma a evitar poeira excessiva e eventuais riscos.<p align=justify>";
	
	$code .= "<b>Acão Prevencionista:</b>";
	$code .= "&nbsp;&nbsp;A nossa ação prevencionista é composta de palestra para conscientização sobre a prevenção aos riscos eminente no ambiente onde estará desenvolvendo suas tarefas. O treinamento é fundamental para que o trabalhador conheça todo o procedimento a ser tomado e com isso ele possa estar apto a sua função.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O EPI é um dos fatores principais para essa ação, porque será com ele que evitará possíveis lesões oriundas do acidente e possibilitará que a jornada laborativa torne sua rotina de trabalho mais segura.";
				
	$code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [14] --> AVALIAÇÕES AMBIENTAIS
/****************************************************************************************************************/
	$code .= "<b>Avaliações Ambientais:</b><br>";
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$code .= "<tr>";
	$code .= "<td width=25% align=center colspan=2><b>Setor/Quantidade</b></td>";
	$code .= "<td width=15% align=center ><b>Agente Risco</b></td>";
	$code .= "<td width=18% align=center ><b>Fonte Geradora</b></td>";
	$code .= "<td width=9% align=center ><b>Nível</b></td>";
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
		$code .= "<td width=15% align=center >Controlável</td>";
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
	$code .= "<td width=100% align=left><b>Data da Vistoria Técnica:</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=justify >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A vistoria ocorreu no dia ".date("d", strtotime($info[data_avaliacao]))." de ".$meses[date("n", strtotime($info[data_criacao]))]." de {$info[ano]}, no interior da empresa: <b> {$info[razao_social]}</b>. Devidamente classificada, setores administrativos bem como setores operacionais.</td>";
	$code .= "</tr>";
	$code .= "</table>";
	
	$code .= "<p>";
	
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$code .= "<tr>";
	$code .= "<td align=center ><b>Setor:</b> {$avl[$x][nome_setor]}</td>";
	$code .= "<td align=center ><b>Nº de Colaboradores:</b> ".str_pad(pg_num_rows($ttal), 2, "0", 0)."</td>";
	$code .= "<td align=center ><b>Atividade:</b> {$avl[$x][tipo_setor]}</td>";
	$code .= "</tr>";
	$code .= "</table>";
	
	$code .= "<p>";
	
	$code .= "<b>Dinâmica da Função:</b>";
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
	
	$code .= "<b>Diagnóstico dos Riscos:</b>";
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
	
	$code .= "<b>Sugestão:</b>";
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
	$code .= "<b>Recomendações / Conclusão</b><p align=justify>";
	$code .= "&nbsp;Considerados que os dados obtidos devem ser adequadamente observados as seguintes recomendações:<p align=justify>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O resultado da avaliação médica e/ou relatório anual do PCMSO, deverá ser discutido em reunião com presença do médico examinador.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Programas de ginástica laboral preventiva e/ou exercícios físicos corretivos de postura devem ser estabelecidos, sob orientação e supervisão técnica e compatibilizando idade, sexo e limitações individuais.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Desenvolvimento de campanhas periódicas de conscientização e combate ao fumo, álcool, drogas e sedentarismo.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Iniciativas de combate ao stress, com incentivo ás atividades de lazer e outras inerentes ao aprimoramento das relações humanas.<br>";
	$code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Divulgação de recomendações e exercícios para prevenir e/ou atenuar os distúrbios circulatórios dos membros inferiores, inclusive para realização doméstica.<p>";
	
	$code .= "Rio de Janeiro, ".date("d", strtotime($info[data_avaliacao]))." de ".$meses[date("n", strtotime($info[data_criacao]))]." de {$info[ano]}";
	
	$code .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$code .= "<tr>";
	$code .= "<td align=center width=50%><b>Revisado por</b></td>";
	$code .= "<td align=center width=50%><b>Aprovado por</b></td>";
	$code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td align=center >$flist[nome]<br>Médica do Trabalho<br>Reg. $flist[registro]<br>&nbsp;</td>";
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
// incorpora o corpo ao PDF na posição 2 e deverá ser interpretado como footage. Todo footage é posicao 2 ou 0(padrão).
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