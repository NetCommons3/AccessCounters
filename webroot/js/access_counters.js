/**
 * @fileoverview AccessCounters Javascript
 * @author ozawa.ryo@withone.co.jp (Ryo Ozawa)
 */


/**
 * AccessCounterFrameSettings Javascript
 *
 * @param {string} Controller name
 * @param {function($scope)} Controller
 */
NetCommonsApp.controller('AccessCounterFrameSettings', function($scope) {

  /**
   * initialize
   *
   * @return {void}
   */
  $scope.initialize = function(data) {
    $scope.counterFrameSetting = data.counterFrameSetting;
    $scope.frameId = data.frameId;
    $scope.currentDisplayTypeName = data.currentDisplayTypeName;
  };

  /**
   * Select display type
   *
   * @return {void}
   */
  $scope.selectDisplayType = function(displayType, typeName) {
    $scope.counterFrameSetting.displayType = displayType + 1;
    $scope.currentDisplayTypeName = typeName;
  };

});
