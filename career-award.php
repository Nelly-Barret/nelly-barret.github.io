<table class="table table-striped table-hover my-table-three">
    <tbody>
    <?php foreach($items as $item): ?>
        <tr>
            <td><?=$item["location"] ?></td>
            <td><b><?=$item["title"] ?></b> (<?=$item["date"] ?>)<br/><p class="description"><?=$item["contents"] ?></p></td>
            <?php if($item["webpage"] != ""): ?>
                <td><a href="<?=$item["webpage"]?>" target="_blank">website</a></td>
            <?php else: ?>
                <td></td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?> 
    </tbody>
</table>