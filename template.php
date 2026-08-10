<?php
require('db.php');

try {
	$sql = "SELECT * FROM project;";
	$projects = $conn->query($sql);
	// $query->bindValue(':uid', $_REQUEST['uid']);
	// $stmt->execute();
	// $elements = $stmt->fetchAll();
	// print_r($elements);
	// $elements = ["a", "b"];
} catch (Exception $e) {
	var_dump($e);
}

try {
	$sql = "SELECT * FROM project_description;";
	$descriptions = $conn->query($sql);
} catch (Exception $e) {
	var_dump($e);
}

?>

<!DOCTYPE html>

<html lang="fr">
<?php include 'head.php'; ?>
    
<body>
	<?php include 'navbar.php'; ?>
    
    <!-- SECTION TALKS -->
    <section class="anchor light">
		<div class="container py-2" id="container-talks">
		</div>
		<?php 
			while($row = $projects->fetch_assoc()): ?>
			<article class='postcard'>
				<?php if($row["image_filepath"] != ""): ?>
					<div class='myImage postcard__img_link'>
						<img class='postcard__img' src='<?= $row["image_filepath"] ?>' alt='<?= $row["img_alt_text"] ?>' />
					</div>
				<?php endif; ?>
				<div class='postcard__text t-dark'>
					<div style='display: flex; justify-content: space-between;'>
						<h4 class="postcard__title"><?= $row["long_title"];?></h4>
					</div>
					<div class='postcard__subtitle'>
						<p class="dates"><?= $row["starting_date"] ?> - <?= $row["end_date"] ?></p>
						<i class="fa-solid fa-user"></i>
						<?= $row["involvement"] ?>
						<i class="fa-solid fa-dollar"></i>
						<?= $row["grant_type"] ?>
						<i class="fa-solid fa-building"></i>
						<?= $row["company"] ?>
						<i class="fa-solid fa-display"></i>
						<a href="<?= $row["webpage"] ?>" target="_blank"><?= $row["webpage"] ?></a>
					</div>
					<div class='postcard__bar'></div>
						<div class='postcard__preview-txt'>
							<ul>
							<?php 
							while($description = $descriptions->fetch_assoc()): ?>
								<?php if($row["id"] == $description["project_id"]): ?>
									<li><?= $description["text"] ?></li>
								<?php endif ?>
							<?php endwhile; ?> 
							</ul>
						</div>
						<?php 
						try {
							$sql = "SELECT * FROM project_description;";
							$descriptions = $conn->query($sql);
						} catch (Exception $e) {
							var_dump($e);
						}
						?>
					</div>
				</div>
				
			</article>
        <?php endwhile; ?> 
    </section>
</body>
</html>