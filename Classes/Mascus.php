<?php

class Mascus {
public $page;
public $test_array, $single_ad_data, $full_ad_data =array();

public function __construct (array $test_array) {
	$this->test_array = $test_array;
	$this->page = $page=new DOMDocument;
}


public function fetch_ad_data() {
	
	foreach ($this->test_array as $ta) {
		sleep(1);
		

		$html = file_get_contents($ta);


		libxml_use_internal_errors(true);
		@$this->page->loadHTML($html);
		$xpath = new DOMXpath($this->page);
		libxml_use_internal_errors(false);

		// GET ROWS (TAG <tr>)  FROM MAIN TABLE
		$tableDomElementsArray=$xpath->query('//*[@id="product-card"]/div/div[3]/div[1]/div[4]/span/div/table/tr');
		//echo "<pre>";
		//print_r($tableDomElementsArray);
		//echo "</pre></br>";

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
			//echo "<pre>";
			
				foreach ($adElementsMascus as $adm) {
					if (strpos($tableDomRow->nodeValue, $adm) !==false) {

						//echo $adm.": ".str_replace($adm, '', $tableDomRow->nodeValue)."</br>";
						$this->single_ad_data[$adm] = str_replace($adm, '', $tableDomRow->nodeValue);  
					}
				}
		

		}
		// GET SELLER DATA
		$sellerName=$xpath->query('//div[@class="company-name"]');
		//echo "Seller name: ".$sellerName[0]->nodeValue;  // COUNTING STARTS FROM ZERRROOO!!!!
		$this->single_ad_data['seller name'] = $sellerName[0]->nodeValue; 

		$this->full_ad_data[] = $this->single_ad_data;
		//HIDDEN PHONE NUMBER --- RIJEŠITI!!!
		//$sellerContacts=$xpath->query('//span[@class="hidden-number-value"]');
		//echo "<pre>";

		//foreach ($sellerContacts as $sellerContact) {
		//	print_r ($sellerContact);
		//}


		//echo "</pre></br>";

	} 
}

public function get_full_ad_data() {
	return $this->full_ad_data;
}

}

