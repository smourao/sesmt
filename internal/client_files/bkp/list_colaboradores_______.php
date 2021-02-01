<div class='novidades_text'>
<p align=justify>
A lista abaixo exibe os funcionários cadastrados em nosso sistema, é importante que esta lista esteja sempre
atualizada.
<?PHP
if($_GET[del] && $_GET[fid]&& is_numeric($_GET[fid])){
    echo "<p align=justify>";
    $sql = "DELETE FROM funcionarios WHERE cod_cliente = ".(int)($_SESSION[cod_cliente])." AND cod_func = ".(int)(anti_injection($_GET[fid]));
    if(pg_query($sql)){
        echo "Colaborador excluído com sucesso!";
    }else{
        echo "Houve um erro ao tentar excluir este colaborador. Por favor, tente novamente em alguns instantes, se o problema persistir, entre em contato com a nossa <a href='?do=contato'>central de atendimento</a>.";
    }
}
?>
</div>
<?PHP
$sql = "SELECT * FROM funcionarios WHERE cod_cliente = $_SESSION[cod_cliente] AND cod_status = 1 ORDER BY nome_func ASC";
$res = pg_query($sql);
$col = pg_fetch_all($res);

echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
echo "<tr>";
    echo "<td class='bgTitle' align=center width=20>Sel</td>";
    echo "<td class='bgTitle' align=center>Nome</td>";
    echo "<td class='bgTitle' align=center width=120>Opções</td>";
echo "</tr>";
for($x=0;$x<pg_num_rows($res);$x++){
    if($x%2)
            $bgclass = 'bgContent1';
        else
            $bgclass = 'bgContent2';
            
    echo "<tr>";
        echo "<td class='$bgclass' align=center><input class='' type=checkbox id='' name='' value=''></td>";
        echo "<td class='$bgclass'>{$col[$x][nome_func]}</td>";
        echo "<td class='$bgclass' align=center>";
        if($tpermiss[acesso_colaboradores] == 1)
            echo "<a href='?do=colaboradores&act=new&fid={$col[$x][cod_func]}'><img src='images/ico-edit.png' border=0 alt='Editar colaborador' title='Editar colaborador'></a>&nbsp;<a href='?do=colaboradores&act=list&fid={$col[$x][cod_func]}&del=1' onclick=\"if(!confirm('Tem certeza que deseja excluir o cadastro deste colaborador?','')){ return false;}\"><img src='images/ico-del.png' border=0 alt='Excluir colaborador' title='Excluir colaborador'></a>";
        else
            echo "&nbsp;";
        echo "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<BR>";
echo "<b>Legenda:</b>";
echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
echo "<tr>";
echo "<td width=25><img src='images/ico-edit.png' border=0 alt='Editar colaborador' title='Editar colaborador'></td><td><font size=1>Editar colaborador.</font></td>";
echo "</tr><tr>";
echo "<td width=25><img src='images/ico-del.png' border=0 alt='Excluir colaborador' title='Excluir colaborador'></td><td><font size=1>Excluir colaborador.</font></td>";
echo "</tr>";
echo "</table>";
?>
