<!DOCTYPE html>
<html lang="en">

<?= $this->include('partials/header') ?>

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
                                    <h4 class="m-0 font-weight-bold text-primary">Lista de Empresas</h4>
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
                                            <th style="width:2%;">Id</th>
                                            <th style="width:15%;">Nome Empresa</th>                                            
                                            <th style="width:13%;">Códigos Negoc.</th>
                                            <th style="width:8%;">Cnpj</th>                                            
                                            <th style="width:5%;">Ano Fundação</th>
                                            <th style="width:15%;">Setor</th>
                                            <th style="width:5%;">Tipo Mercado</th>                                            
                                            <th style="width:5%;">Análise</th>
                                            <th style="width:5%;">Ativo</th>
                                            <th style="width:10%;">Ações</th>
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
    <? echo view("empresa/edit"); ?>


    <!-- Page level custom scripts -->
    <script type='text/javascript'>
        var baseURL = "<?php echo base_url(); ?>";
    </script>
    <script src="assets/js/empresa.js"></script>
</body>

</html>