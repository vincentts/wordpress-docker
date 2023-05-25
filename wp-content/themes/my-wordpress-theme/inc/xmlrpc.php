<?php

add_filter( 'xmlrpc_enabled', '__return_false' );

add_filter('xmlrpc_methods', function () {
    return [];
}, PHP_INT_MAX);