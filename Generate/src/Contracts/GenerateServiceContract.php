<?php

namespace AIGenerate\Services\Generate\Contracts;

use Illuminate\Database\Eloquent\Model;
use AIGenerate\Models\User\User;

interface GenerateServiceContract
{

    public function index(User $user, int $page, int $size);

    public function destroy(Model $generate): bool;

    public function storeExport(Model $generate);
}
