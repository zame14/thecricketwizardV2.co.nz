<?php
function loadVCTemplates($vcDir = '') {
    if(!function_exists('vc_map')) return;
    // Set default
    if(!$vcDir) {
        $vcDir = STYLESHEETPATH . '/includes/vc_templates/';
    }
    if (is_dir($vcDir)) {
        if ( $dh = opendir( $vcDir ) ) {
            while ( ( $file = readdir( $dh ) ) !== false ) {
                if ( substr( $file, 0, 3 ) == 'vc_' && substr( $file, - 4 ) == '.php' ) {
                    require_once($vcDir . $file);
                }
            }
        }
    }
}