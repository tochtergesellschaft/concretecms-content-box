<?php

namespace Concrete\Package\TgsContentBox\Service;

use Concrete\Core\Backup\ContentImporter;

defined('C5_EXECUTE') or die(_('Access Denied.'));

class Install
{
    /**
     * Import and/or update pre-defined content from a xml-file into the cms.
     *
     * When installing or updating this package some predefined blocks/packages/user-groups etc. can
     * be installed or updated directly into the cms automatically.
     *
     * @return void
     */
    public function installXmlContent(): void
    {
        $importer = new ContentImporter();
        $importer->importContentFile('packages/tgs_content_box/config/install/install.xml');
    }
}
