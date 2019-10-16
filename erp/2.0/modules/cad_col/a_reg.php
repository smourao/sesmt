<?PHP
if($_POST[btnSave] && isset($_POST[nome])){
    if(isset($_FILES[assinatura])){
        $uploadErrors = array(
        UPLOAD_ERR_OK => 'Arquivo enviado com sucesso.',
        UPLOAD_ERR_INI_SIZE => 'O arquivo enviado excede o tamanho máximo (upload_max_filesize) no php.ini.',
        UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
        UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
        UPLOAD_ERR_NO_FILE => 'Arquivo não enviado.',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
        UPLOAD_ERR_CANT_WRITE => 'Erro ao escrever o arquivo no disco.',
        UPLOAD_ERR_EXTENSION => 'File upload stopped by extension.',
        );
        //print_r($_FILES);
        //echo $_FILES[assinatura][type];
        if(!$_FILES[assinatura][error]){
            if($_FILES[assinatura][type] == 'image/pjpeg' || $_FILES[assinatura][type] == 'image/gif' || $_FILES[assinatura][type] == 'image/jpeg' || $_FILES[assinatura][type] == 'image/jpg' || $_FILES[assinatura][type] == 'image/pjpg' || $_FILES[assinatura][type] == 'image/png'){
                $temp = rand(1000000000, 9999999999);
                $filename = $temp."_".basename($_FILES[assinatura][name]);
                $path = "images/assinaturas/";
                $target_path = $path.$filename;
                //if already exists, try again...
                if(file_exists($target_path)){
                    $temp = rand();
                    $filename = $temp."_".basename($_FILES[assinatura][name]);
                    $target_path = $path.$filename;
                }
                //try to move
                if(move_uploaded_file($_FILES['assinatura']['tmp_name'], $target_path)){
                    //upload done!
                    //echo "Move ok!";
                }else{
                    //echo "Error on move!";
                }
                //if file exists
                if(file_exists($target_path)){
                   //done
                   $_POST[assinatura] = 'http://www.sesmt-rio.com/erp/2.0/'.$target_path;
                }else{
                   //file not exists
                   //echo "Houve um erro ao enviar a imagem. Por favor, tente novamente mais tarde.<BR>";
                }
            }else{
                //invalid file format
                //echo "O formato da imagem não é suportado. Por favor, utilize uma imagem em um dos seguintes formatos: jpg, gif ou png.<BR>";
            }
        }else{
            switch($_FILES[assinatura][error]){
                case 0:
                case 4:
                break;
                case 1:
                case 2:
                    //echo "A imagem não foi enviada pois excede o tamanho máximo permitido de 1MB.<BR>";
                break;
                case 3:
                case 5:
                case 6:
                case 7:
                   //echo "Houve um erro ao enviar a imagem. Por favor, tente novamente mais tarde.<BR>";
                break;
            }
        }
    }
	
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
						nome  	   = '".addslashes($nome)."'
						, cpf 		   = '$cpf'
						, ctps   	   = '$ctps'
						, msn  		   = '$msn'
						, email  	   = '$email'
						, telefone	   = '$telefone'
						, celular      = '$celular'";
						
	if(isset($_POST[assinatura])) $query_alterar .= ", assinatura   = '$_POST[assinatura]'";
    $query_alterar .= "
						, registro     = '$registromtb'
						, nome_pai     = '".addslashes($nome_pai)."'
						, nome_mae 	   = '".addslashes($nome_mae)."'
						, serie   	   = '$serie'
						, ident  	   = '$ident'
						, orgao  	   = '$orgao'
						, titulo  	   = '$titulo'
						, zona 		   = '$zona'
						, reserva      = '$reserva'";
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
	     showmessage('Colaborador Alterado com Sucesso!');
	}
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
                    echo "<b>Selecione uma opção</b>";
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
	    
		echo "<table width=100% border=0 >";
		echo "<form name=form1 method=post enctype='multipart/form-data'>";
		echo "<tr>";
		echo "<td onclick=\"window.open('common/ajax_upload_func_pic.php', 'upload_pic', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=350,height=250')\" style=\"cursor: pointer;\" align=center width=100 height=120>";
		if(empty($row[foto])){
			echo "<div id=foto name=foto><b>foto</b><p><font size=1>Clique para inserir!</font></p></div>";
		}else{
			echo "<div id=foto name=foto><img src='$row[foto]' border=0 width=100 height=120></div>";
		}
		echo "</td>";
		echo "<td>";
		
	
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td class='text'>";
		echo "<b>Empresa Contratante:</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
        

		/**************************************************************************************************/
		// --> DADOS EMPRESARIAIS
		/**************************************************************************************************/
		
	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Empresa:</b></td>";
        echo "<td align=left width=220><input id='nome' type='text' name='nome' value='".addslashes($row_a[nome])."' size='30' ></td>";
        echo "<td align=left class='text' width=100><b>Endereço:</b></td>";
        echo "<td align=left class='text' width=220><input id='endereco' type='text' name='endereco' value='".addslashes($row_a[endereco])."' size='30' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>CNPJ:</b></td>";
        echo "<td align=left width=220><input id='cnpj_franquia' type='text' name='cnpj_franquia' value='{$row_a[cnpj_franquia]}' size='30' maxlength='14' OnKeyPress=\"formatar(this, '###.###.###-##');\"></td>";
        echo "<td align=left class='text' width=100><b>Cidade:</b></td>";
        echo "<td align=left class='text' width=220><input id='cidade' type='text' name='cidade' value='".addslashes($row_a[cidade])."' size='30' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>CEP:</b></td>";
        echo "<td align=left width=220><input id='cep' type='text' name='cep' value='{$row_a[cep]}' size='30' ></td>";
        echo "<td align=left class='text' width=100><b>Estado:</b></td>";
        echo "<td align=left class='text' width=220><input id='uf' type='text' name='uf' value='{$row_a[uf]}' size='30' ></td>";
        echo "</tr>";
		
		echo "</table>";
		
		
		echo "</td>";
		echo"</tr></table>";
		echo "<input name=pic id=pic value='$row[foto]' type=hidden>";

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
        echo "<td align=left class='text' width=220><input class=inputTextobr id='cpf' type='text' name='cpf' value='{$row[cpf]}' size='35' maxlength='14' OnKeyPress=\"formatar(this, '###.###.###-##');\"></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Nome do pai:</b></td>";
        echo "<td align=left width=220><input id='nome_pai' type='text' name='nome_pai' value=\"$row[nome_pai]\" size='35' ></td>";
        echo "<td align=left class='text' width=100><b>Nome da mãe:</b></td>";
        echo "<td align=left class='text' width=220><input id='nome_mae' type='text' name='nome_mae' value=\"".stripslashes($row[nome_mae])."\" size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Telefone:</b></td>";
        echo "<td align=left width=220><input class=inputTextobr id='telefone' type='text' name='telefone' value='{$row[telefone]}' size='35' maxlength='12' OnKeyPress=\"formatar(this, '##-#### ####');\"></td>";
        echo "<td align=left class='text' width=100><b>Celular:</b></td>";
        echo "<td align=left class='text' width=220><input id='celular' type='text' name='celular' value='{$row[celular]}' size='35' maxlength='13' OnKeyPress=\"formatar(this, '##-#### ####');\"></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>E-mail:</b></td>";
        echo "<td align=left width=220><input id='email' type='text' name='email' value='{$row[email]}' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>MSN:</b></td>";
        echo "<td align=left class='text' width=220><input id='msn' type='text' name='msn' value='{$row[msn]}' size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>CTPS:</b></td>";
        echo "<td align=left width=220><input id='ctps' type='text' name='ctps' value='{$row[ctps]}' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>Serie:</b></td>";
        echo "<td align=left class='text' width=220><input id='serie' type='text' name='serie' value='{$row[serie]}' size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>RG:</b></td>";
        echo "<td align=left width=220><input id='ident' type='text' name='ident' value='{$row[ident]}' size='35' maxlength='10' OnKeyPress=\"formatar(this, '########-#');\"></td>";
        echo "<td align=left class='text' width=100><b>Órgão emissor:</b></td>";
        echo "<td align=left width=200><select name=orgao id=orgao style=\"width: 245px\">
              <option value=1"; if($row[orgao]==1){echo " selected ";} echo">Detran</option>
			  <option value=2"; if($row[orgao]==2){echo " selected ";} echo">IFP</option>
            </select></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Título:</b></td>";
        echo "<td align=left width=220><input id='titulo' type='text' name='titulo' value='{$row[titulo]}' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>Zona eleitoral:</b></td>";
        echo "<td align=left class='text' width=220><input id='zona' type='text' name='zona' value='{$row[zona]}' size='35' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Cert. reservista:</b></td>";
        echo "<td align=left width=220><input id='reserva' type='text' name='reserva' value='{$row[reserva]}' size='35' ></td>";
        echo "<td align=left class='text' width=100><b>Nascimento:</b></td>";
        echo "<td align=left class='text' width=220><input id='dtn' type='text' name='dtn' ";
			if($row[nascimento]){ 
				echo " value='".date("d/m/Y", strtotime($row[nascimento]))."'";
			}else{ 
				echo "&nbsp;";
			}
		echo " size='35' maxlength=10 onkeypress=\"formatar(this, '##/##/####');\" ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Sexo:</b></td>";
        echo "<td align=left width=200><select name=sexo id=sexo style=\"width: 245px\">
              <option value=1"; if($row[sexo]==1){echo " selected ";} echo">Masculino</option>
			  <option value=2"; if($row[sexo]==2){echo " selected ";} echo">Feminino</option>
            </select></td>";
        echo "<td align=left class='text' width=100><b>Est. civil:</b></td>";
        echo "<td align=left width=200><select name=civil id=civil style=\"width: 245px\">
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
        echo "<td align=left class='text' width=220><input id='endereco' type='text' name='endereco' value=\"".stripslashes($row[endereco])."\" size='26' >&nbsp;<input id='num' type='text' name='num' value='{$row[num]}' size='2' ></td>";
        echo "</tr>";

        echo "</table>";
		
		echo "<p>";

		/**************************************************************************************************/
		// --> DADOS COMPLEMENTARES
		/**************************************************************************************************/
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td class='text'>";
		echo "<b>Dados Adicionais:</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";

	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Admissão:</b></td>";
        echo "<td align=left width=220><input id='dtad' type='text' name='dtad' maxlength=10 size='31' class='inputTextobr' ";
			if($row[admissao]){ 
				echo " value='".date("d/m/Y", strtotime($row[admissao]))."'";
			}else{ 
				echo "&nbsp;";
			}
		echo " onkeypress=\"formatar(this, '##/##/####');\" ></td>";
        echo "<td align=left class='text' width=100><b>Demissão:</b></td>";
        echo "<td align=left class='text' width=220><input id='dtdm' type='text' name='dtdm' maxlength=10 size='27' ";
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
        echo "<input id='registromtb' type='text' name='registromtb' value='{$row[registro]}' size='27'>";
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
