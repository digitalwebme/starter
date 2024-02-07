<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Event;
use App\Models\Traits\HasEnums;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Session;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasEnums;

    final const TYPE_STANDARD = 'standard';
    final const TYPE_ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function __construct(array $attributes = array()){
        parent::__construct($attributes);
        $this->connection = 'mysql';
    }
    protected static function booted()
    {
        static::addGlobalScope('onlyActive', function (Builder $builder) {
            $builder->where('is_active', 1);
        });
    }

    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt($value);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    
    public function customers()
    {
        //$this->connection = 'mysql3';
        return $this->belongsToMany(Customer::class);
    }

    public function isAdmin()
    {
        return $this->type == User::TYPE_ADMIN;
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
