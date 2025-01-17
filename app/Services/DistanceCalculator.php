<?php

namespace App\Services;

use Programic\DistanceMatrix\DistanceMatrix;
use Programic\DistanceMatrix\Response;

class DistanceCalculator
{
    /**
     * Create a new class instance.
     */

    protected DistanceMatrix $matrix;
    public function __construct(DistanceMatrix $matrix)
    {
        $this->matrix = $matrix;
    }

    public function calculateDistance(string $from, string $to): Response
    {
        try {
            $response = $this->matrix->from($from)->to($to)->calculate();
        } catch (\Exception $e) {
            //
        }

        return $response;
    }
}
