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

function getTrueTime($gmt) {
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

$date=date("d/m/Y",strtotime($match[2])); // YR-MO-DA
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


function busca_cep($cep){
     $resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep='.urlencode($cep).'&formato=query_string');
     if(!$resultado){
         $resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";
     }
     parse_str($resultado, $retorno);
     return $retorno;
}


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

function check_group(){
   if($_GET['p']=='register' || $_GET['p']=='login' || isset($_SESSION['group']) && !empty($_SESSION['group']) && $_SESSION['group']!="" && $_SESSION['group']=="2" || $_SESSION['group']=="1"){
      return true;
   }else{
      include 'pages/nao_permitido.php';
   }
   break;
}


function get_fornecedor_id($fornecedor_id){
   global $conn;
   $sql = "SELECT fornecedor_id FROM fornecedores WHERE email='{$fornecedor_id}'";
   $result = pg_query($conn, $sql);
   $row = pg_fetch_all($result);
   return $row[0]['fornecedor_id'];
}

function get_fornecedor_segmento($fornecedor_id){
   global $conn;
   $sql = "SELECT segmento FROM fornecedores WHERE email='{$fornecedor_id}'";
   $result = pg_query($conn, $sql);
   $row = pg_fetch_all($result);
   return $row[0]['segmento'];
}

function get_fornecedor_produto($fornecedor_id){
   global $conn;
   $sql = "SELECT * FROM produto_fornecedores WHERE fornecedor_id = '{$fornecedor_id}'";
   $result = pg_query($conn, $sql);
   $row = pg_fetch_all($result);
   return $row;
}



?>
