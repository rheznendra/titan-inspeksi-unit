<?php

if (!function_exists('asSelectArray')) {
    function asSelectArray($enumClass)
    {
        return array_map(
            fn($case) => [
                'label' => method_exists($case, 'label') ? ($case->shortLabel() ?? $case->label()) : $case->name,
                'value' => $case->value
            ],
            $enumClass
        );
    }
}

if (!function_exists('yearsRange')) {
    function yearsRange($startYear = null, $endYear = null, $asOptions = true)
    {
        if (!$startYear) {
            $startYear = date('Y');
        }
        if (!$endYear) {
            $endYear = date('Y') - 50;
        }

        $range = range($startYear, $endYear);

        if (!$asOptions) {
            return $range;
        }

        return collect($range)
            ->map(fn($year) => ['value' => $year, 'label' => $year])
            ->all();
    }
}
