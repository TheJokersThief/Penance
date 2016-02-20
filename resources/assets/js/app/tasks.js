function createTask( description, encryped_list_id ){
	$.ajax({
		url: '/api/task',
		type: 'post',
		cache: false,
		dataType: 'json',
        data: {
        	"description" : description,
        	"list_id"  : encryped_list_id
        }
	});
}

function updateTask( encrypted_task_id, description, done ){
	$.ajax({
		url: '/api/task/'.encrypted_task_id,
		type: 'PUT',
		cache: false,
		dataType: 'json',
        data: {
        	"description" : description,
        	"done"  : done
        }
	});
}

function deleteTask( encrypted_task_id ){
	$.ajax({
		url: '/api/task/'.encrypted_task_id,
		type: 'DELETE',
		cache: false
	});
}