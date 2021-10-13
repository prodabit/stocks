const $controller = 'procard';

$("#dataTable").DataTable({
  "lengthMenu": [[10, 15, 50, -1], [10, 15, 50, "Todos"]],
  "pageLength": 15,
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
        '<button type="button" Title="Excluir" class="btn btn-sm btn-clean btn-icon btn-icon-md px-1 py-0" onclick="excluir('+data[i].id+')"><i class="bi bi-x-circle-fill text-danger"></i></button>';

      ativo = '<i class="bi bi-check2-all text-success"></i>';
      if(data[i].ativo !== null && data[i].ativo !== '1') ativo = '<i class="bi bi-x-circle text-danger"></i>';

      $('#dataTable').dataTable().fnAddData([
        data[i].id,
        data[i].numero,
        data[i].usuario,
        data[i].classe,
        'R$ ' + data[i].saldo,
        data[i].data_cadastro,        
        data[i].limite_diario,
        data[i].limite_credito,        
        ativo,
        botoes
      ]);
    }
};



/* Novo Registro */
$("#btn_novo").click(() => {
  $("#formulario")[0].reset(); //-- limpa todo o form

  var data = new Date().toISOString().slice(0, 10);
  $("#edt_data_cadastro").val(data);
  $("#edt_ultimo_acesso").val(data);  

  $("#edt_id").val(0);
  $("#edt_status_procard").val("1010");
  $("#edt_procard_classe").val(1);
  $("#edt_numero").val("");
  $("#edt_saldo").val("0.00");  
  $("#edt_senha").val("");  
  $("#edt_acessos").val('00');
  $("#edt_admin").prop("checked", false);
  $("#edt_usuario").val("");
  $("#edt_email").val("");
  $("#edt_limite_diario").val("0.00");
  $("#edt_limite_credito").val("0.00");
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
              $("#edt_status_procard").val(data.status_procard_id);
              $("#edt_procard_classe").val(data.procard_classe_id);
              $("#edt_numero").val(data.numero);
              $("#edt_saldo").val(data.saldo);
              $("#edt_data_cadastro").val((data.data_cadastro).substr(0,10));
              $("#edt_senha").val('');
              $("#edt_conf_senha").val('');
              $("#edt_ultimo_acesso").val((data.ultimo_acesso).substr(0,10));
              $("#edt_acessos").val(data.acessos);
              $("#edt_admin").prop("checked", data.admin === "1");
              $("#edt_usuario").val(data.usuario);
              $("#edt_email").val(data.email);
              $("#edt_limite_diario").val(data.limite_diario);
              $("#edt_limite_credito").val(data.limite_credito);
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

  if($("#edt_senha").val() !== ""){
    if($("#edt_senha").val() !== $("#edt_conf_senha").val()){
      swal.fire({icon: 'warning', title: 'Oops...', text: 'Senha difere da confirmação da senha!'});
      return;
    }
  };
  
  $('#modal_loading').show();           
  $.ajax({  
      url: baseURL +'/'+ $controller +'/salvar',
      type: "POST",  
      data: new FormData(this),  
      async: false,
      contentType: false,  
      processData:false, 
      success: function(response) {    
          var response = jQuery.parseJSON(response);                      
          try{
            if(response['status'] === 'error'){
              swal.fire({icon: 'error', title: 'Oops...', text: response['message']});    
            }
            else{
                $('#editModal').modal('hide');  
                swal.fire("Tudo certo!", response['message']);
                loadDataToTable();                 
            } 
          }catch(e){alert('Erro ao salvar o registro. Se o problema persistir, contate o suporte!');} 
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


/* Função para carregar a lista nos combos de unidade, categoria e fabricante */
function loadComboSelect(nome_combo) {  
  var tabela = '';
  switch(nome_combo){
    case 'edt_procard_classe':  tabela = 'procard_classe'; break;
    case 'edt_status_procard':  tabela = 'status_procard'; break;    
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
});


$("#edt_saldo").on("dblclick", function(e) {
  if(e.ctrlKey){
    $("#edt_saldo").prop('readonly',function(i,r){
          return !r;
    });
  }
});



// Call the dataTables jQuery plugin
$(document).ready(function(){

  loadComboSelect('edt_procard_classe');
  loadComboSelect('edt_status_procard');  
  loadDataToTable();
  
  //-- inicia o plugin para o input do tipo file
  //bsCustomFileInput.init(); //-- descomentar para forms que usam o campo input de arquivo
});
