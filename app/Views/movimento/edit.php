<form id="formulario">
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastro/Edição de Movimento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mb-1 mt-3">
                            <div class="col-12 col-sm-8">
                                <label for="usuario">Usuário:</label>
                                <select id="edt_usuario" name="usuario" class="custom-select custom-select-sm form-control form-control-sm">
                                <!-- será preenchido via javascript -->                                    
                                </select>   
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="form-group"><label for="estacao">Estacao:</label><input type="text" id="edt_estacao" name="estacao" class="form-control form-control-sm" readonly/></div>
                            </div>
                        </div>
                        <hr/>

                        <div class="row mb-1 mt-3">
                            <div class="col-12 col-sm-3">
                                <div class="form-group"><label for="data_hora_abertura">Data_hora_abertura:</label><input type="date" id="edt_data_hora_abertura" name="data_hora_abertura" class="form-control form-control-sm" data-mask="00/00/0000" readonly/></div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <div class="form-group"><label for="data_hora_fechamento">Data_hora_fechamento:</label><input type="date" id="edt_data_hora_fechamento" name="data_hora_fechamento" class="form-control form-control-sm" data-mask="00/00/0000" readonly/></div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <div class="form-group"><label for="total_suprimento">Total_suprimento:</label><input type="text" id="edt_total_suprimento" name="total_suprimento" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true" readonly/></div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <div class="form-group"><label for="total_sangria">Total_sangria:</label><input type="text" id="edt_total_sangria" name="total_sangria" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true" readonly/></div>
                            </div>
                        </div>

                        <div class="row mb-1">
                            <div class="col-12 col-sm-3">
                                <div class="form-group"><label for="total_venda">Total_venda:</label><input type="text" id="edt_total_venda" name="total_venda" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true" readonly/></div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <div class="form-group"><label for="total_desconto">Total_desconto:</label><input type="text" id="edt_total_desconto" name="total_desconto" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true" readonly/></div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <div class="form-group"><label for="total_acrescimo">Total_acrescimo:</label><input type="text" id="edt_total_acrescimo" name="total_acrescimo" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true" readonly/></div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <div class="form-group"><label for="total_final">Total_final:</label><input type="text" id="edt_total_final" name="total_final" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true" readonly/></div>
                            </div>
                        </div>

                        <div class="row mb-1">
                            <div class="col-12 col-sm-3">
                                <div class="form-group"><label for="total_recebido">Total_recebido:</label><input type="text" id="edt_total_recebido" name="total_recebido" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true" readonly/></div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <div class="form-group"><label for="total_troco">Total_troco:</label><input type="text" id="edt_total_troco" name="total_troco" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true" readonly/></div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <div class="form-group"><label for="total_cancelado">Total_cancelado:</label><input type="text" id="edt_total_cancelado" name="total_cancelado" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true" readonly/></div>
                            </div>
                            <div class="col-6 col-sm-3">
                                <label for="status_movimento">Status Movimento:</label>
                                <select id="edt_status_movimento" name="status_movimento" class="custom-select custom-select-sm form-control form-control-sm" readonly>
                                    <option value="A" selected>ABERTO</option>
                                    <option value="F">FECHADO</option>                            
                                </select>                               
                            </div>
                        </div>
                        <div class="col-6 col-sm-4">
                            <div class="form-group ml-3"><input type="checkbox" id="edt_ativo" name="ativo" class="form-check-input" /><label class="form-check-label" for="ativo">Ativo</label></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="edt_id" name="id"/>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>                    
                </div>
            </div>
        </div>
    </div>
</form>