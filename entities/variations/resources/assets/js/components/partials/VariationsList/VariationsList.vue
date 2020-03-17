<template>
    <div class="google_optimize_variations-package">
        <a href="#" class="btn btn-xs btn-primary btn-xs" v-on:click.prevent="addVariation">Добавить</a>
        <ul class="variations-list m-t small-list">
            <variations-list-item
                v-for="variation in variations"
                :key="variation.model.id"
                v-bind:variation="variation"
                v-on:remove="removeVariation"
            />
        </ul>
        <input :name="'variations'" type="hidden" :value="JSON.stringify(preparedVariations)">
    </div>
</template>

<script>
  export default {
    name: 'VariationsList',
    props: {
      variationsProp: {
        type: Array,
        default: function() {
          return [];
        }
      },
      experimentIdProp: {
        type: Number,
        default: 0
      }
    },
    data() {
      return {
        variations: this.prepareVariations()
      };
    },
    computed: {
      mode() {
        return window.Admin.vue.stores['google_optimize_variations'].state.mode;
      },
      preparedVariations() {
        return JSON.parse(JSON.stringify(_.map(this.variations, 'model')));
      }
    },
    watch: {
      mode: function(newValue, oldValue) {
        if (newValue === 'save_list_item' && (oldValue === 'add_list_item' || oldValue === 'edit_list_item')) {
          this.saveVariation();
        }
      },
      variationsProp: function() {
        this.variations = this.prepareVariations();
      }
    },
    methods: {
      prepareVariations() {
        let component = this;
        let variations = [];

        component.variationsProp.forEach(function(element) {
          let data = {
            isModified: false,
            model: {
              id: element.id,
              value: element.value,
              experiment_id: component.experimentIdProp,
              views: element.views ?? []
            }
          };

          data.hash = window.hash(data.model);

          variations.push(data);
        });

        window.Admin.vue.stores['google_optimize_variations'].commit('setVariations', variations);

        return variations;
      },
      initVariationsComponent() {
        if (typeof window.Admin.vue.modulesComponents.$refs['google_optimize_variations_VariationsListItemForm'] == 'undefined') {
          window.Admin.vue.modulesComponents.modules.google_optimize_variations.components = _.union(
              window.Admin.vue.modulesComponents.modules.google_optimize_variations.components,
              [
                {
                  name: 'VariationsListItemForm',
                  data: {},
                },
              ]
          );
        }
      },
      addVariation() {
        this.initVariationsComponent();

        window.Admin.vue.stores['google_optimize_variations'].commit('setMode', 'add_list_item');
        window.Admin.vue.stores['google_optimize_variations'].commit('setVariation', {});

        window.waitForElement('#variations_list_item_form_modal', function() {
          $('#variations_list_item_form_modal').modal();
        });
      },
      removeVariation(payload) {
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
            component.variations = _.remove(component.variations, function(variation) {
              return variation.model.id !== payload.model.id;
            });

            window.Admin.vue.stores['google_optimize_variations'].commit('setVariations', component.variations);

            component.$emit('update:variations', {
              variations: _.map(component.variations, 'model'),
            });
          }
        });
      },
      saveVariation() {
        let component = this;

        let storeVariation = JSON.parse(JSON.stringify(window.Admin.vue.stores['google_optimize_variations'].state.variation));
        storeVariation.model.experiment_id = component.experimentIdProp;
        storeVariation.hash = window.hash(storeVariation.model);

        let index = component.getVariationIndex(storeVariation.model.id);

        if (index > -1) {
          component.$set(component.variations, index, storeVariation);
        } else {
          component.variations.push(storeVariation);
        }

        window.Admin.vue.stores['google_optimize_variations'].commit('setVariations', component.variations);

        component.$emit('update:variations', {
          variations: _.map(component.variations, 'model'),
        });
      },
      getVariationIndex(id) {
        let component = this;

        return _.findIndex(component.variations, function(variation) {
          return variation.model.id === id;
        });
      }
    }
  };
</script>

<style scoped>
</style>
