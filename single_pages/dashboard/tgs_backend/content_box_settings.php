<?php

defined('C5_EXECUTE') or die(_('Access Denied.'));

/** @var \Concrete\Core\Form\Service\Form $form */
/** @var \Concrete\Core\Page\View\PageView $view */
/** @var string $buttonText */
/** @var string $buttonType */
?>
<form action="<?php echo $view->action('save'); ?>"
      class="ccm-dashboard-content-form"
      method="post"
      id="mesch-spacer-settings">
    <div class="mb-3">
        <?php
        echo $form->label('buttonType', tc('tgs_content-box', 'Fallback Button-Type'));
        echo $form->text('buttonType', $buttonType);
        ?>
    </div>
    <div class="mb-3">
        <?php
        echo $form->label('buttonText', tc('tgs_content-box', 'Default Button-Text'));
        echo $form->text('buttonText', $buttonText);
        ?>
    </div>
    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <button class="pull-right float-end btn btn-primary" type="submit" ><?php echo t('Save'); ?></button>
        </div>
    </div>
</form>
