<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Favorite
 * 
 * @property int $id
 * @property int $user_id
 * @property int $task_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Task $task
 * @property User $user
 *
 * @package App\Models
 */
class Favorite extends Model
{
	protected $table = 'favorites';

	protected $casts = [
		'user_id' => 'int',
		'task_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'task_id'
	];

	public function task()
	{
		return $this->belongsTo(Task::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
