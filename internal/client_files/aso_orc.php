<?php
$cod_cliente = (int)($_SESSION[cod_cliente]);
$total = 0;
$fun = $_POST[checkbox];
$del = $_POST[delbox];
$add = $_POST[addbox];
//**********************************************************************************************************//
//********************************************* ETAPA 0 ****************************************************//
//**********************************************************************************************************//
if(!$_GET[etp]){
	
echo"	
<img src='images/sub-lista-orcamento.jpg' border=0>
<div class='novidades_text'>
<p align=justify>
A lista abaixo exibe todos os or�amentos gerados at� o momento. � poss�vel a visualiza��o e exclus�o desde que
o or�amento em quest�o n�o tenha sido aprovado.
<p align=justify>
Para aprovar um or�amento, clique no �cone <img src='images/ico-ok.png' border=0 alt='Aprovar or�amento' title='Aprovar or�amento'>
que corresponde ao or�amento que deseja aprovar. Uma vez aprovado, aguarde o contato do nosso setor T�cnico.
</div>";

	$sql = "DELETE FROM orc_aso WHERE ".(int)($_SESSION[cod_cliente])." AND agenda = 0";
	$query = pg_query($sql);
	
    $sql = "SELECT * FROM orc_aso WHERE cod_cliente = ".(int)($_SESSION[cod_cliente])." AND agenda = 1 ORDER BY cod_orc";
    $res = pg_query($sql);
    $orc = pg_fetch_all($res);

    echo "<center><input type=button value='Criar novo or�amento' onclick=\"location.href='?do=aso_orc&etp=1';\"></center><br />";


    echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    echo "<tr>";
        echo "<td class='bgTitle' align=center width=60>C�digo</td>";
        echo "<td class='bgTitle' align=center>Status</td>";
        echo "<td class='bgTitle' align=center width=100>Gerado em</td>";
        echo "<td class='bgTitle' align=center width=100>Op��es</td>";
    echo "</tr>";
    for($x=0;$x<pg_num_rows($res);$x++){
        if($x%2)
            $bgclass = 'bgContent1';
        else
            $bgclass = 'bgContent2';

        echo "<tr>";
		if($orc[$x][cod_orc] != $orc[$x-1][cod_orc]){
            echo "<td class='$bgclass' align=center>{$orc[$x][cod_orc]}</td>";
            echo "<td class='$bgclass' align=left>";
			if($orc[$x][aprovado]){
				echo "Or�amento aprovado.";
			}else{
				echo "Aguardando aprova��o do or�amento."; 
			}
            echo "</td>";
            echo "<td class='$bgclass' align=center>".date("d/m/Y", strtotime($orc[$x][data]))."</td>";
            echo "<td class='$bgclass' align=center>";
			
				echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
				echo "<tr>";
	
				//CONFIRM ETAPA 3
				if(pg_num_rows(pg_query($sql)) && !$orc[$x][aprovado])
					echo "<td width=20 align=center><a href='?do=aso_orc&etp=3&cod_orc={$orc[$x][cod_orc]}'><img src='images/ico-ok.png' border=0 alt='Aprovar or�amento' title='Aprovar or�amento'></a></td>";
				else
					echo "<td width=20 align=center>&nbsp;</td>";
					
				//VIEW ETAPA 4
				echo "<td width=20 align=center ><a target=_blank  href='internal/client_files/aso_orc_pdf.php?cod_orc={$orc[$x][cod_orc]}'><img src='images/ico-view.png' border=0 alt='Visualizar or�amento' title='Visualizar or�amento'></a></td>";

				//DELETE ETAPA 6 / ENCAMINHAMENTOS
				if($orc[$x][status] || $orc[$x][aprovado])
					echo "<td width=20 align=center><a target=_blank  href='internal/client_files/aso_orc_pdf_enc.php?cod_orc={$orc[$x][cod_orc]}'><img src='images/ico-down.png' border=0 alt='Baixar encaminhamentos' title='Baixar encaminhamentos'></a></td>";
				else
					echo "<td width=20 align=center><a href='?do=aso_orc&etp=6&cod_orc={$orc[$x][cod_orc]}' onclick=\"if(!confirm('Tem certeza que deseja excluir este or�amento?','')){ return false;}\"><img src='images/ico-del.png' border=0 alt='Excluir or�amento' title='Excluir or�amento'></a></td>";
	
				echo "</tr>";
				echo "</table>";

            echo "</td>";
		}
        echo "</tr>";
    }
    echo "</table>";
    echo "<BR>";
    echo "<b>Legenda:</b>";
    echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    echo "<tr>";
    echo "<td width=25><img src='images/ico-ok.png' border=0 alt='Aprovar or�amento' title='Aprovar or�amento'></td><td><font size=1>Aprovar or�amento.</font></td>";
    echo "</tr><tr>";
    echo "<td width=25><img src='images/ico-view.png' border=0 alt='Visualizar or�amento' title='Visualizar or�amento'></td><td><font size=1>Visualizar or�amento.</font></td>";
    echo "</tr><tr>";
    echo "<td width=25><img src='images/ico-del.png' border=0 alt='Excluir or�amento' title='Excluir or�amento'></td><td><font size=1>Excluir or�amento.</font></td>";
    echo "</tr><tr>";
    echo "<td width=25><img src='images/ico-down.png' border=0 alt='Baixar encaminhamentos' title='Baixar encaminhamentos'></td><td><font size=1>Baixar encaminhamentos.</font></td>";
    echo "</tr>";
    echo "</table>";
}
//**********************************************************************************************************//
//********************************************* ETAPA 1 ****************************************************//
//**********************************************************************************************************//
if($_GET[etp] == 1){
	
echo"	
<div class='novidades_text'>
<p align=justify>
Escolha abaixo os funcion�rios que ir�o fazer os exames.
</div>";
	
$sql = "SELECT * FROM funcionarios fu, funcao fc WHERE fu.cod_cliente = ".(int)($_SESSION[cod_cliente])." AND fu.cod_status = 1 AND fu.cod_funcao = fc.cod_funcao ORDER BY nome_func";
$query = pg_query($sql);
$array = pg_fetch_all($query);
echo "<form method='post' name='orc_aso' action='?do=aso_orc&etp=cl'>
<table width=100% border=0><tr>
<td class='bgTitle' width='1%'><b>Sel.</b></td>
<td class='bgTitle' align='center' width='60%'><b>Colaborador</b></td>
<td align='center' class='bgTitle' width='25%'><b>Tipo de exame</b></td>
<td align='center' class='bgTitle' width='14%'><b>Data �ltimo exame</b></td></tr>";

for($c=0;$c<pg_num_rows($query);$c++){
	        if($c%2)
            $bgclass = 'bgContent1';
        else
            $bgclass = 'bgContent2';

	$valor = 0;
	$exames = "<b>Exames da Fun��o:</b><br>";
		echo "<tr><td align='center' class='$bgclass'><input checked='checked' type='checkbox' name='checkbox[]' id='checkbox' value='".$array[$c][cod_func]."' /></td>
		<td class='$bgclass'>".$array[$c][nome_func]."</td>
		<td align='center' class='$bgclass'>";
				   echo "<select name=tipo_exame[] id=tipo_exame \">";
                    echo "<option value='2'>Demissional</option>";
                    echo "<option value='3' selected=\"selected\">Peri�dico</option>";
                    echo "<option value='4'>Mudan�a de fun��o</option>";
					echo "<option value='5'>Retorno ao trabalho</option>";
               echo "</select>";
		echo "</td>
		<td class='$bgclass' align='center'>".$array[$c][data_ultimo_exame]."</td>";
		echo "</tr>";
}
echo "</table>";
echo "<br>";
echo "<center><input value='<< Voltar' type=button class=button onclick='javascript:history.back(-1);'>";
echo "<input type=submit value='Avan�ar >>'>";
echo "</form>";
}

//**********************************************************************************************************//
//********************************************* ETAPA CL ***************************************************//
//**********************************************************************************************************//
//*C�digo modificado em 17/10/2018 por Sidnei Mour�o, arquivo original � aso_orc.php20181017*//
if($_GET[etp] == 'cl'){
	$c=0;
$query_max = "SELECT max(cod_orc) as cod_orc FROM orc_aso";
$result_max = pg_query($query_max);
$row_max = pg_fetch_array($result_max);
$cod_orc = $row_max[cod_orc] + 1;
$zy = count($fun);


echo"	
<div class='novidades_text'>
<p align=justify>
Selecione abaixo a cl�nica na qual deseja fazer o or�amento.
</div>";	
	
    $sql = "SELECT * FROM clinicas where ativo = 1 AND cod_clinica != 14 ORDER by razao_social_clinica";
    $res = pg_query($sql);
    $clin = pg_fetch_all($res);

    echo "<table width=100% cellspacing=2 cellpadding=2 border=0>
		  <form method='post' name='orc_aso' action='?do=aso_orc&etp=2&cod_orc=$cod_orc'>";
    	echo "<tr>";
	        echo "<td class='bgTitle' align=center width='75%'>Cl�nica</td>";
	        echo "<td class='bgTitle' align=center width='15%'>Valor</td>";
	        echo "<td class='bgTitle' align=center width='10%'>Op��es</td>";		
    	echo "</tr>";
    	for($xx=0;$xx<pg_num_rows($res);$xx++){
    		for($xy=0;$xy<$zy;$xy++) {
				if($c%2)
				$bgclass = 'bgContent1';
				else
				$bgclass = 'bgContent2';
				$sql = "SELECT * FROM funcionarios fu, funcao fc WHERE fu.cod_cliente = ".(int)($_SESSION[cod_cliente])." AND fu.cod_status = 1 AND fu.cod_funcao = fc.cod_funcao AND fu.cod_func = '".$_POST[checkbox][$xy]."' ORDER BY nome_func";
				$query = pg_query($sql);
				$array = pg_fetch_array($query);
				$valor = 0;
				$exames = "<b>Exames da Fun��o:</b><br>";

				$f="SELECT * FROM fun_exa_cli fe, funcao fu, exame ex, clinica_exame ce WHERE fe.cod_fun = '{$array[cod_funcao]}' AND fe.cod_cli = ".(int)($_SESSION[cod_cliente])." AND fu.cod_funcao = fe.cod_fun AND ex.cod_exame = fe.cod_exa AND ce.cod_clinica = '{$clin[$xx]['cod_clinica']}' AND ce.cod_exame = ex.cod_exame ORDER BY especialidade";
				$ff=pg_query($f);
				$fff=pg_fetch_all($ff);
				for($x=0;$x<pg_num_rows($ff);$x++){
					$exames .=$fff[$x][especialidade]." - R$".$fff[$x][preco_exame]."<br>";
					$i = "INSERT INTO orc_aso(cod_orc, cod_cliente, cod_func, exame, valor, data, aprovado, cod_clinica, tipo_exame) 
						  VALUES ('$cod_orc', '".(int)($_SESSION[cod_cliente])."', '".$_POST[checkbox][$xy]."', '".$fff[$x][especialidade]."', '".$fff[$x][preco_exame]."', '".date('Y-m-d')."', '0', '".$fff[$x][cod_clinica]."', '".$_POST[tipo_exame][$xy]."')";
					$o = pg_query($i);
				}
				/*for($x=0;$x<pg_num_rows($ff);$x++){
					$valor += $fff[$x][preco_exame];
					$total1 += $fff[$x][preco_exame];
					$ex .= $fff[$x][especialidade]."<br>";
				}*/
				$s = "SELECT sum(valor) as valor From orc_aso WHERE cod_orc = '{$cod_orc}' AND cod_clinica = '".$clin[$xx][cod_clinica]."'";
				$ss = pg_query($s);
				$sss = pg_fetch_array($ss);
				$c+=1;	
			}
        echo "<tr>";
            echo "<td class='bgContent2' align=center>{$clin[$xx]['razao_social_clinica']}</td>";
            echo "<td class='bgContent2' align=center>R$".$sss[valor]."</td>";
            echo "<td class='bgContent2' align=center><input type='radio' checked='checked' id='clin' name='clin' value='{$clin[$xx]['cod_clinica']}' /></td>";
        echo "</tr>";
    	}
	echo "</table>";
		echo "<br>";
		if(($c/2)>=10){
  		echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
		echo "<tr><td class='bgTitle'><input name='visita' type='checkbox' value='1' />".($c/2)." Desejo que a Cl�nia venha a minha empresa.</td></tr>";
		echo "</table>";
		echo "<br>";
		}
		echo "<center><input value='<< Voltar' type=button class=button onclick='javascript:history.back(-1);'>";
		echo "<input type=submit value='Confirmar'>";
		echo "</form>";		
}

//**********************************************************************************************************//
//********************************************* ETAPA 2 ****************************************************//
//**********************************************************************************************************//

if($_GET[etp] == 2){
echo"	
<div class='novidades_text'>
<p align=justify>
Seu Or�amento foi Criado com sucesso! Confira os funcion�rios e o resumo do or�amento abaixo.
<p align=justify>
Para visualizar, clique no bot�o abaixo para voltar a p�gina de or�amentos.
</div>";
echo "<br>";
echo "<center><input value='<< Voltar' type=button class=button onclick=\"location.href='?do=aso_orc'\"></center>";

if($_POST[visita]){
	$sql = "UPDATE orc_aso SET visita=1 WHERE cod_orc = '$_GET[cod_orc]'";
	$query = pg_query($sql);
}

$sql = "UPDATE orc_aso SET agenda=1 WHERE cod_orc = '$_GET[cod_orc]' AND cod_clinica = '$_POST[clin]'";
$query = pg_query($sql);

$sql = "DELETE FROM orc_aso WHERE cod_orc = '$_GET[cod_orc]' AND cod_clinica <> '$_POST[clin]' AND agenda=0";
$query = pg_query($sql);

}
//**********************************************************************************************************//
//********************************************* ETAPA 6 ****************************************************//
//**********************************************************************************************************//
if($_GET[etp] == 6){
	$sql = "DELETE FROM orc_aso WHERE cod_orc = '$_GET[cod_orc]'";
	$query = pg_query($sql);
	echo "<center>Or�amento Exclu�do com sucesso!</center>";
	echo "<br>";
	echo "<center><input value='<< Voltar' type=button class=button onclick='javascript:history.back(-1);'></center>";
}
//**********************************************************************************************************//
//********************************************* ETAPA 3 ****************************************************//
//**********************************************************************************************************//
if($_GET[etp] == 3){
	$sql = "DELETE FROM orc_aso WHERE cod_orc = '$_GET[cod_orc]' AND cod_clinica <> '$_POST[clin]'";
$query = pg_query($sql);

	$sql = "SELECT * FROM cliente WHERE cliente_id = ".(int)($_SESSION[cod_cliente]);
	$res = pg_query($sql);
	$cliente = pg_fetch_array($res);

	$sql = "UPDATE orc_aso SET aprovado = 1 WHERE cod_orc = '$_GET[cod_orc]'";
	$query = pg_query($sql);
	echo "<center>Or�amento Aprovado com sucesso!</center>";
	echo "<br>";
	echo "<center><input value='<< Voltar' type=button class=button onclick='javascript:history.back(-1);'></center>";
	
	//OR�AMENTO
	$sql_orc = "SELECT * FROM orc_aso WHERE cod_orc = '$_GET[cod_orc]' AND cod_cliente = $cod_cliente ORDER BY cod_func";
	$query_orc = pg_query($sql_orc);
	$array_orc = pg_fetch_all($query_orc);

	//ACRESCENTAR UM ASO
	$asos = "";
	for($x=0;$x<pg_num_rows($query_orc);$x++){		
		
		if($array_orc[$x][cod_func] != $array_orc[$x-1][cod_func]){
//FUNCIONARIOS
			$sql_func = "SELECT * FROM funcionarios WHERE cod_func = '{$array_orc[$x][cod_func]}' AND cod_cliente = '$cod_cliente'";
			$query_func = pg_query($sql_func);
			$array_func = pg_fetch_array($query_func);
			
			$query_max = "SELECT max(cod_aso) as cod_aso FROM aso";
			$result_max = pg_query($query_max);
			$row_max = pg_fetch_array($result_max);
			$cod_aso = $row_max[cod_aso] + 1;
			$query_insert = "INSERT INTO aso (cod_aso, cod_cliente, cod_setor, cod_func, tipo_exame, cod_clinica, aso_data)
			VALUES ('$cod_aso', '$cod_cliente', '{$array_func[cod_setor]}', '{$array_func[cod_func]}', 'Peri�dico', '{$array_orc[$x][cod_clinica]}', '".date('Y-m-d')."')";
			$result_insert = pg_query($query_insert);
			
		}
		
		//EXAMES
		$sql_exames = "SELECT * FROM exame WHERE especialidade = '{$array_orc[$x][exame]}'";
		$query_exames = pg_query($sql_exames);
		$array_exames = pg_fetch_array($query_exames);
		
		$sql_aso_exame = "INSERT INTO aso_exame (cod_aso, cod_exame, confirma, data) 
					   	  VALUES ('$cod_aso', '$array_exames[cod_exame]', '0', '".date('Y-m-d')."')";
		$query_aso_exame = pg_query($sql_aso_exame);
		
	}
	

	$headers = "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$headers .= "From: SESMT - Seguran�a do Trabalho e Higiene Ocupacional. <suporte@sesmt-rio.com> \n";
	
	$msg  = "<h3>Or�amento de Exames Complementar</h3>";
	$msg .= "<p>O cliente ".$cliente[razao_social]." acabou de aprovar um or�amento de exame complementar!</p>";
	$msg .= "<p>Clique <a href='http://sesmt-rio.com/internal/client_files/aso_orc_pdf.php?cod_orc=".$_GET[cod_orc]."'>aqui</a> para visualizar </p>";
	$msg .= "";
	if($array_orc[0][visita] == 1){
		$msg .= "<p> A cl�nica dever� fazer a visita a empresa.";	
	}
	$msg .= "<p><a href='http://sesmt-rio.com/internal/client_files/aso_orc_pdf_enc.php?cod_orc=".$_GET[cod_orc]."'>Clique aqui caso queira baixar os prontu�rios</a>";

    mail("medicotrab@sesmt-rio.com", "SESMT - Or�amento de Exames", $msg, $headers);
}
?>