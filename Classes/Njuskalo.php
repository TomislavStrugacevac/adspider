<?php

class Njuskalo {
public $page, $string;
public $test_array, $single_ad_data, $get_full_ad_data=array(); 

public function __construct (array $test_array) {
	$this->test_array = $test_array;
	//$this->single_ad_data = $single_ad_data;
	//$this->full_ad_data = $full_ad_data;
	$this->page = $page=new DOMDocument;
	//echo "CLASS NJUSKALO INSTANTIATED...";
	

}


public function fetch_ad_data() {
	
	foreach ($this->test_array as $ta) {
		sleep(1);
		

		$html = file_get_contents($ta);


		libxml_use_internal_errors(true);
		@$this->page->loadHTML($html);
		$xpath = new DOMXpath($this->page);
		libxml_use_internal_errors(false);

		//GET PRICE IN EUR

		$price = $xpath->query('//strong[@class="price price--eur"]');
		//echo "price: ".preg_replace('/\s+/ ', '', $price[0]->nodeValue)."</br>";
		$this->single_ad_data['price']= preg_replace('/\s+/ ', '', $price[0]->nodeValue);

		//GET AD ID
		$njuskalo_id = $xpath->query('//b[@class="base-entity-id"]');
		//echo "njuskalo ID: ".$njuskalo_id[0]->nodeValue."</br>";
		$this->single_ad_data['njuskalo_id']= $njuskalo_id[0]->nodeValue;


		
		// GET ROWS (TAG <tr>)  FROM MAIN TABLE
		$tableDomElementsArray=$xpath->query('//table[@class="table-summary table-summary--alpha"]/tbody/tr');
		

		//echo "<pre>";
		//print_r($tableDomElementsArray);
		//echo "</pre></br>";

		// DEFINE ELEMENTS TO GET FROM TABLE ( correlating to nodeValue )
		$adElementsNjuskalo =array
						('Marka i tip:',
						 'Prijeđeni kilometri:',
						 'Godina proizvodnje:'
						 );


		// GET EVERY ROWS NODE VALUE COMPARE IF IT CONTAINS WANTED ELEMENT AND GET VALUE
		foreach ($tableDomElementsArray as $tableDomRow) {
			//echo "<pre>";
				//print_r($tableDomRow);
				//echo $tableDomRow->nodeValue;
				foreach ($adElementsNjuskalo as $adn) {
				if (strpos($tableDomRow->nodeValue, $adn) !== false) {
					$string=str_replace($adn, '', $tableDomRow->nodeValue); 
					//echo $adn." ".preg_replace('/\s+/ ','',$string)."</br>"; // REMOVE TAB WHITESPACE
					$this->single_ad_data[$adn] = preg_replace('/\s+/ ',' ',$string);  
				}	
		}
		

		}
		
		// GET SELLER DATA
		$sellerName = $xpath->query('//a[@class="Profile-username link"]');
		//echo $sellerName[0]->nodeValue."</br>";
		$this->single_ad_data['sellerName']=$sellerName[0]->nodeValue;
		
		$sellerLocation = $xpath->query('//dl[@class="Profile-addressData"]/dd');
		//echo $sellerLocation[0]->nodeValue."</br>";
		$this->single_ad_data['sellerLocation']=$sellerLocation[0]->nodeValue;

		$sellerContact = $xpath->query('//a[@class="link link-tel link-tel--alpha"]');
		$phone=preg_replace('/\s+/ ','',str_replace('Telefon:','', $sellerContact[0]->nodeValue))."</br>";
		$this->single_ad_data['sellerContact']=$phone;
		

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

