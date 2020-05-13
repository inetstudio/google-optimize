<template>
    <div class="google_optimize_views-package">
        <a href="#" class="btn btn-xs btn-primary btn-xs" v-on:click.prevent="addView">Добавить</a>
        <ul class="views-list m-t small-list">
            <views-list-item
                v-for="view in views"
                :key="view.model.id"
                v-bind:view="view"
                v-on:remove="removeView"
            />
        </ul>
        <input :name="'views'" type="hidden" :value="JSON.stringify(preparedViews)">
    </div>
</template>

<script>
  export default {
    name: 'ViewsList',
    props: {
      viewsProp: {
        type: Array,
        default: function() {
          return [];
        }
      },
      variationIdProp: {
        type: [String, Number]
      }
    },
    data() {
      return {
        views: this.prepareViews(),
      };
    },
    computed: {
      mode() {
        return window.Admin.vue.stores['google_optimize_views'].state.mode;
      },
      preparedViews() {
        return JSON.parse(JSON.stringify(this.views));
      }
    },
    watch: {
      mode: function(newMode, oldMode) {
        if (newMode === 'save_list_item' && (oldMode === 'add_list_item' || oldMode === 'edit_list_item')) {
          this.saveView();
        }
      },
      viewsProp: function() {
        this.views = this.prepareViews();
      },
    },
    methods: {
      prepareViews() {
        let component = this;
        let views = [];

        component.viewsProp.forEach(function(element) {
          let data = {
            isModified: false,
            model: {
              id: element.id,
              name: element.name,
              content: element.content,
              variation_id: component.variationIdProp
            }
          };

          data.hash = window.hash(data.model);

          views.push(data);
        });

        window.Admin.vue.stores['google_optimize_views'].commit('setViews', views);

        return views;
      },
      addView() {
        window.Admin.vue.helpers.initComponent('google_optimize_views', 'ViewsListItemForm', {});

        window.Admin.vue.stores['google_optimize_views'].commit('setMode', 'add_list_item');
        window.Admin.vue.stores['google_optimize_views'].commit('setView', {});

        window.waitForElement('#views_list_item_form_modal', function() {
          $('#views_list_item_form_modal').modal();
        });
      },
      removeView(payload) {
        let component = this;

        swal({
          title: 'Вы уверены?',
          type: 'warning',
          showCancelButton: true,
          cancelButtonText: 'Отмена',
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Да, удалить',
        }).then((result) => {
          if (result.value) {
            this.views = _.remove(component.views, function(view) {
              return view.model.id !== payload.model.id;
            });

            window.Admin.vue.stores['google_optimize_views'].commit('setViews', component.views);

            component.$emit('update:views', {
              views: _.map(component.views, 'model'),
            });
          }
        });
      },
      saveView() {
        let component = this;

        let storeView = JSON.parse(JSON.stringify(window.Admin.vue.stores['google_optimize_views'].state.view));
        storeView.model.variation_id = component.variationIdProp;
        storeView.hash = window.hash(storeView.model);

        let index = component.getViewIndex(storeView.model.id);

        if (index > -1) {
          component.$set(component.views, index, storeView);
        } else {
          component.views.push(storeView);
        }

        window.Admin.vue.stores['google_optimize_views'].commit('setViews', component.views);

        component.$emit('update:views', {
          views: _.map(component.views, 'model'),
        });
      },
      getViewIndex(id) {
        return _.findIndex(this.views, function(view) {
          return view.model.id === id;
        });
      }
    }
  };
</script>

<style scoped>
</style>
