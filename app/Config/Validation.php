<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var string[]
	 */
	public $ruleSets = [
		Rules::class,
		FormatRules::class,
		FileRules::class,
		CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
	
	public $muster = [
		'musterSchreibweise' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Du musst das Muster angeben.'
            ]
		], 
		'musterKlarname' => [
            'rules'  => 'required|alpha_numeric',
            'errors' => [
                'required' => 'Der Klarname fehlt.',
				'alpha_numeric' => 'Etwas ist beim Konvertieren des Klarnames falschgelaufen.'
            ]
		],
		'musterZusatz' => 'permit_empty', 
		'doppelsitzer' => [
            'rules'  => 'is_natural|less_than_equal_to[1]|permit_empty',
            'errors' => 'Wert für Doppelsitzer ist kein boolean.'
		], 
		'woelbklappen' => [
            'rules'  => 'is_natural|less_than_equal_to[1]|permit_empty',
            'errors' => 'Wert für Wölbklappe ist kein boolean.'
		]
	];
}
