<?php

namespace Concrete\Package\TgsContentBox\Definition;

defined('C5_EXECUTE') or die(_('Access Denied.'));

/**
 * Enum to outsource selectable link-types in the destination-picker.
 */
enum LinkType: string
{
    case UNDEFINED = 'none';
    case PAGE = 'page';
    case FILE = 'file';
    case EXTERNAL = 'external_url';
}
