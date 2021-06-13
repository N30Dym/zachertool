<?php
namespace Auth\Controllers;

use CodeIgniter\Controller;
//use Config\Email;
use Config\Services;
use Auth\Models\{ UserModel, MitgliedsStatusModel };

class RegistrationController extends Controller
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
	 * Displays register form.
	 */
	public function register()
	{
            if ($this->session->isLoggedIn && $this->session->mitgliedsStatus == 0) {
                    
                $mitgliedsStatusModel = new MitgliedsStatusModel(); // Neu hinzugefügt

                $datenHeader = $datenInhalt = array();
                echo view('templates/headerView', $datenHeader);
                echo view('flugzeuge/scripts/musterListeScript');
                echo view('templates/navbarView');
                echo view('flugzeuge/musterListeView', $datenInhalt);
                echo view('templates/footerView');
            }
            else
            {
                return redirect()->to(base_url());
            }
            
            //return view($this->config->views['register'], ['config' => $this->config, 'mitgliedsStatusArray' => $mitgliedsStatusModel->getAlleStatusBezeichnungen()]);
	}

    //--------------------------------------------------------------------

	/**
	 * Attempt to register a new user.
	 */
	public function attemptRegister()
	{
		helper('text');

		// save new user, validation happens in the model
		$users = new UserModel();
		$getRule = $users->getRule('registration');
		$users->setValidationRules($getRule);
        $user = [
            'name'          	=> $this->request->getPost('name'),
            'username'         	=> $this->request->getPost('username'), // ursprünglich 'email'
            'password'          => $this->request->getPost('password'),
            'password_confirm'	=> $this->request->getPost('password_confirm'),
            'activate_hash' 	=> random_string('alnum', 32),                    
            'memberstatus'      => $this->request->getPost('memberstatus'), // Neu hinzugefügt
            
        ];

        if (! $users->save($user)) {
			return redirect()->back()->withInput()->with('errors', $users->errors());
        }

		// send activation email
		//helper('auth');
        //send_activation_email($user['email'], $user['activate_hash']);

		// success
        return redirect()->to('login')->with('success', lang('Auth.registrationSuccess'));
	}

    //--------------------------------------------------------------------

	/**
	 * Activate account.
	 */
	/*public function activateAccount()
	{
		$users = new UserModel();

		// check token
		$user = $users->where('activate_hash', $this->request->getGet('token'))
			->where('active', 0)
			->first();

		if (is_null($user)) {
			return redirect()->to('login')->with('error', lang('Auth.activationNoUser'));
		}

		// update user account to active
		$updatedUser['id'] = $user['id'];
		$updatedUser['active'] = 1;
		$users->save($updatedUser);

		return redirect()->to('login')->with('success', lang('Auth.activationSuccess'));
	}*/

}
