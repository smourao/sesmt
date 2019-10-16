<?PHP
function convertwords($text){
$siglas = array("ppp", "ppra", "pcmso", "aso", "cipa", "apgre", "ltcat", "epi", "me", "av", "rj", //Siglas normais
				"ppp,", "ppra,", "pcmso,", "aso,", "cipa,", "apgre,", "ltcat,", "epi,", "me,", "av,", //Siglas com vírgula
				"(ppp)", "(ppra)", "(pcmso)", "(aso)", "(cipa)", "(apgre)", "(ltcat)", "(epi)", "(me)", "(av)", //Siglas entre parênteses
				"nr", "nr.", "mr", "mr.", "in", "in.", "nbr", "nbr.", "me.", "av.", "a0", "a3", "a4", "(a4)"); //Siglas diversas
$minusculo = array("dos", "de");

$at = explode(" ", $text);
$temp = "";
for($x=0;$x<count($at);$x++){
   $atNormal = $at[$x];
   $at[$x] = strtolower($at[$x]);
   $at[$x] = strtr(strtolower($at[$x]),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");

  if(in_array($at[$x], $siglas)){
      $at[$x] = strtoupper($at[$x]);
  }elseif(strlen($at[$x])>2){
      if(!in_array($at[$x], $minusculo)){
          $at[$x] = ucwords($at[$x]);
      }else{
          $at[$x] = $atNormal;
      }
  }else{
      $at[$x] = $atNormal;
  }
	$temp .= $at[$x]." ";
}

if($temp == " "){
   $temp = "";
}
return $temp;
}


function dateDiff($sDataInicial, $sDataFinal)
{
 $sDataI = explode("-", $sDataInicial);
 $sDataF = explode("-", $sDataFinal);

 $nDataInicial = mktime(0, 0, 0, $sDataI[1], $sDataI[0], $sDataI[2]);
 $nDataFinal = mktime(0, 0, 0, $sDataF[1], $sDataF[0], $sDataF[2]);

 return ($nDataInicial > $nDataFinal) ?
    floor(($nDataFinal - $nDataInicial)/86400) : floor(($nDataFinal - $nDataInicial)/86400);
   //floor(($nDataInicial - $nDataFinal)/86400) : floor(($nDataFinal - $nDataInicial)/86400);
}


//retorna true se achar a palavra na string
function str_contain($str, $content, $ignorecase=true){
    if ($ignorecase){
        $str = strtolower($str);
        $content = strtolower($content);
    }
    return strpos($content,$str) ? true : false;
}

function romano($N){
        $N1 = $N;
        $Y = "";
        while ($N/1000 >= 1) {$Y .= "M"; $N = $N-1000;}
        if ($N/900 >= 1) {$Y .= "CM"; $N=$N-900;}
        if ($N/500 >= 1) {$Y .= "D"; $N=$N-500;}
        if ($N/400 >= 1) {$Y .= "CD"; $N=$N-400;}
        while ($N/100 >= 1) {$Y .= "C"; $N = $N-100;}
        if ($N/90 >= 1) {$Y .= "XC"; $N=$N-90;}
        if ($N/50 >= 1) {$Y .= "L"; $N=$N-50;}
        if ($N/40 >= 1) {$Y .= "XL"; $N=$N-40;}
        while ($N/10 >= 1) {$Y .= "X"; $N = $N-10;}
        if ($N/9 >= 1) {$Y .= "IX"; $N=$N-9;}
        if ($N/5 >= 1) {$Y .= "V"; $N=$N-5;}
        if ($N/4 >= 1) {$Y .= "IV"; $N=$N-4;}
        while ($N >= 1) {$Y .= "I"; $N = $N-1;}
        return $Y;
}

?>
