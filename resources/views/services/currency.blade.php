<?php

function clearInputStr($str)
{
    return trim(strip_tags($str));
}

function clearInputInt($val)
{
    return intval(trim($val));
}

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

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currency = clearInputStr($_POST['currency']);
    $dateFrom = new DateTime($_POST['from']);
    $dateTo = new DateTime($_POST['to']);
} else {
    $currency = 'USD';
    $dateFrom = new DateTime('2 week ago');
    $dateTo = new DateTime();
}
?>

<div class="container-fluid services" data-title="{{ $title }}">
    @if(isset($partitions_view) && $partitions_view)
        {!! $partitions_view !!}
    @endif
    @if($work)
        @php
            $exchange = new Exchange();
            $exchange->loadCurrenciesList();
        @endphp
        <section class="dynamic {{ $work->alias }}"
                 data-script="{{ asset(config('settings.services_dir')). '/' . $work->alias . '/' . $work->alias . '.js' }}"
                 data-style="{{ asset(config('settings.services_dir')). '/' . $work->alias . '/' . $work->alias . '.css' }}">
            <div class="main-container">
                <div class="main-block">
                    @if ($exchange::$currencies)
                        <form action="{{ asset(config('settings.services_dir')). '/' . $work->alias }}" method="post">
                            <div class="form-inline">
                                <div class="form-group current-currency">
                                    <label for="currency">Валюта:</label>
                                    <select class="custom-select" name="currency" id="currency">
                                        @foreach ($exchange::$currencies as $curr => $text) {
                                        <option value='{{ $curr }}' {{ ($curr === $currency) ? 'selected' : '' }}>
                                            {{ $text }} [{{ $curr }}]
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="current_rate">
                                <p>Текущий курс: <span id="current_rate"></span></p>
                            </div>
                            <p>Показать динамику за период: </p>
                            <div class="period form-inline">
                                <label for="from">С</label>
                                <input class="form-control" name="from" id="from" type="text"
                                       value="<?= $dateFrom->format('d.m.Y')?>">
                                <label for="to">по</label>
                                <input class="form-control" name="to" id="to" type="text"
                                       value="<?= $dateTo->format('d.m.Y')?>">
                                <input class="btn btn-d" type="submit" value="Показать">
                            </div>
                            <p class="help-block">Доступны данные за последних 20 лет. Для получения более точных
                                значений
                                рекомендуется сузить временной диапазон</p>
                            <div class='alert alert-danger' id="status" style="display: none;">
                                <p>{{ $msg }}</p>
                            </div>
                            <div class="chart">
                                <div class='cssload-container'>
                                    <div class='cssload-whirlpool'></div>
                                </div>
                                <img id='diagram'>
                            </div>
                        </form>
                    @else
                        <div class='alert alert-danger'>
                            <p>Не удалось соединиться с сервисом НБУ</p>
                        </div>
                    @endif
                </div>
                <div class="description_note">
                    <div class="desc_header">
                        <a href="javascript:void(0)" id="description__close">X</a>
                    </div>
                    <div class="desc_common">
                        <div class="desc_text">
                            <h2>{{ $work->title }}</h2>
                            <p>{!! $work->text !!}</p>
                        </div>
                        <div class="desc_meta">
                            @if($work->customer)
                                <p><strong>Заказчик:</strong> {{ $work->customer }}</p>
                            @endif
                            @if($work->techs)
                                <p><strong>Технологии:</strong> {{ $work->techs }}</p>
                            @endif
                            @if($work->created_at)
                                <p><strong>Дата:</strong> {{ $work->created_at }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
</div>

@php
    unset($exchange);
@endphp