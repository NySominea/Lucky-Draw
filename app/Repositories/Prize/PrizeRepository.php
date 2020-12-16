<?php

namespace App\Repositories\Prize;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface PrizeRepository.
 *
 * @package namespace App\Repositories;
 */
interface PrizeRepository extends RepositoryInterface
{
    public function createOrUpdate(array $data, $id);
}
