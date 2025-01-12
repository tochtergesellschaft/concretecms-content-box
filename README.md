# ConcreteCMS - Content Box

The Content Box package adds the Content Box block to your concreteCMS site. With the Content Box, you can easily insert
rich text, an image from the file manager, and a link through the block form. You can choose a link to an internal page
from the sitemap, a link to an internal file from the file-manager, or simply paste an external URL. You also have the
option to leave the link field blank, in which case no button will appear on the page.

This package comes with two custom built-in block templates for the Content Box block. The block's design is fully
responsive, ensuring it adapts to various screen sizes.

Upon installation, the package also creates a new page (single-page) in the CMS backend, where you can configure default
settings for the Content Box.

Thanks to the straightforward handling of block data through the Content-Box Model and the block view (view.php),
creating custom block templates is quick and very easy.

By minimizing unnecessary setting options in the block form, the Content Box is very user-friendly.

The UI of this package is (currently) available in following languages:

* English
* German

Contact me if you need some other langauges!

## Installation

Make sure that the system requirements are met before installing this package to avoid errors.
The recommended way to install this package is via composer.

To install the package, perform the following steps:

1. Download and unzip the package-directory.
2. Move the inner `tga_content_box` folder into your website's `packages` folder.
   The directory-structure should now look like: `/public/packages/tga_content_box`.
3. Log in to your website as admin.
4. Navigate to the **Extend Concrete** dashboard-page (https://example.domain/dashboard/extend/install).
   At the bottom of this page in the **Awaiting Installation** section the package **ConcreteCMS - Content Box**
   should be listed now.
5. Press (**single-klick** NOT double-click) **Install** next to the **ConcreteCMS - Content Box** package.
6. Wait until the page is loaded again completely. The **ConcreteCMS - Content Box** package should now be listet now
   in the **Currently Installed** section.
7. The **Content-Box**-Block was added to the block-set **basic**. You can use the new block now.
8. If you don't have any color-collection configured in your theme you may want to change the
   default button-type (button-color). You can go to the **Content Box Settings**
   dashboard-page (https://example.domain/dashboard/tgs_backend/content_box_settings) and adjust the default values.

## Requirements

* PHP 8.*
* ConcreteCMS 9.*

## Examples

### ContentBox Model

To work with the block-data you can simply use the `Concrete\Package\TgsContentBox\Model\ContentBox` model.
You can create a new instance of the `ContentBox`-Model by using the `tgs/contentbox/factory/contentbox`-service

```php
// creating a ContentBox-Model using the current block-data.
/** @var Concrete\Package\TgsContentBox\Block\TgsContentBox\Controller $blockController */
$relevantBlockData = $blockController->getBlockData();

/** @var \Concrete\Package\TgsContentBox\Model\ContentBox $cb */
$contentBox = app('tgs/contentbox/factory/contentbox')->createFrom($relevantBlockData);

echo $contentBox->getBlockId(); // int|null
echo $contentBox->getButtonType(); // string
echo $contentBox->getImageAlt(); // string
echo $contentBox->hasImage(); // bool
echo $contentBox->getLink(); // string
// etc.
```

## Additional Developer-Info

Package-Handle: `tgs_content_box`<br>
Block-Handle: `tgs_content_box`<br>
Package-Controller: `Concrete\Package\TgsContentBox\Controller`<br>
Block-Controller: `Concrete\Package\TgsContentBox\Block\TgsContentBox\Controller`<br>
ContentBox Factory: `Concrete\Package\TgsContentBox\Factory\ContentBox`<br>
ContentBox Model: `Concrete\Package\TgsContentBox\Model\ContentBox`

## Troubleshooting

If you got some issues while using this package feel free to contact me on the
[Marketplace](https://community.concretecms.com/members/profile/329451) or report an Issue on
[GitHub](https://github.com/tochtergesellschaft/concretecms-content-box/issues).

