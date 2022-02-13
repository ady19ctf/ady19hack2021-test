<html>
  <head>
    <title>vote check</title>
  </head>
  <body>
    <h1>Vote Check</h1>

    <div>{{$user_name}}に投票します。よろしいですか？</div>
  </body>
  <form action="/vote-result" method="post">
        @csrf
        <button class="btn btn-primary" name="candidate" value={{$user_id}} type="submit">Yes</button>
  </form>
  <form action="/vote" method="get">
        @csrf
        <button class="btn btn-primary" type="submit">No</button>
  </form>

  <a href="/home">Return to home.</a></br>
</html>
