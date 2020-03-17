<template>
    <li>
        <div class="row">
            <div class="col-10">
                <span class="m-l-xs">{{ view.model.name }}</span>
            </div>
            <div class="col-2">
                <div class="btn-group float-right">
                    <a href="#" class="btn btn-xs btn-default edit-view m-r" v-on:click.prevent.stop="editView"><i class="fa fa-pencil-alt"></i></a>
                    <a href="#" class="btn btn-xs btn-danger delete-view" v-on:click.prevent.stop="removeView"><i class="fa fa-times"></i></a>
                </div>
            </div>
        </div>
    </li>
</template>

<script>
  export default {
    name: 'ViewsListItem',
    props: {
      view: {
        type: Object,
        required: true,
      },
    },
    methods: {
      initViewsComponent() {
        if (typeof window.Admin.vue.modulesComponents.$refs['google_optimize_views_ViewsListItemForm'] == 'undefined') {
          window.Admin.vue.modulesComponents.modules.google_optimize_views.components = _.union(
              window.Admin.vue.modulesComponents.modules.google_optimize_views.components,
              [
                {
                  name: 'ViewsListItemForm',
                  data: {},
                },
              ]);
        }
      },
      editView() {
        this.initViewsComponent();

        window.Admin.vue.stores['google_optimize_views'].commit('setMode', 'edit_list_item');

        let view = JSON.parse(JSON.stringify(this.view));
        view.isModified = false;

        window.Admin.vue.stores['google_optimize_views'].commit('setView', view);

        window.waitForElement('#views_list_item_form_modal', function() {
          $('#views_list_item_form_modal').modal();
        });
      },
      removeView() {
        this.$emit('remove', {
          model: this.view.model
        });
      },
    },
  };
</script>

<style scoped>
</style>
