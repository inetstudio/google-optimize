<?php

namespace InetStudio\GoogleOptimizePackage\Experiments\Http\Requests\Back\Resource;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Requests\Back\Resource\StoreRequestContract;

/**
 * Class StoreRequest.
 */
class StoreRequest extends FormRequest implements StoreRequestContract
{
    /**
     * Определить, авторизован ли пользователь для этого запроса.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Сообщения об ошибках.
     *
     * @return array
     */
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

    /**
     * Правила проверки запроса.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'event' => 'required|max:255',
            'experiment_id' => 'required|max:255|unique:google_optimize_experiments,experiment_id,'.$this->get('experiment_id'),
        ];
    }

    /**
     * Handle a passed validation attempt.
     *
     * @throws BindingResolutionException
     */
    protected function passedValidation()
    {
        $itemData = app()->make(
            'InetStudio\GoogleOptimizePackage\Experiments\Contracts\DTO\ItemDataContract',
            [
                'parameters' => [
                    'id' => (int) $this->get('id'),
                    'name' => trim(strip_tags($this->get('name'))),
                    'event' => trim(strip_tags($this->get('event'))),
                    'experiment_id' => trim(strip_tags($this->get('experiment_id'))),
                    'is_active' => (int) trim(strip_tags($this->get('is_active'))),
                    'variations' => json_decode($this->get('variations'), true),
                ],
            ]
        );

        $data = compact('itemData');

        request()->merge($data);
    }
}
