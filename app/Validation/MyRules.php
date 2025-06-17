<?php

namespace App\Validation;

class MyRules
{
    public function date_greater_than_equal_to(string $endDate, string $fields, array $data): bool {
        if(!isset($data[$fields])){
            return false;
        }

        return strtotime($endDate) >= strtotime($data[$fields]);
    }

    public function date_greater_than_equal_to_today(string $date, string $fields = null, array $data = []): bool {
        $dateInput = strtotime($date);
        $todayDate = strtotime(date('Y-m-d'));

        return $dateInput >= $todayDate;
    }
}
