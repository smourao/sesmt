<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";

$sql = "SELECT * FROM funcionarios_temp";
$res = pg_query($connect, $sql);
$buffer = pg_fetch_all($res);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Relação de Colaboradores</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<script language="javascript" src="../ajax.js"></script>

<style type="text/css" media="screen">
.excluir{
 font-family: verdana;
 color: #FF0000;
 font-size: 12px;
}

.excluir:hover{
 font-family: verdana;
 color: #fa3d3d;
 font-size: 12px;
}
</style>
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<br>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" class="fontebranca12">
    <div align="center" class="fontebranca22bold">Painel de Controle do Sistema</div>
    </td>
  </tr>
  <tr>
    <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12">
    <div align="center" class="fontepreta14bold">
    <font color="#000000">Relação de Colaboradores</font>
    </div>
    </td>
  </tr>
  <tr>
    <td colspan="4" class="fontebranca12" align=center><br>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td class="fontebranca12" align=center>
        <?PHP
        if($_GET){
            echo "<center><input name=\"btn_voltar\" type=\"button\" id=\"btn_voltar\" onClick=\"javascript:location.href='fun_cliente.php'\" value=\"&lt;&lt; Voltar\">";
        }else{
            echo "<center><input name=\"btn_voltar\" type=\"button\" id=\"btn_voltar\" onClick=\"javascript:location.href='index.php'\" value=\"&lt;&lt; Voltar\">";
        }
        ?>
        </td>
      </tr>
    </table>
      </td>
  </tr>
</table>
<p>


<?PHP
if(!$_GET){
?>
<table width="500" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td width="10" class="linhatopodiresq"><div align="center" class="fontebranca12"><b><center>Cod.</center></b></div></td>
    <td width="15" class="linhatopodir"><div align="center" class="fontebranca12"><b><center>Cliente/Filial</center></b></div></td>
    <td class="linhatopodir"><div align="center" class="fontebranca12"><b><center>Nome</center></b></div></td>
    <td width="15" class="linhatopodir" align=center>
    <div align="center" class="fontebranca12"><div align="center" class="fontebranca12"><b><center>Admissão</center></b></div></td>
    <td width="15" class="linhatopodir">
    <div align="center" class="fontebranca12"><center><b>Migrar</b></center></div></td>
  </tr>
<?PHP
   for($x=0;$x<pg_num_rows($res);$x++){
       echo "<tr>";
       echo "<td class=fontebranca12><center>{$buffer[$x]['cod_func']}</center></td>";
       echo "<td class=fontebranca12><center>{$buffer[$x]['cod_cliente']}/{$buffer[$x]['cod_filial']}</center></td>";
       echo "<td class=fontebranca12>{$buffer[$x]['nome_func']}</td>";
       echo "<td class=fontebranca12><Center>{$buffer[$x]['data_admissao_func']}</center></td>";
       echo "<td class=fontebranca12><a href='?cod_fun={$buffer[$x]['cod_func']}'>Migrar</a></td>";
       echo "</tr>";
   }
?>
</table>

<?PHP
}else{

$sql = "SELECT * FROM funcionarios_temp WHERE cod_func={$_GET['cod_fun']}";
$result = pg_query($connect, $sql);
$buffer = pg_fetch_all($result);

if($_GET['act'] == "migrar"){

$sql = "SELECT max(cod_func)+1 as cod_max FROM funcionarios";
$r = pg_query($connect, $sql);
$row = pg_fetch_array($r);

//print_r($row);

$sql = "SELECT count(cod_func)+1 as num FROM funcionarios WHERE cod_cliente = '{$buffer[0]['cod_cliente']}'";
$rz = pg_query($sql);
$m = pg_fetch_array($rz);

//echo $_POST['funcao'];
$sql = "INSERT INTO funcionarios
(cod_func, nome_func, bairro_func, endereco_func, num_ctps_func, serie_ctps_func, cbo, cod_status, cod_funcao,
cod_setor, cod_cliente, sexo_func, data_nasc_func, data_admissao_func, data_desligamento_func,
dinamica_funcao, cidade, cod_filial, naturalidade, nacionalidade, civil, cor, cpf, rg, cep,
estado, img_url)
VALUES
('{$m['num']}', '{$buffer[0]['nome_func']}', '{$buffer[0]['bairro_func']}', '{$buffer[0]['endereco_func']}',
'{$buffer[0]['num_ctps_func']}', '{$buffer[0]['serie_ctps_func']}','{$buffer[0]['cbo']}',
1, '{$_POST['funcao']}', 0, '{$buffer[0]['cod_cliente']}', '{$buffer[0]['sexo_func']}',
'{$buffer[0]['data_nasc_func']}', '{$buffer[0]['data_admissao_func']}', '',
'{$buffer[0]['dinamica_funcao']}', '{$buffer[0]['cidade']}','{$buffer[0]['cod_filial']}',
'{$buffer[0]['naturalidade']}', '{$buffer[0]['nacionalidade']}', '{$buffer[0]['civil']}',
'{$buffer[0]['cor']}', '{$buffer[0]['cpf']}', '{$buffer[0]['rg']}', '{$buffer[0]['cep']}',
'{$buffer[0]['estado']}', '{$buffer[0]['img_url']}')
";

//echo $sql;
$result = pg_query($connect, $sql);

if($result){
  $sql = "DELETE FROM funcionarios_temp WHERE cod_func={$_GET['cod_fun']}";
  pg_query($connect, $sql);
  echo "<script>
  alert('Colaborador migrado com sucesso!');
  window.location.href='fun_cliente.php';
  </script>";
}else{

}

}else{
echo "<form method=POST action=\"?cod_fun={$_GET['cod_fun']}&act=migrar\">";
?>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" class="fontebranca12">
<center> <b>Dados Pessoais</b> </center>
<table width=500 border=1>
<tr>
    <td  align=center>
    <div id="foto" name="foto" class=fontebranca12>
    <!--<b>foto</b><p><font size=1>Clique para inserir!</font>-->
    <img src='http://marketing/2009/novo/<?php echo $buffer[0]['img_url'];?>' border=0 width=100 height=120>
    </div>
    </td>
    <td valign=top>
        <table border=0 width=380>
           <tr>
               <td width="15%" class=fontebranca12>Nome:</td>
                <td><input name=nome id=nome type=text size=48 class=text value='<?php echo $buffer[0]['nome_func'];?>'></td>
           </tr>
        </table>
        <table border=0 width=380>
           <tr>
               <td width="15%" class=fontebranca12>CPF:</td>
               <td  width=110><input type=text class=text size=12 name=cpf id=cpf onchange="cpf_funcionario();" value='<?php echo $buffer[0]['cpf'];?>'></td>
               <td width="80" class=fontebranca12>RG:</td>
               <td><input name=rg id=rg type=text size=15 class=text value='<?php echo $buffer[0]['rg'];?>'></td>
           </tr>
         </table>
         <table border=0 width=380>
           <tr>
               <td width="15%" class=fontebranca12>Sexo:</td>
                <td  width=110>
                <select name=sexo id=sexo class=text>
                <option <?php if($buffer[0]['sexo_func'] == 'Masculino'){echo 'selected';}?>>Masculino</option>
                <option <?php if($buffer[0]['sexo_func'] == 'Feminino'){echo 'selected';}?>>Feminino</option>
                </select></td>
                <td width="80" class=fontebranca12>Nascimento:</td>
               <td><input name=nascimento id=nascimento type=text size=15 class=text value='<?php echo $buffer[0]['data_nasc_func'];?>'></td>
           </tr>
        </table>
        <table border=0 width=380>
           <tr>
               <td width="15%" class=fontebranca12>Cor:</td>
                <td width=110><input name=cor id=cor type=text size=12 class=text value='<?php echo $buffer[0]['cor'];?>'></td>
                <td width="80" class=fontebranca12>Estado Civil:</td>
               <td><input name=estado_civil id=estado_civil type=text size=15 class=text value='<?php echo $buffer[0]['civil'];?>'></td>
           </tr>
        </table>
    </td>
</tr>
</table>
<p>
<center> <b>Dados Residenciais</b> </center>
<table width=490 border=1>
   <tr>
      <td width=490>
          <table width=490 border=0>
             <tr>
                <td  width="15%" class=fontebranca12>CEP:</td>
                <td  width=100>
                <input type=text name=cep1 id=cep1 size=10 onchange="cep();" maxlength=8 class=text value='<?php echo $buffer[0]['cep'];?>'>
                <input type=hidden id=cep2 name=cep2>
                </td>
                <td width="50" class=fontebranca12>Bairro:</td>
                <td width="85"><input type=text id=bairro name=bairro size=8 class=text value='<?php echo $buffer[0]['bairro_func'];?>'></td>
                <td width="58" class=fontebranca12>Cidade:</td>
                <td><input type=text size=11 name=cidade id=cidade class=text value='<?php echo $buffer[0]['cidade'];?>'></td>
             </tr>
          </table>
          <table width=490 border=0>
             <tr>
                <td  width="15%" class=fontebranca12>Endereço:</td>
                <td  width=210><input type=text size=30 id=endereco name=endereco class=text value='<?php echo $buffer[0]['endereco_func'];?>'></td>
                <td width="65" class=fontebranca12>Estado:</td>
                <td><input type=text size=15 id=estado name=estado class=text value='<?php echo $buffer[0]['estado'];?>'></td>
             </tr>
          </table>
          <table width=490 border=0>
             <tr>
                <td  width="15%" class=fontebranca12>Natural:</td>
                <td  width=182><input name=natural id=natural type=text size=20 class=text value='<?php echo $buffer[0]['naturalidade'];?>'></td>
                <td width="65" class=fontebranca12>Nacionalidade:</td>
                <td><input name=nacionalidade id=nacionalidade type=text size=15 class=text value='<?php echo $buffer[0]['nacionalidade'];?>'></td>
             </tr>
          </table>
      </td>
   </tr>
</table>

<p>

<center><b>Dados Profissionais</b></center>
<table width=490 border=1>
   <tr>
      <td width=490>
          <!-- FUNÇÃO / DESCRIÇÃO DECLARADA PELO CLIENTE-->
          <center><span  class=fontebranca12><b>Função declarada pelo cliente</b></span>
          <table width=490 border=0>
             <tr>
                <td  width="15%" class=fontebranca12>Função:</td>
                <td  width=182><input name=funcao id=funcao type=text size=20 class=text value='<?php echo $buffer[0]['cod_funcao'];?>'></td>
                <td width="65" align=center class=fontebranca12>Dinâmica da Função:</td>
                <td><textarea name=dinamica_da_funcao id=dinamica_da_funcao row=3 cols=15 class=text ><?php echo $buffer[0]['dinamica_funcao'];?></textarea></td>
             </tr>
          </table>

<?PHP
$sql = "SELECT * FROM funcao ORDER BY nome_funcao";
$res = pg_query($connect, $sql);
$funcoes = pg_fetch_all($res);
?>

          <!-- FUNÇÃO OBTIDA PELO CADASTRO GERAL DA FUNÇÃO-->
          <center><span  class=fontebranca12><b>Atribuição de função</b></span>
          <table width=490 border=0>
             <tr>
                <td  width="15%" class=fontebranca12>Função:</td>
                <td  width=182>
                <select name=funcao id=funcao >
                <?PHP
                $desc = array();
                for($x=0;$x<pg_num_rows($res);$x++){
                    echo "<option value='{$funcoes[$x]['cod_funcao']}'>{$funcoes[$x]['nome_funcao']}</option>";
                    $desc[] = $funcoes[$x]['dsc_funcao'];
                }
                ?>
                </select><br>
                <input type=button value='Adicionar Função' onclick="window.location.href='../producao/cad_funcao.php?fun=<?PHP echo $buffer[0]['cod_funcao'];?>&din=<?PHP echo $buffer[0]['dinamica_funcao'];?>'">

                <!--<input name=funcao id=funcao type=text size=20 class=text value='<?php //echo $buffer[0]['cod_funcao'];?>'>-->

                </td>
<!--                <td width="65" align=center class=fontebranca12>Dinâmica da Função:</td>
                <td><textarea name=dinamica_da_funcao id=dinamica_da_funcao row=3 cols=15 class=text ><?php //echo $buffer[0]['dinamica_funcao'];?></textarea></td>-->
             </tr>
          </table>


          <table width=490 border=0>
             <tr>
               <!-- <td  width="15%">Admissão:</td>
                <td  width=100><input name=admissao id=admissao type=text name=cep id=cep size=10 class=text></td>
                <td width="50">CTPS:</td>
                <td width="100"><input name=ctps id=ctps type=text size=11 class=text></td>
                <td width="41">Série:</td>
                <td><input name=serie id=serie type=text size=11 class=text></td>
               -->
                <td  width="15%" class=fontebranca12>Admissão:</td>
                <td  width=182><input name=admissao id=admissao type=text size=20 class=text  value='<?php echo $buffer[0]['data_admissao_func'];?>'></td>
                <td width="65" class=fontebranca12>CBO:</td>
                <td><input name=cbo id=cbo type=text size=15 class=text  value='<?php echo $buffer[0]['cbo'];?>'></td>
             </tr>
             <tr>
                <td  width="15%" class=fontebranca12>CTPS:</td>
                <td  width=182><input name=ctps id=ctps type=text size=20 class=text  value='<?php echo $buffer[0]['num_ctps_func'];?>'></td>
                <td width="65" class=fontebranca12>Série:</td>
                <td><input name=serie id=serie type=text size=15 class=text  value='<?php echo $buffer[0]['serie_ctps_func'];?>'></td>
             </tr>
          </table>

      </td>
   </tr>
</table>
<p>
          <br>
          <center>
          <input type=submit value="Migrar Colaborador">
          </form>

<?PHP
}
}
?>

</table>
</form>
</body>
</html>
