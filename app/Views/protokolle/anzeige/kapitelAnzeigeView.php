<?php 

foreach($protokollLayout as $kapitelNummer => $kapitel)
{
    if($kapitel['protokollKapitelID'] == FLUGZEUG_EINGABE || $kapitel['protokollKapitelID'] == PILOT_EINGABE || $kapitel['protokollKapitelID'] == BELADUNG_EINGABE){ continue; }
    {
        echo "<h2>" . $kapitelNummer . ". " . $kapitel['kapitelDetails']['bezeichnung'] ."</h2>";
    }

    foreach($kapitel as $protokollUnterkapitelID => $unterkapitel)
    {
        if(!is_numeric($protokollUnterkapitelID)) { continue; }
        if($protokollUnterkapitelID > 0)
        {
            echo '<h3 class="ms-2">' . $kapitelNummer . "." . $kapitel[$protokollUnterkapitelID]['unterkapitelDetails']['unterkapitelNummer'] . " " . $kapitel[$protokollUnterkapitelID]['unterkapitelDetails']['bezeichnung'] . "</h3>";
        }
        
        $woelbklappen = ($protokollDaten['flugzeugDaten']['flugzeugMitMuster']['istWoelbklappenFlugzeug'] == 1 && (($unterkapitel['unterkapitelDetails']['woelbklappen'] ?? "") || ($kapitel['kapitelDetails']['woelbklappen'] ?? ""))) ? ['Neutral', 'Kreisflug'] : [0]; 
   
        foreach($woelbklappen as $woelbklappenStellung)
        {
            echo $woelbklappenStellung == 0 ? "" : '<h5 class="ms-2">Wölbklappenstellung: <b>' . $woelbklappenStellung . '</b></h5>';
            echo "<table class='table'>";
            
            foreach($unterkapitel as $protokollEingabeID => $eingabe)
            {
                if(!is_numeric($protokollEingabeID)) { continue; }
                echo "<tr><td>" . $eingabe['eingabeDetails']['bezeichnung'] . "</td>";      
                                   
                foreach($eingabe as $protokollInputID => $input)
                {
                    if(!is_numeric($protokollInputID)) { continue; }
                    
                    if(isset($protokollDaten['eingegebeneWerte'][$input['inputDetails']['id']]))
                    {
                        foreach($protokollDaten['eingegebeneWerte'][$input['inputDetails']['id']][$woelbklappenStellung] as $richtung => $multipelUndWert)
                        {
                            
                            switch($input['inputDetails']['inputTyp'])
                            {
                                //case "Auswahloptionen":
                                    //echo "<td><b>" . ($protokollDaten['']$protokollDaten['eingegebeneWerte'][$input['inputDetails']['id']][$woelbklappenStellung][$richtung][0] ?? "") . "</b> " . ($input['inputDetails']['einheit'] ?? "") . "</td>";
                                    //break; 
                                case "Ganzzahl":
                                case "Textfeld":
                                case "Dezimalzahl":
                                    echo empty($input['inputDetails']['bezeichnung']) ? "<td>" : "<td>" . $input['inputDetails']['bezeichnung'] . "</td><td>";
                                    echo $richtung == 0 ? "" : $richtung . ": ";
                                    echo "<b>" . dezimalZahlenKorrigieren($protokollDaten['eingegebeneWerte'][$input['inputDetails']['id']][$woelbklappenStellung][$richtung][0] ?? "") . "</b> " . ($input['inputDetails']['einheit'] ?? "") . "</td>";
                                    break;                                
                                default:
                                    echo "<b>" . $input['inputDetails']['inputTyp'] . "</b> fehlt noch</td>";

                            }       
                        }
                    }
                }
                echo "</tr>";
            }
            echo "</table>";
        }
    }

}

