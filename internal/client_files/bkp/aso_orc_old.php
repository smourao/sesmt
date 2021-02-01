<?php
$total = 0;
$fun = $_POST[checkbox];
$del = $_POST[delbox];
$add = $_POST[addbox];

//**********************************************************************************************************//
//********************************************* ETAPA 0 ****************************************************//
//**********************************************************************************************************//
if(!$_GET[etp]){
    $sql = "SELECT * FROM orc_aso WHERE cod_cliente = ".(int)($_SESSION[cod_cliente])." ORDER BY cod_orc";
    $res = pg_query($sql);
    $orc = pg_fetch_all($res);

    echo "<center><input type=button value='Criar novo orçamento' onclick=\"location.href='?do=aso_orc&etp=1';\"></center><br />";


    echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    echo "<tr>";
        echo "<td class='bgTitle' align=center width=60>Código</td>";
        echo "<td class='bgTitle' align=center>Status</td>";
        echo "<td class='bgTitle' align=center width=100>Gerado em</td>";
        echo "<td class='bgTitle' align=center width=100>Opções</td>";
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
				echo "Orçamento aprovado.";
			}else{
				echo "Aguardando aprovação do orçamento."; 
			}
            echo "</td>";
            echo "<td class='$bgclass' align=center>".date("d/m/Y", strtotime($orc[$x][data]))."</td>";
            echo "<td class='$bgclass' align=center>";
			
				echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
				echo "<tr>";
	
				//CONFIRM ETAPA 3
				if(pg_num_rows(pg_query($sql)) && !$orc[$x][aprovado])
					echo "<td width=20 align=center><a href='?do=aso_orc&etp=3&cod_orc={$orc[$x][cod_orc]}'><img src='images/ico-ok.png' border=0 alt='Aprovar orçamento' title='Aprovar orçamento'></a></td>";
				else
					echo "<td width=20 align=center>&nbsp;</td>";
					
				//VIEW ETAPA 4
				echo "<td width=20 align=center ><a target=_blank  href='internal/client_files/aso_orc_pdf.php?cod_orc={$orc[$x][cod_orc]}'><img src='images/ico-view.png' border=0 alt='Visualizar orçamento' title='Visualizar orçamento'></a></td>";
		
				//DELETE ETAPA 6
				if($orc[$x][status] || $orc[$x][aprovado])
					echo "<td width=20 align=center>&nbsp;</td>";
				else
					echo "<td width=20 align=center><a href='?do=aso_orc&etp=6&cod_orc={$orc[$x][cod_orc]}' onclick=\"if(!confirm('Tem certeza que deseja excluir este orçamento?','')){ return false;}\"><img src='images/ico-del.png' border=0 alt='Excluir orçamento' title='Excluir orçamento'></a></td>";
	
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
    echo "<td width=25><img src='images/ico-ok.png' border=0 alt='Aprovar orçamento' title='Aprovar orçamento'></td><td><font size=1>Aprovar orçamento.</font></td>";
    echo "</tr><tr>";
    echo "<td width=25><img src='images/ico-view.png' border=0 alt='Visualizar orçamento' title='Visualizar orçamento'></td><td><font size=1>Visualizar orçamento.</font></td>";
    echo "</tr><tr>";
    echo "<td width=25><img src='images/ico-del.png' border=0 alt='Excluir orçamento' title='Excluir orçamento'></td><td><font size=1>Excluir orçamento.</font></td>";
    echo "</tr>";
    echo "</table>";
}
//**********************************************************************************************************//
//********************************************* ETAPA 1 ****************************************************//
//**********************************************************************************************************//
if($_GET[etp] == 1){
$sql = "SELECT * FROM funcionarios fu, funcao fc WHERE fu.cod_cliente = ".(int)($_SESSION[cod_cliente])." AND fu.cod_status = 1 AND fu.cod_funcao = fc.cod_funcao ORDER BY nome_func";
$query = pg_query($sql);
$array = pg_fetch_all($query);
echo "<form method='post' name='orc_aso' action='?do=aso_orc&etp=2'><table width=100% border=0><tr><td class='bgTitle' width='1%'><b>Sel.</b></td><td class='bgTitle' align='center'><b>Colaborador</b></td><td  align='center' class='bgTitle'><b>Data último exame</b></td></tr>";
for($c=0;$c<pg_num_rows($query);$c++){
	        if($c%2)
            $bgclass = 'bgContent1';
        else
            $bgclass = 'bgContent2';

	$valor = 0;
	$exames = "<b>Exames da Função:</b><br>";
		echo "<tr><td align='center' class='$bgclass'><input checked='checked' type='checkbox' name='checkbox[]' id='checkbox' value='".$array[$c][cod_func]."' /></td><td class='$bgclass' width=79%>".$array[$c][nome_func]."</td><td class='$bgclass' width=20%  align='center'>".$array[$c][data_ultimo_exame]."</td>";
		echo "</tr>";
}
echo "</table>";
echo "<br>";
echo "<center><input value='<< Voltar' type=button class=button onclick='javascript:history.back(-1);'>";
echo '<input type="submit" name="button" id="button" value="Gerar Orçamento" /></center>';
echo "</form>";
}
//**********************************************************************************************************//
//********************************************* ETAPA 2 ****************************************************//
//**********************************************************************************************************//

if($_GET[etp] == 2){
echo "<center>Orçamento criado com sucesso!</center><br />";
echo "<table width=100% cellspacing=2 cellpadding=2 border=0><tr><td  align='center' class='bgTitle'><b>Colaborador</b></td><td  align='center' class='bgTitle'><b>Função</b></td><td class='bgTitle' align='center'><b>Valor</b></td></tr>";
$c=0;
$query_max = "SELECT max(cod_orc) as cod_orc FROM orc_aso";
$result_max = pg_query($query_max);
$row_max = pg_fetch_array($result_max);
$cod_orc = $row_max[cod_orc] + 1;

foreach($fun as $fun){
	if($c%2)
	$bgclass = 'bgContent1';
	else
	$bgclass = 'bgContent2';
	$sql = "SELECT * FROM funcionarios fu, funcao fc WHERE fu.cod_cliente = ".(int)($_SESSION[cod_cliente])." AND fu.cod_status = 1 AND fu.cod_funcao = fc.cod_funcao AND fu.cod_func = '$fun' ORDER BY nome_func";
$query = pg_query($sql);
$array = pg_fetch_array($query);
$valor = 0;
$exames = "<b>Exames da Função:</b><br>";
$f="SELECT * FROM fun_exa_cli fe, funcao fu, exame ex, clinica_exame ce WHERE fe.cod_fun = '{$array[cod_funcao]}' AND fe.cod_cli = ".(int)($_SESSION[cod_cliente])." AND fu.cod_funcao = fe.cod_fun AND ex.cod_exame = fe.cod_exa AND ce.cod_clinica = 19 AND ce.cod_exame = ex.cod_exame ORDER BY especialidade";
	$ff=pg_query($f);
	$fff=pg_fetch_all($ff);
	for($x=0;$x<pg_num_rows($ff);$x++){
		$exames .=$fff[$x][especialidade]." - R$".$fff[$x][preco_exame]."<br>";
		$i = "INSERT INTO orc_aso(cod_orc, cod_cliente, cod_func, exame, valor, data, aprovado) 
			  VALUES ('$cod_orc', '".(int)($_SESSION[cod_cliente])."', '".$array[cod_func]."', '".$fff[$x][especialidade]."', '".$fff[$x][preco_exame]."', '".date('Y-m-d')."', '0')";
		$o = pg_query($i);
	}
	echo "<tr><td width=45% class='$bgclass'>".$array[nome_func]."</td><td width=45% onMouseOver=\"return overlib('{$exames}');\" onMouseOut=\"return nd();\" class='$bgclass'>".$array[nome_funcao]."</td><td width=10% class='$bgclass'>R$";
	for($x=0;$x<pg_num_rows($ff);$x++){
		$valor += $fff[$x][preco_exame];
		$total += $fff[$x][preco_exame];
		$ex .= $fff[$x][especialidade]."<br>";
	}
	echo $valor;
	echo "</td></tr>";
	$c+=1;
}
echo "<tr><td colspan='2' height='30' class='bgTitle' align=center><b>Total</b></td><td class='bgTitle'><b>R$".$total."</b></td></tr>";
echo "</table>";
echo "<br>";
echo "<center><input value='<< Voltar' type=button class=button onclick=\"location.href='?do=aso_orc'\"></center>";
}
//**********************************************************************************************************//
//********************************************* ETAPA 6 ****************************************************//
//**********************************************************************************************************//
if($_GET[etp] == 6){
	$sql = "DELETE FROM orc_aso WHERE cod_orc = '$_GET[cod_orc]'";
	$query = pg_query($sql);
	echo "<center>Orçamento Excluído com sucesso!</center>";
	echo "<br>";
	echo "<center><input value='<< Voltar' type=button class=button onclick='javascript:history.back(-1);'></center>";
}

if($_GET[etp] == 3){
	$sql = "UPDATE orc_aso SET aprovado = 1 WHERE cod_orc = '$_GET[cod_orc]'";
	$query = pg_query($sql);
	echo "<center>Orçamento Aprovado com sucesso!</center>";
	echo "<br>";
	echo "<center><input value='<< Voltar' type=button class=button onclick='javascript:history.back(-1);'></center>";
}
?>