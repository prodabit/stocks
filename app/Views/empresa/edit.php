<form id="formulario">
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastro/Edição de empresa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mb-1">
                            <div class="col-12 col-sm-6">
                                <div class="form-group"><label for="nome">Nome:</label><input type="text" id="edt_nome" name="nome" class="form-control form-control-sm text-uppercase" maxlenght="50" /></div>
                            </div>
                            <div class="col-12 col-sm-2 pl-0">
                                <div class="form-group"><label for="fundacao">Fundação:</label><input type="text" id="edt_fundacao" name="fundacao" class="form-control form-control-sm" /></div>
                            </div>
                            <div class="col-12 col-sm-4 pl-0">
                                <label for="edt_setor">Setor:</label>
                                <select id="edt_setor" name="setor" class="custom-select custom-select-sm form-control form-control-sm">                                                
                                </select>                                                                             
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-12 col-sm-3">
                                <div class="form-group"><label for="cnpj">CNPJ:</label><input type="text" id="edt_cnpj" name="cnpj" class="form-control form-control-sm" maxlenght="15" data-mask="00.000.000/0000-00" data-mask-reverse="true" /></div>
                            </div>
                            <div class="col-12 col-sm-1 pl-0">
                                <div class="form-group"><label for="codigo">Codigo:</label><input type="text" id="edt_codigo" name="codigo" class="form-control form-control-sm text-uppercase" /></div>
                            </div>
                            <div class="col-12 col-sm-4 pl-0">
                                <div class="form-group"><label for="codigo_negoc">Codigos Negociação:</label><input type="text" id="edt_codigo_negoc" name="codigo_negoc" class="form-control form-control-sm text-uppercase" maxlenght="50" /></div>
                            </div>
                            <div class="col-12 col-sm-4 pl-0">
                                <label for="edt_tipo_mercado">Tipo Mercado:</label>
                                <select id="edt_tipo_mercado" name="tipo_mercado" class="custom-select custom-select-sm form-control form-control-sm">                                                
                                    <option value="TD" selected>TRADICIONAL</option>
                                    <option value="NM">NOVO MERCADO</option>
                                    <option value="T1">TIPO 1</option>
                                    <option value="T2">TIPO 2</option>                                    
                                </select>                                                                             
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-12 col-sm-4">
                                <div class="form-group"><label for="tag_along_on">Tag Alon ON:</label><input type="text" id="edt_tag_along_on" name="tag_along_on" class="form-control form-control-sm" /></div>
                            </div>
                            <div class="col-12 col-sm-4 pl-0">
                                <div class="form-group"><label for="tag_along_pn">Tag Along PN:</label><input type="text" id="edt_tag_along_pn" name="tag_along_pn" class="form-control form-control-sm" value="-"/></div>
                            </div>
                            <div class="col-12 col-sm-4 pl-0">
                                <div class="form-group"><label for="tag_along_unit">Tag Along Units:</label><input type="text" id="edt_tag_along_unit" name="tag_along_unit" class="form-control form-control-sm" value="-"/></div>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-12 col-sm-4">
                                <div class="form-group"><label for="free_float_on">Free Float ON:</label><input type="text" id="edt_free_float_on" name="free_float_on" class="form-control form-control-sm" /></div>
                            </div>
                            <div class="col-12 col-sm-4 pl-0">
                                <div class="form-group"><label for="free_float_pn">Free Float PN:</label><input type="text" id="edt_free_float_pn" name="free_float_pn" class="form-control form-control-sm" value="-"/></div>
                            </div>
                            <div class="col-12 col-sm-4 pl-0">
                                <div class="form-group"><label for="free_float_total">Free Float Total:</label><input type="text" id="edt_free_float_total" name="free_float_total" class="form-control form-control-sm" value="-"/></div>
                            </div>
                        </div>
                        <hr />
                        <div class="row mb-1">
                            <div class="col-12 col-sm-6">
                                <div class="form-group"><label for="majoritario">Sócio Majoritário:</label><input type="text" id="edt_majoritario" name="majoritario" class="form-control form-control-sm text-uppercase" maxlenght="100" /></div>
                            </div>
                            <div class="col-12 col-sm-3 pl-0">
                                <div class="form-group"><label for="porc_majoritario">% Majoritário:</label><input type="text" id="edt_porc_majoritario" name="porc_majoritario" class="form-control form-control-sm" /></div>
                            </div>
                            <div class="col-12 col-sm-3 pl-0">
                                <div class="form-group"><label for="porc_minoritario">% Minoritário:</label><input type="text" id="edt_porc_minoritario" name="porc_minoritario" class="form-control form-control-sm" /></div>
                            </div>                            
                        </div>
                        <div class="row mb-1">
                            <div class="col-12 col-sm-6">
                                <label for="governo_on">Particip. Governo:</label>
                                <select id="edt_governo_on" name="governo_on" class="custom-select custom-select-sm form-control form-control-sm">                                                
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>                                    
                                </select>   
                            </div>
                            <div class="col-12 col-sm-3 pl-0">
                                <div class="form-group"><label for="porc_governo_on">Porc Particip. Governo:</label><input type="text" id="edt_porc_governo_on" name="porc_governo_on" class="form-control form-control-sm" /></div>
                            </div>
                            <div class="col-12 col-sm-3 pl-0">
                                <div class="form-group"><label for="porc_ibovespa">% Ibovespa:</label><input type="text" id="edt_porc_ibovespa" name="porc_ibovespa" class="form-control form-control-sm" /></div>
                            </div>
                        </div>

                        <div class="row mb-1">
                            <div class="col-12 col-sm-3">                                
                                <div class="form-group"><label for="qtde_acoes_on">Qtde. Ações ON</label><input type="text" id="edt_qtde_acoes_on" name="qtde_acoes_on" class="form-control form-control-sm" /></div>
                            </div>
                            <div class="col-12 col-sm-3 pl-0">                                
                                <div class="form-group"><label for="qtde_acoes_pn">Qtde. Ações PN</label><input type="text" id="edt_qtde_acoes_pn" name="qtde_acoes_pn" class="form-control form-control-sm" /></div>
                            </div>
                            <div class="col-12 col-sm-3 pl-0">                                
                                <div class="form-group"><label for="qtde_acoes_unit">Qtde. Ações UNIT</label><input type="text" id="edt_qtde_acoes_unit" name="qtde_acoes_unit" class="form-control form-control-sm" /></div>
                            </div>
                            <div class="col-12 col-sm-3 pl-0">                                
                                <div class="form-group"><label for="qtde_acoes_total">Qtde. Ações TOTAL</label><input type="text" id="edt_qtde_acoes_total" name="qtde_acoes_total" class="form-control form-control-sm" /></div>
                            </div>
                        </div>

                        <div class="row mb-1">
                            <div class="col-12 col-sm-12">
                                <div class="form-group"><label for="site_ri">Site_ri:</label><input type="text" id="edt_site_ri" name="site_ri" class="form-control form-control-sm" maxlenght="100" /></div>
                            </div>
                        </div>
                        <div class="row mb-1 pl-sm-2">
                            <div class="col-6 col-sm-2">
                                <div class="form-group ml-3"><input type="checkbox" id="edt_ativo" name="ativo" class="form-check-input" /><label class="form-check-label" for="ativo">Ativo</label></div>                            
                            </div>
                            <div class="col-6 col-sm-3">                            
                                <div class="form-group ml-3"><input type="checkbox" id="edt_analise" name="analise" class="form-check-input" /><label class="form-check-label" for="analise">Análise</label></div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="edt_id" name="id" />
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>
                    <button class="btn btn-sm btn-info" type="submit" id="editSalvar">Salvar Registro</button>
                </div>                
            </div>
        </div>
    </div>
    </div>
</form>