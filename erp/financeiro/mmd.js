function show_comp(info){
//onMouseOver=\"return overlib('Clique para ver detalhes.');\" onMouseOut=\"return nd();\"
   var ar = info.split("§");
   var text = "";
   var temp;
   var desc = "";
   var status = "";
   var concluido = "";
   
   text += "<table border=1 width=100%>";
   text += "<tr>";
   text += "<td width=50 align=center><b>Horário</b></td><td align=center><b>Assunto</b></td><td width=150 align=center><b>Ações</b></td>";
   text += "</tr>";
      for(var i = 0;i < ar.length-1;i++){
          temp = ar[i].split("|");
          desc = "";
          desc += "<center><font size=2>"+temp[3]+"</font></center>";
          desc += "<p>";
          desc += "Data: "+temp[0];
          desc += "<BR>";
          desc += "Horário: "+temp[1];
          desc += "<BR>";
          desc += "Duração: "+temp[2];
          desc += "<BR>";
          desc += "Local: "+temp[4];
          desc += "<BR>";
          desc += "<HR>";
          desc += "<center><font size=2>Observações / Descrição</font></center>";
          desc += "<BR>";
          desc += temp[5];
          
          text += "<tr>";
          text += "<td>"+temp[1]+"</td>";
          
          /*
          if(temp[7] == 1){
              text += "<td onMouseOver=\"return overlib('"+desc+"');\" onMouseOut=\"return nd();\" style='font-style:italic;color:#008000;'>"+temp[3]+" [Concluído]</td>";
              concluido = "<a href='?pen="+temp[6]+"' class=concluido>Pendente</a>";
          }else if(temp[8] == 0){
              text += "<td onMouseOver=\"return overlib('"+desc+"');\" onMouseOut=\"return nd();\" style='font-style:italic;color:#767676;'>"+temp[3]+" [Cancelado]</td>";
              status = "<a href='?ati="+temp[6]+"' class=excluir>Ativar</a>";
   //           text += "<td align=center><a href='?del="+temp[6]+"' class=excluir>Cancelar</a> | <a href='?con="+temp[6]+"' class=concluido>Concluído</a></td>";
          }else{
              concluido = "<a href='?con="+temp[6]+"' class=concluido>Concluído</a>";
              status = "<a href='?del="+temp[6]+"' class=excluir>Desativar</a>";
              text += "<td onMouseOver=\"return overlib('"+desc+"');\" onMouseOut=\"return nd();\">"+temp[3]+"</td>";
              //text += "<td align=center><a href='?del="+temp[6]+"' class=excluir>Cancelar</a> | <a href='?con="+temp[6]+"' class=concluido>Concluído</a></td>";
          }
          */

          if(temp[8] == 0){ //inativo
              status = "<a href='?ati="+temp[6]+"' class=excluir>Ativar</a> | <a href='?con="+temp[6]+"' class=concluido>Concluído</a>";
              text += "<td onMouseOver=\"return overlib('"+desc+"');\" onMouseOut=\"return nd();\" style='font-style:italic;color:#767676;'>"+temp[3]+" [Desativado]</td>";
          }else if(temp[8] == 1){ //normal
              status = "<a href='?del="+temp[6]+"' class=excluir>Desativar</a> | <a href='?con="+temp[6]+"' class=concluido>Concluído</a>";
              text += "<td onMouseOver=\"return overlib('"+desc+"');\" onMouseOut=\"return nd();\">"+temp[3]+" [Pendente]</td>";
          }else if(temp[8] == 2){//concluído
              status = "<a href='?del="+temp[6]+"' class=excluir>Desativar</a> | <a href='?pen="+temp[6]+"' class=concluido>Agendado</a>";
              text += "<td onMouseOver=\"return overlib('"+desc+"');\" onMouseOut=\"return nd();\" style='font-style:italic;color:#008000;'>"+temp[3]+" [Concluído]</td>";
          }

          text += "<td align=center>"+status+"</td>";

                   text += "</tr>";

          //text += "<font color=white>" + (i+1) + "</font> - ";
          //text += "Assunto: " + temp[3];
          //text += temp[5] + ": " + temp[2];
          //text += "<br>";
      }
   text += "</table>";
   //var today = ar[0].split("|");
   //alert(today[0]);
    //alert(text+" - ");
    document.getElementById("compromisso").innerHTML = text;

}


function check_mmd_add(){
//alert('ok');
    if(document.getElementById("valor").value==""){
        return false;
    }else if(document.getElementById("parcelas").value==""){
        return false;
    }else if(document.getElementById("dia").value==""){
       return false;
    }else if(document.getElementById("mes").value==""){
       return false;
    }else if(document.getElementById("ano").value==""){
       return false;
    }else{
       return true;
    }
}

/*********************************************************************************/
// FUNÇÕES - AJAX
/*********************************************************************************/
function search_by_date(){
   if(document.getElementById("dia_i").value != "" && document.getElementById("mes_i").value != "" && document.getElementById("ano_i").value != ""){

   }else{
      alert('Por favor, informe a data inicial para a pesquisa!');
      return false;
   }
   if(document.getElementById("dia_f").value != "" && document.getElementById("mes_f").value != "" && document.getElementById("ano_f").value != ""){

   }else{
      alert('Por favor, informe a data final para a pesquisa!');
      return false;
   }
   var date_i = document.getElementById("ano_i").value +"-"+ document.getElementById("mes_i").value +"-"+ document.getElementById("dia_i").value;
   var date_f = document.getElementById("ano_f").value +"-"+ document.getElementById("mes_f").value +"-"+ document.getElementById("dia_f").value;

   var url = "ajax_by_date.php?date_i="+date_i;
   url = url + "&date_f="+date_f;
   url = url + "&cache=" + new Date().getTime();
   http.open("GET", url, true);
   http.onreadystatechange = search_by_date_reply;
   http.send(null);
}
function search_by_date_reply(){
   if(http.readyState == 4)
   {
       var msgz = http.responseText;
       msgz = msgz.replace(/\+/g," ");
       msgz = unescape(msgz);
       if(msgz != ""){
          document.getElementById("conteudo").innerHTML = msgz;
       }
   }else{
      if (http.readyState==1){
         document.getElementById("conteudo").innerHTML = "<center><i>Atualizando...</i></center>";
      }
   }
}

//MOSTRA RESULTADOS PARA UMA DATA ESPECÍFICA
function search_a_date(data){
   var url = "ajax_by_date.php?date_i="+data;
   url = url + "&date_f="+data;
   url = url + "&cache=" + new Date().getTime();
   http.open("GET", url, true);
   http.onreadystatechange = search_a_date_reply;
   http.send(null);
}
function search_a_date_reply(){
   if(http.readyState == 4)
   {
       var msgz = http.responseText;
       msgz = msgz.replace(/\+/g," ");
       msgz = unescape(msgz);
       if(msgz != ""){
          document.getElementById("conteudo").innerHTML = msgz;
       }
   }else{
      if (http.readyState==1){
         document.getElementById("conteudo").innerHTML = "<center><i>Atualizando...</i></center>";
      }
   }
}
// ALTERA VALOR ALVO DO FINANCEIRO - MMD
function change_alvo(){
   var valor = prompt("Valor alvo:", "0,00");
   if(valor != "" && valor != "0,00" && valor!=null){
   }else{
      return false;
   }

   var url = "ajax_alvo.php?valor="+valor;
   url = url + "&cache=" + new Date().getTime();
   http.open("GET", url, true);
   http.onreadystatechange = change_alvo_reply;
   http.send(null);
}
function change_alvo_reply(){
   if(http.readyState == 4)
   {
       var msgz = http.responseText;
       msgz = msgz.replace(/\+/g," ");
       msgz = unescape(msgz);
       if(msgz != ""){
          alert('Valor alvo alterado!');
          document.getElementById("alvo1").innerHTML = msgz;
          document.getElementById("alvo2").innerHTML = msgz;
       }else{
          alert('Erro ao alterar valor base!');
       }
   }else{
      if (http.readyState==1){
         //document.getElementById("conteudo").innerHTML = "<center><i>Atualizando...</i></center>";
      }
   }
}



/*********************************************************************************/
// FUNÇÕES - MMD
/*********************************************************************************/
function change_field(field){
   if(field.name == "dia_i"){
      if(field.value.length >=2){
         document.getElementById("mes_i").focus();
      }
   }else if(field.name == "mes_i"){
      if(field.value.length >=2){
         document.getElementById("ano_i").focus();
      }
   }else if(field.name == "ano_i"){
      if(field.value.length >=4){
         document.getElementById("dia_f").focus();
      }
   }else if(field.name == "dia_f"){
      if(field.value.length >=2){
         document.getElementById("mes_f").focus();
      }
   }else if(field.name == "mes_f"){
      if(field.value.length >=2){
         document.getElementById("ano_f").focus();
      }
   }
}
