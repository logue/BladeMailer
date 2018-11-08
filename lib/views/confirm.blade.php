{{--確認画面--}}
@extends('layout')

@section('title', '入力確認')

@section('content')
<section>
    <h2>{{ $tr('messages.confirm') }}</h2>
    <p>{{ $tr('messages.confirm_message') }}</p>
    <table class="table">
        <thead>
            <tr>
                <th>{{ $tr('messages.key') }}</th>
                <th>{{ $tr('messages.value') }}</th>
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
                <a href="index.php?file={$files[].tmp_name}" target="_blank" class="external">{{ $tr('messages.check_file') }}</a></td>
        </tr>
        @endforeach
    </table>
    <div class="row">
        <form class="col-md" action="./">
            <input type="hidden" name="page" value="finish" />
            <button type="submit" class="btn btn-block btn-primary">{{ $tr('messages.button_post') }}</button>
        </form>
        <form class="col-md" action="./">
            <input type="hidden" name="page" value="input" />
            <button type="submit" class="btn btn-block btn-secondary">{{ $tr('messages.button_back') }}</button>
        </form>
    </div>
</section>