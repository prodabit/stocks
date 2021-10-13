<form id="formulario" autocomplete="false">    
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastro/Edição de configuracao</h5>
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
                                <a class="nav-link px-2 px-sm-3" id="contato-tab" data-toggle="tab" href="#contato" role="tab" aria-controls="contato" aria-selected="false"><i class="bi bi-blockquote-left"></i> Configuração II.</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-2 px-sm-3" id="endereco-tab" data-toggle="tab" href="#endereco" role="tab" aria-controls="endereco" aria-selected="false"><i class="bi bi-signpost"></i> Configuração III</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">

                            <!-- home tab -->
                            <div class="tab-pane fade show active pt-4" id="home" role="tabpanel" aria-labelledby="home-tab">  
                                <div class="row mb-1">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">                                
                                            <label>Logo:</label>
                                            <div class="custom-file">
                                                <input type="file" onchange="previewFile('logo')" class="custom-file-input form-control form-control-sm" id="edt_logo" name="logo" lang="pt">
                                                <label id="lbl_logo" class="custom-file-label" for="edt_logo">Escolha o arquivo</label>
                                            </div>
                                            <div class="mt-2 small">Obs: imagem (png/jpeg/gif) com max 100 KBytes por arquivo.</div> 
                                        </div> 
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">                                
                                            <label>Fundo de Tela:</label>
                                            <div class="custom-file">
                                                <input type="file" onchange="previewFile('fundo_tela')" class="custom-file-input form-control form-control-sm" id="edt_fundo_tela" name="fundo_tela" lang="pt">
                                                <label id="lbl_fundo_tela" class="custom-file-label" for="edt_fundo_tela">Escolha o arquivo</label>
                                            </div>
                                            <div class="mt-2 small">Obs: imagem (png/jpeg/gif) com max 100 KBytes por arquivo.</div> 
                                        </div>                                         
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group"><label for="titulo_cupom">Titulo do Cupom:</label><input type="text" id="edt_titulo_cupom" name="titulo_cupom" class="form-control form-control-sm" maxlenght="100" /></div>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group"><label for="rodape_cupom">Rodapé do Cupom:</label><input type="text" id="edt_rodape_cupom" name="rodape_cupom" class="form-control form-control-sm" maxlenght="300" /></div>
                                    </div>
                                </div>                                
                                <div class="row mb-6">
                                    <div class="col">&nbsp;</div>
                                </div>
                            </div>

                            <!-- contact tab -->
                            <div class="tab-pane fade pt-4" id="contato" role="tabpanel" aria-labelledby="contato-tab">
                                <div class="row mb-1">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group"><label for="desc_tabela_1">Descrição Preço 1:</label><input type="text" id="edt_desc_tabela_1" name="desc_tabela_1" class="form-control form-control-sm" maxlenght="50" /></div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group"><label for="desc_tabela_2">Descrição Preço 2:</label><input type="text" id="edt_desc_tabela_2" name="desc_tabela_2" class="form-control form-control-sm" maxlenght="50" /></div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group"><label for="desc_tabela_3">Descrição preço 3:</label><input type="text" id="edt_desc_tabela_3" name="desc_tabela_3" class="form-control form-control-sm" maxlenght="50" /></div>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group"><label for="porc_tabela_1">Porcentagem Preço 1:</label><input type="number" id="edt_porc_tabela_1" name="porc_tabela_1" class="form-control form-control-sm"/></div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group"><label for="porc_tabela_2">Porcentagem Preço 2:</label><input type="number" id="edt_porc_tabela_2" name="porc_tabela_2" class="form-control form-control-sm"/></div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group"><label for="porc_tabela_3">Porcentagem Preço 3:</label><input type="number" id="edt_porc_tabela_3" name="porc_tabela_3" class="form-control form-control-sm"/></div>
                                    </div>
                                </div>                

                                <div class="row mb-1">                                    
                                    <div class="col-12 col-sm-6">                                        
                                        <div class="form-group">
                                            <label for="centro_custo_os">Centro Custos OS:</label>
                                            <div class="input-group input-group-sm mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi bi-search" style="font-size: 0.685rem;"></i></div>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="edt_centro_custo_os" placeholder="digite para pesquisar" autocomplete="off">                                                
                                            </div>                                            
                                        </div>                                        
                                    </div>   

                                    <div class="col-12 col-sm-6">                                        
                                        <div class="form-group">
                                            <label for="plano_contas_os">Plano de Contas OS:</label>
                                            <div class="input-group input-group-sm mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi bi-search" style="font-size: 0.685rem;"></i></div>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="edt_plano_contas_os" placeholder="digite para pesquisar" autocomplete="off">                                                
                                            </div>                                            
                                        </div>                                        
                                    </div>  
                                </div>

                                <div class="row mb-1">                                    
                                    <div class="col-12 col-sm-6">                                        
                                        <div class="form-group">
                                            <label for="centro_custo_cupom">Centro Custos Cupom:</label>
                                            <div class="input-group input-group-sm mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi bi-search" style="font-size: 0.685rem;"></i></div>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="edt_centro_custo_cupom" placeholder="digite para pesquisar" autocomplete="off">                                                
                                            </div>                                            
                                        </div>                                        
                                    </div>   

                                    <div class="col-12 col-sm-6">                                        
                                        <div class="form-group">
                                            <label for="plano_contas_cupom">Plano de Contas Cupom:</label>
                                            <div class="input-group input-group-sm mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi bi-search" style="font-size: 0.685rem;"></i></div>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="edt_plano_contas_cupom" placeholder="digite para pesquisar" autocomplete="off">                                                
                                            </div>                                            
                                        </div>                                        
                                    </div>  
                                </div>                                
                            </div>

                            <!-- endereco tab -->
                            <div class="tab-pane fade pt-4" id="endereco" role="tabpanel" aria-labelledby="endereco-tab">
                                <div class="row mb-1">
                                    <div class="col-6 col-sm-4">
                                        <div class="form-group ml-4"><input type="checkbox" id="edt_preview_impressao" name="preview_impressao" class="form-check-input" /><label class="form-check-label" for="preview_impressao">Preview_impressao</label></div>
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <div class="form-group ml-4"><input type="checkbox" id="edt_imprimir_dados_empresa" name="imprimir_dados_empresa" class="form-check-input" /><label class="form-check-label" for="imprimir_dados_empresa">Imprimir_dados_empresa</label></div>
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <div class="form-group ml-4"><input type="checkbox" id="edt_baixar_estoque_os" name="baixar_estoque_os" class="form-check-input" /><label class="form-check-label" for="baixar_estoque_os">Baixar_estoque_os</label></div>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-6 col-sm-4">
                                        <div class="form-group ml-4"><input type="checkbox" id="edt_baixa_produto_composto" name="baixa_produto_composto" class="form-check-input" /><label class="form-check-label" for="baixa_produto_composto">Baixa_produto_composto</label></div>
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <div class="form-group ml-4"><input type="checkbox" id="edt_imprimir_senha_cupom" name="imprimir_senha_cupom" class="form-check-input" /><label class="form-check-label" for="imprimir_senha_cupom">Imprimir_senha_cupom</label></div>
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <div class="form-group ml-4"><input type="checkbox" id="edt_imprimir_delivery" name="imprimir_delivery" class="form-check-input" /><label class="form-check-label" for="imprimir_delivery">Imprimir_delivery</label></div>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group ml-4"><input type="checkbox" id="edt_digitais" name="digitais" class="form-check-input" /><label class="form-check-label" for="edt_digitais">Utilizar Digitais</label></div>                                    
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <div class="form-group ml-4"><input type="checkbox" id="edt_leitor_mifare_ativo" name="leitor_mifare_ativo" class="form-check-input" /><label class="form-check-label" for="leitor_mifare_ativo">Leitor_mifare_ativo</label></div>
                                    </div>
                                    <div class="col-12 col-sm-4 toggle-mifare">
                                        <div class="form-group"><label for="porta_leitor_mifare">Porta_leitor_mifare:</label><input type="text" id="edt_porta_leitor_mifare" name="porta_leitor_mifare" class="form-control form-control-sm" maxlenght="10" /></div>
                                    </div>   
                                </div>                                
                                <div class="row mb-1">
                                    <div class="col-12 col-sm-8">                                        
                                        <div class="form-group">
                                            <label for="cliente_vendas">Cliente Padrão Vendas:</label>
                                            <div class="input-group input-group-sm mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi bi-search" style="font-size: 0.685rem;"></i></div>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="edt_cliente_vendas" placeholder="digite para pesquisar" autocomplete="off">                                                
                                            </div>                                            
                                        </div>                                        
                                    </div>  
                                </div>                                
                                <div class="row mb-1">
                                    <div class="col-12 col-sm-8">                                        
                                        <div class="form-group">
                                            <label for="cliente_transferencia">Cliente Padrão Transferências:</label>
                                            <div class="input-group input-group-sm mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi bi-search" style="font-size: 0.685rem;"></i></div>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="edt_cliente_transferencia" placeholder="digite para pesquisar" autocomplete="off">                                                
                                            </div>                                            
                                        </div>                                        
                                    </div>  
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>                
                <div class="modal-footer">
                    <input type="hidden" id="edt_id" name="id"/>
                    <input type="hidden" id="edt_centro_custo_os_id" name="centro_custo_os_id"/>
                    <input type="hidden" id="edt_plano_contas_os_id" name="plano_contas_os_id"/>
                    <input type="hidden" id="edt_centro_custo_cupom_id" name="centro_custo_cupom_id"/>
                    <input type="hidden" id="edt_plano_contas_cupom_id" name="plano_contas_cupom_id"/>
                    <input type="hidden" id="edt_cliente_vendas_id" name="cliente_vendas_id" value="0"/>
                    <input type="hidden" id="edt_cliente_transferencia_id" name="cliente_transferencia_id" value="0"/>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>
                    <button class="btn btn-sm btn-info" type="button" id="editSalvar">Salvar Registro</button>
                </div>
            </div>
        </div>
    </div>
</form>