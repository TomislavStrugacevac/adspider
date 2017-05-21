<?php


class DetailedUrlGenerator {
	public $good_link=true;
	public $njuskalo_links_array=array(); 
	public $mascus_links_array=array(); 
	public $olx_links_array=array(); 
	public $autoline_links_array=array(); 
	public $truckscout24_links_array=array();
	public $new, $page, $url, $pages_array, $pages_node, $pages_link;
	


	public function __construct (StartUrlGenerator $start_url) {
		$this->page = new DOMDocument();
		//echo "DetailedUrlGenerator->__construct:: IN PROGRESS...</br>";

		foreach ($start_url->generate_urls() as $url) {
			$page = new DOMDocument();


			libxml_use_internal_errors(true);
			@$page->loadHTMLFile($url);
			libxml_use_internal_errors(false);

			$pages_array = $page->getElementsByTagName("a");
			
			foreach ($pages_array as $pa) {
					// check if entry contains all the keywords
				if (preg_match('('.$start_url->get_preg_keywords().')',strtolower($pa->nodeValue)) === 1) {
					
					//extract hrefs
					$page_node=$pa->nodeValue;
					$page_link=$pa->getAttribute("href");
					
					// sort hrefs and generate full ad url
					if (strpos($url, "njuskalo")) {	
						
						$this->njuskalo_links_array[]="http://www.njuskalo.hr".$page_link;
					} elseif (strpos($url, "mascus")) {
						if (!strrpos($page_link, "auctions%")) { //skip multiple ads link, keep single ad links
							$this->mascus_links_array[]="https://www.mascus.hr".$page_link."?currency=EUR";
						}
					} elseif (strpos($url, "olx")) {
						$this->olx_links_array[]="https://www.olx.ba".$page_link;
					} elseif (strpos($url, "autoline")) {
						$this->autoline_links_array[]= $page_link;
					} elseif (strpos($url, "truckscout24")) {
						$this->truckscout24_links_array[]="http://ww2.truckscout24.com".$page_link;
					} 
					
				}
			}


		}
	//echo "DetailedUrlGenerator->__construct:: COMPLETED.</br>";

	}

	public function get_links_njuskalo() {
		return $this->njuskalo_links_array;
	}
	public function get_links_mascus() {
		return $this->mascus_links_array;
	}
	public function get_links_olx() {
		return $this->olx_links_array;
	}
	public function get_links_autoline() {
		return $this->autoline_links_array;
	}
	public function get_links_truckscout24() {
		return $this->truckscout24_links_array;
	}
}



