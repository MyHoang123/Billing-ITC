<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
// Add this route for tariff creation API
$route['mbbank/ipn'] = "MbbankPublish/MbbankIPN";                    //IPN PUBLISH

$route['106a6c241b8797f52e1e77317b96a201'] = "home";
$route['106a6c241b8797f52e1e77317b96a201/([a-zA-Z0-9]+)'] = "home/$1";

$route['ee11cbb19052e40b07aac0ca060c23ee'] = "user";
$route['ee11cbb19052e40b07aac0ca060c23ee/([a-zA-Z0-9]+)'] = "user/$1";

$route['d13bc5b68b2bd9e18f29777db17cc563'] = "Common";
$route['d13bc5b68b2bd9e18f29777db17cc563/([a-zA-Z0-9]+)'] = "Common/$1";

$route['dd560916dcc8bb795671b54a5640cec3'] = "Contract_Tariff";
$route['dd560916dcc8bb795671b54a5640cec3/([a-zA-Z0-9]+)'] = "Contract_Tariff/$1";

$route['eaeb30f9f18e0c50b178676f3eaef45f'] = "Task";
$route['eaeb30f9f18e0c50b178676f3eaef45f/([a-zA-Z0-9]+)'] = "Task/$1";

$route['0a90b1bc4078f74b6f0d117ec7df65af'] = "Credit";
$route['0a90b1bc4078f74b6f0d117ec7df65af/([a-zA-Z0-9]+)'] = "Credit/$1";

$route['4b1b4dc8cf38b3c64b1d657da8f5ac8c'] = "Report";
$route['4b1b4dc8cf38b3c64b1d657da8f5ac8c/([a-zA-Z0-9]+)'] = "Report/$1";

$route['a0ce6e32fcbd45dfec6dc291b36a59ad'] = "InvoiceManagement";
$route['a0ce6e32fcbd45dfec6dc291b36a59ad/([a-zA-Z0-9]+)'] = "InvoiceManagement/$1";

$route['466eadd40b3c10580e3ab4e8061161ce'] = "Invoice";
$route['466eadd40b3c10580e3ab4e8061161ce/([a-zA-Z0-9]+)'] = "Invoice/$1";

$route['8625e1de7be14c39b1d14dc03d822497'] = "Tools";
$route['8625e1de7be14c39b1d14dc03d822497/([a-zA-Z0-9]+)'] = "Tools/$1";

$route['b4b8139fd78a5c0460a7de2c25b3f387'] = "ExportRPT";
$route['b4b8139fd78a5c0460a7de2c25b3f387/([a-zA-Z0-9]+)'] = "ExportRPT/$1";

$route['33952728babf3c592dbcfe62883f4662'] = "Edimg";
$route['33952728babf3c592dbcfe62883f4662/([a-zA-Z0-9]+)'] = "Edimg/$1";

$route['72664dc0959f3b0c04891f8c7046a9f3'] = "Api";
$route['72664dc0959f3b0c04891f8c7046a9f3/([a-zA-Z0-9]+)'] = "Api/$1";

$route['d171035a85cc2258e37d64e18505d78c'] = "Mbbank";
$route['d171035a85cc2258e37d64e18505d78c/([a-zA-Z0-9]+)'] = "Mbbank/$1";

$route['defc9d3abbeba4eef5865829848a6a39'] = "MnPayment";
$route['defc9d3abbeba4eef5865829848a6a39/([a-zA-Z0-9]+)'] = "MnPayment/$1";




