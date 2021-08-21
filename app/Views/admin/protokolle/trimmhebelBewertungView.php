<div class="p-3 p-md-5 mb-4 text-white rounded bg-secondary">
    <h1>Bewertung der Trimmhebel pro Flugzeug</h1>
    <p></p>
</div>

<table class='table'>
    <thead>
        <tr>
            <th>Flugzeugmuster</th>
            <th>Noten</th>
            <th>Begründungen</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($protokollDaten as $flugzeug): ?>

            <?php foreach($flugzeug as $flugzeugDaten) : ?>
                <tr>
                    <?php if(isset($flugzeugDaten['flugzeugID'])) : ?>
                        <td><?= $flugzeugDaten['musterSchreibweise'] ?><?= $flugzeugDaten['musterZusatz'] ?></td>
                        <td></td>
                        <td></td>
                    <?php else : ?>
                        <td></td>
                        <td><?php 
                            switch($flugzeugDaten['65'])
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
                            }
                        ?></td>
                        <td><?= $flugzeugDaten['90'] ?></td>
                    <?php endif ?>
                </tr>
            <?php endforeach ?>  
        <?php endforeach ?>
    </tbody>
</table>