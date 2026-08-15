<?php
require('db.php');
try {
	$SQL_AWARDS = "SELECT * FROM award;";
	$awards = $conn->query($SQL_AWARDS);

	$SQL_ALL_TRAINING = "SELECT *, CONCAT('<ul><li>', GROUP_CONCAT(td.text SEPARATOR '</li><li>'), '</li></ul>') AS content FROM training t LEFT JOIN training_description td ON t.id=td.training_id GROUP BY t.id;";
	$trainings = $conn->query($SQL_ALL_TRAINING);
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
		<h1 class="section-title">Awards</h1>
		<table class="table table-striped table-hover my-table-three">
			<tbody>
			<?php while($award = $awards->fetch_assoc()): ?>
				<tr>
					<td><?=$award["location"] ?></td>
					<td><b><?=$award["title"] ?></b> (<?=$award["date"] ?>)<br/><p class="description"><?=$award["contents"] ?></p></td>
					<?php if($award["webpage"] != ""): ?>
						<td><a href="<?=$award["webpage"]?>" target="_blank">website</a></td>
					<?php else: ?>
						<td></td>
					<?php endif; ?>
				</tr>
			<?php endwhile; ?> 
			</tbody>
		</table>
	
		<h1 class="section-title">Training activities</h1>
		<table class="table table-striped table-hover my-table-three">
			<tbody>
			<?php while($training = $trainings->fetch_assoc()): ?>
				<tr>
					<td><img src="<?=$training["logo_filepath"]?>" class="logo"></img></td>
					<td><b><?=$training["title"] ?></b> (<?=$training["duration"] ?>)<br/><div class="description"><?=$training["content"]?></div></td>
					<?php if($training["webpage"] != ""): ?>
						<td><a href="<?=$training["webpage"]?>" target="_blank">website</a></td>
					<?php else: ?>
						<td></td>
					<?php endif; ?>
				</tr>
			<?php endwhile; ?> 
			</tbody>
		</table>
    </section>
</body>
</html>