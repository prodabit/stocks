<form id="combo_form">
    <div class="modal fade" id="kit_produto_modal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="comboTitle">Combos/Kits</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container mt-2">  
                        <div class="row mb-1">
                            <div class="col-12 col-sm-10">
                                <div class="form-group">
                                    <label for="plano_contas_os">Localizar Item/Produto:</label>
                                    <div class="input-group input-group-sm mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="bi bi-search" style="font-size: 0.685rem;"></i></div>
                                        </div>
                                        <input id="combo_produto" type="text" class="form-control form-control-sm" placeholder="digite 2 digitos para pesquisar" autocomplete="off">                                                
                                    </div>                                            
                                </div>
                            </div>
                            <div class="col-12 col-sm-2 pl-0">
                                <button class="btn btn-sm btn-info" style="margin-top: 21px" type="button" id="comboAdd">Adicionar</button>
                            </div>                            
                        </div>    
                        <div id="box_search_combo_produto" class="box_search ml-1">
                            <table class="table table-bordered" style="font-size: 11px;" id="combo_search_table" width="100%" cellspacing="0">
                                <thead><tr>
                                <th  width="5%">#</th>                                
                                <th  width="10%">Código</th>
                                <th  width="55%">Descrição</th>
                                <th  width="15%">Preço Compra</th>
                                <th  width="15%">Preço Venda</th></tr></thead>
                                <tbody></tbody>
                            </table>
                        </div>    

                        <div class="row mb-1" style="min-height: 100px">
                            <div class="col-12 col-sm-2">
                                <div class="form-group"><label for="combo_codigo">Código:</label><input type="text" id="combo_codigo" class="form-control form-control-sm" readonly/></div>
                            </div>    
                            <div class="col-12 col-sm-3 pl-0">
                                <div class="form-group"><label for="combo_preco_compra">Preço de Compra:</label><input type="text" id="combo_preco_compra" class="form-control form-control-sm" data-mask="##0.00" readonly/></div>
                            </div>
                            <div class="col-12 col-sm-2 pl-0">
                                <div class="form-group"><label for="combo_qtde">Qtde:</label><input type="text" id="combo_qtde" name="combo_qtde" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true"/></div>
                            </div>
                            <div class="col-12 col-sm-3 pl-0">
                                <div class="form-group"><label for="combo_valor">Valor:</label><input type="text" id="combo_valor" name="combo_valor" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true"/></div>
                            </div>                                    
                        </div>                
                        <hr/>

                        <div class="row">
                            <div class="col">                    
                                <div class="table-responsive" style="min-height: 200px">
                                    <table class="table table-bordered" id="combo_table" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Código</th>
                                                <th>Descrição</th>
                                                <th>Preço Compra</th>
                                                <th>Qtde</th>
                                                <th>Valor</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="combo_produto_id"/>                    
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>
                    <button class="btn btn-sm btn-info" type="submit" id="btnSalvarComposto">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</form>