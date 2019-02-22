<?php
/**
 * Configuration template for the Discourse module for simpleSAMLphp
 */
$config = array(
    // The URL of your Discourse forum.
    'url' => 'https://forum.example.com',
    
    // Secret string matching the 'sso secret' in your Discourse settings.
    'secret' => 'defaultdiscoursesecret',

    // The authetication source you want to use for the login.
    'authsource' => 'default-sp',

    // Attributes from your authetication source to be passed on to Discord.
    // external_id is required and must be unique to your application.
    // email is required and must be consistent with your application.
    // If you don't define username and name, Discourse will 
    // generate suggestions for these based on the email address. 
    // Define groups if you want auto-provision of goups in Discourse.
    // For more options, see https://meta.discourse.org/t/official-single-sign-on-for-discourse-sso/13045
    'attributes' => array(
      'external_id' => 'user',
      'email'       => 'mail',
      'optional'    => array(
        //'username'      => 'nickname',
        //'name'          => 'realname',
        //'avatar_url'    => 'avatar_url',
        //'add_groups'    => array('groups'),
        //'remove_groups' => array('remove_groups'),
      ),
    ),
);
