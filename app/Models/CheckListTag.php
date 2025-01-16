<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CheckListTag extends Model
{
    protected $guarded = false;
    protected $table = 'check_lists_tags';

    public static function getTags($checkListId)
    {
        return DB::table('check_lists_tags')
            ->where('check_list_id', $checkListId)
            ->leftJoin('tags', 'tags.id', '=', 'check_lists_tags.tag_id')
            ->select('tags.name as tag_name', 'tags.id as tag_id')
            ->get();
    }

    public static function deleteCheckListsTags($checkListId)
    {
        DB::table('check_lists_tags')->where('check_list_id', $checkListId)->delete();
    }
}
