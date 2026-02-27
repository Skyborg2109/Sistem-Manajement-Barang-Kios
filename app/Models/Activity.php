<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['user_id', 'type', 'description', 'is_read'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function unreadCount()
    {
        return self::where('is_read', false)->count();
    }

    public static function log($description, $type = 'system')
    {
        return self::create([
            'user_id' => auth()->id(),
            'type' => $type,
            'description' => $description
        ]);
    }

    public static function getLatest($limit = 5)
    {
        return self::with('user')->latest()->limit($limit)->get();
    }
}
