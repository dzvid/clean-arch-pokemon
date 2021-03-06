<?php

declare(strict_types=1);

namespace App\Shared\Adapters\Presentation\Contracts;

interface PayloadPresenter
{
    public function output(array $data, array $options = []): string;
}