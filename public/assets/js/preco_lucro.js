/* Change Empresa */
$('#lst_empresa').change(function() {
  
  cnpj   = $(this).val();
  ticker = ($('#lst_empresa option:selected').text()).substring(0,5);  

  if(cnpj === "" || ticker === ""){
    swal.fire({icon: 'error', title: 'Oops...', text: 'Selecione uma empresa antes de prosseguir!'});
    return;
  }

  //---- Obtém os dados para gerar o gráfico preço-lucro -------------//
  $('#modal_loading').show();           
  $.ajax({
      type: "post", 
      url: baseURL +'/analise/getListPrecoxBalanco',
      //url: baseURL +'/analise/getListPrecoLucroSemanalJson',
      data: {cnpj, ticker},
      dataType: 'json',             
      success: function(response) {                
        try{if(response['status'] === 'error'){swal.fire({icon: 'error', title: 'Oops...',text: response['message']});}
        }catch(e) {alert('Erro ao salvar o registro. Se o problema persistir, contate o suporte!');};
      },
      complete: function(data){
        dados = generateChart(data.responseJSON);
        myChart.data = dados;
        myChart.update();
        $('#modal_loading').hide();
      }
  });   
});



var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {  
  type: 'line',
  data: {},
  options: { 
    interaction: {
      axis: 'xy',
      mode: 'index'
    }, 
    maintainAspectRatio: false,  
    responsive: true,
    scales: {
      y: {beginAtZero: true}
    },
  } 
});



function generateChart(dados){

  if(dados == undefined || dados.length == 0) return;
  
  labels        = (dados.label).split(","); 
  cotacoes      = JSON.parse(dados.cotacoes);
  lucro         = JSON.parse(dados.v401);
  ativo_total   = JSON.parse(dados.v1);
  patr_liquido  = JSON.parse(dados.v203);
  caixa_liquido = JSON.parse(dados.v601);
  qtde_acoes    = JSON.parse(dados.qtde_acoes);
  
  //-- caso o último lucro liquido seja zero, repete o penultimo
  if(lucro[lucro.length-1] == "0"){
    lucro[lucro.length-1] = lucro[lucro.length-2];
  };
  
  const data = {
    labels: labels,
    datasets: [{
      label: 'Cotação (Ajust).',
      borderColor: '#1e78b5',
      backgroundColor: '#89ceec',   
      borderDash: [5, 5],
      data: cotacoes,
    },
    {
      label: 'L.Líquido',
      backgroundColor: '#b4eadb45',
      borderColor: 'rgb(32, 178, 170)',
      data: lucro,
      fill: "-1"
    },
    {
      label: 'Patr.Liquido',
      backgroundColor: '#d0f1c4a1',
      borderColor: '#99d683e8',
      data: patr_liquido,
      hidden: true,
      fill: "-2"
    },
    {
      label: 'Ativo Total',
      backgroundColor: '#c16744',
      borderColor: '#c16744',
      data: ativo_total,
      hidden: true
      //fill: "-1"
    },
    {
      label: 'Caixa.Liquido',
      backgroundColor: '#539de8',
      borderColor: '#2d7fd2',
      data: caixa_liquido,
      hidden: true
      //fill: "-1"
    },
    {
      label: 'Qtde Ações',
      backgroundColor: '#6a71abb0',
      borderColor: '#363f8aba',
      data: qtde_acoes,
      hidden: true
      //fill: "-1"
    }]
  };  
  return data;  
  //var myChart = new Chart(ctx, config);
};


/****************************************************************************************
Criar uma biblioteca com estes campos abaixo */
const COLORS = [
  '#4dc9f6',
  '#f67019',
  '#f53794',
  '#537bc4',
  '#acc236',
  '#166a8f',
  '#00a950',
  '#58595b',
  '#8549ba'
];

function color(index) {
  return COLORS[index % COLORS.length];
}


const CHART_COLORS = {
  red: 'rgb(255, 99, 132)',
  orange: 'rgb(255, 159, 64)',
  yellow: 'rgb(255, 205, 86)',
  green: 'rgb(75, 192, 192)',
  blue: 'rgb(54, 162, 235)',
  purple: 'rgb(153, 102, 255)',
  grey: 'rgb(201, 203, 207)'
};

const NAMED_COLORS = [
  CHART_COLORS.red,
  CHART_COLORS.orange,
  CHART_COLORS.yellow,
  CHART_COLORS.green,
  CHART_COLORS.blue,
  CHART_COLORS.purple,
  CHART_COLORS.grey,
];

function namedColor(index) {
  return NAMED_COLORS[index % NAMED_COLORS.length];
}
/***************************************************************************************/


/* Atualiza cotações */
$("#btn_refresh").click(() => {
  
  if($('#lst_empresa').val() === '0'){
    return;
  }
  var ticker = $('#lst_empresa option:selected').text();
  ticker = ticker.substring(0,5);
  if(ticker !== ""){
    loadStockPrices(ticker);
    $('#lst_empresa').trigger("change");    
  }
});  


function loadStockPrices(ticker){

  $('#modal_loading').show();           
  $.ajax({
    type: 'POST',
    url: baseURL +'/importacoes/updateStockPrices',        
    dataType: 'json',
    data: {ticker},
    success: function(response) {                
      try{        
        if(response['status'] === 'error'){
            swal.fire({icon: 'error',
                    title: 'Oops...',
                    text: response['message']}
            );    
        }
        else{
            swal.fire("Tudo certo!", response['message']);
        } 
      }catch(e) {     
        alert('Erro ao salvar o registro. Se o problema persistir, contate o suporte!');
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



/* Função para carregar a lista no combo Setor */
function loadComboEmpresa() {  
  $.ajax({
    type: 'POST',
    url: baseURL +'/empresa/getListMinJson',        
    dataType: 'json',
    success: function (myJsonData) {      
      
      if(myJsonData.length > 0){
        var listitems = '<option value=0>Selecione...</option>';
        $.each(myJsonData, function(key, linha){
          if(linha.analise === "1"){
            listitems += '<option value=' + linha.cnpj + '>' + (linha.codigo_negoc).substring(0,5) + ' | ' + linha.nome + '</option>';
          }
        });
        $('#lst_empresa').append(listitems);        
      }
    },
    error: function (e) {      
      console.log("loadDataToTable error: " + JSON.stringify(e));
    }
  });
}



// Call the dataTables jQuery plugin
$(document).ready(function(){

  loadComboEmpresa();
  //generateChart();
  
  //-- inicia o plugin para o input do tipo file
  //bsCustomFileInput.init(); //-- descomentar para forms que usam o campo input de arquivo
});
