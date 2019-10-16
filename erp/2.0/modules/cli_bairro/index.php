<?PHP
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
function convertwords($text){
$siglas = array("ppp", "ppra", "pcmso", "aso", "cipa", "apgre", "ltcat", "epi", "me", "ltda", "av", "rj", //Siglas normais
				"ppp,", "ppra,", "pcmso,", "aso,", "cipa,", "apgre,", "ltcat,", "epi,", "me,", "ltda,", "av,", //Siglas com vírgula
				"(ppp)", "(ppra)", "(pcmso)", "(aso)", "(cipa)", "(apgre)", "(ltcat)", "(epi)", "(me)", "(ltda)", "(av)", //Siglas entre parênteses
				"nr", "nr.", "mr", "mr.", "in", "in.", "nbr", "nbr.", "me.", "ltda.", "av.", "a0", "a3", "a4", "(a4)"); //Siglas diversas
$at = explode(" ", $text);
$temp = "";
for($x=0;$x<count($at);$x++){
   $at[$x] = strtolower($at[$x]);
   $at[$x] = strtr(strtolower($at[$x]),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");

  if(in_array($at[$x], $siglas)){
     $at[$x] = strtoupper($at[$x]);
  }elseif(strlen($at[$x])>2){
        $at[$x] = ucwords($at[$x]);
    }
	$temp .= $at[$x]." ";
}
return $temp;
}


$sql = "
(SELECT DISTINCT TRIM(both ' ' from lower(cliente.bairro)) as bairro FROM cliente WHERE bairro <> '')
UNION
(SELECT DISTINCT TRIM(both ' ' from lower(cliente_comercial.bairro)) as bairro FROM cliente_comercial  WHERE bairro <> '') ORDER BY bairro";
$res = pg_query($connect, $sql);
$buffer = pg_fetch_all($res);

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE STEP OF PPRA!!!
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
            //BUSCA DOS CLIENTES POR BAIRRO
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Pesquisar Bairro</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<form method=POST name='form1' action='?dir=cli_bairro&p=index'>";
					echo "<tr class='roundbordermix text'>";
                    echo "<td class='roundborder text' height=30 align=center >";
					echo "<select name=search style=\"width:230px;\">";
					for($x=0;$x<pg_num_rows($res);$x++){
					   echo "<option value='{$buffer[$x]['bairro']}'"; print $buffer[$x]['bairro'] == $_POST['search'] ? "SELECTED" : ""; echo ">".convertwords($buffer[$x]['bairro'])."</option>";
					}
					echo "</select></td>";
					echo "</tr>";
					
					echo "<tr>";
                    echo "<td class='roundbordermix text' colspan=2 align=center><input type='submit' class='btn' name='btnSearch' value='Busca' onclick=\"if(document.getElementById('search').value==''){return false;}\">";
                    echo "</td>";
                	echo "</tr>";
				echo "</form>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";
                // --> TIPBOX
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class=text height=30 valign=top align=justify>";
                        echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
        echo "</td>";

/**************************************************************************************************/
// -->  RIGHT SIDE
/**************************************************************************************************/
    echo "<td class='text roundborder' valign=top>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'><b>Lista de Clientes por Localidade</b></td>";
        echo "</tr>";
        echo "</table>";

if($_POST){
$sql = "
(SELECT razao_social, telefone, email, endereco, num_end, estado FROM cliente WHERE TRIM(both ' ' from lower(bairro)) = '{$_POST['search']}' ORDER BY razao_social)
UNION
(SELECT razao_social, telefone, email, endereco, num_end, estado FROM cliente_comercial WHERE TRIM(both ' ' from lower(bairro)) = '{$_POST['search']}' ORDER BY razao_social)
";
$result = pg_query($sql);
$data = pg_fetch_all($result);

	echo "<table width=100% border=0 align=center cellpadding=5 cellspacing=0>";
	echo "<tr>";
	echo "<td width=10 class='text' >Nº</td>";
	echo "<td width=200 class='text' >Razão Social</td>";
	echo "<td width=110 class='text' >Telefone</td>";
	echo "<td width=150 class='text' >E-mail</td>";
	echo "<td class='text' >Endereço</td>";
	echo "</tr>";
	
	for($x=0;$x<pg_num_rows($result);$x++){
	echo "<tr class='text roundbordermix'>";
	echo "<td align=center class='text roundborder' >".($x+1)."&nbsp;</td>";
	echo "<td class='text roundborder' >{$data[$x]['razao_social']}&nbsp;</td>";
	echo "<td class='text roundborder' >{$data[$x]['telefone']}&nbsp;</td>";
	echo "<td class='text roundborder' >{$data[$x]['email']}&nbsp;</td>";
	echo "<td class='text roundborder' >{$data[$x]['endereco']} {$data[$x]['num_end']} - {$data[$x]['estado']}&nbsp;</td>";
	echo "</tr>";
	}
	echo "</table>";
}
/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>
