<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Student;
use App\Traits\UniversalSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles;
    use UniversalSearch;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'avatar',
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
            'password' => 'hashed',
        ];
    }


    // Relation Area
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function role()
    {
        return $this->morphToMany(Role::class, 'model', 'model_has_roles');
    }



    // Logic Area
    public function scopeGetUsersSiswaData($query)
    {
        return $query->select('users.id', 'users.username', 'users.email', 'users.avatar', 'students.nis', 'students.user_id')->join('students', 'students.user_id', '=', 'users.id');
    }

    // public function scopeSearch($query, $keyword, array $fields)
    // {
    //     return $query->where(function ($q) use ($keyword, $fields) {
    //         foreach ($fields as $field) {
    //             $q->orWhere($field, 'ILIKE', "%$keyword%");
    //         }

    //         $q->orWhereHas('roles', function ($roleQuery) use ($keyword) {
    //             $roleQuery->where('name', 'ILIKE', "%$keyword%");
    //         });
    //     });
    // }
}
