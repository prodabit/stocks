<form id="form_contatos">
    <div class="modal fade" id="contatosModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contatosModalTitle">Cadastro de Contatos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">         
                        <div class="row mt-2">                     
                            <div class="col-12 col-sm-3"> 
                                <div class="form-group">                                           
                                    <label for="tipo_contato1">Tipo:</label>
                                    <select id="edt_tipo_contato1" name="tipo_contato1" class="custom-select custom-select-sm form-control form-control-sm">
                                        <option value="CEL" selected>CELULAR</option>    
                                        <option value="COM">TEL.COM.</option>
                                        <option value="RES">TEL.RES.</option>                                        
                                        <option value="EMAIL">EMAIL</option>
                                    </select>     
                                </div>
                            </div>  
                            <div class="col-12 col-sm-9 pl-1">                                                                            
                                <div class="form-group"><label for="contato1">Contato:</label><input type="text" id="edt_contato1" name="contato1" class="form-control form-control-sm" maxlenght="20" /></div>                                
                            </div>  
                        </div>
                        <div class="row">                     
                            <div class="col-12 col-sm-3"> 
                                <div class="form-group">                                           
                                    <label for="tipo_contato2">Tipo:</label>
                                    <select id="edt_tipo_contato2" name="tipo_contato2" class="custom-select custom-select-sm form-control form-control-sm">
                                        <option value="CEL">CELULAR</option>    
                                        <option value="COM" selected>TEL.COM.</option>
                                        <option value="RES">TEL.RES.</option>                                        
                                        <option value="EMAIL">EMAIL</option>
                                    </select>     
                                </div>
                            </div>  
                            <div class="col-12 col-sm-9 pl-1">                                                                            
                                <div class="form-group"><label for="contato2">Contato:</label><input type="text" id="edt_contato2" name="contato2" class="form-control form-control-sm" maxlenght="20" /></div>                                
                            </div>  
                        </div>
                        <div class="row">                     
                            <div class="col-12 col-sm-3"> 
                                <div class="form-group">                                           
                                    <label for="tipo_contato3">Tipo:</label>
                                    <select id="edt_tipo_contato3" name="tipo_contato3" class="custom-select custom-select-sm form-control form-control-sm">
                                        <option value="CEL">CELULAR</option>    
                                        <option value="COM">TEL.COM.</option>
                                        <option value="RES" selected>TEL.RES.</option>                                        
                                        <option value="EMAIL">EMAIL</option>
                                    </select>     
                                </div>
                            </div>  
                            <div class="col-12 col-sm-9 pl-1">                                                                            
                                <div class="form-group"><label for="contato3">Contato:</label><input type="text" id="edt_contato3" name="contato3" class="form-control form-control-sm" maxlenght="20" /></div>                                
                            </div>  
                        </div>
                        <div class="row">                     
                            <div class="col-12 col-sm-3"> 
                                <div class="form-group">                                           
                                    <label for="tipo_contato4">Tipo:</label>
                                    <select id="edt_tipo_contato4" name="tipo_contato4" class="custom-select custom-select-sm form-control form-control-sm">
                                        <option value="CEL">CELULAR</option>    
                                        <option value="COM">TEL.COM.</option>
                                        <option value="RES">TEL.RES.</option>                                        
                                        <option value="EMAIL" selected>EMAIL</option>
                                    </select>     
                                </div>
                            </div>  
                            <div class="col-12 col-sm-9 pl-1">                                                                            
                                <div class="form-group"><label for="contato4">Contato:</label><input type="text" id="edt_contato4" name="contato4" class="form-control form-control-sm" maxlenght="20" /></div>                                
                            </div>  
                        </div>
                        <div class="row">                     
                            <div class="col-12 col-sm-3"> 
                                <div class="form-group">                                           
                                    <label for="tipo_contato5">Tipo:</label>
                                    <select id="edt_tipo_contato5" name="tipo_contato5" class="custom-select custom-select-sm form-control form-control-sm">
                                        <option value="CEL">CELULAR</option>    
                                        <option value="COM">TEL.COM.</option>
                                        <option value="RES">TEL.RES.</option>                                        
                                        <option value="EMAIL" selected>EMAIL</option>
                                    </select>     
                                </div>
                            </div>  
                            <div class="col-12 col-sm-9 pl-1">                                                                            
                                <div class="form-group"><label for="contato5">Contato:</label><input type="text" id="edt_contato5" name="contato5" class="form-control form-control-sm" maxlenght="20" /></div>                                
                            </div>  
                        </div>
                    </div>                      
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="edt_pessoa_id" name="pessoa_id"/>                    
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>
                    <button class="btn btn-sm btn-info" type="submit" id="editSalvarContatos">Salvar Registro</button>
                </div>
            </div>
        </div>
    </div>
</form>