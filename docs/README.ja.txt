日本語言語パック(CodeIgniter 1.6.1用)

2007/05/16 日本CodeIgniterユーザ会 <http://codeigniter.jp/>


日本語言語パックは、CodeIgniter を日本語化するものですが、日本CodeIgniterユーザ
会が独自に作成した非公式なパッケージです。CodeIgniter の開発元の EllisLab とは
無関係です。


■日本語言語パックでの変更点
* 言語ファイル
** japanese を追加

* config/user_agents.php
** 日本の携帯端末の定義を追加(Kuniharu Tsujioka contributed)

* バリデーション(検証)クラス
** mb_strlen を使うように修正

* Emailクラス
** messageメソッドで、iso-2022-jp の場合は、stripslashes しないように変更

* HTML
* Welcomeページを日本語に
** metaタグでの charset の指定を追加(titleタグの前に)
** DOCTYPE を追加


■ライセンス
オリジナルの CodeIgniter は、CodeIgniterライセンスです。
日本語言語パックは修正BSDライセンスです。
詳細は、copyright.txt をご覧ください。


■謝辞
CodeIgniter がなければ、この日本語言語パックは誕生しませんでした。
Rick Ellis と EllisLab の開発チームに感謝します。

