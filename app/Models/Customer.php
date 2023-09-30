<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel as FilamentPanel;
use Filament\Tables\Columns\Layout\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class Customer extends Authenticatable implements FilamentUser
{

    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public static $filamentUserColumn = 'is_filament_user';

    protected $fillable = [
        //persnal information
        "name",
        "email",
        "password",
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function canAccessPanel(FilamentPanel $panel): bool
    {
        if(auth()->user()){
            return true;
        };
        return false;
    }

}
