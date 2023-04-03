<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ResourceDump
 *
 * @property int $id
 * @property int $resource_id
 * @property string $html
 * @property string $pretty_html
 * @property string $hash
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ResourceDump newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResourceDump newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResourceDump query()
 * @method static \Illuminate\Database\Eloquent\Builder|ResourceDump whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResourceDump whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResourceDump whereHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResourceDump whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResourceDump wherePrettyHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResourceDump whereResourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResourceDump whereUpdatedAt($value)
 * @property-read ResourceDump|null $resource
 * @mixin \Eloquent
 */
class ResourceDump extends Model
{
    protected $table = 'resource_dumps';

    public function resource(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ResourceDump::class, 'id', 'resource_id');
    }
}
