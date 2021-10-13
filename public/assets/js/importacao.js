/* Novo Registro */
$("#btn_importar_csv_links").click(() => {
  
  var ano = $('#lst_ano').val();
  if(ano == 0){
    swal.fire({icon: 'error', title: 'Oops...',text: response['message']}); return;
  }

  $('#modal_loading').show();  
  $.ajax({
      type: "post", 
      url: baseURL +'/importacoes/importar_csv_trimestral_anual_cvm',
      data: {ano},
      dataType: 'json',             
      success: function(response) {                
        try{if(response['status'] === 'error'){swal.fire({icon: 'error', title: 'Oops...',text: response['message']});}
            else{swal.fire("Tudo certo!", response['message']);} 
        }catch(e) {alert('Erro ao salvar o registro. Se o problema persistir, contate o suporte!');} 
      },complete: function(data){$('#modal_loading').hide();}
  }); 
});  


/* Importar balanços do periodo selecionado */
$("#btn_importar_balanco").click(() => {

  var cnpj = $('#lst_empresa option:selected').val();
  if(cnpj === "") {
    swal.fire({icon: 'error', title: 'Oops...', text: 'Selecione uma empresa antes de prosseguir!'});
    return;
  }
  
  var ini  = $('#ano_ini').val();
  var fim  = $('#ano_fim').val();
  var anual      = $('#check_anual').is(':checked');
  var trimestral = $('#check_trimestral').is(':checked');

  $('#modal_loading').show();           
  $.ajax({
      type: "post", 
      url: baseURL +'/importacoes/importar_balanco_periodo',
      data: {cnpj, ini, fim, anual, trimestral},
      dataType: 'json',             
      success: function(response) {                
        try{if(response['status'] === 'error'){swal.fire({icon: 'error', title: 'Oops...',text: response['message']});}
            else{swal.fire("Tudo certo!", response['message']);} 
        }catch(e) {alert('Erro ao salvar o registro. Se o problema persistir, contate o suporte!');};
        $('#lst_empresa').change(); 
      },complete: function(data){$('#modal_loading').hide();}
  }); 
});  


/* Importar lista de empresas do ano selecionado */
$("#btn_importar_empresas").click(() => {

  var ano = $('#lst_ano_empresa option:selected').val(); 
  $('#modal_loading').show();           
  $.ajax({
      type: "post", 
      url: baseURL +'/importacoes/importarListaEmpresas',
      data: {ano},
      dataType: 'json',             
      success: function(response) {                
        try{if(response['status'] === 'error'){swal.fire({icon: 'error', title: 'Oops...',text: response['message']});}
            else{swal.fire("Tudo certo!", response['message']);} 
        }catch(e) {alert('Erro ao salvar o registro. Se o problema persistir, contate o suporte!');};
        $('#lst_empresa').change(); 
      },complete: function(data){$('#modal_loading').hide();}
  }); 
});  



/* Função para carregar a lista no combo Setor */
function loadComboEmpresa() {  
  
  $.ajax({
    type: 'POST',
    url: baseURL +'/empresa/getListMinJson',        
    dataType: 'json',    
    success: function (myJsonData) {      
      
      if(myJsonData.length > 0){
        var listitems = '<option value=0>Selecione...</option>';
        $.each(myJsonData, function(key, linha){
          if(linha.analise === "1"){
            listitems += '<option value=' + linha.cnpj + '>' + (linha.codigo_negoc).substring(0,5) + ' | ' + linha.nome + '</option>';
          }
        });
        $('#lst_empresa').append(listitems);                
      }
    },
    error: function (e) {      
      console.log("loadDataToTable error: " + JSON.stringify(e));
    }
  });
};


/* Função para carregar a lista no combo Setor */
function loadComboPeriodo(cnpj) {  
  
  $('#ano_ini').empty();        
  $('#ano_fim').empty();        
  
  $.ajax({
    type: 'POST',
    url: baseURL +'/importacaoes/getAnosCadastradosEmpresaJson',        
    dataType: 'json',
    data: {cnpj},
    success: function (myJsonData) {      
      
      if(myJsonData.length > 0){
        var listitems = '';
        $.each(myJsonData, function(key, linha){
          listitems += '<option value=' + linha.ano + '>' + linha.ano + '</option>';
        });
        $('#ano_ini').append(listitems);        
        $('#ano_fim').append(listitems);           
        //-- apaga a lista de periodos
        $('#btn_importar_balanco').prop('disabled', false);
     
      }
    },
    error: function (e) {      
      console.log("loadDataToTable error: " + JSON.stringify(e));
    }
  });
};


/* Função para carregar a lista no combo Ano
   Carrega o ano atual e mais 15 anos anteriores */
function loadComboAno() {  

  $('#lst_ano_empresa').empty();
  $('#lst_ano').empty(); 
  var dt = new Date();
  ano_atual = dt.getFullYear();
  
  var fim = ano_atual -15;
  $('#lst_ano').append('<option value=0>Selecione...</option>');
  for (i = ano_atual; i >= fim; i--) {
    $('#lst_ano').append('<option value=' + i + '>' +i+ '</option>');
    $('#lst_ano_empresa').append('<option value=' + i + '>' +i+ '</option>');   
  }
};



/* Change Empresa */
$('#lst_empresa').change(function() {
  
  cnpj = $(this).val();
  if(cnpj !== "") loadComboPeriodo(cnpj);
});


/* Change Empresa */
$('#lst_periodo').change(function() {
  
  $('#btn_importar_balanco').prop('disabled', true);
  if($(this).val() === "") return;

  $('#btn_importar_balanco').prop('disabled', false);
});




//-- Coloca o foco no segundo input do formulário
$('#editModal').on('shown.bs.modal', function(){
  $(this).closest('form').find('input').eq(0).focus();
})



// Call the dataTables jQuery plugin
$(document).ready(function(){

  loadComboEmpresa();
  loadComboAno();  

  //-- inicia o plugin para o input do tipo file
  //bsCustomFileInput.init(); //-- descomentar para forms que usam o campo input de arquivo
});
