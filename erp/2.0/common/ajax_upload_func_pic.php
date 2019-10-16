<?PHP
session_start();
ob_start();
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
//print_r($_SESSION);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: SESMT - Segurança do Trabalho e Medicina Ocupacional::</title>
</head>
<center><b>RELAÇÃO DE COLABORADORES</b></center>
<br>
<?PHP
//SE ENVIAR

if($_POST){
//echo $uploadedfile_type;
if($uploadedfile_type == 'image/pjpeg' || $uploadedfile_type == 'image/gif' || $uploadedfile_type == 'image/jpeg' || $uploadedfile_type == 'image/jpg' || $uploadedfile_type == 'image/pjpg'){
echo "<center>Não feche esta janela, ela se fechará automaticamente quando o envio do arquivo for concluído!<p>";
            $temp = rand();
            $filename = $_SESSION['usuario_id']."_".$temp."_".basename( $_FILES['uploadedfile']['name']);
            $path = /*getcwd().*/"../images/funcionario/";
            $target_path = $path . $filename;


            if(file_exists($target_path)){
               $temp = rand();
               $filename = $_SESSION['usuario_id']."_".$temp."_".basename( $_FILES['uploadedfile']['name']);
               $target_path = $path . $filename;
            }
            
            if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
                echo "O arquivo foi enviado com sucesso!";

echo"
<script>
window.close();
window.opener.document.getElementById(\"pic\").value = \"images/funcionario/{$filename}\";
window.opener.document.getElementById(\"foto\").innerHTML = \"<img src='images/funcionario/{$filename}' border=0 width=100 height=120>\";
</script>";
                
            }else{
                echo "Houve um erro ao enviar o arquivo para o servidor, por favor tente novamente!<p>";
                
                echo "<input value='Voltar' type=button class=button onclick='javascript:history.back(-1);'>";
                
                echo "<br>";

                if($errorCode !== UPLOAD_ERR_OK && isset($uploadErrors[$errorCode]))
                {
                    echo "código de erro: ".$uploadErrors[$errorCode];
                }
            }

}else{
               echo "Houve um erro ao enviar o arquivo para o servidor, por favor tente novamente!<p>";
               
               echo "<font size=1>código de erro: 104 - Formato de arquivo inválido($uploadedfile_type).</font><p>";

                echo "<center><input value='Voltar' type=button class=button onclick='javascript:history.back(-1);'>";

                echo "<br>";


}
}else{
?>
<center>Selecione uma foto e clique em enviar para adicioná-la ao
cadastro de seu colaborador.
<form enctype="multipart/form-data" name="add" id="add" method="post" action="ajax_upload_func_pic.php?a=2">
<input type="hidden" name="MAX_FILE_SIZE" value="1073741824" /><!-- 1MB --><br>
<input name="uploadedfile" id="uploadedfile" type="file" class=button /><br>
<font size=1>Extensões suportadas: JPG ou GIF</font>
<p align=justify>
<div id=msg></div>
<p>
<input type=submit class=button value="Enviar" class=button onclick="document.getElementById('msg').innerHTML = '<font size=1><b><center>Aguarde, enviando a imagem...</center></b><i><p align=left>- Ao finalizar o envio, esta janela será fechada automaticamente.<br>- O tempo de envio varia de acordo com o tamanho do arquivo.</i></font>';">
</form>
<?PHP
}
?>