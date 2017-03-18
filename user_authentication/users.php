<?php

// あらかじめ登録されているユーザ
// 他のユーザは認証に失敗する
// key : valueで管理
// valueはパスワード
$users = [
  "sakai" => 1111,
  "arai" => 2222,
  "aoki" => 3333,
  "matsushita" => 4444,
  "yamanaka" => 5555
];

// 認証に成功したら、有効期限を返す
$users_limit = [
  "sakai" => "2017/08/21",
  "arai" => "2018/06/09",
  "aoki" => "2017/10/16",
  "matsushita" => "2018/04/07",
  "yamanaka" => "2019/07/28"
];


// ******

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

// 受け取った情報を変数に格納
$input_name = $_GET['name'];
$input_pass = $_GET['pass'];

// echo htmlspecialchars($input_name, ENT_QUOTES, "utf-8");


// 一致したユーザの情報を入れる
$name;

// users[]の中に受け取ったnameと一致するものはあるか調べる
// なければエラーメッセージを返す
foreach ($users as $key => $value) {
  if ($key == $input_name) {
    $name = $input_name;
  }
}

// foreach使う必要がない
// $pass = $users[$input_name];

// echo htmlspecialchars($pass, ENT_QUOTES, "utf-8");

// *****
// ↑ ここまでは実行される

$response = [
  "type" => "",
  "limit" => "",
  "message" => ""
];

// 一致するものがある場合
// passが一致するかを調べる
// なければエラーメッセージを返す
if ($name != null) {
  if ($users[$name] == $input_pass) {
    // 認証成功のメッセージを返す
    $response = [
      "type" => h("json"),
      "limit" => h($users_limit[$input_name]),
      "message" => h("successful authentication")
    ];

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);

  } else {
    // error
    // passが違うよ
    $response = [
      "type" => h("error"),
      "limit" => h(""),
      "message" => h("パスワードが間違っています")
    ];

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
  }
} else {
   // error
   // nameが違うよ
   $response = [
     "type" => h("error"),
     "limit" => h(""),
     "message" => h("その名前は登録されていません")
   ];

   header('Content-Type: application/json; charset=utf-8');
   echo json_encode($response);
}
