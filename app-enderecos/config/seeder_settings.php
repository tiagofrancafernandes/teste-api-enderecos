<?php

/*
|--------------------------------------------------------------------------
| Configrações básicas de seeders
|--------------------------------------------------------------------------
|
| - Mostrar detalhes
| - Máximo de elementos a semear
| - Se deve semear caso apenas se não houver registro na base
|
*/

return [
    /**
     * Mostrar detalhes a cada execução
     */
    'verbose' => env('SEED_SET_VERBOSE', env('APP_DEBUG', false)),

    /**
     * Máximo de elementos a semear na base
     */
    'enable_max_to_seed' => env('SEED_SET_MAX_TO_SEED', false),
    'max_to_seed'        => env('SEED_SET_MAX_TO_SEED', 1000),

    /**
     * Se deve semear caso APENAS se não houver registro na base
     */
    'seed_only_has_no_data' => env('SEED_SET_SEED_ONLY_HAS_NO_DATA', true),

];
