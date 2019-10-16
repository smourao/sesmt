<?php
$dat = date("Y-m-d");
//${dtaso[$key]}
if($_POST[aso1]){
	$sqll = "DELETE FROM aso_exame WHERE cod_aso = '$_POST[aso1]'";
	$queryy = pg_query($sqll);
	$chkbox = $_POST[confirma];	
	$_POST[search] = $_POST[aso1];
	if(is_array($chkbox)){
		foreach($chkbox as $chkbox => $schkbox){
			$sql = "INSERT INTO aso_exame (cod_aso, cod_exame, confirma, data) VALUES ('$_POST[aso1]', '{$_POST[confirma][$chkbox]}', '0', '$dat')";
			if($query = pg_query($sql)){
				showMessage('Exames adicionados com sucesso! O cliente ja receberá um email com os proximos passos.');
				$okk = 1;								
			}else{
				showMessage('Ocorreu um erro no processo, favor falar com o suporte.');
			}
		}
	}else{
		$sql = "INSERT INTO aso_exame (cod_aso, cod_exame, confirma, data) VALUES ('$_POST[aso1]', '$_POST[confirma]', '0', '$dat')";
		
		if($query = @pg_query($sql)){
			showMessage('Exame adicionados com sucesso! O cliente ja receberá um email com o encaminhamento.');
			$okk = 1;
		}else{
			showMessage('Ocorreu um erro no processo, favor falar com o suporte.');
		}
	}
	if($okk == 1){
		$sqla = "SELECT * FROM aso a, reg_pessoa_juridica c WHERE a.cod_aso = $_POST[aso1] AND a.cod_cliente = c.cod_cliente";
		$querya = pg_query($sqla);
		$arraya = pg_fetch_array($querya);
							
		$msg = "Prezado cliente, o encaminhamento solicitado ja está disponível, basta clicar no link abaixo e escolher a clínica de sua preferência.";
		$msg .= '<p /><a href="http://www.sesmt-rio.com/?do=imp_enc&cod_aso='.$arraya[cod_aso].'&a=3&col='.$arraya[cod_func].'">Selecionar clinica e emprimir encaminhamento</a>';
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <suporte@sesmt-rio.com> \n";
		mail("suporte@ti-seg.com;".$arraya[email]."", "SESMT - Solicitação de encaminhamento para ASO avulso Nº: ".$cod_aso, $msg, $headers);
	}

}
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
$_POST[search] = anti_injection($_POST[search]);
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
     echo "<td width=250 class='text roundborder' valign=top>";
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Pesquisa</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
				
				echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<form method=POST name='form1' action='?dir=enc_avulso&p=lista_aso'>";
                    echo "<td class='roundbordermix text' height=30 align=center onmouseover=\"showtip('tipbox', '- Digite o numero do encaminhamento no campo e clique em Busca para pesquisar.');\" onmouseout=\"hidetip('tipbox');\">";
                        echo "<input type='text' class='inputText' name='search' id='search' value='{$_POST[search]}' size=15 maxlength=500>";
                        echo "&nbsp;";
                        echo "<input type='submit' class='btn' name='btnSearch' value='Busca'>";
                    echo "</td>";
                echo "</form>";
				echo "</tr>";
				echo "</table>";
				echo "<P>";
				
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
	echo "<td align=center class='text roundborderselected'><b>Resultado da Pesquisa</b></td>";
	echo "</tr>";
	echo "</table>";
	
	echo "<form method=POST name='form2' action='?dir=enc_avulso&p=lista_aso'>";
	if($_POST[search]){
		$sql = "SELECT * FROM aso WHERE $_POST[search] = cod_aso ORDER BY cod_aso";
		$result_aso = pg_query($sql);
		$row = pg_fetch_array($result_aso);
		$sqll = "SELECT f.*, c.*, s.* FROM funcionarios f, cliente c, setor s
		WHERE
		f.cod_cliente = c.cliente_id AND
		f.cod_setor = s.cod_setor AND
		c.cliente_id = {$row[cod_cliente]} AND
		f.cod_func = {$row[cod_func]}";
		$result = @pg_query($sqll);
		$buffer = @pg_fetch_array($result);
		if($result){
			echo "<table width=100% border=0>";	
			echo "<tr><td width=60%>";
			echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			echo "<tr>";	
			echo "<td bgcolor='$color'><b>Empresa:</b></td>";
			echo "</tr>";
			echo "<tr>";	
			echo "<td>" . $buffer[razao_social] . "</td>";
			echo "</tr>";
			echo "</table>";
			echo "<table  width=100% border=0 cellspacing=2 cellpadding=2 >";
			echo "<tr>";
			echo "<td class='text' width=100%><b>Exames a serem feitos:</b>";
			echo "</td>";
			echo "</tr>";
			echo "</table>";
			$nome_f = $buffer[nome_func];
			$setor_f = $buffer[nome_setor];
			echo "<table width=100% border=0>";
			echo "<tr>";
		
			$sql = "SELECT * FROM exame";
			$result_ex=@pg_query($sql);
					
			for($x=0;$x<@pg_num_rows($result_ex);$x++){
				$row_ex[$x] = @pg_fetch_array($result_ex);
				
				echo "<td align=left class='text' width=100%>";
				echo "<input name=confirma[] type=checkbox value={$row_ex[$x][cod_exame]}>";
				echo $row_ex[$x][especialidade];
				echo "<input name=aso1 type=hidden value={$row[cod_aso]}>";
				echo "</td>";
				echo "</tr>";
			}
		
			echo "<tr>";
			echo "<tr>";			
			echo "</table>";
			echo "</td>";
			echo "<td width=40% valign=top>";
			
			echo "<table width=100%>";	
			echo "<tr>";
			echo "<td width=100%>";
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "<b>Funcionário:</b>";					
			echo "</td>";
			echo "</tr>";
			
			echo "<tr>";
			echo "<td width=100%>";
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			echo $nome_f;			
			echo "</td>";
			echo "</tr>";
			
			echo "<tr>";
			echo "<td width=100%>";
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "<b>Setor: </b>";
			echo $setor_f;						
			echo "</td>";
			echo "</tr>";	
			echo "</table>";
			
			echo "</td>";
			echo "</table>";
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			echo "<table width=100%>";	
			echo "<tr>";
			echo "<td align=center class='text roundborderselected'>";
			echo "<input name=enviaemail type=submit value='Confirmar' class='btn' onmouseover=\"showtip('tipbox', '- Confirma os exames selecionados e envia o encaminhamento para o email cadastrado pelo cliente.');\" onmouseout=\"hidetip('tipbox');\">";
		}else{
		showMessage('ASO não encontrado! Verifique o código e tente novamente!');	
		}
	}
	echo "</td></tr>";
	echo "</form>";
	echo "</table>";
    echo "</td>";
echo "</tr>";
echo "</table>";
?>