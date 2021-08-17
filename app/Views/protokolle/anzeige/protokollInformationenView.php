<h2>1. Angaben zum Protokoll</h2>
<table class="table">
    <tr>
        <td><b>Datum des ersten Fluges:</b></td>
        <td><?= isset($protokollDaten['ProtokollInformationen']['datum']) ? date('d.m.Y', strtotime($protokollDaten['ProtokollInformationen']['datum'])) : "" ?></td>
        <td><b>Gesamtflugzeit für das Protokoll:</b></td>
        <td><?= isset($protokollDaten['ProtokollInformationen']['flugzeit']) ? date('H:m', strtotime($protokollDaten['ProtokollInformationen']['flugzeit'])) : "" ?></td>          
    </tr>
    <?php if(isset($protokollDaten['ProtokollInformationen']['bemerkung']) && ! empty($protokollDaten['ProtokollInformationen']['bemerkung'])) : ?>
        <tr>
            <td><b>Bemerkungen:</b></td>
            <td colspan="3"><?= $protokollDaten['ProtokollInformationen']['bemerkung'] ?></td>
        </tr>
    <?php endif ?>
        
</table>