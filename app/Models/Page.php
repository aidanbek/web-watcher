<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Page
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string $url
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Page> $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PageDump> $dumps
 * @property-read int|null $dumps_count
 * @property-read \App\Models\PageDump|null $lastDump
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PageDump> $lastTwoDumps
 * @property-read int|null $last_two_dumps_count
 * @property-read Page|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Page parents()
 * @method static \Illuminate\Database\Eloquent\Builder|Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Page withoutTrashed()
 * @mixin \Eloquent
 */
class Page extends Model
{
    use SoftDeletes;

    protected $table = 'pages';

    protected $fillable = ['url', 'title'];

    public function parent(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Page::class, 'id', 'parent_id');
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Page::class, 'parent_id', 'id')->orderBy('title');
    }

    public function dumps(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PageDump::class, 'page_id', 'id')->latest();
    }

    public function lastDump(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(PageDump::class, 'page_id', 'id')->latest();
    }

    public function lastTwoDumps(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->dumps()->limit(2);
    }

    public function scopeParents($q)
    {
        return $q->whereNull('parent_id');
    }
}
