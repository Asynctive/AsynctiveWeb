<h3>News Categories</h3>

<p id="error-msg" class="error" style="display: none"></p>

<div class="form-horizontal">
	<button id="createCategory" class="btn btn-primary">Create</button>
	<button id="deleteCategories" class="btn btn-primary" style="margin-left: 50px">Delete</button>
</div>

<br>

<table id="categoriesTable" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th></th>
			<th>Name</th>
			<th>Slug</th>
			<th>Edit</th>
		</tr>
	</thead>
	
	<tbody>
		<?php foreach($categories as $row): ?>
		<tr id="row-<?php echo $row->id ?>">
			<td><input id="chk-delete" type="checkbox" class="checkbox" value="<?php echo $row->id ?>"></td>
			<td><?php echo $row->name ?></td>
			<td><?php echo $row->slug ?></td>
			<td><button id="btn-edit-<?php echo $row->id ?>" class="btn btn-default">Edit</button></td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>


<div class="form-horizontal">
	<button id="createCategory2" class="btn btn-primary">Create</button>
	<button id="deleteCategories2" class="btn btn-primary" style="margin-left: 50px">Delete</button>
</div>