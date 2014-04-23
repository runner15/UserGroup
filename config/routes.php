<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// default_controller
//$route['default_controller']         = 'pages';

// admin
$route['usergroup/admin/users(:any)?']  = 'users$1';
$route['usergroup/admin/group(:any)?']  = 'admin_group$1';
$route['usergroup/admin/sports(:any)?']  = 'admin_sports$1';

// pages
$route['usergroup/sport/(:any)?']  = 'sport/$1';