<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DumpDiff
 *
 * @property int $id
 * @property int $resource_old_dump_id
 * @property int $resource_new_dump_id
 * @property string $html
 * @property string $json
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DumpDiff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DumpDiff newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DumpDiff query()
 * @method static \Illuminate\Database\Eloquent\Builder|DumpDiff whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DumpDiff whereHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DumpDiff whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DumpDiff whereJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DumpDiff whereResourceNewDumpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DumpDiff whereResourceOldDumpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DumpDiff whereUpdatedAt($value)
 * @property-read \App\Models\ResourceDump|null $newDump
 * @property-read \App\Models\ResourceDump|null $oldDump
 * @mixin \Eloquent
 */
class DumpDiff extends Model
{
    protected $table = 'dump_diffs';

    public function oldDump(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ResourceDump::class, 'id', 'resource_old_dump_id');
    }

    public function newDump(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ResourceDump::class, 'id', 'resource_new_dump_id');
    }
}
