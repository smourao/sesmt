<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<?php
$host="postgresql02.sesmt-rio.com";
$user="sesmt_rio";
$pass="diggio3001";
$db="sesmt_rio";
$connect = pg_connect("host=$host dbname=$db user=$user password=$pass");

if($_GET[usb]){
$comercial = "select * from cliente_pc where cnpj NOT IN (SELECT cnpj FROM cliente)";
$comer = pg_query($comercial);
$cc = pg_fetch_all($comer);
//echo "oi".$comercial;
for($x=0;$x<pg_num_rows($comer);$x++){

	$mais = "select max(cliente_id) as cliente_id from cliente";
	$mm = pg_query($mais);
	$m = pg_fetch_array($mm);
	$cliente_id = $m[cliente_id] + 1;
//echo "aqui".$m[cliente_id];
	$cli = "INSERT INTO cliente
	(razao_social, nome_fantasia, endereco, bairro, cep, municipio, estado, telefone, fax, celular, email, cnpj, insc_estadual, insc_municipal,
	descricao_atividade, numero_funcionarios, grau_de_risco, vendedor_id, cnae_id, cliente_id, tel_contato_dir, nome_contato_dir, cargo_contato_dir,
	email_contato_dir, skype_contato_dir, msn_contato_dir, nextel_contato_dir, escritorio_contador, tel_contador, email_contador, skype_contador,
	nome_contador, nome_cont_ind, email_cont_ind, cargo_cont_ind, tel_cont_ind, msn_contador, nextel_id_contato_dir, skype_cont_ind, filial_id,
	status, classe, ano_contrato, cod_orcamento, num_end, membros_brigada, cnpj_contratante, contratante, showsite, cliente_ativo, nextel_contador,
	nextel_id_contador, old_funcnum, tmp_tag, data, data_envio, relatorio_de_atendimento, crc_contador)
	VALUES
	('{$cc[$x][razao_social]}', '{$cc[$x][nome_fantasia]}', '{$cc[$x][endereco]}', '{$cc[$x][bairro]}', '{$cc[$x][cep]}', '{$cc[$x][municipio]}', '{$cc[$x][estado]}', '{$cc[$x][telefone]}', '{$cc[$x][fax]}',
	'{$cc[$x][celular]}', '{$cc[$x][email]}', '{$cc[$x][cnpj]}', '{$cc[$x][insc_estadual]}', '{$cc[$x][insc_municipal]}', '{$cc[$x][descricao_atividade]}', '{$cc[$x][numero_funcionarios]}', '{$cc[$x][grau_de_risco]}',
	{$cc[$x][vendedor_id]}, {$cc[$x][cnae_id]}, {$cliente_id}, '{$cc[$x][tel_contato_dir]}', '{$cc[$x][nome_contato_dir]}', '{$cc[$x][cargo_contato_dir]}', '{$cc[$x][email_contato_dir]}',
	'{$cc[$x][skype_contato_dir]}', '{$cc[$x][msn_contato_dir]}', '{$cc[$x][nextel_contato_dir]}', '{$cc[$x][escritorio_contador]}', '{$cc[$x][tel_contador]}', '{$cc[$x][email_contador]}', '{$cc[$x][skype_contador]}',
	'{$cc[$x][nome_contador]}', '{$cc[$x][nome_cont_ind]}', '{$cc[$x][email_cont_ind]}', '{$cc[$x][cargo_cont_ind]}', '{$cc[$x][tel_cont_ind]}', '{$cc[$x][msn_contador]}', '{$cc[$x][nextel_id_contato_ind]}',
	'{$cc[$x][skype_cont_ind]}', {$cc[$x][filial_id]}, '{$cc[$x][status]}', '{$cc[$x][classe]}', '{$cc[$x][ano_contrato]}', 0, '{$cc[$x][num_end]}', '{$cc[$x][membros_brigada]}', '{$cc[$x][cnpj_contratante]}',
	{$cc[$x][contratante]}, 0, 0, '{$cc[$x][nextel_contador]}', '{$cc[$x][nextel_id_contador]}', 0, 0, '{$cc[$x][data]}', '{$cc[$x][data_envio]}', '{$cc[$x][relatorio_de_atendimento]}', '{$cc[$x][crc_contador]}')";
	pg_query($cli);
echo ">>>>".$cli;
}
}

?>
</body>
</html>
