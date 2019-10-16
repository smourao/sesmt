<?PHP
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
$func = $_POST['f'];
$risco = $_POST['risco'];

   if($func >= 50 && $func <=100){
	  $table = 1;
   }elseif($func >= 101 && $func <=250){
	  $table = 2;
   }elseif($func >= 251 && $func <=500){
	  $table = 3;
   }elseif($func >= 501 && $func <=1000){
	  $table = 4;
   }elseif($func >= 1001 && $func <=2000){
	  $table = 5;
   }elseif($func >= 2001 && $func <=3500){
	  $table = 6;
   }elseif($func >= 3501 && $func <=5000){
	  $table = 7;
   }elseif($func > 5000){
	  $table = 8;
   }else{
   }
echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE STEP OF PPRA!!!
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
            //BUSCA DO DIMENSIONAMENTO DA EMPRESA
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Busca do Dimensionamento</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<form method=POST name='form1' action='?dir=dimensionamento&p=index'>";
					echo "<tr class='roundbordermix text'>";
                    echo "<td class='roundborder text' height=30 align=center >N&deg; de Colaboradores</td>";
                    echo "<td class='roundborder text' height=30 align=center onmouseover=\"showtip('tipbox', '- Digite o número de colaboradores da empresa no campo.');\" onmouseout=\"hidetip('tipbox');\">";
					echo "<input type='text' class='inputText' name='f' id='f' size=5 maxlength=5></td>";
					echo "</tr>";
					
					echo "<tr class='roundbordermix text'>";
					echo "<td class='roundborder text' height=30 align=center >Grau de Risco</td>";
                    echo "<td class='roundborder text' height=30 align=center onmouseover=\"showtip('tipbox', '- Digite o grau de risco da empresa no campo.');\" onmouseout=\"hidetip('tipbox');\">";
                    echo "<input type='text' class='inputText' name='risco' id='risco' size=5 maxlength=5></td>";
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
// -->  RIGHT SIDE STEP OF PPRA!!!
/**************************************************************************************************/
    echo "<td class='text roundborder' valign=top>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'><b>Dimensionamento do SESMT</b></td>";
        echo "</tr>";
        echo "</table>";

		if($risco != ""){
			$sql = "SELECT * FROM cons_dim WHERE risco=".$risco;
			$result = pg_query($connect, $sql);
			$row = pg_fetch_all($result);
		echo "<br><table width=100% border=0 cellpadding=2 cellspacing=2>";
			for($x=0;$x<pg_num_rows($result);$x++){
			   $t = "fun".$table;
				echo "<tr>
					<td width=80% class='text roundborderselected'>";
			   if($row[$x][$t]!=""){
				  echo $row[$x]['tecnicas']."</td>
					<td width=20% class='text roundborderselected'>".$row[$x][$t]."</td>";
			   }else{
				  echo $row[$x]['tecnicas']."</td>
					<td width=20% class='text roundborderselected'> Não necessário.</td>";
			   }
		echo "</td></tr>";
			}
		echo "</table>";
		
		echo "<br><table width=100% border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td class=text>(*) Tempo parcial (mínimo de três horas).<br>&nbsp;</td>
				</tr>
				<tr>
					<td class=text>(**) O dimensionamento total deverá ser feito levando-se em consideração o dimensionamento de faixas de 3501 a 5000 mais o dimensionamento do(s) grupo(s) de 4000 ou fração acima de 2000.<br>&nbsp;</td>
				</tr>
				<tr>
					<td class=text>OBS: Hospitais, Ambulatórios, Maternidade, Casas de Saúde e Repouso, Clínicas e estabelecimentos similares com mais de 500 (quinhentos) empregados deverão contratar um Enfermeiro em tempo integral.</td>
				</tr>
			</table>";
		}
/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>
