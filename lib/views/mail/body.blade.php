お問い合わせフォームよりメールが送信されました。

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
@foreach($params as $key=>$value)
■{{ $key }}：
{{ $value }}
@endforeach

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

IP: {{ $_SERVER['REMOTE_ADDR'] }}
HOST: {{ $_SERVER['REMOTE_HOST'] }}
USER_AGENT: {{$_SERVER['HTTP_USER_AGENT'] }}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━