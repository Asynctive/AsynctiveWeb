<h3><?php echo $title ?></h3>

<?php if(isset($success_message)): ?>
<p class="success"><?php echo $success_message ?></p>
<?php else: ?>

<?php if(isset($update_message)): ?>
<p class="success"><?php echo $update_message ?></p>
<?php endif ?>

<form id="articleForm" class="cmxform" method="POST">
	<div class="form-group">
		<label for="article-title">Title:</label>
		<input id="article-title" name="article_title" type="text" class="form-control" value="<?php echo $article['title'] ?>" style="width: 350px">
		<?php echo form_error('article_title') ?>
	</div>
	
	<div class="form-group">
		<label for="article-categories">Categories:</label>
		<select id="article-categories" class="form-control" name="article_categories[]" multiple="multiple" style="width: 300px">
			<option></option>
			<?php
			foreach($categories as $cat)
			{
				echo "<option value=\"$cat->id\"";
				if (isset($article['categories']) && in_array($cat->id, $article['categories']))
					echo ' selected="selected"';
				 
				echo ">$cat->name</option>";
			}				
			?>
		</select>
	</div>
	
	<div class="form-group">
		<label for="article-content">Content:</label>
		<textarea id="article-content" name="article_content" style="width: 100%; height: 200px"><?php echo $article['content'] ?></textarea>
		<?php echo form_error('article_content') ?>
	</div>
	
	<div class="form-group">
		<button type="submit" class="btn btn-default">Submit</button>
	</div>
</form>

<?php endif ?>
