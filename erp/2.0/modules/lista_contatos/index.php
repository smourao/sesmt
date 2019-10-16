<?php

//consulta pessoa fisica
$sql_f = "SELECT * FROM reg_pessoa_fisica ORDER BY nome";
$query_f = pg_query($sql_f);

//consulta pessoa juridica
$sql_j = "SELECT * FROM reg_pessoa_juridica ORDER BY razao_social";
$query_j = pg_query($sql_j);

?>
<html>
<head>
<title>Lista de Clientes</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
</head>
<style>
#loading{
display: block;
position: relative;
left: 0px;
top: 60px;
width:0px;
height:0px;
color: #888000;
z-index:1;
}

#loading_done{
position: relative;
display: none;
}
</style>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<p>
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="700" border="2" align="center" cellpadding="0" cellspacing="0" class='text roundborderselected'>
    <tr>
    	<th colspan="4" class="linhatopodiresq" ><br>
    	TELA DE RELA&Ccedil;&Atilde;O DE CONTATOS <br>
    	&nbsp;</th>
    </tr><tr>
		<th  height="50"  colspan="4"><input name="btn_sair" class='btn' type="button" id="btn_sair" onClick="location.href='index.php';" value="Sair" style="width:100;">
      &nbsp;			</th>
		</tr>
		
		
		<tr>
		  <th  height="50" >&nbsp;</th>
		  <th  height="50" ><form action="?dir=lista_contatos&p=index" method="post" name="env_emails" id="env_emails">
            <p>
              <label>
              <input type="radio" name="emails" value="f" />
                Pessoa F&iacute;sica</label>
              <br />
              <label>
              <input type="radio" name="emails" value="j" />
                Pessoa Jur&iacute;dica</label>
            </p>
	      </th>
		  <th  height="50" ><input name="enviar" type="submit" value="Listar" class='btn'/></form></th>
		  <th  height="50" >&nbsp;</th>
		</tr>
	</tr>
	<form id="env_emails" name="env_emails" method="post" action="?dir=lista_contatos&p=index2">
	
  		<?php 
  			if ($_POST['emails'] == "f"){
  				
		?>	
		
<tr>
    <td width="43"  class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>N&ordm;</strong></div></td>

    <td width="317"  class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Nome</strong></div></td>

    <td width="292"  class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Profissão</strong></div></td>

    <td width="36"  class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Box</strong></div></td>
  </tr>
  <?php 
  for($x=0;$x < pg_num_rows($query_f);$x++){
				$array_f = pg_fetch_array($query_f);
				?>
  <tr>
    <td class="linhatopodiresq" align="center"><?php echo $x+1; ?></td>
	
   <td class="linhatopodiresq"><?php echo strtolower($array_f[nome]); ?></td>

    <td class="linhatopodiresq"><?php echo strtolower($array_f[profissao]); ?></td>
    <td class="linhatopodiresq" align="center">
      <label>
        <input type="checkbox" name="env_email" value="<?php echo $array_f[id]; ?>" />
        </label>    </td>
  </tr>
  <?php }} ?>
  
  <?php
  				if($_POST['emails'] == "j"){

		?>
		
<tr>
    <td width="43"  class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>N&ordm;</strong></div></td>

    <td width="317"  class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Razão Social</strong></div></td>

    <td width="292"  class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Responsável</strong></div></td>

    <td width="36"  class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Box</strong></div></td>
  </tr>
  
  <?php
    			for($x=0;$x < pg_num_rows($query_j);$x++){
				$array_j = pg_fetch_array($query_j);
				?>
  <tr>
    <td class="linhatopodiresq" align="center"><?php echo $x+1; ?></td>
	
   <td class="linhatopodiresq"><?php echo strtolower($array_j[razao_social]); ?></td>

    <td class="linhatopodiresq"><?php echo strtolower($array_j[responsavel]); ?></td>
    <td class="linhatopodiresq" align="center">
      <label>
        <input type="checkbox" name="env_email" value="<?php echo $array_j[id]; ?>" />
        </label>    </td>
  </tr>
  <?php }}
  			else{
			}
  
  ?>
      <tr >
    <td colspan="4" align="center" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong></strong></div>    </td>
   </tr>
   <?php if($_POST['emails'] != ""){
			?>
    <tr >
    <td colspan="4" align="center" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Digite aqui a menssagem a ser enviada:</strong></div>    </td>
   </tr>
			
    <tr>
    <td colspan="4"  class="linhatopodiresqbase">
	
	<br /><div align="left"><strong>Assunto:</strong><br />
	<input name="assunto" type="text" size="65" /></div>
	
	<br /><div align="left"><strong>Menssagem:</strong><br />
    <textarea name="menssagem" cols="50" rows="5"></textarea></div>
    </div>      </td>
  </tr>
  <tr>
    <td colspan="4"  class="linhatopodiresqbase"><div align="center"><input name="env_emails" type="submit" value="Enviar Emails" class='btn'/></div>      </td>
  </tr>
  
  <?php
   } 
   ?>
  </form>
</table>
<br>
</body>
</html>