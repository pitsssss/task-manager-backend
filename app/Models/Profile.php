<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Profile
 * 
 * @property int $id
 * @property int $user_id
 * @property string $phoneNumber
 * @property string|null $address
 * @property string|null $bio
 * @property Carbon|null $date_of_birth
 * @property string $image
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Profile extends Model
{
	protected $table = 'profiles';

	protected $casts = [
		'user_id' => 'int',
		'date_of_birth' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'phoneNumber',
		'address',
		'bio',
		'date_of_birth',
		'image'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
