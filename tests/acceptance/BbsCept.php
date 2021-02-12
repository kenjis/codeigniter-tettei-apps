<?php

$I = new AcceptanceTester($scenario);
$I->wantTo('掲示板のテスト');

$I->amGoingTo('掲示板にアクセス');
$I->amOnPage('/bbs');
$I->seeInTitle('掲示板');

$I->amGoingTo('新規投稿ボタンを押す');
$I->click('.bbs_new_post_button a');
$I->wait(1);
$I->seeInTitle('掲示板: 新規投稿');

$I->amGoingTo('名前だけ入力して送信するとエラー');
$I->fillField('name', '<script>abc');
$I->click('送信');
$I->wait(1);
$I->seeInFormFields('form', [
	'name' => '<script>abc',
]);
$I->see('件名欄は必須フィールドです');
$I->see('内容欄は必須フィールドです');
$I->see('画像認証コードが一致しません');

$I->amGoingTo('正常データの送信');
$subject = '投稿のテスト ' . time();
$I->fillField('name',     '<script>abc');
$I->fillField('subject',  $subject);
$I->fillField('body',     'これは投稿のテストです。');
$I->fillField('password', '<script>xyz</script>');
$I->fillField('captcha',  '8888');
$I->click('送信');
$I->wait(1);
$I->see('<script>abc');
$I->see('<script>xyz</script>');
$I->see('投稿確認');
$I->click('送信');
$I->wait(1);
$I->see($subject);
