export let experiments = {
  init: function () {
    $(document).ready(function () {
      if ($('#googleOptimizeExperimentForm').length > 0) {
        new window.Vue({
          el: '#googleOptimizeExperimentForm',
        });
      }
    });
  }
};
