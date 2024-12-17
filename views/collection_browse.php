<script language="javascript">
    $('select[name=command]').off('change').on('change', function() {
	const form = $('form');

	const fdata = {
	    command: $(this).val(),
	    criteria: form.find('[name=criteria]').first().val(),
	    sort: form.find('[name=sort]').first().val(),
	    projection: form.find('[name=projection]').first().val(),
	    update: form.find('[name=update]').first().val(),
	}
	app.pjax.navigate(form.attr('action'), { method: 'get', data: fdata, push: true });
    });

    //$('textarea[name=criteria], textarea[name=sort], textarea[name=projection], textarea[name=update]').tabby();
    $('textarea[name=criteria], textarea[name=sort], textarea[name=projection], textarea[name=update]').ace();


    $('.pager-nav').off('click').on('click', function(e) {
	e.preventDefault();

	const form = $('form');
	console.log('pagenav: form=', form);

	const fdata = {
	    command: form.find('select[name=command]').first().val(),
	    criteria: form.find('[name=criteria]').first().val(),
	    sort: form.find('[name=sort]').first().val(),
	    projection: form.find('[name=projection]').first().val(),
	    update: form.find('[name=update]').first().val(),
	}

	console.log('pagenav: fdata=', fdata);
	app.pjax.navigate($(this).attr('href'), { method: 'get', data: fdata, push: true });
    });
</script>

<?php
    $params = [ 'tab' => 'browse', 'db' => $db, 'collection' => $collection ];
    echo R::app()->view->renderFile('collection_nav', $params);
?>

<!-- Query box -->
<form method="post" action="<?= R::app()->url('app.collection_browse', [ 'db' => $db, 'collection' => $collection ]) ?>">
    <div class="row mx-1" style="background-color: #eeefff">
	<div class="col-9">
	    <?php
		echo R::app()->html->field('criteria', [
		    'type' => 'textarea',
		    'label' => 'Criteria',
		    'value' => $criteria ?? '',
		    'rows' => 5,
		    'id' => 'criteria-' . uniqid(),
		]);

		$_class = ($command == 'findAll' ? '' : 'd-none');
		echo "<div class='collapse {$_class}' id='options'>";
		echo R::app()->html->field('sort', [
		    'type' => 'textarea',
		    'label' => 'Sort',
		    'value' => $sort ?? '',
		    'rows' => 3,
		    'id' => 'sort-' . uniqid(),
		]);
		echo R::app()->html->field('projection', [
		    'type' => 'textarea',
		    'label' => 'Projection',
		    'value' => $projection ?? '',
		    'rows' => 3,
		    'id' => 'projection-' . uniqid(),
		]);
		echo "</div>";
		
		echo R::app()->html->field('update', [
		    'type' => 'textarea',
		    'label' => 'Update',
		    'value' => $update ?? '',
		    'rows' => 5,
		    'wrap' => $command != 'update' ? [ 'class' => 'd-none' ] : [ 'class' => 'mb-2' ],
		    'id' => 'update-' . uniqid(),
		]);

		if (!empty($error))
		    echo "<div class='alert alert-danger'>$error</div>";
	    ?>
	</div>
	<div class="col-3">
	    <?php
		echo R::app()->html->field('command', [
		    'type' => 'select',
		    'label' => 'Command',
		    'value' => $command ?? 'findAll',
		    'list' => [ 'findAll' => 'Query', 'update' => 'Update', 'remove' => 'Remove', ],
		]);
	    ?>
	    <input type="submit" class="btn btn-sm btn-success mb-2" value="Apply" pjax-submit>
	    <a class="btn btn-sm btn-outline-primary mb-2 <?=($command=='findAll'?'':'d-none')?>" data-bs-toggle="collapse" href="#options" role="button">Options</a>
	</div>
    </div>
</form>

<!-- Records in collection or action result-->
<?php
    $count = $count ?? null;
    switch($command) {
	case 'findAll':
	    if ($pager->total() == 0) {
		echo "<div class='row mx-1'><div class='col-12'>No records found</div></div>";
	    } else {
		$params = [ 'db' => $db, 'collection' => $collection, 'pager' => $pager, 'rows' => $rows, ];
		echo R::app()->view->renderFile('collection_records', $params);
	    }
	    break;
	case 'update':
	case 'remove':
	    if ($count !== null)
		echo "<div class='row mx-1'><div class='col-12'>$count records may be affected</div></div>";
	    break;
    }