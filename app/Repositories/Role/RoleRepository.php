<?php

namespace App\Repositories\Role;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface RoleRepository.
 *
 * @package namespace App\Repositories;
 */
interface RoleRepository extends RepositoryInterface
{
    public function createOrUpdate(array $data, $id);
}
