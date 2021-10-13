<!DOCTYPE html>
<html lang="en">

<?= $this->include('partials/header_pdv') ?>

<body>

    <div class="main-container bg-light">
        <div class="row">
            <div class="col">
                <!-- topo da tela -->
                <div class="row top-bar">
                    <div class="col">
                        <div class="titulo">Prodabit Sistemas e Automação</div>
                    </div>
                </div>

                <div class="row">
                    <!-- Left side - busca/bobina/totais/botoes -->
                    <div class="col-5 bg-light">
                        <div class="row container-left">
                            <!-- campo de busca -->
                            <div class="col-12 campo_busca pt-1 pb-3 px-3">
                                <div class="input-search">
                                    <input type="text" id="edt_barras" class="form-control form-control-sm" placeholder="Leitura código de barras">
                                    <i class="bi-upc-scan icon-search"></i>
                                </div>
                            </div>

                            <!-- bobina -->
                            <div class="col-12 container-bobina">
                                <div class="bobina">
                                    <table class="table table-striped table-bobina">
                                        <thead>
                                            <tr style="border-bottom: #ccc 1px solid">
                                                <th style="width:55%;">Descrição</th>
                                                <th style="width:15%; text-align: center;">Qtde</th>
                                                <th style="width:15%; text-align: center;">Valor</th>
                                                <th style="width:15%; text-align: center;">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="alinha_esq">Coca Cola 250ml</td>
                                                <td>02</td>
                                                <td>5,00</td>
                                                <td>10,00</td>
                                            </tr>
                                            <tr>
                                                <td class="alinha_esq">Salgado grande</td>
                                                <td>02</td>
                                                <td>3,90</td>
                                                <td>7,80</td>
                                            </tr>
                                            <tr>
                                                <td class="alinha_esq">Chocolate barra</td>
                                                <td>03</td>
                                                <td>4,00</td>
                                                <td>12,00</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- totais -->
                            <div class="col-12 container-totais">
                                <div class="row totais">
                                    <div class="col-5 totais-column-left">
                                        <label>Qtde. Itens</label><br/>
                                        <label class="label-pdv-big">05</label>
                                    </div>
                                    <div class="col-7 totais-column-right">
                                        <label>Qtde. Itens</label><br/>
                                        <label class="label-pdv-big"><span class="label-pdv-small">R$ </span>28,90</label>
                                    </div>
                                </div>
                            </div>

                            <!-- botoes -->
                            <div class="col-12">
                                <div class="row botoes-pdv-itens">
                                    <div class="col-2 btn-add-delete">  
                                        <i class="bi bi-dash-circle-dotted text-secondary"></i>
                                    </div>
                                    <div class="col-3 btn-add-delete">            
                                        <i class="bi bi-plus-circle-dotted text-secondary"></i>                            
                                    </div>
                                    <div class="col-7 btn-add-delete text-right">                                        
                                        <i class="bi bi-x-circle text-danger"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- right side - categorias/produtos/menu/botoes/mensagem -->
                    <div class="col p-2">
                        <div class="container container-botoes-categ" style="min-height: 58vh;">

                            <!-- TAB Categorias  -->
                            <div class="tab" id="tab-categorias">
                                <div class="tab-categorias bg-danger" style="height: 10vn;"><p>Categoria</p></div>
                            </div>

                            <!-- TAB Produtos  -->
                            <div class="tab" id="tab-produtos">
                                <div class="tab-produtos bg-warning" style="height: 10vn;"><p>Produtos</p></div>
                            </div>

                        </div>

                        <div class="container container-menu">
                            <div class="row align-items-end linha-itens-menu">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-3 px-0">
                                            <div class="botao-menu">
                                                <span class="bi bi-search icone-menu text-nowrap"> F1: buscar Produto</span> 
                                            </div>
                                        </div>
                                        <div class="col-3 px-0">
                                            <div class="botao-menu">
                                                <span class="bi bi-credit-card-2-front icone-menu text-nowrap"> F2: Menu Cartão</span> 
                                            </div>
                                        </div>
                                        <div class="col-3 px-0">
                                            <div class="botao-menu">
                                                <span class="bi bi-gear-fill icone-menu text-nowrap"> F3: Menu Operações</span> 
                                            </div>
                                        </div>
                                        <div class="col-3 px-0">
                                            <div class="botao-menu">
                                                <span class="bi bi-trash icone-menu text-nowrap"> F4: Excluir item</span> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-3 px-0 ">
                                            <div class="botao-menu">
                                                <span class="bi bi-arrows-collapse icone-menu text-nowrap"> F5: Desc/Acres.</span> 
                                            </div>
                                        </div>
                                        <div class="col-3 px-0">
                                            <div class="botao-menu">
                                                <span class="bi bi-person-check-fill icone-menu text-nowrap"> F6: Ident.Cliente</span> 
                                            </div>
                                        </div>
                                        <div class="col-3 px-0">
                                            <div class="botao-menu">
                                                <span class="bi bi-cart4 icone-menu text-nowrap"> F7: Finalizar Venda </span> 
                                            </div>
                                        </div>
                                        <div class="col-3 px-0">
                                            <div class="botao-menu">
                                                <span class="bi bi-box-arrow-right icone-menu text-nowrap"> F12: Sair do Caixa</span> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botões Cancelar/Finalizar Venda -->
                        <div class="container container-menu">
                            <div class="row align-items-end linha-itens-menu">
                                <div class="col-12">
                                    <div class="row justify-content-end mt-2">
                                        <div class="col-12 px-0 text-right">                                            
                                            <button type="button" class="btn btn-outline-danger btn-finalizar mr-2"><i class="bi bi-x"></i> Cancelar Venda</button>                                                                                            
                                            <button type="button" class="btn btn-outline-success btn-finalizar mr-1" onclick="toggleTabCatProd()"><i class="bi bi-check"></i> Finalizar Venda</button>                                                                                            
                                        </div>                                                                               
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Campo de mensagem no rodapé da tela -->
                        <div class="container container-mensagem">
                            <div class="row justify-content-between">
                                <div class="col-10">                                    
                                    <label class="label-mensagem">Venda em andamento</label>
                                </div>
                                <div class="col-2 text-right">
                                    <i class="bi bi-broadcast text-danger mr-1 pt-1"></i>
                                    <i class="bi bi-wifi text-success"></i>
                                </div>
                            </div>
                            

                            
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?= $this->include('partials/footer') ?>

    <!-- Page level custom scripts -->
    <script type='text/javascript'>
        var baseURL = "<?php echo base_url(); ?>";
    </script>
    <script src="assets/js/pdv.js"></script>
</body>

</html>