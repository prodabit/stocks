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
                                    <h4 class="m-0 font-weight-bold text-primary">Lista de Cartões Procard</h4>
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
                                            <th style="width: 2%">#</th>
                                            <th style="width: 8%">Número</th>
                                            <th>Usuário</th>
                                            <th style="width: 10%">Classe/Turma</th>
                                            <th style="width: 8%">Saldo</th>
                                            <th style="width: 12%">Data Cadastro</th>                                            
                                            <th style="width: 12%">Limite Diário</th>
                                            <th style="width: 12%">Limite Crédito</th>
                                            <th style="width: 3%">Ativo</th>
                                            <th style="width: 10%; text-align: center;">Ações</th>
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

    <!-- insere o form modal para editar/inserir medicamento -->
    <? echo view("procard/edit"); ?>
    <?= $this->include('partials/footer') ?>

    <!-- Page level custom scripts -->
    <script type='text/javascript'>
        var baseURL = "<?php echo base_url(); ?>";
    </script>
    <script src="assets/js/procard.js"></script>
</body>

</html>