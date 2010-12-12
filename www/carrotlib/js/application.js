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

  toggleTag: function (field, name, force) {
    var names = CFMSLib.getTagNames(field);
    name = name.trim();
    var nodes = $(field.id + '_TagCloud').childNodes;
    var container;
    for (var i = 0 ; i < nodes.length ; i ++) {
      var node = nodes[i];
      if ((node.nodeType == 1) && (node.tagName == 'A')) {
        if (node.firstChild.nodeValue == name) {
          container = node;
        }
      }
    }
    if (container) {
      if (names.member(name) && !force) {
        container.className = container.className.replace(/selected/g, '');
        names.each (function(value, index) {
          if (value == name) {
            names.splice(index, 1);
          }
        });
      } else {
        names.push(name);
        container.className += ' selected';
      }
    }
    field.value = names.uniq().join("\n");
  },

  getTagNames: function (field) {
    var names = [];
    field.value.split(/\r?\n|\r/).each (function(value) {
      if (value = value.trim()) {
        names.push(value);
      }
    });
    return names;
  },

  initialized: true
}
