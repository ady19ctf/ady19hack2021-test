
<html>
  <head>
    <title>vote test</title>
  </head>
  <body>
    <h1>Vote for one candidate.</h1>
    <div>

        <form action="/vote-check" method="post">
            @csrf
            <button class="btn btn-primary" name="candidate" value="candidate A" type="submit">candidate A</button>
        </form>
        <form action="/vote-check" method="post">
            @csrf
            <button class="btn btn-primary" name="candidate" value="candidate B" type="submit">candidate B</button>
        </form>
        <form action="/vote-check" method="post">
            @csrf
            <button class="btn btn-primary" name="candidate" value="candidate C" type="submit">candidate C</button>
        </form>
    </div>
  </body>
  <a href="/home">Return to home.</a></br>
</html>
