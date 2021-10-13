const $controller = 'empresa';

$("#dataTable").DataTable({
  "lengthMenu": [[10, 15, 50, -1], [10, 15, 50, "Todos"]],
  "pageLength": 15,
  responsive: true,
  searching: true,
  "bLengthChange": true,
  "order": [[ 1, "asc" ]],
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
        '<button type="button" Title="Excluir" class="btn btn-sm btn-clean btn-icon btn-icon-md px-1 py-0" onclick="excluir('+data[i].id+')"><i class="bi bi-x-circle-fill text-danger"></i></button>';

      ativo = '<i class="bi bi-check2-all text-success"></i>';
      analise = '<i class="bi bi-graph-up text-success"></i>';
      if(data[i].ativo !== null && data[i].ativo !== '1') ativo = '<i class="bi bi-x-circle text-danger"></i>';
      if(data[i].analise == null || data[i].analise !== '1') analise = '';

      $('#dataTable').dataTable().fnAddData([
        data[i].id,
        data[i].nome,
        data[i].codigo_negoc,
        data[i].cnpj,        
        data[i].fundacao,
        data[i].setor,
        data[i].tipo_mercado,
        analise,
        ativo,        
        botoes
      ]);
    }

    var table = $('#dataTable').DataTable();
    $('#dataTable tbody').on('click', 'tr', function () {      
      var data = table.row( this ).data();
      editar(data[0]);
  } );
};


/* Novo Registro */
$("#btn_novo").click(() => {
  $("#formulario")[0].reset(); //-- limpa todo o form  
  $("#edt_id").val(0);
  $("#edt_fundacao").val("2000");
  $("#edt_setor").val("BIN");
  $("#edt_tipo_mercado").val("NM");
  $("#edt_tag_along_on").val("-");
  $("#edt_tag_along_pn").val("-");
  $("#edt_tag_along_unit").val("-");
  $("#edt_free_float_on").val("-");
  $("#edt_free_float_pn").val("-");
  $("#edt_free_float_total").val("-");
  $("#edt_porc_minoritario").val("-");
  $("#edt_porc_majoritario").val("-");
  $("#edt_governo_on").val("0");
  $("#edt_porc_governo_on").val("-");
  $("#edt_porc_ibovespa").val("-");
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
              $("#edt_codigo").val(data.codigo);
              $("#edt_codigo_negoc").val(data.codigo_negoc);
              $("#edt_cnpj").val(data.cnpj);
              $("#edt_nome").val(data.nome);
              $("#edt_fundacao").val(data.fundacao);
              $("#edt_setor").val(data.setor_id);
              $("#edt_tipo_mercado").val(data.tipo_mercado);
              $("#edt_tag_along_on").val(data.tag_along_on);
              $("#edt_tag_along_pn").val(data.tag_along_pn);
              $("#edt_tag_along_unit").val(data.tag_along_unit);
              $("#edt_free_float_on").val(data.free_float_on);
              $("#edt_free_float_pn").val(data.free_float_pn);
              $("#edt_free_float_total").val(data.free_float_total);
              $("#edt_majoritario").val(data.majoritario);
              $("#edt_porc_minoritario").val(data.porc_minoritario);
              $("#edt_porc_majoritario").val(data.porc_majoritario);
              $("#edt_governo_on").val(data.governo_on);
              $("#edt_porc_governo_on").val(data.porc_governo_on);
              $("#edt_porc_ibovespa").val(data.porc_ibovespa);
              $("#edt_site_ri").val(data.site_ri);
              $("#edt_qtde_acoes_on").val(data.qtde_acoes_on);
              $("#edt_qtde_acoes_pn").val(data.qtde_acoes_pn);
              $("#edt_qtde_acoes_unit").val("0.00");
              $("#edt_qtde_acoes_total").val(data.qtde_acoes_total);
              $("#edt_analise").prop("checked", data.analise === "1");
              $("#edt_ativo").prop("checked", data.ativo === "1");
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
            var response = jQuery.parseJSON(response);
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



/* Função para carregar a lista no combo Setor */
function loadComboSelect(nome_combo) {  
  var tabela = '';
  switch(nome_combo){
    case 'edt_setor':    tabela = 'setor'; break;
  }
  $.ajax({
    type: 'POST',
    url: baseURL +'/cadastrogeral/getListJson',        
    dataType: 'json',
    data: {tabela},
    success: function (myJsonData) {      
      
      if(myJsonData.length > 0){
        var listitems = '<option value=0>Selecione...</option>';
        $.each(myJsonData, function(key, linha){
          listitems += '<option value=' + linha.id + '>' + linha.descricao + '</option>';
        });
        $('#' + nome_combo).append(listitems);        
      }
    },
    error: function (e) {      
      console.log("loadDataToTable error: " + JSON.stringify(e));
    }
  });
}


//-- Coloca o foco no segundo input do formulário
$('#editModal').on('shown.bs.modal', function(){
  $(this).closest('form').find('input').eq(0).focus();
})



// Call the dataTables jQuery plugin
$(document).ready(function(){

  loadComboSelect('edt_setor');
  loadDataToTable();
  
  //-- inicia o plugin para o input do tipo file
  //bsCustomFileInput.init(); //-- descomentar para forms que usam o campo input de arquivo
});
