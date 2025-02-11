jQuery(function ($) {
    var wc_multistore_bulk_sync = {
        bulk_sync_id : false,
        product_sync_id : false,
        current_bulk_sync : false,
        current_product_sync : false,
        current_get_product : false,
        skipped : false,
        init: function () {
            this.toggle_advanced_query();
            this.toggle_advanced_product_settings();
            this.enable_select2();
            this.toggle_child_sites();
            this.form_submit();
            this.enable_tips();
        },
        toggle_advanced_query:function (){
            $('.select-all-products').on('change', function () {
                if ($('.select-all-products').is(':checked')) {
                    $('.wc-multistore-bulk-sync-advanced-container').removeClass('open');
                } else {
                    $('.wc-multistore-bulk-sync-advanced-container').addClass('open');
                }
            });
        },
        toggle_advanced_product_settings:function (){
            $('.use-product-settings').on('change', function () {
                if ($('.use-product-settings').is(':checked')) {
                    $('.wc-multistore-bulk-sync-advanced-product-settings-container').removeClass('open');
                } else {
                    $('.wc-multistore-bulk-sync-advanced-product-settings-container').addClass('open');
                }
            });
        },
        toggle_child_sites:function (){
            $(document).on("click", '.woonet-checkbox-list .select-all', function (e) {
                var checks = $(this).parents('.woonet-checkbox-list').find(':checkbox').filter(':not(:disabled)');
                checks.prop('checked', $(this).is(':checked') ? 'checked' : '');
            });
        },
        enable_select2:function (){
            $('.wc-multistore-select2').select2({
                multiple: true,
                theme: "classic"
            });
        },
        enable_tips:function (){
            $( '.tips' ).tipTip( {'attribute': 'data-tip','fadeIn': 50,'fadeOut': 50,'delay': 200} );
        },
        display_cancel_button:function (bulk_sync_id){
            $('#bulk-sync-cancel-button').attr('data-bulk_sync_id', bulk_sync_id);
            $('#bulk-sync-cancel-button').css('visibility', 'visible');
        },
        hide_cancel_button:function (){
            $('#bulk-sync-cancel-button').css('visibility', 'hidden');
        },
        disable_cancel_button:function (){
            $('#bulk-sync-cancel-button').prop("disabled", true);
        },
        display_sync_button:function (){
            $("#bulk-sync-button").prop("disabled", false);
        },
        hide_sync_button:function (){
            $("#bulk-sync-button").prop("disabled", true);
        },
        show_bulk_sync_progress:function (total_products){
            $(".wc-multistore-bulk-sync-progress-container .finished").attr("data-finished", 0);
            $(".wc-multistore-bulk-sync-progress-container .finished").html('Synced 0');
            $(".wc-multistore-bulk-sync-progress-container .total").attr("data-total", total_products);
            $(".wc-multistore-bulk-sync-progress-container .total").html(' out of ' + total_products);
            $(".wc-multistore-bulk-sync-progress-container .wc-multistore-bulk-sync-progress-bar").progressbar({ value:  0 });
        },
        update_bulk_sync_progress:function (result){
            let total_products = $(".wc-multistore-bulk-sync-progress-container .total").attr('data-total');
            let finished_products = $(".wc-multistore-bulk-sync-progress-container .finished").attr('data-finished');
            finished_products = parseInt(finished_products,10) + 1;
            total_finished_products = finished_products;
            total_products = parseInt(total_products,10);

            if (wc_multistore_bulk_sync.skipped !== 'false'){
                total_finished_products = wc_multistore_bulk_sync.skipped + finished_products;
            }

            let percentage = (total_finished_products / total_products) * 100;

            $(".wc-multistore-bulk-sync-progress-container .wc-multistore-bulk-sync-progress-bar").progressbar({ value:  percentage });

            if (result == 'success'){
                $(".wc-multistore-bulk-sync-progress-container .finished").attr("data-finished", finished_products);
                $(".wc-multistore-bulk-sync-progress-container .finished").html( 'Synced ' + finished_products);
            }

            if (result == 'skipped'){
                if (wc_multistore_bulk_sync.skipped !== false){
                    $(".wc-multistore-bulk-sync-progress-container .skipped").html( 'Skipped ' + wc_multistore_bulk_sync.skipped );
                }
            }
            $('.wc-multistore-bulk-sync-container').scrollTop($('.wc-multistore-bulk-sync-container')[0].scrollHeight);
        },
        update_product_sync_progress:function (result){
            $('#wc-multistore-ajax-sync-product-container-'+result.product_id).find('.wc-multistore-ajax-sync-progress-bar').progressbar({
                value:  result.percentage
            });
            $('.wc-multistore-bulk-sync-container').scrollTop($('.wc-multistore-bulk-sync-container')[0].scrollHeight);
        },
        handle_product_sync_errors:function (product_id,result){
            if( result !== null && result !== undefined && product_id !== undefined ){
                if (result.status === 'failed'){
                    $('#wc-multistore-ajax-sync-product-container-'+product_id+' .right' ).append('<p class="notice-error">' + result.message + '</p>');
                }

                if( result.data !== null && result.data !== undefined && result.data.variation_errors !== null && result.data.variation_errors !== undefined ){
                    for ( i = 0; i < result.data.variation_errors.length; i++ ){
                        $( "#wc-multistore-ajax-sync-product-container-"+ product_id+' .right' ).append('<p class="notice-error">Variation: ' + result.data.variation_errors[i].message + '</p>');
                    }
                }
            }
        },
        display_product_sync_result:function (product_id,result){
            if( result !== null && result !== undefined && product_id !== undefined ){
                if ( result.status === 'success' ){
                    if( result.data !== null && result.data !== undefined && result.data.edit_link !== null && result.data.edit_link !== undefined ){
                        let site_without_https = result.data.edit_link.replace("https://", "");
                        let site_without_http = site_without_https.replace("http://", "");
                        let split_site = site_without_https.split("/wp-admin");
                        let site = split_site[0];
                        $('#wc-multistore-ajax-sync-product-container-'+product_id+' .right' ).append('<p>'+site+' <a target="_blank" href="'+result.data.edit_link+'" >edit</a></p');
                    }
                }
            }
        },
        start_new_bulk_sync:function (){
            $('#bulk-sync-start-new-button').css('visibility', 'visible');
            $('#bulk-sync-start-new-button').on('click', function (){
                window.location.href = $('#bulk-sync-start-new-button').attr('data-attr');
            });
        },
        display_complete_msg:function (){
            $('.wc-multistore-bulk-sync-progress .status').text( 'Complete ');
        },
        display_canceled_msg:function (){
            $('.wc-multistore-bulk-sync-progress .status').text( 'Canceled ');
        },
        form_submit:function (){
            $('#bulk-sync-form').submit(function (e) {
                wc_multistore_bulk_sync.clear_form_errors();
                e.preventDefault();
                if(!wc_multistore_bulk_sync.confirm_form_submit()){return;}
                let serialized_form_data = $('#bulk-sync-form').serialize();
                wc_multistore_bulk_sync.set_bulk_sync_params(serialized_form_data);
            });
        },
        confirm_form_submit:function () {
            if (!confirm("The sync may take a long time depending on the number of produts. Do you really want to begin the sync?")) {
                return false;
            }
            return true;
        },
        set_bulk_sync_id:function (bulk_sync_id) {
            $('#bulk-sync-form').attr('data-bulk_sync_id', bulk_sync_id);
            wc_multistore_bulk_sync.bulk_sync_id = bulk_sync_id;
        },
        set_product_sync_id:function (product_sync_id) {
            $('#bulk-sync-form').attr('data-product_sync_id', product_sync_id);
            wc_multistore_bulk_sync.product_sync_id = product_sync_id;
        },
        clear_form_errors:function () {
            $('.wc-multistore-bulk-sync-form-error-container').empty();
        },
        set_bulk_sync_params:function (serialized_form_data) {
            $('.wc-multistore-bulk-sync-actions-container .spinner').css('visibility','visible');
            var nonce = $('#wc-multistore-bulk-sync-nonce').val();
            $.post(ajaxurl, {action: "wc_multistore_set_bulk_sync_params",data: serialized_form_data,nonce}, function(data){
                data = JSON.parse(data);

                if (data.status === 'skipped') {
                    $('.wc-multistore-bulk-sync-form-error-container').append('<div class="notice notice-warning"><p>'+data.message+'</p></div>');
                }

                if (data.status === 'failed') {
                    $('.wc-multistore-bulk-sync-actions-container .spinner').css('visibility','hidden');
                    $('.wc-multistore-bulk-sync-form-error-container').append('<div class="notice notice-error"><p>Sync could not start: '+data.message+'</p></div>');
                }

                if (data.status === 'success'){
                    let bulk_sync_id = data.id;
                    let total_products = data.total_products;

                    wc_multistore_bulk_sync.set_bulk_sync_id(bulk_sync_id);
                    wc_multistore_bulk_sync.display_cancel_button(bulk_sync_id);
                    wc_multistore_bulk_sync.cancel_bulk_sync();
                    wc_multistore_bulk_sync.hide_sync_button();
                    wc_multistore_bulk_sync.show_bulk_sync_progress(total_products);
                    wc_multistore_bulk_sync.get_next_product(bulk_sync_id);
                }

            }).fail(function(error) {
                if (error.statusText !== 'abort') {
                    $('.wc-multistore-bulk-sync-actions-container .spinner').css('visibility','hidden');
                    $('.wc-multistore-bulk-sync-form-error-container').append('<div class="notice notice-error"><p>Sync could not start: '+error.statusText+' - '+ error.status +'</p></div>');
                }
            });
        },
        cancel_bulk_sync:function (){
            $('#bulk-sync-cancel-button').on('click', function () {
                if (confirm("Do you really want to cancel sync?")) {
                    var product_sync_id = wc_multistore_bulk_sync.product_sync_id;
                    var product_sync_nonce = $('#wc-multistore-product-sync-nonce').val();
                    wc_multistore_bulk_sync.cancel_product_sync(product_sync_id,product_sync_nonce); // cancels current product sync

                    // var bulk_sync_id = $('#bulk-sync-cancel-button').data('bulk_sync_id');
                    var bulk_sync_id = wc_multistore_bulk_sync.bulk_sync_id;
                    var nonce = $('#wc-multistore-bulk-sync-nonce').val();
                    $.post(ajaxurl, {
                        action: 'wc_multistore_cancel_bulk_sync',
                        bulk_sync_id:  bulk_sync_id,
                        nonce:nonce,
                    }, function(response) {
                        $('.wc-multistore-bulk-sync-actions-container .spinner').css('visibility','hidden');
                        wc_multistore_bulk_sync.display_canceled_msg();
                        wc_multistore_bulk_sync.disable_cancel_button();
                        wc_multistore_bulk_sync.start_new_bulk_sync();
                    });
                }
            });
        },
        get_next_product:function (bulk_sync_id) {
            var nonce = $('#wc-multistore-bulk-sync-nonce').val();
            wc_multistore_bulk_sync.current_get_product = $.post(ajaxurl, {action: "wc_multistore_get_next_bulk_sync_product",bulk_sync_id: bulk_sync_id,nonce:nonce}, function(data){
                data = JSON.parse(data);
                let product_id = data.product_id;
                let product_name = data.product_name;
                let product_img = data.product_img;
                let bulk_sync_id =  data.bulk_sync_id;

                if (data.status === 'complete') {
                    $('.wc-multistore-bulk-sync-actions-container .spinner').css('visibility','hidden');
                    wc_multistore_bulk_sync.disable_cancel_button();
                    wc_multistore_bulk_sync.display_complete_msg();
                    wc_multistore_bulk_sync.start_new_bulk_sync();
                }

                if (data.status === 'success'){
                    wc_multistore_bulk_sync.append_product_container(product_id, product_name,product_img);
                    wc_multistore_bulk_sync.sync_product(product_id, 0,data.sites_ids);
                }

                if (data.status === 'skipped'){
                    let message = data.message;
                    wc_multistore_bulk_sync.append_skipped_product_container(product_id, product_name,product_img,message);
                    wc_multistore_bulk_sync.update_bulk_sync_progress('skipped');
                    wc_multistore_bulk_sync.get_next_product(bulk_sync_id);
                }

                if (data.status === 'failed'){
                    $('.wc-multistore-bulk-sync-actions-container .spinner').css('visibility','hidden');
                    $('.wc-multistore-bulk-sync-form-error-container').append('<div class="notice notice-error"><p>Sync stopped: '+data.message+'</p></div>');
                }
            }).fail(function(error) {
                if (error.statusText !== 'abort') {
                    $('.wc-multistore-bulk-sync-actions-container .spinner').css('visibility','hidden');
                    $('.wc-multistore-bulk-sync-form-error-container').append('<div class="notice notice-error"><p>Sync stopped: '+error.statusText+' - '+ error.status +'</p></div>');
                }
            });
        },
        sync_product:function (id,product_sync_id,sites_ids = false) {
            var nonce = $('#wc-multistore-product-sync-nonce').val();
            var ajx_url = ajaxurl + '?' + Math.random().toString(16).slice(2);

             wc_multistore_bulk_sync.current_product_sync = $.post(ajx_url, { action: "wc_multistore_product_sync", id:id, product_sync_id:product_sync_id, sites_ids:sites_ids, nonce:nonce }, function(data){
                data = JSON.parse(data);

                let product_id = data.product_id;
                let status = data.status;
                let product_sync_id = data.product_sync_id;
                let progress = data.progress;
                let bulk_sync_id = $('#bulk-sync-form').data('bulk_sync_id');
                wc_multistore_bulk_sync.set_product_sync_id(product_sync_id);

                if (status === 'pending') {
                    wc_multistore_bulk_sync.handle_product_sync_errors(product_id,data.result);
                    wc_multistore_bulk_sync.display_product_sync_result(product_id,data.result);
                    wc_multistore_bulk_sync.update_product_sync_progress(data);
                    wc_multistore_bulk_sync.sync_product(product_id,product_sync_id);
                }

                if (status === 'complete'){
                    wc_multistore_bulk_sync.handle_product_sync_errors(product_id,data.result);
                    wc_multistore_bulk_sync.display_product_sync_result(product_id,data.result);
                    wc_multistore_bulk_sync.update_product_sync_progress(data);
                    wc_multistore_bulk_sync.update_bulk_sync_progress('success');
                    wc_multistore_bulk_sync.get_next_product(bulk_sync_id);
                }

                if (status === 'failed') {
                    $('.wc-multistore-bulk-sync-actions-container .spinner').css('visibility','hidden');
                    $('.wc-multistore-bulk-sync-form-error-container').append('<div class="notice notice-error"><p>Sync stopped: '+data.message+'</p></div>');
                }
            }).fail(function(error) {
                if (error.statusText !== 'abort') {
                    $('.wc-multistore-bulk-sync-actions-container .spinner').css('visibility','hidden');
                    $('.wc-multistore-bulk-sync-form-error-container').append('<div class="notice notice-error"><p>Sync stopped: '+error.statusText+' - '+ error.status +'</p></div>');
                }
            });
        },
        cancel_product_sync:function ( product_sync_id, nonce ){
            if (wc_multistore_bulk_sync.current_get_product !== false){
                wc_multistore_bulk_sync.current_get_product.abort();
            }
            if (wc_multistore_bulk_sync.current_product_sync !== false){
                wc_multistore_bulk_sync.current_product_sync.abort();
            }

            $.post(ajaxurl, {
                action: 'wc_multistore_cancel_product_sync',
                product_sync_id:  product_sync_id,
                nonce:nonce,
            }, function(response) {
                wc_multistore_bulk_sync.disable_cancel_button();
                wc_multistore_bulk_sync.start_new_bulk_sync();
            });
        },
        append_product_container:function (product_id, product_name,product_img) {
            let product_container = '<div class="wc-multistore-ajax-sync-product-container" id="wc-multistore-ajax-sync-product-container-'+product_id+'" data-product_id='+product_id+'>';
                product_container += '<div class="left"><span class="product-name">'+product_name+'</span><img crossorigin="product-image" src="'+product_img+'" alt=""><span class="wc-multistore-ajax-sync-progress-bar"></span></div>';
                product_container += '<div class="right"></div>';
                product_container += '</div>';

            // add element
            $('.wc-multistore-product-sync-container').append(product_container);
            $('#wc-multistore-ajax-sync-product-container-'+product_id).find('.wc-multistore-ajax-sync-progress-bar').progressbar({
                value:  0
            });
        },
        append_skipped_product_container:function (product_id, product_name,product_img,message) {
            if (wc_multistore_bulk_sync.skipped === false){
                wc_multistore_bulk_sync.skipped = 1;
            }else{
                wc_multistore_bulk_sync.skipped = wc_multistore_bulk_sync.skipped + 1;
            }

            let product_container = '<div class="wc-multistore-ajax-sync-product-container skipped" id="wc-multistore-ajax-sync-product-container-'+product_id+'" data-product_id='+product_id+'>';
                product_container += '<div class="left"><span class="product-name">'+product_name+'</span><img crossorigin="product-image" src="'+product_img+'" alt=""><span class="wc-multistore-ajax-sync-progress-bar"></span></div>';
                product_container += '<div class="right">Skipped: '+message+'</div>';
                product_container += '</div>';

            // add element
            $('.wc-multistore-product-sync-container').append(product_container);
            $('#wc-multistore-ajax-sync-product-container-'+product_id).find('.wc-multistore-ajax-sync-progress-bar').progressbar({
                value:  100
            });
        }
    };

    $(document).ready(function () {
        wc_multistore_bulk_sync.init();
    });
});