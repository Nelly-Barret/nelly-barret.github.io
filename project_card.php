<div class="card">
	<img class="card-img-top" src="<?=$project['image_filepath']?>" alt="<?=$project['img_alt_text']?>" height="100px">
	<div class="card-body">
		<h5 class="card-title"><?=$project["short_title"]?></h5>
		<h6 class="card-subtitle mb-2 text-muted"><?=$project["long_title"]?></h6>
		<!-- <p class="card-text"><?=$project["long_title"]?></p> -->
	</div>
	<ul class="list-group list-group-flush">
		<li class="list-group-item"><i class="fa-solid fa-calendar"></i><?=$project["starting_date"]?>-<?=$project["end_date"]?></li>
		<li class="list-group-item"><i class="fa-solid fa-user"></i><?=$project["involvement"]?></li>
		<li class="list-group-item"><i class="fa-solid fa-dollar-sign"></i><?=$project["grant_type"]?></li>
		<?php if($project["company"] != ""): ?>
			<li class="list-group-item"><i class="fa-solid fa-handshake"></i><?=$project["company"]?></li>
		<?php endif; ?>
	</ul>
	<div class="card-body">
		<a href="#" class="card-link">See in details</a>
		<a href="<?=$project['webpage']?>" target="_blank" class="card-link">Go to the website</a>
	</div>
</div>