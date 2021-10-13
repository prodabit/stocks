<form id="formulario">
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastro/Edição de Conta Corrente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mb-1">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="empresa">Empresa:</label>
                                    <select id="edt_empresa" name="empresa" class="custom-select custom-select-sm form-control form-control-sm">
                                        <!-- será preenchido via javascript -->                                    
                                    </select>                                
                                </div>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-12 col-sm-8">
                                <div class="form-group"><label for="descricao">Descrição:</label><input type="text" id="edt_descricao" name="descricao" class="form-control form-control-sm text-uppercase" maxlenght="100" /></div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="form-group"><label for="saldo">Saldo:</label><input type="text" id="edt_saldo" name="saldo" class="form-control form-control-sm" data-mask="#####0.00" data-mask-reverse="true"/></div>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-12 col-sm-4">
                                <div class="form-group"><label for="cod_banco">Codigo Banco:</label><input type="text" id="edt_cod_banco" name="cod_banco" class="form-control form-control-sm" maxlenght="5" /></div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="form-group"><label for="agencia">Agência:</label><input type="text" id="edt_agencia" name="agencia" class="form-control form-control-sm" maxlenght="10" /></div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="form-group"><label for="num_conta">Número da Conta:</label><input type="text" id="edt_num_conta" name="num_conta" class="form-control form-control-sm" maxlenght="15" /></div>
                            </div>
                        </div>
                        <div class="row mb-1 mt-sm-3">
                            <div class="col-6 col-sm-2">
                                <div class="form-group ml-4"><input type="checkbox" id="edt_caixa" name="caixa" class="form-check-input" /><label class="form-check-label" for="caixa">Caixa</label></div>
                            </div>
                            <div class="col-6 col-sm-2">
                                <div class="form-group ml-4"><input type="checkbox" id="edt_padrao" name="padrao" class="form-check-input" /><label class="form-check-label" for="padrao">Padrão</label></div>
                            </div>
                            <div class="col-6 col-sm-2">
                                <div class="form-group ml-4"><input type="checkbox" id="edt_master" name="master" class="form-check-input" /><label class="form-check-label" for="master">Master</label></div>
                            </div>
                            <div class="col-6 col-sm-2">
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