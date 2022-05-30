<!DOCTYPE html>
<html>
<head>
  <title>Online User Study</title>
  <link rel="stylesheet" type="text/css" href="css/slist.css">
</head>
<body>

  <?php

  session_start();

  $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  $parts = parse_url($actual_link);
  parse_str($parts['query'], $query);
  $_SESSION['PROLIFIC_PID'] = $query['PROLIFIC_PID'];

  ?>

  <div class="formpage">
    <div style="background-color: lavender; border: 1px solid black; width: 600px; padding: 30px;">
      <div class="introtext">
  <h1>Food Recommender System</h1>
  <p>Welcome to our ‘Food Recommender System’ study. The aim of this study is to understand how people make food decisions online, based on personalized recommendations. This study is a part of the master’s thesis project of Lars Giske Holth at University of Bergen, Norway, under supervision of dr.ir. Alain Starke and prof.dr. Christoph Trattner. Before clicking ‘start’ to proceed, please carefully read the procedure followed in this study and give your informed consent for voluntary participation*. You can stop your participation at any time during this study by closing this window.</p>

  <h2>Procedure</h2>
  <p>In this study, you will be asked to answer questions about yourself and your food preferences. Based on your answers, you will be presented two sets of personalized recipe recommendations that fit your profile. For each list, you will be asked to choose one recipe you like the most and to answer questions about the chosen and presented recipes. At the end of the study, you will asked to fill out a short questionnaire.</p>

  <h2>Duration and Compensation</h2>
  <p>The study takes about 5 minutes to complete. You will be compensated with £0.70,- for your participation. This study does not involve any risks, detrimental side effects, or cause discomfort.
    <br><br>
    By clicking the start button, you agree to have read and understood this consent form and that you agree to voluntarily participate in this research.</p>
    <br>
  <p style="color: red;">Do you accept the informed consent?*</p>
  <input class="consent_button" type="button" value="Yes" onclick="location='https://pme22.herokuapp.com/form2.php'" />
  <input class="consent_button" type="button" value="No" onclick="location.href= 'https://app.prolific.co'" />

    <p style="font-size: small;">*We will not store any personal information about you, and not share any data to anyone outside of the research team. The information that we collect from this research project is used for writing scientific publications and will be reported at the group level. It will be completely anonymous and it cannot be traced back to you. For questions about the experiment, please contact the experimenter (tuh007@uib.no). If you have any complaints about this experiment, please contact the supervisor, dr.ir. Alain Starke (alain.starke@uib.no).</p>
    </div>
  </div>
</div>

</body>
</html>
