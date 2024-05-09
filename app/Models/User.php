<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    const RULE_ADMIN = 'ADMIN';
    const RULE_EDITOR = 'EDITOR';
    const RULE_USER = 'USER';
    const RULE_DEFAULT = self::RULE_USER;
    const RULES = [
        self::RULE_ADMIN => 'ADMIN',
        self::RULE_EDITOR => 'EDITOR',
        self::RULE_USER => 'USER'
    ];
    public function canAccessPanel(\Filament\Panel $panel): bool{
        return  $this->can('view-admin',User::class);
    }
    public function isAdmin(): bool{
        return $this->rule === self::RULE_ADMIN;
    }
    public function isEditor(): bool{
        return $this->rule === self::RULE_EDITOR;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rule'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
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
    public function likes(): BelongsToMany{
        return $this->belongsToMany(Post::class,'post_like')->withTimestamps();
    }
    public function comments(): HasMany{
        return $this->hasMany(Comment::class);
    }
    public function hasLiked(Post $post){
        return $this->likes()->where('post_id',$post->id)->exists();
    }

}
