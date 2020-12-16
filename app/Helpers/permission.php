<?php

function permission_modules() {
    return [
        [ 'label' => 'Draw', 'key' => 'Draw' ],
        [ 'label' => 'Prize', 'key' => 'Prize' ],
        [ 'label' => 'Phone', 'key' => 'Phone' ],

        [ 'label' => 'Setting', 'key' => 'Setting' ],
        [ 'label' => 'Administration', 'key' => 'Administration' ],
    ];
}
function permission_actions() {
    return [
        [ 'label' => 'Read', 'key' => 'Read' ],
        [ 'label' => 'Create', 'key' => 'Create' ],
        [ 'label' => 'Edit', 'key' => 'Edit' ],
        [ 'label' => 'Delete', 'key' => 'Delete' ],
    ];
}
