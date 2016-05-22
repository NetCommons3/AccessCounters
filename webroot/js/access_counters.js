/**
 * @fileoverview AccessCounters Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * AccessCounterFrameSettings Javascript
 *
 * @param {string} Controller name
 * @param {function($scope)} Controller
 */
NetCommonsApp.controller('AccessCounterFrameSettings', ['$scope', function($scope) {

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

}]);
