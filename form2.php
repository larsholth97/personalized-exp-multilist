<?php

/* ----------------SINGLE-LIST FORM-----------------------*/

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

$url = ['index4.php', 'index5.php'];
shuffle($url);

echo "<div class='formpage'>";
echo "<form action='" . $url[0] . "' method='POST' style='background-color: lavender; border: 1px solid black; width: 600px; padding: 30px;'>";

?>
<div class="introtext">
  <h1 style="
    font-size: smaller;
    font-weight: 400;">Page 1/4</h1>
    <h1 style="
      font-family: system-ui;
      font-weight: 600;">Personal Information</h1>
  <p>To be able to present you personalized recipe recommendations, please answer the following questions about yourself and your food preferences. This applies to a recipe that you would like to cook in the near future, such as tomorrow night. This information will be used to present you recipes that are personally relevant to you.</p>
</div>
<label for="sexOption" class="userquestion">To which gender do you most identify? </label>
<div class="useranswer">
      <input type="radio" name="sexOption" id="male" value="m" required>
      <label class="labelclass" for="male">Male</label>
      <input type="radio" name="sexOption" id="female" value="f" required>
      <label class="labelclass" for="female">Female</label>
      <input type="radio" name="sexOption" id="na" value="na" required>
      <label class="labelclass" for="na">Other/Prefer not to say</label>
</div>

    <label for="ageOption" class="userquestion">What is your age? </label>
    <div class="useranswer">
      <div class="radioage">
        <input type="radio" name="ageOption" id="16_25" value="16_25" required>
        <label class="labelclass" for="16_25">16-25</label>
      </div>
      <div class="radioage">
        <input type="radio" name="ageOption" id="26_35" value="26_35" required>
        <label class="labelclass" for="26_35">26-35</label>
      </div>
      <div class="radioage">
        <input type="radio" name="ageOption" id="36_45" value="36_45" required>
        <label class="labelclass" for="36_45">36-45</label>
      </div>
      <div class="radioage">
        <input type="radio" name="ageOption" id="46_55" value="46_55" required>
        <label class="labelclass" for="46_55">46-55</label>
      </div>
      <div class="radioage">
        <input type="radio" name="ageOption" id="56_65" value="56_65" required>
        <label class="labelclass" for="56_65">56-65</label>
      </div>
      <div class="radioage">
        <input type="radio" name="ageOption" id="65plus" value="65plus" required>
        <label class="labelclass" for="65plus">65+</label>
      </div>
    </div>

    <label for="healthyeating" class="userquestion">How important is eating healthy to you? </label>
    <div class="useranswer">
      <select name="healthyeating" id="healthyeating" required>
        <option hidden disabled selected value></option>
        <option value="1">Very unimportant</option>
        <option value="2">Unimportant</option>
        <option value="3">Not important, Not unimportant</option>
        <option value="4">Important</option>
        <option value="5">Very important</option>
      </select>
    </div>

    <label for="weight" class="userquestion">What is your weight? (in kilos)</label>
    <div class="useranswer">
      <input class="inputanswer" type="number" value="0" id="weightclass" name="weight" min="0" max="350" step="1" required>
    </div>

    <label for="height" class="userquestion">What is your height? (in centimeters)</label>
    <div class="useranswer">
      <input class="inputanswer" type="number" value="0" id="heightclass" name="height" min="0" max="230" step="1" required>
    </div>

    <label for="eatinghabits" class="userquestion">How would you rate your eating habits? </label>
    <div class="useranswer">
      <select name="eatinghabits" class="eatinghabits" required>
        <option hidden disabled selected value></option>
        <option value="1">Very unhealthy</option>
        <option value="2">Unhealthy</option>
        <option value="3">Not healthy, Not unhealthy</option>
        <option value="4">Healthy</option>
        <option value="5">Very healthy</option>
      </select>
    </div>


    <label for="recipenutrients" class="userquestion">To what extent do you agree with the follow statement: "My health depends on the foods I consume." </label>
    <div class="useranswer">
      <select name="recipenutrients" class="recipenutrients" required>
        <option hidden disabled selected value></option>
        <option value="1">Completely Disagree</option>
        <option value="2">Disagree</option>
        <option value="3">Neutral</option>
        <option value="4">Agree</option>
        <option value="5">Completely Agree</option>
      </select>
    </div>

    <label for="difficulty" class="userquestion">How do you rate your level of cooking experience? </label>
    <div class="useranswer">
      <input class="formcheckinput" type="radio" name="difficulty" id="1" value="1" required>
      <label class="labelclass" for="1">Very low</label>
      <input class="formcheckinput" type="radio" name="difficulty" id="2" value="2" required>
      <label class="labelclass" for="2">Low</label>
      <input class="formcheckinput" type="radio" name="difficulty" id="3" value="3" required>
      <label class="labelclass" for="3">Medium</label>
      <input class="formcheckinput" type="radio" name="difficulty" id="4" value="4" required>
      <label class="labelclass" for="4">High</label>
      <input class="formcheckinput" type="radio" name="difficulty" id="4" value="4" required>
      <label class="labelclass" for="4">Very high</label>
    </div>

    <label for="cookingtime" class="userquestion">What is your maximum preferred cooking time (in minutes)? </label>
    <div class="useranswer">
      <input class="inputanswer" type="number" value="0" id="timeforcooking" name="cookingtime" min="0" max="200" step="10">
    </div>

    <label for="activity" class="userquestion">How often do you engage in physical exercise per week? </label>
    <div class="useranswer">
      <select name="activity" class="activity" required>
        <option hidden disabled selected value></option>
        <option value="1">A lot (More than 9 hours)</option>
        <option value="2">Average (Around 6 hours)</option>
        <option value="3">Little (Less than 3 hours)</option>
      </select>
    </div>

    <label for="dietgoal" class="userquestion">Do you have any weight-related goals? </label>
    <div class="useranswer">
      <select name="dietarygoal" class="dietarygoal" required>
        <option hidden disabled selected value></option>
        <option value="-1">Lose weight</option>
        <option value="1">Gain weight</option>
        <option value="0">No goal</option>
      </select>
    </div>

    <label for="dietrestrict" class="userquestion">Do you have any dietary restrictions? </label>
    <div class="useranswer">
      <input id="diabetes" name="diabetes" value="1" type="checkbox">
      <label for="diabetes">Diabetes</label>
      <input id="vegetarian" name="veggie" value="1" type="checkbox">
      <label for="vegetarian">Vegetarian</label>
      <input id="lactose" name="lactose" value="1" type="checkbox">
      <label for="lactose">Lactose</label>
      <input id="gluten" name="gluten" value="1" type="checkbox">
      <label for="gluten">Gluten-free</label>
    </div>

    <input class="submit_button" type="submit" value="Build your profile" name="onsubmit" style="
    margin-left: 25%;
    margin-bottom: 7%;">

  </form>
</div>
</body>
</html>
