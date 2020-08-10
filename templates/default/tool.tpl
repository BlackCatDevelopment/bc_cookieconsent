<div class="mod_cookieconsent">
    <div class="alert">
        {translate('Please note: The Cookie Consent popup on this page is meant as a preview. It will appear at the position you have selected.')}
    </div>
    <form action="" method="POST">
            <h3>{translate('Common')}</h3>
            <label for="cc_content_href">{translate('Policy page URL')}</label>
            <input type="text" name="cc_content_href" id="cc_content_href" placeholder="https://www.cookiesandyou.com/" title="" value="{$href}"><br />
            <span style="margin-left:250px">
             ---{translate('or')}---
            </span><br />
            <label for="cc_href_pageid">{translate('Policy page')}</label>
            {$select}<br />
            <p style="margin-left:250px;font-style:italic">
            {translate('Please note: The above selection only lists pages whose visibility is set to &quot;public&quot;.')}<br />
            {translate('An internal page always has a higher priority than an external URL.')}
            </p>
            <br />

            <label for="cc_type">{translate('Type')}:</label>
            <select name="cc_type" id="cc_type" title="">
                <option value="info"{if $type=="info"} selected="selected"{/if}>info</option>
                <option value="opt-in"{if $type=="opt-in"} selected="selected"{/if}>opt-in</option>
                <option value="opt-out"{if $type=="opt-out"} selected="selected"{/if}>opt-out</option>
            </select> <i class="cc-info" title="opt-in: {translate('The visitor must explicitly agree to the cookie')}<br />opt-out: {translate('The visitor must explicitly reject the cookie.')}<br />info: {translate('Notify only.')}">i</i><br />
            <label for="">{translate('Position')}:</label>
            <select name="cc_position" id="cc_position" title="">
                <option value="top"{if $position=="top"} selected="selected"{/if}>top</option>
                <option value="bottom"{if $position=="bottom"} selected="selected"{/if}>bottom</option>
                <option value="top-left"{if $position=="top-left"} selected="selected"{/if}>top-left</option>
                <option value="top-right"{if $position=="top-right"} selected="selected"{/if}>top-right</option>
                <option value="bottom-left"{if $position=="bottom-left"} selected="selected"{/if}>bottom-left</option>
                <option value="bottom-right"{if $position=="bottom-right"} selected="selected"{/if}>bottom-right</option>
            </select> <br />
            <label for="">{translate('Theme')}:</label>
            <select name="cc_theme" id="cc_theme" title="">
                <option value="block"{if $theme=="block"} selected="selected"{/if}>block</option>
                <option value="edgeless"{if $theme=="edgeless"} selected="selected"{/if}>edgeless</option>
                <option value="classic"{if $theme=="classic"} selected="selected"{/if}>classic</option>
            </select> <br />
            <label for="">{translate('Palette')}:</label>
            <select name="cc_palette" id="cc_palette" title="">
                <option value="none"{if $palette=="none"} selected="selected"{/if}>none ({translate('choose own colors')})</option>
                <option value="honeybee"{if $palette=="honeybee"} selected="selected"{/if}>honeybee</option>
                <option value="purple"{if $palette=="purple"} selected="selected"{/if}>purple</option>
                <option value="mono"{if $palette=="mono"} selected="selected"{/if}>mono</option>
                <option value="red"{if $palette=="red"} selected="selected"{/if}>red</option>
                <option value="cosmo"{if $palette=="cosmo"} selected="selected"{/if}>cosmo</option>
                <option value="neon"{if $palette=="neon"} selected="selected"{/if}>neon</option>
            </select> <i class="cc-info" title="{translate('Select color palette or choose &quot;none&quot; to set your own colors.')}">i</i><br /><br />

            <div id="cc-own-colors" style="display:none">
                <h3>{translate('Choose your own colors')}</h3>
                <p style="font-style:italic">
                    {translate('Cookie Consent calculates matching colors for colors not set. These are shown in the preview.')}
                </p>
                <label for="">{translate('Popup background color')}:</label>
                <input type="text" name="cc_popup_background" id="cc_popup_background" title="" value="{$popup_background}" class="colorselect"><br />
                <label for="">{translate('Popup text color')}:</label>
                <input type="text" name="cc_popup_text" id="cc_popup_text" title="" value="{$popup_text}" class="colorselect"><br />
                <label for="">{translate('Popup link color')}:</label>
                <input type="text" name="cc_popup_link" id="cc_popup_link" title="" value="{$popup_link}" class="colorselect"><br />

                <label for="">{translate('Button background color')}:</label>
                <input type="text" name="cc_button_background" id="cc_button_background" title="" value="{$button_background}" class="colorselect"><br />
                <label for="">{translate('Button text color')}:</label>
                <input type="text" name="cc_button_text" id="cc_button_text" title="" value="{$button_text}" class="colorselect"><br />
                <label for="">{translate('Button border color')}:</label>
                <input type="text" name="cc_button_border" id="cc_button_border" title="" value="{$button_border}" class="colorselect"><br />
            </div>

            <h3>{translate('Edit contents')}</h3>
            <p style="font-style:italic">
                {translate('The standard texts are in English and are displayed as placeholders in the input fields below. These must be adapted to the actual conditions, i.e. it must be specified what kind of cookies are set and what purposes they serve. A guarantee for the legal security of the default text is expressly not assumed!')}<br />
                {translate('Tip: Create your own texts in English and enter the translation into the DE.php!')}
            </p>
            <label for="cc_content_message">{translate('Message')}</label>
            <textarea name="cc_content_message" id="cc_content_message" title="" placeholder="This website uses cookies to ensure you get the best experience on our website.">{$message}</textarea><br />
            <label for="cc_content_dismiss">{translate('Dismiss')}</label>
            <input type="text" name="cc_content_dismiss" id="cc_content_dismiss" title="" placeholder="Got it!" value="{$dismiss}"><br />
            <label for="cc_content_deny">{translate('Deny')}</label>
            <input type="text" name="cc_content_deny" id="cc_content_deny" placeholder="Decline" title="" value="{$deny}"><br />
            <label for="cc_content_allow">{translate('Allow')}</label>
            <input type="text" name="cc_content_allow" id="cc_content_allow" placeholder="Allow cookies" title="" value="{$allow}"><br />
            <label for="cc_content_learn">{translate('Learn more')}</label>
            <input type="text" name="cc_content_learn" id="cc_content_learn" placeholder="Learn more" title="" value="{$learn}"><br /><br />
        <input type="submit" name="save" title="" value="Speichern" class="btn btn-primary">
    </form>
    <script type="text/javascript" id="code">
    //<![CDATA[
     
    //]]>
    </script>
</div>
