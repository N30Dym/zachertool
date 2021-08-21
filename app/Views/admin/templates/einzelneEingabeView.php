<div class="p-3 p-md-5 mb-4 text-white shadow rounded bg-secondary">
    <h1><?= $titel ?></h1>
</div>

<form method="post" action="<?= str_replace('liste', 'speichern', current_url()) ?>">

     <?= csrf_field() ?>
        
    <div class="row mb-4 g-2">
        <div class="col-lg-1 d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="<?= $zurueckButton ?? base_url() ?>" >
                <button type="button" class="btn btn-danger col-12">Zurück</button>
            </a>
        </div>
        <div class="col-lg-11 d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-success">Speichern</button>
        </div>
    </div>
    
    <div class="row ">
        <div class="col-lg-2">
        </div>

        <div class="col-md-8 p-3 m-3 border rounded shadow">
            <div class="col-12">
                <label for="eingabe" class="form-label ms-3"><?= $eingabeArray['label'] ?></label>
                <input name="eingabe" type="<?= $eingabeArray['type'] ?>" min="<?= $eingabeArray['min'] ?? "" ?>" max="<?= $eingabeArray['max'] ?? "" ?>" step="<?= $eingabeArray['step'] ?? "" ?>" class="form-control" id="eingabe" required >
            </div>
        </div>

        <div class="col-lg-2">
        </div>
    </div>
   
</form>
