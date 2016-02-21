function deleteTask( encrypted_task_id ){
	$.ajax({
		url: 'api/task/'+encrypted_task_id,
		type: 'DELETE',
		cache: false
	});
}

function initTaskList( encrypted_list_id ){

	$('.new-task textarea').keydown(function(e){
		if (e.keyCode == 13){
			e.preventDefault( );
		}
	});

	if(typeof(Storage) !== "undefined") {
	    var hide_done_setting = localStorage.getItem("hide_done");
	    if( hide_done_setting == null ){
	    	localStorage.setItem("hide_done", "false");
	    }
	} else {
		$('#hide-done').show();
    	$('#show-done').hide();
	}

	function TaskViewModel() {
		var self = this;
		self.tasks = ko.observableArray([]);


		self.update = function(){
			$.ajax({
				url: 'api/list/'+encrypted_list_id+'/tasks',
				type: 'GET',
				cache: false,
				dataType: 'json',
		        beforeSend: function( ){
		        	$('.loading').show();
		        },
		        success: function( response ){
		        	self.tasks(response);
		        	$('.loading').hide();
		        }
			});
		};

		self.updateTask = function( ){
			var element = this;
			console.log( "Changed" );
			$.ajax({
				url: 'api/task/'+element.id,
				type: 'PUT',
				cache: false,
				dataType: 'json',
		        data: {
		        	"description" 	: element.description,
		        	"done"			: $('#' + element.id).is(":checked")
		        },
		        success: function( response ){
		        	self.toastResponse( response );
		        }
			});
		}

		self.stripLines = function( ){
			// Prevent newlines in our tasks
			$('textarea').keyup(function(){ 
				$(this).val( $(this).val().replace( /\r?\n/gi, '' ) ); 
			});

			$('textarea').keydown(function(e){
				if (e.keyCode == 13){
					e.preventDefault();
				}
			});
		}

		self.toastResponse = function( response ){
			if( response.success ){
				Materialize.toast( response.success, 2000, 'green lighten-2');
			}

			if( response.error ){
				Materialize.toast( response.error, 3000, 'red lighten-2');
			}
		}

		self.createTask = function( ){
			
			$('textarea').keydown(function(e){
				var description = $('.new-task textarea').val();
				if (e.keyCode == 13 && description != ''){
					// Submit values when they press enter
					e.preventDefault();
					$.ajax({
						url: 'api/task',
						type: 'post',
						cache: false,
						dataType: 'json',
				        data: {
				        	"description" : description,
				        	"list_id"  : encrypted_list_id
				        },
				        beforeSend: function( ){
				        	$('.loading').show();
				        },
				        success: function( response ){
				        	$('.new-task textarea').val("");
				        	self.toastResponse( response );
				        	self.update();
				        }
					});
				}
			});
		}

		self.processShowDone = function( ){
			if(typeof(Storage) !== "undefined") {
				var hide_done_setting = localStorage.getItem("hide_done");

			    if( hide_done_setting == "false" ){
			    	$('#hide-done').show();
			    	$('#show-done').hide();
			    	$('input:checked').parent().parent().show();
			    } else {
			    	$('#hide-done').hide();
			    	$('#show-done').show();
			    	$('input:checked').parent().parent().hide();
			    }
			}
		}

		self.toggleShowDone = function( ){
			if(typeof(Storage) !== "undefined") {
				var hide_done_setting = localStorage.getItem("hide_done");

				localStorage.setItem("hide_done", ( hide_done_setting == "false" ? "true" : "false"));
				self.processShowDone( );
			} else{
				// if they don't have local storage
				if( $('#hide-done').is(':visible') ){
					$('#hide-done').hide();
			    	$('#show-done').show();
				} else{
					$('#hide-done').hide();
			    	$('#show-done').show();
				}
			}
		}

		self.update();
		self.toggleShowDone( );
	}
	
	ko.applyBindings(new TaskViewModel());
}