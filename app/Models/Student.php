<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nis',
        'name',
        'class'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public static function generateNextNis($start_nis = 11901)
    {
        $all_nis = self::orderBy('nis', 'ASC')->pluck('nis');

        $next_nis = null;
        $start_nis = 11901;

        foreach ($all_nis as $nis) {
            if ($start_nis != $nis) {
                $next_nis = $start_nis;
                break;
            }
            $start_nis++;
        }
        return  $next_nis ?? ($all_nis ? $all_nis->max() + 1 : 11901);
    }
}
