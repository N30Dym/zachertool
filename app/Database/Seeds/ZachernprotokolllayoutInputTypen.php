<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernprotokolllayoutInputTypen extends Seeder
{
    protected $DBGroup = 'protokolllayoutDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `input_typen` (`id`, `inputTyp`) VALUES
            (1, 'Textzeile'),
            (2, 'Auswahloptionen'),
            (3, 'Ganzzahl'),
            (4, 'Dezimalzahl'),
            (5, 'Checkbox'),
            (7, 'Textfeld'),
            (8, 'Note');";
        
        try
        {
            $this->db->query($query);
        }
        catch(Exception $ex)
        {
            $this->showError($ex);
        } 
    }
}
