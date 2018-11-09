<?php
/**
 * コントローラー.
 *
 * @author    Logue <logue@hotmail.co.jp>
 * @copyright 2018 Logue
 * @license   MIT
 */
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class Controller
{
    private $app;
    // 除外するフォーム名
    private $exclusion_item = [
        'page',
        'checked',
        'selected',
        'required',             // 必須
        'singlebyte',           // 半角文字
        'alphanumeric',         // 半角英数字
        'alphabetic',           // 半角英字
        'numeric',              // 数字
        'numeric_hyphen',       // 数字+ハイフン
        'hiragana',             // ひらがな
        'katakana',             // カタカナ
        'contain_multibyte',    // 全角文字を含む
        'multibyte',            // 全角文字のみ
        'email',                // メールアドレス
        'match',                // 一致
        'len',                  // 長さ
        'url',                  // URL
        'num_range',            // 数値範囲
        'file',                 // ファイル
        'file_remove',          // ファイル削除
        'file_required',        // ファイル必須
    ];

    public function __construct(Container $app)
    {
        $this->app = $app;
        $this->tr = function ($key, array $replace = []) {
            return $this->app->translator->trans($key, $replace);
        };
        // CSRF token name and value
        $this->csrf_name = $this->app->csrf->getTokenNameKey();
        $this->csrf_key = $this->app->csrf->getTokenValueKey();
        array_push($this->exclusion_item, $this->csrf_name, $this->csrf_key);
    }

    private function tr($key, array $replace = [])
    {
        return $this->app->translator->trans($key, $replace);
    }

    public function input(Request $request, Response $response)
    {
        $ret = [
            'tr'          => $this->tr,
            'name_key'    => $this->csrf_name,
            'value_key'   => $this->csrf_key,
            'token_name'  => $request->getAttribute($this->csrf_name),
            'token_value' => $request->getAttribute($this->csrf_key),
        ];

        $post = $request->getParsedBody();

        if (!empty($post)) {
            foreach ($post as $key=>$value) {
                if (in_array($key, $this->exclusion_item, true)) {
                    continue;
                }
                $ret['value'][$key] = trim($value);
            }
            $ret = array_merge($ret, $this->check($post));
            $ret['checked']['default'] = '';
            $ret['selected']['default'] = '';
        } else {
            // 初期状態の選択
            $ret['checked']['default'] = 'checked="checked"';
            $ret['selected']['default'] = 'checked="checked"';
        }

        return $this->app->view->render($response, 'input', $ret);
    }

    public function check($post)
    {
        $checked = [];
        $selected = [];
        $global_errors = [];
        $required = [];
        $singlebyte = [];
        $alphanumeric = [];
        $alphabetic = [];
        $numeric = [];
        $numeric_hyphen = [];
        $hiragana = [];
        $katakana = [];
        $contain_multibyte = [];
        $multibyte = [];
        $email = [];
        $match = [];
        $len = [];
        $url = [];
        $num_range = [];
        $file = [];
        $file_remove = [];
        $file_required = [];

        // ラジオボタン、チェックボックス、セレクトメニューの選択状態
        foreach ($post as $key1 => $value1) {
            if (is_array($value1)) {
                foreach ($value1 as $value2) {
                    if (!is_array($value2)) {
                        $checked[$key1][$value2] = 'checked="checked"';
                        $selected[$key1][$value2] = 'selected="selected"';
                    }
                }
            } else {
                $checked[$key1][$value1] = 'checked="checked"';
                $selected[$key1][$value1] = 'selected="selected"';
            }
        }

        // 入力必須チェック
        if (isset($post['required'])) {
            foreach ($post['required'] as $value) {
                if (empty($post[$value])) {
                    $global_errors[] = $required[$value] = $this->tr('error.required', ['key' => $value]);
                }
            }
        }
        // 半角文字チェック
        if (isset($post['singlebyte'])) {
            foreach ($post['singlebyte'] as $value) {
                if (!empty($post[$value])) {
                    $post[$value] = mb_convert_kana($post[$value], 'a');
                    if (strlen($post[$value]) !== mb_strlen($post[$value])) {
                        $global_errors[] = $singlebyte[$value] = $this->tr('error.singlebyte', ['key' => $value]);
                    }
                }
            }
        }
        // 半角英数字チェック
        if (isset($post['alphanumeric'])) {
            foreach ($post['alphanumeric'] as $value) {
                if (!empty($post[$value])) {
                    $post[$value] = mb_convert_kana($post[$value], 'a');
                    if (preg_match('/^[a-zA-Z0-9_]*$/', $post[$value]) !== false) {
                        $global_errors[] = $alphanumeic[$value] = $this->tr('error.alphanumeric', ['key' => $value]);
                    }
                }
            }
        }
        // 半角英字チェック
        if (isset($post['alphbetic'])) {
            foreach ($post['alphbetic'] as $value) {
                if (!empty($post[$value])) {
                    $post[$value] = mb_convert_kana($post[$value], 'r');
                    if (preg_match('/^[a-zA-Z]*$/', $post[$value]) !== false) {
                        $global_errors[] = $alphabetic[$value] = $this->tr('error.alphabetic', ['key' => $value]);
                    }
                }
            }
        }
        // 数字チェック
        if (isset($post['numeric'])) {
            foreach ($post['numeric'] as $value) {
                if (!empty($post[$value])) {
                    $post[$value] = mb_convert_kana($post[$value], 'n');
                    if (preg_match('/\A[0-9]*\z/', $post[$value]) !== false) {
                        $global_errors[] = $numeric[$value] = $this->tr('error.numeric', ['key' => $value]);
                    }
                }
            }
        }

        // 数字とハイフンチェック
        if (isset($post['numeric_hyphen'])) {
            foreach ($post['numeric_hyphen'] as $value) {
                if (!empty(post[$value])) {
                    $post[$value] = mb_convert_kana($this->post[$value], 'a');
                    if (preg_match('/\A[0-9-]*\z/', $post[$value]) !== false) {
                        $global_errors[] = $numeric[$value] = $this->tr('error.numeric_hyphen', ['key' => $value]);
                    }
                }
            }
        }
        
        // ひらがなチェック
        if (isset($post['hiragana'])) {
            foreach ($post['hiragana'] as $value) {
                if (!empty($post[$value])) {
                    $post[$value] = mb_convert_kana($this->post[$value], 'cH');
                    $this->post[$value] = $this->deleteBlank($this->post[$value]);
                    if (!$this->isHiragana($this->post[$value])) {
                        $this->tpl->set("hiragana.$value", $this->h($value . $this->config['error_hiragana']));
                        $this->global_errors[] = $this->h($value . $this->config['error_hiragana']);
                    }
                }
            }
        }
        // 全角カタカナチェック
        if (isset($this->post['zenkaku_katakana'])) {
            foreach ($this->post['zenkaku_katakana'] as $value) {
                $this->tpl->set("zenkaku_katakana.$value", false);
                if (!empty($this->post[$value])) {
                    $this->post[$value] = mb_convert_kana($this->post[$value], 'CK');
                    $this->post[$value] = $this->deleteBlank($this->post[$value]);
                    if (!$this->isZenkakuKatakana($this->post[$value])) {
                        $this->tpl->set(
                            "zenkaku_katakana.$value",
                            $this->h($value . $this->config['error_zenkaku_katakana'])
                        );
                        $this->global_errors[] = ($value . $this->config['error_zenkaku_katakana']);
                    }
                }
            }
        }
        // 全角文字チェック
        if (isset($this->post['zenkaku'])) {
            foreach ($this->post['zenkaku'] as $value) {
                $this->tpl->set("zenkaku.$value", false);
                if (!empty($this->post[$value])) {
                    if (!$this->isZenkaku($this->post[$value])) {
                        $this->tpl->set("zenkaku.$value", $this->h($value . $this->config['error_zenkaku']));
                        $this->global_errors[] = $this->h($value . $this->config['error_zenkaku']);
                    }
                }
            }
        }
        // 全て全角文字チェック
        if (isset($this->post['zenkaku_all'])) {
            foreach ($this->post['zenkaku_all'] as $value) {
                $this->tpl->set("zenkaku_all.$value", false);
                if (!empty($this->post[$value])) {
                    if (!$this->isZenkakuAll($this->post[$value])) {
                        $this->tpl->set(
                            "zenkaku_all.$value",
                            $this->h($value . $this->config['error_zenkaku_all'])
                        );
                        $this->global_errors[] = $this->h($value . $this->config['error_zenkaku_all']);
                    }
                }
            }
        }
        // メールアドレスチェック
        if (isset($this->post['email'])) {
            foreach ($this->post['email'] as $value) {
                $this->tpl->set("email.$value", false);
                if (!empty($this->post[$value])) {
                    $this->post[$value] = mb_convert_kana($this->post[$value], 'a');
                    $this->post[$value] = $this->deleteCrlf($this->post[$value]);
                    if (!$this->isEmail($this->post[$value])) {
                        $this->tpl->set("email.$value", $this->h($value . $this->config['error_email']));
                        $this->global_errors[] = $this->h($value . $this->config['error_email']);
                    }
                }
            }
        }
        // 自動返信メールの宛先（ $this->post[$this->config['auto_reply_email']] ）のメールアドレスチェック
        if (!empty($this->post[$this->config['auto_reply_email']])) {
            $this->post[$this->config['auto_reply_email']] = mb_convert_kana($this->post[$this->config['auto_reply_email']], 'a');
            $this->post[$this->config['auto_reply_email']] = $this->deleteCrlf($this->post[$this->config['auto_reply_email']]);
            if (!$this->isEmail($this->post[$this->config['auto_reply_email']])) {
                $this->tpl->set("email." . $this->config['auto_reply_email'], $this->h($this->config['auto_reply_email'] . $this->config['error_email']));
                if (!in_array($this->h($this->config['auto_reply_email'] . $this->config['error_email']), $this->global_errors, true)) {
                    $this->global_errors[] = $this->h($this->config['auto_reply_email'] . $this->config['error_email']);
                }
            }
        }
        // 一致チェック
        if (isset($this->post['match'])) {
            foreach ($this->post['match'] as $value) {
                $array = preg_split('/\s|,/', $value);
                $this->tpl->set("match.$array[0]", false);
                if ((!empty($this->post[$array[0]]) || !empty($this->post[$array[1]]))
                    && $this->post[$array[0]] != $this->post[$array[1]]
                ) {
                    $this->tpl->set("match.$array[0]", $this->h($array[0] . $this->config['error_match']));
                    $this->global_errors[] = $this->h($array[0] . $this->config['error_match']);
                }
            }
        }
        // 文字数チェック
        if (isset($this->post['len'])) {
            foreach ($this->post['len'] as $value) {
                $array = preg_split('/\s|,/', $value);
                $delim = explode('-', $array[1]);
                $delim = array_map('intval', $delim);
                $this->tpl->set("len.$array[0]", false);
                if (!empty($this->post[$array[0]]) && !$this->isAllowLen($this->post[$array[0]], $delim)) {
                    if (empty($delim[0])) {
                        $error_len = str_replace('{文字数}', "$delim[1]文字以下", $this->config['error_len']);
                    } elseif (empty($delim[1])) {
                        $error_len = str_replace('{文字数}', "$delim[0]文字以上", $this->config['error_len']);
                    } else {
                        if ($delim[0] === $delim[1]) {
                            $error_len = str_replace('{文字数}', "$delim[0]文字", $this->config['error_len']);
                        } else {
                            $error_len = str_replace('{文字数}', "$delim[0]〜$delim[1]文字", $this->config['error_len']);
                        }
                    }
                    $this->tpl->set("len.$array[0]", $this->h($array[0] . $error_len));
                    $this->global_errors[] = $this->h($array[0] . $error_len);
                }
            }
        }
        // URL チェック
        if (isset($this->post['url'])) {
            foreach ($this->post['url'] as $value) {
                $this->tpl->set("url.$value", false);
                if (!empty($this->post[$value])) {
                    $this->post[$value] = mb_convert_kana($this->post[$value], 'a');
                    $this->post[$value] = $this->deleteCrlf($this->post[$value]);
                    if (!$this->isUrl($this->post[$value])) {
                        $this->tpl->set("url.$value", $this->h($value . $this->config['error_url']));
                        $this->global_errors[] = $this->h($value . $this->config['error_url']);
                    }
                }
            }
        }
        // 整数範囲チェック
        if (isset($this->post['num_range'])) {
            foreach ($this->post['num_range'] as $value) {
                $array = preg_split('/\s|,/', $value);
                $delim = explode('-', $array[1]);
                $delim = array_map('intval', $delim);
                $this->tpl->set("num_range.$array[0]", false);
                if ($this->post[$array[0]] !== '') {
                    // 数字チェック
                    $this->post[$array[0]] = mb_convert_kana($this->post[$array[0]], 'n');
                    if (!$this->isNum($this->post[$array[0]])) {
                        $this->tpl->set("num_range.$array[0]", $this->h($array[0] . $this->config['error_num']));
                        $this->global_errors[] = $this->h($array[0] . $this->config['error_num']);
                    } else {
                        if (!$this->isAllowNumRange($this->post[$array[0]], $delim)) {
                            if ($delim[0] === $delim[1]) {
                                $error_num_range = str_replace(
                                    '{範囲}',
                                    "ちょうど{$delim[0]}",
                                    $this->config['error_num_range']
                                );
                            } else {
                                if ($delim[1] === 0) {
                                    $error_num_range = str_replace(
                                        '{範囲}',
                                        "{$delim[0]}以上",
                                        $this->config['error_num_range']
                                    );
                                } else {
                                    $error_num_range = str_replace(
                                        '{範囲}',
                                        "{$delim[0]}以上、{$delim[1]}以下",
                                        $this->config['error_num_range']
                                    );
                                }
                            }
                            $this->tpl->set("num_range.$array[0]", $this->h($array[0] . $error_num_range));
                            $this->global_errors[] = $this->h($array[0] . $error_num_range);
                        }
                    }
                }
            }
        }
        // ファイル添付を利用する場合
        if ($this->config['file']) {
            // ファイルの削除
            if (isset($this->post['file_remove'])) {
                foreach ($this->post['file_remove'] as $value) {
                    $tmp_name = $this->post['file'][$value]['tmp_name'];
                    $file_path = $this->config['tmp_dir'] . basename($tmp_name);
                    if (is_file($file_path) && unlink($file_path)) {
                        $this->post['file'][$value]['tmp_name'] = '';
                        $this->post['file'][$value]['name'] = '';
                    } else {
                        $this->global_errors[] = $this->h($tmp_name . $this->config['error_file_remove']);
                    }
                }
            }
            // 既にファイルがアップロードされている場合
            if (isset($this->post['file'])) {
                foreach ($this->post['file'] as $key => $value) {
                    if (isset($value['tmp_name'])) {
                        // single の場合
                        if (is_file($this->config['tmp_dir'] . basename($value['tmp_name']))) {
                            $this->tpl->set("$key.tmp_name", $this->h($value['tmp_name']));
                            $this->tpl->set("$key.name", $this->h($value['name']));
                            $this->files[$key] = array(
                                'tmp_name' => $this->h($value['tmp_name']),
                                'name' => $this->h($value['name'])
                            );
                        }
                    }
                }
            }
            // ファイルの入力必須チェック
            if (isset($this->post['file_required'])) {
                foreach ($this->post['file_required'] as $value) {
                    $this->tpl->set("file_required.$value", false);
                    if (empty($_FILES[$value]['tmp_name']) && empty($this->post['file'][$value]['tmp_name'])) {
                        $this->tpl->set(
                            "file_required.$value",
                            $this->h($value . $this->config['error_file_required'])
                        );
                        $this->global_errors[] = $this->h($value . $this->config['error_file_required']);
                    }
                }
            }
            // ファイルのアップロード
            if (isset($_FILES)) {
                foreach ($_FILES as $key => $value) {
                    $file_error = array();
                    $this->tpl->set("file.$key", false);
                    if (!is_array($value['tmp_name'])) {
                        // single の場合
                        if (!empty($value['tmp_name'])) {
                            // 拡張子のチェック
                            if (!empty($this->config['file_allow_extension']) &&
                                !$this->isAllowFileExtension($value['name'])) {
                                $file_error[] = $this->h($key . $this->config['error_file_extension']);
                                $this->global_errors[] = $this->h($key . $this->config['error_file_extension']);
                            }
                            // 空ファイルのチェック
                            if ($value['size'] === 0) {
                                $file_error[] = $this->h($key . $this->config['error_file_empty']);
                                $this->global_errors[] = $this->h($key . $this->config['error_file_empty']);
                            }
                            // ファイルサイズのチェック
                            if ($value['size'] > $this->config['file_max_size']) {
                                $file_error[] = $this->h($key . str_replace(
                                    '{ファイルサイズ}',
                                    $this->getFormatedBytes($this->config['file_max_size']),
                                    $this->config['error_file_max_size']
                                ));
                                $this->global_errors[] = $this->h($key . str_replace(
                                    '{ファイルサイズ}',
                                    $this->getFormatedBytes($this->config['file_max_size']),
                                    $this->config['error_file_max_size']
                                ));
                            }
                            // エラーを判別
                            if (count($file_error) > 0) {
                                // エラーがある場合、エラーメッセージをセット
                                $this->tpl->set("file.$key", $file_error);
                            } else {
                                // エラーが無い場合、ファイルを$config['tmp_dir']に移動
                                $tmp_name = $this->config['file_name_prefix'] . uniqid(rand()) .
                                    '_' . $value['name'];
                                $file_path = $this->config['tmp_dir'] . $tmp_name;
                                if (move_uploaded_file($value['tmp_name'], $file_path)) {
                                    $this->tpl->set("$key.tmp_name", $this->h($tmp_name));
                                    $this->tpl->set("$key.name", $this->h($value['name']));
                                    $this->files[$key] = array(
                                        'tmp_name' => $this->h($tmp_name),
                                        'name' => $this->h($value['name'])
                                    );
                                } else {
                                    // アップロードに失敗した場合
                                    $file_error[] = $this->h($key . $this->config['error_file_upload']);
                                    $this->global_errors[] = $this->h($key . $this->config['error_file_upload']);
                                    $this->tpl->set("file.$key", $file_error);
                                }
                            }
                        }
                    }
                }
            }
        }
        */
        return [
            'checked'           => $checked,
            'selected'          => $selected,
            'global_errors'     => $global_errors,
            'required'          => $required,
            'singlebyte'        => $singlebyte,
            'alphanumeric'      => $alphanumeric,
            'alphabetic'        => $alphabetic,
            'numeric'           => $numeric,
            'numeric_hyphen'    => $numeric_hyphen,
            'hiragana'          => $hiragana,
            'katakana'          => $katakana,
            'contain_multibyte' => $contain_multibyte,
            'multibyte'         => $multibyte,
            'email'             => $email,
            'match'             => $match,
            'len'               => $len,
            'url'               => $url,
            'num_range'         => $num_range,
            'file'              => $file,
            'file_remove'       => $file_remove,
            'file_required'     => $file_required,
        ];
    }

    public function confirm(Request $request, Response $response)
    {
        $name = $request->getAttribute('name');

        return $this->app->view->render($response, 'confirm', [
            'name' => $name,
        ]);
    }

    public function finish(Request $request, Response $response)
    {
        return $this->app->view->render($response, 'finish', []);
    }
}
