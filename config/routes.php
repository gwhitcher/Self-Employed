<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 * Cache: Routes are cached to improve performance, check the RoutingMiddleware
 * constructor in your `src/Application.php` file to change this behavior.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {

	/* HOME */
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'home']);

    /* LOGIN */
	$routes->connect('/login', array('controller' => 'Users', 'action' => 'login'));
	$routes->connect('/logout', array('controller' => 'Users', 'action' => 'logout'));

	/* ADMIN */
	$routes->connect('/admin', array('controller' => 'Admin', 'action' => 'index'));

	/* MILEAGE */
	$routes->connect('/mileage', array('controller' => 'Mileage', 'action' => 'index'));
	$routes->connect('/mileage/add', array('controller' => 'Mileage', 'action' => 'add'));
	$routes->connect('/mileage/edit/*', array('controller' => 'Mileage', 'action' => 'edit'));
	$routes->connect('/mileage/delete/*', array('controller' => 'Mileage', 'action' => 'delete'));
	$routes->connect('/mileage/export', array('controller' => 'Mileage', 'action' => 'export'));

	/* USERS */
	$routes->connect('/users', array('controller' => 'Users', 'action' => 'index'));
	$routes->connect('/users/add', array('controller' => 'Users', 'action' => 'add'));
	$routes->connect('/users/edit/*', array('controller' => 'Users', 'action' => 'edit'));
	$routes->connect('/users/delete/*', array('controller' => 'Users', 'action' => 'delete'));

	/* EXPENSES */
	$routes->connect('/expenses', array('controller' => 'Expenses', 'action' => 'index'));
	$routes->connect('/expenses/add', array('controller' => 'Expenses', 'action' => 'add'));
	$routes->connect('/expenses/edit/*', array('controller' => 'Expenses', 'action' => 'edit'));
	$routes->connect('/expenses/delete/*', array('controller' => 'Expenses', 'action' => 'delete'));
	$routes->connect('/expenses/export', array('controller' => 'Expenses', 'action' => 'export'));


    $routes->fallbacks(DashedRoute::class);


});