<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

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

    public function syncPermissions($permissions) {
        UserHasPermission::where('user_id',$this->id)->delete();
        foreach ($permissions as $permission) {
            UserHasPermission::updateOrCreate([
                'permission_id' => $permission,
                'user_id' => $this->id,
            ]);
        }
    }

    public function hasRole($role) {
        $roleExist = Role::where('name', trim($role))->first();
        if($roleExist) {
            if($roleExist->id == $this->role_id) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function hasPermissionTo($name, $permission) {
        $permissionExist = Permission::whereName($name)->wherePermission($permission)->first();
        if($permissionExist) {
            return self::userHasPermission($permissionExist->id);
        }
        return false;
    }

    public function userHasPermission($permissionId) {
        $authorize = UserHasPermission::whereUserId($this->id)->wherePermissionId($permissionId)->first();
        if($authorize) {
            return true;
        }
        return false;
    }

    public function userHavingPermissions() {
        return $this->hasMany(UserHasPermission::class);
    }

    public function role() {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
}
