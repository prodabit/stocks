<form id="formulario">
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastro/Edição de forma_pagamento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mb-1">
                            <div class="col-12 col-sm-12">
                                <div class="form-group"><label for="descricao">Descricao:</label><input type="text" id="edt_descricao" name="descricao" class="form-control form-control-sm" maxlenght="100" /></div>
                            </div>
                        </div>
                        <div class="row mb-1 mb-sm-3">
                            <div class="col-12 col-sm-4">
                                <div class="form-group"><label for="liquidez">Liquidez:</label><input type="number" id="edt_liquidez" name="liquidez" class="form-control form-control-sm" maxlenght="6" /></div>
                            </div>                        
                            <div class="col-12 col-sm-4">
                                <div class="form-group"><label for="taxa_adic">Taxa Adicional:</label><input type="number" id="edt_taxa_adic" name="taxa_adic" class="form-control form-control-sm" maxlenght="oubl" /></div>
                            </div>                        
                            <div class="col-12 col-sm-4">
                                <div class="form-group"><label for="parcelas">Parcelas:</label><input type="number" id="edt_parcelas" name="parcelas" class="form-control form-control-sm" maxlenght="6" /></div>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-6 col-sm-4">
                                <div class="form-group ml-4"><input type="checkbox" id="edt_precisa_cliente" name="precisa_cliente" class="form-check-input" /><label class="form-check-label" for="precisacliente">Precisa de Cliente</label></div>
                            </div>
                            <div class="col-6 col-sm-4">
                                <div class="form-group ml-4"><input type="checkbox" id="ativo" name="gera_comissao" class="form-check-input" /><label class="form-check-label" for="geracomissao">Gera Comissão</label></div>
                            </div>                            
                        </div>
                        <div class="row mb-0">
                            <div class="col-6 col-sm-4">
                                <div class="form-group ml-4"><input type="checkbox" id="edt_procard" name="procard" class="form-check-input" /><label class="form-check-label" for="procard">Procard</label></div>
                            </div>
                            <div class="col-6 col-sm-4">
                                <div class="form-group ml-4"><input type="checkbox" id="edt_financeiro" name="financeiro" class="form-check-input" /><label class="form-check-label" for="financeiro">Financeiro</label></div>
                            </div>
                            <div class="col-6 col-sm-4">
                                <div class="form-group ml-4"><input type="checkbox" id="edt_ativo" name="ativo" class="form-check-input" /><label class="form-check-label" for="ativo">Ativo</label></div>
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