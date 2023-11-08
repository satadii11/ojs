{**
 * templates/frontend/components/footer.tpl
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @brief Common site frontend footer.
 *
 * @uses $isFullWidth bool Should this page be displayed without sidebars? This
 *       represents a page-level override, and doesn't indicate whether or not
 *       sidebars have been configured for thesite.
 *}

</div><!-- pkp_structure_main -->

{* Sidebars *}
{if empty($isFullWidth)}
    {capture assign="sidebarCode"}{call_hook name="Templates::Common::Sidebar"}{/capture}
    {if $sidebarCode}
        <div class="pkp_structure_sidebar left" role="complementary">
            {$sidebarCode}
        </div><!-- pkp_sidebar.left -->
    {/if}
{/if}
</div><!-- pkp_structure_content -->

<div class="footer_wrapper" role="contentinfo">
    <div class="d-flex flex-row">
        <div class="d-flex flex-column flex-grow-1">
            <p class="text-published">Published By</p>
            <img class="logo-footer" src="{$publicUrl}/logo_footer.svg" />
            <p class="text-cv">CV. IKINARY PROGRESSIVE PUBLISHER</p>
            <p class="text-copyright d-flex flex-row align-items-center">
                Copyright 
                <span style="margin-left:4px" class="text-copy-bold">&copy;</span>
                <span style="margin-left:4px"><img class="logo-copyright" src="{$publicUrl}/logo_copyright.svg" /></span>
                <span style="margin-left:4px" class="text-copyright-brand">IKINARY HEALTH SCIENCE JOURNAL</span>            
            </p>

            <p class="text-issn">
                e-ISSN xxxx-xxx/x <br />
                print ISSN xxxx-xxxx
                is licensed under a <a href="https://creativecommons.org/licenses/by-sa/4.0/"> Creative Commons Attributions-ShareAlike 4.0 International</a> <br />
                <br />
                &copy; 2023
            </p>

        </div>

        <div class="align-self-end">
            <a href="{url page="about" op="aboutThisPublishingSystem"}">
                <img alt="{translate key="about.aboutThisPublishingSystem"}" src="{$publicUrl}/footer_brand.png" class="footer-brand">
            </a>
        </div>
    </div>
</div><!-- pkp_structure_footer_wrapper -->

</div><!-- pkp_structure_page -->

{load_script context="frontend"}

{call_hook name="Templates::Common::Footer::PageFooter"}
</div>
</body>

</html>