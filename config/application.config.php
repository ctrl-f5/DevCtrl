<?php
return array(
    'modules' => array(
        'Application',
        'DoctrineModule',
        'DoctrineORMModule',
        'Auth',
        'DevCtrl',
        'Ctrl'
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            './module',
            './vendor',
            'Ctrl' => './vendor/ctrlf5/ctrl-lib/'
        ),
    ),
    'view_manager' => array(
        'display_exceptions'       => true,
    ),
);
