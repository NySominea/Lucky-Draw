<?php

namespace App\Repositories\User;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserRepository.
 *
 * @package namespace App\Repositories\User;
 */
interface UserRepository extends RepositoryInterface
{
    public function create(array $data);

    public function update(array $data, $id);
}
