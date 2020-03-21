@extends('admin::back.layouts.app')

@php
    $title = ($item['id']) ? 'Просмотр эксперимента' : 'Создание эксперимента';
@endphp

@section('title', $title)

@section('content')

    @push('breadcrumbs')
        @include('admin.module.google-optimize-package.experiments::back.partials.breadcrumbs.form')
    @endpush

    <div class="wrapper wrapper-content">
        <div class="ibox">
            <div class="ibox-title">
                <a class="btn btn-sm btn-white" href="{{ route('back.google-optimize-package.experiments.index') }}">
                    <i class="fa fa-arrow-left"></i> Вернуться назад
                </a>
            </div>
        </div>

        {!! Form::info() !!}

        {!! Form::open(['url' => (! $item['id']) ? route('back.google-optimize-package.experiments.store') : route('back.google-optimize-package.experiments.update', [$item['id']]), 'id' => 'googleOptimizeExperimentForm', 'enctype' => 'multipart/form-data']) !!}

        @if ($item['id'])
            {{ method_field('PUT') }}
        @endif

        {!! Form::hidden('id', (! $item['id']) ? '' : $item['id'], ['id' => 'object-id']) !!}

        {!! Form::hidden('type', get_class($item), ['id' => 'object-type']) !!}

        <div class="ibox">
            <div class="ibox-title">
                {!! Form::buttons('', '', ['back' => 'back.google-optimize-package.experiments.index']) !!}
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel-group float-e-margins" id="mainAccordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#mainAccordion" href="#collapseMain"
                                           aria-expanded="true">Основная информация</a>
                                    </h5>
                                </div>
                                <div id="collapseMain" class="collapse show" aria-expanded="true">
                                    <div class="panel-body">

                                        {!! Form::string('name', $item['name'], [
                                            'label' => [
                                                'title' => 'Название',
                                            ],
                                        ]) !!}

                                        {!! Form::string('event', $item['event'], [
                                            'label' => [
                                                'title' => 'Событие',
                                            ],
                                        ]) !!}

                                        {!! Form::string('experiment_id', $item['experiment_id'], [
                                            'label' => [
                                                'title' => 'ID',
                                            ],
                                        ]) !!}

                                        <div class="form-group row ">
                                            <label class="col-sm-2 col-form-label font-bold">Варианты</label>
                                            <div class="col-sm-10">
                                                <variations-list
                                                    v-bind:variations-prop="{{ json_encode($item['variations'] ?? []) }}"
                                                    v-bind:experiment-id-prop="{{ $item['id'] ?? 0 }}"
                                                />
                                            </div>
                                        </div>

                                        <div class="form-group row ">
                                            <label class="col-sm-2 col-form-label font-bold">Страницы</label>
                                            <div class="col-sm-10">
                                                <pages-list
                                                    v-bind:pages-prop="{{ json_encode($item['pages'] ?? []) }}"
                                                    v-bind:experiment-id-prop="{{ $item['id'] ?? 0 }}"
                                                />
                                            </div>
                                        </div>

                                        {!! Form::hidden('is_active', 0) !!}
                                        {!! Form::checks('is_active', $item['is_active'], [
                                            'label' => [
                                                'title' => 'Активен',
                                            ],
                                            'checks' => [
                                                [
                                                    'value' => 1,
                                                ],
                                            ],
                                        ]) !!}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ibox-footer">
                {!! Form::buttons('', '', ['back' => 'back.google-optimize-package.experiments.index']) !!}
            </div>
        </div>

        {!! Form::close()!!}
    </div>
@endsection
