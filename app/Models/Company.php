<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'name',
        'email',
        'logo',
        'website_url',
    ];

    protected $casts =
    [
        'name'        => 'string',
        'email'       => 'string',
        'logo'        => 'string',
        'website_url' => 'string',
    ];

    protected $appends = [
        'employee_count',
    ];

    public function employees():HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function getEmployeeCountAttribute()
    {
        return $this->employees()->count();
    }
}
