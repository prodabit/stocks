/* Salvar dados dos contatos */
$('#form_contatos').submit(function(e){
  
  e.preventDefault();  
  $('#modal_loading').show();           
  $.ajax({  
      url: baseURL +'/'+ $controller +'/salvarContatos',
      type: "POST",  
      data: new FormData(this),  
      async: false,
      contentType: false,  
      processData:false, 
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
                
            } 
          }catch(e) {     
            alert('Erro ao salvar o registro. Se o problema persistir, contate o suporte!');
          } 
      },
      complete: function(){
        $('#modal_loading').hide();          
        $('#contatosModal').modal('hide');         
      }
  });
});  



function contatos(pessoa_id, nome){
  
  $("#edt_pessoa_id").val(pessoa_id);
  $("#form_contatos")[0].reset(); //-- limpa todo o form  
  $('#modal_loading').show();           
  $.ajax({
      type: "post", 
      url: baseURL +'/'+ $controller +'/getContatosPessoa',
      data: {pessoa_id},            
      dataType: 'json',             
      async: true,
      success: function(data){
          if(data.length > 0){
            $.each(data, function(key, linha){
              $("#edt_tipo_contato" + (key+1)).val(linha.tipo_contato);
              $("#edt_contato" + (key+1)).val(linha.contato);
            });            
          }
      },
      complete: function(data) {  
          $("#contatosModalTitle").html('Cadastro de Contatos (' + nome +')');
          $('#modal_loading').hide();           
          $('#contatosModal').modal('show');
      }
  });   
};  