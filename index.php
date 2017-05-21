<?php

require ("Classes/StartUrlGenerator.php");
require ("Classes/DetailedUrlGenerator.php");
require ("Classes/SortFactory.php");
require ("Classes/Mascus.php");

ini_set('max_execution_time', 300);

$keywords = array ('mercedes','actros','1844','mega');
$pages = 1;



$start_url = new StartUrlGenerator($keywords, $pages);
$detail_url= new DetailedUrlGenerator($start_url);

echo "<pre>From DetailedUrlGenerator:</br>";
print_r ($detail_url->get_links_njuskalo());
print_r ($detail_url->get_links_mascus());
print_r ($detail_url->get_links_olx());
print_r ($detail_url->get_links_autoline());
print_r ($detail_url->get_links_truckscout24());
echo "</pre></br>";

$mascus = new Mascus($detail_url->get_links_mascus());
$mascus->fetch_ad_data();

echo "<pre>";
print_r ($mascus->get_full_ad_data());
echo "</pre>";


