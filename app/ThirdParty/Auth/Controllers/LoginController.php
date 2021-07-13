<?php
namespace Auth\Controllers;

use CodeIgniter\Controller;
use Config\Email;
use Config\Services;
use Auth\Models\UserModel;

class LoginController extends Controller
{
	/**
	 * Access to current session.
	 *
	 * @var \CodeIgniter\Session\Session
	 */
	protected $session;

	/**
	 * Authentication settings.
	 */
	protected $config;


    //--------------------------------------------------------------------

	public function __construct()
	{
		// start session
		$this->session = Services::session();

		// load auth settings
		$this->config = config('Auth');
	}

    //--------------------------------------------------------------------

	/**
	 * Displays login form or redirects if user is already logged in.
	 */
	/*public function login()
	{
		if ($this->session->isLoggedIn) {
			return redirect()->to(base_url());
		}

		return view($this->config->views['login'], ['config' => $this->config]);
	}*/
        
        public function login()
	{
            $users = new UserModel();          
            
            if ($this->session->isLoggedIn) {
                    return redirect()->to(base_url());
            }            
            elseif(! $users->istAdminAktiv())
            {
                return redirect()->to(base_url('setPassword'));
            }

            $datenHeader['titel'] = "Einloggen";
            
            echo view('templates/headerView', $datenHeader);
            echo view('templates/navbarView');
            echo view('Auth\Views\login');
            echo view('templates/footerView');
	}

    //--------------------------------------------------------------------

	/**
	 * Attempts to verify user's credentials through POST request.
	 */
	public function attemptLogin()
	{
		$users = new UserModel();
		$user = $users->where('username', $this->request->getPost('username'))->first(); // ursprünglich "email"
                //var_dump($user);
                //exit;
		if( // if-Bedingung neu erstellt
                    $user['username'] == 'admin' &&
                    empty($user['password_hash'])
                ) {
                    $passwordController = new PasswordController();
                    return $passwordController->setPassword($user['username']);
                }

                // validate request
		$rules = [
			'username'  => 'required|string', // ursprünglich 'email'  => 'required|valid_email',
			'password'  => 'required|min_length[5]',
		];

		if (! $this->validate($rules)) {
			return redirect()->to(base_url('login'))
				->withInput()
				->with('errors', $this->validator->getErrors());
		}

		// check credentials
                if (
			is_null($user) ||
			! password_verify($this->request->getPost('password'), $user['password_hash'])
		) {
			return redirect()->to('login')->withInput()->with('error', lang('Auth.wrongCredentials'));
		}

		// check activation
		if (!$user['active']) {
			return redirect()->to('login')->withInput()->with('error', lang('Auth.notActivated'));
		}

		// login OK, save user data to session
		$this->session->set('isLoggedIn', true);
                $this->session->set('mitgliedsStatus', $user['memberstatus']);
		$this->session->set('userData', [
		    'id'        => $user['id'],
		    'name'      => $user['name'],
		    'username'  => $user['username'], // ursprünglich 'email'
		    //'new_email' => $user['new_email']
		]);
                
                //$session = session();
                $this->session->setFlashdata('nachricht', 'Erfolgreich angemeldet');
                $this->session->setFlashdata('link', base_url());
                return redirect()->to(base_url('nachricht'));
	}

    //--------------------------------------------------------------------

	/**
	 * Log the user out.
	 */
	public function logout()
	{
		$this->session->remove(['isLoggedIn', 'mitgliedsStatus', 'userData']);

		$this->session->setFlashdata('nachricht', 'Erfolgreich abgemeldet');
                $this->session->setFlashdata('link', base_url());
                return redirect()->to(base_url('nachricht'));
	}

}
