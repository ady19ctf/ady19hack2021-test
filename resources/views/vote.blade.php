
<html>
  <head>
    <title>vote test</title>
  </head>
  <body>
    <h1>Vote for one candidate.</h1>
    <div>
      <dev>
          @foreach($candidate_data_with_realname as $candidate_data)
            <form action="/vote-check" method="post">
            @csrf
            <button class="btn btn-primary" name="candidate" value="{{$candidate_data['name']}},{{$candidate_data['real_name']}}" type="submit">{{$candidate_data['real_name']}}</button>
            </form>
          @endforeach
      </dev>
  </body>
  <a href="/home">Return to home.</a></br>
</html>
