<?php
require_once 'exchange.class.php';

//require_once '../inc/lib.inc.php';

class Diagram
{
    const CUSTOM_FONT = FONT_DIR . "RobotoCondensed-Regular.ttf";
    //const MONTH_NAMES = ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'];

    private $img,
        $currency,
        $from,
        $to,
        $rates,
        $background_color,
        $axis_color,
        $column_color,
        $column_shadow_color,
        $column_glare_color,
        $light_color;

    function __construct($currency, $from, $to)
    {
        $this->img = imageCreateTrueColor(...IMAGE_SIZE);
        $this->currency = $currency;
        $this->from = $from;
        $this->to = $to;

        imageAntiAlias($this->img, true);

        $this->_set_palette();
        $this->_show_axises();
        $this->_show_columns();
    }

    function __destruct()
    {
        imageDestroy($this->img);
    }

    private function _set_palette()
    {
        $this->background_color = imageColorAllocate($this->img, ...BACKGROUND_COLOR);

        $this->axis_color = imageColorAllocate($this->img, ...AXIS_COLOR);

        $this->column_color = imageColorAllocate($this->img, ...COLUMN_COLOR);

        $column_shadow_color_rgb = array_map([$this, "_shadow_rgb"], COLUMN_COLOR);
        $this->column_shadow_color = imageColorAllocate($this->img, ...$column_shadow_color_rgb);

        $column_glare_color_rgb = array_map([$this, "_glare_rgb"], COLUMN_COLOR);
        $this->column_glare_color = imageColorAllocate($this->img, ...$column_glare_color_rgb);

        $this->light_color = imageColorAllocate($this->img, ...LIGHT_COLOR);
    }

    private function _show_axises()
    {
        imageFill($this->img, 0, 0, $this->background_color);

        // Axis Y
        imageRectangle($this->img, CONT_RECT['left'], CONT_RECT['top'],
            CONT_RECT['left'] + 1, CONT_RECT['bottom'], $this->axis_color);
        imageLine($this->img, CONT_RECT['left'], CONT_RECT['top'],
            CONT_RECT['left'] - 2, CONT_RECT['top'] + 13, $this->axis_color);
        imageLine($this->img, CONT_RECT['left'] + 1, CONT_RECT['top'],
            CONT_RECT['left'] - 2 + 1, CONT_RECT['top'] + 10, $this->axis_color);
        imageLine($this->img, CONT_RECT['left'], CONT_RECT['top'],
            CONT_RECT['left'] + 2, CONT_RECT['top'] + 10, $this->axis_color);
        imageLine($this->img, CONT_RECT['left'] + 1, CONT_RECT['top'],
            CONT_RECT['left'] + 2 + 1, CONT_RECT['top'] + 13, $this->axis_color);
        imageTtfText($this->img, FONT_SIZE, 0,
            CONT_RECT['left'] - $this->_centralizer("грн") * 2 - 6, CONT_RECT['top'] + 7,
            $this->axis_color, self::CUSTOM_FONT, "грн");

        // Axis X
        imageRectangle($this->img, CONT_RECT['left'], CONT_RECT['bottom'],
            CONT_RECT['right'], CONT_RECT['bottom'] + 1, $this->axis_color);
        imageLine($this->img, CONT_RECT['right'], CONT_RECT['bottom'],
            CONT_RECT['right'] - 10, CONT_RECT['bottom'] + 2, $this->axis_color);
        imageLine($this->img, CONT_RECT['right'], CONT_RECT['bottom'] + 1,
            CONT_RECT['right'] - 13, CONT_RECT['bottom'] + 2 + 1, $this->axis_color);
        imageLine($this->img, CONT_RECT['right'], CONT_RECT['bottom'],
            CONT_RECT['right'] - 13, CONT_RECT['bottom'] - 2, $this->axis_color);
        imageLine($this->img, CONT_RECT['right'], CONT_RECT['bottom'] + 1,
            CONT_RECT['right'] - 10, CONT_RECT['bottom'] - 2 + 1, $this->axis_color);
        imageTtfText($this->img, FONT_SIZE, 0,
            CONT_RECT['right'] - $this->_centralizer("Дата") * 2, CONT_RECT['bottom'] + 24,
            $this->axis_color, self::CUSTOM_FONT, "Дата");

        // Title
        $x = round((CONT_RECT['right'] + CONT_RECT['left']) / 2) - 10;
        imageTtfText($this->img, FONT_SIZE + 4, 0, $x, CONT_RECT['top'] + 14,
            $this->axis_color, FONT_DIR . "RobotoCondensed-Bold.ttf", $this->currency);

    }

    private function _show_columns()
    {
        $start = CONT_RECT['left'] + 64;
        $end = CONT_RECT['left'] + 700;

        $exchange = new Exchange();
        $this->rates = $exchange->getRatesForPeriod($this->currency, $this->from, $this->to);

        // rateMin, rateAvr, rateMax
        // scaleX, scaleY
        $scaleX = ($end - $start) / (count($this->rates) - 1);
        $rateMax = $rateAvr = 0;
        $rateMin = INF;
        foreach ($this->rates as $rate) {
            $r = floatval($rate[1]);
            if ($r > $rateMax)
                $rateMax = $r;
            if ($r < $rateMin)
                $rateMin = $r;
            $rateAvr += $r;
        }

        // Max line
        imageLine($this->img, CONT_RECT['left'] + 2, MAX_RATE_Y,
            CONT_RECT['right'], MAX_RATE_Y, $this->light_color);
        $rateMaxFormat = rtrim(sprintf("%6.6s", $rateMax), '.');
        $x = CONT_RECT['right'] - $this->_centralizer((string)$rateMaxFormat) * 2 + 5;
        $y = MAX_RATE_Y + round(FONT_SIZE / 2);
        imageFilledRectangle($this->img, $x - 3, MAX_RATE_Y + 1,
            CONT_RECT['right'] + 15, MAX_RATE_Y - 1, $this->background_color);
        imageTtfText($this->img, FONT_SIZE, 0, $x, $y,
            $this->axis_color, self::CUSTOM_FONT, $rateMaxFormat);

        if ($rateMax != $rateMin) {
            $rateAvr = $rateAvr / count($this->rates);
            $scaleY = (MIN_RATE_Y - MAX_RATE_Y) / ($rateMax - $rateMin);

            // Min line
            imageLine($this->img, CONT_RECT['left'] + 2, MIN_RATE_Y,
                CONT_RECT['right'], MIN_RATE_Y, $this->light_color);
            $rateMinFormat = rtrim(sprintf("%6.6s", $rateMin), '.');
            $x = CONT_RECT['right'] - $this->_centralizer((string)$rateMinFormat) * 2 + 5;
            $y = MIN_RATE_Y + round(FONT_SIZE / 2);
            imageFilledRectangle($this->img, $x - 3, MIN_RATE_Y + 1,
                CONT_RECT['right'] + 15, MIN_RATE_Y - 1, $this->background_color);
            imageTtfText($this->img, FONT_SIZE, 0, $x, $y,
                $this->axis_color, self::CUSTOM_FONT, $rateMinFormat);

            // Average line
            $avr_rate_y = MIN_RATE_Y - round(($rateAvr - $rateMin) * $scaleY);
            imageLine($this->img, CONT_RECT['left'] + 2, $avr_rate_y,
                CONT_RECT['right'], $avr_rate_y, $this->light_color);
            $rateAvrFormat = rtrim(sprintf("%6.6s", $rateAvr), '.');
            $x = CONT_RECT['left'] - $this->_centralizer((string)$rateAvrFormat) * 2 - 2;
            $y = $avr_rate_y + round(FONT_SIZE / 2);
            imageFilledRectangle($this->img, $x - 10, $avr_rate_y + 1,
                CONT_RECT['left'] - 2, $avr_rate_y - 1, $this->background_color);
            imageTtfText($this->img, FONT_SIZE, 0, $x, $y,
                $this->axis_color, self::CUSTOM_FONT, $rateAvrFormat);
        }

        // Rates
        foreach ($this->rates as $key => $rate) {
            $r = floatval($rate[1]);
            $x = $start + round($scaleX * $key);
            $y = ($rateMax === $rateMin) ? MAX_RATE_Y : MIN_RATE_Y - round(($r - $rateMin) * $scaleY);
            list($day, $month, $year) = explode('.', $rate[0]);
            $dateFrom = new DateTime($this->from);
            $dateTo = new DateTime($this->to);
            $yearsCount = $dateTo->diff($dateFrom)->y;
            $dateText = ($yearsCount) ? "$month.$year" : "$day.$month";
            imageFilledRectangle($this->img, $x - 10, CONT_RECT['bottom'] - 1,
                $x + 10, $y + 1, $this->column_color);
            imageLine($this->img, $x - 11, CONT_RECT['bottom'] - 1,
                $x - 11, $y, $this->column_glare_color);
            imageLine($this->img, $x - 10, $y,
                $x + 10, $y, $this->column_glare_color);
            imageLine($this->img, $x + 11, CONT_RECT['bottom'] - 1,
                $x + 11, $y, $this->column_shadow_color);
            imageTtfText($this->img, FONT_SIZE - 3, 45,
                $x - mb_strlen($dateText) * 3 + 0, CONT_RECT['bottom'] + mb_strlen($dateText) * 3 + 32,
                $this->axis_color, self::CUSTOM_FONT, $dateText);
        }

        unset($exchange);
    }

    function press()
    {
        header('Content-Type: image/jpeg');
        imagePng($this->img);
    }

    private function _shadow_rgb($n)
    {
        $res = $n - 50;
        return ($res > 0) ? $res : 0;
    }

    private function _glare_rgb($n)
    {
        $res = $n + 30;
        return ($res < 255) ? $res : 255;
    }

    private function _centralizer($str)
    {
        return round((mb_strlen($str) / 2) * (FONT_SIZE / 1.6));
    }
}