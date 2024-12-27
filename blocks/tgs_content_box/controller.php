<?php

namespace Concrete\Package\TgsContentBox\Block\TgsContentBox;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Page\Theme\Theme;

defined('C5_EXECUTE') or die(_('Access Denied.'));

class Controller extends BlockController
{
    protected $btTable = 'btTgsContentBox';
    protected $btInterfaceWidth = "700";
    protected $btInterfaceHeight = "700";
    protected $btDefaultSet = 'basic';

    /** @var int|null $bID */
    protected $bID;

    /** @var string|null $buttonType */
    protected $buttonType;

    /** @var string|null $imgAlt */
    protected $imgAlt;

    /** @var int|null $imgId */
    protected $imgId;

    /** @var string|null $imgLegend */
    protected $imgLegend;

    /** @var string $linkTarget */
    protected $linkTarget;

    /** @var string|null $linkText */
    protected $linkText;

    /** @var string|null $linkType */
    protected $linkType;

    /** @var string|null $linkValue */
    protected $linkValue;

    /** @var string|null $text */
    protected $text;

    public function getBlockTypeName(): string
    {
		return tc('tgs_content-box', 'Content Box');
	}
	public function getBlockTypeDescription(): string
    {
		return tc('tgs_content-box', 'Add image, text and button with only one block.');
	}
    public function add(): void
    {
        $this->prepareAddEdit();

        /** @var \Concrete\Package\TgsContentBox\Service\Transformer $transformer */
        $transformer = app('tgs/contentbox/transformer');

        $this->set('buttonType', $transformer->buttonType());
    }
    public function edit(): void
    {
        $this->prepareAddEdit();
    }
    public function validate($args)
    {
        /** @var \Concrete\Core\Error\ErrorList\ErrorList $errList */
        $errList = parent::validate($args);

        // we need to validate the "linkText" because the db-column "linkText" can save only 255 characters.
        if (strlen($args['linkText']) > 255) {
            $msg = 'The "Link-Text" is too long (max. 255 characters). Current length: %s';

            $errList->add(tc('tgs_content-box', $msg, strlen($args['imgAlt'])));
        }

        return $errList;
    }
    public function save($args): void
    {
        /** @var \Concrete\Package\TgsContentBox\Service\FormUtils $utils */
        $utils = app('tgs/contentbox/form/utils');

        /** @var \Concrete\Package\TgsContentBox\Service\Transformer $transformer */
        $transformer = app('tgs/contentbox/transformer');

        list($linkType, $linkValue) = $utils->getDestinationPicker()->decode(
            'linkHandler',
            $utils->getDestinationLinkPickerTypes(),
            null,
            null,
            $args
        );

        $args['text'] = $transformer->richTextEncode($args['text']);
        $args['imgId'] = !empty($args['imgId']) ? $args['imgId'] : 0;
        $args = $args + [
            'linkType' => $linkType,
            'linkValue' => $linkValue
        ];

        parent::save($args);
    }
    public function view(): void
    {
        $this->requireAsset('css', 'tgs/content-box/view');

        /** @var \Concrete\Package\TgsContentBox\Model\ContentBox $cb */
        $cb = app('tgs/contentbox/factory/contentbox')->createFrom($this->getBlockData());
        
        $this->set('cb', $cb);
    }
    /**
     * Set some default values/helpers when adding or editing the current block-instance.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function prepareAddEdit(): void
    {
        /** @var \Concrete\Package\TgsContentBox\Service\FormUtils $utils */
        $utils = app('tgs/contentbox/form/utils');

        /** @var \Concrete\Package\TgsContentBox\Model\ContentBox $cb */
        $cb = app('tgs/contentbox/factory/contentbox')->createFrom($this->getBlockData());

        $theme = Theme::getSiteTheme();

        $this->set('cb', $cb);
        $this->set('destinationPicker', $utils->getDestinationPicker());
        $this->set('fileManager', $utils->getFilemanager());
        $this->set('linkTargets', app('config')->get('tgs_content_box::general.blockSettings.linkTargets', []));
        $this->set('linkTypes', $utils->getDestinationLinkPickerTypes());
        $this->set('textEditor', $utils->getTextEditor());
        $this->set('themeColorCollection', $theme->getColorCollection());
        $this->set('userInterface', $utils->getUserInterface());
    }
    /**
     * Get the relevant block-data as array for later use.
     *
     * @return array
     */
    public function getBlockData(): array
    {
        return [
            'blockId' => $this->bID,
            'buttonType' => $this->buttonType,
            'imgAlt' => $this->imgAlt,
            'imgId' => $this->imgId,
            'imgLegend' => $this->imgLegend,
            'linkText' => $this->linkText,
            'linkType' => $this->linkType,
            'linkValue' => $this->linkValue,
            'linkTarget' => $this->linkTarget,
            'text' => $this->text
        ];
    }
}
