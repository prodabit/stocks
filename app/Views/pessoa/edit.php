<form id="formulario">
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastro de Cliente/Fornecedor</h5>
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
                                                <div class="col-9">
                                                    <div class="form-group"><label for="nome">Nome:</label><input type="text" id="edt_nome" name="nome" class="form-control form-control-sm" maxlenght="200" /></div>
                                                </div>
                                                <div class="col-3 pl-0">
                                                    <div class="form-group"><label for="contato">Contato:</label><input type="text" id="edt_contato" name="contato" class="form-control form-control-sm" maxlenght="50" /></div>
                                                </div>  
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-9">
                                                    <div class="form-group"><label for="rua">Rua:</label><input type="text" id="edt_rua" name="rua" class="form-control form-control-sm" maxlenght="200" /></div>
                                                </div>
                                                <div class="col-3 pl-0">
                                                    <div class="form-group"><label for="numero">Numero:</label><input type="text" id="edt_numero" name="numero" class="form-control form-control-sm" /></div>
                                                </div>  
                                            </div>
                                        </div>
                                        <div class="col-2 pt-4 pl-1">                                        
                                            <img src="<?php echo base_url('assets/media/_no-image.jpg');?>" alt="foto" id="thumb_foto" class="img-thumbnail" style="width: 100px; height: 100px;">                                            
                                        </div>
                                        <span class="foto-upload" style="top: 95px; right: 26px;"><i class="bi bi-pencil-square text-success"></i></span>                                            
                                        <span class="foto-cancel" style="top: 190px; right: 26px;"><i class="bi bi-trash text-danger"></i></span> 
                                    </div>            
                                    <div class="row mb-3">
                                        <div class="col-12 col-sm-9">
                                            <div class="form-group"><label for="bairro">Bairro:</label><input type="text" id="edt_bairro" name="bairro" class="form-control form-control-sm" maxlenght="200" /></div>
                                        </div>
                                        <div class="col-12 col-sm-3 pl-1">
                                            <div class="form-group"><label for="complemento">Complemento:</label><input type="text" id="edt_complemento" name="complemento" class="form-control form-control-sm" maxlenght="20" /></div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="row pb-3">                     
                                        <div class="col-12 col-sm-3"> 
                                            <div class="form-group">                                           
                                                <label for="uf">UF:</label>
                                                <select id="edt_uf" class="custom-select custom-select-sm form-control form-control-sm">
                                                    <option value="0">SELECIONE..</option>
                                                    <option value="AC">AC</option>
                                                    <option value="AL">AL</option>
                                                    <option value="AP">AP</option>
                                                    <option value="AM">AM</option>
                                                    <option value="BA">BA</option>
                                                    <option value="CE">CE</option>
                                                    <option value="DF">DF</option>
                                                    <option value="ES">ES</option>
                                                    <option value="GO">GO</option>
                                                    <option value="MA">MA</option>
                                                    <option value="MT">MT</option>
                                                    <option value="MS">MS</option>
                                                    <option value="MG">MG</option>
                                                    <option value="PA">PA</option>
                                                    <option value="PB">PA</option>
                                                    <option value="PR">PR</option>
                                                    <option value="PE">PE</option>
                                                    <option value="PI">PI</option>
                                                    <option value="RJ">RJ</option>
                                                    <option value="RN">RN</option>
                                                    <option value="RS">RS</option>
                                                    <option value="RO">RO</option>
                                                    <option value="RR">RR</option>
                                                    <option value="SC">SC</option>
                                                    <option value="SP">SP</option>
                                                    <option value="SE">SE</option>
                                                    <option value="TO">TO</option>
                                                </select>     
                                            </div>
                                        </div>  
                                        <div class="col-12 col-sm-6 pl-1">                                            
                                            <div class="form-group">
                                                <label for="cidade">Cidade:</label>
                                                <select id="edt_cidade" name="cidade" class="custom-select custom-select-sm form-control form-control-sm">
                                                <!-- será preenchido via javascript -->                                    
                                                </select>     
                                            </div>
                                        </div>  
                                        <div class="col-12 col-sm-3 pl-1">
                                            <div class="form-group"><label for="cep">Cep:</label><input type="text" id="edt_cep" name="cep" class="form-control form-control-sm" maxlenght="9" /></div>
                                        </div>                                
                                    </div>                         
                                    <div class="row mb-1">
                                        <div class="col-6 col-sm-2 pl-2">
                                            <div class="form-group ml-4"><input type="checkbox" id="edt_ativo" name="ativo" class="form-check-input" /><label class="form-check-label" for="ativo">Ativo</label></div>
                                        </div>
                                        <div class="col-6 col-sm-2">
                                            <div class="form-group ml-4"><input type="checkbox" id="edt_juridica" name="juridica" class="form-check-input" /><label class="form-check-label" for="juridica">Juridica</label></div>
                                        </div>
                                        <div class="col-6 col-sm-2">
                                            <div class="form-group ml-4"><input type="checkbox" id="edt_fornecedor" name="fornecedor" class="form-check-input" /><label class="form-check-label" for="fornecedor">Fornecedor</label></div>
                                        </div>
                                        <div class="col-6 col-sm-2">
                                            <div class="form-group ml-4"><input type="checkbox" id="edt_transportador" name="transportador" class="form-check-input" /><label class="form-check-label" for="transportador">Transportador</label></div>
                                        </div>                            
                                    </div>
                                </div>
                            </div>

                            <!-- adicionais tab -->
                            <div class="tab-pane fade show pt-2" id="adicionais" role="tabpanel" aria-labelledby="adicionais-tab">  
                                <div class="tab-container">
                                    <div class="row mb-1 mt-2">
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group"><label for="cpf">Cpf:</label><input type="text" id="edt_cpf" name="cpf" class="form-control form-control-sm" maxlenght="20" /></div>
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group"><label for="rg">Rg:</label><input type="text" id="edt_rg" name="rg" class="form-control form-control-sm" maxlenght="20" /></div>
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group"><label for="cnpj">Cnpj:</label><input type="text" id="edt_cnpj" name="cnpj" class="form-control form-control-sm" /></div>
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group"><label for="suframa">Suframa:</label><input type="text" id="edt_suframa" name="suframa" class="form-control form-control-sm" maxlenght="10" /></div>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group"><label for="insc_mun">Insc_mun:</label><input type="text" id="edt_insc_mun" name="insc_mun" class="form-control form-control-sm" maxlenght="15" /></div>
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group"><label for="insc_est">Insc_est:</label><input type="text" id="edt_insc_est" name="insc_est" class="form-control form-control-sm" maxlenght="15" /></div>
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group"><label for="limite_credito">Limite_credito:</label><input type="text" id="edt_limite_credito" name="limite_credito" class="form-control form-control-sm" data-mask="##0.00" data-mask-reverse="true" /></div>
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group"><label for="numero_cartao">Numero_cartao:</label><input type="text" id="edt_numero_cartao" name="numero_cartao" class="form-control form-control-sm" maxlenght="20" /></div>
                                        </div>
                                    </div>                            
                                    <div class="row mb-1">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group"><label for="restricao">Restricao:</label><textarea type="text" id="edt_restricao" name="restricao" class="form-control form-control-sm" maxlenght="300" rows="5"></textarea></div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group"><label for="referencia">Referencia:</label><textarea type="text" id="edt_referencia" name="referencia" class="form-control form-control-sm" maxlenght="300" rows="5"></textarea></div>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group"><label for="data_cadastro">Data_cadastro:</label><input type="text" id="edt_data_cadastro" class="form-control form-control-sm" readonly/></div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="edt_id" name="id"/>                    
                    <input type="file" onchange="previewFile()" id="edt_foto" name="foto" lang="pt" style="width: 0px; height: 0px;">
                    <input type="hidden" id="edt_excluir_foto" name="excluir_foto"/>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>
                    <button class="btn btn-sm btn-info" type="submit" id="editSalvar">Salvar Registro</button>
                </div>
            </div>
        </div>
    </div>
</form>