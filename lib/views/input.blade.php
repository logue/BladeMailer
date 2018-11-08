{{--入力フォーム--}}
@extends('layout')

@section('title', 'メール送信フォーム')

@section('content')

<h1 class="border-bottom">メールフォーム</h1>
<p>{{ $tr('messages.welcome') }}</p>

@if(isset($global_errors) && !count($global_errors) === 0 )
<div class="alert alert-warning">
    <p>{{ $tr('messages.error') }}</p>
    <ul>
        @foreach($global_errors as $error) 
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form method="post" action="./" enctype="multipart/form-data" novalidate="novalidate" {{ isset($global_errors) ?? 'class="was-validated"' }}>
    <section>
        <h2>フォームパーツサンプル</h2>
        <div class="form-group">
            <label for="inputSingleLine">シングルラインインプット</label>
            <input type="text" name="シングルラインインプット" value="{{ $value['シングルラインインプット'] ?? '' }}" class="form-control" id="inputSingleLine" placeholder="シングルラインインプット" />
        </div>
        <div class="form-group">
            <label for="inputMultiLine">マルチラインインプット</label>
            <textarea rows="6" name="マルチラインインプット" class="form-control" id="inputMultiLine" placeholder="マルチラインインプット">{{ $value['マルチラインインプット'] ?? '' }}</textarea>
        </div>
        <fieldset class="form-group">
            <legend class="col-form-label">ラジオボタン</legend>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="radio1" name="ラジオボタン" class="custom-control-input" value="項目１" {{ $checked['ラジオボタン']['項目１'] ?? '' }} />
                <label class="custom-control-label" for="radio1">項目１</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="radio2" name="ラジオボタン" class="custom-control-input" value="項目２" {{ $checked['ラジオボタン']['項目２'] ?? '' }} />
                <label class="custom-control-label" for="radio2">項目２</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="radio3" name="ラジオボタン" class="custom-control-input" value="項目３" {{ $checked['ラジオボタン']['項目３'] ?? '' }} />
                <label class="custom-control-label" for="radio3">項目３</label>
            </div>
        </fieldset>
        <fieldset class="form-group">
            <legend class="col-form-label">チェックボックス</legend>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="check1" class="custom-control-input" name="チェックボックス[]" value="項目１" {{ $checked['チェックボックス']['項目１'] ?? '' }} />
                <label class="custom-control-label" for="check1">項目１</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="check2" class="custom-control-input" name="チェックボックス[]" value="項目２" {{ $checked['チェックボックス']['項目２'] ?? '' }} />
                <label class="custom-control-label" for="check2">項目２</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="check3" class="custom-control-input" name="チェックボックス[]" value="項目３" {{ $checked['チェックボックス']['項目３'] ?? '' }} />
                <label class="custom-control-label" for="check3">項目３</label>
            </div>
        </fieldset>
        <div class="form-group">
            <label for="selectMenu">セレクトメニュー</label>
            <select class="form-control" id="selectMenu" name="セレクトメニュー">
                <option value="項目１" {{ $selected['セレクトメニュー']['項目１'] ?? '' }}>項目１</option>
                <option value="項目２" {{ $selected['セレクトメニュー']['項目２'] ?? '' }}>項目２</option>
                <option value="項目３" {{ $selected['セレクトメニュー']['項目３'] ?? '' }}>項目３</option>
            </select>
        </div>
        <div class="form-group">
            <label for="multiSelectMenu">マルチプルセレクトメニュー</label>
            <select class="form-control" id="multiSelectMenu" name="マルチセレクトメニュー[]" multiple="multiple">
                <option value="項目１" {{ $selected['マルチセレクトメニュー']['項目１'] ?? '' }}>項目１</option>
                <option value="項目２" {{ $selected['マルチセレクトメニュー']['項目２'] ?? '' }}>項目２</option>
                <option value="項目３" {{ $selected['マルチセレクトメニュー']['項目３'] ?? '' }}>項目３</option>
            </select>
        </div>
        <fieldset class="form-group">
            <legend class="col-form-label">ファイル１</legend>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="file1" name="ファイル１" accept=".jpg,.gif,.png,image/gif,image/jpeg,image/png">
                <label class="custom-file-label text-truncate" for="file1">500KB以下のGIF、JPG、PNG</label>
            </div>
            @if(isset($value['ファイル１']))
            <input type="hidden" name="file[ファイル１][tmp_name]" value="{{ $value['ファイル１']['tmp_name'] ?? '' }}" />
            <input type="hidden" name="file[ファイル１][name]" value="{{ $value['ファイル１']['name'] ?? '' }}" />
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="delFile1" class="custom-control-input" name="file_remove[]" value="ファイル１" />
                <label class="custom-control-label" for="delFile1">{{ $tr('messages.delete_file') }}</label>
            </div>
            <p>
                <img src="index.php?file={{ $value['ファイル１']['tmp_name'] }}" alt="{{ $value['ファイル１']['name'] }}" class="img-fluid" />
                <br /><a href="index.php?file={{ $value['ファイル１']['tmp_name'] }}" target="_blank" class="external">{{ $tr('messages.check_file') }}</a>
            </p>
            @endif
            @if(isset($file['ファイル１']))
            <div class="invalid-feedback">
                <ul>
                @foreach($file['ファイル１'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif
        </fieldset>
        <fieldset class="form-group">
            <legend class="col-form-label">ファイル２</legend>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="file2" name="ファイル２" accept=".jpg,.gif,.png,image/gif,image/jpeg,image/png">
                <label class="custom-file-label text-truncate" for="file2">500KB以下のGIF、JPG、PNG</label>
            </div>
            @if(isset($value['ファイル２']))
            <input type="hidden" name="file[ファイル２][tmp_name]" value="{{ $value['ファイル２']['tmp_name'] ?? '' }}" />
            <input type="hidden" name="file[ファイル２][name]" value="{{ $value['ファイル２']['name'] ?? '' }}" />
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="delFile2" class="custom-control-input" name="file_remove[]" value="ファイル２" />
                <label class="custom-control-label" for="delFile2">{{ $tr('messages.delete_file') }}</label>
            </div>
            <p>
                <img src="index.php?file={{ $value['ファイル２']['tmp_name'] }}" alt="{{ $value['ファイル２']['name'] }}" class="img-fluid" />
                <br /><a href="index.php?file={{ $value['ファイル２']['tmp_name'] }}" target="_blank" class="external">{{ $tr('messages.check_file') }}</a>
            </p>
            @endif
            @if(isset($file['ファイル２']))
            <div class="invalid-feedback">
                <ul>
                @foreach($file['ファイル２'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif
        </fieldset>
    </section>
    
    <section>
        <h2>入力オプション</h2>
        <div class="form-group">
            <label for="inputRequired">入力必須</label>
            <input type="text" name="入力必須" value="{{ $value['入力必須'] ?? '' }}" class="form-control {{ isset($required['入力必須']) ? 'is-invalid' : '' }}" id="inputRequired" aria-describedby="inputRequiredBlock" placeholder="入力必須" required="required" />
            <input type="hidden" name="required[]" value="入力必須" />
            <small id="inputRequiredBlock" class="form-text text-muted">必須入力のフォームです。</small>
            @if(isset($required['入力必須']))
            <div class="invalid-feedback">{{ $required['入力必須'] }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputMail">メールアドレス</label>
            <input type="email" name="メールアドレス" value="{{ $value['メールアドレス'] ?? '' }}" class="form-control {{ isset($email['メールアドレス']) ? 'is-invalid' : '' }}" id="inputMail" placeholder="メールアドレス" required="required" />
            <input type="hidden" name="email[]" value="メールアドレス" />
            @if(isset($email['メールアドレス']))
            <div class="invalid-feedback">{{ $email['メールアドレス'] }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputSinglebyte">半角文字</label>
            <input type="text" name="半角文字" value="{{ $value['半角文字'] ?? '' }}" class="form-control {{ isset($singlebyte['半角文字']) ? 'is-invalid' : '' }}" id="inputSinglebyte" placeholder="半角文字" />
            <input type="hidden" name="singlebyte[]" value="半角文字" />
            @if(isset($singlebyte['半角文字']))
            <div class="invalid-feedback">{{ $singlebyte['半角文字'] }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputAlphaNumeric">半角英数字</label>
            <input type="text" name="半角英数字" value="{{ $value['半角英数字'] ?? '' }}" class="form-control {{ isset($alphanumeric['半角英数字']) ? 'is-invalid' : '' }}" id="inputAlphaNumeric" placeholder="半角英数字"  />
            <input type="hidden" name="alphanumeric[]" value="半角英数字" />
            @if(isset($alphanumeric['半角英数字']))
            <div class="invalid-feedback">{{ $alphanumeric['半角英数字'] }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputAlphabetic">半角英字</label>
            <input type="text" name="半角英字" value="{{ $value['半角英字'] ?? '' }}" class="form-control {{ isset($alphabetic['半角英字']) ? 'is-invalid' : '' }}" id="inputAlphabetic" placeholder="半角英字"  />
            <input type="hidden" name="alphabetic[]" value="半角英字" />
            @if(isset($alphabetic['半角英字']))
            <div class="invalid-feedback">{{ $alphabetic['半角英字'] }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputNumeric">数字</label>
            <input type="text" name="数字" value="{{ $value['数字'] ?? '' }}" class="form-control {{ isset($numeric['数字']) ? 'is-invalid' : '' }}" id="inputNumeric" placeholder="数字"  />
            <input type="hidden" name="numeric[]" value="数字" />
            @if(isset($numeric['数字']))
            <div class="invalid-feedback">{{ $numeric['数字'] }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputNumericHyphen">数字＋ハイフン</label>
            <input type="text" name="数字＋ハイフン" value="{{ $value['数字＋ハイフン'] ?? '' }}" class="form-control {{ isset($numeric_hyphen['数字＋ハイフン']) ? 'is-invalid' : '' }}" id="inputNumericHyphen" placeholder="数字＋ハイフン"  />
            <input type="hidden" name="numeric_hyphen[]" value="数字＋ハイフン" />
            @if(isset($numeric_hyphen['数字＋ハイフン']))
            <div class="invalid-feedback">{{ $numeric_hyphen['数字＋ハイフン'] }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputHiragana">ひらがな</label>
            <input type="text" name="ひらがな" value="{{ $value['ひらがな'] ?? '' }}" class="form-control {{ isset($hiragana['ひらがな']) ? 'is-invalid' : '' }}" id="inputHiragana" placeholder="ひらがな"  />
            <input type="hidden" name="hiragana[]" value="ひらがな" />
            @if(isset($hiragana['ひらがな']))
            <div class="invalid-feedback">{{ $hiragana['ひらがな'] }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputKatakana">全角カタカナ</label>
            <input type="text" name="全角カタカナ" value="{{ $value['全角カタカナ'] ?? '' }}" class="form-control {{ isset($katakana['全角カタカナ']) ? 'is-invalid' : '' }}" id="inputKatakana" placeholder="全角カタカナ"  />
            <input type="hidden" name="katakana[]" value="全角カタカナ" />
            @if(isset($katakana['全角カタカナ']))
            <div class="invalid-feedback">{{ $katakana['全角カタカナ'] }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputContainMultibyte">全角文字を含むか</label>
            <input type="text" name="全角文字を含むか" value="{{ $value['全角文字を含むか'] ?? '' }}" class="form-control {{ isset($contain_multibyte['全角文字を含むか']) ? 'is-invalid' : '' }}" id="inputContainMultibyte" placeholder="全角文字を含むか"  />
            <input type="hidden" name="contain_multibyte[]" value="全角文字を含むか" />
            @if(isset($contain_multibyte['全角文字を含むか']))
            <div class="invalid-feedback">{{ $contain_multibyte['全角文字を含むか'] }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputMultibyte">全て全角文字</label>
            <input type="text" name="全て全角文字" value="{{ $value['全て全角文字'] ?? '' }}" class="form-control {{ isset($multibyte['全て全角文字']) ? 'is-invalid' : '' }}" id="inputContainMultibyte" placeholder="全て全角文字"  />
            <input type="hidden" name="multibyte[]" value="全て全角文字" />
            @if(isset($multibyte['全て全角文字']))
            <div class="invalid-feedback">{{ $multibyte['全て全角文字'] }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputLenMore3">3文字以上</label>
            <input type="text" name="3文字以上" value="{{ $value['3文字以上'] ?? '' }}" class="form-control {{ isset($len['3文字以上']) ? 'is-invalid' : '' }}" id="inputLenMore3" placeholder="3文字以上"  />
            <input type="hidden" name="len[]" value="3文字以上 3-" />
            @if(isset($len['3文字以上']))
            <div class="invalid-feedback">{{ $len['3文字以上'] }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputLenLess3">3文字以下</label>
            <input type="text" name="3文字以下" value="{{ $value['3文字以下'] ?? '' }}" class="form-control {{ isset($len['3文字以下']) ? 'is-invalid' : '' }}" id="inputLenLess3" placeholder="3文字以下"  />
            <input type="hidden" name="len[]" value="3文字以下 -3" />
            @if(isset($len['3文字以下']))
            <div class="invalid-feedback">{{ $len['3文字以下'] }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputLen3">3文字固定</label>
            <input type="text" name="3文字固定" value="{{ $value['3文字固定'] ?? '' }}" class="form-control {{ isset($len['3文字固定']) ? 'is-invalid' : '' }}" id="inputLen3" placeholder="3文字固定"  />
            <input type="hidden" name="len[]" value="3文字固定 3-3" />
            @if(isset($len['3文字固定']))
            <div class="invalid-feedback">{{ $len['3文字固定'] }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputLen6to8">6文字以上8文字以下</label>
            <input type="text" name="6文字以上8文字以下" value="{{ $value['6文字以上8文字以下'] ?? '' }}" class="form-control {{ isset($len['6文字以上8文字以下']) ? 'is-invalid' : '' }}" id="inputLen6to8" placeholder="6文字以上8文字以下"  />
            <input type="hidden" name="len[]" value="6文字以上8文字以下 6-8" />
            @if(isset($len['6文字以上8文字以下']))
            <div class="invalid-feedback">{{ $len['6文字以上8文字以下'] }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputLen6to8">6文字以上8文字以下</label>
            <input type="text" name="6文字以上8文字以下" value="{{ $value['6文字以上8文字以下'] ?? '' }}" class="form-control {{ isset($len['6文字以上8文字以下']) ? 'is-invalid' : '' }}" id="inputLen6to8" placeholder="6文字以上8文字以下"  />
            <input type="hidden" name="len[]" value="6文字以上8文字以下 6-8" />
            @if(isset($len['6文字以上8文字以下']))
            <div class="invalid-feedback">{{ $len['6文字以上8文字以下'] }}</div>
            @endif
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputMatch1">一致1</label>
                <input type="text" name="一致1" class="form-control {{ isset($match['一致1']) ? 'is-invalid' : '' }}" value="{{ $value['一致1'] ?? '' }}" id="inputMatch1" placeholder="一致1" />
            </div>
            <div class="form-group col-md-6">
                <label for="inputMatch2">一致2</label>
                <input type="text" name="一致2" class="form-control {{ isset($match['一致1']) ? 'is-invalid' : '' }}" value="{{ $value['一致2'] ?? '' }}" id="inputMatch2" placeholder="一致2" />
            </div>
            <input type="hidden" name="match[]" value="一致1 一致2" />
            @if(isset($match['一致1']))
            <div class="invalid-feedback">{{ $match['一致1'] }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputUrl">URL</label>
            <input type="url" name="url" value="{{ $value['url'] ?? '' }}" class="form-control {{ isset($url['url']) ? 'is-invalid' : '' }}" id="inputUrl" placeholder="https://" />
            <input type="hidden" name="url[]" value="url" />
            @if(isset($url['url']))
            <div class="invalid-feedback">{{ $url['url'] }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputRangeLess3">3以下の数字</label>
            <input type="number" name="3以下の数字" value="{{ $value['3以下の数字'] ?? '' }}" class="form-control {{ isset($range['3以下の数字']) ? 'is-invalid' : '' }}" id="inputRangeLess3" placeholder="3以下の数字"  />
            <input type="hidden" name="range[]" value="3以下の数字 -3" />
            @if(isset($range['3以下の数字']))
            <div class="invalid-feedback">{{ $range['3以下の数字'] }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputRangeMore3">3以上の数字</label>
            <input type="number" name="3以上の数字" value="{{ $value['3以上の数字'] ?? '' }}" class="form-control {{ isset($range['3以上の数字']) ? 'is-invalid' : '' }}" id="inputRangeMore3" placeholder="3以上の数字"  />
            <input type="hidden" name="range[]" value="3以上の数字 3-" />
            @if(isset($range['3以上の数字']))
            <div class="invalid-feedback">{{ $range['3以上の数字'] }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputRangeEq3">ちょうど3の数字</label>
            <input type="number" name="ちょうど3の数字" value="{{ $value['ちょうど3の数字'] ?? '' }}" class="form-control {{ isset($range['ちょうど3の数字']) ? 'is-invalid' : '' }}" id="inputRangeEq3" placeholder="ちょうど3の数字"  />
            <input type="hidden" name="range[]" value="ちょうど3の数字 3-3" />
            @if(isset($range['ちょうど3の数字']))
            <div class="invalid-feedback">{{ $range['ちょうど3の数字'] }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputRangeEq3">1～12の数字</label>
            <div class="form-row">
                <input type="range" name="1～12の数字" value="{{ $value['1～12の数字'] ?? '1' }}" min="1" max="12" class="col-11 custom-range {{ isset($range['1～12の数字']) ? 'is-invalid' : '' }}" id="inputRangeEq3" placeholder="1～12の数字"  />
                <span class="col mx-auto">1</span>
            </div>
            <input type="hidden" name="range[]" value="1～12の数字 1-12" />
            @if(isset($range['1～12の数字']))
            <div class="invalid-feedback">{{ $range['1～12の数字'] }}</div>
            @endif
        </div>
        <fieldset class="form-group">
            <legend class="col-form-label">ファイルの入力必須</legend>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="fileRequired" name="ファイルの入力必須" accept=".jpg,.gif,.png,image/gif,image/jpeg,image/png" />
                <label class="custom-file-label text-truncate" for="fileRequired">500KB以下のGIF、JPG、PNG</label>
            </div>
            <input type="hidden" name="file_required[]" value="ファイルの入力必須" />
            @if(isset($value['ファイルの入力必須']))
            <input type="hidden" name="file[ファイルの入力必須][tmp_name]" value="{{ $value['ファイルの入力必須']['tmp_name'] ?? '' }}" />
            <input type="hidden" name="file[ファイルの入力必須][name]" value="{{ $value['ファイルの入力必須']['name'] ?? '' }}" />
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="delFileRequired" class="custom-control-input" name="file_remove[]" value="ファイルの入力必須" />
                <label class="custom-control-label" for="delFileRequired">{{ $tr('messages.delete_file') }}</label>
            </div>
            <p>
                <img src="index.php?file={{ $value['ファイルの入力必須']['tmp_name'] }}" alt="{{ $value['ファイルの入力必須']['name'] }}" class="img-fluid" />
                <br /><a href="index.php?file={{ $value['ファイルの入力必須']['tmp_name'] }}" target="_blank" class="external">{{ $tr('messages.check_file') }}く</a>
            </p>
            @endif
            @if(isset($file['ファイルの入力必須']) || isset($file_required['ファイルの入力必須']) )
            <div class="invalid-feedback">
                <ul>
                @if(isset($file_required['ファイルの入力必須']))
                    <li>{{ $file_required['ファイルの入力必須'] }}</li>
                @endif
                @if(isset($file['ファイルの入力必須']))
                @foreach($file['ファイルの入力必須'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
                @endif
                </ul>
            </div>
            @endif
        </fieldset>
    </section>

    <section>
        <h2>入力オプションを複数組み合わせるサンプル</h2>
        <p>郵便番号として、「数字とハイフンを含む8文字」をチェックする。</p>
        <div class="form-group">
            <label for="inputZip">郵便番号</label>
            <input type="text" name="郵便番号" value="{{ $value['郵便番号'] ?? '' }}" class="form-control" id="inputZip" placeholder="nnn-nn"  />
            <input type="hidden" name="len[]" value="郵便番号 8" />
            <input type="hidden" name="numeric_hyphen[]" value="郵便番号" />
            @if(isset($len['郵便番号']))
            <div class="invalid-feedback">{{ $range['ちょうど3の数字'] }}</div>
            @endif
            @if(isset($numeric_hyphen['郵便番号']))
            <div class="invalid-feedback">{{ $numeric_hyphen['郵便番号'] }}</div>
            @endif
        </div>
    </section>

    <div class="row">
        <div class="col-md">
            <button type="submit" class="btn btn-block btn-primary">{{ $tr('messages.button_confirm') }}</button>
        </div>
        <div class="col-md">
            <button type="reset" class="btn btn-block btn-secondary">{{ $tr('messages.button_reset') }}</button>
        </div>
    </div>
</form>
@endsection