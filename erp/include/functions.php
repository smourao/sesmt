<?PHP
//INCLUDES
include('db.php');
/*
$host = 'postgresql01.sesmt-rio.com';//'s4d.servegame.com'; //postgresql01.sesmt-rio.com
$port = '5432';
$dbname = 'sesmt_rio';//'loja';//sesmt_rio
$user = 'sesmt_rio';//'postgres';//sesmt_rio
$pass = 'diggio3001';//'xxxxxx';//diggio3001
$str = "host=$host port=$port dbname=$dbname user=$user password=$pass";
$conn = pg_connect($str) or die('Erro ao conectar a base de dados!');
*/


//*************************************************************************
//*************************************************************************
function getTrueTime($gmt, $fa=false) {
// Servidores de tempo
$servers=array(
//"time.nist.gov"//falhou ??
"time-nw.nist.gov",//ok
"time-a.nist.gov",//ok
"time-b.nist.gov",//ok
"time-a.timefreq.bldrdoc.gov",//ok
"time-b.timefreq.bldrdoc.gov",//ok
"time-c.timefreq.bldrdoc.gov",//ok
//"utcnist.colorado.edu",//ok
"nist1.datum.com",//ok
//"nist1-dc.glassey.com",//fail
//"nist1-ny.glassey.com",
//"nist1-sj.glassey.com"
"nist1.aol-ca.truetime.com"//ok
//"nist1.aol-va.truetime.com"//fail
);

$time_server=$servers[rand(0,count($servers)-1)];

$error="<strong>Erro:</strong> Uma tentativa de conexão à ".$time_server." falhou porque o componente conectado não respondeu corretamente após um período de tempo ou a conexão estabelecida falhou porque o host conectado não respondeu.";

$fp=fsockopen($time_server,13,$errno,$errstr,30) or die($error);
if(!$fp) die($error); else {
while(!feof($fp)) $returned.=fgets($fp,128);
fclose($fp);

if(isset($returned) && !empty($returned)){

preg_match("/([0-9]{5}) ([0-9]{2}-[0-9]{2}-[0-9]{2}) ([0-9]{2}:[0-9]{2}:[0-9]{2}) ([0-9]{1,2}) ([0-9]) ([0-9]) ([0-9]{1,5}\.[0-9])/",$returned,$match);

if($fa==false){
$date=date("d/m/Y",strtotime($match[2])); // YR-MO-DA
}else{
$date=date("Y/m/d",strtotime($match[2])); // YR-MO-DA
}

$time=date("H:i:s",mktime(date("H",strtotime($match[3]))+$gmt,date("i",strtotime($match[3])),date("s",strtotime($match[3])))); // HH:MM:SS
$extrasecond=($match[5]==0) ? "Não" : "Sim"; // L
$serverstatus=$match[6]; // H
$offset=number_format($match[7],1,",","."); // msADV

// Manipula status do servidor

if($serverstatus==0) $serverstatus="OK"; else
if($serverstatus==1) $serverstatus="Possibilidade de erro de até 5 segundos"; else
if($serverstatus==2) $serverstatus="O servidor tem um erro de mais de 5 segundos"; else
if($serverstatus==4) $serverstatus="Erro de hardware ou software e a hora não pode ser determinada";

// Retorna informações

return array($returned,$time_server,$date,$time,$extrasecond,$serverstatus,$offset);

}
}
}
//*************************************************************************
//*************************************************************************
function TrueTime($timezone = 'UTC', $format = 'U')
{
    // Time servers used by the NIST Internet Time Service (ITS)
    $servers = array(
        array('64.113.32.5', 'Southfield, Michigan'),
        array('64.125.78.85', 'WiTime, San Jose, California'),
        array('64.236.96.53', 'Symmetricom, AOL facility, Virginia'),
        array('68.216.79.113', 'Columbia County, Georgia'),
        array('69.25.96.13', 'Symmetricom, San Jose, California'),
        array('71.13.91.122', 'Monroe, Michigan'),
        array('128.138.140.44', 'University of Colorado, Boulder'),
        array('129.6.15.28', 'NIST, Gaithersburg, Maryland'),
        array('129.6.15.29', 'NIST, Gaithersburg, Maryland'),
        array('131.107.13.100', 'Microsoft, Redmond, Washington'),
        array('132.163.4.101', 'NIST, Boulder, Colorado'),
        array('132.163.4.102', 'NIST, Boulder, Colorado'),
        array('132.163.4.103', 'NIST, Boulder, Colorado'),
        array('192.43.244.18', 'NCAR, Boulder, Colorado'),
        array('206.246.118.250', 'WiTime, Virginia'),
        array('207.200.81.113', 'Symmetricom, AOL facility, Sunnyvale, California'),
        array('208.184.49.9', 'WiTime, New York City')
    );

    // Server response
    $response = null;

    // Try to get a response recursively
    while (is_null($response) && !empty($servers)) {
        $server_id  = array_rand($servers);
        $server     = $servers[$server_id];
        $connection = @fsockopen($server[0], 13, $errno, $err, 4);

        if ($connection) {
            $response = trim(stream_get_contents($connection, 49));

            // NIST Daytime Time Code Format regexp
            $daytime_re = '\d{5}                          # Modified Julian Date (MJD)
                           \ (\d{2}-(?:0[1-9]|1[0-2])
                              -(?:0[1-9]|[1-2]\d|3[0-1])) # Date (UTC)
                           \ ((?:[0-1]\d|2[0-3])
                              :[0-5]\d:[0-5]\d)           # Time (UTC)
                           \ \d{2}                        # DST flag
                           \ [0-2]                        # Leap second digit
                           \ ([0-3])                      # Health digit
                           \ [\d ]{1,3}\.\d               # Network delay (ms)
                           \ UTC\(NIST\)                  # UTC(NIST) label
                           \ \*                           # OTM (on-time marker)';

            // Get server info
            preg_match("{{$daytime_re}}x", $response, $matches);

            list(, $date, $time, $health) = $matches;

            // Defines server health level
            switch ($health) {
            case 0:
                $health = 'Healthly';
                break;
            case 1:
                $health = 'Operating properly - May be in error by up to 5 s';
                break;
            case 2:
                $health = 'Operating properly - Known to be wrong by more than 5 s';
                break;
            case 3:
                $health = 'Hardware or software failure';
                break;
            default:
                $health = 'Unknown';
            }

            // Do offset correction
            date_default_timezone_set($timezone);

            return array(
                'server_address'  => $server[0],
                'server_location' => $server[1],
                'server_health'   => $health,
                'server_response' => $response,
                'time'            => date($format, strtotime("$date $time GMT"))
            );
        } else {
            // Avoid unresponsively server to speed up function response
            unset($servers[$server_id]);
        }
    }

    return false;
}


function getdata(){

}

//*************************************************************************
//*************************************************************************
 function anti_injection($sql)
 {
 // remove palavras que contenham sintaxe sql
 $sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$sql);
 $sql = trim($sql);//limpa espaços vazio
 $sql = strip_tags($sql);//tira tags html e php
 $sql = addslashes($sql);//Adiciona barras invertidas a uma string
 return $sql;
 }
 //$nome = htmlentities($nome,ENT_QUOTES,'UTF-8');
 
 //modo de usar pegando dados vindos do formulario
//$nome = anti_injection($_POST["nome"]);
//$senha = anti_injection($_POST["senha"]);

function my_file_get_contents( $site_url ){
    $ch = curl_init();
    $timeout = 5; // set to zero for no timeout
    curl_setopt ($ch, CURLOPT_URL, $site_url);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    ob_start();
    curl_exec($ch);
    curl_close($ch);
    $file_contents = ob_get_contents();
    ob_end_clean();
    return $file_contents;
}

//*************************************************************************
//*************************************************************************
function busca_cep($cep){
    // $resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep='.urlencode($cep).'&formato=query_string');
     $resultado = @my_file_get_contents('http://republicavirtual.com.br/web_cep.php?cep='.urlencode($cep).'&formato=query_string');
     if(!$resultado){
         $resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";
     }
     parse_str($resultado, $retorno);
     return $retorno;
}

//*************************************************************************
//*************************************************************************
function random($nNumeros, $nQuant, $min, $max)
{
    $aRand = array();
    for ($i=1; $i<=$nQuant; $i++) {

        $aRand[$i][] = $rand = rand($min, $max);

        while (count($aRand[$i]) < $nNumeros)
            if (!in_array($rand, $aRand[$i]))
                $aRand[$i][] = $rand;
            else
                $rand = rand($min, $max);

    }
    return $aRand;
}
//*************************************************************************
//*************************************************************************
function check_group(){
   if($_GET['p']=='register' || $_GET['p']=='login' || isset($_SESSION['group']) && !empty($_SESSION['group']) && $_SESSION['group']!="" && $_SESSION['group']=="2" || $_SESSION['group']=="1"){
      return true;
   }else{
      include 'pages/nao_permitido.php';
   }
   break;
}

//*************************************************************************
//*************************************************************************
function get_fornecedor_id($fornecedor_id){
   global $conn;
   $sql = "SELECT fornecedor_id FROM fornecedores WHERE email='{$fornecedor_id}'";
   $result = pg_query($conn, $sql);
   $row = pg_fetch_all($result);
   return $row[0]['fornecedor_id'];
}
//*************************************************************************
//*************************************************************************
function get_fornecedor_segmento($fornecedor_id){
   global $conn;
   $sql = "SELECT segmento FROM fornecedores WHERE email='{$fornecedor_id}'";
   $result = pg_query($conn, $sql);
   $row = pg_fetch_all($result);
   return $row[0]['segmento'];
}
//*************************************************************************
//*************************************************************************
function get_fornecedor_produto($fornecedor_id){
   global $conn;
   $sql = "SELECT * FROM produto_fornecedores WHERE fornecedor_id = '{$fornecedor_id}'";
   $result = pg_query($conn, $sql);
   $row = pg_fetch_all($result);
   return $row;
}
//*************************************************************************
//0 - Não Cadastrado
//1 - Física
//2 - Jurídica
//3 - Duplicado
// Retorna um número relacionado à busca na database
//*************************************************************************
function tipo_pessoa($email){
   global $conn;
   $fisica = 0;
   $juridica = 0;
   $retorno = "";

   $sql = "SELECT * FROM reg_pessoa_fisica WHERE email = '{$email}'";
   $result = pg_query($conn, $sql);
   if(pg_num_rows($result)>0){
       $fisica = 1;
   }
   
   $sql = "SELECT * FROM reg_pessoa_juridica WHERE email = '{$email}'";
   $result = pg_query($conn, $sql);
   if(pg_num_rows($result)>0){
       $juridica = 1;
   }
   
   if($fisica == 0 && $juridica == 0){
       $retorno = 0; // email não cadastrado
   }
   if($fisica == 1 && $juridica == 0){
       $retorno = 1; // pessoa física
   }
   if($fisica == 0 && $juridica == 1){
       $retorno = 2; // pessoa juridica
   }
   if($fisica == 1 && $juridica == 1){
       $retorno = 3; // email duplicado
   }
   return $retorno;
}

function get_setor($id=""){
global $conn;
if($id!=""){
   $sql = "SELECT * FROM setor WHERE cod_setor=".$id;
}else{
   $sql = "SELECT * FROM setor";//WHERE".$where;
}
$result = pg_query($conn, $sql);
$array_setor = pg_fetch_all($result);

if($id!=""){
    return $array_setor[0]['nome_setor'];
}else{
    return $array_setor;
}
}

//RETORNA PORCENTAGEM DE PROGRESSO DO PPRA
function ppra_progress($cod_cliente, $setor){
global $conn;
$tela1 = 0;
$tela2 = 0;
$tela3 = 0;
$tela4 = 0;
$tela5 = 0;
/*************************************
 VERIFY PPRA PROGRESS 1
/*************************************/
$sql = "SELECT cs.cod_luz_nat, cs.cod_luz_art, cs.cod_vent_nat, cs.cod_vent_art, cs.cod_edificacao, cs.cod_piso,
 cs.cod_parede, cs.cod_cobertura FROM cliente_setor cs
 WHERE cs.cod_cliente = {$cod_cliente} AND
 cs.cod_setor = {$setor}";
$res = pg_query($conn, $sql);
$buff = pg_fetch_array($res);
for($x=0;$x<count($buff);$x++){
    if(!empty($buff[$x])){
        $tela1+=1;
    }
}
$tela1 = ($tela1 * 100) / 8;

/*************************************
 VERIFY PPRA PROGRESS 2
/*************************************/
$sql = "SELECT f.nome_func FROM funcionarios f
 WHERE f.cod_cliente = {$cod_cliente} AND
 f.cod_setor = {$setor}";
$res = pg_query($conn, $sql);
$buff = pg_fetch_all($res);

if(count($buff)>0){$tela2=100;}else{$tela2=0;}

/*************************************
 VERIFY PPRA PROGRESS 3
/*************************************/
$sql = "SELECT cs.data_avaliacao, cs.hora_avaliacao FROM cliente_setor cs
 WHERE cs.cod_cliente = {$cod_cliente} AND
 cs.cod_setor = {$setor}";
$res = pg_query($conn, $sql);
$buff = pg_fetch_array($res);
for($x=0;$x<count($buff);$x++){
    if(!empty($buff[$x])){
        $tela3+=1;
    }
}
$tela3 = ($tela3 * 100) / 2;

/*************************************
 VERIFY PPRA PROGRESS 4
/*************************************/
$sql = "SELECT rs.cod_agente_risco FROM risco_setor rs
 WHERE rs.cod_cliente = {$cod_cliente} AND
 rs.cod_setor = {$setor}";
$res = pg_query($conn, $sql);
$buff = pg_fetch_array($res);
for($x=0;$x<count($buff);$x++){
    if(!empty($buff[$x])){
        $tela4+=1;
    }
}
$tela4 = ($tela4 * 100) / 1;

/*************************************
 VERIFY PPRA PROGRESS 5
/*************************************/
$sql = "SELECT rs.cod_sugestao FROM sugestao rs
 WHERE rs.cod_cliente = {$cod_cliente} AND
 rs.cod_setor = {$setor}";
$res = pg_query($conn, $sql);
$buff = pg_fetch_array($res);
for($x=0;$x<count($buff);$x++){
    if(!empty($buff[$x])){
        $tela5+=1;
    }
}
$tela5 = ($tela5 * 100) / 1;
$progresso = ($tela5+$tela4+$tela3+$tela2+$tela1)/5;
return $progresso;
}


function cliente_id($email){
global $conn;
$sql = "SELECT cod_cliente FROM reg_pessoa_juridica WHERE email='{$email}'";
$res = pg_query($conn, $sql);
$data = pg_fetch_all($res);
return $data[0]['cod_cliente'];
}

function filial_id($email){
global $conn;
$sql = "SELECT cod_filial FROM reg_pessoa_juridica WHERE email='{$email}'";
$res = pg_query($conn, $sql);
$data = pg_fetch_all($res);
return $data[0]['cod_filial'];
}

//encriptação de dados para GET
function encrypt($string){
    return base64_encode($string);
}
//decriptação de dados para GET
function decrypt($string){
    return base64_decode($string);
}

/******************************************/
/*        RETORNA DIAS DISPONIVEIS        */
/******************************************/
//valor = valor de meta diária
//num = numero de dias retornados
function mmd_dd($valor, $num, $da=false){
global $conn;
 /*
//TrueTime($timezone = 'UTC', $format = 'U');
$dh = getTrueTime('-3', true);
//print_r($dh);
while($dh[3] =="18:00:00"){
    $dh = getTrueTime('-3', true);
}
//echo $dh[2];
*/
//$dia = date("j", strtotime($dh[2]));//"d" 01 - 31 | "j" 1 - 31
$dia = date("j");
if($_GET['mes']!=""){
    $mes = $_GET['mes'];
}else{
    //$mes = date("m", strtotime($dh[2]));
    $mes = date("m");
}
if($_GET['ano']!=""){
    $ano = $_GET['ano'];
}else{
    //$ano = date("Y", strtotime($dh[2]));
    $ano = date("Y");
}
/*
if($mes <12){
   $mes++;
}else{
   $mes =1;
   $ano++;
}   */

$dia_semana = date("w", mktime(0, 0, 0, $mes, 1, $ano));//date("w");
$t_mes = date("t", mktime(0, 0, 0, $mes, 1, $ano)); //cal_days_in_month(CAL_GREGORIAN, 8, 2003);


//VERIFICAÇÃO -> DIAS NÃO DISPONÍVEIS
$sql = "SELECT sum(valor) as valor, data_vencimento FROM mmd_pagamentos GROUP BY data_vencimento ORDER BY data_vencimento";
$result = pg_query($conn, $sql);
$res = pg_fetch_all($result);
$dnd = array();//dias nao disponiveis

for($x=0;$x<count($res);$x++){
    if($res[$x]['valor'] >= $alvo){
        $dnd[] = date("d/m/Y", strtotime($res[$x]['data_vencimento']));
    }
}
$dd = array();
for($x=1;$x<$t_mes;$x++){
    $m = $x."/".$mes."/".$ano;
    if(!in_array($m, $dnd)){
       if($da=true){
           if($x>=date("j")){
               $dd[] = $x."/".$mes."/".$ano;
           }
       }else{
           $dd[] = $x."/".$mes."/".$ano;
       }
    }
}
//print_r($dnd);
//echo "<p>";
//print_r($dd);

//************************************************************
if(count($dd)<$num){
//   $num = count($dd);
//   echo count($dd)." - ".$num;
if($mes <12){
   $mes++;
}else{
   $mes =1;
   $ano++;
}

  for($x=1;$x<$t_mes;$x++){
    $m = $x."/".$mes."/".$ano;
    if(!in_array($m, $dnd)){
            $dd[] = $x."/".$mes."/".$ano;

    }
  }
}

/*if(count($dd)<1){
//$num =1;
echo count($dd)." - ".$num;
} */

$dias_aleatorios = array_rand($dd, $num);
$dias_retorno = array();
for($x=0;$x<$num;$x++){
    //echo $dd[$dias_aleatorios[$x]];
    $dias_retorno[] = $dd[$dias_aleatorios[$x]];
    //echo " | ";
}
return $dias_retorno;
}



// funcao............: valorPorExtenso
// ---------------------------------------------------------------------------
// desenvolvido por..: andré camargo
// versoes...........: 0.1 19:00 14/02/2000
//                     1.0 12:06 16/02/2000
// descricao.........: esta função recebe um valor numérico e retorna uma
//                     string contendo o valor de entrada por extenso
// parametros entrada: $valor (formato que a função number_format entenda :)
// parametros saída..: string com $valor por extenso

function valorPorExtenso($valor=0) {
	$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
	$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões",
"quatrilhões");

	$c = array("", "cem", "duzentos", "trezentos", "quatrocentos",
"quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
	$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta",
"sessenta", "setenta", "oitenta", "noventa");
	$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze",
"dezesseis", "dezesete", "dezoito", "dezenove");
	$u = array("", "um", "dois", "três", "quatro", "cinco", "seis",
"sete", "oito", "nove");

	$z=0;

	$valor = number_format($valor, 2, ".", ".");
	$inteiro = explode(".", $valor);
	for($i=0;$i<count($inteiro);$i++)
		for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
			$inteiro[$i] = "0".$inteiro[$i];

	// $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
	$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
	for ($i=0;$i<count($inteiro);$i++) {
		$valor = $inteiro[$i];
		$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
		$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
		$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

		$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd &&
$ru) ? " e " : "").$ru;
		$t = count($inteiro)-1-$i;
		$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
		if ($valor == "000")$z++; elseif ($z > 0) $z--;
		if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
		if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) &&
($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
	}

	return($rt ? $rt : "zero");
}


?>
