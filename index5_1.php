<?php
/* ----------------NON-PERSONALIZED MULTI-LIST INTERFACE-----------------------*/
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
  $np_opt = explode("//", $_POST['select_p_sl_recipe']);
  $_SESSION['p_sl_recipe'] = $np_opt[0];
  $_SESSION['p_sl_listnr'] = $np_opt[1];
  $_SESSION['p_sl_recipenr'] = $np_opt[2];
  $_SESSION['p_sl_exp'] = $np_opt[3];
}

$array_two = $_SESSION['array_two'];

function score($a, $b) {
  if ($a['score'] == $b['score']) {
    return 0;
  }
  return ($a['score'] < $b['score']) ? 1 : -1;
}

uasort($array_two, 'score');
$sliced_array = array_slice($array_two, 0, 350, true);
$np_array = shuffle_assoc($sliced_array);

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


$np_single_list = $_SESSION['np_single_list'];


if (isset($np_single_list)) {
  if (array_key_exists('np_totalminutes_low',$np_single_list)) {
    $shuffle_np_list = shuffle_assoc($np_array);
    usort($shuffle_np_list, build_sorter('totalminutes'));
    $np_totalminuteslow = array_slice($shuffle_np_list, 0, 25, true);
    $np_single_list['np_totalminutes_low']['recipes'] = $np_totalminuteslow;
  }

  if (array_key_exists('np_totalminutes_high',$np_single_list)) {
    $shuffle_np_list = shuffle_assoc($np_array);
    usort($shuffle_np_list, high_to_low_sorter('totalminutes'));
    $np_totalminuteslow = array_slice($shuffle_np_list, 0, 25, true);
    $np_single_list['np_totalminutes_high']['recipes'] = $np_totalminuteslow;
  }

  if (array_key_exists('np_difficulty_low',$np_single_list)) {
    $shuffle_np_list = shuffle_assoc($np_array);
    usort($shuffle_np_list, build_sorter('difficulty_nr'));
    $np_difficultylow = array_slice($shuffle_np_list, 0, 25, true);
    $np_single_list['np_difficulty_low']['recipes'] = $np_difficultylow;
  }

  if (array_key_exists('np_difficulty_high',$np_single_list)) {
    $shuffle_np_list = shuffle_assoc($np_array);
    usort($shuffle_np_list, high_to_low_sorter('difficulty_nr'));
    $np_difficultyhigh = array_slice($shuffle_np_list, 0, 25, true);
    $np_single_list['np_difficulty_high']['recipes'] = $np_difficultyhigh;
  }

  if (array_key_exists('protein_low',$np_single_list)) {
    $shuffle_np_list = shuffle_assoc($np_array);
    usort($shuffle_np_list, build_sorter('proteins'));
    $np_proteinlow = array_slice($shuffle_np_list, 0, 25, true);
    $np_single_list['protein_low']['recipes'] = $np_proteinlow;
  }

  if (array_key_exists('protein_high',$np_single_list)) {
    $shuffle_np_list = shuffle_assoc($np_array);
    usort($shuffle_np_list, high_to_low_sorter('proteins'));
    $np_proteinhigh = array_slice($shuffle_np_list, 0, 25, true);
    $np_single_list['protein_high']['recipes'] = $np_proteinhigh;
  }

  if (array_key_exists('fat_low',$np_single_list)) {
    $shuffle_np_list = shuffle_assoc($np_array);
    usort($shuffle_np_list, build_sorter('fat'));
    $np_fatlow = array_slice($shuffle_np_list, 0, 25, true);
    $np_single_list['fat_low']['recipes'] = $np_fatlow;
  }

  if (array_key_exists('fat_high',$np_single_list)) {
    $shuffle_np_list = shuffle_assoc($np_array);
    usort($shuffle_np_list, high_to_low_sorter('fat'));
    $np_fathigh = array_slice($shuffle_np_list, 0, 25, true);
    $np_single_list['fat_high']['recipes'] = $np_fathigh;
  }

  if (array_key_exists('fiber_low',$np_single_list)) {
    $shuffle_np_list = shuffle_assoc($np_array);
    usort($shuffle_np_list, build_sorter('fat'));
    $np_fiberlow = array_slice($shuffle_np_list, 0, 25, true);
    $np_single_list['fiber_low']['recipes'] = $np_fiberlow;
  }

  if (array_key_exists('fiber_high',$np_single_list)) {
    $shuffle_np_list = shuffle_assoc($np_array);
    usort($shuffle_np_list, high_to_low_sorter('fiber'));
    $np_fiberhigh = array_slice($shuffle_np_list, 0, 25, true);
    $np_single_list['fiber_high']['recipes'] = $np_fiberhigh;
  }

  if (array_key_exists('calories_low',$np_single_list)) {
    $shuffle_np_list = shuffle_assoc($np_array);
    usort($shuffle_np_list, build_sorter('calories'));
    $np_calorieslow = array_slice($shuffle_np_list, 0, 25, true);
    $np_single_list['calories_low']['recipes'] = $np_calorieslow;
  }

  if (array_key_exists('calories_high',$np_single_list)) {
    $shuffle_np_list = shuffle_assoc($np_array);
    usort($shuffle_np_list, high_to_low_sorter('calories'));
    $np_calorieshigh = array_slice($shuffle_np_list, 0, 25, true);
    $np_single_list['calories_high']['recipes'] = $np_calorieshigh;
  }

  if (array_key_exists('sugar_low',$np_single_list)) {
    $shuffle_np_list = shuffle_assoc($np_array);
    usort($shuffle_np_list, build_sorter('sugars'));
    $np_sugarlow = array_slice($shuffle_np_list, 0, 25, true);
    $np_single_list['sugar_low']['recipes'] = $np_sugarlow;
  }

  if (array_key_exists('saturatedfat_low',$np_single_list)) {
    $shuffle_np_list = shuffle_assoc($np_array);
    usort($shuffle_np_list, build_sorter('saturatedfat'));
    $np_saturatedfatlow = array_slice($shuffle_np_list, 0, 25, true);
    $np_single_list['saturatedfat_low']['recipes'] = $np_saturatedfatlow;
  }

  if (array_key_exists('whoscore',$np_single_list)) {
    $shuffle_np_list = shuffle_assoc($np_array);
    usort($shuffle_np_list, high_to_low_sorter('who_score'));
    $np_whoscore = array_slice($shuffle_np_list, 0, 25, true);
    $np_single_list['whoscore']['recipes'] = $np_whoscore;
  }
}


$key_to_num = array_values($np_single_list);
echo "<form action='endsurvey2.php' method='POST'>";
echo "<div class='lists' style='margin-left:0px;'>";

echo "<h1 style='font-family: system-ui; text-align: center; font-weight: 400; grid-column-start:2; grid-column-end:5;'>Page 3/4</h1>";
echo "<h1 style='font-family: system-ui; text-align: center; font-weight: 400; grid-column-start:1; grid-column-end:6; margin-bottom: 70px;'>Again, please choose only <b>one</b> recipe that you like the most and would like to cook tomorrow night (or in the near future). Then, answer the questions at the end of the page and click ‘continue’ when finished.</h1>";

foreach ($key_to_num as $result_key => $result_value) {
  echo "<div style='grid-column-start: 1;grid-column-end: 6; font-family: system-ui; font-size: larger; font-weight: 600; margin-top: 20px; margin-bottom: -15px;'>" . $result_value['exp'] . "</div>";
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
      echo "<input type='radio' name='select_np_sl_recipe' style='position: relative; top: 5px; left: 65px;' id='" . $rp_value['title'] . "' value='" . $rp_value['title'] . "//" . $result_key . "//" . $rp_key . "//" . $result_value['exp'] . "' required>";
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
    <label class='formchecklabel' for='NP_SL_Q1_1'>1 (Completely Disagree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question1' id='NP_SL_Q1_1' value='NP_SL_Q1_1' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q1_2'>2 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question1' id='NP_SL_Q1_2' value='NP_SL_Q1_2' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q1_3'>3 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question1' id='NP_SL_Q1_3' value='NP_SL_Q1_3' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q1_4'>4 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question1' id='NP_SL_Q1_4' value='NP_SL_Q1_4' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q1_5'>5 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question1' id='NP_SL_Q1_5' value='NP_SL_Q1_5' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q1_6'>6 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question1' id='NP_SL_Q1_6' value='NP_SL_Q1_6' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q1_7'>7 (Completely Agree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question1' id='NP_SL_Q1_7' value='NP_SL_Q1_7' required>
    </label>
  </div>
</div>


<label for='question2' class='questions'>I could understand how the recipes were based on my preferences</label>
<div class='questionanswers'>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q2_1'>1 (Completely Disagree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question2' id='NP_SL_Q2_1' value='NP_SL_Q2_1' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q2_2'>2 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question2' id='NP_SL_Q2_2' value='NP_SL_Q2_2' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q2_3'>3 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question2' id='NP_SL_Q2_3' value='NP_SL_Q2_3' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q2_4'>4 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question2' id='NP_SL_Q2_4' value='NP_SL_Q2_4' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q2_5'>5 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question2' id='NP_SL_Q2_5' value='NP_SL_Q2_5' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q2_6'>6 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question2' id='NP_SL_Q2_6' value='NP_SL_Q2_6' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q2_7'>7 (Completely Agree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question2' id='NP_SL_Q2_7' value='NP_SL_Q2_7' required>
    </label>
  </div>
</div>

<label for='question3' class='questions'>The recommendation process was NOT clear to me</label>
<div class='questionanswers'>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q3_1'>1 (Completely Disagree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question3' id='NP_SL_Q3_1' value='NP_SL_Q3_1' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q3_2'>2 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question3' id='NP_SL_Q3_2' value='NP_SL_Q3_2' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q3_3'>3 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question3' id='NP_SL_Q3_3' value='NP_SL_Q3_3' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q3_4'>4 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question3' id='NP_SL_Q3_4' value='NP_SL_Q3_4' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q3_5'>5 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question3' id='NP_SL_Q3_5' value='NP_SL_Q3_5' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q3_6'>6 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question3' id='NP_SL_Q3_6' value='NP_SL_Q3_6' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q3_7'>7 (Completely Agree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question3' id='NP_SL_Q3_7' value='NP_SL_Q3_7' required>
    </label>
  </div>
</div>

<label for='question4' class='questions'>I could easily find recipes on this page</label>
<div class='questionanswers'>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q4_1'>1 (Completely Disagree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question4' id='NP_SL_Q4_1' value='NP_SL_Q4_1' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q4_2'>2 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question4' id='NP_SL_Q4_2' value='NP_SL_Q4_2' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q4_3'>3 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question4' id='NP_SL_Q4_3' value='NP_SL_Q4_3' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q4_4'>4 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question4' id='NP_SL_Q4_4' value='NP_SL_Q4_4' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q4_5'>5 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question4' id='NP_SL_Q4_5' value='NP_SL_Q4_5' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q4_6'>6 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question4' id='NP_SL_Q4_6' value='NP_SL_Q4_6' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q4_7'>7 (Completely Agree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question4' id='NP_SL_Q4_7' value='NP_SL_Q4_7' required>
    </label>
  </div>
</div>

<label for='question5' class='questions'>This page helped to discover new recipes</label>
<div class='questionanswers'>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q5_1'>1 (Completely Disagree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question5' id='NP_SL_Q5_1' value='NP_SL_Q5_1' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q5_2'>2 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question5' id='NP_SL_Q5_2' value='NP_SL_Q5_2' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q5_3'>3 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question5' id='NP_SL_Q5_3' value='NP_SL_Q5_3' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q5_4'>4 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question5' id='NP_SL_Q5_4' value='NP_SL_Q5_4' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q5_5'>5 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question5' id='NP_SL_Q5_5' value='NP_SL_Q5_5' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q5_6'>6 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question5' id='NP_SL_Q5_6' value='NP_SL_Q5_6' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q5_7'>7 (Completely Agree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question5' id='NP_SL_Q5_7' value='NP_SL_Q5_7' required>
    </label>
  </div>
</div>

<label for='question6' class='questions'>A page like this helps me make better recipe choices</label>
<div class='questionanswers'>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q6_1'>1 (Completely Disagree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question6' id='NP_SL_Q6_1' value='NP_SL_Q6_1' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q6_2'>2 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question6' id='NP_SL_Q6_2' value='NP_SL_Q6_2' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q6_3'>3 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question6' id='NP_SL_Q6_3' value='NP_SL_Q6_3' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q6_4'>4 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question6' id='NP_SL_Q6_4' value='NP_SL_Q6_4' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q6_5'>5 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question6' id='NP_SL_Q6_5' value='NP_SL_Q6_5' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q6_6'>6 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question6' id='NP_SL_Q6_6' value='NP_SL_Q6_6' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q6_7'>7 (Completely Agree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question6' id='NP_SL_Q6_7' value='NP_SL_Q6_7' required>
    </label>
  </div>
</div>

<label for='question7' class='questions'>The task of choosing a recipe was overwhelming</label>
<div class='questionanswers'>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q7_1'>1 (Completely Disagree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question7' id='NP_SL_Q7_1' value='NP_SL_Q7_1' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q7_2'>2 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question7' id='NP_SL_Q7_2' value='NP_SL_Q7_2' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q7_3'>3 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question7' id='NP_SL_Q7_3' value='NP_SL_Q7_3' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q7_4'>4 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question7' id='NP_SL_Q7_4' value='NP_SL_Q7_4' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q7_5'>5 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question7' id='NP_SL_Q7_5' value='NP_SL_Q7_5' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q7_6'>6 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question7' id='NP_SL_Q7_6' value='NP_SL_Q7_6' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q7_7'>7 (Completely Agree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question7' id='NP_SL_Q7_7' value='NP_SL_Q7_7' required>
    </label>
  </div>
</div>

<label for='question8' class='questions'>I changed my mind several times before choosing a recipe</label>
<div class='questionanswers'>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q8_1'>1 (Completely Disagree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question8' id='NP_SL_Q8_1' value='NP_SL_Q8_1' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q8_2'>2 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question8' id='NP_SL_Q8_2' value='NP_SL_Q8_2' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q8_3'>3 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question8' id='NP_SL_Q8_3' value='NP_SL_Q8_3' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q8_4'>4 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question8' id='NP_SL_Q8_4' value='NP_SL_Q8_4' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q8_5'>5 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question8' id='NP_SL_Q8_5' value='NP_SL_Q8_5' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q8_6'>6 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question8' id='NP_SL_Q8_6' value='NP_SL_Q8_6' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q8_7'>7 (Completely Agree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question8' id='NP_SL_Q8_7' value='NP_SL_Q8_7' required>
    </label>
  </div>
</div>

<label for='question9' class='questions'>Comparing the recommended recipes was easy</label>
<div class='questionanswers'>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q9_1'>1 (Completely Disagree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question9' id='NP_SL_Q9_1' value='NP_SL_Q9_1' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q9_2'>2 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question9' id='NP_SL_Q9_2' value='NP_SL_Q9_2' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q9_3'>3 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question9' id='NP_SL_Q9_3' value='NP_SL_Q9_3' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q9_4'>4 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question9' id='NP_SL_Q9_4' value='NP_SL_Q9_4' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q9_5'>5 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question9' id='NP_SL_Q9_5' value='NP_SL_Q9_5' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q9_6'>6 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question9' id='NP_SL_Q9_6' value='NP_SL_Q9_6' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q9_7'>7 (Completely Agree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question9' id='NP_SL_Q9_7' value='NP_SL_Q9_7' required>
    </label>
  </div>
</div>

<label for='question10' class='questions'>I like the recipe I’ve chosen</label>
<div class='questionanswers'>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q10_1'>1 (Completely Disagree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question10' id='NP_SL_Q10_1' value='NP_SL_Q10_1' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q10_2'>2 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question10' id='NP_SL_Q10_2' value='NP_SL_Q10_2' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q10_3'>3 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question10' id='NP_SL_Q10_3' value='NP_SL_Q10_3' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q10_4'>4 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question10' id='NP_SL_Q10_4' value='NP_SL_Q10_4' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q10_5'>5 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question10' id='NP_SL_Q10_5' value='NP_SL_Q10_5' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q10_6'>6 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question10' id='NP_SL_Q10_6' value='NP_SL_Q10_6' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q10_7'>7 (Completely Agree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question10' id='NP_SL_Q10_7' value='NP_SL_Q10_7' required>
    </label>
  </div>
</div>

<label for='question11' class='questions'>I think I will prepare the recipe I’ve chosen</label>
<div class='questionanswers'>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q11_1'>1 (Completely Disagree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question11' id='NP_SL_Q11_1' value='NP_SL_Q11_1' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q11_2'>2 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question11' id='NP_SL_Q11_2' value='NP_SL_Q11_2' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q11_3'>3 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question11' id='NP_SL_Q11_3' value='NP_SL_Q11_3' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q11_4'>4 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question11' id='NP_SL_Q11_4' value='NP_SL_Q11_4' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q11_5'>5 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question11' id='NP_SL_Q11_5' value='NP_SL_Q11_5' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q11_6'>6 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question11' id='NP_SL_Q11_6' value='NP_SL_Q11_6' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q11_7'>7 (Completely Agree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question11' id='NP_SL_Q11_7' value='NP_SL_Q11_7' required>
    </label>
  </div>
</div>

<label for='question12' class='questions'>I know many recipes that I like more than the one I have chosen</label>
<div class='questionanswers'>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q12_1'>1 (Completely Disagree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question12' id='NP_SL_Q12_1' value='NP_SL_Q12_1' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q12_2'>2 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question12' id='NP_SL_Q12_2' value='NP_SL_Q12_2' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q12_3'>3 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question12' id='NP_SL_Q12_3' value='NP_SL_Q12_3' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q12_4'>4 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question12' id='NP_SL_Q12_4' value='NP_SL_Q12_4' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q12_5'>5 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question12' id='NP_SL_Q12_5' value='NP_SL_Q12_5' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q12_6'>6 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question12' id='NP_SL_Q12_6' value='NP_SL_Q12_6' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q12_7'>7 (Completely Agree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question12' id='NP_SL_Q12_7' value='NP_SL_Q12_7' required>
    </label>
  </div>
</div>

<label for='question13' class='questions'>I would recommend the chosen recipe to others</label>
<div class='questionanswers'>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q13_1'>1 (Completely Disagree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question13' id='NP_SL_Q13_1' value='NP_SL_Q13_1' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q13_2'>2 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question13' id='NP_SL_Q13_2' value='NP_SL_Q13_2' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q13_3'>3 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question13' id='NP_SL_Q13_3' value='NP_SL_Q13_3' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q13_4'>4 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question13' id='NP_SL_Q13_4' value='NP_SL_Q13_4' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q13_5'>5 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question13' id='NP_SL_Q13_5' value='NP_SL_Q13_5' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q13_6'>6 <br />
    <input class='formcheckinput' type='radio' name='NP_SL_question13' id='NP_SL_Q13_6' value='NP_SL_Q13_6' required>
    </label>
  </div>
  <div class='radioquestion'>
    <label class='formchecklabel' for='NP_SL_Q13_7'>7 (Completely Agree)<br />
    <input class='formcheckinput' type='radio' name='NP_SL_question13' id='NP_SL_Q13_7' value='NP_SL_Q13_7' required>
    </label>
  </div>
</div>

<div style='
    display: grid;
    grid-template-columns: auto auto auto;
    justify-content: center;
    margin-top: 60px;
    grid-column-start: 1;
    grid-column-end: 6;'><input class='submit_button_sl' style='margin-left:0;' type='submit' value='Continue' name='submit_recipe'></div>";

echo "</div>";


?>

</form>
</body>
</html>
