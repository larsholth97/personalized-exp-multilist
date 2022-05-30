<!DOCTYPE html>
<html>
<head>
  <title>Online User Study</title>
  <link rel="stylesheet" type="text/css" href="css/slist.css">
</head>
<body>

  <h1 style="
    font-family: system-ui;
    text-align: center;
    font-weight: 400;
    right: 30px;
    padding: 30px;">Page 4/4</h1>

    <h1 style="
    font-family: system-ui;
    text-align: center;
    font-weight: 400;
    right: 30px;
    width: 60%;
    position: relative;
    left: 20%;
  ">Now that you have chosen two recipes that you would like to cook the most, please rate your level of agreement with each of the following statements from 1-7.</h1>


  <?php
  session_start();

  if (isset($_POST['submit_recipe'])) {
    #From index3_1
    $_SESSION['NP_SL_question1'] = $_POST['NP_SL_question1'];
    $_SESSION['NP_SL_question2'] = $_POST['NP_SL_question2'];
    $_SESSION['NP_SL_question3'] = $_POST['NP_SL_question3'];
    $_SESSION['NP_SL_question4'] = $_POST['NP_SL_question4'];
    $_SESSION['NP_SL_question5'] = $_POST['NP_SL_question5'];
    $_SESSION['NP_SL_question6'] = $_POST['NP_SL_question6'];
    $_SESSION['NP_SL_question7'] = $_POST['NP_SL_question7'];
    $_SESSION['NP_SL_question8'] = $_POST['NP_SL_question8'];
    $_SESSION['NP_SL_question9'] = $_POST['NP_SL_question9'];
    $_SESSION['NP_SL_question10'] = $_POST['NP_SL_question10'];
    $_SESSION['NP_SL_question11'] = $_POST['NP_SL_question11'];
    $_SESSION['NP_SL_question12'] = $_POST['NP_SL_question12'];
    $_SESSION['NP_SL_question13'] = $_POST['NP_SL_question13'];
    $opt = explode("//", $_POST['select_np_sl_recipe']);
    $_SESSION['np_sl_recipe'] = $opt[0];
    $_SESSION['np_sl_listnr'] = $opt[1];
    $_SESSION['np_sl_recipenr'] = $opt[2];
    $_SESSION['np_sl_exp'] = $opt[3];
  }

  if (isset($_POST['submit_recipe2'])) {
    #From index2_1
    $_SESSION['P_SL_question1'] = $_POST['P_SL_question1'];
    $_SESSION['P_SL_question2'] = $_POST['P_SL_question2'];
    $_SESSION['P_SL_question3'] = $_POST['P_SL_question3'];
    $_SESSION['P_SL_question4'] = $_POST['P_SL_question4'];
    $_SESSION['P_SL_question5'] = $_POST['P_SL_question5'];
    $_SESSION['P_SL_question6'] = $_POST['P_SL_question6'];
    $_SESSION['P_SL_question7'] = $_POST['P_SL_question7'];
    $_SESSION['P_SL_question8'] = $_POST['P_SL_question8'];
    $_SESSION['P_SL_question9'] = $_POST['P_SL_question9'];
    $_SESSION['P_SL_question10'] = $_POST['P_SL_question10'];
    $_SESSION['P_SL_question11'] = $_POST['P_SL_question11'];
    $_SESSION['P_SL_question12'] = $_POST['P_SL_question12'];
    $_SESSION['P_SL_question13'] = $_POST['P_SL_question13'];
    $opt = explode("//", $_POST['select_p_sl_recipe']);
    $_SESSION['p_sl_recipe'] = $opt[0];
    $_SESSION['p_sl_listnr'] = $opt[1];
    $_SESSION['p_sl_recipenr'] = $opt[2];
    $_SESSION['p_sl_exp'] = $opt[3];
  }

  ?>

  <form action="thankyou2.php" method="POST">
  <label for="SL_end_question1" class="questions" style="margin-top:120px;">Several recipes in each list of recommended recipes differed strongly from each other </label>
  <div class="questionanswers" style="border: none;">
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q1_1">1 (Completely Disagree)<br />
      <input class="formcheckinput" type="radio" name="SL_end_question1" id="SL_end_Q1_1" value="SL_end_Q1_1" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q1_2">2 <br />
      <input class="formcheckinput" type="radio" name="SL_end_question1" id="SL_end_Q1_2" value="SL_end_Q1_2" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q1_3">3 <br />
      <input class="formcheckinput" type="radio" name="SL_end_question1" id="SL_end_Q1_3" value="SL_end_Q1_3" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q1_4">4 <br />
      <input class="formcheckinput" type="radio" name="SL_end_question1" id="SL_end_Q1_4" value="SL_end_Q1_4" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q1_5">5 <br />
      <input class="formcheckinput" type="radio" name="SL_end_question1" id="SL_end_Q1_5" value="SL_end_Q1_5" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q1_6">6 <br />
      <input class="formcheckinput" type="radio" name="SL_end_question1" id="SL_end_Q1_6" value="SL_end_Q1_6" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q1_7">7 (Completely Agree)<br />
      <input class="formcheckinput" type="radio" name="SL_end_question1" id="SL_end_Q1_7" value="SL_end_Q1_7" required>
      </label>
    </div>
  </div>

  <label for="SL_end_question2" class="questions" style="margin-top:120px;">The recommendation lists included recipes from many different categories </label>
  <div class="questionanswers" style="border: none;">
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q2_1">1 (Completely Disagree)<br />
      <input class="formcheckinput" type="radio" name="SL_end_question2" id="SL_end_Q2_1" value="SL_end_Q2_1" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q2_2">2 <br />
      <input class="formcheckinput" type="radio" name="SL_end_question2" id="SL_end_Q2_2" value="SL_end_Q2_2" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q2_3">3 <br />
      <input class="formcheckinput" type="radio" name="SL_end_question2" id="SL_end_Q2_3" value="SL_end_Q2_3" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q2_4">4 <br />
      <input class="formcheckinput" type="radio" name="SL_end_question2" id="SL_end_Q2_4" value="SL_end_Q2_4" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q2_5">5 <br />
      <input class="formcheckinput" type="radio" name="SL_end_question2" id="SL_end_Q2_5" value="SL_end_Q2_5" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q2_6">6 <br />
      <input class="formcheckinput" type="radio" name="SL_end_question2" id="SL_end_Q2_6" value="SL_end_Q2_6" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q2_7">7 (Completely Agree)<br />
      <input class="formcheckinput" type="radio" name="SL_end_question2" id="SL_end_Q2_7" value="SL_end_Q2_7" required>
      </label>
    </div>
  </div>

  <label for="SL_end_question3" class="questions" style="margin-top:120px;">Both interfaces contained recipes that were similar to each other </label>
  <div class="questionanswers" style="border: none;">
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q3_1">1 (Completely Disagree)<br />
      <input class="formcheckinput" type="radio" name="SL_end_question3" id="SL_end_Q3_1" value="SL_end_Q3_1" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q3_2">2 <br />
      <input class="formcheckinput" type="radio" name="SL_end_question3" id="SL_end_Q3_2" value="SL_end_Q3_2" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q3_3">3 <br />
      <input class="formcheckinput" type="radio" name="SL_end_question3" id="SL_end_Q3_3" value="SL_end_Q3_3" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q3_4">4 <br />
      <input class="formcheckinput" type="radio" name="SL_end_question3" id="SL_end_Q3_4" value="SL_end_Q3_4" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q3_5">5 <br />
      <input class="formcheckinput" type="radio" name="SL_end_question3" id="SL_end_Q3_5" value="SL_end_Q3_5" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q3_6">6 <br />
      <input class="formcheckinput" type="radio" name="SL_end_question3" id="SL_end_Q3_6" value="SL_end_Q3_6" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q3_7">7 (Completely Agree)<br />
      <input class="formcheckinput" type="radio" name="SL_end_question3" id="SL_end_Q3_7" value="SL_end_Q3_7" required>
      </label>
    </div>
  </div>

  <label for="SL_end_question4" class="questions" style="margin-top:120px;">No two recipes seemed alike </label>
  <div class="questionanswers" style="border: none;">
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q4_1">1 (Completely Disagree)<br />
      <input class="formcheckinput" type="radio" name="SL_end_question4" id="SL_end_Q4_1" value="SL_end_Q4_1" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q4_2">2 <br />
      <input class="formcheckinput" type="radio" name="SL_end_question4" id="SL_end_Q4_2" value="SL_end_Q4_2" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q4_3">3 <br />
      <input class="formcheckinput" type="radio" name="SL_end_question4" id="SL_end_Q4_3" value="SL_end_Q4_3" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q4_4">4 <br />
      <input class="formcheckinput" type="radio" name="SL_end_question4" id="SL_end_Q4_4" value="SL_end_Q4_4" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q4_5">5 <br />
      <input class="formcheckinput" type="radio" name="SL_end_question4" id="SL_end_Q4_5" value="SL_end_Q4_5" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q4_6">6 <br />
      <input class="formcheckinput" type="radio" name="SL_end_question4" id="SL_end_Q4_6" value="SL_end_Q4_6" required>
      </label>
    </div>
    <div class="radioquestion">
      <label class="formchecklabel" for="SL_end_Q4_7">7 (Completely Agree)<br />
      <input class="formcheckinput" type="radio" name="SL_end_question4" id="SL_end_Q4_7" value="SL_end_Q4_7" required>
      </label>
    </div>
  </div>

  <input class="submit_button_sl" type="submit" value="Continue" name="submit_recipe">

</form>

</body>
</html>
