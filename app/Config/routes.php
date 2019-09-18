<?php
Router::connect('/', array('controller' => 'Dashboards', 'action' => 'Index'));
Router::parseExtensions('pdf');
require CAKE . 'Config' . DS . 'routes.php';

