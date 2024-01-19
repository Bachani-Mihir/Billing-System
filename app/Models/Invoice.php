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
    protected $fillable = [
        'client_id',
        'employee_id',
    ];

    protected $guarded = ['id'];

    /**
     * Get the invoice that owns the client.
     */
    public function clients()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the invoice that owns the employee.
     */
    public function employees()
    {
        return $this->belongsTo(Employee::class);
    }
}
