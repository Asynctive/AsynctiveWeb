/*
 * Asynctive Web Admin View Users
 * Author: Andy Deveaux
 */
$('document').ready(function() {
	$('#search-start-date').datepicker({
		onSelect: function(dateText, inst) {
			var epoch = $.datepicker.formatDate('@', $(this).datepicker('getDate')) / 1000;
			$('#start-date').val(epoch);
		}
	});
	
	$('#search-end-date').datepicker({
		onSelect: function(dateText, int) {
			var epoch = $.datepicker.formatDate('@', $(this).datepicker('getDate')) / 1000;
			$('#end-date').val(epoch);
		}
	});
	
	$('#createButton').click(function() {
		window.location.href = '/admin/users/create';
	});
	
	$('#deleteButton').click(function() {
		var ids = [];
		$("input:checkbox[id='chk-delete']:checked").each(function() {
			ids.push(this.value);
		});
		
		if (ids.length == 0 || !confirm('Are you sure you want to delete these users?'))
			return;
			
		$("p[id='error-msg']").hide();			
		console.log('Delete categories: ' + ids);
		
		$.post('/admin/news/articles/delete', {'article_ids[]': ids})
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
});
