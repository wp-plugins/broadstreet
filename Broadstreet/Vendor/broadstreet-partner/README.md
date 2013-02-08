# Broadstreet Wordpress Partner Kit

If you want your users to be able to create "editable" ads, where they can send SMS updates to set their ad's message, use this. If you want to make money with your existing Wordpress plugin, this is the way to do it.

If you are not a Broadstreet partner just yet, and you are interested,
reach out to kenny@broadstreetads.com, and we will get you set up
with an agreement.

## How it Works

All interaction takes place through a modal window that you kick off with the help of some help functions we provide. The user can create a special editable ad with this modal. When the user is finished, the modal will pass back the correct ad code to the page. You can configure where that ad code goes in the `partner.php` file, described below.

## Suggestions

For projects versioned with git, it may be wise to incorporate this into the project as a submodule: http://git-scm.com/book/en/Git-Tools-Submodules

## How to Integrate

This shouldn't take more than 5 minutes.

1. Deploy this folder into your application (perhaps in `vendor/broadstreet`). So:

2. Include vendor/broadstreet/lib/Utility.php in the file/page where you want to show the partner modal. Remember to adjust the path:

    `require_once 'path/to/vendor/broadstreet/lib/Utility.php';`

3. Call `Broadstreet_Mini_Utility::editableJS()` in the `<head>` of the page, or near the opening of `<body>`
4. Call `Broadstreet_Mini_Utility::editableLink()` where you want the modal button to go
5. Copy partner-template.php to partner.php
6. Edit partner.php with this information:

    - BROADSTREET_PARTNER_NAME: Your Broadstreet partner name
    - BROADSTREET_VENDOR_PATH: The path from the **root** of your plugin to the broadstreet folder
    - BROADSTREET_AD_TAG_SELECTOR: The DOM element that, when the modal is closed, ad code should be placed into
    - BROADSTREET_DEBUG: Whether to enable debugging
