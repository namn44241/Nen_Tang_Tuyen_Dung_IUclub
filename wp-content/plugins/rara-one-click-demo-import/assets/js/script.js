jQuery( function ( $ ) {

	$( '.js-rrdi-import-data' ).on( 'click', function () {
		// Reset response div content.
		$( '.js-rrdi-ajax-response' ).empty();

		// Prepare data for the AJAX call
		var data = new FormData();
		data.append( 'action', 'rrdi_import_demo_data' );
		data.append( 'security', rrdi.ajax_nonce );
		data.append( 'selected', $( '#RRDI__demo-import-files' ).val() );
		if ( $('#RRDI__content-file-upload').length ) {
			data.append( 'content_file', $('#RRDI__content-file-upload')[0].files[0] );
		}
		if ( $('#RRDI__widget-file-upload').length ) {
			data.append( 'widget_file', $('#RRDI__widget-file-upload')[0].files[0] );
		}
		if ( $('#RRDI__customizer-file-upload').length ) {
			data.append( 'customizer_file', $('#RRDI__customizer-file-upload')[0].files[0] );
		}

		// AJAX call to import everything (content, widgets, before/after setup)
		ajaxCall( data );

	});

	function ajaxCall( data ) {
		$.ajax({
			method:     'POST',
			url:        rrdi.ajax_url,
			data:       data,
			contentType: false,
			processData: false,
			beforeSend: function() {
				$( '.js-rrdi-ajax-loader' ).show();
			}
		})
		.done( function( response ) {

			if ( 'undefined' !== typeof response.status && 'newAJAX' === response.status ) {
				ajaxCall( data );
			}
			else if ( 'undefined' !== typeof response.message ) {
				$( '.js-rrdi-ajax-response' ).append( '<p>' + response.message + '</p>' );
				$( '.js-rrdi-ajax-loader' ).hide();
				$( '.js-rrdi-import-data' ).prop('disabled', true);
				$( 'a.demo-importer' ).hide();
				$( 'a.home-page-url' ).show();

			}
			else {
				$( '.js-rrdi-ajax-response' ).append( '<div class="notice  notice-error  is-dismissible"><p>' + response + '</p></div>' );
				$( '.js-rrdi-ajax-loader' ).hide();
				$( '.js-rrdi-import-data' ).prop('disabled', true);
				$( 'a.demo-importer' ).hide();
				$( 'a.home-page-url' ).show();
			}
		})
		.fail( function( error ) {
			$( '.js-rrdi-ajax-response' ).append( '<div class="notice  notice-error  is-dismissible"><p>Error: ' + error.statusText + ' (' + error.status + ')' + '</p></div>' );
			$( '.js-rrdi-ajax-loader' ).hide();
			$( '.js-rrdi-import-data' ).prop('disabled', true);
		});
	}

	// Switch preview images on select change event, but only if the img element .js-rrdi-preview-image exists.
	// Also switch the import notice (if it exists).
	$( '#RRDI__demo-import-files' ).on( 'change', function(){
		if ( $( '.js-rrdi-preview-image' ).length ) {

			// Attempt to change the image, else display message for missing image.
			var currentFilePreviewImage = rrdi.import_files[ this.value ]['import_preview_image_url'] || '';
			$( '.js-rrdi-preview-image' ).prop( 'src', currentFilePreviewImage );
			$( '.js-rrdi-preview-image-message' ).html( '' );

			if ( '' === currentFilePreviewImage ) {
				$( '.js-rrdi-preview-image-message' ).html( rrdi.texts.missing_preview_image );
			}
		}

		// Update import notice.
		var currentImportNotice = rrdi.import_files[ this.value ]['import_notice'] || '';
		$( '.js-rrdi-demo-import-notice' ).html( currentImportNotice );
	});

	$('.tabs-menu a').click(function(event) {
        event.preventDefault();
        $(this).parent().addClass('current');
        $(this).parent().siblings().removeClass('current');
        var tab = $(this).attr('href');
        $('.tab-content').not(tab).css('display', 'none');
        $('#'+tab).show();
    });

    var uploadViewToggle = $( '.upload-view-toggle' ),
			$body = $( document.body );
	uploadViewToggle.on( 'click', function() {
		// Toggle the upload view.
		$body.toggleClass( 'show-upload-view' );
		// Toggle the `aria-expanded` button attribute.
		uploadViewToggle.attr( 'aria-expanded', $body.hasClass( 'show-upload-view' ) );
	});
	if( $('.tabs-menu a').attr('href') != 'Demo_Import')
	{
		$('.upload-view-toggle').hide();
	}
	else{
		$('.upload-view-toggle').show();
	}
	$('.tabs-menu a').click(function(event) {
		if( $(this).attr('href') != 'Demo_Import')
		{
			$('.upload-view-toggle').hide();
		}
		else{
			$('.upload-view-toggle').show();
		}
	});

});
