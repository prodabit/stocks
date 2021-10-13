const $controller = 'formapagamento';
var pBusca = '';

$("#dataTable").DataTable({
  "pageLength": 25,
  responsive: true,
  searching: true,
  "bLengthChange": true,
  columnDefs: [
  {responsivePriority: 0, targets: 0},
  {responsivePriority: 1, targets: 1},
  ],
  "language": {
      "lengthMenu": "Mostrar _MENU_ registros por página",
      "zeroRecords": "Nenhum registro encontrado",
      "info": "Exibindo página _PAGE_ de _PAGES_",
      "infoEmpty": "Nenhum registro disponível",
      "infoFiltered": "(filtrado de _MAX_ registros totais)",
      "search":         "Pesquisar:",
      "paginate": {
          "first":      "Primeira",
          "last":       "Última",
          "next":       "Próxima",
          "previous":   "Anterior"
      },
  }
});

function loadDataToTable() {
  
  $('#modal_loading').show();           
  $.ajax({
    type: 'POST',
    url: baseURL +'/'+ $controller +'/getListJson',        
    contentType: "text/plain",
    dataType: 'json',
    success: function (myJsonData) {      
      $("#dataTable").DataTable().clear().draw();      
      if(myJsonData.length > 0){
        populateDataTable(myJsonData);
      }
    },
    complete: function(){
      $('#modal_loading').hide();           
    },
    error: function (e) {      
      console.log("loadDataToTable error: " + JSON.stringify(e));
    }
  });
}


// populate the data table with JSON data
function populateDataTable(data) {
  
  $("#dataTable").DataTable().clear();
  var length = data.length;
    for(var i = 0; i < length; i++) {
      botoes = 
        '<button type="button" Title="Alterar" class="btn btn-sm btn-clean btn-icon btn-icon-md px-1 py-0" onclick="editar('+data[i].id+')"><i class="bi bi-pencil-square text-success"></i></button>'+
        '<button type="button" Title="Excluir" class="btn btn-sm btn-clean btn-icon btn-icon-md px-1 py-0" onclick="excluir('+data[i].id+')"><i class="bi bi-x-circle-fill text-danger"></i></button>'+
        '<button type="button" Title="Associar" class="btn btn-sm btn-clean btn-icon btn-icon-md px-1 py-0" onclick="associar('+data[i].id+')"><i class="bi bi-credit-card text-warning"></i></button>';

      precisa_cliente = procard = financeiro = ativo = '<i class="bi bi-check2-all text-success"></i>';      

      if(data[i].ativo !== null && data[i].ativo !== '1') ativo = '<i class="bi bi-x-circle text-danger"></i>';
      if(data[i].precisa_cliente !== null && data[i].precisa_cliente !== '1') precisa_cliente = '<i class="bi bi-x-circle text-danger"></i>';
      if(data[i].procard !== null && data[i].procard !== '1') procard = '<i class="bi bi-x-circle text-danger"></i>';
      if(data[i].financeiro !== null && data[i].financeiro !== '1') financeiro = '<i class="bi bi-x-circle text-danger"></i>';

      $('#dataTable').dataTable().fnAddData([
        data[i].id,
        data[i].descricao,
        data[i].conta_corrente,
        data[i].liquidez,
        precisa_cliente,
        procard,
        financeiro,                
        ativo,
        botoes
      ]);
    }
};





/* Novo Registro */
$("#btn_novo").click(() => {
  $("#formulario")[0].reset(); //-- limpa todo o form
  
  $("#edt_id").val(0);  
  $("#edt_descricao").val("");
  $("#edt_liquidez").val(0);
  $("#edt_taxa_adic").val("");
  $("#edt_parcelas").val(0);
  $("#edt_precisa_cliente").prop("checked", true);
  $("#edt_gera_comissao").prop("checked", true);
  $("#edt_procard").prop("checked", true);
  $("#edt_financeiro").prop("checked", true);
  $("#edt_ativo").prop("checked", true);
  $('#editModal').modal('show');
});  


/* Editar Registro */
function editar(id){

  $('#modal_loading').show();           
  $.ajax({
      type: "post", 
      url: baseURL +'/'+ $controller +'/getRegistroJson',
      data: {id},            
      dataType: 'json',             
      async: true,
      success: function(data){
          $("#formulario")[0].reset(); //-- limpa todo o form  
          if(data){
              $("#edt_id").val(data.id);
              $("#edt_descricao").val(data.descricao);
              $("#edt_liquidez").val(data.liquidez);
              $("#edt_taxa_adic").val(data.taxa_adic);
              $("#edt_parcelas").val(data.parcelas);
              $("#edt_precisa_cliente").prop("checked", data.precisa_cliente === "1");
              $("#edt_gera_comissao").prop("checked", data.gera_comissao === "1");
              $("#edt_procard").prop("checked", data.procard === "1");
              $("#edt_financeiro").prop("checked", data.financeiro === "1");  
              $("#edt_ativo").prop("checked", data.ativo === "1");  
          }
      },
      complete: function(data) {  
          $('#modal_loading').hide();           
          $('#editModal').modal('show');     
      }
  });   
};  



/* Associar Registro */
function associar(fpgto_id){

  $("#cc_id_fpgto").val(fpgto_id);              
  $('#modal_loading').show();           
  $.ajax({
      type: "post", 
      url: baseURL +'/'+ $controller +'/getAssociacaoJson',
      data: {fpgto_id},            
      dataType: 'json',             
      async: true,
      success: function(data){
          $("#form_associar")[0].reset(); //-- limpa todo o form  
          if(data){              
              $("#cc_conta_corrente").val(data.conta_id);
              $("#cc_id_cliente").val(data.cliente_id);              
              $("#cc_cliente").val(data.cliente);              
          }
      },
      complete: function(data) {  
          $('#modal_loading').hide();           
          $('#associarModal').modal('show');     
      }
  });   
};  



/* Salvar dados do formulário */
$('#formulario').submit(function(e){
  e.preventDefault();  
  
  $.ajax({  
      url: baseURL +'/'+ $controller +'/salvar',
      type: "POST",  
      data: new FormData(this),  
      async: false,
      contentType: false,  
      processData:false, 
      //processing: true,
      //serverSide: true, 
      success: function(response) {                
          try{
            if(response['status'] === 'error'){
                swal.fire({icon: 'error',
                        title: 'Oops...',
                        text: response['message']}
                );    
            }
            else{
                $('#editModal').modal('hide');  
                swal.fire("Tudo certo!", response['message']);
                loadDataToTable();                 
            } 
          }catch(e) {     
            alert('Erro ao salvar o registro. Se o problema persistir, contate o suporte!');
          } 
      }
  });
});  


/* Salvar dados do formulário de Associação */
$('#form_associar').submit(function(e){
  e.preventDefault();  
});


$('#editSalvarAssociar').click(() => {
  var cc_id = $("#cc_conta_corrente").val();
  if(cc_id === "0"){
    Swal.fire(
      'Selecionar Conta Corrente',
      'Selecione uma Conta Corrente antes de continuar.',
      'warning'
    )
    return;
  }
  
  $.ajax({  
      url: baseURL +'/'+ $controller +'/salvar_associacao',
      type: "POST",  
      data: new FormData($('#form_associar')[0]),  
      async: false,
      contentType: false,  
      processData:false, 
      success: function(response) {                
          try{
            if(response['status'] === 'error'){
                swal.fire({icon: 'error',
                        title: 'Oops...',
                        text: response['message']}
                );    
            }
            else{
                $('#associarModal').modal('hide');  
                swal.fire("Tudo certo!", response['message']);
                loadDataToTable();                 
            } 
          }catch(e) {     
            alert('Erro ao salvar o registro. Se o problema persistir, contate o suporte!');
          } 
      }
  });  

});




/* excluir
| função excluir. Seta o campo ativo do registro para '2'
| @params id
*/    
function excluir(id){
    
  Swal.fire({
      title: "Confirma a exclusão?",
      text: "Uma vez exluído, não será possível reativar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sim, Excluir!',
      cancelButtonText: 'Não!',        
      dangerMode: true,
  })
  .then((result) => {
      if (result.value) {
          $.ajax({
            type: "post", 
            url: baseURL +'/'+ $controller +'/excluir',
            data: {id},            
            dataType: 'json',             
            async: true,                
              complete: function(response){                                 
                loadDataToTable();                 
                $('#editModal').modal('hide');  
                swal.fire("Tudo certo!", response['message']);                                
              }
          });
      } else {
          swal.fire("Exclusão cancelada!");
          return false;
      }
  });
};


function loadCCorrentesSelect() {
  $.ajax({
    type: 'POST',
    url: baseURL +'/contacorrente/getListJson',        
    contentType: "text/plain",
    dataType: 'json',
    success: function (myJsonData) {      
      
      if(myJsonData.length > 0){
        var listitems = '<option value="0">Selecione...</option>';
        $.each(myJsonData, function(key, linha){
          listitems += '<option value="' + linha.id + '">' + linha.descricao +' | BCO:'+ linha.cod_banco +' | AG:'+ linha.agencia + '</option>';
        });
        $('#cc_conta_corrente').append(listitems);
        $('#lst_usuario_source').append(listitems);
      }

    },
    error: function (e) {      
      console.log("loadDataToTable error: " + JSON.stringify(e));
    }
  });
}


var availableTutorials  =  [
  "Maria",
  "Jose",
  "Silvia Carlitte",
  "Costancia Braga",
];
$( "#cc_cliente" ).autocomplete({
  source: availableTutorials
});


function loadClientesSearch(filtro) {
  $.ajax({
    type: 'POST',
    url: baseURL +'/pessoa/getListFiltroJson', 
    data: {filtro},    
    dataType: 'json',
    success: function (myJsonData) {      
      
      if(myJsonData.length > 0){
        var lista = '';
        $.each(myJsonData, function(key, linha){
          lista += '<tr><td>' +linha.id+ '</td><td>' +linha.nome+ '</td><td>' +linha.rua+ '</td><td>' +linha.bairro+ '</td></tr>';
        });

        var lista =  
        '<table id="tabela_clientes_busca" class="table table-navegable mb-0">'+
        '<thead>'+
          '<tr>'+
        '  <th>#</th>'+
        '  <th>Nome</th>'+
        '   <th>Rua</th>'+
        '   <th>Bairro</th>'+        
        '</tr>'+
        '</thead>'+
        '<tbody>' +lista+ '</tbody></table>';  
        $('#resultado').html(lista);   
        
        makeNavigable('tabela_clientes_busca', 'resultado', 'cc_id_cliente', 'cc_cliente');
      }
      else{
        $('#resultado').html('');
      }
    },
    error: function (e) {      
      console.log("loadDataToTable error: " + JSON.stringify(e));
    }
  });
}



/* Exibe a lista de clientes na busca */
/*$('#cc_cliente').on('keyup', delay(function(){
  var search = $(this).val();
  if(search.length > 2){
    if(pBusca !== search){
      pBusca = search;
      loadClientesSearch(search);
      //$('#resultado').css('height', '300px');
    }
  }
  else{
    $("#cc_id_cliente").val("0");              
    $('#resultado').html('');    
  }
}, 500));*/




/* coloca o foto na tabela caso a tecla down seja pressionada */
/*$('#cc_cliente').keyup(function(e){
  if(e.which == 40 && $('#tabela_clientes_busca').is(":visible")){
    $('#tabela_clientes_busca').focus();
  }
});*/


function delay(callback, ms) {
  var timer = 0;
  return function() {
    var context = this, args = arguments;
    clearTimeout(timer);
    timer = setTimeout(function () {
      callback.apply(context, args);
    }, ms || 0);
  };
}



//-- Coloca o foco no segundo input do formulário
$('#editModal').on('shown.bs.modal', function(){
  $(this).closest('form').find('input').eq(1).focus();
})


// Call the dataTables jQuery plugin
$(document).ready(function(){
  
  loadCCorrentesSelect()
  loadDataToTable();  
  
  //-- inicia o plugin para o input do tipo file
  //bsCustomFileInput.init(); //-- descomentar para forms que usam o campo input de arquivo
});
