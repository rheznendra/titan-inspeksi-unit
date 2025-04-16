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
