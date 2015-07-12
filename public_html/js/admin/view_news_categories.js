/*
 * Asynctive Web View News Categories Script
 * Author: Andy Deveaux
 */
$('document').ready(function() {
	$("button[id^='createCategory']").click(function() {
		window.location.href = '/admin/news/categories/create';
	});
	
	$("button[id^='deleteCategories']").click(function() {
		
		var ids = [];
		$("input:checkbox[id='chk-delete']:checked").each(function() {
			ids.push(this.value);
		});
		
		if (ids.length == 0 || !confirm('Are you sure you want to delete these categories?'))
			return;
			
		$("p[id='error-msg']").hide();			
		console.log('Delete categories: ' + ids);
		
		$.post('/admin/news/categories/delete', {'category_ids[]': ids})
		.done(function(data) {
			console.log(data);
			var json = $.parseJSON(data);
			if (json.success)
			{
				// Delete rows
				$.each(ids, function(index, value) {
					$("table tr[id='row-" + value + "']").remove();
				});
			}
			else
			{
				$("p[id='error-msg']").html(json.message);
				$("p[id='error-msg']").show();			
			}
		});
	});
	
	$("button[id^='btn-edit-']").click(function() {
		var id = this.id.split('-')[2];
		if (id !== null)
			window.location.href = '/admin/news/categories/edit/' + id;
	});
});