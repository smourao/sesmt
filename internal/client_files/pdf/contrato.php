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
$meses    = array('', 'Janeiro',  'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
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
    die("Não foi possível a exibição deste contrato. [Inconsistência de dados - contrato]");
}
$vencimento = explode("-", $contract[vencimento]);
/***************************************************************************************************************/
$sql = "SELECT * FROM cliente WHERE cliente_id = ".(int)(anti_injection($_GET[cod_cliente]));
$rcl = pg_query($sql);
if(pg_num_rows($rcl)){
    $cliente = pg_fetch_array($rcl);
}else{
    die("Não foi possível a exibição deste contrato. [Inconsistência de dados - cliente]");
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
        die("Não foi possível a exibição deste contrato. [Inconsistência de dados - orçamento]");
    }
}else{
    die("Não foi possível a exibição deste contrato. [Inconsistência de dados - orçamento]");
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
// -> FUNÇÕES
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
    //Prestação de Serviço em Assessoria à Organização de Processo Eleitoral, Eleição em Scrutino Secreto, Apuração de Votação, Confecção de Ata de Eleição e Posse, Registro de Gestão da CIPA – Comissão Interna de Prevenção de Acidente, Junto ao Mte.
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
           $tmp .= " Laudo Técnico de Condições Ambiental de Trabalho - LTCAT; ";
        }else if(in_array($items[$x], $prod2)){
           $tmp .= "Elaboração e Implementação de Mapa de Risco Ambiental Geral Formato A0; ";
        }else if(in_array($items[$x], $prod3)){
           $tmp .= "Elaboração e Implementação de Mapa de Risco Setorial Formato A3; ";
        }else if(in_array($items[$x], $prod4)){
           $tmp .= "Ministração de Curso da CIPA - Comissão Interna de Prevenção de Acidentes; ";
        }else if(in_array($items[$x], $prod5)){
           $tmp .= "Treinamento de Prevenção de Brigada Contra Incêndio; ";
        }else if(in_array($items[$x], $prod6)){
           $tmp .= "Assessoria à CIPA - Comissão Interna de Prevenção de Acidente; ";
        }else if(in_array($items[$x], $prod7)){
           $tmp .= "Emissão de ASO - Atestado e Saúde Ocupacional; ";
        }else if(in_array($items[$x], $prod8)){
           $tmp .= "Elaboração e Implementação do PPRA - Programa de Prevenção a Risco Ambiental; ";
        }else if(in_array($items[$x], $prod9)){
           $tmp .= "Emisão do PPP - Perfil Profissiográfico Previdenciário; ";
        }else if(in_array($items[$x], $prod10)){
           $tmp .= "Elaboração e Implementação do PCMSO - Programa de Controle Médico e Saúde Ocupacional; ";
        }else if(in_array($items[$x], $prod11)){
           $tmp .= "Elaboração e Implementação de APGRE - Avaliação Preliminar e Gerenciamento de Riscos Ergonômicos; ";
        }else if(in_array($items[$x], $prod12)){
           $tmp .= "Prestação de Serviço em Treinamento Sobre Uso do EPI - Equipamento de Proteção Individual, Contendo Forma de Higienização, Guarda dos Equipamentos e o Uso de Forma Adequada a Atender a Necessidade Prevencionista; ";
        }else if(in_array($items[$x], $prod13)){
           $tmp .= "Prestação de Serviço em Assessoria à Organização de Processo Eleitoral, Eleição em Scrutino Secreto, Apuração de Votação, Confecção de Ata de Eleição e Posse, Registro de Gestão da CIPA - Comissão Interna de Prevenção de Acidente - Junto ao Mte; ";
        }else if(in_array($items[$x], $prod14)){
           $tmp .= "Elaboração e Implementação do PPR - Programa de Proteção Respiratória com base ao PPRA;";
        }else if(in_array($items[$x], $prod15)){
           $tmp .= "Elaboração do Relatório Técnico de Laudo de Insalubridade;";
        } /*else if(in_array($items[$x], $prod16)){
           $tmp .= "Análise de Fumo não Metálico (Enxofre);";
        }else if(in_array($items[$x], $prod17)){
           $tmp .= "Análise de Ruído Dosimetria (Dosímetro);";
        }*/
		else{
			$ss = "SELECT * FROM produto WHERE cod_prod = '$items[$x]'";
			$qq = pg_query($ss);
			$aa = pg_fetch_array($qq);
			$tmp .= $aa[desc_resumida_prod].";";
		}
    }
   $tmp .= "(\"Serviços\")";
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
        $cabecalho  = "<div style=\"text-align: right;\"><font size=1>Página {PAGENO} de {nb}</font></div>";
        $cabecalho .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
        $cabecalho .= "<tr>";
        $cabecalho .= "<td align=left height=$header_h valign=top>";
        $cabecalho .= "<span class='bigTitle'><b>SESMT<sup>®</sup></b></span>";
        $cabecalho .= "<BR>";
        $cabecalho .= "SERVIÇOS ESPECIALIZADOS DE SEGURANÇA";
        $cabecalho .= "<BR>";
        $cabecalho .= "E MONITORAMENTO DE ATIVIDADES NO TRABALHO EIRELI";
        $cabecalho .= "";
        $cabecalho .= "</td>";
        $cabecalho .= "<td align=left height=$header_h width=300>
        <table width=100% cellspacing=2 cellpadding=2 border=0>
        <tr>
        <td><b>Nº DO CONTRATO:</b></td><td>$cliente[ano_contrato].".str_pad($cliente[cliente_id], 4,"0",STR_PAD_LEFT)."</td>
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
    $code .= "<div style=\"text-align: center;\"><b>CONTRATO DE PRESTAÇÃO DE SERVIÇOS ".strtoupper($contract[tipo_contrato])."</b></div>";
    $code .= "<p align=justify>";
    $code .= "<b>SESMT SERVIÇOS ESPECIALIZADOS DE SEGURANÇA E MONITORAMENTO DE ATIVIDADES NO TRABALHO EIRELI</b> sociedade devidamente constituída e validamente existente de acordo com as leis do Brasil, inscrita no CNPJ sob o nº 04.722.248/0001-17 e com Inscrição Municipal nº 311.213-6, situada na Rua Marechal Antônio de Souza, 92 na Cidade Rio de Janeiro, Estado RJ, Tel. 21-3014 4304 Ramal 25, fax. 21-3014 4304 Ramal. 25, aqui representada pelo Sr. Pedro Henrique da Silva, RG 000994-6 DDSSD / SIT / MTE, a seguir denominada <b>CONTRATADA</b>.";
    $code .= "<p align=justify>";
    $code .= "<b>".strtoupper($cliente[razao_social])."</b> sociedade devidamente constituída e validamente existente de acordo com as leis do Brasil, com sede na $cliente[endereco] $cliente[num_end], $cliente[bairro], município $cliente[municipio], e estado $cliente[estado], tel. $cliente[telefone], inscrito no CNPJ sob nº $cliente[cnpj], neste ato representado em conformidade com seu contrato social / estatuto, daqui por diante denominada <b>CONTRATANTE</b>;  e.";
    $code .= "<p align=justify>";
    $code .= "(conjuntamente denominadas \"Partes\", e individualmente \"Parte\").";
    $code .= "<p align=justify>";
    $code .= "<b>CONSIDERANDO QUE</b>, de acordo com as NR 9.1.1 que estabelece a obrigatoriedade da elaboração de implantação, por parte de todos os empregadores e instituições que admitam trabalhadores como empregados, do Programa de Prevenção de Riscos Ambientais - PPRA, visando a prevenção da saúde e da integridade dos trabalhadores, através da antecipação, reconhecimento, avaliação e consequentemente o controle de ocorrências de riscos ambientais que existam ou que venha a existir no ambiente de trabalho.";
    $code .= "<p align=justify>";
    $code .= "<b>CONSIDERANDO QUE</b>, nos termos da legislação vigente, (artigo 168 da Consolidação das Leis de Trabalho, Portaria 24 SSST, de 29 de dezembro de 1994; Portaria nº 8, de 08 de Maio de 1996; Normas Regulamentadoras nº 5, 7, 9 e 17, e Instrução Normativa n° 99 do INSS, entre outros, conforme alterados). É obrigatório, por parte dos empregadores, elaborar e implementar: Programa de Controle Médico de Saúde Ocupacional (\"PCMSO\"); Programa de Prevenção de Riscos Ambientais (\"PPRA\"); Laudo Técnico de Condições Ambientais do Trabalho (\"LTCAT\"); Perfil Profissiográfico Previdenciário (\"PPP\"); Mapas de Riscos (\"MR\"); Laudos Ergonômicos (\"Laudos Ergonômicos\"); Atestados de Saúde Ocupacional (\"ASO\"); proferir palestras e promover campanhas de vacinação Antigripal e antitetânica, entre outros;";
    $code .= "<p align=justify>";
    $code .= "<b>CONSIDERANDO QUE</b>, em resposta ao orçamento emitido de nº ".str_pad($contract[cod_orcamento], 4, "0", STR_PAD_LEFT)."/$contract[ano_orcamento] da CONTRATANTE, a CONTRATADA encaminhou à CONTRATANTE uma proposta comercial, documentos anexos ao presente instrumento (\"<b>ANEXO 1</b>\");";
    $code .= "<p align=justify>";
    $code .= "<b>CONSIDERANDO QUE</b>, a CONTRATADA possui a experiência e os recursos necessários para prestar os serviços objeto do presente instrumento;";
    $code .= "<p align=justify>";
    $code .= "<b>RESOLVEM</b>: justas e acertadas, celebrar o presente Contrato de Prestação de Serviços (\"Contrato\"), que se regerá pelas seguintes cláusulas e condições:";
    $code .= "<p align=justify>";

    $code .= "<b>CLÁUSULA PRIMEIRA - DO OBJETO DO CONTRATO</b>";
    $code .= "<p align=justify>";
    
    $code .= "1.1 O presente Contrato tem por finalidade a prestação dos serviços de: ".servicos($il).".";
    $code .= "<p align=justify>";
    
    if($cliente[numero_funcionarios] > 19)
        $code .= "<b>Parágrafo Único</b>: O curso para cipistas eleitos só poderão ser ministrados para os membros votados em scrutino secreto, para esses casos os cursos poderão ser ministrados nas instalações da CONTRATANTE. Obedecendo o calendário de cronograma de ações de gestão da CIPA que consta no ambiente pesquisa no site: www.sesmt-rio.com acesso através do botão cliente de cor laranja e no botão \"serviços\".";
    else
        $code .= "<b>Parágrafo Único</b>: Na forma da lei quando a empresa não estiver enquadrada na obrigatoriedade de manter a CIPA (Comissão Interna de Prevenção de Acidentes), constituída a mesma acatará o disposto na NR 5.6.4. Nesses casos em que se designar um candidato ao curso o mesmo será minsitrado na instalação da CONTRATADA em dias agendados pelo CONTRATANTE no site: www.sesmt-rio.com acesso através do botão cliente de cor laranja e no botão \"serviços\".";

    $code .= "<p align=justify>";
    
    $code .= "<b>CLÁUSULA SEGUNDA - DA OBRIGAÇÃO DA CONTRATADA</b>";
    $code .= "<p align=justify>";
    
    $code .= "2.1 Constituem obrigações da CONTRATADA:";
    $code .= "<p align=justify>";

    $code .= "($alfabeto) Elaborar e implantar o PCMSO para a CONTRATANTE, de acordo com as Especificações Técnicas constantes na NR 7, considerando as NR`s 15 e 17.";
    $code .= "<p align=justify>";
    $alfabeto++;

    $code .= "($alfabeto) Realizar todos os atendimentos e exames médicos previstos no PCMSO (exames médicos admissionais, periódicos, de retorno ao trabalho, de mudança de função e demissionais), incluindo avaliação clínica, anamnese ocupacional, exame físico e mental e coordenar a todos os exames complementares. Nos funcionários da CONTRATANTE. Todos os exames médicos periódicos poderão ser realizados nas dependências da CONTRATANTE, desde que seja feito um adeno, logo que assinado o contrato viabilizando o acordo (\"<b>ANEXO 2</b>\"), para isso a CONTRATANTE contará com a necessidade de equipamentos, como: Maca, Balança, Escadinha de Maca, Arquivo com chaves, Mesa composta de cadeiras para o profissional examinador e o paciente, a sala deve ser arejada com ar condicionado e ou ventilador.";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Avaliar e determinar a periodicidade da realização dos exames médicos aplicáveis;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Emitir todos os ASO`s, conforme aplicável, para tanto as solicitações se darão por acesso a internet no endereço www.sesmt-rio.com, botão cliente; clicar em  botão serviço; no link agendamento, o mesmo deverá ocorrer em até 72 horas de antecedência em alguns casos poderá levar até 120 horas de acordo com a complexidade do exame complementar solicitado pelo médico coordenador do PCMSO, todo e qualquer exame exigido antes das 72 horas a CONTRATADA fica desobrigada de cumprir por força da necessidade dos resultados dos exames complementares esses quando solicitados.";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "<b>Parágrafo Único</b>: A CONTRATANTE declara possuir um efetivo populacional registrado em CTPS de ($cliente[numero_funcionarios]) vidas, que se submeteram a exames clínicos ocupacioal; exames complementares \"sempre que solicitado pelo médico coordenador do PCMSO NR7\" e elaboração do PPP - Perfil Profissiográfico Previdenciário.";
    $code .= "<p align=justify>";

    $code .= "($alfabeto) Manter prontuário clínico individual em arquivo por período não inferior a 20 anos de todos os empregados da CONTRATANTE, solicitar da última contratada o arquivo físico da CONTRATANTE para posse e guarda fiel dos mesmos periodicamente manuseá-lo a fim de garantir a organização e comprobabilidade dos mesmos;";
    $code .= "<p align=justify>";
    $alfabeto++;

    $code .= "($alfabeto) Emitir e apresentar à CONTRATANTE relatório médico anual, conforme aplicável;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Elaborar e implementar o PPRA para a CONTRATANTE de acordo com as especificações técnicas constantes na NR 9, devendo acompanhar e avaliar periodicamente até o cumprimento total de todos os serviços contratados;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Elaborar Mapa de Risco Geral em tamanho \"A3\" e 02 (Dois) mapas de riscos setoriais em tamanhos também \"A4\", para os locais indicados pela CIPA da CONTRATANTE. Os mapas de riscos deverão ser entregues com impressão colorida;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Realizar o levantamento das condições ergonômicas, e emitir o relatório técnico de avaliação ergonômicos, conforme aplicável;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Elaborar e implantar o LTCAT e o PPP, mantendo-os atualizados, conforme aplicável. O arquivo eletrônico dos PPP`s emitidos deverão ser disponibilizados para a área de RH/ADM da CONTRATANTE, via sistema internet no endereço www.sesmt-rio.com, através da senha de uso particular no botão cliente;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    // LETRA K SÓ ESTAR DISPONÍVEL SE TIVER CONSULTORIA À CIPA NO ORÇAMENTO
    // RECEBER NÚMERO DE FUNCIONÁRIOS E SUBSTITUIR PELO (00) -> DONE
    //COD 980 e 981
    $sql = "SELECT * FROM site_orc_produto WHERE cod_orcamento = ".(int)($contract[cod_orcamento])." AND cod_produto = 981 OR cod_produto = 980";
    $rct = pg_query($sql);
    if(pg_num_rows($rct)){
        $code .= "($alfabeto) Proferir ($cliente[numero_funcionarios]) treinamento(s) sobre tema(s) relativo(s) à higiene do trabalho e prevenção de acidentes até o vencimento do contrato, em decorrer a consultoria da CIPA datas e horários a serem acordados com a CONTRATANTE em adeno (\"<b>ANEXO 3</b>\") assinado 72 horas da assinatura do contrato serão estes: Palestra sobre uso de EPI e Brigada de Incêndio e Curso da CIPA designado NR 5.6.4;";
        $code .= "<p align=justify>";
        $alfabeto++;
    }
    
    //SÓ SE HOUVER MAIS DE 19 FUNCIONÁRIOS
    if($cliente[numero_funcionarios] > 19){
        $code .= "($alfabeto) Organizar anualmente a campanha de eleição para escolha de participantes da CIPA Comissão Interna de Prevenção de Acidentes em scrutino secreto, ministração do curso para 01 membro, conforme estipula a NR 5.32 lei 6.514/77 e Port. 3.214/78.";
        $code .= "<p align=justify>";
        $alfabeto++;
    }

    //SÓ SE HOUVER BRIGADA
    $sql = "SELECT * FROM site_orc_produto WHERE cod_orcamento = ".(int)($contract[cod_orcamento])." AND cod_produto = 982";
    $rcy = pg_query($sql);
    if(pg_num_rows($rcy)){
        $code .= "($alfabeto) Constituir a formação de brigadistas para prevenção contra incêndio constituída de (01) Chefe de Equipe, (01) Líder de Equipes e ($membros_brigada) membros.";
        $code .= "<p align=justify>";
        $alfabeto++;
    }
    
    $code .= "($alfabeto) Prover todos os equipamentos e pessoal necessário para a correta e completa prestação dos Serviços;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Garantir as boas condições dos seus consultórios conveniados para a prestação dos Serviços complementares, dotados de todos os equipamentos necessários e certificações para o cumprimento das obrigações aqui previstas;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Observar toda legislação, regulamentações, disciplinas e regulamentos aplicáveis e vigentes quanto a prestação dos Serviços; prestando um trabalho com alto padrão técnico e qualidade, nos prazos e condições convencionados, fornecendo pessoal qualificado, responsabilizando-se pelos Serviços prestados; A CONTRATADA se compromete realizar visita Técnica de integração, por profissional da segurança, a CONTRATANTE, com chegada programada mensalmente a serem agendadas e pactuadas em adeno tão logo a assinatura do contrato, para o cumprimento das mesmas por parte da Sesmt Serviços Especializados de Segurança e Monitoramento de Atividade no Trabalho EIRELI. Essas visitas deverão obedecer ao critério de serem redigidas, impressas e enviadas a CONTRATANTE com cópia protocolada.";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Responder por todas as despesas e obrigações relativas a remuneração, transporte, alimentação, eventuais adicionais devidos, previdência social e prevenção contra acidentes relacionadas aos seus empregados alocados para a prestação dos Serviços;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Garantir, nos termos da legislação em vigor, que os empregados envolvidos na prestação dos Serviços utilizem todos os equipamentos de segurança necessários, quando aplicável, isentando-se a CONTRATANTE de qualquer responsabilidade pelos danos causados e/ou sofridos pelos empregados da CONTRATADA por negligência, imperícia ou imprudência dos mesmos durante a realização dos procedimentos necessários à prestação dos Serviços;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Orientar ao responsável do Departamento Pessoal ou RH da CONTRATANTE à necessidade de afastamento do trabalhador à exposição aos riscos ocupacionais existentes, bem como o encaminhamento do trabalhador à previdência social, para estabelecimento de nexo causal. Avaliação de incapacidade e definição de conduta previdenciária em relação ao trabalho considerado anormal a fim de evitar qualquer reclamação trabalhista, previdenciária ou cível decorrente de acidentes de trabalho atinentes a seus empregados;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Responsabilizar-se pela obtenção de todas as licenças e alvarás necessários para o fornecimento e execução dos Serviços;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Informar à CONTRATANTE, por escrito, quaisquer atos ou fatos relevantes relativos aos Serviços;";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) Refazer os Serviços considerados, a critério da CONTRATANTE, insatisfatórios ou incompletos, sem quaisquer custos adicionais.";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "($alfabeto) De forma a garantir a qualidade e comprobabilidade dos relatórios técnicos os mesmos deverão, em decorrência a saída ou ingresso de trabalhadores ao quadro funcional,  realizar a manutenção dos programas do PPRA; PCMSO; LTCAT; Laudo Ergonômico e o PPP, onde a CONTRATANTE arcará com os custos desses serviços, os custos ficam na ordem de R$ 25,00 por mês sempre que houver manutenção a sofrer os documentos por força de movimentação de pessoal <b>\"Pro rata\"</b>.";
    $code .= "<p align=justify>";
    $alfabeto++;
    
    $code .= "<b>Parágrafo Único</b>: sempre que solicitado pelo fiscal o prontuário médico e os exames complementares a CONTRATANTE solicitará a CONTRATADA para o seu envio até 72 h da visita do fiscal, não responsabilizando a CONTRATADA caso a solicitação seja por um período de tempo superior ao estabelecido neste contrato.";
    $code .= "<p align=justify>";

    $code .= "<b>CLÁUSULA TERCEIRA - DA OBRIGAÇÃO DA CONTRATANTE</b>";
    $code .= "<p align=justify>";

    $code .= "3.1 Constituem obrigações da CONTRATANTE:";
    $code .= "<p align=justify>";

    $code .= "(a) Auxiliar a elaboração e implementação do PCMSO por parte da CONTRATADA; e permitir o acesso da CONTRATADA aos locais necessários para a prestação dos Serviços;";
    $code .= "<p align=justify>";

    $code .= "(b) Fornecer todos os dados cadastrais de seus empregados para que sejam providenciados os prontuários clínicos individuais. Informar com antecedência os funcionários admitidos, demitidos, mudança de função e retorno de licença e fornecer dados da contratada anterior à contratação da, SESMT Serviços Especializados de Segurança e Medicina do Trabalho EIRELI para solicitação do arquivo físico junto ao mesmo para que a guarda e conservação do referido arquivo passe a responsabilidade do médico coordenador atual força desse contrato;";
    $code .= "<p align=justify>";

    $code .= "(c) Após a migração dos E-Docs eletrônicos e suas hospedagens por parte da CONTRATADA, os relatórios técnicos, ASO´s, PPP´s, Anaminésias, Fichas Médicas e Exames Complementares, deverão ser pela CONTRATANTE resguardados os acessos de forma a proporcionar o imediato acesso por parte das autoridades competentes quando necessitar.";
    $code .= "<p align=justify>";

    $code .= "<b>Parágrafo Primeiro</b>: Só poderão ter acesso a prontuário médico, ficha médica, anamnese e exames complementares, fiscal médico, de forma nenhuma a outra formação acadêmica, sempre que o fiscal habilitado solicitar a CONTRATANTE deverá requisitar da CONTRATADA que realizou os exames médicos e exames médicos complementares o arquivo físico para averiguação do fiscal e após isso acontecer retornar a CONTRATADA para arquivamento.";
    $code .= "<p align=justify>";
    
    $code .= "<b>Parágrafo Segundo</b>: Sempre que o fiscal exigir os programas impressos após notificar o pedido, esse deverá ser processado em papel reciclável.";
    $code .= "<p align=justify>";

    $code .= "(d) Cumprir integralmente as normas emanadas do Ministério do Trabalho e Emprego, em especial as contidas nas NR 7 (PCMSO); 9 (PPRA); 15 (Insalubridade); 16 (Periculosidade) e a 17 (Riscos Ergonômicos);";
    $code .= "<p align=justify>";
    
    $code .= "(e) Acatar integralmente, dentro do que especifica a lei 6.514/77 e sua portaria 3.214/78, as orientações apresentadas por escrito nos programas do (PPRA; PCMSO e APGRE)(LTCAT - IN84 INSS) ou descritas no sistema de relacionamento internet no endereço www.sesmt-rio.com, de acesso exclusivo do cliente e do operador atendente ambos via login e senha;";
    $code .= "<p align=justify>";
    
    $code .= "(f) Não caberá ao CONTRATANTE postular direitos sobre matéria já abordada em relatório técnico (PPRA; PCMSO; LTCAT; APGRE) e não cumprido por parte da CONTRATANTE, dessa forma a CONTRATANTE se compromete sempre que cumprida alguma exigência informar a CONTRATADA o cumprimento das mesmas;";
    $code .= "<p align=justify>";
    
    $code .= "(g) descumprimento as determinações do coordenador dos programas médico  e de prevenção a acidentes do trabalho, não garantem a eficácia dos programas do (PPRA e PCMSO, APGRE e todo e qualquer laudo emitido da CONTRATANTE).";
    $code .= "<p align=justify>";
    
    $code .= "(h) A CONTRATANTE se compromete a, em nenhum momento, realizar atendimentos médicos ocupacionais (ASO e ou Complementares) sem que seja sob orientação da CONTRATADA, havendo este comportamento por parte da CONTATANTE, fica a CONTATADA isenta de responsabilidades, evitando assim a desclassificar o atendimento como proposto nas cláusulas: 2.1 (b;c;d;e;f)";
    $code .= "<p align=justify>";
    
    $code .= "(i) No caso da CONTRATANTE optar pela escolha de outra empresa que não seja a indicada pela CONTRATADA, para realização dos procedimentos médicos complementares prescritos no ASO, deverá ser enviado a CONTRATADA o original dos mesmos junto com a anamnese, a fim de que o profissional examinador componha o arquivo físico, e atualização da ficha médica. Vale dizer que a CONTRATADA fica isenta da desqualificação do atendimento conforme determinado na alinea (h);";
    $code .= "<p align=justify>";
    
    $code .= "(j) Enviar mensalmente à CONTRATADA uma relação nominal, discriminando os empregados da CONTRATANTE admitidos e demitidos, via sistema internet www.sesmt-rio.com, botão cliente e depois em botão relação de funcionário.";
    $code .= "<p align=justify>";
    
    $code .= "(k) Caso ocorra uma nova admissão, demissão isoladamente após a assinatura do contrato ou dos programas terem sidos confeccionados, a CONTRATANTE deverá pagar, a titulo de manutenção dos programas, para efeito de atualização conforme exigências das NR`s 7.2.4 e 7.3.1 da lei 6.514/77 e da sua portaria 3.214/78. Para tanto será cobrado automaticamente, sempre que realizado o ASO a importância de R$ 25,00 (vinte e cinco reais) inseridos ao valor da Fatura cobrada mensal.";
    $code .= "<p align=justify>";
    
    $code .= "<b>Parágrafo Primeiro</b>: Sempre que houver qualquer que seja a modificação seja de layout, na atividade da empresa, da forma de executar suas atividades ou movimentação do quadro funcional, deverá comunicar a CONTRATADA imediatamente toda e qualquer alteração ambiental, mudança de layout, mudança de pessoal entre setores, mudança ou ampliação de ramo de atividade, através do site www.sesmt-rio.com em botão \"Cliente\" e depois no botão visita técnica, com uso da senha de acesso.";
    $code .= "<p align=justify>";
    
    $code .= "<b>Parágrafo Segundo</b>: Sempre que ocorrer o registro de ocorrência de acidentes ou comprovação de doença ocupacional, a CONTRATANTE deverá registrar a informação através do site www.sesmt-rio.com no botão cliente, em botão serviços \"Mapa Anual de Acidente e Doenças Ocupacionais\" ou em visita técnica prevista para sua empresa mensalmente quando contratado esse serviço conforme documentos anexos ao presente instrumento (\"<b>ANEXO 4</b>\");";
    $code .= "<p align=justify>";
    
    $code .= "(l) Pagar os exames complementares realizados pela clínica conveniada para a mesma que optar pelo atendimento, em boleto do conveniado os custos de exames complementares necessários ao controle de trabalhadores submetidos a riscos ocupacionais específicos levantados pelo PPRA - Programa de Prevenção de Riscos Ambientais, ora orçados separadamente e aprovado pela CONTRATANTE a realização dos mesmos.";
    $code .= "<p align=justify>";
    
    $code .= "(m) Reembolsar ao CONTRATADO os valores de eventuais despesas que se fizerem necessárias, tais como viagens, estadias, transporte e alimentação de profissionais, desde que a prestação de serviços ora ajustada ocorra fora do Município em que estiver locada a CONTRATADA e ou fora do que estiver acordado neste contrato será cobrado além do reembolso a diária no valor de R$ 250,00 por profissional envolvido de nível superior e de R$ 170,00 para os de nível técnico.";
    $code .= "<p align=justify>";
    
    $code .= "(n) A CONTRATANTE compromete-se a efetuar o pagamento dos boletos vincentes e os já vencidos (quando ocorrer atrasos), através do documento bancário, ficando vedado o depósito em conta corrente e sujeito as correções de encargos como previsto na cláusula: 4.5 deste contrato.";
    $code .= "<p align=justify>";
    
    //BUSCAR VALORES DE ENVIO DE CORRESPONDEICA E ENCARGO BANCARIO DO CADASTRO DE PRODUTOS
    $sql = "SELECT * FROM produto WHERE cod_prod = 7302";
    $envio_cor = pg_fetch_array(pg_query($sql));
    $sql = "SELECT * FROM produto WHERE cod_prod = 7303";
    $encargos = pg_fetch_array(pg_query($sql));
    
    $code .= "(o) A CONTRATANTE pagará em boleto bancário a ser emitido pela CONTRATADA a contar da data da assinatura do contrato em favor do CONTRATADO, independente de ter ou não iniciado ou concluído os serviços, sob os valores correspondentes da planilha de atendimento e ou proposta emitida pelo CONTRATADO e assinada pela CONTRATANTE, será cobrado junto os valores de R$ ".number_format($encargos[preco_prod], 2, ',','.')." (".ltrim(valorPorExtenso($encargos[preco_prod])).") de encargos bancários e R$ ".number_format($envio_cor[preco_prod], 2, ',','.')." (".ltrim(valorPorExtenso($envio_cor[preco_prod])).") por envio de correspondências postadas via correios sempre que ocorrer o caso.";
    $code .= "<p align=justify>";
    
    $code .= "<b>CLÁUSULA QUARTA - DA REMUNERAÇÃO</b>";
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
            $code .= "4.1 As Partes concordam que a remuneração da CONTRATADA pela prestação dos Serviços será a seguinte: <b>R$ ".number_format($valor_total, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, acrescido de taxa de gerenciamento de contrato aberto ficando o cliente livre para praticar exames ocupacionais, sem nenhuma paga a mais. Essa taxa será de alíquota de 30% do valor do contrato. Ficando a mensalidade no valor de <b>R$ ".number_format(round($valor_total_mod/$contract[n_parcelas], 2), 2, ",",".")." (".ltrim(valorPorExtenso(round($valor_total_mod/$contract[n_parcelas], 2))).")</b>, pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (".str_replace('reais','',valorPorExtenso($contract[n_parcelas])).") parcelas iguais.";
        }elseif($contract[n_parcelas] == 1){
            $code .= "4.1 As Partes concordam que a remuneração da CONTRATADA pela prestação dos Serviços será a seguinte: <b>R$ ".number_format($valor_total_mod, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, acrescido de taxa de gerenciamento de contrato aberto ficando o cliente livre para praticar exames ocupacionais, sem nenhuma paga a mais. Essa taxa será de alíquota de 30% do valor do contrato, ficando a mensalidade no valor de <b>R$ ".number_format(round($valor_total_mod/$contract[n_parcelas], 2), 2, ",",".")." (".ltrim(valorPorExtenso(round($valor_total_mod/$contract[n_parcelas], 2))).")</b>, pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (uma) parcela.";
        }else{
            $code .= "4.1 As Partes concordam que a remuneração da CONTRATADA pela prestação dos Serviços será a seguinte: <b>R$ ".number_format($valor_total, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, acrescido de taxa de gerenciamento de contrato aberto ficando o cliente livre para praticar exames ocupacionais, sem nenhuma paga a mais. Essa taxa será de alíquota de 30% do valor do contrato, ficando a mensalidade no valor de <b>R$ ".number_format(round($valor_total_mod/$contract[n_parcelas], 2), 2, ",",".")." (".ltrim(valorPorExtenso(round($valor_total_mod/$contract[n_parcelas], 2))).")</b>, pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (".str_replace('reais','',valorPorExtenso($contract[n_parcelas])).") parcelas iguais.";
        }
    }elseif($contract[tipo_contrato] == "fechado"){
    //CONTATO FECHADO
        if($contract[n_parcelas] > 3){
            $code .= "4.1 As Partes concordam que a remuneração da CONTRATADA pela prestação dos Serviços será a seguinte: <b>R$ ".number_format($valor_total, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, acrescido de taxa de gerenciamento de contrato fechado ficando o cliente livre para praticar exames ocupacionais \"periódicos\", exceto no caso dos ASO´s(Atestado de Saúde Ocupacional) dos tipos: Admissional, demissional e mudança de função, sem nenhuma paga a mais. Essa taxa será de alíquota de 18% do valor do contrato. Ficando a mensalidade no valor de <b>R$ ".number_format(round($valor_total_mod/$contract[n_parcelas], 2), 2, ",",".")." (".ltrim(valorPorExtenso(round($valor_total_mod/$contract[n_parcelas], 2))).")</b>, pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (".str_replace('reais','',valorPorExtenso($contract[n_parcelas])).") parcelas iguais.";
        }elseif($contract[n_parcelas] == 1){
            $code .= "4.1 As Partes concordam que a remuneração da CONTRATADA pela prestação dos Serviços será a seguinte: <b>R$ ".number_format($valor_total, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, ficando o cliente livre para praticar exames ocupacionais \"periódicos\", exceto no caso dos ASO´s(Atestado de Saúde Ocupacional) dos tipos: Admissional, demissional e mudança de função, sem nenhuma paga a mais. Pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (uma) parcela.";
        }else{
            $code .= "4.1 As Partes concordam que a remuneração da CONTRATADA pela prestação dos Serviços será a seguinte: <b>R$ ".number_format($valor_total, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, ficando o cliente livre para praticar exames ocupacionais \"periódicos\", exceto no caso dos ASO´s(Atestado de Saúde Ocupacional) dos tipos: Admissional, demissional e mudança de função, sem nenhuma paga a mais. Ficando a mensalidade no valor de <b>R$ ".number_format(round($valor_total_mod/$contract[n_parcelas], 2), 2, ",",".")." (".ltrim(valorPorExtenso(round($valor_total_mod/$contract[n_parcelas], 2))).")</b>, pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (".str_replace('reais','',valorPorExtenso($contract[n_parcelas])).") parcelas iguais.";
        }

    }elseif($contract[tipo_contrato] == "misto"){
    //CONTATO MISTO
       if($contract[n_parcelas] > 3){
          $code .= "4.1 As Partes concordam que a remuneração da CONTRATADA pela prestação dos Serviços será a seguinte: <b>R$ ".number_format($valor_total, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, acrescido de taxa de gerenciamento de contrato aberto ficando o cliente livre para praticar exames ocupacionais \"periódicos\", exceto no caso dos ASO´s(Atestado de Saúde Ocupacional) dos tipos: Admissional, demissional e mudança de função, sem nenhuma paga a mais. Essa taxa será de alíquota de 18% do valor do contrato. Ficando a mensalidade no valor de <b>R$ ".number_format(round($valor_total_mod/$contract[n_parcelas], 2), 2, ",",".")." (".ltrim(valorPorExtenso(round($valor_total_mod/$contract[n_parcelas], 2))).")</b>, pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (".str_replace('reais','',valorPorExtenso($contract[n_parcelas])).") parcelas iguais.";
       }elseif($contract[n_parcelas] == 1){
          $code .= "4.1 As Partes concordam que a remuneração da CONTRATADA pela prestação dos Serviços será a seguinte: <b>R$ ".number_format($valor_total, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, ficando o cliente livre para praticar exames ocupacionais \"periódicos\", exceto no caso dos ASO´s(Atestado de Saúde Ocupacional) dos tipos: Admissional, demissional e mudança de função, sem nenhuma paga a mais. Pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (uma) parcela.";
       }else{
          $code .= "4.1 As Partes concordam que a remuneração da CONTRATADA pela prestação dos Serviços será a seguinte: <b>R$ ".number_format($valor_total, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, ficando o cliente livre para praticar exames ocupacionais \"periódicos\", exceto no caso dos ASO´s(Atestado de Saúde Ocupacional) dos tipos: Admissional, demissional e mudança de função, sem nenhuma paga a mais. Ficando a mensalidade no valor de <b>R$ ".number_format(round($valor_total_mod/$contract[n_parcelas], 2), 2, ",",".")." (".ltrim(valorPorExtenso(round($valor_total_mod/$contract[n_parcelas], 2))).")</b>, pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (".str_replace('reais','',valorPorExtenso($contract[n_parcelas])).") parcelas iguais.";
       }

    }elseif($contract[tipo_contrato] == "especifico" || $contract[tipo_contrato] == "específico"){
       if($contract[n_parcelas] > 3){
          $code .= "4.1 As Partes concordam que a remuneração da CONTRATADA pela prestação dos Serviços será a seguinte: <b>R$ ".number_format($valor_total, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, acrescido de taxa de gerenciamento de contrato aberto ficando o cliente livre para praticar exames ocupacionais \"periódicos\", exceto no caso dos ASO´s(Atestado de Saúde Ocupacional) dos tipos: Admissional, demissional e mudança de função, sem nenhuma paga a mais. Essa taxa será de alíquota de 18% do valor do contrato. Ficando a mensalidade no valor de <b>R$ ".number_format(round($valor_total_mod/$contract[n_parcelas], 2), 2, ",",".")." (".ltrim(valorPorExtenso(round($valor_total_mod/$contract[n_parcelas], 2))).")</b>, pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (".str_replace('reais','',valorPorExtenso($contract[n_parcelas])).") parcelas iguais.";
       }elseif($contract[n_parcelas] == 1){
          $code .= "4.1 As Partes concordam que a remuneração da CONTRATADA pela prestação dos Serviços será a seguinte: <b>R$ ".number_format($valor_total, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, ficando o cliente livre para praticar exames ocupacionais \"periódicos\", exceto no caso dos ASO´s(Atestado de Saúde Ocupacional) dos tipos: Admissional, demissional e mudança de função, sem nenhuma paga a mais. Pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (uma) parcela.";
       }else{
          $code .= "4.1 As Partes concordam que a remuneração da CONTRATADA pela prestação dos Serviços será a seguinte: <b>R$ ".number_format($valor_total, 2, ",",".")." (".ltrim(valorPorExtenso($valor_total)).")</b>, ficando o cliente livre para praticar exames ocupacionais \"periódicos\", exceto no caso dos ASO´s(Atestado de Saúde Ocupacional) dos tipos: Admissional, demissional e mudança de função, sem nenhuma paga a mais. Ficando a mensalidade no valor de <b>R$ ".number_format(round($valor_total_mod/$contract[n_parcelas], 2), 2, ",",".")." (".ltrim(valorPorExtenso(round($valor_total_mod/$contract[n_parcelas], 2))).")</b>, pagos em ".STR_PAD($contract[n_parcelas], 2, '0', 0)." (".str_replace('reais','',valorPorExtenso($_GET[parcelas])).") parcelas iguais.";
       }
    }
    $code .= "<p align=justify>";
    
    $code .= "<b>Parágrafo Primeiro</b>: Os serviços ora listados na proposta comercial obedecem ao um critério de agrupamento de colaboradores representada da seguinte forma: 1 à 10, 11 à 20, 21 à 50, 51 à 100, 101 à 150, 151 à 250, 251 à 350, 351 à 450, 451 à 500, 501 à 600, 601 à 700, 701 à 800, 801 à 900, 901 à 1000, cabendo sempre que houver manutenções conforme cláusulas 2.1(c) parágrafo único, 2.1(w) e 3.1(k) ocorrerá alteração \"Correção\" automática da cobrança obedecendo ao tabelamento de preços e a fiel cobrança para as \"partes\", evitando que a CONTRATADA deixe de receber os valores de direito e salva guardar a CONTRATANTE de continuar pagando valores acima do que devido por parte de ter reduzido o seu quadro funcional.";
    $code .= "<p align=justify>";
    
    $code .= "<b>Parágrafo Segundo</b>: Conforme parágrafo único na cláusula segunda, em que é mencionado o real efetivo da CONTRATANTE, a CONTRATADA recebe como fiel a informação. Ficando estabelecido que no momento do cadastramento dos dados funcionais de cada colaborador da CONTRATANTE na confecção dos relatórios técnicos, serão corrigidas as parcelas vincendas e cobrada de uma única vez no primeiro vencimento de nova fatura os valores retroativos desde o primeiro vecimento até onde se detecta a divergência.";
    $code .= "<p align=justify>";
    
    
    //VERIFICAR TEXTO ¨¨¨¨¨¨¨¨**|**¨¨¨¨¨¨¨
    if($contract[tipo_contrato] == "misto"){
    //MISTO
        $code .= "(a) Pela a elaboração e implantação do PCMSO e do PPP, incluindo a prestação dos serviços de realização de atendimentos e exames, avaliação de periodicidade de exames, emissão de ASO`s, manutenção de prontuários em 02 (dois) meios expedientes semanais e 01 (um) expediente integral por semana e emissão de relatórios anuais, conforme previsto na cláusula 2.1, a CONTRATANTE pagará mensalmente à CONTRATADA o valor total, fixo de R$ 3,91 (três reais e noventa e um centavos) por cada um de  seus efetivos empregados lotados na G1 em Duque de Caxias - RJ e o valor total, fixo de R$ 3,01 (três reais e um centavo) por cada um de seus efetivos empregados lotados na G2 do Distrito de Imbarie - Rio de Janeiro - RJ; independente de ter ocorrido qualquer consulta médica ocupacional. Esses valores multiplicados por 1.484  (Mil Quatrocentos e Oitenta e Quatro) empregados, obtem-se um total anual de R$ 5.643,74 (Cinco Mil Seiscentos e Quarenta e três reais e Setenta e Quatro centavos).";
        $code .= "<p align=justify>";
        $code .= "(b) Pela elaboração e implantação do PPRA e do LTCAT, conforme previsto na cláusula 2.1, a CONTRATANTE pagará à CONTRATADA o valor total, fixo de R$ 4.059,84 (Quatro mil e cinquenta e nove reais e oitenta e quatro centavos), o que será dividido e pago em (03) três parcelas mensais, iguais e subsequentes, sendo a primeira parcela devida após (30) trinta dias da assinatura deste Contrato; e a terceira e última parcela devida condicionada à entrega dos documentos correspondentes ao PPRA e ao LTCAT as parcelas serão pagas a CONTRATADA nos valores iguais de: R$ 1.353,28 (Um mil trezentos e cinquenta e três reais e vinte e oito centavos).";
        $code .= "<p align=justify>";
        $code .= "(c) Pela elaboração de Laudo Ergonômico, conforme previsto na cláusula 2.1, a CONTRATANTE pagará à CONTRATADA o valor total, fixo de R$ 5.008,80 (Cinco mil, e oito reais e oitenta centavos), o que será dividido e pago em (03) três parcelas mensais, iguais e subseqüentes, sendo a primeira parcela devida após (30) trinta dias da assinatura deste Contrato; e a terceira e última parcela devida condicionada à entrega dos documentos correspondentes ao LAUDO ERGONÔMICO as parcelas serão pagas a CONTRATADA nos valores iguais de: R$ 1.669,60 (mil, seiscentos e sessenta e nove reais e sessenta centavos).";
        $code .= "<p align=justify>";
        $code .= "(d) Pela elaboração do MR, conforme previsto na cláusula 2.1, a CONTRATANTE pagará à CONTRATADA o valor total, fixo de R$ 990,00 (Novecentos e noventa reais), o que será dividido e pago em (03) três parcelas mensais, iguais e subsequentes, sendo a primeira parcela devida após 30 (trinta) dias da assinatura deste Contrato; e a terceira e última parcela devida condicionada à entrega dos documentos correspondentes; ao MR as parcelas serão pagas a CONTRATADA nos valores iguais de: R$ 330,00 (Trezentos e trinta reais).";
        $code .= "<p align=justify>";
        $code .= "(e) Pela realização de palestras, conforme previsto na cláusula 2.1, a CONTRATANTE pagará à CONTRATADA o valor total, fixo de R$ 150,00 (Cento e cinqüenta reais), por palestra, o que será devido após 30 dias da realização de cada palestra;";
        $code .= "<p align=justify>";
        $code .= "(f) Pela vacinação Antigripal nos empregados e prestadores de serviços da CONTRATANTE, a mesma pagará à CONTRATADA o valor fixo de R$ 70,00 (Setenta reais) por pessoa alocada na G1 em Caxias-RJ e o valor fixo de R$ 70,00 (Setenta reais) por pessoa alocada na G2 Imbarie - RJ. Estes preços incluem os custos com aplicação e fornecimento das vacinas e a quantidade a ser paga será a realmente executada e atestada pela Fiscalização;";
        $code .= "<p align=justify>";
        $code .= "(g) Pela vacinação antitetânica nos empregados e prestadores de serviços da CONTRATANTE, a mesma pagará à CONTRATADA o valor fixo de R$ 75,00 (Setenta e cinco reais) por pessoa alocada na G1 em Caxias-RJ e o valor fixo de R$ 75,00 (Setenta e cinco reais) por pessoa alocada na Sede G2 em Imbarie - RJ. Estes preços incluem os custos com aplicação e fornecimento das vacinas e a quantidade a ser paga será a realmente executada e atestada pela Fiscalização;";
        $code .= "<p align=justify>";
        $code .= "(h) Pelo serviço de formação de Brigada de incêndio a CONTRATANTE pagará o valor total fixo de R$ 97,00 (Noventa e sete reais), o que será dividido em (03) três parcelas iguais e subsequentes, sendo a primeira parcela devida após 30 (trinta) dias da assinatura deste Contrato; e a terceira e última parcela devida condicionada à entrega dos documentos correspondentes; a certificação dos brigadistas. As parcelas serão pagas a CONTRATADA nos valores iguais de: R$ 2.101,66 (Dois mil cento e um reais e sessenta e seis centavos).";
        $code .= "<p align=justify>";
        $code .= "4.2 Os pagamentos devidos pela CONTRATANTE à CONTRATADA em decorrência deste Contrato somente vencerão: (I) após 10 dias do envio pela CONTRATADA à CONTRATANTE da respectiva nota fiscal acompanhada de relatório resumo de fatura, (\"Anexo 5\") contendo a descrição dos serviços prestados e (II) após aprovação pela CONTRATANTE dos serviços prestados relatados na nota fiscal pertinente. As partes concordam que a CONTRATANTE não pagará a remuneração devida à CONTRATADA mediante deposito ou Doc. Bancário, e sim que os pagamentos devidos a CONTRATADA serão pagos através de boletos bancários ou documentos similares.";
        $code .= "<p align=justify>";
        $code .= "4.3 Na remuneração prevista na cláusula 4.1, as Partes concordam que a CONTRATADA incluiu todos os tributos e despesas necessárias e aplicáveis à prestação dos Serviços, inclusive os custos com transportes, refeições, etc.";
        $code .= "<p align=justify>";
        $code .= "4.4 Todas e quaisquer despesas eventualmente necessárias à prestação dos Serviços e que não se encontrem incluídas na remuneração prevista na cláusula 4.1 somente serão reembolsadas à CONTRATADA se forem previamente aprovadas por escrito pela CONTRATANTE e devidamente comprovadas pela CONTRATADA.";
        $code .= "<p align=justify>";
        $code .= "4.5 Ocorrendo atraso do pagamento estipulado na cláusula 4.1, item (a), será acrescido à cobrança multa de 3% (três por cento) mais juros de 0,29% ao dia \"pro rata die\".";
        $code .= "<p align=justify>";
    }else{
        $code .= "4.2 Os pagamentos devidos pela CONTRATANTE à CONTRATADA em decorrência deste Contrato somente serão considerado como débito: (I) após 05 dias do envio pela CONTRATADA à CONTRATANTE da respectiva nota fiscal acompanhada de relatório resumo de fatura, (\"<b>ANEXO 5</b>\") contendo a descrição dos Serviços prestados e (II) após aprovação pela CONTRATANTE dos Serviços prestados relatados na nota fiscal pertinente. As partes concordam que a CONTRATANTE não pagará a remuneração devida à CONTRATADA mediante deposito ou Doc. Bancário, e sim que os pagamentos devidos a CONTRATADA serão pagos através de boletos bancários ou documentos similares.";
        $code .= "<p align=justify>";
        $code .= "4.3 Na remuneração prevista na cláusula 4.1, as Partes concordam que a CONTRATADA incluiu todos os tributos e despesas necessárias e aplicáveis à prestação dos Serviços, inclusive os custos com transportes, refeições, etc.";
        $code .= "<p align=justify>";
        $code .= "4.4 Todas e quaisquer despesas eventualmente necessárias à prestação dos Serviços e que não se encontrem incluídas na remuneração prevista na cláusula 4.1 somente serão reembolsadas à CONTRATADA se forem previamente aprovadas por escrito pela CONTRATANTE e devidamente comprovadas pela CONTRATADA.";
        $code .= "<p align=justify>";
        $code .= "4.5 Ocorrendo atraso do pagamento estipulado na cláusula 4.1, item (a), será acrescido à cobrança multa de 3% (três por cento) mais juros de 0,29% ao dia \"pro rata die\".";
        $code .= "<p align=justify>";
    }
    
    if($contract[tipo_contrato] == "especifico"){
       $code .= "4.6 A data do vencimento do documento bancário e do pagamento será dia <b>$vencimento[2]</b> tratando-se de pagamento avista por ser o contrato de serviços específicos, \"sendo concedido mais 05 cinco dias corridos como prazo para pagamento sem correção ou acréscimo\".";
       $code .= "<p align=justify>";
   }else{
       $code .= "4.6 A data do vencimento do documento bancário e do pagamento será todo dia <b>$vencimento[2]</b> de cada mês, \"sendo concedido mais 05 cinco dias corridos como prazo para pagamento sem correção ou acréscimo\".";
       $code .= "<p align=justify>";
   }
    
    $code .= "<b>CLÁUSULA QUINTA - DA FORMA DA APRESENTAÇÂO DOS SERVIÇOS</b>";
    $code .= "<p align=justify>";
    
    $code .= "5.1 Os programas técnicos que correspondem à engenharia de segurança do trabalho e de higiene do trabalho serão apresentados de forma on-line em site da CONTRATANTE www.sesmt-rio.com, através de uso da sua senha pessoal, seu passaporte como administrador será o e-mail cadastrado e a senha será cadastrada secretamente, quando efetuar ou atualizar seu cadastro.";
    $code .= "<p align=justify>";
    
    $code .= "5.2 A CONTRATANTE como administradora poderá gerar dois usuários secundários da senha do administrador, com passaportes e senhas diferentes do administrador, cabe ao administrador limitar o acesso dos dois usuários se desejar cadastra-los, (\"<b>ANEXO 6</b>\"); a contratante tem ciência que  os documentos de anamnese, ficha médica e o arquivos de exames complementares (Ex: Urina, Fezes) ficarão sujeitos à sua responsabilidade da não divulgação, visto que tratam-se de informações sigilosas.";
    $code .= "<p align=justify>";
    
    $code .= "5.3 As rubricas e assinaturas apareceram nos relatórios scaneadas e serão enviados junto ao contrato na forma de (\"<b>ANEXO 7</b>\") procuração dos profissionais que assinam os programas validando assim o documento que em fiscalização deverá ser exibido em tela e apresentar o contrato com as procurações e cópia dos comprovantes de pagamento;";
    $code .= "<p align=justify>";
    
    $code .= "5.4 No caso de não pagamento de parcela até o 5º (quinto) dia da data do vencimento conforme cláusula 4.6 a CONTRATADA reserva-se ao direito de bloquear a senha de acesso da CONTRATANTE até que se efetue o(s) respectivo(s) pagamento(s) da(s) boleta(s) vendida(s);";
    $code .= "<p align=justify>";
    
    $code .= "<b>Parágrafo Único</b>: o bloqueio das senhas se dará ao do administrador que automaticamente bloqueará as dos usuários secundários e o acesso do contador em enxergar seus arquivos, o bloqueio dos programas se fará com 05 (cinco) dias de atraso da fatura e para os ASO`s com 05 (cinco) dias de atraso da fatura.";
    $code .= "<p align=justify>";
    
    $code .= "5.5 Documentos que ficarão disponíveis on-line:";
    $code .= "<p align=justify>";
    
    $code .= "(a) Todos os programas e documentos, bem como cópias dos certificados de treinamentos conforme descritos na prestação de serviço da cláusula primeira deste contrato, assim como as cópias dos exames complementares realizados em clínicas terceirizadas indicadas pela CONTRATADA.";
    $code .= "<p align=justify>";
    
    $code .= "<b>CLÁUSULA SEXTA - DO PRAZO E RESCISÃO</b>";
    $code .= "<p align=justify>";
    
    $code .= "6.1 Este Contrato vigorará pelo prazo de ".strtolower($contract[validade])." a contar da data de sua assinatura, e a sua renovação se dará automaticamente desde que a CONTRATANTE não se manifeste contrária a sua renovação até o 30º dia que antecede o seu término. Podendo ser prorrogado por até igual período, mediante acordo entre as Partes.";
    $code .= "<p align=justify>";
    
    $code .= "6.2 Qualquer uma das Partes poderá considerar rescindido o presente Contrato nas seguintes hipóteses (I) descumprimento de qualquer uma das obrigações contratuais assumidas pela outra Parte, desde que esta, devidamente notificada, não cumpra a obrigação no prazo de 10 (dez) dias corridos, a contar da notificação ou (II) entrada em regime de falência, concordata ou liquidação por qualquer uma das Partes.";
    $code .= "<p align=justify>";
    
    $code .= "6.3 Cada uma das Partes poderá rescindir este Contrato a qualquer tempo, mediante notificação prévia de 30 (trinta) dias, não cabendo aplicação de multas ou qualquer indenização, salva-guardando os compromissos de pagamentos pactuados neste contrato nas cláusulas: 4.2; 4.4 e 4.5.";
    $code .= "<p align=justify>";
    
    $code .= "<b>CLÁUSULA SÉTIMA - ASPECTO TRABALHISTA</b>";
    $code .= "<p align=justify>";
    
    $code .= "7.1 A CONTRATADA é a única responsável pelo contrato de trabalho das pessoas designadas por ela, para a prestação dos Serviços, não podendo ser argüida solidariedade da CONTRATANTE, nem mesmo responsabilidade subsidiária, nas relações trabalhistas relacionadas aos Serviços prestados pela CONTRATADA. A mesma declara, ainda, não existir qualquer vínculo empregatício entre a CONTRATANTE e as pessoas designadas pela CONTRATADA. Para a prestação dos Serviços. Para os fins da presente cláusula, a CONTRATANTE terá o direito de exigir que a CONTRATADA lhe apresente quaisquer documentos necessários à comprovação do cumprimento de suas obrigações trabalhistas e previdenciárias.";
    $code .= "<p align=justify>";
    
    $code .= "<b>CLÁUSULA OITAVA - INCIDÊNCIAS FISCAIS</b>";
    $code .= "<p align=justify>";
    
    $code .= "8.1 Todos os tributos e incidências fiscais, de qualquer natureza, que recaiam ou venham a recair sobre quaisquer valores pagos à CONTRATADA serão de sua única e exclusiva responsabilidade.";
    $code .= "<p align=justify>";
    
    $code .= "<b>CLÁUSULA NONA - SIGILO</b>";
    $code .= "<p align=justify>";

    $code .= "9.1 Todos e quaisquer dados e informações contidos neste Contrato, produzidos, desenvolvidos ou por qualquer forma obtidos pela CONTRATADA em razão deste Contrato só poderão ser divulgados com o prévio e expresso consentimento da CONTRATANTE.";
    $code .= "<p align=justify>";

    $code .= "<b>CLÁUSULA DECIMA - PERDAS E DANOS</b>";
    $code .= "<p align=justify>";

    $code .= "10.1 A CONTRATADA fica desobrigada a pagar toda e qualquer indenização por danos ou prejuízos causados direta e ou indiretamente por ela a qualquer de seus prepostos à CONTRATANTE; a terceiros em decorrência da não execução das recomendações e observações nos serviços, prestados pela CONTRATADA ao CONTRATANTE, ficando a CONTRATADA descompromissada a ressarcir ou responder judicialmente.";
    $code .= "<p align=justify>";

    //$code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [11]
/****************************************************************************************************************/
    $code .= "<b>CLÁUSULA DÉCIMA PRIMEIRA - DISPOSIÇÕES GERAIS</b>";
    $code .= "<p align=justify>";

    $code .= "11.1 As disposições previstas neste Contrato são celebradas em caráter irrevogável e irretratável, obrigando as Partes, seus herdeiros e sucessores, para todos os fins de direito e a qualquer título.";
    $code .= "<p align=justify>";

    $code .= "11.2 Os direitos e obrigações decorrentes deste Contrato não podem ser cedidos a terceiros sem o prévio e expresso consentimento, por escrito, da outra Parte.";
    $code .= "<p align=justify>";

    $code .= "11.3 A tolerância, por qualquer das Partes, ao não cumprimento pela Parte contrária de qualquer dos termos ou condições do presente Contrato, não constituirá abdicação dos direitos que lhe são aqui ou em lei assegurados.";
    $code .= "<p align=justify>";

    $code .= "11.4 Todos e quaisquer adendos ou alterações ao presente Contrato só serão válidos se feitos através de aditivo a este Contrato, assinado por ambas as Partes.";
    $code .= "<p align=justify>";

    $code .= "11.5 Todas e quaisquer correspondências enviadas por uma das Partes à outra se fará por escrito, não devendo ser injustificadamente retidas ou atrasadas, e serão endereçadas conforme segue:";
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
    $tmp = str_replace("(ª)", "", $tmp);
    $tmp = str_replace("(°)", "", $tmp);

    $code .= "Representada: Senhor(ª): $tmp";
    $code .= "<BR>";
    if(!empty($cliente[email_contato_dir])){
        $code .= $cliente[email_contato_dir];
        $code .= "<BR>";
    }
    $code .= "SCE - Sistema de Comunicação Externo, em www.sesmt-rio.com";
    $code .= "<p align=justify>";

    $code .= "<b>CONTRATADA:</b>";
    $code .= "<BR>";
    $code .= "Rua Marechal Antônio de Souza 92, Rio de Janeiro";
    $code .= "<BR>";
    $code .= "Jardim América - Cep 21240-430 - Brasil";
    $code .= "<BR>";
    $code .= "Fax: 55-21-3014 4304";
    $code .= "<BR>";
    $code .= "Representada: Sr. Pedro Henrique";
    $code .= "<BR>";
    $code .= "comercial@sesmt-rio.com, sempre com cópia para financeiro@sesmt-rio.com";
    $code .= "<BR>";
    $code .= "Nextel: 21-7844 9394 - 55*23*31368";
    $code .= "<BR>";
    $code .= "SCE - Sistema de Comunicação Externo, em www.sesmt-rio.com";

    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [12]
/****************************************************************************************************************/
    $code .= "<p align=justify>";
    $code .= "<b>CLÁUSULA DECIMA SEGUNDA - FORO</b>";
    $code .= "<p align=justify>";

    $code .= "12.1 As Partes elegem o foro Central da Comarca da Capital do Estado do Rio de Janeiro para dirimir quaisquer questões oriundas deste Contrato que não possam ser legalmente dirimidas, com exclusão de qualquer outro, por mais privilegiado que seja ou possa vir a ser. E, por estarem de acordo, assinam o presente Contrato em 02 (duas) vias de igual teor e forma, na presença de 02 (duas) testemunhas.";
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
    $code .= "SESMT SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<BR>E MONITORAMENTO DE ATIVIDADES NO TRABALHO EIRELI";
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
//ADENO DE CONTRATO -> ANEXO 2 [REALIZAÇÃO DO ASO DENTRO DA EMPRESA] <- Questionário [Pedro]
/************************************************************************************************/
if(strtolower($contract[sala]) == "sim"){

    $code .= "<div class='pagebreak'></div>";
    
    $code .= "<div style=\"text-align: center;\"><b>(\"ANEXO 2\")</b></div>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    
    $code .= "<b>ANEXO PRIMEIRO - DA FINALIDADE</b>";
    $code .= "<p align=justify>";

    $code .= "<b>Anexo 1.1</b> Em atendimento a necessidade de um serviço personalizado e visando a qualidade dos serviços prestados e a fidelidade de uma melhor consultoria de segurança e higiene do trabalho, implantada pela Sesmt Serviços Especializados em Segurança e Monitoramento de Atividades no Trabalho EIRELI.";
    $code .= "<p align=justify>";

    $code .= "<b>Anexo 1.2</b> A CONTRATANTE, vem por intermédio deste, solicitar a está instituição prestadora de serviços de higiene do trabalho, a realização dos Atestados de Saúde Ocupacional, no interior da empresa CONTRATANTE;";
    $code .= "<p align=justify>";

    $code .= "<b>Anexo 1.3</b> procedimentos para realização da higiene do trabalho e seus complementares poderão ser realizados nas dependências da CONTRATANTE, desde que a mesma forneça a CONTRATADA: Sala em bom estado de conservação; devidamente arejada; munida de mesa acompanhada de (02) duas cadeiras;";
    $code .= "<p align=justify>";

    $code .= "<b>Anexo 1.4</b> A CONTRATADA compromete-se a remeter os funcionários de (03) Três por vez em período de intervalo de 50 minutos, garantindo assim o bom desempenho do profissional examinador;";
    $code .= "<p align=justify>";

    $code .= "<b>ANEXO SEGUNDO - DA REMUNERAÇÃO PELOS SERVIÇOS</b>";
    $code .= "<p align=justify>";

    $code .= "<b>Anexo 2.1</b> pelos serviços na modalidade personalizada serão cobrados a taxa de deslocamento o valor de R$ 20,00 (Vinte Reais) para atendimentos no Município do Rio de Janeiro e R$ 50,00 (Cinqüenta Reais) para demais Municípios, tratando-se de atendimento fora da localização da unidade pré estabelecida em contrato.";
    $code .= "<p align=justify>";

    $code .= "<b>Anexo 2.2</b> Pelos serviços de locação de mão de obra de medicina ocupacional a CONTRATANTE pagará a CONTRATADA os valores correspondentes a R$ 350,00 (Trezentos e cinqüenta reais) para meio período de atendimento diário e R$ 700,00 (Setecentos Reais) para períodos integrais, quando o atendimento for fora da localização da unidade pré estabelecida em contrato.";
    $code .= "<p align=justify>";

    $code .= "<b>Anexo 2.3</b> para os procedimentos médicos complementares ao ASO, as custas serão pagas a CONTRATADA que repassará a clinica conveniada a CONTRATADA, pela realização dos serviços em boleto bancário após a realização dos serviços;";
    $code .= "<p align=justify>";

    $code .= "<b>Anexo 2.4</b> Nenhum atendimento complementar poderá ser inferior a (10) atendimentos sendo cobrado taxa de deslocamento da clinica conveniada da CONTRATADA, de R$ 50,00 (Cinqüenta Reais) para cobrir frete dos equipamentos pagos a clinica conveniada ou encaminhar o funcionário da CONTRATANTE a um dos endereços que ficam no site: www.sesmt-rio.com, no botão cliente, botão agendamento saúde ocupacional.";
    $code .= "<p align=justify>";

    $code .= "<b>PARAGRAFO ÚNICO:</b> A CONTRATANTE poderá escolher outra clinica a seu desejo para a realização dos procedimentos complementares, valendo dizer que o ASO Atestado de Saúde Ocupacional, só será liberado em sistema www.sesmt-rio.com, para visualização após a CONTRATANTE ou a clinica prestadora dos serviços à escolha da CONTRATANTE, entregar os resultados dos exames e a anaminésia preenchida e assinada pelo médico e funcionário da CONTRATANTE.";
    $code .= "<p align=justify>";
    
    $code .= "<b>Anexo 2.5</b> A CONTRATADA poderá disponibiliza os acessórios Necessários que se fizerem necessários para montagem de sala de atendimento médico, como: Maca; Balança; escadinha para maca, a titulo locação pelo custo de R$ 90,00 (Noventa Reais), a diária e ou R$ 120,00 (Cento e Vinte Reais) pago fixo e mensal, sempre a CONTRANTE desejar mediante celebração de contrato de locação dos mobiliários.";
    $code .= "<p align=justify>";
    
    $code .= "<b>PARAGRAFO ÚNICO:</b> Sempre que houver exames complementares esses acessórios deverão compor a sala, não sendo necessário a CONTRATADA ter que aluga-los a mesma poderá também adquiri-los como de sua propriedade, em nenhum momento a CONTRATADA ou uma de suas Clinicas conveniada são obrigadas a oferecer esses acessórios, por força da prestação dos serviços.";
    $code .= "<p align=justify>";

    $code .= "<b>ANEXO TERCEIRO - DA FORMA DE PAGAMENTO</b>";
    $code .= "<p align=justify>";

    $code .= "<b>Anexo 3.1</b> Os pagamentos devido a CONTRATANTE, serão pagos conforme cláusula 4.1 destecontrato;";
    $code .= "<p align=justify>";

    $code .= "<b>Anexo 3.2</b> Os pagamento pertinentes a clinica conveniada indicada pela CONTRATANTE será efetuado em documento de cobrança próprio remetido pela CONTRATADA.";
    $code .= "<p align=justify>";
    
    $code .= "<div class='pagebreak'></div>";
    
    $code .= "<b>ANEXO QUARTO - FORO</b>";
    $code .= "<p align=justify>";

    $code .= "<b>Anexo 4.1</b> As Partes elegem o foro Central da Comarca da Capital do Estado do Rio de Janeiro para dirimir quaisquer questões oriundas deste Contrato que não possam ser legalmente dirimidas, com exclusão de qualquer outro, por mais privilegiado que seja ou possa vir a ser.";
    $code .= "<p align=justify>";

    $code .= "E, por estarem de acordo, assinam o presente Contrato em 02 (duas) vias de igual teor e forma, na presença de 02 (duas) testemunhas.";
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
    $code .= "SESMT SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<BR>E MONITORAMENTO DE ATIVIDADES NO TRABALHO EIRELI";
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
//ADENO DE CONTRATO -> ANEXO 3 [REALIZAÇÃO DE PALESTRAS]
/************************************************************************************************/
//VERIFICAÇÂO DE ITEMS DO ORÇAMENTO
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
    
    $code .= "<b>Anexo 1.1</b> Em atendimento a necessidade de uma implantação da cultura prevencionista, institui-se a ministração de palestras com duração de no máximo 01h00min e visando a qualidade dos serviços prestados e a fidelidade de uma melhor cultura de segurança, implantada pela Sesmt Serviços Especializados em Segurança e Monitoramento de Atividades no Trabalho EIRELI.";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 1.2</b> As palestras serão ministradas mensalmente e por um período não superior a 02h00min;";
    $code .= "<p align=justify>";

    $code .= "<b>ANEXO SEGUNDO - DA AGENDA DE PALESTRAS</b>";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 2.1</b> As palestras serão ministradas por um profissional de segurança do trabalho ou higiene ocupacional da CONTRATADA ou por quem ela designar;";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 2.2</b> Caberá a CONTRATADA informar com antecedência quando, prestadores de serviços terceiros forem contratados com antecedência mínima de 05 (Cinco) dias a CONTRATANTE;";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 2.3</b> As palestras terão temas educativos visando a prevenção e a gerar uma política de cultura de segurança no trabalho e terão temas como:";
    $code .= "<p align=justify>";
    $code .= "$ctxt";
    $code .= "<p align=justify>";
    
    
    $code .= "<b>ANEXO TERCEIRO - DO MATERIAL PARA REALIZAÇÃO DAS PALESTRAS</b>";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 3.1</b> O material didático correrão por conta da CONTRATADA;";
    $code .= "<p align=justify>";
    $code .= "<b>PARAGRAFO ÚNICO:</b> São esses: Ficha de Presença; Certificados de Participação; Material Áudio Visual.";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 3.2</b> Os acessórios correrão por conta da CONTRATANTE;";
    $code .= "<p align=justify>";
    $code .= "<b>PARAGRAFO ÚNICO:</b> São esses: Sala devidamente arejada; cadeiras; computador; retropojetor conexão USB; flip chart; quadro com caneta piloto.";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 3.3</b> A data das palestras serão todo     /      /       . e sempre que o dia escolhido cair em um final de semana a palestra será dimensionada automaticamente para a segunda feira seguinte;";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 3.4</b> Havendo qualquer necessidade de mudança por força do trabalho a CONTRATANTE deverá se comunicar por escrito via e-mail: segtrab@sesmt.com num prazo de 72 horas mínimas a indisponibilidade da liberação de seu efetivo para a palestra, isso não desmarca a visita técnica que acontecera, apenas suprimi a palestra que não poderá ser acumuladas.";
    $code .= "<p align=justify>";

    $code .= "<div class='pagebreak'></div>";

    $code .= "<b>ANEXO QUARTO - FORO</b>";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 4.1</b> As Partes elegem o foro Central da Comarca da Capital do Estado do Rio de Janeiro para dirimir quaisquer questões oriundas deste Contrato que não possam ser legalmente dirimidas, com exclusão de qualquer outro, por mais privilegiado que seja ou possa vir a ser.";
    $code .= "<p align=justify>";
    $code .= "E, por estarem de acordo, assinam o presente Contrato em 02 (duas) vias de igual teor e forma, na presença de 02 (duas) testemunhas.";
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
    $code .= "SESMT SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<BR>E MONITORAMENTO DE ATIVIDADES NO TRABALHO EIRELI";
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
//ADENO DE CONTRATO -> ANEXO 4 [VISITAS TÉCNICAS]
/************************************************************************************************/
//VERIFICAÇÂO DE ITEMS DO ORÇAMENTO
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
    
    $code .= "<b>Anexo 1.1</b> A CONTRATANTE, solicita da CONTRATADA o serviço de visita técnica em sua instalação a fim de garantir a fidelidade de série de procedimentos técnicos.";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 1.2</b> As visitas Técnicas serão realizadas mensalmente e por um período não superior a (04) quatro horas;";
    $code .= "<p align=justify>";

    $code .= "<b>ANEXO SEGUNDO - DA FORMA DE APRESENTAÇÃO E ACESSO</b>";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 2.1</b> O acesso do profissional de segurança da Sesmt Serviços Especializados em Segurança e Monitoramento de Atividades no Trabalho EIRELI, se dará em dia e hora marcada e definida em agenda de visita apresentada pelo CONTRATADO;";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 2.2</b> Nosso profissional se apresentará a pessoa designada pelo CONTRATANTE na sua entrada e na sua saída com cartão de anotação de ponto de chegada e saída para controle da Sesmt Serviços Especializados em Segurança e Monitoramento de Atividades no Trabalho EIRELI;";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 2.3</b> A O acesso por parte de nosso profissional de segurança necessita a ausência de qualquer restrição do acesso, haja em vista a necessidade de conhecer todos os locais de posto de trabalho visando o sucesso do relatório a ser emitido a CONTRATADA e a fidelidade do relatório de segurança elaborado pela CONTRATANTE;";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 2.4</b> CONTRATANTE se compromete a remeter manter todo e total sigilo de toda informação levantada por nos, cabendo tão somente relatar tecnicamente dentro da matéria de segurança e higiene do trabalho.";
    $code .= "<p align=justify>";
    
    $code .= "<b>ANEXO TERCEIRO - RELATÓRIO DE VISITA TÉCNICA</b>";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 3.1</b> A CONTRATADA emitira um relatório da visita técnica detalhando o quadro critico do CONTRATANTE de forma poder monitorar as pendências e incidências de riscos encontradas;";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 3.2</b> A CONTRATADA se compromete a remeter relatório de visita técnica em até (10) dez dias da data da visita da forma por escrito.";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 3.3</b> A CONTRATADA poderá indicar prestadores de serviços para a CONTRATANTE a fim de auxilia no cumprimento das inconformidades encontrada, mais não se responsabiliza por qualquer insatisfação que possa vir acontecer por parte do CONTRATANTE;";
    $code .= "<p align=justify>";
    $code .= "<b>PARAGRAFO ÚNICO:</b> A CONTRATADA poderá prestar a consultoria de monitoramento a CONTRATANTE, como terceirizada como \"compradora\" do seguimento de prevenção de acidente e higiene ocupacional e ou locação de mão de obra numa das áreas ou até mesmo as duas, desde que celebrado contrato de prestação de serviços para essa modalidade.";
    $code .= "<p align=justify>";
    
    $code .= "<b>ANEXO QUARTO - FORMA DE REMUNERAÇÃO</b>";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 4.1</b> A CONTRATADA cobrará a CONTRATANTE pelas visitas técnicas deste contrato o valor de R$ 150,00 (Cento e Cinqüenta Reais) sempre que solicitadas fora da data e agenda em site www.sesmt-rio.com, no botão \"cliente\" através de senha de acesso, ou que quando exceder por solicitação da CONTRATADA o tempo da visita (horas de permanência do profissional no interior da empresa). A CONTRATADA monitorará o tempo do profissional via rádio a fim de evitar excesso e gere desconforto a CONTRATANTE;";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 4.2</b> No caso da CONTRATANTE solicitar a visita por tempo maior das quatro horas, nesse caso o custa para cada hora excedida será de R$ 50,00 (Cinqüenta Reais), para período de permanência de cada (01) horas e 250,00 (Duzentos e Cinqüenta Reais) para cada plantão de 06 horas diárias;";
    $code .= "<p align=justify>";
    $code .= "<b>PARAGRAFO ÚNICO:</b> Fica vedado qualquer gratificação a titulo de gorjeta ou outro qualquer nome a se utilizar, caso qualquer profissional da CONTRATADA venha receber ou solicitar algum ganho que não seja o de sua folha de pagamento e a CONTRATADA venha a tomar conhecimento encontrar-se-á sumariamente demitido do quadro funcional da CONTRATADA.";
    $code .= "<p align=justify>";
    
    
    $code .= "<div class='pagebreak'></div>";

    $code .= "<b>ANEXO QUINTO - FORO</b>";
    $code .= "<p align=justify>";
    $code .= "<b>Anexo 5.1</b> As Partes elegem o foro Central da Comarca da Capital do Estado do Rio de Janeiro para dirimir quaisquer questões oriundas deste Contrato que não possam ser legalmente dirimidas, com exclusão de qualquer outro, por mais privilegiado que seja ou possa vir a ser.";
    $code .= "<p align=justify>";
    $code .= "E, por estarem de acordo, assinam o presente Contrato em 02 (duas) vias de igual teor e forma, na presença de 02 (duas) testemunhas.";
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
    $code .= "SESMT SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<BR>E MONITORAMENTO DE ATIVIDADES NO TRABALHO EIRELI";
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
    $code .= "<td style=\"border: 1px solid #000000; border-right: 0px;\"><b>Resumo da Fatura de Serviço</b></td>";
    $code .= "<td align=right  style=\"border: 1px solid #000000; border-left: 0px;\"><b>Nº 2429/09</b></td>";
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
    $code .= "<b>Código do cliente:</b> ".str_pad($cliente[cliente_id], 4, "0",0)."<BR>";
    $code .= "<b>Data da emissão:</b> 01/04/2009<BR>";
    $code .= "<b>Período de cobrança:</b> 01/03/2009 à 01/04/2009<BR>";
    $code .= "<b>Vencimento:</b> 16/04/2009<BR>";
    $code .= "</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=2 align=center><img src='../../../images/exemplo-fatura.jpg' border=0></td>";
    $code .= "</tr>";
    $code .= "</table>";
    
/************************************************************************************************/
//ADENO DE CONTRATO -> ANEXO 6 [SIGÍLO]
/************************************************************************************************/
    $code .= "<div class='pagebreak'></div>";

    $code .= "<div style=\"text-align: center;\"><b>(\"ANEXO 6\")</b></div>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";

    $code .= "<b>CONSIDERANDO QUE:</b> Na ótica da justiça, nenhuma pessoa pode ser descriminada por qualquer fato que seja, ou motivo algum;";
    $code .= "<p align=justify>";
    $code .= "<b>CONSIDERANDO QUE:</b> A CONTRATANTE e a CONTRATADA são as únicas responsáveis pela administração de todas as informações obtidas e geradas oriunda dos exames médicos complementares;";
    $code .= "<p align=justify>";
    $code .= "<b>CONSIDERANDO QUE:</b> A CONTRATANTE, é responsável pela sua senha pessoal e de veda o acesso dos seus dois usuários secundários;";
    $code .= "<p align=justify>";
    $code .= "<b>RESOLVEM:</b> que é de inteira responsabilidade da CONTRATANTE resguardar as informações médicas complementares de seus funcionários;";
    $code .= "<p align=justify>";
    $code .= "<b>CLÁUSULA PRIMEIRA - OBJETIVO DO ANEXO DO CONTATO</b>";
    $code .= "<p align=justify>";
    $code .= "<b>Cláusula 1.2</b> Fica vedada o direito de divulgação de maneira a expor qualquer que seja o motivo às informações dos resultados de exames médicos complementares de funcionário da CONTRATANTE por parte da CONTRATADA;";
    $code .= "<p align=justify>";
    $code .= "<b>Cláusula 1.3</b> A CONTRATANTE é a única responsável pela guarda fiel das informações de seus funcionários.";
    $code .= "<p align=justify>";
    $code .= "<b>PARAGRAFO ÚNICO:</b> Cabe a CONTRATANTE resguardar sua senha de acesso e limitar o acesso dos dois usuários secundário, vale dizer que quando em fiscalização por parte do Ministério do Trabalho e do Emprego a CONTRATANTE não é obrigada a exibir as informações a fiscal que não seja Médico, sendo de sua responsabilidade se tal fato ocorrerem.";
    $code .= "<p align=justify>";


    $code .= "<div class='pagebreak'></div>";

    $code .= "<b>CLÁUSULA SEGUNDA - FORO</b>";
    $code .= "<p align=justify>";
    $code .= "2.1 As Partes elegem o foro Central da Comarca da Capital do Estado do Rio de Janeiro para dirimir quaisquer questões oriundas deste Contrato que não possam ser legalmente dirimidas, com exclusão de qualquer outro, por mais privilegiado que seja ou possa vir a ser.";
    $code .= "<p align=justify>";
    $code .= "E, por estarem de acordo, assinam o presente Contrato em 02 (duas) vias de igual teor e forma, na presença de 02 (duas) testemunhas.";
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
    $code .= "SESMT SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<BR>E MONITORAMENTO DE ATIVIDADES NO TRABALHO EIRELI";
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
//ADENO DE CONTRATO -> ANEXO 7 [AUTORIZAÇÃO ASSINATURA TÉCNICO]
/************************************************************************************************/
    $code .= "<div class='pagebreak'></div>";

    $code .= "<div style=\"text-align: center;\"><b>(\"ANEXO 7\")</b></div>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    $code .= "<div style=\"text-align: center;\"><b>Autorização</b></div>";
    $code .= "<p align=justify>";
    $code .= "Venho informar a quem interessar saber que Eu, Pedro Henrique da Silva, portador(a) do registro profissional nº RJ/000994-6 órgão expedidor MTE.";
    $code .= "<p align=justify>";
    $code .= "A qual mantém contrato de prestação de serviços de responsável técnica com a empresa: Sesmt Serviços e Especializados de Segurança e Monitoramento de Atividades no Trabalho EIRELI, sob o CNPJ: 04.722.248/0001-17 autoriza a empresa prestadora de serviços em consultoria de Segurança e Medicina Ocupacional a vincular minha rubrica e assinatura nos relatórios os quais sou coordenador (a) em exibição digital no site da empresa. Dando fé à assinatura por mim emitidas através de senha pessoal de acesso ao sistema intrenet da empresa.";
    $code .= "<p align=justify><BR>";
    $code .= "<p align=justify><BR>";
    $code .= "<p align=justify><BR>";
    $code .= "<p align=justify><BR>";
    
    $code .= "<div style=\"text-align: center;\"><img src='../../../images/assinatura_tecnico.jpg' border=0 width=332 height=150></div>";

/************************************************************************************************/
//ADENO DE CONTRATO -> ANEXO 7 [AUTORIZAÇÃO ASSINATURA MÉDICO]
/************************************************************************************************/
    $code .= "<div class='pagebreak'></div>";

    $code .= "<div style=\"text-align: center;\"><b>(\"ANEXO 7\")</b></div>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    $code .= "<div style=\"text-align: center;\"><b>Autorização</b></div>";
    $code .= "<p align=justify>";
    $code .= "Venho informar a quem interessar saber que Eu, Maria de Lourdes Fernandes de Magalhães, portadora do registro profissional nº 52.33.471-0 órgão expedidor CREMERJ e 13.320 MTE.";
    $code .= "<p align=justify>";
    $code .= "A qual mantém contrato de prestação de serviços de responsável técnica com a empresa: Sesmt Serviços e Especializados de Segurança e Monitoramento de Atividades no Trabalho EIRELI, sob o CNPJ: 04.722.248/0001-17, autoriza a empresa prestadora de serviços em consultoria de Segurança e Higiene do Trabalho a vincular minha rubrica e assinatura nos relatórios os quais sou coordenador (a) em exibição digital no site da empresa. Dando fé à assinatura por mim emitidas através de senha pessoal de acesso ao sistema intrenet da empresa.";
    $code .= "<p align=justify><BR>";
    $code .= "<p align=justify><BR>";
    $code .= "<p align=justify><BR>";
    $code .= "<p align=justify><BR>";

    $code .= "<div style=\"text-align: center;\"><img src='../../../images/assinatura_medico.jpg' border=0 width=260 height=122></div>";
/************************************************************************************************/
//ADENO DE CONTRATO -> ANEXO 8 [ARQUIVO FÍSICO]
/************************************************************************************************/
    $code .= "<div class='pagebreak'></div>";

    $code .= "<div style=\"text-align: center;\"><b>(\"ANEXO 8\")</b></div>";
    $code .= "<p align=justify>";
    $code .= "<BR>";
    $code .= "<p align=justify>";
    
    $code .= "<p align=justify>";
    $code .= "<table border=0 width=100%><tr><td><b>Remetente:</b> Drª. Maria de Lourdes Fernandes de Magalhães</td><td width=100><b>Ofício:</b> 0003/09</td></tr></table>";
    $code .= "<p align=justify>";
    $code .= "<b>Destinatário:</b> Dptº Médico do Trabalho";
    $code .= "<p align=justify>";

    $code .= "<table border=0 width=100%><tr><td width=150><b>Razão social:</b></td><td style=\"border: 1px solid #000000;\">&nbsp;&nbsp;</td></tr></table>";
    $code .= "<p align=justify>";
    $code .= "Venho por intermédio desta, solicitar a está instituição prestadora de serviços médicos ocupacionais, os Prontuários Médicos, Fichas Médicas e Exames Complementares dos funcionários da empresa: ".$cliente[razao_social];
    $code .= "<p align=justify>";
    $code .= "<b>Motivo:</b>";
    $code .= "<p align=justify>";
    $code .= "A empresa: {$cliente[razao_social]}, sob o CNPJ: {$cliente[cnpj]}, possui um contrato de prestação de serviço com a SESMT Serviços Especializados em Segurança e Monitoramento de Atividades no Trabalho EIRELI, sendo assim respeitosamente solicitamos a remessa de documentos que compõe o arquivo físico da referida empresa, em cumprimento a legislação 6.514/77 portaria 3.214/78 NR 7.4.5. Os dados obtidos nos exames médicos, incluindo avaliação clínica e exames complementares, as conclusões e as medidas aplicadas deverão ser registrados em prontuário clínico individual, que ficará sob a Responsabilidade do médico-coordenador do PCMSO; e NR 7.4.5.2. Havendo substituição do médico a que se refere o item 7.4.5, os arquivos deverão ser transferidos para seu sucessor.";
    $code .= "<p align=justify>";
    $code .= "<div style=\"text-align: center;\">Sem mais para o momento;</div>";
    $code .= "<p align=justify>";
    $code .= "Aproveito o espaço em aberto para manifestação de minhas considerações e estimas.";
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
