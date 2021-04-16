<h2 class="text-center m-4"><?= esc($title) ?></h2>	

<?= \Config\Services::validation()->listErrors() ?>

<div class="row">
	<div class="col-2">
	</div>
	<div class="col-8">
	
		<form class="needs-validation" method="post" action="flugzeugSpeichern" novalidate=""><!--  novalidate="" nur zum testen!! -->
