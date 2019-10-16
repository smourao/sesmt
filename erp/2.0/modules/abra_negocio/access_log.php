<?PHP
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
if($_GET['order']=="acessos"){
   $sql = "SELECT * FROM site_log ORDER BY acessos DESC";
}elseif($_GET['order']=="data"){
   $sql = "SELECT * FROM site_log ORDER BY ultimo_acesso DESC";
}else{
   $sql = "SELECT * FROM site_log ORDER BY ultimo_acesso DESC";
}

if($_GET['user']){
$sql = "SELECT * FROM site_log WHERE usuario ILIKE '%{$_GET['user']}%' ORDER BY ultimo_acesso DESC";
}

if($_POST && $_POST['email']!=""){
   $sql = "SELECT * FROM site_log WHERE usuario ILIKE '%{$_POST['email']}%' ORDER BY ultimo_acesso DESC";
}

$res = pg_query($connect, $sql);
$buffer = pg_fetch_all($res);

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE STEP OF PPRA!!!
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
            //BUSCA DA LISTA DE ACESSO ABRA SEU NEGÓCIO
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Busca da Lista</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<form method=POST name='form1' action='?dir=abra_negocio&p=index'>";
					echo "<tr class='roundbordermix text'>";
                    echo "<td class='roundborder text' height=30 align=center >E-mail</td>";
                    echo "<td class='roundborder text' height=30 align=center onmouseover=\"showtip('tipbox', '- Digite o e-mail no campo.');\" onmouseout=\"hidetip('tipbox');\">";
					echo "<input type='text' class='inputText' name='email' id='email' size=27></td>";
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
        echo "<td align=center class='text roundborderselected'><b>Lista de Acessos</b></td>";
        echo "</tr>";
        echo "</table>";
		
		if($_GET['user']){
		$pessoa = 0;
		
		$sql = "SELECT * FROM reg_pessoa_fisica WHERE email='{$_GET['user']}'";
		$result = pg_query($sql);
		if(pg_num_rows($result)>0){
		   $pessoa = 1;
		}
		
		if(pg_num_rows($result)<=0 && $pessoa == 0){
		   $sql = "SELECT * FROM reg_pessoa_juridica WHERE email='{$_GET['user']}'";
		   $result = pg_query($sql);
		   if(pg_num_rows($result)>0){
			  $pessoa = 2;
		   }
		}
		
		if($pessoa > 0){
		$cd = pg_fetch_all($result);
		}
		
		if($pessoa == 2 || $pessoa == 1){
		   echo "<center><b><font color=white>"; print $cd[0]['razao_social'] != "" ? $cd[0]['razao_social'] : $cd[0]['nome']; echo "</font></b></center>";
		   echo "<table width=100% border=0 align=center>";
		   echo "   <tr>";
		   echo "      <td width=25% align=center class='text roundborder '><b>E-mail</b></td>";
		   echo "      <td width=15% align=center class='text roundborder '><b>CPF/CNPJ</b></td>";
		   echo "      <td width=10% align=center class='text roundborder '><b>Telefone</b></td>";
		   echo "      <td width=50% align=center class='text roundborder '><b>Endereço</b></td>";
		   echo "   </tr>";
		
		   echo "   <tr>";
		   echo "      <td align=center class='text roundborder '>{$cd[0]['email']}</td>";
		   echo "      <td align=center class='text roundborder '>"; print $cd[0]['cnpj']!= ""? $cd[0]['cnpj'] : $cd[0]['cpf']; echo "</td>";
		   echo "      <td align=center class='text roundborder '>{$cd[0]['telefone']}</td>";
		   echo "      <td align=left class='text roundborder '>{$cd[0]['endereco']} {$cd[0]['numero']} - {$cd[0]['bairro']} - {$cd[0]['cidade']}/{$cd[0]['estado']}</td>";
		   echo "   </tr>";
		
		   echo "</table>";
		}
		
		}

	echo "<table width=100% border=0 align=center cellpadding=5 cellspacing=0>";
	  echo "<tr>";
		echo "<td width=5% class='text roundborder ' align=center><b>Nº</b></td>";
		echo "<td align=center class='text roundborder '><b>Cliente</b></td>";
		echo "<td align=center class='text roundborder '><b>URL</b></td>";
		echo "<td align=center class='text roundborder '><b><a href=\"javascript:location.href='index.php?dir=abra_negocio&p=index.php?order=acessos'\">Acesso</a></b></td>";
		echo "<td align=center class='text roundborder '><b><a href=\"javascript:location.href='index.php?dir=abra_negocio&p=index.php?order=data'\">Último Acesso</a></b></td>";
	  echo "</tr>";
	
	for($x=0;$x<pg_num_rows($res);$x++){
		echo "<tr>";
		echo "<td class='text roundborder ' align=center>".($x+1)."</td>";
		echo "<td class='text roundborder '><a href='index.php?dir=abra_negocio&p=access_log.php?user={$buffer[$x]['usuario']}'>{$buffer[$x]['usuario']}</a></td>";
		echo "<td class='text roundborder '>{$buffer[$x]['site_area']}</td>";
		echo "<td class='text roundborder ' align=center>{$buffer[$x]['acessos']}</td>";
		echo "<td class='text roundborder ' align=center>".date("d/m/Y", strtotime($buffer[$x]['ultimo_acesso']))."</td>";
		echo "</tr>";
	}
	echo "</table>";
/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>