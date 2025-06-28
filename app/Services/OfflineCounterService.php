<?php

namespace App\Services;

use App\Repositories\OfflineCounterRepository;

class OfflineCounterService
{
    protected $repository;

    public function __construct(OfflineCounterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getFilteredCounters(?string $serialNumber, int $perPage = 10)
    {
        return $this->repository->getAllWithFilter($serialNumber, $perPage);
    }

    public function getByHash(string $hash)
    {
        return $this->repository->findByHash($hash);
    }
}
