<?php

/**
 * Generate our simple flat pricing table HTML
 * @return [type]
 */
function dh_ptp_generate_simple_flat_pricing_table_html ($id)
{
    global $features_metabox;
    global $meta;

    $meta = get_post_meta($id, $features_metabox->get_the_id(), TRUE);

    $loop_index = 0;
    $pricing_table_html = '
    <div class="plan-switcher-wrap">
        <p class="plan-switcher-title">
            Billing Frequency:
        </p>
        <label class="plan-switcher">
        <!-- Style this area with flexbox! the checkbox should be hidden. Trigger the plan switching with your own JS -->
            <input type="checkbox">
            <span>Monthly</span>
            <div class="faketoggle"></div>
            <span>Yearly</span>
        </label>
    </div>
    <div id="plan-table-'. $id .'" class="plan-table">';
    
    foreach ($meta['column'] as $column) {

        // Column details
        $plan_name = isset($column['planname'])?$column['planname']:'';
        $plan_monthly_price = isset($column['planmonthlyprice'])?$column['planmonthlyprice']:'';
        $plan_yearly_price = isset($column['planyearlyprice'])?$column['planyearlyprice']:'';
        $plan_features = isset($column['planfeatures'])?$column['planfeatures']:'';
        $button_text = isset($column['buttontext'])?$column['buttontext']:'';
        $button_url = isset($column['buttonurl'])?$column['buttonurl']:'';
        $button_url = trim($button_url);
        
        // Get custom shortcode if any
        $custom_button = false;
        $shortcode_pattern = '|^\[shortcode\](?P<custom_button>.*)\[/shortcode\]$|';
        if ( 
            preg_match( $shortcode_pattern, $button_text, $matches) 
            ||
            preg_match( $shortcode_pattern, $button_url, $matches) 
        ) {
            $custom_button = $matches[ 'custom_button' ];
        }

        // Featured column
        $feature = '';
        $feature_label = '<div class="plan-not-most-popular">&nbsp;</div>';
        if(isset($column['feature']) && $column['feature'] == "featured") {
            $feature = "plan-featured";
            $most_popular_text = isset($meta['most-popular-label-text'])?$meta['most-popular-label-text']:__('Most Popular', PTP_LOC);
        }

        // create the html code
        $pricing_table_html .= '
		<div class="plan-column ' . $feature . ' plan-id-' . $loop_index . '">' .
			'<div class="plan-name">' . $plan_name . '</div> ' .
	  		'<div class="plan-price"><div class="monthly-price">' . $plan_monthly_price . '<span class="plan-duration">per month</span></div>' .
            '<div class="yearly-price hidden">' . $plan_yearly_price . '<span class="plan-duration">per year</span></div></div>' .
                dh_ptp_features_to_html_simple_flat($plan_features, dh_ptp_get_max_number_of_features()) .
  			'<div class="plan-cta">'.
                (($custom_button)?$custom_button:'<a class="plan-button" id="plan-'.$id.'-cta-'.$loop_index.'" href="' . $button_url . '">' . $button_text . '</a>') .
  			'</div>' .
		'</div>';

        $loop_index++;
    }

    $pricing_table_html .= '</div>';

    return $pricing_table_html;
}

/**
 * Returns the highest number of features that one of our columns uses (needed to create blank rows)
 * @return int
 */
function dh_ptp_get_max_number_of_features()
{
    global $meta;

    $max = 0;
    foreach ($meta['column'] as $column) {
        if(isset($column['planfeatures'])) {
            // get number of features
            $col_number_of_features = count( explode( "\n", $column['planfeatures'] ) );

            if ($col_number_of_features > $max) {
                $max = $col_number_of_features;
            }
        }
    }

    return $max;
}

/**
 * Generate HTML code for our features
 * @param $dh_ptp_plan_features - this is an array containing all features
 * @param $dh_ptp_max_number_of_features - the highest number of features that one of our columns uses
 * @return string - the html string containing all features
 */
function dh_ptp_features_to_html_simple_flat ($plan_features, $max_number_of_features)
{
    // the string to be returned
    $html = '';

    // explode string into a useable array
    $features = explode("\n", $plan_features);


    for ($i=0; $i<$max_number_of_features; $i++) {
        // Check if tooltip to exclude initial print

        $nochars = '';

        if (empty($features[$i])) {
            $nochars = 'plan-item-empty';
        }

        if ( substr($features[$i], 0, 2 ) !== "- " ) {

            // DOES IT HAVE A TOOLTIP?
            if ( substr($features[$i + 1], 0, 2 ) === "- ") {
                $tooltip = true;
                $tooltipclass = 'has-tooltip';
            } else {
                $tooltip = false;
                $tooltipclass = 'no-tooltip';
            }

            // PRINT ROW TAG
            $html .= '<div class="plan-item plan-item-id-'.$i.' plan-item-'.$tooltipclass.' '.$nochars.'">'.$focusfeature[0];
            // PRINT CONTENT

            $html .= '<span>';
            if( $features[$i][0] === '*') { $html .= '<b>';}
            $html .= trim(str_replace(array("\n", "\r"), '', $features[$i]), '*');
            if( $features[$i][0] === '*') { $html .= '</b>';}
            $html .= '</span>';
            
            if ($tooltip) {
                $html .= '<div class="plan-item-tooltip plan-item-tooltip-id-'.$i.'">'.str_replace(array("\n", "\r"), '', substr($features[$i + 1], 2)).'</div>';
            }
            // PRINT CLOSING TAG
            $html .= '</div>';
        }
    }

    return $html;
}

function dh_ptp_generate_pricing_table($id)
{
    global $features_metabox;
    $meta = get_post_meta($id, $features_metabox->get_the_id(), TRUE);
 
    //call appropriate function
    return dh_ptp_generate_simple_flat_pricing_table_html($id);
}


