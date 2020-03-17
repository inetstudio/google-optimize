@extends('admin::back.layouts.app')

@php
    $title = 'Эксперименты';
@endphp

@section('title', $title)

@section('content')

    @push('breadcrumbs')
        @include('admin.module.google-optimize-package.experiments::back.partials.breadcrumbs.index')
    @endpush

    <div class="wrapper wrapper-content google-optimize-package">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <a href="{{ route('back.google-optimize-package.experiments.create') }}"
                           class="btn btn-sm btn-primary btn-lg">Добавить</a>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            {{ $table->table(['class' => 'table table-striped table-bordered table-hover dataTable']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@pushonce('scripts:datatables_google_optimize_package_experiments_index')
    {!! $table->scripts() !!}
@endpushonce
