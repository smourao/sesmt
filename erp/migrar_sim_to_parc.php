<?php
session_start();
include "sessao.php";
include "./config/connect.php";
include "functions.php";

$cod_cliente = (int)($_GET[cod_cliente]);
$sql = "SELECT * FROM cliente_comercial WHERE cliente_id = $cod_cliente";
$sim = pg_fetch_array(pg_query($sql));
//echo "Migrar: ".$sim[razao_social]."<BR>";

$sql = "SELECT * FROM cliente_pc WHERE contratante = 1 ORDER BY razao_social";
$rpc = pg_query($sql);
$lpc = pg_fetch_all($rpc);


//drawlable part
echo '<head>';
echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />';
echo '<meta http-equiv="cache-control"   content="no-cache" />';
echo '<meta http-equiv="pragma" content="no-cache" />';
echo '<meta http-equiv="expires" content = "-1" />';

echo '<title>::Sistema SESMT - Cadastro de Cliente - Simulador::</title>';
echo '<link href="css_js/css.css" rel="stylesheet" type="text/css">';
echo '</head>';

echo '<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" tracingsrc="img/Sistema sesmt 3  (2).png" tracingopacity="0">';

echo '<table width="90%" border="0" cellpadding="0" align="center">';
echo '<tr>';
echo '<td class="fontebranca22bold"><div align="center">Simulador -> Parceiro</div></td>';
echo '</tr>';
echo '</table>';

echo "<p>";

//echo "<center><span class='fontebranca12'>Selecione o parceiro contratante abaixo:</span></center>";

echo "<form method='post'>";

echo "<table width='90%' align=center border=0>";

echo "<tr>";
echo "<td align=left width=120><font color=white><b>Empresa:</b></font><td>";
echo "<td align=left><font color=white size=2><b>$sim[razao_social]</b></font></td>";
echo "</tr>";

echo "<tr>";
echo "<td align=left width=120><font color=white><b>Contratante:</b></font><td>";
echo "<td align=left>";
    echo "<select name='cod_cotratante'>";
    for($x=0;$x<pg_num_rows($rpc);$x++){
        echo "<option value='{$lpc[$x][id]}'>{$lpc[$x][razao_social]}</option>";
    }
    echo "</select>";
echo "</td>";
echo "</tr>";
echo "</table>";


echo "<p><center>";
echo "<input type=submit name='sendFrm' value='Migrar'>";
echo "</form>";



//Se já estiver no cadastro UPDATE senão INSERT
if($_POST){
    $sql = "SELECT * FROM cliente_pc WHERE id = ".(int)($_POST[cod_cotratante])."";
    $cont = pg_fetch_array(pg_query($sql));
    
    //verifica se já foi migrado o parceiro pelo cnpj
    $tcnpj = str_replace('-', '', $sim[cnpj]);
    $tcnpj = str_replace('/', '', $tcnpj);
    $tcnpj = str_replace('.', '', $tcnpj);
    $sql = "
    SELECT
        *
    FROM
        cliente_pc
    WHERE
        replace(replace(replace(cnpj,'-',''), '/',''), '.', '') = '{$tcnpj}'
    ";
    $rt = pg_query($sql);
    $bt = pg_fetch_array($rt);

    if(pg_num_rows($rt)>0){
        $sql = "UPDATE cliente_pc SET
        razao_social = '$sim[razao_social]',
        nome_fantasia = '$sim[nome_fantasia]',
        endereco = '$sim[endereco]',
        bairro = '$sim[bairro]',
        cep = '$sim[cep]',
        municipio = '$sim[municipio]',
        estado = '$sim[estado]',
        telefone = '$sim[telefone]',
        fax = '$sim[fax]',
        celular = '$sim[celular]',
        email = '$sim[email]',
        insc_estadual = '$sim[insc_estadual]',
        insc_municipal = '$sim[insc_municipal]',
        cnae_id = $sim[cnae_id],
        descricao_atividade = '$sim[desc_atividade]',
        numero_funcionarios = '$sim[numero_funcionarios]',
        grau_de_risco = '$sim[grau_de_risco]',
        nome_contato_dir = '$sim[nome_contato_dir]',
        cargo_contato_dir = '$sim[cargo_contato_dir]',
        tel_contato_dir = '$sim[tel_contato_dir]',
        email_contato_dir = '$sim[email_contato_dir]',
        skype_contato_dir = '$sim[skype_contato_dir]',
        msn_contato_dir = '$sim[msn_contato_dir]',
        nextel_contato_dir = '$sim[nextel_contato_dir]',
        nextel_id_contato_dir = '$sim[nextel_id_contato_dir]',
        nome_cont_ind  = '$sim[nome_cont_ind]',
        cargo_cont_ind = '$sim[cargo_cont_ind]',
        email_cont_ind = '$sim[email_cont_ind]',
        skype_cont_ind = '$sim[skype_cont_ind]',
        tel_cont_ind = '$sim[tel_cont_ind]',
        escritorio_contador = '$sim[escritorio_contador]',
        tel_contador = '$sim[tel_contador]',
        msn_contador = '$sim[msn_contador]',
        skype_contador = '$sim[skype_contador]',
        nome_contador = '$sim[nome_contador]',
        email_contador = '$sim[email_contador]',
        status = '$sim[status]',
        classe = '$sim[classe]',
        num_end = '$sim[num_end]',
        num_rep = '$sim[num_rep]',
        membros_brigada = '$sim[membros_brigada]'
        WHERE
        id = {$bt[id]}
        ";
        if(pg_query($sql)){
            //echo "Query executada, cliente atualizado para o cadastro.";
            echo "<script>
            alert('Cadastro de parceria atualizado!');
            location.href='simulador_cadastro_cliente.php?cliente_id=$cod_cliente&filial_id=$sim[filial_id]';
            </script>";
        }else{
            //echo "Erro ao executar query... PQP!";
            echo "<script>
            alert('Erro ao atualizar cadastro de parceria!');
            </script>";
        }
    }else{
        //echo "<BR>--> Novo cadastro em parceiro";
        $sql = "SELECT MAX(cliente_id) as max FROM cliente_pc WHERE cnpj_contratante = '$cont[cnpj]'";
        $maxcid = pg_fetch_array(pg_query($sql));
        $maxcid = (int)($maxcid[max]+1);
        
        $sql = "INSERT INTO cliente_pc
        ( cliente_id, filial_id, razao_social, nome_fantasia, endereco,
        bairro, cep, municipio, estado, telefone,
        fax, celular, email, cnpj, cnpj_contratante,
        insc_estadual, insc_municipal, cnae_id,
        descricao_atividade, numero_funcionarios, grau_de_risco,
        nome_contato_dir, cargo_contato_dir, tel_contato_dir,
        email_contato_dir, skype_contato_dir, msn_contato_dir, nextel_contato_dir,
        nextel_id_contato_dir, nome_cont_ind,
        cargo_cont_ind, email_cont_ind, skype_cont_ind,
        tel_cont_ind, escritorio_contador, tel_contador,
        msn_contador, skype_contador, nome_contador,
        email_contador, status, classe,  num_end, num_rep,
        membros_brigada, ano_contrato, contratante) values
        ( $maxcid, 001, '$sim[razao_social]', '$sim[nome_fantasia]', '$sim[endereco]',
        '$sim[bairro]', '$sim[cep]', '$sim[municipio]', '$sim[estado]', '$sim[telefone]',
        '$sim[fax]', '$sim[celular]', '$sim[email]', '$sim[cnpj]', '$cont[cnpj]',
        '$sim[insc_estadual]', '$sim[insc_municipal]', $sim[cnae_id],
        '$sim[desc_atividade]', '$sim[numero_funcionarios]', '$sim[grau_de_risco]',
        '$sim[nome_contato_dir]', '$sim[cargo_contato_dir]', '$sim[tel_contato_dir]',
        '$sim[email_contato_dir]', '$sim[skype_contato_dir]', '$sim[msn_contato_dir]',
        '$sim[nextel_contato_dir]', '$sim[nextel_id_contato_dir]', '$sim[nome_cont_ind]',
        '$sim[cargo_cont_ind]', '$sim[email_cont_ind]', '$sim[skype_cont_ind]',
        '$sim[tel_cont_ind]', '$sim[escritorio_contador]', '$sim[tel_contador]',
        '$sim[msn_contador]', '$sim[skype_contador]', '$sim[nome_contador]',
        '$sim[email_contador]', 'Ativo', '$sim[classe]', '$sim[num_end]', '$sim[num_rep]',
        '$sim[membros_brigada]', '".date("Y")."/".($cont[ano_contrato])."', 0)";
        //echo "<p>";
        //echo $sql;
        //echo "<p>";
        if(pg_query($sql)){
            //echo "Query executada, cliente migrado para o cadastro.";
            echo "<script>
            alert('Cliente migrado para o cadastro de parceria!');
            location.href='simulador_cadastro_cliente.php?cliente_id=$cod_cliente&filial_id=$sim[filial_id]';
            </script>";
        }else{
            //echo "Erro ao executar query... PQP!";
            echo "<script>alert('Erro ao migrar cliente para o cadastro de parceria!');</script>";
        }
    }
}


?>
