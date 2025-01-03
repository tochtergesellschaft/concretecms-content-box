<?php

namespace Concrete\Package\TgsContentBox\Controller\SinglePage\Dashboard\TgsBackend;

use Concrete\Core\Page\Controller\DashboardPageController;
use Illuminate\Contracts\Container\BindingResolutionException;
use Symfony\Component\HttpFoundation\RedirectResponse;

defined('C5_EXECUTE') or die(_('Access Denied.'));

class ContentBoxSettings extends DashboardPageController
{
    /**
     * Config-Namespace prefix to the related package file-config.
     */
    private const CONFIG_NAMESPACE = 'tgs_content_box::general.blockSettings.';

    /**
     * Get the page-description of the current system-page.
     *
     * @return string
     */
    public function getCollectionDescription(): string
    {
        return tc('tgs_content-box', 'Configure default- and fallback-values for the content-box block.');
    }

    /**
     * Validate the request-input.
     *
     * Validates the input for <pre>buttonType</pre> and <pre>buttonText</pre> and adds error-items to the
     * <pre>\Concrete\Core\Error\ErrorList\ErrorList</pre>> if the validation fails.
     *
     * @return void
     */
    public function validate(): void
    {
        $buttonType = $this->request->request('buttonType');
        $buttonText = $this->request->request('buttonText');

        if (empty($buttonType)) {
            $this->error->add(tc('tgs_content-box', 'The field "Button-Type" is required.'));
        } else {
            if (preg_match('/\s/', $buttonType)) {
                $this->error->add(tc(
                    'tgs_content-box',
                    'The field "Button-Type" must not contain whitespaces.'
                ));
            } elseif (strlen($buttonType) > 255) {
                $this->error->add(tc(
                    'tgs_content-box',
                    'The field "Button-Type" may contain a maximum of 255 characters. Characters used: %s',
                    strlen($buttonType)
                ));
            } elseif (preg_match('/^[0-9]/', $buttonType) === 1) {
                $this->error->add(tc(
                    'tgs_content-box',
                    'The field "Button-Type" must not start with a number.'
                ));
            }
        }

        if (empty($buttonText)) {
            $this->error->add(tc('tgs_content-box', 'The field "Default Button-Text" is required.'));
        } else {
            if (strlen($buttonText) > 255) {
                $this->error->add(tc(
                    'tgs_content-box',
                    'The field "Default Button-Text" may contain a maximum of 255 characters. Characters used: %s',
                    strlen($buttonText)
                ));
            }
        }
    }

    /**
     * Validate and save the request-input.
     *
     * This method validates and saves the <pre>buttonType</pre> and <pre>buttonText</pre> values
     * settings to the file-config.
     *
     * @return RedirectResponse
     * @throws BindingResolutionException
     */
    public function save(): RedirectResponse
    {
        $this->validate();

        if ($this->error->has()) {
            $this->flash('error', tc('tgs_content-box', $this->error->toText()));
        } else {
            /** @var \Concrete\Core\Config\Repository\Repository $config */
            $config = $this->app->make('config');
            $buttonType = $this->request->request('buttonType');
            $buttonText = $this->request->request('buttonText');

            $config->save(static::CONFIG_NAMESPACE . 'buttonType', $buttonType);
            $config->save(static::CONFIG_NAMESPACE . 'buttonText', $buttonText);

            $this->flash('success', tc('tgs_content-box', 'Settings updated'));
        }

        return $this->buildRedirect($this->action());
    }

    /**
     * @throws BindingResolutionException
     */
    public function view(): void
    {
        $config = $this->app->make('config');

        $this->set('buttonType', $config->get(static::CONFIG_NAMESPACE . 'buttonType'));
        $this->set('buttonText', $config->get(static::CONFIG_NAMESPACE . 'buttonText'));
    }
}
