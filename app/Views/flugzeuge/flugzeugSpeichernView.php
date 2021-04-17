<h2 class="text-center m-4"><?= esc($title) ?></h2>	

<?= \Config\Services::validation()->listErrors() ?>

<div class="row">
	<div class="col-2">
	</div>
	<div class="col-8">
	
		<form class="needs-validation" method="post" action="/flugzeuge/flugzeugNeu/15" novalidate=""><!--  novalidate="" nur zum testen!! -->
		<!--<?php  //form_open('/flugzeuge/flugzeugNeu/flugzeugSpeichern', ["class" => "needs-validation"]) ?>-->

		
