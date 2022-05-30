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
            text-align: center;"><a href="https://app.prolific.co/submissions/complete?cc=26C7E89E">Click here to return to Profilic</a></p>
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
  $P_SL_question1 = $_SESSION['P_SL_question1'];
  $P_SL_question2 = $_SESSION['P_SL_question2'];
  $P_SL_question3 = $_SESSION['P_SL_question3'];
  $P_SL_question4 = $_SESSION['P_SL_question4'];
  $P_SL_question5 = $_SESSION['P_SL_question5'];
  $P_SL_question6 = $_SESSION['P_SL_question6'];
  $P_SL_question7 = $_SESSION['P_SL_question7'];
  $P_SL_question8 = $_SESSION['P_SL_question8'];
  $P_SL_question9 = $_SESSION['P_SL_question9'];
  $P_SL_question10 = $_SESSION['P_SL_question10'];
  $P_SL_question11 = $_SESSION['P_SL_question11'];
  $P_SL_question12 = $_SESSION['P_SL_question12'];
  $P_SL_question13 = $_SESSION['P_SL_question13'];
  $P_SL_recipe = $_SESSION['p_sl_recipe'];
  $NP_SL_recipe = $_SESSION['np_sl_recipe'];
  $NP_SL_question1 = $_SESSION['NP_SL_question1'];
  $NP_SL_question2 = $_SESSION['NP_SL_question2'];
  $NP_SL_question3 = $_SESSION['NP_SL_question3'];
  $NP_SL_question4 = $_SESSION['NP_SL_question4'];
  $NP_SL_question5 = $_SESSION['NP_SL_question5'];
  $NP_SL_question6 = $_SESSION['NP_SL_question6'];
  $NP_SL_question7 = $_SESSION['NP_SL_question7'];
  $NP_SL_question8 = $_SESSION['NP_SL_question8'];
  $NP_SL_question9 = $_SESSION['NP_SL_question9'];
  $NP_SL_question10 = $_SESSION['NP_SL_question10'];
  $NP_SL_question11 = $_SESSION['NP_SL_question11'];
  $NP_SL_question12 = $_SESSION['NP_SL_question12'];
  $NP_SL_question13 = $_SESSION['NP_SL_question13'];
  $_SESSION['SL_end_question1'] = $_POST['SL_end_question1'];
  $SL_end_question1 = $_SESSION['SL_end_question1'];
  $_SESSION['SL_end_question2'] = $_POST['SL_end_question2'];
  $SL_end_question2 = $_SESSION['SL_end_question2'];
  $_SESSION['SL_end_question3'] = $_POST['SL_end_question3'];
  $SL_end_question3 = $_SESSION['SL_end_question3'];
  $_SESSION['SL_end_question4'] = $_POST['SL_end_question4'];
  $SL_end_question4 = $_SESSION['SL_end_question4'];
  $p_sl_listnr = $_SESSION['p_sl_listnr'];
  $p_sl_recipenr = $_SESSION['p_sl_recipenr'];
  $p_sl_exp = $_SESSION['p_sl_exp'];
  $np_sl_listnr = $_SESSION['np_sl_listnr'];
  $np_sl_recipenr = $_SESSION['np_sl_recipenr'];
  $np_sl_exp = $_SESSION['np_sl_exp'];
  $prolific_id = $_SESSION['PROLIFIC_PID'];


  $insert_answer = "INSERT INTO single_list_answer (sex,
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
    p_sl_question1,
    p_sl_question2,
    p_sl_question3,
    p_sl_question4,
    p_sl_recipe,
    np_sl_recipe,
    np_sl_question1,
    np_sl_question2,
    np_sl_question3,
    np_sl_question4,
    sl_end_question1,
    sl_end_question2,
    sl_end_question3,
    sl_end_question4,
    p_sl_listnr,
    p_sl_recipenr,
    p_sl_exp,
    np_sl_listnr,
    np_sl_recipenr,
    np_sl_exp,
    p_sl_question5,
    p_sl_question6,
    p_sl_question7,
    p_sl_question8,
    p_sl_question9,
    p_sl_question10,
    p_sl_question11,
    p_sl_question12,
    p_sl_question13,
    np_sl_question5,
    np_sl_question6,
    np_sl_question7,
    np_sl_question8,
    np_sl_question9,
    np_sl_question10,
    np_sl_question11,
    np_sl_question12,
    np_sl_question13,
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
    '$P_SL_question1',
    '$P_SL_question2',
    '$P_SL_question3',
    '$P_SL_question4',
    '$P_SL_recipe',
    '$NP_SL_recipe',
    '$NP_SL_question1',
    '$NP_SL_question2',
    '$NP_SL_question3',
    '$NP_SL_question4',
    '$SL_end_question1',
    '$SL_end_question2',
    '$SL_end_question3',
    '$SL_end_question4',
    '$p_sl_listnr',
    '$p_sl_recipenr',
    '$p_sl_exp',
    '$np_sl_listnr',
    '$np_sl_recipenr',
    '$np_sl_exp',
    '$P_SL_question5',
    '$P_SL_question6',
    '$P_SL_question7',
    '$P_SL_question8',
    '$P_SL_question9',
    '$P_SL_question10',
    '$P_SL_question11',
    '$P_SL_question12',
    '$P_SL_question13',
    '$NP_SL_question5',
    '$NP_SL_question6',
    '$NP_SL_question7',
    '$NP_SL_question8',
    '$NP_SL_question9',
    '$NP_SL_question10',
    '$NP_SL_question11',
    '$NP_SL_question12',
    '$NP_SL_question13',
    '$prolific_id')";

  pg_query($conn, $insert_answer);

}
?>

</body>
</html>
