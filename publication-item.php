<li>
	<!-- publication authors, title , conference and year-->
	<b><?= $publication["title"] ?></b>. <br/><?= $publication["the_authors"] ?>. <br/><?=$publication["name"]?>. <?=$publication["year"]?>. <br/>

	<!-- venue publicaiton type and ranking badge -->
	 <!-- the substring remove the last S from the pretty category name, e.g. "International conferences" (subsection title) becomes "International conference" for the publication type in the basge -->
	<span class="badge bg-secondary"><?=substr($CATEGORIES[$publication["category"]], 0, -1)?> [<?=$publication["rank"]?>]</span>
	
	<!-- buttons -->
	<!-- editor url -->
	<?php if($publication["publication_url"] != ""): ?>
		&nbsp;&#183;&nbsp;
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
	<?php if($publication["repository"] != ""): ?>
		&nbsp;&#183;&nbsp;
		<i class="fa-solid fa-code"></i>&nbsp;<a href="<?=$publication["repository"]?>" target="_blank" title="Code URL">Code (<?= $publication["tool"] ?>)</a>
	<?php endif; ?>

	
	<!-- TeX citation -->
	<?php if($publication["bib_key"] != ""): ?>
		&nbsp;&#183;&nbsp;
		<i class="fa-brands fa-tex black-fa"></i>&nbsp;<a href="./bib/<?=$publication["bib_key"]?>.txt" target="_blank" title="TeX citation">BibTeX</a>
	<?php endif; ?>
</li>