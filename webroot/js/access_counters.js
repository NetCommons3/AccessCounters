/**
 * @fileoverview AccessCounters Javascript
 * @author ozawa.ryo@withone.co.jp (Ryo Ozawa)
 */


/**
 * AccessCounters Javascript
 *
 * @param {string} Controller name
 * @param {function(scope)} Controller
 */
NetCommonsApp.controller('AccessCounters',
    function($scope) {

      $scope.counter = {};

      $scope.init = function(frameId, counter) {
        $scope.frameId = frameId;
        $scope.counter = counter;
      };

      $scope.selectLabel = function(index, label) {
        $scope.counter.accessCounterFrameSetting.displayType = index;
        $scope.counter.accessCounterFrameSetting.displayTypeLabel = label;
      };
    });
