<script>
function test() {
		window.location="./signin.php";
	}
</script>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Anonymous Calendar</title>
    <link href="bootstrap.min.css" rel="stylesheet">
    <link href="jumbotron.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="index.php">Anonymous Calendar</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <form class="navbar-form navbar-right">
            <div class="form-group">
              <input type="text" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Σύνδεση</button>

          </form>
        </div>
      </div>
    </nav>
    
    <div class="jumbotron">
      <div class="container">
        <h1>Anonymous Calendar!</h1>
        <p>Αυτό είναι το προσωπικό σας ημερολόγιο με το οποίο θα μπορείτε να εισάγετε ένα γεγονός και να μοιράζεστε το ημερολόγιό σας με άλλους χρήστες.</p>
        <p><a class="btn btn-primary btn-lg" href="#" role="button" onclick="test();">Εγγραφή</a></p>
      </div>
    </div>


      <footer>
        <p>&copy; 2016 Δέσπω, Λίνα, Μήτσος</p>
      </footer>
    </div>
  </body>
</html>
