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
$routes->setDefaultController('Startseite');
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

    // Startseite
$routes->get('/', 'Startseitecontroller::index');
$routes->get('startseite', 'Startseitecontroller::index');

    // Piloten
$routes->get('piloten/neu', 'piloten\Pilotencontroller::pilotAnlegen');
$routes->get('piloten/liste', 'piloten\Pilotencontroller::pilotenListe');
$routes->get('piloten/bearbeiten/(:num)', 'piloten\Pilotencontroller::pilotBearbeiten/$1');
$routes->match(['get', 'post'], 'piloten/speichern', 'piloten\Pilotencontroller::pilotSpeichern');
$routes->get('piloten/speichern', 'piloten\Pilotencontroller::pilotSpeichern');

    // Flugzeuge
$routes->get('flugzeuge/flugzeugNeu', 'flugzeuge\Flugzeugneucontroller::index');
$routes->get('flugzeuge/flugzeugNeu/(:num)', 'flugzeuge\Flugzeugneucontroller::flugzeugAnlegen/$1');
$routes->get('flugzeuge/flugzeugNeu/neu', 'flugzeuge\Flugzeugneucontroller::flugzeugAnlegen/');
$routes->match(['get', 'post'], 'flugzeuge/flugzeugNeu/flugzeugSpeichern', 'flugzeuge\Flugzeugneucontroller::flugzeugSpeichern');
$routes->get('flugzeuge/flugzeugNeu/test', 'flugzeuge\Flugzeugneucontroller::test');

    // Nachrichten
$routes->get('nachricht', 'Nachrichtencontroller::nachricht');

    // Protokolle
$routes->get('protokolle/index', 'protokolle\Protokollcontroller::index/');
$routes->get('protokolle/kapitel', 'protokolle\Protokollcontroller::index/');
$routes->get('protokolle/abbrechen', 'protokolle\Protokollcontroller::abbrechen/');
$routes->match(['get', 'post'], 'protokolle/index/(:num)', 'protokolle\Protokollcontroller::index/$1');
$routes->match(['get', 'post'], 'protokolle/kapitel/1', 'protokolle\Protokollcontroller::index/');
$routes->match(['get', 'post'], 'protokolle/kapitel/(:num)', 'protokolle\Protokollcontroller::kapitel/$1');
$routes->match(['get', 'post'], 'protokolle/speichern', 'protokolle\Protokollcontroller::speichern/');

$routes->get('protokolle/protokollListe/', 'protokolle\Protokolllistencontroller::index');
$routes->get('protokolle/protokollListe/fertig', 'protokolle\Protokolllistencontroller::fertigeProtokolle');
$routes->get('protokolle/protokollListe/offen', 'protokolle\Protokolllistencontroller::angefangeneProtokolle');
$routes->get('protokolle/protokollListe/abgegeben', 'protokolle\Protokolllistencontroller::abgegebeneProtokolle');


//$routes->get('sessionAufheben', 'Startseitecontroller::index');




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
