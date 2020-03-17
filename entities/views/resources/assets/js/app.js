require('./stores/views');

Vue.component(
    'ViewsList',
    require('./components/partials/ViewsList/ViewsList.vue').default,
);
Vue.component(
    'ViewsListItem',
    require('./components/partials/ViewsList/ViewsListItem.vue').default,
);
Vue.component(
    'ViewsListItemForm',
    require('./components/partials/ViewsList/ViewsListItemForm.vue').default,
);

let views = require('./package/views');
views.init();
