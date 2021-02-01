<center><img src='images/orcamentos.jpg' border=0></center>
<?PHP
if($_GET[act] == "list" || empty($_GET[act])){
    include(_CPATCH.'orc_list.php');
}elseif($_GET[act] == "confirm"){
    include(_CPATCH.'orc_confirm.php');
}elseif($_GET[act] == "view"){
    include(_CPATCH.'orc_view.php');
}elseif($_GET[act] == "del"){
    include(_CPATCH.'orc_del.php');
}elseif($_GET[act] == "edit"){
    include(_CPATCH.'orc_edit.php');
}
?>
