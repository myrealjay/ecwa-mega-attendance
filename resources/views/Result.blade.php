<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Result</title>
</head>

<body>
  <p><b>Hello {{ $name }},</b></p>
  <p>You have successfully completed the quiz <b>{{ $userQuiz->quiz->Title }}</b></p>
  <p>You scored %{{ $userQuiz->score }}</p>
  <p>You answered {{ $breakdown }} questions correctly</p>
</body>

</html>