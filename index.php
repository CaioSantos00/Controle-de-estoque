<?php
require "vendor/autoload.php";

use App\Servicos\ErrorLogging\VisualizarLogErros\VisualizarLogErros as VerLogErros;
?>

<p>
	<?= new VerLogErros() ?>
</p>
<script>
	let x = document.querySelector('p').innerText;
	console.log(JSON.parse(x))
</script>