<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Book
 *
 * @property int $id
 * @property string $title
 * @property int $genre_id
 * @property string $authors
 * @property string|null $description
 * @property string $released_at
 * @property string|null $cover_image
 * @property int $pages
 * @property string $language_code
 * @property string $isbn
 * @property int $in_stock
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Borrow[] $borrows
 * @property-read int|null $borrows_count
 * @property-read \App\Models\Genre|null $genres
 * @method static \Illuminate\Database\Eloquent\Builder|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereAuthors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereGenreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereInStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereIsbn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereLanguageCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book wherePages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereReleasedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Book extends Model
{
    use SoftDeletes, HasFactory;

    public function borrows()
    {
        return $this->hasMany(Borrow::class, 'book_id');
    }

    public function genres()
    {
        return $this->belongsTo(Genre::class, 'genre_id','id');
    }

    public function activeBorrows()
    {
        return $this->getAllBorrows()->where('status', '=', 'ACCEPTED');
    }

    // 关联删除
    public static function boot()
    {
        parent::boot();
        static::deleting(function($book) {
            $book->borrows()->each(function($borrow) {
                $borrow->delete();
            });
        });
    }

    // 修复时间戳输出格式
    protected function serializeDate($date)
    {
        return $date->format('Y-m-d H:i');
    }
}
