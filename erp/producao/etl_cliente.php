<?php

include "../config/connect.php";

$sql =  "SELECT 
			descricao_atividade,
			bairro,
			cargo_contato_dir,
			cargo_cont_ind,
			celular,
			cep,
			classe, 
			cnpj,
			0 as cod_cidade,
			0 as cod_cliente,
			0 as cod_cliente_matriz,
			cnae_id,
			0 as cod_contador,
			case when trim(status) =  'ativo' then 1 else 2 end as cod_status, 
			case when associada_id is null then 0 else associada_id end as associada_id,
			case when vendedor_id is null then 0 else vendedor_id end as cod_usuario,
			email,
			email_contato_dir,
			email_cont_ind,
			endereco,
			fax,
			grau_de_risco,
			insc_estadual,
			insc_municipal,
			msn_contato_dir,
			nextel_contato_dir,
			nextel_id_contato_dir,
			nome_cont_ind,
			nome_cont_ind,
			nome_fantasia,
			0 as num_contrato_cliente,
			numero_funcionarios,
			razao_social,
			skype_contato_dir,
			skype_cont_ind,
			tel_contato_dir,
			tel_cont_ind,
			telefone,
			'' as tipo_cliente,
			filial_id,
			ano_contrato
		FROM cliente order by cliente_id";
		

echo $sql . "<p>#################################################<p>";

$resultado = pg_query($sql) or die ("Erro na query de consulta: ".pg_last_error($connect));

$cont = 1;

while($row = pg_fetch_array($resultado))
{

	$sql_insert = "INSERT INTO clientes(
						atividade_cliente,
						bairro_cliente,
						cargo_contato_dir,
						cargo_contato_ind,
						celular_cliente,
						cep_cliente,
						classe,
						cnpj_cliente,
						cod_cidade,
						cod_cliente,
						cod_cliente_matriz,
						cod_cnae,
						cod_contador,
						cod_status,
						cod_unidade,
						cod_usuario,
						email,
						email_contato_dir,
						email_contato_ind,
						endereco_cliente,
						fax_cliente,
						grau_risco_cliente,
						insc_estadual,
						insc_municipal,
						msn_contato_dir,
						nextel_contato_dir,
						nextel_id_contato_dir,
						nome_contato_dir,
						nome_contato_ind,
						nome_fantasia_cliente,
						num_contrato_cliente,
						num_funcionario,
						razao_social_cliente,
						skype_contato_dir,
						skype_contato_ind,
						tel_contato_dir,
						tel_contato_ind,
						telefone_cliente,
						tipo_cliente,
						ano_contrato,
						cod_filial
					)
					values (
						'$row[descricao_atividade]',
						'$row[bairro]' ,
						'$row[cargo_contato_dir]' ,
						'$row[cargo_cont_ind]' ,
						'$row[celular]' ,
						'$row[cep]' ,
						'$row[classe]' ,
						'$row[cnpj]' ,
						$row[cod_cidade] ,
						$cont ,
						$row[cod_cliente_matriz] ,
						$row[cnae_id] ,
						0 ,
						$row[cod_status] ,
						$row[associada_id] ,
						$row[cod_usuario] ,
						'$row[email]' ,
						'$row[email_contato_dir]' ,
						'$row[email_cont_ind]' ,
						'$row[endereco]' ,
						'$row[fax]' ,
						'$row[grau_de_risco]' ,
						'$row[insc_estadual]' ,
						'$row[insc_municipal]' ,
						'$row[msn_contato_dir]' ,
						'$row[nextel_contato_dir]' ,
						'$row[nextel_id_contato_dir]' ,
						'$row[nome_cont_ind]' ,
						'$row[nome_cont_ind]' ,
						'" . str_replace("'"," ",$row[nome_fantasia]) . "',
						'$row[num_contrato_cliente]' ,
						'$row[numero_funcionarios]' ,
						'" . str_replace("'"," ",$row[razao_social]) . "',
						'$row[skype_contato_dir]' ,
						'$row[skype_contato_ind]' ,
						'$row[tel_contato_dir]' ,
						'$row[tel_cont_ind]' ,
						'$row[telefone]' ,
						'$row[tipo_cliente]',
						'$row[ano_contrato]',
						'$row[filial_id]'
					); ";

$sql = str_replace(", ,",", 0,",$sql);

			echo $sql_insert . "<p>";

			$resultado_sql = pg_query($connect, $sql_insert) or die ("*** Erro na query *** : " . pg_last_error($connect));

			$cont++;

}
pg_close($connect);
?>