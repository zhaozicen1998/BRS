<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Borrow
 *
 * @property int $id
 * @property int $reader_id
 * @property int $book_id
 * @property string $status
 * @property string|null $request_processed_at
 * @property int|null $request_managed_by
 * @property string|null $deadline
 * @property string|null $returned_at
 * @property int|null $return_managed_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Book $books
 * @property-read \App\Models\User $borrowedReader
 * @property-read \App\Models\User|null $requestedManager
 * @property-read \App\Models\User|null $returnedManager
 * @method static \Illuminate\Database\Eloquent\Builder|Borrow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Borrow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Borrow query()
 * @method static \Illuminate\Database\Eloquent\Builder|Borrow whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Borrow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Borrow whereDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Borrow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Borrow whereReaderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Borrow whereRequestManagedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Borrow whereRequestProcessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Borrow whereReturnManagedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Borrow whereReturnedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Borrow whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Borrow whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Borrow extends Model
{
    protected $fillable = [
        'reader_id',
        'book_id',
        'status'
    ];

    public function borrowedReader()
    {
        return $this->belongsTo(User::class, 'reader_id');
    }

    public function requestedManager()
    {
        return $this->belongsTo(User::class, 'request_managed_by');
    }

    public function returnedManager()
    {
        return $this->belongsTo(User::class, 'return_managed_by');
    }

    public function books()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    // 修复时间戳输出格式
    protected function serializeDate($date)
    {
        return $date->format('Y-m-d H:i');
    }
}
