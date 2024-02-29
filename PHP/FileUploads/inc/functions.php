<?php


function dd2(...$data)
{
    echo '<pre style="background-color: #f1f1f1; border: 1px solid #ccc; padding: 10px; margin: 10px; border-radius: 5px;">';
    echo '<code>';
    highlight_string("<?php\n" . var_export($data, true));
    echo '</code>';
    echo '</pre>';
}


function dd(...$data)
{
    $backgroundColor = '#f1f1f1';
    $borderColor = '#ccc';

    echo '<pre style="background-color: ' . $backgroundColor . '; border: 1px solid ' . $borderColor . '; padding: 10px; margin: 10px; border-radius: 5px;">';

    if (!empty($data)) {
        foreach ($data as $key => $value) {
            echo '<code>';
            highlight_string("<?php\n" . var_export($value, true));
            echo '</code>';
        }
    } else {
        echo '<strong>No data to dump</strong>';
    }

    echo '</pre>';
    die();
}

function dump(...$data)
{
    $backgroundColor = '#f1f1f1';
    $borderColor = '#ccc';

    echo '<pre style="background-color: ' . $backgroundColor . '; border: 1px solid ' . $borderColor . '; padding: 10px; margin: 10px; border-radius: 5px;">';

    if (!empty($data)) {
        foreach ($data as $key => $value) {
            echo '<code>';
            highlight_string("<?php\n" . var_export($value, true));
            echo '</code>';
        }
    } else {
        echo '<strong>No data to dump</strong>';
    }

    echo '</pre>';
}
