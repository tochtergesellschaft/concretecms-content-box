<?php

namespace Concrete\Package\TgsContentBox\Service;

use Concrete\Core\Backup\ContentImporter;

defined('C5_EXECUTE') or die(_('Access Denied.'));

class Install
{
    /**
     * Installs pre-defined content from a xml-file.
     *
     * @return void
     */
    public function installXmlContent(): void
    {
        $importer = new ContentImporter();
        $importer->importContentFile('packages/tgs_content_box/config/install/install.xml');
    }
}
