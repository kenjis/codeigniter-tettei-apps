# 『CodeIgniter徹底入門』のサンプルアプリケーションをCodeIgniter 3.0にアップデート

ここは『CodeIgniter徹底入門』（翔泳社）に含まれている以下のサンプルアプリケーション（CodeIgniter 1.6.1用）をCodeIgniter 3.0で動作するように更新するためのプロジェクトです（作業中）。

* コンタクトフォーム（7章）
* モバイル対応簡易掲示板（8章）
* 簡易ショッピングサイト（9章）

現在、CodeIgniter 3.0で動作するための更新は完了しており、リファクタリングなどを実施中です。**興味のある方はどなたでもコードレビューをお願いします。**

## 要件

* PHP 5.4以降

## 書籍のコードからの変更点

* CodeIgniter 3.0.0に対応
* フォルダ構成を変更し、Web公開領域を`public`フォルダ以下に限定
* CodeIgniterでComposerを利用可能に設定
* ISO-2022-JPのメールは作成できなくなったのでUTF-8に変更
* CSRF対策を独自実装からCodeIgniterの自動保護に変更
* Codeception/Seleniumによる受入テストの追加 [tests/acceptance](tests/acceptance)
* PHPUnitによるアプリケーションテストの追加 [application/tests](application/tests)
* データベースマイグレーションの追加 [application/database/migrations](application/database/migrations)
* 掲示板
  * コントローラでの文字エンコード変換ができなくなったのでフックのpre_systemに移動
* ショッピング
  * categoryとproductテーブルのSeedを追加 [application/database/seeds](application/database/seeds)
  * キーワード検索をGETメソッドを使うように変更
  * メール本文の作成をテンプレートパーサクラスを使うように変更
  * クラスの分割
  * MY_Controllerの追加
* リファクタリング
  * ビューのコーディングスタイルを統一し、HTMLエスケープを徹底

追加されたComposerのパッケージ

* Cli for CodeIgniter <http://blog.a-way-out.net/blog/2015/05/07/codeigniter-cli/>
* CI PHPUnit Test <http://blog.a-way-out.net/blog/2015/05/19/ci-phpunit-test/>
* Faker <http://blog.a-way-out.net/blog/2014/06/13/faker/>
* Codeception <http://codeception.com/>
* Symfony DomCrawler <http://docs.symfony.gr.jp/symfony2/components/dom_crawler.html>
* PHPUnit <https://phpunit.de/manual/4.6/ja/index.html>
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
$ cd application/tests/
$ ../../vendor/bin/phpunit
~~~

テストカバー率のレポートは`tests/build/coverage`フォルダに作成されます。なお、カバー率の集計にはXdebugが必要です。

### Codeception/Seleniumによる受入テスト

<http://docs.seleniumhq.org/download/> よりSelenium Server 2.45.0をダウンロードします。

ダウンロードしたSeleniumサーバを起動します。

~~~
$ java -jar selenium-server-standalone-2.45.0.jar
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

サンプルアプリケーションのライセンスは「修正BSDライセンス」です。詳細は、[docs/license-codeigniter-tettei-1.4.txt](docs/license-codeigniter-tettei-1.4.txt)をご覧ください。

## 謝辞

サンプルアプリケーションのデザインは、神野みちるさん（株式会社ステップワイズ）にしていただきました。

## 『CodeIgniter徹底入門』について

* [『CodeIgniter徹底入門』情報ページ](http://codeigniter.jp/tettei/)
* [『CodeIgniter徹底入門』に対するノート](https://docs.google.com/document/d/1yWAiCylC_5oWrBYVushfAqalksECRM-StDbtZY6kAoE/edit?hl=ja)
