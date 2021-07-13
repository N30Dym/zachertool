<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Seedcontroller extends Seeder
{
    public function run()
    {
        $this->call('ZachertoolMitgliedsstatus');
        $this->call('ZachernProtokolllayoutProtokollTypen');
        $this->call('ZachernProtokolllayoutProtokolle');
        $this->call('ZachernprotokolllayoutInputTypen');
        $this->call('ZachernprotokolllayoutProtokollKapitel');
        $this->call('ZachernprotokolllayoutProtokollUnterkapitel');
        $this->call('ZachernprotokolllayoutProtokollEingaben');
        $this->call('ZachernprotokolllayoutProtokollInputs');
        $this->call('ZachernprotokolllayoutProtokollLayouts');
    }
}
