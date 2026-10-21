(function ($) {

    window.RTMegaMenuAdmin = {

        init: function () {
            this.renderMenuOptions();
            this.adminSettingsTabs();
            $(document)
                .on('click.RTMegaMenuAdmin', '.save-rtmega-menu', this.saveMenuOptions)
                .on('click.RTMegaMenuAdmin', '.rtmega-menu-opener', this.openMegaMenuModal)
                .on('click.RTMegaMenuAdmin', '.rtmega-menu-modal-closer', this.closeMegaMenuModal)
                .on('click.RTMegaMenuAdmin', '.save-rt-menu-item-options', this.updateRtmegaMenuItemSettings)
                .on('click.RTMegaMenuAdmin', '.delete-rt-menu-item-options', this.deleteRtmegaMenuItemSettings)
                .on('click.RTMegaMenuAdmin', '.rtmega_pro_warning_img', this.alertForLicenseActive)
                .on('click.RTMegaMenuAdmin', '.rtmega_set_icon_toggle_in_nav_item_free', this.alertForLicenseActive)
                .on('click.RTMegaMenuAdmin', '.rtmega-set-visibility-conditions-free', this.alertForLicenseActive)
                .on('click.RTMegaMenuAdmin', '.rtmega-notice .notice-dismiss', this.ignorePluginNotice)
                .on('change.RTMegaMenuAdmin', '#rtmega-template-source-select', this.templateSourceChange)
                .on('click.RTMegaMenuAdmin', '#add-remega-template, #rtmega-create-new-template', this.createNewTemplate)
                .on('change.RTMegaMenuAdmin', '#rtmega-template-select', this.templateChange)
                ;
        },
        renderMenuOptions: function () {
            if ($('#nav-menus-frame').length > 0) {
                var isChecked = rtmegamenu_ajax.rtmega_menu_options_switch == 'on' ? 'checked' : '';
                var isCheckedVal = rtmegamenu_ajax.rtmega_menu_options_switch == 'on' ? 'on' : '';

                var switchHTML = `
                <div class="rtmega-menu-switch-wrapper">
                    <div class="ajax-loader">
                        <img src="${rtmegamenu_ajax.ajaxLoaderUrl}" alt="Ajax Loader">
                    </div>
                    <label class="menu-item-title">
                        <input 
                        type="checkbox" 
                        class="menu-item-checkbox rt_mega_menu_switch" 
                        name="rt_mega_menu_switch" 
                        value="${isCheckedVal}" ${isChecked}>
                            Enable RT Mega Menu
                    </label>
                    <p><input type="submit" class="button button-primary button-large save-rtmega-menu" value="Save"></p>
                </div>`;

                $('#nav-menus-frame').prepend(switchHTML);

                if (rtmegamenu_ajax.rtmega_menu_options_switch == 'on') {
                    $('#menu-to-edit li').each(function () {
                        let menuItemId = $(this).find('.menu-item-checkbox').attr('data-menu-item-id');
                        $(this).addClass('has-rt-mega-menu');
                        $(this).find('label.item-title').append('<span class="rtmega-menu-opener" data-menu_item_id="' + menuItemId + '"><span class="dashicons dashicons-welcome-widgets-menus"></span>RT Mega Menu</span>');

                        let rtMegaMenuOpener = $(this).find('.rtmega-menu-opener');
                        if (rtmegamenu_ajax.rtmega_active_menu_items.indexOf(menuItemId) !== -1 || rtmegamenu_ajax.rtmega_active_menu_items.indexOf(parseInt(menuItemId)) !== -1) {
                            $(rtMegaMenuOpener).addClass('has-mega-menu');
                        }
                    });
                }
            }
        },
        alertForLicenseActive: function () {
            alert(rtmegamenu_ajax.rtmega_pro_warning_msg);
        },
        adminSettingsTabs: function () {
            // Show the first tab and hide the rest
            $('div#rtmega-menu-setting-modal #tabs-nav li:first-child').addClass('active');
            $('div#rtmega-menu-setting-modal .tab-content').hide();
            $('div#rtmega-menu-setting-modal .tab-content:first').show();

            // Click function
            $('div#rtmega-menu-setting-modal #tabs-nav li').click(function () {
                $('div#rtmega-menu-setting-modal #tabs-nav li').removeClass('active');
                $(this).addClass('active');
                $('div#rtmega-menu-setting-modal .tab-content').hide();

                var activeTab = $(this).find('a').attr('href');
                $(activeTab).fadeIn();
                return false;
            });

            //Change Edit url when change template
            $(document).on('change', 'select#rtmega-template-select', function () {
                let templateSource = $('select#rtmega-template-source-select').val();
                let templateId = $(this).val();
                let newEditLink = '';
                if (templateSource == 'elementor') {
                    newEditLink = rtmegamenu_ajax.adminURL + 'post.php?post=' + templateId + '&action=elementor';
                } else {
                    newEditLink = rtmegamenu_ajax.adminURL + 'post.php?post=' + templateId + '&action=edit';
                }
                $('a#edit-remega-selected-template').attr('href', newEditLink);
            })
        },
        ignorePluginNotice: function (that) {

            let notice_id = $(this).parent().data('notice_id');

            $.ajax({
                type: 'POST',
                url: rtmegamenu_ajax.ajaxurl,
                data: {
                    action: "rtmega_ignore_plugin_notice",
                    notice_id: notice_id,
                    nonce: rtmegamenu_ajax.nonce,
                },
                cache: false,
            });
        },
        openMegaMenuModal: function (that, menuItemIdParam) {
            $('#rtmega-menu-setting-modal').css('display', 'flex');
            $('div#rtmega-menu-setting-modal #tabs-nav li').removeClass('active');
            $('div#rtmega-menu-setting-modal #tabs-nav li:first-child').addClass('active');
            let menuItemId = menuItemIdParam ? menuItemIdParam : $(this).attr('data-menu_item_id');
            console.log('menuItemId', menuItemId);

            $('.save-rt-menu-item-options').attr('data-menu_item_id', menuItemId);
            $('.delete-rt-menu-item-options').attr('data-menu_item_id', menuItemId);
            RTMegaMenuAdmin.showMegaMenuModalAjaxLoader($(this));
            RTMegaMenuAdmin.getMenuItemOptions(menuItemId);
        },
        closeMegaMenuModal: function () {
            $('#rtmega-menu-setting-modal').css('display', 'none');
        },
        showMegaMenuModalAjaxLoader: function () {
            $('#rtmega-menu-setting-modal .ajax-loader').css('display', 'flex');
        },
        hideMegaMenuModalAjaxLoader: function () {
            $('#rtmega-menu-setting-modal .ajax-loader').css('display', 'none');
        },
        deleteRtmegaMenuItemSettings: function (that) {
            RTMegaMenuAdmin.showMegaMenuModalAjaxLoader($(this));
            let menu_id = $("#nav-menu-meta-object-id").val();
            let menu_item_id = $(this).attr('data-menu_item_id');
            let status_form = $('#rtmega-menu-setting-modal .form-status');

            $.ajax({
                type: 'POST',
                url: rtmegamenu_ajax.ajaxurl,
                data: {
                    action: "rtmega_delete_menu_options",
                    menu_id: menu_id,
                    menu_item_id: menu_item_id,
                    nonce: rtmegamenu_ajax.nonce,
                },
                cache: false,
                success: function (response) {
                    if (response.success == true) {
                        $(status_form).html('<span class="rtmega-text-success">Settings Deleted!</span>');
                        setTimeout(() => {
                            $(status_form).html('');
                            location.reload();
                        }, 2000);
                        RTMegaMenuAdmin.hideMegaMenuModalAjaxLoader($(this));
                    }

                }
            });
        },
        getMenuItemOptions: function (menu_item_id, active_tab = 1) {

            $.ajax({
                type: 'POST',
                url: rtmegamenu_ajax.ajaxurl,
                data: {
                    action: "rtmega_get_menu_options",
                    menu_item_id: menu_item_id,
                    nonce: rtmegamenu_ajax.nonce,
                    active_tab,
                },
                cache: false,
                success: function (response) {
                    $('#rtmega-menu-setting-modal .tab-contents-wrapper').html(response);
                    RTMegaMenuAdmin.hideMegaMenuModalAjaxLoader($(this));
                }
            });
        },

        saveMenuOptions: function (that) {
            var spinner = $(this).parent().parent().find('.ajax-loader');
            spinner.addClass('show');


            let menu_id = $("#nav-menu-meta-object-id").val();

            var settings = {
                'enable_menu': $(".rt_mega_menu_switch").is(':checked') === true ? 'on' : 'off'
            };

            $.ajax({
                type: 'POST',
                url: rtmegamenu_ajax.ajaxurl,
                data: {
                    action: "rtmega_update_menu_options",
                    actualAction: 'saveMenuOptions',
                    settings: settings,
                    menu_id: menu_id,
                    nonce: rtmegamenu_ajax.nonce,
                },
                cache: false,
                success: function (response) {
                    location.reload();
                }
            });

        },

        updateRtmegaMenuItemSettings: function (that) {

            let footerAction = $(this).attr('data-action');
            RTMegaMenuAdmin.showMegaMenuModalAjaxLoader($(this));
            let menu_id = $("#nav-menu-meta-object-id").val();
            let menu_item_id = $(this).attr('data-menu_item_id');

            // let settings = $('#rtmega_menu_items_settings').serialize();
            // let css = $('#rtmega_menu_items_css').serialize();
            let status_form = $('#rtmega-menu-setting-modal .form-status');

            let css = {};
            let settings = {};


            // Iterate over each input in the form
            $('#rtmega_menu_items_settings').find('input, select').each(function () {
                // Exclude the submit button from the values
                if ($(this).attr('type') !== 'submit' && $(this).attr('name') !== 'search_rt_icon') {
                    settings[$(this).attr('name')] = $(this).val();
                }
            });

            // Iterate over each input in the form
            $('#rtmega_menu_items_css').find('input, select').each(function () {
                // Exclude the submit button from the values
                if ($(this).attr('type') !== 'submit') {
                    css[$(this).attr('name')] = $(this).val();
                }
            });

            var conditions = {};
            $('#rtmega_menu_items_conditions').find('input, select').each(function () {
                if ($(this).attr('type') === 'submit') return;
                var name = $(this).attr('name');
                if (!name) return;
                if ($(this).attr('type') === 'checkbox') {
                    conditions[name] = $(this).is(':checked') ? 'on' : 'off';
                } else if ($(this).is('select[multiple]')) {
                    var vals = $(this).val();
                    conditions[name] = vals && vals.length ? vals.join(',') : '';
                } else {
                    conditions[name] = $(this).val();
                }
            });

            let data = {
                action: "rtmega_update_menu_options",
                actualAction: 'saveMenuItemSettings',
                settings: settings,
                css: css,
                conditions: conditions,
                menu_id: menu_id,
                menu_item_id: menu_item_id,
                nonce: rtmegamenu_ajax.nonce,
            }

            $.ajax({
                type: 'POST',
                url: rtmegamenu_ajax.ajaxurl,
                data: data,
                cache: false,
                success: function (response) {

                    if (response.success == true) {
                        $(status_form).html('<span class="rtmega-text-success">Settings Saved!</span>');
                        setTimeout(() => {
                            $(status_form).html('');
                        }, 2000);
                        RTMegaMenuAdmin.hideMegaMenuModalAjaxLoader($(this));
                        if (footerAction == 'save-close') {
                            RTMegaMenuAdmin.closeMegaMenuModal();
                        }
                    }

                }
            });

        },
        templateSourceChange: function () {
            let template_source = $(this).val();
            let template_select = $('#rtmega-menu-setting-modal #rtmega-template-select');
            let menu_item_id = $('.save-rt-menu-item-options').attr('data-menu_item_id');
            $.ajax({
                type: 'POST',
                url: rtmegamenu_ajax.ajaxurl,
                data: {
                    action: "rtmega_get_templates_data_by_source",
                    template_source: template_source,
                    menu_item_id: menu_item_id,
                    nonce: rtmegamenu_ajax.nonce,
                },
                cache: false,
                success: function (response) {
                    console.log(response.data);

                    // update select options
                    let options = '<option value="">Select Template</option>';
                    let current_template_id = response.data.current_template_id;
                    $.each(response.data, function (index, value) {
                        if (value.id) {
                            options += '<option value="' + value.id + '" ' + (value.id == current_template_id ? 'selected' : '') + '>' + value.title + '</option>';
                        }
                    });
                    template_select.html(options);


                    if (response.data.add_new_link) {
                        $('.rtmega-template-not-found-message').show();
                        $('#rtmega-menu-setting-modal #edit-remega-selected-template').hide();
                        $('#rtmega-menu-setting-modal #add-remega-template').hide();
                        template_select.hide();
                        // update edit link
                        let add_new_link = response.data.add_new_link;
                        $('#rtmega-menu-setting-modal #rtmega-create-new-template').attr('href', add_new_link);
                    } else {
                        $('.rtmega-template-not-found-message').hide();
                        $('#rtmega-menu-setting-modal #add-remega-template').show();


                        // update edit link
                        let current_template_id = response.data.current_template_id;
                        if (current_template_id) {
                            let edit_link = response.data[0].edit_link;
                            $('#rtmega-menu-setting-modal #edit-remega-selected-template').attr('href', edit_link);
                            $('#rtmega-menu-setting-modal #edit-remega-selected-template').show();
                        }
                        template_select.show();
                    }


                    RTMegaMenuAdmin.hideMegaMenuModalAjaxLoader($(this));
                }
            });
        },
        templateChange: function (event) {
            // prevent default
            event.preventDefault();
            const template_select = $('#rtmega-menu-setting-modal #rtmega-template-select');

            // update edit link
            let template_id = template_select.val();
            if (template_id) {
                let edit_link = rtmegamenu_ajax.postEditUrl + template_id;
                $('#rtmega-menu-setting-modal #edit-remega-selected-template').attr('href', edit_link);
                $('#rtmega-menu-setting-modal #edit-remega-selected-template').show();
            } else {
                $('#rtmega-menu-setting-modal #edit-remega-selected-template').hide();
            }
        },
        createNewTemplate: function (event) {

            // prevent default
            event.preventDefault();

            const menu_item_id = $('.save-rt-menu-item-options').attr('data-menu_item_id');
            const template_source = $('#rtmega-template-source-select').val();
            const template_select = $('#rtmega-menu-setting-modal #rtmega-template-select');

            console.log('template_source', template_source);
            console.log('template_select', template_select);
            

            RTMegaMenuAdmin.showMegaMenuModalAjaxLoader($(this));

            $.ajax({
                type: 'POST',
                url: rtmegamenu_ajax.ajaxurl,
                data: {
                    action: "rtmega_create_new_template",
                    template_source: template_source,
                    menu_item_id: menu_item_id,
                    nonce: rtmegamenu_ajax.nonce,
                },
                cache: false,
                success: function (response) {
                    console.log(response.data);

                    // update template select
                    let options = '';
                    let new_template_id = response.data.id;

                    if (new_template_id) {
                        options += '<option value="' + new_template_id + '" ' + (new_template_id == new_template_id ? 'selected' : '') + '>' + response.data.title + '</option>';
                    }

                    template_select.append(options);

                    // hide create new button
                    $('.rtmega-template-not-found-message').hide();
                    $('#rtmega-menu-setting-modal #edit-remega-selected-template').show();
                    template_select.val(new_template_id);
                    template_select.show();
                    // update edit link
                    let edit_link = response.data.edit_link;
                    $('#rtmega-menu-setting-modal #edit-remega-selected-template').attr('href', edit_link);

                    RTMegaMenuAdmin.hideMegaMenuModalAjaxLoader($(this));
                }
            });


        }
    }

    RTMegaMenuAdmin.init();



})(jQuery);