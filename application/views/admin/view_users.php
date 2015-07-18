<h3>View Users</h3>

<p id="error-msg" class="error"></p>

<div>
	<button id="createButton" class="btn btn-primary">Create</button>
	<button id="deleteButton" class="btn btn-primary" style="margin-left: 50px">Delete</button>
</div>

<br>
<form method="GET" class="form-inline">
	<fieldset>
		<legend>Search</legend>
		
		<div class="form-group">
			<input type="text" name="search" class="form-control" placeholder="Search" value="<?php echo $search['term'] ?>">
		</div>
		
		<div class="form-group">
			<select name="search_role" class="form-control">
				<option value="">Category</option>
				<?php foreach($roles as $role): ?>
				<option value="<?php echo $role->id ?>"<?php if($search['role_id'] == $role->id) echo ' selected="selected"' ?>><?php echo $role->label ?></option>
				<?php endforeach ?>
			</select>
		</div>
		
		<div class="form-group">
			<input id="search-start-date" type="text" value="<?php if($search['start_date'] > 0) echo date('m/d/Y', $search['start_date']) ?>">
			to
			<input id="search-end-date" type="text" value="<?php if ($search['end_date'] > 0) echo date('m/d/Y', $search['end_date']) ?>">
			
			<input id="start-date" name="search_start_date" type="hidden" value="<?php echo $search['start_date'] ?>">
			<input id="end-date" name="search_end_date" type="hidden" value="<?php echo $search['end_date'] ?>">
		</div>
		
		<div class="form-group">
			<label for="search-sort" style="display: inline">Sort:</label>
			<select id="search-sort" name="search_sort" class="form-control">
				<option value="username"<?php if($sort == 'username') echo ' selected="selected"' ?>>Username</option>
				<option value="created"<?php if($sort == 'created') echo ' selected="selected"' ?>>Created</option>
				<option value="Updated"<?php if($sort == 'updated') echo ' selected="selected"' ?>>Updated</option>
			</select>
			
			<select name="search_order" class="form-control">
				<option value="desc"<?php if($order == 'desc') echo ' selected="selected"' ?>>Descending</option>
				<option value="asc"<?php if($order == 'asc') echo ' selected="selected"' ?>>Ascending</option> 
			</select>
		</div>
		
		<div class="form-group">
			
		</div>
		
		<button type="submit" class="btn btn-default">Submit</button>
	</fieldset>
</form>

<br>
<table class="table table-striped table-hover table-bordered">
	<thead>
		<tr>
			<td></td>
			<td>Username</td>
			<td>E-mail</td>
			<td>First Name</td>
			<td>Last Name</td>
			<td>Verified</td>
			<td>Created</td>
			<td>Updated</td>
			<td>Edit</td>
		</tr>
	</thead>
	
	<tbody>
		<?php foreach($users as $row): ?>
		<tr id="row-<?php echo $row->id ?>">
			<td><input id="chk-delete" type="checkbox" class="checkbox" value="<?php echo $row->id ?>"></td>
			<td><a href="/admin/users/edit/<?php echo $row->id ?>"><?php echo $row->username ?></a></td>
			<td><a href="mailto:<?php echo $row->email ?>"><?php echo $row->email ?></a></td>
			<td><?php echo $row->first_name ?></td>
			<td><?php echo $row->last_name ?></td>
			<td><?php echo ($row->email_verified) ? 'YES' : 'NO' ?></td>
			<td><?php echo date("d/m/Y h:iA (e)", $row->created) ?></td>
			<td><?php echo date("d/m/Y h:iA (e)", $row->updated) ?></td>
			<td><button id="btn-edit-<?php echo $row->id ?>" class="btn btn-default">Edit</button></td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>
