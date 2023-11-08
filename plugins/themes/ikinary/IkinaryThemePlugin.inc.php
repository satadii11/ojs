<?php

import('lib.pkp.classes.plugins.ThemePlugin');

class IkinaryThemePlugin extends ThemePlugin
{
    /**
     * Load the custom styles for our theme
     */
    public function init()
    {
        $request = Application::get()->getRequest();

        $this->addStyle('stylesheet', 'styles/index.less');
        $this->addStyle('defaultStylesheet', 'defaultStyles/index.less');
        $this->addStyle('bootstrap', 'styles/bootstrap.min.css');

        $this->addStyle(
            'fontAwesome',
            $request->getBaseUrl() . '/lib/pkp/styles/fontawesome/fontawesome.css',
            ['baseUrl' => '']
        );

        // Store additional LESS variables to process based on options
        $additionalLessVariables = [];

        if ($this->getOption('typography') === 'notoSerif') {
            $this->addStyle('font', 'styles/fonts/notoSerif.less');
            $additionalLessVariables[] = '@font: "Noto Serif", -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen-Sans", "Ubuntu", "Cantarell", "Helvetica Neue", sans-serif;';
        } elseif (strpos($this->getOption('typography'), 'notoSerif') !== false) {
            $this->addStyle('font', 'styles/fonts/notoSans_notoSerif.less');
            if ($this->getOption('typography') == 'notoSerif_notoSans') {
                $additionalLessVariables[] = '@font-heading: "Noto Serif", serif;';
            } elseif ($this->getOption('typography') == 'notoSans_notoSerif') {
                $additionalLessVariables[] = '@font: "Noto Serif", serif;@font-heading: "Noto Sans", serif;';
            }
        } elseif ($this->getOption('typography') == 'lato') {
            $this->addStyle('font', 'styles/fonts/lato.less');
            $additionalLessVariables[] = '@font: Lato, sans-serif;';
        } elseif ($this->getOption('typography') == 'lora') {
            $this->addStyle('font', 'styles/fonts/lora.less');
            $additionalLessVariables[] = '@font: Lora, serif;';
        } elseif ($this->getOption('typography') == 'lora_openSans') {
            $this->addStyle('font', 'styles/fonts/lora_openSans.less');
            $additionalLessVariables[] = '@font: "Open Sans", sans-serif;@font-heading: Lora, serif;';
        } else {
            $this->addStyle('font', 'styles/fonts/notoSans.less');
        }

        if (!empty($additionalLessVariables)) {
            $this->modifyStyle('stylesheet', ['addLessVariables' => join("\n", $additionalLessVariables)]);
        }

        // Load jQuery from a CDN or, if CDNs are disabled, from a local copy.
        $min = Config::getVar('general', 'enable_minified') ? '.min' : '';
        $jquery = $request->getBaseUrl() . '/lib/pkp/lib/vendor/components/jquery/jquery' . $min . '.js';
        $jqueryUI = $request->getBaseUrl() . '/lib/pkp/lib/vendor/components/jqueryui/jquery-ui' . $min . '.js';
        // Use an empty `baseUrl` argument to prevent the theme from looking for
        // the files within the theme directory
        $this->addScript('jQuery', $jquery, ['baseUrl' => '']);
        $this->addScript('jQueryUI', $jqueryUI, ['baseUrl' => '']);

        $this->addMenuArea(['primary', 'user']);

        $templateManager = TemplateManager::getManager($request);
        $templateManager->assign('publicUrl', $request->getBaseUrl() . '/public');
    }

    /**
     * Get the display name of this theme
     *
     * @return string
     */
    public function getDisplayName()
    {
        return 'Ikinary Theme';
    }

    /**
     * Get the description of this plugin
     *
     * @return string
     */
    public function getDescription()
    {
        return 'Specific theme for Ikinary Project';
    }
}
