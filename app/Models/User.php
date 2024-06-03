<?php

namespace App\Models;

use App\Models\Profile;
use App\Notifications\VerifyEmail;
use Laravel\Passport\HasApiTokens;
use App\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     description="Users",
 *     @OA\Property(property="id", type="number", format="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="email", type="string"),
 *     @OA\Property(property="role", type="string"),
 *     @OA\Property(property="email_verified_at", type="date"),
 *     @OA\Property(property="password", type="string"),
 *     @OA\Property(property="remember_token", type="string"),
 *     @OA\Property(property="created_at", type="date"),
 *     @OA\Property(property="updated_at", type="date")
 * )
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    public const INSTRUCTOR = 'instructor';
    public const STUDENT = 'student';
    public const ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'role',
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

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id')->withDefault();
    }

    public function courseUsers()
    {
        return $this->hasMany(CourseUser::class);
    }

    public function lessonUsers()
    {
        return $this->hasMany(LessonUser::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'user_id', 'id');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
