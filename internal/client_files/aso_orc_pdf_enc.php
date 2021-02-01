<?PHP
/*****************************************************************************************************************/
// -> INCLUDES / DEFINES
/*****************************************************************************************************************/
define('_MPDF_PATH', '../../common/MPDF45/');
define('_IMG_PATH', '../../images/');
include(_MPDF_PATH.'mpdf.php');
include("../../common/includes/database.php");
include("../../common/includes/functions.php");

/********************************************************************************************************/
// -> VARS
/*********************************************************************************************************/
$orc = $_GET[cod_orc];

/*****************************************************************************************************/
// -> BEGIN DOCUMENT
/******************************************************************************************************/
ob_start(); /************************************************************************************************************/
    // -> HEADER /************************************************************************************************************/
    if($_GET[sem_timbre]){
        $cabecalho .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
        $cabecalho .= "<tr>";
        $cabecalho .= "<td align=left height=$header_h>&nbsp; </td>";
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }else{
        $cabecalho .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
        $cabecalho .= "<tr>";
        $cabecalho .= "<td align=left height=$header_h valign=top width=270><img src='"._IMG_PATH."logo_sesmt.png' width='270' height='135'></td>";
        $cabecalho .= "<td align=center height=$header_h valign=top class='medText'>Serviços Especializados de Segurança e<br>Monitoramento de Atividades no Trabalho<p>Assistência em Segurança e Higiene no Trabalho</td>";
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }
    /************************************************************************************************************/
    // -> FOOTER
    /************************************************************************************************************/
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
        $rodape .= "<td align=left height=$footer_h valign=bottom class='medText'>Telefone: +55 (21) 3014 4304      Fax: Ramal 7<br>Nextel: +55 (21) 7844 6095 / Id 55*23*31641<br>medicotrab@sesmt-rio.com<br>www.sesmt-rio.com / www.shoppingsesmt.com</td>";
        $rodape .= "<td align=right height=$footer_h width=207 valign=bottom><img src='"._IMG_PATH."logo_sesmt2.png' width=207 height=135></td>";
        $rodape .= "</tr>";
        $rodape .= "</table>";
    }
    
/***************************************************************************************************************/
// -> VAR
/***************************************************************************************************************/

$sql_orc = "SELECT * FROM orc_aso WHERE cod_orc = '$orc' ORDER BY cod_func";
$query_orc = pg_query($sql_orc);
$array_orc = pg_fetch_all($query_orc);

$sql_clin = "SELECT * FROM clinicas WHERE cod_clinica = ".$array_orc[0][cod_clinica]." ";
$query_clin = pg_query($sql_clin);
$array_clin = pg_fetch_array($query_clin);

$sql_cli = "SELECT * FROM cliente WHERE cliente_id = ".$array_orc[0][cod_cliente]." ";
$query_cli = pg_query($sql_cli);
$array_cli = pg_fetch_array($query_cli);

$sql_func = "SELECT * FROM funcionarios WHERE cod_cliente = ".$array_orc[0][cod_cliente]." AND cod_func = ".$array_orc[$c][cod_func]." ";
$query_func = pg_query($sql_func);
$array_func = pg_fetch_all($query_func);

$sql = "SELECT * FROM exame WHERE cod_exame = 10 or cod_exame = 11";
$rr = pg_query($sql);
$ee = pg_fetch_all($rr);

$n = 0;

for($x=0;$x<pg_num_rows($query_orc);$x++){
	if($array_orc[$x][cod_func] != $array_orc[$x-1][cod_func]){
		$n+=1;
		$fu[$x] = $array_orc[$x][cod_func];
	}
}

for($x=0;$x<pg_num_rows($query_orc);$x++){
	if($array_orc[$x][cod_func] != $array_orc[$x-1][cod_func]){
		$fu[$x] = $array_orc[$x][cod_func];
	
		$sql_func = "SELECT * FROM funcionarios f, funcao u WHERE f.cod_cliente = ".$array_orc[0][cod_cliente]." AND f.cod_func = '$fu[$x]' AND f.cod_funcao = u.cod_funcao";
		$query_func = pg_query($sql_func);
		$array_func = pg_fetch_array($query_func);
		
		$sql_aso = "SELECT * FROM aso WHERE cod_func = '$fu[$x]' AND cod_cliente = '".$array_orc[0][cod_cliente]."' ORDER BY cod_aso DESC";
		$query_aso = pg_query($sql_aso);
		$array_aso = pg_fetch_all($query_aso);
		$tipo_exame = "";
		$s = "SELECT * FROM aso_exame a, exame e WHERE a.cod_aso = '".$array_aso[0][cod_aso]."' AND a.cod_exame = e.cod_exame";
		$q = pg_query($s);
		$a = pg_fetch_all($q);
		for($z=0;$z<pg_num_rows($q);$z++){
			$tipo_exame.=$a[$z]['especialidade'];
			$tipo_exame .= ";";
		}
		

if($array_orc[0][visita] == 0){
/**************************************************************************************************************/
// -> PAGE [1]
/**************************************************************************************************************/
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=center><b>ENCAMINHAMENTO MÉDICO COMPLEMENTAR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nº ".$array_aso[0][cod_aso]."</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table><p><br><p>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify><b>Clínica:</b> {$array_clin['razao_social_clinica']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=60%><b>Endereço:</b> {$array_clin['endereco_clinica']}</td>";
	$msg_site .= "<td align=justify><b>Nº</b> {$array_clin['num_end']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=40%><b>CEP:</b>  {$array_clin['cep_clinica']}</td>";
	$msg_site .= "<td align=justify ><b>Bairro:</b> {$array_clin['bairro_clinica']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify><b>Ponto de Referência:</b> {$array_clin['referencia_clinica']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table><br>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Assunto:</b> Atendimento para ASO Periódico</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Encaminhado:</b> {$array_func['nome_func']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=60%><b>Função:</b> {$array_func['nome_funcao']}</td>";
	$msg_site .= "<td align=justify width=20%><b>CTPS:</b> {$array_func['num_ctps_func']}</td>";
	$msg_site .= "<td align=justify width=20%><b>Série:</b> {$array_func['serie_ctps_func']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Exames a serem realizados:</b> ".$tipo_exame."</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table><br>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>CNPJ:</b> {$array_cli['cnpj']}</td>";
    $msg_site .= "<td align=justify width=70%><b>Empresa Solicitante:</b> {$array_cli['razao_social']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table><br>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Contato:</b> {$array_cli['telefone']}</td>";
	$msg_site .= "<td align=justify width=70%><b>Resp. Solicitante</b> {$array_cli['nome_contato_dir']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table><br>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=100%><b>Resp. Solicitante</b> {$array_cli['endereco']}, {$array_cli['bairro']}, {$array_cli['municipio']}, {$array_cli['estado']} - CEP: {$array_cli['cep']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table><br>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Horário:</b> Ordem de Chegada de Segunda a Sexta</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Horário Término para atendimento Laboratorial:</b> 11h00min</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Horário Término para atendimento Geral:</b> 15h00min</td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table><br>";

	for($y=0;$y<pg_num_rows($rr);$y++){
		if($ee[$y][cod_exame] == '10' ){
		$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
		$msg_site .= "<tr>";
		$msg_site .= "<td align=justify width=30%>EAS - Fazer uma higiene íntima rigorosa em sua casa, usando sabonete e água, enxaguar bem com água abundante e secar bem com uma toalha limpa; Coletar a primeira urina da manhã ou 2 horas após a última micção; Desprezar o primeiro jato da urina no vaso sanitário e coletar no copo descartável o jato do meio, mais ou menos (até a metade do copo) desprezando o restante da micção no vaso sanitário; Imediatamente, passar a urina do copo para o tubo, até preencher totalmente, fechar e muito bem e identificar com seu nome completo.</td>";
		$msg_site .= "</tr>";
		$msg_site .= "</table><br>";
		}
		
		if($ee[$y][cod_exame] == 11 ){
		$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
		$msg_site .= "<tr>";
		$msg_site .= "<td align=justify width=30%>EPF - Colher as fezes diretamente no frasco ou sobre um papel ou plástico e transferir para o pote, este procedimento de preferência no período da manhã e depois de coletar (pequena porção) levar para o local do exame, caso não seja possível, acondicionar o pote em um saco plástico e manter refrigerado.</td>";
		$msg_site .= "</tr>";
		$msg_site .= "</table><br>";
		}
	}
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>OBS: O não comparecimento do candidato e/ou a não realização de algum procedimento ora agendado e não cumprido pelo solicitante não anulará a cobrança do mesmo, ficando o crédito para esse mesmo candidato se submeter em outra data.</b></td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table>";
	
    $msg_site .= "<div class='pagebreak'></div>";
}
/**************************************************************************************************************/
// -> PAGE [2]
/**************************************************************************************************************/
	$msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=center colspan=4><b>SESMT - Serviços Especializados de Segurança de Monitoramento de Atividades no Trabalho LTDA</b></td>";
    $msg_site .= "<td align=justify><b>Prontuário Médico:</b> ".$array_aso[0][cod_aso]."</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=5><b>Clínica:</b> {$array_clin['razao_social_clinica']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=5><b>Empresa:</b> {$array_cli['razao_social']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=5><b>Nome:</b> {$array_func['nome_func']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=2 width=40%><b>Função Atual:</b> {$array_func['nome_funcao']}</td>";
	$msg_site .= "<td align=justify colspan=2 width=40%><b>Função Anterior:</b> </td>";
	$msg_site .= "<td align=justify width=20%><b>RG:</b> {$array_func['rg']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=20%><b>Sexo:</b> {$array_func['sexo_func']}</td>";
	$msg_site .= "<td align=justify width=20%><b>Est. Civil:</b> {$array_func['civil']}</td>";
	$msg_site .= "<td align=justify width=20%><b>Cor:</b> {$array_func['cor']}</td>";
	$msg_site .= "<td align=justify width=20%><b>Nasc.:</b> {$array_func['data_nasc_func']}</td>";
	$msg_site .= "<td align=justify width=20%><b>Natural:</b> {$array_func['naturalidade']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=5><b>Endereço:</b> {$array_func['endereco_func']}</td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table>";
	
	$msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=2><b>Antecedentes Familiares:&nbsp;&nbsp;&nbsp;Parentesco</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=50%><b>&bull; Tuberculose/Diabete/Câncer ______________________________________</b></td>";
	$msg_site .= "<td align=justify width=50%><b>&bull; Asma/Alergias/Urticária __________________________________________</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=50%><b>&bull; Doença do Coração/Pressão Alta _________________________________</b></td>";
	$msg_site .= "<td align=justify width=50%><b>&bull; Doença Mental/Nervosa __________________________________________</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=2><b>&bull; Outras _______________________________________________________________________________________________________________________________________</b></td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table>";
	
	$msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=2><b>Antecedentes Pessoais</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Doença do Coração/Pressão Alta ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Enxerga Bem ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Varizes/Varicocele/Hérnias ( )</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Dor no Peito/Palpitação ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Ouve Bem/Otite/Zumbido ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Hemorróidas/Diarréia Frequente ( )</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Bronquite/Asma/Rinite ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Já teve internado ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Sofreu doença não mencionada ( )</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Doenças Coluna/Dor nas Costas ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Encontra-se grávida ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Pode executar tarefas pesadas ( )</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Doenças Renais(Rins) ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Doença Mental/Nervosa ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Tem alguma deficiência ( )</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Doença do Fígado/Diabetes ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Dor de Cabeça/Tonturas/Convulsões ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Sofreu alguma cirurgia ( )</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Úlcera/Gastrite ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Alergia/Doença de Pele ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Tabagismo(Fumo)/Etilismo(Bebe) ( )</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Resfriado/Tosse Crônica/Sinusite ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Reumatismo/Dor nas Juntas ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b> </b></td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table><br>";

	$msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=2><b>Antecedentes Ocupacionais</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=50%><b>&bull; Suas condições de saúde exige trabalho especial ( )</b></td>";
	$msg_site .= "<td align=justify width=50%><b>&bull; Recebeu indenização por acidente de trabalho ( )</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=50%><b>&bull; Perdeu dias de trabalho por motivos de saúde ( )</b></td>";
	$msg_site .= "<td align=justify width=50%><b>&bull; Esteve doente devido seu trabalho ( )</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=50%><b>&bull; Esteve afastado pelo I.N.P.S. ( )</b></td>";
	$msg_site .= "<td align=justify width=50%><b> </b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=2><b>Anotações(tratamentos-remédios): _________________________________________________________________________________________________________</b></td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table><br>";
	
	$msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=4><b>Exame Físico</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=25%><b>Cabeça</b></td>";
	$msg_site .= "<td align=justify width=25%><b>Pescoço</b></td>";
	$msg_site .= "<td align=justify width=25%><b>Tórax</b></td>";
	$msg_site .= "<td align=justify width=25%><b>Abdome</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=25%>Boca/Dente: ______________</td>";
	$msg_site .= "<td align=justify width=25%>Faringe: _______________</td>";
	$msg_site .= "<td align=justify width=25%>Coração: _______________</td>";
	$msg_site .= "<td align=justify width=25%>Hérnias: _______________</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=25%>Nariz: _______________</td>";
	$msg_site .= "<td align=justify width=25%>Amídalas: _______________</td>";
	$msg_site .= "<td align=justify width=25%>Pulmões: _______________</td>";
	$msg_site .= "<td align=justify width=25%>Anéis: _______________</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=25%>Língua: _______________</td>";
	$msg_site .= "<td align=justify width=25%>Laringe: _______________</td>";
	$msg_site .= "<td align=justify width=25%><b></b></td>";
	$msg_site .= "<td align=justify width=25%><b></b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=25%>Ouvidos: _______________</td>";
	$msg_site .= "<td align=justify width=25%>Tireóide: _______________</td>";
	$msg_site .= "<td align=justify width=25%><b></b></td>";
	$msg_site .= "<td align=justify width=25%><b></b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=25%><b>Genital</b></td>";
	$msg_site .= "<td align=justify width=25%><b>Membros</b></td>";
	$msg_site .= "<td align=justify width=25%><b></b></td>";
	$msg_site .= "<td align=justify width=25%><b></b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=25%>Varicocele: _______________</td>";
	$msg_site .= "<td align=justify width=25%>Isquemia: _______________</td>";
	$msg_site .= "<td align=justify width=25%>Pé Plano: _______________</td>";
	$msg_site .= "<td align=justify width=25%><b>Pressão Arterial: _______________</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=25%>Hidroxila: _______________</td>";
	$msg_site .= "<td align=justify width=25%>Edemas: _______________</td>";
	$msg_site .= "<td align=justify width=25%>Pele/Mucosa: _______________</td>";
	$msg_site .= "<td align=justify width=25%><b>Pulso: _______________</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=25%>D.U.M.: _______________</td>";
	$msg_site .= "<td align=justify width=25%>Má Formação: _______________</td>";
	$msg_site .= "<td align=justify width=25%>Coluna Vertebral: _______________</td>";
	$msg_site .= "<td align=justify width=25%><b>Altura: _______________</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=25%>Corrimentos: _______________</td>";
	$msg_site .= "<td align=justify width=25%>Calos: _______________</td>";
	$msg_site .= "<td align=justify width=25%>Varizes: _______________</td>";
	$msg_site .= "<td align=justify width=25%><b>Peso: _______________</b></td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table><br>";
	
	$msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify ><b>Exames Complementares</b></td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table>";
	
	$msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=15%><b>Exames</b></td>";
	$msg_site .= "<td align=justify width=8%><b>Data</b> </td>";
	$msg_site .= "<td align=justify width=10%><b>Resultado</b></td>";
	$msg_site .= "<td align=justify width=15%><b>Exames</b></td>";
	$msg_site .= "<td align=justify width=8%><b>Data</b> </td>";
	$msg_site .= "<td align=justify width=10%><b>Resultado</b></td>";
	$msg_site .= "<td align=justify width=15%><b>Exames</b></td>";
	$msg_site .= "<td align=justify width=8%><b>Data</b> </td>";
	$msg_site .= "<td align=justify width=10%><b>Resultado</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=15%><b>Eritrograma</b></td>";
	$msg_site .= "<td align=justify width=8%></td>";
	$msg_site .= "<td align=justify width=10%></td>";
	$msg_site .= "<td align=justify width=15%><b>Urina - EAS</b></td>";
	$msg_site .= "<td align=justify width=8%></td>";
	$msg_site .= "<td align=justify width=10%></td>";
	$msg_site .= "<td align=justify width=15%><b>Oftalmologico</b></td>";
	$msg_site .= "<td align=justify width=8%></td>";
	$msg_site .= "<td align=justify width=10%></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=15%><b>Leucograma</b></td>";
	$msg_site .= "<td align=justify width=8%></td>";
	$msg_site .= "<td align=justify width=10%></td>";
	$msg_site .= "<td align=justify width=15%><b>Fezes</b></td>";
	$msg_site .= "<td align=justify width=8%></td>";
	$msg_site .= "<td align=justify width=10%></td>";
	$msg_site .= "<td align=justify width=15%><b>Grupo Sanguinio</b></td>";
	$msg_site .= "<td align=justify width=8%></td>";
	$msg_site .= "<td align=justify width=10%></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=15%><b>Plaquetas</b></td>";
	$msg_site .= "<td align=justify width=8%></td>";
	$msg_site .= "<td align=justify width=10%></td>";
	$msg_site .= "<td align=justify width=15%><b>RX Torax</b></td>";
	$msg_site .= "<td align=justify width=8%></td>";
	$msg_site .= "<td align=justify width=10%></td>";
	$msg_site .= "<td align=justify width=15%><b>Fator RH</b></td>";
	$msg_site .= "<td align=justify width=8%></td>";
	$msg_site .= "<td align=justify width=10%></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=15%><b>VDRL</b></td>";
	$msg_site .= "<td align=justify width=8%></td>";
	$msg_site .= "<td align=justify width=10%></td>";
	$msg_site .= "<td align=justify width=15%><b>Audiometria</b></td>";
	$msg_site .= "<td align=justify width=8%></td>";
	$msg_site .= "<td align=justify width=10%></td>";
	$msg_site .= "<td align=justify width=15%></td>";
	$msg_site .= "<td align=justify width=8%></td>";
	$msg_site .= "<td align=justify width=10%></td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table><br>";
	
	$msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify>Assino como prova de ter declarado a verdade: ________________________________, ____/____/________</td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table><br><br><br>";
	
	$msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=center width=50%>_____________________________________________________________</td>";
	$msg_site .= "<td align=center width=50%>_____________________________________________________________</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=center width=50%>Assinatura do Candidato</td>";
	$msg_site .= "<td align=center width=50%>Assinatura do Examinador</td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table>";

	}
}

    $msg_site .= "</body>";
    $msg_site .= "</html>";


ob_end_clean();

/*****************************************************************************************************************/
// -> OUTPUT
/*****************************************************************************************************************/
//$html = ob_get_clean();
//$html = utf8_encode($html);

//$mpdf = new mPDF('pt','A4',3,'',8,8,5,14,9,9,'P');
//class mPDF ([ string $msg_clientepage [, mixed $format [, float $default_font_size [, string $default_font [, float $margin_left , float $margin_right , float $margin_top , float $margin_bottom , float $margin_header , float $margin_footer [, string $orientation ]]]]]])
$mpdf = new mPDF('pt', 'A4', 12, 'verdana', 8, 8, 0, 0, 0, 0, 'P'); //P: DEFAULT Portrait L: Landscape
//$mpdf->allow_charset_conversion=true;
$mpdf->charset_in='iso-8859-1';
$mpdf->SetDisplayMode('fullpage');
//$mpdf->SetFooter('{DATE j/m/Y&nbsp; H:i}|{PAGENO}/{nb}|SEDUC / SIGETI');
$mpdf->SetHTMLHeader($cabecalho);
$mpdf->SetHTMLFooter($rodape);

//carregar folha de estilos
$stylesheet = file_get_contents('../../common/css/pdf.css');
//incorporar folha de estilos ao documento
$mpdf->WriteHTML($stylesheet,1);

// incorpora o corpo ao PDF na posição 2 e deverá ser interpretado como footage. Todo footage é posicao 2 ou 0(padrão).
$mpdf->WriteHTML($msg_site);
//void WriteHTML ( string $html [, int $mode [, boolean $initialise  [, boolean $close ]]])
//MODE Values
//0 - Parses a whole html document
//1 - Parses the html as styles and stylesheets only
//2 - Parses the html as output elements only
//3 - (For internal use only - parses the html code without writing to document)
//4 - (For internal use only - writes the html code to a buffer)
//DEFAULT: 0

//nome do arquivo de saida PDF
$arquivo = "orc_aso".$orc.".pdf";

//gera o relatorio
$mpdf->Output($arquivo,'I');
/*
I: send the file inline to the browser. The plug-in is used if available. The name given by filename is used when one selects the "Save as" option on the link generating the PDF.
D: send to the browser and force a file download with the name given by filename.
F: save to a local file with the name given by filename (may include a path).
S: return the document as a string. filename is ignored.
*/
exit();
?>