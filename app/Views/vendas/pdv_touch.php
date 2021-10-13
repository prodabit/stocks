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
                        <label class="titulo-prodabit">Prodabit Sistemas e Automação</label>
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

                    <!-- right side - tab categorias -->
                    <div class="col p-2" id="tab-categorias">
                        <?= $this->include('vendas/partials/tab-categorias') ?>                        
                    </div>

                    <!-- right side - tab produtos -->
                    <div class="col p-2" id="tab-produtos">
                        <?= $this->include('vendas/partials/tab-produtos') ?>                        
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