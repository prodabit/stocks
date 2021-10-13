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
                                    <h4 class="m-0 font-weight-bold text-primary">Lista de Permissões</h4>                            
                                </div>
                                <div class="col-12 col-sm-2">
                                    <button class="btn btn-info add-new btn-sm btn-block" role="button" id="btn_salvar"><span data-feather="plus"></span><i class="bi bi-save"></i> Salvar</button>                                                                                         
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row ml-0">
                                <div class="col-12 col-sm-4 pl-0">
                                    <label for="usuario">Selecione o usuário:</label>
                                    <select id="lst_usuario" name="usuario" class="custom-select custom-select-sm form-control form-control-sm">
                                        <!-- será preenchido via javascript -->                                    
                                    </select>
                                </div>                                                                
                                <div class="col-12 col-sm-4 pl-0 hide_show">
                                    <label for="usuario_source">Copiar deste usuário:</label>
                                    <select id="lst_usuario_source" name="usuario_source" class="custom-select custom-select-sm form-control form-control-sm">
                                    </select>
                                </div>                                
                            </div>
                            <div class="row justify-content-between ml-1 mt-2">
                                <div class="col-4 col-sm-3">
                                    <div class="form-group ml-2">                                        
                                        <input type="checkbox" id="edt_copiar" name="copiar" class="form-check-input" />
                                        <label class="form-check-label" for="edt_copiar">Copiar de outro usuário</label>                                        
                                    </div>
                                </div>    
                                <div class="col-2 text-right">                                                                
                                    <label type="button" class="badge badge-light px-2" id="lst_sel_todos">TODOS</label>
                                    <label type="button" class="badge badge-light px-2" id="lst_sel_nenhum">NENHUM</label>
                                </div>                                                                                            
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Descrição</th>                                                                                        
                                            <th>Grupo</th>
                                            <th>Ativo</th>
                                            <th>Selecionar</th>
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

    <!-- Page level custom scripts -->
    <script type='text/javascript'>
        var baseURL = "<?php echo base_url();?>";                
    </script>
    
    <script src="assets/js/permissao.js"></script>    
</body>
</html>