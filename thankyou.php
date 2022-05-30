<!DOCTYPE html>
<html>
<head>
  <title>Online User Study</title>
  <link rel="stylesheet" type="text/css" href="css/slist.css">
</head>
<body>
  <div class="formpage">
    <div style="background-color: lavender; border: 1px solid black; width: 600px; padding: 30px; margin-top: 100px;">
      <div class="introtext">
        <h1 style="
          text-align: center;
          font-weight: 400;">Thank you for participating in the study!</h1>
          <p style="
            text-align: center;"><a href="https://app.prolific.co/submissions/complete?cc=6B6A9EEF">Click here to return to Profilic</a></p>
    </div>
  </div>
</div>

<?php

require "connect.php";


session_start();
if (isset($_POST['submit_recipe'])) {

  $sexOption = $_SESSION['sexOption'];
  $ageOption = $_SESSION['ageOption'];
  $healthyeating = $_SESSION['healthyeating'];
  $weight = $_SESSION['weight'];
  $height = $_SESSION['height'];
  $eatinghabits = $_SESSION['eatinghabits'];
  $recipenutri = $_SESSION['recipenutrients'];
  $cookingdifficulty = $_SESSION['difficulty'];
  $cookingtime = $_SESSION['cookingtime'];
  $activity = $_SESSION['activity'];
  $dietarygoal = $_SESSION['dietarygoal'];
  $diet_restriction = $_SESSION['diet_restriction'];
  $P_ML_question1 = $_SESSION['P_ML_question1'];
  $P_ML_question2 = $_SESSION['P_ML_question2'];
  $P_ML_question3 = $_SESSION['P_ML_question3'];
  $P_ML_question4 = $_SESSION['P_ML_question4'];
  $P_ML_question5 = $_SESSION['P_ML_question5'];
  $P_ML_question6 = $_SESSION['P_ML_question6'];
  $P_ML_question7 = $_SESSION['P_ML_question7'];
  $P_ML_question8 = $_SESSION['P_ML_question8'];
  $P_ML_question9 = $_SESSION['P_ML_question9'];
  $P_ML_question10 = $_SESSION['P_ML_question10'];
  $P_ML_question11 = $_SESSION['P_ML_question11'];
  $P_ML_question12 = $_SESSION['P_ML_question12'];
  $P_ML_question13 = $_SESSION['P_ML_question13'];
  $P_ML_recipe = $_SESSION['p_ml_recipe'];
  $NP_ML_recipe = $_SESSION['np_ml_recipe'];
  $NP_ML_question1 = $_SESSION['NP_ML_question1'];
  $NP_ML_question2 = $_SESSION['NP_ML_question2'];
  $NP_ML_question3 = $_SESSION['NP_ML_question3'];
  $NP_ML_question4 = $_SESSION['NP_ML_question4'];
  $NP_ML_question5 = $_SESSION['NP_ML_question5'];
  $NP_ML_question6 = $_SESSION['NP_ML_question6'];
  $NP_ML_question7 = $_SESSION['NP_ML_question7'];
  $NP_ML_question8 = $_SESSION['NP_ML_question8'];
  $NP_ML_question9 = $_SESSION['NP_ML_question9'];
  $NP_ML_question10 = $_SESSION['NP_ML_question10'];
  $NP_ML_question11 = $_SESSION['NP_ML_question11'];
  $NP_ML_question12 = $_SESSION['NP_ML_question12'];
  $NP_ML_question13 = $_SESSION['NP_ML_question13'];
  $_SESSION['ML_end_question1'] = $_POST['ML_end_question1'];
  $ML_end_question1 = $_SESSION['ML_end_question1'];
  $_SESSION['ML_end_question2'] = $_POST['ML_end_question2'];
  $ML_end_question2 = $_SESSION['ML_end_question2'];
  $_SESSION['ML_end_question3'] = $_POST['ML_end_question3'];
  $ML_end_question3 = $_SESSION['ML_end_question3'];
  $_SESSION['ML_end_question4'] = $_POST['ML_end_question4'];
  $ML_end_question4 = $_SESSION['ML_end_question4'];
  $p_ml_listnr = $_SESSION['p_ml_listnr'];
  $p_ml_recipenr = $_SESSION['p_ml_recipenr'];
  $p_ml_exp = $_SESSION['p_ml_exp'];
  $np_ml_listnr = $_SESSION['np_ml_listnr'];
  $np_ml_recipenr = $_SESSION['np_ml_recipenr'];
  $np_ml_exp = $_SESSION['np_ml_exp'];
  $p_ml_all_lists = $_SESSION['all_p_lists'];
  $np_ml_all_lists = $_SESSION['all_np_lists'];
  $prolific_id = $_SESSION['PROLIFIC_PID'];


  $insert_answer = "INSERT INTO multi_list_answer (sex,
    age,
    importance_eating,
    weight,
    height,
    eatinghabits,
    recipe_nutrients,
    cookingexperience,
    cookingtime,
    activity,
    dietgoal,
    dietrestrict,
    p_ml_question1,
    p_ml_question2,
    p_ml_question3,
    p_ml_question4,
    p_ml_recipe,
    np_ml_recipe,
    np_ml_question1,
    np_ml_question2,
    np_ml_question3,
    np_ml_question4,
    ml_end_question1,
    ml_end_question2,
    ml_end_question3,
    ml_end_question4,
    p_ml_listnr,
    p_ml_recipenr,
    p_ml_exp,
    np_ml_listnr,
    np_ml_recipenr,
    np_ml_exp,
    p_ml_question5,
    p_ml_question6,
    p_ml_question7,
    p_ml_question8,
    p_ml_question9,
    p_ml_question10,
    p_ml_question11,
    p_ml_question12,
    p_ml_question13,
    np_ml_question5,
    np_ml_question6,
    np_ml_question7,
    np_ml_question8,
    np_ml_question9,
    np_ml_question10,
    np_ml_question11,
    np_ml_question12,
    np_ml_question13,
    p_ml_all_lists,
    np_ml_all_lists,
    prolific_id)
  VALUES ('$sexOption',
    '$ageOption',
    '$healthyeating',
    '$weight',
    '$height',
    '$eatinghabits',
    '$recipenutri',
    '$cookingdifficulty',
    '$cookingtime',
    '$activity',
    '$dietarygoal',
    '$diet_restriction',
    '$P_ML_question1',
    '$P_ML_question2',
    '$P_ML_question3',
    '$P_ML_question4',
    '$P_ML_recipe',
    '$NP_ML_recipe',
    '$NP_ML_question1',
    '$NP_ML_question2',
    '$NP_ML_question3',
    '$NP_ML_question4',
    '$ML_end_question1',
    '$ML_end_question2',
    '$ML_end_question3',
    '$ML_end_question4',
    '$p_ml_listnr',
    '$p_ml_recipenr',
    '$p_ml_exp',
    '$np_ml_listnr',
    '$np_ml_recipenr',
    '$np_ml_exp',
    '$P_ML_question5',
    '$P_ML_question6',
    '$P_ML_question7',
    '$P_ML_question8',
    '$P_ML_question9',
    '$P_ML_question10',
    '$P_ML_question11',
    '$P_ML_question12',
    '$P_ML_question13',
    '$NP_ML_question5',
    '$NP_ML_question6',
    '$NP_ML_question7',
    '$NP_ML_question8',
    '$NP_ML_question9',
    '$NP_ML_question10',
    '$NP_ML_question11',
    '$NP_ML_question12',
    '$NP_ML_question13',
    '$p_ml_all_lists',
    '$np_ml_all_lists',
    '$prolific_id')";

  pg_query($conn, $insert_answer);
}
?>

</body>
</html>
