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
                <div class="container-fluid container-importacoes p-4">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-3 text-gray-800">Importação de Arquivos</h1>

                    <div class="row">
                        <div class="col-5">
                            <!-- Circle Buttons -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Arquivos ITR</h6>
                                </div>
                                <div class="card-body">
                                    <p>Importa os arquivos ITR (semestrais) ou DPF (anuais) para a tabela itr_source_links. 
                                    </p>
                                    <p>Link da página onde obtemos os arquivos manualmente. <br/>
                                       Baixar arquivos ITR (semestrais)  <a href="http://dados.cvm.gov.br/dataset/cia_aberta-doc-itr" target="_blank">Baixar ITR</a><br/>
                                       Baixar arquivos DPF (anuais)  <a href="http://dados.cvm.gov.br/dataset/cia_aberta-doc-dfp" target="_blank">Baixar DPF</a>                                       
                                    </p>
                                    <div class="row mb-4">
                                        <div class="col-12 col-sm-5">
                                            <label for="lst_ano">Selecione o ano:</label>
                                            <select id="lst_ano" class="custom-select custom-select-sm form-control form-control-sm">
                                                <!-- será preenchido via javascript -->                                    
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Circle Buttons (Default) -->
                                    <div class="mb-2">
                                        <button id="btn_importar_csv_links" class="btn btn-primary btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="bi bi-arrow-bar-down"></i>
                                            </span>
                                            <span class="text">Importar Arquivos Links</span>
                                        </button>
                                    </div>                                    
                                </div>
                            </div>
                        </div>

                        <!-- Brand Buttons -->
                        <div class="col-6 pl-0">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Importar Lista Empresas</h6>
                                </div>
                                <div class="card-body">   
                                    <p>Importa toda a lista de empresas do site da CVM de um determinado ano.</p>
                                    <div class="row mb-4">                                 
                                        <div class="col-10">
                                            <label for="lst_ano_empresa">Selecione o ano:</label>
                                            <select id="lst_ano_empresa" class="custom-select custom-select-sm form-control form-control-sm">
                                                <!-- será preenchido via javascript -->                                    
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <button id="btn_importar_empresas" class="btn btn-primary btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="bi bi-arrow-bar-down"></i>
                                                </span>
                                                <span class="text">Importar Empresas</span>
                                            </button>
                                        </div> 
                                    </div>
                                </div>
                            </div>                        
                        </div>
                    </div>                    
                    
                    <div class="row">
                        <div class="col-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Importar Balanço Empresa</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <label for="lst_empresa">Selecione a Empresa:</label>
                                            <select id="lst_empresa" class="custom-select custom-select-sm form-control form-control-sm">
                                                <!-- será preenchido via javascript -->                                    
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">                                        
                                        <div class="col-6">
                                            <label for="ano_ini">Selecione o Período do Balanço:</label>
                                            <select id="ano_ini" class="custom-select custom-select-sm form-control form-control-sm">
                                                <!-- será preenchido via javascript -->                                    
                                            </select>
                                        </div>
                                        <div class="col-6 pl-0">                              
                                            <label for="ano_fim">&nbsp;</label>              
                                            <select id="ano_fim" class="custom-select custom-select-sm form-control form-control-sm">
                                                <!-- será preenchido via javascript -->                                    
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-4">                                        
                                        <div class="col-3">
                                            <div class="form-check pt-2 ml-1">
                                                <input class="form-check-input" type="checkbox" id="check_trimestral">
                                                <label class="form-check-label" for="gridCheck">
                                                    Importar Trimestral
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-3">                              
                                            <div class="form-check pt-2 ml-1">
                                                <input class="form-check-input" type="checkbox" id="check_anual" checked>
                                                <label class="form-check-label" for="gridCheck">
                                                    Importar Anual
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <button id="btn_importar_balanco" class="btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="bi bi-arrow-bar-down"></i>
                                        </span>
                                        <span class="text">Importar Balanços</span>
                                    </a>
                                </div>                        
                            </div>    
                        </div>  
                    </div>                                  

                    <div class="row">
                       
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
    <script src="assets/js/importacao.js"></script>
</body>

</html>