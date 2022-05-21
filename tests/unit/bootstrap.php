<?php
/**
 * PHPUnit bootstrap file
 */

require_once __DIR__ . '/../../vendor/autoload.php';

WP_Mock::setUsePatchwork( true );
WP_Mock::bootstrap();
