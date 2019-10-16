function change_pessoa_pc(obj){
    if(obj.value==0){
        is_juridica();
    }else{
        is_fisica();
    }
}

function is_fisica(){
    document.getElementById("txtRazao").innerHTML = "Nome";
    document.getElementById("nome_fantasia").disabled = true;
    document.getElementById("txtCnpj").innerHTML = "CPF";
    document.getElementById("insc_estadual").disabled = true;
    document.getElementById("insc_municipal").disabled = true;
    document.getElementById("cnae_digitado").disabled = true;
    document.getElementById("grupo_cipa").disabled = true;
    document.getElementById("grau_de_risco").disabled = true;
    document.getElementById("desc_atividade").disabled = true;
    document.getElementById("classe").disabled = true;
    document.getElementById("membros_brigada").disabled = true;
    document.getElementById("num_rep").disabled = true;
    document.getElementById("cnpj").onkeypress = function(){
        formatar(document.getElementById("cnpj"), '###.###.###-##');
    }
}

function is_juridica(){
    document.getElementById("txtRazao").innerHTML = "Razão Social";
    document.getElementById("nome_fantasia").disabled = false;
    document.getElementById("txtCnpj").innerHTML = "CNPJ";
    document.getElementById("insc_estadual").disabled = false;
    document.getElementById("insc_municipal").disabled = false;
    document.getElementById("cnae_digitado").disabled = false;
    document.getElementById("grupo_cipa").disabled = false;
    document.getElementById("grau_de_risco").disabled = false;
    document.getElementById("desc_atividade").disabled = false;
    document.getElementById("classe").disabled = false;
    document.getElementById("membros_brigada").disabled = false;
    document.getElementById("num_rep").disabled = false;
    document.getElementById("cnpj").onkeypress = function(){
        formatar(document.getElementById("cnpj"), '##.###.###/####-##');
    }
}
