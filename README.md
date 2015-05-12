# 『CodeIgniter徹底入門』のサンプルアプリケーションをCodeIgniter 3.0にアップデート

ここは『CodeIgniter徹底入門』（翔泳社）に含まれている以下のサンプルアプリケーション（CodeIgniter 1.6.1用）をCodeIgniter 3.0で動作するように更新するためのプロジェクトです（作業中）。

* コンタクトフォーム（7章）
* モバイル対応簡易掲示板（8章）
* 簡易ショッピングサイト（9章）

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
* 掲示板
  * コントローラでの文字エンコード変換ができなくなったのでフックのpre_systemに移動
* ショッピング
  * categoryとproductテーブルのSeedを追加 [application/database/seeds](application/database/seeds)
  * キーワード検索をGETメソッドを使うように変更
  * メール本文の作成をテンプレートパーサクラスを使うように変更
  * クラスの分割
* リファクタリング
  * ビューのコーディングスタイルを統一し、HTMLエスケープを徹底

追加されたComposerのパッケージ

* Cli for CodeIgniter <http://blog.a-way-out.net/blog/2015/05/07/codeigniter-cli/>
* CI PHPUnit Test <https://github.com/kenjis/ci-phpunit-test>
* Faker
* Codeception
* Symfony DomCrawler

## インストール方法

@TODO

## 参考

* [application/以下のCodeIgniter 3.0へのアップデート](https://github.com/kenjis/codeigniter-tettei-apps/commit/3dcdeefc8e42b2c8f6636fba5e86c7de28f961a3?w=1)

## ライセンス

サンプルアプリケーションのライセンスは「修正BSDライセンス」です。詳細は、[docs/license-codeigniter-tettei-1.4.txt](docs/license-codeigniter-tettei-1.4.txt)をご覧ください。

## 謝辞

サンプルアプリケーションのデザインは、神野みちるさん（株式会社ステップワイズ）にしていただきました。

## 『CodeIgniter徹底入門』について

* [『CodeIgniter徹底入門』情報ページ](http://codeigniter.jp/tettei/)
* [『CodeIgniter徹底入門』に対するノート](https://docs.google.com/document/d/1yWAiCylC_5oWrBYVushfAqalksECRM-StDbtZY6kAoE/edit?hl=ja)
