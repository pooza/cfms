{*
一覧画面テンプレート

@package jp.co.commons.cfms
@subpackage UserProject
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
{assign var='body.id' value='sec'}
{assign var='body.class' value='door'}
{include file='UserHeader'}
{include file='MemberHeader'}

<div id="container">
	<h2 class="large door_text"><strong>ようこそ、{$account.name}様。</strong></h2>
	<div class="scroller"><div class="content">

	{foreach from=$pages key='page_index' item='page' name='pages'}
	<div class="section" id="section_{$page_index}">
	<table width="0" border="0" cellspacing="0" cellpadding="0" class="door_box">
		<tr>
			<td class="icon_img">
				{if !$smarty.foreach.pages.first}
					<a href="#"><img class="previous_button" src="/images/door_icon_left.gif" width="16" height="60" alt=""></a>
				{/if}
			</td>
			<td>
				<table width="0" border="0" cellspacing="0" cellpadding="0" class="door01 roll">
					{foreach from=$page item='row'}
						<tr>
							{foreach from=$row item='project'}
								<td width="162">
									{if $project.id}
										<a href="/UserProject/Wall/{$project.id}"><img src="/images/door_img.gif" width="68" height="113" alt=""></a>
									{/if}
								</td>
							{/foreach}
						</tr>
						<tr>
							{foreach from=$row item='project'}
								<td class="door_text" valign="top">
									<p class="normal text_l">{strip}
										{if $project.id}
											<a href="/UserProject/Wall/{$project.id}">{$project.name}</a>
										{/if}
									{/strip}</p>
								</td>
							{/foreach}
						</tr>
					{/foreach}
				</table>
			</td>
			<td class="icon_img">
				{if !$smarty.foreach.pages.last}
					<a href="#"><img class="next_button" src="/images/door_icon_right.gif" width="16" height="61" alt=""></a>
				{/if}
			</td>
		</tr>
	</table>
	</div>
	{/foreach}

	</div></div>
</div>
<script type="text/javascript" charset="utf-8">
{literal}
document.observe('dom:loaded', function () {
  var glider = new Glider('container', {
    duration: 0.5
  });
  $$('.previous_button').each(function (element) {
    element.observe('click', function () {
      glider.previous();
    });
  });
  $$('.next_button').each(function (element) {
    element.observe('click', function () {
      glider.next();
    });
  });
});
{/literal}
</script>

{include file='MemberFooter'}
{include file='UserFooter'}

{* vim: set tabstop=4: *}
