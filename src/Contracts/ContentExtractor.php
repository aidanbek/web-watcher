<?php

namespace Ditcher\Contracts;

interface ContentExtractor
{
    public function extract(): Content;
}