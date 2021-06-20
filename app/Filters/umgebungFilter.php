<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

/**
 * Dieser Filter checkt vor jedem Seitenaufruf, welche Datenbanken verwendet werden. Wenn nicht die "scharfen" Datenbanken
 * verwendet werden, wird warnhinweis oben im Fenster ausgegeben
 *
 * @author Lars
 */
class umgebungFilter implements FilterInterface 
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $flugzeugeDB        = \Config\Database::connect('flugzeugeDB');
        $pilotenDB          = \Config\Database::connect('pilotenDB');
        $protokolleDB       = \Config\Database::connect('protokolleDB');
        $protokolllayoutDB  = \Config\Database::connect('protokolllayoutDB');
        
        if($flugzeugeDB->database !== 'zachern_flugzeuge' OR $pilotenDB->database !== 'zachern_piloten' OR $protokolleDB->database !== 'zachern_protokolle' OR $protokolllayoutDB->database !== 'zachern_protokolllayout')
        {
            echo '<!-- Durch den Filter umgebungFilter definiert -->
            <div class="container-fluid alert alert-danger text-center">
                DU BENUTZT MINDESTENS EINE TESTDATENBANK
            </div>';
        }     
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
