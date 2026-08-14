<ul>
	<?php while($service = $services->fetch_assoc()): ?>
		<li>
			[<?= $service["rank"] ?>] <?= $service["acronym"] ?>: <?= $service["years"] ?>
		</li>
	<?php endwhile; ?> 
</ul>