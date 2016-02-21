function initTaskList( encrypted_list_id ){

	// Set a default state for hiding "done" items
	if(typeof(Storage) !== "undefined") {
	    var hide_done_setting = localStorage.getItem("hide_done");
	    if( hide_done_setting == null ){
	    	localStorage.setItem("hide_done", "false");
	    }
	} else {
		$('#hide-done').show();
    	$('#show-done').hide();
	}

	/**
	 * This is essentially a "List" model but fuck it
	 */
	function TaskViewModel() {
		var self = this;
		self.throttleRate = 50; // How many milliseconds should updates be throttled

		self.tasks = ko.observableArray([]).extend({ rateLimit: self.throttleRate });
		self.lastNewTask = "";

		/**
		 * Populate the observable array with all the tasks
		 */
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
		        	$('textarea').elastic();
		        	setTimeout( function( ){ self.processShowDone( ) }, self.throttleRate );
		        }
			});
		};

		/**
		 * Update a task
		 */
		self.updateTask = function( ){
			var element = this;
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

		/**
		 * Remove new lines from copied data
		 */
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

		/**
		 * Create a toast message when a response comes in
		 * @param  {object} response
		 */
		self.toastResponse = function( response ){
			if( response.success ){
				Materialize.toast( response.success, 1000, 'green lighten-2');
			}

			if( response.error ){
				Materialize.toast( response.error, 3000, 'red lighten-2');
			}
		}

		/**
		 * Listen for an "enter" press on the create task textarea
		 */
		self.createTaskListener = function( ){

			$('textarea').keydown(function(e){
				if (e.keyCode == 13){
					// If key is "enter"
					var description = $('.new-task textarea').val();
					if ( description != self.lastNewTask && description != ''){
						// If description is not duplicate of last and isn't empty
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
					        	// Show the loading bar
					        	$('.loading').show();
					        },
					        success: function( response ){
					        	// Reset the new task textarea
					        	$('.new-task textarea').val("");
					        	// Give the user some feedback on the request
					        	self.toastResponse( response );

					        	$('.loading').hide();
					        	// Push the new task onto the list
					        	self.tasks.push( response.task );

					        	// Scroll back to the textarea
					        	$('html, body').animate({
							        scrollTop: $(".new-task").offset().top
							    }, 2000);

							    self.lastNewTask = description;
					        }
						});
					}
				}
			});
		}

		/**
		 * Delete a task
		 */
		self.deleteTask = function( ){

			$.ajax({
				url: 'api/task/'+this.token,
				type: 'DELETE',
				cache: false,
				beforeSend: function( ){
					// To compensate for transmission delay,
					// remove the task before it's actually removed
					$('[taskid='+this.id+']').remove();
				},
				success: function( response ){
		        	self.toastResponse( response );
		        	self.update();
		        }
			});
		}

		/**
		 * Determine whether to hide or show "done" items
		 */
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

		/**
		 * Toggle whether to show "done" items
		 */
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

		/**
		 * Copy the list's URL to the clipboard
		 * @return {[type]} [description]
		 */
		self.copyToClipboard = function( ){
			var element = '#URL';

			var $temp = $("<input>");
			$("body").append($temp);
			$temp.val($(element).text()).select();
			document.execCommand("copy");
			$temp.remove();

			Materialize.toast( "URL Copied!", 2000, 'blue lighten-2');
		}

		// Populate the list
		self.update();
		// Start listening for task creation
		self.createTaskListener();
	}
	
	// Apply this wonderful model to our view
	ko.applyBindings(new TaskViewModel());
}