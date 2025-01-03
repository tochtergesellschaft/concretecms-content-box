<?php

namespace Concrete\Package\TgsContentBox\Model;

use Concrete\Core\Entity\File\File;
use Concrete\Core\Support\Facade\Application;

defined('C5_EXECUTE') or die(_('Access Denied.'));

class ContentBox implements \JsonSerializable
{
    /**
     * The block-id of the current block-instance.
     *
     * When adding a new block to the page the block-id's initial value is null.
     *
     * @var int|null $blockId
     */
    private ?int $blockId;
    /**
     * The button-type (button-color).
     *
     * Selectable values are collected from the page-theme <code>getColorCollection();</code> method.
     *
     * @var string $buttonType
     */
    private string $buttonType;
    /**
     * The image alternative-text.
     *
     * This text-value is only plain-text and not rich-text.
     *
     * @var string|null $imageAlt
     */
    private ?string $imageAlt;
    /**
     * The image-file object.
     *
     * Only ff an image was selected in the block-form.
     *
     * @var File|null $imageFile
     */
    private ?File $imageFile;
    /**
     * If an image was selected and found at the moment of use.
     *
     * True, if an image was selected and the corresponding image-file object was
     * found at the moment of use. False otherwise.
     *
     * @var bool $hasImage
     */
    private bool $hasImage;
    /**
     * If a link was selected and the url is not empty.
     *
     * True, if a link was selected and the link-url could be built and the link-url is not empty.
     * False, otherwise.
     *
     * @var bool $hasLink
     */
    private bool $hasLink;
    /**
     * The image-id.
     *
     * The image-id of the selected image. <code>null</code> if no image was selected or the image
     * was deleted since the block was saved.
     *
     * @var int|null $imageId
     */
    private ?int $imageId;
    /**
     * The image-path.
     *
     * The image-path of the selected image.
     *
     * @var string|null $imagePath
     */
    private ?string $imagePath;
    /**
     * The image-legend.
     *
     * This is only plain-text and not rich-text.
     *
     * @var string|null $imageLegend
     */
    private ?string $imageLegend;
    /**
     * The link-url.
     *
     * This value can be used as example in <code>href</code> html attributes.
     * This value will be built depending on the <code>$linkValue</code> property of this model.
     * Inside the database the page-id, file-id or the external-url will be saved. Therefore,
     * the link-url must be built differently sometimes.
     *
     * @var string $link
     */
    private string $link;
    /**
     * The button-text.
     *
     * The button-text of the link. This value is commonly used as button-text. If no text was
     * set via the block-form the fallback value of this config will be used:
     * <pre>app('config')->get('tgs_content_box::general.blockSettings.buttonText');</pre>
     *
     * @var string $buttonText
     */
    private string $buttonText;
    /**
     * The link-type.
     *
     * The link-type of the selected link. This value is used to detect which type of link
     * the user has selected. Values are outsourced here:
     * <pre>Concrete\Package\TgsContentBox\Definition\LinkType</pre>
     *
     * @var string|null $linkType
     */
    private ?string $linkType;
    /**
     * The raw link-value.
     *
     * The raw link-value of the selected link. This can be the page-id, file-id, the external-link
     * or nothing (if no link was selected/set). This value can not be used directly as example
     * inside html href attribute. Use the <code>$this->getLink()</code> method to get the
     * transformer link-url.
     *
     * @var string $linkValue
     */
    private string $linkValue;
    /**
     * The link-target.
     *
     * The link-target of the link. This is as default <code>_self</code> or <code>_blank</code>
     * The values can be set in this config:
     * <pre>app('config')->get('tgs_content_box::general.blockSettings.linkTargets');</pre>
     *
     * @var string $linkTarget
     */
    private string $linkTarget;
    /**
     * The text.
     *
     * The text. This is rich-text and not only plain-text. Therefore, print this value inside a
     * **div** html-tag (or similar tag) and not inside as example a **p** html-tag because this can cause
     * invalid html code (no paragraph inside paragraph and so on...).
     *
     * @var string|null $text
     */
    private ?string $text;

    public function setBlockId($blockId): void
    {
        $this->blockId = $blockId;
    }

    public function setButtonText($buttonText): void
    {
        $this->buttonText = $buttonText;
    }

    public function setButtonType($buttonType): void
    {
        $this->buttonType = $buttonType;
    }

    public function setImageAlt($imageAlt): void
    {
        $this->imageAlt = $imageAlt;
    }

    public function setImageFile($imageFile): void
    {
        $this->imageFile = $imageFile;
    }

    public function setHasImage($hasImage): void
    {
        $this->hasImage = $hasImage;
    }

    public function setHasLink($hasLink): void
    {
        $this->hasLink = $hasLink;
    }

    public function setImageId($imageId): void
    {
        $this->imageId = $imageId;
    }

    public function setImagePath($imagePath): void
    {
        $this->imagePath = $imagePath;
    }

    public function setImageLegend($imageLegend): void
    {
        $this->imageLegend = $imageLegend;
    }

    public function setLink($link): void
    {
        $this->link = $link ?? '';
    }

    public function setLinkType($linkType): void
    {
        $this->linkType = $linkType;
    }

    public function setLinkValue($linkValue): void
    {
        $this->linkValue = $linkValue ?? '';
    }

    public function setLinkTarget($linkTarget): void
    {
        $this->linkTarget = $linkTarget ?? '';
    }

    public function setText($text): void
    {
        $this->text = $text;
    }

    /**
     * The block-id of the current block-instance.
     *
     * When adding a new block to the page the block-id's initial value is null.
     *
     * @return int|null
     */
    public function getBlockId(): ?int
    {
        return $this->blockId;
    }

    /**
     * The button-text of the link.
     *
     * This value is commonly used as button-text. If no text was set via the block-form
     * the fallback value of this config will be used:
     * <pre>app('config')->get('tgs_content_box::general.blockSettings.buttonText');</pre>
     *
     * @return string
     */
    public function getButtonText(): string
    {
        return $this->buttonText;
    }

    /**
     * The button-type (or button-color).
     *
     * This is commonly a bootstrap color css-class as example <code>primary</code> or <code>secondary</code>.
     *
     * @return string
     */
    public function getButtonType(): string
    {
        return $this->buttonType;
    }

    /**
     * The image alternative-text.
     *
     * This is only plain-text and not rich-text.
     *
     * @return string|null
     */
    public function getImageAlt(): ?string
    {
        return $this->imageAlt;
    }

    /**
     * The image-file object.
     *
     * Will be collected if an image was selected in the block-form.
     *
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * If an image was selected and found at the moment of use.
     *
     * True, if an image was selected and the corresponding image-file object was found. False otherwise.
     * False as example when the file was deleted since the image was selected inside the block-form.
     *
     * @return bool
     */
    public function getHasImage(): bool
    {
        return $this->hasImage;
    }

    /**
     * If a link was selected and the url is not empty.
     *
     * True, if a link was selected and the link-url could be built and the link-url is not empty.
     * False, otherwise.
     *
     * @return bool
     */
    public function getHasLink(): bool
    {
        return $this->hasLink;
    }

    /**
     * The image-id of the selected image.
     * <code>null</code> if no image was selected or the image was deleted since the block was saved.
     *
     * @return int|null
     */
    public function getImageId(): ?int
    {
        return $this->imageId;
    }

    /**
     * The image-path of the selected image with option to include the base-url.
     *
     * @param bool $includeBaseUrl
     * @return string|null
     */
    public function getImagePath(bool $includeBaseUrl = false): ?string
    {
        if ($includeBaseUrl) {
            return Application::getApplicationURL() . $this->imagePath;
        }

        return $this->imagePath;
    }

    /**
     * The image-legend.
     *
     * This is only plain-text and not rich-text.
     *
     * @return string|null
     */
    public function getImageLegend(): ?string
    {
        return $this->imageLegend;
    }

    /**
     * The link-url.
     *
     * This value can be used as example in <code>href</code> html attributes.
     * This value will be built depending on the <code>$linkValue</code> property of this model.
     * Inside the database the page-id, file-id or the external-url will be saved. Therefore,
     * the link-url must be built differently sometimes.
     *
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * The link-rel.
     *
     * Depending on the *linkTarget* property.
     *
     * @return string
     */
    public function getLinkRel(): string
    {
        return $this->linkTarget === '_blank' ? 'noopener noreferrer' : '';
    }

    /**
     * The link-type of the selected link.
     *
     * This value is used to detect which type of link the user has selected.
     * Values are outsourced here:
     * <pre>Concrete\Package\TgsContentBox\Definition\LinkType</pre>
     *
     * @return string|null
     */
    public function getLinkType(): ?string
    {
        return $this->linkType;
    }

    /**
     * The raw link-value of the selected link.
     *
     * This can be the page-id, file-id, the external-link
     * or nothing (if no link was selected/set). This value can not be used directly as example
     * inside html href attribute. Use the <code>$this->getLink()</code> method to get the
     * transformed link-url.
     *
     * @return string
     */
    public function getLinkValue(): string
    {
        return $this->linkValue;
    }

    /**
     * The link-target of the link.
     *
     * This is as default <code>_self</code> or <code>_blank</code> The values can be set in this config:
     * <pre>app('config')->get('tgs_content_box::general.blockSettings.linkTargets');</pre>
     *
     * @return string
     */
    public function getLinkTarget(): string
    {
        return $this->linkTarget;
    }

    /**
     * The text.
     *
     * The text. This is rich-text and not only plain-text. Therefore, print this value inside a
     * **div** html-tag (or similar tag) and not inside as example a **p** html-tag because this can cause
     * invalid html code (no paragraph inside paragraph and so on...).
     *
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * Wrapper for <code>$this->hasImage()</code> method.
     *
     * True, if an image was selected and the corresponding image-file object was found. False otherwise.
     * False as example when the file was deleted since the image was selected inside the block-form.
     *
     * @return bool
     */
    public function hasImage(): bool
    {
        return $this->getHasImage();
    }

    /**
     * Wrapper for <code>$this->getHasLink()</code> method.
     *
     * True, if a link was selected and the link-url could be built and the link-url is not empty.
     * False, otherwise.
     *
     * @return bool
     */
    public function hasLink(): bool
    {
        return $this->getHasLink();
    }

    public function jsonSerialize(): array
    {
        return [
            // @TODO: ...
        ];
    }
}
