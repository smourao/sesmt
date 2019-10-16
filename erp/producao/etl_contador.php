<?php

include "../config/connect.php";

$sql =  "SELECT  distinct escritorio_contador
			, tel_contador
			, email_contador
			, skype_contador
			, nome_contador
			, msn_contador
		FROM cliente
		where trim(nome_contador) is not null
			and trim(nome_contador) <> ''
			and trim(tel_contador) is not null";
		

echo $sql . "<p>#################################################<p>";

$resultado = pg_query($sql) or die ("Erro na query de consulta: ".pg_last_error($connect));

$cont = 1;

while($row = pg_fetch_array($resultado))
{

	$sql_insert = "INSERT INTO contador(
						  cod_contador
						, tel_contador
						, email_contador
						, skype_contador
						, nome_contador
						, msn_contador
						, escritorio_contador
						, crc_contador
						, endereco_contador
						, bairro_contador
						, fax_contador
						, cod_cidade
						, cep_contador 
					)
					values (
						 $cont
						, '$row[tel_contador]'
						, '$row[email_contador]'
						, '$row[skype_contador]'
						, '$row[nome_contador]'
						, '$row[msn_contador]'
						, '$row[escritorio_contador]'
						, '$row[crc_contador]'
						, '$row[endereco_contador]'
						, '$row[bairro_contador]'
						, '$row[fax_contador]'
						, 0
						, '$row[cep_contador]'
					); ";

			echo $sql_insert . "<p>";

			$resultado_sql = pg_query($connect, $sql_insert) or die ("*** Erro na query *** : " . pg_last_error($connect));

			$cont++;
}
pg_close($connect);
?>