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
	<div class="col-md-12">
		<div class="card-body">
			<div>
			<!-- Titles -->
			<div class="card-title">
				<h5><?=$project["short_title"]?> (<?=date('M Y', strtotime($project["start_date"])) ?> - <?=date('M Y', strtotime($project["end_date"]))?>)</h5>
				<img style="float: right; margin-top: -2rem;" class="rounded-start" src="<?=$project['image_filepath']?>" alt="<?=$project['img_alt_text']?>" height="100px" width="100px">
			</div>
			<h6 class="card-subtitle mb-2 text-muted"><?=$project["long_title"]?></h6>
			<!-- Tags -->
			<?php while($tag = $projects_tags->fetch_assoc()): ?>
				<?php if($tag["project_id"] == $project["prid"]): ?>
					<span class="badge text-bg-secondary"><?=$tag["tag"]?></span>
				<?php endif; ?>
			<?php endwhile;?>
			</div>
			
			<!-- Orange line -->
			<div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
				<div class="progress-bar"></div>
			</div>
			<!-- Infos -->
			<i class="fa-solid fa-user"></i><?=$project["involvement"]?>&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-dollar-sign"></i><?=$project["grant_type"]?>
			<?php if($project["company"] != ""): ?>
				&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-handshake"></i><?=$project["company"]?>
			<?php endif; ?>
			<?php if($project["webpage"] != ""): ?>
				&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-up-right-from-square"></i><a href="<?=$project["webpage"]?>" target="_blank">project page</a>
			<?php endif; ?>
			<br/>
			<button class="btn btn-light collapse-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProject<?=$project["prid"]?>" aria-expanded="false" aria-controls="collapseProject<?=$project["prid"]?>">Open details</button>

			<div class="collapse" id="collapseProject<?=$project["prid"]?>">
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
					<ul>
					<?php while($tool = $projects_tools->fetch_assoc()): ?>
						<?php if($tool["project_id"] == $project["prid"]): ?>
							<li><b><?=$tool["title"]?></b> <a href="<?=$tool["repository"]?>" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i></a> (<?=$tool["language"]?> application, <?=$tool["loc"]?>k LOC, <?= compute_duration($tool["start_date"], $tool["end_date"])?>)</li>
						<?php endif; ?>
					<?php endwhile;?>
					</ul>
			</div>
		</div>
	</div>
</div>




