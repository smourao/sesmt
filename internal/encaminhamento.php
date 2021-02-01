<?PHP
/*****************************************************************************************************************/
// -> INCLUDES / DEFINES
/*****************************************************************************************************************/
define('_MPDF_PATH', '../common/MPDF45/');
define('_IMG_PATH', '../images/');
include(_MPDF_PATH.'mpdf.php');
include("../common/includes/database.php");
include("../common/includes/functions.php");

/*****************************************************************************************************************/
// -> VARS
/*****************************************************************************************************************/
$header_h = 75;//header height;
$footer_h = 75;//footer height;

function coloca_zeros($numero){
   return str_pad($numero, 4, "0", STR_PAD_LEFT);
}

$cod_aso = $_GET[cod_aso];

/*ATUALIZAR UM ASO*/
$sql = "UPDATE aso SET cod_clinica = '$_GET[cl]' WHERE cod_aso = '$_GET[cod_aso]'";
$query = pg_query($sql);

//CLINICA
$cn_sql = "SELECT * FROM clinicas WHERE cod_clinica = '$_GET[cl]'";
$cn_query = pg_query($cn_sql);
$clinica = pg_fetch_array($cn_query);


//CLIENTE
$sql = "SELECT * FROM cliente WHERE cliente_id = '$_GET[cod]'";
$query = pg_query($sql);
$cliente = pg_fetch_array($query);

//FUNCIONARIO
$sql = "SELECT * FROM funcionarios f, funcao u WHERE f.cod_cliente = '$_GET[cod]' AND f.cod_func = '$_GET[col]' AND f.cod_funcao = u.cod_funcao";
$query = pg_query($sql);
$funcionario = pg_fetch_array($query);

//EXAMES
$sql = "SELECT a.*, e.* FROM aso_exame a, exame e WHERE a.cod_aso = '$_GET[cod_aso]' AND a.cod_exame = e.cod_exame";
$query = pg_query($sql);
$exam = pg_fetch_all($query);
$tipo_exame = '';
for($i=0;$i<pg_num_rows($query);$i++){
	$exames .= $exam[$i][especialidade].'; ';
}

//ASO
$sql = "SELECT * FROM aso WHERE cod_aso = '$_GET[cod_aso]'";
$query = pg_query($sql);
$tp_aso = pg_fetch_array($query);


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
        $cabecalho .= "<td align=center height=$header_h valign=top class='medText'>Servi�os Especializados de Seguran�a e<br>Monitoramento de Atividades no Trabalho<p>Assist�ncia em Seguran�a e Higiene no Trabalho</td>";
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
    $msg_site .= "<td align=center><b>ENCAMINHAMENTO M�DICO COMPLEMENTAR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; N� ".$cod_aso."</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table><p><br><p>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify><b>Cl�nica:</b> {$clinica['razao_social_clinica']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=60%><b>Endere�o:</b> {$clinica['endereco_clinica']}</td>";
	$msg_site .= "<td align=justify><b>N�</b> {$clinica['num_end']}</td>";
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
    $msg_site .= "<td align=justify><b>Ponto de Refer�ncia:</b> {$clinica['referencia_clinica']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table><br>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Assunto:</b> Atendimento para ASO $tp_aso[tipo_exame]</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Encaminhado:</b> $funcionario[nome_func]</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=60%><b>Fun��o:</b> {$funcionario['nome_funcao']}</td>";
	$msg_site .= "<td align=justify width=20%><b>CTPS:</b> {$funcionario['num_ctps_func']}</td>";
	$msg_site .= "<td align=justify width=20%><b>S�rie:</b> {$funcionario['serie_ctps_func']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "</table>";
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Exames a serem realizados:</b> $exames</td>";
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
    $msg_site .= "<td align=justify width=30%><b>Hor�rio:</b> Ordem de Chegada de Segunda a Sexta</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Hor�rio T�rmino para atendimento Laboratorial:</b> 11h00min</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Hor�rio T�rmino para atendimento Geral:</b> 15h00min</td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table><br>";

	for($y=0;$y<pg_num_rows($rr);$y++){
		if($ee[$y][cod_exame] == '10' ){
		$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
		$msg_site .= "<tr>";
		$msg_site .= "<td align=justify width=30%>EAS - Fazer uma higiene �ntima rigorosa em sua casa, usando sabonete e �gua, enxaguar bem com �gua abundante e secar bem com uma toalha limpa; Coletar a primeira urina da manh� ou 2 horas ap�s a �ltima mic��o; Desprezar o primeiro jato da urina no vaso sanit�rio e coletar no copo descart�vel o jato do meio, mais ou menos (at� a metade do copo) desprezando o restante da mic��o no vaso sanit�rio; Imediatamente, passar a urina do copo para o tubo, at� preencher totalmente, fechar e muito bem e identificar com seu nome completo.</td>";
		$msg_site .= "</tr>";
		$msg_site .= "</table><br>";
		}
		
		if($ee[$y][cod_exame] == 11 ){
		$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
		$msg_site .= "<tr>";
		$msg_site .= "<td align=justify width=30%>EPF - Colher as fezes diretamente no frasco ou sobre um papel ou pl�stico e transferir para o pote, este procedimento de prefer�ncia no per�odo da manh� e depois de coletar (pequena por��o) levar para o local do exame, caso n�o seja poss�vel, acondicionar o pote em um saco pl�stico e manter refrigerado.</td>";
		$msg_site .= "</tr>";
		$msg_site .= "</table><br>";
		}
	}
	
	$msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>OBS: O n�o comparecimento do candidato e/ou a n�o realiza��o de algum procedimento ora agendado e n�o cumprido pelo solicitante n�o anular� a cobran�a do mesmo, ficando o cr�dito para esse mesmo candidato se submeter em outra data.</b></td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table>";
	
    $msg_site .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [2]
/****************************************************************************************************************/
	$msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=center colspan=5><b>SESMT - Servi�os Especializados de Seguran�a de Monitoramento de Atividades no Trabalho LTDA</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=4></td>";
    $msg_site .= "<td align=justify><b>Prontu�rio M�dico:</b> $cod_aso</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=5><b>Cl�nica:</b> {$clinica['razao_social_clinica']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=5><b>Empresa:</b> {$cliente['razao_social']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=5><b>Nome:</b> {$funcionario['nome_func']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=2 width=40%><b>Fun��o Atual:</b> {$funcionario['nome_funcao']}</td>";
	$msg_site .= "<td align=justify colspan=2 width=40%><b>Fun��o Anterior:</b> </td>";
	$msg_site .= "<td align=justify width=20%><b>RG:</b> {$funcionario['rg']}</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=20%><b>Sexo:</b> {$funcionario['sexo_func']}</td>";
	$msg_site .= "<td align=justify width=20%><b>Est. Civil:</b> </td>";
	$msg_site .= "<td align=justify width=20%><b>Cor:</b> </td>";
	$msg_site .= "<td align=justify width=20%><b>Nasc.:</b> </td>";
	$msg_site .= "<td align=justify width=20%><b>Natural:</b> </td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=5><b>Endere�o:</b> {$funcionario['endereco_func']}</td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table>";
	
	$msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=2><b>Antecedentes Familiares:&nbsp;&nbsp;&nbsp;Parentesco</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=50%><b>&bull; Tuberculose/Diabete/C�ncer ______________________________________</b></td>";
	$msg_site .= "<td align=justify width=50%><b>&bull; Asma/Alergias/Urtic�ria __________________________________________</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=50%><b>&bull; Doen�a do Cora��o/Press�o Alta _________________________________</b></td>";
	$msg_site .= "<td align=justify width=50%><b>&bull; Doen�a Mental/Nervosa __________________________________________</b></td>";
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
    $msg_site .= "<td align=justify width=33%><b>&bull; Doen�a do Cora��o/Press�o Alta ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Enxerga Bem ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Varizes/Varicocele/H�rnias ( )</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Dor no Peito/Palpita��o ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Ouve Bem/Otite/Zumbido ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Hemorr�idas/Diarr�ia Frequente ( )</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Bronquite/Asma/Rinite ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; J� teve internado ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Sofreu doen�a n�o mencionada ( )</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Doen�as Coluna/Dor nas Costas ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Encontra-se gr�vida ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Pode executar tarefas pesadas ( )</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Doen�as Renais(Rins) ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Doen�a Mental/Nervosa ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Tem alguma defici�ncia ( )</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Doen�a do F�gado/Diabetes ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Dor de Cabe�a/Tonturas/Convuls�es ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Sofreu alguma cirurgia ( )</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; �lcera/Gastrite ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Alergia/Doen�a de Pele ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Tabagismo(Fumo)/Etilismo(Bebe) ( )</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Resfriado/Tosse Cr�nica/Sinusite ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b>&bull; Reumatismo/Dor nas Juntas ( )</b></td>";
	$msg_site .= "<td align=justify width=33%><b> </b></td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table><br>";

	$msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=2><b>Antecedentes Ocupacionais</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=50%><b>&bull; Suas condi��es de sa�de exige trabalho especial ( )</b></td>";
	$msg_site .= "<td align=justify width=50%><b>&bull; Recebeu indeniza��o por acidente de trabalho ( )</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=50%><b>&bull; Perdeu dias de trabalho por motivos de sa�de ( )</b></td>";
	$msg_site .= "<td align=justify width=50%><b>&bull; Esteve doente devido seu trabalho ( )</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=50%><b>&bull; Esteve afastado pelo I.N.P.S. ( )</b></td>";
	$msg_site .= "<td align=justify width=50%><b> </b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=2><b>Anota��es(tratamentos-rem�dios): _________________________________________________________________________________________________________</b></td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table><br>";
	
	$msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
	$msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=4><b>Exame F�sico</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=25%><b>Cabe�a</b></td>";
	$msg_site .= "<td align=justify width=25%><b>Pesco�o</b></td>";
	$msg_site .= "<td align=justify width=25%><b>T�rax</b></td>";
	$msg_site .= "<td align=justify width=25%><b>Abdome</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=25%>Boca/Dente: ______________</td>";
	$msg_site .= "<td align=justify width=25%>Faringe: _______________</td>";
	$msg_site .= "<td align=justify width=25%>Cora��o: _______________</td>";
	$msg_site .= "<td align=justify width=25%>H�rnias: _______________</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=25%>Nariz: _______________</td>";
	$msg_site .= "<td align=justify width=25%>Am�dalas: _______________</td>";
	$msg_site .= "<td align=justify width=25%>Pulm�es: _______________</td>";
	$msg_site .= "<td align=justify width=25%>An�is: _______________</td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=25%>L�ngua: _______________</td>";
	$msg_site .= "<td align=justify width=25%>Laringe: _______________</td>";
	$msg_site .= "<td align=justify width=25%><b></b></td>";
	$msg_site .= "<td align=justify width=25%><b></b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=25%>Ouvidos: _______________</td>";
	$msg_site .= "<td align=justify width=25%>Tire�ide: _______________</td>";
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
	$msg_site .= "<td align=justify width=25%>P� Plano: _______________</td>";
	$msg_site .= "<td align=justify width=25%><b>Press�o Arterial: _______________</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=25%>Hidroxila: _______________</td>";
	$msg_site .= "<td align=justify width=25%>Edemas: _______________</td>";
	$msg_site .= "<td align=justify width=25%>Pele/Mucosa: _______________</td>";
	$msg_site .= "<td align=justify width=25%><b>Pulso: _______________</b></td>";
    $msg_site .= "</tr>";
	$msg_site .= "<tr>";
	$msg_site .= "<td align=justify width=25%>D.U.M.: _______________</td>";
	$msg_site .= "<td align=justify width=25%>M� Forma��o: _______________</td>";
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
    $msg_site .= "</table><br>";
	$msg_site .= "<br>";

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

	
$headers = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: SESMT - Seguran�a do Trabalho e Higiene Ocupacional. <medicotrab@sesmt-rio.com> \n";


$msg = "Ol�! Luciana, servimo-nos deste e-mail para informa-la que um ASO foi agendado pelo site!<br> 
		<b>Encaminhamento N�: </b>".$cod_aso." <br>
		<b>Cliente: </b>".$cliente[razao_social]." <br> 
		<b>Funcion�rio: </b>".$funcionario[0][nome_func]." <br>
		<b>Tipo de ASO: </b>".$tipo_exame;
$mail_list = "medicotrab@sesmt-rio.com";
mail($mail_list, "SESMT - ASO N�: ".$cod_aso, $msg, $headers);

//mail('raylan@raylansoares.com', 'Agendamento de ASO Cliente', $msg_cliente, $headers);
//mail("{$cliente[email]}", 'Agendamento de ASO Cliente', $msg_cliente, $headers);
//mail('medicotrab@sesmt-rio.com', 'Agendamento de ASO M�dico', $msg_medico, $headers);
//mail('medicinacomplementar@sesmt-rio.com', 'Agendamento de ASO M�dico', $msg_medico, $headers);
//mail("{$clinica[email_clinica]}", 'Agendamento de ASO Cl�nica', $msg_clinica, $headers);
//mail('financeiro@sesmt-rio.com', 'Agendamento de ASO Financeiro', $msg_financeiro, $headers);

/*
mail("{$cliente[email]}", 'Agendamento de ASO Cliente', $msg_cliente, $headers);
mail('suporte@sesmt-rio.com', 'Agendamento de ASO M�dico', $msg_medico, $headers);
mail('suporte@sesmt-rio.com', 'Agendamento de ASO M�dico', $msg_medico, $headers);
mail("{$clinica[email_clinica]}", 'Agendamento de ASO Cl�nica', $msg_clinica, $headers);
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
$stylesheet = file_get_contents('../common/css/pdf.css');
//incorporar folha de estilos ao documento
$mpdf->WriteHTML($stylesheet,1);

// incorpora o corpo ao PDF na posi��o 2 e dever� ser interpretado como footage. Todo footage � posicao 2 ou 0(padr�o).
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