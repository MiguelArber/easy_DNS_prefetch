<?php

  /**
   * Implementing hook_menu().
   */

function easy_DNS_prefetch_menu() {

  $items = array();

  $items['admin/config/easy_DNS_prefetch'] = [
    'title' => t('Configuration of easy_DNS_prefetch'),
    'description' => t('Configure the Easy DNS Prefetch module'),
    'page callback' => 'drupal_get_form',
    'page arguments' => array('easy_DNS_prefetch_admin'),
    'access arguments' => array('administer easy_DNS_prefetch settings'),
    'type' => MENU_NORMAL_ITEM,
    'file' => 'src/Form/easy_DNS_prefetch_admin.php'
    ];

  return $items;
}