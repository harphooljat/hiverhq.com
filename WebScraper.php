<?php

include_once('simple_html_dom.php');

class WebScraper {

	private  $url;
	private static $instance;

	private function __construct() {

	}

	public static function getInstance($class = __CLASS__) {

		if (!isset(self::$instance)) {
			self::$instance = new $class;
		}

		return self::$instance;
	}

	public function setURL($url) {
		$this->url = $url;
	}
	
	public function cleanText($text) {
		$text = trim(strip_tags(html_entity_decode($text)));
		return preg_replace('/\s+/', ' ', $text);
	}

	public function splitText($text) {
	    return preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
	}
	
	public function cleanWord($word) {
		return strtolower(trim($word, ',-&()/+.:@%'));
	}

	public function scrapeURL() {
		$wordsCount = [];

		// create HTML DOM
		$html = file_get_html($this->url);

		foreach($html->find('body') as $div) {
			$text = $this->cleanText($div->plaintext);
			$words = $this->splitText($text);
			foreach($words as $word) {
				$word = $this->cleanWord($word);

				if (empty($word)) continue;
				if (is_numeric($word)) continue;

				if (!isset($wordsCount[$word])) {
					$wordsCount[$word] = 0;
				}

				$wordsCount[$word]++;
			}
		}

		arsort($wordsCount);
		$wordsCount =  array_slice($wordsCount, 0, 5);

		// clean up memory
		$html->clear();
		unset($html);

		return $wordsCount;
	}
}
