<form id="formulario">
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastro/Edição de Categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mb-1">
                            <div class="col-12 col-sm-8">
                                <div class="row mb-1">
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group"><label for="descricao">Descrição:</label><input type="text" id="edt_descricao" name="descricao" class="form-control form-control-sm" maxlenght="100" /></div>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group"><label for="ordem">Ordem:</label><input type="number" id="edt_ordem" name="ordem" class="form-control form-control-sm" /></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <img src="" alt="foto" id="thumb_foto" class="img-thumbnail" style="width: 80px; height: 80px; margin-top:20px;">
                            </div>
                        </div>
                        
                        <div class="row mb-1">
                            <div class="col-8">
                                <div class="form-group">
                                    <label>Foto:</label>
                                    <div class="custom-file">
                                        <input type="file" onchange="previewFile()" class="custom-file-input form-control form-control-sm" id="edt_foto" name="foto" lang="pt">
                                        <label id="lbl_foto" class="custom-file-label" for="edt_foto">Escolha o arquivo</label>
                                    </div>
                                    <div class="mt-2 small">Obs: imagem (png/jpeg/gif) com max 100 KBytes por arquivo.</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group ml-3 mt-4">
                                    <div class="custom-file">
                                        <div class="form-group"><input type="checkbox" id="edt_excluir_foto" name="excluir_foto" class="form-check-input" /><label class="form-check-label" for="excluir_foto">Apagar foto</label></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-12 col-sm-3">
                                <div class="form-group ml-4"><input type="checkbox" id="edt_auto_atendimento" name="auto_atendimento" class="form-check-input" maxlenght="1" /><label class="form-check-label" for="auto_atendimento">Auto Atendimento</label></div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="form-group ml-4"><input type="checkbox" id="edt_ativo" name="ativo" class="form-check-input" maxlenght="1" /><label class="form-check-label" for="ativo">Ativo</label></div>
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