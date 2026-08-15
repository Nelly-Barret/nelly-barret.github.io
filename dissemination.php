<?php
require('db.php');
try {
	$SQL_TALKS = "SELECT * FROM dissemination ORDER BY date DESC, id ASC;";
	$talks = $conn->query($SQL_TALKS);
} catch (Exception $e) {
	var_dump($e);
}

?>

<!DOCTYPE html>

<html lang="fr">
<?php include 'head.php'; ?>
    
<body>
	<?php include 'navbar.php'; ?>
    
    <section class="anchor light">
		<h1 class="section-title">Selection</h1>

		<p style="color: red;">TODO</p>

		<h1 class="section-title">Invited talks</h1>
		<table class="table table-striped table-hover my-table-four">
			<tbody>
			<?php while($talk = $talks->fetch_assoc()): ?>
				<?php if($talk["category"] == "Seminar"): ?>
					<tr>
						<td><img src="<?=$talk["logo_filepath"]?>" class="logo"></img></td>
						<td><?=date('F Y', strtotime($talk["date"])) ?></td>
						<td><?=$talk["title"] ?></td>
						<td><a href="<?=$talk["resource"]?>" target="_blank">PDF</a></td>
					</tr>
				<?php endif; ?>
			<?php endwhile; ?> 
			</tbody>
		</table>

		<h1 class="section-title">Panels</h1>
		<?php $talks = $conn->query($SQL_TALKS); ?>

		<table class="table table-striped table-hover my-table-four">
			<tbody>
			<?php while($talk = $talks->fetch_assoc()): ?>
				<?php if($talk["category"] == "Panel"): ?>
					<tr>
						<td><img src="<?=$talk["logo_filepath"]?>" class="logo"></img></td>
						<td><?=date('F Y', strtotime($talk["date"])) ?></td>
						<td><?=$talk["title"] ?><br/><span class="badge text-bg-secondary"><?=$talk["crowd"] ?></span></td>
						<?php if($talk["resource"] != ""): ?>
							<td><a href="<?=$talk["resource"]?>" target="_blank">video</a></td>
						<?php else: ?>
							<td></td>
						<?php endif; ?>
					</tr>
				<?php endif; ?>
			<?php endwhile; ?> 
			</tbody>
		</table>

		<h1 class="section-title">Vulgarization talks</h1>
		<?php $talks = $conn->query($SQL_TALKS); ?>
		
		<table class="table table-striped table-hover my-table-four">
			<tbody>
			<?php while($talk = $talks->fetch_assoc()): ?>
				<?php if($talk["category"] == "Vulgarization"): ?>
					<tr>
						<td><img src="<?=$talk["logo_filepath"]?>" class="logo"></img></td>
						<td><?=date('F Y', strtotime($talk["date"])) ?></td>
						<td><?=$talk["title"] ?><br/><span class="badge text-bg-secondary"><?=$talk["crowd"] ?></span></td>
						<?php if($talk["resource"] != ""): ?>
							<td><a href="<?=$talk["resource"]?>" target="_blank">PDF</a></td>
						<?php else: ?>
							<td></td>
						<?php endif; ?>
					</tr>
				<?php endif; ?>
			<?php endwhile; ?> 
			</tbody>
		</table>

		<h1 class="section-title">Female empowerment talks</h1>
		<?php $talks = $conn->query($SQL_TALKS); ?>
		
		<table class="table table-striped table-hover my-table-four">
			<tbody>
			<?php while($talk = $talks->fetch_assoc()): ?>
				<?php if($talk["category"] == "Female empowerment"): ?>
					<tr>
						<td><img src="<?=$talk["logo_filepath"]?>" class="logo"></img></td>
						<td><?=date('F Y', strtotime($talk["date"])) ?></td>
						<td><?=$talk["title"] ?><br/><span class="badge text-bg-secondary"><?=$talk["crowd"] ?></span></td>
						<?php if($talk["resource"] != ""): ?>
							<td><a href="<?=$talk["resource"]?>" target="_blank">website</a></td>
						<?php else: ?>
							<td></td>
						<?php endif; ?>
					</tr>
				<?php endif; ?>
			<?php endwhile; ?> 
			</tbody>
		</table>
    </section>
</body>
</html>