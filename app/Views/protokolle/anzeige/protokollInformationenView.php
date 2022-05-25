<h2>1. Angaben zum Protokoll</h2>

<div class="row">
    <div class="col-lg-1">

    </div>
    <div class="col-sm-10">
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <td>Datum des ersten Fluges:</td>
                    <td><b><?= isset($protokollDaten['protokollDetails']['datum']) ? date('d.m.Y', strtotime($protokollDaten['protokollDetails']['datum'])) : "" ?></b></td>
                    <td>Gesamtflugzeit für das Protokoll:</td>
                    <td><b><?= isset($protokollDaten['protokollDetails']['flugzeit']) ? date('H:i', strtotime($protokollDaten['protokollDetails']['flugzeit'])) : "" ?></b></td>          
                </tr>
                <?php if(isset($protokollDaten['protokollDetails']['bemerkung']) && ! empty($protokollDaten['protokollDetails']['bemerkung'])) : ?>
                    <tr>
                        <td>Bemerkungen:</td>
                        <td colspan="3"><b><?= $protokollDaten['protokollDetails']['bemerkung'] ?></b></td>
                    </tr>
                <?php endif ?>

            </table>
        </div>
    </div>
    <div class="col-lg-1">
        
    </div>
</div>