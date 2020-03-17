require('./stores/variations');

Vue.component(
    'VariationsList',
    require('./components/partials/VariationsList/VariationsList.vue').default,
);
Vue.component(
    'VariationsListItem',
    require('./components/partials/VariationsList/VariationsListItem.vue').default,
);
Vue.component(
    'VariationsListItemForm',
    require('./components/partials/VariationsList/VariationsListItemForm.vue').default,
);

let variations = require('./package/variations');
variations.init();
