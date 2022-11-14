<?php

// Allow svg files upload
add_filter('upload_mimes', 'pga_mime_types');
function pga_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
