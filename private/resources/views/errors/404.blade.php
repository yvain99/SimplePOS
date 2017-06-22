<!DOCTYPE html>
<html>
    <head>
        <title>Page Not Found</title>

        <link rel="SHORTCUT ICON" href="{{ asset('img/title.ico') }}" />

        <style>

            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #333;
                display: table;
                font-weight: 500;
                font-family: helvetica, calibri, sans-serif;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Are You Lost?</div>
                click <a href="{{ URL('') }}">here</a> to back to home.
            </div>
        </div>
    </body>
</html>
