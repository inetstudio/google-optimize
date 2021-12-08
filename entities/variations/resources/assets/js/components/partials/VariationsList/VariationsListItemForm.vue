<template>
    <div class="modal inmodal fade" id="variations_list_item_form_modal" tabindex="-1" role="dialog" aria-hidden="true" ref="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                    <h1 class="modal-title">Вариант</h1>
                </div>

                <div class="modal-body">
                    <div class="ibox-content" v-bind:class="{ 'sk-loading': options.loading }">
                        <div class="sk-spinner sk-spinner-double-bounce">
                            <div class="sk-double-bounce1"></div>
                            <div class="sk-double-bounce2"></div>
                        </div>

                        <base-input-text
                            label = "Значение"
                            name = "value"
                            v-bind:value.sync = "variation.model.value"
                        />

                        <div class="form-group row ">
                            <label class="col-sm-2 col-form-label font-bold">Представления</label>
                            <div class="col-sm-10">
                                <views-list
                                    v-bind:views-prop="variation.model.views"
                                    v-bind:variation-id-prop="variation.model.id"
                                    v-on:update:views="updateViews"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <a href="#" class="btn btn-primary" v-on:click.prevent="saveVariation">Сохранить</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import hash from 'object-hash';

  export default {
    name: 'VariationsListItemForm',
    data() {
      return {
        options: {
          loading: true
        },
        variation: {}
      };
    },
    computed: {
      mode() {
        return window.Admin.vue.stores['google_optimize_variations'].state.mode;
      },
    },
    watch: {
      'variation.model': {
        handler: function(newValue, oldValue) {
          this.variation.isModified = !(!newValue
              || typeof newValue.id === 'undefined'
              || typeof oldValue.id === 'undefined'
              || this.variation.hash === hash(newValue));
        },
        deep: true,
      },
    },
    methods: {
      initComponent: function() {
        let component = this;

        component.variation = JSON.parse(JSON.stringify(window.Admin.vue.stores['google_optimize_variations'].state.emptyVariation));

        component.options.loading = false;
      },
      loadVariation() {
        let component = this;

        component.variation = JSON.parse(JSON.stringify(window.Admin.vue.stores['google_optimize_variations'].state.variation));
      },
      saveVariation() {
        let component = this;

        let existsIndex = _.findIndex(window.Admin.vue.stores['google_optimize_variations'].state.variations, function(variation) {
          return variation.model.id !== component.variation.model.id && variation.model.value === component.variation.model.value;
        });

        if (existsIndex > -1) {

          $(component.$refs.modal).modal('hide');

          return;
        } else if (component.variation.isModified && component.variation.model.value !== '') {
          window.Admin.vue.stores['google_optimize_variations'].commit('setVariation', JSON.parse(JSON.stringify(component.variation)));
          window.Admin.vue.stores['google_optimize_variations'].commit('setMode', 'save_list_item');
        }

        $(component.$refs.modal).modal('hide');
      },
      updateViews(payload) {
        this.variation.model.views = payload.views;
      }
    },
    created: function() {
      this.initComponent();
    },
    mounted() {
      let component = this;

      this.$nextTick(function() {
        $(component.$refs.modal).on('show.bs.modal', function() {
          component.loadVariation();
        });

        $(component.$refs.modal).on('hide.bs.modal', function() {
          component.variation = JSON.parse(JSON.stringify(window.Admin.vue.stores['google_optimize_variations'].state.emptyVariation));
        });
      });
    }
  };
</script>

<style scoped>
</style>
