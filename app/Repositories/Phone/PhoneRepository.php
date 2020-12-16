<?php

namespace App\Repositories\Phone;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface PhoneRepository.
 *
 * @package namespace App\Repositories;
 */
interface PhoneRepository extends RepositoryInterface
{
    public function createOrUpdate(array $data, $id);
}
