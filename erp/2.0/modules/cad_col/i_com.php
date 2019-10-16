<?PHP
if($_POST && !empty($_GET[funcionario_id])){
	if($_POST[dtop]){
            $tmp = explode("/", $_POST[dtop]);
    	    $dtop = $tmp[2]."/".$tmp[1]."/".$tmp[0];
	}
	
	if($_POST[dt]){
            $tmp = explode("/", $_POST[dt]);
    	    $dt = $tmp[2]."/".$tmp[1]."/".$tmp[0];
	}
	
	if( empty($_POST["salario"]) ){
			$salario = 0;
		}else{
			$salario = str_replace(".","",$_POST["salario"]);
			$salario = str_replace(",",".",$salario);
	}
	
	$consulta = "SELECT * FROM comp_reg_emp WHERE funcionario_id = ".$_GET[funcionario_id];
	$cons = pg_query($connect, $consulta);
	if(pg_num_rows($cons) == 0){	
	
		$query_incluir = "INSERT INTO comp_reg_emp
						 (funcionario_id, sindicato, matricula, banco1, banco2, agencia1, agencia2, data_opcao, inscricao, ocupacao, dt_admissao, pagamento,
						 hora1, hora2, hora3, hora4, bene, obs, folha, contrato)
						 VALUES 
						 ($funcionario_id, '".addslashes($sindicato)."', '$matricula', '".addslashes($banco1)."', '".addslashes($banco2)."', '$agencia1', '$agencia2',
						 '$dtop', '$inscricao', '".addslashes($ocupacao)."', '$dt', '$pagamento', '$hora1', '$hora2', '$hora3', '$hora4', '".addslashes($bene)."',
						 '".addslashes($obs)."', $folha, $contrato)";
			
			$salario = str_replace(".","",$_POST["salario"]);
			$salario = str_replace(",",".",$salario);
			
		if(pg_query($connect, $query_incluir)){
			$query_incluir = "INSERT INTO alt_sal
							 (funcionario_id, data, salario)
							 VALUES 
							 ($funcionario_id, '$dt', '$salario')";
		pg_query($connect, $query_incluir);
		}
		showmessage('Complemento do Colaborador Incluído com Sucesso!');

	}else{
	
		$query_alterar = "UPDATE comp_reg_emp SET 
							sindicato  	  = '".addslashes($sindicato)."'
							, matricula   = '$matricula'
							, banco1   	  = '".addslashes($banco1)."'
							, banco2  	  = '".addslashes($banco2)."'
							, agencia1    = '$agencia1'
							, agencia2	  = '$agencia2'
							, data_opcao  = '$dtop'
							, inscricao   = '$inscricao'
							, ocupacao    = '".addslashes($ocupacao)."'
							, dt_admissao = '$dt'
							, pagamento   = '$pagamento'
							, hora1  	  = '$hora1'
							, hora2  	  = '$hora2'
							, hora3  	  = '$hora3'
							, hora4 	  = '$hora4'
							, bene        = '".addslashes($bene)."'
							, obs		  = '".addslashes($obs)."'
							, folha		  = $folha
							,contrato	  = $contrato
							WHERE funcionario_id = ".$_GET[funcionario_id];
		pg_query($connect, $query_alterar);
		
			$salario = str_replace(".","",$_POST["salario"]);
			$salario = str_replace(",",".",$salario);
		
		if(pg_query($connect, $query_alterar)){
			$query_alterar = "INSERT INTO alt_sal
							 (funcionario_id, data, salario)
							 VALUES 
							 ($funcionario_id, '$dt', '$salario')";
		@pg_query($connect, $query_alterar);
		}
		showmessage('Complemento do Colaborador Alterado com Sucesso!');
	}
}

echo "<script>
function calcula_horas(){
	if(document.getElementById('hora1').value != '' && document.getElementById('hora2').value != '' && document.getElementById('hora3').value != ''){
		var h1 = document.getElementById('hora1').value;
		var h2 = document.getElementById('hora2').value;
		var h3 = document.getElementById('hora3').value;
		h1 = h1.split(':');
		h2 = h2.split(':');
		h3 = h3.split(':');
		var ha = (((h2[0] * 60) + parseInt(h2[1])) - ((h1[0] * 60) + parseInt(h1[1])))-((h3[0]*60) + parseInt(h3[1]));
		
		//document.write(((ha*5)/60));
		var tt = ((ha)*5);
		document.getElementById('hora4').value = Math.floor((tt-60)/60) + ':' + (tt%60);
	}
}
</script>";

/***************************************************************************************************/
// --> BUSCA DA TABELA DE REGISTRO DE EMPREGADOS
/***************************************************************************************************/
$busca = "SELECT * FROM comp_reg_emp WHERE funcionario_id = ".$_GET[funcionario_id];
$bus = pg_query($connect, $busca);
$row_bus = pg_fetch_array($bus);

/***************************************************************************************************/
// --> BUSCA DA TABELA ALTERAÇÃO DE SALÁRIOS
/***************************************************************************************************/
$busca = "SELECT * FROM alt_sal WHERE funcionario_id = ".$_GET[funcionario_id]." ORDER BY id desc";
$alt = pg_query($busca);
$row_alt = pg_fetch_array($alt);

/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Opções</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

				echo "<table border=0 cellpadding=2 cellspacing=3 width=100%><tbody>";
				echo "<tr><td class=roundbordermix text align=left height=30>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnCad' value='Voltar' onclick=\"location.href='?dir=cad_col&p=index';\"  onmouseover=\"showtip('tipbox', '- Voltar para lista de colaboradores.');\" onmouseout=\"hidetip('tipbox');\"></td>";
					
					echo "<td class='text' align=center></td>";

                echo "</tr>";
								
                echo "<tr>";
                    echo "<td class='text' height=30 align=center><input type='button' class='btn' name='btnReg' value='Registro' onclick=\"location.href='?dir=cad_col&p=a_reg&funcionario_id=$_GET[funcionario_id]';\"  onmouseover=\"showtip('tipbox', '- Permite alterar o registro do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnReg' value='Complemento' onclick=\"location.href='?dir=cad_col&funcionario_id=$_GET[funcionario_id]&p=i_com';\"  onmouseover=\"showtip('tipbox', '- Permite registrar/alterar um complemento no cadastro do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                echo "</tr>";
				echo "<tr>";
                    echo "<td class='text' height=30 align=center><input type='button' class='btn' name='btnAlt' value='Alterar Salário' onclick=\"location.href='?dir=cad_col&funcionario_id=$_GET[funcionario_id]&p=in_sal';\"  onmouseover=\"showtip('tipbox', '- Permite incluir/alterar o salário do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnfer' value='Férias' onclick=\"location.href='?dir=cad_col&funcionario_id=$_GET[funcionario_id]&p=in_fer';\"  onmouseover=\"showtip('tipbox', '- Permite visualizar as férias do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                echo "</tr>";
				
				echo "<tr>";
                    echo "<td class='text' height=30 align=center><input type='button' class='btn' name='btnFrdf' value='Relação Doc.' onclick=\"window.open('./modules/cad_col/frdf.php?funcionario_id=$_GET[funcionario_id]&p=frdf', 'SESMT', 'height=1030, width=760, scrollbars = yes, status=yes, toolbar = yes, menubar=yes');\"  onmouseover=\"showtip('tipbox', '- Permite visualizar a relação de documentos necessários para admissão do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnAc' value='Inf. de Acesso' onclick=\"location.href='?dir=cad_col&p=i_ac&funcionario_id=$_GET[funcionario_id]';\"  onmouseover=\"showtip('tipbox', '- Informações de acesso do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                echo "</tr>";
				
                echo "</table>";
				echo "</td></tr></tbody></table><br />";
				
				
				$query_func = "SELECT f.*, u.* FROM funcionario f, usuario u WHERE f.funcionario_id = u.funcionario_id ORDER BY f.nome";
				$result_func = pg_query($connect, $query_func);
				$list = pg_fetch_all($result_func);
			
				echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
				echo "<tr>";
				echo "<td align=left class='text'><b>Lista de funcionários:</b></td>";
				echo "</tr>";
				for($i=0;$i<pg_num_rows($result_func);$i++){
					if($list[$i][status] == 0){
						$bg = "bgcolor=#CD0000'";				
					}else{
						$bg = "";	
					}
					echo "<tr class='text roundbordermix'>";
					echo "<td align=left $bg class='text roundborder curhand' onclick=\"location.href='?dir=cad_col&p=a_reg&funcionario_id={$list[$i]['funcionario_id']}';\" alt='Clique aqui para editar' title='Clique aqui para editar'>{$list[$i]['nome']}&nbsp;</td>";
					echo "</tr>";
				}
				echo "</table>";
				echo "<p>";

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
		echo "<form name=form1 method=post>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'><b>Cadastro Complementar do Colaborador</b></td>";
        echo "</tr>";
        echo "</table>";
	    
		/**************************************************************************************************/
		// --> DADOS SINDICAIS
		/**************************************************************************************************/
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td class='text'>";
		echo "<b>Sindicato a que pertence:</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
        
	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Sindicato:</b></td>";
        echo "<td align=left width=220><input id='sindicato' type='text' name='sindicato' size='30' value=\"".stripslashes($row_bus[sindicato])."\" ></td>";
        echo "<td align=left class='text' width=100><b>Nº matricula:</b></td>";
        echo "<td align=left class='text' width=220><input id='matricula' type='text' name='matricula' size='30' value='{$row_bus[matricula]}' ></td>";
        echo "</tr>";

		echo "</table>";
		echo "<p>";
		
		/**************************************************************************************************/
		// --> DADOS BANCÁRIOS
		/**************************************************************************************************/
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td class='text' width=50%>";
		echo "<b>FGTS:</b>";
		echo "</td>";
		echo "<td class='text' width=50%>";
		echo "<b>PIS:</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";

   	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
	    echo "<tr>";
		echo "<td align=left class='text' width=100><b>Banco depositário:</b></td>";
        echo "<td align=left width=220><input id='banco1' type='text' name='banco1' size='30' value=\"".stripslashes($row_bus[banco1])."\" ></td>";
        echo "<td align=left class='text' width=100><b>Banco depositário:</b></td>";
        echo "<td align=left class='text' width=220><input id='banco2' type='text' name='banco2' size='30' value=\"".stripslashes($row_bus[banco2])."\" ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Agência:</b></td>";
        echo "<td align=left width=220><input id='agencia1' type='text' name='agencia1' size='30' value='{$row_bus[agencia1]}' ></td>";
        echo "<td align=left class='text' width=100><b>Agência:</b></td>";
        echo "<td align=left class='text' width=220><input id='agencia2' type='text' name='agencia2' size='30' value='{$row_bus[agencia2]}' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Data da opção:</b></td>";
        echo "<td align=left width=220><input id='dtop' type='text' name='dtop' size='30' maxlength=10 value='".date("d/m/Y", strtotime($row_bus[data_opcao]))."'  onkeypress=\"formatar(this, '##/##/####');\" ></td>";
        echo "<td align=left class='text' width=100><b>Nº inscrição:</b></td>";
        echo "<td align=left class='text' width=220><input id='inscricao' type='text' name='inscricao' size='30' value='{$row_bus[inscricao]}' ></td>";
        echo "</tr>";
		
		echo "</table>";
		echo "<p>";

		/**************************************************************************************************/
		// --> DADOS SALARIAIS
		/**************************************************************************************************/
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td class='text'>";
		echo "<b>Dados empregatícios:</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
        
	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Nº Contrato:</b></td>";
        echo "<td align=left width=220><input id='contrato' type='text' name='contrato' size='30' value='".str_pad($row_bus[contrato], 4,"0",STR_PAD_LEFT)."' ></td>";
        echo "<td align=left class='text' width=100><b>Reg. Folha:</b></td>";
        echo "<td align=left class='text' width=220><input id='folha' type='text' name='folha' size='30' value='".str_pad($row_bus[folha], 3,"0",STR_PAD_LEFT)."' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Ocupação:</b></td>";
        echo "<td align=left width=220><input id='ocupacao' type='text' name='ocupacao' size='30' value=\"".stripslashes($row_bus[ocupacao])."\" ></td>";
        echo "<td align=left class='text' width=100><b>Admissão:</b></td>";
        echo "<td align=left class='text' width=220><input id='dt' type='text' name='dt' size='30' maxlength=10 value='".date("d/m/Y", strtotime($row_bus[dt_admissao]))."'  onkeypress=\"formatar(this, '##/##/####');\" ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Salário:</b></td>";
        echo "<td align=left width=220><input id='salario' type='text' name='salario' size='30' onkeypress=\"return FormataReais(this, '.', ',', event);\" value=".$row_alt[salario]." ></td>";
        echo "<td align=left class='text' width=100><b>Forma de pagamento:</b></td>";
        echo "<td align=left width=200><input id='pagamento' type='text' name='pagamento' size='30' value='{$row_bus[pagamento]}' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Horário de trabalho:</b></td>";
        echo "<td align=left width=220 class=text>das<input id='hora1' type='text' name='hora1' size='5' maxlength='5' OnKeyPress=\"formatar(this, '##:##');\" onblur=\"calcula_horas();\" value='{$row_bus[hora1]}' >às<input id='hora2' type='text' name='hora2' size='5' maxlength='5' OnKeyPress=\"formatar(this, '##:##');\"  onblur=\"calcula_horas();\" value='{$row_bus[hora2]}' >horas</td>";
        echo "<td align=left class='text' width=100><b>Intervalo:</b></td>";
        echo "<td align=left class='text' width=220><input id='hora3' type='text' name='hora3' size='23' maxlength='4' OnKeyPress=\"formatar(this, '#:##');\" value='{$row_bus[hora3]}'  onblur=\"calcula_horas();\" >horas</td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Horas semanais:</b></td>";
        echo "<td align=left width=220><input id='hora4' type='text' name='hora4' size='30' value='{$row_bus[hora4]}' ></td>";
        echo "<td align=left class='text' width=100><b>Beneficiários:</b></td>";
        echo "<td align=left class='text' width=220><input id='bene' type='text' name='bene' size='30' value=\"".stripslashes($row_bus[bene])."\" ></td>";
        echo "</tr>";
       
	    echo "</table>";
        echo "<p>";

		/**************************************************************************************************/
		// --> OBSERVAÇÕES
		/**************************************************************************************************/
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td class='text'>";
		echo "<b>Observações:</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
        
	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Observações:</b></td>";
        echo "<td align=left width=220 colspan=3><textarea id=obs type=text name=obs cols=70 rows=2>".stripslashes($row_bus[obs])."</textarea></td>";
        echo "</tr>";
        echo "</table>";

		echo "<p>";
		
		echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
			echo "<tr>";
			echo "<td align=left class='text'>";
				echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
				echo "<tr>";
					echo "<td align=center class='text roundbordermix'>";
					echo "<input type='button' class='btn' name='btnBack' value='Voltar' onclick=\"location.href='?dir=cad_col&p=a_reg&funcionario_id=$_GET[funcionario_id]';\"  onmouseover=\"showtip('tipbox', '- Voltar para tela de alteração de registro de colaboradores.');\" onmouseout=\"hidetip('tipbox');\">";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "<input type='submit' class='btn' name='btnSave' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
					echo "</td>";
				echo "</tr>";
				echo "</table>";
			echo "</tr>";
		echo "</table>";

		echo "</form>";

/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>