<?php
class Exchange
{
    const XML_URL = 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange';

    public static $currencies;

    function loadCurrenciesList()
    {
        $url = self::XML_URL;
        self::$currencies = [];
        try {
            $xml = new SimpleXMLElement($url, null, true);
            foreach ($xml->currency as $currency) {
                self::$currencies[(string)$currency->cc] = (string)$currency->txt;
            }
        } catch (Exception $e) {
        }
    }

    function getCurrency($currency, $date)
    {
        $url = self::XML_URL . "?date=" . $date->format('Ymd');
        try {
            $xml = new SimpleXMLElement($url, null, true);
        } catch (Exception $e) {
            return false;
        }
        $res = $xml->xpath("//currency/cc[.='$currency']/parent::*");
        return $res[0]; // SimpleXMLObject
    }

    function getRatesForPeriod($currency, $from, $to)
    {
        $dateFrom = new DateTime($from);
        $dateTo = new DateTime($to);

        // Test if start rate is available
        try {
            while (!$this->getCurrency($currency, $dateFrom)->rate) {
                $dateFrom->modify('+1 year');
                $from = $dateFrom->format('Y-m-d');
                if ($dateFrom > $dateTo)
                    throw new Exception('Нет данных за период.');
            }
        } catch (Exception $e) {
            return false;
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
            if (!$c) {
                return false;
            }
            if ($c->rate)
                $rates[] = [(string)$c->exchangedate, (string)$c->rate];
        }

        return $rates; // array
    }

}