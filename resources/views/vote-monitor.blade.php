<html>
  <head>
    <title>vote monitor</title>
  </head>
  <body>
    <h1>Voted Users</h1>
    <div>
      <dev>
          Users who completed voting is as follows.<br>
          @foreach($candidate_data_array as $candidate_data)
            {{$candidate_data['user-id']}} | {{$candidate_data['email']}} | {{$candidate_data['address']}} 
            <br>
          @endforeach
      </dev>
  </body>
  <a href="/home">Return to home.</a></br>
</html>
