const $controller = 'produto';

/* Datatable para a lista principal do módulo */
$("#dataTable").DataTable({
  "lengthMenu": [[10, 15, 50, -1], [10, 15, 50, "Todos"]],
  "pageLength": 15,
  responsive: true,
  searching: true,
  "bLengthChange": true,
  columnDefs: [
  {responsivePriority: 0, targets: 0},
  {responsivePriority: 1, targets: 1},
  {targets: [8], className: 'dt-body-center'}
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



/* Carrega a lista de produtos para a tabela principal */
function loadDataToTable() {  
  $('#modal_loading').show();           
  $.ajax({
    type: 'POST',
    url: baseURL +'/'+ $controller +'/getListMinJson',        
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
      if(data[i].kit === '1'){
        botoes += '<button type="button" Title="Kit/Combo" class="btn btn-sm btn-clean btn-icon btn-icon-md px-1 py-0" onclick="composicao('+data[i].id+',\''+data[i].descricao+'\')"><i class="bi bi-columns-gap text-warning"></i></button>';
      } 
      ativo = '<i class="bi bi-check2-all text-success"></i>';
      if(data[i].ativo !== null && data[i].ativo !== '1') ativo = '<i class="bi bi-x-circle text-danger"></i>';
      $('#dataTable').dataTable().fnAddData([
        data[i].id,
        data[i].codigo,
        data[i].ean,
        data[i].descricao,
        data[i].preco_compra,
        data[i].preco_minimo,
        data[i].preco_venda,
        data[i].estoque,
        ativo,
        botoes
      ]);
    }
};



/* Novo Registro para o cadastro de produtos */
$("#btn_novo").click(() => {
  $("#formulario")[0].reset(); //-- limpa todo o form  
  var data = new Date().toISOString().slice(0, 10);
  $("#edt_id").val(0);
  $("#edt_categoria").val(1);
  $("#edt_fabricante").val(1);
  $("#edt_preco_compra").val("0.00");
  $("#edt_preco_minimo").val("0.00");
  $("#edt_preco_venda").val("0.00");
  $("#edt_estoque").val("0.00");
  $("#edt_estoque_anterior").val("0.00");
  $("#edt_unidade").val("UN");  
  $("#edt_data_cadastro").val(data);
  $("#edt_data_ult_compra").val(data);
  $("#edt_data_ult_venda").val("");
  $("#edt_peso").val("0");    
  $("#edt_cst").val("060");
  $("#edt_ncm").val("16025000");  
  $("#edt_cfop").val("5405");
  $("#edt_csosn").val("500");  
  $("#edt_taxa_ipi").val("0");
  $("#edt_taxa_issqn").val("0");
  $("#edt_taxa_pis").val("0");
  $("#edt_taxa_cofins").val("0");
  $("#edt_taxa_icms").val("0");
  $("#edt_taxa_fcp").val("0");
  $("#edt_cst_pis").val("07");
  $("#edt_cst_cofins").val("07");
  $("#edt_cst_ipi").val("53");  
  $("#edt_cest").val("17.048.02"); //-- massas alimenticeas
  $("#edt_tabela").prop("checked", true);  
  $("#edt_producao").prop("checked", true);        
  $("#edt_ativo").prop("checked", true);
  $('#edt_excluir_foto').val('0')
  $('#editModal').modal('show');
  ActivateFirstTab();
});  



/* Editar Registro do cadastro de produtos */
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
              $("#edt_categoria").val(data.categoria_id);
              $("#edt_fabricante").val(data.fabricante_itens_id);
              $("#edt_ncm").val(data.ncm);
              $("#edt_codigo").val(data.codigo);
              $("#edt_ean").val(data.ean);
              $("#edt_descricao").val(data.descricao);
              $("#edt_cor").val(data.cor);
              $("#edt_tamanho").val(data.tamanho);
              $("#edt_serie").val(data.serie);
              $("#edt_preco_compra").val(data.preco_compra);
              $("#edt_preco_minimo").val(data.preco_minimo);
              $("#edt_preco_venda").val(data.preco_venda);
              $("#edt_estoque").val(data.estoque);
              $("#edt_estoque_anterior").val(data.estoque_anterior);
              $("#edt_unidade").val(data.unidade);
              $("#edt_modelo").val(data.modelo);
              $("#edt_data_cadastro").val((data.data_cadastro).substr(0,10));
              $("#edt_data_ult_compra").val(data.data_ult_compra); //-- já esta no formato 
              $("#edt_data_ult_venda").val(data.data_ult_venda);   //-- já esta no formato 
              $("#edt_peso").val(data.peso);
              $("#edt_iat").prop("checked", data.iat === "1");
              $("#edt_ippt").prop("checked", data.ippt === "1");
              $("#edt_comissao").val(data.comissao);
              $("#edt_cst").val(data.cst);
              $("#edt_csosn").val(data.csosn);
              $("#edt_tipo_item_sped").val(data.tipo_item_sped);
              $("#edt_taxa_ipi").val(data.taxa_ipi);
              $("#edt_taxa_issqn").val(data.taxa_issqn);
              $("#edt_taxa_pis").val(data.taxa_pis);
              $("#edt_taxa_cofins").val(data.taxa_cofins);
              $("#edt_taxa_icms").val(data.taxa_icms);
              $("#edt_taxa_fcp").val(data.taxa_fcp);
              $("#edt_cst_pis").val(data.cst_pis);
              $("#edt_cst_cofins").val(data.cst_cofins);
              $("#edt_cst_ipi").val(data.cst_ipi);
              $("#edt_cfop").val(data.cfop);
              $("#edt_cest").val(data.cest);
              $("#edt_tabela").prop("checked", data.tabela === "1");
              $("#edt_kit").prop("checked", data.kit === "1");
              $("#edt_producao").prop("checked", data.producao === "1");
              $("#edt_calcula_peso").prop("checked", data.calcula_peso === "1");
              $("#edt_produtos_similares").val(data.produtos_similares);
              $("#edt_comanda_id").val(data.comanda_id);
              $("#edt_nutri_id").val(data.nutri_id);
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
          ActivateFirstTab();
      }
  });   
};  



/* Envia dados do formulário do cadastro de produtos para salvar */
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
      success: function(response) {                
          try{
            if(response['status'] === 'error'){
                swal.fire({icon: 'error',
                        title: 'Oops...',
                        text: response['message']}
                );    
            }else{
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



/* função excluir. Seta o campo ativo do registro para '2' */    
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
    case 'edt_unidade':    tabela = 'unidade_produto'; break;
    case 'edt_categoria':  tabela = 'categoria'; break;
    case 'edt_fabricante': tabela = 'fabricante_itens'; break;
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



//-- Coloca o foco no primeiro input do formulário de edição de produtos
$('#editModal').on('shown.bs.modal', function(){
  $(this).closest('form').find('input').eq(0).focus();
});


/* Ativa a primeira tab do cadatro de produtos modal */
function ActivateFirstTab() {
  $('a[href="#home"]').tab('show');
}


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



/* Fim das funções da tela de protudos ---------------------------- */
/* ---------------------------------------------------------------- */


/* Obtém a lista de itens que compoem um produto composto */
function composicao(id, descricao){
  $('#edt_id').val(id); //-- coloca o id do produto no campo 
  $("#box_search_combo_produto").hide();     
  $('#modal_loading').show();           
  $.ajax({
      type: "post", 
      url: baseURL +'/'+ $controller +'/getListProdCompostoJson',
      data: {id},            
      dataType: 'json',             
      async: true,
      success: function(data){
          
        $("#combo_form")[0].reset(); //-- limpa todo o form  
          $("#combo_table > tbody").empty();

          if(data.length > 0){            
            //-- coloca o nome do produto composto no título do Modal
            $("#comboTitle").text('Combos/Kits (' + descricao +')');
            $.each(data, function(key, linha){              
              
              var listitems = 
              '<tr><td>'+ linha.produto_id +'</td>'+
              '<td>'+ linha.codigo +'</td>'+
              '<td>'+ linha.descricao +'</td>'+
              '<td>'+ linha.preco_compra +'</td>'+
              '<td>'+ linha.qtde +'</td>'+
              '<td>'+ linha.valor +'</td>'+
              '<td class="tdComboBtnDelete"><button type="button" Title="Excluir" class="btn btn-sm btn-clean btn-icon btn-icon-md px-1 py-0 btnComboDelete"><i class="bi bi-x-circle-fill text-danger"></i></button></td></tr>';
              $("#combo_table > tbody").append(listitems);
            });            
          }
      },
      complete: function(data) {  
          $('#modal_loading').hide();                     
          $('#kit_produto_modal').modal('show');               
      }
  });   
};  



/* Adiciona um botão para apagar um item da tabela/lista de itens do combo */
$('#combo_table').on('click', '.btnComboDelete', function() { 
  $(this).closest("tr").remove();
});



/*  Coloca o foco no segundo input do formulário de produtos compostos */
$('#kit_produto_modal').on('shown.bs.modal', function(){
  $(this).closest('form').find('input').eq(0).focus();
})



/* Exibe a lista de produtos na busca do modal de produtos compostos */
$('#combo_produto').keyup(delay(function(e){
  var search = $(this).val();
  if(search.length > 1){
    loadResultSearchProdutosCombo(search);        
  }
}, 300));



/* Função utilizada para dar um delay na busca de produtos da tela de produtos compostos */
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



/* Função para buscar no servidor uma lista de produtos de acordo com o filtro enviado (codigo e descricao) */
function loadResultSearchProdutosCombo(filtro) {
  $('#combo_produto_id').val('0');        
  $("#combo_search_table > tbody").empty();
  var boxBusca = $("#box_search_combo_produto");
  boxBusca.hide();  
  vUrl = baseURL +'/produto/getListFiltroJson';
  
  $.ajax({
    type: 'POST',
    url: vUrl, 
    data: {filtro},    
    dataType: 'json',
    success: function (lista){     
      if(lista.length > 0) {          
        var listitems = '';
        $.each(lista, function(key, linha){             
          listitems += 
          '<tr>'+
          '<td>'+ linha.id +'</td>'+
          '<td>'+ linha.codigo +'</td>'+          
          '<td>'+ linha.descricao +'</td>'+
          '<td>'+ linha.preco_compra +'</td>'+         
          '<td>'+ linha.preco_venda +'</td>';          
        });     
        $("#combo_search_table > tbody").append(listitems);
        boxBusca.show();   
        
        /*-- Adiciona o onclick para cada tag <li> --*/
        let allList = boxBusca[0].querySelectorAll("li");
        for (let i = 0; i < allList.length; i++) {    
          allList[i].setAttribute('onclick', 'select(this)');
        }               
      } 
      else{boxBusca.hide();}
    },
    error: function (e) {      
      console.log("loadDataToTable error: " + JSON.stringify(e));      
    }
  });  
}



/* Evento de Click na tabela de resultados da busca por produto no modal de combos */
$('#combo_search_table').click(function(e) { 
    var id = $(e.target).closest('tr').children("td:first").text();
    var codigo = $(e.target).closest('tr').find("td:nth-child(2)").text();
    var desc = $(e.target).closest('tr').find("td:nth-child(3)").text();
    var pcompra = $(e.target).closest('tr').find("td:nth-child(4)").text();
    var pvenda = $(e.target).closest('tr').find("td:nth-child(5)").text();
    $('#combo_produto_id').val(id);
    $('#combo_codigo').val(codigo);
    $('#combo_produto').val(desc);  
    $('#combo_preco_compra').val(pcompra);  
    $('#combo_valor').val(pvenda);  
    $('#combo_qtde').val('1.00');      
    $("#box_search_combo_produto").hide();     
});


/* Salva os dados dos itens de um produtos composto */
$('#btnSalvarComposto').click(() => {  
  /* converte a tebala html para json */
  var json_tbl = $('#combo_table tbody tr').get().map(function(row) {
    return $(row).find('td').get().map(function(cell) {
      if($(cell).hasClass('tdComboBtnDelete')){return ''} 
      else{return $(cell).html();}
    });
  });

  id = $('#edt_id').val();
  if(id == '0'){
    swal.fire({icon: 'warning', title: 'Oops...', text: 'O produto composto não foi localizado. Selecione o produto na lista de produtos novamente.'}); 
  }

  $.ajax({
    type: 'POST',
    url: baseURL +'/'+ $controller +'/saveProdutosKit',        
    data: {id, tabela: json_tbl},    
    dataType: 'json',
    success: function(response) {                
      try{
        if(response['status'] === 'error'){
            swal.fire({icon: 'error',
                    title: 'Oops...',
                    text: response['message']}
            );    
        }else{
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
})



/* Evento de Click no botão de adicionar itens em um produto composto */
$("#comboAdd").click(() => {
    var id = $('#combo_produto_id').val()
    if(id === $('#edt_id').val()){
      swal.fire({icon: 'warning', title: 'Oops...', text: 'O item não pode ser igual ao produto composto!'});       
      $('#combo_produto_id').focus();
      return;
    }
    
    var codigo = $('#combo_codigo').val();
    var desc = $('#combo_produto').val(); 
    var pcompra = $('#combo_preco_compra').val();  
    var valor = $('#combo_valor').val(); 
    var qtde = $('#combo_qtde').val(); 

    var linha = 
    '<tr>'+
    '<td>'+ id +'</td>'+
    '<td>'+ codigo +'</td>'+          
    '<td>'+ desc +'</td>'+
    '<td>'+ pcompra +'</td>'+         
    '<td>'+ qtde +'</td>'+
    '<td>'+ valor +'</td>'+
    '<td><button type="button" Title="Excluir" class="btn btn-sm btn-clean btn-icon btn-icon-md px-1 py-0 btnComboDelete"><i class="bi bi-x-circle-fill text-danger"></i></button></td></tr>';
     $("#combo_table > tbody").append(linha);
});     


// Call the dataTables jQuery plugin
$(document).ready(function(){
  loadComboSelect('edt_unidade');
  loadComboSelect('edt_categoria');
  loadComboSelect('edt_fabricante');  
  loadDataToTable();  
    
  //-- inicia o plugin para o input do tipo file
  //bsCustomFileInput.init(); //-- descomentar para forms que usam o campo input de arquivo
});
