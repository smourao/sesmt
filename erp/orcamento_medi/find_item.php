<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: SESMT - Segurança do Trabalho e Medicina Ocupacional::</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="orc.js"></script>
<script language="javascript" src="scripts.js"></script>
<style type="text/css" title="mystyles" media="all">
<!--
loading{
display: block;
position: relative;
left: 0px;
top: 60px;
width:0px;
height:0px;
color: #888000;
z-index:1;
}

loading_done{
position: relative;
display: none;
}

-->
</style>
<script>
function do_sel(){
for (i=0;i<document.f1.elements.length;i++){
      if(document.f1.elements[i].type == "checkbox"){
         if(document.f1.elements[i].checked==1){
              deselecionar_tudo();
              i = document.f1.elements.length;
         }else{
              selecionar_tudo();
              i = document.f1.elements.length;
         }
      }
}
}

function selecionar_tudo(){
   for (i=0;i<document.f1.elements.length;i++)
      if(document.f1.elements[i].type == "checkbox")
         document.f1.elements[i].checked=1
}

function deselecionar_tudo(){
   for (i=0;i<document.f1.elements.length;i++)
      if(document.f1.elements[i].type == "checkbox")
         document.f1.elements[i].checked=0
}
</script>
</head>
<body background="#006633" bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">

<?PHP
if($_GET['seg_id']!="4"){
?>
<!--
<center>Clínicas</center>
<br>
<form method="POST">
<center>
<input type=text name=search id=search class=text size=12 value=<?PHP echo $_POST['search'];?>>
<input type=submit value="Procurar" class=button>
</center>
</form>
-->
<?PHP
}


include "../config/connect.php";

$sql = "SELECT * FROM site_orc_medi_info WHERE cod_orcamento = $_GET[cod_orcamento]";
$result = pg_query($sql);
$orcinfo = pg_fetch_array($result);
if($orcinfo[cod_clinica]){
    $sql = "SELECT * FROM clinicas WHERE cod_clinica = $orcinfo[cod_clinica]";
    $result = pg_query($sql);
    $cinfo = pg_fetch_array($result);
    
    echo "<center>$cinfo[razao_social_clinica]</center>";
}


if(!$_GET[cod_clinica]){
    if($orcinfo[cod_clinica]){
        echo "<script>location.href='?cod_cliente=$_GET[cod_cliente]&cod_filial=$_GET[cod_filial]&cod_orcamento=$_GET[cod_orcamento]&cod_clinica={$orcinfo[cod_clinica]}';</script>";
    }
    $sql = "SELECT * FROM clinicas WHERE ativo=1 ORDER BY razao_social_clinica";
    $result = pg_query( $sql);
    $clinicas = pg_fetch_all($result);
    echo "<center><font size=2><b>Clínicas</b></font></center>";
    echo "<br>";
    echo "<center><font size=1>".pg_num_rows($result)." clínicas cadastradas</font></center>";
    echo "<br>";
    echo "<table border=1 cellspacing=0 cellpadding=0 width=100%>";
    echo "<tr>";
    echo "<td align=center><b><font size=1>Selecionar</font></b></td>";
    echo "<td align=center><b><font size=1>Clinica</font></b></td>";
    echo "</tr>";
        for($x=0;$x<pg_num_rows($result);$x++){
            echo "<tr>";
               //echo "<td align=center style=\"cursor:pointer;\" onclick=\"add_orcamento_produto(prompt('Quantidade / Número de participantes:', '1'), {$buffer[$x]['cod_prod']});\"><font size=2><b>Adicionar</b></font></td>";
               echo "<td align=center style=\"cursor:pointer;\" onclick=\"location.href='?cod_cliente=$_GET[cod_cliente]&cod_filial=$_GET[cod_filial]&cod_orcamento=$_GET[cod_orcamento]&cod_clinica={$clinicas[$x]['cod_clinica']}';\"><font size=2><b>Selecionar</b></font></td>";
               echo "<td align=left><font size=2>{$clinicas[$x]['razao_social_clinica']}</font></td>";
            echo "</tr>";
        }
    echo "</table>";
}

//DEPOIS DE SELECIONAR A CLÍNICA, EXIBIÇÃO DE FUNCIONÁRIOS
if($_GET[cod_clinica] && !$_POST){

    if(!$orcinfo[cod_clinica]){
        $sql = "UPDATE site_orc_medi_info SET cod_clinica = $_GET[cod_clinica] WHERE cod_orcamento = $_GET[cod_orcamento]";
        pg_query($sql);
    }

    echo "<form name=f1 method=post>";
    echo "<center><font size=2><b>Funcionários</b></font></center>";
    echo "<br>";
    $sql = "SELECT * FROM funcionarios WHERE cod_cliente = $_GET[cod_cliente]";
    $result = pg_query( $sql);
    $buffer = pg_fetch_all($result);
    echo "<center><font size=1>".pg_num_rows($result)." funcionários cadastrados</font></center>";
    echo "<br>";
    echo "<table border=1 cellspacing=0 cellpadding=0 width=100%>";
    echo "<tr>";
    echo "<td align=center style=\"cursor:pointer;\" title='Marcar/Desmarcar todos' alt='Marcar/Desmarcar todos' onclick=\"javascript:do_sel();\"><b><font size=1>Sel.</font></b></td>
      <td align=center><b><font size=1>Funcionário</font></b></td>";
    echo "</tr>";
    $sql = "SELECT * FROM site_orc_medi_produto
            WHERE cod_orcamento = $_GET[cod_orcamento]";
    $r = pg_query($sql);
    $d = pg_fetch_all($r);
    for($x=0;$x<pg_num_rows($r);$x++){
        $ar .= $d[$x][funcionarios];
    }
    $flist = explode("|", $ar);
    
        for($x=0;$x<pg_num_rows($result);$x++){
            echo "<tr>";
               //echo "<td align=center style=\"cursor:pointer;\" onclick=\"add_orcamento_produto(prompt('Quantidade:', '1'), {$buffer[$x]['cod_prod']});\"><font size=2><b>Adicionar</b></font></td>";
               echo "<td align=center style=\"cursor:pointer;\"><input type=checkbox name=f{$buffer[$x]['cod_func']} id=f{$buffer[$x]['cod_func']} value='{$buffer[$x]['cod_func']}' ";
               if(in_array($buffer[$x]['cod_func'], $flist)){
                   echo " checked disabled";
               }
               echo " ></td>";
               echo "<td align=left><font size=2>{$buffer[$x]['nome_func']} {$grupo}</font></td>";
            echo "</tr>";
        }
    echo "</table>";
    echo "<center><input type=submit value='Confirmar'></center>";
    echo "</form>";
}

//SELECIONADO FUNCIONARIOS E ENVIADO O FORMULÁRIO
if($_GET[cod_clinica] && $_POST){
    $eval = array();
    $eqnt = array();
    foreach($_POST as $key => $id){
        //dados do funcionario
        $sql = "SELECT * FROM funcionarios WHERE cod_cliente = $_GET[cod_cliente] AND cod_func = $id";
        $result = pg_query($sql);
        $funcionario = pg_fetch_array($result);
        
        //DADOS DA CLINICA
        $sql = "SELECT * FROM clinicas WHERE cod_clinica = $_GET[cod_clinica]";
        $re = pg_query($sql);
        $cinfo = pg_fetch_array($re);
        
        //lista de exames para a função do cabra acima
        $sql = "SELECT * FROM funcao_exame WHERE cod_exame = $funcionario[cod_funcao]";
        $result = pg_query($sql);
        $exames = pg_fetch_all($result);
        
        //seleciona preço de cada exame na tabela de preços da clinica selecionada
        for($e=0;$e<pg_num_rows($result);$e++){
            $sql = "SELECT * FROM clinica_exame
            WHERE
            cod_clinica = $_GET[cod_clinica] AND
            cod_exame = {$exames[$e][exame_id]}";
            $res = pg_query($sql);
            $vex = pg_fetch_array($res);

            $sql = "SELECT * FROM site_orc_medi_produto
            WHERE cod_orcamento = $_GET[cod_orcamento] AND cod_produto = {$exames[$e][exame_id]}";
            $r = pg_query($sql);
            $d = pg_fetch_array($r);
            
            $flist = explode("|", $d[funcionarios]);
            if(!is_numeric($vex[preco_exame])){
                $vex[preco_exame] = '0.00';
            }
            
             //$vex[preco_exame] += (($vex[preco_exame] * $cinfo[por_exames])/100);

            if(!in_array($funcionario[cod_func], $flist)){
                if(pg_num_rows($r)>0){
                    $sql = "UPDATE site_orc_medi_produto SET quantidade = ".($d[quantidade]+1).", funcionarios = '$d[funcionarios]".$funcionario[cod_func]."|' WHERE
                    cod_orcamento = $_GET[cod_orcamento] AND cod_produto = {$exames[$e][exame_id]}";
                    pg_query($sql);
                }else{
                    $sql = "INSERT INTO site_orc_medi_produto (cod_orcamento, cod_cliente, cod_filial,
                    cod_produto, quantidade, aprovado, preco_aprovado, funcionarios) VALUES
                    ('$_GET[cod_orcamento]', '$_GET[cod_cliente]', '$_GET[cod_filial]',
                    '{$exames[$e][exame_id]}', 1, 1, '$vex[preco_exame]', '$funcionario[cod_func]|')";
                    pg_query($sql);
                }
            }

            echo "<script>location.href='?cod_cliente=$_GET[cod_cliente]&cod_filial=$_GET[cod_filial]&cod_orcamento=$_GET[cod_orcamento]&cod_clinica={$orcinfo[cod_clinica]}';update_me();</script>";

            if(pg_num_rows($res)>0){
                echo $exames[$e][descricao]." ->".$vex[preco_exame]." ";
                echo "<BR>";
            }else{
                $enc .= $exames[$e][descricao].";";
            }
        }
        

        //echo "FID: $key -> $id";
        echo "<P>";
        echo "A clínica solicitada, não possui preço para os seguintes exames:<BR>";
        echo $enc;
    }
}
?>
