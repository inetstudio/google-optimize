<template>
    <div class="modal inmodal fade" id="views_list_item_form_modal" tabindex="-1" role="dialog" aria-hidden="true" ref="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                    <h1 class="modal-title">Представление</h1>
                </div>

                <div class="modal-body">
                    <div class="ibox-content" v-bind:class="{ 'sk-loading': options.loading }">
                        <div class="sk-spinner sk-spinner-double-bounce">
                            <div class="sk-double-bounce1"></div>
                            <div class="sk-double-bounce2"></div>
                        </div>

                        <base-input-text
                            label = "Имя"
                            name = "name"
                            v-bind:value.sync = "view.model.name"
                        />

                        <base-code
                            label = "Содержимое"
                            name = "view_content"
                            v-bind:value.sync="view.model.content"
                            v-bind:attributes = "{
                                'id': 'view_content'
                            }"
                        />
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <a href="#" class="btn btn-primary" v-on:click.prevent="saveView">Сохранить</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'ViewsListItemForm',
    data() {
      return {
        options: {
          loading: true
        },
        view: {}
      };
    },
    computed: {
      mode() {
        return window.Admin.vue.stores['google_optimize_views'].state.mode;
      },
    },
    watch: {
      'view.model': {
        handler: function(newValue, oldValue) {
          this.view.isModified = !(!newValue
              || typeof newValue.id === 'undefined'
              || typeof oldValue.id === 'undefined'
              || this.view.hash === window.hash(newValue));
        },
        deep: true,
      },
    },
    methods: {
      initComponent: function() {
        let component = this;

        component.view = JSON.parse(JSON.stringify(window.Admin.vue.stores['google_optimize_views'].state.emptyView));

        component.options.loading = false;
      },
      loadView() {
        let component = this;

        component.view = JSON.parse(JSON.stringify(window.Admin.vue.stores['google_optimize_views'].state.view));

        $('#view_content').next()[0].CodeMirror.setValue(component.view.model.content);
      },
      saveView() {
        let component = this;

        let existsIndex = _.findIndex(window.Admin.vue.stores['google_optimize_views'].state.views, function(variation) {
          return variation.model.id !== component.view.model.id && variation.model.name === component.view.model.name;
        });

        if (existsIndex > -1) {

          $(this.$refs.modal).modal('hide');

          return;
        } else if (component.view.isModified && component.view.model.name !== '') {
          window.Admin.vue.stores['google_optimize_views'].commit('setView', JSON.parse(JSON.stringify(component.view)));
          window.Admin.vue.stores['google_optimize_views'].commit('setMode', 'save_list_item');
        }

        $(this.$refs.modal).modal('hide');
      }
    },
    created: function() {
      this.initComponent();
    },
    mounted() {
      let component = this;

      this.$nextTick(function() {
        $(component.$refs.modal).on('show.bs.modal', function() {
          component.loadView();
        });

        $(component.$refs.modal).on('shown.bs.modal', function() {
          $('#view_content').next()[0].CodeMirror.refresh();
        });

        $(component.$refs.modal).on('hide.bs.modal', function() {
          component.view = JSON.parse(JSON.stringify(window.Admin.vue.stores['google_optimize_views'].state.emptyView));
          $('#view_content').next()[0].CodeMirror.setValue('');
        });
      });
    }
  };
</script>

<style scoped>
</style>
