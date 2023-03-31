<?php

namespace Ditcher\Contracts;

interface DiffCalculator
{
    public function calculate($old, $new): Diff;
}