<?php

namespace Concrete\Package\TgsContentBox\Service;

use Concrete\Core\Application\Application;
use Concrete\Core\Application\ApplicationAwareInterface;
use Concrete\Core\Editor\LinkAbstractor;
use Concrete\Core\Entity\File\File as FileEntity;
use Concrete\Core\File\File;
use Concrete\Core\Page\Page;
use Concrete\Core\Page\Theme\Theme;

defined('C5_EXECUTE') or die(_('Access Denied.'));

class Transformer implements ApplicationAwareInterface
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
     * Get the current selected button-type (button-color). if no button-type was set we try to get the
     * first one of the theme color-collection. if no colors where defined we use
     * the default value "default".
     *
     * @param mixed $buttonType
     * @return string
     */
    public function buttonType($buttonType = ''): string
    {
        if (empty($buttonType)) {
            $theme = Theme::getSiteTheme();
            $themeColorCollection = $theme->getColorCollection();

            if (is_object($themeColorCollection) && !$themeColorCollection->isEmpty()) {
                /** @var \Concrete\Core\Page\Theme\Color\Color $defaultColor */
                $defaultColor = $themeColorCollection->first();

                return $defaultColor->getVariable();
            }

            /** @var \Concrete\Core\Config\Repository\Liaison $config */
            $config = app('config');

            return $config->get('tgs_content_box::general.blockSettings.buttonType', 'default');
        }

        return $buttonType;
    }
    /**
     * Find an image-ressource by file-id.
     *
     * @param $fId
     * @return FileEntity|null
     */
    public function getImage($fId): ?FileEntity
    {
        return File::getByID($fId);
    }
    /**
     * Get the link-url based on the given link-type. Either the page-id, file-id or the
     * external-url is stored in the database. We need to handle it different when building
     * the link-url.
     *
     * @param $linkType
     * @param mixed $value
     * @return string
     */
    public function getLinkByType($linkType = '', mixed $value): string
    {
        switch ($linkType) {
            case 'page':
                $page = Page::getByID($value);

                return is_object($page) && !$page->isError() ? $page->getCollectionLink() : '';

            case 'file':
                $file = File::getByID($value);
                $approvedVersion = is_object($file) ? $file->getApprovedVersion() : null;

                return is_object($approvedVersion) ? $approvedVersion->getRelativePath() : '';

            case 'external_url':
                return $value;

            case 'none':
            default:
                return '';
        }
    }
    /**
     * Transform encoded rich-text into normal text based on the current page's edit mode status.
     * This means abstract links are transformed to human-readable links etc.
     *
     * @param string $text The rich text to decode
     * @return string The decoded text if successful, null otherwise
     */
    public function richTextDecode($text = ''): string
    {
        $c = Page::getCurrentPage();

        if (is_object($c) && $c->isEditMode()) {
            $text = LinkAbstractor::translateFromEditMode($text);
        }

        return LinkAbstractor::translateFrom($text);
    }
    /**
     * Transform decoded rich-text. This is required when saving rich-text to the db.
     *
     * @param string $text The text to encode
     * @return string The encoded rich-text
     */
    public function richTextEncode($text = ''): string
    {
        return LinkAbstractor::translateTo($text);
    }

    /**
     * Get a valid button-text. If the link-text was not set get a fallback-value
     * from the related package-config.
     *
     * @param $buttonText
     * @return string
     */
    public function buttonText($buttonText = ''): string
    {
        if (empty($buttonText)) {
            /** @var \Concrete\Core\Config\Repository\Liaison $config */
            $config = app('config');

            return $config->get('tgs_content_box::general.blockSettings.buttonText', 'more');
        }

        return trim($buttonText);
    }
}
