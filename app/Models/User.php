<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Auth;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

     public static function checkRole($key)
    {
        // Check if user is authenticated first
        if (!Auth::check() || !Auth::user()) {
            return false;
        }
        
        $data = Role::where('id', Auth::user()->role_id)->where('slug', $key)->first();
        if ($data)
        {
            return true;
        }else{
            return false;
        }

    }

     public static function getRole($key)
    {
        // Check if user is authenticated first
        if (!Auth::check() || !Auth::user()) {
            return false;
        }
        
        $data = Role::where('id', Auth::user()->role_id)->where('id', $key)->first();
        if ($data)
        {
            return $data->name;
        }else{
            return false;
        }

    }

     public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
