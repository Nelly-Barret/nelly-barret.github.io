<table style="border: solid 1px;" id="test_table">
	<thead>
		<tr>
			<th>Id</th>
			<th>Champ</th>
		</tr>
	</thead>
	<tbody>
		<?php while($test = $tests->fetch_assoc()): ?>
			<tr style="border: solid 1px;">
				<td style="border: solid 1px;"><?= $test["id"] ?></td>
				<td style="border: solid 1px;"><?= $test["champ"] ?></td>
				<td style="border: solid 1px;"><button onclick="modifTestVal(<?= $test['id']?>, '<?= $test['champ']?>')" >Modifier</button></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>