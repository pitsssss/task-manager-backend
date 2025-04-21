<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

	protected $table = 'users';

	protected $casts = [
		'email_verified_at' => 'datetime'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'email',
		'Role',
		'email_verified_at',
		'password',
		'remember_token'
	];

public function favoriteTasks()
{
    return $this->belongsToMany(Task::class, 'favorites');
}


	public function profiles()
	{
		return $this->hasMany(Profile::class);
	}

	public function tasks()
	{
		return $this->hasMany(Task::class);
	}
}
