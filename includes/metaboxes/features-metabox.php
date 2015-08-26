<div id="dh_ptp_tabs_container" class="my_meta_control">
    <!-- clear our floats -->
    <div class="clear"></div>

    <?php include ( PTP_PLUGIN_PATH . '/includes/metaboxes/metabox-blocks/tab-content.php');?>
    <?php include ( PTP_PLUGIN_PATH . '/includes/metaboxes/metabox-blocks/tab-advanced-settings.php');?>
    <?php //include ( PTP_PLUGIN_PATH . '/includes/metaboxes/metabox-blocks/tab-template.php'); ?>

    <div id="ptp-save-buttons">
        <div style="margin-left:10px;margin-right:10px;">
            <input type="hidden" name="publish" id="publish" value="1"/>
            <input type="hidden" name="dh_ptp_tab" id="dh_ptp_tab" value="#dh_ptp_tabs_1"/>
            <input style="float:none; margin-left:10px;" name="save" id="dh_ptp_save" type="submit" class="button button-large" accesskey="p" value="<?php _e('Save', PTP_LOC); ?>" />
       </div>
    </div>
</div>
