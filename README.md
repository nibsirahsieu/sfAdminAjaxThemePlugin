#sfAdminAjaxThemePlugin#

The `sfAdminAjaxThemePlugin` is a symfony plugin to ajaxify symfony admin generator.
This plugin comes with two themes, ajaxtheme for propel 1.4 (sfPropelPlugin) and ajaxtheme15 for propel 1.5 (sfPropel15Plugin)

## Screenshot ##

* [http://nibsirahsieu.com/2010/11/26/sfadminajaxthemeplugin-now-in-symfony-plugin-repository](http://nibsirahsieu.com/2010/11/26/sfadminajaxthemeplugin-now-in-symfony-plugin-repository)

## Installation ##
  * Add the jQuery libary plugin  in your `view.yml`

  * Install the plugin

        git clone git://github.com/nibsirahsieu/sfAdminAjaxThemePlugin.git

  * Activate the plugin in the `config/ProjectConfiguration.class.php`

        [php]
        class ProjectConfiguration extends sfProjectConfiguration
        {
          public function setup()
          {
            ...
            $this->enablePlugins('sfAdminAjaxThemePlugin');
            ...
          }
        }
  * Clear your cache

        $ symfony cc

  * Publish the plugin's assets:

        ./symfony plugin:publish-assets

## How to use ##
  * Generate an admin generator, for example:

        ./symfony --theme=ajaxtheme15 propel:generate-admin Product

  * If you already have an admin generator, you can simply change the theme inside your `generator.yml`, then clear your cache.

        theme: ajaxtheme15 #ajaxtheme if you are using sfPropelPlugin

  * By default, this plugin come with [jquery form plugin](http://malsup.com/jquery/form/), if you already have it and want to use your own, add below to your `app.yml`. For example:

        [yml]
        all:
          jquery_form_dir: /js/jquery.form.js

That's it! You are ready now to use your new admin generator theme.

Your feedback is welcome

TODO :
------
    1. automatically ajaxify sortable table (if sortable behavior defined in the schema)
