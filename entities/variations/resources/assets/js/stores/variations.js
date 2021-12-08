import hash from 'object-hash';
import { v4 as uuidv4 } from 'uuid';

window.Admin.vue.stores['google_optimize_variations'] = new window.Vuex.Store({
  state: {
    emptyVariation: {
      model: {
        value: '',
        experiment_id: 0,
        views: []
      },
      errors: {},
      isModified: false,
      hash: '',
    },
    variation: {},
    variations: [],
    mode: '',
  },
  mutations: {
    setVariation(state, variation) {
      let emptyVariation = JSON.parse(JSON.stringify(state.emptyVariation));
      emptyVariation.model.id = uuidv4();

      let resultVariation = _.merge(emptyVariation, variation);
      resultVariation.hash = hash(resultVariation.model);

      state.variation = resultVariation;
    },
    setVariations(state, variations) {
      state.variations = variations;
    },
    setMode(state, mode) {
      state.mode = mode;
    },
    reset(state) {
      state.mode = '';
      state.variation = {};
      state.variations = [];
    }
  },
});
