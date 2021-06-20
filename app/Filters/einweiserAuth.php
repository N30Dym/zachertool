<?php
namespace App\Filters;

use Config\Services;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
/**
 * Description of adminAuth
 *
 * @author Lars
 */
class einweiserAuth implements FilterInterface
{
    
    public function before(RequestInterface $request, $arguments = null)
    {
        // start session
        $session = Services::session();
        
        if( ! $session->isLoggedIn OR ($session->mitgliedsStatus != ADMINISTRATOR AND $session->mitgliedsStatus != ZACHEREINWEISER))
        {
            return redirect()->to(site_url('login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}