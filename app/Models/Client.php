<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
    ];

    protected $guarded = ['id'];

    /**
     * Get the invoices associated with the client.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

}
