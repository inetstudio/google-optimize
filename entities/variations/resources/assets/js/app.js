import {variations} from './package/variations';

require('./stores/variations');

window.Vue.component(
    'VariationsList',
    () => import('./components/partials/VariationsList/VariationsList.vue'),
);
window.Vue.component(
    'VariationsListItem',
    () => import('./components/partials/VariationsList/VariationsListItem.vue'),
);
window.Vue.component(
    'VariationsListItemForm',
    () => import('./components/partials/VariationsList/VariationsListItemForm.vue'),
);

variations.init();
