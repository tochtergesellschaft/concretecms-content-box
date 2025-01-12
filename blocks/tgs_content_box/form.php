<?php

defined('C5_EXECUTE') or die(_('Access Denied.'));

/**
 * @var \Concrete\Core\Application\Service\FileManager $fileManager
 * @var \Concrete\Core\Application\Service\UserInterface $userInterface
 * @var \Concrete\Core\Editor\CkeditorEditor $textEditor
 * @var \Concrete\Core\Form\Service\DestinationPicker\DestinationPicker $destinationPicker
 * @var \Concrete\Core\Form\Service\Form $form
 * @var \Concrete\Core\Page\Theme\Color\ColorCollection $themeColorCollection
 * @var \Concrete\Package\TgsContentBox\Model\ContentBox $cb
 * @var array $linkTargets
 * @var array $linkTypes
 */

echo $userInterface->tabs([
    ['content-box-text', tc('tgs_content-box', 'Text'), true],
    ['content-box-image', tc('tgs_content-box', 'Image')],
    ['content-box-button', tc('tgs_content-box', 'Link / Button')]
]);
?>
<div class="tab-content">
    <div id="content-box-text" class="ccm-tab-content tab-pane active" role="tabpanel">
        <div class="form-group mb-3">
            <?php
            echo $form->label('text', tc('tgs_content-box', 'Text'));
            echo $textEditor->outputBlockEditModeEditor('text', $cb->getText());
            ?>
        </div>
    </div>
    <div id="content-box-image" class="ccm-tab-content tab-pane" role="tabpanel">
        <div class="form-group mb-3">
            <?php
            echo $form->label('imgId', tc('tgs_content-box', 'Image'));
            echo $fileManager->image(
                'imgId',
                'imgId',
                tc('tgs_content-box', 'Select image'),
                $cb->getImageId()
            );
            ?>
        </div>
        <div class="form-group mb-3">
            <?php
            echo $form->label('imgAlt', tc('tgs_content-box', 'Alternative-Text'));
            echo $form->text('imgAlt', $cb->getImageAlt());
            ?>
        </div>
        <div class="form-group mb-3">
            <?php
            echo $form->label('imgCaption', tc('tgs_content-box', 'Image-Caption'));
            echo $form->textarea('imgCaption', $cb->getImageCaption(), ['rows' => 5]);
            ?>
        </div>
    </div>
    <div id="content-box-button" class="ccm-tab-content tab-pane" role="tabpanel">
        <div class="form-group">
            <?php
            echo $form->label('linkHandler', tc('tgs_content-box', 'Link'));
            echo $destinationPicker->generate(
                'linkHandler',
                $linkTypes,
                $cb->getLinkType(),
                $cb->getLinkValue()
            );
            ?>
        </div>
        <div class="form-group mb-3">
            <?php
            echo $form->label('linkTarget', tc('tgs_content-box', 'Link-Target'));
            echo $form->select(
                'linkTarget',
                $linkTargets,
                $cb->getLinkTarget()
            );
            ?>
        </div>
        <div class="form-group mb-3">
            <?php
            echo $form->label('buttonText', tc('tgs_content-box', 'Button-Text'));
            echo $form->text('buttonText', $cb->getButtonText());
            ?>
        </div>
        <?php if ($themeColorCollection) { ?>
            <div class="form-group mb-3">
                <?php echo $form->label('buttonType', tc('tgs_content-box', 'Button-Type')); ?>
                <div data-vue-app="content-box-backend">
                    <concrete-theme-color-input :color-collection='<?php echo json_encode($themeColorCollection); ?>'
                                                color="<?php echo $cb->getButtonType(); ?>"
                                                input-name="buttonType"></concrete-theme-color-input>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php // @TODO: outsource js/css into separate asset-files. ?>
<script type="text/javascript">
    $(function () {
        Concrete.Vue.activateContext('cms', function (Vue, config) {
            new Vue({
                el: 'div[data-vue-app=content-box-backend]',
                components: config.components
            });
        });
    });
</script>
<style>
    .cke_wysiwyg_div.cke_editable {
        min-height: 350px;
    }
</style>
