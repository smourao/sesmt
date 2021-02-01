<center><img src='images/colaboradores.jpg' border=0></center>
<p align=justify>
<?PHP
$sql = "SELECT f.*, a.* FROM funcionarios f, aso a  
		WHERE f.cod_cliente = $_SESSION[cod_cliente] 
		AND f.cod_func = a.cod_func 
		AND a.cod_cliente = $_SESSION[cod_cliente] ORDER BY cod_aso";
$res = pg_query($sql);
$col = pg_fetch_all($res);

echo "<table width=100% border=0>";
echo "<tr>";
    echo "<td class='bgTitle' align='center' width='20%'>Cód. ASO</td>";
    echo "<td class='bgTitle' align='center' width='65%'>Nome</td>";
    echo "<td class='bgTitle' align='center' width='15%'>Opções</td>";
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
			
			
	echo '<a target=_blank href="erp/2.0/modules/gerar_aso/exame/aso_pdf/'.$col[$x][cod_cliente].'/ASO_'.$col[$x][cod_aso].'.pdf"><img src=\'images/ico-view.png\' border=0 alt=\'Visualizar ASO\' title=\'Visualizar ASO\'> </a>';

		$cc = $col[$x][cod_cliente];
		$ca = $col[$x][cod_aso];
		
	echo '<a target=_blank href="erp/2.0/modules/gerar_aso/exame/verifica.php?arquivo=aso_pdf/'.$cc.'/ASO_'.$ca.'.pdf"> <img src=\'images/ico-down.png\' border=0 alt=\'Baixar ASO\' title=\'Baixar ASO\'></a>';
	
	
	
		}else{
            echo "<img src='images/ico-del.png' border=0 alt='ASO não Disponível!' title='ASO não Disponível!'>&nbsp;";
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
echo "<td width=25><img src='images/ico-down.png' border=0 alt='Baixar ASO' title='Baixar ASO'></td><td><font size=1>Fazer Download do ASO formato PDF. Caso não tenha um leitor de PDF faça download e instale clicando no botão abaixo:</font></td>";
echo "</tr></table>";
echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
echo "<tr><td width=25></td><td><a target=_blank href='http://get.adobe.com/br/reader/'><img src='images/Adobe-Reader-Download.jpg' border=0 alt='Get Adobe Reader' title='Get Adobe Reader' width='110' height='30'></a></td>";
echo "</tr>";
echo "</table><p>";
echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
echo "<tr><td ><img src='images/ico-del.png' border=0 alt='ASO Indisponível' title='ASO Indisponível'></td><td><font size=1>ASO Indisponível, a visualização só estará disponível quando os exames complementares agendados na clínica escolhida forem feitos e confirmados, caso já tenham sido feitos entre em contato através do email: suporte@ti-seg.com.</font></td>";
echo "</tr>";
echo "</table>";

?>