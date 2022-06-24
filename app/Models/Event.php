<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
  use HasFactory;
  
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'created_at'
  ];

  /**
   * @return HasOne
   * @description get the detail associated with the post
   */
  public function workshops(): HasMany
  {
      return $this->hasMany(Workshop::class);
  }
}
