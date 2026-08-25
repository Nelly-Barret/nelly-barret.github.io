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

	<!-- code publication -->
	<?php 
		$SQL_CODE = "SELECT * FROM publication_tool pt LEFT JOIN tool t ON pt.tool_id = t.toid;";
		$codes = $conn->query($SQL_CODE);
		$the_code = "";
		$the_code_url = "";
		while($code = $codes->fetch_assoc()) {
			if($code["publication_id"] == $publication["puid"]) {
				$the_code = $code["title"];
				$the_code_url = $code["repository"];
			}
		}
	?>

	<b><?= $publication["title"] ?></b>. <br/><?= $str_authors ?>. <br/><?=$publication["name"]?>. <?=$publication["year"]?>. <br/>

	<!-- publication authors, title , conference and year-->
	
	<!-- buttons -->
	<!-- editor url -->
	<?php if($publication["publication_url"] != ""): ?>
		<i class="fa-solid fa-up-right-from-square"></i><a href="<?=$publication["publication_url"]?>" target="_blank">Publisher page</a> 
	<?php endif; ?>

	<!-- DOI url -->
	<?php if($publication["doi_url"] != ""): ?>
		&nbsp;&#183;&nbsp;
		<i class="fa-solid fa-up-right-from-square"></i>&nbsp;<a href="<?=$publication["doi_url"]?>" target="_blank">DOI</a> 
	<?php endif; ?>
		
	<!-- paper url -->
	<?php if($publication["paper_url"] != ""): ?>
		&nbsp;&#183;&nbsp;
		<!-- <a href="<?=$publication["paper_url"]?>" target="_blank" title="PDF paper"><i class="fa-solid fa-file-pdf black-fa"></i></a> -->
		<i class="fa-solid fa-file-pdf black-fa"></i>&nbsp;<a href="<?=$publication["paper_url"]?>" target="_blank" title="PDF paper">Paper</a>
	<?php endif; ?>
	
	
	<!-- slides url -->
	<?php if($publication["slides_url"] != ""): ?>
		&nbsp;&#183;&nbsp;
		<i class="fa-solid fa-file-powerpoint black-fa"></i>&nbsp;<a href="<?=$publication["slides_url"]?>" target="_blank" title="PDF slides">Slides</a>
	<?php endif; ?>
		
		
	<!-- poster url -->
	<?php if($publication["poster_url"] != ""): ?>
		&nbsp;&#183;&nbsp;
		<i class="fa-solid fa-file-invoice black-fa"></i>&nbsp;<a href="<?=$publication["poster_url"]?>" target="_blank" title="PDF poster">Poster</a>
	<?php endif; ?>


	<!-- Code link -->
	<?php if($the_code_url != ""): ?>
		&nbsp;&#183;&nbsp;
		<i class="fa-solid fa-code"></i>&nbsp;<a href="<?=$the_code_url?>" target="_blank" title="Code URL">Code (<?= $the_code ?>)</a>
	<?php endif; ?>

	
	<!-- TeX citation -->
	<?php if($publication["bib_key"] != ""): ?>
		&nbsp;&#183;&nbsp;
		<i class="fa-brands fa-tex black-fa"></i>&nbsp;<a href="./bib/<?=$publication["bib_key"]?>.txt" target="_blank" title="TeX citation">BibTeX</a>
	<?php endif; ?>
</li>