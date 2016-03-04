# Introduction #
This plugin implements facebook OpenGraph API for products and whole site at all.

http://developers.facebook.com/docs/reference/api/

# Why #

I wrote short article describing why is good to use OpenGraph API.

http://blog.javaee.cz/2011/02/prestashop-opengraph-module-like.html


# Installation #

Installation is following best practices in prestashop, so

  * Download .zip file
  * Unzip to <..your-prestashop-folder../modules/>.
  * Install plugin in your modules admin section, is in "seo" tab.
  * Provide your facebook id (so this e-shop is managed by you)
  * Add "og" xml namespace to your template header.tpl <html xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">

# Supported version #

Module was tested on 1.2.5.0 production and 1.4.0.12 testing, so I'm guessing that 1.3.x will be also supported..

# Debugging #

Hardest thing was get product\_id and image\_id, this was done by current lang\_id.

  * If you are using more languages, so lang\_id is present in HTTP GET (or cookies) and everyting works well.
  * If you are not using multiple languages and you force language in admin (as me in first project), you MUST hardcode your lang\_id in hookHeader function.
