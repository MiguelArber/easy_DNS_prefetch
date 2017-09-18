<?php

/**
 * Formulario de configuración desde el menú de administración
 * Configuration form from the Administration menu
 *
 * @return array The form structure.
 */

function easy_DNS_prefetch_admin($form, &$form_state) {

  // There will be many fields with the same name, so we need to be able to
  // access the form hierarchically with a tree structure.

  $easy_DNS_prefetch_URL = variable_get('easy_DNS_prefetch_URL', NULL);

  $form['#tree'] = TRUE;

  $form['description'] = array(
    '#type' => 'item',
    '#title' => t('Add the domains to be prefetched:'),
    '#description' => t("The DNS prefetch technique allows you to minimize the impact of the DNS resolution time on the total page load time. In the background, the browsers will actively perform domain name resolution actions, this way the referenced items will be ready to be used since the DNS will have already been resolved. This process reduces latency when the user clicks a link. Add the domains that are frequently used in your site in order to boost the page loading speed."),
  );

  if (empty($form_state['num_domains'])) {
    $form_state['num_domains'] = 1;
  }


  // Build the number of doamin fieldsets indicated by $form_state['num_domains']
  if(!isset($form_state['clicked_button']['#value']) || ( $form_state['clicked_button']['#value'] !== 'Remove latest domain')) {

    $count = count($easy_DNS_prefetch_URL);
    if ($count > $form_state['num_domains']) {
      $form_state['num_domains'] = $count;
    }

  }
  for ($i = 0; $i < $form_state['num_domains']; $i++) {

    $form['domain'][$i]['easy_DNS_prefetch_URL'] = array(
      '#type' => 'textfield',
      '#title' => t('Domain '.($i+1).':'),
      '#description' => t("ADD the HTTP prefix."),
      '#size' => 60,
      '#maxlength' => 250,
      //'#required' => TRUE,
      '#default_value' => isset($easy_DNS_prefetch_URL[$i]) ? $easy_DNS_prefetch_URL[$i] : NULL,
    );

  }

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => 'Submit',
  );

  // Adds "Add another domain" button.
  $form['add_domain'] = array(
    '#type' => 'submit',
    '#value' => t('Add another domain'),
    '#submit' => array('easy_DNS_prefetch_URL_add'),
  );

  // If there are more than one domain, this button allows removal of the
  // last domain added.
  if ($form_state['num_domains'] > 1) {
    $form['remove_domain'] = [
      '#type' => 'submit',
      '#value' => t('Remove latest domain'),
      '#submit' => ['easy_DNS_prefetch_URL_remove'],
      // Since we are removing a domain, don't validate until later.
      '#limit_validation_errors' => [],
    ];
  }

  return $form;
}

function easy_DNS_prefetch_URL_add($form, &$form_state) {
  // Everything in $form_state is persistent, so we'll just use
  // $form_state['add_domain']
  $form_state['num_domains']++;

  // Setting $form_state['rebuild'] = TRUE causes the form to be rebuilt again.
  $form_state['rebuild'] = TRUE;
}

/**
 * Submit handler for "Remove domain" button on easy_DNS_prefetch_admin().
 */
function easy_DNS_prefetch_URL_remove($form, &$form_state) {

  if (($form_state['num_domains'] > 1)) {
    $form_state['num_domains']--;
  }

  // Setting $form_state['rebuild'] = TRUE causes the form to be rebuilt again.
  $form_state['rebuild'] = TRUE;
}

/**
 * Validation function.
 */
function easy_DNS_prefetch_admin_validate($form, &$form_state) {

  //Pattern validation for URL
  $pattern = '/^(https?:\/\/)(?!\-)(?:[a-zA-Z\d\-]{0,62}[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$/'; //Needs the '/.../' delimiters

  foreach($form_state['values']['domain'] as $key => $domain) {
      //$domain = $form_state['values']['domain'][$i]['easy_DNS_prefetch_URL'];
      $check = preg_match($pattern, $domain['easy_DNS_prefetch_URL']);

      if ($check != 1 && $form_state['values']['domain'][$key]['easy_DNS_prefetch_URL'] != "") {
        form_set_error("domain][$key][easy_DNS_prefetch_URL", $form_state['values']['domain'][$key]['easy_DNS_prefetch_URL'] . t(': Wrong domain format!'));
      }
    }
}

/**
 * Submit function.
 */

function easy_DNS_prefetch_admin_submit($form, &$form_state) {

  $values = $form_state['values']['domain'];


  $output = t(nl2br("The following domains have been correctly submitted: \n"));

  for ($i = 0; $i <= count($values); $i++) {

    if ($values[$i]['easy_DNS_prefetch_URL'] == "") {
      unset($values[$i]);
    } else {
      $output .= t("@domain",
          [
            '@domain' => $values[$i]['easy_DNS_prefetch_URL'],
          ]) . nl2br("\n");
    }
  }

  $values = array_values(array_filter($values));
  drupal_set_message($output);
  variable_set('easy_DNS_prefetch_URL', $values);

}