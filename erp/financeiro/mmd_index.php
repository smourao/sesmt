<?PHP
session_start();
?>
<!--
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: SESMT - Segurança do Trabalho e Medicina Ocupacional ::</title>
<script type="text/javascript" src="java.js"></script>
<script type="text/javascript" src="include/java/flash.js"></script>
<script type="text/javascript" src="include/java/ajax.js"></script>
<script type="text/javascript" src="include/java/mm_css_menu.js"></script>
<script type="text/javascript" src="include/java/js.js"></script>
<script type="text/javascript" src="include/java/java.js"></script>
<script type="text/javascript" src="include/java/keyboard.js"></script>
<style type="text/css" media="screen">
	@import url("include/css/cliente.css");
	@import url("include/css/contador.css");
	@import url("include/css/franquia.css");
	@import url("include/css/style.css");
	@import url("include/css/keyboard.css");

body{
 font-family: verdana;
 /*color: #FFFFFF;*/
 font-size: 12px;
}


td{
 font-family: verdana;
 /*color: #FFFFFF;*/
 font-size: 12px;
}

.excluir{
 font-family: verdana;
 color: #FF0000;
 font-size: 12px;
}

.excluir:hover{
 font-family: verdana;
 color: #fa3d3d;
 font-size: 12px;
}

.concluido{
 font-family: verdana;
 color: #008000;
 font-size: 12px;
}

.concluido:hover{
 font-family: verdana;
 color: #2a9d2a;
 font-size: 12px;
}

input{
 font-family: verdana;
 /*color: #FFFFFF;*/
 font-size: 12px;
}

input[type=button] {
    border: 1px solid #006;
    background: #008000;
    color:#99cc33;
}

input[type=button]:hover {
    border: 1px solid #006;
    background: #008000;
    color:#99cc33;
}

input.button{
    border: 1px solid #006;
    background: #008000;
    color:#99cc33;
}

input.button:hover{
    border: 1px solid #006;
    background: #008000;
    color:#99cc33;
}
</style>
-->
<?PHP
include("include/db.php");
//SET COLOR
$col_bg1 = "#a9baa8";
$col_comp = "#c05d5d";
$col_comp_fin = "#5dc062";

$sql = "SELECT * FROM financeiro_config WHERE id = 1";
$rconfig = pg_query($sql);
$config = pg_fetch_array($rconfig);

$alvo = $config['alvo'];//450.00;

$d_setor = array("Todos","Jurídico", "Técnico", "Médico", "Suporte", "Comercial", "Parcerias");

Function dia($dia)
{
   switch($dia)
   {
      case "0" : echo "Dom"; break;
      case "1" : echo "Seg"; break;
      case "2" : echo "Ter"; break;
      case "3" : echo "Qua"; break;
      case "4" : echo "Qui"; break;
      case "5" : echo "Sex"; break;
      case "6" : echo "Sáb"; break;
   }
}


//*******************************************
//ATRIBUIÇÃO DE VALORES PARA VARIÁVEIS
//*******************************************
$dsem = 0;
$dmes = 1;
$semana = 0;
$meses = array("", "Janeiro",
                   "Fevereiro",
                   "Março",
                   "Abril",
                   "Maio",
                   "Junho",
                   "Julho",
                   "Agosto",
                   "Setembro",
                   "Outubro",
                   "Novembro",
                   "Dezembro");
$dia = date("j");//"d" 01 - 31 | "j" 1 - 31
if($_GET['mes']!=""){
    $mes = $_GET['mes'];
}else{
    $mes = date("n");
}
if($_GET['ano']!=""){
    $ano = $_GET['ano'];
}else{
    $ano = date("Y");
}
$dia_semana = date("w", mktime(0, 0, 0, $mes, 1, $ano));//date("w");
$t_mes = date("t", mktime(0, 0, 0, $mes, 1, $ano)); //cal_days_in_month(CAL_GREGORIAN, 8, 2003);


//$sql = "SELECT * FROM mmd_pagamentos WHERE data_vencimento BETWEEN '$ano/$mes/1' AND '$ano/$mes/$t_mes'";
/*
$sql = "
SELECT
   *
FROM
   financeiro_fatura
WHERE
   vencimento BETWEEN '$ano/$mes/1' AND '$ano/$mes/$t_mes'
AND
   status = 0
AND 1=2
";
   
$resulta = pg_query($conn, $sql);
$row = pg_fetch_all($resulta);
//print_r($row);
*/
$pagamento = array();
$x=0;
/*
for($x=0;$x<count($row);$x++){
    $pagamento[$x] .= $row[$x]['id'];
    $pagamento[$x] .= "|";
    $pagamento[$x] .= $row[$x]['cod_fatura'];//$row[$x]['cod_pagamento'];
    $pagamento[$x] .= "|";
    $pagamento[$x] .= $row[$x]['cod_cliente'];
    $pagamento[$x] .= "|";
    $pagamento[$x] .= $row[$x]['cod_filial'];
    $pagamento[$x] .= "|";
    $pagamento[$x] .= $row[$x]['n_parcelas'];
    $pagamento[$x] .= "|";
    $pagamento[$x] .= $row[$x]['parcela_atual'];
    $pagamento[$x] .= "|";
    $pagamento[$x] .= $row[$x]['valor'];
    $pagamento[$x] .= "|";
    $pagamento[$x] .= $row[$x]['vencimento'];
    $pagamento[$x] .= "|";
    $pagamento[$x] .= $row[$x]['vencimento'];//data_pagamento
    $pagamento[$x] .= "|";
}

$first = count($row);
*/
$sql = "SELECT
   *
FROM
   site_fatura_info
WHERE
   data_vencimento BETWEEN '$ano/$mes/1' AND '$ano/$mes/$t_mes'
--AND
--   migrado = 0
";
$rz = pg_query($sql);
$resumo = pg_fetch_all($rz);

//print_r($pagamento);
$k = 0;
for($i=0;$i<pg_num_rows($rz);$i++){
   $sql = "SELECT SUM(valor*quantidade) as valor FROM site_fatura_produto WHERE cod_fatura = '{$resumo[$i]['cod_fatura']}'";
   $rd = pg_query($sql);
   $data = pg_fetch_array($rd);
   $par = explode("/", $resumo[$i]['parcela']);
   if($par[1] == "12"){
   $pagamento[$x+$k] .= $resumo[$i]['id'];
   $pagamento[$x+$k] .= "|";
   $pagamento[$x+$k] .= $resumo[$i]['cod_fatura'];//$row[$x]['cod_pagamento'];
   $pagamento[$x+$k] .= "|";
   $pagamento[$x+$k] .= $resumo[$i]['cod_cliente'];
   $pagamento[$x+$k] .= "|";
   $pagamento[$x+$k] .= $resumo[$i]['cod_filial'];
   $pagamento[$x+$k] .= "|";
   $pagamento[$x+$k] .= $resumo[$i]['parcela'];
   $pagamento[$x+$k] .= "|";
   $pagamento[$x+$k] .= $resumo[$i]['parcela'];
   $pagamento[$x+$k] .= "|";
   $pagamento[$x+$k] .= $data['valor'];
   $pagamento[$x+$k] .= "|";
   $pagamento[$x+$k] .= $resumo[$i]['data_vencimento'];
   $pagamento[$x+$k] .= "|";
   $pagamento[$x+$k] .= $resumo[$i]['data_vencimento'];//data_pagamento
   $pagamento[$x+$k] .= "|";
   $k++;
   }
}

//echo "<p>";
//print_r($pagamento);
//echo count($pagamento);
//*******************************************
//TABELA PARA CENTRALIZAÇÃO
//*******************************************
$p_mes = $mes+1;
$p_ano = $ano;
$a_ano = $ano;
if($p_mes >= 13){
    $p_mes = 1;
    $p_ano++;
}

$a_mes = $mes-1;
if($a_mes <= 0){
    $a_mes = 12;
    $a_ano--;
}

echo "<table border=0 width=350 >";
echo "<tr><td width=10>";
//echo "<input type=button value='Mês Anterior' class=button onClick=\"location.href='?mes=$a_mes&ano=$a_ano';\">";
echo "</td>";
echo "<td align=center width=330>";
echo "<a href='?s=mmd_index&mes=$a_mes&ano=$a_ano' class=fontebranca12><< </a>";
echo "<b>".$meses[str_pad($mes, 1)]." / ".$ano."</b>";
echo"<a href='?s=mmd_index&mes=$p_mes&ano=$p_ano' class=fontebranca12> >> </a>";
echo "</td>";
echo "<td align=right width=10>";
//echo"<input type=button value='Próximo Mês'class=button onClick=\"location.href='?mes=$p_mes&ano=$p_ano';\">";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table border=0 width=100% align=center>";
echo "<tr>";
echo "<td width=400 valign=top>";
echo "<table border=1 width=400 height=300 align=center cellpadding=0 cellspacing=0>";
echo "<tr>";
for($x=0;$x<7;$x++){
    echo "<td height=10 align=center width=70
    style='border: 1px solid;
    font-family: Verdana;
    /*background-color: $col_bg1;*/
    color:#FFFFFF;'
    >
    <b>";
    dia($x);
    echo "</b></td>";
}
echo "</tr>";
//*******************************************
//LOOP PRINCIPAL
//*******************************************
while($dmes <= $t_mes){
     echo "<tr>";
     //ACCERT OF VARIABLES - RESETS
     If($dia_semana > 6)
     {
         $dia_semana = 0;
     }
     $dsem = 0;
     $semana = 0;
     
     //Monta semana na agenda
     while($semana < 7){
         if($dsem>6){
             $dsem = 0;
         }
      $dtz = $ano."-".str_pad($mes, 2, "0", STR_PAD_LEFT)."-".str_pad($dmes, 2, "0", STR_PAD_LEFT);
      if($dmes <= $t_mes){
         if($dia_semana == $dsem){
                //*******************************************
                //VERIFICA PAGAMENTOS
                //*******************************************
                $n_pag_dia = 0;
                $pag_finalizados = 0;
                unset($pag);
                unset($temp);
                for($i=0;$i<count($pagamento);$i++){
                    $pag_u = explode("|", $pagamento[$i]);
                    $temp = str_pad($dmes, 2,"0",STR_PAD_LEFT)."-".str_pad($mes, 2,"0",STR_PAD_LEFT)."-".$ano;

                    //Se houver compromisso para este dia
                    if(date("d-m-Y", strtotime($pag_u[7])) == $temp){
                        $pag[$n_pag_dia] = $pagamento[$i];//explode("|", $compromisso[$i]);
                        $n_pag_dia++;
                    }else{
                       //se não houver pagamentos para este dia
                    }
                }

            //*******************************************
            //SE EH O DIA ATUAL (COLOCAR BORDA)
            //*******************************************
            if($dmes == $dia){
                   $total_dia = 0;//total para cada dia
                   if(count($pag)>0){
                   for($q = 0;$q<count($pag);$q++){
                       $t = explode("|", $pag[$q]);
                       $total_dia += $t[6];
                   }

                //se houver compromisso no dia
                       echo "<td  align=center width=70 height=40 onclick=\"search_a_date('{$dtz}');\" style='border: 2px solid;border-color: #000000;background-color:";print $total_dia >= $alvo ? $col_comp_fin : $col_comp;echo ";'><b>$dmes</b><br>";print $total_dia >= $alvo ? "<font color=#FFFFFF size=1>" : "<font color=#FFFFFF size=1>"; echo "R$ ".number_format($total_dia, 2, ',', '.')."</font></td>";
                   }else{
                       echo "<td  align=center width=70 height=40 onclick=\"search_a_date('{$dtz}');\" style='border: 2px solid;border-color: #000000;'><b>$dmes</b></td>";
                   }
            //*******************************************
            //SE NAO EH O DIA ATUAL (SEM BORDA)
            //*******************************************
            }else{
                   //$ret="";
                   $total_dia = 0;//total para cada dia
                   
                   if(count($pag)>0){
                   for($q = 0;$q<count($pag);$q++){
                       $t = explode("|", $pag[$q]);
                       $total_dia += $t[6];
                   }
                       echo "<td align=center width=70 height=40 onclick=\"search_a_date('{$dtz}');\" style='background-color:";print $total_dia >= $alvo ? $col_comp_fin : $col_comp;echo ";'>$dmes<br>";print $total_dia >= $alvo ? "<font color=#FFFFFF size=1>" : "<font color=#FFFFFF size=1>"; echo "R$ ".number_format($total_dia, 2, ',', '.')."</font></td>";
                   }else{
                       echo "<td align=center width=70 height=40 onclick=\"search_a_date('{$dtz}');\">$dmes</td>";
                   }


            }
             $dia_semana++;
             $dsem++;
             $dmes++;
         }else{
            //BEGIN OF CALENDAR - BLANK SPACES
            echo "<td  align=center width=70>&nbsp;</td>";
            $dsem++;
         }
      }else{
            //END OF CALENDAR - BLANK SPACES
            echo "<td  align=center width=70>&nbsp;</td>";
            $dsem++;
      }
         $semana++;
     }
    echo "</tr>";
}
echo "</table>";



//VERIFICAÇÃO -> DIAS NÃO DISPONÍVEIS
$sql = "SELECT sum(valor) as valor, data_vencimento FROM mmd_pagamentos GROUP BY data_vencimento ORDER BY data_vencimento";
$result = pg_query($conn, $sql);
$res = pg_fetch_all($result);
$dnd = array();//dias nao disponiveis

for($x=0;$x<count($res);$x++){
    //echo date("d/m/Y", strtotime($res[$x]['data_vencimento'])) ;
    //echo $res[$x]['valor'];
    if($res[$x]['valor'] >= $alvo){
        $dnd[] = date("d/m/Y", strtotime($res[$x]['data_vencimento']));
        //echo date("d/m/Y", strtotime($res[$x]['data_vencimento']));
    }
}

for($x=1;$x<$t_mes;$x++){
    $m = $x."/".$mes."/".$ano;
    if(!in_array($m, $dnd)){
        $dd[] = $x."/".$mes."/".$ano;
    }
}

echo "<p>";
$dias_aleatorios = array_rand($dd, 3);
/*
for($x=0;$x<count($dias_aleatorios);$x++){
    echo $dd[$dias_aleatorios[$x]];
    echo " | ";
}
*/

echo "<table width=100% border=0>";
    echo "<tr>";
        echo "<td align=center>";
/*
        echo "<center>
        Alvo: <span onclick=\"javascript:change_alvo();\" style=\"cursor:pointer;\">R$ ".number_format($alvo, 2, '.', ',')."</span>";
    echo "</td>";
    echo "</tr>";
    echo "<tr><td>";
*/


    echo "</td></tr>";
echo "</table>";





/*************************************************************************/
// RIGHT SIDE - RECEITAS DO MÊS
/*************************************************************************/
echo "</td>";
echo "<td valign=top>";
 /*
    echo "<table border=0 width=100% height=350 valign=top>";
    echo "<tr>";
    echo "<td style='color:#FFFFFF; font-family:verdana;' valign=top>";
        echo "<center><b></b></center>";
        echo "<center>";
       //echo "<input type=button value='Adicionar Receita' class='button' OnClick=\"window.open('adicionar.php?a=receita','page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=400');\">";
        echo "</center>";
        //echo "<p>";
        echo "<div id=compromisso style='color:#000000;font-size:12px;font-style:Verdana;'>";
        //echo "<center>Receitas este mês</center>";
        echo "<table width=100% border=1>";
        echo "<tr>";
        echo "<td width=120><center><b>Data</b></td>
        <td><center><b>Descritivo</b></td>
        <td width=120><center><b>Valor</b></td>
        <!-- <td width=20><b><Center>Parcela</b></td> -->";
        echo "</tr>";
        $soma = 0;
        for($x=0;$x<pg_num_rows($resulta);$x++){
        //$msg = "";
           echo "<TR>";
           echo "<td>".date("d/m/Y", strtotime($row[$x]['vencimento']))."</td>";
           echo "<td onMouseOver=\"return overlib('{$row[$x]['titulo']}');\" onMouseOut=\"return nd();\">{$row[$x]['titulo']}</td>";
           echo "<td align=right>R$ ".number_format($row[$x]['valor'], 2, ',','.')."</td>";
           //echo "<td align=center>{$row[$x]['parcela_atual']}/{$row[$x]['n_parcelas']}</td>";
           echo "</TR>";
           $soma += $row[$x]['valor'];
        }
        echo "</table>";
        
        echo "<table width=100% border=1>";
        echo "<tr>";
        echo "<td width=120><b>Total</b></td>";
        echo "<td align=right><b>R$ ".number_format($soma, 2, ',','.')."</b></td>";
        echo "</tr>";
        echo "</table>";


        echo "</div>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";   */
    echo "<table width=100% border=0>";
    echo "<tr>";
        echo "<td width=30 height=30 style='border: 1px solid;'>&nbsp;</td>";
        echo "<td>Dia sem receita</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td width=30 height=30 style='border: 1px solid;background-color:$col_comp_fin;'>&nbsp;</td>";
        echo "<td>Alvo diário alcançado (R$ <span id=alvo1>".number_format($alvo, 2, '.', ',')."</span>)</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td width=30 height=30 style='border: 1px solid;background-color:$col_comp;'>&nbsp;</td>";
        echo "<td>Abaixo do alvo diário (R$ <span id=alvo2>".number_format($alvo, 2, '.', ',')."</span>)</td>";
    echo "</tr>";
    echo "</table>";

    echo "<p>";
    
    echo "<input type=button value='Alterar valor alvo' onclick='change_alvo();'>";
    
    echo "<p>";
    
    echo "<table width=100% border=0>";
    echo "<tr>";
    echo "   <td colspan=2><b>Pesquisa por período</b></td>";
    echo "</tr>";
    echo "<tr>";
    echo "   <td width=60>Inicio:</td>";
    echo "   <td><input type=text size=2 maxlength=2 name=dia_i id=dia_i onkeyup=\"change_field(this);\"> / <input type=text maxlength=2 size=2 name=mes_i id=mes_i onkeyup=\"change_field(this);\"> / <input type=text maxlength=4 size=4 name=ano_i id=ano_i onkeyup=\"change_field(this);\"></td>";
    echo "</tr>";
    echo "<tr>";
    echo "   <td width=60>Término:</td>";
    echo "   <td><input type=text size=2 maxlength=2 name=dia_f id=dia_f onkeyup=\"change_field(this);\"> / <input type=text maxlength=2 size=2 name=mes_f id=mes_f onkeyup=\"change_field(this);\"> / <input type=text maxlength=4 size=4 name=ano_f id=ano_f onkeyup=\"change_field(this);\"></td>";
    echo "</tr>";
    echo "<tr>";
    echo "   <td colspan=2 align=center><input type=button value='Pesquisar' name='btnSearch' id='btnSearch' onclick=\"search_by_date();\"></td>";
    echo "</tr>";
    echo "</table>";
    

echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table border=0 width=100%>";
echo "<tr>";
echo "   <td valign=top><div id=conteudo></div></td>";
echo "</tr>";
echo "</table>";

?>
