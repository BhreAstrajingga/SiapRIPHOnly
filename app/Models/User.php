<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\DataUser;
use App\Models\PullRiph;
use App\Models\Post;
use App\Models\MasterKelompok;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
	use SoftDeletes;
	use Notifiable;
	use Auditable;
	use HasFactory;
	use HasApiTokens;

	public const ROLE_TYPE_SELECT = [
		'1' => 'Kementerian/Direktorat',
		'2' => 'Pelaku Usaha',
	];



	public $table = 'users';

	protected $hidden = [
		'remember_token',
		'password',
	];

	protected $dates = [
		'email_verified_at',
		'created_at',
		'updated_at',
		'deleted_at',
	];

	protected $fillable = [
		'name',
		'username',
		'email',
		'email_verified_at',
		'password',
		'remember_token',
		'roleaccess',
		'created_at',
		'updated_at',
		'deleted_at',
	];

	public static function getUserById($id)
	{
		$user = User::where(function ($query) use ($id) {
			$query
				->where('id', $id);
		})
			->with('data_user')
			->get();

		return $user;
	}

	public function getIsAdminAttribute()
	{
		return $this->roles()->where('id', 1)->exists();
	}

	public function isSRoot()
    {
        return $this->roles()->where('id', 7)->exists();
    }

	public function getEmailVerifiedAtAttribute($value)
	{
		return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
	}

	public function setEmailVerifiedAtAttribute($value)
	{
		$this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
	}

	public function setPasswordAttribute($input)
	{
		if ($input) {
			$this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
		}
	}

	public function sendPasswordResetNotification($token)
	{
		$this->notify(new ResetPassword($token));
	}

	public function roles()
	{
		return $this->belongsToMany(Role::class);
	}

	public function post()
	{
		return $this->hasMany(Post::class);
	}

	public function data_user()
	{
		return $this->hasOne(DataUser::class);
	}

	public function masterkelompok()
	{
		return $this->hasMany(MasterKelompok::class);
	}


	public function commitmentbackdate()
	{
		return $this->hasMany(CommitmentBackdate::class);
	}

	protected function serializeDate(DateTimeInterface $date)
	{
		return $date->format('Y-m-d H:i:s');
	}


	//new update from branch
	public function starred()
	{
		return $this->belongsToMany('App\Models\Post', 'starred_posts', 'user_id', 'post_id');
	}

	public function dataadmin()
	{
		return $this->belongsTo(DataAdministrator::class, 'id', 'user_id');
	}
}
