# 『CodeIgniter徹底入門』のサンプルアプリケーションをCodeIgniter 3.xにアップデート

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kenjis/codeigniter-tettei-apps/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/kenjis/codeigniter-tettei-apps/?branch=develop)
[![Coverage Status](https://coveralls.io/repos/kenjis/codeigniter-tettei-apps/badge.svg?branch=develop)](https://coveralls.io/r/kenjis/codeigniter-tettei-apps?branch=develop)
[![Build Status](https://travis-ci.org/kenjis/codeigniter-tettei-apps.svg?branch=develop)](https://travis-ci.org/kenjis/codeigniter-tettei-apps)

ここは『CodeIgniter徹底入門』（翔泳社）に含まれている以下のサンプルアプリケーション（CodeIgniter 1.6.1用）をCodeIgniter 3.xで動作するように更新するためのプロジェクトです（作業中）。

* コンタクトフォーム（7章）
* モバイル対応簡易掲示板（8章）
* 簡易ショッピングサイト（9章）

現在、CodeIgniter 3.xで動作するための更新は完了しており、リファクタリングなどを実施中です。

**興味のある方はどなたでもコードレビューをお願いします。**

## 要件

* PHP 5.5以降
* MySQL

## 書籍のコードからの変更点

* CodeIgniter 3.1.3に対応（CodeIgniter本体は [CodeIgniter Composer Installer](http://blog.a-way-out.net/blog/2015/12/06/install-codeigniter/) によりComposerでインストール）
* フォルダ構成を変更し、Web公開領域を`public`フォルダ以下に限定
* CodeIgniterでComposerを利用可能に設定
* ISO-2022-JPのメールは作成できなくなったのでUTF-8に変更
* CSRF対策を独自実装からCodeIgniterの自動保護に変更
* Codeception/Seleniumによる受入テストの追加 [tests/acceptance](tests/acceptance)
* PHPUnitによるアプリケーションテストの追加 [application/tests](application/tests)
* データベースマイグレーションの追加 [application/database/migrations](application/database/migrations)
* 掲示板
  * コントローラでの文字エンコード変換ができなくなったのでフックの`pre_system`に移動
* ショッピング
  * `category`と`product`テーブルのSeederを追加 [application/database/seeds](application/database/seeds)
  * キーワード検索をGETメソッドを使うように変更
  * メール本文の作成をテンプレートパーサクラスを使うように変更
  * クラスの分割
  * `MY_Controller`の追加
  * ビューにTwigを利用
  * XSS脆弱性の修正
* リファクタリング
  * ビューのコーディングスタイルを統一し、HTMLエスケープを徹底

追加されたComposerのパッケージ

* CodeIgniter Simple and Secure Twig <https://github.com/kenjis/codeigniter-ss-twig>
* Cli for CodeIgniter <http://blog.a-way-out.net/blog/2015/05/07/codeigniter-cli/>
* ci-phpunit-test <http://blog.a-way-out.net/blog/2015/05/19/ci-phpunit-test/>
* Faker <http://blog.a-way-out.net/blog/2014/06/13/faker/>
* Codeception <http://codeception.com/> <http://piccagliani.github.io/Codeception.docs.ja_JP/>
* Symfony DomCrawler <http://docs.symfony.gr.jp/symfony2/components/dom_crawler.html>
* Symfony CssSelector <http://docs.symfony.gr.jp/symfony2/components/css_selector.html>
* PHPUnit <https://phpunit.de/manual/4.8/ja/index.html>
* CodeIgniter Debug Bar <https://github.com/kenjis/codeigniter-debugbar>

## インストール方法

### ダウンロード

https://github.com/kenjis/codeigniter-tettei-apps/archive/develop.zip をダウンロードし解凍します。

### Apacheの設定

`codeigniter-tettei-apps/public`フォルダが公開フォルダです。ここを <http://localhost/CodeIgniter/> でアクセスできるように設定してください。

例えば、以下のようにApacheの`htdocs`以下にシンボリックリンクを張ります。

~~~
$ cd /paht/to/Apache/htdocs/
$ ln -s /path/to/codeigniter-tettei-apps/public/ CodeIgniter
~~~

なお、`.htaccess`によるmod_rewriteの設定を有効にしてください。

### ファイルのパーミッション設定

必要な場合は、以下のフォルダにApacheから書き込みできる権限を付与してください。

~~~
$ cd /path/to/codeigniter-tettei-apps/
$ chmod o+w application/logs/
$ chmod o+w application/cache/
$ chmod o+w public/captcha/
~~~

### 依存パッケージのインストール

Composerで依存パッケージをインストールします。

~~~
$ php composer.phar self-update
$ php composer.phar install
~~~

### データベースとユーザの作成

MySQLにデータベースとユーザを作成します。

~~~
CREATE DATABASE `codeigniter` DEFAULT CHARACTER SET utf8;
GRANT ALL PRIVILEGES ON codeigniter.* TO username@localhost IDENTIFIED BY 'password';
~~~

### データベースマイグレーションとシーディングの実行

データベースにテーブルを作成し、テストデータを挿入します。

~~~
$ php cli migrate
$ php cli seed
~~~

## テストの実行方法

### PHPUnitによるアプリケーションテスト

~~~
$ composer test
~~~

テストカバー率のレポートは`build/coverage`フォルダに作成されます。なお、カバー率の集計にはXdebugが必要です。

### Codeception/Seleniumによる受入テスト

<https://www.mozilla.org/ja/firefox/new/> よりFirefoxをダウンロードしインストールします。

<http://docs.seleniumhq.org/download/> より最新のSelenium Standalone Serverをダウンロードし、プロジェクトのルートフォルダに配置します。

<https://github.com/mozilla/geckodriver/releases> より最新のgeckodriver（手許ではgeckodriver-v0.13.0-macos.tar.gzにて検証）をダウンロードし、解凍したドライバをプロジェクトのルートフォルダに配置します。

ダウンロードしたSeleniumサーバを起動します。

~~~
$ java -jar selenium-server-standalone-3.0.1.jar
~~~

受入テストを実行します。

~~~
$ sh acceptance-test.sh
~~~

## 参考

書籍のコードほぼそのままでCodeIgniter 3.0.0に対応したものを見たい場合は、[master](https://github.com/kenjis/codeigniter-tettei-apps/tree/master)ブランチをご覧ください。

また、具体的な変更点は以下をご覧ください。

* [application/以下のCodeIgniter 3.0へのアップデート](https://github.com/kenjis/codeigniter-tettei-apps/commit/3dcdeefc8e42b2c8f6636fba5e86c7de28f961a3?w=1)

## ライセンス

サンプルアプリケーションのライセンスは「修正BSDライセンス」です。詳細は、[docs/license-codeigniter-tettei-1.4.txt](docs/license-codeigniter-tettei-1.4.txt) をご覧ください。

## 謝辞

サンプルアプリケーションのデザインは、神野みちるさん（株式会社ステップワイズ）にしていただきました。

## 『CodeIgniter徹底入門』について

* [『CodeIgniter徹底入門』情報ページ](http://codeigniter.jp/tettei/)
* [『CodeIgniter徹底入門』に対するノート](https://github.com/codeigniter-jp/codeigniter-tettei-note)
