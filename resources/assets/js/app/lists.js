function deleteList( encrypted_list_id ){
	$.ajax({
		url: '/api/list/'.encrypted_task_id,
		type: 'DELETE',
		cache: false
	});
}

function updateList( title, slug, globalValue, encrypted_list_id ){
	$.ajax({
		url: '/api/task/'.encryped_list_id,
		type: 'PUT',
		cache: false,
		dataType: 'json',
        data: {
        	"title" : title,
        	"slug" : slug,
        	"global" : globalValue
        }
	});
}