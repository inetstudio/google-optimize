let experiments = {};

experiments.init = function () {
  $(document).ready(function () {
    if ($('#googleOptimizeExperimentForm').length > 0) {
      new Vue({
        el: '#googleOptimizeExperimentForm',
      });
    }
  });
};

module.exports = experiments;
