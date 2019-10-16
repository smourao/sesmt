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
             <li>Prontuários</li>
             <li>Orç. Exame Complementar</li>
             <li><a href="?dir=autorizacao_atend&p=index">Autorização de Atendimento</a></li>
         </ul>
     <!--</fieldset>-->
    </td>

    <td width=5% class="text" valign=top>&nbsp;</td>
    
    <td width=30% class="text roundborderselected" valign=top id="fsengseg">
     <div style="position: relative; top: -16px;left: 10px;"><img src="images/engseg-ico.png" border=0 align=middle></div>
         <ul>
             <li>Ata da Cipa</li>
             <li>Cadastro de Treinamento</li>
             <li>Cadastro Geral da Função</li>
             <li><a href="?dir=cgrt&p=index" onclick="alert('Este módulo ainda está em desenvolvimento!');">Cadastro de Relatórios Técnicos</a></li>
         </ul>
    </td>

    <td width=5% class="text" valign=top>&nbsp;</td>


    <td width=30% class="text roundborderselected" valign=top id="fsrec">
        <div style="position: relative; top: -16px;left: 10px;"><img src="images/recepcao-ico.png" border=0 align=middle></div>
         <ul>
             <li>Newsletter</li>
             <li>Lista de Fornecedores</li>
             <li><a href="?dir=cont_atendimento&p=index" onclick="alert('Este módulo ainda está em desenvolvimento!');">Controle de Atendimento</a></li>
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
             <li>Orçamento de Clientes</li>
             <li>Orçamento do Simulador</li>
             <li>Simulador Av. Ambiental</li>
         </ul>
    </td>

    <td width=5% class="text" valign=top>&nbsp;</td>

    <td width=30% class="text roundborderselected" valign=top id="fsrela">
     <div style="position: relative; top: -16px;left: 10px;"><img src="images/relatorios-ico.png" border=0 align=middle></div>
         <ul>
             <li>Ordem de Serviço</li>
         </ul>
    </td>

    <td width=5% class="text" valign=top>&nbsp;</td>


    <td width=30% class="text roundborderselected" valign=top id="fscadas">
        <div style="position: relative; top: -16px;left: 10px;"><img src="images/cadastros-ico.png" border=0 align=middle></div>
          <ul>
             <li>Cadastro do Simulador</li>
             <li><a href="?dir=cad_cliente&p=index" onclick="alert('Este módulo ainda está em desenvolvimento!');">Cadastro de Clientes</a></li>
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
             <li>Usuários</li>
             <li>Franquias</li>
             <li>Funcionários</li>
             <li>Tipo de Atividade</li>
             <li>Cliente por Bairro</li>
             <li>Consulta de Acessos</li>
             <li>Viabilidade de Localidade</li>
             <li>Administração de Contratos</li>
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
             <li>Tipo de Identificação</li>
             <li>Descrição de Nota Fiscal</li>
             <li>Controle de Inadimplência</li>
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
             <li>Acesso à Franquia</li>
             <li>Clínicas Cadastradas</li>
             <li>Relação de Colaboradores</li>
         </ul>
    </td>

    <td width=5% class="text" valign=top>&nbsp;</td>

    <td width=30% class="text roundborderselected" valign=top id="fsadm">
     <div style="position: relative; top: -16px;left: 10px;"><img src="images/edificacao-ico.png" border=0 align=middle></div>
         <ul>
             <li>Setor</li>
             <li>Aparelhos de Medição</li>
             <li>Tipo de Edificação</li>
             <li>Tipo Ventilação Natural</li>
             <li>Tipo Ventilação Artificial</li>
             <li>Tipo Iluminação Natural</li>
             <li>Tipo Iluminação Artificial</li>
             <li>Caracterítica da Parede</li>
             <li>Caracterítica Cobertura</li>
             <li>Caracterítica do Piso Piso</li>
         </ul>
    </td>

    <td width=5% class="text" valign=top>&nbsp;</td>


    <td width=30% class="text roundborderselected" valign=top id="fsadm">
     <div style="position: relative; top: -16px;left: 10px;"><img src="images/setorial-ico.png" border=0 align=middle></div>
         <ul>
             <li>CNAE</li>
             <li>Tipo Contato</li>
             <li>Municípios e DDD</li>
             <li>Nível de Tolerância</li>
             <li>Contato Com o Agente</li>
             <li>Cadastro Geral da Função</li>
             <li>Classificação da Atividade</li>
             <li>Ordem de Serviço Por Função</li>
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
             <li>Pesquisa da Brigada de Incêndio</li>
         </ul>
    </td>

    <td width=5% class="text" valign=top>&nbsp;</td>

    <td width=30% class="text roundborderselected" valign=top id="fsadm">
     <div style="position: relative; top: -16px;left: 10px;"><img src="images/medida-preventiva-ico.png" border=0 align=middle></div>
         <ul>
             <li>Tipo Hidrante</li>
             <li>Tipo Para-Raio</li>
             <li>Demarcação Solo</li>
             <li>Tipo Instalação</li>
             <li>Placa Sinalização</li>
             <li>Diâmetro Mangueira</li>
             <li>Alarme Contra Incêndio</li>
             <li>Tipo Sistema Fixo Contra Incêndio</li>
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
