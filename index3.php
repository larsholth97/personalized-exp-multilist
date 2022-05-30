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

if(isset($_POST['onsubmit'])) {

  #Cooking time
  $cookingtime = $_POST['cookingtime'];
  $_SESSION['cookingtime'] = $_POST['cookingtime'];

  #Dietary restrictions
  $diabetes = $_POST['diabetes'];
  $veggie = $_POST['veggie'];
  $lactose = $_POST['lactose'];
  $gluten = $_POST['gluten'];

  #Cooking cooking difficulty
  $cookingdifficulty = $_POST['difficulty'];
  $_SESSION['difficulty'] = $_POST['difficulty'];

  #Dietary goal
  $dietarygoal = $_POST['dietarygoal'];
  $_SESSION['dietarygoal'] = $_POST['dietarygoal'];

  #Eating habits
  $eatinghabits = $_POST['eatinghabits'];
  $_SESSION['eatinghabits'] = $_POST['eatinghabits'];

  #Importance of healthy eating
  $healthyeating = $_POST['healthyeating'];
  $_SESSION['healthyeating'] = $_POST['healthyeating'];

  #Physical activity
  $activity = $_POST['activity'];
  $_SESSION['activity'] = $_POST['activity'];

  #BMI Calculation
  $height= $_POST['height'];
  $_SESSION['height'] = $_POST['height'];
  $weight = $_POST['weight'];
  $_SESSION['weight'] = $_POST['weight'];

  $ageOption = $_POST['ageOption'];
  $_SESSION['ageOption'] = $_POST['ageOption'];
  $sexOption = $_POST['sexOption'];
  $_SESSION['sexOption'] = $_POST['sexOption'];
  $recipenutri = $_POST['recipenutrients'];
  $_SESSION['recipenutrients'] = $_POST['recipenutrients'];


  $index = 0;
  if($height !=0 && $weight !=0) {
    $index = round($weight/($height*$height) * 10000);
  }

  #BMI classification
  if ($index < 18) {
    $bmi = "underweight";
  } else if ($index < 25) {
    $bmi = "normal";
  } else if ($index < 30) {
    $bmi = "pre_overweight";
  } else if ($index < 35) {
    $bmi = "overweight";
  } else {
    $bmi = "obese";
  }

  #Query variables
  $where = [];
  $query = "";

  if (!empty($_POST['diabetes'])) $where[] = "fat <= '14' AND saturatedfat <= '4.5' AND sugars <= '14.75' AND sodium <= '500'";
  if (!empty($_POST['veggie'])) $where[] = "isvegetarian='1'";
  if (!empty($_POST['lactose'])) $where[] = "islactosefree='1'";
  if (!empty($_POST['gluten'])) $where[] = "isglutenfree='1'";

  if (!empty($where)) {
    $query = "WHERE " . implode(" AND ", $where);
  }

  $implode_array = implode(",",$where);
  $diet_restriction = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $implode_array);
  $_SESSION['diet_restriction'] = $diet_restriction;

  $sql = "SELECT title, imageurl, description, totalminutes, calories, carbohydrates,
                sugars, proteins, fat, saturatedfat,
                fibers, cholesterol, sodium, difficulty
                FROM recipe_dataset $query";

  $result = pg_query($conn, $sql);
  $recipes = array();
  if (pg_num_rows($result) > 0) {
    while ($row = pg_fetch_array($result)) {
      $recipes[] = $row;
    }
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



  #Add a score column to array
  $newlist = array();
  foreach ($recipes as $recipe) {
    $score = 0;
    $key = 'score';
    $recipe[$key] = $score;
    $recipe['difficulty_nr'] = 0;

####################################################################################################
# CALCULATE WHO SCORE #
####################################################################################################

    $gen_carb_perc = $recipe['carbohydrates']*4/$recipe['calories']*100;
    $gen_sugar_perc = $recipe['sugars']*4/$recipe['calories']*100;
    $gen_prot_perc = $recipe['proteins']*4/$recipe['calories']*100;
    $gen_fat_perc = $recipe['fat']*9/$recipe['calories']*100;
    $gen_satfat_perc = $recipe['saturatedfat']*9/$recipe['calories']*100;
    $gen_fiber_dens = $recipe['fibers']/($recipe['calories']/238.84);
    $gen_sodium_dens = $recipe['sodium']/($recipe['calories']/238.84);

    $recipe['who_score'] = 0;
    if ($gen_prot_perc >= 10.0 && $gen_prot_perc <= 15.0) {
      $recipe['who_score'] += 1;
    }

    if ($gen_carb_perc >= 55.0 && $gen_carb_perc <= 75.0) {
      $recipe['who_score'] += 1;
    }

    if ($gen_sugar_perc < 10) {
      $recipe['who_score'] += 1;
    }

    if ($gen_fat_perc >= 15.0 && $gen_fat_perc <= 30.0) {
      $recipe['who_score'] += 1;
    }

    if ($gen_satfat_perc < 10) {
      $recipe['who_score'] += 1;
    }
####################################################################################################
# COOKING DIFFICULTY #
####################################################################################################

    if ($cookingdifficulty == 1) {
      if ($recipe['difficulty'] == 'Very easy') {
        $recipe['difficulty_nr'] += 1;
        $recipe['score'] += 4;
      }
      if ($recipe['difficulty'] == 'Easy') {
        $recipe['difficulty_nr'] += 2;
        $recipe['score'] += 3;
      }
      if ($recipe['difficulty'] == 'Medium') {
        $recipe['difficulty_nr'] += 3;
        $recipe['score'] += 2;
      }
      if ($recipe['difficulty'] == 'Hard') {
        $recipe['difficulty_nr'] += 4;
        $recipe['score'] += 1;
      }
    }

    if ($cookingdifficulty == 2) {
      if ($recipe['difficulty'] == 'Very easy') {
        $recipe['difficulty_nr'] += 1;
        $recipe['score'] += 3;
      }
      if ($recipe['difficulty'] == 'Easy') {
        $recipe['difficulty_nr'] += 2;
        $recipe['score'] += 4;
      }
      if ($recipe['difficulty'] == 'Medium') {
        $recipe['difficulty_nr'] += 3;
        $recipe['score'] += 2;
      }
      if ($recipe['difficulty'] == 'Hard') {
        $recipe['difficulty_nr'] += 4;
        $recipe['score'] += 1;
      }
    }

    if ($cookingdifficulty == 3) {
      if ($recipe['difficulty'] == 'Very easy') {
        $recipe['difficulty_nr'] += 1;
        $recipe['score'] += 1;
      }
      if ($recipe['difficulty'] == 'Easy') {
        $recipe['difficulty_nr'] += 2;
        $recipe['score'] += 3;
      }
      if ($recipe['difficulty'] == 'Medium') {
        $recipe['difficulty_nr'] += 3;
        $recipe['score'] += 4;
      }
      if ($recipe['difficulty'] == 'Hard') {
        $recipe['difficulty_nr'] += 4;
        $recipe['score'] += 2;
      }
    }

    if ($cookingdifficulty == 4) {
      if ($recipe['difficulty'] == 'Very easy') {
        $recipe['difficulty_nr'] += 1;
        $recipe['score'] += 1;
      }
      if ($recipe['difficulty'] == 'Easy') {
        $recipe['difficulty_nr'] += 2;
        $recipe['score'] += 2;
      }
      if ($recipe['difficulty'] == 'Medium') {
        $recipe['difficulty_nr'] += 3;
        $recipe['score'] += 3;
      }
      if ($recipe['difficulty'] == 'Hard') {
        $recipe['difficulty_nr'] += 4;
        $recipe['score'] += 4;
      }
    }


####################################################################################################
# TOTAL MINUTES #
####################################################################################################

    if ($cookingtime >= $recipe['totalminutes']) {
      $recipe['score'] += 8;
    }

####################################################################################################
# DIET GOALS #
####################################################################################################

    if ($dietarygoal == -1) {
      if ($recipe['fat'] <= 15) {
        $recipe['score'] += 4;
      }
      if ($recipe['calories'] <= 550) {
        $recipe['score'] += 4;
      }
      if ($recipe['carbohydrates'] <= 23) {
        $recipe['score'] += 4;
      }
      if ($recipe['saturatedfat'] <= 8) {
        $recipe['score'] += 4;
      }
      if ($recipe['sugars'] <= 8) {
        $recipe['score'] += 4;
      }
    }

    if ($dietarygoal == 1) {
      if ($recipe['fat'] >= 15) {
        $recipe['score'] += 4;
      }
      if ($recipe['calories'] >= 550) {
        $recipe['score'] += 4;
      }
    }

    if ($dietarygoal == 0) {
      $recipe['score'] += 0;
    }

####################################################################################################
# EATING HABITS #
####################################################################################################

    if ($eatinghabits == 1) {
      if ($recipe['fat'] <= 15) {
        $recipe['score'] += 5;
      }
      if ($recipe['fat'] >= 15) {
        $recipe['score'] += 1;
      }
      if ($recipe['calories'] <= 550) {
        $recipe['score'] += 5;
      }
      if ($recipe['calories'] >= 550) {
        $recipe['score'] += 1;
      }
      if ($recipe['carbohydrates'] <= 23) {
        $recipe['score'] += 5;
      }
      if ($recipe['carbohydrates'] >= 23) {
        $recipe['score'] += 1;
      }
      if ($recipe['saturatedfat'] <= 8) {
        $recipe['score'] += 5;
      }
      if ($recipe['saturatedfat'] >= 8) {
        $recipe['score'] += 1;
      }
      if ($recipe['sugars'] <= 8) {
        $recipe['score'] += 5;
      }
      if ($recipe['sugars'] >= 8) {
        $recipe['score'] += 1;
      }
    }

    if ($eatinghabits == 2) {
      if ($recipe['fat'] <= 23) {
        $recipe['score'] += 4;
      }
      if ($recipe['fat'] >= 23) {
        $recipe['score'] += 2;
      }
      if ($recipe['calories'] <= 650) {
        $recipe['score'] += 4;
      }
      if ($recipe['calories'] >= 650) {
        $recipe['score'] += 2;
      }
      if ($recipe['carbohydrates'] <= 28) {
        $recipe['score'] += 4;
      }
      if ($recipe['carbohydrates'] >= 28) {
        $recipe['score'] += 2;
      }
      if ($recipe['saturatedfat'] <= 11) {
        $recipe['score'] += 4;
      }
      if ($recipe['saturatedfat'] >= 11) {
        $recipe['score'] += 2;
      }
      if ($recipe['sugars'] <= 9) {
        $recipe['score'] += 4;
      }
      if ($recipe['sugars'] >= 9) {
        $recipe['score'] += 2;
      }
    }

    if ($eatinghabits == 3) {
      if ($recipe['fat'] <= 25) {
        $recipe['score'] += 3;
      }
      if ($recipe['fat'] >= 25) {
        $recipe['score'] += 4;
      }
      if ($recipe['calories'] <= 700) {
        $recipe['score'] += 3;
      }
      if ($recipe['calories'] >= 700) {
        $recipe['score'] += 4;
      }
      if ($recipe['carbohydrates'] <= 35) {
        $recipe['score'] += 3;
      }
      if ($recipe['carbohydrates'] >= 35) {
        $recipe['score'] += 4;
      }
      if ($recipe['saturatedfat'] <= 13) {
        $recipe['score'] += 3;
      }
      if ($recipe['saturatedfat'] >= 13) {
        $recipe['score'] += 4;
      }
      if ($recipe['sugars'] <= 12) {
        $recipe['score'] += 3;
      }
      if ($recipe['sugars'] >= 12) {
        $recipe['score'] += 4;
      }
    }

    if ($eatinghabits == 4) {
      if ($recipe['fat'] <= 35)  {
        $recipe['score'] += 2;
      }
      if ($recipe['fat'] >= 35)  {
        $recipe['score'] += 4;
      }
      if ($recipe['calories'] <= 750) {
        $recipe['score'] += 2;
      }
      if ($recipe['calories'] >= 750) {
        $recipe['score'] += 4;
      }
      if ($recipe['carbohydrates'] <= 45) {
        $recipe['score'] += 2;
      }
      if ($recipe['carbohydrates'] >= 45) {
        $recipe['score'] += 4;
      }
      if ($recipe['saturatedfat'] <= 18) {
        $recipe['score'] += 2;
      }
      if ($recipe['saturatedfat'] >= 18) {
        $recipe['score'] += 4;
      }
      if ($recipe['sugars'] <= 18) {
        $recipe['score'] += 2;
      }
      if ($recipe['sugars'] >= 18) {
        $recipe['score'] += 4;
      }
    }

    if ($eatinghabits == 5) {
      if ($recipe['fat'] <= 45) {
        $recipe['score'] += 1;
      }
      if ($recipe['fat'] >= 45) {
        $recipe['score'] += 5;
      }
      if ($recipe['calories'] <= 850) {
        $recipe['score'] += 1;
      }
      if ($recipe['calories'] >= 850) {
        $recipe['score'] += 5;
      }
      if ($recipe['carbohydrates'] <= 55) {
        $recipe['score'] += 1;
      }
      if ($recipe['carbohydrates'] >= 55) {
        $recipe['score'] += 5;
      }
      if ($recipe['saturatedfat'] <= 24) {
        $recipe['score'] += 1;
      }
      if ($recipe['saturatedfat'] >= 24) {
        $recipe['score'] += 5;
      }
      if ($recipe['sugars'] <= 24) {
        $recipe['score'] += 1;
      }
      if ($recipe['sugars'] >= 24) {
        $recipe['score'] += 5;
      }
    }

####################################################################################################
# ACTIVITY AND BMI #
####################################################################################################

    if (($activity == 1 || $activity == 2) && $bmi == "underweight") {
      if ($recipe['proteins'] >= 38) {
        $recipe['score'] += 5;
      }
      if ($recipe['fat'] >= 30) {
        $recipe['score'] += 5;
      }
      if ($recipe['fibers'] >= 4) {
        $recipe['score'] += 5;
      }
    }

    if ($activity == 3 && $bmi == "underweight") {
      if ($recipe['proteins'] <= 38) {
        $recipe['score'] += 5;
      }
      if ($recipe['fat'] <= 30) {
        $recipe['score'] += 5;
      }
      if ($recipe['fibers'] <= 6) {
        $recipe['score'] += 5;
      }
    }

    if ($activity == 1 && $bmi == "normal") {
      if ($recipe['proteins'] >= 38) {
        $recipe['score'] += 4;
      }
      if ($recipe['fat'] >= 30) {
        $recipe['score'] += 4;
      }
      if ($recipe['fibers'] >= 4) {
        $recipe['score'] += 4;
      }
    }

    if (($activity == 2 || $activity == 3) && $bmi == "normal") {
      if ($recipe['proteins'] <= 38) {
        $recipe['score'] += 4;
      }
      if ($recipe['fat'] <= 25) {
        $recipe['score'] += 4;
      }
      if ($recipe['fibers'] <= 5) {
        $recipe['score'] += 4;
      }
    }

    if ($activity == 1 && $bmi == "pre_overweight") {
      if ($recipe['calories'] <= 750) {
        $recipe['score'] += 3;
      }
      if ($recipe['fat'] <= 30) {
        $recipe['score'] += 3;
      }
      if ($recipe['sugar'] <= 5) {
        $recipe['score'] += 3;
      }
    }

    if (($activity == 2 || $activity == 3) && $bmi == "pre_overweight") {
      if ($recipe['calories'] <= 650) {
        $recipe['score'] += 3;
      }
      if ($recipe['fat'] <= 20) {
        $recipe['score'] += 3;
      }
      if ($recipe['sugar'] <= 5) {
        $recipe['score'] += 3;
      }
    }

    if ($activity == 1 && $bmi == "overweight") {
      if ($recipe['calories'] <= 650) {
        $recipe['score'] += 4;
      }
      if ($recipe['fat'] <= 20) {
        $recipe['score'] += 4;
      }
      if ($recipe['sugar'] <= 4) {
        $recipe['score'] += 4;
      }
    }

    if (($activity == 2 || $activity == 3) && $bmi == "overweight") {
      if ($recipe['calories'] <= 550) {
        $recipe['score'] += 4;
      }
      if ($recipe['fat'] <= 15) {
        $recipe['score'] += 4;
      }
      if ($recipe['sugar'] <= 4) {
        $recipe['score'] += 4;
      }
    }

    if ($activity == 1 && $bmi == "obese") {
      if ($recipe['calories'] <= 450) {
        $recipe['score'] += 5;
      }
      if ($recipe['fat'] <= 15) {
        $recipe['score'] += 5;
      }
      if ($recipe['sugar'] <= 3) {
        $recipe['score'] += 5;
      }
    }

    if (($activity == 2 || $activity == 3) && $bmi == "obese") {
      if ($recipe['calories'] <= 350) {
        $recipe['score'] += 5;
      }
      if ($recipe['fat'] <= 10) {
        $recipe['score'] += 5;
      }
      if ($recipe['sugar'] <= 3) {
        $recipe['score'] += 5;
      }
    }

####################################################################################################
# LIST CREATION #
####################################################################################################

    #New array with score
    $newlist[] = $recipe;
    #Shuffle recipe dataset
    $shuffling_all_recipes = shuffle_assoc($newlist);

    #Split recipe dataset in two
    list($array_one, $array_two) = array_chunk($shuffling_all_recipes, ceil(count($shuffling_all_recipes) / 2));

    $_SESSION['array_two'] = $array_two;
  }

  #Rank array based on score
  function score($a, $b) {
    if ($a['score'] == $b['score']) {
      return 0;
    }
    return ($a['score'] < $b['score']) ? 1 : -1;
  }

  uasort($array_one, 'score');
  $sliced_array = array_slice($array_one, 0, 350, true);
  $np_shuffle = shuffle_assoc($sliced_array);


  #Sorting from low to high
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


#################################################################################
# CREATING EXPLANATIONS ACROSS CONDITIONS #
#################################################################################

if ($eatinghabits == 1 || $eatinghabits == 2) {
  $habits_exp = ['exp' => 'Healthy Recipes That Could Improve Your Unhealthy Eating Habits'];
  $habits_unhealthy['habits_unhealthy'] = $habits_exp;

  $np_whoscore_low = ['exp' => 'Healthy Recipes That Meet Dietary Intake Guidelines'];
  $np_recipe_list['whoscore'] = $np_whoscore_low;
}

if ($eatinghabits == 3 || $eatinghabits == 4 || $eatinghabits == 5) {
  $habits_exp = ['exp' => 'Healthy Recipes That Are in Line With Your Healthy Eating Habits'];
  $habits_healthy['habits_healthy'] = $habits_exp;

  $np_whoscore_low = ['exp' => 'Healthy Recipes That Meet Dietary Intake Guidelines'];
  $np_recipe_list['whoscore'] = $np_whoscore_low;
}

if ($cookingtime <= 50) {
  $cookingtime_exp = ['exp' => 'Recipes With a Rather Short Cooking Time, Which Matches Your Preferences'];
  $totalminutes_low['totalminutes_low'] = $cookingtime_exp;

  $np_totalminutes_low = ['exp' => 'Recipes With a Short Cooking Time'];
  $np_recipe_list['np_totalminutes_low'] = $np_totalminutes_low;
}

if ($cookingtime >= 51) {
  $cookingtime_exp = ['exp' => 'Recipes With a Long Cooking Time, but No Longer Than Your Preferred Cooking Time'];
  $totalminutes_high['totalminutes_high'] = $cookingtime_exp;

  $np_totalminutes_high = ['exp' => 'Recipes With a Long Cooking Time'];
  $np_recipe_list['np_totalminutes_high'] = $np_totalminutes_high;
}

if ($cookingdifficulty == 1) {
  $difficulty_exp = ['exp' => 'These Recipes Are Very Easy to Prepare, Which Matches Your Low Level of Cooking Experience'];
  $difficulty_low['difficulty_low'] = $difficulty_exp;

  $np_difficulty_low = ['exp' => 'Recipes That Are Easy to Cook'];
  $np_recipe_list['np_difficulty_low'] = $np_difficulty_low;
}
if ($cookingdifficulty == 2) {
  $difficulty_exp = ['exp' => 'These Recipes Are Easy to Prepare, Which Matches Your Low Level of Cooking Experience'];
  $difficulty_low['difficulty_low'] = $difficulty_exp;

  $np_difficulty_low = ['exp' => 'Recipes That Are Easy to Cook'];
  $np_recipe_list['np_difficulty_low'] = $np_difficulty_low;
}

if ($cookingdifficulty == 3 || $cookingdifficulty == 4) {
  $difficulty_exp = ['exp' => 'These Recipes Are Rather Challenging to Prepare, but Match Your Level of Cooking Experience'];
  $difficulty_high['difficulty_high'] = $difficulty_exp;

  $np_difficulty_high = ['exp' => 'Challenging Recipes to Try'];
  $np_recipe_list['np_difficulty_high'] = $np_difficulty_high;
}

if (($activity == 1 || $activity == 2) && $bmi == "underweight") {
  $activity_exp_protein = ['exp' => 'High-Protein Recipes That Match Your Body Mass Index and High Level of Physical Activity'];
  $protein_high['activity_protein_high'] = $activity_exp_protein;
  $activity_exp_fat = ['exp' => 'High-Fat Recipes That Match Your Body Mass Index and High Level of Physical Activity'];
  $fat_high['activity_fat_high_low'] = $activity_exp_fat;
  $activity_exp_fiber = ['exp' => 'High-Fiber Recipes That Match Your Body Mass Index and High Level of Physical Activity'];
  $fiber_high['activity_fibre_high_low'] = $activity_exp_fiber;

  $np_protein_high = ['exp' => 'High-Protein Recipes'];
  $np_recipe_list['protein_high'] = $np_protein_high;

  $np_fat_high = ['exp' => 'High-Fat Recipes'];
  $np_recipe_list['fat_high'] = $np_fat_high;

  $np_fiber_high = ['exp' => 'High-Fiber Recipes'];
  $np_recipe_list['fiber_high'] = $np_fiber_high;
}

if ($activity == 3 && $bmi == "underweight") {
  $activity_exp_protein = ['exp' => 'High-Protein Recipes That Match Your Body Mass Index and Low Level of Physical Activity'];
  $protein_high['activity_protein_high'] = $activity_exp_protein;
  $activity_exp_fat = ['exp' => 'High-Fat Recipes That Match Your Body Mass Index and Low Level of Physical Activity'];
  $fat_high['activity_fat_high_low'] = $activity_exp_fat;
  $activity_exp_fiber = ['exp' => 'High-Fiber Recipes That Match Your Body Mass Index and Low Level of Physical Activity'];
  $fiber_high['activity_fibre_high_low'] = $activity_exp_fiber;

  $np_protein_high = ['exp' => 'High-Protein Recipes'];
  $np_recipe_list['protein_high'] = $np_protein_high;

  $np_fat_high = ['exp' => 'High-Fat Recipes'];
  $np_recipe_list['fat_high'] = $np_fat_high;

  $np_fiber_high = ['exp' => 'High-Fiber Recipes'];
  $np_recipe_list['fiber_high'] = $np_fiber_high;
}

if (($activity == 1 || $activity == 2) && $bmi == "normal") {
  $activity_exp_calories = ['exp' => 'Low-Calorie Recipes That Match Your Body Mass Index and High Level of Physical Activity'];
  $calories_low['activity_calories'] = $activity_exp_calories;
  $activity_exp_fat = ['exp' => 'Low-Fat Recipes That Match Your Body Mass Index and High Level of Physical Activity'];
  $fat_high['activity_fat_high_low'] = $activity_exp_fat;
  $activity_exp_sugars = ['exp' => 'Low-Sugar Recipes That Match Your Body Mass Index and High Level of Physical Activity'];
  $sugar_low['activity_sugars'] = $activity_exp_sugars;

  $np_calories_low = ['exp' => 'Low-Calorie Recipes'];
  $np_recipe_list['calories_low'] = $np_calories_low;

  $np_fat_low = ['exp' => 'Low-Fat Recipes'];
  $np_recipe_list['fat_low'] = $np_fat_low;

  $np_sugar_low = ['exp' => 'Low-Sugar Recipes'];
  $np_recipe_list['sugar_low'] = $np_sugar_low;
}

if ($activity == 3 && $bmi == "normal") {
  $activity_exp_calories = ['exp' => 'Low-Calorie Recipes That Match Your Body Mass Index and Low Level of Physical Activity'];
  $calories_low['activity_calories'] = $activity_exp_calories;
  $activity_exp_fat = ['exp' => 'Low-Fat Recipes That Match Your Body Mass Index and Low Level of Physical Activity'];
  $fat_low['activity_fat_low_high'] = $activity_exp_fat;
  $activity_exp_sugars = ['exp' => 'Low-Sugar Recipes That Match Your Body Mass Index and Low Level of Physical Activity'];
  $sugar_low['activity_sugars'] = $activity_exp_sugars;

  $np_calories_low = ['exp' => 'Low-Calorie Recipes'];
  $np_recipe_list['calories_low'] = $np_calories_low;

  $np_fat_low = ['exp' => 'Low-Fat Recipes'];
  $np_recipe_list['fat_low'] = $np_fat_low;

  $np_sugar_low = ['exp' => 'Low-Sugar Recipes'];
  $np_recipe_list['sugar_low'] = $np_sugar_low;
}

if (($activity == 1 || $activity == 2) && $bmi == "pre_overweight") {
  $activity_exp_calories = ['exp' => 'Low-Calorie Recipes That Match Your Body Mass Index and High Level of Physical Activity'];
  $calories_low['activity_calories'] = $activity_exp_calories;
  $activity_exp_fat = ['exp' => 'Low-Fat Recipes That Match Your Body Mass Index and High Level of Physical Activity'];
  $fat_low['activity_fat_low_high'] = $activity_exp_fat;
  $activity_exp_sugars = ['exp' => 'Low-Sugar Recipes That Match Your Body Mass Index and High Level of Physical Activity'];
  $sugar_low['activity_sugars'] = $activity_exp_sugars;

  $np_calories_low = ['exp' => 'Low-Calorie Recipes'];
  $np_recipe_list['calories_low'] = $np_calories_low;

  $np_fat_low = ['exp' => 'Low-Fat Recipes'];
  $np_recipe_list['fat_low'] = $np_fat_low;

  $np_sugar_low = ['exp' => 'Low-Sugar Recipes'];
  $np_recipe_list['sugar_low'] = $np_sugar_low;
}

if ($activity == 3 && $bmi == "pre_overweight") {
  $activity_exp_calories = ['exp' => 'Low-Calorie Recipes That Match Your Body Mass Index and Low Level of Physical Activity'];
  $calories_low['activity_calories'] = $activity_exp_calories;
  $activity_exp_fat = ['exp' => 'Low-Fat Recipes That Match Your Body Mass Index and Low Level of Physical Activity'];
  $fat_low['activity_fat_low_high'] = $activity_exp_fat;
  $activity_exp_sugars = ['exp' => 'Low-Sugar Recipes That Match Your Body Mass Index and Low Level of Physical Activity'];
  $sugar_low['activity_sugars'] = $activity_exp_sugars;

  $np_calories_low = ['exp' => 'Low-Calorie Recipes'];
  $np_recipe_list['calories_low'] = $np_calories_low;

  $np_fat_low = ['exp' => 'Low-Fat Recipes'];
  $np_recipe_list['fat_low'] = $np_fat_low;

  $np_sugar_low = ['exp' => 'Low-Sugar Recipes'];
  $np_recipe_list['sugar_low'] = $np_sugar_low;
}

if (($activity == 1 || $activity == 2) && $bmi == "overweight") {
  $activity_exp_calories = ['exp' => 'Low-Calorie Recipes That Match Your Body Mass Index and High Level of Physical Activity'];
  $calories_low['activity_calories'] = $activity_exp_calories;
  $activity_exp_fat = ['exp' => 'Low-Fat Recipes That Match Your Body Mass Index and High Level of Physical Activity'];
  $fat_low['activity_fat_low_high'] = $activity_exp_fat;
  $activity_exp_sugars = ['exp' => 'Low-Sugar Recipes That Match Your Body Mass Index and High Level of Physical Activity'];
  $sugar_low['activity_sugars'] = $activity_exp_sugars;

  $np_calories_low = ['exp' => 'Low-Calorie Recipes'];
  $np_recipe_list['calories_low'] = $np_calories_low;

  $np_fat_low = ['exp' => 'Low-Fat Recipes'];
  $np_recipe_list['fat_low'] = $np_fat_low;

  $np_sugar_low = ['exp' => 'Low-Sugar Recipes'];
  $np_recipe_list['sugar_low'] = $np_sugar_low;
}

if ($activity == 3 && $bmi == "overweight") {
  $activity_exp_calories = ['exp' => 'Low-Calorie Recipes That Match Your Body Mass Index and Low Level of Physical Activity'];
  $calories_low['activity_calories'] = $activity_exp_calories;
  $activity_exp_fat = ['exp' => 'Low-Fat Recipes That Match Your Body Mass Index and Low Level of Physical Activity'];
  $fat_low['activity_fat_low_high'] = $activity_exp_fat;
  $activity_exp_sugars = ['exp' => 'Low-Sugar Recipes That Match Your Body Mass Index and Low Level of Physical Activity'];
  $sugar_low['activity_sugars'] = $activity_exp_sugars;

  $np_calories_low = ['exp' => 'Low-Calorie Recipes'];
  $np_recipe_list['calories_low'] = $np_calories_low;

  $np_fat_low = ['exp' => 'Low-Fat Recipes'];
  $np_recipe_list['fat_low'] = $np_fat_low;

  $np_sugar_low = ['exp' => 'Low-Sugar Recipes'];
  $np_recipe_list['sugar_low'] = $np_sugar_low;
}

if (($activity == 1 || $activity == 2) && $bmi == "obese") {
  $activity_exp_calories = ['exp' => 'Low-Calorie Recipes That Match Your Body Mass Index and High Level of Physical Activity'];
  $calories_low['activity_calories'] = $activity_exp_calories;
  $activity_exp_fat = ['exp' => 'Low-Fat Recipes That Match Your Body Mass Index and High Level of Physical Activity'];
  $fat_low['activity_fat_low_high'] = $activity_exp_fat;
  $activity_exp_sugars = ['exp' => 'Low-Sugar Recipes That Match Your Body Mass Index and High Level of Physical Activity'];
  $sugar_low['activity_sugars'] = $activity_exp_sugars;

  $np_calories_low = ['exp' => 'Low-Calorie Recipes'];
  $np_recipe_list['calories_low'] = $np_calories_low;

  $np_fat_low = ['exp' => 'Low-Fat Recipes'];
  $np_recipe_list['fat_low'] = $np_fat_low;

  $np_sugar_low = ['exp' => 'Low-Sugar Recipes'];
  $np_recipe_list['sugar_low'] = $np_sugar_low;
}

if ($activity == 3 && $bmi == "obese") {
  $activity_exp_calories = ['exp' => 'Low-Calorie Recipes That Match Your Body Mass Index and Low Level of Physical Activity'];
  $calories_low['activity_calories'] = $activity_exp_calories;
  $activity_exp_fat = ['exp' => 'Low-Fat Recipes That Match Your Body Mass Index and Low Level of Physical Activity'];
  $fat_low['activity_fat_low_high'] = $activity_exp_fat;
  $activity_exp_sugars = ['exp' => 'Low-Sugar Recipes That Match Your Body Mass Index and Low Level of Physical Activity'];
  $sugar_low['activity_sugars'] = $activity_exp_sugars;

  $np_calories_low = ['exp' => 'Low-Calorie Recipes'];
  $np_recipe_list['calories_low'] = $np_calories_low;

  $np_fat_low = ['exp' => 'Low-Fat Recipes'];
  $np_recipe_list['fat_low'] = $np_fat_low;

  $np_sugar_low = ['exp' => 'Low-Sugar Recipes'];
  $np_recipe_list['sugar_low'] = $np_sugar_low;
}

if ($dietarygoal == -1) {
  $dietarygoal_exp_saturatedfat = ['exp' => 'Recipes Low in Saturated Fat That Match Your Weight-Loss Goal'];
  $saturatedfat_low['dietarygoal_saturatedfat'] = $dietarygoal_exp_saturatedfat;
  $dietarygoal_exp_fat = ['exp' => 'Low-Fat Recipes That Match Your Weight-Loss Goal'];
  $fat_low['dietarygoal_fat_low_high'] = $dietarygoal_exp_fat;
  $dietarygoal_exp_calories = ['exp' => 'Low-Calorie Recipes That Match Your Weight-Loss Goal'];
  $calories_low['dietarygoal_calories'] = $dietarygoal_exp_calories;

  $np_calories_low = ['exp' => 'Low-Calorie Recipes'];
  $np_recipe_list['calories_low'] = $np_calories_low;

  $np_fat_low = ['exp' => 'Low-Fat Recipes'];
  $np_recipe_list['fat_low'] = $np_fat_low;

  $np_saturatedfat_low = ['exp' => 'Recipes Low in Saturated Fat'];
  $np_recipe_list['saturatedfat_low'] = $np_saturatedfat_low;
}

if ($dietarygoal == 1) {
  $dietarygoal_exp_protein = ['exp' => 'High-Protein Recipes That Match Your Weight-Gain Goal'];
  $protein_high['dietarygoal_protein_high'] = $dietarygoal_exp_protein;
  $dietarygoal_exp_fat = ['exp' => 'High-Fat Recipes That Match Your Weight-Gain Goal'];
  $fat_high['dietarygoal_fat_high_low'] = $dietarygoal_exp_fat;
  $dietarygoal_exp_calories = ['exp' => 'High-Calorie Recipes That Match Your Weight-Gain Goal'];
  $calories_high['dietarygoal_calories_high'] = $dietarygoal_exp_calories;

  $np_protein_high = ['exp' => 'High-Protein Recipes'];
  $np_recipe_list['protein_high'] = $np_protein_high;

  $np_fat_high = ['exp' => 'High-Fat Recipes'];
  $np_recipe_list['fat_high'] = $np_fat_high;

  $np_calories_high = ['exp' => 'High-Calorie Recipes'];
  $np_recipe_list['calories_high'] = $np_calories_high;
}

if (!empty($_POST['veggie'])) {
  $vegetarian_exp = ['exp' => 'Healthy Recipes That Also Match Your Vegetarian Dietary Preferences'];
  $habits_healthy['vegetarian_healthy'] = $vegetarian_exp;

  $np_whoscore_low = ['exp' => 'Healthy Recipes That Meet Dietary Intake Guidelines'];
  $np_recipe_list['whoscore'] = $np_whoscore_low;
}

if (!empty($_POST['diabetes'])) {
  $diabetes_cal_exp = ['exp' => 'Low-Calorie Recipes That Also Fit Your Diabetes Dietary Restriction'];
  $calories_low['low_cal_diabetes'] = $diabetes_cal_exp;
  $diabetes_minute_exp = ['exp' => 'Recipes With a Long Cooking Time That Match Your Preferred Cooking Time and Your Diabetes Dietary Restriction'];
  $totalminutes_high['high_minutes_diabetes'] = $diabetes_minute_exp;

  $np_calories_low = ['exp' => 'Low-Calorie Recipes'];
  $np_recipe_list['calories_low'] = $np_calories_low;

  $np_sugar_low = ['exp' => 'Low-Sugar Recipes'];
  $np_recipe_list['sugar_low'] = $np_sugar_low;

  $np_whoscore_low = ['exp' => 'Healthy Recipes That Meet Dietary Intake Guidelines'];
  $np_recipe_list['whoscore'] = $np_whoscore_low;

}

if (!empty($_POST['lactose'])) {
  $lactosefree_exp = ['exp' => 'Healthy Recipes That Fit Your Lactose-Free Dietary Restriction'];
  $habits_healthy['lactose_healthy'] = $lactosefree_exp;

  $np_whoscore_low = ['exp' => 'Healthy Recipes That Meet Dietary Intake Guidelines'];
  $np_recipe_list['whoscore'] = $np_whoscore_low;

}

if (!empty($_POST['gluten'])) {
  $glutenfree_exp = ['exp' => 'Healthy Recipes That Fit Your Gluten-Free Dietary Restriction'];
  $habits_healthy['glutenfree_healthy'] = $glutenfree_exp;

  $np_whoscore_low = ['exp' => 'Healthy Recipes That Meet Dietary Intake Guidelines'];
  $np_recipe_list['whoscore'] = $np_whoscore_low;
}

if (isset($habits_unhealthy)) {
  $random_keys = array_rand($habits_unhealthy);
  $list_recipes[$random_keys] = $habits_unhealthy[$random_keys];
}

if (isset($habits_healthy)) {
  $random_keys = array_rand($habits_healthy);
  $list_recipes[$random_keys] = $habits_healthy[$random_keys];
}

if (isset($totalminutes_low)) {
  $random_keys = array_rand($totalminutes_low);
  $list_recipes[$random_keys] = $totalminutes_low[$random_keys];
}

if (isset($totalminutes_high)) {
  $random_keys = array_rand($totalminutes_high);
  $list_recipes[$random_keys] = $totalminutes_high[$random_keys];
}

if (isset($difficulty_low)) {
  $random_keys = array_rand($difficulty_low);
  $list_recipes[$random_keys] = $difficulty_low[$random_keys];
}

if (isset($difficulty_high)) {
  $random_keys = array_rand($difficulty_high);
  $list_recipes[$random_keys] = $difficulty_high[$random_keys];
}

if (isset($protein_high)) {
  $random_keys = array_rand($protein_high);
  $list_recipes[$random_keys] = $protein_high[$random_keys];
}

if (isset($fat_high)) {
  $random_keys = array_rand($fat_high);
  $list_recipes[$random_keys] = $fat_high[$random_keys];
}

if (isset($fiber_high)) {
  $random_keys = array_rand($fiber_high);
  $list_recipes[$random_keys] = $fiber_high[$random_keys];
}

if (isset($calories_low)) {
  $random_keys = array_rand($calories_low);
  $list_recipes[$random_keys] = $calories_low[$random_keys];
}

if (isset($calories_high)) {
  $random_keys = array_rand($calories_high);
  $list_recipes[$random_keys] = $calories_high[$random_keys];
}

if (isset($fat_low)) {
  $random_keys = array_rand($fat_low);
  $list_recipes[$random_keys] = $fat_low[$random_keys];
}

if (isset($sugar_low)) {
  $random_keys = array_rand($sugar_low);
  $list_recipes[$random_keys] = $sugar_low[$random_keys];
}

if (isset($saturatedfat_low)) {
  $random_keys = array_rand($saturatedfat_low);
  $list_recipes[$random_keys] = $saturatedfat_low[$random_keys];
}

  #Shuffle personalized lists and cut to only 5 lists
  $shuffle_recipes = shuffle_assoc($list_recipes);
  $multi_list = array_slice($shuffle_recipes, 0, 5, true);

  $_SESSION['multi_list'] = $multi_list;

  $p_lists = array_column($multi_list, 'exp');
  $all_p_lists = implode(" | ", $p_lists);
  $_SESSION['all_p_lists'] = $all_p_lists;

  #Shuffle non personalized lists
  $shuffle_np_recipes = shuffle_assoc($np_recipe_list);
  $np_multi_list = array_slice($shuffle_np_recipes, 0, 5, true);

  $np_lists = array_column($np_multi_list, 'exp');
  $all_np_lists = implode(" | ", $np_lists);
  $_SESSION['all_np_lists'] = $all_np_lists;

  ######################################################################################

  if (isset($np_multi_list)) {
    if (array_key_exists('np_totalminutes_low',$np_multi_list)) {
      $shuffle_np_list = shuffle_assoc($np_shuffle);
      usort($shuffle_np_list, build_sorter('totalminutes'));
      $np_totalminuteslow = array_slice($shuffle_np_list, 0, 5, true);
      $np_multi_list['np_totalminutes_low']['recipes'] = $np_totalminuteslow;
    }

    if (array_key_exists('np_totalminutes_high',$np_multi_list)) {
      $shuffle_np_list = shuffle_assoc($np_shuffle);
      usort($shuffle_np_list, high_to_low_sorter('totalminutes'));
      $np_totalminuteslow = array_slice($shuffle_np_list, 0, 5, true);
      $np_multi_list['np_totalminutes_high']['recipes'] = $np_totalminuteslow;
    }

    if (array_key_exists('np_difficulty_low',$np_multi_list)) {
      $shuffle_np_list = shuffle_assoc($np_shuffle);
      usort($shuffle_np_list, build_sorter('difficulty_nr'));
      $np_difficultylow = array_slice($shuffle_np_list, 0, 5, true);
      $np_multi_list['np_difficulty_low']['recipes'] = $np_difficultylow;
    }

    if (array_key_exists('np_difficulty_high',$np_multi_list)) {
      $shuffle_np_list = shuffle_assoc($np_shuffle);
      usort($shuffle_np_list, high_to_low_sorter('difficulty_nr'));
      $np_difficultyhigh = array_slice($shuffle_np_list, 0, 5, true);
      $np_multi_list['np_difficulty_high']['recipes'] = $np_difficultyhigh;
    }

    if (array_key_exists('protein_low',$np_multi_list)) {
      $shuffle_np_list = shuffle_assoc($np_shuffle);
      usort($shuffle_np_list, build_sorter('proteins'));
      $np_proteinlow = array_slice($shuffle_np_list, 0, 5, true);
      $np_multi_list['protein_low']['recipes'] = $np_proteinlow;
    }

    if (array_key_exists('protein_high',$np_multi_list)) {
      $shuffle_np_list = shuffle_assoc($np_shuffle);
      usort($shuffle_np_list, high_to_low_sorter('proteins'));
      $np_proteinhigh = array_slice($shuffle_np_list, 0, 5, true);
      $np_multi_list['protein_high']['recipes'] = $np_proteinhigh;
    }

    if (array_key_exists('fat_low',$np_multi_list)) {
      $shuffle_np_list = shuffle_assoc($np_shuffle);
      usort($shuffle_np_list, build_sorter('fat'));
      $np_fatlow = array_slice($shuffle_np_list, 0, 5, true);
      $np_multi_list['fat_low']['recipes'] = $np_fatlow;
    }

    if (array_key_exists('fat_high',$np_multi_list)) {
      $shuffle_np_list = shuffle_assoc($np_shuffle);
      usort($shuffle_np_list, high_to_low_sorter('fat'));
      $np_fathigh = array_slice($shuffle_np_list, 0, 5, true);
      $np_multi_list['fat_high']['recipes'] = $np_fathigh;
    }

    if (array_key_exists('fiber_low',$np_multi_list)) {
      $shuffle_np_list = shuffle_assoc($np_shuffle);
      usort($shuffle_np_list, build_sorter('fat'));
      $np_fiberlow = array_slice($shuffle_np_list, 0, 5, true);
      $np_multi_list['fiber_low']['recipes'] = $np_fiberlow;
    }

    if (array_key_exists('fiber_high',$np_multi_list)) {
      $shuffle_np_list = shuffle_assoc($np_shuffle);
      usort($shuffle_np_list, high_to_low_sorter('fiber'));
      $np_fiberhigh = array_slice($shuffle_np_list, 0, 5, true);
      $np_multi_list['fiber_high']['recipes'] = $np_fiberhigh;
    }

    if (array_key_exists('calories_low',$np_multi_list)) {
      $shuffle_np_list = shuffle_assoc($np_shuffle);
      usort($shuffle_np_list, build_sorter('calories'));
      $np_calorieslow = array_slice($shuffle_np_list, 0, 5, true);
      $np_multi_list['calories_low']['recipes'] = $np_calorieslow;
    }

    if (array_key_exists('calories_high',$np_multi_list)) {
      $shuffle_np_list = shuffle_assoc($np_shuffle);
      usort($shuffle_np_list, high_to_low_sorter('calories'));
      $np_calorieshigh = array_slice($shuffle_np_list, 0, 5, true);
      $np_multi_list['calories_high']['recipes'] = $np_calorieshigh;
    }

    if (array_key_exists('sugar_low',$np_multi_list)) {
      $shuffle_np_list = shuffle_assoc($np_shuffle);
      usort($shuffle_np_list, build_sorter('sugars'));
      $np_sugarlow = array_slice($shuffle_np_list, 0, 5, true);
      $np_multi_list['sugar_low']['recipes'] = $np_sugarlow;
    }

    if (array_key_exists('saturatedfat_low',$np_multi_list)) {
      $shuffle_np_list = shuffle_assoc($np_shuffle);
      usort($shuffle_np_list, build_sorter('saturatedfat'));
      $np_saturatedfatlow = array_slice($shuffle_np_list, 0, 5, true);
      $np_multi_list['saturatedfat_low']['recipes'] = $np_saturatedfatlow;
    }

    if (array_key_exists('whoscore',$np_multi_list)) {
      $shuffle_np_list = shuffle_assoc($np_shuffle);
      usort($shuffle_np_list, high_to_low_sorter('who_score'));
      $np_whoscore = array_slice($shuffle_np_list, 0, 5, true);
      $np_multi_list['whoscore']['recipes'] = $np_whoscore;
    }
  }

  $key_to_num = array_values($np_multi_list);
  echo "<form action='index2_1.php' method='POST'>";
  echo "<div class='lists'>";

  echo "<h1 style='font-family: system-ui; text-align: center; font-weight: 400; grid-column-start:2; grid-column-end:5;'>Page 2/4</h1>";
  echo "<h1 style='font-family: system-ui; text-align: center; font-weight: 400; grid-column-start:1; grid-column-end:6; margin-bottom: 70px;'>Please choose only <b>one</b> recipe that you like the most and would like to cook tomorrow night (or in the near future). Then, answer the questions at the end of the page and click ‘continue’ when finished.</h1>";

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
        echo "<input type='radio' name='select_np_ml_recipe' style='position: relative; top: 5px; left: 65px;' id='" . $rp_value['title'] . "' value='" . $rp_value['title'] . "//" . $result_key . "//" . $rp_key . "//" . $result_value['exp'] . "' required>";
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
        <label class='formchecklabel' for='NP_ML_Q1_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question1' id='NP_ML_Q1_1' value='NP_ML_Q1_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q1_2'>2 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question1' id='NP_ML_Q1_2' value='NP_ML_Q1_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q1_3'>3 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question1' id='NP_ML_Q1_3' value='NP_ML_Q1_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q1_4'>4 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question1' id='NP_ML_Q1_4' value='NP_ML_Q1_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q1_5'>5 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question1' id='NP_ML_Q1_5' value='NP_ML_Q1_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q1_6'>6 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question1' id='NP_ML_Q1_6' value='NP_ML_Q1_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q1_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question1' id='NP_ML_Q1_7' value='NP_ML_Q1_7' required>
        </label>
      </div>
    </div>


    <label for='question2' class='questions'>I could understand how the recipes were based on my preferences</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q2_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question2' id='NP_ML_Q2_1' value='NP_ML_Q2_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q2_2'>2 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question2' id='NP_ML_Q2_2' value='NP_ML_Q2_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q2_3'>3 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question2' id='NP_ML_Q2_3' value='NP_ML_Q2_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q2_4'>4 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question2' id='NP_ML_Q2_4' value='NP_ML_Q2_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q2_5'>5 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question2' id='NP_ML_Q2_5' value='NP_ML_Q2_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q2_6'>6 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question2' id='NP_ML_Q2_6' value='NP_ML_Q2_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q2_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question2' id='NP_ML_Q2_7' value='NP_ML_Q2_7' required>
        </label>
      </div>
    </div>

    <label for='question3' class='questions'>The recommendation process was NOT clear to me</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q3_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question3' id='NP_ML_Q3_1' value='NP_ML_Q3_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q3_2'>2 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question3' id='NP_ML_Q3_2' value='NP_ML_Q3_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q3_3'>3 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question3' id='NP_ML_Q3_3' value='NP_ML_Q3_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q3_4'>4 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question3' id='NP_ML_Q3_4' value='NP_ML_Q3_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q3_5'>5 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question3' id='NP_ML_Q3_5' value='NP_ML_Q3_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q3_6'>6 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question3' id='NP_ML_Q3_6' value='NP_ML_Q3_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q3_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question3' id='NP_ML_Q3_7' value='NP_ML_Q3_7' required>
        </label>
      </div>
    </div>

    <label for='question4' class='questions'>I could easily find recipes on this page</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q4_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question4' id='NP_ML_Q4_1' value='NP_ML_Q4_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q4_2'>2 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question4' id='NP_ML_Q4_2' value='NP_ML_Q4_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q4_3'>3 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question4' id='NP_ML_Q4_3' value='NP_ML_Q4_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q4_4'>4 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question4' id='NP_ML_Q4_4' value='NP_ML_Q4_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q4_5'>5 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question4' id='NP_ML_Q4_5' value='NP_ML_Q4_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q4_6'>6 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question4' id='NP_ML_Q4_6' value='NP_ML_Q4_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q4_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question4' id='NP_ML_Q4_7' value='NP_ML_Q4_7' required>
        </label>
      </div>
    </div>

    <label for='question5' class='questions'>This page helped to discover new recipes</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q5_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question5' id='NP_ML_Q5_1' value='NP_ML_Q5_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q5_2'>2 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question5' id='NP_ML_Q5_2' value='NP_ML_Q5_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q5_3'>3 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question5' id='NP_ML_Q5_3' value='NP_ML_Q5_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q5_4'>4 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question5' id='NP_ML_Q5_4' value='NP_ML_Q5_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q5_5'>5 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question5' id='NP_ML_Q5_5' value='NP_ML_Q5_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q5_6'>6 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question5' id='NP_ML_Q5_6' value='NP_ML_Q5_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q5_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question5' id='NP_ML_Q5_7' value='NP_ML_Q5_7' required>
        </label>
      </div>
    </div>

    <label for='question6' class='questions'>A page like this helps me make better recipe choices</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q6_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question6' id='NP_ML_Q6_1' value='NP_ML_Q6_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q6_2'>2 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question6' id='NP_ML_Q6_2' value='NP_ML_Q6_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q6_3'>3 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question6' id='NP_ML_Q6_3' value='NP_ML_Q6_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q6_4'>4 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question6' id='NP_ML_Q6_4' value='NP_ML_Q6_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q6_5'>5 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question6' id='NP_ML_Q6_5' value='NP_ML_Q6_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q6_6'>6 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question6' id='NP_ML_Q6_6' value='NP_ML_Q6_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q6_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question6' id='NP_ML_Q6_7' value='NP_ML_Q6_7' required>
        </label>
      </div>
    </div>

    <label for='question7' class='questions'>The task of choosing a recipe was overwhelming</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q7_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question7' id='NP_ML_Q7_1' value='NP_ML_Q7_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q7_2'>2 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question7' id='NP_ML_Q7_2' value='NP_ML_Q7_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q7_3'>3 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question7' id='NP_ML_Q7_3' value='NP_ML_Q7_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q7_4'>4 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question7' id='NP_ML_Q7_4' value='NP_ML_Q7_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q7_5'>5 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question7' id='NP_ML_Q7_5' value='NP_ML_Q7_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q7_6'>6 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question7' id='NP_ML_Q7_6' value='NP_ML_Q7_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q7_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question7' id='NP_ML_Q7_7' value='NP_ML_Q7_7' required>
        </label>
      </div>
    </div>

    <label for='question8' class='questions'>I changed my mind several times before choosing a recipe</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q8_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question8' id='NP_ML_Q8_1' value='NP_ML_Q8_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q8_2'>2 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question8' id='NP_ML_Q8_2' value='NP_ML_Q8_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q8_3'>3 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question8' id='NP_ML_Q8_3' value='NP_ML_Q8_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q8_4'>4 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question8' id='NP_ML_Q8_4' value='NP_ML_Q8_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q8_5'>5 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question8' id='NP_ML_Q8_5' value='NP_ML_Q8_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q8_6'>6 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question8' id='NP_ML_Q8_6' value='NP_ML_Q8_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q8_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question8' id='NP_ML_Q8_7' value='NP_ML_Q8_7' required>
        </label>
      </div>
    </div>

    <label for='question9' class='questions'>Comparing the recommended recipes was easy</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q9_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question9' id='NP_ML_Q9_1' value='NP_ML_Q9_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q9_2'>2 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question9' id='NP_ML_Q9_2' value='NP_ML_Q9_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q9_3'>3 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question9' id='NP_ML_Q9_3' value='NP_ML_Q9_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q9_4'>4 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question9' id='NP_ML_Q9_4' value='NP_ML_Q9_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q9_5'>5 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question9' id='NP_ML_Q9_5' value='NP_ML_Q9_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q9_6'>6 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question9' id='NP_ML_Q9_6' value='NP_ML_Q9_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q9_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question9' id='NP_ML_Q9_7' value='NP_ML_Q9_7' required>
        </label>
      </div>
    </div>

    <label for='question10' class='questions'>I like the recipe I’ve chosen</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q10_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question10' id='NP_ML_Q10_1' value='NP_ML_Q10_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q10_2'>2 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question10' id='NP_ML_Q10_2' value='NP_ML_Q10_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q10_3'>3 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question10' id='NP_ML_Q10_3' value='NP_ML_Q10_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q10_4'>4 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question10' id='NP_ML_Q10_4' value='NP_ML_Q10_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q10_5'>5 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question10' id='NP_ML_Q10_5' value='NP_ML_Q10_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q10_6'>6 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question10' id='NP_ML_Q10_6' value='NP_ML_Q10_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q10_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question10' id='NP_ML_Q10_7' value='NP_ML_Q10_7' required>
        </label>
      </div>
    </div>

    <label for='question11' class='questions'>I think I will prepare the recipe I’ve chosen</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q11_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question11' id='NP_ML_Q11_1' value='NP_ML_Q11_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q11_2'>2 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question11' id='NP_ML_Q11_2' value='NP_ML_Q11_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q11_3'>3 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question11' id='NP_ML_Q11_3' value='NP_ML_Q11_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q11_4'>4 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question11' id='NP_ML_Q11_4' value='NP_ML_Q11_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q11_5'>5 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question11' id='NP_ML_Q11_5' value='NP_ML_Q11_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q11_6'>6 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question11' id='NP_ML_Q11_6' value='NP_ML_Q11_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q11_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question11' id='NP_ML_Q11_7' value='NP_ML_Q11_7' required>
        </label>
      </div>
    </div>

    <label for='question12' class='questions'>I know many recipes that I like more than the one I have chosen</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q12_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question12' id='NP_ML_Q12_1' value='NP_ML_Q12_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q12_2'>2 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question12' id='NP_ML_Q12_2' value='NP_ML_Q12_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q12_3'>3 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question12' id='NP_ML_Q12_3' value='NP_ML_Q12_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q12_4'>4 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question12' id='NP_ML_Q12_4' value='NP_ML_Q12_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q12_5'>5 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question12' id='NP_ML_Q12_5' value='NP_ML_Q12_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q12_6'>6 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question12' id='NP_ML_Q12_6' value='NP_ML_Q12_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q12_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question12' id='NP_ML_Q12_7' value='NP_ML_Q12_7' required>
        </label>
      </div>
    </div>

    <label for='question13' class='questions'>I would recommend the chosen recipe to others</label>
    <div class='questionanswers'>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q13_1'>1 (Completely Disagree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question13' id='NP_ML_Q13_1' value='NP_ML_Q13_1' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q13_2'>2 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question13' id='NP_ML_Q13_2' value='NP_ML_Q13_2' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q13_3'>3 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question13' id='NP_ML_Q13_3' value='NP_ML_Q13_3' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q13_4'>4 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question13' id='NP_ML_Q13_4' value='NP_ML_Q13_4' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q13_5'>5 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question13' id='NP_ML_Q13_5' value='NP_ML_Q13_5' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q13_6'>6 <br />
        <input class='formcheckinput' type='radio' name='NP_ML_question13' id='NP_ML_Q13_6' value='NP_ML_Q13_6' required>
        </label>
      </div>
      <div class='radioquestion'>
        <label class='formchecklabel' for='NP_ML_Q13_7'>7 (Completely Agree)<br />
        <input class='formcheckinput' type='radio' name='NP_ML_question13' id='NP_ML_Q13_7' value='NP_ML_Q13_7' required>
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
    '><input class='submit_button' type='submit' value='Continue' name='submit_recipe'></div>";

  echo "</div>";
}

  ?>

  </form>
  </body>
  </html>
