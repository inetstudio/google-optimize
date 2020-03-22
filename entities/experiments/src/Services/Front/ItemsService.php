<?php

namespace InetStudio\GoogleOptimizePackage\Experiments\Services\Front;

use Illuminate\Http\Request;
use InvalidArgumentException;
use Illuminate\View\ViewName;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use InetStudio\GoogleOptimizePackage\Variations\Contracts\Models\VariationModelContract;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Models\ExperimentModelContract;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Services\Front\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService implements ItemsServiceContract
{
    /**
     * @var ExperimentModelContract
     */
    protected $model;

    /**
     * ItemsService constructor.
     *
     * @param  ExperimentModelContract  $model
     */
    public function __construct(ExperimentModelContract $model)
    {
        $this->model = $model;
    }

    /**
     * Инициализируем A/B эксперименты.
     *
     * @param  Request  $request
     */
    public function initialize(Request $request): void
    {
        $items = $this->model->all();

        $data = [
            'views' => [],
            'experiments' => [],
        ];

        foreach ($items as $item) {
            if (! $this->requestIsMatch($item, $request)) {
                continue;
            }

            $variation = $this->setCookie($item);

            $views = $this->getViewsContent($variation);
            $experimentData = $this->getExperimentData($variation);

            if (! empty($views)) {
                $data['views'][] = $views;
            }

            if (! empty($experimentData)) {
                $data['experiments'][] = $experimentData;
            }
        }

        $data['views'] = collect($data['views'])->collapse()->toArray();

        $this->setSession($data);
    }

    /**
     * Устанавливаем куки экспериментов.
     *
     * @param  ExperimentModelContract  $item
     *
     * @return VariationModelContract|null
     */
    protected function setCookie(ExperimentModelContract $item): ?VariationModelContract
    {
        $cookieName = 'google_optimize_experiment_'.$item->experiment_id;

        $variation = (Cookie::has($cookieName))
            ? $item->variations->where('id', Cookie::get($cookieName))->first()
            : (($item->variations->count() > 0) ? $item->variations->random(1)->first() : null);

        $cookieValue = $variation->id ?? 0;

        if (! $item->is_active || ! $variation) {
            Cookie::queue(Cookie::forget($cookieName));

            return null;
        }

        if ($item->is_active && $variation) {
            if (! Cookie::has($cookieName)) {
                Cookie::queue($cookieName, $cookieValue, 144000);
            }

            return $variation;
        }

        Cookie::queue(Cookie::forget($cookieName));

        return null;
    }

    /**
     * Сохраняем настройки экспериментов в сессию.
     *
     * @param  array  $data
     */
    protected function setSession(array $data)
    {
        Session::put('google_optimize_experiments', $data);
    }

    /**
     * Проверяем, что эксперимент доступен для запроса.
     *
     * @param  ExperimentModelContract  $experiment
     * @param  Request  $request
     *
     * @return bool
     */
    protected function requestIsMatch(ExperimentModelContract $experiment, Request $request): bool
    {
        $isMatch = $experiment->pages->count() == 0;

        foreach ($experiment->pages as $page) {
            if ($request->is(trim($page->additional_info['path'], '/'))) {
                $isMatch = true;
            }
        }

        return $isMatch;
    }

    /**
     * Получаем содержимое представлений.
     *
     * @param  $variation
     *
     * @return array
     */
    protected function getViewsContent($variation): array
    {
        $data = [];

        foreach ($variation->views ?? [] as $view) {
            try {
                $viewPath = view()->getFinder()->find(ViewName::normalize($view->name));

                if ($view->content != '') {
                    $data[$viewPath] = $view->content;
                }
            } catch (InvalidArgumentException $error) {}
        }

        return $data;
    }

    /**
     * @param $variation
     *
     * @return array
     */
    protected function getExperimentData($variation): array
    {
        $data = [];

        if ($variation) {
            $data['event'] = $variation->experiment->event;
            $data['experimentId'] = $variation->experiment->experiment_id;
            $data['variationId'] = $variation->value;
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getUserExperiments(): array
    {
        $data = Session::get('google_optimize_experiments', []);

        return $data['experiments'] ?? [];
    }
}
