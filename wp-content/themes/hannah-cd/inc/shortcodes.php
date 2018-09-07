<?php

/*****************************************************************/
/* REPLACE SHORTCODE p AND br */
/*****************************************************************/

if ( ! function_exists('hannah_cd_fix_shortcodes') ) :

    function hannah_cd_fix_shortcodes($content) {
        $array = array(
            '<p>[' => '[',
            ']</p>' => ']',
            ']<br />' => ']'
        );
        $content = strtr($content, $array);
        return $content;
    }

    add_filter('the_content', 'hannah_cd_fix_shortcodes');

endif;


/*****************************************************************/
/* ALLOW SHORTCODES IN CONTACT FORM 7 */
/*****************************************************************/

if ( ! function_exists('hannah_cd_shortcodes_in_cf7') ) :

    function hannah_cd_shortcodes_in_cf7($form) {
        $form = do_shortcode($form);
        return $form;
    }

	add_filter('wpcf7_form_elements', 'hannah_cd_shortcodes_in_cf7');

endif;


/*****************************************************************/
/* CREATE A SHORTCODE SELECTION BOX */
/*****************************************************************/

// add the button to wp editor

/* if ( ! function_exists('hannah_cd_shortcodes_button') ) :

    function hannah_cd_shortcodes_button() {
		
        $button_output = '<a href="#TB_inline?height=600&width=300&inlineId=theme_shortcodes" class="button thickbox" onClick="openThickbox(this);" id="theme_shortcodes_button"><span></span> ' . esc_html__('Shortcodes', 'hannah-cd') . '</a>';
		
		return $button_output;
		
    }

    add_action('media_buttons_context', 'hannah_cd_shortcodes_button');

endif; */

// add content for the popup window

if ( ! function_exists('hannah_cd_shortcodes_content') ) :

    function hannah_cd_shortcodes_content() {
        ?>

        <style>
            .shortcode-thickbox #theme_shortcodes_button span {display:inline-block;width:18px;height:18px;vertical-align:text-top}
            .shortcode-thickbox #theme_shortcodes_button span:before {content:"\f109";font:normal 18px/1 dashicons;color:#82878c}

            .shortcode-thickbox #TB_window {overflow:hidden;height:50%!important}
            .shortcode-thickbox #TB_ajaxContent {position:relative;width:100%!important;height:100%!important;padding:0px!important}
            .shortcode-thickbox .theme-shortcodes {position:absolute;top:0px;right:0px;bottom:30px;left:0px;overflow:hidden;overflow-y:auto}
            .theme-shortcodes * {box-sizing:border-box}
            .theme-shortcodes button {opacity:0.3;margin-top:12px!important;transition:all 0.5s}

            .theme-shortcodes .container textarea {display:none;position:absolute;top:40px;right:40px;left:auto;width:40%;height:300px;padding:20px;background:#eee;font-size:13px;font-family:Consolas,"Andale Mono", "Lucida Console", "Lucida Sans Typewriter", Monaco, "Courier New", "monospace";resize:none;z-index:1;box-shadow:0px 2px 10px rgba(0,0,0,0.3)}
            .theme-shortcodes .container:nth-child(2n) textarea {left:40px;right:auto}

            .theme-shortcodes .example {display:inline-block;width:15px;height:15px;text-align:center;background:#eee;font-size:9px;border-radius:50%;margin-left:10px}
            .theme-shortcodes .example:hover ~ textarea {display: block}

            .theme-shortcodes .container:hover button {opacity:1;transition:all 0.5s}
            .theme-shortcodes .container {float:left;width:50%;padding:10px 20px;border-right:1px solid #ddd;border-bottom:1px solid #ddd}
            .theme-shortcodes .container:hover {background:#fafafa}
            .theme-shortcodes .container:nth-child(2n) {border-right:0px}
            .theme-shortcodes .container h4 {float:left}
            .theme-shortcodes .container button {float:right}

            .theme-shortcodes .options {display:none;position:absolute;top:60px;right:60px;left:60px;padding:30px;background:#fff;box-shadow:0px 2px 10px rgba(0,0,0,0.6);z-index:2}
            .theme-shortcodes .options table {border-collapse:collapse;border-spacing:10px}
            .theme-shortcodes .options td {padding:6px 10px 6px 0px}
            .theme-shortcodes .options td button {float:left}
            .theme-shortcodes .options h2 {margin-top:0px}
            .theme-shortcodes .options-overlay {display:none;position:absolute;top:0px;right:0px;bottom:0px;left:0px;background:rgba(0,0,0,0.7);z-index:1}
            .theme-shortcodes .options.isVisible, .theme-shortcodes .options-overlay.isVisible {display:block}
            .theme-shortcodes .options .tb-close-icon {cursor:pointer}
            .theme-shortcodes .options .tb-close-icon:hover {color:#00a0d2}
        </style>

        <div id="theme_shortcodes" style="display:none">

            <div class="theme-shortcodes">

                <div class="container">
                    <h4>
        				<?php esc_html_e('Button', 'hannah-cd'); ?> 
                        <span class="example">?</span>
                        <textarea>Example: [button link="http://www.google.de']Click Me[/button]</textarea>
                    </h4>
                    <button class="button-primary" id="shc_options_button"><?php esc_html_e('Options', 'hannah-cd'); ?></button>
                    <div class="options">
                        <h2><?php esc_html_e('Shortcode Options', 'hannah-cd'); ?></h2>
                        <table>
                            <tr>
                                <td class="label"><?php esc_html_e('Title', 'hannah-cd'); ?>:</td>
                                <td><input type="text" id="shc_button_title" placeholder="Click me"></td>
                            </tr>
                            <tr>
                                <td class="label"><?php esc_html_e('URL', 'hannah-cd'); ?>:</td>
                                <td class="label"><input type="text" id="shc_button_url" placeholder="http://..."></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button class="btn_shortcode button-primary" id="shc_button"><?php esc_html_e('Add Shortcode', 'hannah-cd'); ?></button>
                                </td>
                            </tr>
                        </table>
                        <span class="tb-close-icon"></span>
                    </div>
                    <div class="options-overlay"></div>
                </div>

                <div class="container">
                    <h4>
        				<?php esc_html_e('Unordered List', 'hannah-cd'); ?>
                        <span class="example">?</span>
                        <textarea>Example: [button link="http://www.google.de']Click Me[/button]</textarea>
                    </h4>
                    <button class="btn_shortcode button-primary" id="shc_ulist"><?php esc_html_e('Add Shortcode', 'hannah-cd'); ?></button>
                    <textarea>Example: [ulist]<ul><li>Your list element</li><li>Your list element 2</li><li>Your list element 3</li></ul>[/ulist]</textarea>
                </div>

                <div class="container">
                    <h4>
        				<?php esc_html_e('Ordered List', 'hannah-cd'); ?>
                        <span class="example">?</span>
                        <textarea>Example: [olist]<ol><li>Your list element</li><li>Your list element 2</li><li>Your list element 3</li></ol>[/olist]</textarea>
                    </h4>
                    <button class="btn_shortcode button-primary" id="shc_olist"><?php esc_html_e('Add Shortcode', 'hannah-cd'); ?></button>
                </div>

                <div class="container">
                    <h4>
        				<?php esc_html_e('Tab Menu', 'hannah-cd'); ?>
                        <span class="example">?</span>
                        <textarea>Example: [tabmenu][tab]tab item 1[/tab][tab]tab item 2[/tab][/tabmenu][tab-content][tab-pane]The content of tab item 1.[/tab-pane][tab-pane]The content of tab item 2.[/tab-pane][/tab-content]</textarea>
                    </h4>
                    <button class="btn_shortcode button-primary" id="shc_tabmenu"><?php esc_html_e('Add Shortcode', 'hannah-cd'); ?></button>
                </div>

                <div class="container">
                    <h4>
        				<?php esc_html_e('Accordion Menu', 'hannah-cd'); ?>
                        <span class="example">?</span>
                        <textarea>Example: [acc][acc-item item="accordion item 1"]The content of tab item 1.[/acc-item][acc-item item="accordion item 2"]The content of tab item 2.[/acc-item][/acc]</textarea>
                    </h4>
                    <button class="btn_shortcode button-primary" id="shc_accordion"><?php esc_html_e('Add Shortcode', 'hannah-cd'); ?></button>
                </div>

                <div class="container">
                    <h4>
        				<?php esc_html_e('Toggle Menu', 'hannah-cd'); ?>
                        <span class="example">?</span>
                        <textarea>Example: [toggle][toggle-item item="Your item title 1"] Lorem ipsum dolor sit amet, consectetuer adipiscing elit. [/toggle-item][toggle-item item="Your item title 2"] Lorem ipsum dolor sit amet, consectetuer adipiscing elit. [/toggle-item][/toggle]</textarea>
                    </h4>
                    <button class="btn_shortcode button-primary" id="shc_toggle"><?php esc_html_e('Add Shortcode', 'hannah-cd'); ?></button>
                </div>

                <div class="container">
                    <h4>
       					<?php esc_html_e('Video Embed', 'hannah-cd'); ?>
                        <span class="example">?</span>
                        <textarea>Example: [video type="youtube" link="QoY77paKjLY"][/video]</textarea>
                    </h4>
                    <button class="button-primary" id="shc_options_button"><?php esc_html_e('Options', 'hannah-cd'); ?></button>
                    <div class="options">
                        <h2><?php esc_html_e('Shortcode Options', 'hannah-cd'); ?></h2>
                        <table>
                            <tr>
                                <td class="label"><?php esc_html_e('Type', 'hannah-cd'); ?>:</td>
                                <td>
                                    <select id="shc_video_select">
                                        <option value="youtube">YouTube</option>
                                        <option value="vimeo">Vimeo</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="label"><?php esc_html_e('Video ID', 'hannah-cd'); ?>:</td>
                                <td><input type="text" id="shc_video_id" placeholder="QoY77paKjLY"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button class="btn_shortcode button-primary" id="shc_video"><?php esc_html_e('Add Shortcode', 'hannah-cd'); ?></button>
                                </td>
                            </tr>
                        </table>
                        <span class="tb-close-icon"></span>
                    </div>
                    <div class="options-overlay"></div>
                </div>

                <div class="container">
                    <h4>
        				<?php esc_html_e('Icon', 'hannah-cd'); ?>
                        <span class="example">?</span>
                        <textarea>Example: [icon type="fa-search" size="2"][/icon]</textarea>
                    </h4>
                    <button class="button-primary" id="shc_options_button"><?php esc_html_e('Options', 'hannah-cd'); ?></button>
                    <div class="options">
                        <h2><?php esc_html_e('Shortcode Options', 'hannah-cd'); ?></h2>
                        <table>
                            <tr>
                                <td class="label"><?php esc_html_e('Font Awesome Icon Name', 'hannah-cd'); ?>:</td>
                                <td><input type="text" id="shc_icon_name" placeholder="fa-search"></td>
                            </tr>
                            <tr>
                                <td class="label"><?php esc_html_e('Icon Size', 'hannah-cd'); ?>:</td>
                                <td>
                                    <select id="shc_icon_select">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button class="btn_shortcode button-primary" id="shc_icon"><?php esc_html_e('Add Shortcode', 'hannah-cd'); ?></button>
                                </td>
                            </tr>
                        </table>
                        <span class="tb-close-icon"></span>
                    </div>
                    <div class="options-overlay"></div>
                </div>

                <div class="container">
                    <h4>
        				<?php esc_html_e('Alert Box', 'hannah-cd'); ?>
                        <span class="example">?</span>
                        <textarea>Example: [alert type="success"]Well done! You successfully read this important alert message.[/alert]</textarea>
                    </h4>
                    <button class="button-primary" id="shc_options_button"><?php esc_html_e('Options', 'hannah-cd'); ?></button>
                    <div class="options">
                        <h2><?php esc_html_e('Shortcode Options', 'hannah-cd'); ?></h2>
                        <table>
                            <tr>
                                <td class="label"><?php esc_html_e('Type', 'hannah-cd'); ?>:</td>
                                <td>
                                    <select id="shc_alert_select">
                                        <option value="success">Success</option>
                                        <option value="info">Info</option>
                                        <option value="warning">Warning</option>
                                        <option value="danger">Danger</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="label"><?php esc_html_e('Content', 'hannah-cd'); ?>:</td>
                                <td><input type="text" id="shc_alert_content" placeholder="Your message ..."></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button class="btn_shortcode button-primary" id="shc_alert"><?php esc_html_e('Add Shortcode', 'hannah-cd'); ?></button>
                                </td>
                            </tr>
                        </table>
                        <span class="tb-close-icon"></span>
                    </div>
                    <div class="options-overlay"></div>
                </div>

                <div class="container">
                    <h4>
        				<?php esc_html_e('Leadin', 'hannah-cd'); ?>
                        <span class="example">?</span>
                        <textarea>Example: [leadin align="left"]Create your blog and share your voice.[/leadin]</textarea>
                    </h4>
                    <button class="button-primary" id="shc_options_button"><?php esc_html_e('Options', 'hannah-cd'); ?></button>
                    <div class="options">
                        <h2><?php esc_html_e('Shortcode Options', 'hannah-cd'); ?></h2>
                        <table>
                            <tr>
                                <td class="label"><?php esc_html_e('Align', 'hannah-cd'); ?>:</td>
                                <td>
                                    <select id="shc_leadin_select">
                                        <option value="left">Left</option>
                                        <option value="right">Right</option>
                                        <option value="full">Full</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="label"><?php esc_html_e('Content', 'hannah-cd'); ?>:</td>
                                <td><input type="text" id="shc_leadin_content" placeholder="Your message ..."></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button class="btn_shortcode button-primary" id="shc_leadin"><?php esc_html_e('Add Shortcode', 'hannah-cd'); ?></button>
                                </td>
                            </tr>
                        </table>
                        <span class="tb-close-icon"></span>
                    </div>
                    <div class="options-overlay"></div>
                </div>

                <div class="container">
                    <h4>
        				<?php esc_html_e('Columns', 'hannah-cd'); ?>
                        <span class="example">?</span>
                        <textarea>Example: [column][col size="2"]Column 1[/col][col size="2"]Column 2[/col][/column]</textarea>
                    </h4>
                    <button class="button-primary" id="shc_options_button"><?php esc_html_e('Options', 'hannah-cd'); ?></button>
                    <div class="options">
                        <h2><?php esc_html_e('Shortcode Options', 'hannah-cd'); ?></h2>
                        <table>
                            <tr>
                                <td class="label"><?php esc_html_e('Count of Columns', 'hannah-cd'); ?>:</td>
                                <td>
                                    <select id="shc_column_select">
                                        <option value="2">2 Columns</option>
                                        <option value="3">3 Columns</option>
                                        <option value="4">4 Columns</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button class="btn_shortcode button-primary" id="shc_column"><?php esc_html_e('Add Shortcode', 'hannah-cd'); ?></button>
                                </td>
                            </tr>
                        </table>
                        <span class="tb-close-icon"></span>
                    </div>
                    <div class="options-overlay"></div>
                </div>

                <div class="container">
                    <h4>
        				<?php esc_html_e('Highlight Text', 'hannah-cd'); ?>
                        <span class="example">?</span>
                        <textarea>Example: [mark]Highlighted Text[/mark]</textarea>
                    </h4>
                    <button class="button-primary" id="shc_options_button"><?php esc_html_e('Options', 'hannah-cd'); ?></button>
                    <div class="options">
                        <h2><?php esc_html_e('Shortcode Options', 'hannah-cd'); ?></h2>
                        <table>
                            <tr>
                                <td class="label"><?php esc_html_e('Content', 'hannah-cd'); ?>:</td>
                                <td><input type="text" id="shc_highlight_content" placeholder="Your message ..."></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button class="btn_shortcode button-primary" id="shc_highlight"><?php esc_html_e('Add Shortcode', 'hannah-cd'); ?></button>
                                </td>
                            </tr>
                        </table>
                        <span class="tb-close-icon"></span>
                    </div>
                    <div class="options-overlay"></div>
                </div>

                <div class="container">
                    <h4>
        				<?php esc_html_e('Post List', 'hannah-cd'); ?>
                        <span class="example">?</span>
                        <textarea>Example: [post-list count="3" column="1"][/post-list]</textarea>
                    </h4>
                    <button class="button-primary" id="shc_options_button"><?php esc_html_e('Options', 'hannah-cd'); ?></button>
                    <div class="options">
                        <h2><?php esc_html_e('Shortcode Options', 'hannah-cd'); ?></h2>
                        <table>
                            <tr>
                                <td class="label"><?php esc_html_e('Count of Columns', 'hannah-cd'); ?>:</td>
                                <td>
                                    <select id="shc_post_column_select">
                                        <option value="none">None</option>
                                        <option value="1">1 Column</option>
                                        <option value="2">2 Columns</option>
                                        <option value="3">3 Columns</option>
                                        <option value="4">4 Columns</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="label"><?php esc_html_e('Count of Posts', 'hannah-cd'); ?>:</td>
                                <td><input type="text" id="shc_post_count" placeholder="1"></td>
                            </tr>
                            <tr>
                                <td class="label"><?php esc_html_e('Include specific Post IDs only', 'hannah-cd'); ?>:</td>
                                <td><input type="text" id="shc_post_id" placeholder="666,231,344"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button class="btn_shortcode button-primary" id="shc_post"><?php esc_html_e('Add Shortcode', 'hannah-cd'); ?></button>
                                </td>
                            </tr>
                        </table>
                        <span class="tb-close-icon"></span>
                    </div>
                    <div class="options-overlay"></div>
                </div>

                <div class="container">
                    <h4>
        				<?php esc_html_e('Page List', 'hannah-cd'); ?>
                        <span class="example">?</span>
                        <textarea>Example: [post-list count="3" column="1" type="page"][/post-list]</textarea>
                    </h4>
                    <button class="button-primary" id="shc_options_button"><?php esc_html_e('Options', 'hannah-cd'); ?></button>
                    <div class="options">
                        <h2><?php esc_html_e('Shortcode Options', 'hannah-cd'); ?></h2>
                        <table>
                            <tr>
                                <td class="label"><?php esc_html_e('Count of Columns', 'hannah-cd'); ?>:</td>
                                <td>
                                    <select id="shc_page_column_select">
                                        <option value="none">None</option>
                                        <option value="1">1 Column</option>
                                        <option value="2">2 Columns</option>
                                        <option value="3">3 Columns</option>
                                        <option value="4">4 Columns</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="label"><?php esc_html_e('Count of Pages', 'hannah-cd'); ?>:</td>
                                <td><input type="text" id="shc_page_count" placeholder="1"></td>
                            </tr>
                            <tr>
                                <td class="label"><?php esc_html_e('Include specific Page IDs only', 'hannah-cd'); ?>:</td>
                                <td><input type="text" id="shc_page_id" placeholder="666,231,344"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button class="btn_shortcode button-primary" id="shc_page"><?php esc_html_e('Add Shortcode', 'hannah-cd'); ?></button>
                                </td>
                            </tr>
                        </table>
                        <span class="tb-close-icon"></span>
                    </div>
                    <div class="options-overlay"></div>
                </div>

                <div class="container">
                    <h4>
        				<?php esc_html_e('Dropcap', 'hannah-cd'); ?>
                        <span class="example">?</span>
                        <textarea>Example: [dropcap]Y[/dropcap]our text ...</textarea>
                    </h4>
                    <button class="button-primary" id="shc_options_button"><?php esc_html_e('Options', 'hannah-cd'); ?></button>
                    <div class="options">
                        <h2><?php esc_html_e('Shortcode Options', 'hannah-cd'); ?></h2>
                        <table>
                            <tr>
                                <td class="label"><?php esc_html_e('First Letter', 'hannah-cd'); ?>:</td>
                                <td><input type="text" id="shc_dropcap_first" placeholder="Y"></td>
                            </tr>
                            <tr>
                                <td class="label"><?php esc_html_e('Second Part', 'hannah-cd'); ?>:</td>
                                <td><input type="text" id="shc_dropcap_second" placeholder="our message ..."></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button class="btn_shortcode button-primary" id="shc_dropcap"><?php esc_html_e('Add Shortcode', 'hannah-cd'); ?></button>
                                </td>
                            </tr>
                        </table>
                        <span class="tb-close-icon"></span>
                    </div>
                    <div class="options-overlay"></div>
                </div>

                <div class="container">
                    <h4>
        				<?php esc_html_e('Google Maps Embed', 'hannah-cd'); ?>
                        <span class="example">?</span>
                        <textarea>Example: [maps width="100%" height="350px" link="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d453478.8144488746!2d152.71233137091994!3d-27.38185974480549!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sde!2sde!4v1484508882042"] [/maps]</textarea>
                    </h4>
                    <button class="button-primary" id="shc_options_button"><?php esc_html_e('Options', 'hannah-cd'); ?></button>
                    <div class="options">
                        <h2><?php esc_html_e('Shortcode Options', 'hannah-cd'); ?></h2>
                        <table>
                            <tr>
                                <td class="label"><?php esc_html_e('Width', 'hannah-cd'); ?>:</td>
                                <td><input type="text" id="shc_maps_width" placeholder="100"></td>
                                <td>
                                    <select id="shc_maps_width_unit_select">
                                        <option value="%">Percent</option>
                                        <option value="px">Pixel</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="label"><?php esc_html_e('Height', 'hannah-cd'); ?>:</td>
                                <td><input type="text" id="shc_maps_height" placeholder="300"></td>
                                <td>
                                    <select id="shc_maps_height_unit_select">
                                        <option value="px">Pixel</option>
                                        <option value="%">Percent</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="label"><?php esc_html_e('Google Maps URL', 'hannah-cd'); ?>:</td>
                                <td><input type="text" id="shc_maps_url" placeholder="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d453478.8144488746!2d152.71233137091994!3d-27.38185974480549!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sde!2sde!4v1484508882042"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button class="btn_shortcode button-primary" id="shc_maps"><?php esc_html_e('Add Shortcode', 'hannah-cd'); ?></button>
                                </td>
                            </tr>
                        </table>
                        <span class="tb-close-icon"></span>
                    </div>
                    <div class="options-overlay"></div>
                </div>

                <div class="container">
                    <h4>
        				<?php esc_html_e('Divider', 'hannah-cd'); ?>
                        <span class="example">?</span>
                        <textarea>Example: [divider type="solid"][/divider]</textarea>
                    </h4>
                    <button class="button-primary" id="shc_options_button"><?php esc_html_e('Options', 'hannah-cd'); ?></button>
                    <div class="options">
                        <h2><?php esc_html_e('Shortcode Options', 'hannah-cd'); ?></h2>
                        <table>
                            <tr>
                                <td class="label"><?php esc_html_e('Style', 'hannah-cd'); ?>:</td>
                                <td>
                                    <select id="shc_divider_select">
                                        <option value="solid">Solid</option>
                                        <option value="dotted">Dotted</option>
                                        <option value="dashed">Dashed</option>
                                        <option value="double">Double</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="label"><?php esc_html_e('Content', 'hannah-cd'); ?>:</td>
                                <td><input type="text" id="shc_divider_content" placeholder="Your message ..."></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button class="btn_shortcode button-primary" id="shc_divider"><?php esc_html_e('Add Shortcode', 'hannah-cd'); ?></button>
                                </td>
                            </tr>
                        </table>
                        <span class="tb-close-icon"></span>
                    </div>
                    <div class="options-overlay"></div>
                </div>

            </div>

        </div>


    <?php
    }

    add_action('admin_footer', 'hannah_cd_shortcodes_content');

endif;

// add shortcodes to editor

if ( ! function_exists('hannah_cd_shortcodes_to_editor') ) :

    function hannah_cd_shortcodes_to_editor() { ?>

        <script>
            jQuery(document).ready(function($) {

                // add class to body

                if ($('#theme_shortcodes_button').length) {
                    $('body').addClass('shortcode-thickbox');
                }

                // set top offset for textarea example tooltip

                $('.theme-shortcodes').scroll(function() {
                    $('.theme-shortcodes textarea').css('top', $('.theme-shortcodes').scrollTop() + 40)
                });

                // set top / bottom offset for options overlay

                $('.theme-shortcodes').scroll(function() {
                    $('.theme-shortcodes .options').css('top', $('.theme-shortcodes').scrollTop() + 60)
                    $('.theme-shortcodes .options-overlay').css('bottom', -$('.theme-shortcodes').scrollTop())
                });

                // manage option overlay

                $('.theme-shortcodes .container').ready(function() {

                    // show the option panel
                    $(this).on('click touchstart', 'button', function(e) {
                        $(this).closest('.container').find(".options").addClass('isVisible');
                        $(this).closest('.container').find(".options-overlay").addClass('isVisible');
                        e.stopPropagation();
                    });

                    $(this).on("click touchstart", '.options', function(e) {
                        e.stopPropagation();
                    });

                    // hide the option panel
                    $(document).on("click touchstart", function() {
                        $(this).find(".options").removeClass('isVisible');
                        $(this).find(".options-overlay").removeClass('isVisible');
                    });

                    $(this).on('click touchstart', '.tb-close-icon, .btn_shortcode', function() {
                        $(this).closest('.container').find(".options").removeClass('isVisible');
                        $(this).closest('.container').find(".options-overlay").removeClass('isVisible');
                    });

                    $('body').on('click', '.button.thickbox', function() {
                        $(".options").removeClass('isVisible');
                        $(".options-overlay").removeClass('isVisible');
                    });

                });

                $('.btn_shortcode').on('click', function() {

                    // get button user content
                    var shc_button_url = $('#shc_button_url').val();
                    var shc_button_title = $('#shc_button_title').val();

                    // get video user content
                    var shc_video_type = $('#shc_video_select').val();
                    var shc_video_id = $('#shc_video_id').val();

                    // get icon user content
                    var shc_icon_name = $('#shc_icon_name').val();
                    var shc_icon_size = $('#shc_icon_select').val();

                    // get alert user content
                    var shc_alert_content = $('#shc_alert_content').val();
                    var shc_alert_type = $('#shc_alert_select').val();

                    // get leadin user content
                    var shc_leadin_content = $('#shc_leadin_content').val();
                    var shc_leadin_align = $('#shc_leadin_select').val();

                    // get column user content
                    if ($('#shc_column_select').val() == '2') {
                        var get_columns = '[col size="2"]Column 1[/col][col size="2"]Column 2[/col]';
                    } else if ($('#shc_column_select').val() == '3') {
                        var get_columns = '[col size="3"]Column 1[/col][col size="3"]Column 2[/col][col size="3"]Column 3[/col]';
                    } else {
                        var get_columns = '[col size="4"]Column 1[/col][col size="4"]Column 2[/col][col size="4"]Column 3[/col][col size="4"]Column 4[/col]';
                    }

                    // get highlight user content
                    var shc_highlight_content = $('#shc_highlight_content').val();

                    // get post user content
                    var shc_post_column_select = $('#shc_post_column_select').val();
                    var shc_post_count = $('#shc_post_count').val();
                    var shc_post_id = $('#shc_post_id').val();

                    if ($('#shc_post_id').val()) {
                        var get_post_list = '[post-list count="' + shc_post_count + '" column="' + shc_post_column_select + '" post_ids="' + shc_post_id + '"][/post-list]';
                    } else {
                        var get_post_list = '[post-list count="' + shc_post_count + '" column="' + shc_post_column_select + '"][/post-list]';
                    }

                    // get page user content
                    var shc_page_column_select = $('#shc_page_column_select').val();
                    var shc_page_count = $('#shc_page_count').val();
                    var shc_page_id = $('#shc_page_id').val();

                    if ($('#shc_page_id').val()) {
                        var get_page_list = '[post-list count="' + shc_page_count + '" column="' + shc_page_column_select + '" post_ids="' + shc_page_id + '" type="page"][/post-list]';
                    } else {
                        var get_page_list = '[post-list count="' + shc_page_count + '" column="' + shc_page_column_select + '" type="page"][/post-list]';
                    }

                    // get dropcap user content
                    var shc_dropcap_first = $('#shc_dropcap_first').val();
                    var shc_dropcap_second = $('#shc_dropcap_second').val();

                    // get google maps user content
                    var shc_maps_width = $('#shc_maps_width').val();
                    var shc_maps_height = $('#shc_maps_height').val();

                    if ($('#shc_maps_width_unit_select').val() == '%') {
                        var shc_maps_width_unit = '%';
                    } else {
                        var shc_maps_width_unit = 'px';
                    }

                    if ($('#shc_maps_height_unit_select').val() == 'px') {
                        var shc_maps_height_unit = 'px';
                    } else {
                        var shc_maps_height_unit = '%';
                    }

                    var shc_maps_url = $('#shc_maps_url').val();

                    // get divider user content
                    var shc_divider_style = $('#shc_divider_select').val();
                    var shc_divider_content = $('#shc_divider_content').val();

                    // get the id of the clicked element and load the correct shortcode
                    switch (this.id) {
                        case 'shc_button':
                            var shortcode = '[button link="' + shc_button_url + '"]' + shc_button_title + '[/button]';
                            break;
                        case 'shc_ulist':
                            var shortcode = '[ulist]<ul><li>Your list element</li><li>Your list element 2</li><li>Your list element 3</li></ul>[/ulist]';
                            break;
                        case 'shc_olist':
                            var shortcode = '[olist]<ol><li>Your list element</li><li>Your list element 2</li><li>Your list element 3</li></ol>[/olist]';
                            break;
                        case 'shc_tabmenu':
                            var shortcode = '[tabmenu][tab]tab item 1[/tab][tab]tab item 2[/tab][/tabmenu][tab-content][tab-pane]The content of tab item 1.[/tab-pane][tab-pane]The content of tab item 2.[/tab-pane][/tab-content]';
                            break;
                        case 'shc_accordion':
                            var shortcode = '[acc][acc-item item="accordion item 1"]The content of tab item 1.[/acc-item][acc-item item="accordion item 2"]The content of tab item 2.[/acc-item][/acc]';
                            break;
                        case 'shc_toggle':
                            var shortcode = '[toggle][toggle-item item="Your item title 1"] Lorem ipsum dolor sit amet, consectetuer adipiscing elit. [/toggle-item][toggle-item item="Your item title 2"] Lorem ipsum dolor sit amet, consectetuer adipiscing elit. [/toggle-item][/toggle]';
                            break;
                        case 'shc_video':
                            var shortcode = '[video type="' + shc_video_type + '" link="' + shc_video_id + '"][/video]';
                            break;
                        case 'shc_icon':
                            var shortcode = '[icon type="' + shc_icon_name + '" size="' + shc_icon_size + '"][/icon]';
                            break;
                        case 'shc_alert':
                            var shortcode = '[alert type="' + shc_alert_type + '"]' + shc_alert_content + '[/alert]';
                            break;
                        case 'shc_leadin':
                            var shortcode = '[leadin align="' + shc_leadin_align + '"]' + shc_leadin_content + '[/leadin]';
                            break;
                        case 'shc_column':
                            var shortcode = '[column]' + get_columns + '[/column]';
                            break;
                        case 'shc_highlight':
                            var shortcode = '[mark]' + shc_highlight_content + '[/mark]';
                            break;
                        case 'shc_post':
                            var shortcode = get_post_list;
                            break;
                        case 'shc_page':
                            var shortcode = get_page_list;
                            break;
                        case 'shc_dropcap':
                            var shortcode = '[dropcap]' + shc_dropcap_first + '[/dropcap]' + shc_dropcap_second;
                            break;
                        case 'shc_maps':
                            var shortcode = '[maps width="' + shc_maps_width + shc_maps_width_unit + '" height="' + shc_maps_height + shc_maps_height_unit + '" link="' + shc_maps_url + '"][/maps]';
                            break;
                        case 'shc_divider':
                            var shortcode = '[divider type="' + shc_divider_style + '"]' + shc_divider_content + '[/divider]';
                            break;
                    }

                    // WP TEXT EDITOR

                    if ( window.editorType == 'html' || window.editorType != 'tmce' || ! tinyMCE.activeEditor || tinyMCE.activeEditor.isHidden() ) {

                        // get the selected shortcode
                        var txtToAdd = shortcode;

                        // get the currently selected editor
                        var editor = $('textarea.wp-editor-area[data-editor-id="' + window.editorId + '"]');

                        // get the currently cursor position and add the shortcode
                        var caretPos = editor[0].selectionStart;
                        var textAreaTxt = editor.val();
                        editor.val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos));

                    // WP TINYMCE EDITOR

                    } else {

                        tinyMCE.activeEditor.dom.setHTML( tinyMCE.activeEditor.selection.setContent(shortcode) );

                    }

                    // close the thickbox after adding shortcode to editor
                    self.parent.tb_remove();

                });
				
            });
			
			// set own IDs for each editor items (if there are more than one editor at the same page)
			
            function openThickbox(el) {

                jQuery('.wp-editor-wrap').each(function(i) {
                    var setID = i + 1;

                    jQuery(this).attr('data-editor-id', setID);
                    jQuery(this).find('.wp-editor-area').attr('data-editor-id', setID);
                    jQuery(this).find('#theme_shortcodes_button').attr('data-editor-id', setID);
					
					// check the currently editor is html editor
					if( jQuery(this).hasClass('html-active') ) {
						jQuery(this).attr('data-editor-type', 'html');
						jQuery(this).find('.wp-editor-area').attr('data-editor-type', 'html');
						jQuery(this).find('#theme_shortcodes_button').attr('data-editor-type', 'html');
					// check the currently editor is tinymce editor
					} else if( jQuery(this).hasClass('tmce-active') ) {
						jQuery(this).attr('data-editor-type', 'tmce');
						jQuery(this).find('.wp-editor-area').attr('data-editor-type', 'tmce');
						jQuery(this).find('#theme_shortcodes_button').attr('data-editor-type', 'tmce');
					}
					
                });
                
                window.editorId = el.getAttribute('data-editor-id');
				window.editorType = el.getAttribute('data-editor-type');
				
            };

        </script>

    <?php
    }

    add_action('admin_footer', 'hannah_cd_shortcodes_to_editor');

endif;


/* --> FIND ALL SHORTCODES IN THE THEME PLUGIN <-- */

