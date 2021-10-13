<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->add('usuario', 'Usuario::listar');
$routes->add('permissao', 'Permissao::listar');
$routes->add('empresa', 'Empresa::listar');
$routes->add('preco-lucro', 'Analise::preco_lucro');
$routes->add('warren-buffet', 'Analise::warren-buffet');

$routes->add('configuracao', 'Configuracao::listar');
$routes->add('teste', 'Venda::teste');

//-- Modulo de cadatro geral. Basta alterar aqui para funcionar. Para tabelas no formato (id, descricao, ativo)
$routes->add('setor', 'Cadastrogeral::listar/setor');
$routes->add('fabricante', 'Cadastrogeral::listar/fabricante');
$routes->add('procard_classe', 'Cadastrogeral::listar/procard_classe');
$routes->add('status_procard', 'Cadastrogeral::listar/status_procard');

$routes->add('importacoes', 'Importacoes::show_form_importar');
$routes->add('importacoes/importar_itr', 'Importacoes::importar_itr');
$routes->add('importacoes/importar_balanco_periodo', 'Importacoes::importar_balanco_periodo');
$routes->add('importacaoes/getLinkArquivoEmpresaJson', 'Importacoes::getLinkArquivoEmpresaJson');
$routes->add('importacaoes/getAnosCadastradosEmpresaJson', 'Importacoes::getAnosCadastradosEmpresaJson');

$routes->add('fundos_imobiliarios', 'Artigos::fundos_imobiliarios');


/*$routes->add('categoria/getListJson', 'Categoria::getListJson');
$routes->add('estacao/getListJson', 'Estacao::getListJson');
$routes->add('centrocusto/getListJson', 'Centrocusto::getListJson');*/


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
