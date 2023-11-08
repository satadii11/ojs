{**
 * templates/frontend/pages/aboutThisPublishingSystem.tpl
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @brief Display the page to view details about the OJS software.
 *
 * @uses $currentContext Journal The journal currently being viewed
 * @uses $appVersion string Current version of OJS
 * @uses $contactUrl string URL to the journal's contact page
 *}
{include file="frontend/components/header.tpl" pageTitle="about.aboutContext"}
<div class="d-flex flex-row">
    <div class="page page_about">
        {include file="frontend/components/breadcrumbs.tpl" currentTitleKey="about.aboutContext"}
        <h1>
            {translate key="about.aboutContext"}
        </h1>
        {include file="frontend/components/editLink.tpl" page="management" op="settings" path="context" anchor="masthead" sectionTitleKey="about.aboutContext"}

        {$currentContext->getLocalizedData('about')}
    </div><!-- .page -->

    {include file="frontend/components/sidebar.tpl"}
</div>

{include file="frontend/components/footer.tpl"}
