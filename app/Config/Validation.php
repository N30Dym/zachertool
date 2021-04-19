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
                'required' => 'Das Muster wurde nicht angegeben.'
            ]
		], 
		'musterKlarname' => [
            'rules'  => 'required|alpha_numeric',
            'errors' => [
                'required' => 'Der Klarname fehlt.',
				'alpha_numeric' => 'Etwas ist beim Konvertieren des Klarnames schiefgelaufen.'
            ]
		],
		'musterZusatz' => 'permit_empty', 
		'istDoppelsitzer' => [
            'rules'  => 'is_natural|less_than_equal_to[1]|permit_empty',
            'errors' => 'Der Wert für Doppelsitzer ist kein Boolean.'
		], 
		'istWoelbklappenFlugzeug' => [
            'rules'  => 'is_natural|less_than_equal_to[1]|permit_empty',
            'errors' => 'Der Wert für Wölbklappe ist kein Boolean.'
		]
	];
	
	public $musterDetails =[
		'musterID' => [
            'rules'  	=> 'required|numeric',
            'errors' 	=> [
                'required'	=> 'Die musterID wurde angeben.',
				'numeric' 	=> 'Die musterID ist keine Zahl.'
            ]
		],
		'kupplung' => [
            'rules'  	=> 'required|in_list[Bug,Schwerpunkt]',
            'errors' 	=> [
                'required' 	=> 'Der Kupplungstyp wurde nicht angegeben.',
				'in_list' 	=> 'Für den Kupplungstyp wurde eine nicht vorhandene Option gewählt.'
            ]
		],
		'diffQR' => [
            'rules'  	=> 'required|in_list[Ja,Nein]',
            'errors' 	=> [
                'required' 	=> 'Die Querruderdifferenzierung wurde nicht angegeben.',
				'in_list' 	=> 'Für die Querruderdifferenzierung wurde eine nicht vorhandene Option gewählt.'
            ]
		],
		'radgroesse' => [
            'rules' 	=> 'required|string',
            'errors'	=> 'Die Radgröße wurde nicht angegeben.'
		],
		'radbremse' => [
            'rules'  	=> 'required|in_list[Scheibe,Trommel]',
            'errors' 	=> [
                'required' 	=> 'Der Radbremsetyp wurde nicht angegeben.',
				'in_list' 	=> 'Für den Radbremsetyp wurde eine nicht vorhandene Option gewählt.'
            ]
		],
		'radfederung' => [
            'rules'  	=> 'required|in_list[Ja,Nein]',
            'errors' 	=> [
                'required' 	=> 'Die Radfederung wurde nicht angegeben.',
				'in_list' 	=> 'Für die Radfederung wurde eine nicht vorhandene Option gewählt.'
            ]
		],
		'fluegelflaeche' => [
            'rules'  	=> 'required|numeric',
            'errors' 	=> [
                'required' 	=> 'Die Flügelfläche wurde nicht angegeben.',
				'numeric'	=> 'Die Flügelfläche wurde nicht als Zahl angegeben.'
            ]
		],
		'spannweite' => [
            'rules'  	=> 'required|numeric',
            'errors' 	=> [
                'required' 	=> 'Die Spannweite wurde nicht angegeben.',
				'numeric'	=> 'Die Spannweite wurde nicht als Zahl angegeben.'
            ]
		],
		'bremsklappen' => [
            'rules'  => 'required|string',
            'errors' => 'Die Bremsklappenart wurde nicht angegeben.'
		],
		'iasVG' => [
            'rules'  => 'permit_empty|numeric',
            'errors' => [
                'numeric' => 'Für die IAS<sub>VG</sub> wurde keine Zahl angegeben.'
            ]
		],
		'mtow' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required' 	=> 'Das MTOW wurde nicht angegeben.',
				'numeric'	=> 'Das MTOW wurde nicht als Zahl angegeben.'
            ]
		],
		'leermasseSPMin' => [
            'rules'  => 'permit_empty|numeric',
            'errors' => [
                'numeric' => 'Der Leermasseschwerpunktsbereich wurde nicht als Zahl angegeben.'
            ]
		],
		'leermasseSPMax' => [
            'rules'  => 'permit_empty|numeric',
            'errors' => ['Der Leermasseschwerpunktsbereich wurde nicht als Zahl angegeben.'
            ]
		],
		'flugSPMin' => [
            'rules'  => 'permit_empty|numeric',
            'errors' => [
                'numeric' => 'Der Flugschwerpunktsbereich wurde nicht als Zahl angegeben.'
            ]
		],
		'flugSPMax' => [
            'rules'  => 'permit_empty|numeric',
            'errors' => [
                'numeric' => 'Der Flugschwerpunktsbereich wurde nicht als Zahl angegeben.'
            ]
		],
		'bezugspunkt' => [
            'rules'  => 'required|string',
            'errors' => [
                'required' => 'Der Flugschwerpunktsbereich wurde nicht angegeben.',
				'string' => 'Falsches Format für den Flugschwerpunktsbereich.'
            ]
		],
		'anstellwinkel' => [
            'rules'  => 'required|string',
            'errors' => [
                'required' => 'Die Längsneigung wurde nicht angegeben.',
				'string' => 'Falsches Format für die Längsneigung.'
            ]
		],
	];
	
	public $flugzeuge = [
		'kennung' => [
            'rules'  => 'required|alpha_numeric_punct',
            'errors' => [
                'required' => 'Du musst die Kennung angeben.',
				'alpha_numeric_punct' => 'Die Kennung enthält nicht zulässige Zeichen.'
			]
        ], 
		'musterID' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Die musterID wurde angeben.',
				'numeric' => 'Die musterID ist keine Zahl.'
            ]
		],
		'sichtbar' => [
            'rules'  => 'is_natural|less_than_equal_to[1]|permit_empty',
            'errors' =>  'Die Sichtbarkeit ist kein Boolean.'
		]
	];
}
