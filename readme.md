# Modula Gallery - The Best WordPress Gallery Plugin 🏞️

Modula is the fastest, most customizable, and versatile image gallery plugin for WordPress. Built from the ground up with the latest technology, Modula ensures that your galleries load quickly while also looking fantastic on popular devices.

---

👉 Not a developer? Running WordPress? [Download Modula](https://wordpress.org/plugins/modula-best-grid-gallery/) on WordPress.org.

![Plugin version](https://img.shields.io/wordpress/plugin/v/modula-best-grid-gallery.svg) 
![WordPress Rating](https://img.shields.io/wordpress/plugin/r/modula-best-grid-gallery.svg) 
![WordPress Downloads](https://img.shields.io/wordpress/plugin/dt/modula-best-grid-gallery.svg) 
[![License](https://img.shields.io/badge/license-GPL--3.0%2B-green.svg)](https://github.com/WPChill/modula-lite/blob/master/license.txt) 


Welcome to the Modula Gallery Plugin GitHub repository. Here you can browse the source, look at open issues, and contribute to the project.

This repository exists for opening up new issues, reporting existing bugs, and anything else related to development. This is not the place to ask for support, so please [reach out to us](https://wp-modula.com/contact-us/) and we'll happily assist you.

 ## 🙋 Support

 This repository is not suitable for WordPress support. Please don't use GitHub issues for non-development related support requests. Don't get us wrong, we're more than happy to help you! However, to get the support you need please use the following channels:

* [WP.org Support Forums](https://wordpress.org/support/plugin/modula-best-grid-gallery) - for all **free** users.
* [Priority Support](https://wp-modula.com/contact-us/) - exclusively for our **customers**.
* [Modula Documentation](https://wp-modula.com/knowledge-base/) - for everyone

## 🌱 Getting Started

If you're looking to contribute to Modula, welcome! We're glad you're here. Please ⭐️ this repository and fork it to begin local development.

Most of us are using [Local by Flywheel](https://localbyflywheel.com/) to develop on WordPress, which makes set up quick and easy. If you prefer [Docker](https://www.docker.com/), [VVV](https://github.com/Varying-Vagrant-Vagrants/VVV), or another flavor of local development that's cool too!

## ✅ Prerequisites
* [Node.js](https://nodejs.org/en/) as JavaScript engine.
* [NPM](https://docs.npmjs.com/) npm command globally available in CLI.
* [WP CLI](https://wp-cli.org) wp-cli command globally available (Local by Flywheel has this built-in).

## 💻 Local Development

To get started developing you will need to perform the following steps:

1. Create a new WordPress site using your favorite local development software.
2. `cd` into your local plugins directory: `/wp-content/plugins/`
3. Fork this repository from GitHub and then clone that into your plugins directory in a new `modula-best-grid-gallery` directory
4. Run `npm install` to get the necessary npm packages
5. Activate the plugin in WordPress
7. Run `npm run scss` to start the watch process which will build the sass and script files and live reload using [Browsersync](https://www.browsersync.io/)

That's it. You're now ready to start development.

**Available commands**

| Command             | Description  |
| :------------- | :------------ |
| `npm run min:js`      | Use this command to minify plugin JavaScript files (note: this command does not minify Gutengerg assets).  |
| `npm run min:css`      |    Use this command to minify plugin CSS files (note: this command does not minify Gutengerg assets). This command will also concat files from the /front/ folder into front.css |
| `npm run pot` |  Use this command to build the .POT file for the plugin. Scans all of the plugin's files (includig JS files) and builds the .POT file. |
| `npm run wpchill` |  Use this command to minify all of the plugin's assets and generate the .POT file. |
| `npm run plugin-zip` |  Use this command to build a ZIP of the entire plugin folder, omitting node_modules, .dotfiles and .dotfolders |
| `npm run build` |  Official documentation: https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/#build |
| `npm run start` |  Official documentation: https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/#start |
| `npm run lint:css` |  Official documentation: https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/#lint-style |
| `npm run lint:js` |  Official documentation: https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/#lint-js |

**Development Notes**

* Ensure that you have `SCRIPT_DEBUG` enabled within your wp-config.php file. Here's a good example of wp-config.php for debugging:
    ```
     // Enable WP_DEBUG mode
    define( 'WP_DEBUG', true );

    // Enable Debug logging to the /wp-content/debug.log file
    define( 'WP_DEBUG_LOG', true );

    // Loads unminified core files
    define( 'SCRIPT_DEBUG', true );
    ```
* Commit the `package.lock` file. Read more about why [here](https://docs.npmjs.com/files/package-lock.json).
* Your editor should recognize the `.eslintrc` and `.editorconfig` files within the Repo's root directory. Please only submit PRs following those coding style rulesets.
