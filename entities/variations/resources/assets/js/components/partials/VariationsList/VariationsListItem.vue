<template>
    <li>
        <div class="row">
            <div class="col-10">
                <span class="m-l-xs">{{ variation.model.value }}</span>
            </div>
            <div class="col-2">
                <div class="btn-group float-right">
                    <a href="#" class="btn btn-xs btn-default edit-variation m-r" v-on:click.prevent.stop="editVariation"><i class="fa fa-pencil-alt"></i></a>
                    <a href="#" class="btn btn-xs btn-danger delete-variation" v-on:click.prevent.stop="removeVariation"><i class="fa fa-times"></i></a>
                </div>
            </div>
        </div>
    </li>
</template>

<script>
  export default {
    name: 'VariationsListItem',
    props: {
      variation: {
        type: Object,
        required: true,
      },
    },
    methods: {
      initVariationsComponent() {
        if (typeof window.Admin.vue.modulesComponents.$refs['google_optimize_variations_VariationsListItemForm'] == 'undefined') {
          window.Admin.vue.modulesComponents.modules.google_optimize_variations.components = _.union(
              window.Admin.vue.modulesComponents.modules.google_optimize_variations.components,
              [
                {
                  name: 'VariationsListItemForm',
                  data: {},
                },
              ]);
        }
      },
      editVariation() {
        this.initVariationsComponent();

        window.Admin.vue.stores['google_optimize_variations'].commit('setMode', 'edit_list_item');

        let variation = JSON.parse(JSON.stringify(this.variation));
        variation.isModified = false;

        window.Admin.vue.stores['google_optimize_variations'].commit('setVariation', variation);

        window.waitForElement('#variations_list_item_form_modal', function() {
          $('#variations_list_item_form_modal').modal();
        });
      },
      removeVariation() {
        this.$emit('remove', {
          model: this.variation.model
        });
      },
    },
  };
</script>

<style scoped>
</style>
