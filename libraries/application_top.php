<?php

// ΜΕΤΑΒΛΗΤΕΣ ΔΙΑΚΟΜΙΣΤΗ ΒΑΣΗΣ ΔΕΔΟΜΕΝΩΝ :
//-------------------------------------------


define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'diforozi_mycalendar');


// ΜΕΤΑΒΛΗΤΕΣ & FUNCTIONS ΣΥΣΤΗΜΑΤΟΣ :
//---------------------------

session_start();

require_once('mysql_stuff.php');

//######################################################################################################

$server_url      = 'http://127.0.0.1/calendar/'; /* || Μεταβλητή με το root url της εφαρμογής.                       || */
$pages_dir       = 'pages/';                     /* || Μεταβλητή με τον κατάλογο αρχείων περιεχομένου ( και κώδικα ) || */
$css_dir         = 'css/';                       /* || Μεταβλητή με τον κατάλογο αρχείων css                         || */
$javascript_dir  = 'javascript/';                

define('MAIN_PAGE',  $server_url);
define('IMAGES_DIR', $server_url . 'images/');
define('TEMPLATES_DIR', '../template_parts/');
define('LIBRARIES_DIR', '../libraries/');
define('HEADER_MENU', TEMPLATES_DIR . 'header.php');
define('INDEX_HEADER', 'template_parts/header.php');
define('CSS_DIR', MAIN_PAGE . $css_dir);
define('CALENDAR_CSS', CSS_DIR . 'calendar.css');
define('FOOTER', TEMPLATES_DIR . 'footer.php');
define('INDEX_FOOTER', 'template_parts/footer.php');
define('APPLICATION_BOTTOM_SCRIPT',  LIBRARIES_DIR . 'application_bottom.php');
define('INDEX_APPLICATION_BOTTOM_SCRIPT', 'libraries/application_bottom.php');
define('ABOUT_US_PAGE', MAIN_PAGE . $pages_dir . 'about_us.php');
define('HOW_IT_WORKS_PAGE', MAIN_PAGE . $pages_dir . 'how_it_works.php');
define('LOGIN_PAGE', MAIN_PAGE . $pages_dir . 'login.php');
define('LOGOUT_PAGE', MAIN_PAGE . $pages_dir . 'logout.php');
define('REGISTER_PAGE', MAIN_PAGE . $pages_dir . 'register.php');
define('NEW_CALENDAR_PAGE', MAIN_PAGE . $pages_dir . 'new_calendar.php?page=newcalendar');
define('DELETEUSER_PAGE', MAIN_PAGE . $pages_dir  . 'deleteuser.php');
define('REPLACE_PAGE', MAIN_PAGE . $pages_dir . 'replace.php');
define('CLASSES_DIR', '../classes/');
define('EMAIL_DIR', '../email/');
define('EMAIL_DIR_IMAGES', '../email/images/');
define('EMAIL_IMAGES', '../images/');
define('DIRECT_EMAIL_IMAGES', MAIN_PAGE . 'email/images/');
define('EMAIL_TEMPLATES', EMAIL_DIR . 'templates/');
define('EMAIL_CSS', '../css/');
define('JS_DIR', MAIN_PAGE . $javascript_dir);
define('MODAL_CSS', CSS_DIR . 'jquery.modal.css');
define('MODAL_JS', JS_DIR . 'jquery.modal.js');
define('NEW_CALENDAR_CLASS', CLASSES_DIR . 'calendar.php');

?>