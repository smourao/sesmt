<?php
include "../sessao.php";
include "../config/connect.php";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<script language="JavaScript" type="text/javascript" src="richtext.js"></script>
<title>Administração Jornal SESMT</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<br>
<form action="" method="post" name="riscos" id="riscos">
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="5" class="fontebranca12">
    <div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>
    <div align="center"></div>      <div align="center"></div>      <div align="center"></div></td>
  </tr>
  <tr>
    <td colspan="5" bgcolor="#FFFFFF" class="fontebranca12">
    <div align="center" class="fontepreta14bold"><font color="#000000">Jornal SESMT </font></div></td>
  </tr>
  <tr>
    <td colspan="5" class="fontebranca12"><br>
      <table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td class="fontebranca12"><input name="btn_incluir" type="button" id="btn_incluir" value="Incluir" onClick="location.href='?action=new'"></td>
        <td class="fontebranca12"><input name="btn_editar" type="button" id="btn_editar" value="Editar" onClick="location.href='?action=edit'"></td>
        <td class="fontebranca12"><input name="btn_email" type="button" id="btn_email" value="Lista de E-Mails" onClick="location.href='?action=email'"></td>
        <td class="fontebranca12">
        <input name="btn_voltar" type="button" id="btn_voltar" onClick="location.href='index.php'" value="&lt;&lt; Voltar"></td>
      </tr>

    </table>
      <br></td>
  </tr>
</table>
</form>
<?PHP
/***********************************************************************************************/
// NEW
/***********************************************************************************************/
if($_GET['action']=="new"){
   //Send form to insert data at database
   if($_POST['submit']=="Enviar"){

      $_POST[txtResumido] = str_ireplace('<img', '<img align=left', $_POST[txtResumido], $cr);
      $_POST[txtCompleto] = str_ireplace('<img', '<img align=left', $_POST[txtCompleto], $cc);
      
      if(!$cr){
          $_POST[txtResumido] = str_ireplace('<img', '<img align=left', $_POST[txtResumido], $cr);
      }
      
      if(!$cc){
          $_POST[txtCompleto] = str_ireplace('<img', '<img align=left', $_POST[txtCompleto], $cc);
      }
      
      
      $_POST['titulo'] = addslashes($_POST['titulo']);
      $_POST['txtResumido'] = addslashes($_POST['txtResumido']);
      $_POST['txtCompleto'] = addslashes($_POST['txtCompleto']);

      
      $sql = "INSERT INTO site_jornal_sesmt
      (titulo, resumo, detalhado, data, ano, mes, enviado_por, exibir, ordem)
      VALUES
      ('{$_POST['titulo']}', '{$_POST['txtResumido']}', '{$_POST['txtCompleto']}', '".date("Y-m-d")."',
      '{$_POST['ano']}', '{$_POST['mes']}', 'Pedro Henrique', 1, '{$_POST['order']}')
      ";
      if(pg_query($sql)){
          echo "<center><span class=fontebranca12>Texto enviado com sucesso!</span></center>";
      }else{
          echo "<center><span class=fontebranca12>Erro ao enviar o texto para o banco de dados!</span></center>";
      }
   }else{
    echo '<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">';
    echo "<tr><td  class=fontebranca12>";
    echo '<form name="RTEDemo" action="jornal_admin.php?action=new" method="post" onsubmit="return submitForm();">';

    $mes = date("n");


    echo '<table border=0>
    <tr>
       <td class="fontebranca12">Titulo:</td><td><input type=text name="titulo" id="titulo"></td>
    </tr>
    <tr>
       <td class="fontebranca12">Mes:</td>
       <td>
       <!--<input type=text name="mes" id="mes" size=2>-->
       <select name=mes>
          <option value=1 '; print $mes == 1 ? "selected" : ""; echo' >Janeiro</option>
          <option value=2 '; print $mes == 2 ? "selected" : ""; echo' >Fevereiro</option>
          <option value=3 '; print $mes == 3 ? "selected" : ""; echo' >Março</option>
          <option value=4 '; print $mes == 4 ? "selected" : ""; echo' >Abril</option>
          <option value=5 '; print $mes == 5 ? "selected" : ""; echo' >Maio</option>
          <option value=6 '; print $mes == 6 ? "selected" : ""; echo' >Junho</option>
          <option value=7 '; print $mes == 7 ? "selected" : ""; echo' >Julho</option>
          <option value=8 '; print $mes == 8 ? "selected" : ""; echo' >Agosto</option>
          <option value=9 '; print $mes == 9 ? "selected" : ""; echo' >Setembro</option>
          <option value=10 '; print $mes == 10 ? "selected" : ""; echo' >Outubro</option>
          <option value=11 '; print $mes == 11 ? "selected" : ""; echo' >Novembro</option>
          <option value=12 '; print $mes == 12 ? "selected" : ""; echo' >Dezembro</option>
       </select>
       </td>
    </tr>
    <tr>
    <td class="fontebranca12">Ano:</td>
    <td>
    <!--<input type=text name="ano" id="ano" size=4>-->
       <select name=ano>
          <option  '; print date("Y") == 2005 ? "selected" : ""; echo' >2005</option>
          <option  '; print date("Y") == 2006 ? "selected" : ""; echo' >2006</option>
          <option  '; print date("Y") == 2007 ? "selected" : ""; echo' >2007</option>
          <option  '; print date("Y") == 2008 ? "selected" : ""; echo' >2008</option>
          <option  '; print date("Y") == 2009 ? "selected" : ""; echo' >2009</option>
          <option  '; print date("Y") == 2010 ? "selected" : ""; echo' >2010</option>
          <option  '; print date("Y") == 2011 ? "selected" : ""; echo' >2011</option>
       </select>
    </td>
    </tr>
    <tr>
       <td class="fontebranca12">Ordem:</td><td class="fontebranca12">
       <input type=text name="order" id="order" size=2 value=0> (Prioridade de exibição, ordem decrescente.)</td>
    </tr>
    <table>
    <p>
    ';

    echo "<script language=\"JavaScript\" type=\"text/javascript\">
    <!--
    function submitForm() {
    	updateRTEs();
    	return true;
    }
    //Usage: initRTE(imagesPath, includesPath, cssFile)
    initRTE(\"images/\", \"\", \"\");
    //-->
    </script>
    <noscript><p><b>Javascript precisa estar habilitado para utilizar este formulário!</b></p></noscript>

    <script language=\"JavaScript\" type=\"text/javascript\">
    <!--
    //writeRichText(fieldname, html, width, height, buttons, readOnly)
    document.writeln('<center><b>Texto resumido</b></center><br>');
    writeRichText('txtResumido', '', 520, 500, true, false);
    document.writeln('<br><br>');
    document.writeln('<center><b>Texto Completo</b></center><br>');
    writeRichText('txtCompleto', '', 520, 500, true, false);
    //-->
    </script>
    <p>
    <center>
    <input type=\"submit\" name=\"submit\" value=\"Enviar\"></p>
    <input type=hidden name=conteudo id=conteudo>
    </form>
    ";
    echo "</td></tr></table>";
    }


//DEBUG - TESTES
if($_POST['submit']=="Enviar"){
    $sql = "SELECT email, cliente_id, filial_id, email_contato_dir, email_contador, email_cont_ind FROM cliente
            UNION
            SELECT email, cliente_id, filial_id, email_contato_dir, email_contador, email_cont_ind FROM cliente_comercial";
    
    $result = pg_query($sql);
    $lista = pg_fetch_all($result);
    $allmail = array();
    
    for($x=0;$x<pg_num_rows($result);$x++){
        $cl = array();
        if($lista[$x][email]){
            $emails = explode(";", str_replace("/", ";", $lista[$x][email]));
            for($l=0;$l<count($emails);$l++){
                if($emails[$l]){
                    $cl[] = $emails[$l];//$lista[$x][email];
                }
            }
        }
        
        if($lista[$x][email_contato_dir]){
            $emails = explode(";", str_replace("/", ";", $lista[$x][email_contato_dir]));
            for($l=0;$l<count($emails);$l++){
                if($emails[$l]){
                    $cl[] = $emails[$l];//$lista[$x][email];
                }
            }
        }

        if($lista[$x][email_contador]){
            $emails = explode(";", str_replace("/", ";", $lista[$x][email_contador]));
            for($l=0;$l<count($emails);$l++){
                if($emails[$l]){
                    $cl[] = $emails[$l];//$lista[$x][email];
                }
            }
        }
        
        if($lista[$x][email_cont_ind]){
            $emails = explode(";", str_replace("/", ";", $lista[$x][email_cont_ind]));
            for($l=0;$l<count($emails);$l++){
                if($emails[$l]){
                    $cl[] = $emails[$l];//$lista[$x][email];
                }
            }
        }

        $cl = array_flip($cl);
        $cl = array_flip($cl);
        
        //seleciona o ID da noticia adicionada
        $sql = "SELECT MAX(id) as max FROM site_jornal_sesmt";
        $r = pg_query($sql);
        $max = pg_fetch_array($r);
        $max = $max[max];
        
        //-->Desabilitada verificação de duplicidade de msg por email;
        //este teste deixa o sistema lento pelo grande numero de contatos e querys
        for($y=0;$y<count($cl);$y++){
                //verifica se jão não foi cadastrado pra esta noticia o email a receber
                /*
                $sql = "SELECT * FROM site_jornal_mail WHERE noticia_id = '$max' AND email = '{$cl[$y]}'";
                $r = pg_query($sql);
                $ex = pg_fetch_all($r);
                //se não houver cadastro desta noticia pro email, adiciona-o a lista
                if(pg_num_rows($r)<=0 && !empty($cl[$y])){
                */
                    $sql = "INSERT INTO site_jornal_mail
                    (cod_cliente, cod_filial, email, noticia_id)
                    VALUES
                    ('{$lista[$x][cliente_id]}', '{$lista[$x][filial_id]}', '{$cl[$y]}',
                    '{$max}')";
                    //Desabilitar o registro
                    pg_query($sql);
                    $allmail[] = $cl[$y];
                //}
        }
    }
        
        //INSERIR DA TABELA DE EMAILS AVULSOS AKI NO ARRAY $CL
        $cl = array();
        $sql = "SELECT * FROM site_newsletter_info WHERE receive = 1";
        $resultado = pg_query($sql);
        $news = pg_fetch_all($resultado);
        for($z=0;$z<pg_num_rows($resultado);$z++){
            $cl[] = $news[$z][email];
        }
        $cl = array_flip($cl);
        $cl = array_flip($cl);
        for($y=0;$y<count($cl);$y++){
                //verifica se jão não foi cadastrado pra esta noticia o email a receber
                $sql = "SELECT * FROM site_jornal_mail WHERE noticia_id = '$max' AND
                email = '{$cl[$y]}'";
                $r = pg_query($sql);
                $ex = pg_fetch_all($r);
                //se não houver cadastro desta noticia pro email, adiciona-o a lista
                if(pg_num_rows($r)<=0 && !empty($cl[$y])){
                    $sql = "INSERT INTO site_jornal_mail
                    (cod_cliente, cod_filial, email, noticia_id)
                    VALUES
                    ('0', '0', '{$cl[$y]}',
                    '{$max}')";
                    //Desabilitar o registro
                    pg_query($sql);
                    $allmail[] = $cl[$y];
                }
        }
        //print_r($allmail);
        //echo "<BR>";
}
}

if($_GET['action']=="del"){
   if($_GET['id']){
      $sql = "DELETE FROM site_jornal_sesmt WHERE id={$_GET['id']}";
      if(pg_query($sql)){
          echo "<center><span class=fontebranca12>Notícia excluída do banco de dados!</span></center>";
      }else{
          echo "<center><span class=fontebranca12>Erro ao excluir notícia!</span></center>";
      }
   }
}


if($_GET['action']=="edit"){
   if($_GET['id'] && $_GET['ordem'] == ""){
      if($_POST['submit']=="Enviar"){
      $sql = "UPDATE site_jornal_sesmt
      SET titulo='{$_POST['titulo']}', resumo='".$_POST['txtResumido']."',
      detalhado='".$_POST['txtCompleto']."', data='".date("Y-m-d")."',
      ano='{$_POST['ano']}', mes='{$_POST['mes']}', ordem='{$_POST['order']}' WHERE id={$_GET['id']}";

      if(pg_query($sql)){
          echo "<center><span class=fontebranca12>Texto editado com sucesso!</span></center>";
      }else{
          echo "<center><span class=fontebranca12>Erro ao editar o texto no banco de dados!</span></center>";
      }
      //print_r($_POST);
//      echo $sql;
      }

       $sql = "SELECT * FROM site_jornal_sesmt WHERE id={$_GET['id']}";
       $result = pg_query($sql);
       $buffer = pg_fetch_all($result);

echo '<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">';
echo "<tr><td  class=fontebranca12>";
echo '<form name="RTEDemo" action="jornal_admin.php?action=edit&id='.$_GET['id'].'" method="post" onsubmit="return submitForm();">';
echo '<table border=0>
<tr>
   <td class="fontebranca12">Titulo:</td>
   <td><input type=text name="titulo" id="titulo" value="'.$buffer[0]['titulo'].'"></td>
</tr>
<tr>
   <td class="fontebranca12">Mes:</td>
   <td>
   <!--<input type=text name="mes" id="mes" size=2>-->
   <select name=mes>
      <option value=1'; if($buffer[0][mes]=="1")echo " selected "; echo '>Janeiro</option>
      <option value=2'; if($buffer[0][mes]=="2")echo " selected "; echo '>Fevereiro</option>
      <option value=3'; if($buffer[0][mes]=="3")echo " selected "; echo '>Março</option>
      <option value=4'; if($buffer[0][mes]=="4")echo " selected "; echo '>Abril</option>
      <option value=5'; if($buffer[0][mes]=="5")echo " selected "; echo '>Maio</option>
      <option value=6'; if($buffer[0][mes]=="6")echo " selected "; echo '>Junho</option>
      <option value=7'; if($buffer[0][mes]=="7")echo " selected "; echo '>Julho</option>
      <option value=8'; if($buffer[0][mes]=="8")echo " selected "; echo '>Agosto</option>
      <option value=9'; if($buffer[0][mes]=="9")echo " selected "; echo '>Setembro</option>
      <option value=10'; if($buffer[0][mes]=="10")echo " selected "; echo '>Outubro</option>
      <option value=11'; if($buffer[0][mes]=="11")echo " selected "; echo '>Novembro</option>
      <option value=12'; if($buffer[0][mes]=="12")echo " selected "; echo '>Dezembro</option>
   </select>
   </td>
</tr>
<tr>
<td class="fontebranca12">Ano:</td>
<td>
<!--<input type=text name="ano" id="ano" size=4>-->
   <select name=ano>
      <option>2005</option>
      <option>2006</option>
      <option>2007</option>
      <option>2008</option>
      <option selected>2009</option>
      <option>2010</option>
      <option>2011</option>
   </select>
</td>
</tr>
<tr>
   <td class="fontebranca12">Ordem:</td><td class="fontebranca12">
   <input type=text name="order" id="order" size=2 value="'.$buffer[0]['ordem'].'"> (Prioridade de exibição, ordem decrescente.)</td>
</tr>
<table>
<p>
<input type=hidden name=texto value="dfbfb">
';
$cr = $buffer[0]['resumo'];
$cr = str_replace("\r\n", "<br/>",$cr);
$cr = ltrim($cr, '/\s');

//$cc = nl2br($buffer[0]['detalhado']);
$cc = $buffer[0]['detalhado'];
$cc = str_replace("\r\n", "<br/>",$cc);

//echo "--->".$cr."<---";

//echo "<div style=\"border: 1px solid;\">".nl2br($buffer[0]['detalhado'])."</div>";
echo "<script language=\"JavaScript\" type=\"text/javascript\">
<!--
function submitForm() {
	updateRTEs();
	return true;
}
//Usage: initRTE(imagesPath, includesPath, cssFile)
initRTE(\"images/\", \"\", \"\");
//-->
</script>
<noscript><p><b>Javascript precisa estar habilitado para utilizar este formulário!</b></p></noscript>

<script language=\"JavaScript\" type=\"text/javascript\">
<!--
//writeRichText(fieldname, html, width, height, buttons, readOnly)
document.writeln('<center><b>Texto resumido</b></center><br>');
writeRichText('txtResumido', '".$cr."', 520, 100, true, false);
document.writeln('<br><br>');
document.writeln('<center><b>Texto Completo</b></center><br>');
writeRichText('txtCompleto', '".$cc."', 520, 200, true, false);
//-->
</script>
<p>
<center>
<input type=\"submit\" name=\"submit\" value=\"Enviar\"></p>
<input type=hidden name=conteudo id=conteudo>
</form>
";
echo "</td></tr></table>";

   }else{
      if(is_numeric($_GET['ordem']) && is_numeric($_GET['id'])){
         $sql = "UPDATE site_jornal_sesmt SET ordem='{$_GET['ordem']}' WHERE id='{$_GET['id']}'";
        //echo $sql;
         pg_query($sql);
      }
      
       $sql = "SELECT * FROM site_jornal_sesmt ORDER BY ano DESC, mes DESC, ordem DESC";
       $result = pg_query($sql);
       $buffer = pg_fetch_all($result);

       echo "<table width=500 border=1 align=center class=fontebranca12>";
       echo "   <tr>";
       echo "      <td align=center><b>Ações</b></td><td align=center><b>Título</b></td>
       <td align=center><b>Resumo</b></td><td align=center><b>Mês/Ano</b></td><td align=center><b>Ordem</b></td>";
       echo "   </tr>";
          for($x=0;$x<pg_num_rows($result);$x++){
             echo "   <tr>";
             echo "
             <td align=center>
             <a href='?action=edit&id={$buffer[$x]['id']}' class=linkpadrao>Editar</a>
             <P>
             <a href='?action=del&id={$buffer[$x]['id']}' class=excluir>Excluir</a></td>
             <td>{$buffer[$x]['titulo']}</td>
             <td>{$buffer[$x]['resumo']}</td>
             <td>{$buffer[$x]['mes']}/{$buffer[$x]['ano']}</td>
  			 <td align=center>
               <img src='images/up.png' border=0 style=\"cursor:pointer;\" onclick=\"location.href='?action=edit&id={$buffer[$x]['id']}&ordem=".($buffer[$x]['ordem']+1)."'\">
               {$buffer[$x]['ordem']}
               <img src='images/down.png' border=0 style=\"cursor:pointer;\" onclick=\"location.href='?action=edit&id={$buffer[$x]['id']}&ordem="; print $buffer[$x]['ordem'] > 0 ? $buffer[$x]['ordem']-1 : 0; echo "'\">
               </td>
             ";
             echo "   </tr>";
          }
       echo "</table>";
   }
}

/************************************************************************************************/
// E-MAIL
/************************************************************************************************/
if($_GET[action]=="email"){


    echo "<form method=post action='?action=email'>";
    echo '<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">';
    echo "<tr>";
    echo "<td class=fontebranca12 width=60><b>E-Mail:</b></td>";
    echo "<td class=fontebranca12 width=180><input type=text name=newemail id=newemail size=25></td>";
    echo "<td class=fontebranca12><input type=submit value='Cadastrar'></td>";
    echo "</tr>";
    echo "</table>";
    echo "</form>";
    
    echo "<P>";
    
    echo "<div class=linksistema style=\"color: #FFFFFF;\"><center>[ <a href='?action=email&l=all' class=linksistema>#</a> | ";
    $al = "A";
    for($x = "1";$x<="26";$x++){
        echo "<a href='?action=email&l=".strtolower($al)."' class=linksistema>".$al."</a>";
        if($al != "Z"){
           echo " | ";
        }
        $al++;
    }

    $sql = "SELECT * FROM site_newsletter_info";
    $result = pg_query($sql);
    
    echo " ]<P><font size=1>".pg_num_rows($result)." E-Mails cadastrados</font></center></div>";
    

    
    
    if($_POST[newemail]){
        $newemail = addslashes(strtolower($_POST[newemail]));
        $sql = "SELECT * FROM site_newsletter_info WHERE lower(email) = '$newemail'";
        $result = pg_query($sql);
        if(pg_num_rows($result)>0){
            //echo "<script>alert('Este email já está cadastrado!');</script>";
            echo "<center><font size=2 color=red>Este email já está cadastrado!</font></center>";
        }else{
           $sql = "INSERT INTO site_newsletter_info (email) values ('$newemail')";
           if(pg_query($sql)){
               echo "<center><font size=2 color=green>O email $newemail foi cadastrado!</font></center>";
           }else{
               echo "<center><font size=2 color=red>Houve um erro ao cadastrar este email!</font></center>";
           }
        }
    }
    
    if($_GET[id]){
        if($_GET[a] == "del"){
            $sql = "DELETE FROM site_newsletter_info WHERE id = '{$_GET[id]}'";
            if(pg_query($sql)){
                echo "<center><font size=2 color=green>O Email foi deletado do banco de dados com sucesso!</font></center>";
            }
        }else{
            $sql = "UPDATE site_newsletter_info SET receive = '$_GET[a]' WHERE id = '{$_GET[id]}'";
            pg_query($sql);
        }
    }
    echo "<BR>";

    if($_GET[l]){
        if($_GET[l] == 'all')
            $sql = "SELECT * FROM site_newsletter_info WHERE SUBSTR(email, 1, 1) ~ '^[0-9]+$'";
        else
            $sql = "SELECT * FROM site_newsletter_info WHERE lower(email) like '".addslashes($_GET[l])."%' ORDER BY email";
    }else{
        $sql = "SELECT * FROM site_newsletter_info WHERE lower(email) like 'a%' ORDER BY email";
    }
    $result = pg_query($sql);
    $buffer = pg_fetch_all($result);
    
    echo '<table width="500" border="1" align="center" cellpadding="0" cellspacing="0">';
    echo "<tr>";
    echo "<td class=fontebranca12 colspan=4 align=center>Os emails de clientes e simulador não estão listados abaixo e são enviados automaticamente.</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=fontebranca12 width=20 align=center><b>Nº</b></td>";
    echo "<td class=fontebranca12 align=center><b>E-Mail</b></td>";
    echo "<td class=fontebranca12 width=60 align=center><b>Status</b></td>";
    echo "<td class=fontebranca12 width=160 align=center><b>Ação</b></td>";
    echo "</tr>";
    for($x=0;$x<pg_num_rows($result);$x++){
        //
        echo "<tr>";
        echo "<td class=fontebranca12 align=center>".($x+1)."</td>";
        echo "<td class=fontebranca12>&nbsp;&nbsp;{$buffer[$x][email]}</td>";
        //echo "<td class=fontebranca12 align=center>";
            print $buffer[$x][receive] ? "<td class=fontebranca12 align=center bgcolor=green>Ativo" : "<td class=fontebranca12 align=center bgcolor=red>Inativo";
        echo "</td>";
        echo "<td class=fontebranca12 align=center>";
            print $buffer[$x][receive] ? "<input style=\"width: 65px;\" type=button value='Desativar' onclick=\"location.href='?action=email&a=0&id={$buffer[$x][id]}'\">" : "<input style=\"width: 65px;\" type=button value='Ativar' onclick=\"location.href='?action=email&a=1&id={$buffer[$x][id]}'\">";
            echo "&nbsp;<input style=\"width: 65px;\" type=button value='Excluir' onclick=\"if(confirm('Tem certeza que deseja excluir este email do banco de dados?','')){location.href='?action=email&a=del&id={$buffer[$x][id]}';}\">";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>
</body>
</html>
