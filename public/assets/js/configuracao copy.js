const $controller = 'configuracao';

$("#dataTable").DataTable({
  "pageLength": 25,
  responsive: true,
  searching: true,
  "bLengthChange": true,
  columnDefs: [
  {responsivePriority: 0, targets: 0},
  {responsivePriority: 1, targets: 1},
  {targets: 6, className: 'dt-body-center'}
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
        '<button type="button" Title="Alterar" class="btn btn-sm btn-clean btn-icon btn-icon-md px-1 py-0" onclick="editar('+data[i].id+')"><i class="bi bi-pencil-square text-success"></i></button>';

      preview = '<i class="bi bi-check2-all text-success"></i>';
      if(data[i].preview_impressao !== null && data[i].preview_impressao !== '1') preview = '<i class="bi bi-x-circle text-danger"></i>';

      $('#dataTable').dataTable().fnAddData([
        data[i].id,
        data[i].centro_custo_os,
        data[i].plano_contas_os,
        data[i].centro_custo_cupom,
        data[i].plano_contas_cupom,                
        preview,                
        botoes        
      ]);
    }
};



/* Editar Registro */
function editar(){

  $('#modal_loading').show();           
  $.ajax({
      type: "post", 
      url: baseURL +'/'+ $controller +'/getRegistroJson',      
      dataType: 'json',             
      async: true,
      success: function(data){
          $("#formulario")[0].reset(); //-- limpa todo o form  
          if(data){
              $("#edt_id").val(data.id);
              $("#edt_dir_log").val(data.dir_log);
              $("#edt_dir_backup").val(data.dir_backup);
              $("#edt_baixar_estoque_os").prop("checked", data.baixar_estoque_os === "1");
              $("#edt_centro_custo_os_id").val(data.centro_custo_os_id);
              $("#edt_plano_contas_os_id").val(data.plano_contas_os_id);
              $("#edt_centro_custo_cupom_id").val(data.centro_custo_cupom_id);
              $("#edt_plano_contas_cupom_id").val(data.plano_contas_cupom_id);

              $("#edt_centro_custo_os").val(data.centro_custo_os);
              $("#edt_plano_contas_os").val(data.plano_contas_os);
              $("#edt_centro_custo_cupom").val(data.centro_custo_cupom);
              $("#edt_plano_contas_cupom").val(data.plano_contas_cupom);

              $("#edt_logo").val(data.logo);
              $("#edt_desc_tabela_1").val(data.desc_tabela_1);
              $("#edt_desc_tabela_2").val(data.desc_tabela_2);
              $("#edt_desc_tabela_3").val(data.desc_tabela_3);
              $("#edt_leitor_mifare_ativo").prop("checked", data.leitor_mifare_ativo === "1");
              $("#edt_porta_leitor_mifare").val(data.porta_leitor_mifare);
              $("#edt_fundo_tela").val(data.fundo_tela);
              $("#edt_preview_impressao").prop("checked", data.preview_impressao === "1");
              $("#edt_dir_imagens").val(data.dir_imagens);
              $("#edt_imprimir_dados_empresa").prop("checked", data.imprimir_dados_empresa === "1");
              $("#edt_titulo_cupom").val(data.titulo_cupom);
              $("#edt_rodape_cupom").val(data.rodape_cupom);
              $("#edt_porc_tabela_1").val(data.porc_tabela_1);
              $("#edt_porc_tabela_2").val(data.porc_tabela_2);
              $("#edt_porc_tabela_3").val(data.porc_tabela_3);
              $("#edt_baixa_produto_composto").prop("checked", data.baixa_produto_composto === "1");
              $("#edt_imprimir_senha_cupom").prop("checked", data.imprimir_senha_cupom === "1");
              $("#edt_digitais").val(data.digitais);
              $("#edt_imprimir_delivery").prop("checked", data.imprimir_delivery === "1");
              $("#edt_cliente_vendas_id").val(data.cliente_vendas_id);
              $("#edt_cliente_transferencia_id").val(data.cliente_transferencia_id);
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


//-- Coloca o foco no primeiro input do formulário
$('#editModal').on('shown.bs.modal', function(){
  $(this).closest('form').find('input').eq(0).focus();
});


/* Exibe a lista de clientes na busca */
$('#edt_centro_custo_os').keyup(delay(function(e){
    $('#box_search_ccusto_os').hide();
    var search = $(this).val();
    if(search.length > 0){
      loadResultSearch('centro_custo_os', search);        
    }
}, 500));


/* Exibe a lista de clientes na busca */
$('#edt_centro_custo_cupom').keyup(delay(function(e){
  $('#box_search_ccusto_cupom').hide();
  var search = $(this).val();
  if(search.length > 0){
    loadResultSearch('centro_custo_cupom', search);        
  }
}, 500));

/* Exibe a lista de clientes na busca */
$('#edt_plano_contas_os').keyup(delay(function(e){
  $('#box_search_pcontas_os').hide();
  var search = $(this).val();
  if(search.length > 0){
    loadResultSearch('plano_contas_os', search);        
  }
}, 500));

/* Exibe a lista de clientes na busca */
$('#edt_plano_contas_cupom').keyup(delay(function(e){
  $('#box_search_pcontas_cupom').hide();
  var search = $(this).val();
  if(search.length > 0){
    loadResultSearch('plano_contas_cupom', search);        
  }
}, 500));


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

function loadResultSearch(modulo, filtro) {

  switch(modulo){
    case 'centro_custo_os':
      var campoId   = $("#edt_centro_custo_os_id"); var campoText = $("#edt_centro_custo_os");
      var boxBusca  = $("#box_search_ccusto_os");   var tabela    = 'centro_custo';
      break; 
    case 'centro_custo_cupom':
      var campoId   = $("#edt_centro_custo_cupom_id"); var campoText = $("#edt_centro_custo_cupom");
      var boxBusca  = $("#box_search_ccusto_cupom");   var tabela    = 'centro_custo';
      break;   
    case 'plano_contas_os':
      var campoId   = $("#edt_plano_contas_os_id"); var campoText = $("#edt_plano_contas_os");
      var boxBusca  = $("#box_search_pcontas_os");   var tabela    = 'plano_contas';
      break; 
    case 'plano_contas_cupom':
      var campoId   = $("#edt_plano_contas_cupom_id"); var campoText = $("#edt_plano_contas_cupom");
      var boxBusca  = $("#box_search_pcontas_cupom");   var tabela    = 'plano_contas';
      break;     
  }  
  boxBusca.show();

  var myJsonData = fetchData(tabela, filtro);
  boxBusca.html('');
  if(myJsonData === '') return;  

  var lista = '';
  $.each(myJsonData, function(key, linha){
    lista += '<tr><td>' +linha.id+ '</td><td>' +linha.descricao+ '</td></tr>';
  });

  var lista =  
    '<table id="tabela_resultado_busca" class="table table-bordered table-striped mb-0">'+
    '<thead><tr><th>#</th><th>Descrição</th></tr></thead>'+
    '<tbody>' +lista+ '</tbody></table>';  
  boxBusca.html(lista);   
        
  //-- pega o valor na tabela de resultado e coloca no edit
  $("#tabela_resultado_busca").on('click','tr',function(e){
    e.preventDefault();          
    var id = $(this).closest('tr')[0].children[0].innerText;
    var descricao = $(this).closest('tr')[0].children[1].innerText;
    campoId.val(id);
    campoText.val(descricao);
    boxBusca.html('');
    boxBusca.hide();
  }); 
}


function fetchData(tabela, filtro) {
  
  var resultado = '';
  $.ajax({
    type: 'POST',
    url: baseURL +'/cadastrogeral/getListFiltroJson', 
    data: {tabela, filtro},    
    dataType: 'json',
    async: false,
    success: function (myJsonData){      
      resultado = myJsonData;
    },
    error: function (e) {      
      console.log("loadDataToTable error: " + JSON.stringify(e));      
    }
  });
  return resultado;
}


// getting all required elements
const searchWrapper = $(".search-input")[0];
const inputBox = $('.search-input > input')[0];
const suggBox = searchWrapper.querySelector(".autocom-box");

// if user press any key and release
inputBox.onkeyup = delay(function(e){
  let busca = e.target.value; //user enetered data
  if(busca){
      
      let lista = fetchData('plano_contas', busca);
      lista = lista.map((linha)=>{
          // passing return linha inside li tag
          return linha = '<li id="'+linha.id+'">'+ linha.descricao +'</li>';
      });
      searchWrapper.classList.add("active"); //show autocomplete box
      showSuggestions(lista);
      let allList = suggBox.querySelectorAll("li");
      for (let i = 0; i < allList.length; i++) {
          //adding onclick attribute in all li tag
          allList[i].setAttribute("onclick", "select(this)");
      }
  }else{
      searchWrapper.classList.remove("active"); //hide autocomplete box
  }
},500);



function select(element){
    let selectData = element.textContent;
    let id = element.id;
    inputBox.value = selectData;
    searchWrapper.classList.remove("active");
    alert(id);
}

function showSuggestions(lista){
    let listData;
    if(!lista.length){
        userValue = inputBox.value;
        listData = '<li>'+ userValue +'</li>';
    }else{
        listData = lista.join('');
    }
    suggBox.innerHTML = listData;
}



// Call the dataTables jQuery plugin
$(document).ready(function(){

  loadDataToTable();
  
  //-- inicia o plugin para o input do tipo file
  bsCustomFileInput.init(); //-- descomentar para forms que usam o campo input de arquivo
});
