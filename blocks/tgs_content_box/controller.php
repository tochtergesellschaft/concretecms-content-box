<?php

namespace Concrete\Package\TgsContentBox\Block\TgsContentBox;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Error\ErrorList\ErrorList;
use Concrete\Core\Page\Theme\Theme;
use Illuminate\Contracts\Container\BindingResolutionException;

defined('C5_EXECUTE') or die(_('Access Denied.'));

class Controller extends BlockController
{
    protected $btTable = 'btTgsContentBox';
    protected $btInterfaceWidth = "700";
    protected $btInterfaceHeight = "700";
    protected $btDefaultSet = 'basic';

    /**
     * @var int|null $bID
     */
    protected $bID;

    /**
     * @var string|null $buttonText
     */
    protected $buttonText;

    /**
     * @var string|null $buttonType
     */
    protected $buttonType;

    /**
     * @var string|null $imgAlt
     */
    protected $imgAlt;

    /**
     * @var int|null $imgId
     */
    protected $imgId;

    /**
     * @var string|null $imgCaption
     */
    protected $imgCaption;

    /**
     * @var string $linkTarget
     */
    protected $linkTarget;

    /**
     * @var string|null $linkType
     */
    protected $linkType;

    /**
     * @var string|null $linkValue
     */
    protected $linkValue;

    /**
     * @var string|null $text
     */
    protected $text;

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getBlockTypeName(): string
    {
        return tc('tgs_content-box', 'Content Box');
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getBlockTypeDescription(): string
    {
        return tc('tgs_content-box', 'Add image, text and button with only one block.');
    }

    /**
     * @throws BindingResolutionException
     */
    public function add(): void
    {
        $this->prepareAddEdit();

        /** @var \Concrete\Package\TgsContentBox\Service\Transformer $transformer */
        $transformer = app('tgs/contentbox/transformer');

        $this->set('buttonType', $transformer->buttonType());
    }

    /**
     * @throws BindingResolutionException
     */
    public function edit(): void
    {
        $this->prepareAddEdit();
    }

    /**
     * {@inheritDoc}
     *
     * @param $args
     * @return ErrorList
     */
    public function validate($args): ErrorList
    {
        /** @var ErrorList $errList */
        $errList = parent::validate($args);

        // we need to validate the field "buttonText" because the db-column "buttonText"
        // can save only 255 characters.
        if (isset($args['buttonText'])) {
            if (strlen($args['buttonText']) > 255) {
                $msg = 'The "Button-Text" is too long (max. 255 characters). Current length: %s';

                $errList->add(tc('tgs_content-box', $msg, strlen($args['buttonText'])));
            }
        } else {
            $errList->add(tc('tgs_content-box', 'The field "Button-Text" is required.'));
        }

        return $errList;
    }

    /**
     * {@inheritDoc}
     *
     * @throws BindingResolutionException
     */
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

        $args['text'] = isset($args['text']) ? $transformer->richTextEncode($args['text']) : '';
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
     * @throws BindingResolutionException
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
     * Get the relevant block-data.
     *
     * Get the relevant block-data as array to build an instance of:
     * <pre>\Concrete\Package\TgsContentBox\Model\ContentBox</pre>
     *
     * @return array
     */
    public function getBlockData(): array
    {
        return [
            'blockId' => $this->bID,
            'buttonText' => $this->buttonText,
            'buttonType' => $this->buttonType,
            'imgAlt' => $this->imgAlt,
            'imgId' => $this->imgId,
            'imgCaption' => $this->imgCaption,
            'linkType' => $this->linkType,
            'linkValue' => $this->linkValue,
            'linkTarget' => $this->linkTarget,
            'text' => $this->text
        ];
    }
}
