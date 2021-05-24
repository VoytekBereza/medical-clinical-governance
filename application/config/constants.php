<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Europe/London');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESCTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

// User defined variables

define('DEFAULT_TITLE',':: Hubnet ::');

//define('DEFAULT_META_DESCRIPTION');

// define('SURL','https://'.$_SERVER['HTTP_HOST'].'/');
define('SURL','http://'.$_SERVER['HTTP_HOST'].'/hubnet/V2/');

define('TECHDEVELOPERS_SURL','https://pharmafocus.co.uk/');
define('TECHDEVELOPERS_API_SURL',TECHDEVELOPERS_SURL.'api/');

define('GETJAB_SURL','https://getjab.co.uk/');

define('CUSTOM_PACKAGE_PRICE','399.00');

define('MURL','https://'.$_SERVER['HTTP_HOST']);
define('SITE_NAME','Welcome to Hubnet.io');

// Health 
define('VH_SURL','https://voyagerhealth.co.uk/');

define('ASSETS',SURL.'assets/');
define('CSS',SURL.'assets/css/');
define('JS',SURL.'assets/js/');
define('SLIDER',SURL.'assets/slider.images/');
define('IMAGES',SURL.'assets/images/');
define('IMG',SURL.'assets/img/');
define('FONTS_AWSOME',SURL.'assets/font-awesome/');
define('FONTS_AWSOME_CSS',SURL.'assets/font-awesome/css/');
define('TRAINING_COURSE_IMAGES',SURL.'assets/training_course_images/');
define('PGD_IMAGES',SURL.'assets/pgd_images/');
define('USER_SIGNATURE',SURL.'assets/user_signature/');
define('ORG_STAMP',SURL.'assets/org_stamp/');
define('ORG_STAMP_THUMB',SURL.'assets/org_stamp/thumb-');
define('VIDEOS',SURL.'assets/videos/');
define('PDF',SURL.'assets/pdf/');
define('CSV',SURL.'assets/csv/');
define('TRAINING_LOG_FILES',SURL.'assets/training_log_files/');
define('CQC_STAMPS',SURL.'assets/images/cqc_stamps/');
define('ORG_LOGO',SURL.'assets/images/org_logo/');
define('SITE_LOGO',IMAGES.'logo.png');


//PAYPAL Credentials
define('PAYPAL_API_USERNAME','businesskodion_api1.gmail.com');
define('PAYPAL_API_SIGNATURE','AyoSqNDiiTFioCQFoi0NYig-W70oAUZfBIuExYEM-1dihOkVXrCtF3xB');
define('PAYPAL_API_PASSWORD','4MXMY3EJ7AMJHQ5S');
define('PAYPAL_SANDBOX_STATUS',TRUE); //False = LIVE, True = Sandbox
define('PAYMENT_METHOD','Sale');
define('CURRENCY','GBP');

//Order Prefix
define('ORDER_PREFIX','VOY-');

//Authorized Stamp Path
define('AUTHORIZED_STAMP_PATH',IMAGES.'ritchiestamp.png');

define('CAPTCHA_ENABLE','0'); // 0 = Off, 1 = On!