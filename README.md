# Discourse SSO module for SimpleSAMLphp

## Requirements
* SimpleSAMLphp
* Discourse
* cviebrock/discourse-php: https://github.com/cviebrock/discourse-php

## Installation
Go to your SimpleSAMLphp directory:
```
cd /var/simplesamlphp
```

This module requires cviebrock/discourse-php which can be installed using composer:
```
composer require "cviebrock/discourse-php" --update-no-dev
```

Check out the module code from GitHub:
```
git clone https://github.com/reswild/discourse.git modules/discourse
```

Copy sample configuration, and edit it as needed:
```
cp modules/discourse/config-templates/module_discourse.php config/module_discourse.php
nano config/module_discourse.php
```

Enable module:
```
touch modules/discourse/enable
```

## Configuration options
* `url` The URL of your Discourse forum.
* `secret` Secret string matching the 'sso secret' in your Discourse settings.
* `authsource` The authetication source you want to use for the login.
* `attributes` Attributes from your authetication source to be passed on to Discourse.
  * `external_id` Required and must be unique to your application.
  * `email` Required and must be consistent with your application.
  * `optional` Array of optional attributes. For a full list of options, see 
  https://meta.discourse.org/t/official-single-sign-on-for-discourse-sso/13045

In the admin settings on your Discourse site, make sure that `sso secret` 
matches what you entered in the SimpleSAML settings, and set `sso url` as 
\[url-to-simplesamlphp\]/module.php/discourse/index.php.
Once you are sure everything is correct, check the box for `enable sso`.
