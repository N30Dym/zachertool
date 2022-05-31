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
$routes->add('/', 'Startseitecontroller::index');
$routes->add('startseite', 'Startseitecontroller::index');

    // Piloten
$routes->get('piloten/neu', 'piloten\Pilotencontroller::pilotAnlegen');
$routes->get('piloten/liste', 'piloten\Pilotencontroller::pilotenListe');
$routes->get('piloten/bearbeiten/(:num)', 'piloten\Pilotencontroller::pilotBearbeiten/$1');
$routes->match(['get', 'post'], 'piloten/bearbeiten/(:num)', 'piloten\Pilotencontroller::pilotBearbeiten/$1');
$routes->get('piloten/anzeigen/(:num)', 'piloten\Pilotencontroller::pilotAnzeigen/$1');
$routes->match(['get', 'post'], 'piloten/speichern', 'piloten\Pilotencontroller::pilotSpeichern');
$routes->get('piloten/speichern', 'piloten\Pilotencontroller::pilotSpeichern');

    // Flugzeuge
$routes->get('flugzeuge/neu/(:num)', 'flugzeuge\Flugzeugcontroller::flugzeugNeu/$1');
$routes->get('flugzeuge/neu', 'flugzeuge\Flugzeugcontroller::flugzeugNeu');
$routes->get('flugzeuge/bearbeiten/(:num)', 'flugzeuge\Flugzeugcontroller::flugzeugBearbeiten/$1');
$routes->get('muster/liste', 'flugzeuge\Flugzeugcontroller::musterListe');
$routes->get('flugzeuge/liste', 'flugzeuge\Flugzeugcontroller::flugzeugListe');
$routes->match(['get', 'post'], 'flugzeuge/speichern', 'flugzeuge\Flugzeugcontroller::flugzeugSpeichern');
$routes->get('flugzeuge/anzeigen/(:num)', 'flugzeuge\Flugzeugcontroller::flugzeugAnzeigen/$1');
$routes->get('flugzeuge/datenblatt/(:num)', 'flugzeuge\Flugzeugcontroller::flugzeugDatenblattPDFErzeugen/$1');

    // Nachrichten
//$routes->get('nachricht', 'Nachrichtencontroller::nachricht');

    // Protokolle
$routes->get('protokolle/index', 'protokolle\Protokollcontroller::index/');
$routes->get('protokolle/neu', 'protokolle\Protokollcontroller::neu');
$routes->get('protokolle/kapitel', 'protokolle\Protokollcontroller::index/');
$routes->get('protokolle/abbrechen', 'protokolle\Protokollcontroller::abbrechen/');
$routes->match(['get', 'post'], 'protokolle/index', 'protokolle\Protokollcontroller::index');
$routes->match(['get', 'post'], 'protokolle/index/(:num)', 'protokolle\Protokollcontroller::index/$1');
$routes->match(['get', 'post'], 'protokolle/kapitel/(:num)', 'protokolle\Protokollcontroller::kapitel/$1');
$routes->match(['get', 'post'], 'protokolle/speichern', 'protokolle\Protokollcontroller::speichern/');
$routes->match(['get', 'post'], 'protokolle/absenden', 'protokolle\Protokollcontroller::absenden/');

$routes->add('protokolle/protokollListe/', 'protokolle\ausgabe\Protokolllistencontroller::index');
$routes->get('protokolle/protokollListe/fertig', 'protokolle\ausgabe\Protokolllistencontroller::fertigeProtokolle');
$routes->get('protokolle/protokollListe/offen', 'protokolle\ausgabe\Protokolllistencontroller::angefangeneProtokolle');
$routes->get('protokolle/protokollListe/abgegeben', 'protokolle\ausgabe\Protokolllistencontroller::abgegebeneProtokolle');

    // Protokolle anzeigen
$routes->get('protokolle/anzeigen/(:num)', 'protokolle\ausgabe\Protokolldarstellungscontroller::anzeigen/$1');

$routes->group('admin', function($routes)
{
    $routes->group('piloten', function($routes)
    {
        $routes->add('', 'admin\Adminpilotencontroller::index');
        $routes->add('index', 'admin\Adminpilotencontroller::index');
        $routes->add('liste/(:segment)', 'admin\Adminpilotencontroller::liste/$1');
        $routes->add('speichern/(:segment)', 'admin\Adminpilotenspeichercontroller::speichern/$1');
        $routes->post('speichern/(:segment)', 'admin\Adminpilotenspeichercontroller::speichern/$1');
        $routes->add('bearbeiten/(:num)', 'admin\Adminpilotencontroller::bearbeiten/$1');
        $routes->post('datenSpeichern', 'admin\Adminpilotenspeichercontroller::ueberschreibePilotenDaten');
    });
    
    $routes->group('flugzeuge', function($routes)
    {
        $routes->add('', 'admin\Adminflugzeugcontroller::index');
        $routes->add('index', 'admin\Adminflugzeugcontroller::index');
        $routes->add('liste/(:segment)', 'admin\Adminflugzeugcontroller::liste/$1');
        $routes->add('bearbeitenListe/(:segment)', 'admin\Adminflugzeugcontroller::bearbeitenListe/$1');
        $routes->add('bearbeiten/(:segment)/(:num)', 'admin\Adminflugzeugcontroller::bearbeiten/$1/$2');
        $routes->add('speichern/(:segment)', 'admin\Adminflugzeugspeichercontroller::speichern/$1');
        $routes->post('speichern/(:segment)', 'admin\Adminflugzeugspeichercontroller::speichern/$1');
    });
    
    $routes->group('protokolle', function($routes)
    {
        $routes->add('', 'admin\Adminprotokollcontroller::index');
        $routes->add('index', 'admin\Adminprotokollcontroller::index');
        $routes->add('liste/(:segment)', 'admin\Adminprotokollcontroller::liste/$1');
        $routes->add('speichern/(:segment)', 'admin\Adminprotokollspeichercontroller::speichern/$1');
        $routes->post('speichern/(:segment)', 'admin\Adminprotokollspeichercontroller::speichern/$1');
    });
    
    $routes->addRedirect('', '/');
});



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
