/**
 * @fileoverview AccessCounters Javascript
 * @author ozawa.ryo@withone.co.jp (Ryo Ozawa)
 */


/**
 * AccessCounters Javascript
 *
 * @param {string} Controller name
 * @param {function(scope, http, modal, modalStack)} Controller
 */
NetCommonsApp.controller('AccessCounters',
    function($scope, $http, $modal, $modalStack) {

      /**
       * AccessCounters plugin view url
       *
       * @const
       */
      $scope.PLUGIN_EDIT_URL = '/access_counters/access_counter_edit/';

      /**
       * AccessCounter
       *
       * @type {Object.<string>}
       */
      $scope.counter = {};

      /**
       * Initialize
       *
       * @return {void}
       */
      $scope.initialize = function(frameId, counter) {
        $scope.frameId = frameId;
        $scope.counter = counter;
      };

      /**
       * Show manage dialog
       *
       * @return {void}
       */
      $scope.showManage = function() {
        // 既に開いているモーダルウィンドウをキャンセルする
        $modalStack.dismissAll('canceled');

        var templateUrl = $scope.PLUGIN_EDIT_URL + 'view/' +
                          $scope.frameId + '.json';
        var controller = 'AccessCounters.edit';

        $modal.open({
          templateUrl: templateUrl,
          controller: controller,
          backdrop: 'static',
          scope: $scope
        }).result.then(
            function(result) {},
            function(reason) {
              if (typeof reason.data === 'object') {
                // openによるエラー
                $scope.flash.danger(reason.status + ' ' + reason.data.name);
              } else if (reason === 'canceled') {
                // キャンセル
                $scope.flash.close();
              }
            }
        );
      };

      /**
       * formatCount method
       *
       * @param {number} count
       * @param {number} displayDigit
       * @return {array}
       */
      $scope.formatCount = function(count, displayDigit) {

        // デフォルト値
        if (count == null || displayDigit == null) {
          count = 1234567890;
          displayDigit = 10;
        }

        var countStr = String(count);
        var countDigit = countStr.length;

        // 表示桁数よりカウント桁数が大きい場合、表示桁数を修正
        if (displayDigit < countDigit) {
          displayDigit = countDigit;
        }

        // 表示桁数に合わせてゼロパディング
        var displayCount = ('000000000' + countStr).slice(-displayDigit);

        // 表示用に1文字ずつ分割したリストを返す
        return displayCount.split('');
      };

      /**
       * formatCount method
       *
       * @param {boolean} isValid
       * @return {string}
       */
      $scope.getValidationState = function(isValid) {
        if ($scope.counter.AccessCounter.is_started) {
          return '';
        }
        return (isValid) ? 'has-success' : 'has-error';
      };

    });


/**
 * AccessCounters.edit Javascript
 *
 * @param {string} Controller name
 * @param {function(scope, http, modalStack)} Controller
 */
NetCommonsApp.controller('AccessCounters.edit',
    function($scope, $http, $modalStack) {

      /**
       * label of display typel
       *
       * @type {string}
       */
      $scope.displayTypeLabel =
          $scope.counter.AccessCounterFrameSetting.display_type_label;

      /**
       * edit object
       *
       * @type {Object.<string>}
       */
      $scope.edit = {
        _method: 'POST',
        data: {
          AccessCounter: {
            starting_count: +($scope.counter.AccessCounter.starting_count),
            is_started: $scope.counter.AccessCounter.is_started
          },
          AccessCounterFrameSetting: {
            id: +($scope.counter.AccessCounterFrameSetting.id),
            display_type:
                +($scope.counter.AccessCounterFrameSetting.display_type),
            display_digit:
                +($scope.counter.AccessCounterFrameSetting.display_digit)
          },
          Frame: {
            id: $scope.frameId
          },
          _Token: {
            key: '',
            fields: '',
            unlocked: ''
          }
        }
      };

      /**
       * dialog cancel
       *
       * @return {void}
       */
      $scope.cancel = function() {
        $modalStack.dismissAll('canceled');
      };

      /**
       * dialog changeDisplayType
       *
       * @param {string} displayTypeLabel
       * @param {number} displayType
       * @return {void}
       */
      $scope.changeDisplayType = function(displayTypeLabel, displayType) {
        $scope.displayTypeLabel = displayTypeLabel;
        $scope.edit.data.AccessCounterFrameSetting.display_type = displayType;
      };

      /**
       * dialog save
       *
       * @return {void}
       */
      $scope.save = function() {
        $http.get($scope.PLUGIN_EDIT_URL + 'form/' +
                  $scope.frameId + '/' + Math.random() + '.json')
          .success(function(data) {
              //フォームエレメント生成
              var form = $('<div>').html(data);

              //セキュリティキーセット
              $scope.edit.data._Token.key =
                  $(form).find('input[name="data[_Token][key]"]').val();
              $scope.edit.data._Token.fields =
                  $(form).find('input[name="data[_Token][fields]"]').val();
              $scope.edit.data._Token.unlocked =
                  $(form).find('input[name="data[_Token][unlocked]"]').val();

              //登録情報をPOST
              $scope.sendPost($scope.edit);
            })
          .error(function(data, status) {
              $scope.flash.danger(status + ' ' + data.name);
            });
      };

      /**
       * send post
       *
       * @param {Object.<string>} postParams
       * @return {void}
       */
      $scope.sendPost = function(postParams) {
        $http.post($scope.PLUGIN_EDIT_URL + 'edit/' +
            $scope.frameId + '/' + Math.random() + '.json',
            $.param(postParams),
            {headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
          .success(function(data) {
              angular.copy(data.counter, $scope.counter);
              $scope.flash.success(data.name);
              $modalStack.dismissAll('saved');
            })
          .error(function(data, status) {
              $scope.flash.danger(status + ' ' + data.name);
            });
      };

    });

