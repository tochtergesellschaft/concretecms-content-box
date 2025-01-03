<?php

namespace Concrete\Package\TgsContentBox\Definition;

defined('C5_EXECUTE') or die(_('Access Denied.'));

/**
 * Enumeration to outsource selectable link-types in the destination-picker.
 */
enum LinkType: string
{
    /**
     * Represents an undefined link-type.
     */
    case UNDEFINED = 'none';
    /**
     * Represents a link to an internal-page.
     *
     * The <pre>\Concrete\Core\Form\Service\DestinationPicker\DestinationPicker</pre> ui will handle
     * the selection of a page from the sitemap in the frontend.
     */
    case PAGE = 'page';
    /**
     * Represents a link to a file.
     *
     * The <pre>\Concrete\Core\Form\Service\DestinationPicker\DestinationPicker</pre> ui will handle
     * the selection of a file from the file-manager in the frontend.
     */
    case FILE = 'file';
    /**
     * Represents a link to an external URL.
     *
     * The <pre>\Concrete\Core\Form\Service\DestinationPicker\DestinationPicker</pre> ui will show
     * a simple text-input form-field in the frontend the user can paste the external url inside.
     */
    case EXTERNAL = 'external_url';
}
