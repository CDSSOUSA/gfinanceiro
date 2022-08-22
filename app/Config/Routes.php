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
$routes->setDefaultController('Main');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Main::index');
$routes->post('/login', 'Main::login');

/*ROUTES  ACCOUNT*/
$routes->group(
    '/account',
    ['namespace' => 'App\Controllers\Account'],
    function ($routes) {
        $routes->get('add', 'Account::add');
        $routes->post('create', 'Account::create');
        $routes->get('list', 'Account::list');
        $routes->get('edit/(:any)', 'Account::edit/$1');
        $routes->get('balance', 'Account::balance');
        $routes->put('update', 'Account::update');
        $routes->delete('delete', 'Account::delete');
    }
);
/*ROUTES  RUBRICA*/
$routes->group(
    '/rubrica',
    ['namespace' => 'App\Controllers\Rubrica'],
    function ($routes) {
        $routes->get('add', 'Rubrica::add');
        $routes->get('list', 'Rubrica::show');
        $routes->get('edit/(:any)', 'Rubrica::edit/$1');
        $routes->post('create', 'Rubrica::create');
        $routes->put('update', 'Rubrica::update');
        $routes->delete('delete', 'Rubrica::delete');
    }
);
/*ROUTES  MOVIMENTAÇÃO*/
$routes->group(
    '/movement',
    ['namespace' => 'App\Controllers\Movement'],
    function ($routes) {
        $routes->get('add', 'Movement::add');
        $routes->get('list', 'Movement::show');
        $routes->get('resume/(:any)/(:any)/(:any)', 'Movement::resumeDay/$1/$2/$3');
        $routes->get('resume/(:any)/(:any)', 'Movement::resume/$1/$2');
        $routes->get('edit/(:any)', 'Movement::edit/$1');
        $routes->get('search/(:any)', 'Movement::search/$1');
        $routes->post('result', 'Movement::result');
        $routes->post('create', 'Movement::create');
        $routes->put('update', 'Movement::update');
        $routes->delete('delete', 'Movement::delete');
    }
);

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
