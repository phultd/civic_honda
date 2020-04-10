/*
* Table of content:
* check port in host
* Toggle sidebar by button
*/

$(document).ready(function () {
	$.ajaxSetup({ headers: {'X-CSRF-TOKEN': csrf} });

	/*
	* Toggle sidebar by button
	*/
	$('.sidebar-toggle').on('click', function() {
		$('#sidebar').stop().toggleClass('collapsed');
		$('#content-wrapper').stop().toggleClass('expanded');
	});

	/*
	* check scroll window, animate sidebar
	*/
	window.onscroll = function() {
		if (document.body.scrollTop > 1 || document.documentElement.scrollTop > 1) {
	    	$('#sidebar .btn-toolbar').stop().addClass('collapsed');
	    } else {
			$('#sidebar .btn-toolbar').stop().removeClass('collapsed');
	    }
	};

	/*
	* CKEditor
	*/
	$('.wysiwyg').each(function() {
		var wysiwyg = CKEDITOR.replace( $(this).attr('id') );
		CKFinder.setupCKEditor( wysiwyg );
	})

	// select image button
	$('.btn-wysiwyg').click(function() {
		var elementId = $(this).attr('id');
		var remove_btn = '<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>';
		CKFinder.modal( {
			chooseFiles: true,
			width: 800,
			height: 600,
			onInit: function( finder ) {
				finder.on( 'files:choose', function( evt ) {
					var file = evt.data.files.first();
					var file_url = file.getUrl();
					file_url = url_port( file_url );
					$('#'+elementId).parent().find('.image-preview').html('');
					$('#'+elementId).parent().find('input').val('');
					$('#'+elementId).parent().find('.image-preview').html('<img class="img-thumbnail" src="'+file_url+'">'+remove_btn);
					// $('#'+elementId).parent().find('input').val(file_url.replace(/^.*\/\/[^\/]+/, ''));
					$('#'+elementId).parent().find('input').val(file_url);
				} );

				finder.on( 'file:choose:resizedImage', function( evt ) {
					var file_url = evt.data.resizedUrl;
					file_url = url_port( file_url );
					$('#'+elementId).parent().find('.image-preview').html('');
					$('#'+elementId).parent().find('input').val('');
					$('#'+elementId).parent().find('.image-preview').html('<img class="img-thumbnail" src="'+file_url+'">'+remove_btn);
					// $('#'+elementId).parent().find('input').val(file_url.replace(/^.*\/\/[^\/]+/, ''));
					$('#'+elementId).parent().find('input').val(file_url);
				} );
			}
		} );
	})

	// remove selected image
	$(document).on('click','.btn-wysiwyg-remove',function() {
		$(this).parent().parent().find('input').val('');
		$(this).parent().html('No image selected');
	})

	// check port in host
	function url_port( url ) {
		if( app_env == 'local' ) {
			url = url.replace("/public","");
		}
		var new_url = new URL(url);
		new_url.port = location.port;
		return new_url;
	}

});

$(window).on('load', function() {
	$('.btn-outline-primary, .btn-outline-secondary, .btn-outline-success, .btn-outline-info, .btn-outline-warning, .btn-outline-danger, .btn-outline-dark, .btn-outline-light, .btn-outline-default').removeClass('waves-light');
	$('.mdb-select').materialSelect();
})
