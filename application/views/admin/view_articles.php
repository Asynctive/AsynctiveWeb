<h3>News Articles</h3>

<div class="form-horizontal">
	<button id="createArticle" class="btn btn-primary" >Create</button>
	<button id="deleteArticles" class="btn btn-primary" style="margin-left: 50px">Delete</button>
</div>

<br>

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
		<tr>
			<td><input id="chk-delete" type="checkbox" class="checkbox" value="<?php echo $row->id ?>"></td>
			<td><?php echo $row->title ?></td>
			<td><?php echo "<a href=\"/admin/users/$row->user_id\">$row->username</a>" ?></td>
			<td>
				<?php
					$length = count($row->categories);
					for($i = 0; $i < $length; $i++): 
				?>
				<a href="/admin/news/categories/edit/<?php echo $row->categories[$i]['id'] ?>"><?php echo $row->categories[$i]['name'] ?></a>
				<?php if($i < ($length-1)) echo ', ' ?>
				<?php endfor ?>
			</td>
			<td><?php echo date("", $row->created) ?></td>
			<td><?php echo date("", $row->updated) ?></td>
			<td><button id="btn-edit-<?php echo $row->id ?>" class="btn btn-default">Edit</button></td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>
