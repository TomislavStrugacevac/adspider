<?php

class StartUrlGenerator {
// generate start webpages to search on main ad sites	
	
	public function __construct (array $keywords, $pages) {
		$this->keywords = $keywords;
		$this->pages = $pages;
	}

	public function generate_urls() {
		echo "StartUrlGenerator->generate_urls:: IN PROGRESS...</br>";
		$x=1;
		$base_url='';
		$full_url_array = array();
		foreach ($this->keywords as $keyword) {
			if ( $x < count($this->keywords)) {
				$base_url .= $keyword."+"; 
				$x++;
			} else {
				$base_url .= $keyword;
			}
		}
		$x=1;
		
		//generate Njuškalo
		for ($p=1; $p<=$this->pages; $p++) {
			$full_url_array[]= "http://www.njuskalo.hr/index.php?ctl=search_ads&keywords=".$base_url."&page=".$p;
		}

		//generate Mascus
		for ($p=1; $p<=$this->pages; $p++) {
			$full_url_array[]= "https://www.mascus.hr/".$base_url."/auctions%3d1/+/".$p.",100,yearofmanufacture_desc,search.html?currency=EUR";
		}

		//generate Olx.ba
		for ($p=1; $p<=$this->pages; $p++) {
			$full_url_array[]= "https://www.olx.ba/pretraga?trazilica=".$base_url."&stranica=".$p;

		}

		//generate Autoline
		for ($p=1; $p<=$this->pages; $p++) {
			$full_url_array[]= "https://autoline.hr/search_text.php?query=".$base_url."&page=".$p;

		}

		// generate 24truckscout.de
		for ($p=1; $p<=$this->pages; $p++) {
			$base_url_24=str_replace("+", "%20", $base_url);
			$full_url_array[]= "http://ww2.truckscout24.com/catalog/search/".$base_url_24."\"/filter/page/".$p."/100";

		}

		
		
		echo "StartUrlGenerator->generate_urls:: COMPLETED.</br>";
		return $full_url_array;

	}

	public function get_keywords(){
		return $this->keywords;
	}

	public function get_preg_keywords(){
		$k=1;
		$pregkey='';
		foreach ( $this->keywords as $keyword ) {
			if ($k<count($this->keywords)) {
				$pregkey .= $keyword.'|'; 
				$k++;
			} else {
				$pregkey .= $keyword;	
			}

		};
		$k=1;
		return ($pregkey);
	}
} 
