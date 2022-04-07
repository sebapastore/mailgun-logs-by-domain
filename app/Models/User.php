<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    const ROLE_ADMIN = 'Admin';
    const ROLE_CUSTOMER = 'Customer';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Available roles for user.
     */
    public static array $roles = [
        self::ROLE_ADMIN,
        self::ROLE_CUSTOMER,
    ];

    public function domains(): BelongsToMany
    {
        return $this->belongsToMany(Domain::class);
    }

    public static function getRolesForSelect(): Collection
    {
        return Helper::arrayToSelectableCollection(self::$roles);
    }

    public static function getRolesForSelectWithAllOption(): Collection
    {
        return collect([['id' => '', 'name' => 'Todos']])
            ->merge(self::getRolesForSelect());
    }

    public function canAccessDomainData($domainId): bool
    {
        if($this->role === self::ROLE_ADMIN) {
            return true;
        }

        if($this->role === self::ROLE_CUSTOMER) {
            $this->domains->contains(fn($domain, $key) => $domain->id === $domainId);
        }

        return false;
    }

    public function getDomainsForSelect(): Collection
    {
        if($this->role === self::ROLE_ADMIN) {
            return Domain::get()->map(
                fn($domain) => ['id' => $domain->id, 'name' => $domain->name]
            );
        }

        if($this->role === self::ROLE_CUSTOMER) {
            return $this->domains->map(
                fn($domain) => ['id' => $domain->id, 'name' => $domain->name]
            );
        }

        return collect();
    }
}
