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
$meses    = array('', 'Janeiro',  'Fevereiro', 'Mar�o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
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
            <font size="7" face="Verdana, Arial, Helvetica, sans-serif">SESMT<sup><font size=3>�</font></sup></font>&nbsp;&nbsp;
			<font size="1" face="Verdana, Arial, Helvetica, sans-serif">SERVI�OS ESPECIALIZADOS DE SEGURAN�A<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
			CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></strong>
            </td>';
			
			$cabecalho .= ' <td width=40% align="right" height=$header_h>
            <font face="Verdana, Arial, Helvetica, sans-serif" size="4">
            <b>Programa de Controle M�dico e de Sa�de Ocupacional</b>
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
    $code .= "<center><div class='bigTitle'><b>PROGRAMA DE CONTROLE M�DICO E DE SA�DE OCUPACIONAL</b></div></center>";
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
// -> PAGE [3]
/****************************************************************************************************************/
    $code .= "<div class='mainTitle'><b>APRESENTA��O</b></div>";
    $code .= "<BR><p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O presente trabalho tem como objetivo Sistematizar as A��es desenvolvidas na empresa, atendendo as Exig�ncias da nova NR-7 criada pela Secretaria de Seguran�a e Medicina do Trabalho, em vigor desde 30/12/1994 que vem estabelecer um controle da sa�de de todos os Empregados. O car�ter preventivo permeia todo o texto, o que demonstra a preocupa��o da Empresa com a qualidade de vida dos seus empregados.";

    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [4]
/****************************************************************************************************************/
    $code .= "<div class='mainTitle'><b>SUM�RIO</b></div>";
    $code .= "<BR><p align=justify>";
    $code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";
    $code .= "<td width=30>1.</td><td>CONSIDERA��ES INICIAIS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td width=30>2.</td><td>OBJETIVOS � GERAIS E/OU ESPEC�FICOS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td width=30>3.</td><td>DEFINI��ES E COMPOSI��O DO PCMSO</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td width=30>4.</td><td>DIRETRIZES</td>";
    $code .= "</tr>";
    $code .= "<tr>";
	
    $code .= "<td width=30>5.</td><td>METODOLOGIA</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td width=30>6.</td><td>PROCEDIMENTO � EXAMES COMPLEMENTARES</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td width=30>7.</td><td>ESTRAT�GIA</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td width=30>8.</td><td>RESPONSABILIDADE E ATRIBUI��ES</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td width=30>9.</td><td>DESCRI��O SETORIAL DAS INSTALA��ES DA EMPRESA</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td width=30>10.</td><td>SISTEMATIZA��O SETORIAL</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td width=30>11.</td><td>DADOS CADASTRAIS DOS FUNCION�RIOS E CRONOGRAMA DE EXAMES</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td width=30>12.</td><td>CONSIDERA��ES FINAIS</td>";
    $code .= "</tr>";
    $code .= "</table>";

    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [5]
/****************************************************************************************************************/
    $code .= "<div class='mediumTitle'><b>1. CONSIDERA��ES INICIAIS</b></div>";
    $code .= "<p align=justify>";

    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No momento em que o mundo passa por profundas transforma��es, que trazem em seu rastro novas formas de produ��o, que remodelam as estruturas organizacionais, o interesse com a qualidade de vida se torna indispens�vel.<BR>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O homem neste contexto se constitui em objeto de preocupa��o para as empresas, que buscam atrav�s de diversos programas atenderem suas necessidades de bem estar f�sico e mental.<BR>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dentre esses programas encontra-se o Programa de Controle M�dico da Sa�de Ocupacional � PCMSO, que vem resgatar o compromisso com a sa�de do trabalho, com rela��o � defini��o de condutas de preserva��o da sa�de trazendo em seu bojo o compromisso com a melhoria da qualidade de vida do empregado.<BR>";

    $code .= "<BR><p align=justify>";
    $code .= "<div class='mediumTitle'><b>2. OBJETIVOS</b></div>";
    $code .= "<p align=justify>";

    $code .= "<table width=100% cellspacing=2 cellpadding=2 border=1>";
    $code .= "<tr>";
    $code .= "<td width=50% align=center class='bgtitle'>GERAIS</td><td width=50% align=center class='bgtitle'>ESPEC�FICOS</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td valign=top>A - Prevenir, controlar, avaliar e conhecer as condi��es de sa�de dos trabalhadores;<BR><p><BR>B - Atender a pol�tica, princ�pios e valores de qualidade da empresa.</td>";
    $code .= "<td valign=top>A - Desenvolver a��es que contribuam para a melhoria da qualidade de vida do empregado;<BR><p><BR>B - Promover campanhas educativas voltadas para o investimento na sa�de;<BR><p><BR>C - Atender as exig�ncias do Minist�rio do Trabalho atrav�s da NR-07, publicada em 30.12.94 no D.O.U.;<BR><p><BR>D - Acatar o estabelecido, na portaria 3.214/78 do MTb e da portaria 24/94 do SST, NR7.</td>";
    $code .= "</tr>";
    $code .= "</table>";

    $code .= "<BR><p align=justify>";
    $code .= "<div class='mediumTitle'><b>3. DEFINI��ES E COMPOSI��O DO PCMSO</b></div>";
    $code .= "<p align=justify>";

    $code .= "<b>EXAMES M�DICOS OCUPACIONAIS (EMO)</b> � s�o exames m�dicos a que s�o submetidos os trabalhadores, a fim de serem avaliadas suas condi��es de sa�de e compreendem em Exame B�sico (Avalia��o Cl�nica) e Exames Complementares, tendo em vista o exerc�cio das atividades laborativa.";
    $code .= "<p align=justify>";
    $code .= "<b>EXAME M�DICO ADMISSIONAL (EMA)</b> � exame a que s�o submetidos todos os candidatos, aprovados nas demais etapas do processo seletivo, a fim de serem avaliadas as suas condi��es de sa�de, conhecidas tamb�m como pr�-admissional devido � vis�o da avalia��o do candidato antes da sua contrata��o como medida preventiva e de controle da boa sa�de do quadro funcional.";
    $code .= "<p align=justify>";
    $code .= "<b>EXAMES M�DICOS DE MUDAN�A DE FUN��O (EMMF)</b> � exame a que s�o submetidos, os empregados candidatos � reclassifica��o para cargo ou posto de trabalho que exija do ocupante caracter�stica somato-ps�quicas distintas das do cargo que ocupam, bem como antes de qualquer altera��o de atividade, posto de trabalho ou de �rea, que implique na exposi��o do empregado a risco diferente daquele a que estava exposto anteriormente, o que caracteriza mudan�a de fun��o. Entende-se ainda a promo��o como mudan�a de fun��o, cabe � ger�ncia de coordena��o informar ao servi�o m�dico antes da efetiva��o da mudan�a.";
    $code .= "<p align=justify>";
    $code .= "<b>EXAME M�DICO PERI�DICO (EMP)</b> - exame a que s�o submetidos, em prazos regulares e previamente programados, todos os empregados da empresa ao completarem o ciclo de doze meses do �ltimo exame submetido, podendo ser admissional ou peri�dico.";
	
	$code .= "<div class='pagebreak'></div>";
	
    $code .= "<p align=justify>";
    $code .= "<b>EXAME DE RETORNO AO TRABALHO (EMRT)</b> � exame a que s�o submetidos todos os empregados afastados por per�odo igual ou superior a 30 dias, por motivo de doen�as, acidentes, partos e fim de f�rias, no primeiro dia de retorno � atividade submeter-se-� a reavalia��o pelo m�dico do trabalho e recebera o ASO de libera��o ao servi�o.<p>";
    $code .= "<p align=justify>";
    $code .= "<b>EXAME M�DICO DEMISSIONAL (EMD)</b> � exame a que s�o submetidos os empregados, por ocasi�o da cessa��o do contrato de trabalho. � realizado, obrigatoriamente, em todos os casos de demiss�o, desde que o �ltimo Exame M�dico Ocupacional tenha sido realizado h� mais de 90 (Noventa) dias, visa tamb�m o cumprimento da IN 84 de 17.12.2002, anexo XV do INSS/DC. � perfil profissiogr�fico previdenci�rio.";

    $code .= "<BR><p align=justify>";
    $code .= "<div class='mediumTitle'><b>4. DIRETRIZES</b></div>";
    $code .= "<p align=justify>";

    $code .= "1� A crit�rio do m�dico examinador, em fun��o da avalia��o cl�nica, qualquer outro exame complementar poder� ser solicitado al�m daqueles estabelecidos, somente para esclarecimento de diagn�stico e n�o para acompanhamento de tratamento, sendo neste caso, integralmente custeado pela Empresa.";
    $code .= "<BR><p align=justify>";
    $code .="2� EMMF compreende avalia��o cl�nica e exames complementares previstos para o novo cargo/posto de trabalho que n�o tenham sido realizados no EMP de acordo com a TABELA DE EXAMES M�DICOS OCUPACIONAIS.";
    $code .= "<BR><p align=justify>";
    $code .="3� Quando o EMMF estiver programado para o per�odo de 90 (noventa) dias antes daquele previsto para o EMP, deve ser feita com antecipa��o deste, dentro da modalidade correspondente observando o disposto acima.";
    $code .= "<BR><p align=justify>";
    $code .="4� Ao deixar o trabalho em atividade que desenvolve risco, o empregado deve ser submetido a exame(s) espec�fico(s) para verifica��o de poss�vel doen�a decorrente do trabalho.";
    $code .= "<BR><p align=justify>";
    $code .="5� EMP corresponde avalia��o cl�nica e exames complementares conforme a TABELA DE EXAMES M�DICOS OCUPACIONAIS, com periodicidade e abrang�ncias definidas na TABELA PERIOCIDADE DE EXAMES.";
    $code .= "<BR><p align=justify>";
    $code .="6� EMRT compreende avalia��o cl�nica, a crit�rio do m�dico examinador, se necess�rios exames complementares, exclusivamente para fins de diagn�stico.";
    $code .= "<BR><p align=justify>";
    $code .="7� Na realiza��o do EMRT, quando o prazo para o EMP estiver vencido ou previsto para os pr�ximos 60 dias, este dever� ser realizado juntamente com o de EMRT obedecendo aos crit�rios pr�prios, devendo o m�dico examinador assinalar os dois exames, n�o s� na Ficha M�dica de Exame Ocupacional como no ASO.";
    $code .= "<BR><p align=justify>";
    $code .="8� No caso de EMD de empregados que executam atividades que envolvam riscos ocupacionais, � obrigat�ria a realiza��o de exames complementares espec�ficos, em fun��o do agente agressor.";

    $code .= "<BR><p align=justify>";
	
	$code .= "<div class='pagebreak'></div>";
	
    $code .= "<div class='mediumTitle'><b>5. METODOLOGIA</b></div>";
    $code .= "<p align=justify>";

    $code .="1� Ao realizar o EMO, o m�dico examinador preencher� o Prontu�rio M�dico Ocupacional e far� constar no ASO as seguintes conclus�es:";
    $code .= "<BR><p align=justify>";
    $code .= "�	TIPO I - APTO";
    $code .= "<BR><p align=justify>";
    $code .= "�	TIPO II � INAPTO";
    $code .= "<BR><p align=justify>";
    $code .= "A. No caso de conclus�o do tipo II, dever�o ser detalhadas as raz�es que determinam inaptid�o.";
    $code .= "<BR><p align=justify>";
    $code .= "B. No caso do tipo I, se houver restri��es, com base no estabelecido no item anterior, o M�dico de Trabalho Coordenador do PCMSO dever� avaliar o caso, definir as atividades que o empregado poder� exercer e, se for o caso, encaminhar para reaproveitamento funcional.";
    $code .= "<BR><p align=justify>";
    $code .= "2� O m�dico examinador, ao t�rmino do exame, dever�, tamb�m, assinar o ASO.";
    $code .= "<BR><p align=justify>";
    $code .= "3� O Atestado de Sa�de Ocupacional � ASO ser� emitido em duas vias.";
    $code .= "<BR><p align=justify>";
    $code .= "4� A primeira via do ASO ficar� arquivada na Empresa, devendo conter a assinatura do empregado, atestando o recebimento da segunda  via.";
    $code .= "<BR><p align=justify>";
    $code .= "5� A segunda via do ASO ser�, obrigatoriamente, entregue ao empregado.";
    $code .= "<BR><p align=justify>";
    $code .= "6� O Prontu�rio M�dico Ocupacional dever� ser arquivado pelo prazo de 20 (vinte) anos. Ap�s o desligamento do empregado.";
    $code .= "<BR><p align=justify>";
    $code .= "7� Somente o m�dico e o empregado poder�o ter acesso �s informa��es do Prontu�rio M�dico Ocupacional; habitualmente, e excepcionalmente o fiscal, no caso de se tratar de fiscal m�dico, caso contr�rio vale a primeira recomenda��o.";

    $code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [6]
/****************************************************************************************************************/
    $code .= "<BR><p><BR>";
    $code .= "<BR><p><BR>";
    $code .= "<BR><p><BR>";
    $code .= "<center><div class='bigTitle'><b>PROGRAMA DE CONTROLE M�DICO DE SA�DE OCUPACIONAL</b></div></center>";
    $code .= "<BR><p>";
    $code .= "<BR><p>";
    $code .= "<center><div class='bigTitle'><b>PCMSO � ".$info[ano]."</b></div></center>";
    $code .= "<BR><p><BR>";
    $code .= "<BR><p>";
    $code .= "<center><div class='bigTitle'><b>EXAMES M�DICOS OCUPACIONAIS E PROCEDIMENTOS</b></div></center>";
    $code .= "";
    $code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [7]
/****************************************************************************************************************/
    $code .= "<div class='mediumTitle'><b>6. PROCEDIMENTO � EXAMES COMPLEMENTARES</b></div>";
    $code .= "<p align=justify>";

    $code .= "O m�dico examinador de acordo com a avalia��o cl�nica solicitar� no ASO os exames complementares a serem realizados, nos casos cab�veis para diagn�sticos, pelas rotinas previamente estabelecidas de acordo com os Quadros I e II da NR-7.";
    $code .= "<BR><p align=justify>";
    $code .= "- O ASO s� ser� emitido ap�s aprova��o da empresa para realiza��o dos exames solicitados e o retorno do candidato/ empregado para a avalia��o dos resultados e parecer final do m�dico examinador.";
    $code .= "<BR><p align=justify>";
    $code .= "- Os resultados dos exames ser�o avaliados e anotados no Prontu�rio M�dico Ocupacional do empregado, pelo m�dico examinador, ap�s isto ser� entregue ao candidato/ empregado.";
    $code .= "<BR><p align=justify>";
    $code .= "OBSERVA��ES:<BR>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. A responsabilidade do encaminhamento dos candidatos a empregos e/ ou empregados para a realiza��o dos exames complementares solicitados � exclusivamente da Empresa.";
    $code .= "<BR><p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. A NR-7 torna obrigat�ria a realiza��o dos Exames M�dicos Ocupacionais, que compreendem avalia��o cl�nica e exames complementares solicitados, inviabiliza a monitorizar�o dos indicadores biol�gicos.";

    $code .= "<BR><p align=justify>";
    $code .= "<div class='mediumTitle'><b>7. ESTRAT�GIA</b></div>";
    $code .= "<p align=justify>";

    $code .= "Sendo verificada, atrav�s do Exame M�dico Ocupacional, exposi��o excessiva aos agentes de riscos, mesmo sem qualquer sintomatologia ou sinal cl�nico, o trabalhador dever� ser afastado do local de trabalho, ou do risco, at� que seja normalizada a situa��o e as medidas de controle nos ambientes de trabalho tenham sido adotadas.";
    $code .= "<BR><p align=justify>";
    $code .= "Sendo constatada a ocorr�ncia ou agravamento de doen�a profissional, ou verificadas altera��es que revelem qualquer tipo de disfun��o de �rg�o ou sistema biol�gico, mesmo sem sintomatologia, adotar as seguintes condutas:";
    $code .= "<BR><p align=justify>";
    $code .= "1� Afastar, imediatamente o empregado da exposi��o ao agente causador de risco;";
    $code .= "<BR><p align=justify>";
    $code .= "2� Emitir Comunica��o de Acidente do Trabalho � CAT, em 6 (seis) vias, de acordo com  a  ordem de servi�o 329 � INSS � DSS 26/10/93 � LTPS /94;";
    $code .= "<BR><p align=justify>";
    $code .= "3� Encaminhar o empregado a Previd�ncia Social, para estabelecimento de anexo causal de defini��o de conduta;";
    $code .= "<BR><p align=justify>";
    $code .= "4� Adotar medidas de corre��o e controle no ambiente de trabalho.";

    $code .= "<BR><p align=justify>";
    $code .= "<div class='mediumTitle'><b>8. RESPONSABILIDADE E ATRIBUI��ES</b></div>";
    $code .= "<p align=justify>";

    $code .= "<div class='mediumTitle'><b>EMPREGADOR</b></div>";
    $code .= "<p align=justify>";
    $code .= "&bull; Garantir a elabora��o e efetiva implementa��o, bem como zelar pela sua efic�cia;<br>";
    $code .= "&bull; Custear todos os procedimentos relativos a implanta��o do  PCMSO;<br>";
    $code .= "&bull; Indicar o m�dico coordenador como respons�vel pela execu��o do PCMSO.";
    $code .= "<BR><p align=justify>";
	
	$code .= "<div class='pagebreak'></div>";
		
    $code .= "<div class='mediumTitle'><b>SUPERVISORES</b></div>";
    $code .= "<p align=justify>";
    $code .= "&bull; Fornecer as informa��es necess�rias � elabora��o e execu��o do PCMSO;<br>";
    $code .= "&bull; Garantir a libera��o, durante a execu��o do servi�o, dos funcion�rios para os Procedimentos previstos no PCMSO junto ao m�dico do trabalho examinador;<br>";
    $code .= "&bull; Exigir dos funcion�rios a execu��o e o cumprimento dos pedidos dos m�dicos do trabalho, referente ao PCMSO.<br>";
    $code .= "&bull; Advertir os funcion�rios que n�o cumprirem as normas de convoca��o para exames peri�dicos.";
    $code .= "<BR><p align=justify>";

    $code .= "<div class='mediumTitle'><b>EMPREGADOS</b></div>";
    $code .= "<p align=justify>";
    $code .= "&bull; Submeter-se aos exames cl�nicos e complementares, quando convocado;<br>";
    $code .= "&bull; Seguir as orienta��es expedidas pelo m�dico coordenador;<br>";
    $code .= "&bull; Levantar e dar ci�ncia ao servi�o m�dico e a seguran�a do trabalho de situa��es que possam provocar doen�as profissionais.";
    $code .= "<BR><p align=justify>";

    $code .= "<div class='mediumTitle'><b>M�DICO COORDENADOR</b></div>";
    $code .= "<p align=justify>";
    $code .= "&bull; Realizar os exames necess�rios previstos na NR-7;<br>";
    $code .= "&bull; Indicar entidades capacitadas, equipadas e qualificadas a realizarem os exames complementares;<br>";
    $code .= "&bull; Manter o arquivo de prontu�rios cl�nicos e an�lise ocupacional;<br>";
    $code .= "&bull; Solicitar � empresa, quando necess�rio � emiss�o da CAT Comunica��o de Acidentes do Trabalho.";
    $code .= "<BR><p align=justify>";

    $code .= "<div class='mediumTitle'><b>DEPARTAMENTO DE RECURSOS HUMANOS / DEPARTAMENTO PESSOAL</b></div>";
    $code .= "<p align=justify>";
    $code .= "&bull; Dar ci�ncia ao servi�o m�dico dos procedimentos organizacionais necess�rios � execu��o do PCMSO;<br>";
    $code .= "&bull; Aplicar as se��es disciplinares cab�veis quando n�o forem cumpridos os procedimentos previstos neste PCMSO e nas Normas de Procedimentos de Sa�de Ocupacional pelos funcion�rios.";
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
	
    $code .= "<div class='mediumTitle'><b>9. DESCRI��O SETORIAL DAS INSTALA��ES DA EMPRESA</b></div>";
    $code .= "<p align=justify>";

    $code .= "A empresa situa-se em endere�o j� citado, assim dividido:";
    $code .= "<BR><p align=justify>";

    $code .= "<table width=100% cellspacig=2 cellpadding=2 border=1>";
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' width=50%><b>SETOR</b></td><td align=center class='bgtitle' width=50%><b>DESCRI��O</b></td>";
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
    $code .= "<div class='mediumTitle'><b>10. SISTEMATIZA��O SETORIAL</b></div>";
    $code .= "<p align=justify>";

    $code .= "A fim de dinamizarmos o estudo sistem�tico NR7 (PCMSO) dividiremos a empresa por setores:";
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
        $poss_doen_ocupacionais = "";//possibilidade de doen�as ocupacionais
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
        $code .= "<td colspan=2><b>Din�mica:</b> {$setores[$x][desc_setor]}</td>";
        $code .= "</tr>";
        $code .= "<tr>";
        $code .= "<td colspan=2><b>Riscos:</b> $riscaralho</td>";
        $code .= "</tr>";
        $code .= "<tr>";
        $code .= "<td colspan=2><b>Possibilidade de Doen�as Ocupacionais:</b> $poss_doen_ocupacionais</td>";
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
    $code .= "<div class='mediumTitle'><b>11. DADOS CADASTRAIS DOS FUNCION�RIOS E CRONOGRAMA DE EXAMES</b></div>";
    $code .= "<p align=justify>";

    $code .= "Independente da faixa et�ria, a coordena��o do PCMSO determina exames anuais personalizados, conforme tabela abaixo. O encaminhamento do funcion�rio para o peri�dico � de fundamental import�ncia para futura elabora��o do PPP, tendo como data base o per�odo de 12 meses entre a realiza��o dos exames.";
    $code .= "<BR><p align=justify>";

    $code .= "<table width=100% cellspacig=2 cellpadding=2 border=1>";
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle'><b>NOME</b></td>";
    $code .= "<td align=center class='bgtitle'><b>FUN��O</b></td>";
    $code .= "<td align=center class='bgtitle' width=100><b>ADMISS�O</b></td>";
    $code .= "<td align=center class='bgtitle' width=100><b>�LTIMO EXAME</b></td>";
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

    $code .= "OBS: Recomenda-se que a lista nominal, documento de identifica��o e data do �ltimo exame dos colaboradores por setor, conste nos mesmos de acordo com suas fun��es e din�mica da fun��o.";

    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [11]
/****************************************************************************************************************/
    $code .= "<div class='mediumTitle'><b>12. CONSIDERA��ES FINAIS</b></div>";
    $code .= "<p align=justify>";

    $code .= "1� No caso de epidemias ou endemias de doen�as de controle previs�veis por vacina��o, o m�dico examinador, por ocasi�o dos Exames M�dicos Ocupacionais, poder� solicitar a imuniza��o e/ ou o atestado de vacina��o.";
    $code .= "<BR><p align=justify>";
    $code .= "2� Os casos de doen�as de notifica��o compuls�ria, verificados durante os Exames M�dicos Ocupacionais, ser�o comunicados �s autoridades sanit�rias correspondentes e ao candidato/ empregado ou aos seus familiares.";
    $code .= "<BR><p align=justify>";
    $code .= "3� O n�o comparecimento ao Exame M�dico Ocupacional acarretar� as seguintes medidas:<br>";
    $code .= "&bull; EMA -  elimina��o do processo admissional;<br>";
    $code .= "&bull; EMMF � retardamento da mudan�a at� a realiza��o do exame;<br>";
    $code .= "&bull; EMRT � o empregado s� poder� reassumir suas atividades ap�s se submeter a esta modalidade de exame;<br>";
    $code .= "&bull; EMD � o desligamento de empregado ficar� condicionado � realiza��o do exame dentro do prazo de 15 dias que antecedem o desligamento definitivo do empregado;<br>";
    $code .= "&bull; EMP �  san��es administrativas disciplinares, a crit�rio do empregador.";
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
    $code .= "<b>Dr�. Maria de Lourdes F. de Magalh�es</b>";
    $code .= "<BR>";
    $code .= "M�dica do Trabalho � Coordenadora do PCMSO";
    $code .= "<BR>";
    $code .= "CRM 52.33471-0 Reg. MTE 13.330";

    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [12]
/****************************************************************************************************************/
    $code .= "<BR><p><BR>";
    $code .= "<BR><p><BR>";
    $code .= "<BR><p><BR>";
    $code .= "<center><div class='bigTitle'><b>PROGRAMA DE CONTROLE M�DICO DE SA�DE OCUPACIONAL</b></div></center>";
    $code .= "<BR><p>";
    $code .= "<BR><p>";
    $code .= "<center><div class='bigTitle'><b>PCMSO � ".$info[ano]."</b></div></center>";
    $code .= "<BR><p><BR>";
    $code .= "<BR><p>";
    $code .= "<center><div class='bigTitle'><b>EXAMES M�DICOS OCUPACIONAIS E PROCEDIMENTOS</b></div></center>";
    $code .= "";
    $code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [13] -> EMA
/****************************************************************************************************************/
    $code .= "<table width=100% cellspacig=2 cellpadding=2 border=1>";
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' colspan=5><b>EXAME M�DICO ADMISSIONAL (EMA)</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=center width=25%><b>Candidatos a</b></td>";
    $code .= "<td align=center width=20%><b>Descri��o da atividade</b></td>";
    $code .= "<td align=center width=20%><b>Agente de risco</b></td>";
    $code .= "<td align=center width=20%><b>Rotina<BR>&nbsp;AC&nbsp;&nbsp;|&nbsp;&nbsp;EC&nbsp;</b></td>";
    $code .= "<td align=center width=15%><b>Observa��o</b></td>";
    $code .= "</tr>";

    //obtem lista e dados das fun��es	
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
    $code .= "<td align=center colspan=4><b>Descri��o</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left>AC = Avalia��o Cl�nica</td>";
    $code .= "<td align=left colspan=4>An�lise ocupacional, exame f�sico e mental.</td>";
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
    $code .= "<td align=left class='bgtitle' colspan=5><b>PERIODICIDADE:</b> Os procedimentos dever�o ser adotados at� 5 (cinco) dias antes da admiss�o.</td>";
    $code .= "</tr>";
    $code .= "</table>";

    $code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [14] -> EMP
/****************************************************************************************************************/
    $code .= "<table width=100% cellspacig=2 cellpadding=2 border=1>";
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' colspan=5><b>EXAME M�DICO PERI�DICO (EMP)</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=center width=25%><b>Candidatos a</b></td>";
    $code .= "<td align=center width=20%><b>Descri��o da atividade</b></td>";
    $code .= "<td align=center width=20%><b>Agente de risco</b></td>";
    $code .= "<td align=center width=20%><b>Rotina<BR>&nbsp;AC&nbsp;&nbsp;|&nbsp;&nbsp;EC&nbsp;</b></td>";
    $code .= "<td align=center width=15%><b>Observa��o</b></td>";
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
    $code .= "<td align=center colspan=4><b>Descri��o</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left>AC = Avalia��o Cl�nica</td>";
    $code .= "<td align=left colspan=4>An�lise ocupacional, exame f�sico e mental.</td>";
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
    $code .= "<td align=left class='bgtitle' colspan=5><b>PERIODICIDADE:</b> Os procedimentos dever�o ser adotados regularmente a cada 12 (Doze) meses.</td>";
    $code .= "</tr>";
    $code .= "</table>";


/****************************************************************************************************************/
// -> PAGE [15] -> EMD
/****************************************************************************************************************/
    $code .= "<table width=100% cellspacig=2 cellpadding=2 border=1>";
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' colspan=5><b>EXAME M�DICO DEMISSIONAL (EMD)</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=center width=25%><b>Candidatos a</b></td>";
    $code .= "<td align=center width=20%><b>Descri��o da atividade</b></td>";
    $code .= "<td align=center width=20%><b>Agente de risco</b></td>";
    $code .= "<td align=center width=20%><b>Rotina<BR>&nbsp;AC&nbsp;&nbsp;|&nbsp;&nbsp;EC&nbsp;</b></td>";
    $code .= "<td align=center width=15%><b>Observa��o</b></td>";
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
    $code .= "<td align=center colspan=4><b>Descri��o</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left>AC = Avalia��o Cl�nica</td>";
    $code .= "<td align=left colspan=4>An�lise ocupacional, exame f�sico e mental.</td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left>EC = Exames Complementares</td>";
    $code .= "<td align=left colspan=4></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td align=left class='bgtitle' colspan=5><b>PERIODICIDADE:</b> Os procedimentos dever�o ser adotados at� 10 (dez) dias ap�s a demiss�o.</td>";
    $code .= "</tr>";
    $code .= "</table>";

    $code .= "<BR><P><BR>";

    $code .= "<table width=100% cellspacig=2 cellpadding=2 border=1>";
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' colspan=5><b>EXAME M�DICO RETORNO DE TRABALHO (EMRT)</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=5><p align=justify>Dever�o ser realizadas avalia��es cl�nicas e exames complementares, se necess�rio, para esclarecimento de diagn�stico, no primeiro dia da volta ao trabalho, de todos trabalhadores ausentes no per�odo igual ou superior a 30 (trinta) dias por motivo de doen�a ou acidente de natureza ocupacional ou n�o e parto.</td>";
    $code .= "</tr>";
    $code .= "</table>";

    $code .= "<BR><P><BR>";

    $code .= "<table width=100% cellspacig=2 cellpadding=2 border=1>";
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle' colspan=5><b>EXAME M�DICO DE MUDAN�A DE FUN��O (EMMF)</b></td>";
    $code .= "</tr>";
    $code .= "<tr>";
    $code .= "<td colspan=5><p align=justify>Dever� ser realizado em at� 5 (cinco) dias da mudan�a, desde que as altera��es na atividade no posto de trabalho ou setor impliquem na exposi��o do trabalhador a riscos diferentes daqueles a que estava exposto.</td>";
    $code .= "</tr>";
    $code .= "</table>";

    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [16]
/****************************************************************************************************************/
    $code .= "<center><div class='bigTitle'><b>PROGRAMA DE CONTROLE M�DICO DE SA�DE OCUPACIONAL</b></div></center>";
    $code .= "<center><div style=\"text-align: center;\"><b>PCMSO</b></div></center>";
    $code .= "<hr>";
    $code .= "<div style=\"text-align: center;\">";
    $code .= "<i><b>Realiza��o:</b> </i><BR>";
    $code .= "Rio de Janeiro, ".date("d", strtotime($info[data_avaliacao]))." de ".$meses[date("n", strtotime($info[data_avaliacao]))]." de ".date("Y", strtotime($info[data_avaliacao]))."";
    $code .= "<p>";
    $code .= "<i><b>Per�odo:</b> </i><BR>";
    $code .= "".$meses[date("n", strtotime($info[data_avaliacao]))]."/".date("Y", strtotime($info[data_avaliacao]))." � ".$meses[date("n", strtotime($info[data_avaliacao]))]."/".((int)(date("Y", strtotime($info[data_avaliacao])))+1)."";
    $code .= "<p>";
    $code .= "<i><b>Elabora��o:</b> </i><BR>";
    $code .= "SESMT � SERVI�OS ESPECIALIZADOS DE SEGURAN�A E MONITORAMENTO DE ATIVIDADE NO TRABALHO LTDA<br>";
    $code .= "RUA MARECHAL ANT�NIO DE SOUZA, 92 � JARDIM AM�RICA<br>";
    $code .= "CNPJ 04.722.248/0001-17<BR>";

    if($_GET[sem_assinatura])
        $code .= "<BR>";
    else
        if(!$_GET[html])
            $code .= "<img src='"._IMG_PATH."assin_medica0.png' border=0><BR>";

        
    $code .= "Dr�. Maria de Lourdes F. de Magalh�es<BR>";
    $code .= "M�dica do Trabalho<BR>";
    $code .= "Coordenadora do PCMSO<BR>";
    $code .= "CRM /RJ � 52.33.471-0 - MTE 13320<p>";
    $code .= "<i><b>Fundamenta��o Legal:</b> </i><BR>";
    $code .= "Constitui��o federal, cap�tulo II (Dos Direitos Sociais), artigo 6� e 7�, incisos XXII, XXIII, XXVIII E XXXIII;<BR>";
    $code .= "Consolida��o das leis do trabalho � CLT, Cap�tulo V, artigos 168 e 1669; Lei 6.514, de 22 de dezembro de 1977;<BR>";
    $code .= "Portaria do MTE n� 24, de 29/12/94, aprova o novo texto da NR-7.";
    $code .= "</div>";
    $code .= "<hr>";
    $code .= "<center><div class='mainTitle'><b>$info[razao_social]</b></div></center>";
    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [17]
/****************************************************************************************************************/
    //$code .= "<BR><p><BR>";
    $code .= "<center><div class='bigTitle'><b>PROGRAMA DE CONTROLE M�DICO DE SA�DE OCUPACIONAL</b></div></center>";
    $code .= "<BR><p>";
    $code .= "<BR><p>";
    $code .= "<center><div class='bigTitle'><b>PCMSO � ".$info[ano]." / ".($info[ano]+1)."</b></div></center>";
    $code .= "<BR><p>";
    $code .= "<BR><p>";
    $code .= "<center><div class='bigTitle'><b>ANEXOS; CONSIDERA��ES GERAIS; INFORMA��ES COMPLEMENTARES; PLANEJAMENTO ANUAL E RELA��O DE EMPREGADOS</b></div></center>";
    $code .= "<BR><p>";
    $code .= "<BR><p>";
    $code .= "<center><div class='bigTitle'><b>PCMSO � ".$info[ano]." / ".($info[ano]+1)."</b></div></center>";

    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [18]
/****************************************************************************************************************/
    $code .= "<BR><p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Para cada exame realizado dever� ser emitido um atestado de sa�de ocupacional em tr�s vias, devendo a
    primeira via ficar arquivada na empresa para controle e eventual apresenta��o � fiscaliza��o, a segunda dever�
    ser entregue aos funcion�rios, o qual dever� protocolar, a primeira e terceira via com o m�dico coordenador para
    seu controle.<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Todo o funcion�rio dever� possuir um prontu�rio cl�nico individual que dever� ficar sob-responsabilidade do coordenador durante um per�odo m�nimo de 20 anos ap�s o desligamento do funcion�rio.
    No prontu�rio dever� constar todo o dado obtido nos exames m�dicos, avalia��es cl�nicas e exames complementares,
    bem como as conclus�es e eventuais medidas aplicadas: em caso de substitui��o do coordenador os arquivos dever�o
    ser transferidos para seu sucessor; o coordenador dever� emitir relat�rio anual dos objetivos alcan�ados, que
    dever� ser anexado ao final do ano vigente do per�odo referido no PCMSO.<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Todos os estabelecimentos comerciais e ou institucionais, devem possuir um kit de primeiros socorros,
    composto, por exemplo, dos seguintes itens por setor ou fun��o:<p align=justify>";
    $code .= "�gua oxigenada; �lcool 70%; Algod�o em bolinha; Atadura; Cotonete; Curativo adesivo (band-aid);
    Esparadrapo; Ficha de controle de retirada; Gaze esterilizada; Luva descart�vel; Pin�a; Rela��o de material e
    quantidade contida no arm�rio; Reparil gel; Repelente; Solu��o antiss�ptica; Soro fisiol�gico; Term�metro;
    Vaselina l�quida ou Dersani.<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O PCMSO poder� sofrer altera��es a qualquer momento, em algumas partes ou at� mesmo no seu todo,
    quando o m�dico detectar mudan�as nos riscos ocupacionais decorrentes de altera��es nos processos de trabalho,
    novas descobertas da ci�ncia m�dica em rela��o a efeitos de riscos existentes, mudan�a de crit�rios e
    interpreta��o de exames ou ainda a reavalia��o do reconhecimento dos riscos por compet�ncia da legisla��o NR.<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O PCMSO dever� ter car�ter de preven��o, rastreamento e diagn�stico precoce dos agravos � sa�de
    relacionados ao trabalho, inclusive de natureza sub-cl�nica, al�m da constata��o da exist�ncia de casos de
    doen�as profissionais ou danos irrevers�veis � sa�de dos trabalhadores. Em face ao despacho de 1� de outubro de
    96 da Secretaria de Seguran�a e Sa�de do Trabalho.<p align=justify>";
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
    $code .= "<div class='mainTitle'><b>INFORMA��ES COMPLEMENTARES</b></div>";
    $code .= "<BR><p align=justify>";
    $code .= "<div class='mediumTitle'><b>RECOMENDA��ES � EMPRESA</b></div>";
    $code .= "<BR><p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Este cap�tulo tem como objetivo principal orientar a administra��o desta empresa como se pode minimizar os problemas decorrentes de incid�ncia e imper�cia no �mbito da empresa, ele visa trazer uma oportunidade com um custo baixo, e n�o s� orientar os colaboradores de sua empresa, mas, salvar e guardar a qualidade dos produtos e servi�os prestados aos seus clientes sem contar o bom nome da empresa que deve ser sempre protegido de esc�ndalos e de investidas das fiscaliza��es.";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recomenda-se que todos os colaboradores devam receber orienta��es sobre seguran�a do trabalho e preven��o de acidentes, objetivando cumprir com a NR 5.6.4 lei 6.514/77 que diz n�o haver obrigatoriedade da CIPA institu�da atrav�s do voto por falta de contingente, dever� ter um colaborador treinado, funcionando como um multiplicador aos demais companheiros.";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recomenda-se que todos os colaboradores devam receber orienta��es sobre alcoolismo, objetivando desmotivar o uso de tal subst�ncia o que acarretaria em poss�veis danos a sa�de e na produtividade da empresa.";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recomenda-se que todos os colaboradores devam receber orienta��es sobre tabagismo, objetivando desmotivar o uso de tal subst�ncia o que acarretaria em poss�veis danos a sa�de do fumante, dos que os rodeiam e na produtividade da empresa, podendo ainda provocar princ�pios de inc�ndios.";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recomenda-se que todos os colaboradores devam receber orienta��es sobre doen�as sexualmente transmiss�veis (DST), doen�as ostenculares relacionadas ao trabalho (DORT), objetivando a conscientiza��o e preven��o das mesmas.";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recomenda-se que todos os colaboradores devam receber orienta��es sobre o uso dos equipamentos de preven��o individual (EPI), objetivando a conscientiza��o e preven��o da sa�de e integridade f�sica dos colaboradores e isen��o de a��es jur�dicas.";
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
    $code .= "<div class='mediumTitle'><b>RECOMENDA��ES DE RISCOS BIOL�GICOS CONSIDERADOS LEVES PARA MONITORAMENTO DO PCMSO</b></div>";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cobrir com capas pl�sticas os teclados dos micros computadores ou virar as teclas para baixo no final de cada expediente, proporcionando assim que as part�culas de poeiras suspensas no ambiente n�o nos sedimentem.";
    $code .= "<p align=justify>";
    $code .= "<b>Poss�veis Sintomas:</b> Dor de cabe�a, problemas al�rgicos e respirat�rios.";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Substituir vasos de plantas naturais por artificiais em ambientes refrigerados mecanicamente \"Ar Condicionado\".";
    $code .= "<p align=justify>";
    $code .= "<b>Poss�veis Sintomas:</b> Problemas Al�rgicos e dermatol�gicos, gerado dos excrementos de anel�deos que em contato com ar refrigerado e respirado pelo ser humano em ambiente enclausurado.";
    $code .= "<p align=justify>";

    $code .= "<div class='mediumTitle'><b>CAMPANHA DE VACINA��O</b></div>";
    $code .= "<p align=justify>";

    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recomenda-se Divulgar, incentivar e promover a pol�tica de vacina��o prevencionista como:";
    $code .= "<p align=justify>";
    $code .= "<b>Antigripal</b> � Recomendada para todas as idades e sendo administrada anualmente, pr�xima aos meses de inverno, preferencialmente no m�s de Abril.";
    $code .= "<p align=justify>";
    $code .= "<b>Antitet�nica</b> � Recomendada a tomar as 03 doses e depois a cada 10 anos.";
    $code .= "<p align=justify>";
    $code .= "<b>Hepatite</b> � Recomendada na fase adulta a tomar as 03 doses sendo que a 2� depois com 30 dias e a 3� dose com 180 dias.";
    $code .= "<p align=justify>";
    $code .= "<b>Vacina contra Rub�ola</b> - Dever�o ser vacinadas nas campanhas realizadas pela Secretaria de Estado da Sa�de: com aplica��o da vacina dupla viral (sarampo e rub�ola) em homens e mulheres de 20 a 39 anos de idade mesmo aquelas que j� tomaram a vacina anteriormente ou que referem j� ter tido a doen�a e pessoas com idade at� 19 anos a tr�plice viral (sarampo, caxumba e rub�ola).";
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
    $code .= "<div class='mediumTitle'><b>RECOMENDA��ES DE CONTROLES DE EPIDEMIOLOGIA</b></div>";
    $code .= "<p align=justify>";
    $code .= "<b>AEDES AEGYPT (Mosquito da Dengue):</b> A �nica maneira de evitar a dengue ( Aedes Aegypt) � n�o deixar o mosquito nascer. Combater a larva � mais f�cil que combater o mosquito adulto.";
    $code .= "<p align=justify>";
    $code .= "� a� que voc� pode ajudar! Lembre-se:";
    $code .= "<p align=justify>";
    $code .= "&bull; Designar um grupo de trabalho em sua Unidade/�rg�o com a participa��o da Cipa, sob a Coordena��o do ATU/ATD;<br>";
    $code .= "&bull; Eliminar os criadouros internos como: vasos, pratos de xaxim, enfeites e todo tipo de situa��o que possa acumular �gua limpa;<br>";
    $code .= "&bull; Providenciar a limpeza de calhas, lajes, caixas d'�gua juntamente com o apoio do Estec;<br>";
    $code .= "&bull; Remover entulhos provenientes de restos de constru��o, sucata de descarte e lixos em geral;<br>";
    $code .= "&bull; Fiscalizar o cumprimento das medidas adotadas;<br>";
    $code .= "&bull; Divulgar aos funcion�rios e convenc�-los que essa proibi��o � para o bem comum.<BR>";
    $code .= "<BR><p>";
    $code .= "<b>GRIPE H1N1 (Influenza A):</b> Considerando de que o v�rus da gripe H1N1 est� confirmado a multiplica��o e sua plorifera��o, a melhor forma de combater a doen�a � a preven��o.<BR>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lista com alguns h�bitos que ser� muito �til manter, s�o recomenda��es do Centro de controle e preven��o de doen�as dos Estados Unidos.";
    $code .= "<p align=justify>";
    $code .= "� a� que voc� pode ajudar! Lembre-se:";
    $code .= "<p align=justify>";
    $code .= "&bull; Evite contato direto com pessoas doentes;<br>";
    $code .= "&bull; Cubra seu nariz e boca se por a caso for tossir ou espirrar;<br>";
    $code .= "&bull; Evite ao m�ximo tocar no nariz, boca e olhos, se for mesmo necess�rio lave as m�os antes;<br>";
    $code .= "&bull; Se voc� ficar doente, procure ficar em casa e restringir o contato com outras pessoas, para evitar o contagio;<br>";
    $code .= "&bull; Lave as m�os sempre com �gua e sab�o, �lcool tamb�m � �timo para higienizar as m�os.<br>";
    $code .= "<p align=justify>";
    $code .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fique atento, pois os sintomas da gripe H1N1 s�o muito parecidos com o da gripe comum, voc� pode ter:
    febre, letargia, falta de apetite e tosse.<BR>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Em algumas pessoas esta gripe pode provocar: coriza, garganta seca, n�usea, v�mito e diarreia. Se voc� ou algum
    familiar tiver com estes sintomas procure um m�dico.";

    $code .= "<BR><p>";
    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [22]
/****************************************************************************************************************/
    $code .= "<div class='mainTitle'><b>PLANEJAMENTO ANUAL DE: ".$info[ano]." � ".($info[ano]+1)."</b></div>";
    $code .= "<BR><p align=justify>";

    $code .= "<table width=100% border=1 cellspacing=2 cellpadding=2>";
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle'><b>ATIVIDADE</b></td>";
    for($x=1;$x<=12;$x++){
         $code .= "<td align=center class='bgtitle' WIDTH=40><b>$m[$x]</b></td>";
    }
    $code .= "</tr>";

    $code .= "<tr>";
    $code .= "<td>Elabora��o do PCMSO</td>";
    for($x=1;$x<=12;$x++){
        if($x == date("n", strtotime($info[data_avaliacao]))) $val = "xxx"; else $val = " ";
        $code .= "<td align=center>$val</td>";
    }
    $code .= "</tr>";

    $code .= "<tr>";
    $code .= "<td>Realiza��o dos Exames Peri�dicos</td>";
    for($x=1;$x<=12;$x++){
        if($x == date("n", strtotime($info[data_avaliacao]))) $val = "xxx"; else $val = " ";
        $code .= "<td align=center>$val</td>";
    }
    $code .= "</tr>";

    $code .= "<tr>";
    $code .= "<td>Avalia��o Global da Efic�cia do Programa</td>";
    for($x=1;$x<=12;$x++){
        if($x == date("n", mktime(0, 0, 0, date("n", strtotime($info[data_avaliacao]))+6, 1, date("Y", strtotime($info[data_avaliacao]))))) $val = "x"; else $val = " ";
        $code .= "<td align=center>$val</td>";
    }
    $code .= "</tr>";

    $code .= "<tr>";
    $code .= "<td>Elabora��o do Relat�rio Anual</td>";
    for($x=1;$x<=12;$x++){
        if($x == date("n", mktime(0, 0, 0, date("n", strtotime($info[data_avaliacao]))+11, 1, date("Y", strtotime($info[data_avaliacao]))))) $val = "xx"; else $val = " ";
        $code .= "<td align=center>$val</td>";
    }
    $code .= "</tr>";

    $code .= "<tr>";
    $code .= "<td>Renova��o do Programa</td>";
    for($x=1;$x<=12;$x++){
        if($x == date("n", mktime(0, 0, 0, date("n", strtotime($info[data_avaliacao]))+11, 1, date("Y", strtotime($info[data_avaliacao]))))) $val = "xx"; else $val = " ";
        $code .= "<td align=center>$val</td>";
    }
    $code .= "</tr>";
    $code .= "</table>";
    $code .= "<BR><p>";

    $code .= "<b>Legenda:</b><p>";

    $code .= "x - Em Execu��o no Ano de $info[ano] / ".($info[ano]+1)."<BR>";
    $code .= "xx - Em Execu��o no Ano de ".($info[ano]+1)."<BR>";
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
    $code .= "<div class='mainTitle'><b>RELA��O DE FUNCION�RIOS</b></div>";
    $code .= "<p align=justify>";

    $code .= "<table width=100% border=1 cellspacing=2 cellpadding=2>";
    $code .= "<tr>";
    $code .= "<td align=center class='bgtitle'>NOME</td>";
    $code .= "<td align=center class='bgtitle'>FUN��O</td>";
    $code .= "<td align=center class='bgtitle'>ADMISS�O</td>";
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

    $code .= "OBS.: Recomenda-se que a lista nominal, documento de identifica��o e data do �ltimo exame dos colaboradores por setor, conste nos mesmos de acordo com suas fun��es e din�mica da fun��o.";

    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [24]
/****************************************************************************************************************/
    $code .= "<div class='mainTitle'><b>RELAT�RIO ANUAL $info[ano] / ".($info[ano]+1)."</b></div>";
    $code .= "<p align=justify>";

    $code .= "<b>Coordenador(a):</b> Dr� Maria de Lourdes Fernandes de Magalh�es";
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
    $code .= "<td align=center class='bgtitle'>FUN��O</td>";
    $code .= "<td align=center class='bgtitle'>NATUREZA DO EXAME</td>";
    $code .= "<td align=center class='bgtitle'>N� ANUAL DE EXAMES REALIZADOS</td>";
    $code .= "<td align=center class='bgtitle'>RESULTADOS ANORMAIS</td>";
    $code .= "<td align=center class='bgtitle'>RESULTADOS NORMAIS (%)</td>";
    $code .= "<td align=center class='bgtitle'>N� EXAMES PARA O ANO SEGUINTE</td>";
    $code .= "</tr>";
    for($x=0;$x<pg_num_rows($rlf);$x++){
        //Exames por fun��o
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
}else{
    echo $code;
}
?>