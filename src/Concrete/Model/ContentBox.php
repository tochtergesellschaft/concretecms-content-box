<?php

namespace Concrete\Package\TgsContentBox\Model;

use Concrete\Core\Entity\File\File;
use Concrete\Core\Support\Facade\Application;

defined('C5_EXECUTE') or die(_('Access Denied.'));

class ContentBox implements \JsonSerializable
{
    private ?int $blockId;
    private string $buttonType;
    private ?File $imageFile;
    private ?string $imageAlt;
    private bool $hasImage;
    private bool $hasLink;
    private ?int $imageId;
    private ?string $imagePath;
    private ?string $imageLegend;
    private string $link;
    private ?string $linkText;
    private ?string $linkType;
    private string $linkValue;
    private string $linkTarget;
    private ?string $text;

    public function setBlockId($blockId): void
    {
        $this->blockId = $blockId;
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
    public function setLinkText($linkText): void
    {
        $this->linkText = $linkText;
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
     * Get the id of the current block-instance.
     *
     * @return int
     */
    public function getBlockId(): int
    {
        return $this->blockId;
    }
    /**
     * The button-type (or button-color). Selectable values are collected from the page-theme
     * <code>getColorCollection()</code> method.
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
     * @return string|null
     */
    public function getImageAlt(): ?string
    {
        return $this->imageAlt;
    }
    /**
     * The image-object of the selected file.
     *
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
    /**
     * True, if an image was selected in the block-form and the related file-object
     * was found at this moment.
     *
     * @return bool
     */
    public function getHasImage(): bool
    {
        return $this->hasImage;
    }
    /**
     * True, if an external-url was set or an url could be extracted from the selected file/page.
     *
     * @return bool
     */
    public function getHasLink(): bool
    {
        return $this->hasLink;
    }
    /**
     * The file-id of the selected image.
     *
     * @return int|null
     */
    public function getImageId(): ?int
    {
        return $this->imageId;
    }
    /**
     * The image-path with option to include the base-url of the selected image.
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
     * @return string|null
     */
    public function getImageLegend(): ?string
    {
        return $this->imageLegend;
    }
    /**
     * The link-rel depending on the <code>linkTarget</code> property.
     *
     * @return string
     */
    public function getLinkRel(): string
    {
        return $this->linkTarget === '_blank' ? 'noopener noreferrer' : '';
    }
    /**
     * The link-text. Commonly used as button-text.
     *
     * @return string|null
     */
    public function getLinkText(): ?string
    {
        return $this->linkText;
    }
    /**
     * The type of the link. Commonly used to detect if the user has selected a file
     * page or external-url as link.
     *
     * @return string|null
     */
    public function getLinkType(): ?string
    {
        return $this->linkType;
    }
    /**
     * The raw value of the selected link. This can be the file-id, page-id or the full
     * external-url. This value can not be used as example directly inside a href.
     *
     * @return mixed
     */
    public function getLinkValue(): mixed
    {
        return $this->linkValue;
    }
    /**
     * The transformed link. As example this value can be used inside a href.
     *
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }
    /**
     * The selected link-target. As example <code>_self</code> or <code>_blank</code>.
     * @return string
     */
    public function getLinkTarget(): string
    {
        return $this->linkTarget;
    }
    /**
     * The text (rich-text).
     *
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }
    /**
     * Wrapper for <code>$this->>getHasLink()</code> method.
     *
     * @return bool
     */
    public function hasImage(): bool
    {
        return $this->getHasImage();
    }
    /**
     * Wrapper for <code>$this->>getHasLink()</code> method.
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
