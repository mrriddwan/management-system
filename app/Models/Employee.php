<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'company_id',
    ];

    protected $casts =
    [
        'first_name'   => 'string',
        'last_name'    => 'string',
        'email'        => 'string',
        'phone_number' => 'string',
        'company_id'   => 'integer',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
