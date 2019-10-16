<?PHP
/*****************************************************************************************************************/
// -> INCLUDES / DEFINES
/*****************************************************************************************************************/
define('_MPDF_PATH', '../../../../common/MPDF45/');
define('_IMG_PATH', '../../../../images/');
include(_MPDF_PATH.'mpdf.php');
include("../../../../common/database/conn.php");
//define('_IMG_PATH_', '../../../../images/relatorios/');
/*****************************************************************************************************************/
// -> VARS
/*****************************************************************************************************************/
$cod_cgrt = (int)(base64_decode($_GET[cod_cgrt]));
$code     = "";
$header_h = 175;//header height;
$footer_h = 170;//footer height;
$meses    = array('', 'Janeiro',  'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$m        = array(" ", "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");
/*****************************************************************************************************************/
// -> CGRT / CLIENTE INFO
/*****************************************************************************************************************/
$sql = "SELECT cgrt.*, c.*, cnae.* FROM cgrt_info cgrt, cliente c, cnae cnae 
		WHERE cgrt.cod_cgrt = $cod_cgrt AND cgrt.cod_cliente = c.cliente_id AND c.cnae_id = cnae.cnae_id";
$rci = pg_query($sql);
$info = pg_fetch_array($rci);


$cod_cliente = $info[cod_cliente];

//func list
$sql = "SELECT cfl.*,f.*, fun.* FROM cgrt_func_list cfl, funcionarios f, funcao fun 
		WHERE cfl.cod_cgrt = $cod_cgrt AND f.cod_cliente = cfl.cod_cliente AND f.cod_func = cfl.cod_func 
		AND fun.cod_funcao = cfl.cod_funcao AND cfl.status = 1 AND f.cod_status = 1 ORDER BY f.nome_func";
$rfl = pg_query($sql);
$funclist = pg_fetch_all($rfl);

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
            <b>Programa de Controle Médico e de Saúde Ocupacional</b>
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
    if($_GET[html]){
        $code .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
    }
	$ano = $info[ano];
	$ano2 = $ano+1;
    $code .= "<html>";
    $code .= "<head>";
    $code .= '<link href="../style.css" rel="stylesheet" type="text/css"/>';
    $code .= "</head>";
    $code .= "<body style=\"display: inline\">";
/****************************************************************************************************************/
// -> PAGE [1]
/****************************************************************************************************************/
    $code .= "<BR><p><BR>";
    $code .= "<center><div class='mainTitle'><b>".$info[razao_social]."</b></div></center>";
    $code .= "<BR><p>";
    $code .= "<table align=center width=100% border=0><tr><td align=center><img src='"._IMG_PATH."uno_top.jpg' border=0></td></tr></table>";
    $code .= "<BR><p>";
    $code .= "<center><div class='bigTitle'><b>PROGRAMA DE CONTROLE MÉDICO E DE SAÚDE OCUPACIONAL</b></div></center>";
    $code .= "<BR><p><BR>";
    $code .= "<center><div class='mainTitle'>$ano / $ano2</div></center>";
    $code .= "";
    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [2]
/****************************************************************************************************************/
    $code .= "<div class='mainTitle'><b>EMPRESA</b></div>";
    $code .= "<BR><p align=justify>";
    $code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";
    $code .= "<td>Razão social:</td><td>$info[razao_social]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Endereço: </td><td>$info[endereco], $info[num_end]</td>";
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
    $code .= "<td>Responsável: </td><td>$info[nome_contato_dir]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Contador: </td><td>$info[nome_contador]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Telefone: </td><td>$info[tel_contador]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Efetivo geral: </td><td>".str_pad(pg_num_rows($rfl), 2, "0", 0)."</td>";
    $code .= "</tr><tr>";
    $efemas = 0;//efetivo masculino
    $efefem = 0;//efetivo feminino
    $efe18 = 0;//efetivo com menos de 18 anos
    $efe45 = 0;//efetivo com mais de 45 anos
    for($x=0;$x<pg_num_rows($rfl);$x++){
        if(strtolower($funclist[$x][sexo_func]) == 'masculino')
            $efemas++;
        else
            $efefem++;
        if((date("Y")-date("Y",strtotime($funclist[$x][data_nasc_func])))<18)
            $efe18++;
        if((date("Y")-date("Y",strtotime($funclist[$x][data_nasc_func])))>45)
            $efe45++;
    }
    $code .= "<td>Efetivo masculino: </td><td>".str_pad($efemas, 2, "0", 0)."</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Efetivo feminino: </td><td>".str_pad($efefem, 2, "0", 0)."</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Efetivo menor de 18 anos: </td><td>".str_pad($efe18, 2, "0", 0)."</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Efetivo maior de 45 anos: </td><td>".str_pad($efe45, 2, "0", 0)."</td>";
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
// -> PAGE [3]
/****************************************************************************************************************/
    $code .= "<div class='mainTitle'><b>APRESENTAÇÃO</b></div>";
    $code .= "<BR><p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O presente trabalho tem como objetivo Sistematizar as Ações desenvolvidas na empresa, atendendo as Exigências da nova NR-7 criada pela Secretaria de Segurança e Medicina do Trabalho, em vigor desde 30/12/1994 que vem estabelecer um controle da saúde de todos os Empregados. O caráter preventivo permeia todo o texto, o que demonstra a preocupação da Empresa com a qualidade de vida dos seus empregados.";

    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [4]
/****************************************************************************************************************/
    $code .= "<div class='mainTitle'><b>SUMÁRIO</b></div>";
    $code .= "<BR><p align=justify>";
    $code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";
    $code .= "<td width=30>1.</td><td>CONSIDERAÇÕES INICIAIS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td width=30>2.</td><td>OBJETIVOS – GERAIS E/OU ESPECÍFICOS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td width=30>3.</td><td>DEFINIÇÕES E COMPOSIÇÃO DO PCMSO</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td width=30>4.</td><td>DIRETRIZES</td>";
    $code .= "</tr>";
    $code .= "<tr>";
	
    $code .= "<td width=30>5.</td><td>METODOLOGIA</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td width=30>6.</td><td>PROCEDIMENTO – EXAMES COMPLEMENTARES</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td width=30>7.</td><td>ESTRATÉGIA</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td width=30>8.</td><td>RESPONSABILIDADE E ATRIBUIÇÕES</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td width=30>9.</td><td>DESCRIÇÃO SETORIAL DAS INSTALAÇÕES DA EMPRESA</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td width=30>10.</td><td>SISTEMATIZAÇÃO SETORIAL</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td width=30>11.</td><td>DADOS CADASTRAIS DOS FUNCIONÁRIOS E CRONOGRAMA DE EXAMES</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td width=30>12.</td><td>CONSIDERAÇÕES FINAIS</td>";
    $code .= "</tr>";
    $code .= "</table>";

    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [5]
/****************************************************************************************************************/
    $code .= "<div class='mediumTitle'><b>1. CONSIDERAÇÕES INICIAIS</b></div>";
    $code .= "<p align=justify>";

    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No momento em que o mundo passa por profundas transformações, que trazem em seu rastro novas formas de produção, que remodelam as estruturas organizacionais, o interesse com a qualidade de vida se torna indispensável.<BR>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O homem neste contexto se constitui em objeto de preocupação para as empresas, que buscam através de diversos programas atenderem suas necessidades de bem estar físico e mental.<BR>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dentre esses programas encontra-se o Programa de Controle Médico da Saúde Ocupacional – PCMSO, que vem resgatar o compromisso com a saúde do trabalho, com relação à definição de condutas de preservação da saúde trazendo em seu bojo o compromisso com a melhoria da qualidade de vida do empregado.<BR>";

    $code .= "<BR><p align=justify>";
    $code .= "<div class='mediumTitle'><b>2. OBJETIVOS</b></div>";
    $code .= "<p align=justify>";

    $code .= "<table width=100% cellspacing=2 cellpadding=2 border=1>";
    $code .= "<tr>";
    $code .= "<td width=50% align=center class='bgtitle'>GERAIS</td><td width=50% align=center class='bgtitle'>ESPECÍFICOS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td valign=top>A - Prevenir, controlar, avaliar e conhecer as condições de saúde dos trabalhadores;<BR><p><BR>B - Atender a política, princípios e valores de qualidade da empresa.</td>";
    $code .= "<td valign=top>A - Desenvolver ações que contribuam para a melhoria da qualidade de vida do empregado;<BR><p><BR>B - Promover campanhas educativas voltadas para o investimento na saúde;<BR><p><BR>C - Atender as exigências do Ministério do Trabalho através da NR-07, publicada em 30.12.94 no D.O.U.;<BR><p><BR>D - Acatar o estabelecido, na portaria 3.214/78 do MTb e da portaria 24/94 do SST, NR7.</td>";
    $code .= "</tr>";
    $code .= "</table>";

    $code .= "<BR><p align=justify>";
    $code .= "<div class='mediumTitle'><b>3. DEFINIÇÕES E COMPOSIÇÃO DO PCMSO</b></div>";
    $code .= "<p align=justify>";

    $code .= "<b>EXAMES MÉDICOS OCUPACIONAIS (EMO)</b> – são exames médicos a que são submetidos os trabalhadores, a fim de serem avaliadas suas condições de saúde e compreendem em Exame Básico (Avaliação Clínica) e Exames Complementares, tendo em vista o exercício das atividades laborativa.";
    $code .= "<p align=justify>";
    $code .= "<b>EXAME MÉDICO ADMISSIONAL (EMA)</b> – exame a que são submetidos todos os candidatos, aprovados nas demais etapas do processo seletivo, a fim de serem avaliadas as suas condições de saúde, conhecidas também como pré-admissional devido à visão da avaliação do candidato antes da sua contratação como medida preventiva e de controle da boa saúde do quadro funcional.";
    $code .= "<p align=justify>";
    $code .= "<b>EXAMES MÉDICOS DE MUDANÇA DE FUNÇÃO (EMMF)</b> – exame a que são submetidos, os empregados candidatos à reclassificação para cargo ou posto de trabalho que exija do ocupante característica somato-psíquicas distintas das do cargo que ocupam, bem como antes de qualquer alteração de atividade, posto de trabalho ou de área, que implique na exposição do empregado a risco diferente daquele a que estava exposto anteriormente, o que caracteriza mudança de função. Entende-se ainda a promoção como mudança de função, cabe à gerência de coordenação informar ao serviço médico antes da efetivação da mudança.";
    $code .= "<p align=justify>";
    $code .= "<b>EXAME MÉDICO PERIÓDICO (EMP)</b> - exame a que são submetidos, em prazos regulares e previamente programados, todos os empregados da empresa ao completarem o ciclo de doze meses do último exame submetido, podendo ser admissional ou periódico.";
	
	$code .= "<div class='pagebreak'></div>";
	
    $code .= "<p align=justify>";
    $code .= "<b>EXAME DE RETORNO AO TRABALHO (EMRT)</b> – exame a que são submetidos todos os empregados afastados por período igual ou superior a 30 dias, por motivo de doenças, acidentes, partos e fim de férias, no primeiro dia de retorno à atividade submeter-se-á a reavaliação pelo médico do trabalho e recebera o ASO de liberação ao serviço.<p>";
    $code .= "<p align=justify>";
    $code .= "<b>EXAME MÉDICO DEMISSIONAL (EMD)</b> – exame a que são submetidos os empregados, por ocasião da cessação do contrato de trabalho. É realizado, obrigatoriamente, em todos os casos de demissão, desde que o último Exame Médico Ocupacional tenha sido realizado há mais de 90 (Noventa) dias, visa também o cumprimento da IN 84 de 17.12.2002, anexo XV do INSS/DC. – perfil profissiográfico previdenciário.";

    $code .= "<BR><p align=justify>";
    $code .= "<div class='mediumTitle'><b>4. DIRETRIZES</b></div>";
    $code .= "<p align=justify>";

    $code .= "1º A critério do médico examinador, em função da avaliação clínica, qualquer outro exame complementar poderá ser solicitado além daqueles estabelecidos, somente para esclarecimento de diagnóstico e não para acompanhamento de tratamento, sendo neste caso, integralmente custeado pela Empresa.";
    $code .= "<BR><p align=justify>";
    $code .="2º EMMF compreende avaliação clínica e exames complementares previstos para o novo cargo/posto de trabalho que não tenham sido realizados no EMP de acordo com a TABELA DE EXAMES MÉDICOS OCUPACIONAIS.";
    $code .= "<BR><p align=justify>";
    $code .="3º Quando o EMMF estiver programado para o período de 90 (noventa) dias antes daquele previsto para o EMP, deve ser feita com antecipação deste, dentro da modalidade correspondente observando o disposto acima.";
    $code .= "<BR><p align=justify>";
    $code .="4º Ao deixar o trabalho em atividade que desenvolve risco, o empregado deve ser submetido a exame(s) específico(s) para verificação de possível doença decorrente do trabalho.";
    $code .= "<BR><p align=justify>";
    $code .="5º EMP corresponde avaliação clínica e exames complementares conforme a TABELA DE EXAMES MÉDICOS OCUPACIONAIS, com periodicidade e abrangências definidas na TABELA PERIOCIDADE DE EXAMES.";
    $code .= "<BR><p align=justify>";
    $code .="6º EMRT compreende avaliação clínica, a critério do médico examinador, se necessários exames complementares, exclusivamente para fins de diagnóstico.";
    $code .= "<BR><p align=justify>";
    $code .="7º Na realização do EMRT, quando o prazo para o EMP estiver vencido ou previsto para os próximos 60 dias, este deverá ser realizado juntamente com o de EMRT obedecendo aos critérios próprios, devendo o médico examinador assinalar os dois exames, não só na Ficha Médica de Exame Ocupacional como no ASO.";
    $code .= "<BR><p align=justify>";
    $code .="8º No caso de EMD de empregados que executam atividades que envolvam riscos ocupacionais, é obrigatória a realização de exames complementares específicos, em função do agente agressor.";

    $code .= "<BR><p align=justify>";
	
	$code .= "<div class='pagebreak'></div>";
	
    $code .= "<div class='mediumTitle'><b>5. METODOLOGIA</b></div>";
    $code .= "<p align=justify>";

    $code .="1º Ao realizar o EMO, o médico examinador preencherá o Prontuário Médico Ocupacional e fará constar no ASO as seguintes conclusões:";
    $code .= "<BR><p align=justify>";
    $code .= "•	TIPO I - APTO";
    $code .= "<BR><p align=justify>";
    $code .= "•	TIPO II – INAPTO";
    $code .= "<BR><p align=justify>";
    $code .= "A. No caso de conclusão do tipo II, deverão ser detalhadas as razões que determinam inaptidão.";
    $code .= "<BR><p align=justify>";
    $code .= "B. No caso do tipo I, se houver restrições, com base no estabelecido no item anterior, o Médico de Trabalho Coordenador do PCMSO deverá avaliar o caso, definir as atividades que o empregado poderá exercer e, se for o caso, encaminhar para reaproveitamento funcional.";
    $code .= "<BR><p align=justify>";
    $code .= "2º O médico examinador, ao término do exame, deverá, também, assinar o ASO.";
    $code .= "<BR><p align=justify>";
    $code .= "3º O Atestado de Saúde Ocupacional – ASO será emitido em duas vias.";
    $code .= "<BR><p align=justify>";
    $code .= "4º A primeira via do ASO ficará arquivada na Empresa, devendo conter a assinatura do empregado, atestando o recebimento da segunda  via.";
    $code .= "<BR><p align=justify>";
    $code .= "5º A segunda via do ASO será, obrigatoriamente, entregue ao empregado.";
    $code .= "<BR><p align=justify>";
    $code .= "6º O Prontuário Médico Ocupacional deverá ser arquivado pelo prazo de 20 (vinte) anos. Após o desligamento do empregado.";
    $code .= "<BR><p align=justify>";
    $code .= "7º Somente o médico e o empregado poderão ter acesso às informações do Prontuário Médico Ocupacional; habitualmente, e excepcionalmente o fiscal, no caso de se tratar de fiscal médico, caso contrário vale a primeira recomendação.";

    $code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [6]
/****************************************************************************************************************/
    $code .= "<BR><p><BR>";
    $code .= "<BR><p><BR>";
    $code .= "<BR><p><BR>";
    $code .= "<center><div class='bigTitle'><b>PROGRAMA DE CONTROLE MÉDICO DE SAÚDE OCUPACIONAL</b></div></center>";
    $code .= "<BR><p>";
    $code .= "<BR><p>";
    $code .= "<center><div class='bigTitle'><b>PCMSO – ".$info[ano]."</b></div></center>";
    $code .= "<BR><p><BR>";
    $code .= "<BR><p>";
    $code .= "<center><div class='bigTitle'><b>EXAMES MÉDICOS OCUPACIONAIS E PROCEDIMENTOS</b></div></center>";
    $code .= "";
    $code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [7]
/****************************************************************************************************************/
    $code .= "<div class='mediumTitle'><b>6. PROCEDIMENTO – EXAMES COMPLEMENTARES</b></div>";
    $code .= "<p align=justify>";

    $code .= "O médico examinador de acordo com a avaliação clínica solicitará no ASO os exames complementares a serem realizados, nos casos cabíveis para diagnósticos, pelas rotinas previamente estabelecidas de acordo com os Quadros I e II da NR-7.";
    $code .= "<BR><p align=justify>";
    $code .= "- O ASO só será emitido após aprovação da empresa para realização dos exames solicitados e o retorno do candidato/ empregado para a avaliação dos resultados e parecer final do médico examinador.";
    $code .= "<BR><p align=justify>";
    $code .= "- Os resultados dos exames serão avaliados e anotados no Prontuário Médico Ocupacional do empregado, pelo médico examinador, após isto será entregue ao candidato/ empregado.";
    $code .= "<BR><p align=justify>";
    $code .= "OBSERVAÇÕES:<BR>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. A responsabilidade do encaminhamento dos candidatos a empregos e/ ou empregados para a realização dos exames complementares solicitados é exclusivamente da Empresa.";
    $code .= "<BR><p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. A NR-7 torna obrigatória a realização dos Exames Médicos Ocupacionais, que compreendem avaliação clínica e exames complementares solicitados, inviabiliza a monitorizarão dos indicadores biológicos.";

    $code .= "<BR><p align=justify>";
    $code .= "<div class='mediumTitle'><b>7. ESTRATÉGIA</b></div>";
    $code .= "<p align=justify>";

    $code .= "Sendo verificada, através do Exame Médico Ocupacional, exposição excessiva aos agentes de riscos, mesmo sem qualquer sintomatologia ou sinal clínico, o trabalhador deverá ser afastado do local de trabalho, ou do risco, até que seja normalizada a situação e as medidas de controle nos ambientes de trabalho tenham sido adotadas.";
    $code .= "<BR><p align=justify>";
    $code .= "Sendo constatada a ocorrência ou agravamento de doença profissional, ou verificadas alterações que revelem qualquer tipo de disfunção de órgão ou sistema biológico, mesmo sem sintomatologia, adotar as seguintes condutas:";
    $code .= "<BR><p align=justify>";
    $code .= "1º Afastar, imediatamente o empregado da exposição ao agente causador de risco;";
    $code .= "<BR><p align=justify>";
    $code .= "2º Emitir Comunicação de Acidente do Trabalho – CAT, em 6 (seis) vias, de acordo com  a  ordem de serviço 329 – INSS – DSS 26/10/93 – LTPS /94;";
    $code .= "<BR><p align=justify>";
    $code .= "3º Encaminhar o empregado a Previdência Social, para estabelecimento de anexo causal de definição de conduta;";
    $code .= "<BR><p align=justify>";
    $code .= "4º Adotar medidas de correção e controle no ambiente de trabalho.";

    $code .= "<BR><p align=justify>";
    $code .= "<div class='mediumTitle'><b>8. RESPONSABILIDADE E ATRIBUIÇÕES</b></div>";
    $code .= "<p align=justify>";

    $code .= "<div class='mediumTitle'><b>EMPREGADOR</b></div>";
    $code .= "<p align=justify>";
    $code .= "&bull; Garantir a elaboração e efetiva implementação, bem como zelar pela sua eficácia;<br>";
    $code .= "&bull; Custear todos os procedimentos relativos a implantação do  PCMSO;<br>";
    $code .= "&bull; Indicar o médico coordenador como responsável pela execução do PCMSO.";
    $code .= "<BR><p align=justify>";
	
	$code .= "<div class='pagebreak'></div>";
		
    $code .= "<div class='mediumTitle'><b>SUPERVISORES</b></div>";
    $code .= "<p align=justify>";
    $code .= "&bull; Fornecer as informações necessárias à elaboração e execução do PCMSO;<br>";
    $code .= "&bull; Garantir a liberação, durante a execução do serviço, dos funcionários para os Procedimentos previstos no PCMSO junto ao médico do trabalho examinador;<br>";
    $code .= "&bull; Exigir dos funcionários a execução e o cumprimento dos pedidos dos médicos do trabalho, referente ao PCMSO.<br>";
    $code .= "&bull; Advertir os funcionários que não cumprirem as normas de convocação para exames periódicos.";
    $code .= "<BR><p align=justify>";

    $code .= "<div class='mediumTitle'><b>EMPREGADOS</b></div>";
    $code .= "<p align=justify>";
    $code .= "&bull; Submeter-se aos exames clínicos e complementares, quando convocado;<br>";
    $code .= "&bull; Seguir as orientações expedidas pelo médico coordenador;<br>";
    $code .= "&bull; Levantar e dar ciência ao serviço médico e a segurança do trabalho de situações que possam provocar doenças profissionais.";
    $code .= "<BR><p align=justify>";

    $code .= "<div class='mediumTitle'><b>MÉDICO COORDENADOR</b></div>";
    $code .= "<p align=justify>";
    $code .= "&bull; Realizar os exames necessários previstos na NR-7;<br>";
    $code .= "&bull; Indicar entidades capacitadas, equipadas e qualificadas a realizarem os exames complementares;<br>";
    $code .= "&bull; Manter o arquivo de prontuários clínicos e análise ocupacional;<br>";
    $code .= "&bull; Solicitar à empresa, quando necessário à emissão da CAT Comunicação de Acidentes do Trabalho.";
    $code .= "<BR><p align=justify>";

    $code .= "<div class='mediumTitle'><b>DEPARTAMENTO DE RECURSOS HUMANOS / DEPARTAMENTO PESSOAL</b></div>";
    $code .= "<p align=justify>";
    $code .= "&bull; Dar ciência ao serviço médico dos procedimentos organizacionais necessários à execução do PCMSO;<br>";
    $code .= "&bull; Aplicar as seções disciplinares cabíveis quando não forem cumpridos os procedimentos previstos neste PCMSO e nas Normas de Procedimentos de Saúde Ocupacional pelos funcionários.";
    $code .= "<BR><p align=justify>";

    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [8] -> LISTAGEM DE SETORES
/****************************************************************************************************************/

/***********************************************/

$sql = "SELECT id_pt FROM cliente_setor WHERE id_ppra = ".(int)($cod_cgrt)." AND is_posto_trabalho = 1 AND id_pt > 0 GROUP BY id_pt";
    $ridpt = pg_query($sql);
	while($posto_trabalho = pg_fetch_array($ridpt)){
        $sql = "SELECT * FROM posto_trabalho WHERE id = ".(int)($posto_trabalho[id_pt]);
        $ptinfo = pg_fetch_array(pg_query($sql));
		
	$code .= "<br><p>";
	$code .= "<div class='mainTitle' align=center><center><b>POSTO DE SERVIÇO</b></center></div>";
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
	$code .= "<div class='pagebreak'></div>";
	
    }



/*********************************************/


    $sql = "SELECT * FROM cliente_setor WHERE id_ppra = $cod_cgrt";
    $pos = pg_query($sql);
    $posto = pg_fetch_array($pos);

	//if($posto[is_posto_trabalho] == '0'){
	$sql = "SELECT s.* FROM cliente_setor cs, setor s WHERE cs.cod_setor = s.cod_setor AND cs.id_ppra = $cod_cgrt";
    $rsi = pg_query($sql);
    $setores = pg_fetch_all($rsi);
	
    $code .= "<div class='mediumTitle'><b>9. DESCRIÇÃO SETORIAL DAS INSTALAÇÕES DA EMPRESA</b></div>";
    $code .= "<p align=justify>";

    $code .= "A empresa situa-se em endereço já citado, assim dividido:";
    $code .= "<BR><p align=justify>";

    $code .= "<table width=100% cellspacig=2 cellpadding=2 border=1>";
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' width=50%><b>SETOR</b></td><td align=center class='bgtitle' width=50%><b>DESCRIÇÃO</b></td>";
    $code .= "</tr>";

    for($x=0;$x<pg_num_rows($rsi);$x++){
        $code .= "<tr>";
        $code .= "<td>{$setores[$x][nome_setor]}</td><td>{$setores[$x][desc_setor]}</td>";
        $code .= "</tr>";
    }

    $code .= "</table>";

    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [9]
/****************************************************************************************************************/
    $code .= "<div class='mediumTitle'><b>10. SISTEMATIZAÇÃO SETORIAL</b></div>";
    $code .= "<p align=justify>";

    $code .= "A fim de dinamizarmos o estudo sistemático NR7 (PCMSO) dividiremos a empresa por setores:";
    $code .= "<BR><p align=justify>";

    for($x=0;$x<pg_num_rows($rsi);$x++){
        //efetivo no setor
        $sql = "SELECT count(*) as n FROM cgrt_func_list WHERE cod_cgrt = $cod_cgrt AND status = 1 AND cod_setor = ".(int)($setores[$x][cod_setor]);
        $set_efetivo = pg_fetch_array(pg_query($sql));
        $set_efetivo = $set_efetivo[n];
        //Riscos do setor
        $sql = "SELECT tr.nome_tipo_risco, ar.nome_agente_risco, rs.* FROM risco_setor rs, agente_risco ar, tipo_risco tr WHERE rs.id_ppra = $cod_cgrt AND rs.cod_setor = ".(int)($setores[$x][cod_setor])." AND ar.cod_agente_risco = rs.cod_agente_risco AND tr.cod_tipo_risco = ar.cod_tipo_risco";
        $rar = pg_query($sql);
        $risetor = pg_fetch_all($rar);
        $riscaralho = "";
        $poss_doen_ocupacionais = "";//possibilidade de doenças ocupacionais
        $med_preventivas = "";//acoes_necessarias -> medidas preventivas
        $poss_acidentes = "";// possibilidade de acidentes
        $med_corretivas = "";//medidas corretivas
        for($y=0;$y<pg_num_rows($rar);$y++){
            if(!empty($risetor[$y][nome_tipo_risco]))
                $riscaralho .= "<b>{$risetor[$y][nome_tipo_risco]}-></b>{$risetor[$y][nome_agente_risco]};";
            if(!empty($risetor[$y][diagnostico]))
                $poss_doen_ocupacionais .= "{$risetor[$y][diagnostico]};";
            if(!empty($risetor[$y][acao_necessaria]))
                $med_preventivas .= "{$risetor[$y][acao_necessaria]};";
            if(!empty($risetor[$y][acidente]))
                $poss_acidentes .= "{$risetor[$y][acidente]};";
            if(!empty($risetor[$y][corretiva]))
                $med_corretivas .= "{$risetor[$y][corretiva]};";
        }

        $code .= "<table width=100% cellspacig=2 cellpadding=2 border=1>";
        $code .= "<tr>";
        $code .= "<td class='bgtitle'><b>Setor:</b> {$setores[$x][nome_setor]}</td>";
        $code .= "<td width=150><b>Efetivo:</b> ".str_pad($set_efetivo, 2, "0",0)."</td>";
        $code .= "</tr>";
        $code .= "<tr>";
        $code .= "<td colspan=2><b>Dinâmica:</b> {$setores[$x][desc_setor]}</td>";
        $code .= "</tr>";
        $code .= "<tr>";
        $code .= "<td colspan=2><b>Riscos:</b> $riscaralho</td>";
        $code .= "</tr>";
        $code .= "<tr>";
        $code .= "<td colspan=2><b>Possibilidade de Doenças Ocupacionais:</b> $poss_doen_ocupacionais</td>";
        $code .= "</tr>";
        $code .= "<tr>";
        $code .= "<td colspan=2><b>Medidas Preventivas:</b> $med_preventivas</td>";
        $code .= "</tr>";
        $code .= "<tr>";
        $code .= "<td colspan=2><b>Possibilidades de Acidentes:</b> $poss_acidentes</td>";
        $code .= "</tr>";
        $code .= "<tr>";
        $code .= "<td colspan=2><b>Medidas Corretivas:</b> $med_corretivas</td>";
        $code .= "</tr>";
        $code .= "</table>";
        $code .= "<BR><p align=justify>";
    }
	
  
	//}
	
    
$code .= "<div class='pagebreak'></div>";	
	
/****************************************************************************************************************/
// -> PAGE [11]
/****************************************************************************************************************/
    $code .= "<div class='mediumTitle'><b>11. DADOS CADASTRAIS DOS FUNCIONÁRIOS E CRONOGRAMA DE EXAMES</b></div>";
    $code .= "<p align=justify>";

    $code .= "Independente da faixa etária, a coordenação do PCMSO determina exames anuais personalizados, conforme tabela abaixo. O encaminhamento do funcionário para o periódico é de fundamental importância para futura elaboração do PPP, tendo como data base o período de 12 meses entre a realização dos exames.";
    $code .= "<BR><p align=justify>";

    $code .= "<table width=100% cellspacig=2 cellpadding=2 border=1>";
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle'><b>NOME</b></td>";
    $code .= "<td align=center class='bgtitle'><b>FUNÇÃO</b></td>";
    $code .= "<td align=center class='bgtitle' width=100><b>ADMISSÃO</b></td>";
    $code .= "<td align=center class='bgtitle' width=100><b>ÚLTIMO EXAME</b></td>";
    $code .= "</tr>";
    for($x=0;$x<pg_num_rows($rfl);$x++){
        $sql = "SELECT * FROM aso WHERE cod_cliente = $info[cod_cliente] AND cod_func = {$funclist[$x][cod_func]} ORDER BY aso_data DESC";
        $raso = pg_query($sql);
        // if(pg_num_rows($raso)){
        //    $laso = pg_fetch_array($raso);
        //    $laso = date("d/m/Y", strtotime($laso[aso_data]));
      //  }else{
            $laso = $funclist[$x][data_ultimo_exame];
       // }
        $code .= "<tr>";
        $code .= "<td>{$funclist[$x][nome_func]}</td>";
        $code .= "<td>{$funclist[$x][nome_funcao]}</td>";
        $code .= "<td>"; if($funclist[$x][data_admissao_func] == '1969-12-31'){ $code .= " "; } else{ $code .= $funclist[$x][data_admissao_func];} $code .= "</td>";
        $code .= "<td>$laso</td>";
        $code .= "</tr>";
    }
    $code .= "</table>";

    $code .= "OBS: Recomenda-se que a lista nominal, documento de identificação e data do último exame dos colaboradores por setor, conste nos mesmos de acordo com suas funções e dinâmica da função.";

    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [11]
/****************************************************************************************************************/
    $code .= "<div class='mediumTitle'><b>12. CONSIDERAÇÕES FINAIS</b></div>";
    $code .= "<p align=justify>";

    $code .= "1º No caso de epidemias ou endemias de doenças de controle previsíveis por vacinação, o médico examinador, por ocasião dos Exames Médicos Ocupacionais, poderá solicitar a imunização e/ ou o atestado de vacinação.";
    $code .= "<BR><p align=justify>";
    $code .= "2º Os casos de doenças de notificação compulsória, verificados durante os Exames Médicos Ocupacionais, serão comunicados às autoridades sanitárias correspondentes e ao candidato/ empregado ou aos seus familiares.";
    $code .= "<BR><p align=justify>";
    $code .= "3º O não comparecimento ao Exame Médico Ocupacional acarretará as seguintes medidas:<br>";
    $code .= "&bull; EMA -  eliminação do processo admissional;<br>";
    $code .= "&bull; EMMF – retardamento da mudança até a realização do exame;<br>";
    $code .= "&bull; EMRT – o empregado só poderá reassumir suas atividades após se submeter a esta modalidade de exame;<br>";
    $code .= "&bull; EMD – o desligamento de empregado ficará condicionado à realização do exame dentro do prazo de 15 dias que antecedem o desligamento definitivo do empregado;<br>";
    $code .= "&bull; EMP –  sanções administrativas disciplinares, a critério do empregador.";
    $code .= "<BR><p align=justify>";

    $code .= "Rio de Janeiro, ".date("d", strtotime($info[data_criacao]))." de ".$meses[date("n", strtotime($info[data_criacao]))]." de ".date("Y", strtotime($info[data_criacao]));
    $code .= "<BR><p align=justify>";
	if($_GET[sem_assinatura])
        $code .= "";
    else
        if(!$_GET[html])
            $code .= "<div style=\"text-align: left;\"><img src='"._IMG_PATH."assin_medica0.png' border=0 width=210 height=100></div>";
    $code .= "________________________________________________________";
    $code .= "<BR>";
    $code .= "<b>Drª. Maria de Lourdes F. de Magalhães</b>";
    $code .= "<BR>";
    $code .= "Médica do Trabalho – Coordenadora do PCMSO";
    $code .= "<BR>";
    $code .= "CRM 52.33471-0 Reg. MTE 13.330";

    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [12]
/****************************************************************************************************************/
    $code .= "<BR><p><BR>";
    $code .= "<BR><p><BR>";
    $code .= "<BR><p><BR>";
    $code .= "<center><div class='bigTitle'><b>PROGRAMA DE CONTROLE MÉDICO DE SAÚDE OCUPACIONAL</b></div></center>";
    $code .= "<BR><p>";
    $code .= "<BR><p>";
    $code .= "<center><div class='bigTitle'><b>PCMSO – ".$info[ano]."</b></div></center>";
    $code .= "<BR><p><BR>";
    $code .= "<BR><p>";
    $code .= "<center><div class='bigTitle'><b>EXAMES MÉDICOS OCUPACIONAIS E PROCEDIMENTOS</b></div></center>";
    $code .= "";
    $code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [13] -> EMA
/****************************************************************************************************************/
    $code .= "<table width=100% cellspacig=2 cellpadding=2 border=1>";
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' colspan=5><b>EXAME MÉDICO ADMISSIONAL (EMA)</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=center width=25%><b>Candidatos a</b></td>";
    $code .= "<td align=center width=20%><b>Descrição da atividade</b></td>";
    $code .= "<td align=center width=20%><b>Agente de risco</b></td>";
    $code .= "<td align=center width=20%><b>Rotina<BR>&nbsp;AC&nbsp;&nbsp;|&nbsp;&nbsp;EC&nbsp;</b></td>";
    $code .= "<td align=center width=15%><b>Observação</b></td>";
    $code .= "</tr>";

    //obtem lista e dados das funções	
	$sql = "SELECT fec.*, cfl.*, fun.* FROM fun_exa_cli fec, funcao fun, cgrt_func_list cfl 
			WHERE cfl.cod_cgrt = $cod_cgrt 
			AND cfl.cod_funcao = fun.cod_funcao 
			AND cfl.cod_funcao = fec.cod_fun 
			AND EXTRACT(YEAR FROM cfl.data_admissao) = '$info[ano]' 
			AND cfl.status = 1 
			ORDER BY fun.nome_funcao";
	
    $rlf = pg_query($sql);
    $lfuncoes = pg_fetch_all($rlf);
    for($i=0;$i<pg_num_rows($rlf);$i++){
	$cli = $lfuncoes[$i][cod_cliente];
        //tipo_setor
		if($lfuncoes[$i][nome_funcao] != $lfuncoes[$i-1][nome_funcao]){
        $sql = "SELECT cs.cod_setor, cs.tipo_setor FROM cliente_setor cs, cgrt_func_list f 
				WHERE cs.id_ppra = $cod_cgrt AND f.cod_funcao = {$lfuncoes[$i][cod_funcao]} AND f.cod_setor = cs.cod_setor
				AND f.status = 1 GROUP BY cs.tipo_setor, cs.cod_setor ";
        $tiposetor = pg_fetch_array(pg_query($sql));

        $sql = "SELECT distinct(tr.nome_tipo_risco) FROM risco_setor rs, agente_risco ag, tipo_risco tr, cgrt_func_list f, funcao fu
        WHERE f.cod_funcao = fu.cod_funcao AND f.cod_cliente = rs.cod_cliente AND f.cod_setor = rs.cod_setor
        AND rs.cod_agente_risco = ag.cod_agente_risco AND ag.cod_tipo_risco = tr.cod_tipo_risco AND rs.id_ppra = $cod_cgrt
        AND fu.cod_funcao = {$lfuncoes[$i][cod_funcao]} AND EXTRACT(YEAR FROM f.data_admissao) = '$info[ano]' AND f.status = 1";
        $rsr = pg_query($sql);
        $setris = pg_fetch_all($rsr);
        $tmptxt = '';
        for($p=0;$p<pg_num_rows($rsr);$p++){
            $tmptxt .= $setris[$p][nome_tipo_risco]."<BR>";
        }
        $code .= "<tr>";
        $code .= "<td align=left>{$lfuncoes[$i][nome_funcao]}</td>";
        $code .= "<td align=center>$tiposetor[tipo_setor]</td>"; //??????????????????????????????????????????
        $code .= "<td align=left  >$tmptxt</td>";
        $code .= "<td align=center>&nbsp;SIM&nbsp;&nbsp;|&nbsp;&nbsp;SIM&nbsp;</td>";
        $code .= "<td align=center></td>";
        $code .= "</tr>";
    }}
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' colspan=5><b>PROCEDIMENTOS</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=center><b>Tipo de Exame</b></td>";
    $code .= "<td align=center colspan=4><b>Descrição</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left>AC = Avaliação Clínica</td>";
    $code .= "<td align=left colspan=4>Análise ocupacional, exame físico e mental.</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left>EC = Exames Complementares</td>";
    $code .= "<td align=left colspan=4>";
    for($i=0;$i<pg_num_rows($rlf);$i++){
	if($lfuncoes[$i][cod_funcao] != $lfuncoes[$i-1][cod_funcao]){
	$fuu = $lfuncoes[$i][cod_funcao];
        $code .= "<b>{$lfuncoes[$i][nome_funcao]}: </b>";
		$sql = "SELECT fec.*, exa.* FROM fun_exa_cli fec, exame exa 
		WHERE fec.cod_fun = $fuu 
		AND fec.cod_exa = exa.cod_exame 
		AND fec.cod_cli = $cli ";
        $recps = pg_query($sql);
        $ecpf = pg_fetch_all($recps);
        for($w=0;$w<pg_num_rows($recps);$w++){
            $code .= $ecpf[$w][especialidade]."; ";
        }
        $code .= "<BR>";
    }}
    $code .= "</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left class='bgtitle' colspan=5><b>PERIODICIDADE:</b> Os procedimentos deverão ser adotados até 5 (cinco) dias antes da admissão.</td>";
    $code .= "</tr>";
    $code .= "</table>";

    $code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [14] -> EMP
/****************************************************************************************************************/
    $code .= "<table width=100% cellspacig=2 cellpadding=2 border=1>";
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' colspan=5><b>EXAME MÉDICO PERIÓDICO (EMP)</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=center width=25%><b>Candidatos a</b></td>";
    $code .= "<td align=center width=20%><b>Descrição da atividade</b></td>";
    $code .= "<td align=center width=20%><b>Agente de risco</b></td>";
    $code .= "<td align=center width=20%><b>Rotina<BR>&nbsp;AC&nbsp;&nbsp;|&nbsp;&nbsp;EC&nbsp;</b></td>";
    $code .= "<td align=center width=15%><b>Observação</b></td>";
    $code .= "</tr>";
    $code .= "</tr>";
	$sql = "SELECT fec.*, cfl.*, fun.* FROM fun_exa_cli fec, funcao fun, cgrt_func_list cfl 
			WHERE cfl.cod_cgrt = $cod_cgrt 
			AND cfl.cod_funcao = fun.cod_funcao 
			AND cfl.cod_funcao = fec.cod_fun 
			AND EXTRACT(YEAR FROM cfl.data_admissao) < '$info[ano]' 
			AND cfl.status = 1
			ORDER BY cod_fun";
    $rlf = pg_query($sql);
    $lfuncoes = pg_fetch_all($rlf);
    for($i=0;$i<pg_num_rows($rlf);$i++){
	$cli = $lfuncoes[$i][cod_cliente];
	if($lfuncoes[$i][cod_funcao] != $lfuncoes[$i-1][cod_funcao]){
        //tipo_setor
        $sql = "SELECT cs.cod_setor, cs.tipo_setor FROM cliente_setor cs, cgrt_func_list f 
				WHERE cs.id_ppra = $cod_cgrt AND f.cod_funcao = {$lfuncoes[$i][cod_funcao]} AND f.cod_setor = cs.cod_setor 
				AND f.status = 1 GROUP BY cs.tipo_setor, cs.cod_setor ";
        $tiposetor = pg_fetch_array(pg_query($sql));

        $sql = "SELECT distinct(tr.nome_tipo_risco) FROM risco_setor rs, agente_risco ag, tipo_risco tr, cgrt_func_list f, funcao fu
        WHERE f.cod_funcao = fu.cod_funcao AND f.cod_cliente = rs.cod_cliente AND f.cod_setor = rs.cod_setor
        AND rs.cod_agente_risco = ag.cod_agente_risco AND ag.cod_tipo_risco = tr.cod_tipo_risco AND rs.id_ppra = $cod_cgrt
        AND fu.cod_funcao = {$lfuncoes[$i][cod_funcao]} AND EXTRACT(YEAR FROM f.data_admissao) < '$info[ano]' AND f.status = 1";
        $rsr = pg_query($sql);
        $setris = pg_fetch_all($rsr);
        $tmptxt = '';
		
        for($p=0;$p<pg_num_rows($rsr);$p++){
            $tmptxt .= $setris[$p][nome_tipo_risco]."<BR>";
        }
        $code .= "<tr>";
        $code .= "<td align=left>"./*($i+1)*/str_pad($lfuncoes[$i][n], 2, "0",0)." - {$lfuncoes[$i][nome_funcao]}</td>";
        $code .= "<td align=center>$tiposetor[tipo_setor]</td>"; //??????????????????????????????????????????
        $code .= "<td align=left  >$tmptxt</td>";
        $code .= "<td align=center>&nbsp;SIM&nbsp;&nbsp;|&nbsp;&nbsp;SIM&nbsp;</td>";
        $code .= "<td align=center></td>";
        $code .= "</tr>";
    }}
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' colspan=5><b>PROCEDIMENTOS</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=center><b>Tipo de Exame</b></td>";
    $code .= "<td align=center colspan=4><b>Descrição</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left>AC = Avaliação Clínica</td>";
    $code .= "<td align=left colspan=4>Análise ocupacional, exame físico e mental.</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left>EC = Exames Complementares</td>";
    $code .= "<td align=left colspan=4>";
    for($i=0;$i<pg_num_rows($rlf);$i++){
	if($lfuncoes[$i][cod_funcao] != $lfuncoes[$i-1][cod_funcao]){
	$fuu = $lfuncoes[$i][cod_funcao];
        $code .= "<b>{$lfuncoes[$i][nome_funcao]}: </b>";
		$sql = "SELECT fec.*, exa.* FROM fun_exa_cli fec, exame exa 
		WHERE fec.cod_fun = $fuu 
		AND fec.cod_exa = exa.cod_exame 
		AND fec.cod_cli = $cli ";
        $recps = pg_query($sql);
        $ecpf = pg_fetch_all($recps);
        for($w=0;$w<pg_num_rows($recps);$w++){
            $code .= $ecpf[$w][especialidade]."; ";
        }
        $code .= "<BR>";
    }}
    $code .= "</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left class='bgtitle' colspan=5><b>PERIODICIDADE:</b> Os procedimentos deverão ser adotados regularmente a cada 12 (Doze) meses.</td>";
    $code .= "</tr>";
    $code .= "</table>";


/****************************************************************************************************************/
// -> PAGE [15] -> EMD
/****************************************************************************************************************/
    $code .= "<table width=100% cellspacig=2 cellpadding=2 border=1>";
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' colspan=5><b>EXAME MÉDICO DEMISSIONAL (EMD)</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=center width=25%><b>Candidatos a</b></td>";
    $code .= "<td align=center width=20%><b>Descrição da atividade</b></td>";
    $code .= "<td align=center width=20%><b>Agente de risco</b></td>";
    $code .= "<td align=center width=20%><b>Rotina<BR>&nbsp;AC&nbsp;&nbsp;|&nbsp;&nbsp;EC&nbsp;</b></td>";
    $code .= "<td align=center width=15%><b>Observação</b></td>";
    $code .= "</tr>";

    $code .= "<tr>";
    $code .= "<td align=left>&nbsp;</td>";
    $code .= "<td align=center>&nbsp;</td>"; //??????????????????????????????????????????
    $code .= "<td align=left  >&nbsp;</td>";
    $code .= "<td align=center>&nbsp;</td>";
    $code .= "<td align=center>&nbsp;</td>";
    $code .= "</tr>";

    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' colspan=5><b>PROCEDIMENTOS</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=center><b>Tipo de Exame</b></td>";
    $code .= "<td align=center colspan=4><b>Descrição</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left>AC = Avaliação Clínica</td>";
    $code .= "<td align=left colspan=4>Análise ocupacional, exame físico e mental.</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left>EC = Exames Complementares</td>";
    $code .= "<td align=left colspan=4></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left class='bgtitle' colspan=5><b>PERIODICIDADE:</b> Os procedimentos deverão ser adotados até 10 (dez) dias após a demissão.</td>";
    $code .= "</tr>";
    $code .= "</table>";

    $code .= "<BR><P><BR>";

    $code .= "<table width=100% cellspacig=2 cellpadding=2 border=1>";
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' colspan=5><b>EXAME MÉDICO RETORNO DE TRABALHO (EMRT)</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=5><p align=justify>Deverão ser realizadas avaliações clínicas e exames complementares, se necessário, para esclarecimento de diagnóstico, no primeiro dia da volta ao trabalho, de todos trabalhadores ausentes no período igual ou superior a 30 (trinta) dias por motivo de doença ou acidente de natureza ocupacional ou não e parto.</td>";
    $code .= "</tr>";
    $code .= "</table>";

    $code .= "<BR><P><BR>";

    $code .= "<table width=100% cellspacig=2 cellpadding=2 border=1>";
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' colspan=5><b>EXAME MÉDICO DE MUDANÇA DE FUNÇÃO (EMMF)</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=5><p align=justify>Deverá ser realizado em até 5 (cinco) dias da mudança, desde que as alterações na atividade no posto de trabalho ou setor impliquem na exposição do trabalhador a riscos diferentes daqueles a que estava exposto.</td>";
    $code .= "</tr>";
    $code .= "</table>";

    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [16]
/****************************************************************************************************************/
    $code .= "<center><div class='bigTitle'><b>PROGRAMA DE CONTROLE MÉDICO DE SAÚDE OCUPACIONAL</b></div></center>";
    $code .= "<center><div style=\"text-align: center;\"><b>PCMSO</b></div></center>";
    $code .= "<hr>";
    $code .= "<div style=\"text-align: center;\">";
    $code .= "<i><b>Realização:</b> </i><BR>";
    $code .= "Rio de Janeiro, ".date("d", strtotime($info[data_avaliacao]))." de ".$meses[date("n", strtotime($info[data_avaliacao]))]." de ".date("Y", strtotime($info[data_avaliacao]))."";
    $code .= "<p>";
    $code .= "<i><b>Período:</b> </i><BR>";
    $code .= "".$meses[date("n", strtotime($info[data_avaliacao]))]."/".date("Y", strtotime($info[data_avaliacao]))." à ".$meses[date("n", strtotime($info[data_avaliacao]))]."/".((int)(date("Y", strtotime($info[data_avaliacao])))+1)."";
    $code .= "<p>";
    $code .= "<i><b>Elaboração:</b> </i><BR>";
    $code .= "SESMT – SERVIÇOS ESPECIALIZADOS DE SEGURANÇA E MONITORAMENTO DE ATIVIDADE NO TRABALHO LTDA<br>";
    $code .= "RUA MARECHAL ANTÔNIO DE SOUZA, 92 – JARDIM AMÉRICA<br>";
    $code .= "CNPJ 04.722.248/0001-17<BR>";

    if($_GET[sem_assinatura])
        $code .= "<BR>";
    else
        if(!$_GET[html])
            $code .= "<img src='"._IMG_PATH."assin_medica0.png' border=0><BR>";

        
    $code .= "Drª. Maria de Lourdes F. de Magalhães<BR>";
    $code .= "Médica do Trabalho<BR>";
    $code .= "Coordenadora do PCMSO<BR>";
    $code .= "CRM /RJ – 52.33.471-0 - MTE 13320<p>";
    $code .= "<i><b>Fundamentação Legal:</b> </i><BR>";
    $code .= "Constituição federal, capítulo II (Dos Direitos Sociais), artigo 6º e 7º, incisos XXII, XXIII, XXVIII E XXXIII;<BR>";
    $code .= "Consolidação das leis do trabalho – CLT, Capítulo V, artigos 168 e 1669; Lei 6.514, de 22 de dezembro de 1977;<BR>";
    $code .= "Portaria do MTE nº 24, de 29/12/94, aprova o novo texto da NR-7.";
    $code .= "</div>";
    $code .= "<hr>";
    $code .= "<center><div class='mainTitle'><b>$info[razao_social]</b></div></center>";
    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [17]
/****************************************************************************************************************/
    //$code .= "<BR><p><BR>";
    $code .= "<center><div class='bigTitle'><b>PROGRAMA DE CONTROLE MÉDICO DE SAÚDE OCUPACIONAL</b></div></center>";
    $code .= "<BR><p>";
    $code .= "<BR><p>";
    $code .= "<center><div class='bigTitle'><b>PCMSO – ".$info[ano]." / ".($info[ano]+1)."</b></div></center>";
    $code .= "<BR><p>";
    $code .= "<BR><p>";
    $code .= "<center><div class='bigTitle'><b>ANEXOS; CONSIDERAÇÕES GERAIS; INFORMAÇÕES COMPLEMENTARES; PLANEJAMENTO ANUAL E RELAÇÃO DE EMPREGADOS</b></div></center>";
    $code .= "<BR><p>";
    $code .= "<BR><p>";
    $code .= "<center><div class='bigTitle'><b>PCMSO – ".$info[ano]." / ".($info[ano]+1)."</b></div></center>";

    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [18]
/****************************************************************************************************************/
    $code .= "<BR><p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Para cada exame realizado deverá ser emitido um atestado de saúde ocupacional em três vias, devendo a
    primeira via ficar arquivada na empresa para controle e eventual apresentação à fiscalização, a segunda deverá
    ser entregue aos funcionários, o qual deverá protocolar, a primeira e terceira via com o médico coordenador para
    seu controle.<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Todo o funcionário deverá possuir um prontuário clínico individual que deverá ficar sob-responsabilidade do coordenador durante um período mínimo de 20 anos após o desligamento do funcionário.
    No prontuário deverá constar todo o dado obtido nos exames médicos, avaliações clínicas e exames complementares,
    bem como as conclusões e eventuais medidas aplicadas: em caso de substituição do coordenador os arquivos deverão
    ser transferidos para seu sucessor; o coordenador deverá emitir relatório anual dos objetivos alcançados, que
    deverá ser anexado ao final do ano vigente do período referido no PCMSO.<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Todos os estabelecimentos comerciais e ou institucionais, devem possuir um kit de primeiros socorros,
    composto, por exemplo, dos seguintes itens por setor ou função:<p align=justify>";
    $code .= "Água oxigenada; Álcool 70%; Algodão em bolinha; Atadura; Cotonete; Curativo adesivo (band-aid);
    Esparadrapo; Ficha de controle de retirada; Gaze esterilizada; Luva descartável; Pinça; Relação de material e
    quantidade contida no armário; Reparil gel; Repelente; Solução antisséptica; Soro fisiológico; Termômetro;
    Vaselina líquida ou Dersani.<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O PCMSO poderá sofrer alterações a qualquer momento, em algumas partes ou até mesmo no seu todo,
    quando o médico detectar mudanças nos riscos ocupacionais decorrentes de alterações nos processos de trabalho,
    novas descobertas da ciência médica em relação a efeitos de riscos existentes, mudança de critérios e
    interpretação de exames ou ainda a reavaliação do reconhecimento dos riscos por competência da legislação NR.<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O PCMSO deverá ter caráter de prevenção, rastreamento e diagnóstico precoce dos agravos à saúde
    relacionados ao trabalho, inclusive de natureza sub-clínica, além da constatação da existência de casos de
    doenças profissionais ou danos irreversíveis à saúde dos trabalhadores. Em face ao despacho de 1º de outubro de
    96 da Secretaria de Segurança e Saúde do Trabalho.<p align=justify>";
    $code .= "<BR><p>";
    /*
    $code .= "<div style=\"text-align: right;\">
    Rio de Janeiro, ".date("d", strtotime($info[data_avaliacao]))." de ".$meses[date("n", strtotime($info[data_avaliacao]))]." de ".date("Y", strtotime($info[data_avaliacao]))."
    <BR>
    <img src='http://www.sesmt-rio.com/erp/img/ass_medica.png' border=0 width='180' height='110'>
    </div>";
    */
    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [19]
/****************************************************************************************************************/
    $code .= "<div class='mainTitle'><b>INFORMAÇÕES COMPLEMENTARES</b></div>";
    $code .= "<BR><p align=justify>";
    $code .= "<div class='mediumTitle'><b>RECOMENDAÇÕES À EMPRESA</b></div>";
    $code .= "<BR><p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Este capítulo tem como objetivo principal orientar a administração desta empresa como se pode minimizar os problemas decorrentes de incidência e imperícia no âmbito da empresa, ele visa trazer uma oportunidade com um custo baixo, e não só orientar os colaboradores de sua empresa, mas, salvar e guardar a qualidade dos produtos e serviços prestados aos seus clientes sem contar o bom nome da empresa que deve ser sempre protegido de escândalos e de investidas das fiscalizações.";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recomenda-se que todos os colaboradores devam receber orientações sobre segurança do trabalho e prevenção de acidentes, objetivando cumprir com a NR 5.6.4 lei 6.514/77 que diz não haver obrigatoriedade da CIPA instituída através do voto por falta de contingente, deverá ter um colaborador treinado, funcionando como um multiplicador aos demais companheiros.";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recomenda-se que todos os colaboradores devam receber orientações sobre alcoolismo, objetivando desmotivar o uso de tal substância o que acarretaria em possíveis danos a saúde e na produtividade da empresa.";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recomenda-se que todos os colaboradores devam receber orientações sobre tabagismo, objetivando desmotivar o uso de tal substância o que acarretaria em possíveis danos a saúde do fumante, dos que os rodeiam e na produtividade da empresa, podendo ainda provocar princípios de incêndios.";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recomenda-se que todos os colaboradores devam receber orientações sobre doenças sexualmente transmissíveis (DST), doenças ostenculares relacionadas ao trabalho (DORT), objetivando a conscientização e prevenção das mesmas.";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recomenda-se que todos os colaboradores devam receber orientações sobre o uso dos equipamentos de prevenção individual (EPI), objetivando a conscientização e prevenção da saúde e integridade física dos colaboradores e isenção de ações jurídicas.";
    $code .= "<p align=justify>";

    $code .= "<BR><p>";
    /*
    $code .= "<div style=\"text-align: right;\">
    <img src='http://www.sesmt-rio.com/erp/img/ass_medica.png' border=0 width='180' height='110'>
    </div>";
    */
    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [20]
/****************************************************************************************************************/
    $code .= "<div class='mediumTitle'><b>RECOMENDAÇÕES DE RISCOS BIOLÓGICOS CONSIDERADOS LEVES PARA MONITORAMENTO DO PCMSO</b></div>";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cobrir com capas plásticas os teclados dos micros computadores ou virar as teclas para baixo no final de cada expediente, proporcionando assim que as partículas de poeiras suspensas no ambiente não nos sedimentem.";
    $code .= "<p align=justify>";
    $code .= "<b>Possíveis Sintomas:</b> Dor de cabeça, problemas alérgicos e respiratórios.";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Substituir vasos de plantas naturais por artificiais em ambientes refrigerados mecanicamente \"Ar Condicionado\".";
    $code .= "<p align=justify>";
    $code .= "<b>Possíveis Sintomas:</b> Problemas Alérgicos e dermatológicos, gerado dos excrementos de anelídeos que em contato com ar refrigerado e respirado pelo ser humano em ambiente enclausurado.";
    $code .= "<p align=justify>";

    $code .= "<div class='mediumTitle'><b>CAMPANHA DE VACINAÇÃO</b></div>";
    $code .= "<p align=justify>";

    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recomenda-se Divulgar, incentivar e promover a política de vacinação prevencionista como:";
    $code .= "<p align=justify>";
    $code .= "<b>Antigripal</b> – Recomendada para todas as idades e sendo administrada anualmente, próxima aos meses de inverno, preferencialmente no mês de Abril.";
    $code .= "<p align=justify>";
    $code .= "<b>Antitetânica</b> – Recomendada a tomar as 03 doses e depois a cada 10 anos.";
    $code .= "<p align=justify>";
    $code .= "<b>Hepatite</b> – Recomendada na fase adulta a tomar as 03 doses sendo que a 2º depois com 30 dias e a 3º dose com 180 dias.";
    $code .= "<p align=justify>";
    $code .= "<b>Vacina contra Rubéola</b> - Deverão ser vacinadas nas campanhas realizadas pela Secretaria de Estado da Saúde: com aplicação da vacina dupla viral (sarampo e rubéola) em homens e mulheres de 20 a 39 anos de idade mesmo aquelas que já tomaram a vacina anteriormente ou que referem já ter tido a doença e pessoas com idade até 19 anos a tríplice viral (sarampo, caxumba e rubéola).";
    $code .= "<p align=justify>";

    $code .= "<BR><p>";
    /*
    $code .= "<div style=\"text-align: right;\">
    <img src='http://www.sesmt-rio.com/erp/img/ass_medica.png' border=0 width='180' height='110'>
    </div>";
    */
    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [21]
/****************************************************************************************************************/
    $code .= "<div class='mediumTitle'><b>RECOMENDAÇÕES DE CONTROLES DE EPIDEMIOLOGIA</b></div>";
    $code .= "<p align=justify>";
    $code .= "<b>AEDES AEGYPT (Mosquito da Dengue):</b> A única maneira de evitar a dengue ( Aedes Aegypt) é não deixar o mosquito nascer. Combater a larva é mais fácil que combater o mosquito adulto.";
    $code .= "<p align=justify>";
    $code .= "É aí que você pode ajudar! Lembre-se:";
    $code .= "<p align=justify>";
    $code .= "&bull; Designar um grupo de trabalho em sua Unidade/Órgão com a participação da Cipa, sob a Coordenação do ATU/ATD;<br>";
    $code .= "&bull; Eliminar os criadouros internos como: vasos, pratos de xaxim, enfeites e todo tipo de situação que possa acumular água limpa;<br>";
    $code .= "&bull; Providenciar a limpeza de calhas, lajes, caixas d'água juntamente com o apoio do Estec;<br>";
    $code .= "&bull; Remover entulhos provenientes de restos de construção, sucata de descarte e lixos em geral;<br>";
    $code .= "&bull; Fiscalizar o cumprimento das medidas adotadas;<br>";
    $code .= "&bull; Divulgar aos funcionários e convencê-los que essa proibição é para o bem comum.<BR>";
    $code .= "<BR><p>";
    $code .= "<b>GRIPE H1N1 (Influenza A):</b> Considerando de que o vírus da gripe H1N1 está confirmado a multiplicação e sua ploriferação, a melhor forma de combater a doença é a prevenção.<BR>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lista com alguns hábitos que será muito útil manter, são recomendações do Centro de controle e prevenção de doenças dos Estados Unidos.";
    $code .= "<p align=justify>";
    $code .= "É aí que você pode ajudar! Lembre-se:";
    $code .= "<p align=justify>";
    $code .= "&bull; Evite contato direto com pessoas doentes;<br>";
    $code .= "&bull; Cubra seu nariz e boca se por a caso for tossir ou espirrar;<br>";
    $code .= "&bull; Evite ao máximo tocar no nariz, boca e olhos, se for mesmo necessário lave as mãos antes;<br>";
    $code .= "&bull; Se você ficar doente, procure ficar em casa e restringir o contato com outras pessoas, para evitar o contagio;<br>";
    $code .= "&bull; Lave as mãos sempre com água e sabão, álcool também é ótimo para higienizar as mãos.<br>";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fique atento, pois os sintomas da gripe H1N1 são muito parecidos com o da gripe comum, você pode ter:
    febre, letargia, falta de apetite e tosse.<BR>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Em algumas pessoas esta gripe pode provocar: coriza, garganta seca, náusea, vômito e diarreia. Se você ou algum
    familiar tiver com estes sintomas procure um médico.";

    $code .= "<BR><p>";
    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [22]
/****************************************************************************************************************/
    $code .= "<div class='mainTitle'><b>PLANEJAMENTO ANUAL DE: ".$info[ano]." à ".($info[ano]+1)."</b></div>";
    $code .= "<BR><p align=justify>";

    $code .= "<table width=100% border=1 cellspacing=2 cellpadding=2>";
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle'><b>ATIVIDADE</b></td>";
    for($x=1;$x<=12;$x++){
         $code .= "<td align=center class='bgtitle' WIDTH=40><b>$m[$x]</b></td>";
    }
    $code .= "</tr>";

    $code .= "<tr>";
    $code .= "<td>Elaboração do PCMSO</td>";
    for($x=1;$x<=12;$x++){
        if($x == date("n", strtotime($info[data_avaliacao]))) $val = "xxx"; else $val = " ";
        $code .= "<td align=center>$val</td>";
    }
    $code .= "</tr>";

    $code .= "<tr>";
    $code .= "<td>Realização dos Exames Periódicos</td>";
    for($x=1;$x<=12;$x++){
        if($x == date("n", strtotime($info[data_avaliacao]))) $val = "xxx"; else $val = " ";
        $code .= "<td align=center>$val</td>";
    }
    $code .= "</tr>";

    $code .= "<tr>";
    $code .= "<td>Avaliação Global da Eficácia do Programa</td>";
    for($x=1;$x<=12;$x++){
        if($x == date("n", mktime(0, 0, 0, date("n", strtotime($info[data_avaliacao]))+6, 1, date("Y", strtotime($info[data_avaliacao]))))) $val = "x"; else $val = " ";
        $code .= "<td align=center>$val</td>";
    }
    $code .= "</tr>";

    $code .= "<tr>";
    $code .= "<td>Elaboração do Relatório Anual</td>";
    for($x=1;$x<=12;$x++){
        if($x == date("n", mktime(0, 0, 0, date("n", strtotime($info[data_avaliacao]))+11, 1, date("Y", strtotime($info[data_avaliacao]))))) $val = "xx"; else $val = " ";
        $code .= "<td align=center>$val</td>";
    }
    $code .= "</tr>";

    $code .= "<tr>";
    $code .= "<td>Renovação do Programa</td>";
    for($x=1;$x<=12;$x++){
        if($x == date("n", mktime(0, 0, 0, date("n", strtotime($info[data_avaliacao]))+11, 1, date("Y", strtotime($info[data_avaliacao]))))) $val = "xx"; else $val = " ";
        $code .= "<td align=center>$val</td>";
    }
    $code .= "</tr>";
    $code .= "</table>";
    $code .= "<BR><p>";

    $code .= "<b>Legenda:</b><p>";

    $code .= "x - Em Execução no Ano de $info[ano] / ".($info[ano]+1)."<BR>";
    $code .= "xx - Em Execução no Ano de ".($info[ano]+1)."<BR>";
    $code .= "xxx - Executado<BR>";

    $code .= "<BR><p>";
    /*
    $code .= "<div style=\"text-align: right;\">
    <img src='http://www.sesmt-rio.com/erp/img/ass_medica.png' border=0 width='180' height='110'>
    </div>";
    */
    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [23]
/****************************************************************************************************************/
    $code .= "<div class='mainTitle'><b>RELAÇÃO DE FUNCIONÁRIOS</b></div>";
    $code .= "<p align=justify>";

    $code .= "<table width=100% border=1 cellspacing=2 cellpadding=2>";
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle'>NOME</td>";
    $code .= "<td align=center class='bgtitle'>FUNÇÃO</td>";
    $code .= "<td align=center class='bgtitle'>ADMISSÃO</td>";
    $code .= "<td align=center class='bgtitle'>CTPS</td>";
    $code .= "<td align=center class='bgtitle'>NASCIMENTO</td>";
    $code .= "<td align=center class='bgtitle'>CBO</td>";
    $code .= "</tr>";
    for($x=0;$x<pg_num_rows($rfl);$x++){
        $code .= "<tr>";
        $code .= "<td>{$funclist[$x][nome_func]}</td>";
        $code .= "<td>{$funclist[$x][nome_funcao]}</td>";
        $code .= "<td align=center>"; if($funclist[$x][data_admissao_func] == '1969-12-31'){ $code .= " "; }else{ $code .= $funclist[$x][data_admissao_func];} $code .= "</td>";
        $code .= "<td align=center>{$funclist[$x][num_ctps_func]}/{$funclist[$x][serie_ctps_func]}</td>";
        $code .= "<td align=center>"; if($funclist[$x][data_nasc_func] == '1969-12-31'){ $code .= " "; }else{ $code .= $funclist[$x][data_nasc_func];} $code .= "</td>";
        $code .= "<td align=center>{$funclist[$x][cbo]}</td>";
        $code .= "</tr>";
    }
    $code .= "</table>";

    $code .= "OBS.: Recomenda-se que a lista nominal, documento de identificação e data do último exame dos colaboradores por setor, conste nos mesmos de acordo com suas funções e dinâmica da função.";

    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [24]
/****************************************************************************************************************/
    $code .= "<div class='mainTitle'><b>RELATÓRIO ANUAL $info[ano] / ".($info[ano]+1)."</b></div>";
    $code .= "<p align=justify>";

    $code .= "<b>Coordenador(a):</b> Drª Maria de Lourdes Fernandes de Magalhães";
    $code .= "<p align=justify>";
    $code .= "<b>Data:</b> ".$meses[date("n", strtotime($info[data_criacao]))]." de ".date("Y", strtotime($info[data_criacao]))."";
    $code .= "<p align=justify>";
    if($_GET[sem_assinatura])
        $code .= "";
    else
        if(!$_GET[html])
            $code .= "<div style=\"text-align: center;\"><img src='"._IMG_PATH."assin_medica0.png' border=0 width=210 height=100></div>";


    $sql = "SELECT fun.cod_funcao, fun.nome_funcao FROM cgrt_func_list cfl, funcao fun 
			WHERE cfl.cod_cgrt = $cod_cgrt AND fun.cod_funcao = cfl.cod_funcao AND cfl.status = 1
			GROUP BY fun.cod_funcao, fun.nome_funcao ORDER BY fun.nome_funcao";
    $rlf = pg_query($sql);
    $funcoes = pg_fetch_all($rlf);

    $code .= "<table width=100% border=1 cellspacing=2 cellpadding=2>";
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle'>FUNÇÃO</td>";
    $code .= "<td align=center class='bgtitle'>NATUREZA DO EXAME</td>";
    $code .= "<td align=center class='bgtitle'>Nº ANUAL DE EXAMES REALIZADOS</td>";
    $code .= "<td align=center class='bgtitle'>RESULTADOS ANORMAIS</td>";
    $code .= "<td align=center class='bgtitle'>RESULTADOS NORMAIS (%)</td>";
    $code .= "<td align=center class='bgtitle'>Nº EXAMES PARA O ANO SEGUINTE</td>";
    $code .= "</tr>";
    for($x=0;$x<pg_num_rows($rlf);$x++){
        //Exames por função
        $sql = "SELECT fec.*, e.especialidade FROM fun_exa_cli fec, exame e WHERE fec.cod_fun = ".(int)($funcoes[$x][cod_funcao])." AND fec.cod_cli = ".$cod_cliente." AND fec.cod_exa = e.cod_exame";
        $rle = pg_query($sql);
        $exames = pg_fetch_all($rle);
        $exalist = "";
        for($i=0;$i<pg_num_rows($rle);$i++)
            $exalist .= $exames[$i][especialidade].";<BR>";

        $sql = "SELECT count(*) as n FROM cgrt_func_list WHERE cod_cgrt = $cod_cgrt AND status = 1 AND cod_funcao = ".(int)($funcoes[$x][cod_funcao]);
        $nfu = pg_fetch_array(pg_query($sql));
        $nfu = $nfu[n];

        $code .= "<tr>";
        $code .= "<td>{$funcoes[$x][nome_funcao]}</td>";
        $code .= "<td>{$exalist}</td>";
        $code .= "<td align=center>$nfu</td>";
        $code .= "<td align=center>0</td>";
        $code .= "<td align=center>100%</td>";/*round(($nfu*100)/$maxfunc)*/
        $code .= "<td align=center>$nfu</td>";
        $code .= "</tr>";
    }
    $code .= "</table>";

ob_end_clean();

/*****************************************************************************************************************/
// -> OUTPUT
/*****************************************************************************************************************/
if(!$_GET[html]){
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
    $mpdf->SetHTMLFooter($rodape.'<div align="center"><b>{PAGENO}</b></div>');
    //carregar folha de estilos
    //$stylesheet = file_get_contents('./pcmso.css');
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
}else{
    echo $code;
}
?>