
## About SCULD

Sculd is a web app for blockchain-based electronic voting system.


## Sculd 

Sculd consists of MVC model. The view files follow:
- [Welcome](https://github.com/ady19ctf/ady19hack2021-test/blob/main/resources/views/welcome.blade.php): Top page of this web app
- [Dashboard](https://github.com/ady19ctf/ady19hack2021-test/blob/main/resources/views/dashboard.blade.php): displayed after users logged in successfully
- [Vote](https://github.com/ady19ctf/ady19hack2021-test/blob/main/resources/views/user/vote/index.blade.php): only users (not administrator) available to vote for one of several candidates
- [Vote Check](https://github.com/ady19ctf/ady19hack2021-test/blob/main/resources/views/user/vote/vote-check.blade.php): confirm your choice on previous Vote page
- [Vote Result](https://github.com/ady19ctf/ady19hack2021-test/blob/main/resources/views/user/vote/vote-result.blade.php): voted completely and displayed transaction id
- [Vote Status](https://github.com/ady19ctf/ady19hack2021-test/blob/main/resources/views/admin/VoteStatus/index.blade.php): only administrator available to see the status which candidates users voted for

The controller files follows:

- [CheckRole](https://github.com/ady19ctf/ady19hack2021-test/blob/main/app/Http/Middleware/CheckRole.php): 

