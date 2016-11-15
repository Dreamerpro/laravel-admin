<?php
namespace App\Traits;
use Webpatser\Uuid\Uuid as U;

trait Uuid{
	
	protected static function boot()
	{
		parent::boot();
		static::creating(function($model)
		{
			$model->{$model->getKeyName()}=U::generate(4);
		});
	}
}