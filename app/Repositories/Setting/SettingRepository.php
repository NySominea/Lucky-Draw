<?php

namespace App\Repositories\Setting;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface SettingRepository.
 *
 * @package namespace App\Repositories\Setting;
 */
interface SettingRepository extends RepositoryInterface
{
    public function createOrUpdate(array $data);
}
