<?php

namespace App\Http\Requests\CheckList;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'checklist.name' => 'required|string|max:255', // Название чек-листа обязательно
            'checklist.tags' => 'required|string', // Теги обязательны
            'checklist.items' => 'required|array|min:1', // Список пунктов обязателен и не пустой
            'checklist.items.*.item_id' => 'required|integer', // Каждый элемент должен иметь id и это должно быть целым числом
            'checklist.items.*.item_text' => 'required|string|max:255', // Каждый элемент должен содержать текст
            'checklist.isOnPublish' => 'required|boolean',
        ];
    }
    public function messages()
    {
        return [
            'checklist.name.required' => 'Название чек-листа обязательно.',
            'checklist.tags.required' => 'Теги обязательны.',
            'checklist.items.required' => 'Чек-лист должен содержать хотя бы один пункт.',
            'checklist.items.*.item_id.required' => 'ID каждого пункта обязателен.',
            'checklist.items.*.item_id.integer' => 'ID каждого пункта должен быть числом.',
            'checklist.items.*.item_text.required' => 'Текст каждого пункта обязателен.',
            'checklist.items.*.item_text.string' => 'Текст каждого пункта должен быть строкой.',
            'checklist.items.*.item_text.max' => 'Текст каждого пункта не должен превышать 255 символов.',
        ];
    }
}
