<?php
namespace App\Traits;

use DateTime;
use IntlDateFormatter;

trait DateManipulation
{
    public function convertToWords($year)
    {
        $units = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
        $tens = ['', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
        $teens = ['diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve'];

        if ($year < 10) {
            return $units[$year];
        } elseif ($year < 20) {
            return $teens[$year - 10];
        } elseif ($year < 100) {
            $unit = $year % 10;
            $ten = (int)($year / 10);

            if($tens[$ten] == 'veinte'){
                $result =  'veinti';
                if ($unit > 0) {
                    $result .= '' . $units[$unit];
                }
                return $result;
            }

            $result = $tens[$ten];
            if ($unit > 0) {
                $result .= ' y ' . $units[$unit];
            }
            return $result;
        } elseif ($year < 1000) {
            $hundreds = (int)($year / 100);
            $remainder = $year % 100;
            $result = $units[$hundreds] . 'cientos';
            if ($remainder > 0) {
                $result .= ' ' . $this->convertToWords($remainder);
            }
            return $result;
        } elseif ($year < 1000000) {
            $thousands = (int)($year / 1000);
            $remainder = $year % 1000;
            $result = $this->convertToWords($thousands) . ' mil';
            if ($remainder > 0) {
                $result .= ' ' . $this->convertToWords($remainder);
            }
            return $result;
        }

        return 'Número fuera de rango';
    }


    public function getNameMonth(DateTime $today): string{
      return IntlDateFormatter::formatObject( $today, 'MMMM' );
    }

    public function getNameDayMonth(DateTime $today): string{
        return IntlDateFormatter::formatObject( $today, "d 'de' MMMM");
    }
    public function getNameDayMonthYear(DateTime $today): string{
        return IntlDateFormatter::formatObject( $today, "d 'de' MMMM 'del' y");
    }

    public function getDayInString(int $numberDay) {
        $unidades = ['', 'primer', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve', 'diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve', 'veinte', 'veintiuno', 'veintidós', 'veintitrés', 'veinticuatro', 'veinticinco', 'veintiséis', 'veintisiete', 'veintiocho', 'veintinueve', 'treinta', 'treinta y uno'];
         if ($numberDay >= 1 && $numberDay <= 31) {
            return $unidades[$numberDay];
        } else {
            return '';
        }
    }

    public function formatDefault(string $date): string{
      return  DateTime::createFromFormat('d/m/Y', $date)->format('Y-m-d');
    }
}