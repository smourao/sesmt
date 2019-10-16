<?php
SESSION_START();
//print_r($_SESSION);
//include "../sessao.php";
include "config/connect.php";

$sql = "SELECT * FROM funcionario WHERE funcionario_id = '{$_SESSION['usuario_id']}'";
$result = pg_query($sql);
$data = pg_fetch_array($result);
if($data['grupo_id'] == 1 || $data['grupo_id'] == 2){

}else{

   echo "<script>
   alert('Acesso não permitido para este grupo! Entre em contato com o Administrador.');
   location.href='tela_principal.php';
   </script>";
   die("Acesso não permitido para seu grupo! Entre em contato com o Administrador.");
}
?>
<html>
<head>
<title>Lista de Contadores</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="orc.js"></script>
<script language="javascript" src="scripts.js"></script>
<script language="javascript" src="js.js"></script>
<script language="javascript" src="screen.js"></script>

</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<p>
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="800" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="6" class="linhatopodiresq" bgcolor="#009966">
        <br>RELAÇÃO DE CONTADORES<br></th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="6">
			<br>
				<input name="btn_sair" type="button" id="btn_sair" onClick="MM_goToURL('parent','./tela_principal.php'); return document.MM_returnValue" value="Sair" style="width:100;">
			<br>
			</th>
		</tr>
	</tr>
	
	<tr>
      <td height="26" colspan="6" class="linhatopodiresq">
	  <br>
    <!--
      <table width="500" border="0" align="center">
        <tr>
         <form action="javascript:select_cliente();">
          <td width="25%" align=right><strong>Razão Social:</strong></td>
          <td width="50%" align=center><input name="cliente" id="cliente" type="text" size="30" style="background:#FFFFCC"></td>
          <td width="25%" align=left><input type="button" onclick="select_cliente();" name="Submit" value="Pesquisar" class="inputButton" style="width:100;"></td>
          </form>
        </tr>
      </table>
     -->
     
     <!-- CONTEÚDO -->
     <table width="500" border="0" align="center">
        <tr>
          <td width="100%" align=right>
              <div id="lista_orcamentos">
              </div>
          </td>
        </tr>
     </table>
      
<!--      </form>-->
	 </td>
    </tr>
  <tr>
    <th colspan="6" class="linhatopodiresq" bgcolor="#009966">
      <h3>Lista de Contadores</h3>
    </th>
  </tr>
  <tr>
    <td width="2%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12" style="font-size:12px;"><strong>Nº</strong></div></td>

<!--
    <td width="10%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Cód Cliente</strong></div></td>
-->
    <td width="20%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Escritório
	</strong></div></td>

    <td width="20%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Contador</strong></div></td>

    <td width="12%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Telefone</strong></div></td>

    <td width="20%" colspan=2 bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Referência</strong></div></td>
  </tr>
<?php

$sql = "SELECT DISTINCT(nome_contador), escritorio_contador, email_contador, tel_contador FROM cliente WHERE TRIM(nome_contador) <> '' ORDER BY nome_contador";
$result = pg_query($sql);
$buffer = pg_fetch_all($result);

for($x=0;$x<pg_num_rows($result);$x++){
$sql = "SELECT razao_social FROM cliente WHERE nome_contador = '{$buffer[$x]['nome_contador']}'";
$r = pg_query($sql);
$data = pg_fetch_all($r);
$clist = "<center><b>Empresas</b></center><p>";
    for($y=0;$y<pg_num_rows($r);$y++){
        $clist .= ($y+1)." - <b>{$data[$y][razao_social]}</b><BR>";
    }
?>
  <tr>
    <td class="linhatopodiresq">
	  <div align="center" class="fontebranca12">
      <?PHP echo $x+1;?>
	  </div>
	</td>

    <td class="linhatopodiresq">
	  <div align="left"  class="fontebranca12">
             <b><?PHP echo $buffer[$x]['escritorio_contador'];?></b>
	  </div>
	</td>
	
	    <td class="linhatopodiresq">
	  <div align="left"  class="fontebranca12">
   <?PHP echo $buffer[$x]['nome_contador'];?>
	  </div>
	</td>

	
    <td class="linhatopodiresq">
	  <div align="left"  class="fontebranca12">
         <?PHP echo $buffer[$x]['tel_contador'];?>
	  </div>
	</td>

    <td colspan=2 class="linhatopodiresq">
	  <div align="center"  class="fontebranca12"  onMouseOver="return overlib('<?PHP echo $clist;?>');" onMouseOut="return nd();">
         <?PHP echo "(".pg_num_rows($r).")".$data[0]['razao_social'];?>
	  </div>
	</td>

  </tr>
<?php
  }
  $fecha = pg_close($connect);
?>
  <tr>
    <td bgcolor="#009966" class="linhatopodiresqbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
  </tr>
</table>
<pre>














</pre>
</body>
</html>
