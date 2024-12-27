<?php

namespace Concrete\Package\TgsContentBox\Factory;

use Concrete\Package\TgsContentBox\Model\ContentBox as ContentBoxModel;

defined('C5_EXECUTE') or die(_('Access Denied.'));

class ContentBox
{
    /**
     * Create a <code>ContentBox<code> model instance with the given data.
     *
     * @param array $data
     * @return ContentBoxModel
     */
    public function createFrom(array $data): ContentBoxModel
    {
        /** @var \Concrete\Package\TgsContentBox\Service\Transformer $transformer */
        $transformer = app('tgs/contentbox/transformer');

        $link = $transformer->getLinkByType($data['linkType'], $data['linkValue']);

        $image = $transformer->getImage($data['imgId']);
        $hasImage = is_object($image);
        $imagePath = '';

        if (is_object($image)) {
            $approvedVersion = $image->getApprovedVersion();

            if (is_object($approvedVersion)) {
                $imagePath = $approvedVersion->getRelativePath();
            }
        }

        /** @var \Concrete\Package\TgsContentBox\Model\ContentBox $cb */
        $cb = app('tgs/contentbox/model/contentbox');
        $cb->setBlockId($data['blockId']);
        $cb->setButtonType($transformer->buttonType($data['buttonType']));
        $cb->setImageFile($image);
        $cb->setImageAlt($data['imgAlt']);
        $cb->setHasImage($hasImage);
        $cb->setHasLink(!empty($link));
        $cb->setImageId($hasImage ? $data['imgId'] : null);
        $cb->setImagePath($imagePath);
        $cb->setImageLegend($data['imgLegend']);
        $cb->setLinkText($transformer->linkText($data['linkText']));
        $cb->setLinkType($data['linkType']);
        $cb->setLinkValue($data['linkValue']);
        $cb->setLinkTarget($data['linkTarget']);
        $cb->setLink($link);
        $cb->setText($transformer->richTextDecode($data['text']));

        return $cb;
    }
}
