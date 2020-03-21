require('./stores/pages');

Vue.component(
    'PagesList',
    require('./components/partials/PagesList/PagesList.vue').default,
);
Vue.component(
    'PagesListItem',
    require('./components/partials/PagesList/PagesListItem.vue').default,
);
Vue.component(
    'PagesListItemForm',
    require('./components/partials/PagesList/PagesListItemForm.vue').default,
);

let pages = require('./package/pages');
pages.init();
