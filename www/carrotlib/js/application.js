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
      key: $('key').value
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

  updateAccountList: function () {
    var params = {
      key: $('key').value
    };
    new Ajax.Updater('AccountList', '/AdminAccount/ListByProject?' + $H(params).toQueryString());
  },

  initializeAccountList: function () {
    new Ajax.Request('/AdminAccount/ListAll', {
      onComplete: function () {
        new Ajax.Updater('AccountList', '/AdminAccount/ListByProject');
      }
    });
  },

  updateAccountStatus: function (checkbox) {
    var id = checkbox.id.split('_')[1];
    var params = {account_id: id};
    if (checkbox.checked) {
      params.status = 1;
    } else {
      params.status = 0;
    }
    new Ajax.Request('/AdminProject/JoinAccount', {
      method: 'POST',
      parameters: params,
      onComplete: function (response) {
        if (checkbox.checked) {
          $('account_row_' + id).className = 'show';
        } else {
          $('account_row_' + id).className = 'hide';
        }
      },
      onFailure: function (response) {
        alert(response.responseText);
      }
    });
  },

  initialized: true
}
