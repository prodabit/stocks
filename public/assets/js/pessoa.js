const $controller = 'pessoa';
var cidade_id = '0';

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
        '<button type="button" Title="Excluir" class="btn btn-sm btn-clean btn-icon btn-icon-md px-1 py-0" onclick="excluir('+data[i].id+')"><i class="bi bi-x-circle-fill text-danger"></i></button>'+
        '<button type="button" Title="contatos" class="btn btn-sm btn-clean btn-icon btn-icon-md px-1 py-0" onclick="contatos('+data[i].id+',\''+data[i].nome+'\')"><i class="bi-people-fill text-primary"></i></button>';

      ativo = juridica = fornecedor = '<i class="bi bi-check2-all text-success"></i>';
      if(data[i].ativo !== null && data[i].ativo !== '1') ativo = '<i class="bi bi-x-circle text-danger"></i>';
      if(data[i].juridica !== '1') juridica = '<i class="bi bi-circle text-danger"></i>';
      if(data[i].fornecedor !== null && data[i].fornecedor !== '1') fornecedor = '<i class="bi bi-circle text-danger"></i>';

      $('#dataTable').dataTable().fnAddData([
        data[i].id,        
        data[i].nome,
        data[i].rua,
        data[i].numero,
        data[i].complemento,
        data[i].bairro,
        data[i].cidade +'/'+ data[i].uf,
        juridica,
        fornecedor,        
        ativo,
        botoes
      ]);
    }
};



/* Novo Registro */
$("#btn_novo").click(() => {
  $("#edt_cidade").find('option').remove();
  $("#formulario")[0].reset(); //-- limpa todo o form  
  $("#edt_id").val(0);
  $("#edt_uf").val(0);
  //$("#edt_cidade_id").val(0);
  $("#edt_nome").val("");
  $("#edt_rua").val("");
  $("#edt_numero").val("");
  $("#edt_complemento").val("");
  $("#edt_bairro").val("");
  $("#edt_cep").val("");
  $("#edt_cpf").val("");
  $("#edt_rg").val("");
  $("#edt_cnpj").val("");
  $("#edt_insc_mun").val("");
  $("#edt_insc_est").val("");
  $("#edt_foto").val("");
  $("#edt_restricao").val("");
  $("#edt_contato").val("");
  $("#edt_referencia").val("");
  $("#edt_data_cadastro").val("");
  $("#edt_suframa").val("");
  $("#edt_limite_credito").val("");
  $("#edt_numero_cartao").val("");
  $("#edt_juridica").prop("checked", false);
  $("#edt_fornecedor").prop("checked", false);
  $("#edt_transportador").prop("checked", false);
  $("#edt_ativo").prop("checked", true);
  $('#edt_excluir_foto').val('0')
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
              $("#edt_uf").val(data.uf);
              $('#edt_uf').trigger("change");
              cidade_id = data.cidade_id;              
              $("#edt_nome").val(data.nome);
              $("#edt_rua").val(data.rua);
              $("#edt_numero").val(data.numero);
              $("#edt_complemento").val(data.complemento);
              $("#edt_bairro").val(data.bairro);
              $("#edt_cep").val(data.cep);
              $("#edt_cpf").val(data.cpf);
              $("#edt_rg").val(data.rg);
              $("#edt_cnpj").val(data.cnpj);
              $("#edt_insc_mun").val(data.insc_mun);
              $("#edt_insc_est").val(data.insc_est);              
              $("#edt_restricao").val(data.restricao);
              $("#edt_contato").val(data.contato);
              $("#edt_referencia").val(data.referencia);
              $("#edt_data_cadastro").val(data.data_cadastro);
              $("#edt_suframa").val(data.suframa);
              $("#edt_limite_credito").val(data.limite_credito);
              $("#edt_numero_cartao").val(data.numero_cartao);
              $("#edt_juridica").prop("checked", data.juridica === "1");
              $("#edt_fornecedor").prop("checked", data.fornecedor === "1");
              $("#edt_transportador").prop("checked", data.transportador === "1");
              $("#edt_ativo").prop("checked", data.ativo === "1");  
              $('#edt_excluir_foto').val("0");
              $('#thumb_foto')[0].src =  baseURL + '/assets/media/_no-image.jpg';
              if(data.foto !== ""){
                var preview = $('#thumb_foto')[0]; //-- [0] para pegar o thumb da imagem
                preview.src = baseURL + '/assets/media/' + data.foto;                
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


//-- Lista as cidade de acordo com a UF selecionada
$('#edt_uf').change((e) =>{
  uf = (e.target.value);
  $.ajax({
    type: "post", 
    url: baseURL +'/cadastrogeral/getListaCidades',
    data: {uf},
    dataType: 'json',             
    async: true,
    success: function(data){        
      $("#edt_cidade").find('option').remove();
      if(data.length > 0){
        var listitems = '';
        $.each(data, function(key, linha){
          listitems += '<option value=' + linha.id + '>' + linha.cidade + '</option>';
        });
        $('#edt_cidade').append(listitems);   
        $("#edt_cidade").val(cidade_id);     
      }
    },
    error: function (e) {      
      console.log("loadDataToTable error: " + JSON.stringify(e));
    }
  });   
})



/* Selecionar a UF  padrão */
function selecionarUFPadrao(id){
  $.ajax({
      type: "post", 
      url: baseURL +'/cadastrogeral/getUFEmpresa',
      dataType: 'json',             
      async: true,
      success: function(data){
          $("#edt_uf").val('0');
          if(data){$("#edt_uf").val(data.uf)};
      }
  });   
};  


//-- Coloca o foco no segundo input do formulário
$('#editModal').on('shown.bs.modal', function(){
  $(this).closest('form').find('input').eq(1).focus();
});



/* Funções para cerregamento e cancelamento de foto do produto */
$(".foto-upload").click(() => {
  $('#edt_foto').trigger('click');   
});
$(".foto-cancel").click(() => {
  var preview = $('#thumb_foto')[0]; //-- [0] para pegar o thumb da imagem
  preview.src =  baseURL + "/assets/media/_no-image.jpg";
  $('#edt_excluir_foto').val('1')
});



/* Função para carregar a imagem de um arquivo em um campo de imagem */
function previewFile() {
  var preview = $('#thumb_foto')[0]; //-- [0] para pegar o thumb da imagem
  var file    = document.querySelector('input[type=file]').files[0];
  var reader  = new FileReader();
  reader.onloadend = function () {
    preview.src = reader.result;
  }
  if (file) {
    $('#edt_excluir_foto').val('0');
    reader.readAsDataURL(file);
  } else {
    preview.src = "";
  }
}



// Call the dataTables jQuery plugin
$(document).ready(function(){

  loadDataToTable();

  
  //-- inicia o plugin para o input do tipo file
  //bsCustomFileInput.init(); //-- descomentar para forms que usam o campo input de arquivo
});
