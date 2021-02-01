<center><img src='images/colaboradores.jpg' border=0></center>

<div class='novidades_text'>
<p align=justify>

</div>
<?PHP
echo "<center>";

echo "<a href='?do=colaboradores&act=list'>";
print $_GET[act] == 'list' ? "<img src='images/sub-relacao-colaboradores-sel.jpg' border=0>" : "<img src='images/sub-relacao-colaboradores.jpg' border=0>";
echo "</a>";



echo "</center>";
echo "<BR>";

if($_GET[act] == 'list'){
    include(_CPATCH.'list_colaboradores.php');
}elseif($_GET[act] == 'new'){
    if($tpermiss[acesso_colaboradores] == 1)
        include(_CPATCH.'new_colaborador.php');
}
?>
