<?php

namespace InetStudio\GoogleOptimizePackage\Experiments\Http\Requests\Back\Resource;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\GoogleOptimizePackage\Pages\DTO\ItemData as PageItemData;
use InetStudio\GoogleOptimizePackage\Views\DTO\ItemData as ViewItemData;
use InetStudio\GoogleOptimizePackage\Variations\DTO\ItemData as VariationItemData;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Requests\Back\Resource\StoreRequestContract;

class StoreRequest extends FormRequest implements StoreRequestContract
{
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле «Название» обязательно для заполнения',
            'name.max' => 'Поле «Название» не должно превышать 255 символов',
            'event.required' => 'Поле «Событие» обязательно для заполнения',
            'event.max' => 'Поле «Событие» не должно превышать 255 символов',
            'experiment_id.required' => 'Поле «ID» обязательно для заполнения',
            'experiment_id.max' => 'Поле «ID» не должно превышать 255 символов',
            'experiment_id.unique' => 'Такое значение поля «ID» уже существует',
        ];
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'event' => 'required|max:255',
            'experiment_id' => 'required|max:255|unique:google_optimize_experiments,experiment_id,'.$this->get('experiment_id'),
        ];
    }

    protected function passedValidation()
    {
        $variations = [];
        $pages = [];

        foreach (json_decode($this->get('variations'), true) as $variation) {
            $views = [];
            foreach ($variation['views'] ?? [] as $view) {
                $views[] = new ViewItemData($view);
            }
            $variation['views'] = $views;

            $variations[] = new VariationItemData($variation);
        }

        foreach (json_decode($this->get('pages'), true) as $page) {
            $pages[] = new PageItemData($page);
        }

        $itemData = resolve(
            'InetStudio\GoogleOptimizePackage\Experiments\Contracts\DTO\ItemDataContract',
            [
                'args' => [
                    'id' => (int) $this->get('id'),
                    'name' => trim(strip_tags($this->get('name'))),
                    'event' => trim(strip_tags($this->get('event'))),
                    'experiment_id' => trim(strip_tags($this->get('experiment_id'))),
                    'is_active' => (int) trim(strip_tags($this->get('is_active'))),
                    'variations' => $variations,
                    'pages' => $pages,
                ],
            ]
        );

        $data = compact('itemData');

        request()->merge($data);
    }
}
