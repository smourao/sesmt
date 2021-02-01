<?PHP
/*****************************************************************************************************************/
// -> INCLUDES / DEFINES
/*****************************************************************************************************************/
define('_MPDF_PATH', '../../../common/MPDF45/');
define('_IMG_PATH', '../../../images/');
include(_MPDF_PATH.'mpdf.php');
include("../../../common/includes/database.php");
include("../../../common/includes/functions.php");

/*****************************************************************************************************************/
// -> VARS
/*****************************************************************************************************************/
$cod_cgrt = (int)($_GET[cod_cgrt]);
$code     = "";
$header_h = 75;//header height;
$footer_h = 75;//footer height;
$meses    = array('', 'Janeiro',  'Fevereiro', 'Mar�o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$m        = array("", "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");
$alfabeto = "a";

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

//LTCAT
$prod1 = array(440, 441, 442, 443, 444, 445, 446, 447, 1009, 1010, 1011, 1012, 1013, 1014,
448, 804, 805, 890, 892, 894, 896, 942, 1015, 1016, 1017, 1018, 1019, 1020);
//MAPA RISCO1
$prod2 = array(963, 965);
//MAPA RISCO2
$prod3 = array(422, 964);
//CIPA
$prod4 = array(897, 840);
//BRIGADA
$prod5 = array(982);
//PROC ELEITORAL
$prod6 = array(980, 981);
//ASO
$prod7 = array(891, 893, 895, 928, 929, 930, 931, 932);
//PPRA
$prod8 = array(423, 966, 967, 967, 968, 969, 970, 971, 990, 991, 992, 993, 994, 995, 996);//array(423, 945, 946, 947, 948, 949, 950, 951);
//PPP
$prod9 = array(933, 934, 935, 936, 937, 938, 939, 940);
//PCMSO
$prod10= array(424, 952, 953, 954, 955, 956, 957, 958);
//APGRE
$prod11= array(972, 973, 974, 975, 976, 977, 978, 979, 1003, 1004, 1005, 1006, 1007, 1008);
//CURSO EPI
$prod12= array(431);
//CURSOS
//$id_curso = array(425, 426, 427, 428, 429, 430, 431, 772,840, 897,  941, 982, 983);
$id_curso = array(425, 426, 427, 428, 429, 430, 431, 772,/*840, 897,*/981,  941, 982, 983);

//PPRA
$id_ppra = array(423, 966, 967, 967, 969, 970, 971, 990, 991, 992, 993, 994, 995, 996);
$id_visita_tecnica = array(70042);

/*****************************************************************************************************************/
// -> DATA / QUERYS / JOBS
/*****************************************************************************************************************/
$sql = "SELECT * FROM site_gerar_contrato WHERE id = ".(int)(anti_injection($_GET[id]))." AND cod_cliente = ".(int)(anti_injection($_GET[cod_cliente]));
$rct = pg_query($sql);
if(pg_num_rows($rct)){
    $contract = pg_fetch_array($rct);
}else{
    die("N�o foi poss�vel a exibi��o deste contrato. [Inconsist�ncia de dados - contrato]");
}
$vencimento = explode("-", $contract[vencimento]);
/***************************************************************************************************************/
$sql = "SELECT * FROM cliente WHERE cliente_id = ".(int)(anti_injection($_GET[cod_cliente]));
$rcl = pg_query($sql);
if(pg_num_rows($rcl)){
    $cliente = pg_fetch_array($rcl);
}else{
    die("N�o foi poss�vel a exibi��o deste contrato. [Inconsist�ncia de dados - cliente]");
}

/***************************************************************************************************************/
$sql = "SELECT op.*, p.preco_prod, p.desc_detalhada_prod, p.desc_resumida_prod, p.cod_atividade FROM site_orc_produto op, produto p WHERE op.cod_orcamento = ".(int)($contract[cod_orcamento])." AND op.cod_cliente = ".(int)($contract[cod_cliente])." AND (p.cod_prod = op.cod_produto)";
$rpi = pg_query($sql);
if(pg_num_rows($rpi)){
    $pd = pg_fetch_all($rpi);
    $valor_total = 0;
    for($x=0;$x<pg_num_rows($rpi);$x++){
        if(!empty($pd[$x][preco_aprovado]))
            $valor_total += $pd[$x][preco_aprovado] * $pd[$x][quantidade];
        else
            $valor_total += $pd[$x][preco_prod] * $pd[$x][quantidade];
    }
    $vt = $valor_total;
    $sql = "SELECT cod_produto FROM site_orc_produto WHERE cod_orcamento = ".(int)($contract[cod_orcamento]);
    $rp = pg_query($sql);
    if(pg_num_rows($rp)){
        $pl = pg_fetch_all($rp);
        $il = array();
        for($p=0;$p<pg_num_rows($rp);$p++){
           $il[] = $pl[$p][cod_produto];
        }
    }else{
        die("N�o foi poss�vel a exibi��o deste contrato. [Inconsist�ncia de dados - or�amento]");
    }
}else{
    die("N�o foi poss�vel a exibi��o deste contrato. [Inconsist�ncia de dados - or�amento]");
}
/***************************************************************************************************************/
    $sql = "SELECT * FROM brigadistas WHERE classe = '$cliente[classe]'";
    $rbr = pg_query($sql);
    $row_calc = pg_fetch_array($rbr);

    $menor = $row_calc['ate_10'];
    $maior = $row_calc['mais_10'];
    $quantidade = $cliente[numero_funcionarios];

    if($quantidade <= 10)
 	    $calculo = $quantidade*($menor/100);
 	else
  	    $calculo = 10*($menor/100)+($quantidade-10)*($maior/100);

    $chefe=1;
    $lider=1;
    if($calculo > 0)
       $membros_brigada = round($calculo, 0)-2;
    else
       $membros_brigada = 0;
/***************************************************************************************************************/

/*****************************************************************************************************************/
// -> FUN��ES
/*****************************************************************************************************************/
function servicos($items){
    //LTCAT
    $prod1 = array(440, 441, 442, 443, 444, 445, 446, 447, 1009, 1010, 1011, 1012, 1013, 1014,
    448, 804, 805, 890, 892, 894, 896, 942, 1015, 1016, 1017, 1018, 1019, 1020);
    //MAPA RISCO1
    $prod2 = array(963, 422);
    //MAPA RISCO2
    $prod3 = array(965, 964);
    //CIPA
    $prod4 = array(897, 840);
    //BRIGADA
    $prod5 = array(982);
    //PROC ELEITORAL
    $prod6 = array(/*980, */981);
    //ASO
    $prod7 = array(891, 893, 895, 928, 929, 930, 931, 932);
    //PPRA
    $prod8 = array(423, 966, 967, 967, 968, 969, 970, 971, 990, 991, 992, 993, 994, 995, 996);//array(423, 945, 946, 947, 948, 949, 950, 951);
    //PPP
    $prod9 = array(933, 934, 935, 936, 937, 938, 939, 940);
    //PCMSO
    $prod10= array(424, 952, 953, 954, 955, 956, 957, 958);
    //APGRE
    $prod11= array(972, 973, 974, 975, 976, 977, 978, 979, 1003, 1004, 1005, 1006, 1007, 1008);
    //CURSO EPI
    $prod12= array(431);
    //Presta��o de Servi�o em Assessoria � Organiza��o de Processo Eleitoral, Elei��o em Scrutino Secreto, Apura��o de Vota��o, Confec��o de Ata de Elei��o e Posse, Registro de Gest�o da CIPA � Comiss�o Interna de Preven��o de Acidente, Junto ao Mte.
    $prod13= array(980);
    //PPR
    $prod14 = array(950, 951, 984, 985, 986, 987, 988, 989);
    //LAUDO DE INSALUBRIDADE
    $prod15 = array(7298);
	
//	$prod16 = array(70107);
//	$prod17 = array(70116);
	
    $id_visita_tecnica = array(70042);

    //CURSOS
    $id_curso = array(425, 426, 427, 428, 429, 430, 431, 772,840, 897,  941, 982, 983);
    //PPRA
    $id_ppra = array(423, 966, 967, 967, 969, 970, 971, 990, 991, 992, 993, 994, 995, 996);

    $tmp = "";
    for($x=0;$x<count($items);$x++){
        if(in_array($items[$x], $prod1)){
           $tmp .= " Laudo T�cnico de Condi��es Ambiental de Trabalho - LTCAT; ";
        }else if(in_array($items[$x], $prod2)){
           $tmp .= "Elabora��o e Implementa��o de Mapa de Risco Ambiental Geral Formato A0; ";
        }else if(in_array($items[$x], $prod3)){
           $tmp .= "Elabora��o e Implementa��o de Mapa de Risco Setorial Formato A3; ";
        }else if(in_array($items[$x], $prod4)){
           $tmp .= "Ministra��o de Curso da CIPA - Comiss�o Interna de Preven��o de Acidentes; ";
        }else if(in_array($items[$x], $prod5)){
           $tmp .= "Treinamento de Preven��o de Brigada Contra Inc�ndio; ";
        }else if(in_array($items[$x], $prod6)){
           $tmp .= "Assessoria � CIPA - Comiss�o Interna de Preven��o de Acidente; ";
        }else if(in_array($items[$x], $prod7)){
           $tmp .= "Emiss�o de ASO - Atestado e Sa�de Ocupacional; ";
        }else if(in_array($items[$x], $prod8)){
           $tmp .= "Elabora��o e Implementa��o do PPRA - Programa de Preven��o a Risco Ambiental; ";
        }else if(in_array($items[$x], $prod9)){
           $tmp .= "Emis�o do PPP - Perfil Profissiogr�fico Previdenci�rio; ";
        }else if(in_array($items[$x], $prod10)){
           $tmp .= "Elabora��o e Implementa��o do PCMSO - Programa de Controle M�dico e Sa�de Ocupacional; ";
        }else if(in_array($items[$x], $prod11)){
           $tmp .= "Elabora��o e Implementa��o de APGRE - Avalia��o Preliminar e Gerenciamento de Riscos Ergon�micos; ";
        }else if(in_array($items[$x], $prod12)){
           $tmp .= "Presta��o de Servi�o em Treinamento Sobre Uso do EPI - Equipamento de Prote��o Individual, Contendo Forma de Higieniza��o, Guarda dos Equipamentos e o Uso de Forma Adequada a Atender a Necessidade Prevencionista; ";
        }else if(in_array($items[$x], $prod13)){
           $tmp .= "Presta��o de Servi�o em Assessoria � Organiza��o de Processo Eleitoral, Elei��o em Scrutino Secreto, Apura��o de Vota��o, Confec��o de Ata de Elei��o e Posse, Registro de Gest�o da CIPA - Comiss�o Interna de Preven��o de Acidente - Junto ao Mte; ";
        }else if(in_array($items[$x], $prod14)){
           $tmp .= "Elabora��o e Implementa��o do PPR - Programa de Prote��o Respirat�ria com base ao PPRA;";
        }else if(in_array($items[$x], $prod15)){
           $tmp .= "Elabora��o do Relat�rio T�cnico de Laudo de Insalubridade;";
        } /*else if(in_array($items[$x], $prod16)){
           $tmp .= "An�lise de Fumo n�o Met�lico (Enxofre);";
        }else if(in_array($items[$x], $prod17)){
           $tmp .= "An�lise de Ru�do Dosimetria (Dos�metro);";
        }*/
		else{
			$ss = "SELECT * FROM produto WHERE cod_prod = '$items[$x]'";
			$qq = pg_query($ss);
			$aa = pg_fetch_array($qq);
			$tmp .= $aa[desc_resumida_prod].";";
		}
    }
   $tmp .= "(\"Servi�os\")";
   return $tmp;
}
/*************************************************************************************************/
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
        $cabecalho .= "<td align=left height=$header_h> </td>";
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }else{
        $cabecalho  = "<div style=\"text-align: right;\"><font size=1>P�gina {PAGENO} de {nb}</font></div>";
        $cabecalho .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
        $cabecalho .= "<tr>";
        $cabecalho .= "<td align=left height=$header_h valign=top>";
        $cabecalho .= "<span class='bigTitle'><b>SESMT<sup>�</sup></b></span>";
        $cabecalho .= "<BR>";
        $cabecalho .= "SERVI�OS ESPECIALIZADOS DE SEGURAN�A";
        $cabecalho .= "<BR>";
        $cabecalho .= "E MONITORAMENTO DE ATIVIDADES NO TRABALHO EIRELI";
        $cabecalho .= "";
        $cabecalho .= "</td>";
        $cabecalho .= "<td align=left height=$header_h width=300>
        <table width=100% cellspacing=2 cellpadding=2 border=0>
        <tr>
        <td><b>N� DO CONTRATO:</b></td><td>$cliente[ano_contrato].".str_pad($cliente[cliente_id], 4,"0",STR_PAD_LEFT)."</td>
        </tr><tr>
        <td><b>CNPJ:</b></td><td>04.722.248/0001-17</td>
        </tr><tr>
        <td><b>INSC. MUN.:</b></td><td>311.213-6</td>
        </tr>
        </table>
        </td>";
        $cabecalho .= "</tr>";
        /*
        $cabecalho .= "<tr>";
        $cabecalho .= "<td colspan=2>CNPJ 04.722.248/0001-17&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;INSC. MUN. 311.213-6</td>";
        $cabecalho .= "</tr>";
        */
        $cabecalho .= "</table>";
    }
    /************************************************************************************************************/
    // -> FOOTER
    /************************************************************************************************************/
    //assinatura
    /*
    if($_GET[sem_assinatura])
        $rodape  = "";
    else
        $rodape  = "<div style=\"position: relative; text-align: right; width: 100%\"><img src='"._IMG_PATH."ass_medica.png' border=0 width='180' height='110'></div>";
    */
    if($_GET[sem_timbre]){
        $rodape .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$footer_h>";
        $rodape .= "<tr>";
        $rodape .= "<td align=left height=$footer_h> </td>";
        $rodape .= "</tr>";
        $rodape .= "</table>";
    }else{
        $rodape .= "<table width=100% border=0 cellspacing=0 cellpadding=0>";
        $rodape .= "<tr>";
        $rodape .= "<td>";
        $rodape .= "
        <b>Telefone: +55 (21) 3014 4304      Fax: Ramal 7</b>
        <br>Nextel: +55 (21) 7844 9394 / Id 55*23*31368
        <br>faleprimeirocomagente@sesmt-rio.com / juridico@sesmt-rio.com
        <br>www.sesmt-rio.com / www.shoppingsesmt.com";
        $rodape .= "</td>";
        $rodape .= "<td align=right><div style=\"width: 85px; text-align: left;\"><b>Pensando em<BR>renovar seus<BR>programas?<BR>Fale primeiro<BR>com a gente!</b></div></td>";
        $rodape .= "</tr>";
        $rodape .= "</table>";
    }
    $code .= "<html>";
    $code .= "<head>";
    $code .= "</head>";
    $code .= "<body>";
    
/****************************************************************************************************************/
// -> PAGE [1]
/****************************************************************************************************************/
    $code .= "";
    $code .= "<div style=\"text-align: center;\"><b>CONTRATO DE PRESTA��O DE SERVI�OS ".strtoupper($contract[tipo_contrato])."</b></div>";
    $code .= "<p align=justify>";
    $code .= "<b>SESMT SERVI�OS ESPECIALIZADOS DE SEGURAN�A E MONITORAMENTO DE ATIVIDADES NO TRABALHO EIRELI</b> sociedade devidamente constitu�da e validamente existente de acordo com as leis do Brasil, inscrita no CNPJ sob o n� 04.722.248/0001-17 e com Inscri��o Municipal n� 311.213-6, situada na Rua Marechal Ant�nio de Souza, 92 na Cidade Rio de Janeiro, Estado RJ, Tel. 21-3014 4304 Ramal 25, fax. 21-3014 4304 Ramal. 25, aqui representada pelo Sr. Pedro Henrique da Silva, RG 000994-6 DDSSD / SIT / MTE, a seguir denominada <b>CONTRATADA</b>.";
    $code .= "<p align=justify>";
    $code .= "<b>".strtoupper($cliente[razao_social])."</b> sociedade devidamente constitu�da e validamente existente de acordo com as leis do Brasil, com sede na $cliente[endereco] $cliente[num_end], $cliente[bairro], munic�pio $cliente[municipio], e estado $cliente[estado], tel. $cliente[telefone], inscrito no CNPJ sob n� $cliente[cnpj], neste ato representado em conformidade com seu contrato social / estatuto, daqui por diante denominada <b>CONTRATANTE</b>;  e.";
    $code .= "<p align=justify>";
    $code .= "(conjuntamente denominadas \"Partes\", e individualmente \"Parte\").";
    $code .= "<p align=justify>";
    $code .= "<b>CONSIDERANDO QUE</b>, de acordo com as NR 9.1.1 que estabelece a obrigatoriedade da elabora��o de implanta��o, por parte de todos os empregadores e institui��es que admitam trabalhadores como empregados, do Programa de Preven��o de Riscos Ambientais - PPRA, visando a preven��o da sa�de e da integridade dos trabalhadores, atrav�s da antecipa��o, reconhecimento, avalia��o e consequentemente o controle de ocorr�ncias de riscos ambientais que existam ou que venha a existir no ambiente de trabalho.";
    $code .= "<p align=justify>";
    $code .= "<b>CONSIDERANDO QUE</b>, nos termos da legisla��o vigente, (artigo 168 da Consolida��o das Leis de Trabalho, Portaria 24 SSST, de 29 de dezembro de 1994; Portaria n� 8, de 08 de Maio de 1996; Normas Regulamentadoras n� 5, 7, 9 e 17, e Instru��o Normativa n� 99 do INSS, entre outros, conforme alterados). � obrigat�rio, por parte dos empregadores, elaborar e implementar: Programa de Controle M�dico de Sa�de Ocupacional (\"PCMSO\"); Programa de Preven��o de Riscos Ambientais (\"PPRA\"); Laudo T�cnico de Condi��es Ambientais do Trabalho (\"LTCAT\"); Perfil Profissiogr�fico Previdenci�rio (\"PPP\"); Mapas de Riscos (\"MR\"); Laudos Ergon�micos (\"Laudos Ergon�micos\"); Atestados de Sa�de Ocupacional (\"ASO\"); proferir palestras e promover campanhas de vacina��o Antigripal e antitet�nica, entre outros;";
    $code .= "<p align=justify>";
    $code .= "<b>CONSIDERANDO QUE</b>, em resposta ao or�amento emitido de n� ".str_pad($contract[cod_orcamento], 4, "0", STR_PAD_LEFT)."/$contract[ano_orcamento] da CONTRATANTE, a CONTRATADA encaminhou � CONTRATANTE uma proposta comercial, documentos anexos ao presente instrumento (\"<b>ANEXO 1</b>\");";
    $code .= "<p align=justify>";
    $code .= "<b>CONSIDERANDO QUE</b>, a CONTRATADA possui a experi�ncia e os recursos necess�rios para prestar os servi�os objeto do presente instrumento;";
    $code .= "<p align=justify>";
    $code .= "<b>RESOLVEM</b>: justas e acertadas, celebrar o presente Contrato de Presta��o de Servi�os (\"Contrato\"), que se reger� pelas seguintes cl�usulas e condi��es:";
    $code .= "<p align=justify>";

    $code .= "<b>CL�USULA PRIMEIRA - DO OBJETO DO CONTRATO</b>";
    $code .= "<p align=justify>";
    
    $code .= "1.1 O presente Contrato tem por finalidade a presta��o dos servi�os de: ".servicos($il).".";
    $code .= "<p align=justify>";
    
    if($cliente[numero_funcionarios] > 19)
        $code .= "<b>Par�grafo �nico</b>: O curso para cipistas eleitos s� poder�o ser ministrados para os membros votados em scrutino secreto, para esses casos os cursos poder�o ser ministrados nas instala��es da CONTRATANTE. Obedecendo o calend�rio de cronograma de a��es de gest�o da CIPA que consta no ambiente pesquisa no site: www.sesmt-rio.com acesso atrav�s do bot�o cliente de cor laranja e no bot�o \"servi�os\".";
    else
        $code .= "<b>Par�grafo �nico</b>: Na forma da lei quando a empresa n�o estiver enquadrada na obrigatoriedade de manter a CIPA (Comiss�o Interna de Preven��o de Acidentes), constitu�da a mesma acatar� o disposto na NR 5.6.4. Nesses casos em que se designar um candidato ao curso o mesmo ser� minsitrado na instala��o da CONTRATADA em dias agendados pelo CONTRATANTE no site: www.sesmt-rio.com acesso atrav�s do bot�o cliente de cor laranja e no bot�o \"servi�os\".";

    $code .= "<p align=justify>";
    
    $code .= "<b>CL�USULA SEGUNDA - DA OBRIGA��O DA CONTRATADA</b>";
    $code .= "<p align=justify>";
    
    $code .= "2.1 Constituem obriga��es da CONTRATADA:";
    $code .= "<p align=justify>";

    $code .= "($alfabeto) Elaborar e implantar o PCMSO para a CONTRATANTE, de acordo com as Especifica��es T�cnicas constantes na NR 7, considerando as NR`s 15 e 17.";
    $code .= "<p align=justify>";
    $alfabeto++;

    $code .= "($alfabeto) Realizar todos os atendimentos e exames m�dicos previstos no PCMSO (exames m�dicos admissionais, peri�dicos, de retorno ao trabalho, de mudan�a de fun��o e demissionais), incluindo avalia��o cl�nica, anamnese ocupacional, exame f�sico e mental e coordenar a todos os exames complementares. Nos funcion�rios da CONTRATANTE. Todos os exames m�dicos peri�dicos poder�o ser realizados nas depend�ncias da CONTRATANTE, desde que seja feito um adeno, logo que assinado o contrato viabilizando o acordo (\"<b>ANEXO 2</b>\"), para isso a CONTRATANTE contar� com a necessidade de equipamentos, como: Maca, Balan�a, Escadinha de Maca, Arquivo com chaves, Mesa composta de cadeiras para o profissional examinador e o paciente, a sala deve ser arejada com ar condicionado e ou ventilador.";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Avaliar e determinar a periodicidade da realiza��o dos exames m�dicos aplic�veis;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Emitir todos os ASO`s, conforme aplic�vel, para tanto as solicita��es se dar�o por acesso a internet no endere�o www.sesmt-rio.com, bot�o cliente; clicar em  bot�o servi�o; no link agendamento, o mesmo dever� ocorrer em at� 72 horas de anteced�ncia em alguns casos poder� levar at� 120 horas de acordo com a complexidade do exame complementar solicitado pelo m�dico coordenador do PCMSO, todo e qualquer exame exigido antes das 72 horas a CONTRATADA fica desobrigada de cumprir por for�a da necessidade dos resultados dos exames complementares esses quando solicitados.";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "<b>Par�grafo �nico</b>: A CONTRATANTE declara possuir um efetivo populacional registrado em CTPS de ($cliente[numero_funcionarios]) vidas, que se submeteram a exames cl�nicos ocupacioal; exames complementares \"sempre que solicitado pelo m�dico coordenador do PCMSO NR7\" e elabora��o do PPP - Perfil Profissiogr�fico Previdenci�rio.";
    $code .= "<p align=justify>";

    $code .= "($alfabeto) Manter prontu�rio cl�nico individual em arquivo por per�odo n�o inferior a 20 anos de todos os empregados da CONTRATANTE, solicitar da �ltima contratada o arquivo f�sico da CONTRATANTE para posse e guarda fiel dos mesmos periodicamente manuse�-lo a fim de garantir a organiza��o e comprobabilidade dos mesmos;";
    $code .= "<p align=justify>";
    $alfabeto++;

    $code .= "($alfabeto) Emitir e apresentar � CONTRATANTE relat�rio m�dico anual, conforme aplic�vel;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Elaborar e implementar o PPRA para a CONTRATANTE de acordo com as especifica��es t�cnicas constantes na NR 9, devendo acompanhar e avaliar periodicamente at� o cumprimento total de todos os servi�os contratados;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Elaborar Mapa de Risco Geral em tamanho \"A3\" e 02 (Dois) mapas de riscos setoriais em tamanhos tamb�m \"A4\", para os locais indicados pela CIPA da CONTRATANTE. Os mapas de riscos dever�o ser entregues com impress�o colorida;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Realizar o levantamento das condi��es ergon�micas, e emitir o relat�rio t�cnico de avalia��o ergon�micos, conforme aplic�vel;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Elaborar e implantar o LTCAT e o PPP, mantendo-os atualizados, conforme aplic�vel. O arquivo eletr�nico dos PPP`s emitidos dever�o ser disponibilizados para a �rea de RH/ADM da CONTRATANTE, via sistema internet no endere�o www.sesmt-rio.com, atrav�s da senha de uso particular no bot�o cliente;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    // LETRA K S� ESTAR DISPON�VEL SE TIVER CONSULTORIA � CIPA NO OR�AMENTO
    // RECEBER N�MERO DE FUNCION�RIOS E SUBSTITUIR PELO (00) -> DONE
    //COD 980 e 981
    $sql = "SELECT * FROM site_orc_produto WHERE cod_orcamento = ".(int)($contract[cod_orcamento])." AND cod_produto = 981 OR cod_produto = 980";
    $rct = pg_query($sql);
    if(pg_num_rows($rct)){
        $code .= "($alfabeto) Proferir ($cliente[numero_funcionarios]) treinamento(s) sobre tema(s) relativo(s) � higiene do trabalho e preven��o de acidentes at� o vencimento do contrato, em decorrer a consultoria da CIPA datas e hor�rios a serem acordados com a CONTRATANTE em adeno (\"<b>ANEXO 3</b>\") assinado 72 horas da assinatura do contrato ser�o estes: Palestra sobre uso de EPI e Brigada de Inc�ndio e Curso da CIPA designado NR 5.6.4;";
        $code .= "<p align=justify>";
        $alfabeto++;
    }
    
    //S� SE HOUVER MAIS DE 19 FUNCION�RIOS
    if($cliente[numero_funcionarios] > 19){
        $code .= "($alfabeto) Organizar anualmente a campanha de elei��o para escolha de participantes da CIPA Comiss�o Interna de Preven��o de Acidentes em scrutino secreto, ministra��o do curso para 01 membro, conforme estipula a NR 5.32 lei 6.514/77 e Port. 3.214/78.";
        $code .= "<p align=justify>";
        $alfabeto++;
    }

    //S� SE HOUVER BRIGADA
    $sql = "SELECT * FROM site_orc_produto WHERE cod_orcamento = ".(int)($contract[cod_orcamento])." AND cod_produto = 982";
    $rcy = pg_query($sql);
    if(pg_num_rows($rcy)){
        $code .= "($alfabeto) Constituir a forma��o de brigadistas para preven��o contra inc�ndio constitu�da de (01) Chefe de Equipe, (01) L�der de Equipes e ($membros_brigada) membros.";
        $code .= "<p align=justify>";
        $alfabeto++;
    }
    
    $code .= "($alfabeto) Prover todos os equipamentos e pessoal necess�rio para a correta e completa presta��o dos Servi�os;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Garantir as boas condi��es dos seus consult�rios conveniados para a presta��o dos Servi�os complementares, dotados de todos os equipamentos necess�rios e certifica��es para o cumprimento das obriga��es aqui previstas;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Observar toda legisla��o, regulamenta��es, disciplinas e regulamentos aplic�veis e vigentes quanto a presta��o dos Servi�os; prestando um trabalho com alto padr�o t�cnico e qualidade, nos prazos e condi��es convencionados, fornecendo pessoal qualificado, responsabilizando-se pelos Servi�os prestados; A CONTRATADA se compromete realizar visita T�cnica de integra��o, por profissional da seguran�a, a CONTRATANTE, com chegada programada mensalmente a serem agendadas e pactuadas em adeno t�o logo a assinatura do contrato, para o cumprimento das mesmas por parte da Sesmt Servi�os Especializados de Seguran�a e Monitoramento de Atividade no Trabalho EIRELI. Essas visitas dever�o obedecer ao crit�rio de serem redigidas, impressas e enviadas a CONTRATANTE com c�pia protocolada.";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Responder por todas as despesas e obriga��es relativas a remunera��o, transporte, alimenta��o, eventuais adicionais devidos, previd�ncia social e preven��o contra acidentes relacionadas aos seus empregados alocados para a presta��o dos Servi�os;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Garantir, nos termos da legisla��o em vigor, que os empregados envolvidos na presta��o dos Servi�os utilizem todos os equipamentos de seguran�a necess�rios, quando aplic�vel, isentando-se a CONTRATANTE de qualquer responsabilidade pelos danos causados e/ou sofridos pelos empregados da CONTRATADA por neglig�ncia, imper�cia ou imprud�ncia dos mesmos durante a realiza��o dos procedimentos necess�rios � presta��o dos Servi�os;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Orientar ao respons�vel do Departamento Pessoal ou RH da CONTRATANTE � necessidade de afastamento do trabalhador � exposi��o aos riscos ocupacionais existentes, bem como o encaminhamento do trabalhador � previd�ncia social, para estabelecimento de nexo causal. Avalia��o de incapacidade e defini��o de conduta previdenci�ria em rela��o ao trabalho considerado anormal a fim de evitar qualquer reclama��o trabalhista, previdenci�ria ou c�vel decorrente de acidentes de trabalho atinentes a seus empregados;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Responsabilizar-se pela obten��o de todas as licen�as e alvar�s necess�rios para o fornecimento e execu��o dos Servi�os;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Informar � CONTRATANTE, por escrito, quaisquer atos ou fatos relevantes relativos aos Servi�os;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Refazer os Servi�os considerados, a crit�rio da CONTRATANTE, insatisfat�rios ou incompletos, sem quaisquer custos adicionais.";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) De forma a garantir a qualidade e comprobabilidade dos relat�rios t�cnicos os mesmos dever�o, em decorr�ncia a sa�da ou ingresso de trabalhadores ao quadro funcional,  realizar a manuten��o dos programas do PPRA; PCMSO; LTCAT; Laudo Ergon�mico e o PPP, onde a CONTRATANTE arcar� com os custos desses servi�os, os custos ficam na ordem de R$ 25,00 por m�s sempre que houver manuten��o a sofrer os documentos por for�a de movimenta��o de pessoal <b>\"Pro rata\"</b>.";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "<b>Par�grafo �nico</b>: sempre que solicitado pelo fiscal o prontu�rio m�dico e os exames complementares a CONTRATANTE solicitar� a CONTRATADA para o seu envio at� 72 h da visita do fiscal, n�o responsabilizando a CONTRATADA caso a solicita��o seja por um per�odo de tempo superior ao estabelecido neste contrato.";
    $code .= "<p align=justify>";

    $code .= "<b>CL�USULA TERCEIRA - DA OBRIGA��O DA CONTRATANTE</b>";
    $code .= "<p align=justify>";

    $code .= "3.1 Constituem obriga��es da CONTRATANTE:";
    $code .= "<p align=justify>";

    $code .= "(a) Auxiliar a elabora��o e implementa��o do PCMSO por parte da CONTRATADA; e permitir o acesso da CONTRATADA aos locais necess�rios para a presta��o dos Servi�os;";
    $code .= "<p align=justify>";

    $code .= "(b) Fornecer todos os dados cadastrais de seus empregados para que sejam providenciados os prontu�rios cl�nicos individuais. Informar com anteced�ncia os funcion�rios admitidos, demitidos, mudan�a de fun��o e retorno de licen�a e fornecer dados da contratada anterior � contrata��o da, SESMT Servi�os Especializados de Seguran�a e Medicina do Trabalho EIRELI para solicita��o do arquivo f�sico junto ao mesmo para que a guarda e conserva��o do referido arquivo passe a responsabilidade do m�dico coordenador atual for�a desse contrato;";
    $code .= "<p align=justify>";

    $code .= "(c) Ap�s a migra��o dos E-Docs eletr�nicos e suas hospedagens por parte da CONTRATADA, os relat�rios t�cnicos, ASO�s, PPP�s, Anamin�sias, Fichas M�dicas e Exames Complementares, dever�o ser pela CONTRATANTE resguardados os acessos de forma a proporcionar o imediato acesso por parte das autoridades competentes quando necessitar.";
    $code .= "<p align=justify>";

    $code .= "<b>Par�grafo Primeiro</b>: S� poder�o ter acesso a prontu�rio m�dico, ficha m�dica, anamnese e exames complementares, fiscal m�dico, de forma nenhuma a outra forma��o acad�mica, sempre que o fiscal habilitado solicitar a CONTRATANTE dever� requisitar da CONTRATADA que realizou os exames m�dicos e exames m�dicos complementares o arquivo f�sico para averigua��o do fiscal e ap�s isso acontecer retornar a CONTRATADA para arquivamento.";
    $code .= "<p align=justify>";
    
    $code .= "<b>Par�grafo Segundo</b>: Sempre que o fiscal exigir os programas impressos ap�s notificar o pedido, esse dever� ser processado em papel recicl�vel.";
    $code .= "<p align=justify>";

    $code .= "(d) Cumprir integralmente as normas emanadas do Minist�rio do Trabalho e Emprego, em especial as contidas nas NR 7 (PCMSO); 9 (PPRA); 15 (Insalubridade); 16 (Periculosidade) e a 17 (Riscos Ergon�micos);";
    $code .= "<p align=justify>";
    
    $code .= "(e) Acatar integralmente, dentro do que especifica a lei 6.514/77 e sua portaria 3.214/78, as orienta��es apresentadas por escrito nos programas do (PPRA; PCMSO e APGRE)(LTCAT - IN84 INSS) ou descritas no sistema de relacionamento internet no endere�o www.sesmt-rio.com, de acesso exclusivo do cliente e do operador atendente ambos via login e senha;";
    $code .= "<p align=justify>";
    
    $code .= "(f) N�o caber� ao CONTRATANTE postular direitos sobre mat�ria j� abordada em relat�rio t�cnico (PPRA; PCMSO; LTCAT; APGRE) e n�o cumprido por parte da CONTRATANTE, dessa forma a CONTRATANTE se compromete sempre que cumprida alguma exig�ncia informar a CONTRATADA o cumprimento das mesmas;";
    $code .= "<p align=justify>";
    
    $code .= "(g) descumprimento as determina��es do coordenador dos programas m�dico  e de preven��o a acidentes do trabalho, n�o garantem a efic�cia dos programas do (PPRA e PCMSO, APGRE e todo e qualquer laudo emitido da CONTRATANTE).";
    $code .= "<p align=justify>";
    
    $code .= "(h) A CONTRATANTE se compromete a, em nenhum momento, realizar atendimentos m�dicos ocupacionais (ASO e ou Complementares) sem que seja sob orienta��o da CONTRATADA, havendo este comportamento por parte da CONTATANTE, fica a CONTATADA isenta de responsabilidades, evitando assim a desclassificar o atendimento como proposto nas cl�usulas: 2.1 (b;c;d;e;f)";
    $code .= "<p align=justify>";
    
    $code .= "(i) No caso da CONTRATANTE optar pela escolha de outra empresa que n�o seja a indicada pela CONTRATADA, para realiza��o dos procedimentos m�dicos complementares prescritos no ASO, dever� ser enviado a CONTRATADA o original dos mesmos junto com a anamnese, a fim de que o profissional examinador componha o arquivo f�sico, e atualiza��o da ficha m�dica. Vale dizer que a CONTRATADA fica isenta da desqualifica��o do atendimento conforme determinado na alinea (h);";
    $code .= "<p align=justify>";
    
    $code .= "(j) Enviar mensalmente � CONTRATADA uma rela��o nominal, discriminando os empregados da CONTRATANTE admitidos e demitidos, via sistema internet www.sesmt-rio.com, bot�o cliente e depois em bot�o rela��o de funcion�rio.";
    $code .= "<p align=justify>";
    
    $code .= "(k) Caso ocorra uma nova admiss�o, demiss�o isoladamente ap�s a assinatura do contrato ou dos programas terem sidos confeccionados, a CONTRATANTE dever� pagar, a titulo de manuten��o dos programas, para efeito de atualiza��o conforme exig�ncias das NR`s 7.2.4 e 7.3.1 da lei 6.514/77 e da sua portaria 3.214/78. Para tanto ser� cobrado automaticamente, sempre que realizado o ASO a import�ncia de R$ 25,00 (vinte e cinco reais) inseridos ao valor da Fatura cobrada mensal.";
    $code .= "<p align=justify>";
    
    $code .= "<b>Par�grafo Primeiro</b>: Sempre que houver qualquer que seja a modifica��o seja de layout, na atividade da empresa, da forma de executar suas atividades ou movimenta��o do quadro funcional, dever� comunicar a CONTRATADA imediatamente toda e qualquer altera��o ambiental, mudan�a de layout, mudan�a de pessoal entre setores, mudan�a ou amplia��o de ramo de atividade, atrav�s do site www.sesmt-rio.com em bot�o \"Cliente\" e depois no bot�o visita t�cnica, com uso da senha de acesso.";
    $code .= "<p align=justify>";
    
    $code .= "<b>Par�grafo Segundo</b>: Sempre que ocorrer o registro de ocorr�ncia de acidentes ou comprova��o de doen�a ocupacional, a CONTRATANTE dever� registrar a informa��o atrav�s do site www.sesmt-rio.com no bot�o cliente, em bot�o servi�os \"Mapa Anual de Acidente e Doen�as Ocupacionais\" ou em visita t�cnica prevista para sua empresa mensalmente quando contratado esse servi�o conforme documentos anexos ao presente instrumento (\"<b>ANEXO 4</b>\");";
    $code .= "<p align=justify>";
    
    $code .= "(l) Pagar os exames complementares realizados pela cl�nica conveniada para a mesma que optar pelo atendimento, em boleto do conveniado os custos de exames complementares necess�rios ao controle de trabalhadores submetidos a riscos ocupacionais espec�ficos levantados pelo PPRA - Programa de Preven��o de Riscos Ambientais, ora or�ados separadamente e aprovado pela CONTRATANTE a realiza��o dos mesmos.";
    $code .= "<p align=justify>";
    
    $code .= "(m) Reembolsar ao CONTRATADO os valores de eventuais despesas que se fizerem necess�rias, tais como viagens, estadias, transporte e alimenta��o de profissionais, desde que a presta��o de servi�os ora ajustada ocorra fora do Munic�pio em que estiver locada a CONTRATADA e ou fora do que estiver acordado neste contrato ser� cobrado al�m do reembolso a di�ria no valor de R$ 250,00 por profissional envolvido de n�vel superior e de R$ 170,00 para os de n�vel t�cnico.";
    $code .= "<p align=justify>";
    
    $code .= "(n) A CONTRATANTE compromete-se a efetuar o pagamento dos boletos vincentes e os j� vencidos (quando ocorrer atrasos), atrav�s do documento banc�rio, ficando vedado o dep�sito em conta corrente e sujeito as corre��es de encargos como previsto na cl�usula: 4.5 deste contrato.";
    $code .= "<p align=justify>";
    
    //BUSCAR VALORES DE ENVIO DE CORRESPONDEICA E ENCARGO BANCARIO DO CADASTRO DE PRODUTOS
    $sql = "SELECT * FROM produto WHERE cod_prod = 7302";
    $envio_cor = pg_fetch_array(pg_query($sql));
    $sql = "SELECT * FROM produto WHERE cod_prod = 7303";
    $encargos = pg_fetch_array(pg_query($sql));
    
    $code .= "(o) A CONTRATANTE pagar� em boleto banc�rio a ser emitido pela CONTRATADA a contar da data da assinatura do contrato em favor do CONTRATADO, independente de ter ou n�o iniciado ou conclu�do os servi�os, sob os valores correspondentes da planilha de atendimento e ou proposta emitida pelo CONTRATADO e assinada pela CONTRATANTE, ser� cobrado junto os valores de R$ ".number_format($encargos[preco_prod], 2, ',','.')." (".ltrim(valorPorExtenso($encargos[preco_prod])).") de encargos banc�rios e R$ ".number_format($envio_cor[preco_prod], 2, ',','.')." (".ltrim(valorPorExtenso($envio_cor[preco_prod])).") por envio de correspond�ncias postadas via correios sempre que ocorrer o caso.";
    $code .= "<p align=justify>";
    
    $code .= "<b>CL�USULA QUARTA - DA REMUNERA��O</b>";
    $code .= "<p align=justify>";
    
    
    // VALORES E PAGAMENTOS DESCRITOS ABAIXO.
    if($contract[tipo_contrato] == "aberto"){
        $valor_total = ($valor_total+(($valor_total*18)/100));
        if($contract[n_parcelas] > 3){
            //$valor_total_mod = round(($valor_total+(($valor_total*18)/100)));
            $valor_total_mod = round($vt+($vt*30/100)+($vt*18/100));  //round($valor_total+(($valor_total*30)/100));
        }elseif($contract[n_parcelas] == 1){
            $valor_total_mod = round($vt+($vt*30/100)+($vt*18/100));//round(($valor_total+(($valor_total*30)/100)));
        }else{
            $valor_total_mod = round($vt+($vt*30/100)+($vt*18/100));//round(($valor_total+(($valor_total*30)/100)));
        }
    }else{
        if($contract[n_parcelas] > 3){
            //Acrescimo de 18%
            $valor_total_mod = round(($valor_total+(($valor_total*18)/100)));
        }elseif($contract[n_parcelas] == 1){
            //Desconto de 7% pra pagamento a vista
            //$valor_total_mod = round(($valor_total-(($valor_total*7)/100)));
            $valor_total_mod = $valor_total;
        }else{
            $valor_total_mod = $valor_total;
        }
    }
    
    if($contract[tipo_contrato] == "aberto"){
    //CONTATO ABERTO
        if($contract[n_parcelas] > 3){
            $code .= "4.1 As Partes concordam que a remunera��o da CONTRATADA pela presta��o dos Servi�os ser� a seguinte: <b>R$ ".number_format($valor_total, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, acrescido de taxa de gerenciamento de contrato aberto ficando o cliente livre para praticar exames ocupacionais, sem nenhuma paga a mais. Essa taxa ser� de al�quota de 30% do valor do contrato. Ficando a mensalidade no valor de <b>R$ ".number_format(round($valor_total_mod/$contract[n_parcelas], 2), 2, ",",".")." (".ltrim(valorPorExtenso(round($valor_total_mod/$contract[n_parcelas], 2))).")</b>, pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (".str_replace('reais','',valorPorExtenso($contract[n_parcelas])).") parcelas iguais.";
        }elseif($contract[n_parcelas] == 1){
            $code .= "4.1 As Partes concordam que a remunera��o da CONTRATADA pela presta��o dos Servi�os ser� a seguinte: <b>R$ ".number_format($valor_total_mod, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, acrescido de taxa de gerenciamento de contrato aberto ficando o cliente livre para praticar exames ocupacionais, sem nenhuma paga a mais. Essa taxa ser� de al�quota de 30% do valor do contrato, ficando a mensalidade no valor de <b>R$ ".number_format(round($valor_total_mod/$contract[n_parcelas], 2), 2, ",",".")." (".ltrim(valorPorExtenso(round($valor_total_mod/$contract[n_parcelas], 2))).")</b>, pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (uma) parcela.";
        }else{
            $code .= "4.1 As Partes concordam que a remunera��o da CONTRATADA pela presta��o dos Servi�os ser� a seguinte: <b>R$ ".number_format($valor_total, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, acrescido de taxa de gerenciamento de contrato aberto ficando o cliente livre para praticar exames ocupacionais, sem nenhuma paga a mais. Essa taxa ser� de al�quota de 30% do valor do contrato, ficando a mensalidade no valor de <b>R$ ".number_format(round($valor_total_mod/$contract[n_parcelas], 2), 2, ",",".")." (".ltrim(valorPorExtenso(round($valor_total_mod/$contract[n_parcelas], 2))).")</b>, pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (".str_replace('reais','',valorPorExtenso($contract[n_parcelas])).") parcelas iguais.";
        }
    }elseif($contract[tipo_contrato] == "fechado"){
    //CONTATO FECHADO
        if($contract[n_parcelas] > 3){
            $code .= "4.1 As Partes concordam que a remunera��o da CONTRATADA pela presta��o dos Servi�os ser� a seguinte: <b>R$ ".number_format($valor_total, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, acrescido de taxa de gerenciamento de contrato fechado ficando o cliente livre para praticar exames ocupacionais \"peri�dicos\", exceto no caso dos ASO�s(Atestado de Sa�de Ocupacional) dos tipos: Admissional, demissional e mudan�a de fun��o, sem nenhuma paga a mais. Essa taxa ser� de al�quota de 18% do valor do contrato. Ficando a mensalidade no valor de <b>R$ ".number_format(round($valor_total_mod/$contract[n_parcelas], 2), 2, ",",".")." (".ltrim(valorPorExtenso(round($valor_total_mod/$contract[n_parcelas], 2))).")</b>, pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (".str_replace('reais','',valorPorExtenso($contract[n_parcelas])).") parcelas iguais.";
        }elseif($contract[n_parcelas] == 1){
            $code .= "4.1 As Partes concordam que a remunera��o da CONTRATADA pela presta��o dos Servi�os ser� a seguinte: <b>R$ ".number_format($valor_total, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, ficando o cliente livre para praticar exames ocupacionais \"peri�dicos\", exceto no caso dos ASO�s(Atestado de Sa�de Ocupacional) dos tipos: Admissional, demissional e mudan�a de fun��o, sem nenhuma paga a mais. Pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (uma) parcela.";
        }else{
            $code .= "4.1 As Partes concordam que a remunera��o da CONTRATADA pela presta��o dos Servi�os ser� a seguinte: <b>R$ ".number_format($valor_total, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, ficando o cliente livre para praticar exames ocupacionais \"peri�dicos\", exceto no caso dos ASO�s(Atestado de Sa�de Ocupacional) dos tipos: Admissional, demissional e mudan�a de fun��o, sem nenhuma paga a mais. Ficando a mensalidade no valor de <b>R$ ".number_format(round($valor_total_mod/$contract[n_parcelas], 2), 2, ",",".")." (".ltrim(valorPorExtenso(round($valor_total_mod/$contract[n_parcelas], 2))).")</b>, pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (".str_replace('reais','',valorPorExtenso($contract[n_parcelas])).") parcelas iguais.";
        }

    }elseif($contract[tipo_contrato] == "misto"){
    //CONTATO MISTO
       if($contract[n_parcelas] > 3){
          $code .= "4.1 As Partes concordam que a remunera��o da CONTRATADA pela presta��o dos Servi�os ser� a seguinte: <b>R$ ".number_format($valor_total, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, acrescido de taxa de gerenciamento de contrato aberto ficando o cliente livre para praticar exames ocupacionais \"peri�dicos\", exceto no caso dos ASO�s(Atestado de Sa�de Ocupacional) dos tipos: Admissional, demissional e mudan�a de fun��o, sem nenhuma paga a mais. Essa taxa ser� de al�quota de 18% do valor do contrato. Ficando a mensalidade no valor de <b>R$ ".number_format(round($valor_total_mod/$contract[n_parcelas], 2), 2, ",",".")." (".ltrim(valorPorExtenso(round($valor_total_mod/$contract[n_parcelas], 2))).")</b>, pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (".str_replace('reais','',valorPorExtenso($contract[n_parcelas])).") parcelas iguais.";
       }elseif($contract[n_parcelas] == 1){
          $code .= "4.1 As Partes concordam que a remunera��o da CONTRATADA pela presta��o dos Servi�os ser� a seguinte: <b>R$ ".number_format($valor_total, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, ficando o cliente livre para praticar exames ocupacionais \"peri�dicos\", exceto no caso dos ASO�s(Atestado de Sa�de Ocupacional) dos tipos: Admissional, demissional e mudan�a de fun��o, sem nenhuma paga a mais. Pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (uma) parcela.";
       }else{
          $code .= "4.1 As Partes concordam que a remunera��o da CONTRATADA pela presta��o dos Servi�os ser� a seguinte: <b>R$ ".number_format($valor_total, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, ficando o cliente livre para praticar exames ocupacionais \"peri�dicos\", exceto no caso dos ASO�s(Atestado de Sa�de Ocupacional) dos tipos: Admissional, demissional e mudan�a de fun��o, sem nenhuma paga a mais. Ficando a mensalidade no valor de <b>R$ ".number_format(round($valor_total_mod/$contract[n_parcelas], 2), 2, ",",".")." (".ltrim(valorPorExtenso(round($valor_total_mod/$contract[n_parcelas], 2))).")</b>, pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (".str_replace('reais','',valorPorExtenso($contract[n_parcelas])).") parcelas iguais.";
       }

    }elseif($contract[tipo_contrato] == "especifico" || $contract[tipo_contrato] == "espec�fico"){
       if($contract[n_parcelas] > 3){
          $code .= "4.1 As Partes concordam que a remunera��o da CONTRATADA pela presta��o dos Servi�os ser� a seguinte: <b>R$ ".number_format($valor_total, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, acrescido de taxa de gerenciamento de contrato aberto ficando o cliente livre para praticar exames ocupacionais \"peri�dicos\", exceto no caso dos ASO�s(Atestado de Sa�de Ocupacional) dos tipos: Admissional, demissional e mudan�a de fun��o, sem nenhuma paga a mais. Essa taxa ser� de al�quota de 18% do valor do contrato. Ficando a mensalidade no valor de <b>R$ ".number_format(round($valor_total_mod/$contract[n_parcelas], 2), 2, ",",".")." (".ltrim(valorPorExtenso(round($valor_total_mod/$contract[n_parcelas], 2))).")</b>, pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (".str_replace('reais','',valorPorExtenso($contract[n_parcelas])).") parcelas iguais.";
       }elseif($contract[n_parcelas] == 1){
          $code .= "4.1 As Partes concordam que a remunera��o da CONTRATADA pela presta��o dos Servi�os ser� a seguinte: <b>R$ ".number_format($valor_total, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, ficando o cliente livre para praticar exames ocupacionais \"peri�dicos\", exceto no caso dos ASO�s(Atestado de Sa�de Ocupacional) dos tipos: Admissional, demissional e mudan�a de fun��o, sem nenhuma paga a mais. Pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (uma) parcela.";
       }else{
          $code .= "4.1 As Partes concordam que a remunera��o da CONTRATADA pela presta��o dos Servi�os ser� a seguinte: <b>R$ ".number_format($valor_total, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, ficando o cliente livre para praticar exames ocupacionais \"peri�dicos\", exceto no caso dos ASO�s(Atestado de Sa�de Ocupacional) dos tipos: Admissional, demissional e mudan�a de fun��o, sem nenhuma paga a mais. Ficando a mensalidade no valor de <b>R$ ".number_format(round($valor_total_mod/$contract[n_parcelas], 2), 2, ",",".")." (".ltrim(valorPorExtenso(round($valor_total_mod/$contract[n_parcelas], 2))).")</b>, pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (".str_replace('reais','',valorPorExtenso($_GET[parcelas])).") parcelas iguais.";
       }
    }
    $code .= "<p align=justify>";
    
    $code .= "<b>Par�grafo Primeiro</b>: Os servi�os ora listados na proposta comercial obedecem ao um crit�rio de agrupamento de colaboradores representada da seguinte forma: 1 � 10, 11 � 20, 21 � 50, 51 � 100, 101 � 150, 151 � 250, 251 � 350, 351 � 450, 451 � 500, 501 � 600, 601 � 700, 701 � 800, 801 � 900, 901 � 1000, cabendo sempre que houver manuten��es conforme cl�usulas 2.1(c) par�grafo �nico, 2.1(w) e 3.1(k) ocorrer� altera��o \"Corre��o\" autom�tica da cobran�a obedecendo ao tabelamento de pre�os e a fiel cobran�a para as \"partes\", evitando que a CONTRATADA deixe de receber os valores de direito e salva guardar a CONTRATANTE de continuar pagando valores acima do que devido por parte de ter reduzido o seu quadro funcional.";
    $code .= "<p align=justify>";
    
    $code .= "<b>Par�grafo Segundo</b>: Conforme par�grafo �nico na cl�usula segunda, em que � mencionado o real efetivo da CONTRATANTE, a CONTRATADA recebe como fiel a informa��o. Ficando estabelecido que no momento do cadastramento dos dados funcionais de cada colaborador da CONTRATANTE na confec��o dos relat�rios t�cnicos, ser�o corrigidas as parcelas vincendas e cobrada de uma �nica vez no primeiro vencimento de nova fatura os valores retroativos desde o primeiro vecimento at� onde se detecta a diverg�ncia.";
    $code .= "<p align=justify>";
    
    
    //VERIFICAR TEXTO ��������**|**�������
    if($contract[tipo_contrato] == "misto"){
    //MISTO
        $code .= "(a) Pela a elabora��o e implanta��o do PCMSO e do PPP, incluindo a presta��o dos servi�os de realiza��o de atendimentos e exames, avalia��o de periodicidade de exames, emiss�o de ASO`s, manuten��o de prontu�rios em 02 (dois) meios expedientes semanais e 01 (um) expediente integral por semana e emiss�o de relat�rios anuais, conforme previsto na cl�usula 2.1, a CONTRATANTE pagar� mensalmente � CONTRATADA o valor total, fixo de R$ 3,91 (tr�s reais e noventa e um centavos) por cada um de  seus efetivos empregados lotados na G1 em Duque de Caxias - RJ e o valor total, fixo de R$ 3,01 (tr�s reais e um centavo) por cada um de seus efetivos empregados lotados na G2 do Distrito de Imbarie - Rio de Janeiro - RJ; independente de ter ocorrido qualquer consulta m�dica ocupacional. Esses valores multiplicados por 1.484  (Mil Quatrocentos e Oitenta e Quatro) empregados, obtem-se um total anual de R$ 5.643,74 (Cinco Mil Seiscentos e Quarenta e tr�s reais e Setenta e Quatro centavos).";
        $code .= "<p align=justify>";
        $code .= "(b) Pela elabora��o e implanta��o do PPRA e do LTCAT, conforme previsto na cl�usula 2.1, a CONTRATANTE pagar� � CONTRATADA o valor total, fixo de R$ 4.059,84 (Quatro mil e cinquenta e nove reais e oitenta e quatro centavos), o que ser� dividido e pago em (03) tr�s parcelas mensais, iguais e subsequentes, sendo a primeira parcela devida ap�s (30) trinta dias da assinatura deste Contrato; e a terceira e �ltima parcela devida condicionada � entrega dos documentos correspondentes ao PPRA e ao LTCAT as parcelas ser�o pagas a CONTRATADA nos valores iguais de: R$ 1.353,28 (Um mil trezentos e cinquenta e tr�s reais e vinte e oito centavos).";
        $code .= "<p align=justify>";
        $code .= "(c) Pela elabora��o de Laudo Ergon�mico, conforme previsto na cl�usula 2.1, a CONTRATANTE pagar� � CONTRATADA o valor total, fixo de R$ 5.008,80 (Cinco mil, e oito reais e oitenta centavos), o que ser� dividido e pago em (03) tr�s parcelas mensais, iguais e subseq�entes, sendo a primeira parcela devida ap�s (30) trinta dias da assinatura deste Contrato; e a terceira e �ltima parcela devida condicionada � entrega dos documentos correspondentes ao LAUDO ERGON�MICO as parcelas ser�o pagas a CONTRATADA nos valores iguais de: R$ 1.669,60 (mil, seiscentos e sessenta e nove reais e sessenta centavos).";
        $code .= "<p align=justify>";
        $code .= "(d) Pela elabora��o do MR, conforme previsto na cl�usula 2.1, a CONTRATANTE pagar� � CONTRATADA o valor total, fixo de R$ 990,00 (Novecentos e noventa reais), o que ser� dividido e pago em (03) tr�s parcelas mensais, iguais e subsequentes, sendo a primeira parcela devida ap�s 30 (trinta) dias da assinatura deste Contrato; e a terceira e �ltima parcela devida condicionada � entrega dos documentos correspondentes; ao MR as parcelas ser�o pagas a CONTRATADA nos valores iguais de: R$ 330,00 (Trezentos e trinta reais).";
        $code .= "<p align=justify>";
        $code .= "(e) Pela realiza��o de palestras, conforme previsto na cl�usula 2.1, a CONTRATANTE pagar� � CONTRATADA o valor total, fixo de R$ 150,00 (Cento e cinq�enta reais), por palestra, o que ser� devido ap�s 30 dias da realiza��o de cada palestra;";
        $code .= "<p align=justify>";
        $code .= "(f) Pela vacina��o Antigripal nos empregados e prestadores de servi�os da CONTRATANTE, a mesma pagar� � CONTRATADA o valor fixo de R$ 70,00 (Setenta reais) por pessoa alocada na G1 em Caxias-RJ e o valor fixo de R$ 70,00 (Setenta reais) por pessoa alocada na G2 Imbarie - RJ. Estes pre�os incluem os custos com aplica��o e fornecimento das vacinas e a quantidade a ser paga ser� a realmente executada e atestada pela Fiscaliza��o;";
        $code .= "<p align=justify>";
        $code .= "(g) Pela vacina��o antitet�nica nos empregados e prestadores de servi�os da CONTRATANTE, a mesma pagar� � CONTRATADA o valor fixo de R$ 75,00 (Setenta e cinco reais) por pessoa alocada na G1 em Caxias-RJ e o valor fixo de R$ 75,00 (Setenta e cinco reais) por pessoa alocada na Sede G2 em Imbarie - RJ. Estes pre�os incluem os custos com aplica��o e fornecimento das vacinas e a quantidade a ser paga ser� a realmente executada e atestada pela Fiscaliza��o;";
        $code .= "<p align=justify>";
        $code .= "(h) Pelo servi�o de forma��o de Brigada de inc�ndio a CONTRATANTE pagar� o valor total fixo de R$ 97,00 (Noventa e sete reais), o que ser� dividido em (03) tr�s parcelas iguais e subsequentes, sendo a primeira parcela devida ap�s 30 (trinta) dias da assinatura deste Contrato; e a terceira e �ltima parcela devida condicionada � entrega dos documentos correspondentes; a certifica��o dos brigadistas. As parcelas ser�o pagas a CONTRATADA nos valores iguais de: R$ 2.101,66 (Dois mil cento e um reais e sessenta e seis centavos).";
        $code .= "<p align=justify>";
        $code .= "4.2 Os pagamentos devidos pela CONTRATANTE � CONTRATADA em decorr�ncia deste Contrato somente vencer�o: (I) ap�s 10 dias do envio pela CONTRATADA � CONTRATANTE da respectiva nota fiscal acompanhada de relat�rio resumo de fatura, (\"Anexo 5\") contendo a descri��o dos servi�os prestados e (II) ap�s aprova��o pela CONTRATANTE dos servi�os prestados relatados na nota fiscal pertinente. As partes concordam que a CONTRATANTE n�o pagar� a remunera��o devida � CONTRATADA mediante deposito ou Doc. Banc�rio, e sim que os pagamentos devidos a CONTRATADA ser�o pagos atrav�s de boletos banc�rios ou documentos similares.";
        $code .= "<p align=justify>";
        $code .= "4.3 Na remunera��o prevista na cl�usula 4.1, as Partes concordam que a CONTRATADA incluiu todos os tributos e despesas necess�rias e aplic�veis � presta��o dos Servi�os, inclusive os custos com transportes, refei��es, etc.";
        $code .= "<p align=justify>";
        $code .= "4.4 Todas e quaisquer despesas eventualmente necess�rias � presta��o dos Servi�os e que n�o se encontrem inclu�das na remunera��o prevista na cl�usula 4.1 somente ser�o reembolsadas � CONTRATADA se forem previamente aprovadas por escrito pela CONTRATANTE e devidamente comprovadas pela CONTRATADA.";
        $code .= "<p align=justify>";
        $code .= "4.5 Ocorrendo atraso do pagamento estipulado na cl�usula 4.1, item (a), ser� acrescido � cobran�a multa de 3% (tr�s por cento) mais juros de 0,29% ao dia \"pro rata die\".";
        $code .= "<p align=justify>";
    }else{
        $code .= "4.2 Os pagamentos devidos pela CONTRATANTE � CONTRATADA em decorr�ncia deste Contrato somente ser�o considerado como d�bito: (I) ap�s 05 dias do envio pela CONTRATADA � CONTRATANTE da respectiva nota fiscal acompanhada de relat�rio resumo de fatura, (\"<b>ANEXO 5</b>\") contendo a descri��o dos Servi�os prestados e (II) ap�s aprova��o pela CONTRATANTE dos Servi�os prestados relatados na nota fiscal pertinente. As partes concordam que a CONTRATANTE n�o pagar� a remunera��o devida � CONTRATADA mediante deposito ou Doc. Banc�rio, e sim que os pagamentos devidos a CONTRATADA ser�o pagos atrav�s de boletos banc�rios ou documentos similares.";
        $code .= "<p align=justify>";
        $code .= "4.3 Na remunera��o prevista na cl�usula 4.1, as Partes concordam que a CONTRATADA incluiu todos os tributos e despesas necess�rias e aplic�veis � presta��o dos Servi�os, inclusive os custos com transportes, refei��es, etc.";
        $code .= "<p align=justify>";
        $code .= "4.4 Todas e quaisquer despesas eventualmente necess�rias � presta��o dos Servi�os e que n�o se encontrem inclu�das na remunera��o prevista na cl�usula 4.1 somente ser�o reembolsadas � CONTRATADA se forem previamente aprovadas por escrito pela CONTRATANTE e devidamente comprovadas pela CONTRATADA.";
        $code .= "<p align=justify>";
        $code .= "4.5 Ocorrendo atraso do pagamento estipulado na cl�usula 4.1, item (a), ser� acrescido � cobran�a multa de 3% (tr�s por cento) mais juros de 0,29% ao dia \"pro rata die\".";
        $code .= "<p align=justify>";
    }
    
    if($contract[tipo_contrato] == "especifico"){
       $code .= "4.6 A data do vencimento do documento banc�rio e do pagamento ser� dia <b>$vencimento[2]</b> tratando-se de pagamento avista por ser o contrato de servi�os espec�ficos, \"sendo concedido mais 05 cinco dias corridos como prazo para pagamento sem corre��o ou acr�scimo\".";
       $code .= "<p align=justify>";
   }else{
       $code .= "4.6 A data do vencimento do documento banc�rio e do pagamento ser� todo dia <b>$vencimento[2]</b> de cada m�s, \"sendo concedido mais 05 cinco dias corridos como prazo para pagamento sem corre��o ou acr�scimo\".";
       $code .= "<p align=justify>";
   }
    
    $code .= "<b>CL�USULA QUINTA - DA FORMA DA APRESENTA��O DOS SERVI�OS</b>";
    $code .= "<p align=justify>";
    
    $code .= "5.1 Os programas t�cnicos que correspondem � engenharia de seguran�a do trabalho e de higiene do trabalho ser�o apresentados de forma on-line em site da CONTRATANTE www.sesmt-rio.com, atrav�s de uso da sua senha pessoal, seu passaporte como administrador ser� o e-mail cadastrado e a senha ser� cadastrada secretamente, quando efetuar ou atualizar seu cadastro.";
    $code .= "<p align=justify>";
    
    $code .= "5.2 A CONTRATANTE como administradora poder� gerar dois usu�rios secund�rios da senha do administrador, com passaportes e senhas diferentes do administrador, cabe ao administrador limitar o acesso dos dois usu�rios se desejar cadastra-los, (\"<b>ANEXO 6</b>\"); a contratante tem ci�ncia que  os documentos de anamnese, ficha m�dica e o arquivos de exames complementares (Ex: Urina, Fezes) ficar�o sujeitos � sua responsabilidade da n�o divulga��o, visto que tratam-se de informa��es sigilosas.";
    $code .= "<p align=justify>";
    
    $code .= "5.3 As rubricas e assinaturas apareceram nos relat�rios scaneadas e ser�o enviados junto ao contrato na forma de (\"<b>ANEXO 7</b>\") procura��o dos profissionais que assinam os programas validando assim o documento que em fiscaliza��o dever� ser exibido em tela e apresentar o contrato com as procura��es e c�pia dos comprovantes de pagamento;";
    $code .= "<p align=justify>";
    
    $code .= "5.4 No caso de n�o pagamento de parcela at� o 5� (quinto) dia da data do vencimento conforme cl�usula 4.6 a CONTRATADA reserva-se ao direito de bloquear a senha de acesso da CONTRATANTE at� que se efetue o(s) respectivo(s) pagamento(s) da(s) boleta(s) vendida(s);";
    $code .= "<p align=justify>";
    
    $code .= "<b>Par�grafo �nico</b>: o bloqueio das senhas se dar� ao do administrador que automaticamente bloquear� as dos usu�rios secund�rios e o acesso do contador em enxergar seus arquivos, o bloqueio dos programas se far� com 05 (cinco) dias de atraso da fatura e para os ASO`s com 05 (cinco) dias de atraso da fatura.";
    $code .= "<p align=justify>";
    
    $code .= "5.5 Documentos que ficar�o dispon�veis on-line:";
    $code .= "<p align=justify>";
    
    $code .= "(a) Todos os programas e documentos, bem como c�pias dos certificados de treinamentos conforme descritos na presta��o de servi�o da cl�usula primeira deste contrato, assim como as c�pias dos exames complementares realizados em cl�nicas terceirizadas indicadas pela CONTRATADA.";
    $code .= "<p align=justify>";
    
    $code .= "<b>CL�USULA SEXTA - DO PRAZO E RESCIS�O</b>";
    $code .= "<p align=justify>";
    
    $code .= "6.1 Este Contrato vigorar� pelo prazo de ".strtolower($contract[validade])." a contar da data de sua assinatura, e a sua renova��o se dar� automaticamente desde que a CONTRATANTE n�o se manifeste contr�ria a sua renova��o at� o 30� dia que antecede o seu t�rmino. Podendo ser prorrogado por at� igual per�odo, mediante acordo entre as Partes.";
    $code .= "<p align=justify>";
    
    $code .= "6.2 Qualquer uma das Partes poder� considerar rescindido o presente Contrato nas seguintes hip�teses (I) descumprimento de qualquer uma das obriga��es contratuais assumidas pela outra Parte, desde que esta, devidamente notificada, n�o cumpra a obriga��o no prazo de 10 (dez) dias corridos, a contar da notifica��o ou (II) entrada em regime de fal�ncia, concordata ou liquida��o por qualquer uma das Partes.";
    $code .= "<p align=justify>";
    
    $code .= "6.3 Cada uma das Partes poder� rescindir este Contrato a qualquer tempo, mediante notifica��o pr�via de 30 (trinta) dias, n�o cabendo aplica��o de multas ou qualquer indeniza��o, salva-guardando os compromissos de pagamentos pactuados neste contrato nas cl�usulas: 4.2; 4.4 e 4.5.";
    $code .= "<p align=justify>";
    
    $code .= "<b>CL�USULA S�TIMA - ASPECTO TRABALHISTA</b>";
    $code .= "<p align=justify>";
    
    $code .= "7.1 A CONTRATADA � a �nica respons�vel pelo contrato de trabalho das pessoas designadas por ela, para a presta��o dos Servi�os, n�o podendo ser arg�ida solidariedade da CONTRATANTE, nem mesmo responsabilidade subsidi�ria, nas rela��es trabalhistas relacionadas aos Servi�os prestados pela CONTRATADA. A mesma declara, ainda, n�o existir qualquer v�nculo empregat�cio entre a CONTRATANTE e as pessoas designadas pela CONTRATADA. Para a presta��o dos Servi�os. Para os fins da presente cl�usula, a CONTRATANTE ter� o direito de exigir que a CONTRATADA lhe apresente quaisquer documentos necess�rios � comprova��o do cumprimento de suas obriga��es trabalhistas e previdenci�rias.";
    $code .= "<p align=justify>";
    
    $code .= "<b>CL�USULA OITAVA - INCID�NCIAS FISCAIS</b>";
    $code .= "<p align=justify>";
    
    $code .= "8.1 Todos os tributos e incid�ncias fiscais, de qualquer natureza, que recaiam ou venham a recair sobre quaisquer valores pagos � CONTRATADA ser�o de sua �nica e exclusiva responsabilidade.";
    $code .= "<p align=justify>";
    
    $code .= "<b>CL�USULA NONA - SIGILO</b>";
    $code .= "<p align=justify>";

    $code .= "9.1 Todos e quaisquer dados e informa��es contidos neste Contrato, produzidos, desenvolvidos ou por qualquer forma obtidos pela CONTRATADA em raz�o deste Contrato s� poder�o ser divulgados com o pr�vio e expresso consentimento da CONTRATANTE.";
    $code .= "<p align=justify>";

    $code .= "<b>CL�USULA DECIMA - PERDAS E DANOS</b>";
    $code .= "<p align=justify>";

    $code .= "10.1 A CONTRATADA fica desobrigada a pagar toda e qualquer indeniza��o por danos ou preju�zos causados direta e ou indiretamente por ela a qualquer de seus prepostos � CONTRATANTE; a terceiros em decorr�ncia da n�o execu��o das recomenda��es e observa��es nos servi�os, prestados pela CONTRATADA ao CONTRATANTE, ficando a CONTRATADA descompromissada a ressarcir ou responder judicialmente.";
    $code .= "<p align=justify>";

    //$code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [11]
/****************************************************************************************************************/
    $code .= "<b>CL�USULA D�CIMA PRIMEIRA - DISPOSI��ES GERAIS</b>";
    $code .= "<p align=justify>";

    $code .= "11.1 As disposi��es previstas neste Contrato s�o celebradas em car�ter irrevog�vel e irretrat�vel, obrigando as Partes, seus herdeiros e sucessores, para todos os fins de direito e a qualquer t�tulo.";
    $code .= "<p align=justify>";

    $code .= "11.2 Os direitos e obriga��es decorrentes deste Contrato n�o podem ser cedidos a terceiros sem o pr�vio e expresso consentimento, por escrito, da outra Parte.";
    $code .= "<p align=justify>";

    $code .= "11.3 A toler�ncia, por qualquer das Partes, ao n�o cumprimento pela Parte contr�ria de qualquer dos termos ou condi��es do presente Contrato, n�o constituir� abdica��o dos direitos que lhe s�o aqui ou em lei assegurados.";
    $code .= "<p align=justify>";

    $code .= "11.4 Todos e quaisquer adendos ou altera��es ao presente Contrato s� ser�o v�lidos se feitos atrav�s de aditivo a este Contrato, assinado por ambas as Partes.";
    $code .= "<p align=justify>";

    $code .= "11.5 Todas e quaisquer correspond�ncias enviadas por uma das Partes � outra se far� por escrito, n�o devendo ser injustificadamente retidas ou atrasadas, e ser�o endere�adas conforme segue:";
    $code .= "<p align=justify>";

    $code .= "<b>CONTRATANTE:</b>";
    $code .= "<BR>";
    $code .= "$cliente[endereco] $cliente[num_end], $cliente[estado]";
    $code .= "<BR>";
    $code .= "$cliente[bairro], CEP: $cliente[cep] - Brasil";
    $code .= "<BR>";
    $code .= "Fax: $cliente[fax]";
    $code .= "<BR>";
    
    $tmp = str_replace("Sr.", "", $cliente[nome_contato_dir]);
    $tmp = str_replace("(�)", "", $tmp);
    $tmp = str_replace("(�)", "", $tmp);

    $code .= "Representada: Senhor(�): $tmp";
    $code .= "<BR>";
    if(!empty($cliente[email_contato_dir])){
        $code .= $cliente[email_contato_dir];
        $code .= "<BR>";
    }
    $code .= "SCE - Sistema de Comunica��o Externo, em www.sesmt-rio.com";
    $code .= "<p align=justify>";

    $code .= "<b>CONTRATADA:</b>";
    $code .= "<BR>";
    $code .= "Rua Marechal Ant�nio de Souza 92, Rio de Janeiro";
    $code .= "<BR>";
    $code .= "Jardim Am�rica - Cep 21240-430 - Brasil";
    $code .= "<BR>";
    $code .= "Fax: 55-21-3014 4304";
    $code .= "<BR>";
    $code .= "Representada: Sr. Pedro Henrique";
    $code .= "<BR>";
    $code .= "comercial@sesmt-rio.com, sempre com c�pia para financeiro@sesmt-rio.com";
    $code .= "<BR>";
    $code .= "Nextel: 21-7844 9394 - 55*23*31368";
    $code .= "<BR>";
    $code .= "SCE - Sistema de Comunica��o Externo, em www.sesmt-rio.com";

    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [12]
/****************************************************************************************************************/
    $code .= "<p align=justify>";
    $code .= "<b>CL�USULA DECIMA SEGUNDA - FORO</b>";
    $code .= "<p align=justify>";

    $code .= "12.1 As Partes elegem o foro Central da Comarca da Capital do Estado do Rio de Janeiro para dirimir quaisquer quest�es oriundas deste Contrato que n�o possam ser legalmente dirimidas, com exclus�o de qualquer outro, por mais privilegiado que seja ou possa vir a ser. E, por estarem de acordo, assinam o presente Contrato em 02 (duas) vias de igual teor e forma, na presen�a de 02 (duas) testemunhas.";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<div style=\"text-align: center;\">Rio de Janeiro,  ".date("d")." de ".$meses[date("n")]." de ".date("Y")."</div>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<div style=\"text-align: center;\">";
    $code .= "_________________________________________________________<BR>";
    $code .= "SESMT SERVI�OS ESPECIALIZADOS DE SEGURAN�A<BR>E MONITORAMENTO DE ATIVIDADES NO TRABALHO EIRELI";
    $code .= "<BR>";
    $code .= "CNPJ 04.722.248/0001-17";
    $code .= "</div>";
    
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<div style=\"text-align: center;\">";
    $code .= "_________________________________________________________<BR>";
    $code .= "$cliente[razao_social]<BR>";
    $code .= "CNPJ $cliente[cnpj]";
    $code .= "</div>";
    
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    
    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<b>Testemunhas:</b>";
    $code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";
    $code .= "<td width=50%>___________________________________<BR>Nome:<BR>CPF:</td>";
    $code .= "<td width=50%>___________________________________<BR>Nome:<BR>CPF:</td>";
    $code .= "</tr>";
    $code .= "</table>";
    $code .= "<p align=justify>";
    
/************************************************************************************************/
//ADENO DE CONTRATO -> ANEXO 1 [PROPOSTA COMERCIAL]
/************************************************************************************************/


/************************************************************************************************/
//ADENO DE CONTRATO -> ANEXO 2 [REALIZA��O DO ASO DENTRO DA EMPRESA] <- Question�rio [Pedro]
/************************************************************************************************/
if(strtolower($contract[sala]) == "sim"){

    $code .= "<div class='pagebreak'></div>";
    
    $code .= "<div style=\"text-align: center;\"><b>(\"ANEXO 2\")</b></div>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    
    $code .= "<b>ANEXO PRIMEIRO - DA FINALIDADE</b>";
    $code .= "<p align=justify>";

    $code .= "<b>Anexo 1.1</b> Em atendimento a necessidade de um servi�o personalizado e visando a qualidade dos servi�os prestados e a fidelidade de uma melhor consultoria de seguran�a e higiene do trabalho, implantada pela Sesmt Servi�os Especializados em Seguran�a e Monitoramento de Atividades no Trabalho EIRELI.";
    $code .= "<p align=justify>";

    $code .= "<b>Anexo 1.2</b> A CONTRATANTE, vem por interm�dio deste, solicitar a est� institui��o prestadora de servi�os de higiene do trabalho, a realiza��o dos Atestados de Sa�de Ocupacional, no interior da empresa CONTRATANTE;";
    $code .= "<p align=justify>";

    $code .= "<b>Anexo 1.3</b> procedimentos para realiza��o da higiene do trabalho e seus complementares poder�o ser realizados nas depend�ncias da CONTRATANTE, desde que a mesma forne�a a CONTRATADA: Sala em bom estado de conserva��o; devidamente arejada; munida de mesa acompanhada de (02) duas cadeiras;";
    $code .= "<p align=justify>";

    $code .= "<b>Anexo 1.4</b> A CONTRATADA compromete-se a remeter os funcion�rios de (03) Tr�s por vez em per�odo de intervalo de 50 minutos, garantindo assim o bom desempenho do profissional examinador;";
    $code .= "<p align=justify>";

    $code .= "<b>ANEXO SEGUNDO - DA REMUNERA��O PELOS SERVI�OS</b>";
    $code .= "<p align=justify>";

    $code .= "<b>Anexo 2.1</b> pelos servi�os na modalidade personalizada ser�o cobrados a taxa de deslocamento o valor de R$ 20,00 (Vinte Reais) para atendimentos no Munic�pio do Rio de Janeiro e R$ 50,00 (Cinq�enta Reais) para demais Munic�pios, tratando-se de atendimento fora da localiza��o da unidade pr� estabelecida em contrato.";
    $code .= "<p align=justify>";

    $code .= "<b>Anexo 2.2</b> Pelos servi�os de loca��o de m�o de obra de medicina ocupacional a CONTRATANTE pagar� a CONTRATADA os valores correspondentes a R$ 350,00 (Trezentos e cinq�enta reais) para meio per�odo de atendimento di�rio e R$ 700,00 (Setecentos Reais) para per�odos integrais, quando o atendimento for fora da localiza��o da unidade pr� estabelecida em contrato.";
    $code .= "<p align=justify>";

    $code .= "<b>Anexo 2.3</b> para os procedimentos m�dicos complementares ao ASO, as custas ser�o pagas a CONTRATADA que repassar� a clinica conveniada a CONTRATADA, pela realiza��o dos servi�os em boleto banc�rio ap�s a realiza��o dos servi�os;";
    $code .= "<p align=justify>";

    $code .= "<b>Anexo 2.4</b> Nenhum atendimento complementar poder� ser inferior a (10) atendimentos sendo cobrado taxa de deslocamento da clinica conveniada da CONTRATADA, de R$ 50,00 (Cinq�enta Reais) para cobrir frete dos equipamentos pagos a clinica conveniada ou encaminhar o funcion�rio da CONTRATANTE a um dos endere�os que ficam no site: www.sesmt-rio.com, no bot�o cliente, bot�o agendamento sa�de ocupacional.";
    $code .= "<p align=justify>";

    $code .= "<b>PARAGRAFO �NICO:</b> A CONTRATANTE poder� escolher outra clinica a seu desejo para a realiza��o dos procedimentos complementares, valendo dizer que o ASO Atestado de Sa�de Ocupacional, s� ser� liberado em sistema www.sesmt-rio.com, para visualiza��o ap�s a CONTRATANTE ou a clinica prestadora dos servi�os � escolha da CONTRATANTE, entregar os resultados dos exames e a anamin�sia preenchida e assinada pelo m�dico e funcion�rio da CONTRATANTE.";
    $code .= "<p align=justify>";
    
    $code .= "<b>Anexo 2.5</b> A CONTRATADA poder� disponibiliza os acess�rios Necess�rios que se fizerem necess�rios para montagem de sala de atendimento m�dico, como: Maca; Balan�a; escadinha para maca, a titulo loca��o pelo custo de R$ 90,00 (Noventa Reais), a di�ria e ou R$ 120,00 (Cento e Vinte Reais) pago fixo e mensal, sempre a CONTRANTE desejar mediante celebra��o de contrato de loca��o dos mobili�rios.";
    $code .= "<p align=justify>";
    
    $code .= "<b>PARAGRAFO �NICO:</b> Sempre que houver exames complementares esses acess�rios dever�o compor a sala, n�o sendo necess�rio a CONTRATADA ter que aluga-los a mesma poder� tamb�m adquiri-los como de sua propriedade, em nenhum momento a CONTRATADA ou uma de suas Clinicas conveniada s�o obrigadas a oferecer esses acess�rios, por for�a da presta��o dos servi�os.";
    $code .= "<p align=justify>";

    $code .= "<b>ANEXO TERCEIRO - DA FORMA DE PAGAMENTO</b>";
    $code .= "<p align=justify>";

    $code .= "<b>Anexo 3.1</b> Os pagamentos devido a CONTRATANTE, ser�o pagos conforme cl�usula 4.1 destecontrato;";
    $code .= "<p align=justify>";

    $code .= "<b>Anexo 3.2</b> Os pagamento pertinentes a clinica conveniada indicada pela CONTRATANTE ser� efetuado em documento de cobran�a pr�prio remetido pela CONTRATADA.";
    $code .= "<p align=justify>";
    
    $code .= "<div class='pagebreak'></div>";
    
    $code .= "<b>ANEXO QUARTO - FORO</b>";
    $code .= "<p align=justify>";

    $code .= "<b>Anexo 4.1</b> As Partes elegem o foro Central da Comarca da Capital do Estado do Rio de Janeiro para dirimir quaisquer quest�es oriundas deste Contrato que n�o possam ser legalmente dirimidas, com exclus�o de qualquer outro, por mais privilegiado que seja ou possa vir a ser.";
    $code .= "<p align=justify>";

    $code .= "E, por estarem de acordo, assinam o presente Contrato em 02 (duas) vias de igual teor e forma, na presen�a de 02 (duas) testemunhas.";
    $code .= "<p align=justify>";

    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<div style=\"text-align: center;\">Rio de Janeiro,  ".date("d")." de ".$meses[date("n")]." de ".date("Y")."</div>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<div style=\"text-align: center;\">";
    $code .= "_________________________________________________________<BR>";
    $code .= "SESMT SERVI�OS ESPECIALIZADOS DE SEGURAN�A<BR>E MONITORAMENTO DE ATIVIDADES NO TRABALHO EIRELI";
    $code .= "<BR>";
    $code .= "CNPJ 04.722.248/0001-17";
    $code .= "</div>";

    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<div style=\"text-align: center;\">";
    $code .= "_________________________________________________________<BR>";
    $code .= "$cliente[razao_social]<BR>";
    $code .= "CNPJ $cliente[cnpj]";
    $code .= "</div>";

    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<b>Testemunhas:</b>";
    $code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";
    $code .= "<td width=50%>___________________________________<BR>Nome:<BR>CPF:</td>";
    $code .= "<td width=50%>___________________________________<BR>Nome:<BR>CPF:</td>";
    $code .= "</tr>";
    $code .= "</table>";
    $code .= "<p align=justify>";
}

/************************************************************************************************/
//ADENO DE CONTRATO -> ANEXO 3 [REALIZA��O DE PALESTRAS]
/************************************************************************************************/
//VERIFICA��O DE ITEMS DO OR�AMENTO
$sql = "SELECT o.*, p.desc_resumida_prod FROM site_orc_produto o, produto p WHERE o.cod_orcamento = ".(int)($contract[cod_orcamento])." AND p.cod_prod = o.cod_produto";
$res3 = pg_query($sql);
$buff3 = pg_fetch_all($res3);
$show_adeno_3 = 0;
$alpha = 'a';
$ctxt = "";
for($x=0;$x<pg_num_rows($res3);$x++){
   if(in_array($buff3[$x]['cod_produto'], $id_curso)){
      $show_adeno_3 = 1;
      $ctxt .= "$alpha) {$buff3[$x]['desc_resumida_prod']};<BR>";
      $alpha++;
   }
}
if(!empty($show_adeno_3)){
    $code .= "<div class='pagebreak'></div>";
    $code .= "<div style=\"text-align: center;\"><b>(\"ANEXO 3\")</b></div>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<b>ANEXO PRIMEIRO - DA FINALIDADE</b>";
    $code .= "<p align=justify>";
    
    $code .= "<b>Anexo 1.1</b> Em atendimento a necessidade de uma implanta��o da cultura prevencionista, institui-se a ministra��o de palestras com dura��o de no m�ximo 01h00min e visando a qualidade dos servi�os prestados e a fidelidade de uma melhor cultura de seguran�a, implantada pela Sesmt Servi�os Especializados em Seguran�a e Monitoramento de Atividades no Trabalho EIRELI.";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 1.2</b> As palestras ser�o ministradas mensalmente e por um per�odo n�o superior a 02h00min;";
    $code .= "<p align=justify>";

    $code .= "<b>ANEXO SEGUNDO - DA AGENDA DE PALESTRAS</b>";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 2.1</b> As palestras ser�o ministradas por um profissional de seguran�a do trabalho ou higiene ocupacional da CONTRATADA ou por quem ela designar;";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 2.2</b> Caber� a CONTRATADA informar com anteced�ncia quando, prestadores de servi�os terceiros forem contratados com anteced�ncia m�nima de 05 (Cinco) dias a CONTRATANTE;";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 2.3</b> As palestras ter�o temas educativos visando a preven��o e a gerar uma pol�tica de cultura de seguran�a no trabalho e ter�o temas como:";
    $code .= "<p align=justify>";
    $code .= "$ctxt";
    $code .= "<p align=justify>";
    
    
    $code .= "<b>ANEXO TERCEIRO - DO MATERIAL PARA REALIZA��O DAS PALESTRAS</b>";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 3.1</b> O material did�tico correr�o por conta da CONTRATADA;";
    $code .= "<p align=justify>";
    $code .= "<b>PARAGRAFO �NICO:</b> S�o esses: Ficha de Presen�a; Certificados de Participa��o; Material �udio Visual.";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 3.2</b> Os acess�rios correr�o por conta da CONTRATANTE;";
    $code .= "<p align=justify>";
    $code .= "<b>PARAGRAFO �NICO:</b> S�o esses: Sala devidamente arejada; cadeiras; computador; retropojetor conex�o USB; flip chart; quadro com caneta piloto.";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 3.3</b> A data das palestras ser�o todo     /      /       . e sempre que o dia escolhido cair em um final de semana a palestra ser� dimensionada automaticamente para a segunda feira seguinte;";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 3.4</b> Havendo qualquer necessidade de mudan�a por for�a do trabalho a CONTRATANTE dever� se comunicar por escrito via e-mail: segtrab@sesmt.com num prazo de 72 horas m�nimas a indisponibilidade da libera��o de seu efetivo para a palestra, isso n�o desmarca a visita t�cnica que acontecera, apenas suprimi a palestra que n�o poder� ser acumuladas.";
    $code .= "<p align=justify>";

    $code .= "<div class='pagebreak'></div>";

    $code .= "<b>ANEXO QUARTO - FORO</b>";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 4.1</b> As Partes elegem o foro Central da Comarca da Capital do Estado do Rio de Janeiro para dirimir quaisquer quest�es oriundas deste Contrato que n�o possam ser legalmente dirimidas, com exclus�o de qualquer outro, por mais privilegiado que seja ou possa vir a ser.";
    $code .= "<p align=justify>";
    $code .= "E, por estarem de acordo, assinam o presente Contrato em 02 (duas) vias de igual teor e forma, na presen�a de 02 (duas) testemunhas.";
    $code .= "<p align=justify>";
    
    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<div style=\"text-align: center;\">Rio de Janeiro,  ".date("d")." de ".$meses[date("n")]." de ".date("Y")."</div>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<div style=\"text-align: center;\">";
    $code .= "_________________________________________________________<BR>";
    $code .= "SESMT SERVI�OS ESPECIALIZADOS DE SEGURAN�A<BR>E MONITORAMENTO DE ATIVIDADES NO TRABALHO EIRELI";
    $code .= "<BR>";
    $code .= "CNPJ 04.722.248/0001-17";
    $code .= "</div>";

    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<div style=\"text-align: center;\">";
    $code .= "_________________________________________________________<BR>";
    $code .= "$cliente[razao_social]<BR>";
    $code .= "CNPJ $cliente[cnpj]";
    $code .= "</div>";

    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<b>Testemunhas:</b>";
    $code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";
    $code .= "<td width=50%>___________________________________<BR>Nome:<BR>CPF:</td>";
    $code .= "<td width=50%>___________________________________<BR>Nome:<BR>CPF:</td>";
    $code .= "</tr>";
    $code .= "</table>";
    $code .= "<p align=justify>";
}

/************************************************************************************************/
//ADENO DE CONTRATO -> ANEXO 4 [VISITAS T�CNICAS]
/************************************************************************************************/
//VERIFICA��O DE ITEMS DO OR�AMENTO
$sql = "SELECT * FROM site_orc_produto WHERE cod_orcamento = ".(int)($contract[cod_orcamento]);
$res4 = pg_query($sql);
$buff4 = pg_fetch_all($res4);

$show_adeno_4 = 0;
for($x=0;$x<pg_num_rows($res4);$x++){
   if(in_array($buff4[$x]['cod_produto'], $id_visita_tecnica)){
      $show_adeno_4 = 1;
   }
}

if(!empty($show_adeno_4)){
    $code .= "<div class='pagebreak'></div>";
    
    $code .= "<div style=\"text-align: center;\"><b>(\"ANEXO 4\")</b></div>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<b>ANEXO PRIMEIRO - DA FINALIDADE</b>";
    $code .= "<p align=justify>";
    
    $code .= "<b>Anexo 1.1</b> A CONTRATANTE, solicita da CONTRATADA o servi�o de visita t�cnica em sua instala��o a fim de garantir a fidelidade de s�rie de procedimentos t�cnicos.";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 1.2</b> As visitas T�cnicas ser�o realizadas mensalmente e por um per�odo n�o superior a (04) quatro horas;";
    $code .= "<p align=justify>";

    $code .= "<b>ANEXO SEGUNDO - DA FORMA DE APRESENTA��O E ACESSO</b>";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 2.1</b> O acesso do profissional de seguran�a da Sesmt Servi�os Especializados em Seguran�a e Monitoramento de Atividades no Trabalho EIRELI, se dar� em dia e hora marcada e definida em agenda de visita apresentada pelo CONTRATADO;";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 2.2</b> Nosso profissional se apresentar� a pessoa designada pelo CONTRATANTE na sua entrada e na sua sa�da com cart�o de anota��o de ponto de chegada e sa�da para controle da Sesmt Servi�os Especializados em Seguran�a e Monitoramento de Atividades no Trabalho EIRELI;";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 2.3</b> A O acesso por parte de nosso profissional de seguran�a necessita a aus�ncia de qualquer restri��o do acesso, haja em vista a necessidade de conhecer todos os locais de posto de trabalho visando o sucesso do relat�rio a ser emitido a CONTRATADA e a fidelidade do relat�rio de seguran�a elaborado pela CONTRATANTE;";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 2.4</b> CONTRATANTE se compromete a remeter manter todo e total sigilo de toda informa��o levantada por nos, cabendo t�o somente relatar tecnicamente dentro da mat�ria de seguran�a e higiene do trabalho.";
    $code .= "<p align=justify>";
    
    $code .= "<b>ANEXO TERCEIRO - RELAT�RIO DE VISITA T�CNICA</b>";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 3.1</b> A CONTRATADA emitira um relat�rio da visita t�cnica detalhando o quadro critico do CONTRATANTE de forma poder monitorar as pend�ncias e incid�ncias de riscos encontradas;";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 3.2</b> A CONTRATADA se compromete a remeter relat�rio de visita t�cnica em at� (10) dez dias da data da visita da forma por escrito.";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 3.3</b> A CONTRATADA poder� indicar prestadores de servi�os para a CONTRATANTE a fim de auxilia no cumprimento das inconformidades encontrada, mais n�o se responsabiliza por qualquer insatisfa��o que possa vir acontecer por parte do CONTRATANTE;";
    $code .= "<p align=justify>";
    $code .= "<b>PARAGRAFO �NICO:</b> A CONTRATADA poder� prestar a consultoria de monitoramento a CONTRATANTE, como terceirizada como \"compradora\" do seguimento de preven��o de acidente e higiene ocupacional e ou loca��o de m�o de obra numa das �reas ou at� mesmo as duas, desde que celebrado contrato de presta��o de servi�os para essa modalidade.";
    $code .= "<p align=justify>";
    
    $code .= "<b>ANEXO QUARTO - FORMA DE REMUNERA��O</b>";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 4.1</b> A CONTRATADA cobrar� a CONTRATANTE pelas visitas t�cnicas deste contrato o valor de R$ 150,00 (Cento e Cinq�enta Reais) sempre que solicitadas fora da data e agenda em site www.sesmt-rio.com, no bot�o \"cliente\" atrav�s de senha de acesso, ou que quando exceder por solicita��o da CONTRATADA o tempo da visita (horas de perman�ncia do profissional no interior da empresa). A CONTRATADA monitorar� o tempo do profissional via r�dio a fim de evitar excesso e gere desconforto a CONTRATANTE;";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 4.2</b> No caso da CONTRATANTE solicitar a visita por tempo maior das quatro horas, nesse caso o custa para cada hora excedida ser� de R$ 50,00 (Cinq�enta Reais), para per�odo de perman�ncia de cada (01) horas e 250,00 (Duzentos e Cinq�enta Reais) para cada plant�o de 06 horas di�rias;";
    $code .= "<p align=justify>";
    $code .= "<b>PARAGRAFO �NICO:</b> Fica vedado qualquer gratifica��o a titulo de gorjeta ou outro qualquer nome a se utilizar, caso qualquer profissional da CONTRATADA venha receber ou solicitar algum ganho que n�o seja o de sua folha de pagamento e a CONTRATADA venha a tomar conhecimento encontrar-se-� sumariamente demitido do quadro funcional da CONTRATADA.";
    $code .= "<p align=justify>";
    
    
    $code .= "<div class='pagebreak'></div>";

    $code .= "<b>ANEXO QUINTO - FORO</b>";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 5.1</b> As Partes elegem o foro Central da Comarca da Capital do Estado do Rio de Janeiro para dirimir quaisquer quest�es oriundas deste Contrato que n�o possam ser legalmente dirimidas, com exclus�o de qualquer outro, por mais privilegiado que seja ou possa vir a ser.";
    $code .= "<p align=justify>";
    $code .= "E, por estarem de acordo, assinam o presente Contrato em 02 (duas) vias de igual teor e forma, na presen�a de 02 (duas) testemunhas.";
    $code .= "<p align=justify>";

    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<div style=\"text-align: center;\">Rio de Janeiro,  ".date("d")." de ".$meses[date("n")]." de ".date("Y")."</div>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<div style=\"text-align: center;\">";
    $code .= "_________________________________________________________<BR>";
    $code .= "SESMT SERVI�OS ESPECIALIZADOS DE SEGURAN�A<BR>E MONITORAMENTO DE ATIVIDADES NO TRABALHO EIRELI";
    $code .= "<BR>";
    $code .= "CNPJ 04.722.248/0001-17";
    $code .= "</div>";

    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<div style=\"text-align: center;\">";
    $code .= "_________________________________________________________<BR>";
    $code .= "$cliente[razao_social]<BR>";
    $code .= "CNPJ $cliente[cnpj]";
    $code .= "</div>";

    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<b>Testemunhas:</b>";
    $code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";
    $code .= "<td width=50%>___________________________________<BR>Nome:<BR>CPF:</td>";
    $code .= "<td width=50%>___________________________________<BR>Nome:<BR>CPF:</td>";
    $code .= "</tr>";
    $code .= "</table>";
    $code .= "<p align=justify>";
}

/************************************************************************************************/
//ADENO DE CONTRATO -> ANEXO 5 [MODELO DE FATURA]
/************************************************************************************************/
    $code .= "<div class='pagebreak'></div>";

    $code .= "<div style=\"text-align: center;\"><b>(\"ANEXO 5\")</b></div>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    
    $code .= "<table width=100% border=0 ecllspacing=0 cellpadding=0>";
    $code .= "<tr>";
    $code .= "<td style=\"border: 1px solid #000000; border-right: 0px;\"><b>Resumo da Fatura de Servi�o</b></td>";
    $code .= "<td align=right  style=\"border: 1px solid #000000; border-left: 0px;\"><b>N� 2429/09</b></td>";
    $code .= "</tr>";
    $code .= "</table>";
    
    $code .= "<table width=100% border=0>";
    $code .= "<tr>";
    $code .= "<td width=50%></td>";
    $code .= "<td>";
    $code .= "<b>Cliente:</b> $cliente[razao_social]<BR>";
    $code .= "<b>CNPJ:</b> $cliente[cnpj]<BR>";
    $code .= "<b>Contrato do cliente:</b> $cliente[ano_contrato].".str_pad($cliente[cliente_id], 4,"0",0)."<BR>";
    $code .= "<b>Tipo de contrato:</b> $contract[tipo_contrato]<BR>";
    $code .= "<b>C�digo do cliente:</b> ".str_pad($cliente[cliente_id], 4, "0",0)."<BR>";
    $code .= "<b>Data da emiss�o:</b> 01/04/2009<BR>";
    $code .= "<b>Per�odo de cobran�a:</b> 01/03/2009 � 01/04/2009<BR>";
    $code .= "<b>Vencimento:</b> 16/04/2009<BR>";
    $code .= "</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=2 align=center><img src='../../../images/exemplo-fatura.jpg' border=0></td>";
    $code .= "</tr>";
    $code .= "</table>";
    
/************************************************************************************************/
//ADENO DE CONTRATO -> ANEXO 6 [SIG�LO]
/************************************************************************************************/
    $code .= "<div class='pagebreak'></div>";

    $code .= "<div style=\"text-align: center;\"><b>(\"ANEXO 6\")</b></div>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<b>CONSIDERANDO QUE:</b> Na �tica da justi�a, nenhuma pessoa pode ser descriminada por qualquer fato que seja, ou motivo algum;";
    $code .= "<p align=justify>";
    $code .= "<b>CONSIDERANDO QUE:</b> A CONTRATANTE e a CONTRATADA s�o as �nicas respons�veis pela administra��o de todas as informa��es obtidas e geradas oriunda dos exames m�dicos complementares;";
    $code .= "<p align=justify>";
    $code .= "<b>CONSIDERANDO QUE:</b> A CONTRATANTE, � respons�vel pela sua senha pessoal e de veda o acesso dos seus dois usu�rios secund�rios;";
    $code .= "<p align=justify>";
    $code .= "<b>RESOLVEM:</b> que � de inteira responsabilidade da CONTRATANTE resguardar as informa��es m�dicas complementares de seus funcion�rios;";
    $code .= "<p align=justify>";
    $code .= "<b>CL�USULA PRIMEIRA - OBJETIVO DO ANEXO DO CONTATO</b>";
    $code .= "<p align=justify>";
    $code .= "<b>Cl�usula 1.2</b> Fica vedada o direito de divulga��o de maneira a expor qualquer que seja o motivo �s informa��es dos resultados de exames m�dicos complementares de funcion�rio da CONTRATANTE por parte da CONTRATADA;";
    $code .= "<p align=justify>";
    $code .= "<b>Cl�usula 1.3</b> A CONTRATANTE � a �nica respons�vel pela guarda fiel das informa��es de seus funcion�rios.";
    $code .= "<p align=justify>";
    $code .= "<b>PARAGRAFO �NICO:</b> Cabe a CONTRATANTE resguardar sua senha de acesso e limitar o acesso dos dois usu�rios secund�rio, vale dizer que quando em fiscaliza��o por parte do Minist�rio do Trabalho e do Emprego a CONTRATANTE n�o � obrigada a exibir as informa��es a fiscal que n�o seja M�dico, sendo de sua responsabilidade se tal fato ocorrerem.";
    $code .= "<p align=justify>";


    $code .= "<div class='pagebreak'></div>";

    $code .= "<b>CL�USULA SEGUNDA - FORO</b>";
    $code .= "<p align=justify>";
    $code .= "2.1 As Partes elegem o foro Central da Comarca da Capital do Estado do Rio de Janeiro para dirimir quaisquer quest�es oriundas deste Contrato que n�o possam ser legalmente dirimidas, com exclus�o de qualquer outro, por mais privilegiado que seja ou possa vir a ser.";
    $code .= "<p align=justify>";
    $code .= "E, por estarem de acordo, assinam o presente Contrato em 02 (duas) vias de igual teor e forma, na presen�a de 02 (duas) testemunhas.";
    $code .= "<p align=justify>";

    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<div style=\"text-align: center;\">Rio de Janeiro,  ".date("d")." de ".$meses[date("n")]." de ".date("Y")."</div>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<div style=\"text-align: center;\">";
    $code .= "_________________________________________________________<BR>";
    $code .= "SESMT SERVI�OS ESPECIALIZADOS DE SEGURAN�A<BR>E MONITORAMENTO DE ATIVIDADES NO TRABALHO EIRELI";
    $code .= "<BR>";
    $code .= "CNPJ 04.722.248/0001-17";
    $code .= "</div>";

    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<div style=\"text-align: center;\">";
    $code .= "_________________________________________________________<BR>";
    $code .= "$cliente[razao_social]<BR>";
    $code .= "CNPJ $cliente[cnpj]";
    $code .= "</div>";

    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<b>Testemunhas:</b>";
    $code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";
    $code .= "<td width=50%>___________________________________<BR>Nome:<BR>CPF:</td>";
    $code .= "<td width=50%>___________________________________<BR>Nome:<BR>CPF:</td>";
    $code .= "</tr>";
    $code .= "</table>";
    $code .= "<p align=justify>";

/************************************************************************************************/
//ADENO DE CONTRATO -> ANEXO 7 [AUTORIZA��O ASSINATURA T�CNICO]
/************************************************************************************************/
    $code .= "<div class='pagebreak'></div>";

    $code .= "<div style=\"text-align: center;\"><b>(\"ANEXO 7\")</b></div>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    $code .= "<div style=\"text-align: center;\"><b>Autoriza��o</b></div>";
    $code .= "<p align=justify>";
    $code .= "Venho informar a quem interessar saber que Eu, Pedro Henrique da Silva, portador(a) do registro profissional n� RJ/000994-6 �rg�o expedidor MTE.";
    $code .= "<p align=justify>";
    $code .= "A qual mant�m contrato de presta��o de servi�os de respons�vel t�cnica com a empresa: Sesmt Servi�os e Especializados de Seguran�a e Monitoramento de Atividades no Trabalho EIRELI, sob o CNPJ: 04.722.248/0001-17 autoriza a empresa prestadora de servi�os em consultoria de Seguran�a e Medicina Ocupacional a vincular minha rubrica e assinatura nos relat�rios os quais sou coordenador (a) em exibi��o digital no site da empresa. Dando f� � assinatura por mim emitidas atrav�s de senha pessoal de acesso ao sistema intrenet da empresa.";
    $code .= "<p align=justify><BR>";
    $code .= "<p align=justify><BR>";
    $code .= "<p align=justify><BR>";
    $code .= "<p align=justify><BR>";
    
    $code .= "<div style=\"text-align: center;\"><img src='../../../images/assinatura_tecnico.jpg' border=0 width=332 height=150></div>";

/************************************************************************************************/
//ADENO DE CONTRATO -> ANEXO 7 [AUTORIZA��O ASSINATURA M�DICO]
/************************************************************************************************/
    $code .= "<div class='pagebreak'></div>";

    $code .= "<div style=\"text-align: center;\"><b>(\"ANEXO 7\")</b></div>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    $code .= "<div style=\"text-align: center;\"><b>Autoriza��o</b></div>";
    $code .= "<p align=justify>";
    $code .= "Venho informar a quem interessar saber que Eu, Maria de Lourdes Fernandes de Magalh�es, portadora do registro profissional n� 52.33.471-0 �rg�o expedidor CREMERJ e 13.320 MTE.";
    $code .= "<p align=justify>";
    $code .= "A qual mant�m contrato de presta��o de servi�os de respons�vel t�cnica com a empresa: Sesmt Servi�os e Especializados de Seguran�a e Monitoramento de Atividades no Trabalho EIRELI, sob o CNPJ: 04.722.248/0001-17, autoriza a empresa prestadora de servi�os em consultoria de Seguran�a e Higiene do Trabalho a vincular minha rubrica e assinatura nos relat�rios os quais sou coordenador (a) em exibi��o digital no site da empresa. Dando f� � assinatura por mim emitidas atrav�s de senha pessoal de acesso ao sistema intrenet da empresa.";
    $code .= "<p align=justify><BR>";
    $code .= "<p align=justify><BR>";
    $code .= "<p align=justify><BR>";
    $code .= "<p align=justify><BR>";

    $code .= "<div style=\"text-align: center;\"><img src='../../../images/assinatura_medico.jpg' border=0 width=260 height=122></div>";
/************************************************************************************************/
//ADENO DE CONTRATO -> ANEXO 8 [ARQUIVO F�SICO]
/************************************************************************************************/
    $code .= "<div class='pagebreak'></div>";

    $code .= "<div style=\"text-align: center;\"><b>(\"ANEXO 8\")</b></div>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    
    $code .= "<p align=justify>";
    $code .= "<table border=0 width=100%><tr><td><b>Remetente:</b> Dr�. Maria de Lourdes Fernandes de Magalh�es</td><td width=100><b>Of�cio:</b> 0003/09</td></tr></table>";
    $code .= "<p align=justify>";
    $code .= "<b>Destinat�rio:</b> Dpt� M�dico do Trabalho";
    $code .= "<p align=justify>";

    $code .= "<table border=0 width=100%><tr><td width=150><b>Raz�o social:</b></td><td style=\"border: 1px solid #000000;\">&nbsp;&nbsp;</td></tr></table>";
    $code .= "<p align=justify>";
    $code .= "Venho por interm�dio desta, solicitar a est� institui��o prestadora de servi�os m�dicos ocupacionais, os Prontu�rios M�dicos, Fichas M�dicas e Exames Complementares dos funcion�rios da empresa: ".$cliente[razao_social];
    $code .= "<p align=justify>";
    $code .= "<b>Motivo:</b>";
    $code .= "<p align=justify>";
    $code .= "A empresa: {$cliente[razao_social]}, sob o CNPJ: {$cliente[cnpj]}, possui um contrato de presta��o de servi�o com a SESMT Servi�os Especializados em Seguran�a e Monitoramento de Atividades no Trabalho EIRELI, sendo assim respeitosamente solicitamos a remessa de documentos que comp�e o arquivo f�sico da referida empresa, em cumprimento a legisla��o 6.514/77 portaria 3.214/78 NR 7.4.5. Os dados obtidos nos exames m�dicos, incluindo avalia��o cl�nica e exames complementares, as conclus�es e as medidas aplicadas dever�o ser registrados em prontu�rio cl�nico individual, que ficar� sob a Responsabilidade do m�dico-coordenador do PCMSO; e NR 7.4.5.2. Havendo substitui��o do m�dico a que se refere o item 7.4.5, os arquivos dever�o ser transferidos para seu sucessor.";
    $code .= "<p align=justify>";
    $code .= "<div style=\"text-align: center;\">Sem mais para o momento;</div>";
    $code .= "<p align=justify>";
    $code .= "Aproveito o espa�o em aberto para manifesta��o de minhas considera��es e estimas.";
    $code .= "<p align=justify>";
    $code .= "<div style=\"text-align: center;\"><b>Cordialmente,</b></div>";
    $code .= "";
    $code .= "<p align=justify>";
    $code .= "";
    $code .= "<p align=justify><BR>";
    $code .= "<p align=justify><BR>";
    $code .= "<p align=justify><BR>";
    $code .= "<p align=justify><BR>";
    $code .= "<div style=\"text-align: center;\"><img src='../../../images/assinatura_medico.jpg' border=0 width=260 height=122></div>";
/****************************************************************************************************************/
// -> PAGE [X]
/****************************************************************************************************************/
/*    $code .= "<div class='mainTitle'><b>TITULO</b></div>";
    $code .= "<p align=justify>";

    $code .= "<div class='pagebreak'></div>";
*/

    $code .= "</body>";
    $code .= "</html>";

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
$stylesheet = file_get_contents('../../../common/css/pdf.css');
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
$arquivo = "contrato_".$contract[tipo_contrato]."_".$cliente[ano_contrato].".".str_pad($cliente[cliente_id], 4, "0",0)."_".date("d-m-Y-H_i").'.pdf';

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
