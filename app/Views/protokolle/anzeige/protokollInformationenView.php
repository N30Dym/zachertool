<h2>1. Angaben zum Protokoll</h2>
<table class="table">
    <tr>
        <td>Datum des ersten Fluges:</td>
        <td><b><?= isset($protokollDaten['ProtokollInformationen']['datum']) ? date('d.m.Y', strtotime($protokollDaten['ProtokollInformationen']['datum'])) : "" ?></b></td>
        <td>Gesamtflugzeit für das Protokoll:</td>
        <td><b><?= isset($protokollDaten['ProtokollInformationen']['flugzeit']) ? date('H:m', strtotime($protokollDaten['ProtokollInformationen']['flugzeit'])) : "" ?></b></td>          
    </tr>
    <?php if(isset($protokollDaten['ProtokollInformationen']['bemerkung']) && ! empty($protokollDaten['ProtokollInformationen']['bemerkung'])) : ?>
        <tr>
            <td>Bemerkungen:</td>
            <td colspan="3"><b><?= $protokollDaten['ProtokollInformationen']['bemerkung'] ?></b></td>
        </tr>
    <?php endif ?>
        
</table>