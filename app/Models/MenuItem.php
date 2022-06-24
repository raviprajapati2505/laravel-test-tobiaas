<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
   */
    protected $fillable = [
      'name',
      'url',
      'parent_id',
      'created_at'
    ];
  
    // //each category might have one parent
    // public function parent() {
    //   return $this->belongsToOne(static::class, 'parent_id');
    // }
  
    // //each category might have multiple children
    // public function children() {
    //   return $this->hasMany(static::class, 'parent_id')->orderBy('name', 'asc');
    // }
    // Define Eloquent parent child relationship
    public function parent() {
        return $this->belongsTo(self::class, 'parent_id');
    }

    // for first level child this will works enough
    public function children() {
        return $this->hasMany(self::class, 'parent_id');
    }

    // and here is the trick for nestable child. 
    public static function nestable($items) {
      foreach ($items as $item) {
          if (!$item->children->isEmpty()) {
              $item->children = self::nestable($item->children);
            }
        }

        return $items;
    }
    
    public static function getChildren($parent) {
      $tree = Array();
      if (!empty($parent)) {
          $tree = MenuItem::where('parent_id', $parent)->toArray();
          foreach ($tree as $key => $val) {
              $ids = self::getChildren($val);
              if(!empty($ids)){
                  if(count($ids)>0) $tree = array_merge($tree, $ids);
              }
          }
      }
      return $tree;
  }
}
