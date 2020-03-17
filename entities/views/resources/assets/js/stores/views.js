window.Admin.vue.stores['google_optimize_views'] = new Vuex.Store({
  state: {
    emptyView: {
      model: {
        name: '',
        content: '',
        variation_id: 0
      },
      errors: {},
      isModified: false,
      hash: '',
    },
    view: {},
    views: [],
    mode: '',
  },
  mutations: {
    setView(state, view) {
      let emptyView = JSON.parse(JSON.stringify(state.emptyView));
      emptyView.model.id = UUID.generate();

      let resultView = _.merge(emptyView, view);
      resultView.hash = window.hash(resultView.model);

      state.view = resultView;
    },
    setViews(state, views) {
      state.views = views;
    },
    setMode(state, mode) {
      state.mode = mode;
    },
    reset(state) {
      state.mode = '';
      state.view = {};
      state.viewsNames = [];
    }
  },
});
