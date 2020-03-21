<template>
    <li>
        <div class="row">
            <div class="col-10">
                <span class="m-l-xs">{{ page.model.pageable_type }}: {{ page.model.additional_info.suggestion || page.model.additional_info.path }}</span>
            </div>
            <div class="col-2">
                <div class="btn-group float-right">
                    <a href="#" class="btn btn-xs btn-default edit-page m-r" v-on:click.prevent.stop="editPage"><i class="fa fa-pencil-alt"></i></a>
                    <a href="#" class="btn btn-xs btn-danger delete-page" v-on:click.prevent.stop="removePage"><i class="fa fa-times"></i></a>
                </div>
            </div>
        </div>
    </li>
</template>

<script>
  export default {
    name: 'PagesListItem',
    props: {
      page: {
        type: Object,
        required: true,
      },
    },
    methods: {
      initPagesComponent() {
        if (typeof window.Admin.vue.modulesComponents.$refs['google_optimize_pages_PagesListItemForm'] == 'undefined') {
          window.Admin.vue.modulesComponents.modules.google_optimize_pages.components = _.union(
              window.Admin.vue.modulesComponents.modules.google_optimize_pages.components,
              [
                {
                  name: 'PagesListItemForm',
                  data: {},
                },
              ]);
        }
      },
      editPage() {
        let component = this;

        component.initPagesComponent();

        window.Admin.vue.stores['google_optimize_pages'].commit('setMode', 'edit_list_item');

        let page = JSON.parse(JSON.stringify(component.page));
        page.isModified = false;

        window.Admin.vue.stores['google_optimize_pages'].commit('setPage', page);

        window.waitForElement('#pages_list_item_form_modal', function() {
          $('#pages_list_item_form_modal').modal();
        });
      },
      removePage() {
        let component = this;

        component.$emit('remove', {
          model: component.page.model
        });
      },
    },
  };
</script>

<style scoped>
</style>
