<?php
$arUrlRewrite=array (
  0 => 
  array (
    'CONDITION' => '#^/location/metro/(.*)/(.*)$#',
    'RULE' => 'location=$1_metro&$2',
    'ID' => '',
    'PATH' => '/location/index.php',
    'SORT' => 100,
  ),
  3 => 
  array (
    'CONDITION' => '#^/services/(.*)/(.*)#',
    'RULE' => 'ELEMENT_CODE=$1&$2',
    'ID' => '',
    'PATH' => '/services/index.php',
    'SORT' => 100,
  ),
  4 => 
  array (
    'CONDITION' => '#^/sitemap_metro.xml#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/sitemap_xml/sitemap_metro.php',
    'SORT' => 100,
  ),
  7 => 
  array (
    'CONDITION' => '#^/sitemap.xml#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/sitemap_xml/sitemap_all.php',
    'SORT' => 100,
  ),
);
