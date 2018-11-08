{{--全体のレイアウト--}}
<!doctype html>
<html lang="ja">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha256-eSi1q2PG6J7g7ib17yAaWMcrr5GrtohYChqibrV7PBE=" crossorigin="anonymous" />
        <title>@yield('title')</title>
        <style>
            :lang(ja) .custom-file-label::after {
                content: "ファイルを選択";
            }
        </style>
    </head>
    <body>
        <main class="container">
@yield('content')
        </main>
        <hr />
        <footer>
            <p class="text-center">Blade✉Mailer</p>
        </footer>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.slim.min.js" integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js" integrity="sha256-E/V4cWE4qvAeO5MOhjtGtqDzPndRO1LBk8lJ/PR7CA4=" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function(){
                $('.custom-file-input').on('change', function(){
                    const $label = $(this).next('.custom-file-label');
                    const fileName = $(this).val().split('\\').pop(); 
                    $label.data('default', $label.html());
                    $label.addClass('selected').html(fileName);
                });

                $('.custom-range').on('change', function(){
                    $(this).next().text($(this).val());
                }).on('input', function(){
                    $(this).next().text($(this).val());
                })

                $('form').on('reset', function(){
                    $('.custom-file-input').each(function(){
                        const $label = $(this).next('.custom-file-label');
                        $label.html($label.data('default'));
                    });
                });
            });
        </script>
    </body>
</html>