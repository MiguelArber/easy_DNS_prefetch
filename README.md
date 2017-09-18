# Easy DNS Prefetch
### A module provides a simple way to prefetch DNS in your Drupal site.

---

## Description

The ***DNS prefetch*** technique allows you to **minimize** the impact of the **DNS resolution time** on the total page load time. 
In the background, the browsers will actively perform domain name resolution actions, this way the referenced items will be **ready to be used** since the **DNS** will have **already been resolved**. 
The DNS prefetching **reduces latency** when the user clicks a link. This is done by adding a dns-prefetch directive for the browsers into your site's head. 

This module allows you to **easily** add the domains that are frequently used in your site in order to **boost** the page loading speed.
Just write down the URL you wish to prefetch and **Easy DNS Prefetch** will do the rest, as easy as that.


## Installation & use

This section describes how to install the module and get it working.

1. Upload contents of the ```drupal-module``` folder to ```/sites/all/modules/easy_dns_prefetch/``` directory.
2. Activate the Easy DNS Prefetch module through the *Modules* menu in Drupal.
3. Click on the menu item *Configuration* or just go to ```/admin/config/easy_DNS_prefetch```
4. Add the domains you wish to prefetch. Save when you're finished.
5. That's it! Your prefetched domains should appear now in the source code of your site.
