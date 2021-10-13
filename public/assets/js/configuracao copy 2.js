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
              $("#edt_cliente_vendas").val(data.cliente_vendas);
              $("#edt_cliente_transferencia").val(data.cliente_transferencia);
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



/* Exibe a lista centos de custo busca */
$('#edt_centro_custo_os').keyup(delay(function(e){
    var search = $(this).val();
    if(search.length > 0){
      loadResultSearch('centro_custo_os', search);        
    }
}, 500));


/* Exibe a lista centos de custo busca */
$('#edt_centro_custo_cupom').keyup(delay(function(e){
  var search = $(this).val();
  if(search.length > 0){
    loadResultSearch('centro_custo_cupom', search);        
  }
}, 500));

/* Exibe a lista planos de conta busca */
$('#edt_plano_contas_os').keyup(delay(function(e){
  var search = $(this).val();
  if(search.length > 0){
    loadResultSearch('plano_contas_os', search);        
  }
}, 500));

/* Exibe a lista planos de conta busca */
$('#edt_plano_contas_cupom').keyup(delay(function(e){
  var search = $(this).val();
  if(search.length > 0){
    loadResultSearch('plano_contas_cupom', search);        
  }
}, 500));

/* Exibe a lista de clientes na busca */
$('#edt_cliente_vendas').keyup(delay(function(e){
  var search = $(this).val();
  if(search.length > 0){
    loadResultSearch('cliente_vendas', search);        
  }
}, 500));


/* Exibe a lista de clientes na busca */
$('#edt_cliente_transferencia').keyup(delay(function(e){
  var search = $(this).val();
  if(search.length > 0){
    loadResultSearch('cliente_transferencia', search);        
  }
}, 500));



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
      var boxBusca  = $("#box_search_pcontas_os");  var tabela    = 'plano_contas';
      break; 
    case 'plano_contas_cupom':
      var campoId   = $("#edt_plano_contas_cupom_id"); var campoText = $("#edt_plano_contas_cupom");
      var boxBusca  = $("#box_search_pcontas_cupom");  var tabela    = 'plano_contas';
      break;     
    case 'cliente_vendas':
        var campoId   = $("#edt_cliente_vendas_id"); var campoText = $("#edt_cliente_vendas");
        var boxBusca  = $("#box_search_cliente_vendas");  var tabela    = 'pessoa';
        break;         
    case 'cliente_transferencia':
        var campoId   = $("#edt_cliente_transferencia_id"); var campoText = $("#edt_cliente_transferencia");
        var boxBusca  = $("#box_search_cliente_transferencia");  var tabela    = 'pessoa';
        break;                 
  } 
  
  boxBusca.hide();  
  fetchData(tabela, filtro, boxBusca[0].id, campoId[0].id, campoText[0].id);  
}


function select(element, boxBusca, campoId, campoText){  
  $('#' + campoId).val(element.id);
  $('#' + campoText).val(element.textContent);  
  $('#' + boxBusca).html('');
  $('#' + boxBusca).hide();
}



/* Realiza a consulta ba base via ajax  */
function fetchData(tabela, filtro, boxBusca, campoId, campoText) {

  boxBusca  = $('#' +boxBusca);
  boxBusca.html('');
  vUrl = baseURL +'/cadastrogeral/getListFiltroJson';
  if(tabela === 'pessoa') vUrl = baseURL +'/pessoa/getListMinFiltroJson';
  
  $.ajax({
    type: 'POST',
    url: vUrl, 
    data: {tabela, filtro},    
    dataType: 'json',
    success: function (lista){      

      boxBusca.show();
      if(lista.length > 0) {
          // cria a lista de tags <li>
          lista = lista.map((linha)=>{
            return linha = '<li id="'+linha.id+'">'+ linha.descricao +'</li>';
          });    
          boxBusca.html(lista);   

          // adiciona o onclick para cada tag <li>
          let allList = boxBusca[0].querySelectorAll("li");
          for (let i = 0; i < allList.length; i++) {    
            allList[i].setAttribute('onclick', 'select(this, "' +boxBusca[0].id+ '","' +campoId +'","'+ campoText +'")');
          }               
      } 
      else{        
        $('#' +campoId).val('0');        
        boxBusca.hide();        
      }
    },
    error: function (e) {      
      console.log("loadDataToTable error: " + JSON.stringify(e));      
    }
  });  
}



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


//-- Coloca o foco no primeiro input do formulário
$('#editModal').on('shown.bs.modal', function(){
  $(this).closest('form').find('input').eq(0).focus();
});


// Call the dataTables jQuery plugin
$(document).ready(function(){

  loadDataToTable();
  
  //-- inicia o plugin para o input do tipo file
  bsCustomFileInput.init(); //-- descomentar para forms que usam o campo input de arquivo
});
