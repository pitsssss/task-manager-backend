<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 * 
 * @property int $id
 * @property int $user_id
 * @property string $Title
 * @property string|null $Description
 * @property string $Priority
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 * @property Collection|Category[] $categories
 * @property Collection|Favorite[] $favorites
 *
 * @package App\Models
 */
class Task extends Model
{
	protected $table = 'tasks';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'Title',
		'Description',
		'Priority'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function categories()
	{
		return $this->belongsToMany(Category::class)
					->withPivot('id')
					->withTimestamps();
	}

	public function favorites()
	{
		return $this->hasMany(Favorite::class);
	}
}
