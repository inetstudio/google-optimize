import {pages} from './package/pages';

require('./stores/pages');

window.Vue.component(
    'PagesList',
    () => import('./components/partials/PagesList/PagesList.vue'),
);
window.Vue.component(
    'PagesListItem',
    () => import('./components/partials/PagesList/PagesListItem.vue'),
);
window.Vue.component(
    'PagesListItemForm',
    () => import('./components/partials/PagesList/PagesListItemForm.vue'),
);

pages.init();
