const $controller = 'categoria';

$("#dataTable").DataTable({
  "lengthMenu": [[10, 15, 50, -1], [10, 15, 50, "Todos"]],
  "pageLength": 15,
  responsive: true,
  searching: true,
  "bLengthChange": true,
  columnDefs: [
  {responsivePriority: 0, targets: 1},
  {responsivePriority: 1, targets: 4},
  {responsivePriority: 2, targets: 3},
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
  $.ajax({
    type: 'POST',
    url: baseURL +'/'+ $controller +'/getListJson',        
    contentType: "text/plain",
    dataType: 'json',
    success: function (data) {
      myJsonData = data;
      populateDataTable(myJsonData);
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

      auto_atendimento = '<i class="bi bi-check2-all text-success"></i>';
      ativo = '<i class="bi bi-check2-all text-success"></i>';
      if(data[i].auto_atendimento !== '1') auto_atendimento = '<i class="bi bi-x-circle text-danger"></i>';
      if(data[i].ativo !== '1') ativo = '<i class="bi bi-x-circle text-danger"></i>';

      $('#dataTable').dataTable().fnAddData([
        data[i].id,
        data[i].descricao,
        data[i].ordem,
        data[i].foto,
        auto_atendimento,
        ativo,
        botoes
      ]);
    }
};



/* Novo Registro */
$("#btn_novo").click(() => {
  $("#formulario")[0].reset(); //-- limpa todo o form
  $('#edt_id').val(0);
  $('#edt_ativo').prop('checked', true);
  $('#edt_auto_atendimento').prop('checked', true);   
  $('#edt_excluir_foto').prop('checked', false); 
  $('#thumb_foto')[0].src =  baseURL + '/assets/media/_no-image.jpg';
  $('#editModal').modal('show');
});  


/* Editar Registro */
function editar(id){

  //$('#modal_loading').show();         
  //$('#modal_loading_main').hide();        
  $.ajax({
      type: "post", 
      url: baseURL +'/'+ $controller +'/getRegistroJson',
      data: {id},            
      dataType: 'json',             
      async: true,
      success: function(data){
          $("#formulario")[0].reset(); //-- limpa todo o form  
          if(data){
              $('#edt_id').val(data.id);
              $('#edt_descricao').val(data.descricao);            
              $('#edt_ordem').val(data.ordem);                            
              $('#edt_ativo').prop('checked', data.ativo === '1');
              $('#edt_auto_atendimento').prop('checked', data.auto_atendimento === '1');                
              $('#edt_excluir_foto').prop('checked', false); 
              $('#lbl_foto').text(data.foto);

              $('#thumb_foto')[0].src =  baseURL + '/assets/media/_no-image.jpg';
              if(data.foto !== ""){
                var preview = $('#thumb_foto')[0]; //-- [0] para pegar o thumb da imagem
                preview.src = baseURL + '/assets/media/' + data.foto;
              }
            }
      },
      complete: function(data) {  
          //$('#modal_loading').hide(); 
          //$('#modal_loading_main').show();              
          $('#editModal').modal('show');     
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

function previewFile() {
  var preview = $('#thumb_foto')[0]; //-- [0] para pegar o thumb da imagem
  var file    = document.querySelector('input[type=file]').files[0];
  var reader  = new FileReader();

  reader.onloadend = function () {
    preview.src = reader.result;
  }

  if (file) {
    reader.readAsDataURL(file);
  } else {
    preview.src = "";
  }
}


//-- Coloca o foco no segundo input do formulário
$('#editModal').on('shown.bs.modal', function(){
  $(this).closest('form').find('input').eq(1).focus();
})


// Call the dataTables jQuery plugin
$(document).ready(function(){

  loadDataToTable();
  
  //-- inicia o plugin para o input do tipo file
  bsCustomFileInput.init();
});
