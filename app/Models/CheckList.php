<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CheckList extends Model
{
    protected $guarded = false;
    protected $table = 'check_lists';

    public static function getCheckLists()
    {
        return DB::table('check_lists')
            ->select('id as check_list_id', 'name', 'isOnPublish')
            ->get();
    }

    public static function changePublishStatus($checkListId, $publishStatus)
    {
        DB::table('check_lists')
            ->where('id', $checkListId)
            ->update(['isOnPublish' => $publishStatus]);
    }

    public static function deleteCheckList($checkListId)
    {
        DB::table('check_lists')
            ->where('id', $checkListId)
            ->delete();
    }

}
