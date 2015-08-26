<div id="dh_ptp_tabs_3" class="dh_ptp_tab">

    <?php $mb->the_field('dh-ptp-simple-flat-template'); ?>
    <div id="simple-flat-selector" class="template-selector  template-selected">
        <input type="hidden" name="<?php $mb->the_name(); ?>" value="<?php if (!is_null($metabox->get_the_value())) {
        $mb->the_value();
    } elseif (!$mb->is_last()) {
        echo "selected";
    } ?>" class="form-control template-hidden-input" />
        <img src="<?php echo PTP_PLUGIN_PATH_FOR_SUBDIRS . '/assets/ui/img/simple-flat.png'; ?>" class="template-image">
        <p class="template-headline"><?php _e('Design 1', PTP_LOC); ?></p>
        <ul class="template-feature">
            <li><?php _e('Ideal For Responsive Sites', PTP_LOC); ?></li>
            <li><?php _e('Supports Up To 10 Columns', PTP_LOC); ?></li>
        </ul>
        <a onClick="" class="button template-button"><?php _e('Use This Template', PTP_LOC); ?></a>
    </div>

    <!-- clear our floats -->
    <div class="clear"></div>
</div>