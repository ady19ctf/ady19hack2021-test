
<html>
  <head>
    <title>vote test</title>
  </head>
  <body>
    <h1>Vote for one candidate.</h1>
    <div>
      <dev>
          @foreach($candidate_data_array as $candidate_data)
            <form action="/vote-check" method="post">
            @csrf
            <button class="btn btn-primary" name="candidate" value={{$candidate_data[0]}} type="submit">{{$candidate_data[0]}}</button>
            </form>
          @endforeach
      </dev>
  </body>
  <a href="/home">Return to home.</a></br>
</html>
