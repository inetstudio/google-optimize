import hash from 'object-hash';
import { v4 as uuidv4 } from 'uuid';

window.Admin.vue.stores['google_optimize_pages'] = new window.Vuex.Store({
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
      emptyPage.model.id = uuidv4();

      let resultPage = _.merge(emptyPage, page);
      resultPage.hash = hash(resultPage.model);

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
