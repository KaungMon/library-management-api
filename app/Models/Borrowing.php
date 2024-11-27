<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'librarian_id',
        'member_id',
        'borrow_date',
        'return_date',
        'status_id'
    ];

    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function book() {
        return $this->belongsTo(Book::class);
    }

    public function librarian() {
        return $this->belongsTo(User::class, 'librarian_id');
    }

    public function member() {
        return $this->belongsTo(User::class, 'member_id');
    }
}
