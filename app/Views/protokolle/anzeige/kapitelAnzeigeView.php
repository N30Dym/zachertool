<?php 

foreach($protokollLayout as $kapitelNummer => $kapitel)
{
    if($kapitel['protokollKapitelID'] == FLUGZEUG_EINGABE || $kapitel['protokollKapitelID'] == PILOT_EINGABE || $kapitel['protokollKapitelID'] == BELADUNG_EINGABE){ continue; }

    echo "<h2>" . $kapitelNummer . ". " . $kapitel['kapitelDetails']['bezeichnung'] ."</h2>";

    foreach($kapitel as $protokollUnterkapitelID => $unterkapitel)
    {
        if(!is_numeric($protokollUnterkapitelID)) { continue; }
        if($protokollUnterkapitelID > 0)
        {
            echo '<h4 class="ms-4">' . $kapitelNummer . "." . $kapitel[$protokollUnterkapitelID]['unterkapitelDetails']['unterkapitelNummer'] . " " . $kapitel[$protokollUnterkapitelID]['unterkapitelDetails']['bezeichnung'] . "</h4>";
        }
        
        $woelbklappen = ($protokollDaten['flugzeugDaten']['flugzeugMitMuster']['istWoelbklappenFlugzeug'] == 1 && (($unterkapitel['unterkapitelDetails']['woelbklappen'] ?? "") || ($kapitel['kapitelDetails']['woelbklappen'] ?? ""))) ? ['Neutral', 'Kreisflug'] : [0]; 
        echo "<div class='row'><div class='col-lg-1'></div><div class='col-sm-10'>";
        foreach($woelbklappen as $woelbklappenStellung)
        {
            
            
            echo $woelbklappenStellung == 0 ? "" : '<h5 class="ms-4 mt-4">Wölbklappenstellung: <b>' . $woelbklappenStellung . '</b></h5>';
            echo "<div class='table-responsive-lg'><table class='table'>";
            
            foreach($unterkapitel as $protokollEingabeID => $eingabe)
            {
                if(!is_numeric($protokollEingabeID)) { continue; }
                if(empty($eingabe['eingabeDetails']['doppelsitzer']) OR ($protokollDaten['flugzeugDaten']['flugzeugMitMuster']['istWoelbklappenFlugzeug'] == 1 && $eingabe['eingabeDetails']['doppelsitzer'] == 1))
                {
                    if($eingabe['eingabeDetails']['multipel'])
                    {
                        foreach($eingabe as $protokollInputID => $input)
                        {
                            if(!is_numeric($protokollInputID)) { continue; }

                            echo "<tr>";
                            if($input['inputDetails']['bezeichnung'] != "")
                            {
                                echo '<td>' . $input['inputDetails']['bezeichnung'] . "</td>";
                            }

                            if(isset($protokollDaten['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][0]))
                            {
                                foreach($protokollDaten['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][0] as $wert)
                                {

                                    echo '<td valign="middle"><b>';
                                    switch($input['inputDetails']['inputTyp'])
                                    {
                                        case "Dezimalzahl": 
                                        case "Ganzzahl":
                                        case "Textzeile":
                                            echo  dezimalZahlenKorrigieren($wert);
                                            break;
                                        default:
                                            echo "";
                                    }
                                    echo "</b>";

                                    if($input['inputDetails']['einheit'] ?? "" != "")
                                    {
                                        echo '&nbsp;' . $input['inputDetails']['einheit'];
                                    }

                                    echo "</td>";

                                }
                            }
                            echo "</tr>";
                        }
                    }
                    else
                    {
                        echo "<tr><td>" . $eingabe['eingabeDetails']['bezeichnung'] . "</td>"; 


                        foreach($eingabe as $protokollInputID => $input)
                        {
                            if(!is_numeric($protokollInputID)) { continue; }

                            if(isset($protokollDaten['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung]))
                            {
                                ksort($protokollDaten['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung]);
                                foreach($protokollDaten['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung] as $richtung => $multipelUndWert)
                                {

                                    switch($input['inputDetails']['inputTyp'])
                                    {
                                        case "Auswahloptionen":
                                            echo empty($input['inputDetails']['bezeichnung']) ? "<td>" : "<td>" . $input['inputDetails']['bezeichnung'] . "</td><td>";
                                            if(!empty($protokollDaten['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$richtung][0]))
                                            {
                                                $auswahlOptionID = $protokollDaten['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$richtung][0];
                                                echo "<b>" . $protokollDaten['auswahloptionen'][$auswahlOptionID]['option'] . "</b>";
                                            }
                                            echo "</td>";
                                            break;
                                        case "Note":
                                            echo "<td><b>";
                                            switch($protokollDaten['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$richtung][0] ?? null)
                                            {
                                                case 1:
                                                    echo "5";
                                                    break;
                                                case 2:
                                                    echo "4";
                                                    break;
                                                case 3:
                                                    echo "3";
                                                    break;
                                                case 4:
                                                    echo "2";
                                                    break;
                                                case 5:
                                                    echo "1";
                                                    break;
                                                case 6:
                                                    echo "1+";
                                                    break;
                                                default:
                                                    echo "";
                                            }
                                            echo "</b></td>";
                                            break;
                                        case "Checkbox":
                                            if(isset($protokollDaten['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$richtung][0]))
                                            {
                                                echo "<td><b>" . ($input['inputDetails']['bezeichnung'] ?? "") . "</b></td>";
                                            }
                                            break;
                                        case "Textzeile":
                                        case "Ganzzahl":
                                        case "Textfeld":
                                        case "Dezimalzahl":
                                            echo empty($input['inputDetails']['bezeichnung']) ? "<td>" : "<td>" . $input['inputDetails']['bezeichnung'] . "</td><td>";
                                            echo $richtung == 0 ? "" : $richtung . ": ";
                                            echo "<b>" . dezimalZahlenKorrigieren($protokollDaten['eingegebeneWerte'][$protokollInputID][$woelbklappenStellung][$richtung][0] ?? "") . "</b>&nbsp;" . ($input['inputDetails']['einheit'] ?? "") . "</td>";
                                            break;                                
                                        default:
                                            echo "<td><b>" . $input['inputDetails']['inputTyp'] . "</b> fehlt noch</td>";

                                    }       
                                }
                            }
                        }
                        echo "</tr>";
                    }
                }
            }
            echo "</table></div>";
            
        }
        echo "</div><div class='col-lg-1'></div></div>";
    }
}

