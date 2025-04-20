<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CategoryTask
 * 
 * @property int $id
 * @property int $category_id
 * @property int $task_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Category $category
 * @property Task $task
 *
 * @package App\Models
 */
class CategoryTask extends Model
{
	protected $table = 'category_task';

	protected $casts = [
		'category_id' => 'int',
		'task_id' => 'int'
	];

	protected $fillable = [
		'category_id',
		'task_id'
	];

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function task()
	{
		return $this->belongsTo(Task::class);
	}
}
