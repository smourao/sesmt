<?PHP
$sql = "SELECT c.razao_social, ti.*, cur.* FROM site_treinamento_info ti, cliente c, bt_cursos cur WHERE ti.cod_cliente = c.cliente_id AND ti.cod_curso = cur.id AND ti.cod_certificado = ".(int)($_GET[cod_certificado]);
$res = pg_query($sql);
$buffer = pg_fetch_array($res);

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    echo "<b>Participantes do Treinamento</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    //FORM - SAVE DATA
    echo "<form method=post id='frmdetailtreinamento' name='frmdetailtreinamento'>";

    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=left class=text width='140'>Cód. Certificado:</td>";
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=cod_certificado id=cod_certificado value='".str_pad($buffer[cod_certificado], 3, "0",0)."' readonly></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='140'>Cliente:</td>";
    echo "<td align=left class=text width='500'><b>$buffer[razao_social]</b></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='140'>$buffer[tipo_treinamento]:</td>";
    echo "<td align=left class=text width='500'>$buffer[curso]</td>";
    echo "</tr>";

    echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Participantes:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=left class=text width='45'>Sel.</td>";
echo "<td align=left class=text>Participante:</td>";
echo "<td align=left class=text width='150'>Função:</td>";
echo "</tr>";
$sql = "SELECT f.*, fu.* FROM funcionarios f, funcao fu WHERE fu.cod_funcao = f.cod_funcao AND f.cod_cliente = ".(int)($buffer[cod_cliente]);
$rfl = pg_query($sql);
$funcs = pg_fetch_all($rfl);
for($x=0;$x<pg_num_rows($rfl);$x++){
    $sql = "SELECT * FROM bt_treinamento WHERE cert_empresa = $_GET[cod_certificado] AND cod_funcionario = {$funcs[$x][cod_func]}";
    $r = pg_query($sql);
    echo "<tr class='roundbordermix'>";
    echo "<td align=left "; print pg_num_rows($r) ? " class='text roundborderselected' ":" class='text' "; echo " width='25'><input type=checkbox name='' id='' value='' "; print pg_num_rows($r) ? " checked ":""; echo " ></td>";
    echo "<td align=left "; print pg_num_rows($r) ? " class='text roundborderselected' ":" class='text' "; echo " >{$funcs[$x][nome_func]}</td>";
    echo "<td align=left "; print pg_num_rows($r) ? " class='text roundborderselected' ":" class='text' "; echo "  width='250'>{$funcs[$x][nome_funcao]}</td>";
    echo "</tr>";
}
echo "</table>";

echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td align=left class='text'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
            echo "<td align=center class='text roundbordermix'>";
            echo "<input type='button' class='btn' name='btnBackProd' value='Voltar' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=lista&page=$_GET[page]';\" onmouseover=\"showtip('tipbox', '- Voltar, retorna à lista de produtos.');\" onmouseout=\"hidetip('tipbox');\" >";
            echo "&nbsp;";
            echo "<input type='submit' class='btn' name='btnSaveProd' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";
            echo "&nbsp;";
            echo "<input type='button' class='btn' name='btnDelProd' value='Excluir' onclick=\"if(confirm('Tem certeza que deseja excluir este produto?','')) location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=lista&page=$_GET[page]&cod_prod=$_GET[cod_prod]&del=1';\" onmouseover=\"showtip('tipbox', '- Excluir, remove este produto do cadastro.');\" onmouseout=\"hidetip('tipbox');\" >";
            echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</tr>";
echo "</table>";
?>
