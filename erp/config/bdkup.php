<?php

if($_SERVER['REMOTE_ADDR'] == "127.0.0.1"){

ob_start();

ini_set('output_buffering', '4096');
ini_set('error_reporting', NO);

// dados de conexуo com o banco de dados a ser backupeado
$server = "postgresql02.sesmt-rio.com;
$usuario = "sesmt-rio";
$senha = "diggio3001";
$dbname = "sesmt-rio";

// conectando ao banco
mysql_connect($server,$usuario,$senha) or die(mysql_error());
mysql_select_db($dbname) or die(mysql_error());

// gerando um arquivo sql. Como?
// a funчуo fopen, abre um arquivo, que no meu caso, serс chamado como: nomedobanco.sql
// note que eu estou concatenando dinamicamente o nome do banco com a extensуo .sql.
$back = fopen($dbname.".sql","w");

// aqui, listo todas as tabelas daquele banco selecionado acima
$res = mysql_list_tables($dbname) or die(mysql_error()); 

// resgato cada uma das tabelas, num loop
while ($row = mysql_fetch_row($res)) {
$table = $row[0];
// usando a funчуo SHOW CREATE TABLE do mysql, exibo as funчѕes de criaчуo da tabela,
// exportando tambщm isso, para nosso arquivo de backup
$res2 = mysql_query("SHOW CREATE TABLE $table");
// digo que o comando acima deve ser feito em cada uma das tabelas
while ( $lin = mysql_fetch_row($res2)){
// instruчѕes que serуo gravadas no arquivo de backup
fwrite($back,"DROP TABLE IF EXISTS $table;");
fwrite($back,"$row[1]\n\n");
fwrite($back,"\n#\n# Criaчуo da Tabela : $table\n#\n\n");
fwrite($back,"$lin[1] ;\n\n#\n# Dados a serem incluэdos na tabela\n#\n\n");

// seleciono todos os dados de cada tabela pega no while acima
// e depois gravo no arquivo .sql, usando comandos de insert
$res3 = mysql_query("SELECT * FROM $table");
while($r=mysql_fetch_row($res3)){
$sql="INSERT INTO `$table`  VALUES (";

// este laчo irс executar os comandos acima, gerando o arquivo ao final,
// na funчуo fwrite (gravar um arquivo)
// este laчo tambщm irс substituir as aspas duplas, simples e campos vazios
// por aspas simples, colocando espaчos e quebras de linha ao final de cada registro, etc
// deixando o arquivo pronto para ser importado em outro banco
for($j=0; $j<mysql_num_fields($res3);$j++)
{       if (is_numeric($r[$j])){
$sql .="".addslashes($r[$j]).",";// se o valor щ numщrico, fica sem aspas simples...
}else{
$sql .="'".addslashes($r[$j])."',";// se o valor nуo щ numщrico, ele fica entre aspas simples...
}}
$sql = ereg_replace(",$", "", $sql);
$sql .=");\n";

fwrite($back,$sql);
}
}
}

// fechar o arquivo que foi gravado
fclose($back);
// gerando o arquivo para download, com o nome do banco e extensуo sql.
$arquivo = $dbname.".sql";
header("Content-type: application/sql");
header("Content-Disposition: attachment; filename=$arquivo");
// lъ e exibe o conteњdo do arquivo gerado
readfile($arquivo);
}else{
        echo $_SERVER['REMOTE_ADDR']."<br><br>permissao negada";
}
?>