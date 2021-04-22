        <div class="mt-5 row"> 

           <div class="col-3">
           </div>
           <div class="col-6">
               <?php if(isset($_SESSION['kapitelNummern'])) : ?>
                   <div class="d-flex row">
                       <div class="input-group mb-3">
                           <select id="kapitelAuswahl" class="form-select">
                               <option value="1" selected>1 - Informationen zum Protokoll</option>
                               <?php foreach($_SESSION['kapitelNummern'] as $kapitelNummer) : ?>
                                   <option value="<?= esc($kapitelNummer) ?>"><?= esc($kapitelNummer) . " - " . esc($_SESSION['kapitelBezeichnungen'][$kapitelNummer]) ?></option>
                               <?php endforeach ?>
                           </select>
                           <button type="submit" id="kapitelGo" class="btn btn-success" formaction="">Go!</botton>
                       </div>           
                   </div>
               <?php endif ?>
           </div>
           <div class="col-3">
               <button type="submit" class="btn btn-success col-12">Weiter ></button>
           </div>

        </div>
        <div class="col-1">
    </div>
</div>