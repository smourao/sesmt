<?php
session_start();
ob_start();
include "../sessao.php";
include "../config/connect.php";
$uploadErrors = array(
    UPLOAD_ERR_OK => 'There is no error, the file uploaded with success.',
    UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
    UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
    UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
    UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
    UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
    UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
    UPLOAD_ERR_EXTENSION => 'File upload stopped by extension.',
);
$errorCode = $_FILES['uploadedfile']['error'];

//print_r($_FILES['uploadedfile']);
//echo $_FILES['uploadedfile'];
//echo "pqp";
//print_r($_POST);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Administração Jornal SESMT</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<br>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" class="fontebranca12">
    <div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>
    <div align="center"></div>      <div align="center"></div>      <div align="center"></div></td>
  </tr>
  <tr>
    <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12">
    <div align="center" class="fontepreta14bold"><font color="#000000">Upload de Imagem</font></div></td>
  </tr>
  <tr>
    <td colspan="4" class="fontebranca12"><br>
      <table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td class="fontebranca12" colspan=3>
            <?php
            
            if($_POST){
                //echo $uploadedfile_type;
                if($uploadedfile_type == 'image/pjpeg' || $uploadedfile_type == 'image/gif' ||
                $uploadedfile_type == 'image/jpeg' || $uploadedfile_type == 'image/jpg' ||
                $uploadedfile_type == 'image/pjpg'){
                
                echo "<center>Não feche esta janela, ela se fechará automaticamente quando o envio do arquivo for concluído!<p>";
                $temp = rand();
                $filename = $temp."_".basename($_FILES['uploadedfile']['name']);

                $path = "images/uploaded/";//"images/funcionarios/upload/";/*getcwd().*/
                $target_path = $path . $filename;

                if(file_exists($target_path)){
                    $temp = rand();
                    $filename = $_SESSION['cod_cliente']."_".$_SESSION['cod_filial']."_".$temp."_".basename( $_FILES['uploadedfile']['name']);
                    $target_path = $path . $filename;
                }

                //SE ARQUIVO FOI UPLOADEADO
                if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
                    echo "O arquivo foi enviado com sucesso!";
                    echo "<script>
                    //alert('{$target_path}');
                    var n = window.name;
                    window.opener.addImage3('$_GET[rte]', 'http://www.sesmt-rio.com/erp/adm/$target_path');
                    window.close();
                    </script>";
                }else{
                    echo "Houve um erro ao enviar o arquivo para o servidor, por favor tente novamente!<p>";
                    echo "<input value='Voltar' type=button class=button onclick='javascript:history.back(-1);'>";
                    echo "<br>";
                    if($errorCode !== UPLOAD_ERR_OK && isset($uploadErrors[$errorCode]))
                    {
                        //echo "código de erro: ".$uploadErrors[$errorCode];
                    }
                }
                }else{
                    echo "Houve um erro ao enviar o arquivo para o servidor, por favor tente novamente!<p>";
                    echo "<font size=1>código de erro: 104 - Formato de arquivo inválido($uploadedfile_type).</font><p>";
                    echo "<center><input value='Voltar' type=button class=button onclick='javascript:history.back(-1);'>";
                    echo "<br>";
                }
            
            }else{
                echo "<form enctype=\"multipart/form-data\" name=\"add\" id=\"add\" method=\"post\">";
                echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"1073741824\" /><!-- 1MB --><br>";
                echo "<input name=\"uploadedfile\" id=\"uploadedfile\" type=\"file\"/><br>";
                echo "<font size=1>Extensões suportadas: JPG ou GIF</font>";
                echo "<p align=justify>";
                echo "<div id=msg></div>";
                echo "<p>";
                echo "<input type=submit class=button value=\"Enviar\" onclick=\"document.getElementById('msg').innerHTML = '<font size=1><b><center>Aguarde, enviando a imagem...</center></b><i><p align=left>- Ao finalizar o envio, esta janela será fechada automaticamente.<br>- O tempo de envio varia de acordo com o tamanho do arquivo.</i></font>';\">";
                echo "</form>";
            }
            
            if($ok){
                echo "<script>";
                echo "alert(window.name);";
                echo "var n = window.name;";
                echo "window.opener.addImage('$_GET[rte]');";
                echo "</script>";
            }
            ?>
        </td>
      </tr>
    </table>
</body>
</html>
