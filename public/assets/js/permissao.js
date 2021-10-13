const $controller = 'permissao';

$("#dataTable").DataTable({
  "pageLength": 100,
  responsive: true,
  searching: false,
  "bLengthChange": false,
  "order": [[1, "asc" ]],
  columnDefs: [{	
      targets: 4,                    
      orderable: false,
      width: '4%',      
      render: function(data, type, full, meta) {

        if (data === '0'){
          return '<input type="checkbox" class="checkbox_menu_item">';          
        }
        else {
          return '<input type="checkbox" class="checkbox_menu_item" checked>';          
        }
      },
    },
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

function loadDataToTable(usuario_id) {
  $.ajax({
    type: 'POST',
    url: baseURL +'/'+ $controller +'/getListJson',        
    data: {usuario_id},
    //contentType: "text/plain",
    dataType: 'json',
    success: function (myJsonData) {      
      $("#dataTable").DataTable().clear().draw();      
      if(myJsonData.length > 0){
        populateDataTable(myJsonData);
      }
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

      ativo = '<i class="bi bi-check2-all text-success"></i>';
      grupo = '<i class="bi bi-octagon-fill"></i>';
      if(data[i].ativo !== null && data[i].ativo !== '1') ativo = '<i class="bi bi-x-circle text-danger"></i>';
      
      descricao = data[i].descricao;
      if(data[i].flggrupo !== null && data[i].flggrupo === '1'){
         grupo = '<i class="bi bi-octagon-fill text-success"></i>';
         descricao = '<b>' + data[i].descricao + '</b>  <i class="bi bi-back"></i>';
      }

      $('#dataTable').dataTable().fnAddData([        
        data[i].id,
        descricao,
        grupo,        
        ativo,
        data[i].checked
      ]);
    }
};


function loadUsuariosSelect() {
  $.ajax({
    type: 'POST',
    url: baseURL +'/'+ $controller +'/getUsersListJson',        
    contentType: "text/plain",
    dataType: 'json',
    success: function (myJsonData) {      
      
      if(myJsonData.length > 0){
        var listitems = '<option value=0>Selecione...</option>';
        $.each(myJsonData, function(key, linha){
          listitems += '<option value=' + linha.id + '>' + linha.nome + '</option>';
        });
        $('#lst_usuario').append(listitems);
        $('#lst_usuario_source').append(listitems);
      }

    },
    error: function (e) {      
      console.log("loadDataToTable error: " + JSON.stringify(e));
    }
  });
}


/* Novo Registro */
$("#lst_usuario").change(() => {  
  var usuario_id = $("#lst_usuario").val();
  if(usuario_id === '0') exit();  
  loadDataToTable(usuario_id);  
});  


/* Botão Salvar  -------------------------------*/
/*----------------------------------------------*/
$("#btn_salvar").click(() => {
    
  usuario_id = $('#lst_usuario').val();
  usuario_source_id = $('#lst_usuario_source').val();
  if(typeof usuario_id === "undefined") usuario_id = '0';
  if(typeof usuario_source_id === "undefined") usuario_source_id = '0';

  if(usuario_id === '0'){
    Swal.fire(
      'Usuário',
      'Selecione um usuário antes de continuar.',
      'warning'
    )
    return;
  } 

  if($('#edt_copiar').is(':checked')){
    if(usuario_source_id === '0'){
      Swal.fire(
        'Copiar de Usuário ',
        'Selecione um usuário a copiar antes de continuar.',
        'warning'
      )
      return;
    }

    if(usuario_id === usuario_source_id){
        Swal.fire(
          'Copiar de Usuário ',
          'Usuário a copiar é igual ao usuário copiado!',
          'warning'
        )
        return;      
    }
  } 
  
  var tabela = document.getElementById('dataTable');
  var numLinhas = tabela.rows.length;
  
  //-- Obtém os ids do checkbox selecionados
  var ids = '';
  for (i = 1; i < numLinhas; i++){      
    var linha = tabela.rows.item(i);  
    var input = linha.getElementsByTagName("input")[0];
    if(input != null && input.type == "checkbox" && input.checked){                
      if(ids !== '') ids += ',';
      ids += linha.children[0].innerText; 
    }            
  } 
  
  //-- obtemos os ids. Agora salvamos via ajax
  $.ajax({
    type: 'POST',
    url: baseURL +'/'+ $controller +'/salvar',            
    dataType: 'json',
    data: {usuario_id, usuario_source_id, menu_ids: ids},
    success: function (response) {  
        if(response['status'] === 'error'){
            swal.fire({icon: 'error', title: 'Oops...', text: response['message']}
            );    
        }
        else{
          $('#editModal').modal('hide');                  
          $("#edt_copiar").prop("checked", false); 
          $(".hide_show").hide(); 
          $('#lst_usuario').trigger("change");  
          $('#lst_usuario_source').val("0");              
          swal.fire("Tudo certo!", response['message']);}
    },
    error: function (e) {      
      console.log("loadDataToTable error: " + JSON.stringify(e));
    }
  });  
});





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
                $("#edt_copiar").prop("checked", false); 
                $(".hide_show").hide(); 
                $('#lst_usuario').trigger("change");              
                //loadDataToTable(); 
                swal.fire("Tudo certo!", response['message']);                
            } 
          }catch(e) {     
            alert('Erro ao salvar o registro. Se o problema persistir, contate o suporte!');
          } 
      }
  });
});  


$("#edt_copiar").click(function(){
  $(".hide_show").toggle();
});



//-- Coloca o foco no segundo input do formulário
$('#editModal').on('shown.bs.modal', function(){
  $(this).closest('form').find('input').eq(1).focus();
});


$("#lst_sel_todos").click(() => {  
  $(".checkbox_menu_item").prop("checked", true);
});
$("#lst_sel_nenhum").click(() => {  
  $(".checkbox_menu_item").prop("checked", false);
});





// Call the dataTables jQuery plugin
$(document).ready(function(){

  loadUsuariosSelect();
  
  //-- inicia o plugin para o input do tipo file
  //bsCustomFileInput.init(); //-- descomentar para forms que usam o campo input de arquivo
});
