<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\DiffType
 *
 * @property int $id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DiffType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiffType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiffType query()
 * @method static \Illuminate\Database\Eloquent\Builder|DiffType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiffType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiffType whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiffType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DiffType extends Model
{
    protected $table = 'diff_types';

    protected $fillable = [
      'title',
    ];
}
