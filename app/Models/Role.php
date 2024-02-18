<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeSearch(Builder $query, string $search): void
    {
        $query->where('id', 'LIKE', '%' . $search . '%')
            ->orWhere('name', 'LIKE', '%' . $search . '%')
            ->orWhere('guard_name', 'LIKE', '%' . $search . '%')
            ->orderBy('id', 'DESC');
    }
}
