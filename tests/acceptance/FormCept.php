<?php

$I = new AcceptanceTester($scenario);
$I->wantTo('コンタクトフォームのテスト');

$I->amGoingTo('ホームにアクセス');
$I->amOnPage('/');
$I->seeInTitle('CodeIgniterへようこそ！');

$I->amGoingTo('コンタクトフォームにアクセス');
$I->amOnPage('/form');
$I->seeInTitle('コンタクトフォーム');

$I->amGoingTo('名前だけ入力して送信するとメールアドレス欄がエラー');
$I->fillField('name', '<script>abc</script>');
$I->click('確認');
$I->wait(1);
$I->see('メールアドレス欄は必須フィールドです');
$I->seeInFormFields('form', [
	'name' => '<script>abc</script>',
]);

$I->amGoingTo('正常データを送信して入力フォームに戻る');
$I->fillField('name', '<script>abc</script>');
$I->fillField('email', 'test@example.jp');
$I->fillField('comment', '<script>xyz</script>');
$I->click('確認');
$I->wait(1);
$I->See('<script>abc</script>');
$I->See('<script>xyz</script>');
$I->see('お問い合わせ内容の確認');
$I->click('修正');
$I->wait(1);
$I->seeInFormFields('form', [
	'name'    => '<script>abc</script>',
	'email'   => 'test@example.jp',
	'comment' => '<script>xyz</script>',
]);

$I->amGoingTo('正常データの送信');
$I->click('確認');
$I->wait(1);
$I->See('<script>xyz</script>');
$I->see('お問い合わせ内容の確認');
$I->click('送信');
$I->wait(1);
$I->see('送信しました');
