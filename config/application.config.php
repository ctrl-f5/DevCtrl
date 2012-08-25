<?php
return array(
    'modules' => array(
        'DoctrineModule',
        'DoctrineORMModule',
        'Ctrl\Module\Auth',
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
            'Ctrl\Module\Auth' => './vendor/ctrl-f5/ctrlAuth/',
            'Ctrl' => './vendor/ctrl-f5/ctrllib/',
        ),
    ),
    'view_manager' => array(
        'display_exceptions'       => true,
    ),
);
