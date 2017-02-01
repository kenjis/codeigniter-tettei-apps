<?php

$I = new AcceptanceTester($scenario);
$I->wantTo('ショップのテスト');

$I->amGoingTo('ショップにアクセス');
$I->amOnPage('/shop');
$I->seeInTitle('CIショップ');

$I->amGoingTo('左コラムの「CD」をクリック');
$I->click('CD');
$I->wait(1);
$I->see('「CD」のリスト');

$I->amGoingTo('検索ボタンを空のまま押す');
$I->fillField('q', '');
$I->click('GO');
$I->wait(1);
$I->see('「全商品」の検索結果');

$I->amGoingTo('「入門」を検索');
$I->fillField('q', '入門');
$I->click('GO');
$I->wait(1);
$I->see('「入門」の検索結果');

$I->amGoingTo('左コラムの「本」をクリック');
$I->click('本');
$I->wait(1);
$I->see('「本」のリスト');

$I->amGoingTo('「CodeIgniter徹底入門」をクリック');
$I->click('CodeIgniter徹底入門');
$I->wait(1);
$I->see('日本初のCodeIgniter解説書');

$I->amGoingTo('「カゴに入れる」をクリック');
$I->click('カゴに入れる');
$I->wait(1);
$I->see('買い物かご');

$I->amGoingTo('「レジに進む」をクリック');
$I->click('レジに進む');
$I->wait(1);
$I->see('お客様情報の入力');

$I->amGoingTo('名前のみ入力して送信');
$I->fillField('name', '<script>abc</script>');
$I->click('確認');
$I->wait(1);
$I->see('住所欄は必須フィールドです');
$I->seeInFormFields('form', [
	'name' => '<script>abc</script>',
]);

$I->amGoingTo('正常なお客様情報の送信');
$I->fillField('name', '発火太郎');
$I->fillField('zip', '111-1111');
$I->fillField('addr', '東京都');
$I->fillField('tel', '03-3333-3333');
$I->fillField('email', 'test@example.jp');
$I->click('確認');
$I->wait(1);
$I->see('注文内容の確認');
$I->see('発火太郎');
$I->see('111-1111');
$I->see('東京都');
$I->see('03-3333-3333');
$I->see('test@example.jp');

$I->amGoingTo('お客様情報の入力へ戻りメールアドレスのみ修正する');
$I->click('お客様情報の入力へ戻る');
$I->wait(1);
$I->seeInFormFields('form', [
	'name'  => '発火太郎',
	'zip'   => '111-1111',
	'addr'  => '東京都',
	'tel'   => '03-3333-3333',
	'email' => 'test@example.jp',
]);
$I->fillField('email', 'tarou@example.jp');
$I->click('確認');
$I->wait(1);

$I->amGoingTo('注文を確定する');
$I->click('注文を確定する');
$I->wait(1);
$I->see('ご注文ありがとうございます');
