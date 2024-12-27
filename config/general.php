<?php

defined('C5_EXECUTE') or die(_('Access Denied.'));

return [
    'blockSettings' => [
        // the default button-type (button-color) if no one was set ond no
        // theme-color-collection was defined.
        'buttonType' => 'primary',
        // the link-targets the user can select in the block-form.
        'linkTargets' => [
            '_self' => tc('tgs_content-box', 'Same Window (_self)'),
            '_blank' => tc('tgs_content-box', 'New Window (_blank)')
        ],
        'linkText' => tc('tgs_content-box', 'more')
    ]
];
