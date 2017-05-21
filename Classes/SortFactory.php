<?php

class SortFactory {
	public $links_array=array();
	public $extracted_ads = array (
		array (
			'link' 			=> '$ad_url',
			'oznaka_oglasa' => '$ad_id',
			'marka_i_tip'	=> '$ad_model',
			'cijena_eur'	=> '$ad_price',
			'godište'		=> '$ad_yop',
			'km-ms'			=> '$ad_kmwh',
			'lokacija'		=> '$ad_location',
			'prodavatelj'	=> '$ad_seller',
			'kontakt'		=> '$ad_contact',
			)
	);
	public $page;

		

	public function __construct ( DetailedUrlGenerator $detailed_url_generator) {
		$this->links_array = $detailed_url_generator->get_detailed_links();
		return $this->links_array;
	}

	public static function extract () {
		foreach ($this->links_array as $link) {
			echo "Sleeping for a sec...</br>";
			sleep(1);

			$page = new DOMDocument();
			libxml_use_internal_errors(true);
			@$page->loadHTMLFile($link);
			libxml_use_internal_errors(false);

			if (strpos($link, "njuskalo")) {
				$page->getElementsByTagName ();


				
			} elseif (strpos($link, "mascus")) {
				$page->getElementsByTagName ("span");

						
			} elseif (strpos($link, "olx")) {


						
			} elseif (strpos($link, "autoline")) {


						
			} elseif (strpos($link, "truckscout24")) {


						
			}


		}
	}

}