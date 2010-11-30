/**
 * アプリケーション ユーティリティ関数
 *
 * @package jp.co.commons.cfms
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */

var CFMSLib = {
  updateProjectList: function () {
    var params = {
      key: $('key').value,
      status: $('status').value
    };
    new Ajax.Updater('ProjectList', '/AdminProject/ListByAccount?' + $H(params).toQueryString());
  },

  initializeProjectList: function () {
    new Ajax.Request('/AdminProject/ListAll', {
      onComplete: function () {
        new Ajax.Updater('ProjectList', '/AdminProject/ListByAccount');
      }
    });
  },

  updateProjectStatus: function (checkbox) {
    var id = checkbox.id.split('_')[1];
    var params = {project_id: id};
    if (checkbox.checked) {
      params.status = 1;
    } else {
      params.status = 0;
    }
    new Ajax.Request('/AdminAccount/JoinProject', {
      method: 'POST',
      parameters: params,
      onComplete: function (response) {
        if (checkbox.checked) {
          $('project_row_' + id).className = 'show';
        } else {
          $('project_row_' + id).className = 'hide';
        }
      },
      onFailure: function (response) {
        alert(response.responseText);
      }
    });
  },

  initialized: true
}
