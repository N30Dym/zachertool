<?php 

namespace Auth\Models;

use CodeIgniter\Model;

/**
 * @author Lars Kastner
 */
class MitgliedsStatusModel extends Model
{
    
    protected $DBGroup      = 'zachertoolDB';
    protected $table        = 'mitgliedsstatus';
    protected $primaryKey   = 'id';

    protected $returnType   = 'array';
    protected $useSoftDeletes = false;

    // this happens first, model removes all other fields from input data
    protected $allowedFields = [
            'statusBezeichnung'
    ];

    protected $validationRules  = [
        'statusBezeichnung' => 'required|string'
    ];

    // this runs after field validation
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];


//--------------------------------------------------------------------

    public function getAlleStatusBezeichnungen()
    {
        var_dump($this->findAll());
        return $this->findAll();
    }

}
