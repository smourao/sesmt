<?PHP
/******************************************************************************************************/
/*****CÓDIGO CRIADO POR SIDNEI MOURÃO EM 13/11/2018*******/
/******************************************************************************************************/
//Get client
$sql = "SELECT * FROM reg_pessoa_juridica WHERE cod_cliente = '{$_GET[cod_cliente]}'";
$res = pg_query($sql);
$buffer = pg_fetch_array($res);

if(isset($_POST['btnAlterar'])){
	//consulta se email ja existe
	$cst = "SELECT * FROM reg_pessoa_juridica WHERE email = '{$_POST['email']}'";
	$rst = pg_query($cst);
	$cach = pg_fetch_array($rst);
	if($buffer['email'] != $cach['email']){
		$up = "UPDATE reg_pessoa_juridica SET email = '{$_POST['email']}', senha = '".md5($_POST['senha'])."' WHERE cod_cliente = '{$_GET['cod_cliente']}'";
		if($resup = pg_query($up))
			echo '<script type="text/javascript">alert("Alteração realizada com sucesso!");</script>';
	}else{
		echo '<script type="text/javascript">alert("Erro ao efetuar a alteração, email ja existe!");</script>';
	}
}
echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
    echo "<td width=250 class='text roundborder' valign=top>";
		// RESUMO DO CLIENTE
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborderselected'>";
			echo "<b>Principais informações do cliente</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		echo "<p>";
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=left class='text'><b>Responsável:</b>&nbsp;{$buffer[responsavel]}</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td align=left class='text'><b>Email:</b>&nbsp;{$buffer[email_pessoal]}</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td align=left class='text'><b>Telefone:</b>&nbsp;{$buffer[telefone]}</td>";
		echo "</tr>";
		echo "</table>";
		echo "<p>";
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
			echo "<td align=center class='text roundborderselected'><b>Opções</b></td>";
		echo "</tr>";
		echo "</table>";
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
			echo "<td class='roundbordermix text' height=30 align=left>";
				echo "<form method=post>";
				echo "<table width=100% border=0>";
				echo "<tr>";
				echo "<td class='text' align=center><input type='button' class='btn' name='butVtr' value='Voltar' onclick=\"location.href='?dir=cad_cliente&p=detalhe_cliente&cod_cliente=$_GET[cod_cliente]';\" onmouseover=\"showtip('tipbox', '- Voltar, permite voltar para o cadastro de clientes.');\" onmouseout=\"hidetip('tipbox');\"></td>";
				echo "</tr>";
				echo "</table>"; 
				echo "</form>";
			echo "</td>";
		echo "</tr>";
		echo "</table>";
	
		// --> TIPBOX
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
			echo "<td class=text height=30 valign=top align=justify>";
				echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";
			echo "</td>";
		echo "</tr>";
		echo "</table>";
    echo "</td>";

/**************************************************************************************************/
// -->  RIGHT SIDE!!!
/**************************************************************************************************/
    echo "<td class='text roundborder' valign=top>";
    	echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'>";
            echo "<b>{$buffer[razao_social]}</b>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";

		echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
		echo "<tr>";
		echo "<td align=left class='text'>";
			echo "<form method=post name='' action='' enctype='multpart/form-data'";
				echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
					echo "<tr>";
						echo "<td align=right class=text width='100'>Login: </td>";
		    			echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=email id=email value=\"".addslashes($buffer[email])."\"></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td align=right class=text width='100'>Senha: </td>";
		    			echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=senha id=senha value=\"".addslashes($buffer[senha])."\"></td>";
					echo "</tr>";
				echo "</table>";
				echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
				    echo "<tr>";
				    echo "<td align=left class='text'>";
				        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
				        echo "<tr>";
				            echo "<td align=center class='text roundbordermix'>";
				            echo "<input type='submit' class='btn' name='btnAlterar' value='Alterar' onmouseover=\"showtip('tipbox', '- Alterar, irá alterar as informações no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";
				            echo "</td>";
				        echo "</tr>";
				        echo "</table>";
				    echo "</tr>";
				echo "</table>";
			echo "</form>";
		echo "<td>";
		echo "</tr>";
		echo "</table>";
	echo "</td>";
echo "</tr>";
echo "</table>";
?>