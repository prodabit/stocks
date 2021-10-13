const $controller = 'movimento';

$("#dataTable").DataTable({
  "lengthMenu": [[10, 15, 50, -1], [10, 15, 50, "Todos"]],
  "pageLength": 15,
  responsive: true,
  searching: true,
  "order": [[0, "desc"]],  
  "bLengthChange": true,
  columnDefs: [],  
  buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
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
        '<button type="button" Title="Excluir" class="btn btn-sm btn-clean btn-icon btn-icon-md px-1 py-0" onclick="excluir('+data[i].id+')"><i class="bi bi-x-circle-fill text-danger"></i></button>';

      ativo = '<i class="bi bi-check2-all text-success"></i>';
      if(data[i].ativo !== null && data[i].ativo !== '1') ativo = '<i class="bi bi-x-circle text-danger"></i>';

      var data_abertura = ''; var data_fechamento = '';
      if(data[i].data_hora_abertura !== null){
        data_abertura = new Date(data[i].data_hora_abertura);
        data_abertura = data_abertura.toLocaleDateString() +' '+ data_abertura.toLocaleTimeString()
      } 
      if(data[i].data_hora_fechamento !== null){
        data_fechamento = new Date(data[i].data_hora_fechamento);
        data_fechamento = data_fechamento.toLocaleDateString() +' '+ data_fechamento.toLocaleTimeString()
      }

      $('#dataTable').dataTable().fnAddData([
        data[i].id,
        data_abertura,
        data_fechamento,        
        data[i].usuario,
        data[i].estacao,
        data[i].total_venda,
        data[i].status_movimento,        
        ativo,
        botoes
      ]);
    }
};



/* Novo Registro */
$("#btn_novo").click(() => {
    var data = new Date().toISOString().slice(0, 10);  
    $("#formulario")[0].reset(); //-- limpa todo o form
    $("#edt_id").val(0);
    $("#edt_usuario").val(0);
    $("#edt_estacao").val("");
    $("#edt_data_hora_abertura").val(data);
    $("#edt_data_hora_fechamento").val("");
    $("#edt_total_suprimento").val("0");
    $("#edt_total_sangria").val("0");
    $("#edt_total_venda").val("0");
    $("#edt_total_desconto").val("0");
    $("#edt_total_acrescimo").val("0");
    $("#edt_total_final").val("0");
    $("#edt_total_recebido").val("0");
    $("#edt_total_troco").val("0");
    $("#edt_total_cancelado").val("0");
    $("#edt_status_movimento").val("A");
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
              $("#edt_usuario").val(data.usuario_id);
              $("#edt_estacao").val(data.estacao);
              $("#edt_data_hora_abertura").val((data.data_hora_abertura).substr(0,10));              
              $("#edt_total_suprimento").val(data.total_suprimento);
              $("#edt_total_sangria").val(data.total_sangria);
              $("#edt_total_venda").val(data.total_venda);
              $("#edt_total_desconto").val(data.total_desconto);
              $("#edt_total_acrescimo").val(data.total_acrescimo);
              $("#edt_total_final").val(data.total_final);
              $("#edt_total_recebido").val(data.total_recebido);
              $("#edt_total_troco").val(data.total_troco);
              $("#edt_total_cancelado").val(data.total_cancelado);
              $("#edt_status_movimento").prop("checked", data.status_movimento === "1");
              $("#edt_ativo").prop("checked", data.ativo === "1");  

              if(data.data_hora_fechamento !== null) {                
                var data_fechamento = (data.data_hora_fechamento).substr(0,10)                
                $("#edt_data_hora_fechamento").val(data_fechamento);
              }              
          }
      },
      complete: function(data) {  
          $('#modal_loading').hide();           
          $('#editModal').modal('show');     
      }
  });   
};  


/* Salvar dados do formulário */
$('#formulario').submit(function(e){
  e.preventDefault();  
  
  $('#modal_loading').show();           
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
      },
      complete: function(){
        $('#modal_loading').hide();           
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


//-- Coloca o foco no segundo input do formulário
$('#editModal').on('shown.bs.modal', function(){
  $(this).closest('form').find('select').eq(0).focus();
})


function loadComboSelect(nome_combo) {
  
  $.ajax({
    type: 'POST',
    url: baseURL +'/usuario/getListJson',        
    dataType: 'json',    
    success: function (myJsonData) {      
      if(myJsonData.length > 0){
        var listitems = '<option value=0>Selecione...</option>';
        $.each(myJsonData, function(key, linha){
          listitems += '<option value=' + linha.id + '>' + linha.nome + '</option>';
        });
        $('#edt_usuario').append(listitems);        
      }
    },
    error: function (e) {      
      console.log("loadDataToTable error: " + JSON.stringify(e));
    }
  });
}



// Call the dataTables jQuery plugin
$(document).ready(function(){

  loadDataToTable();
  loadComboSelect();
  //$( "#btn_novo" ).trigger( "click" );
  
  //-- inicia o plugin para o input do tipo file
  //bsCustomFileInput.init(); //-- descomentar para forms que usam o campo input de arquivo
});
