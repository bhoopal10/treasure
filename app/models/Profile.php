<?php 
use Illuminate\Database\Eloquent\Relations\BelongsTo,
    Illuminate\Database\Eloquent\Relations\BelongsToMany,
    Illuminate\Database\Eloquent\Relations\HasMany;
class Profile extends Eloquent
{
	protected $table='profile';
}