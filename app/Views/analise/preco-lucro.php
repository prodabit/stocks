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
                                    <h4 class="m-0 font-weight-bold text-primary">Gráfico Análise Preço/Lucro</h4>                            
                                </div>
                                <div class="col-12 col-sm-4">
                                    <!--<button class="btn btn-info add-new btn-sm btn-block" role="button" id="btn_salvar"><span data-feather="plus"></span><i class="bi bi-save"></i> Salvar</button> -->                                                                                         
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row ml-0 mb-3">
                                <div class="col-12 col-sm-3 pl-0">
                                    <label for="lst_empresa">Selecione a Empresa:</label>
                                    <select id="lst_empresa" class="custom-select custom-select-sm form-control form-control-sm">
                                        <!-- será preenchido via javascript -->                                    
                                    </select>
                                    <label class="small mt-2 pl-1">5 requisições por min / 500 requisições por dia</label>
                                </div>   
                                <div class="col-12 col-sm-1 pl-0" style="margin-top: 1.4rem;">
                                    <button id="btn_refresh" class="btn btn-info btn-circle btn-sm"><i class="bi bi-arrow-counterclockwise"></i></button>                                    
                                </div>
                                                                                             
                            </div>
                            <div class="chart-container">
                                <canvas id="myChart" width="400" height="400"></canvas>
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

    <!-- Page level custom scripts -->
    <script type='text/javascript'>
        var baseURL = "<?php echo base_url();?>";                
    </script>
    
    <script src="assets/js/chart.js"></script>    
    <script src="assets/js/preco_lucro.js"></script>    
</body>
</html>