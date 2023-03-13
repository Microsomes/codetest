#Issues noticed.

1) hard coded values noticed, we should be using .env
2) type for $db was not PDO, but was string
3) getStatus was not using prepared statement so thats a security risk due to sql injection
4) getStatus was not using try catch so if there was an error it would not be caught
