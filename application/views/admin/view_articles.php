<h3>News Articles</h3>

<div>
	<button id="createArticle" class="btn btn-primary" >Create</button>
	<button id="deleteArticles" class="btn btn-primary" style="margin-left: 50px">Delete</button>
</div>

<br>

<p id="error-msg" class="error" style="display: none"></p>

<br><br>

<form name="searchForm" class="form-inline" method="GET">
	<fieldset>
		<legend>Search</legend>
		
		<p>Options</p>
		<p>
			<code>user:&lt;name&gt;</code><br>
			<code>category:&lt;category&gt;</code>
		</p>
		
		<div class="form-group">
			<input id="search-term" name="search_term" class="form-control" value="<?php echo $search ?>">
		</div>
		
		<div class="form-group">
			<label for="search-field" style="display: inline-block !important">Sort:</label>
			<select id="search-field" name="search_sort" class="form-control">
				<option value="created"<?php if($sort == 'created') echo ' selected="selected"'?>>Created</option>
				<option value="title"<?php if($sort == 'title') echo ' selected="selected"'?>>Title</option>
				<option value="updated"<?php if($sort == 'updated') echo ' selected="selected"'?>>Updated</option>
			</select>
		</div>
		
		<div class="form-group">
			<select id="search-order" name="search_order" class="form-control">
				<option value="asc"<?php if($order == 'asc') echo ' selected="selected"'?>>Ascending</option>
				<option value="desc"<?php if($order == 'desc') echo ' selected="selected"'?>>Descending</option>
			</select>
		</div>
		
		<div class="form-group">
			<input id="search-start-date" type="text" value="<?php if($start_date > 0) echo date('m/d/Y', $start_date) ?>">
			to
			<input id="search-end-date" type="text" value="<?php echo date('m/d/Y', $end_date) ?>">
		</div>
		
		<input id="search-date1" name="search_date1" type="hidden" value="<?php echo $start_date ?>">
		<input id="search-date2" name="search_date2" type="hidden" value="<?php echo $end_date ?>">
		
		<div class="form-group">
			<button type="submit" class="btn btn-default">Submit</button>
		</div>
	</fieldset>
</form>

<?php echo $this->pagination->create_links() ?>
<table id="articlesTable" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th></th>
			<th>Title</th>
			<th>Creator</th>
			<th>Categories</th>
			<th>Created</th>
			<th>Updated</th>
			<th>Edit</th>
		</tr>
	</thead>
	
	<tbody>
		<?php foreach($articles as $row): ?>
		<tr id="row-<?php echo $row->id ?>">
			<td><input id="chk-delete" type="checkbox" class="checkbox" value="<?php echo $row->id ?>"></td>
			<td><?php echo $row->title ?></td>
			<td><?php echo "<a href=\"/admin/users/$row->user_id\" target=\"_blank\">$row->username</a>" ?></td>
			<td>
				<?php
					$length = count($row->categories);
					for($i = 0; $i < $length; $i++): 
				?>
				<a href="/admin/news/categories/edit/<?php echo $row->categories[$i]['id'] ?>" target="_blank"><?php echo $row->categories[$i]['name'] ?></a>
				<?php if($i < ($length-1)) echo ', ' ?>
				<?php endfor ?>
			</td>
			<td><?php echo date("d/m/Y h:iA (e)", $row->created) ?></td>
			<td><?php if($row->updated != 0) echo date("d/m/Y h:iA (e)", $row->updated) ?></td>
			<td><button id="btn-edit-<?php echo $row->id ?>" class="btn btn-default">Edit</button></td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>
<?php echo $this->pagination->create_links() ?>
