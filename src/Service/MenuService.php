<?php

namespace App\Service;

use App\Repository\MenuRepository;

class MenuService
{
    public function __construct(private MenuRepository $repository)
    {}

    public function findAll()
    {
        return $this->repository->findAllForRendering();
    }
}
