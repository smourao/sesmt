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

    if($_GET[act] == "del"){
        if($_GET[id]){
            $sql = "DELETE FROM bt_cursos WHERE id= '{$_GET[id]}'";
            if(pg_query($sql)){
                echo "<script>alert('Curso excluido!');</script>";
            }else{
                echo "<script>alert('Erro ao escluir curso!');</script>";
            }
        }
    }

    if($_POST){
        $sql = "INSERT INTO bt_cursos (livro, curso, descricao, carga_horaria, conteudo_programatico, exigencia) VALUES
        ('{$_POST[livro]}', '".addslashes($_POST[curso])."', '".addslashes($_POST[descricao])."',
        '{$_POST[carga_horaria]}',
        '".addslashes($_POST[cont_programatico])."', '".addslashes($_POST[exigencia])."')";
        if(pg_query($sql)){
            echo "<script>alert('Curso adicionado!');</script>";
        }else{
            echo "<script>alert('Erro ao inserir curso na tabela!');</script>";
        }
    }

    echo "<FORM method=post>";
    echo "<table width=100% BORDER=0 align=center>";

    echo "<tr>";
    echo "<td width=150 align=right class=fontebranca12><b>Curso:</b></td>";
    echo "<td><input type=text name=curso id=curso size=50></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td width=150 align=right class=fontebranca12><b>Nº Livro:</b></td>";
    echo "<td><input type=text name=livro id=livro size=30></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td width=150 align=right class=fontebranca12><b>Carga Horária:</b></td>";
    echo "<td class=fontebranca12><input type=text name=carga_horaria id=carga_horaria size=5> Hs</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td width=150 align=right class=fontebranca12><b>Descrição:</b></td>";
    echo "<td>";
    echo "<textarea name=descricao id=descricao cols=50 rows=6></textarea>";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td width=150 align=right class=fontebranca12><b>Exigência:</b></td>";
    echo "<td>";
    echo "<textarea name=exigencia id=exigencia cols=50 rows=6></textarea>";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td width=150 align=right class=fontebranca12><b>Conteúdo Programático:</b></td>";
    echo "<td>";
    echo "<textarea name=cont_programatico id=cont_programatico cols=50 rows=6></textarea>";
    echo "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td width=150 align=right class=fontebranca12>&nbsp;</td>";
    echo "<td class=fontebranca12 align=center><input type=submit value='Adicionar' onclick=\"return checkall();\"></td>";
    echo "</tr>";
    
    echo "</table>";
    echo "</form>";
    
    $sql = "SELECT * FROM bt_cursos ORDER BY livro ASC";
    $result = pg_query($sql);
    $buffer = pg_fetch_all($result);
    
    echo "<table width=100% BORDER=1 align=center>";
    echo "<tr>";
    echo "<td class=fontebranca12 align=center width=20><b>Livro</b></td>";
    echo "<td class=fontebranca12 align=center width=200><b>Curso</b></td>";
    echo "<td class=fontebranca12 align=center><b>Descrição</b></td>";
    echo "<td class=fontebranca12 align=center width=35><b>Excluir</b></td>";
    echo "</tr>";
    for($x=0;$x<pg_num_rows($result);$x++){
        echo "<tr>";
        echo "<td class=fontebranca12 align=center>{$buffer[$x][livro]}</td>";
        echo "<td class=fontebranca12>{$buffer[$x][curso]}</td>";
        echo "<td class=fontebranca12>{$buffer[$x][descricao]}</td>";
        echo "<td class=fontebranca12><a href='?action=new_curso&act=del&id={$buffer[$x][id]}' class=fontebranca12 onclick=\"return confirm('Tem certeza que deseja remover este curso da database?','');\"><b>Excluir</b></a></td>";
        echo "</tr>";
    }
    echo "</table>";


?>

