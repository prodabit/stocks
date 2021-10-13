<!DOCTYPE html>
<html lang="en">

<?= $this->include('partials/header_jquery_ui') ?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?= $this->include('partials/sidemenu') ?>  

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

            <!-- Top Bar -->
            <?= $this->include('partials/topbar'); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <h4 class="m-0 font-weight-bold text-primary">Lista de Formas de Pagamento</h4>                            
                                </div>
                                <div class="col-12 col-sm-2">
                                    <button class="btn btn-info add-new btn-sm btn-block" role="button" id="btn_novo"><span data-feather="plus"></span> Novo</button>                                                                                         
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Descrição</th>
                                            <th>Conta Destino</th>
                                            <th>Liquidez</th>                                                                                        
                                            <th>Precisa Cliente</th>                                            
                                            <th>ProCard</th>
                                            <th>Financeiro</th>                                            
                                            <th>Ativo</th>
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
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?= $this->include('partials/footer-page') ?>
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="bi-chevron-up"></i>
    </a>

    <?= $this->include('partials/footer') ?>

    <!-- insere o form modal para editar/inserir medicamento -->
    <? echo view("forma_pagamento/edit");?>   

    <!-- insere o form modal para associar com Conta Corrente -->
    <? echo view("forma_pagamento/associar_contacorrente");?>   

    <!-- Page level custom scripts -->
    <script type='text/javascript'>
        var baseURL = "<?php echo base_url();?>";                
    </script>
    <script src="assets/js/jquery-ui.min.js"></script> <!-- necessário para o autocomplete -->        
    <script src="assets/js/forma_pagamento.js"></script>        
</body>
</html>