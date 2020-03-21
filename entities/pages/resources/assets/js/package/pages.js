let pages = {};

pages.init = function() {
  if (!window.Admin.vue.modulesComponents.modules.hasOwnProperty('google_optimize_pages')) {
    window.Admin.vue.modulesComponents.modules = Object.assign(
        {}, window.Admin.vue.modulesComponents.modules, {
          google_optimize_pages: {
            components: [],
          },
        });
  }
};

module.exports = pages;
