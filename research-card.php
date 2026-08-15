<?php
require('db.php');
try {
	$SQL_PROJECTS_TAGS = "SELECT * FROM project_tag;";
	$projects_tags = $conn->query($SQL_PROJECTS_TAGS);

	$SQL_PROJECTS_TOOLS = "SELECT * FROM tool;";
	$projects_tools = $conn->query($SQL_PROJECTS_TOOLS);
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
				<!-- Tags -->
				<?php while($tag = $projects_tags->fetch_assoc()): ?>
					<?php if($tag["project_id"] == $project["id"]): ?>
						<span class="badge text-bg-secondary"><?=$tag["tag"]?></span>
					<?php endif; ?>
				<?php endwhile;?>
				<!-- Orange line -->
				<div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
					<div class="progress-bar"></div>
				</div>
				<!-- Infos -->
				<ul class="list-group">
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
				<button class="btn btn-light collapse-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProject<?=$project['id']?>" aria-expanded="false" aria-controls="collapseProject<?=$project['id']?>">Open details</button>
				<div class="collapse" id="collapseProject<?=$project['id']?>">
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
					<!-- Associated publications -->
					<h5>Associated publications</h5>
						<p class="todo">TODO</p>
					<!-- Tools and artifacts -->
					<h5>Artifacts</h5>
						<?php while($tool = $projects_tools->fetch_assoc()): ?>
							<?php if($tool["project_id"] == $project["id"]): ?>
								<h6><?=$tool["title"]?></h6>
								<ul>
									<li>Repository: <a href="<?=$tool["repository"]?>" target="_blank"><?=$tool["repository"]?></a></li>
									<li>LOC: <?=$tool["loc"]?>k</li>
									<li>Languages: <?=$tool["language"]?></li>
									<li>Duration: <?= compute_duration($tool["start_date"], $tool["end_date"])?></li>
								</ul>
							<?php endif; ?>
						<?php endwhile;?>
				</div>
			</div>
		</div>
	</div>
</div>




