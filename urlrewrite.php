<?php
$arUrlRewrite=array (
  2 => 
  array (
    'CONDITION' => '#^/location/rayon/(.*)/(.*)$#',
    'RULE' => 'location=$1_rayon&$2',
    'ID' => '',
    'PATH' => '/location/index.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/location/okrug/(.*)/(.*)$#',
    'RULE' => 'location=$1_okrug&$2',
    'ID' => '',
    'PATH' => '/location/index.php',
    'SORT' => 100,
  ),
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
  6 => 
  array (
    'CONDITION' => '#^/sitemap_rayon.xml#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/sitemap_xml/sitemap_rayon.php',
    'SORT' => 100,
  ),
  5 => 
  array (
    'CONDITION' => '#^/sitemap_okrug.xml#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/sitemap_xml/sitemap_okrug.php',
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
