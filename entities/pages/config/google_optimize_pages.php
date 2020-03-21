<?php

return [

    'pages_types' => [
        [
            'text' => 'Категория',
            'value' => 'categories',
            'attributes' => [
                'data-suggestions' => 'back.categories.getSuggestions',
            ],
        ],
        [
            'text' => 'Тег',
            'value' => 'tags',
            'attributes' => [
                'data-suggestions' => 'back.tags.getSuggestions',
            ],
        ],
        [
            'text' => 'Статья',
            'value' => 'articles',
            'attributes' => [
                'data-suggestions' => 'back.articles.getSuggestions',
            ],
        ],
        [
            'text' => 'Страница',
            'value' => 'pages',
            'attributes' => [
                'data-suggestions' => 'back.pages.getSuggestions',
            ],
        ],
        [
            'text' => 'Паттерн',
            'value' => 'pattern',
            'attributes' => [],
        ],
    ],

];
