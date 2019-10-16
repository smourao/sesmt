<?php

include "../config/connect.php";

$query_clientes = " SELECT cliente_id, 
						nome_fantasia,
						cnpj,
						razao_social,
						insc_estadual,
						insc_municipal,
						endereco, 
						bairro,
						cep,
						municipio,
						estado,
						telefone,
						fax,
						celular,
						email, 
						numero_funcionarios, 
						grau_de_risco,
						tel_contato_dir, 
						nome_contato_dir,
						cargo_contato_dir,
						email_contato_dir,
						skype_contato_dir, 
						msn_contato_dir,
						nextel_contato_dir,
						nome_cont_ind, 
						email_cont_ind,
						cargo_cont_ind,
						tel_cont_ind, 
						msn_contador, 
						nextel_id_contato_dir, 
						skype_cont_ind,
						filial_id,
						status,
						classe
					  FROM cliente";

	$result_clientes = pg_query($query_clientes) 
		or die ("Erro na query: $query_clientes".pg_last_error($connect));

	$cont = 0;
		while($row = pg_fetch_array($result_clientes))
		{
			$sql = "INSERT INTO clientes( associada_id
								, bairro
								, cargo_cont_ind, cargo_contato_dir, celular, cep, classe, cliente_id, cnpj, contador_id
								, email, email_cont_ind, email_contato_dir, endereco, estado
								, fax, filial_id
								, grau_de_risco, 
								insc_estadual, insc_municipal
								, msn_contato_dir, municipio
								, nextel_contato_dir, nextel_id_contato_dir, nome_cont_ind, nome_contato_dir, nome_fantasia, numero_funcionarios
								, razao_social
								, skype_cont_ind, skype_contato_dir, status
								, tel_cont_ind, tel_contato_dir, telefone
								, vendedor_id)
						VALUES ($row[associada_id]
								, '$row[bairro]'
								, '$row[cargo_cont_ind]', '$row[cargo_contato_dir]', '$row[celular]', '$row[cep]', '$row[classe]', $row[cliente_id], '$row[cnpj]', $row[contador_id]
								, '$row[email]', '$row[email_cont_ind]', '$row[email_contato_dir]', '$row[endereco]', '$row[estado]'
								, '$row[fax]', $row[filial_id]
								, '$row[grau_de_risco]'
								, '$row[insc_estadual]', '$row[insc_municipal]'
								, '$row[msn_contato_dir]', '$row[municipio]'
								, '$row[nextel_contato_dir]', '$row[nextel_id_contato_dir]', '$row[nome_cont_ind]', '$row[nome_contato_dir]', '$row[nome_fantasia]', '$row[numero_funcionarios]'
								, '$row[razao_social]'
								, '$row[skype_cont_ind]', '$row[skype_contato_dir]', '$row[status]'
								, '$row[tel_cont_ind]', '$row[tel_contato_dir]', '$row[telefone]' ";
				
				if($row[vendedor_id]!="") {
					$sql = $sql . ", $row[vendedor_id])";
				} else{
					$sql = $sql . ", 0)";
				}

			echo strtoupper($sql) . "<p>";
/*
			$result_sql = pg_query(strtoupper($sql)) 
				or die ("Erro na query: ".pg_last_error($connect));

			if($result_sql) {
				echo "Funcionou! " . $cont ;
				$cont = $cont+1;
			}
*/			
			$result_sql = "";
			$sql = "";
		}

pg_close($connect);
?>