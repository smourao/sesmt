<center><img src="images/main_title.png" border=0></center>
<BR>
<table width=100% height=200 cellspacing=5 cellpadding=0 border=0>
<tr>
    <td width=30% class="text roundborderselected" valign=top id="fsmed">
     <!--<fieldset class="roundborderselected" id="fsmed">-->
         <!--<legend style="font-size: 18px; width: 225px;"><div style="width: 225px;">&nbsp;</div></legend>-->
         <div style="position: relative; top: -16px;left: 10px;"><img src="images/medicina-ico.png" border=0 align=middle></div>
         <ul>
             <li>Aso Avulso</li>
             <li>Aso de Contrato</li>
             <li>Aso sem Complementar</li>
             <li>Prontu�rios</li>
             <li>Or�. Exame Complementar</li>
             <li><a href="?dir=autorizacao_atend&p=index">Autoriza��o de Atendimento</a></li>
         </ul>
     <!--</fieldset>-->
    </td>

    <td width=5% class="text" valign=top>&nbsp;</td>
    
    <td width=30% class="text roundborderselected" valign=top id="fsengseg">
     <div style="position: relative; top: -16px;left: 10px;"><img src="images/engseg-ico.png" border=0 align=middle></div>
         <ul>
             <li>Ata da Cipa</li>
             <li>Cadastro de Treinamento</li>
             <li>Cadastro Geral da Fun��o</li>
             <li><a href="?dir=cgrt&p=index" onclick="alert('Este m�dulo ainda est� em desenvolvimento!');">Cadastro de Relat�rios T�cnicos</a></li>
         </ul>
    </td>

    <td width=5% class="text" valign=top>&nbsp;</td>


    <td width=30% class="text roundborderselected" valign=top id="fsrec">
        <div style="position: relative; top: -16px;left: 10px;"><img src="images/recepcao-ico.png" border=0 align=middle></div>
         <ul>
             <li>Newsletter</li>
             <li>Lista de Fornecedores</li>
             <li><a href="?dir=cont_atendimento&p=index" onclick="alert('Este m�dulo ainda est� em desenvolvimento!');">Controle de Atendimento</a></li>
         </ul>
    </td>
</tr>
</table>
<BR>
<table width=100% height=200 cellspacing=5 cellpadding=0 border=0>
<tr>
    <td width=30% class="text roundborderselected" valign=top id="fscome">
     <div style="position: relative; top: -16px;left: 10px;"><img src="images/comercial-ico.png" border=0 align=middle></div>
         <ul>
             <!--
             <li><a href="?dir=cad_cliente&p=index">Lista de Clientes</a></li>
             <li>Lista do Simulador</li>
             -->
             <li>Lista de Produtos</li>
             <li>Lista de Contadores</li>
             <li>Carta de Vendedores</li>
             <li>Or�amento de Clientes</li>
             <li>Or�amento do Simulador</li>
             <li>Simulador Av. Ambiental</li>
         </ul>
    </td>

    <td width=5% class="text" valign=top>&nbsp;</td>

    <td width=30% class="text roundborderselected" valign=top id="fsrela">
     <div style="position: relative; top: -16px;left: 10px;"><img src="images/relatorios-ico.png" border=0 align=middle></div>
         <ul>
             <li>Ordem de Servi�o</li>
         </ul>
    </td>

    <td width=5% class="text" valign=top>&nbsp;</td>


    <td width=30% class="text roundborderselected" valign=top id="fscadas">
        <div style="position: relative; top: -16px;left: 10px;"><img src="images/cadastros-ico.png" border=0 align=middle></div>
          <ul>
             <li>Cadastro do Simulador</li>
             <li><a href="?dir=cad_cliente&p=index" onclick="alert('Este m�dulo ainda est� em desenvolvimento!');">Cadastro de Clientes</a></li>
             <li>Cadastro de Parceria</li>
             <li>Cadastro de Produtos</li>
             <li>Cadastro de Clinicas</li>
             <li>Cadastro de Fornecedores</li>
         </ul>
    </td>
</tr>
</table>
<BR>
<?PHP
if($_SESSION[grupo] == "administrador"){
?>
<table width=100% height=200 cellspacing=5 cellpadding=0 border=0>
<tr>
    <td width=30% class="text roundborderselected" valign=top id="fsadm">
     <div style="position: relative; top: -16px;left: 10px;"><img src="images/estatisticas-ico.png" border=0 align=middle></div>
         <ul>
             <li>&nbsp;</li>
         </ul>
    </td>

    <td width=5% class="text" valign=top>&nbsp;</td>

    <td width=30% class="text roundborderselected" valign=top id="fsadm">
     <div style="position: relative; top: -16px;left: 10px;"><img src="images/administracao-ico.png" border=0 align=middle></div>
         <ul>
             <li>Cargos</li>
             <li>Usu�rios</li>
             <li>Franquias</li>
             <li>Funcion�rios</li>
             <li>Tipo de Atividade</li>
             <li>Cliente por Bairro</li>
             <li>Consulta de Acessos</li>
             <li>Viabilidade de Localidade</li>
             <li>Administra��o de Contratos</li>
         </ul>
    </td>

    <td width=5% class="text" valign=top>&nbsp;</td>


    <td width=30% class="text roundborderselected" valign=top id="fsadm">
     <div style="position: relative; top: -16px;left: 10px;"><img src="images/financeiro-ico.png" border=0 align=middle></div>
         <ul>
             <li>Resumo de Fatura</li>
             <li>Gerar Nota Fiscal</li>
             <li>Controle Financeiro</li>
             <li>Planilha de Faturas</li>
             <li>Tipo de Identifica��o</li>
             <li>Descri��o de Nota Fiscal</li>
             <li>Controle de Inadimpl�ncia</li>
         </ul>
    </td>
</tr>
</table>
<BR>
<table width=100% height=200 cellspacing=5 cellpadding=0 border=0>
<tr>
    <td width=30% class="text roundborderselected" valign=top id="fsadm">
     <div style="position: relative; top: -16px;left: 10px;"><img src="images/site-admin-ico.png" border=0 align=middle></div>
         <ul>
             <li>Jornal SESMT</li>
             <li>Acesso � Franquia</li>
             <li>Cl�nicas Cadastradas</li>
             <li>Rela��o de Colaboradores</li>
         </ul>
    </td>

    <td width=5% class="text" valign=top>&nbsp;</td>

    <td width=30% class="text roundborderselected" valign=top id="fsadm">
     <div style="position: relative; top: -16px;left: 10px;"><img src="images/edificacao-ico.png" border=0 align=middle></div>
         <ul>
             <li>Setor</li>
             <li>Aparelhos de Medi��o</li>
             <li>Tipo de Edifica��o</li>
             <li>Tipo Ventila��o Natural</li>
             <li>Tipo Ventila��o Artificial</li>
             <li>Tipo Ilumina��o Natural</li>
             <li>Tipo Ilumina��o Artificial</li>
             <li>Caracter�tica da Parede</li>
             <li>Caracter�tica Cobertura</li>
             <li>Caracter�tica do Piso Piso</li>
         </ul>
    </td>

    <td width=5% class="text" valign=top>&nbsp;</td>


    <td width=30% class="text roundborderselected" valign=top id="fsadm">
     <div style="position: relative; top: -16px;left: 10px;"><img src="images/setorial-ico.png" border=0 align=middle></div>
         <ul>
             <li>CNAE</li>
             <li>Tipo Contato</li>
             <li>Munic�pios e DDD</li>
             <li>N�vel de Toler�ncia</li>
             <li>Contato Com o Agente</li>
             <li>Cadastro Geral da Fun��o</li>
             <li>Classifica��o da Atividade</li>
             <li>Ordem de Servi�o Por Fun��o</li>
         </ul>
    </td>
</tr>
</table>
<BR>

<table width=100% height=200 cellspacing=5 cellpadding=0 border=0>
<tr>
    <td width=30% class="text roundborderselected" valign=top id="fsadm">
    <div style="position: relative; top: -16px;left: 10px;"><img src="images/pesquisas-ico.png" border=0 align=middle></div>
         <ul>
             <li>Pesquisa da Cipa</li>
             <li>Pesquisa do SESMT</li>
             <li>Pesquisa da Brigada de Inc�ndio</li>
         </ul>
    </td>

    <td width=5% class="text" valign=top>&nbsp;</td>

    <td width=30% class="text roundborderselected" valign=top id="fsadm">
     <div style="position: relative; top: -16px;left: 10px;"><img src="images/medida-preventiva-ico.png" border=0 align=middle></div>
         <ul>
             <li>Tipo Hidrante</li>
             <li>Tipo Para-Raio</li>
             <li>Demarca��o Solo</li>
             <li>Tipo Instala��o</li>
             <li>Placa Sinaliza��o</li>
             <li>Di�metro Mangueira</li>
             <li>Alarme Contra Inc�ndio</li>
             <li>Tipo Sistema Fixo Contra Inc�ndio</li>
         </ul>
    </td>

    <td width=5% class="text" valign=top>&nbsp;</td>


    <td width=30% class="text roundborderselected" valign=top id="fsadm">&nbsp;
    
    </td>
</tr>
</table>
<?PHP
}
?>
