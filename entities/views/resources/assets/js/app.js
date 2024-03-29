import {views} from './package/views';

require('./stores/views');

window.Vue.component(
    'ViewsList',
    () => import('./components/partials/ViewsList/ViewsList.vue'),
);
window.Vue.component(
    'ViewsListItem',
    () => import('./components/partials/ViewsList/ViewsListItem.vue'),
);
window.Vue.component(
    'ViewsListItemForm',
    () => import('./components/partials/ViewsList/ViewsListItemForm.vue'),
);

views.init();
