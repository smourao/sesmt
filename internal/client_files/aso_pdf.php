<center><img src='images/colaboradores.jpg' border=0></center>
<p align=justify>
<?PHP
echo "<table width=40% style='margin-left:160px'>";
echo "<tr>";
echo "<td><input type=button value='Funcion�rios Ativos' onclick=\"location.href='?do=aso_pdf&act=ativos';\"></td>";
echo "<td><input type=button value='Funcion�rios Inativos' onclick=\"location.href='?do=aso_pdf&act=inativos';\"></td>";
echo "</tr>";
echo "</table>";
echo "<p align=justify>";








if($_GET[act] == "ativos"){

$sqlulano = "SELECT a.aso_data FROM funcionarios f, aso a  
		WHERE f.cod_cliente = $_SESSION[cod_cliente] 
		AND f.cod_func = a.cod_func 
		AND a.cod_cliente = $_SESSION[cod_cliente]
		AND f.cod_status = 1
		AND a.aso_resultado !='' ORDER BY aso_data DESC";
$resulano = pg_query($sqlulano);
$colulano = pg_fetch_all($resulano);

$ulano = $colulano[0]["aso_data"];


$dt 			= 	explode('-', $ulano);
$ulano			=	$dt[0];





$sqlpriano = "SELECT a.aso_data FROM funcionarios f, aso a  
		WHERE f.cod_cliente = $_SESSION[cod_cliente] 
		AND f.cod_func = a.cod_func 
		AND a.cod_cliente = $_SESSION[cod_cliente]
		AND f.cod_status = 1
		AND a.aso_resultado !='' ORDER BY aso_data ASC";
$respriano = pg_query($sqlpriano);
$colpriano = pg_fetch_all($respriano);

$priano = $colpriano[0]["aso_data"];


$dt 			= 	explode('-', $priano);
$priano			=	$dt[0];

echo "Ano: ";
for($x=$priano;$x<=$ulano;$x++){
	echo "<a href='?do=aso_pdf&act=ativos&ano=$x'>".$x."</a>";
	if($x == $ulano){
		echo "";
	}else{
		echo " | ";	
	}
}




if(!$_GET[ano]){




$sql = "SELECT f.*, a.* FROM funcionarios f, aso a  
		WHERE f.cod_cliente = $_SESSION[cod_cliente] 
		AND f.cod_func = a.cod_func 
		AND a.cod_cliente = $_SESSION[cod_cliente]
		AND f.cod_status = 1
		AND a.aso_resultado !='' ORDER BY nome_func ASC";
$res = pg_query($sql);
$col = pg_fetch_all($res);




echo "<table width=100% border=0>";
echo "<tr>";
    echo "<td class='bgTitle' align='center' width='20%'>C�d. ASO</td>";
    echo "<td class='bgTitle' align='center' width='65%'>Nome</td>";
    echo "<td class='bgTitle' align='center' width='15%'>Op��es</td>";
echo "</tr>";
for($x=0;$x<pg_num_rows($res);$x++){
    if($x%2)
            $bgclass = 'bgContent1';
        else
            $bgclass = 'bgContent2';
            
    echo "<tr>";
		echo "<td class='$bgclass' align=center>{$col[$x][cod_aso]}</td>";
        echo "<td class='$bgclass'>&nbsp;{$col[$x][nome_func]}</td>";
        echo "<td class='$bgclass' align=center>";		


		if(file_exists("erp/2.0/modules/gerar_aso/exame/aso_pdf/".$col[$x][cod_cliente]."/ASO_".$col[$x][cod_aso].".pdf") && $tpermiss[acesso_colaboradores] == 1 && $col[$x][aso_resultado] != ""){
			
			
	echo '<a target=_blank href="erp/2.0/modules/gerar_aso/exame/?cod_cliente='.$col[$x][cod_cliente].'&setor='.$col[$x][cod_setor].'&funcionario='.$col[$x][cod_func].'&aso='.$col[$x][cod_aso].'"><img src=\'images/ico-view.png\' border=0 alt=\'Visualizar ASO\' title=\'Visualizar ASO\'> </a>';

		$cc = $col[$x][cod_cliente];
		$ca = $col[$x][cod_aso];
		
	echo '<a target=_blank href="erp/2.0/modules/gerar_aso/exame/verifica.php?arquivo=aso_pdf/'.$cc.'/ASO_'.$ca.'.pdf"> <img src=\'images/ico-down.png\' border=0 alt=\'Baixar ASO\' title=\'Baixar ASO\'></a>';
	
	
	
		}else{
            echo "<img src='images/ico-del.png' border=0 alt='ASO n�o Dispon�vel!' title='ASO n�o Dispon�vel!'>&nbsp;";
		}
		
        echo "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<BR>";
echo "<b>Legenda:</b>";
echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
echo "<tr>";
echo "<td width=25><img src='images/ico-view.png' border=0 alt='Visualizar ASO' title='Visualizar ASO'></td><td><font size=1>Visualizar ASO.</font></td>";
echo "</tr><tr>";
echo "<td width=25><img src='images/ico-down.png' border=0 alt='Baixar ASO' title='Baixar ASO'></td><td><font size=1>Fazer Download do ASO formato PDF. Caso n�o tenha um leitor de PDF fa�a download e instale clicando no bot�o abaixo:</font></td>";
echo "</tr></table>";
echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
echo "<tr><td width=25></td><td><a target=_blank href='http://get.adobe.com/br/reader/'><img src='images/Adobe-Reader-Download.jpg' border=0 alt='Get Adobe Reader' title='Get Adobe Reader' width='110' height='30'></a></td>";
echo "</tr>";
echo "</table><p>";
echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
echo "<tr><td ><img src='images/ico-del.png' border=0 alt='ASO Indispon�vel' title='ASO Indispon�vel'></td><td><font size=1>ASO Indispon�vel, a visualiza��o s� estar� dispon�vel quando os exames complementares agendados na cl�nica escolhida forem feitos e confirmados, caso j� tenham sido feitos entre em contato atrav�s do email: suporte@ti-seg.com.</font></td>";
echo "</tr>";
echo "</table>";











}else if($_GET[ano] !=''){

$anopes = $_GET['ano'];

$comecodata = $anopes."-01-01";


$fimdata = $anopes."-12-31";



$sql = "SELECT f.*, a.* FROM funcionarios f, aso a  
		WHERE f.cod_cliente = $_SESSION[cod_cliente] 
		AND f.cod_func = a.cod_func 
		AND a.cod_cliente = $_SESSION[cod_cliente]
		AND f.cod_status = 1
		AND a.aso_resultado !=''
		AND a.aso_data between '$comecodata' and '$fimdata' ORDER BY nome_func ASC";
$res = pg_query($sql);
$col = pg_fetch_all($res);







echo "<table width=100% border=0>";
echo "<tr>";
    echo "<td class='bgTitle' align='center' width='20%'>C�d. ASO</td>";
    echo "<td class='bgTitle' align='center' width='65%'>Nome</td>";
    echo "<td class='bgTitle' align='center' width='15%'>Op��es</td>";
echo "</tr>";
for($x=0;$x<pg_num_rows($res);$x++){
    if($x%2)
            $bgclass = 'bgContent1';
        else
            $bgclass = 'bgContent2';
            
    echo "<tr>";
		echo "<td class='$bgclass' align=center>{$col[$x][cod_aso]}</td>";
        echo "<td class='$bgclass'>&nbsp;{$col[$x][nome_func]}</td>";
        echo "<td class='$bgclass' align=center>";		


		if(file_exists("erp/2.0/modules/gerar_aso/exame/aso_pdf/".$col[$x][cod_cliente]."/ASO_".$col[$x][cod_aso].".pdf") && $tpermiss[acesso_colaboradores] == 1 && $col[$x][aso_resultado] != ""){
			
			
	echo '<a target=_blank href="erp/2.0/modules/gerar_aso/exame/?cod_cliente='.$col[$x][cod_cliente].'&setor='.$col[$x][cod_setor].'&funcionario='.$col[$x][cod_func].'&aso='.$col[$x][cod_aso].'"><img src=\'images/ico-view.png\' border=0 alt=\'Visualizar ASO\' title=\'Visualizar ASO\'> </a>';

		$cc = $col[$x][cod_cliente];
		$ca = $col[$x][cod_aso];
		
	echo '<a target=_blank href="erp/2.0/modules/gerar_aso/exame/verifica.php?arquivo=aso_pdf/'.$cc.'/ASO_'.$ca.'.pdf"> <img src=\'images/ico-down.png\' border=0 alt=\'Baixar ASO\' title=\'Baixar ASO\'></a>';
	
	
	
		}else{
            echo "<img src='images/ico-del.png' border=0 alt='ASO n�o Dispon�vel!' title='ASO n�o Dispon�vel!'>&nbsp;";
		}
		
        echo "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<BR>";
echo "<b>Legenda:</b>";
echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
echo "<tr>";
echo "<td width=25><img src='images/ico-view.png' border=0 alt='Visualizar ASO' title='Visualizar ASO'></td><td><font size=1>Visualizar ASO.</font></td>";
echo "</tr><tr>";
echo "<td width=25><img src='images/ico-down.png' border=0 alt='Baixar ASO' title='Baixar ASO'></td><td><font size=1>Fazer Download do ASO formato PDF. Caso n�o tenha um leitor de PDF fa�a download e instale clicando no bot�o abaixo:</font></td>";
echo "</tr></table>";
echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
echo "<tr><td width=25></td><td><a target=_blank href='http://get.adobe.com/br/reader/'><img src='images/Adobe-Reader-Download.jpg' border=0 alt='Get Adobe Reader' title='Get Adobe Reader' width='110' height='30'></a></td>";
echo "</tr>";
echo "</table><p>";
echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
echo "<tr><td ><img src='images/ico-del.png' border=0 alt='ASO Indispon�vel' title='ASO Indispon�vel'></td><td><font size=1>ASO Indispon�vel, a visualiza��o s� estar� dispon�vel quando os exames complementares agendados na cl�nica escolhida forem feitos e confirmados, caso j� tenham sido feitos entre em contato atrav�s do email: suporte@ti-seg.com.</font></td>";
echo "</tr>";
echo "</table>";


}



}else if($_GET[act] == "inativos"){
	
	
$sqlulano = "SELECT a.aso_data FROM funcionarios f, aso a  
		WHERE f.cod_cliente = $_SESSION[cod_cliente] 
		AND f.cod_func = a.cod_func 
		AND a.cod_cliente = $_SESSION[cod_cliente]
		AND f.cod_status = 0
		AND a.aso_resultado !='' ORDER BY aso_data DESC";
$resulano = pg_query($sqlulano);
$colulano = pg_fetch_all($resulano);

$ulano = $colulano[0]["aso_data"];


$dt 			= 	explode('-', $ulano);
$ulano			=	$dt[0];





$sqlpriano = "SELECT a.aso_data FROM funcionarios f, aso a  
		WHERE f.cod_cliente = $_SESSION[cod_cliente] 
		AND f.cod_func = a.cod_func 
		AND a.cod_cliente = $_SESSION[cod_cliente]
		AND f.cod_status = 0
		AND a.aso_resultado !='' ORDER BY aso_data ASC";
$respriano = pg_query($sqlpriano);
$colpriano = pg_fetch_all($respriano);

$priano = $colpriano[0]["aso_data"];


$dt 			= 	explode('-', $priano);
$priano			=	$dt[0];


echo "Ano: ";
for($x=$priano;$x<=$ulano;$x++){
	echo "<a href='?do=aso_pdf&act=inativos&ano=$x'>".$x."</a>";
	if($x == $ulano){
		echo "";
	}else{
		echo " | ";	
	}
}
	


if(!$_GET[ano]){




$sql = "SELECT f.*, a.* FROM funcionarios f, aso a  
		WHERE f.cod_cliente = $_SESSION[cod_cliente] 
		AND f.cod_func = a.cod_func 
		AND a.cod_cliente = $_SESSION[cod_cliente]
		AND f.cod_status = 0
		AND a.aso_resultado !='' ORDER BY nome_func ASC";
$res = pg_query($sql);
$col = pg_fetch_all($res);




echo "<table width=100% border=0>";
echo "<tr>";
    echo "<td class='bgTitle' align='center' width='20%'>C�d. ASO</td>";
    echo "<td class='bgTitle' align='center' width='65%'>Nome</td>";
    echo "<td class='bgTitle' align='center' width='15%'>Op��es</td>";
echo "</tr>";
for($x=0;$x<pg_num_rows($res);$x++){
    if($x%2)
            $bgclass = 'bgContent1';
        else
            $bgclass = 'bgContent2';
            
    echo "<tr>";
		echo "<td class='$bgclass' align=center>{$col[$x][cod_aso]}</td>";
        echo "<td class='$bgclass'>&nbsp;{$col[$x][nome_func]}</td>";
        echo "<td class='$bgclass' align=center>";		


		if(file_exists("erp/2.0/modules/gerar_aso/exame/aso_pdf/".$col[$x][cod_cliente]."/ASO_".$col[$x][cod_aso].".pdf") && $tpermiss[acesso_colaboradores] == 1 && $col[$x][aso_resultado] != ""){
			
			
	echo '<a target=_blank href="erp/2.0/modules/gerar_aso/exame/?cod_cliente='.$col[$x][cod_cliente].'&setor='.$col[$x][cod_setor].'&funcionario='.$col[$x][cod_func].'&aso='.$col[$x][cod_aso].'"><img src=\'images/ico-view.png\' border=0 alt=\'Visualizar ASO\' title=\'Visualizar ASO\'> </a>';

		$cc = $col[$x][cod_cliente];
		$ca = $col[$x][cod_aso];
		
	echo '<a target=_blank href="erp/2.0/modules/gerar_aso/exame/verifica.php?arquivo=aso_pdf/'.$cc.'/ASO_'.$ca.'.pdf"> <img src=\'images/ico-down.png\' border=0 alt=\'Baixar ASO\' title=\'Baixar ASO\'></a>';
	
	
	
		}else{
            echo "<img src='images/ico-del.png' border=0 alt='ASO n�o Dispon�vel!' title='ASO n�o Dispon�vel!'>&nbsp;";
		}
		
        echo "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<BR>";
echo "<b>Legenda:</b>";
echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
echo "<tr>";
echo "<td width=25><img src='images/ico-view.png' border=0 alt='Visualizar ASO' title='Visualizar ASO'></td><td><font size=1>Visualizar ASO.</font></td>";
echo "</tr><tr>";
echo "<td width=25><img src='images/ico-down.png' border=0 alt='Baixar ASO' title='Baixar ASO'></td><td><font size=1>Fazer Download do ASO formato PDF. Caso n�o tenha um leitor de PDF fa�a download e instale clicando no bot�o abaixo:</font></td>";
echo "</tr></table>";
echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
echo "<tr><td width=25></td><td><a target=_blank href='http://get.adobe.com/br/reader/'><img src='images/Adobe-Reader-Download.jpg' border=0 alt='Get Adobe Reader' title='Get Adobe Reader' width='110' height='30'></a></td>";
echo "</tr>";
echo "</table><p>";
echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
echo "<tr><td ><img src='images/ico-del.png' border=0 alt='ASO Indispon�vel' title='ASO Indispon�vel'></td><td><font size=1>ASO Indispon�vel, a visualiza��o s� estar� dispon�vel quando os exames complementares agendados na cl�nica escolhida forem feitos e confirmados, caso j� tenham sido feitos entre em contato atrav�s do email: suporte@ti-seg.com.</font></td>";
echo "</tr>";
echo "</table>";

}






	
	
if($_GET[ano] !=''){

$anopes = $_GET['ano'];

$comecodata = $anopes."-01-01";


$fimdata = $anopes."-12-31";



$sql = "SELECT f.*, a.* FROM funcionarios f, aso a  
		WHERE f.cod_cliente = $_SESSION[cod_cliente] 
		AND f.cod_func = a.cod_func 
		AND a.cod_cliente = $_SESSION[cod_cliente]
		AND f.cod_status = 0
		AND a.aso_resultado !=''
		AND a.aso_data between '$comecodata' and '$fimdata' ORDER BY nome_func ASC";
$res = pg_query($sql);
$col = pg_fetch_all($res);




echo "<table width=100% border=0>";
echo "<tr>";
    echo "<td class='bgTitle' align='center' width='20%'>C�d. ASO</td>";
    echo "<td class='bgTitle' align='center' width='65%'>Nome</td>";
    echo "<td class='bgTitle' align='center' width='15%'>Op��es</td>";
echo "</tr>";
for($x=0;$x<pg_num_rows($res);$x++){
    if($x%2)
            $bgclass = 'bgContent1';
        else
            $bgclass = 'bgContent2';
            
    echo "<tr>";
		echo "<td class='$bgclass' align=center>{$col[$x][cod_aso]}</td>";
        echo "<td class='$bgclass'>&nbsp;{$col[$x][nome_func]}</td>";
        echo "<td class='$bgclass' align=center>";		


		if(file_exists("erp/2.0/modules/gerar_aso/exame/aso_pdf/".$col[$x][cod_cliente]."/ASO_".$col[$x][cod_aso].".pdf") && $tpermiss[acesso_colaboradores] == 1 && $col[$x][aso_resultado] != ""){
			
			
	echo '<a target=_blank href="erp/2.0/modules/gerar_aso/exame/?cod_cliente='.$col[$x][cod_cliente].'&setor='.$col[$x][cod_setor].'&funcionario='.$col[$x][cod_func].'&aso='.$col[$x][cod_aso].'"><img src=\'images/ico-view.png\' border=0 alt=\'Visualizar ASO\' title=\'Visualizar ASO\'> </a>';

		$cc = $col[$x][cod_cliente];
		$ca = $col[$x][cod_aso];
		
	echo '<a target=_blank href="erp/2.0/modules/gerar_aso/exame/verifica.php?arquivo=aso_pdf/'.$cc.'/ASO_'.$ca.'.pdf"> <img src=\'images/ico-down.png\' border=0 alt=\'Baixar ASO\' title=\'Baixar ASO\'></a>';
	
	
	
		}else{
            echo "<img src='images/ico-del.png' border=0 alt='ASO n�o Dispon�vel!' title='ASO n�o Dispon�vel!'>&nbsp;";
		}
		
        echo "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<BR>";
echo "<b>Legenda:</b>";
echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
echo "<tr>";
echo "<td width=25><img src='images/ico-view.png' border=0 alt='Visualizar ASO' title='Visualizar ASO'></td><td><font size=1>Visualizar ASO.</font></td>";
echo "</tr><tr>";
echo "<td width=25><img src='images/ico-down.png' border=0 alt='Baixar ASO' title='Baixar ASO'></td><td><font size=1>Fazer Download do ASO formato PDF. Caso n�o tenha um leitor de PDF fa�a download e instale clicando no bot�o abaixo:</font></td>";
echo "</tr></table>";
echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
echo "<tr><td width=25></td><td><a target=_blank href='http://get.adobe.com/br/reader/'><img src='images/Adobe-Reader-Download.jpg' border=0 alt='Get Adobe Reader' title='Get Adobe Reader' width='110' height='30'></a></td>";
echo "</tr>";
echo "</table><p>";
echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
echo "<tr><td ><img src='images/ico-del.png' border=0 alt='ASO Indispon�vel' title='ASO Indispon�vel'></td><td><font size=1>ASO Indispon�vel, a visualiza��o s� estar� dispon�vel quando os exames complementares agendados na cl�nica escolhida forem feitos e confirmados, caso j� tenham sido feitos entre em contato atrav�s do email: suporte@ti-seg.com.</font></td>";
echo "</tr>";
echo "</table>";
	
	
	
	
	
}
	
}



?>