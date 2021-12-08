<template>
    <div class="google_optimize_pages-package">
        <a href="#" class="btn btn-xs btn-primary btn-xs" v-on:click.prevent="addPage">Добавить</a>
        <ul class="pages-list m-t small-list">
            <pages-list-item
                v-for="page in pages"
                :key="page.model.id"
                v-bind:page="page"
                v-on:remove="removePage"
            />
        </ul>
        <input :name="'pages'" type="hidden" :value="JSON.stringify(preparedPages)">
    </div>
</template>

<script>
  import hash from 'object-hash';
  import Swal from 'sweetalert2';

  export default {
    name: 'PagesList',
    props: {
      pagesProp: {
        type: Array,
        default: function() {
          return [];
        }
      },
      experimentIdProp: {
        type: Number
      }
    },
    data() {
      return {
        pages: this.preparePages(),
      };
    },
    computed: {
      mode() {
        return window.Admin.vue.stores['google_optimize_pages'].state.mode;
      },
      preparedPages() {
        return JSON.parse(JSON.stringify(_.map(this.pages, 'model')));
      }
    },
    watch: {
      mode: function(newMode, oldMode) {
        if (newMode === 'save_list_item' && (oldMode === 'add_list_item' || oldMode === 'edit_list_item')) {
          this.savePage();
        }
      },
      pagesProp: function() {
        this.pages = this.preparePages();
      },
    },
    methods: {
      preparePages() {
        let component = this;
        let pages = [];

        component.pagesProp.forEach(function(element) {
          let data = {
            isModified: false,
            model: {
              id: element.id,
              experiment_id: component.experimentIdProp,
              pageable_type: element.pageable_type,
              pageable_id: element.pageable_id,
              additional_info: element.additional_info,
            }
          };

          data.hash = hash(data.model);

          pages.push(data);
        });

        window.Admin.vue.stores['google_optimize_pages'].commit('setPages', pages);

        return pages;
      },
      addPage() {
        window.Admin.vue.helpers.initComponent('google_optimize_pages', 'PagesListItemForm', {});

        window.Admin.vue.stores['google_optimize_pages'].commit('setMode', 'add_list_item');
        window.Admin.vue.stores['google_optimize_pages'].commit('setPage', {});

        window.waitForElement('#pages_list_item_form_modal', function() {
          $('#pages_list_item_form_modal').modal();
        });
      },
      removePage(payload) {
        let component = this;

        Swal.fire({
          title: 'Вы уверены?',
          icon: 'warning',
          showCancelButton: true,
          cancelButtonText: 'Отмена',
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Да, удалить',
        }).then((result) => {
          if (result.value) {
            component.pages = _.remove(component.pages, function(page) {
              return page.model.id !== payload.model.id;
            });

            window.Admin.vue.stores['google_optimize_pages'].commit('setPages', component.pages);

            component.$emit('update:pages', {
              pages: _.map(component.pages, 'model'),
            });
          }
        });
      },
      savePage() {
        let component = this;

        let storePage = JSON.parse(JSON.stringify(window.Admin.vue.stores['google_optimize_pages'].state.page));
        storePage.model.experiment_id = component.experimentIdProp;
        storePage.hash = hash(storePage.model);

        let index = component.getPageIndex(storePage.model.id);

        if (index > -1) {
          component.$set(component.pages, index, storePage);
        } else {
          component.pages.push(storePage);
        }

        window.Admin.vue.stores['google_optimize_pages'].commit('setPages', component.pages);

        component.$emit('update:pages', {
          pages: _.map(component.pages, 'model'),
        });
      },
      getPageIndex(id) {
        let component = this;

        return _.findIndex(component.pages, function(page) {
          return page.model.id === id;
        });
      }
    }
  };
</script>

<style scoped>
</style>
