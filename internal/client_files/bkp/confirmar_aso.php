<?PHP
/*****************************************************************************************************************/
// -> INCLUDES / DEFINES
/*****************************************************************************************************************/
define('_MPDF_PATH', '../../common/MPDF45/');
define('_IMG_PATH', '../../images/');
include(_MPDF_PATH.'mpdf.php');
include("../../common/includes/database.php");
include("../../common/includes/functions.php");

/*****************************************************************************************************************/
// -> VARS
/*****************************************************************************************************************/
$msg_site = "";
$msg_cliente = "";
$msg_medico = "";
$msg_clinica = "";
$msg_financeiro = "";
$header_h = 75;//header height;
$footer_h = 75;//footer height;

function coloca_zeros($numero){
   return str_pad($numero, 4, "0", STR_PAD_LEFT);
}

$data1 = $_GET[data_agendamento];
$d = explode("/",$data1);
$data1 = $d[2]."/".$d[1]."/".$d[0];

		 if ($_GET['tp'] == 1) $tipo_exame = "Admissional";
		 if ($_GET['tp'] == 2) $tipo_exame = "Demissional";
		 if ($_GET['tp'] == 3) $tipo_exame = "Periódico";
		 if ($_GET['tp'] == 4) $tipo_exame = "Mudança de função";
		 if ($_GET['tp'] == 5) $tipo_exame = "Retorno ao trabalho";

/*ACRESCENTAR UM ASO*/
$query_max = "SELECT max(cod_aso) as cod_aso FROM aso";
$result_max = pg_query($query_max);
$row_max = pg_fetch_array($result_max);
$cod_aso = $row_max[cod_aso] + 1;
$query_insert = "INSERT INTO aso (cod_aso, cod_cliente, cod_setor, aso_data, cod_func, tipo_exame, cod_clinica)
				VALUES ({$cod_aso}, {$_GET[cliente]}, {$_GET[set]}, '$data_agendamento', {$_GET[col]}, '$tipo_exame', {$_GET[cl]})";
$reresult_insert = pg_query($query_insert);

//RECEBE LISTA DE EXAMES
$exames = unserialize(stripslashes($_GET['ex']));//ARRAY COM EXAMES PASSADOS COM POST
$fix = "";
for($x=0;$x<count($exames);$x++){
$in = "INSERT INTO aso_exame (cod_aso, cod_exame, data, confirma) VALUES ({$cod_aso}, {$exames[$x]}, '$data_agendamento', 0)";
$inn = pg_query($in);
	$fix .= "ce.cod_exame = {$exames[$x]}";
	if($x < count($exames)-1){
		$fix.=" OR ";
	}
}

//SELECIONA PRECO DOS EXAMES
$sql = "SELECT ce.*, e.* FROM clinica_exame ce, exame e
		WHERE ce.cod_clinica={$_GET['cl']} AND ce.cod_exame = e.cod_exame AND ($fix)";
$r = pg_query($sql);
$data = pg_fetch_all($r);

$valor_total = 0;
$valor_desc = "";
for($x=0;$x<pg_num_rows($r);$x++){
	$valor_desc .= "".$data[$x]['especialidade']." - R$ ".number_format(($data[$x]['preco_exame']/*+(($data[$x]['preco_exame']*20)/100)*/),2,',','.');
	$valor_desc .= "<br>";

	$valor_total+=$data[$x]['preco_exame'];//+(($data[$x]['preco_exame']*20)/100);
	
	$cod_exames .= "{$data[$x][cod_exame]}";
	$tipo_exames .= "{$data[$x]['especialidade']}";
	if($x < count($data)-1){
	   $tipo_exames .= ", ";
	}
}
 
$sql = "SELECT f.*, fe.exame_id, fe.descricao, fun.nome_funcao, fun.dsc_funcao
FROM funcionarios f, funcao_exame fe, funcao fun
WHERE f.cod_cliente = '".$_GET['cliente']."' AND f.cod_func = {$_GET['col']} AND f.cod_funcao = fe.cod_exame
AND fun.cod_funcao = fe.cod_exame AND f.cod_setor = {$_GET[set]}";
$rss = pg_query($sql);
$funcionario = pg_fetch_all($rss);

$sql = "SELECT * FROM clinicas WHERE cod_clinica = {$_GET['cl']}";
$result = pg_query($sql);
$clinica = pg_fetch_array($result);

$sql = "SELECT * FROM cliente WHERE cliente_id = ".$_GET['cliente'];
$r = pg_query($sql);
$cliente = pg_fetch_array($r);

$sql = "SELECT * FROM exame WHERE cod_exame = 10 or cod_exame = 11";
$rr = pg_query($sql);
$ee = pg_fetch_all($rr);

/*********************************************************************************************/
$exam = "";
$hoje = date("Y/m/d");
$data_agendamento = $_GET[data_agendamento];
$sql = "SELECT * FROM site_aso_agendamento WHERE cod_cliente=".$_GET['cliente']." AND cod_funcionario={$_GET['col']} 
AND data_agendamento='{$data_agendamento}'";
$resu = pg_query($sql);
$count = pg_num_rows($resu);

if($count <= 0){
	for($x=0;$x<count($data);$x++){
		$exam = "{$data[$x]['cod_exame']}";
	    $sql = "INSERT INTO site_aso_agendamento
	    (cod_cliente, cod_filial, cod_funcionario, cod_clinica, exames, valor, data_agendamento, cod_aso)
	    VALUES
	    ('".$_GET['cliente']."', '1', '{$_GET['col']}', '{$_GET['cl']}', '{$exam}', '$valor_total', '$data_agendamento', '$cod_aso')";
	    pg_query($sql);
	}
}

$sql = "SELECT * FROM site_aso_agendamento WHERE cod_cliente=".$_GET['cliente']." AND cod_funcionario={$_GET['col']} 
AND data_agendamento='{$data_agendamento}'";
$resu2 = pg_query($sql);
$count2 = pg_fetch_all($resu2);

/*****************************************************************************************************************/
// -> BEGIN DOCUMENT
/*****************************************************************************************************************/
ob_start();
    /*************************************************************************************************************/
    // -> HEADER
    /*************************************************************************************************************/
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
    $msg_site .= "<html>";
    $msg_site .= "<head>";
    $msg_site .= "</head>";
    $msg_site .= "<body>";
    
/****************************************************************************************************************/
// -> PAGE [1]
/****************************************************************************************************************/
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=center><b>ENCAMINHAMENTO MÉDICO COMPLEMENTAR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nº ".$cod_aso."</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table><p><br><p>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify><b>Clínica:</b> {$clinica['razao_social_clinica']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=60%><b>Endereço:</b> {$clinica['endereco_clinica']}</td>";
	$msg_site .= "<td align=justify><b>Nº</b> {$clinica['num_end']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=40%><b>CEP:</b>  {$clinica['cep_clinica']}</td>";
	$msg_site .= "<td align=justify ><b>Bairro:</b> {$clinica['bairro_clinica']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify><b>Ponto de Referência:</b> {$clinica['referencia_clinica']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table><br>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Assunto:</b> Atendimento para ASO $tipo_exame</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Encaminhado:</b> {$funcionario[0]['nome_func']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=60%><b>Função:</b> {$funcionario[0]['nome_funcao']}</td>";
	$msg_site .= "<td align=justify width=20%><b>CTPS:</b> {$funcionario[0]['num_ctps_func']}</td>";
	$msg_site .= "<td align=justify width=20%><b>Série:</b> {$funcionario[0]['serie_ctps_func']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Exames a serem realizados:</b> $tipo_exames</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table><br>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>CNPJ:</b> {$cliente['cnpj']}</td>";
    $msg_site .= "<td align=justify width=70%><b>Empresa Solicitante:</b> {$cliente['razao_social']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table><br>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Contato:</b> {$cliente['telefone']}</td>";
	$msg_site .= "<td align=justify width=70%><b>Resp. Solicitante</b> {$cliente['nome_contato_dir']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table><br>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=100%><b>Resp. Solicitante</b> {$cliente['endereco']}, {$cliente['bairro']}, {$cliente['municipio']}, {$cliente['estado']} - CEP: {$cliente['cep']}</td>";
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
/****************************************************************************************************************/
// -> PAGE [2]
/****************************************************************************************************************/
	$msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=center colspan=5><b>SESMT - Serviços Especializados de Segurança de Monitoramento de Atividades no Trabalho LTDA</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=4></td>";
    $msg_site .= "<td align=justify><b>Prontuário Médico:</b> $cod_aso</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=5><b>Clínica:</b> {$clinica['razao_social_clinica']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=5><b>Empresa:</b> {$cliente['razao_social']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=5><b>Nome:</b> {$funcionario[0]['nome_func']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=2 width=40%><b>Função Atual:</b> {$funcionario[0]['nome_funcao']}</td>";
	$msg_site .= "<td align=justify colspan=2 width=40%><b>Função Anterior:</b> </td>";
	$msg_site .= "<td align=justify width=20%><b>RG:</b> {$funcionario[0]['rg']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=20%><b>Sexo:</b> {$funcionario[0]['sexo_func']}</td>";
	$msg_site .= "<td align=justify width=20%><b>Est. Civil:</b> </td>";
	$msg_site .= "<td align=justify width=20%><b>Cor:</b> </td>";
	$msg_site .= "<td align=justify width=20%><b>Nasc.:</b> </td>";
	$msg_site .= "<td align=justify width=20%><b>Natural:</b> </td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=5><b>Endereço:</b> {$funcionario[0]['endereco_func']}</td>";
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
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=3><b>Obs: ____________________________________________________________________________________________________________________________________________</b></td>";
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
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=2><b>Obs: ____________________________________________________________________________________________________________________________________________</b></td>";
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
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=4><b>Obs: ____________________________________________________________________________________________________________________________________________</b></td>";
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
    $msg_site .= "</table><br>";
	
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
	
    $msg_site .= "</body>";
    $msg_site .= "</html>";

/****************************************************************************************************************/
// -> PAGE [1]
/****************************************************************************************************************/
    $msg_cliente .= "<html>";
    $msg_cliente .= "<head>";
    $msg_cliente .= "</head>";
    $msg_cliente .= "<body>";

	$msg_cliente .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
	$msg_cliente .= "<tr>";
	$msg_cliente .= "<td align=left height=$header_h valign=top width=270><img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt.png\" width='270' height='135'></td>";
	$msg_cliente .= "<td align=center height=$header_h valign=top class='medText'>Serviços Especializados de Segurança e<br>Monitoramento de Atividades no Trabalho<p>Assistência em Segurança e Higiene no Trabalho</td>";
	$msg_cliente .= "</tr>";
	$msg_cliente .= "</table>";

	$msg_cliente .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=center><b>ENCAMINHAMENTO MÉDICO COMPLEMENTAR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nº ".$cod_aso."</b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "</table><p><br><p>";
	
	$msg_cliente .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify><b>Clínica:</b> {$clinica['razao_social_clinica']}</td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "</table>";
	
	$msg_cliente .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=60%><b>Endereço:</b> {$clinica['endereco_clinica']}</td>";
	$msg_cliente .= "<td align=justify><b>Nº</b> {$clinica['num_end']}</td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "</table>";
	
	$msg_cliente .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=40%><b>CEP:</b>  {$clinica['cep_clinica']}</td>";
	$msg_cliente .= "<td align=justify ><b>Bairro:</b> {$clinica['bairro_clinica']}</td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "</table>";
	
	$msg_cliente .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify><b>Ponto de Referência:</b> {$clinica['referencia_clinica']}</td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "</table><br>";
	
	$msg_cliente .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=30%><b>Assunto:</b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "</table>";
	
	$msg_cliente .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=30%><b>Encaminhado:</b> {$funcionario[0]['nome_func']}</td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "</table>";
	
	$msg_cliente .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=60%><b>Função:</b> {$funcionario[0]['nome_funcao']}</td>";
	$msg_cliente .= "<td align=justify width=20%><b>CTPS:</b> {$funcionario[0]['num_ctps_func']}</td>";
	$msg_cliente .= "<td align=justify width=20%><b>Série:</b> {$funcionario[0]['serie_ctps_func']}</td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "</table>";
	
	$msg_cliente .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=30%><b>Tipo dos Exames:</b> $tipo_exames</td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "</table><br>";
	
	$msg_cliente .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=30%><b>Assunto:</b> Atendimento para {$_GET[tp]}</td>";
    $msg_cliente .= "</tr>";
    $msg_cliente .= "</table>";
	
	$msg_cliente .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=30%><b>Empresa Solicitante:</b> {$cliente['razao_social']}</td>";
    $msg_cliente .= "</tr>";
    $msg_cliente .= "</table>";
	
	$msg_cliente .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=50%><b>CNPJ:</b> {$cliente['cnpj']}</td>";
	$msg_cliente .= "<td align=justify width=50%><b>Resp. Solicitante:</b> {$cliente['nome_contato_dir']}</td>";
    $msg_cliente .= "</tr>";
    $msg_cliente .= "</table><br>";
	
	$msg_cliente .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=30%><b>Horário:</b> Ordem de Chegada de Segunda a Sexta</td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=30%><b>Horário Término para atendimento Laboratorial:</b> 11h00min</td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=30%><b>Horário Término para atendimento Geral:</b> 15h00min</td>";
    $msg_cliente .= "</tr>";
    $msg_cliente .= "</table><br>";
	
	for($y=0;$y<pg_num_rows($rr);$y++){
		if($ee[$y][cod_exame] == '10' ){
		$msg_cliente .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
		$msg_cliente .= "<tr>";
		$msg_cliente .= "<td align=justify width=30%>EAS - Fazer uma higiene íntima rigorosa em sua casa, usando sabonete e água, enxaguar bem com água abundante e secar bem com uma toalha limpa; Coletar a primeira urina da manhã ou 2 horas após a última micção; Desprezar o primeiro jato da urina no vaso sanitário e coletar no copo descartável o jato do meio, mais ou menos (até a metade do copo) desprezando o restante da micção no vaso sanitário; Imediatamente, passar a urina do copo para o tubo, até preencher totalmente, fechar e muito bem e identificar com seu nome completo.</td>";
		$msg_cliente .= "</tr>";
		$msg_cliente .= "</table><br>";
		}
		
		if($ee[$y][cod_exame] == 11 ){
		$msg_cliente .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
		$msg_cliente .= "<tr>";
		$msg_cliente .= "<td align=justify width=30%>EPF - Colher as fezes diretamente no frasco ou sobre um papel ou plástico e transferir para o pote, este procedimento de preferência no período da manhã e depois de coletar (pequena porção) levar para o local do exame, caso não seja possível, acondicionar o pote em um saco plástico e manter refrigerado.</td>";
		$msg_cliente .= "</tr>";
		$msg_cliente .= "</table><br>";
		}
	}
	
	$msg_cliente .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=30%><b>OBS: O não comparecimento do candidato e/ou a não realização de algum procedimento ora agendado e não cumprido pelo solicitante não anulará a cobrança do mesmo, ficando o crédito para esse mesmo candidato se submeter em outra data.</b></td>";
    $msg_cliente .= "</tr>";
    $msg_cliente .= "</table>";
	
	$msg_cliente .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$footer_h>";
	$msg_cliente .= "<tr>";
	$msg_cliente .= "<td align=left height=$footer_h valign=bottom class='medText'>Telefone: +55 (21) 3014 4304      Fax: Ramal 7<br>Nextel: +55 (21) 7844 6095 / Id 55*23*31641<br>medicotrab@sesmt-rio.com<br>www.sesmt-rio.com / www.shoppingsesmt.com</td>";
	$msg_cliente .= "<td align=right height=$footer_h width=207 valign=bottom><img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt2.png\" width=207 height=135></td>";
	$msg_cliente .= "</tr>";
	$msg_cliente .= "</table>";
    $msg_cliente .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [2]
/****************************************************************************************************************/
	$msg_cliente .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
	$msg_cliente .= "<tr>";
	$msg_cliente .= "<td align=left height=$header_h valign=top width=270><img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt.png\" width='270' height='135'></td>";
	$msg_cliente .= "<td align=center height=$header_h valign=top class='medText'>Serviços Especializados de Segurança e<br>Monitoramento de Atividades no Trabalho<p>Assistência em Segurança e Higiene no Trabalho</td>";
	$msg_cliente .= "</tr>";
	$msg_cliente .= "</table>";
	
	$msg_cliente .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=center colspan=5><b>SESMT - Serviços Especializados de Segurança de Monitoramento de Atividades no Trabalho LTDA<p>Prontuário Médico</b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify colspan=5><b>Empresa:</b> {$cliente['razao_social']}</td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify colspan=5><b>Nome:</b> {$funcionario[0]['nome_func']}</td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify colspan=2 width=40%><b>Função Atual:</b> {$funcionario[0]['nome_funcao']}</td>";
	$msg_cliente .= "<td align=justify colspan=2 width=40%><b>Função Anterior:</b> </td>";
	$msg_cliente .= "<td align=justify width=20%><b>RG:</b> {$funcionario[0]['rg']}</td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=20%><b>Sexo:</b> {$funcionario[0]['sexo_func']}</td>";
	$msg_cliente .= "<td align=justify width=20%><b>Est. Civil:</b> </td>";
	$msg_cliente .= "<td align=justify width=20%><b>Cor:</b> </td>";	
	$msg_cliente .= "<td align=justify width=20%><b>Nasc.:</b> </td>";
	$msg_cliente .= "<td align=justify width=20%><b>Natural:</b> </td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify colspan=5><b>Endereço:</b> {$funcionario[0]['endereco_func']}</td>";
    $msg_cliente .= "</tr>";
    $msg_cliente .= "</table>";
	
	$msg_cliente .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify colspan=2><b>Antecedentes Familiares:&nbsp;&nbsp;&nbsp;Parentesco</b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=50%><b>&bull; Tuberculose/Diabete/Câncer ______________________________________</b></td>";
	$msg_cliente .= "<td align=justify width=50%><b>&bull; Asma/Alergias/Urticária __________________________________________</b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=50%><b>&bull; Doença do Coração/Pressão Alta _________________________________</b></td>";
	$msg_cliente .= "<td align=justify width=50%><b>&bull; Doença Mental/Nervosa __________________________________________</b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify colspan=2><b>&bull; Outras _______________________________________________________________________________________________________________________________________</b></td>";
    $msg_cliente .= "</tr>";
    $msg_cliente .= "</table>";
	
	$msg_cliente .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify colspan=2><b>Antecedentes Pessoais</b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=33%><b>&bull; Doença do Coração/Pressão Alta ( )</b></td>";
	$msg_cliente .= "<td align=justify width=33%><b>&bull; Enxerga Bem ( )</b></td>";
	$msg_cliente .= "<td align=justify width=33%><b>&bull; Varizes/Varicocele/Hérnias ( )</b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=33%><b>&bull; Dor no Peito/Palpitação ( )</b></td>";
	$msg_cliente .= "<td align=justify width=33%><b>&bull; Ouve Bem/Otite/Zumbido ( )</b></td>";
	$msg_cliente .= "<td align=justify width=33%><b>&bull; Hemorróidas/Diarréia Frequente ( )</b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=33%><b>&bull; Bronquite/Asma/Rinite ( )</b></td>";
	$msg_cliente .= "<td align=justify width=33%><b>&bull; Já teve internado ( )</b></td>";
	$msg_cliente .= "<td align=justify width=33%><b>&bull; Sofreu doença não mencionada ( )</b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=33%><b>&bull; Doenças Coluna/Dor nas Costas ( )</b></td>";
	$msg_cliente .= "<td align=justify width=33%><b>&bull; Encontra-se grávida ( )</b></td>";
	$msg_cliente .= "<td align=justify width=33%><b>&bull; Pode executar tarefas pesadas ( )</b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=33%><b>&bull; Doenças Renais(Rins) ( )</b></td>";
	$msg_cliente .= "<td align=justify width=33%><b>&bull; Doença Mental/Nervosa ( )</b></td>";
	$msg_cliente .= "<td align=justify width=33%><b>&bull; Tem alguma deficiência ( )</b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=33%><b>&bull; Doença do Fígado/Diabetes ( )</b></td>";
	$msg_cliente .= "<td align=justify width=33%><b>&bull; Dor de Cabeça/Tonturas/Convulsões ( )</b></td>";
	$msg_cliente .= "<td align=justify width=33%><b>&bull; Sofreu alguma cirurgia ( )</b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=33%><b>&bull; Úlcera/Gastrite ( )</b></td>";
	$msg_cliente .= "<td align=justify width=33%><b>&bull; Alergia/Doença de Pele ( )</b></td>";
	$msg_cliente .= "<td align=justify width=33%><b>&bull; Tabagismo(Fumo)/Etilismo(Bebe) ( )</b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=33%><b>&bull; Resfriado/Tosse Crônica/Sinusite ( )</b></td>";
	$msg_cliente .= "<td align=justify width=33%><b>&bull; Reumatismo/Dor nas Juntas ( )</b></td>";
	$msg_cliente .= "<td align=justify width=33%><b> </b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify colspan=3><b>Obs: ____________________________________________________________________________________________________________________________________________</b></td>";
    $msg_cliente .= "</tr>";
    $msg_cliente .= "</table><br>";

	$msg_cliente .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify colspan=2><b>Antecedentes Ocupacionais</b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
	$msg_cliente .= "<td align=justify width=50%><b>&bull; Suas condições de saúde exige trabalho especial ( )</b></td>";
	$msg_cliente .= "<td align=justify width=50%><b>&bull; Recebeu indenização por acidente de trabalho ( )</b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
	$msg_cliente .= "<td align=justify width=50%><b>&bull; Perdeu dias de trabalho por motivos de saúde ( )</b></td>";
	$msg_cliente .= "<td align=justify width=50%><b>&bull; Esteve doente devido seu trabalho ( )</b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
	$msg_cliente .= "<td align=justify width=50%><b>&bull; Esteve afastado pelo I.N.P.S. ( )</b></td>";
	$msg_cliente .= "<td align=justify width=50%><b> </b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify colspan=2><b>Anotações(tratamentos-remédios): _________________________________________________________________________________________________________</b></td>";
    $msg_cliente .= "</tr>";
    $msg_cliente .= "</table><br>";
	
	$msg_cliente .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify colspan=4><b>Exame Físico</b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
	$msg_cliente .= "<td align=justify width=25%><b>Cabeça</b></td>";
	$msg_cliente .= "<td align=justify width=25%><b>Pescoço</b></td>";
	$msg_cliente .= "<td align=justify width=25%><b>Tórax</b></td>";
	$msg_cliente .= "<td align=justify width=25%><b>Abdome</b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
	$msg_cliente .= "<td align=justify width=25%>Boca/Dente: ______________</td>";
	$msg_cliente .= "<td align=justify width=25%>Faringe: _______________</td>";
	$msg_cliente .= "<td align=justify width=25%>Coração: _______________</td>";
	$msg_cliente .= "<td align=justify width=25%>Hérnias: _______________</td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
	$msg_cliente .= "<td align=justify width=25%>Nariz: _______________</td>";
	$msg_cliente .= "<td align=justify width=25%>Amídalas: _______________</td>";
	$msg_cliente .= "<td align=justify width=25%>Pulmões: _______________</td>";
	$msg_cliente .= "<td align=justify width=25%>Anéis: _______________</td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
	$msg_cliente .= "<td align=justify width=25%>Língua: _______________</td>";
	$msg_cliente .= "<td align=justify width=25%>Laringe: _______________</td>";
	$msg_cliente .= "<td align=justify width=25%><b></b></td>";
	$msg_cliente .= "<td align=justify width=25%><b></b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
	$msg_cliente .= "<td align=justify width=25%>Ouvidos: _______________</td>";
	$msg_cliente .= "<td align=justify width=25%>Tireóide: _______________</td>";
	$msg_cliente .= "<td align=justify width=25%><b></b></td>";
	$msg_cliente .= "<td align=justify width=25%><b></b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
	$msg_cliente .= "<td align=justify width=25%><b>Genital</b></td>";
	$msg_cliente .= "<td align=justify width=25%><b>Membros</b></td>";
	$msg_cliente .= "<td align=justify width=25%><b></b></td>";
	$msg_cliente .= "<td align=justify width=25%><b></b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
	$msg_cliente .= "<td align=justify width=25%>Varicocele: _______________</td>";
	$msg_cliente .= "<td align=justify width=25%>Isquemia: _______________</td>";
	$msg_cliente .= "<td align=justify width=25%>Pé Plano: _______________</td>";
	$msg_cliente .= "<td align=justify width=25%><b>Pressão Arterial: _______________</b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
	$msg_cliente .= "<td align=justify width=25%>Hidroxila: _______________</td>";
	$msg_cliente .= "<td align=justify width=25%>Edemas: _______________</td>";
	$msg_cliente .= "<td align=justify width=25%>Pele/Mucosa: _______________</td>";
	$msg_cliente .= "<td align=justify width=25%><b>Pulso: _______________</b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
	$msg_cliente .= "<td align=justify width=25%>D.U.M.: _______________</td>";
	$msg_cliente .= "<td align=justify width=25%>Má Formação: _______________</td>";
	$msg_cliente .= "<td align=justify width=25%>Coluna Vertebral: _______________</td>";
	$msg_cliente .= "<td align=justify width=25%><b>Altura: _______________</b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
	$msg_cliente .= "<td align=justify width=25%>Corrimentos: _______________</td>";
	$msg_cliente .= "<td align=justify width=25%>Calos: _______________</td>";
	$msg_cliente .= "<td align=justify width=25%>Varizes: _______________</td>";
	$msg_cliente .= "<td align=justify width=25%><b>Peso: _______________</b></td>";
    $msg_cliente .= "</tr>";
    $msg_cliente .= "</table><br>";
	
	$msg_cliente .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify ><b>Exames Complementares</b></td>";
    $msg_cliente .= "</tr>";
    $msg_cliente .= "</table>";
	
	$msg_cliente .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=15%><b>Exames</b></td>";
	$msg_cliente .= "<td align=justify width=8%><b>Data</b> </td>";
	$msg_cliente .= "<td align=justify width=10%><b>Resultado</b></td>";
	$msg_cliente .= "<td align=justify width=15%><b>Exames</b></td>";
	$msg_cliente .= "<td align=justify width=8%><b>Data</b> </td>";
	$msg_cliente .= "<td align=justify width=10%><b>Resultado</b></td>";
	$msg_cliente .= "<td align=justify width=15%><b>Exames</b></td>";
	$msg_cliente .= "<td align=justify width=8%><b>Data</b> </td>";
	$msg_cliente .= "<td align=justify width=10%><b>Resultado</b></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=15%><b>Eritrograma</b></td>";
	$msg_cliente .= "<td align=justify width=8%></td>";
	$msg_cliente .= "<td align=justify width=10%></td>";
	$msg_cliente .= "<td align=justify width=15%><b>Urina - EAS</b></td>";
	$msg_cliente .= "<td align=justify width=8%></td>";
	$msg_cliente .= "<td align=justify width=10%></td>";
	$msg_cliente .= "<td align=justify width=15%><b>Oftalmologico</b></td>";
	$msg_cliente .= "<td align=justify width=8%></td>";
	$msg_cliente .= "<td align=justify width=10%></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=15%><b>Leucograma</b></td>";
	$msg_cliente .= "<td align=justify width=8%></td>";
	$msg_cliente .= "<td align=justify width=10%></td>";
	$msg_cliente .= "<td align=justify width=15%><b>Fezes</b></td>";
	$msg_cliente .= "<td align=justify width=8%></td>";
	$msg_cliente .= "<td align=justify width=10%></td>";
	$msg_cliente .= "<td align=justify width=15%><b>Grupo Sanguinio</b></td>";
	$msg_cliente .= "<td align=justify width=8%></td>";
	$msg_cliente .= "<td align=justify width=10%></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=15%><b>Plaquetas</b></td>";
	$msg_cliente .= "<td align=justify width=8%></td>";
	$msg_cliente .= "<td align=justify width=10%></td>";
	$msg_cliente .= "<td align=justify width=15%><b>RX Torax</b></td>";
	$msg_cliente .= "<td align=justify width=8%></td>";
	$msg_cliente .= "<td align=justify width=10%></td>";
	$msg_cliente .= "<td align=justify width=15%><b>Fator RH</b></td>";
	$msg_cliente .= "<td align=justify width=8%></td>";
	$msg_cliente .= "<td align=justify width=10%></td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify width=15%><b>VDRL</b></td>";
	$msg_cliente .= "<td align=justify width=8%></td>";
	$msg_cliente .= "<td align=justify width=10%></td>";
	$msg_cliente .= "<td align=justify width=15%><b>Audiometria</b></td>";
	$msg_cliente .= "<td align=justify width=8%></td>";
	$msg_cliente .= "<td align=justify width=10%></td>";
	$msg_cliente .= "<td align=justify width=15%></td>";
	$msg_cliente .= "<td align=justify width=8%></td>";
	$msg_cliente .= "<td align=justify width=10%></td>";
    $msg_cliente .= "</tr>";
    $msg_cliente .= "</table><br>";
	
	$msg_cliente .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=justify>Assino como prova de ter declarado a verdade: ________________________________, ____/____/________</td>";
    $msg_cliente .= "</tr>";
    $msg_cliente .= "</table><br>";
	
	$msg_cliente .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=center width=50%>_____________________________________________________________</td>";
	$msg_cliente .= "<td align=center width=50%>_____________________________________________________________</td>";
    $msg_cliente .= "</tr>";
	$msg_cliente .= "<tr>";
    $msg_cliente .= "<td align=center width=50%>Assinatura do Candidato</td>";
	$msg_cliente .= "<td align=center width=50%>Assinatura do Examinador</td>";
    $msg_cliente .= "</tr>";
    $msg_cliente .= "</table>";
	
	$msg_cliente .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$footer_h>";
	$msg_cliente .= "<tr>";
	$msg_cliente .= "<td align=left height=$footer_h valign=bottom class='medText'>Telefone: +55 (21) 3014 4304      Fax: Ramal 7<br>Nextel: +55 (21) 7844 6095 / Id 55*23*31641<br>medicotrab@sesmt-rio.com<br>www.sesmt-rio.com / www.shoppingsesmt.com</td>";
	$msg_cliente .= "<td align=right height=$footer_h width=207 valign=bottom><img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt2.png\" width=207 height=135></td>";
	$msg_cliente .= "</tr>";
	$msg_cliente .= "</table>";
	
    $msg_cliente .= "</body>";
    $msg_cliente .= "</html>";

/************************************************************************************************/
//MENSAGEM PARA MÉDICOS
/************************************************************************************************/
	$msg_medico .= "<html>";
    $msg_medico .= "<head>";
    $msg_medico .= "</head>";
    $msg_medico .= "<body>";
	
	$msg_medico .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
	$msg_medico .= "<tr>";
	$msg_medico .= "<td align=left height=$header_h valign=top width=270><img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt.png\" width='270' height='135'></td>";
	$msg_medico .= "<td align=center height=$header_h valign=top class='medText'>Serviços Especializados de Segurança e<br>Monitoramento de Atividades no Trabalho<p>Assistência em Segurança e Higiene no Trabalho</td>";
	$msg_medico .= "</tr>";
	$msg_medico .= "</table>";

	$msg_medico .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_medico .= "<tr>";
    $msg_medico .= "<td align=center><b>CONFIRMAÇÃO DE AGENDAMENTO MÉDICO COMPLEMENTAR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nº ".str_pad($count2[0]['id'], 4,"0",STR_PAD_LEFT)."</b></td>";
    $msg_medico .= "</tr>";
	$msg_medico .= "</table><p><br><p>";
	
	$msg_medico .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
	$msg_medico .= "<tr>";
    $msg_medico .= "<td align=justify><b>Empresa Solicitante:</b> {$cliente['razao_social']}</td>";
    $msg_medico .= "</tr>";
	$msg_medico .= "</table><br>";
	
	$msg_medico .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_medico .= "<tr>";
    $msg_medico .= "<td align=justify width=60%><b>CNPJ:</b> {$cliente['cnpj']}</td>";
	$msg_medico .= "<td align=justify><b>Resp. Solicitante</b> {$cliente['nome_contato_dir']}</td>";
    $msg_medico .= "</tr>";
	$msg_medico .= "</table><br>";
	
	$msg_medico .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_medico .= "<tr>";
    $msg_medico .= "<td align=justify width=30%><b>Horário:</b> Ordem de Chegada de Segunda a Sexta</td>";
    $msg_medico .= "</tr>";
	$msg_medico .= "<tr>";
    $msg_medico .= "<td align=justify width=30%><b>Horário Término para atendimento Laboratorial:</b> 11h00min</td>";
    $msg_medico .= "</tr>";
	$msg_medico .= "<tr>";
    $msg_medico .= "<td align=justify width=30%><b>Horário Término para atendimento Geral:</b> 15h00min</td>";
    $msg_medico .= "</tr>";
    $msg_medico .= "</table><br>";
	
	$msg_medico .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_medico .= "<tr>";
    $msg_medico .= "<td align=justify width=30%><b>Assunto:</b></td>";
    $msg_medico .= "</tr>";
	$msg_medico .= "</table>";
	
	$msg_medico .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_medico .= "<tr>";
    $msg_medico .= "<td align=justify width=30%><b>Encaminhado:</b> {$funcionario[0]['nome_func']}</td>";
    $msg_medico .= "</tr>";
	$msg_medico .= "</table>";
	
	$msg_medico .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_medico .= "<tr>";
    $msg_medico .= "<td align=justify width=60%><b>Função:</b> {$funcionario[0]['nome_funcao']}</td>";
	$msg_medico .= "<td align=justify width=20%><b>CTPS:</b> {$funcionario[0]['num_ctps_func']}</td>";
	$msg_medico .= "<td align=justify width=20%><b>Série:</b> {$funcionario[0]['serie_ctps_func']}</td>";
    $msg_medico .= "</tr>";
	$msg_medico .= "</table>";
	
	$msg_medico .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_medico .= "<tr>";
    $msg_medico .= "<td align=justify width=30%><b>Tipo dos Exames:</b> $tipo_exames</td>";
    $msg_medico .= "</tr>";
	$msg_medico .= "</table><br>";
	
	$msg_medico .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_medico .= "<tr>";
    $msg_medico .= "<td align=justify width=30%><b>Assunto:</b> Atendimento para {$_GET[tp]}</td>";
    $msg_medico .= "</tr>";
    $msg_medico .= "</table><br>";
	
	$msg_medico .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_medico .= "<tr>";
    $msg_medico .= "<td align=justify><b>Ao recepcionar os exames complementares para prescrição do ASO, informar ao financeiro se todos estão acompanhados de suas anamneses.</b></td>";
    $msg_medico .= "</tr>";
    $msg_medico .= "</table>";
	
	$msg_medico .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$footer_h>";
	$msg_medico .= "<tr>";
	$msg_medico .= "<td align=left height=$footer_h valign=bottom class='medText'>Telefone: +55 (21) 3014 4304      Fax: Ramal 7<br>Nextel: +55 (21) 7844 6095 / Id 55*23*31641<br>medicotrab@sesmt-rio.com<br>www.sesmt-rio.com / www.shoppingsesmt.com</td>";
	$msg_medico .= "<td align=right height=$footer_h width=207 valign=bottom><img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt2.png\" width=207 height=135></td>";
	$msg_medico .= "</tr>";
	$msg_medico .= "</table>";

    $msg_medico .= "</body>";
    $msg_medico .= "</html>";

/************************************************************************************************/
//MENSAGEM PARA CLÍNICAS
/************************************************************************************************/
	$msg_clinica .= "<html>";
    $msg_clinica .= "<head>";
    $msg_clinica .= "</head>";
    $msg_clinica .= "<body>";
	
	$msg_clinica .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
	$msg_clinica .= "<tr>";
	$msg_clinica .= "<td align=left height=$header_h valign=top width=270><img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt.png\" width='270' height='135'></td>";
	$msg_clinica .= "<td align=center height=$header_h valign=top class='medText'>Serviços Especializados de Segurança e<br>Monitoramento de Atividades no Trabalho<p>Assistência em Segurança e Higiene no Trabalho</td>";
	$msg_clinica .= "</tr>";
	$msg_clinica .= "</table>";

	$msg_clinica .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_clinica .= "<tr>";
    $msg_clinica .= "<td align=center><b>CONFIRMAÇÃO DE AGENDAMENTO MÉDICO COMPLEMENTAR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nº ".str_pad($count2[0]['id'], 4,"0",STR_PAD_LEFT)."</b></td>";
    $msg_clinica .= "</tr>";
	$msg_clinica .= "</table><p><br><p>";
	
	$msg_clinica .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
	$msg_clinica .= "<tr>";
    $msg_clinica .= "<td align=justify><b>Empresa Solicitante:</b> {$cliente['razao_social']}</td>";
    $msg_clinica .= "</tr>";
	$msg_clinica .= "</table><br>";
	
	$msg_clinica .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_clinica .= "<tr>";
    $msg_clinica .= "<td align=justify width=60%><b>CNPJ:</b> {$cliente['cnpj']}</td>";
	$msg_clinica .= "<td align=justify><b>Resp. Solicitante</b> {$cliente['nome_contato_dir']}</td>";
    $msg_clinica .= "</tr>";
	$msg_clinica .= "</table><br>";
	
	$msg_clinica .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_clinica .= "<tr>";
    $msg_clinica .= "<td align=justify width=30%><b>Horário:</b> Ordem de Chegada de Segunda a Sexta</td>";
    $msg_clinica .= "</tr>";
	$msg_clinica .= "<tr>";
    $msg_clinica .= "<td align=justify width=30%><b>Horário Término para atendimento Laboratorial:</b> 11h00min</td>";
    $msg_clinica .= "</tr>";
	$msg_clinica .= "<tr>";
    $msg_clinica .= "<td align=justify width=30%><b>Horário Término para atendimento Geral:</b> 15h00min</td>";
    $msg_clinica .= "</tr>";
    $msg_clinica .= "</table><br>";
	
	$msg_clinica .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_clinica .= "<tr>";
    $msg_clinica .= "<td align=justify width=30%><b>Assunto:</b></td>";
    $msg_clinica .= "</tr>";
	$msg_clinica .= "</table>";
	
	$msg_clinica .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_clinica .= "<tr>";
    $msg_clinica .= "<td align=justify width=30%><b>Encaminhado:</b> {$funcionario[0]['nome_func']}</td>";
    $msg_clinica .= "</tr>";
	$msg_clinica .= "</table>";
	
	$msg_clinica .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_clinica .= "<tr>";
    $msg_clinica .= "<td align=justify width=60%><b>Função:</b> {$funcionario[0]['nome_funcao']}</td>";
	$msg_clinica .= "<td align=justify width=20%><b>CTPS:</b> {$funcionario[0]['num_ctps_func']}</td>";
	$msg_clinica .= "<td align=justify width=20%><b>Série:</b> {$funcionario[0]['serie_ctps_func']}</td>";
    $msg_clinica .= "</tr>";
	$msg_clinica .= "</table>";
	
	$msg_clinica .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_clinica .= "<tr>";
    $msg_clinica .= "<td align=justify width=30%><b>Tipo dos Exames:</b> $tipo_exames</td>";
    $msg_clinica .= "</tr>";
	$msg_clinica .= "</table><br>";
	
	$msg_clinica .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_clinica .= "<tr>";
    $msg_clinica .= "<td align=justify width=30%><b>Assunto:</b> Atendimento para {$_GET[tp]}</td>";
    $msg_clinica .= "</tr>";
    $msg_clinica .= "</table><br>";
	
	$msg_clinica .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_clinica .= "<tr>";
    $msg_clinica .= "<td align=justify><b>A anamnese segue junto ao paciente pré-preenchida ela deverá regressar a SESMT junto com os resultados dos exames, caso o resultado não contenha a anamnese a SESMT reserva-se no direito de efetuar o pagamento dos serviços prestados.</b></td>";
    $msg_clinica .= "</tr>";
    $msg_clinica .= "</table>";
	
	$msg_clinica .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$footer_h>";
	$msg_clinica .= "<tr>";
	$msg_clinica .= "<td align=left height=$footer_h valign=bottom class='medText'>Telefone: +55 (21) 3014 4304      Fax: Ramal 7<br>Nextel: +55 (21) 7844 6095 / Id 55*23*31641<br>medicotrab@sesmt-rio.com<br>www.sesmt-rio.com / www.shoppingsesmt.com</td>";
	$msg_clinica .= "<td align=right height=$footer_h width=207 valign=bottom><img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt2.png\" width=207 height=135></td>";
	$msg_clinica .= "</tr>";
	$msg_clinica .= "</table>";

    $msg_clinica .= "</body>";
    $msg_clinica .= "</html>";

/************************************************************************************************/
//MENSAGEM PARA FINANCEIRO
/************************************************************************************************/
	$msg_financeiro .= "<html>";
    $msg_financeiro .= "<head>";
    $msg_financeiro .= "</head>";
    $msg_financeiro .= "<body>";
	
	$msg_financeiro .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
	$msg_financeiro .= "<tr>";
	$msg_financeiro .= "<td align=left height=$header_h valign=top width=270><img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt.png\" width='270' height='135'></td>";
	$msg_financeiro .= "<td align=center height=$header_h valign=top class='medText'>Serviços Especializados de Segurança e<br>Monitoramento de Atividades no Trabalho<p>Assistência em Segurança e Higiene no Trabalho</td>";
	$msg_financeiro .= "</tr>";
	$msg_financeiro .= "</table>";

	$msg_financeiro .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_financeiro .= "<tr>";
    $msg_financeiro .= "<td align=center><b>ENCAMINHAMENTO MÉDICO COMPLEMENTAR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nº ".$cod_aso."</b></td>";
    $msg_financeiro .= "</tr>";
	$msg_financeiro .= "</table><p><br><p>";
	
	$msg_financeiro .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
	$msg_financeiro .= "<tr>";
    $msg_financeiro .= "<td align=justify><b>Clínica:</b> {$clinica['razao_social_clinica']}</td>";
    $msg_financeiro .= "</tr>";
	$msg_financeiro .= "</table><br>";
	
	$msg_financeiro .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_financeiro .= "<tr>";
    $msg_financeiro .= "<td align=justify width=60%><b>Endereço:</b> {$clinica['endereco_clinica']}</td>";
	$msg_financeiro .= "<td align=justify><b>Nº</b> {$clinica['num_end']}</td>";
    $msg_financeiro .= "</tr>";
	$msg_financeiro .= "</table><br>";
	
	$msg_financeiro .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_financeiro .= "<tr>";
    $msg_financeiro .= "<td align=justify width=60%><b>CEP:</b>  {$clinica['cep_clinica']}</td>";
	$msg_financeiro .= "<td align=justify><b>Bairro:</b> {$clinica['bairro_clinica']}</td>";
    $msg_financeiro .= "</tr>";
	$msg_financeiro .= "</table><br>";
	
	$msg_financeiro .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_financeiro .= "<tr>";
    $msg_financeiro .= "<td align=justify width=30%><b>Assunto:</b></td>";
    $msg_financeiro .= "</tr>";
	$msg_financeiro .= "</table>";
	
	$msg_financeiro .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_financeiro .= "<tr>";
    $msg_financeiro .= "<td align=justify width=30%><b>Encaminhado:</b> {$funcionario[0]['nome_func']}</td>";
    $msg_financeiro .= "</tr>";
	$msg_financeiro .= "</table>";
	
	$msg_financeiro .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_financeiro .= "<tr>";
    $msg_financeiro .= "<td align=justify width=60%><b>Função:</b> {$funcionario[0]['nome_funcao']}</td>";
	$msg_financeiro .= "<td align=justify width=20%><b>CTPS:</b> {$funcionario[0]['num_ctps_func']}</td>";
	$msg_financeiro .= "<td align=justify width=20%><b>Série:</b> {$funcionario[0]['serie_ctps_func']}</td>";
    $msg_financeiro .= "</tr>";
	$msg_financeiro .= "</table>";
	
	$msg_financeiro .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_financeiro .= "<tr>";
    $msg_financeiro .= "<td align=justify width=30%><b>Tipo dos Exames:</b> $tipo_exames</td>";
    $msg_financeiro .= "</tr>";
	$msg_financeiro .= "</table><br>";
	
	$msg_financeiro .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_financeiro .= "<tr>";
    $msg_financeiro .= "<td align=justify><b>Empresa Solicitante:</b>  {$cliente['razao_social']}</td>";
    $msg_financeiro .= "</tr>";
    $msg_financeiro .= "</table><br>";
	
	$msg_financeiro .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_financeiro .= "<tr>";
    $msg_financeiro .= "<td align=justify ><b>CNPJ:</b>  {$cliente['cnpj']}</td>";
	$msg_financeiro .= "<td align=justify ><b>Resp. Solicitante:</b> {$cliente['nome_contato_dir']}</td>";
    $msg_financeiro .= "</tr>";
	$msg_financeiro .= "</table><br>";
	
	$msg_financeiro .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_financeiro .= "<tr>";
    $msg_financeiro .= "<td align=justify><b>Endereço:</b>  {$cliente['endereco']}, {$cliente['num_end']} - {$cliente['bairro']} - {$cliente['estado']}</td>";
    $msg_financeiro .= "</tr>";
    $msg_financeiro .= "</table>";
	
	$msg_financeiro .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$footer_h>";
	$msg_financeiro .= "<tr>";
	$msg_financeiro .= "<td align=left height=$footer_h valign=bottom class='medText'>Telefone: +55 (21) 3014 4304      Fax: Ramal 7<br>Nextel: +55 (21) 7844 6095 / Id 55*23*31641<br>medicotrab@sesmt-rio.com<br>www.sesmt-rio.com / www.shoppingsesmt.com</td>";
	$msg_financeiro .= "<td align=right height=$footer_h width=207 valign=bottom><img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt2.png\" width=207 height=135></td>";
	$msg_financeiro .= "</tr>";
	$msg_financeiro .= "</table>";

    $msg_financeiro .= "</body>";
    $msg_financeiro .= "</html>";
	
$headers = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <medicotrab@sesmt-rio.com> \n";


$msg = "Olá! Luciana, servimo-nos deste e-mail para informa-la que um ASO foi agendado pelo site!<br> 
		<b>Encaminhamento Nº: </b>".$cod_aso." <br>
		<b>Cliente: </b>".$cliente[razao_social]." <br> 
		<b>Funcionário: </b>".$funcionario[0][nome_func]." <br>
		<b>Tipo de ASO: </b>".$tipo_exame;
$mail_list = "medicotrab@sesmt-rio.com";
mail($mail_list, "SESMT - ASO Nº: ".$cod_aso, $msg, $headers);

//mail('raylan@raylansoares.com', 'Agendamento de ASO Cliente', $msg_cliente, $headers);
//mail("{$cliente[email]}", 'Agendamento de ASO Cliente', $msg_cliente, $headers);
//mail('medicotrab@sesmt-rio.com', 'Agendamento de ASO Médico', $msg_medico, $headers);
//mail('medicinacomplementar@sesmt-rio.com', 'Agendamento de ASO Médico', $msg_medico, $headers);
//mail("{$clinica[email_clinica]}", 'Agendamento de ASO Clínica', $msg_clinica, $headers);
//mail('financeiro@sesmt-rio.com', 'Agendamento de ASO Financeiro', $msg_financeiro, $headers);

/*
mail("{$cliente[email]}", 'Agendamento de ASO Cliente', $msg_cliente, $headers);
mail('suporte@sesmt-rio.com', 'Agendamento de ASO Médico', $msg_medico, $headers);
mail('suporte@sesmt-rio.com', 'Agendamento de ASO Médico', $msg_medico, $headers);
mail("{$clinica[email_clinica]}", 'Agendamento de ASO Clínica', $msg_clinica, $headers);
mail('suporte@sesmt-rio.com', 'Agendamento de ASO Financeiro', $msg_financeiro, $headers);
*/
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