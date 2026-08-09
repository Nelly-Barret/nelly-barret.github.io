<li>
	<!-- publication authors -->
	<?php 
		$SQL_AUTHORS = "SELECT * FROM publication_author pa LEFT JOIN person pe ON pa.author_id = pe.id ORDER BY pa.publication_id ASC, pa.author_position ASC;";
		$authors = $conn->query($SQL_AUTHORS);
		$publication_authors = [];
		while($author = $authors->fetch_assoc()) {
			if($author["publication_id"] == $publication["id"]) {
				$publication_authors[] = $author["last_name"]." ".$author["first_name"][0];
			}
		}

		// concat authors with a comma
		$str_authors = implode(", ", $publication_authors);

		// underline my name if I am the main author
		if($publication["main_author"] == 1) {
			$str_authors = str_replace("Barret N", "<u>Barret N</u>", $str_authors);
		}
	?>

	<!-- publication title -->
	<?= $str_authors ?>. <b><?= $publication["title"] ?></b>. <?=$publication["name"]?>. <?=$publication["year"]?>.
	<br/>

	<!-- conference name -->
	<?php if($publication["acronym"] != ""): ?>
		<span class="badge text-bg-secondary" style="background-color: <?=$COLORS[$publication['category']]?> !important"><?=$publication["acronym"]?></span>
	<?php endif; ?>

	<!-- publication type -->
	<?php if($publication["category"] != ""): ?>
		<span class="badge text-bg-secondary"><?=$CATEGORIES[$publication["category"]]?></span>
	<?php endif; ?>

	<!-- year -->
	<?php if($publication["year"] != ""): ?>
		<span class="badge text-bg-secondary"><?=$publication["year"]?></span>
	<?php endif; ?>
	<br/>

	<!-- buttons -->
	<!-- publication url -->
	<?php if($publication["publication_url"] != ""): ?>
		<button type="button" class="btn btn-light"><a href="<?=$publication["publication_url"]?>" target="_blank">publication link</a></button>
	<?php endif; ?>

	<!-- paper url -->
	<?php if($publication["paper_url"] != ""): ?>
		<button type="button" class="btn btn-light"><a href="<?=$publication["paper_url"]?>" target="_blank">pdf</a></button>
	<?php endif; ?>

	<!-- slides url -->
	<?php if($publication["slides_url"] != ""): ?>
		<button type="button" class="btn btn-light"><a href="<?=$publication["slides_url"]?>" target="_blank">slides</a></button>
	<?php endif; ?>

	<!-- poster url -->
	<?php if($publication["poster_url"] != ""): ?>
		<button type="button" class="btn btn-light"><a href="<?=$publication["poster_url"]?>" target="_blank">poster</a></button>
	<?php endif; ?>

	<!-- TeX citation -->
	<?php if($publication["bib_id"] != ""): ?>
		<button class="btn btn-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBib<?=$publication['bib_id']?>" aria-expanded="false" aria-controls="collapseBib<?=$publication['bib_id']?>">
			<i class='fa-brands fa-tex my-icon' style='color: blue;'></i>
		</button>
		<div class="collapse" id="collapseBib<?=$publication['bib_id']?>" style='font-family: monospace, monospace'>
			<div class="card card-body">
				@<?= $publication["type"]?> {<?= $publication["key"]?></br>
					&nbsp;&nbsp;title={<?= $publication["title"]?>},</br>
					<?php if($publication["venue"] != ""): ?>
						&nbsp;&nbsp;volume={<?=$publication["venue"]?>},</br>
					<?php endif; ?>
					<?php if($publication["volume"] != ""): ?>
						&nbsp;&nbsp;volume={<?=$publication["volume"]?>},</br>
					<?php endif; ?>
					<?php if($publication["number"] != ""): ?>
						&nbsp;&nbsp;number={<?=$publication["number"]?>},</br>
					<?php endif; ?>
					<?php if($publication["publisher"] != ""): ?>
						&nbsp;&nbsp;publisher={<?=$publication["publisher"]?>},</br>
					<?php endif; ?>
					<?php if($publication["booktitle"] != ""): ?>
						&nbsp;&nbsp;booktitle={<?=$publication["booktitle"]?>}</br>
					<?php endif; ?>
				}
			</div>
		</div>
	<?php endif; ?>
	<br/>
</li>