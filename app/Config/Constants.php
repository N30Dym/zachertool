<?php

use Auth\Models\MitgliedsStatusModel;
/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2592000);
defined('YEAR')   || define('YEAR', 31536000);
defined('DECADE') || define('DECADE', 315360000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
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
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

//-------------------------------------------------------------------------------------------------------------------------------------

/*
 * Beim Erstellen des Protokolllayouts gibt nehmen die Kapitel "Angaben zum Flugzeug", "Angaben zum Piloten / zu den Piloten" und "Angaben zum Beladungszustand"
 * eine besondere Rolle ein. Diese k??nnen bei allen ProtokollTypen aufgerufen werden und sind fest programmierte Seiten.
 * Um diese drei Seiten aufrufen zu k??nnen werden ihre IDs in Konstanten gespeichert, die dann von ??berall aufgerufen werden k??nnen.
 * So kommt es zu keinen Verwechslungen
 * 
 */
defined('PROTOKOLL_AUSWAHL')    || define('PROTOKOLL_AUSWAHL', 0); // "Angaben zum Protokoll"
defined('FLUGZEUG_EINGABE')     || define('FLUGZEUG_EINGABE', 1); // "Angaben zum Flugzeug"
defined('PILOT_EINGABE')        || define('PILOT_EINGABE', 2); // "Angaben zum Piloten / zu den Piloten"
defined('BELADUNG_EINGABE')     || define('BELADUNG_EINGABE', 3); // "Angaben zur Beladung"

//-------------------------------------------------------------------------------------------------------------------------------------

/**
 * Um den Mitgliedsstatus klar zu definieren werden hier die IDs der jeweiligen Status geladen und als
 * Administrator, bzw. Zachereinweiser definiert. Weitere Status k??nnen erg??nzt werden.
 */

defined('ADMINISTRATOR')    || define('ADMINISTRATOR', 1); // Administrator ID setzen
defined('ZACHEREINWEISER')  || define('ZACHEREINWEISER', 2); // Zachereinweiser ID setzen
