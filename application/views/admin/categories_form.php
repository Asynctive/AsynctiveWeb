<h3><?php echo $title ?></h3>

<?php if(isset($success_message)): ?>
<p class="success"><?php echo $success_message ?></p>
<p><a href="/admin/news/categories">Go back</a></p>
<?php else: ?>

<?php if(isset($success_update_message)): ?>
<p class="success"><?php echo $success_update_message ?></p>
<?php endif ?>

<form id="categoryForm" class="cmxform" method="POST">
	<div class="form-group">
		<label for="category-name">Name:</label>
		<input id="category-name" name="category_name" type="text" class="form-control" value="<?php echo $category_name ?>" style="width: 350px">
		<?php echo form_error('category_name') ?>
	</div>
	
	<div class="form-group">
		<label for="category-slug">Slug:</label>
		<input id="category-slug" name="category_slug" type="text" class="form-control" value="<?php echo $category_slug ?>" style="width: 350px">
		<?php echo form_error('category_slug') ?>
	</div>
	
	<div class="form-group">
		<button type="submit" class="btn btn-default">Submit</button>
	</div>
</form>

<?php endif ?>
