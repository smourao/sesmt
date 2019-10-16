<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");

function convertwords($text){
$siglas = array("ppp", "ppra", "pcmso", "aso", "cipa", "apgre", "ltcat", "epi", "ltda", "sa", "me",//Siglas normais
				"ppp,", "ppra,", "pcmso,", "aso,", "cipa,", "apgre,", "ltcat,", "epi,", //Siglas com vírgula
				"(ppp)", "(ppra)", "(pcmso)", "(aso)", "(cipa)", "(apgre)", "(ltcat)", "(epi)", //Siglas entre parênteses
				"nr", "nr.", "mr", "mr.", "in", "in.", "me.", "nbr", "nbr.", "ltda.", "a0", "a3", "a4", "(a4)", "s/a"); //Siglas diversas
$at = explode(" ", $text);
$temp = "";
for($x=0;$x<count($at);$x++){
   $at[$x] = strtolower($at[$x]);
   $at[$x] = strtr(strtolower($at[$x]),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");

  if(in_array($at[$x], $siglas)){
     $at[$x] = strtoupper($at[$x]);
  }elseif(strlen($at[$x])>3){
     if($x==0){
        $at[$x] = ucwords($at[$x]);
     }
  }else{
     if($x==0){
         $at[$x] = ucwords($at[$x]);
     }
  }

    $temp .= $at[$x]." ";
}
return $temp;
}

$sql = "SELECT * FROM loja_legendas WHERE categoria='{$_GET['categori']}'";
$result = pg_query($sql);
$buffer = pg_fetch_all($result);

$tmp = "";

for($x=0;$x<pg_num_rows($result);$x++){
   //
   $tmp .= convertwords($buffer[$x]['legenda']);
   $tmp .= "|";
}

echo $tmp;

?>

