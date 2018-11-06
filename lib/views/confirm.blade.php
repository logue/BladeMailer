{{--確認画面--}}
@extends('layout')

@section('title', '入力確認')

@section('content')
<section>
    <h2>入力内容の確認</h2>
    <p>以下の内容でよろしければ、ページ下部の送信ボタンを押してください。<br />
        誤りがある場合は、前画面に戻って再度ご入力ください。</p>
    <table class="table">
        <thead>
            <tr>
                <th>項目</th>
                <th>値</th>
            </tr>
        </thead>
        @foreach($params as $key=>$value)
        <tr>
            <th>{{ $key }}</th>
            <td>{{ nl2br($value) }}</td>
        </tr>
        @endforeach
        @foreach($files as $key=>$value)
        <tr>
            <th>{{ $key }}</th>
            <td>{$files[].name}<br>
                <img src="index.php?file={$files[].tmp_name}" width="300"><br>
                <a href="index.php?file={$files[].tmp_name}" target="_blank" class="external">画像を別ウィンドウで開く</a></td>
        </tr>
        @endforeach
    </table>
    <div class="row">
        <form class="col-md">
            <input type="hidden" name="page" value="finish" />
            <button type="submit" class="btn btn-block btn-primary">送信する</button>
        </form>
        <form class="col-md">
            <input type="hidden" name="page" value="input" />
            <button type="reset" class="btn btn-block btn-secondary">入力画面に戻る</button>
        </form>
    </div>
</section>