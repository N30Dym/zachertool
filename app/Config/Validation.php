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
	
    public $musterDetails = [ 
        'musterID' => [
            'rules'  	=> 'required|numeric',
            'errors' 	=> [
                'required'  => 'Die musterID wurde nicht angegeben.',
                'numeric'   => 'Die musterID ist keine Zahl.'
            ]
        ],
        'kupplung' => [
            'rules'  	=> 'required|in_list[Bug,Schwerpunkt]',
            'errors' 	=> [
                'required'  => 'Der Kupplungstyp wurde nicht angegeben.',
                'in_list'   => 'Für den Kupplungstyp wurde eine nicht vorhandene Option gewählt.'
            ]
        ],
        'diffQR' => [
            'rules'  	=> 'required|in_list[Ja,Nein]',
            'errors' 	=> [
                'required'  => 'Die Querruderdifferenzierung wurde nicht angegeben.',
                'in_list'   => 'Für die Querruderdifferenzierung wurde eine nicht vorhandene Option gewählt.'
            ]
        ],
        'radgroesse' => [
            'rules'     => 'required|string',
            'errors'    => 'Die Radgröße wurde nicht angegeben.'
        ],
        'radbremse' => [
            'rules'  	=> 'required|in_list[Scheibe,Trommel]',
            'errors' 	=> [
                'required'  => 'Der Radbremsetyp wurde nicht angegeben.',
                'in_list'   => 'Für den Radbremsetyp wurde eine nicht vorhandene Option gewählt.'
            ]
        ],
        'radfederung' => [
            'rules'  	=> 'required|in_list[Ja,Nein]',
            'errors' 	=> [
                'required'  => 'Die Radfederung wurde nicht angegeben.',
                'in_list'   => 'Für die Radfederung wurde eine nicht vorhandene Option gewählt.'
            ]
        ],
        'fluegelflaeche' => [
            'rules'  	=> 'required|numeric',
            'errors' 	=> [
                'required'  => 'Die Flügelfläche wurde nicht angegeben.',
                'numeric'   => 'Die Flügelfläche wurde nicht als Zahl angegeben.'
            ]
        ],
        'spannweite' => [
            'rules'  	=> 'required|numeric',
            'errors' 	=> [
                'required'  => 'Die Spannweite wurde nicht angegeben.',
                'numeric'   => 'Die Spannweite wurde nicht als Zahl angegeben.'
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
                'required'  => 'Das MTOW wurde nicht angegeben.',
                'numeric'   => 'Das MTOW wurde nicht als Zahl angegeben.'
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
                'required'  => 'Der Flugschwerpunktsbereich wurde nicht angegeben.',
                'string'    => 'Falsches Format für den Flugschwerpunktsbereich.'
            ]
        ],
        'anstellwinkel' => [
            'rules'  => 'required|string',
            'errors' => [
                'required'  => 'Die Längsneigung wurde nicht angegeben.',
                'string'    => 'Falsches Format für die Längsneigung.'
            ]
        ],
    ];

	
    public $musterDetailsOhneMusterID = [
        'kupplung' => [
            'rules'  	=> 'required|in_list[Bug,Schwerpunkt]',
            'errors' 	=> [
                'required'  => 'Der Kupplungstyp wurde nicht angegeben.',
                'in_list'   => 'Für den Kupplungstyp wurde eine nicht vorhandene Option gewählt.'
            ]
        ],
        'diffQR' => [
            'rules'  	=> 'required|in_list[Ja,Nein]',
            'errors' 	=> [
                'required'  => 'Die Querruderdifferenzierung wurde nicht angegeben.',
                'in_list'   => 'Für die Querruderdifferenzierung wurde eine nicht vorhandene Option gewählt.'
            ]
        ],
        'radgroesse' => [
            'rules' 	=> 'required|string',
            'errors'	=> 'Die Radgröße wurde nicht angegeben.'
		],
		'radbremse' => [
            'rules'  	=> 'required|in_list[Scheibe,Trommel]',
            'errors' 	=> [
                'required'  => 'Der Radbremsetyp wurde nicht angegeben.',
                'in_list'   => 'Für den Radbremsetyp wurde eine nicht vorhandene Option gewählt.'
            ]
        ],
        'radfederung' => [
            'rules'  	=> 'required|in_list[Ja,Nein]',
            'errors' 	=> [
                'required'  => 'Die Radfederung wurde nicht angegeben.',
                'in_list'   => 'Für die Radfederung wurde eine nicht vorhandene Option gewählt.'
            ]
        ],
        'fluegelflaeche' => [
            'rules'  	=> 'required|numeric',
            'errors' 	=> [
                'required'  => 'Die Flügelfläche wurde nicht angegeben.',
                'numeric'   => 'Die Flügelfläche wurde nicht als Zahl angegeben.'
            ]
        ],
        'spannweite' => [
            'rules'  	=> 'required|numeric',
            'errors' 	=> [
                'required'  => 'Die Spannweite wurde nicht angegeben.',
                'numeric'   => 'Die Spannweite wurde nicht als Zahl angegeben.'
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
                'required'  => 'Das MTOW wurde nicht angegeben.',
                'numeric'   => 'Das MTOW wurde nicht als Zahl angegeben.'
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
                'required'  => 'Der Flugschwerpunktsbereich wurde nicht angegeben.',
                'string'    => 'Falsches Format für den Flugschwerpunktsbereich.'
            ]
        ],
        'anstellwinkel' => [
            'rules'  => 'required|string',
            'errors' => [
                'required'  => 'Die Längsneigung wurde nicht angegeben.',
                'string'    => 'Falsches Format für die Längsneigung.'
            ]
        ]
    ];
	
    public $flugzeuge = [
        'kennung' => [
            'rules'  => 'required|string',
            'errors' => [
                'required'              => 'Die Kennung wurde nicht angeben.',
                'alpha_numeric_punct'   => 'Die Kennung enthält nicht zulässige Zeichen.'
            ]
        ], 
        'musterID' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Die musterID wurde angeben.',
                'numeric'   => 'Die musterID ist keine Zahl.'
            ]
        ],
        'sichtbar' => [
            'rules'  => 'is_natural|less_than_equal_to[1]|permit_empty',
            'errors' =>  'Die Sichtbarkeit ist kein Boolean.'
            ]
	];
	
    public $flugzeugeOhneMusterID = [
        'kennung' => [
            'rules'  => 'required|string',
            'errors' => [
                'required'              => 'Die Kennung wurde nicht angeben.',
                'alpha_numeric_punct'   => 'Die Kennung enthält nicht zulässige Zeichen.'
            ]
        ], 
        'sichtbar' => [
            'rules'  => 'is_natural|less_than_equal_to[1]|permit_empty',
            'errors' =>  'Die Sichtbarkeit ist kein Boolean.'
            ]
	];
	
    public $flugzeugDetails = [
        'flugzeugID' => [
            'rules'  	=> 'required|numeric',
            'errors' 	=> [
                'required'  => 'Die flugzeugID wurde nicht angegeben.',
                'numeric'   => 'Die flugzeugID ist keine Zahl.'
            ]
        ],
        'baujahr'=> [
            'rules'  	=> 'required|numeric',
            'errors' 	=> [
                'required'  => 'Das Baujahr wurde nicht angegeben.',
                'numeric'   => 'Das Baujahr ist keine Zahl.'
            ]
        ],
        'seriennummer'=> [
            'rules'  	=> 'required|string',
            'errors' 	=> [
                'required'  => 'Die Seriennummer wurde nicht angegeben.',
            ]
        ],
        'kupplung' => [
            'rules'  	=> 'required|in_list[Bug,Schwerpunkt]',
            'errors' 	=> [
                'required'  => 'Der Kupplungstyp wurde nicht angegeben.',
                'in_list'   => 'Für den Kupplungstyp wurde eine nicht vorhandene Option gewählt.'
            ]
        ],
        'diffQR' => [
            'rules'  	=> 'required|in_list[Ja,Nein]',
            'errors'    => [
                'required'  => 'Die Querruderdifferenzierung wurde nicht angegeben.',
                'in_list'   => 'Für die Querruderdifferenzierung wurde eine nicht vorhandene Option gewählt.'
            ]
        ],
        'radgroesse' => [
            'rules' 	=> 'required|string',
            'errors'	=> 'Die Radgröße wurde nicht angegeben.'
        ],
        'radbremse' => [
            'rules'  	=> 'required|in_list[Scheibe,Trommel]',
            'errors' 	=> [
                'required'  => 'Der Radbremsetyp wurde nicht angegeben.',
                'in_list'   => 'Für den Radbremsetyp wurde eine nicht vorhandene Option gewählt.'
            ]
        ],
        'radfederung' => [
            'rules'  	=> 'required|in_list[Ja,Nein]',
            'errors' 	=> [
                'required'  => 'Die Radfederung wurde nicht angegeben.',
                'in_list'   => 'Für die Radfederung wurde eine nicht vorhandene Option gewählt.'
            ]
        ],
        'fluegelflaeche' => [
            'rules'  	=> 'required|numeric',
            'errors' 	=> [
                'required'  => 'Die Flügelfläche wurde nicht angegeben.',
                'numeric'   => 'Die Flügelfläche wurde nicht als Zahl angegeben.'
            ]
        ],
        'spannweite' => [
            'rules'  	=> 'required|numeric',
            'errors' 	=> [
                'required'  => 'Die Spannweite wurde nicht angegeben.',
                'numeric'   => 'Die Spannweite wurde nicht als Zahl angegeben.'
            ]
        ],
        'variometer' => [
            'rules'  	=> 'required|string',
            'errors' 	=> [
                'required'  => 'Das Variometer wurde nicht angegeben.',
                'string'    => 'Die Eingabe des Variometers enthält Zeichen, die nicht gespeichert werden können.'
            ]
        ],
        'tekArt' => [
            'rules'  	=> 'required|string',
            'errors' 	=> [
                'required'  => 'Die Art der TEK-Düse wurde nicht angegeben.',
                'string'    => 'Die Eingabe der TEK enthält Zeichen, die nicht gespeichert werden können.'
            ]
        ],
        'tekPosition' => [
            'rules'  	=> 'required|string',
            'errors' 	=> [
                'required'  => 'Die Position der TEK-Düse wurde nicht angegeben.',
                'string'    => 'Die Eingabe der TEK enthält Zeichen, die nicht gespeichert werden können.'
            ]
        ],
        'pitotArt' => [
            'rules'  	=> 'required|string',
            'errors' 	=> [
                'required'  => 'Die Lage der Gesamtdruckabnahme wurde nicht angegeben.',
                'string'    => 'Die Eingabe der Lage der Gesamtdruckabnahme enthält Zeichen, die nicht gespeichert werden können.'
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
                'required'  => 'Das MTOW wurde nicht angegeben.',
                'numeric'   => 'Das MTOW wurde nicht als Zahl angegeben.'
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
                'required'  => 'Der Flugschwerpunktsbereich wurde nicht angegeben.',
                'string'    => 'Falsches Format für den Flugschwerpunktsbereich.'
            ]
        ],
        'anstellwinkel' => [
            'rules'  => 'required|string',
            'errors' => [
                'required'  => 'Die Längsneigung wurde nicht angegeben.',
                'string'    => 'Falsches Format für die Längsneigung.'
            ]
        ],
        'kommentar' => [
            'rules'  => 'permit_empty|string',
            'errors' => [
                'string'    => 'Falsches Format für den Kommentar.'
            ]
        ]
    ];
	
    public $flugzeugDetailsOhneFlugzeugID =[
        'baujahr'=> [
            'rules'  	=> 'required|numeric',
            'errors' 	=> [
                'required'  => 'Das Baujahr wurde nicht angegeben.',
                'numeric'   => 'Das Baujahr ist keine Zahl.'
            ]
        ],
        'seriennummer'=> [
            'rules'     => 'required|string',
            'errors'    => [
                'required'  => 'Die Seriennummer wurde nicht angegeben.',
            ]
        ],
        'kupplung' => [
            'rules'  	=> 'required|in_list[Bug,Schwerpunkt]',
            'errors' 	=> [
                'required'  => 'Der Kupplungstyp wurde nicht angegeben.',
                'in_list'   => 'Für den Kupplungstyp wurde eine nicht vorhandene Option gewählt.'
            ]
        ],
        'diffQR' => [
            'rules'  	=> 'required|in_list[Ja,Nein]',
            'errors' 	=> [
                'required'  => 'Die Querruderdifferenzierung wurde nicht angegeben.',
                'in_list'   => 'Für die Querruderdifferenzierung wurde eine nicht vorhandene Option gewählt.'
            ]
        ],
        'radgroesse' => [
            'rules' 	=> 'required|string',
            'errors'	=> 'Die Radgröße wurde nicht angegeben.'
        ],
        'radbremse' => [
            'rules'  	=> 'required|in_list[Scheibe,Trommel]',
            'errors' 	=> [
                'required'  => 'Der Radbremsetyp wurde nicht angegeben.',
                'in_list'   => 'Für den Radbremsetyp wurde eine nicht vorhandene Option gewählt.'
            ]
        ],
        'radfederung' => [
            'rules'  	=> 'required|in_list[Ja,Nein]',
            'errors' 	=> [
                'required'  => 'Die Radfederung wurde nicht angegeben.',
                'in_list'   => 'Für die Radfederung wurde eine nicht vorhandene Option gewählt.'
            ]
        ],
        'fluegelflaeche' => [
            'rules'  	=> 'required|numeric',
            'errors' 	=> [
                'required'  => 'Die Flügelfläche wurde nicht angegeben.',
                'numeric'   => 'Die Flügelfläche wurde nicht als Zahl angegeben.'
            ]
        ],
        'spannweite' => [
            'rules'  	=> 'required|numeric',
            'errors' 	=> [
                'required'  => 'Die Spannweite wurde nicht angegeben.',
                'numeric'   => 'Die Spannweite wurde nicht als Zahl angegeben.'
            ]
        ],
        'variometer' => [
            'rules'  	=> 'required|string',
            'errors' 	=> [
                'required'  => 'Das Variometer wurde nicht angegeben.',
                'string'    => 'Die Eingabe des Variometers enthält Zeichen, die nicht gespeichert werden können.'
            ]
        ],
        'tekArt' => [
            'rules'  	=> 'required|string',
            'errors' 	=> [
                'required'  => 'Die Art der TEK-Düse wurde nicht angegeben.',
                'string'    => 'Die Eingabe der TEK enthält Zeichen, die nicht gespeichert werden können.'
            ]
        ],
        'tekPosition' => [
            'rules'  	=> 'required|string',
            'errors' 	=> [
                'required'  => 'Die Position der TEK-Düse wurde nicht angegeben.',
                'string'    => 'Die Eingabe der TEK enthält Zeichen, die nicht gespeichert werden können.'
            ]
        ],
        'pitotPosition' => [
            'rules'  	=> 'required|string',
            'errors' 	=> [
                'required'  => 'Die Lage der Gesamtdruckabnahme wurde nicht angegeben.',
                'string'    => 'Die Eingabe der Lage der Gesamtdruckabnahme enthält Zeichen, die nicht gespeichert werden können.'
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
                'required'  => 'Das MTOW wurde nicht angegeben.',
                'numeric'   => 'Das MTOW wurde nicht als Zahl angegeben.'
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
                'required'  => 'Der Flugschwerpunktsbereich wurde nicht angegeben.',
                'string'    => 'Falsches Format für den Flugschwerpunktsbereich.'
            ]
        ],
        'anstellwinkel' => [
            'rules'  => 'required|string',
            'errors' => [
                'required'  => 'Die Längsneigung wurde nicht angegeben.',
                'string'    => 'Falsches Format für die Längsneigung.'
            ]
        ],
        'kommentar' => [
            'rules'  => 'permit_empty|string',
            'errors' => [
                'string'    => 'Falsches Format für den Kommentar.'
            ]
        ]
    ];
	
    public $musterHebelarm = [
        'musterID' => [
            'rules'  	=> 'required|numeric',
            'errors' 	=> [
                'required'  => 'Die musterID wurde nicht angegeben.',
                'numeric'   => 'Die musterID ist keine Zahl.'
            ]
        ], 
        'beschreibung' => [
            'rules'  => 'required|string',
            'errors' => [
                'required'  => 'Die Hebelarmbeschreibung wurde nicht angegeben.',
                'string'    => 'Die Eingabe der Hebelarmbeschreibung enthält Zeichen, die nicht gespeichert werden können.'
            ]
        ], 
        'hebelarm' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Die Hebelarmlänge wurde nicht angegeben.',
                'numeric'   => 'Der Hebelarmlänge ist keine Zahl.'
            ]
        ]
    ];

    public $flugzeugHebelarm = [
        'flugzeugID' => [
            'rules'  	=> 'required|numeric',
            'errors' 	=> [
                'required'  => 'Die flugzeugID wurde nicht angegeben.',
                'numeric'   => 'Die flugzeugID ist keine Zahl.'
            ]
        ], 
        'beschreibung' => [
            'rules'  => 'required|string',
            'errors' => [
                 'required' => 'Die Hebelarmbeschreibung wurde nicht angegeben.',
                'string'    => 'Die Eingabe der Hebelarmbeschreibung enthält Zeichen, die nicht gespeichert werden können.'
            ]
        ], 
        'hebelarm' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Die Hebelarmlänge wurde nicht angegeben.',
                'numeric'   => 'Der Hebelarmlänge ist keine Zahl.'
            ]
        ]
    ];

    public $flugzeugHebelarmeOhneFlugzeugID = [
        'beschreibung' => [
            'rules'  => 'required|string',
            'errors' => [
                'required'  => 'Die Hebelarmbeschreibung wurde nicht angegeben.',
                'string'    => 'Die Eingabe der Hebelarmbeschreibung enthält Zeichen, die nicht gespeichert werden können.'
            ]
        ], 
        'hebelarm' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Die Hebelarmlänge wurde nicht angegeben.',
                'numeric'   => 'Der Hebelarmlänge ist keine Zahl.'
            ]
        ]
    ];

    public $musterKlappe = [
        'musterID' => [
            'rules'  	=> 'required|numeric',
            'errors' 	=> [
                'required'  => 'Die musterID wurde nicht angegeben.',
                'numeric'   => 'Die musterID ist keine Zahl.'
            ]
        ], 
        'stellungBezeichnung' => [
            'rules'  => 'required|string',
            'errors' => [
                'required'  => 'Die Beschreibung der Wölbklappenstellung wurde nicht angegeben.',
                'string'    => 'Die Eingabe der Beschreibung der Wölbklappenstellung enthält Zeichen, die nicht gespeichert werden können.'
            ]
        ], 
        'stellungWinkel' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Die Winkel der Wölbklappenstellung wurde nicht angegeben.',
                'numeric'   => 'Der Winkel der Wölbklappenstellung ist keine Zahl.'
            ]
        ], 
        'neutral' => [
            'rules'  => 'is_natural|less_than_equal_to[1]|permit_empty',
            'errors' => 'Neutralstellung ist kein Boolean.'
        ], 
        'kreisflug' => [
            'rules'  => 'is_natural|less_than_equal_to[1]|permit_empty',
            'errors' => 'Kreisflugstellung ist kein Boolean.'
        ], 
        'iasVG' => [
            'rules'  => 'numeric|permit_empty',
            'errors' => 'IAS<sub>VG</sub> ist keine Zahl.'
        ]
    ];

    public $flugzeugKlappe = [
        'flugzeugID' => [
            'rules'  	=> 'required|numeric',
            'errors' 	=> [
                'required'  => 'Die flugzeugID wurde nicht angegeben.',
                'numeric'   => 'Die flugzeugID ist keine Zahl.'
            ]
        ], 
        'stellungBezeichnung' => [
            'rules'  => 'required|string',
            'errors' => [
                'required'  => 'Die Beschreibung der Wölbklappenstellung wurde nicht angegeben.',
                'string'    => 'Die Eingabe der Beschreibung der Wölbklappenstellung enthält Zeichen, die nicht gespeichert werden können.'
            ]
        ], 
        'stellungWinkel' => [
            'rules'  => 'required|numeric',
            'errors' => [
               'required'   => 'Die Winkel der Wölbklappenstellung wurde nicht angegeben.',
                'numeric'   => 'Der Winkel der Wölbklappenstellung ist keine Zahl.'
            ]
        ], 
        'neutral' => [
            'rules'  => 'is_natural|less_than_equal_to[1]|permit_empty',
            'errors' => 'Neutralstellung ist kein Boolean.'
        ], 
        'kreisflug' => [
            'rules'  => 'is_natural|less_than_equal_to[1]|permit_empty',
            'errors' => 'Kreisflugstellung ist kein Boolean.'
        ], 
        'iasVG' => [
            'rules'  => 'numeric|permit_empty',
            'errors' => 'IAS<sub>VG</sub> ist keine Zahl.'
        ]
    ];
	
    public $flugzeugKlappenOhneFlugzeugID = [
        'stellungBezeichnung' => [
            'rules'  => 'required|string',
            'errors' => [
                'required'  => 'Die Beschreibung der Wölbklappenstellung wurde nicht angegeben.',
                'string'    => 'Die Eingabe der Beschreibung der Wölbklappenstellung enthält Zeichen, die nicht gespeichert werden können.'
            ]
        ], 
        'stellungWinkel' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Die Winkel der Wölbklappenstellung wurde nicht angegeben.',
                'numeric'   => 'Der Winkel der Wölbklappenstellung ist keine Zahl.'
            ]
        ], 
        'neutral' => [
            'rules'  => 'is_natural|less_than_equal_to[1]|permit_empty',
            'errors' => 'Neutralstellung ist kein Boolean.'
        ], 
        'kreisflug' => [
            'rules'  => 'is_natural|less_than_equal_to[1]|permit_empty',
            'errors' => 'Kreisflugstellung ist kein Boolean.'
        ], 
        'iasVG' => [
            'rules'  => 'numeric|permit_empty',
            'errors' => 'IAS<sub>VG</sub> ist keine Zahl.'
        ]
    ];

    public $flugzeugWaegung = [
        'flugzeugID' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Die flugzeugID wurde nicht angegeben.',
                'numeric'   => 'Die flugzeugID ist keine Zahl.'
            ]
        ], 
        'leermasse'=> [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Die Leermasse wurde nicht angegeben.',
                'numeric'   => 'Der Leermasse ist keine Zahl.'
            ]
        ], 
        'schwerpunkt' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Der Schwerpunkt wurde nicht angegeben.',
                'numeric'   => 'Der Schwerpunkt ist keine Zahl.'
            ]
        ], 
        'zuladungMin' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Die Mindestzuladung wurde nicht angegeben.',
                'numeric'   => 'Die Mindestzuladung ist keine Zahl.'
            ]
        ], 
        'zuladungMax' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Die Maximalzuladung wurde nicht angegeben.',
                'numeric'   => 'Die Maximalzuladung ist keine Zahl.'
            ]
        ], 
        'datum' => [
            'rules'  => 'required|valid_date[Y-m-d]',
            'errors' => [
                'required'      => 'Das Datum der letzten Wägung wurde nicht angegeben.',
                'valid_date'    => 'Das Datum der letzten Wägung wurde in einem falschen Format angegeben: JJJJ-MM-TT'
            ]
        ]
    ];

    public $flugzeugWaegungOhneFlugzeugID = [
        'leermasse'=> [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Die Leermasse wurde nicht angegeben.',
                'numeric'   => 'Der Leermasse ist keine Zahl.'
            ]
        ], 
        'schwerpunkt' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Der Schwerpunkt wurde nicht angegeben.',
                'numeric'   => 'Der Schwerpunkt ist keine Zahl.'
            ]
        ], 
        'zuladungMin' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Die Mindestzuladung wurde nicht angegeben.',
                'numeric'   => 'Die Mindestzuladung ist keine Zahl.'
            ]
        ], 
        'zuladungMax' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Die Maximalzuladung wurde nicht angegeben.',
                'numeric'   => 'Die Maximalzuladung ist keine Zahl.'
            ]
        ], 
        'datum' => [
            'rules'  => 'required|valid_date[Y-m-d]',
            'errors' => [
                'required'      => 'Das Datum der letzten Wägung wurde nicht angegeben.',
                'valid_date'    => 'Das Datum der letzten Wägung wurde in einem falschen Format angegeben: JJJJ-MM-TT.'
            ]
        ]
    ];

    public $pilot = [
        'vorname' => [
            'rules'  => 'required|string',
            'errors' => [
                'required'  => 'Der Vorname wurde nicht angegeben.',
                'string'    => 'Der Vorname enthält ungültige Zeichen.'
            ]
        ], 
        'nachname' => [
            'rules'  => 'required|string',
            'errors' => [
                'required'  => 'Der Nachname wurde nicht angegeben.',
                'string'    => 'Der Nachname enthält ungültige Zeichen.'
            ]
        ], 
        'spitzname' => [
            'rules'  => 'permit_empty|string',
            'errors' => [
                'string' => 'Der Spitzname enthält ungültige Zeichen.'
            ]
        ],
        'groesse' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Die Größe wurde nicht angegeben.',
                'numeric'   => 'Die Größe enthält ungültige Zeichen.'
            ]
        ],
        'akafliegID' => [
            'rules'  => 'permit_empty|is_natural',
            'errors' => [
                'is_natural'   => 'Die AkafliegID enthält ungültige Zeichen.'
            ]
        ],
        'sichtbar' => [
            'rules'  => 'is_natural|less_than_equal_to[1]|permit_empty',
            'errors' => 'Die Sichtbarkeit ist kein Boolean.'
        ],
        'zachereinweiser' => [
            'rules'  => 'is_natural|less_than_equal_to[1]|permit_empty',
            'errors' => 'Die Sichtbarkeit ist kein Boolean.'
        ],
    ];
    
    public $pilotDetailsOhnePilotID = [
        'stundenNachSchein' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Die Stunden nach Schein wurden nicht angegeben.',
                'numeric'   => 'Die Stunden nach Schein enthalten ungültige Zeichen.'
            ]
        ], 
        'geflogeneKm' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Die geflogenen Kilometer wurden nicht angegeben.',
                'numeric'   => 'Die geflogenen Kilometer enthalten ungültige Zeichen.'
            ]
        ], 
        'typenAnzahl' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Die Anzahl der geflogenen Typen wurde nicht angegeben.',
                'numeric'   => 'Die Anzahl der geflogenen Typen enthält ungültige Zeichen.'
            ]
        ],
        'gewicht' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Das Pilotengewicht wurde nicht angegeben.',
                'numeric'   => 'Das Pilotengewicht enthält ungültige Zeichen.'
            ]
        ],
        'datum' => [
            'rules'  => 'permit_empty|valid_date[Y-m-d]',
            'errors' => [
                'valid_date' => 'Das Datum hat ein falsches Format: JJJJ-MM-TT'
            ]
        ],
        'sichtbar' => [
            'rules'  => 'is_natural|less_than_equal_to[1]|permit_empty',
            'errors' => 'Die Sichtbarkeit ist kein Boolean.'
        ],
        'zachereinweiser' => [
            'rules'  => 'is_natural|less_than_equal_to[1]|permit_empty',
            'errors' => 'Die Sichtbarkeit ist kein Boolean.'
        ],
    ];
    
    public $pilotDetails = [
        'pilotID' => [
            'rules'  => 'required|is_natural',
            'errors' => [
                'required'      => 'Die pilotID fehlt.',
                'is_natural'    => 'Die pilotId ist ungültig'
            ]
        ],
        'stundenNachSchein' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Die Stunden nach Schein wurden nicht angegeben.',
                'numeric'   => 'Die Stunden nach Schein enthalten ungültige Zeichen.'
            ]
        ], 
        'geflogeneKm' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Die geflogenen Kilometer wurden nicht angegeben.',
                'numeric'   => 'Die geflogenen Kilometer enthalten ungültige Zeichen.'
            ]
        ], 
        'typenAnzahl' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Die Anzahl der geflogenen Typen wurde nicht angegeben.',
                'numeric'   => 'Die Anzahl der geflogenen Typen enthält ungültige Zeichen.'
            ]
        ],
        'gewicht' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Das Pilotengewicht wurde nicht angegeben.',
                'numeric'   => 'Das Pilotengewicht enthält ungültige Zeichen.'
            ]
        ],
        'datum' => [
            'rules'  => 'permit_empty|valid_date[Y-m-d]',
            'errors' => [
                'valid_date' => 'Das Datum hat ein falsches Format: JJJJ-MM-TT'
            ]
        ]
    ];
    
    public $protokolle = [
        'flugzeugID' => [
            'rules'  => 'permit_empty|is_natural',
            'errors' => [
                'numeric'   => 'Die FlugzeugID ist ungültig.'
            ]
        ],
        'pilotID' => [
            'rules'  => 'permit_empty|is_natural',
            'errors' => [
                'is_natural'    => 'Die PilotID ist ungültig.'
            ]
        ],
        'copilotID' => [
            'rules'  => 'permit_empty|is_natural',
            'errors' => [
                'is_natural'    => 'Die CopilotID ist ungültig.'
            ]
        ], 
        'protokollIDs' => [
            'rules'  => 'required|valid_json',
            'errors' => [
                'valid_json'    => "Das Format der ProtokollIDs ist invalide.",
                'required'      => "Es wurde keine ProtokollID angegeben."
            ]
        ], 
        'flugzeit' => [
            'rules'  => 'permit_empty|valid_date[H:i]',
            'errors' => [
                'valid_date'    => 'Die eingegebene Flugzeit hat ein falsches Format: hh:mm.'
            ]
        ], 
        'stundenAufDemMuster' => [
            'rules'  => 'permit_empty|numeric',
            'errors' => [
                'numeric'    => 'Die Eingabe zur Anzahl der Stunden auf dem Muster enth#lt ungültige Zeichen.'
            ]
        ],
        'bemerkung' => [
            'rules'  => 'permit_empty|string',
            'errors' => [
                'string'   => 'Die Bemerkung hat ein falsches Format.'
            ]
        ],
        'bestaetigt' => [
            'rules'  => 'permit_empty|is_natural|less_than_equal_to[1]',
            'errors' => [
                'is_natural'            => 'Die Bestätigt-Flag ist kein Integer.',
                'less_than_equal_to'    => 'Die Bestätigt-Flag ist größer als 1.'
            ]
        ],
        'fertig' => [
            'rules'  => 'permit_empty|is_natural|less_than_equal_to[1]',
            'errors' => [
                'is_natural'            => 'Die Fertig-Flag ist kein Integer.',
                'less_than_equal_to'    => 'Die Fertig-Flag ist größer als 1.'
            ]
        ],
        'datum' => [
            'rules'  => 'required|valid_date[Y-m-d]',
            'errors' => [
                'valid_date'    => 'Das Datum hat ein falsches Format: JJJJ.MM.TT',
                'required'      => 'Das Datum muss angegeben werden.'
            ]
        ]
    ];
    
    public $kommentareOhneProtokollSpeicherID =  [       
        'protokollKapitelID' => [
            'rules'  => 'required|is_natural',
            'errors' => [
                'required'      => 'Es wurde keine KapitelID gegeben.',
                'is_natural'    => 'Die KapitelID ist ungültig.'
            ]
        ],
        'kommentar' => [
            'rules'  => 'required|string',
            'errors' => [
                'required'  => 'Es wurde kein Kommentar gegeben.',
                'string'    => 'Der Kommentar enthält ungültige Zeichen.'
            ]
        ]
    ];
    
    public $kommentare =  [ 
        'protokollSpeicherID' => [
            'rules'  => 'required|is_natural',
            'errors' => [
                'required'      => 'Es wurde keine ProtokollSpeicherID gegeben.',
                'is_natural'    => 'Die ProtokollSpeicherID ist ungültig.'
            ]
        ],
        'protokollKapitelID' => [
            'rules'  => 'required|is_natural',
            'errors' => [
                'required'      => 'Es wurde keine KapitelID gegeben.',
                'is_natural'    => 'Die KapitelID ist ungültig.'
            ]
        ],
        'kommentar' => [
            'rules'  => 'required|string',
            'errors' => [
                'required'  => 'Es wurde kein Kommentar gegeben.',
                'string'    => 'Der Kommentar enthält ungültige Zeichen.'
            ]
        ]
    ];
    
    public $hStWegeOhneProtokollSpeicherID =  [ 
        'protokollKapitelID' => [
            'rules'  => 'required|is_natural',
            'errors' => [
                'required'      => 'Es wurde keine KapitelID gegeben.',
                'is_natural'    => 'Die KapitelID ist ungültig.'
            ]
        ],
        'gedruecktHSt' => [
            'rules'  => 'required|is_natural',
            'errors' => [
                'required'      => 'Es wurde kein Wert für das HSt im gedrückten Zustand angegeben.',
                'is_natural'    => 'Der HSt Weg für den gedrückten Zustand muss eine ganze Zahl sein.'
            ]
        ],
        'neutralHSt' => [
            'rules'  => 'required|is_natural',
            'errors' => [
                'required'      => 'Es wurde kein Wert für das HSt im neutralen Zustand angegeben.',
                'is_natural'    => 'Der HSt Weg für den neutralen Zustand muss eine ganze Zahl sein.'
            ]
        ],
        'gezogenHSt' => [
            'rules'  => 'required|is_natural',
            'errors' => [
                'required'      => 'Es wurde kein Wert für das HSt im gezogenen Zustand angegeben.',
                'is_natural'    => 'Der HSt Weg für den gezogenen Zustand muss eine ganze Zahl sein.'
            ]
        ]
    ];
    
    public $hStWege =  [ 
        'protokollSpeicherID' => [
            'rules'  => 'required|is_natural',
            'errors' => [
                'required'      => 'Es wurde keine ProtokollSpeicherID gegeben.',
                'is_natural'    => 'Die ProtokollSpeicherID ist ungültig.'
            ]
        ],
        'protokollKapitelID' => [
            'rules'  => 'required|is_natural',
            'errors' => [
                'required'      => 'Es wurde keine KapitelID gegeben.',
                'is_natural'    => 'Die KapitelID ist ungültig.'
            ]
        ],
        'gedruecktHSt' => [
            'rules'  => 'required|is_natural',
            'errors' => [
                'required'      => 'Es wurde kein Wert für das HSt im gedrückten Zustand angegeben.',
                'is_natural'    => 'Der HSt Weg für den gedrückten Zustand muss eine ganze Zahl sein.'
            ]
        ],
        'neutralHSt' => [
            'rules'  => 'required|is_natural',
            'errors' => [
                'required'      => 'Es wurde kein Wert für das HSt im neutralen Zustand angegeben.',
                'is_natural'    => 'Der HSt Weg für den neutralen Zustand muss eine ganze Zahl sein.'
            ]
        ],
        'gezogenHSt' => [
            'rules'  => 'required|is_natural',
            'errors' => [
                'required'      => 'Es wurde kein Wert für das HSt im gezogenen Zustand angegeben.',
                'is_natural'    => 'Der HSt Weg für den gezogenen Zustand muss eine ganze Zahl sein.'
            ]
        ]
    ];
    
    public $beladungOhneProtokollSpeicherID =  [ 
        'flugzeugHebelarmID' => [
            'rules'  => 'permit_empty|is_natural',
            'errors' => [
                'required'      => 'Es wurde keine FlugzeugHebelarmID gegeben.',
                'is_natural'    => 'Die FlugzeugHebelarmID ist ungültig.'
            ]
        ],
        'bezeichnung' => [
            'rules'  => 'permit_empty|string',
            'errors' => [
                'string'    => 'Die Hebelarmbezeichnung enthält ungültige Zeichen.'
            ]
        ],
        'hebelarm' => [
            'rules'  => 'permit_empty|numeric',
            'errors' => [
                'numeric'   => 'Der Hebelarm muss eine Zahl sein.'
            ]
        ],
        'gewicht' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Es wurde kein Gewicht für einen der erforderlichen Hebelarme gegeben.',
                'numeric'   => 'Das Gewicht für die Hebelarme muss eine Zahl sein.'
            ]
        ]
    ];
    
    public $beladung =  [ 
        'protokollSpeicherID' => [
            'rules'  => 'permit_empty|is_natural',
            'errors' => [
                'required'      => 'Es wurde keine ProtokollSpeicherID gegeben.',
                'is_natural'    => 'Die ProtokollSpeicherID ist ungültig.'
            ]
        ],
        'flugzeugHebelarmID' => [
            'rules'  => 'required|is_natural',
            'errors' => [
                'required'      => 'Es wurde keine FlugzeugHebelarmID gegeben.',
                'is_natural'    => 'Die FlugzeugHebelarmID ist ungültig.'
            ]
        ],
        'bezeichnung' => [
            'rules'  => 'permit_empty|string',
            'errors' => [
                'string'    => 'Die Hebelarmbezeichnung enthält ungültige Zeichen.'
            ]
        ],
        'hebelarm' => [
            'rules'  => 'permit_empty|numeric',
            'errors' => [
                'numeric'   => 'Der Hebelarm muss eine Zahl sein.'
            ]
        ],
        'gewicht' => [
            'rules'  => 'required|numeric',
            'errors' => [
                'required'  => 'Es wurde kein Gewicht für einen der erforderlichen Hebelarme gegeben.',
                'numeric'   => 'Das Gewicht für die Hebelarme muss eine Zahl sein.'
            ]
        ]
    ];
    
    public $daten = [
        'protokollSpeicherID' => [
            'rules'  => 'required|is_natural',
            'errors' => [
                'required'      => 'Es wurde keine ProtokollSpeicherID gegeben.',
                'is_natural'    => 'Die ProtokollSpeicherID ist ungültig.'
            ]
        ],
        'protokollInputID' => [
            'rules'  => 'required|is_natural',
            'errors' => [
                'required'      => 'Es wurde keine ProtokollInputID gegeben.',
                'is_natural'    => 'Die ProtokollInputID ist ungültig.'
            ]
        ],
        'wert' => [
            'rules'  => 'required',
            'errors' => [
                'required'  => 'Es wurde kein Wert gegeben.'
            ]
        ],
        'woelbklappenstellung' => [
            'rules'  => 'permit_empty|in_list[Neutral,Kreisflug]',
            'errors' => [
                'in_list'   => 'Die Wölbklappenstellung entspricht nicht den vorgegebenen Parametern (Neutral, Kreisflug).'
            ]
        ],
        'linksUndRechts' => [
            'rules'  => 'permit_empty|in_list[Links,Rechts]',
            'errors' => [
                'in_list'   => 'Die Richtung entspricht nicht den vorgegebenen Parametern (Links, Rechts).'
            ]
        ],
        'multipelNr' => [
            'rules'  => 'permit_empty|is_natural',
            'errors' => [
                'is_natural'    => 'Bei der Eingabe Multipler Werte ist etwas schief gelaufen.'
            ]
        ]
    ];
    
    public $datenOhneProtokollSpeicherID = [
        'protokollInputID' => [
            'rules'  => 'required|is_natural',
            'errors' => [
                'required'      => 'Es wurde keine ProtokollInputID gegeben.',
                'is_natural'    => 'Die ProtokollInputID ist ungültig.'
            ]
        ],
        'wert' => [
            'rules'  => 'required',
            'errors' => [
                'required'  => 'Es wurde kein Wert gegeben.'
            ]
        ],
        'woelbklappenstellung' => [
            'rules'  => 'permit_empty|in_list[Neutral,Kreisflug]',
            'errors' => [
                'in_list'   => 'Die Wölbklappenstellung entspricht nicht den vorgegebenen Parametern (Neutral, Kreisflug).'
            ]
        ],
        'linksUndRechts' => [
            'rules'  => 'permit_empty|in_list[Links,Rechts]',
            'errors' => [
                'in_list'   => 'Die Richtung entspricht nicht den vorgegebenen Parametern (Links, Rechts).'
            ]
        ],
        'multipelNr' => [
            'rules'  => 'permit_empty|is_natural',
            'errors' => [
                'is_natural'    => 'Bei der Eingabe Multipler Werte ist etwas schief gelaufen.'
            ]
        ]
    ];
    
    public $eingabeText = [
        'wert' => [
            'rules'  => 'string',
            'errors' => [
                'string'   => 'Ein Textfeld enthält ungültige Zeichen.'
            ] 
        ]
    ];
    
    public $eingabeGanzzahl = [
        'wert' => [
            'rules'  => 'integer',
            'errors' => [
                'is_natural'   => 'Eine Zahleneingabe für Ganzzahlen enthält ungültige Zeichen.'
            ] 
        ]
    ];
    
    public $eingabeDezimalzahl = [
        'wert' => [
            'rules'  => 'numeric',
            'errors' => [
                'numeric'   => 'Eine Zahleneingabe für Dezimalzahlen enthält ungültige Zeichen.'
            ] 
        ]
    ];
    
    public $eingabeCheckbox = [
        'wert' => [
            'rules'  => 'is_natural|less_than_equal_to[1]',
            'errors' => [
                'is_natural'    => 'Eine Checkbox enthält ungültige Zeichen.',
                'less_than_equal_to'     => 'Eine Checkbox enthält einen Wert größer 1.'
            ] 
        ]
    ];
    
    public $eingabeNote = [
        'wert' => [
            'rules'  => 'in_list[1,2,3,4,5,6]',
            'errors' => [
                'in_list'    => 'Eine Note enthält einen ungültigen Wert.'
            ] 
        ]
    ];    
}
