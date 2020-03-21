window.Admin.vue.stores['google_optimize_pages'] = new Vuex.Store({
  state: {
    emptyPage: {
      model: {
        experiment_id: 0,
        pageable_type: '',
        pageable_id: 0,
        additional_info: {
          suggestion: '',
          path: ''
        }
      },
      errors: {},
      isModified: false,
      hash: ''
    },
    page: {},
    pages: [],
    mode: '',
  },
  mutations: {
    setPage(state, page) {
      let emptyPage = JSON.parse(JSON.stringify(state.emptyPage));
      emptyPage.model.id = UUID.generate();

      let resultPage = _.merge(emptyPage, page);
      resultPage.hash = window.hash(resultPage.model);

      state.page = resultPage;
    },
    setPages(state, pages) {
      state.pages = pages;
    },
    setMode(state, mode) {
      state.mode = mode;
    },
    reset(state) {
      state.mode = '';
      state.page = {};
      state.pages = [];
    }
  },
});
