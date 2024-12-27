<?php

namespace Concrete\Package\TgsContentBox\Service;

use Doctrine\ORM\EntityManagerInterface;

defined('C5_EXECUTE') or die(_('Access Denied.'));

class Uninstall
{
    /**
     * Delete the package-related db-tables.
     *
     * @return void
     */
    public function deleteDbTables(): void
    {
        /** @var EntityManagerInterface $em */
        $em = app(EntityManagerInterface::class);
        $sm = $em->getConnection()->getSchemaManager();

        if ($sm->tablesExist(['btTgsContentBox'])) {
            $sm->dropTable('btTgsContentBox');
        }
    }
}
