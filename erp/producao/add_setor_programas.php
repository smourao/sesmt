<?php header("Content-Type: text/html; charset=ISO-8859-1",true) ?>
<?PHP
include "../config/connect.php";
$cod_funcao = $_GET['cod_funcao'];
$desc = $_GET['id'];
$cod_prod = $_GET['cod_prod'];

if(empty($cod_prod)){
$sql = "SELECT MAX(cod_prod)+1 as max FROM produto";
$r = pg_query($sql);
$max = pg_fetch_array($r);

    $sql = "INSERT INTO produto (cod_prod, desc_detalhada_prod, desc_resumida_prod, cod_atividade, preco_prod)
    VALUES
    ('{$max[max]}','{$desc}','{$desc}','3','0.00')";
    $added = pg_query($sql);

    $msg = "
    <!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
   <HTML>
   <HEAD>
    <TITLE>Informativo</TITLE>
    <META http-equiv=Content-Type content=\"text/html; charset=iso-8859-1\">
    <META content=\"MSHTML 6.00.2900.3157\" name=GENERATOR>
    <style type=\"text/css\">
    td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
    .style2 {font-family: Verdana, Arial, Helvetica, sans-serif}
    .style13 {font-size: 14px}
    .style15 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10; }
    .style16 {font-size: 9px}
    .style17 {font-family: Arial, Helvetica, sans-serif}
    .style18 {font-size: 12px}
    </style>
    </HEAD>
   <BODY>
    <center><b>Produto adicionado ao cadastro de produto</b></center><p>
    <b>Cód. Produto:</b> $max[max]<br>
    <b>Descrição:</b> $desc<p>
    ";
    $headers = "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
    $headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <webmaster@sesmt-rio.com> \n";
    mail('pedrohenrique@gmail.com', 'Produto adicionado ao cadastro de produtos!', $msg, $headers);
    $cod_prod = $max[max];
}

$sql = "SELECT * FROM setor_programas WHERE cod_setor = {$cod_funcao} AND descricao = '{$desc}'";
$result = pg_query($connect, $sql);
if(pg_num_rows($result) < 1){
     $sql="INSERT INTO setor_programas (cod_setor, descricao, cod_produto)values({$cod_funcao}, '{$desc}', '{$cod_prod}')";
     $result = pg_query($connect, $sql);
}

$sql = "SELECT * FROM setor_programas WHERE cod_setor = {$cod_funcao}";
$result = pg_query($connect, $sql);
$r = pg_fetch_all($result);

for($x=0;$x<pg_num_rows($result);$x++){
     $text .= "<tr><td bgcolor=\"#009966\">".($x+1)."</td><td bgcolor=\"#009966\">".$r[$x]['descricao']."</td>
     <td align=center bgcolor=\"#009966\">
     <a href=\"javascript:remove_setor_programas({$r[$x]['id']});\" class=excluir>X</a>
     </td></tr>|";
}
echo $text;
?>
