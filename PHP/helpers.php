<?php

function dump(...$data)
{
    $backgroundColor = 'black';
    $borderColor = '#ccc';

    echo '<pre style="background-color: ' . $backgroundColor . '; border: 1px solid ' . $borderColor . '; padding: 10px; margin: 2px; border-radius: 5px;">';

    if (!empty($data)) {
        foreach ($data as $key => $value) {
            echo '<code style="display: block; white-space: pre-wrap;">';
            echo '<span style="color: lime;">' . htmlspecialchars(var_export($value, true)) . '</span>';
            echo '</code>';
        }
    } else {
        echo '<strong>No data to dump</strong>';
    }

    echo '</pre>';
}

