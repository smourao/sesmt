<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Untitled Document</title>
</head>

<body>

<center><img src='images/titles_boleto.png' border=0></center>


<img src='images/sub-title-left_boleto.png' border=0>
<div class='novidades_text'>
<p align=justify>
A lista abaixo exibe todos os boletos gerados at&eacute; o momento. &Eacute; poss&iacute;vel a visualiza&ccedil;&atilde;o e pedir a segunda via de todos os boletos
<p align=justify>
Para visualizar um boleto, clique no &iacute;cone <img src='images/ico-view.png' border=0 alt='Visualizar Boleto' title='Visualizar Boleto'>
que corresponde ao boleto que deseja visualizar.

</div>
<?PHP

$verboletosql = "SELECT * FROM cliente_boleto WHERE cod_cliente = ".(int)($_SESSION[cod_cliente])." ORDER BY id DESC ";
$verboletoquery = pg_query($verboletosql);
$verboleto = pg_fetch_all($verboletoquery);
$verboletonum = pg_num_rows($verboletoquery);



    echo "<center><input type=button value='Fazer 2° via' onclick=\"location.href='https://www63.bb.com.br/portalbb/boleto/boletos/hc21e,999,3322,10343.bbx';\"></center>";
	
	echo "<p /><table width=100% cellspacing=2 cellpadding=2 border=0>";
    echo "<tr>";
        echo "<td class='bgTitle' align=center width=60>Código</td>";
        echo "<td class='bgTitle' align=center width=100>Gerado em</td>";
		echo "<td class='bgTitle' align=center width=100>Vencimento</td>";
        echo "<td class='bgTitle' align=center width=100>Visualizar</td>";
    echo "</tr>";
	
	for($x=0;$x<$verboletonum;$x++){
        if($x%2)
            $bgclass = 'bgContent1';
        else
            $bgclass = 'bgContent2';
			
	$dirboleto = "http://sesmt-rio.com/erp/2.0/".$verboleto[$x][boleto];		
	
	$idboleto = base64_encode($verboleto[$x][id]);
	
	$dt = 	explode('-', $verboleto[$x]['data_vencimento']);
	$data_vencimento		=	$dt[2]."/".$dt[1]."/".$dt[0];
	
	echo "<tr height = 30>";
    echo "<td class='$bgclass' align=center>{$verboleto[$x][id]}</td>";
	echo "<td class='$bgclass' align=center>".date("d/m/Y", strtotime($verboleto[$x][data_lancamento]))."</td>";
	echo "<td class='$bgclass' align=center>{$data_vencimento}</td>";
	echo "<td class='$bgclass' align=center><a href='$dirboleto'><img src='images/ico-view.png' border=0 alt='Visualizar Boleto' title='Visualizar Boleto'></a></td>";
	echo "</tr>";
	
	
	}
	echo "</table>";

  
?>

</body>
</html>