<li>
	<!-- publication authors -->
	<?php 
		$SQL_AUTHORS = "SELECT * FROM publication_author pa LEFT JOIN person pe ON pa.author_id = pe.peid ORDER BY pa.publication_id ASC, pa.author_position ASC;";
		$authors = $conn->query($SQL_AUTHORS);
		$publication_authors = [];
		while($author = $authors->fetch_assoc()) {
			if($author["publication_id"] == $publication["puid"]) {
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

	<!-- publication authors, title , conference and year-->
	<?php if($publication["publication_url"] != ""): ?>
		<?= $str_authors ?>. <a href="<?=$publication["publication_url"]?>" target="_blank"><?= $publication["title"] ?></a>. <?=$publication["name"]?>. <?=$publication["year"]?>. 
	<?php else: ?>
		<?= $str_authors ?>. <b><?= $publication["title"] ?></b>. <?=$publication["name"]?>. <?=$publication["year"]?>. 
	<?php endif; ?>

	<!-- buttons -->
	<!-- editor url -->
		
	<!-- paper url -->
	<?php if($publication["paper_url"] != ""): ?>
		<a href="<?=$publication["paper_url"]?>" target="_blank" title="PDF paper"><i class="fa-solid fa-file-pdf black-fa"></i></a>
	<?php endif; ?>

	<!-- slides url -->
	<?php if($publication["slides_url"] != ""): ?>
		<a href="<?=$publication["slides_url"]?>" target="_blank" title="PDF slides"><i class="fa-solid fa-file-powerpoint black-fa"></i></a>
	<?php endif; ?>

	<!-- poster url -->
	<?php if($publication["poster_url"] != ""): ?>
		<a href="<?=$publication["poster_url"]?>" target="_blank" title="PDF poster"><i class="fa-solid fa-file-invoice black-fa"></i></a>
	<?php endif; ?>

	<!-- TeX citation -->
	<?php if($publication["bib_key"] != ""): ?>
		<a href="./bib/<?=$publication["bib_key"]?>.txt" target="_blank" title="TeX citation"><i class="fa-brands fa-tex black-fa"></i></a>
	<?php endif; ?>
</li>