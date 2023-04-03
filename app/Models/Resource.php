<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Resource
 *
 * @property int $id
 * @property int $parent_id
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Resource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Resource newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Resource query()
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereUrl($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Resource> $children
 * @property-read int|null $children_count
 * @property-read Resource|null $parent
 * @mixin \Eloquent
 */
class Resource extends Model
{
    protected $table = 'resources';

    public function parent(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Resource::class, 'id', 'parent_id');
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Resource::class, 'parent_id', 'id');
    }
}
