<form id="formulario">
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastro/Edição de produto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active px-2 px-sm-3" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><i class="bi bi-house"></i> Principal</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-2 px-sm-3" id="configuracao-tab" data-toggle="tab" href="#configuracao" role="tab" aria-controls="configuracao" aria-selected="false"><i class="bi bi-blockquote-left"></i> Configuração II.</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-2 px-sm-3" id="impostos-tab" data-toggle="tab" href="#impostos" role="tab" aria-controls="impostos" aria-selected="false"><i class="bi bi-signpost"></i> Impostos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-2 px-sm-3" id="adicionais-tab" data-toggle="tab" href="#adicionais" role="tab" aria-controls="adicionais" aria-selected="false"><i class="bi bi-signpost"></i> Adicionais</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">

                            <!-- home tab -->
                            <div class="tab-pane fade show active pt-4" id="home" role="tabpanel" aria-labelledby="home-tab">  
                                <div class="tab-container">
                                    <div class="row mb-1">
                                        <div class="col-10">
                                            <div class="row mb-1">
                                                <div class="col-12 col-sm-6">
                                                    <div class="form-group"><label for="codigo">Código:</label><input type="text" id="edt_codigo" name="codigo" class="form-control form-control-sm" /></div>
                                                </div>
                                                <div class="col-12 col-sm-6">
                                                    <div class="form-group"><label for="ean">Ean:</label><input type="text" id="edt_ean" name="ean" class="form-control form-control-sm" data-mask="00000000000000" maxlenght="14" /></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2">                                        
                                            <img src="<?php echo base_url('assets/media/_no-image.jpg');?>" alt="foto" id="thumb_foto" class="img-thumbnail" style="width: 80px; height: 80px;">                                            
                                        </div>
                                        <span class="foto-upload"><i class="bi bi-pencil-square text-success"></i></span>                                            
                                        <span class="foto-cancel"><i class="bi bi-trash text-danger"></i></span> 
                                    </div>                                
                                    <div class="row mb-1">
                                        <div class="col-12 col-sm-12">
                                            <div class="form-group"><label for="descricao">Descrição/Nome Item:</label><input type="text" id="edt_descricao" name="descricao" class="form-control form-control-sm" maxlenght="255" /></div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 col-sm-8">                                            
                                            <label for="categoria">Categoria:</label>
                                            <select id="edt_categoria" name="categoria" class="custom-select custom-select-sm form-control form-control-sm">
                                            <!-- será preenchido via javascript -->                                    
                                            </select>     
                                        </div>                                       
                                        <div class="col-12 col-sm-4">
                                            <label for="fabricante">Fabricante:</label>
                                            <select id="edt_fabricante" name="fabricante" class="custom-select custom-select-sm form-control form-control-sm">                                            
                                            <!-- será preenchido via javascript -->                                    
                                            </select>     
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="preco_compra">Preço de Compra:</label><input type="text" id="edt_preco_compra" name="preco_compra" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true"/></div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="preco_venda">Preco de Venda:</label><input type="text" id="edt_preco_venda" name="preco_venda" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true"/></div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="preco_minimo">Preco Mínimo de Venda:</label><input type="text" id="edt_preco_minimo" name="preco_minimo" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true"/></div>
                                        </div>                                    
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="estoque">Estoque:</label><input type="text" id="edt_estoque" name="estoque" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true"/></div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="estoque_anterior">Estoque Anterior:</label><input type="text" id="edt_estoque_anterior" name="estoque_anterior" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true"/></div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <label for="unidade">Unidade:</label>
                                            <select id="edt_unidade" name="unidade" class="custom-select custom-select-sm form-control form-control-sm">    
                                            <!-- será preenchido via javascript -->                                    
                                            </select>                                                                                         
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-6 col-sm-4">
                                            <div class="form-group ml-4"><input type="checkbox" id="edt_ativo" name="ativo" class="form-check-input" /><label class="form-check-label" for="ativo">Ativo</label></div>
                                        </div>
                                    </div> 
                                </div>
                            </div>

                            <!-- home tab -->
                            <div class="tab-pane fade show pt-4" id="configuracao" role="tabpanel" aria-labelledby="configuracao-tab">  
                                <div class="tab-container">
                                    <div class="row mb-1">
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="ncm">NCM:</label><input type="text" id="edt_ncm" name="ncm" class="form-control form-control-sm" data-mask="0000000000"/></div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="cest">Cest:</label><input type="text" id="edt_cest" name="cest" class="form-control form-control-sm" data-mask="00.000.00"/></div>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-12 col-sm-12">
                                            <div class="form-group"><label for="modelo">Modelo:</label><input type="text" id="edt_modelo" name="modelo" class="form-control form-control-sm" maxlenght="100" /></div>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-12 col-sm-12">
                                            <div class="form-group"><label for="produtos_similares">Produtos Similares:</label><input type="text" id="edt_produtos_similares" name="produtos_similares" class="form-control form-control-sm" maxlenght="100" /></div>
                                        </div>
                                    </div>
                                    <hr>                                        
                                    <div class="row mb-1">
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group"><label for="peso">Peso:</label><input type="number" id="edt_peso" name="peso" class="form-control form-control-sm" /></div>
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group"><label for="comissao">Comissão:</label><input type="number" id="edt_comissao" name="comissao" class="form-control form-control-sm" /></div>
                                        </div>
                                        <div class="col-6 col-sm-3">
                                            <label for="edt_iat">Iat:</label>
                                            <select id="edt_iat" name="iat" class="custom-select custom-select-sm form-control form-control-sm">                                                
                                                <option value="A" selected>Arredondamento</option>
                                                <option value="T">Truncamento</option>
                                            </select>                                             
                                        </div>
                                        <div class="col-6 col-sm-3">
                                            <label for="ippt">Ippt:</label>
                                            <select id="edt_ippt" name="ippt" class="custom-select custom-select-sm form-control form-control-sm">                                                
                                                <option value="P">Produção Própria</option>
                                                <option value="T" selected>Produção de Terceiros</option>
                                            </select>                                              
                                        </div>                                    
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group"><label for="cor">Cor:</label><input type="text" id="edt_cor" name="cor" class="form-control form-control-sm" /></div>
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group"><label for="tamanho">Tamanho:</label><input type="text" id="edt_tamanho" name="tamanho" class="form-control form-control-sm" /></div>
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group"><label for="serie">Série:</label><input type="text" id="edt_serie" name="serie" class="form-control form-control-sm" maxlenght="30" /></div>
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group"><label for="...">...</label><input type="text" class="form-control form-control-sm" maxlenght="30" /></div>
                                        </div>
                                    </div>
                                    <div class="row mb-1 mt-4">
                                        <div class="col-6 col-sm-2">
                                            <div class="form-group ml-4"><input type="checkbox" id="edt_tabela" name="tabela" class="form-check-input" /><label class="form-check-label" for="tabela">Tabela</label></div>
                                        </div>
                                        <div class="col-6 col-sm-2">
                                            <div class="form-group ml-4"><input type="checkbox" id="edt_kit" name="kit" class="form-check-input" /><label class="form-check-label" for="kit">Kit/Combo</label></div>
                                        </div>                                    
                                        <div class="col-6 col-sm-2">
                                            <div class="form-group ml-4"><input type="checkbox" id="edt_calcula_peso" name="calcula_peso" class="form-check-input" /><label class="form-check-label" for="calcula_peso">Calcula Peso</label></div>
                                        </div>
                                        <div class="col-6 col-sm-3">
                                            <div class="form-group ml-4"><input type="checkbox" id="edt_producao" name="producao" class="form-check-input" /><label class="form-check-label" for="producao">Item de Produção</label></div>
                                        </div>
                                    </div>                                                            
                                </div>
                            </div>

                            <!-- home tab -->
                            <div class="tab-pane fade show pt-4" id="impostos" role="tabpanel" aria-labelledby="impostos-tab"> 
                                <div class="tab-container">
                                    <div class="row mb-1">
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="cfop">Cfop:</label><input type="text" id="edt_cfop" name="cfop" class="form-control form-control-sm" data-mask="0000"/></div>
                                        </div>                                
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="csosn">Csosn:</label><input type="text" id="edt_csosn" name="csosn" class="form-control form-control-sm" data-mask="0000"/></div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="cst">Cst:</label><input type="text" id="edt_cst" name="cst" class="form-control form-control-sm" data-mask="000" maxlenght="3" /></div>
                                        </div>                                    
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="cst_pis">Cst Pis:</label><input type="text" id="edt_cst_pis" name="cst_pis" class="form-control form-control-sm" data-mask="000" maxlenght="3"/></div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="cst_cofins">Cst Cofins:</label><input type="text" id="edt_cst_cofins" name="cst_cofins" class="form-control form-control-sm" data-mask="000" maxlenght="3"/></div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="cst_ipi">Cst Ipi:</label><input type="text" id="edt_cst_ipi" name="cst_ipi" class="form-control form-control-sm" data-mask="000" maxlenght="3"/></div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mb-1">
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="taxa_ipi">Alíquota Ipi:</label><input type="number" id="edt_taxa_ipi" name="taxa_ipi" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true"/></div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="taxa_issqn">Alíquota  ISSQN:</label><input type="number" id="edt_taxa_issqn" name="taxa_issqn" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true"/></div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="taxa_pis">Alíquota Pis:</label><input type="number" id="edt_taxa_pis" name="taxa_pis" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true"/></div>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="taxa_cofins">Alíquota Cofins:</label><input type="number" id="edt_taxa_cofins" name="taxa_cofins" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true"/></div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="taxa_icms">Alíquota  ICMS:</label><input type="number" id="edt_taxa_icms" name="taxa_icms" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true"/></div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="taxa_fcp">Alíquota FCP (Comb. Pobreza):</label><input type="number" id="edt_taxa_fcp" name="taxa_fcp" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true"/></div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mb-1">
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="tipo_item_sped">Tipo Item Sped:</label><input type="text" id="edt_tipo_item_sped" name="tipo_item_sped" class="form-control form-control-sm" /></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- home tab -->
                            <div class="tab-pane fade show pt-4" id="adicionais" role="tabpanel" aria-labelledby="adicionais-tab">  
                                <div class="tab-container">
                                    <div class="row mb-1">
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="comanda_id">Comanda:</label><input type="number" id="edt_comanda_id" name="comanda_id" class="form-control form-control-sm" maxlenght="11" /></div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="nutri_id">Tabela Nutricional:</label><input type="number" id="edt_nutri_id" name="nutri_id" class="form-control form-control-sm" maxlenght="6" /></div>
                                        </div>
                                    </div>  
                                    <div class="row mb-1">
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="data_cadastro">Data do Cadastro:</label><input type="date" id="edt_data_cadastro" class="form-control form-control-sm" data-mask="00/00/0000" readonly/></div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="data_ult_compra">Data Ult. Compra:</label><input type="date" id="edt_data_ult_compra" class="form-control form-control-sm" data-mask="00/00/0000" readonly/></div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group"><label for="data_ult_venda">Data Ult. Venda:</label><input type="date" id="edt_data_ult_venda" class="form-control form-control-sm" data-mask="00/00/0000" readonly/></div>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="edt_id" name="id"/>
                    <input type="hidden" id="edt_tipi_id" name="tipi_id"/>                    
                    <input type="file" onchange="previewFile()" id="edt_foto" name="foto" lang="pt" style="width: 0px; height: 0px;">
                    <input type="hidden" id="edt_excluir_foto" name="excluir_foto"/>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>
                    <button class="btn btn-sm btn-info" type="submit" id="editSalvar">Salvar Registro</button>
                </div>
            </div>
        </div>
    </div>
</form>