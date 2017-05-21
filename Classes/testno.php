<?php

$page = new DOMDocument();

$test_array = array ('https://www.mascus.hr/transport/rabljene-traktorske-jedinice/mercedes-benz-actros-1844/elhkjtci.html?currency=EUR',
    'https://www.mascus.hr/transport/rabljene-traktorske-jedinice/mercedes-benz-actros-1844/aihwemjl.html?currency=EUR',
    'https://www.mascus.hr/transport/rabljene-traktorske-jedinice/mercedes-benz-actros-1844/lx8lillj.html?currency=EUR',
    'https://www.mascus.hr/transport/rabljene-traktorske-jedinice/mercedes-benz-actros-1844/fxishpck.html?currency=EUR',
    'https://www.mascus.hr/transport/rabljene-traktorske-jedinice/mercedes-benz-actros-1844/licplubs.html?currency=EUR',
    'https://www.mascus.hr/transport/rabljene-traktorske-jedinice/mercedes-benz-actros-1844/atbp9xdr.html?currency=EUR' );

foreach ($test_array as $ta) {
sleep(1);

$html = file_get_contents($ta);


libxml_use_internal_errors(true);
@$page->loadHTML($html);
$xpath = new DOMXpath($page);
libxml_use_internal_errors(false);

// GET ROWS (TAG <tr>)  FROM MAIN TABLE
$tableDomElementsArray=$xpath->query('//*[@id="product-card"]/div/div[3]/div[1]/div[4]/span/div/table/tr');
echo "<pre>";
print_r($tableDomElementsArray);
echo "</pre></br>";

// DEFINE ELEMENTS TO GET FROM TABLE ( correlating to nodeValue )
$adElementsMascus =array
				('Mascus ID',
				 'Marka / model',
				 'Cijena isklj. PDV',
				 'Godina registracije',
				 'Očitanje brojača',
				 'Država');


// GET EVERY ROWS NODE VALUE COMPARE IF IT CONTAINS WANTED ELEMENT AND GET VALUE
foreach ($tableDomElementsArray as $tableDomRow) {
	echo "<pre>";
	
		foreach ($adElementsMascus as $adm) {
			if (strpos($tableDomRow->nodeValue, $adm) !==false) {

				echo $adm.": ".str_replace($adm, '', $tableDomRow->nodeValue)."</br>";
				
			}
		}
}


// GET SELLER DATA
$sellerName=$xpath->query('//div[@class="company-name"]');
echo "Seller name: ".$sellerName->item(0)->nodeValue;  // COUNT STARTING FROM ZERRROOO!!!!


//HIDDEN PHONE NUMBER --- RIJEŠITI!!!
//$sellerContacts=$xpath->query('//span[@class="hidden-number-value"]');
//echo "<pre>";

//foreach ($sellerContacts as $sellerContact) {
//	print_r ($sellerContact);
//}


echo "</pre></br>";

} 

