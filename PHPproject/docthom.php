<!DOCTYPE html>
<html>
<head>
    <title>Doctor Page</title>
    <link rel="stylesheet" href="css/styles.css">
  </head>
  <body>
    <div>
      <header>
        <h1>Welcome to Doctor's page</h1>
        <a href="HOME.html">Log out</a>
      </header>
    <main>
        <div>
            <div class="picture">
                <img src="image/doc.jpeg" >
            </div>
            <div class="welcome">
                <h1>Welcome, Doctor</h1>
                <p>Here you can manage your patient's information, medical tests, and See results.</p>
            </div>
            <a href="patientHistory.php" class="view-page"><button>View Information</button></a>
            <a href="medicaltestRequest.php" class="view-page"><button>Medical Test<button></a>
            <a href="resultView.php" class="view-page"><button>View Results</button></a>
        </div>
    </main>
    <?php include('include/footer.php');?>
  </body>
</html>
    