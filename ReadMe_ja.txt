Step 1.
PushComponent.php を app/Controller/Component/ 以下に置く
PushSampleController.php を app/Controller/ 以下に置く

Step 2.
pemファイル を app/Vendor/ の下に置く

Step 3.
PushComponent.phpに各種設定をする
(pemの場所とか、pemのパスワードとか)

Step 4.
PushSampleController.phpの送り先のdevice tokenを書き換え

Step 5.
ブラウザで　http://サイトのurl/push_sample/　を叩く

以上