<?php

declare(strict_types=1);

namespace Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;
use Tests\Fixtures\Support\FillHelper;

final class User extends Model
{
    public string $name = '';

    public function hydrate(array $data): void
    {
        $this->fill($data);
    }

    public function hydrateForce(array $data): void
    {
        $this->forceFill($data);
    }

    public function assign(array $data): void
    {
        $this->name = $data['name'] ?? $this->name;
    }

    public function usesHelper(FillHelper $helper): void
    {
        $helper->fill(['foo' => 'bar']);
    }
}
