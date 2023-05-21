<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PageDump
 *
 * @property int $id
 * @property int $page_id
 * @property string $html
 * @property string $raw_html
 * @property string $pretty_html
 * @property string $raw_pretty_html
 * @property string $hash
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read PageDump|null $resource
 * @method static \Illuminate\Database\Eloquent\Builder|PageDump newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageDump newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageDump query()
 * @method static \Illuminate\Database\Eloquent\Builder|PageDump whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageDump whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageDump whereHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageDump whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageDump wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageDump wherePrettyHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageDump whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PageDump extends Model
{
    protected $table = 'page_dumps';

    protected $fillable = [
      'page_id',
      'html',
      'hash',
      'pretty_html',
    ];

    protected $appends = ['raw_html', 'raw_pretty_html'];

    public function resource(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(PageDump::class, 'id', 'resource_id');
    }

    public function getRawHtmlAttribute(): string
    {
        return html_entity_decode($this->html);
    }

    public function getRawPrettyHtmlAttribute(): string
    {
        return html_entity_decode($this->pretty_html);
    }
}
