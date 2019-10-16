<?php 
if(empty($_POST[dat])){
	$data = date("Y/m/d");
}else{
	$dt = explode("/", $_POST[dat]);
	$data = $dt[2]."/".$dt[1]."/".$dt[0];
}
$hora = date("H:i:s");

/******************** DADOS DO FUNCIONÁRIO **********************/
$query_func = "SELECT cod_func, nome_func, num_ctps_func, serie_ctps_func, cbo, dinamica_funcao, f.cod_cliente, f.cod_setor, c.filial_id
					  FROM funcionarios f, cliente c, cliente_setor cs 
					  WHERE c.cliente_id = cs.cod_cliente
					  and f.cod_cliente = cs.cod_cliente
					  and f.cod_func = $_GET[funcionario]
					  and f.cod_cliente = $_GET[cod_cliente]
					  and f.cod_setor = $_GET[setor]";
$result_func = pg_query($query_func);
$row_func = pg_fetch_array($result_func);

if($_GET[aso] !="" && $_POST) {
    $query_insert = "UPDATE aso SET 
		aso_data				   = '$data',
		aso_resultado			   = '$aso_resultado', 
		aso_hora				   = '$hora', 
		risco_id				   = $risco_id,
		classificacao_atividade_id = $classificacao_atividade_id, 
		tipo_exame				   = '$tipo_exame', 
		obs						   = '$obs'
    WHERE cod_aso = $_GET[aso]";
	$result_insert = pg_query($query_insert);
	if ($result_insert) { // se os inserts foram corretos
		showMessage('Dados do funcionário alterados com sucesso!');
	}
}	

$sql = "SELECT * FROM aso WHERE cod_aso = '{$_GET[aso]}'";
$raso = pg_query($sql);
$buffer = pg_fetch_array($raso);

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
	 	echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborderselected'>";
			echo "<b>opção</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborder'>";			
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Relação Func.' onclick=\"location.href='?dir=cad_cliente&p=cadastro_func&cod_cliente=$_GET[cod_cliente]';\" onmouseover=\"showtip('tipbox', '- Volta para tela de relação de funcionários.');\" onmouseout=\"hidetip('tipbox');\"></td>";
		echo "<td class='text' align=center><input type='button' class='btn' name='button_outros' value='Exames Compl.' onclick=\"location.href='?dir=gerar_aso&p=complementar&cod_cliente=$_GET[cod_cliente]&setor=$_GET[setor]&funcionario=$_GET[funcionario]&aso=$_GET[aso]';\" onmouseover=\"showtip('tipbox', '- Escolher exames complementares para o funcionário.');\" onmouseout=\"hidetip('tipbox');\"></td>";
        echo "</tr>";
		echo "</table>";
		echo "</td>";
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
        echo "<td align=center class='text roundborderselected'>";
        echo "<b>Gerar ASO</b>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";

/************************************************************************************************/
/*                  ACTION: MAIN FORM!                                                          */
/************************************************************************************************/
    echo "<form name=form1 method=post>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 >";
    echo "<tr>";
    echo "<td class='text' width='120'><b>Código do ASO:</b></td>";
	echo "<td class='text' align=left><b>". str_pad($buffer[cod_aso], "4", "0", ""). "</b></td>";
    echo "</tr>";
	echo "</table>";
	
	echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
    echo "<tr>";
    echo "<td align=left class='text' width=100><b>Cód. Cliente:</b></td>";
    echo "<td align=left class='text' width=220>". str_pad($buffer[cod_cliente], "4", "0", ""). "</td>";
    echo "<td align=left class='text' width=100><b>Cód. Setor:</b></td>";
    echo "<td align=left class='text' width=100>". str_pad($buffer[cod_setor], "4", "0", ""). "</td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Data:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=dat id=dat value='". date("d/m/Y", strtotime($buffer[aso_data])). "' maxlength=10 onkeypress=\"formatar(this, '##/##/####');\"></td>";
    echo "<td align=left class='text' width='100'><b>Hora:</b></td>";
    echo "<td align=left class='text' width='220'>$buffer[aso_hora]</td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Colaborador:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=funcionario id=funcionario value='$row_func[nome_func]'></td>";
    echo "<td align=left class='text' width='100'><b>CTPS:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=num_ctps_func id=num_ctps_func value='$row_func[num_ctps_func]'></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Série:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=serie_ctps_func id=serie_ctps_func value='$row_func[serie_ctps_func]' maxlength='9' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '#####-###');\" onblur=\"check_cep(this);\">&nbsp;<span id='verify_cep'></span></td>";
    echo "<td align=left class='text' width='100'><b>CBO:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=cbo id=cbo value='$row_func[cbo]'></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Dinâmica da Função:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=dinamica_funcao id=dinamica_funcao value='{$row_func[dinamica_funcao]}'></td>";
    echo "<td align=left class='text' width='100'><b>Classificação da Atividade:</b></td>";
    echo "<td align=left class='text' width='220'><select name='classificacao_atividade_id' id='classificacao_atividade_id' class='inputText' style=\"width: 130px;\">";
		
		$query_ativ="SELECT * FROM classificacao_atividade";
		$result_ativ=pg_query($query_ativ);
		while($row_ativ=pg_fetch_array($result_ativ)){
			if($buffer[classificacao_atividade_id]<>$row_ativ[classificacao_atividade_id]){
				echo "<option value='$row_ativ[classificacao_atividade_id]'>" . $row_ativ[nome_atividade] . "</option>";
			}else{
				echo "<option value='$row_ativ[classificacao_atividade_id]' selected>" . $row_ativ[nome_atividade] . "</option>";
			}
		}
		
	echo "</select></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Nível de Tolerância:</b></td>";
    echo "<td align=left class='text' width='220'><select name='risco_id' id='risco_id' class='inputText' style=\"width: 130px;\">";
			
		$query_clas="select risco_id, nome, descricao from risco_cliente";
		$result_clas=pg_query($query_clas);
		while($row_clas=pg_fetch_array($result_clas)){
			if($buffer[risco_id]<>$row_clas[risco_id]){
				echo "<option value=\"$row_clas[risco_id]\">" . $row_clas[nome] . "</option>";
			}else{
				echo "<option value=\"$row_clas[risco_id]\" selected>" . $row_clas[nome] . "</option>";
			} 
		}
				
	echo "</select></td>";
    echo "<td align=left class='text' width='100'><b>Tipo de Exame:</b></td>";
    echo "<td align=left class='text' width='220'><select name='tipo_exame' id='tipo_exame' class='inputText' style=\"width: 130px;\">";
		echo "<option value='Admissional'"; if($buffer[tipo_exame]=="Admissional"){echo "selected";} echo ">Admissional</option>";
		echo "<option value='Periódico'"; if($buffer[tipo_exame]=="Periodico"){echo "selected";} echo ">Periódico</option>";
		echo "<option value='Mudanca de Funcao'"; if($buffer[tipo_exame]=="Mudanca de Funcao"){echo "selected";} echo ">Mudança de Função</option>";
		echo "<option value='Retorno ao Trabalho'"; if($buffer[tipo_exame]=="Retorno ao Trabalho"){echo "selected";} echo ">Retorno Trabalho</option>";
		echo "<option value='Demissional'"; if($buffer[tipo_exame]=="Demissional"){echo "selected";} echo ">Demissional</option>";
	echo "</select></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Resultado:</b></td>";
    echo "<td align=left class='text' width='220'><select name='aso_resultado' id='aso_resultado' onchange=\"apto(this.value);\" style=\"width: 130px;\">";
		echo "<option value=''"; if($buffer[aso_resultado]==""){echo "selected";} echo "></option>";
		echo "<option value='__________'"; if($buffer[aso_resultado]=="__________"){echo "selected";} echo ">__________</option>";
		echo "<option value='Apto'"; if($buffer[aso_resultado]=="Apto"){echo "selected";} echo ">Apto</option>";
		echo "<option value='Apto à manipular alimentos'"; if($buffer[aso_resultado]=="Apto à manipular alimentos"){echo "selected";} echo ">Apto à manipular alimentos</option>";
		echo "<option value='Apto para trabalhar em altura'"; if($buffer[aso_resultado]=="Apto para trabalhar em altura"){echo "selected";} echo ">Apto para trabalhar em altura</option>";
		echo "<option value='Apto para operar empilhadeira'"; if($buffer[aso_resultado]=="Apto para operar empilhadeira"){echo "selected";} echo ">Apto para operar empilhadeira</option>";
		echo "<option value='Apto para trabalhar em espaço confinado'"; if($buffer[aso_resultado]=="Apto para trabalhar em espaço confinado"){echo "selected";} echo ">Apto para trabalhar em espaço confinado</option>";
		echo "<option value='Inapto'"; if($buffer[aso_resultado]=="Inapto"){echo "selected";} echo ">Inapto</option>";
		echo "<option value='Apto com Restrição'"; if($buffer[aso_resultado]=="Apto com Restrição"){echo "selected";} echo ">Apto com Restrição</option>";
	echo "</select></td>";
    echo "<td align=left class='text' width='100'><b>&nbsp;</b></td>";
    echo "<td align=left class='text' width='220'></td>";
    echo "</tr>";
	
	echo "</table>";
	
	echo "<p>";
	
	echo "<div align='center' style=\"display:none;\" id='ds'>";
	echo "<table width=100% border=0 cellpadding=2 cellspacing=2 class='text roundborderselected'>";
		echo "<tr>";
			echo "<td align=left class='text'><textarea cols='80' rows=2 name=obs id=obs class='inputText'>{$buffer[obs]}</textarea></td>";
		echo "</tr>";
	echo "</table>";
	echo "</div>";

	echo "<p>";

	/*******************************************************************************************************/
	// DADOS DOS EXAMES
	/*******************************************************************************************************/
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td class='text'><b>Riscos</b></td>";
    echo "</tr>";
	echo "</table>";
	
	echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Riscos da Função:</b></td>";
	if( !empty($_GET[cod_cliente]) and !empty($_GET[setor]) ){
		$query_risco="SELECT Distinct(nome_tipo_risco)
					  FROM tipo_risco tr, risco_setor rs, agente_risco ar, cliente c, setor s
					  WHERE ar.cod_agente_risco = rs.cod_agente_risco
					  AND ar.cod_tipo_risco = tr.cod_tipo_risco
					  AND c.cliente_id = rs.cod_cliente
					  AND s.cod_setor = rs.cod_setor 
					  AND rs.cod_setor = $_GET[setor]
					  AND rs.cod_cliente = $_GET[cod_cliente] order by nome_tipo_risco";
		$result_risco=pg_query($query_risco);
		
		echo "<td align=left class='text' width='220'><textarea cols='70' rows=2 name=cod_tipo_risco id=cod_tipo_risco class='inputText'>";
		
			while($row_risco=pg_fetch_array($result_risco)){ 
		echo "{$row_risco[nome_tipo_risco]}; ";
			}
		echo "</textarea></td>";
		}
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Especificação dos Riscos:</b></td>";
	if( !empty($_GET[cod_cliente]) and !empty($_GET[setor]) ){
		$query_agente="SELECT Distinct(nome_agente_risco)
					   FROM tipo_risco tr, risco_setor rs, agente_risco ar, cliente c, setor s
					   WHERE ar.cod_agente_risco = rs.cod_agente_risco
					   AND ar.cod_tipo_risco = tr.cod_tipo_risco
					   AND c.cliente_id = rs.cod_cliente
					   AND s.cod_setor = rs.cod_setor 
					   AND rs.cod_setor = $_GET[setor]
					   AND rs.cod_cliente = $_GET[cod_cliente] order by nome_agente_risco";
		$result_agente=pg_query($query_agente);

		echo "<td align=left class='text' width='220'><textarea cols='70' rows=2 name=cod_agente_risco id=cod_agente_risco class='inputText'>";

			while($row_agente=pg_fetch_array($result_agente)){ 
		echo "{$row_agente[nome_agente_risco]}; ";
			}
		echo "</textarea></td>";
		}
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Exames Complementares:</b></td>";
	if( !empty($_GET[aso]) ){
			$query_exame="SELECT e.especialidade
						   FROM site_aso_agendamento s, aso a, exame e, cliente c
						   WHERE s.exames = e.cod_exame
						   AND a.cod_cliente = c.cliente_id
						   AND s.cod_aso = a.cod_aso
						   AND s.cod_aso = $_GET[aso]
						   AND s.status = 1";
			$result_exame=pg_query($query_exame);

			echo "<td align=left class='text'><textarea id='cod_exame' name='cod_exame' class='inputText' rows=2 cols=70 class='fonte'>";

				while($row_exame=pg_fetch_array($result_exame)){ 
			          echo "{$row_exame[especialidade]}; ";
				}
			echo "</textarea></td>";
			}
    echo "</tr>";

    echo "</table>";
   
echo "<p>";

echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td align=left class='text'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
            echo "<td align=center class='text roundbordermix'>";
            echo "<input type='submit' class='btn' name='btnSave' value='Gravar' onmouseover=\"showtip('tipbox', '- Gravar, armazenará todos os dados funcionário.');\" onmouseout=\"hidetip('tipbox');\" >";
			echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</tr>";
echo "</table>";
   
    echo "</form>";

    echo "<p>";
/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>