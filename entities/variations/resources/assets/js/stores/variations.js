window.Admin.vue.stores['google_optimize_variations'] = new Vuex.Store({
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
      emptyVariation.model.id = UUID.generate();

      let resultVariation = _.merge(emptyVariation, variation);
      resultVariation.hash = window.hash(resultVariation.model);

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
