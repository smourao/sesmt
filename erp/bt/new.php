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

</script>
<?PHP

    if($_POST){
        $tmp = explode("/", $_POST[data]);
        $ndata = $tmp[2]."-".$tmp[1]."-".$tmp[0];
        $sql = "INSERT INTO bt_info (livro, folha, reg_certificado, participante, ctps, serie, data,
        empresa, curso) VALUES
        ('{$_POST[livro]}', '{$_POST[folha]}', '{$_POST[certificado]}', '{$_POST[participante]}',
        '{$_POST[ctps]}', '{$_POST[serie]}', '".date("Y-m-d", strtotime($ndata))."',
        '{$_POST[empresa]}', '{$_POST[curso]}')";
        
        //echo $sql;
        
        if(pg_query($sql)){
            echo "<script>alert('Registro adicionado!');</script>";
        }else{
            echo "<script>alert('Erro ao inserir registro na tabela!');</script>";
        }
    }

    echo "<FORM method=post>";
    echo "<table width=100% BORDER=0 align=center>";

    echo "<tr>";
    echo "<td width=150 align=right class=fontebranca12><b>Empresa:</b></td>";
    echo "<td><input type=text name=empresa id=empresa size=30></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td width=150 align=right class=fontebranca12><b>Participante:</b></td>";
    echo "<td><input type=text name=participante id=participante size=30></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td width=150 align=right class=fontebranca12><b>Curso:</b></td>";
    echo "<td>";
    $sql = "SELECT * FROM bt_cursos ORDER BY curso";
    $r = pg_query($sql);
    $curso = pg_fetch_all($r);
    echo "<select name=curso id=curso onchange=\"get_book_info(this.value);\">";
    echo "<option></option>";
    for($x=0;$x<pg_num_rows($r);$x++){
        echo "<option value='{$curso[$x][id]}'>{$curso[$x][curso]}</option>";
    }
    echo "</select>";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td width=150 align=right class=fontebranca12><b>CTPS:</b></td>";
    echo "<td class=fontebranca12><input type=text name=ctps id=ctps size=15> <b>Série:</b> <input type=text name=serie id=serie size=5></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td width=150 align=right class=fontebranca12><b>Data:</b></td>";
    echo "<td class=fontebranca12><input type=text name=data maxlength=10 onkeyup=\"fdata(this);\" id=data size=10 value='".date("d/m/Y")."'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td width=150 align=right class=fontebranca12><b>Livro:</b></td>";
    echo "<td class=fontebranca12><input type=text name=livro id=livro size=10 value=''></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td width=150 align=right class=fontebranca12><b>Folha:</b></td>";
    echo "<td class=fontebranca12><input type=text name=folha id=folha size=10 value=''></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td width=150 align=right class=fontebranca12><b>Reg. Certificado:</b></td>";
    echo "<td class=fontebranca12><input type=text name=certificado id=certificado size=10 value='{$max[maxc]}'></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td width=150 align=right class=fontebranca12>&nbsp;</td>";
    echo "<td class=fontebranca12><input type=submit value='Enviar' onclick=\"return checkall();\"></td>";
    echo "</tr>";
    
    echo "</table>";
    echo "</form>";

?>

