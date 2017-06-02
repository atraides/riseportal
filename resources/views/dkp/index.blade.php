<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Rise Legacy Points</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #121212;
                color: #eaeaea;
                font-family: 'Verdana', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

	    .class_0 { text-decoration:none;color:#000 !important }
	    .class_1 { text-decoration:none;color:#c41f3b !important }
	    .class_2 {text-decoration:none;color:#ff7d0a !important}
	    .class_3 {text-decoration:none;color:#abd473 !important}
	    .class_4 {text-decoration:none;color:#69ccf0 !important}
	    .class_5 {text-decoration:none;color:#f58cba !important}
	    .class_6 {text-decoration:none;color:#fff !important}
	    .class_7 {text-decoration:none;color:#fff569 !important}
	    .class_8 {text-decoration:none;color:#0070de !important}
	    .class_9 {text-decoration:none;color:#9482c9 !important}
	    .class_10 {text-decoration:none;color:#c79c6e !important}
	    .class_11 {text-decoration:none;color:#00ff96 !important}
	    .class_12 {text-decoration:none;color:#a330c9 !important}
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="m-b-md">
			<table>
				<tr>
					<th>Name</td>
					<th>RLP</td>
				</tr>
			@foreach ($dkp as $member)
				<tr>
					<td class='class_{{ $member['class'] }}'>{{ $member['name'] }}</td>
					<td>{{ $member['current'] }}</td>
				</tr>
			@endforeach
			</table>
                </div>
            </div>
        </div>
    </body>
</html>
