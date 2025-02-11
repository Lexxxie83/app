jQuery( function( $ ) {

	var wc_multistore_settings = {
		init: function() {
			$('#form_data').submit(function (e){
				e.preventDefault();
				var settings = $('#form_data').serialize();
				var nonce = $('#mstore_form_nonce').val();
				$(".wc-multistore-settings-notices").empty();
				$(".spinner").addClass("is-active");
				$(".submit input").addClass("disabled");

				$.ajax({
					type:		'POST',
					url:		wc_multistore_ajax.ajax_url,
					data:		{
						action : 'wc_multistore_save_master_settings',
						settings : settings,
						nonce : nonce,
					},
					dataType:   'json',
					success:	function( result ) {
						if (result.status === 'failed'){
							$(".wc-multistore-settings-notices").append('<div class="notice notice-error"><p>'+result.message+'</p></div>');
						}
						if (result.messages){
							result.messages.forEach(function (message,index){
								$(".wc-multistore-settings-notices").append('<div class="notice notice-success"><p>'+message+'</p></div>');
							});
						}

						$(".spinner").removeClass("is-active");
						$(".submit input").removeClass("disabled");
					},
					error:	function( jqXHR, textStatus, errorThrown ) {
						// if (result.messages){
						// 	result.messages.forEach(function (message,index){
								$(".wc-multistore-settings-notices").append('<div class="notice notice-error"><p>'+textStatus+'</p></div>');
							// });
						// }
						$(".spinner").removeClass("is-active");
						$(".submit input").removeClass("disabled");
					}
				});
			});

			// images
			$('.wc-multistore-image-settings-switch').change(function() {
				if( this.value === 'yes' || $(this).parents('table').find('.wc-multistore-image-settings-update-switch').val() === 'yes'){
					$(this).parents('table').find('.wc-multistore-image-settings-row').removeClass('hidden');
					$(this).parents('table').find('.wc-multistore-image-settings').removeClass('hidden');
					$(this).parents('table').find('.wc-multistore-image-settings-update').removeClass('hidden');
				}else{
					$(this).parents('table').find('.wc-multistore-image-settings-row').addClass('hidden');
					$(this).parents('table').find('.wc-multistore-image-settings').addClass('hidden');
					$(this).parents('table').find('.wc-multistore-image-settings-update').addClass('hidden');
				}
			});
			// images update
			$('.wc-multistore-image-settings-update-switch').change(function() {
				if( this.value === 'yes' || $(this).parents('table').find('.wc-multistore-image-settings-switch').val() === 'yes'){
					$(this).parents('table').find('.wc-multistore-image-settings-row').removeClass('hidden');
					$(this).parents('table').find('.wc-multistore-image-settings').removeClass('hidden');
					$(this).parents('table').find('.wc-multistore-image-settings-update').removeClass('hidden');
				}else{
					$(this).parents('table').find('.wc-multistore-image-settings-row').addClass('hidden');
					$(this).parents('table').find('.wc-multistore-image-settings').addClass('hidden');
					$(this).parents('table').find('.wc-multistore-image-settings-update').addClass('hidden');
				}
			});

			// attributes
			$('.wc-multistore-attributes-settings-switch').change(function() {
				if( this.value === 'yes' || $(this).parents('table').find('.wc-multistore-attributes-settings-update-switch').val() === 'yes'){
					$(this).parents('table').find('.wc-multistore-attributes-settings-row').removeClass('hidden');
					$(this).parents('table').find('.wc-multistore-attributes-settings').removeClass('hidden');
					$(this).parents('table').find('.wc-multistore-attributes-settings-update').removeClass('hidden');
				}else{
					$(this).parents('table').find('.wc-multistore-attributes-settings-row').addClass('hidden');
					$(this).parents('table').find('.wc-multistore-attributes-settings-update').addClass('hidden');
					$(this).parents('table').find('.wc-multistore-attributes-settings').addClass('hidden');

				}
			});
			// attributes update
			$('.wc-multistore-attributes-settings-update-switch').change(function() {
				if( this.value === 'yes' || $(this).parents('table').find('.wc-multistore-attributes-settings-switch').val() === 'yes'){
					$(this).parents('table').find('.wc-multistore-attributes-settings-row').removeClass('hidden');
					$(this).parents('table').find('.wc-multistore-attributes-settings').removeClass('hidden');
					$(this).parents('table').find('.wc-multistore-attributes-settings-update').removeClass('hidden');
				}else{
					$(this).parents('table').find('.wc-multistore-attributes-settings-row').addClass('hidden');
					$(this).parents('table').find('.wc-multistore-attributes-settings-update').addClass('hidden');
					$(this).parents('table').find('.wc-multistore-attributes-settings').addClass('hidden');
				}
			});

			// variations
			$('.wc-multistore-variations-settings-switch').change(function() {
				if( this.value === 'yes' || $(this).parents('table').find('.wc-multistore-variations-settings-update-switch').val() === 'yes'){
					$(this).parents('table').find('.wc-multistore-variations-settings-row').removeClass('hidden');
					$(this).parents('table').find('.wc-multistore-variations-settings').removeClass('hidden');
					$(this).parents('table').find('.wc-multistore-variations-settings-update').removeClass('hidden');
				}else{
					$(this).parents('table').find('.wc-multistore-variations-settings-row').addClass('hidden');
					$(this).parents('table').find('.wc-multistore-variations-settings').addClass('hidden');
					$(this).parents('table').find('.wc-multistore-variations-settings-update').addClass('hidden');
				}
			});
			// variations update
			$('.wc-multistore-variations-settings-update-switch').change(function() {
				if( this.value === 'yes' || $(this).parents('table').find('.wc-multistore-variations-settings-switch').val() === 'yes'){
					$(this).parents('table').find('.wc-multistore-variations-settings-row').removeClass('hidden');
					$(this).parents('table').find('.wc-multistore-variations-settings').removeClass('hidden');
					$(this).parents('table').find('.wc-multistore-variations-settings-update').removeClass('hidden');
				}else{
					$(this).parents('table').find('.wc-multistore-variations-settings-row').addClass('hidden');
					$(this).parents('table').find('.wc-multistore-variations-settings').addClass('hidden');
					$(this).parents('table').find('.wc-multistore-variations-settings-update').addClass('hidden');
				}
			});

			// categories
			$('.wc-multistore-categories-settings-switch').change(function() {
				if( this.value === 'yes' || $(this).parents('table').find('.wc-multistore-categories-settings-update-switch').val() === 'yes'){
					$(this).parents('table').find('.wc-multistore-categories-settings-row').removeClass('hidden');
					$(this).parents('table').find('.wc-multistore-categories-settings').removeClass('hidden');
					$(this).parents('table').find('.wc-multistore-categories-settings-update').removeClass('hidden');
				}else{
					$(this).parents('table').find('.wc-multistore-categories-settings-row').addClass('hidden');
					$(this).parents('table').find('.wc-multistore-categories-settings').addClass('hidden');
					$(this).parents('table').find('.wc-multistore-categories-settings-update').addClass('hidden');
				}
			});

			// categories update
			$('.wc-multistore-categories-settings-update-switch').change(function() {
				if( this.value === 'yes' || $(this).parents('table').find('.wc-multistore-categories-settings-switch').val() === 'yes'){
					$(this).parents('table').find('.wc-multistore-categories-settings-row').removeClass('hidden');
					$(this).parents('table').find('.wc-multistore-categories-settings').removeClass('hidden');
					$(this).parents('table').find('.wc-multistore-categories-settings-update').removeClass('hidden');
				}else{
					$(this).parents('table').find('.wc-multistore-categories-settings-row').addClass('hidden');
					$(this).parents('table').find('.wc-multistore-categories-settings').addClass('hidden');
					$(this).parents('table').find('.wc-multistore-categories-settings-update').addClass('hidden');
				}
			});

			// product status change
			$('.wc-multistore-product-status-settings-switch').change(function() {
				if( this.value === 'yes'){
					$(this).parents('table').find('.wc-multistore-default-product-status-row').addClass('hidden');
				}else{
					$(this).parents('table').find('.wc-multistore-default-product-status-row').removeClass('hidden');
				}
			});

			$('.woomulti_option_with_warning').change(function() {
				if ( this.value == 'yes' ) {
					$('.woomulti_options_warning', $(this).parent().parent()).show();
				} else {
					$('.woomulti_options_warning', $(this).parent().parent()).hide();
				}
			});

			if ( $('.row-order-import-to').attr( 'data-option-visible') == 'yes' ) {
				$('.row-order-import-to').show();
			} else {
				$('.row-order-import-to').hide();
			}

			$( "select[name=enable-order-import]" ).on( 'change', function(){
				if ( this.value == 'yes' ) {
					$('.row-order-import-to').show();
				} else {
					$('.row-order-import-to').hide();
				}
			});

			$("select[name=enable-order-import]").change(function() {
				if ( this.value === 'yes' ) {
					$('#clone-products-during-import-order').removeAttr('disabled');
				} else {
					$('#clone-products-during-import-order').attr('disabled', true);
				}
			});

			if ( $('.row-global-image-master').attr( 'data-option-visible') == 'yes' ) {
				$('.row-global-image-master').show();
			} else {
				$('.row-global-image-master').hide();
			}

			$( "select[name=enable-global-image]" ).on( 'change', function(){
				if ( this.value == 'yes' ) {
					$('.row-global-image-master').show();
				} else {
					$('.row-global-image-master').hide();
				}
			});

			$("#synchronize-by-default").change(function() {
				if ( this.value === 'yes' ) {
					$('#inherit-by-default').removeAttr('disabled');
				} else {
					$('#inherit-by-default').attr('disabled', true);
				}
			});

			$("#synchronize-rest-by-default").change(function() {
				if ( this.value == 'yes' ) {
					$('#inherit-rest-by-default').removeAttr('disabled');
				} else {
					$('#inherit-rest-by-default').attr('disabled', true);
				}
			});
		},
		maybe_display_import_to: function(){
			if ( $('.row-order-import-to').attr('data-option-visible') == 'yes' ) {
				$('.row-order-import-to').css('display', 'block !important');
			}
		},
		maybe_display_global_image_master: function(){
			if ( $('.row-global-image-master').attr('data-option-visible') == 'yes' ) {
				$('.row-order-import-to').css('display', 'block !important');
			}
		},
		enable_tips: function(){
			$( '.tips' ).tipTip( {'attribute': 'data-tip','fadeIn': 50,'fadeOut': 50,'delay': 200} );
		},
		sort_tabs: function(){
			var tabs = $( "#fields-control" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
			$( "#fields-control li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
			tabs.find( ".ui-tabs-nav" ).sortable({
				axis: "y",
				stop: function() {
					tabs.tabs( "refresh" );
				}
			});
		},
	};

	$(document).ready(function(){
		wc_multistore_settings.init();
		wc_multistore_settings.maybe_display_import_to();
		wc_multistore_settings.maybe_display_global_image_master();
		wc_multistore_settings.enable_tips();
		wc_multistore_settings.sort_tabs();
	});

});