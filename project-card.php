<?php
require('db.php');
try {
	$SQL_PROJECTS_TAGS = "SELECT * FROM project_tag;";
	$projects_tags = $conn->query($SQL_PROJECTS_TAGS);
} catch (Exception $e) {
	var_dump($e);
}

?>


<div class="card mb-3">
	<div class="row g-0">
		<div class="col-md-1">
			<img class="img-fluid rounded-start" src="<?=$project['image_filepath']?>" alt="<?=$project['img_alt_text']?>" height="100px">
		</div>
		<div class="col-md-11">
			<div class="card-body">
				<!-- Titles -->
				<h5 class="card-title"><?=$project["short_title"]?></h5>
				<h6 class="card-subtitle mb-2 text-muted"><?=$project["long_title"]?></h6>
				<!-- Infos -->
				<ul class="list-group list-group-horizontal-lg">
					<li class="list-group-item"><i class="fa-solid fa-calendar"></i><?=date('F Y', strtotime($project["starting_date"])) ?> - <?=date('F Y', strtotime($project["end_date"]))?></li>
					<li class="list-group-item"><i class="fa-solid fa-user"></i><?=$project["involvement"]?></li>
					<li class="list-group-item"><i class="fa-solid fa-dollar-sign"></i><?=$project["grant_type"]?></li>
					<?php if($project["company"] != ""): ?>
						<li class="list-group-item"><i class="fa-solid fa-handshake"></i><?=$project["company"]?></li>
					<?php endif; ?>
					<?php if($project["webpage"] != ""): ?>
						<li class="list-group-item"><i class="fa-solid fa-display"></i><a href="<?=$project["webpage"]?>" target="_blank"><?=$project["webpage"]?></a></li>
					<?php endif; ?>
				</ul>
				<!-- Orange line -->
				<div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
					<div class="progress-bar"></div>
				</div>
				<!-- Achivements -->
				<h5>Scientific achievements</h5>
					<ol>
					<?php foreach(explode(';', $project["scientific"]) as $achievement): ?>
						<li><?=$achievement?></li>
					<?php endforeach; ?>
					</ol>
				<h5>Practical outcomes</h5>
					<ol>
						<?php foreach(explode(';', $project["practical"]) as $practical): ?>
							<li><?=$practical?></li>
						<?php endforeach; ?>
					</ol>
				<!-- Tags -->
				<?php while($tag = $projects_tags->fetch_assoc()): ?>
					<?php if($tag["project_id"] == $project["id"]): ?>
						<span class="badge text-bg-secondary"><?=$tag["tag"]?></span>
					<?php endif; ?>
				<?php endwhile;?>
			</div>
		</div>
	</div>
</div>


