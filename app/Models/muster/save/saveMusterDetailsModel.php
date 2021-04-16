<?php

namespace App\Models\muster\save;

use CodeIgniter\Model;

class saveMusterDetailsModel extends Model
{
	/*
	 * Verbindungsvariablen für den Zugriff zur
	 * Datenbank zachern_flugzeuge auf die 
	 * Tabelle muster
	 */
    protected $DBGroup 		= 'flugzeugeDB';
	protected $table     	= 'muster_details';
    protected $primaryKey 	= 'id';
	
	protected $allowedFields = ['musterID', 'kupplung', 'diffQR', 'radgroesse', 'radbremse', 'radfederung', 'fluegelflaeche', 'spannweite', 'bremsklappen', 'iasVG', 'mtow', 'leermasseSPMin', 'leermasseSPMax', 'flugSPMin', 'flugSPMax', 'zuladungMin', 'zuladungMax', 'bezugspunkt', 'anstellwinkel', 'erstelltAm'];
}