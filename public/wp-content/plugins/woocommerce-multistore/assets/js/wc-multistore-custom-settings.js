jQuery( function( $ ) {

    var wc_multistore_custom_settings = {
        init: function() {
            $('#form_data').submit(function (e){
                e.preventDefault();
                var settings = $('#form_data').serialize();
                var nonce = $('#_mstore_form_submit_taxonomies_nonce').val();
                $(".wc-multistore-custom-settings-notices").empty();
                $(".spinner").addClass("is-active");
                $(".submit input").addClass("disabled");

                $.ajax({
                    type:		'POST',
                    url:		wc_multistore_ajax.ajax_url,
                    data:		{
                        action : 'wc_multistore_save_master_custom_data_settings',
                        settings : settings,
                        nonce : nonce,
                    },
                    dataType:   'json',
                    success:	function( result ) {
                        if (result.status === 'failed'){
                            $(".wc-multistore-custom-settings-notices").append('<div class="notice notice-error"><p>'+result.message+'</p></div>');
                        }

                        if (result.status === 'success'){
                            $(".wc-multistore-custom-settings-notices").append('<div class="notice notice-success"><p>'+result.message+'</p></div>');
                        }

                        $(".spinner").removeClass("is-active");
                        $(".submit input").removeClass("disabled");
                    },
                    error:	function( jqXHR, textStatus, errorThrown ) {
                        $(".wc-multistore-custom-settings-notices").append('<div class="notice notice-error"><p>'+textStatus + errorThrown+ jqXHR+'</p></div>');
                        $(".spinner").removeClass("is-active");
                        $(".submit input").removeClass("disabled");
                    }
                });
            });


        }
    };

    $(document).ready(function(){
        wc_multistore_custom_settings.init();
    });

});