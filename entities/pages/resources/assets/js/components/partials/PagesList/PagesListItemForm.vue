<template>
    <div class="modal inmodal fade" id="pages_list_item_form_modal" tabindex="-1" role="dialog" aria-hidden="true" ref="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                    <h1 class="modal-title">Страница</h1>
                </div>

                <div class="modal-body">
                    <div class="ibox-content" v-bind:class="{ 'sk-loading': loading }">
                        <div class="sk-spinner sk-spinner-double-bounce">
                            <div class="sk-double-bounce1"></div>
                            <div class="sk-double-bounce2"></div>
                        </div>

                        <template v-if="options.ready">
                            <base-dropdown
                                label = "Тип страницы"
                                v-bind:attributes="{
                                    label: 'text',
                                    placeholder: 'Выберите тип страницы',
                                    clearable: false,
                                    reduce: option => option.value
                                }"
                                v-bind:options = "options.pagesTypes"
                                v-bind:selected.sync="page.model.pageable_type"
                            />

                            <div class="has-warning" v-show="showSuggestions">
                                <base-autocomplete
                                    name = "page_suggestion"
                                    v-bind:attributes = "{
                                        'data-search': '',
                                        'placeholder': 'Введите название страницы',
                                        'autocomplete': 'off'
                                    }"
                                    v-on:select="suggestionSelect"
                                    v-bind:value.sync = "page.model.additional_info.suggestion"
                                />
                            </div>

                            <div v-show="showPath">
                                <base-input-text
                                    label = "Паттерн"
                                    name = "page_path"
                                    v-bind:attributes = "{
                                        'disabled': (page.model.pageable_type !== 'pattern'),
                                    }"
                                    v-bind:value.sync = "page.model.additional_info.path"
                                />
                            </div>
                        </template>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <a href="#" class="btn btn-primary" v-on:click.prevent="savePage">Сохранить</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import hash from 'object-hash';

    export default {
        name: 'PagesListItemForm',
        data() {
            return {
                loading: true,
                options: {
                    ready: false,
                    pagesTypes: []
                },
                page: {}
            }
        },
        computed: {
            showSuggestions() {
                return (this.page.model.pageable_type !== 'pattern' && this.page.model.pageable_type !== '');
            },
            showPath() {
                return this.page.model.pageable_type !== '';
            }
        },
        watch: {
            'page.model': {
                handler: function (newValue, oldValue) {
                    this.page.isModified = ! (! newValue
                        || typeof newValue.id === 'undefined'
                        || typeof oldValue.id === 'undefined'
                        || this.page.hash === hash(newValue));
                },
                deep: true
            },
            'page.model.pageable_type': function (newValue, oldValue) {
                let component = this;

                if (! newValue || (newValue === oldValue)) {
                    return;
                }

                if (!! oldValue) {
                    let currentData = {
                        model: {
                            id: component.page.model.id,
                            pageable_type: newValue
                        }
                    };

                    component.page = _.merge(JSON.parse(JSON.stringify(window.Admin.vue.stores['google_optimize_pages'].state.emptyPage)), currentData);
                }

              let typeIndex = _.findIndex(component.options.pagesTypes, function (type) {
                return type.value === newValue;
              });

                let routeName = (typeIndex > -1) ? component.options.pagesTypes[typeIndex].attributes['data-suggestions'] : undefined;
                let suggestionsURL = (typeof routeName !== 'undefined') ? String(route(routeName)) : '';

                if (suggestionsURL) {
                    $('#page_suggestion').autocomplete().setOptions({
                        serviceUrl: suggestionsURL
                    });
                }
            }
        },
        methods: {
            initComponent: function() {
                let component = this;

                component.page = JSON.parse(JSON.stringify(window.Admin.vue.stores['google_optimize_pages'].state.emptyPage));

                let url = route('back.admin-panel.config.get', 'google_optimize_pages.pages_types');

                component.loading = true;

                axios.post(url).then(response => {
                    component.options.pagesTypes = response.data;
                    component.loading = false;
                    component.options.ready = true;
                });
            },
            loadPage() {
                let component = this;

                component.loading = true;
                component.page = JSON.parse(JSON.stringify(window.Admin.vue.stores['google_optimize_pages'].state.page));

                $('#page_type').val(component.page.model.pageable_type).trigger('change');

                component.loading = (! component.options.ready);
            },
            savePage() {
                let component = this;

                let existsIndex = _.findIndex(window.Admin.vue.stores['google_optimize_pages'].state.pages, function(page) {
                    return page.model.id !== component.page.model.id
                        && page.model.pageable_id === component.page.model.pageable_id
                        && page.model.pageable_type === component.page.model.pageable_type;
                });

                if (existsIndex > -1) {

                    $(component.$refs.modal).modal('hide');

                    return;
                } else if (component.page.isModified && component.page.model.value !== '') {
                    window.Admin.vue.stores['google_optimize_pages'].commit('setPage', JSON.parse(JSON.stringify(component.page)));
                    window.Admin.vue.stores['google_optimize_pages'].commit('setMode', 'save_list_item');
                }

                $(component.$refs.modal).modal('hide');
            },
            suggestionSelect(payload) {
                let component = this;

                let data = payload.data;

                component.page.model.additional_info.suggestion = data.title || '';
                component.page.model.additional_info.path = data.path || '';
                component.page.model.pageable_id = data.id || 0;
            }
        },
        created: function() {
            this.initComponent();
        },
        mounted() {
            let component = this;

            component.$nextTick(function() {
                $(component.$refs.modal).on('show.bs.modal', function() {
                    component.loadPage();
                });

                $(component.$refs.modal).on('hide.bs.modal', function() {
                    component.page = JSON.parse(JSON.stringify(window.Admin.vue.stores['google_optimize_pages'].state.emptyPage));

                    $('#page_type').val(null).trigger('change');
                });
            });
        }
    }
</script>

<style scoped>
</style>
