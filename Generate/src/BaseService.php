<?php

namespace App\Modules\Services\Generate\src;

use Illuminate\Database\Eloquent\Model;
use AIGenerate\Models\User\User;
use AIGenerate\Services\Generate\Contracts\GenerateServiceContract;

abstract class BaseService implements GenerateServiceContract
{
    public function index(User $user, int $page, int $size)
    {
        return $this->getRepository()->index($user, $page, $size);
    }

    abstract protected function getRepository();

    public function destroy(Model $generate): bool
    {
        return $this->getRepository()->destroy($generate);
    }

    public function storeExport(Model $generate)
    {
        return $this->getExportRepository()->store($generate);
    }

    abstract protected function getExportRepository();
}
