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

	<!-- <div class="row"> -->

	<!-- conference name -->
	<?php if($publication["acronym"] != ""): ?>
		<!-- <div class="col"> -->
			<span class="badge text-bg-secondary publication-button" style="background-color: <?=$COLORS[$publication['category']]?> !important"><?=$publication["acronym"]?></span>
		<!-- </div> -->
	<?php endif; ?>

	<!-- publication type -->
	<?php if($publication["category"] != ""): ?>
		<!-- <div class="col"> -->
			<span class="badge text-bg-secondary publication-button"><?=$CATEGORIES[$publication["category"]]?></span>
		<!-- </div> -->
	<?php endif; ?>

	<!-- year -->
	<?php if($publication["year"] != ""): ?>
		<!-- <div class="col"> -->
			<span class="badge text-bg-secondary publication-button"><?=$publication["year"]?></span>
		<!-- </div> -->
	<?php endif; ?>
	<br/>

	<!-- buttons -->
	<!-- publication url -->
	<?php if($publication["publication_url"] != ""): ?>
		<!-- <div class="col"> -->
		<a href="<?=$publication["publication_url"]?>" target="_blank" style="display: inline-block !important"><i class="fa-solid fa-up-right-from-square"></i></a>
		<!-- </div> -->
	<?php endif; ?>

	<!-- paper url -->
	<?php if($publication["paper_url"] != ""): ?>
		<!-- <div class="col"> -->
			<span class="inline-span"><a href="<?=$publication["paper_url"]?>" target="_blank"><i class="fa-solid fa-file-pdf"></i>paper</a></span>
		<!-- </div> -->
	<?php endif; ?>

	<!-- slides url -->
	<?php if($publication["slides_url"] != ""): ?>
		<!-- <div class="col"> -->
			<span><a href="<?=$publication["slides_url"]?>" target="_blank"><i class="fa-solid fa-file-pdf">slides</a></span>
		<!-- </div> -->
	<?php endif; ?>

	<!-- poster url -->
	<?php if($publication["poster_url"] != ""): ?>
		<!-- <div class="col"> -->
			<span class="inline-span"><a href="<?=$publication["poster_url"]?>" target="_blank"><i class="fa-solid fa-file-pdf">poster</a></span>
		<!-- </div> -->
	<?php endif; ?>

	<!-- TeX citation -->
	<?php if($publication["bib_id"] != ""): ?>
		<!-- <div class="col"> -->
		<button class="btn btn-light collapse-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBib<?=$publication['bib_id']?>" aria-expanded="false" aria-controls="collapseBib<?=$publication['bib_id']?>"><i class="fa-brands fa-tex"></i>TeX citation</button>
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
		<!-- </div> -->
	<?php endif; ?>
	<!-- </div> -->
</li>