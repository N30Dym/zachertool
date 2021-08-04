<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeedController extends Seeder
{
    public function run()
    {
        $this->call('ZachertoolMitgliedsstatus');
        
        $this->call('ZachernProtokolllayoutProtokollTypen');
        $this->call('ZachernProtokolllayoutProtokolle');
        $this->call('ZachernProtokolllayoutInputTypen');
        $this->call('ZachernProtokolllayoutProtokollKapitel');
        $this->call('ZachernProtokolllayoutProtokollUnterkapitel');
        $this->call('ZachernProtokolllayoutProtokollEingaben');
        $this->call('ZachernProtokolllayoutProtokollInputs');
        $this->call('ZachernProtokolllayoutProtokollLayouts');
        $this->call('ZachernProtokolllayoutAuswahllisten');
        $this->call('ZachernProtokolllayoutProtokollKategorien'); 
        
        $this->call('ZachernPilotenPiloten');
        $this->call('ZachernPilotenPilotenDetails');
        $this->call('ZachernPilotenPilotenAkafliegs');
        
        $this->call('ZachernFlugzeugeMuster');
        $this->call('ZachernFlugzeugeMusterDetails');
        $this->call('ZachernFlugzeugeMusterKlappen');
        $this->call('ZachernFlugzeugeMusterHebelarme');
        
        $this->call('ZachernFlugzeugeFlugzeuge');
        $this->call('ZachernFlugzeugeFlugzeugDetails');
        $this->call('ZachernFlugzeugeFlugzeugKlappen');
        $this->call('ZachernFlugzeugeFlugzeugHebelarme');
        $this->call('ZachernFlugzeugeFlugzeugWaegung');
        
        $this->call('ZachernProtokolleProtokolle');
        $this->call('ZachernProtokolleBeladung');
        $this->call('ZachernProtokolleHStWege');
        $this->call('ZachernProtokolleKommentare');
        $this->call('ZachernProtokolleDaten');        
    }
}
