<!DOCTYPE html>
<html lang="{$currentLocale|replace:"_":"-"}" xml:lang="{$currentLocale|replace:"_":"-"}">
{if !$pageTitleTranslated}{capture assign="pageTitleTranslated"}{translate key=$pageTitle}{/capture}{/if}
{include file="frontend/components/headerHead.tpl"}
<body>
    <div class="main_content">
        <header>
            <div class="logo_wrapper d-flex flex-row justify-content-between">
                <div class="site_logo">
                    {capture assign="homeUrl"}
                        {url page="index" router=\PKP\core\PKPApplication::ROUTE_PAGE}
                    {/capture}

                    <a href="{$homeUrl}" class="is_img">
                        <img src="{$publicUrl}/logo_header.png" />
                    </a>
                </div>
                <div class="d-flex flex-column justify-content-between">
                    <div class="navigation_user_wrapper">
                        {load_menu name="user" ulClass="navigation_user"}
                    </div>

                    {if $currentContext && $requestedPage !== 'search'}
                        <div class="navigation_search_wrapper align-self-end">
                            <a href="{url page="search"}" class="pkp_search pkp_search_desktop">
                                <span class="fa fa-search" aria-hidden="true"></span>
                                {translate key="common.search"}
                            </a>
                        </div>
                    {/if}
                </div>
            </div>

            {capture assign="primaryMenu"}
                {load_menu name="primary" ulClass="navigation_primary"}
            {/capture}

            <div class="menu_wrapper d-flex flex-row">
                <nav class="nav_primary_menu flex-fill">
                    {$primaryMenu}
                </nav>

                <div style="width: 307px;margin-right: 21px;border-left: black solid 1px;" />
            </div>
        </header>

        <div class="structure_content">
            <div class="structure_main" role="main">
                <a id="content_main"></a>