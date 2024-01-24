<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the invoice that owns the user.
     */
    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
