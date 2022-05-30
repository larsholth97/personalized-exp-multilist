<?php
/* ----------------PERSONALIZED MULTI-LIST INTERFACE-----------------------*/
require "connect.php";


?>

<!DOCTYPE html>
<html>
<head>
  <title>Online User Study</title>
  <link rel="stylesheet" type="text/css" href="css/slist.css">
</head>
<body>

<?php
session_start();

if (isset($_POST['submit_recipe'])) {
  $_SESSION['NP_ML_question1'] = $_POST['NP_ML_question1'];
  $_SESSION['NP_ML_question2'] = $_POST['NP_ML_question2'];
  $_SESSION['NP_ML_question3'] = $_POST['NP_ML_question3'];
  $_SESSION['NP_ML_question4'] = $_POST['NP_ML_question4'];
  $_SESSION['NP_ML_question5'] = $_POST['NP_ML_question5'];
  $_SESSION['NP_ML_question6'] = $_POST['NP_ML_question6'];
  $_SESSION['NP_ML_question7'] = $_POST['NP_ML_question7'];
  $_SESSION['NP_ML_question8'] = $_POST['NP_ML_question8'];
  $_SESSION['NP_ML_question9'] = $_POST['NP_ML_question9'];
  $_SESSION['NP_ML_question10'] = $_POST['NP_ML_question10'];
  $_SESSION['NP_ML_question11'] = $_POST['NP_ML_question11'];
  $_SESSION['NP_ML_question12'] = $_POST['NP_ML_question12'];
  $_SESSION['NP_ML_question13'] = $_POST['NP_ML_question13'];
  $np_opt = explode("//", $_POST['select_np_ml_recipe']);
  $_SESSION['np_ml_recipe'] = $np_opt[0];
  $_SESSION['np_ml_listnr'] = $np_opt[1];
  $_SESSION['np_ml_recipenr'] = $np_opt[2];
  $_SESSION['np_ml_exp'] = $np_opt[3];
}

#Function for shuffling array
function shuffle_assoc($list) {
  if (!is_array($list)) return $list;
  $keys = array_keys($list);
  shuffle($keys);
  $random = array();
  foreach ($keys as $key) {
    $random[$key] = $list[$key];
  }
  return $random;
}

#Sorting functions
function build_sorter($key) {
  return function ($a, $b) use ($key) {
    return strnatcmp($a[$key], $b[$key]);
  };
}

#Sorting from high to low
function high_to_low_sorter($key) {
  return function ($a, $b) use ($key) {
    return strnatcmp($b[$key], $a[$key]);
  };
}

#Function for finding difference between arrays
function array_difference($arraya, $arrayb) {
  foreach ($arraya as $keya => $valuea) {
    if (in_array($valuea, $arrayb)) {
      unset($arraya[$keya]);
    }
  }
  return $arraya;
}



$array_two = $_SESSION['array_two'];

#Rank array based on score
function score($a, $b) {
  if ($a['score'] == $b['score']) {
    return 0;
  }
  return ($a['score'] < $b['score']) ? 1 : -1;
}

uasort($array_two, 'score');
$sliced_array = array_slice($array_two, 0, 350, true);
$subset = shuffle_assoc($sliced_array);

$multi_list = $_SESSION['multi_list'];

if (isset($multi_list)) {
  if (array_key_exists('habits_unhealthy',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, build_sorter('who_score'));
    $list_unhealthyhabits = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['habits_unhealthy']['recipes'] = $list_unhealthyhabits;
  }

  if (array_key_exists('habits_healthy',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, build_sorter('who_score'));
    $list_healthyhabits = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['habits_healthy']['recipes'] = $list_healthyhabits;
  }

  if (array_key_exists('activity_fat_low_high',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, build_sorter('fat'));
    $list_lowfat = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['activity_fat_low_high']['recipes'] = $list_lowfat;
  }

  if (array_key_exists('dietarygoal_fat_low_high',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, build_sorter('fat'));
    $list_lowfat = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['dietarygoal_fat_low_high']['recipes'] = $list_lowfat;
  }

  if (array_key_exists('totalminutes_low',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, build_sorter('totalminutes'));
    $list_lowminutes = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['totalminutes_low']['recipes'] = $list_lowminutes;
  }

  if (array_key_exists('totalminutes_high',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, high_to_low_sorter('totalminutes'));
    $list_highminutes = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['totalminutes_high']['recipes'] = $list_highminutes;
  }

  if (array_key_exists('high_minutes_diabetes',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, high_to_low_sorter('totalminutes'));
    $list_highminutes = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['high_minutes_diabetes']['recipes'] = $list_highminutes;
  }

  if (array_key_exists('difficulty_low',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, build_sorter('difficulty_nr'));
    $list_lowdifficulty = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['difficulty_low']['recipes'] = $list_lowdifficulty;
  }

  if (array_key_exists('difficulty_high',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, high_to_low_sorter('difficulty_nr'));
    $list_highdifficulty = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['difficulty_high']['recipes'] = $list_highdifficulty;
  }

  if (array_key_exists('activity_protein_high',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, high_to_low_sorter('proteins'));
    $list_highprotein = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['activity_protein_high']['recipes'] = $list_highprotein;
  }

  if (array_key_exists('dietarygoal_protein_high',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, high_to_low_sorter('proteins'));
    $list_highprotein = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['dietarygoal_protein_high']['recipes'] = $list_highprotein;
  }

  if (array_key_exists('activity_fat_high_low',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, high_to_low_sorter('fat'));
    $list_highfat = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['activity_fat_high_low']['recipes'] = $list_highfat;
  }

  if (array_key_exists('dietarygoal_fat_high_low',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, high_to_low_sorter('fat'));
    $list_highfat = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['dietarygoal_fat_high_low']['recipes'] = $list_highfat;
  }

  if (array_key_exists('activity_fibre_high_low',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, high_to_low_sorter('fibers'));
    $list_highfibre = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['activity_fibre_high_low']['recipes'] = $list_highfibre;
  }

  if (array_key_exists('activity_calories',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, build_sorter('calories'));
    $list_lowcals = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['activity_calories']['recipes'] = $list_lowcals;
  }

  if (array_key_exists('dietarygoal_calories',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, build_sorter('calories'));
    $list_lowcals = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['dietarygoal_calories']['recipes'] = $list_lowcals;
  }

  if (array_key_exists('low_cal_diabetes',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, build_sorter('calories'));
    $list_lowcals = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['low_cal_diabetes']['recipes'] = $list_lowcals;
  }

  if (array_key_exists('activity_sugars',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, build_sorter('sugars'));
    $list_lowsugars = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['activity_sugars']['recipes'] = $list_lowsugars;
  }

  if (array_key_exists('activity_saturatedfat',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, build_sorter('saturatedfat'));
    $list_lowsaturatedfat = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['activity_saturatedfat']['recipes'] = $list_lowsaturatedfat;
  }

  if (array_key_exists('dietarygoal_saturatedfat',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, build_sorter('saturatedfat'));
    $list_lowsaturatedfat = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['dietarygoal_saturatedfat']['recipes'] = $list_lowsaturatedfat;
  }

  if (array_key_exists('dietarygoal_calories_high',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, high_to_low_sorter('calories'));
    $list_highcals = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['dietarygoal_calories_high']['recipes'] = $list_highcals;
  }

  if (array_key_exists('vegetarian_healthy',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, high_to_low_sorter('who_score'));
    $list_restrict = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['vegetarian_healthy']['recipes'] = $list_restrict;
  }

  if (array_key_exists('lactose_healthy',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, high_to_low_sorter('who_score'));
    $list_restrict = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['lactose_healthy']['recipes'] = $list_restrict;
  }

  if (array_key_exists('glutenfree_healthy',$multi_list)) {
    $pre_shuffle = shuffle_assoc($subset);
    usort($pre_shuffle, high_to_low_sorter('who_score'));
    $list_restrict = array_slice($pre_shuffle, 0, 5, true);
    $multi_list['glutenfree_healthy']['recipes'] = $list_restrict;
  }
}


$key_to_num = array_values($multi_list);
echo "<form action='endsurvey.php' method='POST'>";
echo "<div class='lists'>";

echo "<h1 style='font-family: system-ui; text-align: center; font-weight: 400; grid-column-start:2; grid-column-end:5;'>Page 3/4</h1>";
echo "<h1 style='font-family: system-ui; text-align: center; font-weight: 400; grid-column-start:1; grid-column-end:6; margin-bottom: 70px;'>Again, please choose only <b>one</b> recipe that you like the most and would like to cook tomorrow night (or in the near future). Then, answer the questions at the end of the page and click ‘continue’ when finished.</h1>";


foreach ($key_to_num as $result_key => $result_value) {
  echo "<div style='grid-column-start: 1;grid-column-end: 8; font-family: system-ui; font-size: larger; font-weight: 600; margin-top: 20px; margin-bottom: -15px;'>" . $result_value['exp'] . "</div>";
  foreach ($result_value['recipes'] as $rp_key => $rp_value) {
    echo "<div class='box'>";
      echo "<div style='height: 400px;'>";
        echo "<img src='" . $rp_value['imageurl'] . "' alt='Food' width='240' height='190'>";
        echo "<div style='font-family: system-ui; margin: 10px; font-weight: 600;'>" . $rp_value['title'] . "</div>";
        echo "<div style='font-family: system-ui; margin: 10px; font-size: 14px;'>" . "Cooking time: " . $rp_value['totalminutes'] . " minutes" . "</div>";
        echo "<div style='font-family: system-ui; margin: 10px; font-size: 14px;'>" . $rp_value['description'] . "</div>";
      echo "</div>";
      echo "<div style='display: grid;grid-template-columns: auto auto;justify-content: center;height: 30px;border: 1px solid lavender;outline: 1px solid black;background-color: lavender;margin-bottom: 50px;font-family: system-ui;'>";
      echo "<label style='height: 40px;'>";
      echo "<input type='radio' name='select_p_ml_recipe' style='position: relative; top: 5px; left: 65px;' id='" . $rp_value['title'] . "' value='" . $rp_value['title'] . "//" . $result_key . "//" . $rp_key . "//" . $result_value['exp'] . "' required>";
      echo "<span style='position: relative; top: 3px; left: 70px;'>Choose recipe</span>";
      echo "<div class='borderline' style='position: relative; height: 430px; width: 240px; margin: 10px; bottom: 430px;'></div>";
      echo "</label>";
      echo "</div>";
    echo "</div>";
  }
}


  echo "<h1 style='
    font-family: system-ui;
    text-align: center;
    font-weight: 400;
    right: 30px;
    padding: 30px;
    grid-column-start: 2;
    grid-column-end: 5;
    margin-top: 70px;'>Rate the following statements from 1-7 based on your level of agreement.</h1>";

    echo "<label for='question1' class='questions'>I understood why the recipes were recommended to me</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q1_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question1' id='P_ML_Q1_1' value='P_ML_Q1_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q1_2'>2 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question1' id='P_ML_Q1_2' value='P_ML_Q1_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q1_3'>3 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question1' id='P_ML_Q1_3' value='P_ML_Q1_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q1_4'>4 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question1' id='P_ML_Q1_4' value='P_ML_Q1_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q1_5'>5 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question1' id='P_ML_Q1_5' value='P_ML_Q1_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q1_6'>6 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question1' id='P_ML_Q1_6' value='P_ML_Q1_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q1_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question1' id='P_ML_Q1_7' value='P_ML_Q1_7' required>
        </label>
      </div>
    </div>


    <label for='question2' class='questions'>I could understand how the recipes were based on my preferences</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q2_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question2' id='P_ML_Q2_1' value='P_ML_Q2_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q2_2'>2 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question2' id='P_ML_Q2_2' value='P_ML_Q2_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q2_3'>3 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question2' id='P_ML_Q2_3' value='P_ML_Q2_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q2_4'>4 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question2' id='P_ML_Q2_4' value='P_ML_Q2_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q2_5'>5 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question2' id='P_ML_Q2_5' value='P_ML_Q2_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q2_6'>6 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question2' id='P_ML_Q2_6' value='P_ML_Q2_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q2_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question2' id='P_ML_Q2_7' value='P_ML_Q2_7' required>
        </label>
      </div>
    </div>

    <label for='question3' class='questions'>The recommendation process was NOT clear to me</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q3_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question3' id='P_ML_Q3_1' value='P_ML_Q3_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q3_2'>2 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question3' id='P_ML_Q3_2' value='P_ML_Q3_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q3_3'>3 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question3' id='P_ML_Q3_3' value='P_ML_Q3_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q3_4'>4 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question3' id='P_ML_Q3_4' value='P_ML_Q3_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q3_5'>5 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question3' id='P_ML_Q3_5' value='P_ML_Q3_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q3_6'>6 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question3' id='P_ML_Q3_6' value='P_ML_Q3_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q3_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question3' id='P_ML_Q3_7' value='P_ML_Q3_7' required>
        </label>
      </div>
    </div>

    <label for='question4' class='questions'>I could easily find recipes on this page</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q4_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question4' id='P_ML_Q4_1' value='P_ML_Q4_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q4_2'>2 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question4' id='P_ML_Q4_2' value='P_ML_Q4_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q4_3'>3 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question4' id='P_ML_Q4_3' value='P_ML_Q4_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q4_4'>4 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question4' id='P_ML_Q4_4' value='P_ML_Q4_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q4_5'>5 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question4' id='P_ML_Q4_5' value='P_ML_Q4_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q4_6'>6 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question4' id='P_ML_Q4_6' value='P_ML_Q4_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q4_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question4' id='P_ML_Q4_7' value='P_ML_Q4_7' required>
        </label>
      </div>
    </div>

    <label for='question5' class='questions'>This page helped to discover new recipes</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q5_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question5' id='P_ML_Q5_1' value='P_ML_Q5_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q5_2'>2 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question5' id='P_ML_Q5_2' value='P_ML_Q5_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q5_3'>3 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question5' id='P_ML_Q5_3' value='P_ML_Q5_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q5_4'>4 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question5' id='P_ML_Q5_4' value='P_ML_Q5_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q5_5'>5 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question5' id='P_ML_Q5_5' value='P_ML_Q5_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q5_6'>6 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question5' id='P_ML_Q5_6' value='P_ML_Q5_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q5_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question5' id='P_ML_Q5_7' value='P_ML_Q5_7' required>
        </label>
      </div>
    </div>

    <label for='question6' class='questions'>A page like this helps me make better recipe choices</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q6_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question6' id='P_ML_Q6_1' value='P_ML_Q6_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q6_2'>2 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question6' id='P_ML_Q6_2' value='P_ML_Q6_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q6_3'>3 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question6' id='P_ML_Q6_3' value='P_ML_Q6_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q6_4'>4 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question6' id='P_ML_Q6_4' value='P_ML_Q6_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q6_5'>5 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question6' id='P_ML_Q6_5' value='P_ML_Q6_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q6_6'>6 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question6' id='P_ML_Q6_6' value='P_ML_Q6_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q6_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question6' id='P_ML_Q6_7' value='P_ML_Q6_7' required>
        </label>
      </div>
    </div>

    <label for='question7' class='questions'>The task of choosing a recipe was overwhelming</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q7_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question7' id='P_ML_Q7_1' value='P_ML_Q7_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q7_2'>2 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question7' id='P_ML_Q7_2' value='P_ML_Q7_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q7_3'>3 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question7' id='P_ML_Q7_3' value='P_ML_Q7_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q7_4'>4 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question7' id='P_ML_Q7_4' value='P_ML_Q7_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q7_5'>5 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question7' id='P_ML_Q7_5' value='P_ML_Q7_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q7_6'>6 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question7' id='P_ML_Q7_6' value='P_ML_Q7_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q7_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question7' id='P_ML_Q7_7' value='P_ML_Q7_7' required>
        </label>
      </div>
    </div>

    <label for='question8' class='questions'>I changed my mind several times before choosing a recipe</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q8_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question8' id='P_ML_Q8_1' value='P_ML_Q8_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q8_2'>2 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question8' id='P_ML_Q8_2' value='P_ML_Q8_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q8_3'>3 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question8' id='P_ML_Q8_3' value='P_ML_Q8_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q8_4'>4 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question8' id='P_ML_Q8_4' value='P_ML_Q8_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q8_5'>5 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question8' id='P_ML_Q8_5' value='P_ML_Q8_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q8_6'>6 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question8' id='P_ML_Q8_6' value='P_ML_Q8_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q8_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question8' id='P_ML_Q8_7' value='P_ML_Q8_7' required>
        </label>
      </div>
    </div>

    <label for='question9' class='questions'>Comparing the recommended recipes was easy</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q9_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question9' id='P_ML_Q9_1' value='P_ML_Q9_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q9_2'>2 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question9' id='P_ML_Q9_2' value='P_ML_Q9_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q9_3'>3 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question9' id='P_ML_Q9_3' value='P_ML_Q9_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q9_4'>4 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question9' id='P_ML_Q9_4' value='P_ML_Q9_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q9_5'>5 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question9' id='P_ML_Q9_5' value='P_ML_Q9_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q9_6'>6 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question9' id='P_ML_Q9_6' value='P_ML_Q9_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q9_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question9' id='P_ML_Q9_7' value='P_ML_Q9_7' required>
        </label>
      </div>
    </div>

    <label for='question10' class='questions'>I like the recipe I’ve chosen</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q10_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question10' id='P_ML_Q10_1' value='P_ML_Q10_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q10_2'>2 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question10' id='P_ML_Q10_2' value='P_ML_Q10_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q10_3'>3 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question10' id='P_ML_Q10_3' value='P_ML_Q10_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q10_4'>4 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question10' id='P_ML_Q10_4' value='P_ML_Q10_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q10_5'>5 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question10' id='P_ML_Q10_5' value='P_ML_Q10_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q10_6'>6 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question10' id='P_ML_Q10_6' value='P_ML_Q10_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q10_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question10' id='P_ML_Q10_7' value='P_ML_Q10_7' required>
        </label>
      </div>
    </div>

    <label for='question11' class='questions'>I think I will prepare the recipe I’ve chosen</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q11_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question11' id='P_ML_Q11_1' value='P_ML_Q11_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q11_2'>2 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question11' id='P_ML_Q11_2' value='P_ML_Q11_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q11_3'>3 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question11' id='P_ML_Q11_3' value='P_ML_Q11_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q11_4'>4 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question11' id='P_ML_Q11_4' value='P_ML_Q11_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q11_5'>5 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question11' id='P_ML_Q11_5' value='P_ML_Q11_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q11_6'>6 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question11' id='P_ML_Q11_6' value='P_ML_Q11_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q11_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question11' id='P_ML_Q11_7' value='P_ML_Q11_7' required>
        </label>
      </div>
    </div>

    <label for='question12' class='questions'>I know many recipes that I like more than the one I have chosen</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q12_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question12' id='P_ML_Q12_1' value='P_ML_Q12_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q12_2'>2 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question12' id='P_ML_Q12_2' value='P_ML_Q12_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q12_3'>3 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question12' id='P_ML_Q12_3' value='P_ML_Q12_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q12_4'>4 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question12' id='P_ML_Q12_4' value='P_ML_Q12_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q12_5'>5 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question12' id='P_ML_Q12_5' value='P_ML_Q12_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q12_6'>6 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question12' id='P_ML_Q12_6' value='P_ML_Q12_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q12_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question12' id='P_ML_Q12_7' value='P_ML_Q12_7' required>
        </label>
      </div>
    </div>

    <label for='question13' class='questions'>I would recommend the chosen recipe to others</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q13_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question13' id='P_ML_Q13_1' value='P_ML_Q13_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q13_2'>2 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question13' id='P_ML_Q13_2' value='P_ML_Q13_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q13_3'>3 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question13' id='P_ML_Q13_3' value='P_ML_Q13_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q13_4'>4 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question13' id='P_ML_Q13_4' value='P_ML_Q13_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q13_5'>5 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question13' id='P_ML_Q13_5' value='P_ML_Q13_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q13_6'>6 <br />
        <input class='formcheckinput' type='radio' name='P_ML_question13' id='P_ML_Q13_6' value='P_ML_Q13_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='P_ML_Q13_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='P_ML_question13' id='P_ML_Q13_7' value='P_ML_Q13_7' required>
        </label>
      </div>
    </div>

  <div style='
      display: grid;
      grid-template-columns: auto auto auto;
      justify-content: center;
      margin-top: 60px;
      grid-column-start: 1;
      grid-column-end: 6;
  '><input class='submit_button' type='submit' value='Continue' name='submit_recipe2'></div>";

echo "</div>";

?>


</form>

</body>
</html>
