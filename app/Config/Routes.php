<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('HomeController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'HomeController::index');
$routes->get('/accounts', 'AccountController::index');
$routes->get('/accounts/create', 'AccountController::create');
$routes->post('/accounts/create', 'AccountController::create');
$routes->get('/accounts/(:any)/create-sub', 'AccountController::create/$1');
$routes->post('/accounts/(:any)/create-sub', 'AccountController::create/$1');
$routes->get('/accounts/(:any)/update', 'AccountController::update/$1');
$routes->post('/accounts/(:any)/update', 'AccountController::update/$1');
$routes->post('/accounts/(:any)/delete', 'AccountController::delete/$1');

$routes->get('/users', 'UserController::index');
$routes->get('/users/create', 'UserController::create');
$routes->post('/users/create', 'UserController::create');
$routes->get('/users/(:any)/update', 'UserController::update/$1');
$routes->post('/users/(:any)/update', 'UserController::update/$1');
$routes->post('/users/(:any)/delete', 'UserController::delete/$1');

$routes->get('/transaction-statuses', 'TransactionStatusController::index');
$routes->get('/transaction-statuses/create', 'TransactionStatusController::create');
$routes->post('/transaction-statuses/create', 'TransactionStatusController::create');
$routes->get('/transaction-statuses/(:any)/update', 'TransactionStatusController::update/$1');
$routes->post('/transaction-statuses/(:any)/update', 'TransactionStatusController::update/$1');
$routes->post('/transaction-statuses/(:any)/delete', 'TransactionStatusController::delete/$1');

$routes->get('/transactions', 'TransactionController::index');
$routes->get('/transactions/create', 'TransactionController::create');
$routes->post('/transactions/create', 'TransactionController::create');
$routes->get('/transactions/(:any)/update', 'TransactionController::update/$1');
$routes->post('/transactions/(:any)/update', 'TransactionController::update/$1');
$routes->post('/transactions/(:any)/delete', 'TransactionController::delete/$1');
$routes->get('/transactions/(:any)', 'TransactionController::view/$1');

$routes->get('/adjustments', 'AdjustmentController::index');
$routes->get('/adjustments/create', 'AdjustmentController::create');
$routes->post('/adjustments/create', 'AdjustmentController::create');
$routes->get('/adjustments/(:any)/update', 'AdjustmentController::update/$1');
$routes->post('/adjustments/(:any)/update', 'AdjustmentController::update/$1');
$routes->post('/adjustments/(:any)/delete', 'AdjustmentController::delete/$1');
$routes->get('/adjustments/(:any)', 'AdjustmentController::view/$1');

$routes->get('/journal/general/excel', 'JournalController::generalExcel');
$routes->get('/journal/general/pdf', 'JournalController::generalPdf');
$routes->get('/journal/general', 'JournalController::general');

$routes->get('/journal/adjustment/excel', 'JournalController::adjustmentExcel');
$routes->get('/journal/adjustment/pdf', 'JournalController::adjustmentPdf');
$routes->get('/journal/adjustment', 'JournalController::adjustment');

$routes->get('/posting/excel', 'PostingController::downloadExcel');
$routes->get('/posting/pdf', 'PostingController::downloadPdf');
$routes->get('/posting', 'PostingController::index');

$routes->get('/sheet/balance/pdf', 'SheetController::balancePdf');
$routes->get('/sheet/balance', 'SheetController::balance');

$routes->get('/sheet/work/pdf', 'SheetController::workPdf');
$routes->get('/sheet/work', 'SheetController::work');

$routes->get('/report/revenue/pdf', 'ReportController::revenuePdf');
$routes->get('/report/revenue', 'ReportController::revenue');

$routes->get('/report/balance/pdf', 'ReportController::balancePdf');
$routes->get('/report/balance', 'ReportController::balance');

$routes->get('/report/balance/pdf', 'ReportController::balancePdf');
$routes->get('/report/balance', 'ReportController::balance');

$routes->get('/report/capital/pdf', 'ReportController::capitalPdf');
$routes->get('/report/capital', 'ReportController::capital');

$routes->get('/report/cashflow/pdf', 'ReportController::cashflowPdf');
$routes->get('/report/cashflow', 'ReportController::cashflow');


$routes->get('/api/statuses', 'AccountRestController::index');

$routes->get('/api/accounts', 'AccountRestController::index');
$routes->post('/api/accounts/create', 'AccountRestController::create');
$routes->post('/api/accounts/(:any)/sub', 'AccountRestController::create/$1');
$routes->post('/api/accounts/(:any)', 'AccountRestController::update/$1');
$routes->delete('/api/accounts/(:any)', 'AccountRestController::delete/$1');

$routes->get('/api/transactions', 'TransactionRestController::index');
$routes->post('/api/transactions', 'TransactionRestController::create');
$routes->get('/api/transactions/(:any)', 'TransactionRestController::show/$1');
$routes->post('/api/transactions/(:any)', 'TransactionRestController::update/$1');
$routes->delete('/api/transactions/(:any)', 'TransactionRestController::delete/$1');

$routes->get('/api/adjustments', 'AdjustmentRestController::index');
$routes->post('/api/adjustments', 'AdjustmentRestController::create');
$routes->get('/api/adjustments/(:any)', 'AdjustmentRestController::show/$1');
$routes->post('/api/adjustments/(:any)', 'AdjustmentRestController::update/$1');
$routes->delete('/api/adjustments/(:any)', 'AdjustmentRestController::delete/$1');


service('auth')->routes($routes);

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
