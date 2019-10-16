<?PHP
if($_POST[nome] != ""){
	
	if($_POST[dtad]){
            $tmp = explode("/", $_POST[dtad]);
    	    $dtad = $tmp[2]."/".$tmp[1]."/".$tmp[0];
	}
	
	if($_POST[dtdm]){
            $tmp = explode("/", $_POST[dtdm]);
    	    $dtdm = $tmp[2]."/".$tmp[1]."/".$tmp[0];
	}

	if($_POST[dtn]){
            $tmp = explode("/", $_POST[dtn]);
    	    $dtn = $tmp[2]."/".$tmp[1]."/".$tmp[0];
	}

	$query_alterar = "UPDATE funcionario SET 
						grupo_id 	   = $grupo_id
						, associada_id = $associada_id
						, cargo_id     = $cargo_id
						, nome  	   = '".addslashes($nome)."'
						, cpf 		   = '$cpf'
						, ctps   	   = '$ctps'
						, msn  		   = '$msn'
						, email  	   = '$email'
						, telefone	   = '$telefone'
						, celular      = '$celular'
						, assinatura   = '$assinatura'
						, registro     = '$registromtb'
						, nome_pai     = '".addslashes($nome_pai)."'
						, nome_mae 	   = '".addslashes($nome_mae)."'
						, serie   	   = '$serie'
						, ident  	   = '$ident'
						, orgao  	   = '$orgao'
						, titulo  	   = '$titulo'
						, zona 		   = '$zona'
						, reserva      = '$reserva'
                        , is_coord     = $_POST[is_coord]";
						if($_POST[dtn] != ""){
							$query_alterar.=", nascimento = '$dtn'"; 
						}
						if($_POST[dtad] != ""){
							$query_alterar.=", admissao = '$dtad'"; 
						}
						if($_POST[dtdm] != ""){
							$query_alterar.=", demissao = '$dtdm'"; 
						}
						$query_alterar.="
						, sexo  	   = '$sexo'
						, civil 	   = '$civil'
						, conjuge	   = '".addslashes($conjuge)."'
						, foto		   = '$pic'
						, endereco	   = '".addslashes($endereco)."'
						, num		   = '$num'
						WHERE funcionario_id = ".$funcionario_id;
	if(pg_query($connect, $query_alterar)){	
		$query_alterar_usuario = "UPDATE usuario SET
									grupo_id = $grupo_id
									, login = '$login'
									, senha = '$senha'
									WHERE funcionario_id = ".$funcionario_id;
		pg_query($connect, $query_alterar_usuario);
	}
	     showmessage('Colaborador Alterado com Sucesso!');
}

/***************************************************************************************************/
// -> FAZ A COMPARAÇÃO PARA BUSCAR OS DADOS NECESSARIOS PARA ILUSTRAR A TELA
/***************************************************************************************************/
$query="SELECT f.*, u.grupo_id, u.login, u.senha
		FROM funcionario f, usuario u
		WHERE f.funcionario_id = u.funcionario_id AND f.funcionario_id = $funcionario_id
		ORDER BY f.nome";
$result=pg_query($connect, $query);
$row=pg_fetch_array($result);

/***************************************************************************************************/
// -> CONSULTA DA ASSOCIADA Q VAI ILUSTRAR A TELA
/***************************************************************************************************/
$query_associada="SELECT * FROM associada ORDER BY nome";
$result_associada=pg_query($connect, $query_associada);
$row_a = pg_fetch_array($result_associada);

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
                    echo "<td class='text' height=30 align=center><input type='button' class='btn' name='btnReg' value='Registro' onclick=\"location.href='?dir=func_sesmt&p=a_reg&funcionario_id=$_GET[funcionario_id]';\"  onmouseover=\"showtip('tipbox', '- Permite alterar o registro do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnReg' value='Complemento' onclick=\"location.href='?dir=func_sesmt&p=a_reg&funcionario_id=$_GET[funcionario_id]&p=i_com';\"  onmouseover=\"showtip('tipbox', '- Permite registrar/alterar um complemento no cadastro do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                echo "</tr>";
				echo "<tr>";
                    echo "<td class='text' height=30 align=center><input type='button' class='btn' name='btnAlt' value='Alterar Salário' onclick=\"location.href='?dir=func_sesmt&p=a_reg&funcionario_id=$_GET[funcionario_id]&p=in_sal';\"  onmouseover=\"showtip('tipbox', '- Permite incluir/alterar o salário do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnfer' value='Férias' onclick=\"location.href='?dir=func_sesmt&p=a_reg&funcionario_id=$_GET[funcionario_id]&p=in_fer';\"  onmouseover=\"showtip('tipbox', '- Permite visualizar as férias do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                echo "</tr>";
				echo "<tr>";
                    echo "<td class='text' height=30 align=center><input type='button' class='btn' name='btnSin' value='Cont. Sindical' onclick=\"location.href='?dir=func_sesmt&p=a_reg&funcionario_id=$_GET[funcionario_id]&p=in_sind';\"  onmouseover=\"showtip('tipbox', '- Permite visualizar o ano da contribuição sindical do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnAci' value='Acidente Trab.' onclick=\"location.href='?dir=func_sesmt&p=a_reg&funcionario_id=$_GET[funcionario_id]&p=in_aci';\" onmouseover=\"showtip('tipbox', '- Permite registrar/alterar um complemento no cadastro do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                echo "</tr>";
				echo "<tr>";
                    echo "<td class='text' height=30 align=center><input type='button' class='btn' name='btnFrdf' value='Relação Doc.' onclick=\"window.open('./modules/func_sesmt/frdf.php?funcionario_id=$_GET[funcionario_id]&p=frdf', 'SESMT', 'height=1030, width=760, scrollbars = yes, status=yes, toolbar = yes, menubar=yes');\"  onmouseover=\"showtip('tipbox', '- Permite visualizar a relação de documentos necessários para admissão do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnCont' value='Contrato Public.' onclick=\"window.open('../../contratos/publicidade.php?fid=$_GET[funcionario_id]', 'SESMT', 'height=1030, width=760, scrollbars = yes, status=yes, toolbar = yes, menubar=yes');\" onmouseover=\"showtip('tipbox', '- Permite visualizar o contrato de publicidade do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                echo "</tr>";
                echo "</table>";
				
				echo "</td></tr></tbody></table>";
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
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'><b>Registro de Colaboradores</b></td>";
        echo "</tr>";
        echo "</table>";
	    
		echo "<table width=15% border=1 >";
		echo "<form name=form1 method=post>";
		echo "<tr>";
		echo "<td onclick=\"window.open('common/ajax_upload_func_pic.php', 'upload_pic', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=350,height=250')\" style=\"cursor: pointer;\" align=center width=100 height=120>";
		if(empty($row[foto])){
			echo "<div id=foto name=foto><b>foto</b><p><font size=1>Clique para inserir!</font></p></div>";
		}else{
			echo "<div id=foto name=foto><img src='$row[foto]' border=0 width=100 height=120></div>";
		}
		echo "</td></tr></table>";
		echo "<input name=pic id=pic value='$row[foto]' type=hidden>";


		/**************************************************************************************************/
		// --> DADOS EMPRESARIAIS
		/**************************************************************************************************/
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td class='text'>";
		echo "<b>Empresa Contratante:</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
        
	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Empresa:</b></td>";
        echo "<td align=left width=220><input id='nome' type='text' name='nome' value='".addslashes($row_a[nome])."' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>Endereço:</b></td>";
        echo "<td align=left class='text' width=220><input id='endereco' type='text' name='endereco' value='".addslashes($row_a[endereco])."' size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>CNPJ:</b></td>";
        echo "<td align=left width=220><input id='cnpj_franquia' type='text' name='cnpj_franquia' value='{$row_a[cnpj_franquia]}' size='18' maxlength='14' OnKeyPress=\"formatar(this, '###.###.###-##');\"></td>";
        echo "<td align=left class='text' width=100><b>Cidade:</b></td>";
        echo "<td align=left class='text' width=220><input id='cidade' type='text' name='cidade' value='".addslashes($row_a[cidade])."' size='18' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>CEP:</b></td>";
        echo "<td align=left width=220><input id='cep' type='text' name='cep' value='{$row_a[cep]}' size='18' ></td>";
        echo "<td align=left class='text' width=100><b>Estado:</b></td>";
        echo "<td align=left class='text' width=220><input id='uf' type='text' name='uf' value='{$row_a[uf]}' size='18' ></td>";
        echo "</tr>";
		
		echo "</table>";
		
		echo "<p>";

		/**************************************************************************************************/
		// --> DADOS PESSOAIS
		/**************************************************************************************************/
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td class='text'>";
		echo "<b>Dados pessoais:</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
        
	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Nome:</b></td>";
        echo "<td align=left width=220><input class=inputTextobr id='nome' type='text' name='nome' value=\"".stripslashes($row[nome])."\" size='35' ></td>";
        echo "<td align=left class='text' width=100><b>CPF:</b></td>";
        echo "<td align=left class='text' width=220><input class=inputTextobr id='cpf' type='text' name='cpf' value='{$row[cpf]}' size='18' maxlength='14' OnKeyPress=\"formatar(this, '###.###.###-##');\"></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Nome do pai:</b></td>";
        echo "<td align=left width=220><input id='nome_pai' type='text' name='nome_pai' value=\"$row[nome_pai]\" size='35' ></td>";
        echo "<td align=left class='text' width=100><b>Nome da mãe:</b></td>";
        echo "<td align=left class='text' width=220><input id='nome_mae' type='text' name='nome_mae' value=\"".stripslashes($row[nome_mae])."\" size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Telefone:</b></td>";
        echo "<td align=left width=220><input class=inputTextobr id='telefone' type='text' name='telefone' value='{$row[telefone]}' size='18' maxlength='12' OnKeyPress=\"formatar(this, '##-#### ####');\"></td>";
        echo "<td align=left class='text' width=100><b>Celular:</b></td>";
        echo "<td align=left class='text' width=220><input id='celular' type='text' name='celular' value='{$row[celular]}' size='18' maxlength='12' OnKeyPress=\"formatar(this, '##-#### ####');\"></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>E-mail:</b></td>";
        echo "<td align=left width=220><input id='email' type='text' name='email' value='{$row[email]}' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>MSN:</b></td>";
        echo "<td align=left class='text' width=220><input id='msn' type='text' name='msn' value='{$row[msn]}' size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>CTPS:</b></td>";
        echo "<td align=left width=220><input id='ctps' type='text' name='ctps' value='{$row[ctps]}' size='18' ></td>";
        echo "<td align=left class='text' width=100><b>Serie:</b></td>";
        echo "<td align=left class='text' width=220><input id='serie' type='text' name='serie' value='{$row[serie]}' size='18' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>RG:</b></td>";
        echo "<td align=left width=220><input id='ident' type='text' name='ident' value='{$row[ident]}' size='18' maxlength='10' OnKeyPress=\"formatar(this, '########-#');\"></td>";
        echo "<td align=left class='text' width=100><b>Órgão emissor:</b></td>";
        echo "<td align=left width=200><select name=orgao id=orgao style=\"width: 100px\">
              <option value=1"; if($row[orgao]==1){echo " selected ";} echo">Detran</option>
			  <option value=2"; if($row[orgao]==2){echo " selected ";} echo">IFP</option>
            </select></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Título:</b></td>";
        echo "<td align=left width=220><input id='titulo' type='text' name='titulo' value='{$row[titulo]}' size='18' ></td>";
        echo "<td align=left class='text' width=100><b>Zona eleitoral:</b></td>";
        echo "<td align=left class='text' width=220><input id='zona' type='text' name='zona' value='{$row[zona]}' size='18' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Cert. reservista:</b></td>";
        echo "<td align=left width=220><input id='reserva' type='text' name='reserva' value='{$row[reserva]}' size='18' ></td>";
        echo "<td align=left class='text' width=100><b>Nascimento:</b></td>";
        echo "<td align=left class='text' width=220><input id='dtn' type='text' name='dtn' ";
			if($row[nascimento]){ 
				echo " value='".date("d/m/Y", strtotime($row[nascimento]))."'";
			}else{ 
				echo "&nbsp;";
			}
		echo " size='18' maxlength=10 onkeypress=\"formatar(this, '##/##/####');\" ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Sexo:</b></td>";
        echo "<td align=left width=200><select name=sexo id=sexo style=\"width: 100px\">
              <option value=1"; if($row[sexo]==1){echo " selected ";} echo">Masculino</option>
			  <option value=2"; if($row[sexo]==2){echo " selected ";} echo">Feminino</option>
            </select></td>";
        echo "<td align=left class='text' width=100><b>Est. civil:</b></td>";
        echo "<td align=left width=200><select name=civil id=civil style=\"width: 100px\">
              <option value=1"; if($row[civil]==1){echo " selected ";} echo">Casado(a)</option>
			  <option value=2"; if($row[civil]==2){echo " selected ";} echo">Solteiro(a)</option>
			  <option value=3"; if($row[civil]==3){echo " selected ";} echo">Divórciado(a)</option>
			  <option value=4"; if($row[civil]==4){echo " selected ";} echo">Viúvo(a)</option>
            </select></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Cônjuge:</b></td>";
        echo "<td align=left width=220><input id='conjuge' type='text' name='conjuge' value=\"".stripslashes($row[conjuge])."\" size='35' ></td>";
        echo "<td align=left class='text' width=100><b>Endereço:</b></td>";
        echo "<td align=left class='text' width=220><input id='endereco' type='text' name='endereco' value=\"".stripslashes($row[endereco])."\" size='22' >&nbsp;<input id='num' type='text' name='num' value='{$row[num]}' size='3' ></td>";
        echo "</tr>";

        echo "</table>";
		
		echo "<p>";

		/**************************************************************************************************/
		// --> DADOS COMPLEMENTARES
		/**************************************************************************************************/
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td class='text'>";
		echo "<b>Dados complementares:</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";

	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
        echo "<tr>";
        echo "<td align=left class='text' width=100><b>Associada:</b></td>";
        echo "<td align=left width=220><select class=inputTextobr name=associada_id id=associada_id style=\"width: 220px\">
			 <option value=''>Associada</option>";
			 $query_associada="SELECT * FROM associada ORDER BY nome";
			 $result_associada=pg_query($connect, $query_associada);
			 while($row_associada=pg_fetch_array($result_associada)){ 			 
				if($row_associada[associada_id]<>$row[associada_id]){
			 		echo "<option value='{$row_associada[associada_id]}'> $row_associada[nome] </option>";
				}else{
					echo "<option value='{$row_associada[associada_id]}' selected> $row_associada[nome] </option>";
				}
			 }	
		echo "</select></td>";
        echo "<td align=left class='text' width=100><b>Grupo:</b></td>";
        echo "<td align=left width=220><select class=inputTextobr name=grupo_id id=grupo_id style=\"width: 100px\">
			 <option value=''>Grupo</option>";
			 $query_grupo="SELECT * FROM grupo ORDER BY nome";
			 $result_grupo=pg_query($connect, $query_grupo);
			 while($row_grupo=pg_fetch_array($result_grupo)){ 
			 	if($row_grupo[grupo_id]<>$row[grupo_id]){
			 		echo "<option value='{$row_grupo[grupo_id]}'> $row_grupo[nome] </option>";
				}else{
					echo "<option value='{$row_grupo[grupo_id]}' selected> $row_grupo[nome] </option>";
				}
			 }
		echo "</select></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Cargo:</b></td>";
        echo "<td align=left width=220><select class=inputTextobr name=cargo_id id=cargo_id style=\"width: 220px\">
			 <option value=''>Cargo</option>";
			 $query_cargo="SELECT * FROM cargo ORDER BY nome";
			 $result_cargo=pg_query($connect, $query_cargo);
			 while($row_cargo=pg_fetch_array($result_cargo)){ 
			 	if($row_cargo[cargo_id]<>$row[cargo_id]){
			 		echo "<option value='{$row_cargo[cargo_id]}'> $row_cargo[nome] </option>";
				}else{
					echo "<option value='{$row_cargo[cargo_id]}' selected> $row_cargo[nome] </option>";
				}
			 }
		echo "</select></td>";
        echo "<td align=left class='text' width=100><b>Coordenador:</b></td>";
        echo "<td align=left class='text' width=220>";
        echo "<select name='is_coord' id='is_coord'>";
            echo "<option value=0"; if(!$row[is_coord]) echo" selected "; echo">Não</option>";
            echo "<option value=1"; if($row[is_coord]) echo" selected "; echo">Sim</option>";
            echo "</select>";
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Login:</b></td>";
        echo "<td align=left class='text' width=220><input class='inputTextobr' id='login' type='text' name='login' value='{$row[login]}' size='33'></td>";
        echo "<td align=left class='text' width=100><b>Senha:</b></td>";
        echo "<td align=left class='text' width=220><input class='inputTextobr' id='senha' type='password' name='senha' value='{$row[senha]}' size='18' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Admissão:</b></td>";
        echo "<td align=left width=220><input id='dtad' type='text' name='dtad' maxlength=10 ";
			if($row[admissao]){ 
				echo " value='".date("d/m/Y", strtotime($row[admissao]))."'";
			}else{ 
				echo "&nbsp;";
			}
		echo " onkeypress=\"formatar(this, '##/##/####');\" ></td>";
        echo "<td align=left class='text' width=100><b>Demissão:</b></td>";
        echo "<td align=left class='text' width=220><input id='dtdm' type='text' name='dtdm' maxlength=10 ";
			if($row[demissao]){ 
				echo " value='".date("d/m/Y", strtotime($row[demissao]))."'";
			}else{ 
				echo "&nbsp;";
			} 
		echo " onkeypress=\"formatar(this, '##/##/####');\" ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Assinatura:</b></td>";
        echo "<td align=left width=220><input id='assinatura' type='file' name='assinatura' size='13'></td>";
        echo "<td align=left class='text' width=100><b>Registro MTB:</b></td>";
        echo "<td align=left class='text' width=220>";
        echo "<input id='registromtb' type='text' name='registromtb' value='{$row[registro]}' size='18'>";
        echo "</td>";
        echo "</tr>";

        echo "</table>";
		
		echo "<p>";
		
		echo "&nbsp;<span class=inputTextobr>&nbsp;&nbsp;&nbsp;&nbsp;</span><font size=1><i> - Campos com esta coloração são de preenchimento obrigatório!</i></font><p>";
		
		echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
			echo "<tr>";
			echo "<td align=left class='text'>";
				echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
				echo "<tr>";
					echo "<td align=center class='text roundbordermix'>";
					echo "<input type='submit' class='btn' name='btnSave' value='Alterar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
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
