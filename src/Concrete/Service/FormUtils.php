<?php

namespace Concrete\Package\TgsContentBox\Service;

use Concrete\Core\Application\ApplicationAwareInterface;
use Concrete\Core\Application\Application;
use Concrete\Core\Application\Service\FileManager;
use Concrete\Core\Application\Service\UserInterface;
use Concrete\Core\Editor\CkeditorEditor;
use Concrete\Core\Form\Service\DestinationPicker\DestinationPicker;
use Concrete\Package\TgsContentBox\Definition\LinkType;
use Illuminate\Contracts\Container\BindingResolutionException;

defined('C5_EXECUTE') or die(_('Access Denied.'));

class FormUtils implements ApplicationAwareInterface
{
    /**
     * @var Application $app
     */
    protected $app;

    public function setApplication(Application $application): void
    {
        $this->app = $application;
    }
    /**
     * @return UserInterface
     * @throws BindingResolutionException
     */
    public function getUserInterface(): UserInterface
    {
        return $this->app->make(UserInterface::class);
    }
    /**
     * @return FileManager
     * @throws BindingResolutionException
     */
    public function getFileManager(): FileManager
    {
        return $this->app->make(FileManager::class);
    }
    /**
     * @return DestinationPicker
     * @throws BindingResolutionException
     */
    public function getDestinationPicker(): DestinationPicker
    {
        return $this->app->make(DestinationPicker::class);
    }
    /**
     * Get the text-editor helper-class with option to deselect editor-tools.
     *
     * @param array $deselect
     * @return CkeditorEditor
     * @throws BindingResolutionException
     */
    public function getTextEditor(array $deselect = []): CkeditorEditor
    {
        $editor = $this->app->make(CkeditorEditor::class);

        if (count($deselect)) {
            $editor->getPluginManager()->deselect($deselect);
        }

        return $editor;
    }
    /**
     * Get the predefined link types to choose from in the block-form. In the external-link-type
     * the data length is limited to 255 characters.
     *
     * @return array
     */
    public function getDestinationLinkPickerTypes(): array
    {
        return [
            LinkType::UNDEFINED->value,
            LinkType::PAGE->value,
            LinkType::FILE->value,
            LinkType::EXTERNAL->value => ['maxlength' => 255],
        ];
    }
}
