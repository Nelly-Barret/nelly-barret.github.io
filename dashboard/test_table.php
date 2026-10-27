<table id="test_table" class="table table-striped">
	<thead>
		<tr>
			<th>Id</th>
			<th>Champ</th>
		</tr>
	</thead>
	<tbody>
		<?php while($test = $tests->fetch_assoc()): ?>
			<tr>
				<td><?= $test["id"] ?></td>
				<td><?= $test["champ"] ?></td>
				<td><button onclick="modifTestVal(<?= $test['id']?>, '<?= $test['champ']?>')" >Modifier</button></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>