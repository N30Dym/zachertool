<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

use Config\Services;
/**
 * Description of protokollSessionDatenLoeschenFilter
 *
 * @author Lars
 */
class protokollSessionDatenLoeschenFilter  implements FilterInterface {
    
    public function before(RequestInterface $request, $arguments = null)
    {
        if(session_status() !== PHP_SESSION_ACTIVE)
        {
           $session = Services::session();   
        }

        if(isset($_SESSION['protokoll']))
        {
            unset($_SESSION['protokoll']);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
