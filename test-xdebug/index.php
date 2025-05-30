<?php
var_dump(extension_loaded('xdebug'));
if (function_exists('xdebug_info')) {
    xdebug_info();
} else {
    phpinfo();
}
?>