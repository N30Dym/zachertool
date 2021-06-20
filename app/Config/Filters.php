<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use App\Filters\{ adminAuth, einweiserAuth, umgebungFilter, protokollSessionDatenLoeschenFilter };


class Filters extends BaseConfig
{
	/**
	 * Configures aliases for Filter classes to
	 * make reading things nicer and simpler.
	 *
	 * @var array
	 */
	public $aliases = [
            'csrf'                                  => CSRF::class,
            'toolbar'                               => DebugToolbar::class,
            'honeypot'                              => Honeypot::class,
            'adminAuth'                             => adminAuth::class,
            'einweiserAuth'                         => einweiserAuth::class,
            'umgebungFilter'                        => umgebungFilter::class,
            'protokollSessionDatenLoeschenFilter'   => protokollSessionDatenLoeschenFilter::class,
	];

	/**
	 * List of filter aliases that are always
	 * applied before and after every request.
	 *
	 * @var array
	 */
	public $globals = [
            'before' => [
                // 'honeypot',
                'csrf',
                'umgebungFilter',
                'protokollSessionDatenLoeschenFilter' => ['except' => [ 'protokolle/index*', 'protokolle/kapitel*', 'protokolle/speichern*', 'protokolle/absenden*' ]],

            ],
            'after'  => [
                'toolbar',
                // 'honeypot',
            ],
	];

	/**
	 * List of filter aliases that works on a
	 * particular HTTP method (GET, POST, etc.).
	 *
	 * Example:
	 * 'post' => ['csrf', 'throttle']
	 *
	 * @var array
	 */
	public $methods = [];//['post' => 'csrf'];

	/**
	 * List of filter aliases that should run on any
	 * before or after URI patterns.
	 *
	 * Example:
	 * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
	 *
	 * @var array
	 */
	public $filters = [
            'einweiserAuth' => ['before' => 'admin/*']            
        ];
}
