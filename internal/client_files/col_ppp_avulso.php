<div class='novidades_text'>
<p align=justify>
<?PHP
/*************************************************************************************************************/
// --> POST FUNC DATA - SAVE/ADD
/*************************************************************************************************************/
if($_POST && $_POST[btnSaveFunc]){
    $_GET[fid] = (int)(anti_injection($_GET[fid]));
    // -- EDIT FUNC DATA -------------------------------------------------------------------------------------
    if($_GET[fid]){
        $sql = "UPDATE funcionarios SET
        nome_func = '".anti_injection($_POST[nome])."',
        cod_funcao = '".anti_injection($_POST[funcao])."',
        dinamica_funcao = '".anti_injection($_POST[dinamica_funcao])."',
        cbo = '".anti_injection($_POST[cbo])."',
        num_ctps_func = '".anti_injection($_POST[ctps])."',
        serie_ctps_func = '".anti_injection($_POST[serie])."'";
    }else{
    // -- ADD FUNC DATA --------------------------------------------------------------------------------------
        $sql = "SELECT * FROM funcionarios WHERE cod_cliente = ".(int)($_SESSION[cod_cliente])." AND num_ctps_func = '".anti_injection($_POST[ctps])."' AND serie_ctps_func = '".anti_injection($_POST[serie])."'";
        if(pg_num_rows(pg_query($sql)) <= 0){
            $sql = "SELECT MAX(cod_func) as cod_func FROM funcionarios WHERE cod_cliente = ".(int)($_SESSION[cod_cliente]);
            $max = pg_fetch_array(pg_query($sql));
            $max = $max[cod_func] + 1;
            $sql = "INSERT INTO funcionarios
            (cod_func, nome_func, num_ctps_func, serie_ctps_func, cbo, cod_funcao, cod_setor
            dinamica_funcao, cod_cliente,
            cod_status)
            VALUES
            ('$max',
			'".anti_injection($_POST[nome])."',
            '".anti_injection($_POST[ctps])."',
            '".anti_injection($_POST[serie])."',
			'".anti_injection($_POST[cbo])."',
            '".anti_injection($_POST[funcao])."',
            '0',
            '".anti_injection($_POST[dinamica_funcao])."',
            '".anti_injection($_SESSION[cod_cliente])."', 1)";
			
			
			
			
			
			
            if(pg_query($sql)){
			
				$ctpss = $_POST[ctps];
			
                echo "<br />Dados do colaborador cadastrados com sucesso!, <a href=\"?do=aso_avulso&a=2&tp=1&cod=$max&set={$_POST[setor]}\">Clique aqui para agendar o ASO admissional!</a>";
           		   
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
    <td width=180>Nome:</td>
    <td><input type=text class='required' name='nome' id='nome' value='<?=$fun[nome_func]?>' size='50' onkeyup="change_classname('nome', 'required');"></td>
</tr>


<tr>
    <td width=180>Data de Nascimento:</td>
    <td><input type=text class='required' name='data_nascimento' id='data_nascimento' value='<?=$fun[data_nascimento]?>' size='10' required></td>
</tr>


<tr>
    <td width=180>Data de Nascimento:</td>
    <td><input type=text class='required' name='data_nascimento' id='data_nascimento' value='<?=$fun[data_nascimento]?>' size='10' required></td>
</tr>

<tr>
    <td width=180>PIS:</td>
    <td><input type=text class='required' name='nit' id='nit' value='<?=$fun[nit]?>' size='10' required></td>
</tr>


<tr>
    <td width=180>Sexo:</td>
    <td><input type=text class='required' name='sexo' id='sexo' value='<?=$fun[sexo]?>' size='10' maxlength="1" required></td>
</tr>

<tr>
    <td width=180>CTPS:</td>
    <td><input type=text class='required' name='ctps' id='ctps' value='<?=$fun[ctps]?>' size='10' required></td>
</tr>


<tr>
    <td width=180>Sére:</td>
    <td><input type=text class='required' name='ctps_serie' id='ctps_serie' value='<?=$fun[ctps_serie]?>' size='10' required></td>
</tr>

<tr>
    <td width=180>UF:</td>
    <td><input type=text class='required' name='ctps_uf' id='ctps_uf' value='<?=$fun[ctps_uf]?>' size='10'  maxlength="2" required></td>
</tr>

<tr>
    <td width=180>Data da Admissão:</td>
    <td><input type=text class='required' name='data_admissao' id='data_admissao' value='<?=$fun[data_admissao]?>' size='10' required></td>
</tr>


<tr>
    <td width=180>Data do Desligamento:</td>
    <td><input type=text class='required' name='data_desligamento' id='data_desligamento' value='<?=$fun[data_desligamento]?>' size='10' required></td>
</tr>


</table>

<p><BR>

<img src='images/sub-dados-profissionais.jpg' border=0>
<table width=100% cellspacing=2 cellpadding=2 border=0>

<tr>
<td width=180>Função:</td>
<td>
<?PHP
	
	$fu_cl = "SELECT * FROM funcao ORDER BY nome_funcao";
	$fu_cli = pg_query($fu_cl);
	$fun_cli = pg_fetch_all($fu_cli);
	
    $sql = "SELECT cod_funcao, nome_funcao, dsc_funcao FROM funcao ORDER BY nome_funcao";
    $rlf = pg_query($sql);
    $funcoes = pg_fetch_all($rlf);
    
	echo "<select class='required' name='funcao' id='funcao' style=\"width: 308px;\" onchange=\"get_dinamica_funcao(this.value);\" onkeyup=\"change_classname('funcao', 'required');\">";
        echo "<option value=''></option>";
    for($y=0;$y < pg_num_rows($fu_cli);$y++){
		if($fun_cli[$y][cod_funcao] != $fun_cli[$y-1][cod_funcao]){
			echo "<option value='{$fun_cli[$y][cod_funcao]}'";
			if($fun[cod_funcao] == $fun_cli[$y][cod_funcao]){
			echo " selected ";
			$dinamica = $fun_cli[$y][dsc_funcao];
			}else{
			 "";
			 }
			 echo ">".substr($fun_cli[$y][nome_funcao], 0, 71)."</option>";
			 echo ">{$funcoes[$y][nome_funcao]}</option>";
		}
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
<td width=180>CBO:</td>
<td><input onpaste="return false;" type=text id='cbo' name='cbo' value='<?=$fun[cbo]?>' size=10 maxlength="9" onkeydown="return only_number(event);" class='required' onkeyup="change_classname('cbo', 'required');"></td>
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

