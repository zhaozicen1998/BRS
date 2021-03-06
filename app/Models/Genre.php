<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Genre
 *
 * @property int $id
 * @property string $name
 * @property string $style
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property-read int|null $books_count
 * @method static \Illuminate\Database\Eloquent\Builder|Genre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Genre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Genre query()
 * @method static \Illuminate\Database\Eloquent\Builder|Genre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Genre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Genre whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Genre whereStyle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Genre whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Genre extends Model
{
    use SoftDeletes, HasFactory;

    public function books()
    {
        return $this->hasMany(Book::class, 'genre_id','id');
    }

    // 关联删除
    public static function boot()
    {
        parent::boot();
        static::deleting(function($genre) {
            $genre->books()->each(function($book) {
                $book->delete();
            });
        });
    }

    // 修复时间戳输出格式
    protected function serializeDate($date)
    {
        return $date->format('Y-m-d H:i');
    }
}
