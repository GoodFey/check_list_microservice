<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CheckListItem extends Model
{
    protected $guarded = false;
    protected $table = 'check_list_items';

    public static function getItems($checkListId)
    {
        return DB::table('check_list_items')
            ->where('check_list_id', $checkListId)
            ->select('id as item_id', 'text as item_text')
            ->get();
    }

    public static function deleteCheckListItems($checkListId)
    {
        return DB::table('check_list_items')
            ->where('check_list_id', $checkListId)
            ->delete();
    }
}
