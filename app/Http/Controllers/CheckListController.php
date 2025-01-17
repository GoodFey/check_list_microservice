<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckList\StoreCheckListRequest;
use App\Http\Requests\CheckList\UpdateRequest;
use App\Models\CheckList;
use App\Models\CheckListItem;
use App\Models\CheckListTag;
use App\Models\Tag;
use Illuminate\Http\Request;

class CheckListController extends Controller
{
    public static function store(StoreCheckListRequest $request)
    {
        $data = $request->validated();

        // Сохранение чек листа
        $currentCheckList = CheckList::create([
            'name' => $data['checklist']['name'],
            'isOnPublish' => $data['checklist']['isOnPublish'],
        ]);

        // Сохранение пунктов чек листа, с привязкой к id текущего чек-листа
        foreach ($data['checklist']['items'] as $item) {

            CheckListItem::create([
                    'text' => $item['text'],
                    'check_list_id' => $currentCheckList->id
                ]
            );
        }

        // Разделение строки тегов на массив
        $tags = array_map(function ($tag) {
            return strtolower(trim($tag));
        }, explode(',', $data['checklist']['tags']));


        // Сохранение тегов в базе данных + cохранение таблицы чек листы - тэги (многие ко многим)
        foreach ($tags as $tag) {
            $currentTag = Tag::firstOrCreate(['name' => $tag]);
            CheckListTag::create([
                'tag_id' => $currentTag->id,
                'check_list_id' => $currentCheckList->id,
            ]);
        }

        return response()->json('success', 201);
    }

    public static function index()
    {
        $checkLists = CheckList::getCheckLists()->toArray();

        foreach ($checkLists as $checkList) {
            $checkList->items = CheckListItem::getItems($checkList->check_list_id)->toArray();
            $checkList->tags = CheckListTag::getTags($checkList->check_list_id)->toArray();
        }

        return response()->json($checkLists);
    }

    public static function changePublishStatus($checkListId, Request $request)
    {
        $publishStatus = $request->validate([
            'isOnPublish' => ['nullable', 'boolean'],
        ]);


        CheckList::changePublishStatus($checkListId, $publishStatus['isOnPublish']);

        return response()->json('success', 201);
    }

    public static function delete($checkListId)
    {
        CheckListTag::deleteCheckListsTags($checkListId);
        CheckListItem::deleteCheckListItems($checkListId);
        CheckList::deleteCheckList($checkListId);


    }

    public static function edit($checklistId)
    {

        $checkList = CheckList::find($checklistId);
        $checkList->items = CheckListItem::getItems($checklistId)->toArray();
        $checkList->tags = CheckListTag::getTags($checklistId)->toArray();

        return response()->json($checkList->toArray());
    }


    public static function update($checklistId, UpdateRequest $request)
    {

        $data = $request->validated();


        // Сохранение чек листа
        $currentCheckList = CheckList::find($checklistId);
        $currentCheckList->update([
            'name' => $data['checklist']['name'],
            'isOnPublish' => $data['checklist']['isOnPublish'] ? 1 : 0
        ]);

        // Сохранение пунктов чек листа, с привязкой к id текущего чек-листа
        foreach ($data['checklist']['items'] as $item) {
            CheckListItem::updateOrCreate(
                ['id' => $item['item_id']], // Условие для поиска записи
                [
                    'text' => $item['item_text'], // Поля для обновления
                    'check_list_id' => $currentCheckList->id,
                ]);
        }

        // Разделение строки тегов на массив
        $tags = array_map(function ($tag) {
            return strtolower(trim($tag));
        }, explode(',', $data['checklist']['tags']));



        // Сохранение тегов в базе данных + cохранение таблицы чек листы - тэги (многие ко многим)
        foreach ($tags as $tag) {
            $currentTag = Tag::firstOrCreate(['name' => $tag]);
            CheckListTag::updateOrCreate([
                'tag_id' => $currentTag->id,
                'check_list_id' => $currentCheckList->id,
            ]);
        }


        return response()->json();
    }
}
