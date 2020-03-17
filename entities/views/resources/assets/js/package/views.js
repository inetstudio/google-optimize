let views = {};

views.init = function() {
  if (!window.Admin.vue.modulesComponents.modules.hasOwnProperty('google_optimize_views')) {
    window.Admin.vue.modulesComponents.modules = Object.assign(
        {}, window.Admin.vue.modulesComponents.modules, {
          google_optimize_views: {
            components: [],
          },
        });
  }
};

module.exports = views;
