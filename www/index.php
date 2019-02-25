<?php
// Discourse SSO based on https://github.com/cviebrock/discourse-php.

if (isset($_GET['sso']) && isset($_GET['sig'])) {
  // Get configuration.
  $config = SimpleSAML_Configuration::getConfig('module_discourse.php');
  $url = $config->getValue('url');
  $secret = $config->getValue('secret');
  $authsource = $config->getValue('authsource');
  $att_names = $config->getValue('attributes');

  $sso = new Cviebrock\DiscoursePHP\SSOHelper();
  $sso->setSecret($secret);

  // Load the payload passed in by Discourse.
  $payload = $_GET['sso'];
  $signature = $_GET['sig'];

  // Validate the payload.
  if (!($sso->validatePayload($payload,$signature))) {
    // invaild, deny
    header("HTTP/1.1 403 Forbidden");
    echo("Bad SSO request");
    die();
  }

  $nonce = $sso->getNonce($payload);

  // SimpleSAML authentication code.
  $auth = new \SimpleSAML\Auth\Simple($authsource);
  $auth->requireAuth();
  $att = $auth->getAttributes();

  // Required and must be unique to your application.
  $external_id = $att[$att_names['external_id']][0];

  // Required and must be consistent with your application.
  $email = $att[$att_names['email']][0];

  // Optional - if you don't set these, Discourse will generate suggestions
  // based on the email address.
  $optional_att = array();
  foreach ($att_names['optional'] as $key => $value) {
    $optional_att[$key] = is_array($value) ? implode(',', $att[$value[0]]) : $att[$value][0];
  }

  // Build query string and redirect back to the Discourse site.
  $query = $sso->getSignInString($nonce, $external_id, $email, $optional_att);
  header('Location: ' . $url . '/session/sso_login?' . $query);
  exit(0);
}
elseif (isset($_GET['logout'])) {
  $config = SimpleSAML_Configuration::getConfig('module_discourse.php');
  $authsource = $config->getValue('authsource');
  $auth = new \SimpleSAML\Auth\Simple($authsource);
  $auth->logout();
}
