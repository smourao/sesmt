<center><img src='images/t_register.jpg' border=0></center>
<p align=justify>
<?PHP
if($_GET[tos])
    @include(_IPATCH.'register_par_form.php');
else
    @include(_IPATCH.'term_of_service_par.php');
?>
