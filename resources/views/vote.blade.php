
<html>
  <head>
    <title>vote test</title>
  </head>
  <body>
    <h1>Vote for one candidate.</h1>
    <div>
        <form action="/vote-result" method="post">
            @csrf
            <button class="btn btn-primary" name="vote_for_a" type="submit">candidate A</button>
        </form>
        <form action="/vote-result" method="post">
            @csrf
            <button class="btn btn-primary" name="vote_for_b" type="submit">candidate B</button>
        </form>
        <form action="/vote-result" method="post">
            @csrf
            <button class="btn btn-primary" name="vote_for_c" type="submit">candidate C</button>
        </form>
    </div>
  </body>
</html>
