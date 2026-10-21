<table class="table table-striped table-hover my-table-four">
	<tbody>
	<?php foreach($items as $item): ?>
		<tr>
			<td><img src="<?=$item["logo_filepath"]?>" class="logo" title="<?= $item['school']?>"></img></td>
			<td><?= $item["semester"]." ".$item["year"]?></td>
			<td>
				<p data-status="<?=$item['status']?>"><?=$item["topic"] ?></p>
				<p class="description">
					<u>Student:</u> <?=$item["first_name"]." ".$item["last_name"] ?> (<?=$item["level"]?>)
					<br/>
					<u>Supervision team:</u> <?=$item["the_team"]?>
					<?php if($item["report"] != "" || $item["slides"] != ""): ?>
						<br/>
					<?php endif; ?>
					<?php if($item["report"] != ""): ?>
						<a href="<?=$item['report']?>" target="_blank"><i class="fa-solid fa-file-pdf black-fa"></i>Report</a>
					<?php endif; ?>
					<?php if($item["slides"] != ""): ?>
						<a href="<?=$item['slides']?>" target="_blank"><i class="fa-solid fa-file-powerpoint black-fa"></i>Slides</a>
					<?php endif; ?>
				</p>
			</td>
			<td><?= status_badge($item["status"]) ?></td>
		</tr>
	<?php endforeach; ?> 
	</tbody>
</table>