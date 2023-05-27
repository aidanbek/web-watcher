<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PageSibling
 *
 * @property int $id
 * @property int $page_id
 * @property int $sibling_page_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PageSibling newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageSibling newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageSibling query()
 * @method static \Illuminate\Database\Eloquent\Builder|PageSibling whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageSibling whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageSibling wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageSibling whereSiblingPageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageSibling whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PageSibling extends Model
{
    use HasFactory;

    protected $table = 'page_siblings';

    protected $fillable = [
        'page_id',
        'sibling_page_id',
    ];
}
