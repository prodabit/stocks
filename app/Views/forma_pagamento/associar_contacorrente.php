<form id="form_associar">
    <div class="modal fade" id="associarModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Associar com Conta Corrente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mb-1">                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="conta_corrente">Conta Corrente:</label>
                                    <select id="cc_conta_corrente" name="conta_corrente" class="custom-select custom-select-sm form-control form-control-sm">
                                        <!-- será preenchido via javascript -->                                    
                                    </select>                                
                                </div>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="cliente">Cliente Padrão:</label>
                                    <div class="input-group input-group-sm mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="bi bi-search" style="font-size: 0.685rem;"></i></div>
                                        </div>
                                        <input type="text" id="cc_cliente" name="cliente" autocomplete="off" placeholder="Buscar cliente..." class="form-control form-control-sm text-uppercase" maxlenght="100" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="cc_id_cliente" name="id_cliente" value="0">
                    <input type="hidden" id="cc_id_fpgto" name="id_fpgto" value="0">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>                    
                    <button type="button" class="btn btn-sm btn-info" id="editSalvarAssociar">Salvar Registro</button> 
                </div>
            </div>
        </div>
    </div>
</form>