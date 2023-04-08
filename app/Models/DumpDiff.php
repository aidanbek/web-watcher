<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DumpDiff
 *
 * @property int $id
 * @property int $page_old_dump_id
 * @property int $page_new_dump_id
 * @property string $html
 * @property string $json
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PageDump|null $newDump
 * @property-read \App\Models\PageDump|null $oldDump
 * @method static \Illuminate\Database\Eloquent\Builder|DumpDiff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DumpDiff newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DumpDiff query()
 * @method static \Illuminate\Database\Eloquent\Builder|DumpDiff whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DumpDiff whereHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DumpDiff whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DumpDiff whereJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DumpDiff wherePageNewDumpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DumpDiff wherePageOldDumpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DumpDiff whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DumpDiff extends Model
{
    protected $table = 'dump_diffs';

    protected $fillable = [
        'page_old_dump_id',
        'page_new_dump_id',
        'html',
        'json'
    ];

    public function oldDump(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(PageDump::class, 'id', 'page_old_dump_id');
    }

    public function newDump(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(PageDump::class, 'id', 'page_new_dump_id');
    }
}
