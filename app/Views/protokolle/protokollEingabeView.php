<h2 class="text-center m-4"><?= esc($title) ?></h2>	


<div class="row">
	<div class="col-2">
            <div class="p-3 row bg-dark">

                <input type="submit" class="col-12" value="1. Einleitung" formaction="/">
                <input type="submit" class="col-12" value="2. Einleitung" formaction="/">
                <input type="submit" class="col-12" value="3. Einleitung" formaction="/">
                <input type="submit" class="col-12" value="4. Einleitung" formaction="/">

            </div>	
	</div>
	<div class="col-8">
	
            <!--<form class="needs-validation" method="post" action="/flugzeuge/flugzeugNeu/15" novalidate=""><!--  novalidate="" nur zum testen!! -->
            <?=  form_open(site_url('flugzeuge/flugzeugNeu/flugzeugSpeichern'), ["class" => "needs-validation", /*"novalidate" => "novalidate"*/]) ?>



            <div class="mt-5 row"> 
            
                <div class="col-2">
                </div>
                
                <div class="col-2">
                    <button type="submit" class="btn btn-success col-12">< Zurück</button>
                </div>
                
                <div class="col-4">
                    <select></select>
                    <button>Go!</botton>
                </div>
                
                <div class="col-2">
                    <button type="submit" class="btn btn-success col-12">Weiter ></button>
                </div>
                
                <div class="col-2">
                </div>
                
            </div>
	<div class="col-2">
	</div>
</div>