let variations = {};

variations.init = function() {
  if (!window.Admin.vue.modulesComponents.modules.hasOwnProperty('google_optimize_variations')) {
    window.Admin.vue.modulesComponents.modules = Object.assign(
        {}, window.Admin.vue.modulesComponents.modules, {
          google_optimize_variations: {
            components: [],
          },
        });
  }
};

module.exports = variations;
