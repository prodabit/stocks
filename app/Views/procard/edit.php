<form id="formulario">
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastro/Edição de Cartão Procard</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mb-1 mt-3">
                            <div class="col-12 col-sm-4">
                                <div class="form-group"><label for="numero">Número/ID:</label><input type="text" id="edt_numero" name="numero" class="form-control form-control-sm" maxlenght="30" /></div>
                            </div>                            
                            <div class="col-12 col-sm-8">
                                <div class="form-group"><label for="usuario">Usuário:</label><input type="text" id="edt_usuario" name="usuario" class="form-control form-control-sm text-uppercase" maxlenght="100" /></div>
                            </div>
                        </div>  
                        <hr/>
                        <div class="row mb-1">
                            <div class="col-12 col-sm-6">
                                <div class="form-group"><label for="email">Email:</label><input type="text" id="edt_email" name="email" class="form-control form-control-sm" maxlenght="100" /></div>
                            </div>
                            <div class="col-12 col-sm-3 pl-1">
                                <div class="form-group"><label for="senha">Senha:</label><input type="password" id="edt_senha" name="senha" class="form-control form-control-sm" maxlenght="8" /></div>
                            </div>
                            <div class="col-12 col-sm-3 pl-1">
                                <div class="form-group"><label for="senha">Conf. Senha:</label><input type="password" id="edt_conf_senha" name="conf_senha" class="form-control form-control-sm" maxlenght="8" /></div>
                            </div>
                        </div>
                        <div class="row mb-1">                     
                            <div class="col-12 col-sm-6"> 
                                <div class="form-group">                                           
                                    <label for="status_procard">Status Procard:</label>
                                    <select id="edt_status_procard" name="status_procard" class="custom-select custom-select-sm form-control form-control-sm">
                                    <!-- será preenchido via javascript -->                                    
                                    </select>     
                                </div>
                            </div>  
                            <div class="col-12 col-sm-6 pl-1">                                            
                                <div class="form-group">
                                    <label for="procard_classe">Classe/Grupo:</label>
                                    <select id="edt_procard_classe" name="procard_classe" class="custom-select custom-select-sm form-control form-control-sm">
                                    <!-- será preenchido via javascript -->                                    
                                    </select>     
                                </div>
                            </div>                                    
                        </div> 
                        <div class="row mb-1"> 
                            <div class="col-12 col-sm-4">
                                <div class="form-group"><label for="limite_diario">Limite Diário:</label><input type="text" id="edt_limite_diario" name="limite_diario" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true" /></div>
                            </div>
                            <div class="col-12 col-sm-4 pl-1">
                                <div class="form-group"><label for="limite_credito">Limite Crédito:</label><input type="text" id="edt_limite_credito" name="limite_credito" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true" /></div>
                            </div>
                            <div class="col-12 col-sm-4 pl-1">
                                <div class="form-group"><label for="saldo">Saldo:</label><input type="text" id="edt_saldo" name="saldo" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true" readonly/></div>
                            </div>                            
                        </div>  
                        <hr/>
                        <div class="row mb-1">
                            <div class="col-12 col-sm-4">
                                <div class="form-group"><label for="data_cadastro">Data Cadastro:</label><input type="date" id="edt_data_cadastro" name="data_cadastro" class="form-control form-control-sm" readonly/></div>
                            </div>
                            <div class="col-12 col-sm-4 pl-1">
                                <div class="form-group"><label for="ultimo_acesso">Último Acesso:</label><input type="date" id="edt_ultimo_acesso" name="ultimo_acesso" class="form-control form-control-sm" readonly/></div>
                            </div>   
                            <div class="col-12 col-sm-4 pl-1">
                                <div class="form-group"><label for="acessos">Acessos:</label><input type="number" id="edt_acessos" name="acessos" class="form-control form-control-sm" readonly/></div>
                            </div>                         
                        </div>
                        <div class="row ml-2">                            
                            <div class="col-6 col-sm-2">
                                <div class="form-group ml-4"><input type="checkbox" id="edt_ativo" name="ativo" class="form-check-input" /><label class="form-check-label" for="ativo">Ativo</label></div>
                            </div>
                            <div class="col-6 col-sm-2">
                                <div class="form-group ml-4"><input type="checkbox" id="edt_admin" name="admin" class="form-check-input" /><label class="form-check-label" for="admin">Admin</label></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="edt_id" name="id"/>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>
                    <button class="btn btn-sm btn-info" type="submit" id="editSalvar">Salvar Registro</button>
                </div>
            </div>
        </div>
    </div>
</form>