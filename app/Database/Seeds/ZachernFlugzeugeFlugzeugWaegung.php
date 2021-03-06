<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZachernFlugzeugeFlugzeugWaegung extends Seeder
{
    protected $DBGroup = 'flugzeugeDB';
    
    public function run()
    {
        $query = "INSERT IGNORE INTO `flugzeug_waegung` (`flugzeugID`, `leermasse`, `schwerpunkt`, `datum`, `zuladungMin`, `zuladungMax`) VALUES
            (1, '428.20', '712.00', '2017-03-16', '66.00', '210.00'),
            (2, '282.50', '608.80', '2018-03-25', '65.00', '98.50'),
            (3, '300.80', '539.00', '2014-03-20', '80.00', '115.00'),
            (4, '447.50', '562.20', '2015-07-24', '80.00', '182.00'),
            (5, '253.90', '687.30', '2013-08-06', '52.00', '108.00'),
            (6, '269.70', '645.94', '2017-07-16', '75.00', '99.00'),
            (7, '656.00', '554.60', '2016-04-15', '88.00', '180.20'),
            (8, '275.40', '644.61', '2017-08-16', '75.00', '110.00'),
            (9, '244.80', '611.00', '2019-03-30', '70.00', '109.00'),
            (10, '278.70', '552.00', '2019-06-11', '75.00', '88.50'),
            (11, '273.90', '561.85', '2016-05-02', '82.00', '110.00'),
            (12, '338.90', '713.30', '2018-05-27', '64.50', '86.00'),
            (13, '294.90', '606.00', '2018-05-07', '70.00', '105.00'),
            (14, '513.20', '672.00', '2017-01-18', '85.00', '230.00'),
            (15, '308.20', '435.80', '2015-04-25', '62.00', '94.50'),
            (16, '265.00', '640.80', '2018-03-30', '70.00', '85.00'),
            (17, '297.00', '634.60', '2018-03-20', '71.00', '110.00'),
            (17, '297.90', '633.10', '2020-07-01', '71.00', '110.00'),
            (18, '409.10', '698.00', '2018-03-29', '58.00', '170.00'),
            (18, '410.90', '705.00', '2021-04-01', '59.00', '170.00'),
            (19, '156.80', '494.00', '2018-08-01', '68.00', '94.00'),
            (20, '423.30', '525.87', '2018-07-20', '73.00', '220.00'),
            (21, '396.00', '739.00', '2016-03-22', '70.00', '220.00'),
            (22, '254.00', '650.00', '2020-07-13', '80.00', '110.00'),
            (23, '277.40', '482.00', '2020-08-01', '75.00', '93.50'),
            (24, '486.80', '701.00', '2020-08-13', '0.00', '0.00'),
            (25, '316.60', '0.00', '2020-08-03', '80.00', '115.00'),
            (26, '484.90', '568.15', '2019-03-27', '70.00', '215.00'),
            (26, '482.70', '582.50', '2021-07-28', '70.00', '215.00'),
            (27, '466.60', '553.72', '2015-07-06', '73.00', '212.60'),
            (28, '424.30', '714.50', '2020-03-02', '70.00', '225.70');";
        
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
