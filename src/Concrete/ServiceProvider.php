<?php

namespace Concrete\Package\TgsContentBox;

use Concrete\Core\Foundation\Service\Provider as CoreServiceProvider;
use Concrete\Package\TgsContentBox\Model\ContentBox as ContentBoxModel;
use Concrete\Package\TgsContentBox\Factory\ContentBox as ContentBoxFactory;
use Concrete\Package\TgsContentBox\Service\FormUtils;
use Concrete\Package\TgsContentBox\Service\Install;
use Concrete\Package\TgsContentBox\Service\Uninstall;
use Concrete\Package\TgsContentBox\Service\Transformer;

defined('C5_EXECUTE') or die(_('Access Denied.'));

class ServiceProvider extends CoreServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->app->singleton('tgs/contentbox/form/utils', FormUtils::class);
        $this->app->singleton('tgs/contentbox/factory/contentbox', ContentBoxFactory::class);
        $this->app->singleton('tgs/contentbox/install', Install::class);
        $this->app->singleton('tgs/contentbox/model/contentbox', ContentBoxModel::class);
        $this->app->singleton('tgs/contentbox/transformer', Transformer::class);
        $this->app->singleton('tgs/contentbox/uninstall', Uninstall::class);
    }
}
