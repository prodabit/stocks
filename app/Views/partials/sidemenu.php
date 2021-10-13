<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <!--<div class="sidebar-brand-icon rotate-n-15">-->
        <div class="sidebar-brand-icon">
            <i class="bi-grid-3x2-gap-fill"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Stocks <sup>plus</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="<? echo base_url();?>">
            <i class="bi-speedometer2"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Grupo Menu - Cadastros -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="bi-gear"></i>
            <span>Cadastros</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">                
                <a class="collapse-item" href="<? echo base_url();?>/usuario">Usuários</a>                
                <a class="collapse-item" href="<? echo base_url();?>/setor">Setores</a>                
                <a class="collapse-item" href="<? echo base_url();?>/empresa">Empresas</a>                                                                
                <a class="collapse-item" href="<? echo base_url();?>/configuracao">Configuração</a>                                      
            </div>
        </div>
    </li>
    

    <!-- Grupo Menu - GráficosAnálises -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProduto"
            aria-expanded="true" aria-controls="collapseProduto">
            <i class="bi-basket"></i>
            <span>Análises/Gráficos</span>
        </a>
        <div id="collapseProduto" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">                
                <a class="collapse-item" href="<? echo base_url();?>/preco-lucro">Preço/Lucro</a>
                <a class="collapse-item" href="<? echo base_url();?>/waren-buffet">Warren Buffet</a>                                
            </div>
        </div>
    </li>

    <!-- Grupo Menu - Importações -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProcard"
            aria-expanded="true" aria-controls="collapseProcard">
            <i class="bi-person-badge"></i>
            <span>Importações</span>
        </a>
        <div id="collapseProcard" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">    
                <h6 class="collapse-header">Importar Documentos:</h6>            
                <a class="collapse-item" href="<? echo base_url();?>/importacoes">Importar Arquivos</a>                
            </div>
        </div>
    </li>

    <!-- Grupo Menu - Financeiro -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFinanceiro"
            aria-expanded="true" aria-controls="collapseFinanceiro">
            <i class="bi-calculator"></i>
            <span>Artigos/Livros</span>
        </a>
        <div id="collapseFinanceiro" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">                       
                <a class="collapse-item" href="<? echo base_url();?>/fundos_imobiliarios">Fundos Imobiliários</a>         
                <a class="collapse-item" href="<? echo base_url();?>/contas_receber">Indicadores Fundam.</a>                         
            </div>
        </div>
    </li>

    <!-- Grupo Vendas -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVendas"
            aria-expanded="true" aria-controls="collapseVendas">
            <i class="bi bi-basket"></i>
            <span>Vendas</span>
        </a>
        <div id="collapseVendas" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">                       
                <a class="collapse-item" href="<? echo base_url();?>/movimentos">Movimentos</a>                         
            </div>
        </div>
    </li>

    <!-- Frente de Caixa -->
    <li class="nav-item active">
        <a class="nav-link" href="<? echo base_url();?>/pdv">
            <i class="bi-cart4 text-danger"></i>
            <span>PDV</span>
        </a>
    </li>    

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="bi-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="login.html">Login</a>
                <a class="collapse-item" href="register.html">Register</a>
                <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="404.html">404 Page</a>
                <a class="collapse-item" href="blank.html">Blank Page</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="<? echo base_url();?>/categoria">
            <i class="bi-graph-up"></i>
            <span>categoria</span></a>
    </li>
    <!-- Nav Item - Tables -->
    <li class="nav-item active">
        <a class="nav-link" href="tables.html">
            <i class="bi-table"></i>
            <span>Tables</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"><i class="bi bi-chevron-up text-white"></i></button>
    </div>

</ul>
<!-- End of Sidebar -->