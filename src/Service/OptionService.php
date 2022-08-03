<?php

namespace App\Service;

use App\Repository\OptionRepository;

class OptionService
{
    public function __construct(private OptionRepository $repository)
    {}

    public function findAll()
    {
        return $this->repository->findAllForRendering();
    }

    public function getValue(string $name)
    {
        return $this->repository->getValue($name);
    }
}
