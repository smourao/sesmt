<script language="javascript">
function find_cliente(){
    var url = "find_cliente.php?texto="+document.getElementById('empresa').value;
    url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
    http.open("GET", url, true);
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
    http.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
    http.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
    http.setRequestHeader("Pragma", "no-cache");
    http.onreadystatechange = find_cliente_result;
    http.send(null);
}

function find_cliente_result(){
if(http.readyState == 4)
{
    var msg = http.responseText;
    document.getElementById('sgt').innerHTML = msg;
}else{
    if (http.readyState==1){
       document.getElementById('sgt').style.display = 'block';
    }
 }
}
</script>

<script>
function checkall(){
    if(document.getElementById("empresa").value == ""){
        alert('O campo Empresa deve ser preenchido!');
        document.getElementById("empresa").focus();
        return false;
    }
    if(document.getElementById("participante").value == ""){
        alert('O campo Participante não deve ficar em branco!');
        document.getElementById("participante").focus();
        return false;
    }
    
    if(document.getElementById("ctps").value == ""){
        alert('O campo CTPS não deve ficar em branco!');
        document.getElementById("ctps").focus();
        return false;
    }
    
    if(document.getElementById("serie").value == ""){
        alert('O campo Série não deve ficar em branco!');
        document.getElementById("serie").focus();
        return false;
    }
    
    if(document.getElementById("livro").value == ""){
        alert('O campo Livro não deve ficar em branco!');
        document.getElementById("livro").focus();
        return false;
    }
    
    if(document.getElementById("folha").value == ""){
        alert('O campo Folha não deve ficar em branco!');
        document.getElementById("folha").focus();
        return false;
    }
    
    if(document.getElementById("certificado").value == ""){
        alert('O campo Reg. Certificado não deve ficar em branco!');
        document.getElementById("certificado").focus();
        return false;
    }
    
    if(document.getElementById("curso").options[document.getElementById('curso').selectedIndex].value == ""){
        alert('O campo Curso não deve ficar em branco!');
        return false;
    }
    
    var formatado = document.getElementById("data").value;
    if (formatado.length == 10){
        if(!formatado.match(/^((0[1-9]|[12]\d)\/(0[1-9]|1[0-2])|30\/(0[13-9]|1[0-2])|31\/(0[13578]|1[02]))\/\d{4}$/)){
            alert('Data Inválida! - ' + formatado);
            document.getElementById("data").focus();
            return false;
        }
    }else{
        if(formatado.length > 0){
            alert('A previsão para término deve estar no formato: dd/mm/yyyy');
            return false;
        }
    }
    return true;
}

function fdata(objeto){
    if (objeto.value.length == 2 || objeto.value.length == 5 ){
        objeto.value = objeto.value+"/";
    }
}

function cs1(){
    if(document.getElementById("cod_cliente").value == ""){
        document.getElementById("cod_cliente").focus();
        return false;
    }
    
    if(document.getElementById("cod_filial").value == ""){
        document.getElementById("cod_filial").focus();
        return false;
    }
    
    if(document.getElementById("data_inicio").value == ""){
        document.getElementById("data_inicio").focus();
        return false;
    }
    if(document.getElementById("data_termino").value == ""){
        document.getElementById("data_termino").focus();
        return false;
    }
    if(document.getElementById("livro").value == ""){
        document.getElementById("livro").focus();
        return false;
    }
    
    if(document.getElementById("folha").value == ""){
        document.getElementById("folha").focus();
        return false;
    }
    if(document.getElementById("certificado").value == ""){
        document.getElementById("certificado").focus();
        return false;
    }
    
    if(document.getElementById("registromtb").value == ""){
        document.getElementById("registromtb").focus();
        return false;
    }
    
    if(document.getElementById("instrutor").value == ""){
        document.getElementById("instrutor").focus();
        return false;
    }
    
    if(document.getElementById("prof_instrutor").value == ""){
        document.getElementById("prof_instrutor").focus();
        return false;
    }
    
    return true;
}


</script>
<?PHP

    if(!$_POST[treinamento] && !$_GET[s]){
        echo "<center><b>Selecione o tipo de treinamento</b></center>";
        echo "<P>";
        echo "<FORM method=post>";
        echo "<table width=100% BORDER=0 align=center>";
        echo "<tr>";
        echo "<td width=150 align=right class=fontebranca12><b>Treinamento:</b></td>";
        echo "<td>";
        echo "&nbsp;&nbsp;&nbsp;";
        echo "<select name=treinamento id=treinamento>";
        echo "<option value='Curso'>Curso</option>";
        echo "<option value='Palestra'>Palestra</option>";
        echo "</select>";
        echo "&nbsp;&nbsp;&nbsp;";
        echo "<input type=submit value='Continuar'>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        echo "</form>";
    }

    if($_POST[treinamento] && !$_GET[s]){
        echo "<center><b>Dados do treinamento</b></center>";
        echo "<P>";
        
        echo "<FORM method=post action='?action=new&s=2'>";
        echo "<table width=100% BORDER=0 align=center>";
        
        echo "<tr>";
        echo "<td width=150 align=right class=fontebranca12><b>Treinamento:</b></td>";
        echo "<td>";
        echo "<input type=text readonly name=treinamento id=treinamento value='$_POST[treinamento]'>";
        echo "</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td width=150 align=right class=fontebranca12><b>Empresa:</b></td>";
        echo "<td>";
        echo "<input type=text name=empresa id=empresa value='$_POST[empresa]' size=35 onkeyup=\"find_cliente();\">";
        echo '<div id=sgt name=sgt style="display: none;position: absolute; border: 0px solid; width: 300px;background-color: #009966;">
               <center><font size=1 color=white><i>Atualizando...</i></font></center>
        </div>';
        echo "</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td width=150 align=right class=fontebranca12><b>Cód. Cliente:</b></td>";
        echo "<td>";
        echo "<input type=text size=5 readonly name=cod_cliente id=cod_cliente value='$_POST[cod_cliente]'>";
        echo "</td>";
        echo "</tr>";

        /*
        echo "<tr>";
        echo "<td width=150 align=right class=fontebranca12><b>Cód. Filial:</b></td>";
        echo "<td>";
        echo "<input type=text size=5 readonly name=cod_filial id=cod_filial value='$_POST[cod_filial]'>";
        echo "</td>";
        echo "</tr>";
        */
        echo "<input type=hidden name=cod_filial id=cod_filial value='$_POST[cod_filial]'>";
        //DATA INICIO
        echo "<tr>";
        echo "<td width=150 align=right class=fontebranca12><b>Data Inicio:</b></td>";
        echo "<td>";
        echo "<input type=text size=10 maxlength=10 name=data_inicio id=data_inicio onkeypress=\"formataDataDigitada(this);\">";
        echo "</td>";
        echo "</tr>";
        
        //DATA TERMINO
        echo "<tr>";
        echo "<td width=150 align=right class=fontebranca12><b>Data Término:</b></td>";
        echo "<td>";
        echo "<input type=text size=10 maxlength=10 name=data_termino id=data_termino onkeypress=\"formataDataDigitada(this);\">";
        echo "</td>";
        echo "</tr>";
        
        //LISTA DE CURSOS
        echo "<tr>";
        echo "<td width=150 align=right class=fontebranca12><b>Curso:</b></td>";
        echo "<td>";
        $sql = "SELECT * FROM bt_cursos ORDER BY curso";
        $r = pg_query($sql);
        $curso = pg_fetch_all($r);
        echo "<select name=curso id=curso onchange=\"get_book_info(this.value);\">";
        echo "<option></option>";
        for($x=0;$x<pg_num_rows($r);$x++){
            echo "<option value='{$curso[$x][id]}'>{$curso[$x][carga_horaria]}-{$curso[$x][curso]}</option>";
        }
        echo "</select>";
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td width=150 align=right class=fontebranca12><b>Livro:</b></td>";
        echo "<td class=fontebranca12><input type=text readonly name=livro id=livro size=10 value=''></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td width=150 align=right class=fontebranca12><b>Folha:</b></td>";
        echo "<td class=fontebranca12><input type=text readonly name=folha id=folha size=10 value=''></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td width=150 align=right class=fontebranca12><b>Reg. Certificado:</b></td>";
        echo "<td class=fontebranca12><input type=text readonly name=certificado id=certificado size=10 value='{$max[maxc]}'></td>";
        echo "</tr>";
        
        /*
        echo "<tr>";
        echo "<td width=150 align=right class=fontebranca12><b>Instrutor:</b></td>";
        echo "<td>";
        echo "<input type=text size=35 name=instrutor id=instrutor>";
        echo "</td>";
        echo "</tr>";
        */
        //LISTA DE INSTRUTORES
        echo "<tr>";
        echo "<td width=150 align=right class=fontebranca12><b>Instrutor:</b></td>";
        echo "<td>";
        $sql = "SELECT * FROM funcionario WHERE registro is not null ORDER BY nome";
        $r = pg_query($sql);
        $inst = pg_fetch_all($r);
        echo "<select name=instrutor id=instrutor onchange=\"get_instrutor_info(this.value);\">";
        echo "<option></option>";
        for($x=0;$x<pg_num_rows($r);$x++){
            echo "<option value='{$inst[$x][nome]}'>{$inst[$x][nome]}</option>";
        }
        echo "</select>";
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td width=150 align=right class=fontebranca12><b>Profissão Instrutor:</b></td>";
        echo "<td>";
        echo "<input type=text size=35 name=prof_instrutor id=prof_instrutor>";
        echo "</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td width=150 align=right class=fontebranca12><b>Registro MTB:</b></td>";
        echo "<td>";
        echo "<input type=text size=35 name=registromtb id=registromtb>";
        echo "</td>";
        echo "</tr>";
        
        echo "</table>";
        echo "<center><input type=submit value='Continuar' name=continue onclick='return cs1();'></center>";
        echo "</form>";
    }
    
    //SECOND STEP
    if($_GET[s] == 2){
        //print_r($_POST);
        echo "<center><b>Selecione os funcionários participantes</b></center>";
        echo "<P>";
        
        $sql = "SELECT f.*, func.nome_funcao FROM funcionarios f, funcao func
        WHERE
        f.cod_cliente = {$_POST[cod_cliente]}
        AND
        f.cod_funcao = func.cod_funcao
        ORDER BY cod_func";
        
        $result = pg_query($sql);
        $func = pg_fetch_all($result);

        echo "<form method=post action='?action=new&s=3'>";
        
        echo "<input type=hidden name='treinamento' value='$_POST[treinamento]'>";
        echo "<input type=hidden name='empresa' value='$_POST[empresa]'>";
        echo "<input type=hidden name='cod_cliente' value='$_POST[cod_cliente]'>";
        echo "<input type=hidden name='cod_filial' value='$_POST[cod_filial]'>";
        echo "<input type=hidden name='data_inicio' value='$_POST[data_inicio]'>";
        echo "<input type=hidden name='data_termino' value='$_POST[data_termino]'>";
        echo "<input type=hidden name='curso' value='$_POST[curso]'>";
        echo "<input type=hidden name='livro' value='$_POST[livro]'>";
        echo "<input type=hidden name='folha' value='$_POST[folha]'>";
        echo "<input type=hidden name='certificado' value='$_POST[certificado]'>";
        echo "<input type=hidden name='instrutor' value='$_POST[instrutor]'>";
        echo "<input type=hidden name='prof_instrutor' value='$_POST[prof_instrutor]'>";
        echo "<input type=hidden name='registromtb' value='$_POST[registromtb]'>";

        echo "<table width=100% border=1 celspacing=2 celpadding=2>";
        echo "<tr>";
        echo "<td width=15 align=center class=fontebranca12><b>Cód.</b></td>";
        echo "<td align=center class=fontebranca12><b>Nome</b></td>";
        echo "<td align=center class=fontebranca12><b>Cargo</b></td>";
        echo "<td align=center class=fontebranca12><b>Selecionar</b></td>";
        echo "</tr>";
        foreach($func as $f){
            echo "<tr>";
            echo "<td class=fontebranca12 align=center><b>$f[cod_func]</b></td>";//$f[nome_func];
            echo "<td class=fontebranca12><b>$f[nome_func]</b></td>";
            echo "<td class=fontebranca12>$f[nome_funcao]</td>";
            echo "<td class=fontebranca12 align=center><input type=checkbox name='funcs[]' value='$f[cod_func]'></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<center><input type=submit value='Finalizar'></center>";
        echo "</form>";
    }
    
    
    if($_GET[s] == 3 && $_POST){
        echo "<center><b>Treinamentos Adicionados</b></center>";
        echo "<P>";
        //print_r($_POST);
        //echo "<P>";
        $tmp = explode("/", $_POST[data_inicio]);
        $datai = $tmp[2]."/".$tmp[1]."/".$tmp[0];
        $tmp = explode("/", $_POST[data_termino]);
        $datat = $tmp[2]."/".$tmp[1]."/".$tmp[0];

        $sql = "SELECT max(numero_certificado) as n FROM bt_treinamento";
                $result = pg_query($sql);
                $num = pg_fetch_array($result);
                $num = $num[n]+1;
                $cert_empresa = $num;

        foreach($_POST[funcs] as $cf){
            $sql = "SELECT * FROM bt_treinamento
            WHERE cod_cliente = $_POST[cod_cliente] AND
            cod_funcionario = $cf AND cod_curso = $_POST[curso] AND data_inicio = $datai AND data_termino = $datat";
            $result = pg_query($sql);
            //if is not in the database, insert...
            if(pg_num_rows($result)<=0){
                $num++;
                
                $sql = "SELECT count(*) as n FROM bt_treinamento WHERE livro = '{$_POST[livro]}'";
                $resu = pg_query($sql);
                $nr = pg_fetch_array($resu);
                
                $nfolha = ceil(($nr[n]/100));
                
                $sql = "INSERT INTO bt_treinamento (cod_curso, cod_cliente, cod_filial,
                cod_funcionario, data_inicio, data_termino, livro, folha, numero_certificado,
                empresa, tipo_treinamento, nome_instrutor, profissao_instrutor, data_criacao,
                reg_instrutor, cert_empresa) VALUES
                ('{$_POST[curso]}', '{$_POST[cod_cliente]}', '{$_POST[cod_filial]}',
                '{$cf}', '{$datai}', '{$datat}', '{$_POST[livro]}', '{$nfolha}',
                '{$num}', '{$_POST[empresa]}', '{$_POST[treinamento]}', '{$_POST[instrutor]}',
                '{$_POST[prof_instrutor]}', '".date("Y/m/d")."', '$_POST[registromtb]', $cert_empresa)";
                if(pg_query($sql)){
                    echo "<script>location.href='?action=list';</script>";
                }else{
                    echo "Houve um erro ao inserir os itens selecionados na database!";
                }
            }
        }
    }
?>
