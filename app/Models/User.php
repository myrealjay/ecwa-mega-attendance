<?php

namespace App\Models;

use App\Mail\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use SoftDeletes;
    use HasApiTokens, HasFactory, Notifiable;

    const STATUS = [
        'ACTIVE' => 'active',
        'SUSPENDED' => 'suspended'
    ];

    protected $guarded = ['id'];

    protected $appends = ['name'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Send the email verification notification.
     *
     * @param string $password
     * @return void
     */
    public function sendEmailVerification(string $password)
    {
        $this->notify(new VerifyEmail($this, $password));
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getNameAttribute()
    {
        return ucwords($this->attributes['first_name'] . ' '.$this->attributes['last_name']);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function firstName() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
        );
    }

    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function lastName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
        );
        
    }

     /**
     * Get the user's dob.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function dob() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => date('Y-m-d', strtotime($value)),
        );
    }

    /**
     * Get the user's wedding date.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function weddingDate() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? date('Y-m-d', strtotime($value)) : null,
        );
    }

    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => ucfirst($attributes['first_name']).' '.ucfirst($attributes['last_name']),
        );
    }
}
