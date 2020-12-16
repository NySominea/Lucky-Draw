<?php

namespace App\Repositories\Draw;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface DrawRepository.
 *
 * @package namespace App\Repositories;
 */
interface DrawRepository extends RepositoryInterface
{
    public function createOrUpdate(array $data, $id);
}
