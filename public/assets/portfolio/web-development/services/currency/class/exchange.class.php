<?php
class Exchange {
	const XML_URL = 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange';

	public static $currencies;

	function __construct() {

	}

	function __destruct() {

	}

	function loadCurrenciesList() {
		$url = self::XML_URL;
		$xml = new SimpleXMLElement($url, null, true);
		self::$currencies = [];
		foreach ($xml->currency as $currency) {
			self::$currencies[(string)$currency->cc] = (string)$currency->txt;
		}
	}

	function getCurrency($currency, $date) {
		$url = self::XML_URL . "?date=" . $date->format('Ymd');
		$xml = new SimpleXMLElement($url, null, true);
		$res = $xml->xpath("//currency/cc[.='$currency']/parent::*");
		return $res[0]; // SimpleXMLObject
	}

	function getRatesForPeriod($currency, $from, $to) {
		$dateFrom = new DateTime($from);
		$dateTo = new DateTime($to);

		// Test if start rate is available
		while (!$this->getCurrency($currency, $dateFrom)->rate) {
			$dateFrom->modify('+1 year');
			$from = $dateFrom->format('Y-m-d');
			if ($dateFrom > $dateTo)
				throw new Exception('Нет данных за период.');
		}

		$period = $dateTo->diff($dateFrom)->days;
		$rates = [];

		if ($period < 15) {
			$scale = 1;
		} else {
			$scale = floatval($period) / 15;
			$period = 15;
		}

		for ($i = 0; $i <= $period; $i++) {
			$date = new DateTime($from);
			$date->modify("+" . round($scale * $i) . " day");
			$c = $this->getCurrency($currency, $date);
			if ($c->rate)
				$rates[] = [(string)$c->exchangedate, (string)$c->rate ];
		}

		return $rates; // array
	}

}