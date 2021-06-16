<?php

namespace App\Models\piloten;

use CodeIgniter\Model;

/**
 * Description of pilotenAkafliegsModel
 *
 * @author Lars
 */
class pilotenAkafliegsModel extends Model {
    protected $DBGroup          = 'pilotenDB';
    protected $table            = 'piloten_akafliegs';
    protected $primaryKey       = 'id';
    protected $validationRules 	= ['akaflieg' => 'required'];
    
    protected $allowedFields = [ 'akafliegs', 'sichtbar' ];
    
    public function getAlleAkafliegs()
    {
        return $this->findAll();
    }
    
    public function getSichtbareAkafliegs()
    {
        return $this->where('sichtbar', 1)->findAll();
    }
}
