<script>
function test() {
	var cForm   = document.forms.edit_p_form;
		var errstr  = 0;  
		var emailRegEx = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;

		
		if ( cForm.onoma.value==''){
			errstr=errstr+1;		
			cForm.onoma.placeholder="����� �����";
		}
		if ( cForm.epitheto.value==''){	
			errstr=errstr+1;							
			cForm.epitheto.placeholder="����� �������";
		}

		
		if ( cForm.mail.value==''){
			errstr=errstr+1;
			cForm.mail.placeholder="����� e-mail";

		}
		 
		else
		{
			if (cForm.mail.value.search(emailRegEx) == -1)
			{
				errstr=errstr+1;
				cForm.mail.value="";
				cForm.mail.placeholder="�� ������������ �����  e-mail";

			}
		}

		 
		if ( cForm.username.value==''){
			errstr=errstr+1;
			cForm.username.placeholder="����� username";
		}
		if ( cForm.password.value==''){
			errstr=errstr+1;
			cForm.password.placeholder="����� password";
		}

		if (errstr.length==0) {
			document.forms.edit_p_form.submit(); }
	}
</script>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="windows-1253">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>������� ���� ������</title>
    <link href="bootstrap.min.css" rel="stylesheet">
    <link href="signin.css" rel="stylesheet">
  </head>

  <body>
 <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="index.php">Anonymous Calendar</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
        </div>
      </div>
    </nav>

    <div class="container">
      <form class="form-signin" name="edit_p_form" method="post" enctype="multipart/form-data" action="add_user.php">
        <h2 class="form-signin-heading">�������� �������� �� �������� ���</h2>
		<p>�����<p/>
        <?php echo"<input type='text' name='onoma' id='onoma' class='form-control'>"; ?>
		<p>�������</p>
		<?php echo"<input type='text' name='epitheto' class='form-control'>"; ?>
		<p>���������� ��������</p>
        <?php echo"<input type='date' id='imgennisis' name='imgennisis' class='form-control'>"; ?>
		<p>����</p>
        <input type="radio" name='filo' id="filo" value="male">  ������ <br>
        <input type="radio" name='filo' id="filo" value="female"> ������� <br>
		<p>E-mail</p>
        <?php echo"<input type='text' id='mail' name='mail' class='form-control'>"; ?>
		<p>Username</p>
        <?php echo"<input type='text;' id='username' name='username' class='form-control' >"; ?>
		<p>Password</p>
        <?php echo"<input type='password' id='password' name='password' class='form-control' >"; ?>
        <button class="btn btn-lg btn-primary btn-block" type="submit" onClick="test()">�������</button>
      </form>
    </div> 
  </body>
</html>
