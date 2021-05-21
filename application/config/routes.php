<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "home";

$route['404_override'] = 'pages/page_not_found_404';

$route['pharmafocus'] = 'home/buying_group/pharmafocus';
$route['avicenna'] = 'home/buying_group/avicenna';
$route['numark'] = 'home/buying_group/numark';
$route['propharm'] = 'home/buying_group/propharm';
$route['edinpharm'] = 'home/buying_group/edinpharm';
$route['camrx'] = 'home/buying_group/camrx';
$route['albapharm'] = 'home/buying_group/albapharm';
$route['none'] = 'home/buying_group/none';
$route['multiple'] = 'home/buying_group/multiple';
$route['alphega'] = 'home/buying_group/alphega';
$route['npa'] = 'home/buying_group/npa';
$route['welocum'] = 'home/buying_group/welocum';
$route['propharmaace'] = 'home/buying_group/propharmaace';
$route['premium'] = 'home/buying_group/premium';
$route['pharmaco'] = 'home/buying_group/pharmaco';
$route['pharmaplus'] = 'home/buying_group/pharmaplus';
$route['firza'] = 'home/buying_group/firza';
$route['pm'] = 'home/buying_group/pm';
$route['pc'] = 'home/buying_group/pc';
$route['paradigm'] = 'home/buying_group/paradigm';
$route['pip'] = 'home/buying_group/pip';
$route['pharmagem'] = 'home/buying_group/pharmagem';
$route['taveljab'] = 'home/buying_group/taveljab';
$route['connect'] = 'home/buying_group/connect';


$route['travel-core-2'] = 'pages/index/travel-core-2';
$route['online-prescribing'] = 'pages/index/online-prescribing';
$route['digital-back-office'] = 'pages/index/digital-back-office';
$route['vrflu'] = 'pages/index/vrflu';
$route['about-us'] = 'pages/index/about-us';
$route['services'] = 'pages/index/services';
$route['terms-and-conditions'] = 'pages/index/terms--conditions';
$route['disclaimer'] = 'pages/index/disclaimer';
$route['security-policy'] = 'pages/index/security-policy';
$route['statement-of-purpose'] = 'pages/index/statement-of-purpose';
$route['sitemap'] = 'pages/index/sitemap';
$route['ipreg'] = 'pages/index/ipreg';
$route['subscribe'] = 'pages/index/subscribe';
$route['sub'] = 'pages/index/sub';
$route['pages/(:any)'] = 'pages/index/$1';

$route['survey/submit-survey'] = 'survey/submit_survey';
$route['survey/(:any)'] = 'survey/index/$1';
$route['eps-embed/(:any)'] = 'eps_embed/index/$1';
$route['rp-embed/(:any)'] = 'rp_embed/index/$1';
$route['survey/(:any)/(:any)'] = 'survey/index/$1/$2';

// -----------------------------------------------------------------
// ----------------------- PMR -------------------------------------
$route['organization/pmr'] = 'pmr/index';
$route['organization/pmr/add-edit-patient'] = 'pmr/add_edit_patient';
$route['organization/pmr/add-edit-patient/(:any)'] = 'pmr/add_edit_patient/$1';
$route['organization/pmr/add-edit-patient-process'] = 'pmr/add_edit_patient_process';
$route['organization/pmr/view-raf/(:any)/(:any)/(:any)'] = 'pmr/view_raf/$1/$2/$3';
$route['organization/pmr/dispense-transaction'] = 'pmr/dispense_transaction';
$route['organization/pmr/decline-transaction'] = 'pmr/decline_transaction';
$route['organization/pmr/download-rx'] = 'pmr/download_rx';
$route['organization/pmr/view-all-requests/(:any)'] = 'pmr/view_all_requests/$1';
$route['organization/pmr/get-category-raf-data'] = 'pmr/get_category_raf_data';
$route['organization/pmr/get-medicine-details'] = 'pmr/get_medicine_details';
$route['organization/pmr/save-walkin-pgd'] = 'pmr/save_walkin_pgd';
$route['organization/pmr/get-brands-diseases'] = 'pmr/get_brands_diseases';
$route['organization/pmr/get-vaccine-brands'] = 'pmr/get_vaccine_brands';
$route['organization/pmr/add-vaccine-row'] = 'pmr/add_vaccine_row';
$route['organization/pmr/get-medicine-raf'] = 'pmr/get_medicine_raf';
$route['organization/pmr/thankyou/(:any)/(:any)'] = 'pmr/thankyou/$1/$2';

$route['organization/pmr/(:any)'] = 'pmr/index/$1';

$route['registers/add-edit-registers/(:any)'] = 'registers/add_edit_registers/$1';
$route['registers/add-edit-patient/(:any)'] = 'registers/add_edit_patient/$1';
$route['registers/add-edit-prescriber/(:any)'] = 'registers/add_edit_prescriber/$1';
$route['registers/add-edit-supplier/(:any)'] = 'registers/add_edit_supplier/$1';

$route['registers/check-balance/(:any)/(:any)'] = 'registers/check-balance/$1/$2';
$route['registers/common-pdf/(:any)'] = 'registers/common-pdf/$1';
$route['registers/common-pdf/(:any)/(:any)'] = 'registers/common-pdf/$1/$2';
$route['registers/add-edit-entry/(:any)/(:any)'] = 'registers/add-edit-entry/$1/$2';
$route['registers/view-check-balance-reason/(:any)'] = 'registers/view-check-balance-reason/$1';
$route['registers/view-supply-reason/(:any)'] = 'registers/view-supply-reason/$1';

$route['registers/add-edit-witness/(:any)'] = 'registers/add-edit-witness/$1';
$route['registers/add-edit-cd-return/(:any)/(:any)'] = 'registers/add-edit-cd-return/$1/$2';

$route['registers/add-edit-pom-private-entry/(:any)'] = 'registers/add-edit-pom-private-entry/$1';
$route['registers/add-edit-special/(:any)'] = 'registers/add-edit-special/$1';
$route['registers/add-edit-emergency-supply/(:any)'] = 'registers/add-edit-emergency-supply/$1';
$route['registers/adjust-entry/(:any)'] = 'registers/adjust_entry/$1';
$route['registers/adjust-register-entery-process'] = 'registers/adjust_register_entery_process';


$route['registers/(:num)'] = 'registers/index/$1';
$route['registers/(:any)/(:num)'] = 'registers/index/$1/$2';

$route['translate_uri_dashes'] = TRUE;
/* End of file routes.php */
/* Location: ./application/config/routes.php */