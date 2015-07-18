/*
 * Asynctive Web View Articles Script
 * Author: Andy Deveaux
 */
$('document').ready(function() {
	$('#search-start-date').datepicker({
		onSelect: function(dateText, inst) {
			var epoch = $.datepicker.formatDate('@', $(this).datepicker('getDate')) / 1000;
			$('#search-date1').val(epoch);
		}
	});
	
	$('#search-end-date').datepicker({
		onSelect: function(dateText, inst) {
			var epoch = $.datepicker.formatDate('@', $(this).datepicker('getDate')) / 1000;
			$('#search-date2').val(epoch);
		}
	});
	
	$('#createArticle').click(function() {
		window.location.href = "/admin/news/articles/create";		
	});
	
	$('#deleteArticles').click(function() {
		var ids = [];
		$("input:checkbox[id='chk-delete']:checked").each(function() {
			ids.push(this.value);
		});
		
		if (ids.length == 0 || !confirm('Are you sure you want to delete these articles?'))
			return;
			
		$("p[id='error-msg']").hide();			
		console.log('Delete articles: ' + ids);
		
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
	
	$("button[id^='btn-edit-']").click(function() {
		var id = this.id.split('-')[2];
		if (id !== null)
			window.location.href = '/admin/news/articles/edit/' + id;
	});
});
