<?php

namespace Concrete\Package\TgsContentBox;

use Concrete\Core\Application\Application;
use Concrete\Core\Asset\AssetList;
use Concrete\Core\Foundation\Service\ProviderList;
use Concrete\Core\Http\Request;
use Concrete\Core\Package\Package;
use Concrete\Core\Package\PackageService;
use Concrete\Package\TgsContentBox\Service\Install as PackageInstaller;
use Concrete\Package\TgsContentBox\Service\Uninstall as PackageUninstaller;
use Concrete\Package\TgsContentBox\ServiceProvider as PackageServiceProvider;

defined('C5_EXECUTE') or die(_('Access Denied.'));

class Controller extends Package
{
	protected string $pkgHandle = 'tgs_content_box';
	protected $appVersionRequired = '9';
	protected string $pkgVersion = '0.0.1';
    /**
     * @var \Concrete\Core\Entity\Package $pkg
     */
    private $pkg;

    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->pkg = app(PackageService::class)->getByHandle($this->pkgHandle);
    }
	public function getPackageName(): string
    {
		return tc('tgs_content-box', 'ConcreteCMS - Content Box');
	}
	public function getPackageDescription(): string
    {
		return tc(
            'tgs_content-box',
            'Add image, text and button with only one block. Very easy to make custom templates from.'
        );
	}
    /**
     * This method will be executed when the package is loaded. This happens each request.
     * Therefore, we need to keep this method as clean as possible.
     *
     * @return void
     */
    public function on_start(): void
    {
        $this->registerAssets();
        $this->registerServices();
    }
    /**
     * @inheritdoc
     */
	public function install(): void
    {
		$this->pkg = parent::install();

        $this->importUpdateContent();
	}
    /**
     * @inerhitDoc
     */
    public function upgrade(): void
    {
        parent::upgrade();

        $this->importUpdateContent();
    }
    /**
     * @inheritdoc
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
	public function uninstall(): void
    {
		parent::uninstall();

        $request = app(Request::class);

        if ($request->request->get('remove-db-tables')) {
            $uninstaller = app(PackageUninstaller::class);
            $uninstaller->deleteDbTables();
        }
	}
    private function registerAssets(): void
    {
        $al = AssetList::getInstance();
        $al->register(
            'css',
            'tgs/content-box/view',
            'css/block/view.css',
            [
                'minify' => true,
                'combine' => true,
            ],
            $this
        );
    }
    private function registerServices(): void
    {
        $pl = new ProviderList($this->app);
        $pl->registerProvider(PackageServiceProvider::class);
    }
    private function importUpdateContent(): void
    {
        $installer = app(PackageInstaller::class);
        $installer->installXmlContent();
    }
}
