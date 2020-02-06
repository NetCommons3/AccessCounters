/**
 * @fileoverview AccessCounters Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 * @author exkazuu@gmail.com (Kazunori Sakamoto)
 */


/**
 * AccessCounters Controller Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, NC3_URL)} Controller
 */
NetCommonsApp.controller('AccessCounters', ['$scope', 'NC3_URL', function($scope, NC3_URL) {

  /**
   * initialize
   *
   * @return {void}
   */
  $scope.initialize = function(frameId, counterText) {
    $scope.counterText = counterText;
    $.ajax({
      url: NC3_URL + '/access_counters/access_counters/view.json?frame_id=' + frameId,
      cache: false,
      success: function (data) {
        $scope.$apply(function() {
          $scope.counterText = data.counterText;
        });
      }
    });
  };
}]);


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
