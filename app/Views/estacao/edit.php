<form id="formulario">
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastro/Edição de estacao</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mb-1">
                            <div class="col-12 col-sm-12">
                                <div class="form-group"><label for="nome">Nome:</label><input type="text" id="edt_nome" name="nome" class="form-control form-control-sm" maxlenght="45" /></div>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-12 col-sm-12">
                                <div class="form-group"><label for="local">Local:</label><input type="text" id="edt_local" name="local" class="form-control form-control-sm" maxlenght="200" /></div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4">
                            <div class="form-group ml-4"><input type="checkbox" id="edt_ativo" name="ativo" class="form-check-input" /><label class="form-check-label" for="ativo">Ativo</label></div>
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