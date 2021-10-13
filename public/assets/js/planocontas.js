const $controller = 'planocontas';


function loadData() {
  
  $('#modal_loading').show();           
  $.ajax({
    type: 'POST',
    url: baseURL +'/'+ $controller +'/getListRecursiveJson',        
    contentType: "text/plain",
    success: function (myJsonData) {   
      
      $('.card-body').empty().append(myJsonData);
    },
    complete: function(){
      associarBlcikBotoesTreeView();
      associarClickListLi();
      $('#modal_loading').hide();           
    },
    error: function (e) {      
      console.log("loadData error: " + JSON.stringify(e));
    }
  });
}



function associarBlcikBotoesTreeView(){
  var toggler = document.getElementsByClassName("bi-caret-right-fill");
  var i;

  for (i = 0; i < toggler.length; i++) {
    toggler[i].addEventListener("click", function() {
      this.parentElement.querySelector(".nested").classList.toggle("active");
      this.classList.toggle("bi-caret-right-fill");
      this.classList.toggle("bi-caret-down-fill");
    });
  }
}


function associarClickListLi(){
    
  $("#tree_view").on("click","li",function(e) {
    e.stopPropagation();
    $("#edt_id").val(this.id);
    $("#edt_chave_pai").val(this.innerText);
    
    
    $("#tree_view li").removeClass("font-weight-bold");
    this.classList.add("font-weight-bold");
    //editar(this.id); 
  });  
}



/* Novo Registro */
$("#btn_novo").click(() => {
  
  id = $("#edt_id").val();
  if(id === "0"){
      Swal.fire(
        'Selecione um registro',
        'Selecione um plano de contas para ser o pai do novo registro.',
        'warning'
      )
      return;
  };
  
  $("#row-chave-pai").show();
  $("#edt_descricao").val('');
  $("#edt_ativo").prop("checked", true);
  $("#edt_novo").val('true');  
  $('#editModal').modal('show');
});  


/* Editar Registro */
$("#btn_editar").click(() => {
  
  id = $("#edt_id").val();
  if(id === "0"){
      Swal.fire(
        'Selecione um registro',
        'Selecione um registro para edição.',
        'warning'
      )
      return;
  };  
  
  $("#row-chave-pai").hide();
  $("#edt_descricao").val($("#edt_chave_pai").val());
  $("#edt_novo").val('false');  
  $("#edt_ativo").prop("checked", true);
  $('#editModal').modal('show');
});  



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
                loadData();                 
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



//-- Coloca o foco no segundo input do formulário
$('#editModal').on('shown.bs.modal', function(){
  $(this).closest('form').find('input').eq(1).focus();
})



// Call the dataTables jQuery plugin
$(document).ready(function(){

  loadData();  
});
