<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Workshop extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'start',
    'end',
    'event_id',
    'name',
    'created_at'
  ];

  public function event(): BelongsTo
  {
      return $this->belongsTo(Event::class);
  }
}
