/**
 * @fileoverview アクセスカウンター Javascript
 * @author Shohei Nakajima
 */

/**
 * アクセスカウンター Javascript
 *
 * @param {string}
 * @param {function(scope, http)}
 */
NetCommonsApp.controller('AccessCounters.edit', function($scope , $http) {

	/**
	 * plugin url
	 *
	 * @type {string}
	 */
	var pluginsUrl = '/access_counters/';

	/**
	 * get edit form url
	 *
	 * @type {string}
	 */
	$scope.getEditFormUrl = pluginsUrl + 'access_counters/get_edit_form/';

	/**
	 * post url
	 *
	 * @type {string}
	 */
	$scope.postUrl = pluginsUrl + 'access_counters/edit/';

	/**
	 * image url
	 *
	 * @type {string}
	 */
	$scope.imgaeUrl = pluginsUrl + 'img/%s/%s.gif';

	/**
	 * frame id
	 *
	 * @type {number}
	 */
	$scope.frameId = 0;

	/**
	 * block id
	 *
	 * @type {number}
	 */
	$scope.blockId = 0;

	/**
	 * data id
	 *
	 * @type {number}
	 */
	$scope.dataId = 0;

	/**
	 * ステータスID
	 *     Publish: 1 公開
	 *     PublishRequest: 2 公開申請
	 *     Draft: 3 下書き
	 *     Reject: 4 差し戻し
	 *
	 * @const
	 */
	$scope.STATUS = {
		'Publish' : 1,
		'PublishRequest' : 2,
		'Draft' : 3,
		'Reject' : 4
	};

	/**
	 * コンテンツ編集エリアのID属性
	 *
	 * @type {string}
	 */
	var contentEditBtnAreaTag = '';

	/**
	 * コンテンツ編集の公開するボタンのID属性
	 *
	 * @type {string}
	 */
	var contentExecPublishBtnTag = '';

	/**
	 * プレビューエリアのID属性
	 *
	 * @type {string}
	 */
	var previewAreaTag = '';

	/**
	 * フォームエリアのID属性
	 *
	 * @type {string}
	 */
	var formAreaTag = '';

	/**
	 * POST用フォームエリアのID属性
	 *
	 * @type {string}
	 */
	var formPostAreaTag = '';

	/**
	 * フォームコンテンツのID属性
	 *
	 * @type {string}
	 */
	var formContentsTag = '';

	/**
	 * 登録ボタンエリアのID属性
	 *
	 * @type {string}
	 */
	var formButtonAreaTag = '';

	/**
	 * プレビューボタンのID属性
	 *
	 * @type {string}
	 */
	var btnPreviewTag = '';

	/**
	 * プレビュー閉じるボタンのID属性
	 *
	 * @type {string}
	 */
	var btnClosePreviewTag = '';

	/**
	 * 下書きボタンのID属性
	 *
	 * @type {string}
	 */
	var btnDraftTag = '';

	/**
	 * 差し戻しボタンのID属性
	 *
	 * @type {string}
	 */
	var btnRejectTag = '';

	/**
	 * 状態ラベルエリアのID属性
	 *
	 * @type {string}
	 */
	var statusLabelsTag = '';

	/**
	 * プレビュー表示中ラベルのID属性
	 *
	 * @type {string}
	 */
	var previewLabelTag = '';

	/**
	 * 処理結果メッセージエリアのID属性
	 *
	 * @type {string}
	 */
	var resultMessageAreaTag = '';

	/**
	 * コンテンツエリアのID属性
	 *
	 * @type {string}
	 */
	var contentViewTag = '';

	/**
	 * idのセット
	 *
	 * @param {number} frameId  frames.id
	 * @param {number} blockId  blocks.id
	 * @param {number} dataId   access_counters_formats.id
	 * @return {void}
	 */
	$scope.setId = function(frameId , blockId, dataId) {
		$scope.frameId = frameId;
		if (blockId) {
			$scope.blockId = blockId;
		}
		if (dataId) {
			$scope.dataId = dataId;
		}

		//DOM
		formAreaTag = '#access-counters-form-area-' + $scope.frameId;
		formPostAreaTag = '#access-counters-form-post-area-' + $scope.frameId;
		formContentsTag = '#access-counters-form-contents-' + $scope.frameId;
		previewAreaTag = '#access-counters-preview-area-' + $scope.frameId;
		resultMessageAreaTag = '#access-counters-message-area-' + $scope.frameId;

		contentEditBtnAreaTag = '#access-counters-content-edit-btn-area-' + $scope.frameId;
		contentExecPublishBtnTag = contentEditBtnAreaTag + ' .access-counters-btn-publish';

		formButtonAreaTag = '#access-counters-form-button-area-' + $scope.frameId;
		btnPreviewTag = '#access-counters-btn-preview-' + $scope.frameId;
		btnClosePreviewTag = '#access-counters-btn-close-preview-' + $scope.frameId;
		btnDraftTag = '#access-counters-btn-draft-' + $scope.frameId;
		btnRejectTag = '#access-counters-btn-reject-' + $scope.frameId;

		statusLabelsTag = '#access-counters-status-labels-' + $scope.frameId;
		previewLabelTag = statusLabelsTag + ' .access-counters-preview';

		contentViewTag = '#access-counters-content-view-' + $scope.frameId;
	};

	/**
	 * フォームを閉じる
	 *
	 * @param {number} frameId  frames.id
	 * @return {void}
	 */
	$scope.closeEditForm = function(frameId) {
		//IDのセット
		//$scope.setId(frameId);

		//フォームエリアを隠す
		$(formAreaTag).addClass('hidden');
		//コンテンツ編集ボタンエリアを表示する
		$(contentEditBtnAreaTag).removeClass('hidden');
		//登録ボタンエリアを隠す
		$(formButtonAreaTag).addClass('hidden');
		//コンテンツエリアを表示する
		$(contentViewTag).removeClass('hidden');

		//プレビューも閉じる
		$scope.closePreview();
	};

	/**
	 * フォームを開く
	 *
	 * @param {number} frameId  frames.id
	 * @param {number} blockId  blocks.id
	 * @param {number} dataId   access_counters_formats.id
	 * @return {void}
	 */
	$scope.openEditForm = function(frameId , blockId, dataId) {
		//IDのセット
		$scope.setId(frameId, blockId, dataId);

		//フォームエリアを表示する
		$(formAreaTag).removeClass('hidden');
		//コンテンツ編集ボタンエリアを隠す
		$(contentEditBtnAreaTag).addClass('hidden');
		//登録ボタンエリアを表示する
		$(formButtonAreaTag).removeClass('hidden');
		//コンテンツエリアを隠す
		$(contentViewTag).addClass('hidden');
	};

	/**
	 * メッセージ（実行結果）を表示
	 *
	 * @param {stirng} messageType
	 * @param {stirng} text
	 * @return {void}
	 */
	$scope.showResultMess = function(messageType, text) {
		//結果メッセージを隠す(fadeInで表示するため)
		//$(resultMessageAreaTag).css('display', 'none');

		//メッセージエリアを表示する
		$(resultMessageAreaTag).removeClass('hidden');

		//エラーメッセージ
		if (messageType == 'error') {
			//メッセージのCSSをセット
			$(resultMessageAreaTag).addClass('alert-danger');
			$(resultMessageAreaTag).removeClass('alert-success');
			//メッセージ表示
			$(resultMessageAreaTag + ' .message').html(text);
			//エラーの場合は消さない
			$(resultMessageAreaTag).fadeIn(500);
		}

		//処理正常メッセージ
		if (messageType == 'success') {
			//メッセージのCSSをセット
			$(resultMessageAreaTag).addClass('alert-success');
			$(resultMessageAreaTag).removeClass('alert-danger');
			//メッセージ表示
			$(resultMessageAreaTag + ' .message').html(text);
			//メッセージを表示して、自動で隠す
			$(resultMessageAreaTag).fadeIn(500).fadeTo(1000, 1).fadeOut(500);
		}
	}

	/**
	 * メッセージ（実行結果）を閉じる
	 *
	 * @return {void}
	 */
	$scope.closeResultMess = function() {
		//メッセージエリアを隠す
		$(resultMessageAreaTag).addClass('hidden');
		//メッセージ削除
		$(resultMessageAreaTag + ' .message').html('');
	}

	/**
	 * プレビューの表示
	 *
	 * @return {void}
	 */
	$scope.showPreview = function() {
		//表示桁数
		var showDigitNumber = parseInt($(formAreaTag + ' form' + ' select[name="data[AccessCountersFormat][show_digit_number]"]').val());
		//表示画像
		var showNumberImage = $(formAreaTag + ' form' + ' select[name="data[AccessCountersFormat][show_number_image]"]').val();
		showNumberImage = jQuery.trim(showNumberImage);

		//表示画像のセット
		var displayCount = '';
		for (var i = 0; i < showDigitNumber; i++) {
			if (showNumberImage == '') {
				displayCount = displayCount + String(i);
			} else {
				displayCount = displayCount + "<img src='" + $scope.imgaeUrl.replace('%s', showNumberImage).replace('%s',  String(i)) + "' />";
			}
		}

		/** @todo エスケープ処理が必要 */
		//文字(前)
		var showPrefixFormat = $(formAreaTag + ' form' + ' textarea[name="data[AccessCountersFormat][show_prefix_format]"]').val();
		showPrefixFormat = showPrefixFormat.replace(/[\n\r]/g, '<br />');

		//文字(後)
		var showSuffixFormat = $(formAreaTag + ' form' + ' textarea[name="data[AccessCountersFormat][show_suffix_format]"]').val();
		showSuffixFormat = showSuffixFormat.replace(/[\n\r]/g, '<br />');

		//プレビューに内容セット
		$(previewAreaTag).html(showPrefixFormat + displayCount + showSuffixFormat);

		//プレビュー表示中ラベルを表示する
		$(previewLabelTag).removeClass('hidden');
		//プレビューボタンを隠す
		$(btnPreviewTag).addClass('hidden');
		//プレビュー閉じるボタンを表示する
		$(btnClosePreviewTag).removeClass('hidden');
		//プレビューエリアを表示する
		$(previewAreaTag).removeClass('hidden');
		//フォームコンテンツを隠す
		$(formContentsTag).addClass('hidden');
	};

	/**
	 * プレビューを終了する
	 *
	 * @return {void}
	 */
	$scope.closePreview = function() {
		//プレビュー表示中ラベルを隠す
		$(previewLabelTag).addClass('hidden');
		//プレビューボタンを表示する
		$(btnPreviewTag).removeClass('hidden');
		//プレビュー閉じるボタンを隠す
		$(btnClosePreviewTag).addClass('hidden');
		//プレビューエリアを隠す
		$(previewAreaTag).addClass('hidden');
		//フォームコンテンツを表示する
		$(formContentsTag).removeClass('hidden');
	};

	/**
	 * 各ボタン処理
	 *     Cancel: 閉じる
	 *     Preview: プレビュー
	 *     PreviewClose: プレビューの終了
	 *     Draft: 下書き
	 *     Reject: 差し戻し
	 *     PublishRequest: 公開申請
	 *     Publish: 公開
	 *
	 * @todo 非同期通信中のボタン無効化
	 *
	 * @param {stirng} type
	 * @param {number} frameId
	 * @param {number} blockId
	 * @param {number} dataId
	 * @return {void}
	 */
	$scope.post = function(type , frameId , blockId, dataId) {
		//idセット
		$scope.setId(frameId, blockId ,dataId);

		//閉じる
		if (type === 'Cancel') {
			$scope.closeEditForm(frameId);
			return;
		}
		//プレビュー
		if (type === 'Preview') {
			$scope.showPreview();
			return  ;
		}
		//プレビューの終了
		if (type === 'PreviewClose') {
			$scope.closePreview();
			return ;
		}

		/** @todo 非同期通信中のボタン無効化 */

		//上記以外
		$scope.sendPost(type , blockId, dataId);
	}

	/**
	 * 登録処理
	 *
	 * @param {stirng} type
	 * @return {void}
	 */
	$scope.sendPost = function(type) {
		//Post用のフォームを取得し、Postする
		$http({method: 'GET', url: $scope.getEditFormUrl + $scope.frameId + '/' + Math.random()})
			.success(function(data, status, headers, config) {
				//POST用のフォームセット
				$(formPostAreaTag).html(data);

				//ステータスのセット
				$(formPostAreaTag + ' form' + ' select[name="data[AccessCountersFormat][status]"]').val(type);

				var postParams = {};
				//POSTフォームのシリアライズ
				var i = 0;
				var postParamsArray = $(formPostAreaTag + ' form').serializeArray();
				var length = postParamsArray.length;
				for (var i = 0; i < length; i++) {
					postParams[postParamsArray[i]['name']] = postParamsArray[i]['value'];
				}

				//入力フォームのシリアライズ
				var i = 0;
				var inputParamsArray = $(formAreaTag + ' form').serializeArray();
				var length = inputParamsArray.length;
				for (var i = 0; i < length; i++) {
					postParams[inputParamsArray[i]['name']] = inputParamsArray[i]['value'];
				}

				//登録情報をPOST
				$scope.sendSavePost(postParams);
			})
			.error(function(data, status, headers, config) {
				//keyの取得に失敗
				if(! data) { data = "ERROR!"; }
				$scope.showResultMess("error" , data);
			});
	}

	/**
	 * 登録処理
	 *
	 * @param {Object.<string>} postParams
	 * @return {void}
	 */
	$scope.sendSavePost = function(postParams) {
		//登録情報をPOST
		$.ajax({
			method:'POST' ,
			url: $scope.postUrl + $scope.frameId + '/' + Math.random(),
			data: postParams,
			success:function(json, status, headers, config) {
				$(formPostAreaTag).html(' '); //POSTフォームの破棄
				$scope.setNewest(json);
				$scope.showResultMess("success" , json.message);
				$scope.closeEditForm($scope.frameId);
			},
			error:function(json, status, headers, config) {
				$(formPostAreaTag).html(' '); //POSTフォームの破棄
				if (! json.message) {
					$scope.showResultMess("error" , headers);
				} else {
					$scope.showResultMess("error" , json.message);
				}
			}
		});
	}

	/**
	 * 最新の情報にいれかえる
	 *
	 * @param {Object.<string>} json
	 * @return {void}
	 */
	$scope.setNewest = function(json) {
		//ステータスラベルのクリア
		var statusLabelClassTag = statusLabelsTag + ' .access-counters-status-';
		$(statusLabelClassTag + $scope.STATUS.Publish).addClass('hidden');
		$(statusLabelClassTag + $scope.STATUS.Draft).addClass('hidden');
		$(statusLabelClassTag + $scope.STATUS.PublishRequest).addClass('hidden');
		$(statusLabelClassTag + $scope.STATUS.Reject).addClass('hidden');

		//ステータスIDの取得
		var statusId = json.data.AccessCountersFormat.status_id;
		//ステータスラベルの表示
		$(statusLabelClassTag + statusId).removeClass('hidden');

		//ステータス毎の処理
		if (statusId == $scope.STATUS.PublishRequest) {
			//公開申請
			$(contentExecPublishBtnTag).removeClass('hidden');
			//ボタンの切り替え(下書き→差し戻し)
			$(btnRejectTag).removeClass('hidden');
			$(btnDraftTag).addClass('hidden');

		} else if (statusId == $scope.STATUS.Reject || statusId == $scope.STATUS.Publish) {
			//差し戻し or 公開
			$(contentExecPublishBtnTag).addClass('hidden');
			//ボタンの切り替え(差し戻し→下書き)
			$(btnRejectTag).addClass('hidden');
			$(btnDraftTag).removeClass('hidden');

		}

		//一般画面の最新表示
		$(contentViewTag).html(json.data.showCountContent);
	}
});

NetCommonsApp.controller('AccessCounters.setting', function($scope , $http) {

    $scope.getPluginName = function(n) {

    }
});