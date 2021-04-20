<?= view('templates/headerView') ?>
</head>
<body class="bg-light">
<main>

	<div style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);" class="text-center">	
		<h3><?= esc($nachricht) ?></h3>
		<a href="<?= esc($link) ?>"
			<button type="button" class="btn btn-primary">Zurück</button>
		</a>
	</div>
	
<?= view('templates/footerView') ?>