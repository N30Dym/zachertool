<?php
if (! function_exists('schwerpunktlageBerechnen'))
{
    function schwerpunktlageBerechnen(array $protokollBeladungen, array $flugzeugHebelarme, $flugzeugWaegung)
    {
        if(empty($flugzeugWaegung))
        {
            return null;
        }
        
        $summeMomente = $summeMassen = 0;
        
        foreach($protokollBeladungen as $flugzeugHebelarmID => $beladung)
        {                        
            if($flugzeugHebelarmID == "weiterer")
            {
                $summeMomente   += $beladung['laenge'] * $beladung['gewicht'];
                $summeMassen    += $beladung['gewicht'];
                continue;
            }
            
            $hebelarm = $masse = 0;

            foreach($beladung as $gewicht)
            {
                $summeMassen    += $gewicht;
                $masse          += $gewicht;
            }
            foreach($flugzeugHebelarme as $flugzeugHebelarm)
            {
                if($flugzeugHebelarm['id'] == $flugzeugHebelarmID)
                {
                    $hebelarm = $flugzeugHebelarm['hebelarm'];
                    break;
                }
            }
            
            $summeMomente += $masse * $hebelarm;
        }
        
        $summeMomente += $flugzeugWaegung['leermasse'] * $flugzeugWaegung['schwerpunkt'];
        $summeMassen += $flugzeugWaegung['leermasse'];

        return round($summeMomente / $summeMassen, 1);
    }
}