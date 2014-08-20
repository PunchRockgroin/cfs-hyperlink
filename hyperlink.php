<?php

class cfs_hyperlink extends cfs_field
{

    function __construct() {
        $this->name = 'hyperlink';
        $this->label = __( 'Hyperlink', 'cfs' );
    }


    function html( $field ) {
        if ( empty( $field->value ) ) {
            $field->value = array(
                'url'       => 'http://',
                'text'      => '',
                'class'     => '',
                'target'    => '',
            );
        }
    ?>
        <div class="cfs-hyperlink" style="overflow:hidden;">
		    <div class="cfs-hyperlink-url" style="width:49%;float:left;">
                <div>URL</div>
                <input type="text" name="<?php echo $field->input_name; ?>[url]" class="link-url" value="<?php echo $field->value['url']; ?>" />
		    </div>
		    <div class="cfs-hyperlink-text" style="width:49%;float:right;">
                <div>Link Text</div>
                <input type="text" name="<?php echo $field->input_name; ?>[text]" class="link-text" value="<?php echo $field->value['text']; ?>" />
		    </div>
            <div class="cfs-hyperlink-target" style="width:49%;float:left;padding-top:1em;">
                <label for="<?php echo $field->input_name; ?>_target">
                    <input type="checkbox" name="<?php echo $field->input_name; ?>[target]" class="link-target" value="_blank" <?php echo (isset($field->value['target']) && $field->value['target'] != ''  ? 'checked' : ''); ?>  />
                    <span>Open in new window?</span>
                </label>
            </div>
	    </div>
    <?php
    }


    function pre_save( $value, $field ) {
        // convert to a proper associative array when inside a Loop
	    if ( isset( $value[0]['url'] ) && isset( $value[1]['text'] ) ) {
		    $value = array(
			    'url' => $value[0]['url'],
                'text' => $value[1]['text'],
			    'target' => $value[2]['target'],
		    );
	    }
        return serialize( $value );
    }


    function prepare_value( $value, $field ) {
        return unserialize( $value[0] );
    }


    function format_value_for_api( $value, $field ) {
        $output = '';

        if ( ! empty( $value['url'] ) ) {
            $output = '<a href="' . $value['url'] . '" target="' . $value['target'] . '">' . $value['text'] . '</a>';
        }

        return $output;
    }
}
