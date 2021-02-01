<center><img src='images/colaboradores.jpg' border=0></center>
<p align=justify>
<?PHP
$sql = "SELECT * FROM funcionarios  
		WHERE cod_cliente = $_SESSION[cod_cliente] 
		ORDER BY nome_func";
$res = pg_query($sql);
$col = pg_fetch_all($res);

echo "<table width=100% border=0>";
echo "<tr>";
    echo "<td class='bgTitle' align='center' width='85%'>Nome</td>";
    echo "<td class='bgTitle' align='center' width='15%'>Opções</td>";
echo "</tr>";
for($x=0;$x<pg_num_rows($res);$x++){
    if($x%2){
            $bgclass = 'bgContent1';
    }else{
            $bgclass = 'bgContent2';
    }   
    echo "<tr>";
    echo "<td class='$bgclass'>&nbsp;{$col[$x][nome_func]}</td>";
    echo "<td class='$bgclass' align=center>";
	echo '<a target=_blank href="erp/2.0/modules/cgrt/relatorios/ppp/?cliente='.base64_encode((int)($col[$x][cod_cliente])).'&setor='.base64_encode((int)($col[$x][cod_setor])).'&funcionario='.base64_encode((int)($col[$x][cod_func])).'&cod_cgrt='.base64_encode((int)($col[$x][cod_cgrt])).'"><img src=\'images/ico-view.png\' border=0 alt=\'Visualizar PPP\' title=\'Visualizar PPP\'></a>';		
    echo "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<BR>";
echo "<b>Legenda:</b>";
echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
echo "<tr>";
echo "<td width=25><img src='images/ico-view.png' border=0 alt='Visualizar PPP' title='Visualizar PPP'></td><td><font size=1>Visualizar PPP.</font></td>";
echo "</tr>";
echo "</table>";

?>