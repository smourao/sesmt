<div class='novidades_text'>
<p align=justify>
<?PHP
/*************************************************************************************************************/
// --> POST FUNC DATA - SAVE/ADD
/*************************************************************************************************************/
if($_POST && $_POST[btnSaveFunc]){
    //print_r($_POST);
    //print_r($_FILES);

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
    
    //file type ok!
    if(!$_FILES[upload][error]){
        if($_FILES[upload][type] == 'image/pjpeg' || $_FILES[upload][type] == 'image/gif' || $_FILES[upload][type] == 'image/jpeg' || $_FILES[upload][type] == 'image/jpg' || $_FILES[upload][type] == 'image/pjpg' || $_FILES[upload][type] == 'image/png'){
            $temp = rand(1000000000, 9999999999);
            $filename = $_SESSION[cod_cliente]."_".$temp."_".basename($_FILES[upload][name]);
            $path = "images/funcionarios/upload/";/*getcwd().*/
            $target_path = $path.$filename;
            //if already exists, try again...
            if(file_exists($target_path)){
                $temp = rand();
                $filename = $_SESSION[cod_cliente]."_".$temp."_".basename($_FILES[upload][name]);
                $target_path = $path.$filename;
            }
            //try to move
            if(move_uploaded_file($_FILES['upload']['tmp_name'], $target_path)){
                //upload done!
                //echo "Move ok!";
            }else{
                //echo "Error on move!";
            }
            //if file exists
            if(file_exists($target_path)){
               //done
               $_POST[img_url] = $target_path;
               //echo "file ok";
            }else{
               //file not exists
               //echo "File not exists";
               echo "Houve um erro ao enviar a imagem. Por favor, tente novamente mais tarde.<BR>";
            }
        }else{
            //invalid file format
            echo "O formato da imagem não é suportado. Por favor, utilize uma imagem em um dos seguintes formatos: jpg, gif ou png.<BR>";
        }
    }else{
        switch($_FILES[upload][error]){
            case 0:
            case 4:
            break;
            case 1:
            case 2:
                echo "A imagem não foi enviada pois excede o tamanho máximo permitido de 1MB.<BR>";
            break;
            case 3:
            case 5:
            case 6:
            case 7:
               echo "Houve um erro ao enviar a imagem. Por favor, tente novamente mais tarde.<BR>";
            break;
        }
    }
    $_GET[fid] = (int)(anti_injection($_GET[fid]));
    // -- EDIT FUNC DATA -------------------------------------------------------------------------------------
    if($_GET[fid]){
        $sql = "UPDATE funcionarios SET
        rg = '".anti_injection($_POST[rg])."',
        nome_func = '".anti_injection($_POST[nome])."',
        sexo_func = '".anti_injection($_POST[sexo])."',
        data_nasc_func = '".anti_injection($_POST[nascimento])."',
        civil = '".anti_injection($_POST[estado_civil])."',
        cep = '".anti_injection($_POST[cep])."',
        endereco_func = '".anti_injection($_POST[endereco])."',
        bairro_func = '".anti_injection($_POST[bairro])."',
        cidade = '".anti_injection($_POST[cidade])."',
        estado = '".anti_injection($_POST[estado])."',
        naturalidade = '".anti_injection($_POST[natural])."',
        nacionalidade = '".anti_injection($_POST[nacionalidade])."',
		cod_setor = '".anti_injection($_POST[setor])."',
        cod_funcao = '".anti_injection($_POST[funcao])."',
        dinamica_funcao = '".anti_injection($_POST[dinamica_funcao])."',
        data_admissao_func = '".anti_injection($_POST[admissao])."',
        cbo = '".anti_injection($_POST[cbo])."',
        num_ctps_func = '".anti_injection($_POST[ctps])."',
        serie_ctps_func = '".anti_injection($_POST[serie])."'";
        if($_POST[img_url])
            $sql .= ", img_url = '$_POST[img_url]'";
        $sql .= " WHERE cod_func = $_GET[fid] AND cod_cliente = ".(int)($_SESSION[cod_cliente]);
        if(pg_query($sql)){
            echo "Dados do colaborador atualizados com sucesso!";
        }else{
            echo "Houve um erro ao tentar atualizar os dados deste colaborador. Por favor, tente novamente em alguns instantes, se o problema persistir, entre em contato com a nossa <a href='?do=contato'>central de atendimento</a>.";
        }
    }else{
    // -- ADD FUNC DATA --------------------------------------------------------------------------------------
        //$sql = "SELECT * FROM funcionarios WHERE cod_cliente = ".(int)($_SESSION[cod_cliente])." AND lower(nome_func) = '".strtolower(anti_injection($_POST[nome]))."'";
        $sql = "SELECT * FROM funcionarios WHERE cod_cliente = ".(int)($_SESSION[cod_cliente])." AND num_ctps_func = '".anti_injection($_POST[ctps])."' AND serie_ctps_func = '".anti_injection($_POST[serie])."'";
        if(pg_num_rows(pg_query($sql)) <= 0){
            $sql = "SELECT MAX(cod_func) as cod_func FROM funcionarios WHERE cod_cliente = ".(int)($_SESSION[cod_cliente]);
            $max = pg_fetch_array(pg_query($sql));
            $max = $max[cod_func] + 1;
            $sql = "INSERT INTO funcionarios
            (cod_func, nome_func, endereco_func, bairro_func, num_ctps_func, serie_ctps_func, cbo, cod_funcao, sexo_func,
            data_nasc_func, data_admissao_func, dinamica_funcao, cidade, cod_cliente, cod_setor, naturalidade, nacionalidade,
            civil, rg, cep, estado, img_url, cod_status)
            VALUES
            ('$max', '".anti_injection($_POST[nome])."', '".anti_injection($_POST[endereco])."',
            '".anti_injection($_POST[bairro])."', '".anti_injection($_POST[ctps])."',
            '".anti_injection($_POST[serie])."','".anti_injection($_POST[cbo])."',
            '".anti_injection($_POST[funcao])."', '".anti_injection($_POST[sexo])."',
            '".anti_injection($_POST[nascimento])."', '".anti_injection($_POST[admissao])."',
            '".anti_injection($_POST[dinamica_funcao])."', '".anti_injection($_POST[cidade])."',
            '".anti_injection($_SESSION[cod_cliente])."', '".anti_injection($_POST[setor])."',
			'".anti_injection($_POST[naturalidade])."',
            '".anti_injection($_POST[nacionalidade])."', '".anti_injection($_POST[estado_civil])."',
            '".anti_injection($_POST[rg])."', '".anti_injection($_POST[cep])."', '".anti_injection($_POST[estado])."',
            '$_POST[img_url]', 1)";
			

			
            if(pg_query($sql)){
			
				$ctpss = $_POST[ctps];

																	
			
                echo "<br />Dados do colaborador cadastrados com sucesso!, <a href=\"?do=geraso&a=2&tp=1&cod=$max&set={$_POST[setor]}\">Clique aqui para agendar o ASO admissional!</a>";
           
		   
		   
		   
		    }else{
			echo $setorcliente;
                echo "Houve um erro ao tentar cadastrar os dados deste colaborador. Por favor, tente novamente em alguns instantes, se o problema persistir, entre em contato com a nossa <a href='?do=contato'>central de atendimento</a>.";
            }
        }else{
            echo "Já existe um funcionário cadastrado com o mesmo CTPS informado.";
        }
    }
}
/*************************************************************************************************************/
// --> GET FUNC DATA
/*************************************************************************************************************/
if($_GET[fid] && is_numeric($_GET[fid])){
    $_GET[fid] = (int)(anti_injection($_GET[fid]));
    $sql = "SELECT * FROM funcionarios WHERE cod_func = $_GET[fid] AND cod_cliente = ".(int)($_SESSION[cod_cliente]);
    $res = pg_query($sql);
    $fun = pg_fetch_array($res);
    echo "Preencha todos os campos obrigatórios e clique no botão salvar dados para <b>atualizar os dados</b> deste colaborador.";
}else{
    echo "Para realizar um <b>novo cadastro</b> de um colaborador, preencha todos os campos obrigatórios abaixo. Lembrando, que não é possível o cadastro se a CTPS já estiver cadastrada.";
}
?>
</div>
<form enctype="multipart/form-data" method="post" name="frmAddFunc" onsubmit="return check_func_form(this);">
<img src='images/sub-dados-pessoais.jpg' border=0>
<table width=100% cellspacing=2 cellpadding=2 border=0>
<tr>
    <td width=180 height=120>&nbsp;</td>
    <td>
        <button onclick="return false;" style="border: 0px solid #000;width: 100px; height: 120px; position: relative; top: 0px; left: 0px;">
        <a href="javascript: void(0)">
            <?PHP
                if($fun[img_url]){
                    echo "<img src='$fun[img_url]' border=0 width=100 height=120>";
                }else{
                    echo "<img src='images/without-pic.jpg' border=0>";
                }
            ?>
        </a>
        </button>
        <input type="file" id="upload_input" name="upload" style="cursor: pointer; font-size: 20px; height: 30px; width: 100px; opacity: 0; filter:alpha(opacity: 0);  position: relative; top: -5px; left: -110px" />
    </td>
</tr>
<tr>
    <td width=180>RG:</td>
    <td><input type=text class='' name='rg' id='rg' value='<?=$fun[rg]?>' onkeyup="change_classname('rg', 'required');"></td>
</tr>
<tr>
    <td width=180>Nome:</td>
    <td><input type=text class='required' name='nome' id='nome' value='<?=$fun[nome_func]?>' size='30' onkeyup="change_classname('nome', 'required');"></td>
</tr>
<tr>
    <td width=180>Sexo:</td>
    <td><input type=radio id='sexo_m' name='sexo' value='masculino' <?PHP if(strtolower($fun[sexo_func]) == 'masculino') echo 'checked';?> > Masculino <input type=radio id='sexo_f' name='sexo' value='feminino' <?PHP if(strtolower($fun[sexo_func]) == 'feminino') echo 'checked';?> > Feminino</td>
</tr>
<tr>
    <td width=180>Nascimento:</td>
    <td><input type=text id='nascimento' name='nascimento' value='<?=$fun[data_nasc_func]?>' size=10 maxlength=10 onkeypress="formatar(this, '##/##/####');" onkeydown="return only_number(event);" class='required' onkeyup="change_classname('nascimento', 'required');"></td>
</tr>
<tr>
    <td width=180>Estado civil:</td>
    <td>
        <select class='required' name='estado_civil' id='estado_civil' onchange="change_classname('nascimento', 'required');">
            <option value=''></option>
            <option value='Solteiro' <?PHP if(strtolower($fun[civil]) == 'solteiro') echo "selected";?> >Solteiro</option>
            <option value='Casado' <?PHP if(strtolower($fun[civil]) == 'casado') echo "selected";?> >Casado</option>
            <option value='Divorciado' <?PHP if(strtolower($fun[civil]) == 'divorciado') echo "selected";?> >Divorciado</option>
            <option value='Desquitado' <?PHP if(strtolower($fun[civil]) == 'desquitado') echo "selected";?> >Desquitado</option>
            <option value='Viúvo' <?PHP if(strtolower($fun[civil]) == 'viúvo') echo "selected";?> >Viúvo</option>
        </select>
    </td>
</tr>
</table>

<p><BR>

<img src='images/sub-dados-residenciais.jpg' border=0>
<table width=100% cellspacing=2 cellpadding=2 border=0>
<tr>
<td width=180>CEP:</td>
<td><input type=text id='cep' name='cep' value='<?=$fun[cep]?>' size=10 maxlength="9" onkeydown="return only_number(event);" onkeypress="formatar(this, '#####-###');" size=30 class='' onblur="check_cep(this);" onkeyup="change_classname('cep', 'required');">&nbsp;<span id='loading_cep'></span></td>
</tr>
<tr>
<td width=180>Endereço:</td>
<td><input type=text id=endereco name=endereco size=30 value='<?=$fun[endereco_func]?>'  class='' onkeyup="change_classname('endereco', 'required');"> <!-- Nº <input type=text id=num_end name=num_end value='511'  size=5 class='required' onkeydown="return only_number(event);" onkeyup="change_classname('email', 'required');">--></td>
</tr>
<tr>
<td width=180>Bairro:</td>
<td><input type=text id='bairro' name='bairro' value='<?=$fun[bairro_func]?>' class='' onkeyup="change_classname('bairro', 'required');"></td>
</tr>
<tr>
<td width=180>Cidade:</td>
<td><input type=text id='cidade' name='cidade' value='<?=$fun[cidade]?>' class='' onkeyup="change_classname('cidade', 'required');"></td>
</tr>
<tr>
<td width=180>Estado:</td>
<td>
<select name="estado" id="estado" class='' onkeyup="change_classname('estado', 'required');">
            <option value=""></option>
            <option value="AC" <?PHP if(substr($fun[estado], 0, 2) == 'AC') echo "selected";?> >Acre</option>

            <option value="AM" <?PHP if(substr($fun[estado], 0, 2) == 'AM') echo "selected";?> >Amazonas</option>
            <option value="AP" <?PHP if(substr($fun[estado], 0, 2) == 'AP') echo "selected";?> >Amapá</option>
            <option value="AL" <?PHP if(substr($fun[estado], 0, 2) == 'AL') echo "selected";?> >Alagoas</option>

            <option value="BA" <?PHP if(substr($fun[estado], 0, 2) == 'BA') echo "selected";?> >Bahia</option>
            <option value="CE" <?PHP if(substr($fun[estado], 0, 2) == 'CE') echo "selected";?> >Ceará</option>
            <option value="DF" <?PHP if(substr($fun[estado], 0, 2) == 'DF') echo "selected";?> >Distrito Federal</option>

            <option value="ES" <?PHP if(substr($fun[estado], 0, 2) == 'ES') echo "selected";?> >Espírito Santo</option>
            <option value="GO" <?PHP if(substr($fun[estado], 0, 2) == 'GO') echo "selected";?> >Goiás</option>

            <option value="MA" <?PHP if(substr($fun[estado], 0, 2) == 'MA') echo "selected";?> >Maranhão</option>
            <option value="MT" <?PHP if(substr($fun[estado], 0, 2) == 'MT') echo "selected";?> >Mato Grosso</option>
            <option value="MS" <?PHP if(substr($fun[estado], 0, 2) == 'MS') echo "selected";?> >Mato Grosso do Sul</option>
            <option value="MG" <?PHP if(substr($fun[estado], 0, 2) == 'MG') echo "selected";?> >Minas Gerais</option>

            <option value="PA" <?PHP if(substr($fun[estado], 0, 2) == 'PA') echo "selected";?> >Pará</option>
            <option value="PB" <?PHP if(substr($fun[estado], 0, 2) == 'PB') echo "selected";?> >Paraíba</option>

            <option value="PE" <?PHP if(substr($fun[estado], 0, 2) == 'PE') echo "selected";?> >Pernambuco</option>
            <option value="PR" <?PHP if(substr($fun[estado], 0, 2) == 'PR') echo "selected";?> >Paraná</option>
            <option value="PI" <?PHP if(substr($fun[estado], 0, 2) == 'PI') echo "selected";?> >Piauí</option>
            <option value="RJ" <?PHP if(substr($fun[estado], 0, 2) == 'RJ') echo "selected";?> >Rio de Janeiro</option>

            <option value="RN" <?PHP if(substr($fun[estado], 0, 2) == 'RN') echo "selected";?> >Rio Grande do Norte</option>
            <option value="RO" <?PHP if(substr($fun[estado], 0, 2) == 'RO') echo "selected";?> >Rondônia</option>

            <option value="RS" <?PHP if(substr($fun[estado], 0, 2) == 'RS') echo "selected";?> >Rio Grande do Sul</option>
            <option value="RR" <?PHP if(substr($fun[estado], 0, 2) == 'RR') echo "selected";?> >Roraima</option>
            <option value="SC" <?PHP if(substr($fun[estado], 0, 2) == 'SC') echo "selected";?> >Santa Catarina</option>
            <option value="SE" <?PHP if(substr($fun[estado], 0, 2) == 'SE') echo "selected";?> >Sergipe</option>

            <option value="SP" <?PHP if(substr($fun[estado], 0, 2) == 'SP') echo "selected";?> >São Paulo</option>
            <option value="TO" <?PHP if(substr($fun[estado], 0, 2) == 'TO') echo "selected";?> >Tocantins</option>

</select>
</td>
</tr>
<tr>
<td width=180>Natural:</td>
<td><input type=text id='natural' name='natural' class='' value='<?=$fun[naturalidade]?>' ></td>
</tr>
<tr>
<td width=180>Nacionalidade:</td>
<td><input type=text id='nacionalidade' name='nacionalidade' class='' value='<?=$fun[nacionalidade]?>' ></td>
</tr>
</table>

<p><BR>

<img src='images/sub-dados-profissionais.jpg' border=0>
<table width=100% cellspacing=2 cellpadding=2 border=0>




<tr>
<td width=180>Setor:</td>
<td>
<?PHP
	//lista codigo de setores de acordo com o cliente
	$client = $_SESSION['cod_cliente'];
//	$sql2 = "SELECT * FROM cliente_setor WHERE cod_cliente = $client";
   // $rlf2 = pg_query($sql2);
   // $funcoes2 = pg_fetch_all($rlf2);

	$sql3 = "SELECT s.*, cs.* FROM setor s, cliente_setor cs WHERE cs.cod_setor = s.cod_setor AND cs.cod_cliente = $client ORDER BY s.nome_setor" ;
    //$sql3 = "SELECT * FROM setor INNER JOIN cliente_setor ON cliente_setor.cod_setor = setor.cod_setor WHERE cod_cliente = $client ORDER BY nome_setor";
    $rlf3 = pg_query($sql3);
    $funcoes3 = pg_fetch_all($rlf3);
	
    echo "<select class='required' name='setor' id='setor' style=\"width: 300px;\" onkeyup=\"change_classname('setor', 'required');\">";
        echo "<option value=''></option>";
    for($y=0;$y < pg_num_rows($rlf3);$y++){
echo "<option value='{$funcoes3[$y][cod_setor]}'"; print $fun[cod_setor] == $funcoes3[$y][cod_setor] ? " selected " : ""; echo ">".substr($funcoes3[$y][nome_setor], 0, 71)."</option>";
    }
    echo "</select>";

?>
</td>
</tr>
<tr>
<td width=180>Função:</td>
<td>
<?PHP
    $sql = "SELECT cod_funcao, nome_funcao, dsc_funcao FROM funcao ORDER BY nome_funcao";
    $rlf = pg_query($sql);
    $funcoes = pg_fetch_all($rlf);
    echo "<select class='required' name='funcao' id='funcao' style=\"width: 300px;\" onchange=\"get_dinamica_funcao(this.value);\" onkeyup=\"change_classname('funcao', 'required');\">";
        echo "<option value=''></option>";
    for($y=0;$y < pg_num_rows($rlf);$y++){
	
	echo "<option value='{$funcoes[$y][cod_funcao]}'";
	if($fun[cod_funcao] == $funcoes[$y][cod_funcao]){
	echo " selected ";
	$dinamica = $funcoes[$y][dsc_funcao];
	}else{
	 "";
	 }
	 echo ">".substr($funcoes[$y][nome_funcao], 0, 71)."</option>";

        echo ">{$funcoes[$y][nome_funcao]}</option>";
    }
    echo "</select>&nbsp;<span id='loading_funcao'></span>";

?>
</td>
</tr>
<tr>
<td width=180>Dinâmica da função:</td>
<td><textarea id=dinamica_funcao name=dinamica_funcao class='required' rows=4 style="width: 300px;" readonly><?=$dinamica?></textarea></td>
</tr>
<tr>
<td width=180>Data de admissão:</td>
<td><input type=text id='admissao' name='admissao' value='<?=$fun[data_admissao_func]?>' size=10 maxlength=10 onkeypress="formatar(this, '##/##/####');" onkeydown="return only_number(event);" class='required' onkeyup="change_classname('admissao', 'required');"></td>
</tr>
<tr>
<td width=180>CBO:</td>
<td><input type=text id='cbo' name='cbo' value='<?=$fun[cbo]?>' size=10 maxlength="9" onkeydown="return only_number(event);" class='required' onkeyup="change_classname('cbo', 'required');"></td>
</tr>
<tr>
<td width=180>CTPS:</td>
<td><input type=text id='ctps' name='ctps' value='<?=$fun[num_ctps_func]?>' size=10 maxlength="10" onkeydown="return only_number(event);" class='required' onkeyup="change_classname('ctps', 'required');"></td>
</tr>
<tr>
<td width=180>Série:</td>
<td><input type=text id='serie' name='serie' value='<?=$fun[serie_ctps_func]?>' size=10 maxlength="10" onkeydown="return only_number(event);" class='required' onkeyup="change_classname('serie', 'required');"></td>
</tr>
</table>
<BR><p>
<center><input type=submit name=btnSaveFunc id=btnSaveFunc value='Salvar dados'></center>
</form>

