<?php
/*
* MAIN API
    - Manages all commands

* Sources:
    - https://stackoverflow.com/questions/2385701/regular-expression-for-first-and-last-name

    - https://stackoverflow.com/questions/18301408/php-is-array-returns-1-on-true-and-breaks-on-false

    - https://stackoverflow.com/questions/12026842/how-to-validate-an-email-address-in-php
*/

//* SESSION START
// NOTE: In a production application I would check if user is authenticated to ensure only authenticated, permitted users can hit this API
session_name("Survey");
session_start();

//* DECODING JSON SENT IN REQUEST
$json = file_get_contents("php://input");
$postObj = json_decode($json);

$PAGE = $postObj->page;

//* MAIN DECISION MAKER CONTROL
// Each Case Is A Page To Validate On A Page By Page Basis
// If validation is correct, values are stored in session otherwise session for that page is emptied.
switch ($PAGE) {
    case 1:
        $name = $postObj->name;
        $programmingYears = $postObj->programmingYears;

        $message = validatePage1($name, $programmingYears);

        if ($message === "LOOKS GOOD") {
            $response = array("type" => "SUCCESS", "name" => $name, "programmingYears" => $programmingYears);

            $_SESSION["PAGE1"] = $response;
            header('Content-type: application/json');
            echo json_encode($response);
        } else {
            if (isset($_SESSION['PAGE1'])) unset($_SESSION['PAGE1']);
            $response = array("type" => "ERROR", "message" => $message);
            header('Content-type: application/json');
            echo json_encode($response);
        }

        break;

    case 2:
        $nodeJS = $postObj->nodeJS;
        $es6Knowledge = $postObj->es6Knowledge;

        $message = validatePage2($nodeJS, $es6Knowledge);

        if ($message === "LOOKS GOOD") {
            $response = array("type" => "SUCCESS", "nodeJS" => $nodeJS, "es6Knowledge" => $es6Knowledge);

            $_SESSION["PAGE2"] = $response;
            header('Content-type: application/json');
            echo json_encode($response);
        } else {
            if (isset($_SESSION['PAGE2'])) unset($_SESSION['PAGE2']);
            $response = array("type" => "ERROR", "message" => $message);
            header('Content-type: application/json');
            echo json_encode($response);
        }

        break;

    case 3:
        $loveMost = $postObj->loveMost;
        $dislikeMost = $postObj->dislikeMost;
        $proneToLeave = $postObj->proneToLeave;

        $message = validatePage3($loveMost, $dislikeMost, $proneToLeave);

        if ($message === "LOOKS GOOD") {
            $response = array("type" => "SUCCESS", "loveMost" => $loveMost, "dislikeMost" => $dislikeMost, "proneToLeave" => $proneToLeave);

            $_SESSION["PAGE3"] = $response;
            header('Content-type: application/json');
            echo json_encode($response);
        } else {
            if (isset($_SESSION['PAGE3'])) unset($_SESSION['PAGE3']);
            $response = array("type" => "ERROR", "message" => $message);
            header('Content-type: application/json');
            echo json_encode($response);
        }

        break;

    case 4:
        $wouldRecommend = (int) $postObj->wouldRecommend;

        $message = validatePage4($wouldRecommend);

        if ($message === "LOOKS GOOD") {
            $response = array("type" => "SUCCESS", "wouldRecommend" => $wouldRecommend);

            $_SESSION["PAGE4"] = $response;
            header('Content-type: application/json');
            echo json_encode($response);
        } else {
            if (isset($_SESSION['PAGE4'])) unset($_SESSION['PAGE4']);
            $response = array("type" => "ERROR", "message" => $message);
            header('Content-type: application/json');
            echo json_encode($response);
        }

        break;

    case 5:
        $surveyMethod = $postObj->surveyMethod;
        $futureSurveys = $postObj->futureSurveys;
        $emailFuture = $postObj->emailFuture;

        // So Validation Works With No Selected And Future Surveys
        if ($futureSurveys === "NO" && $emailFuture === "") {
            $emailFuture = "noemail@email.com";
        } else if ($futureSurveys === "NO" && $emailFuture !== "") {
            $emailFuture = "noemail@email.com";
        }

        $message = validatePage5($surveyMethod, $futureSurveys, $emailFuture);

        if ($message === "LOOKS GOOD") {
            $response = array("type" => "SUCCESS", "surveyMethod" => $surveyMethod, "futureSurveys" => $futureSurveys, "emailFuture" => $emailFuture);

            $_SESSION["PAGE5"] = $response;

            //~ Add TO Database, As All Other Data Has Been Validated
            $dbAddSuccess = addToDatabase();
            if ($dbAddSuccess) {
                header('Content-type: application/json');
                echo json_encode($response);
            } else {
                $errResponse = array("type" => "ERROR", "message" => "DB Add Failed");
                header('Content-type: application/json');
                echo json_encode($errResponse);
            }
        } else {
            if (isset($_SESSION['PAGE5'])) unset($_SESSION['PAGE5']);
            $response = array("type" => "ERROR", "message" => $message);
            header('Content-type: application/json');
            echo json_encode($response);
        }

        break;

    case "GET-DATA": // Gets data for summary page
        $PAGE1 = isset($_SESSION["PAGE1"]) ? $_SESSION["PAGE1"] : "";
        $PAGE2 = isset($_SESSION["PAGE2"]) ? $_SESSION["PAGE2"] : "";
        $PAGE3 = isset($_SESSION["PAGE3"]) ? $_SESSION["PAGE3"] : "";
        $PAGE4 = isset($_SESSION["PAGE4"]) ? $_SESSION["PAGE4"] : "";
        $PAGE5 = isset($_SESSION["PAGE5"]) ? $_SESSION["PAGE5"] : "";

        $response = array("PAGE1" => $PAGE1, "PAGE2" => $PAGE2, "PAGE3" => $PAGE3, "PAGE4" => $PAGE4, "PAGE5" => $PAGE5);
        header('Content-type: application/json');
        echo json_encode($response);
        break;

    default: // Default Case
        $response = "You should not be here!";
        echo json_encode($response);
}

//* VALIDATION FUNCTIONS
// Can Declare Functions After Invocation Due To Function Hoisting 
function validatePage1($name, $programmingYears)
{
    $isName = preg_match("/^[a-z ,.'-]+$/i", $name);
    $isNumeric = is_numeric($programmingYears);
    if ($isName && $isNumeric) {
        return "LOOKS GOOD";
    } else if (!$isName && !$isNumeric) {
        return "Name is not correct and programming years is not numeric";
    } else if (!$isName) {
        return "Name is not correct";
    } else if (!$isNumeric) {
        return "Programming years is not numeric";
    }
}

function validatePage2($nodeJS, $es6Knowledge)
{
    $possibleValues = array("YES", "NO");
    $nodeJSValid = in_array($nodeJS, $possibleValues, true);
    $es6KnowledgeValid = in_array($es6Knowledge, $possibleValues, true);

    if ($nodeJSValid && $es6KnowledgeValid) {
        return "LOOKS GOOD";
    } else if (!$nodeJSValid && !$es6KnowledgeValid) {
        return "Both values are invalid";
    } else if (!$nodeJSValid) {
        return "Server side JS has an invalid value";
    } else if (!$es6KnowledgeValid) {
        return "ES6 Knowledge has an invalid value";
    }
}

function validatePage3($loveMost, $dislikeMost, $proneToLeave)
{
    $possibleValuesLove = array("Dynamic Typing", "Client & Server", "Reach & Demand", "Other");
    $possibleValuesDislike = array("Dynamic Typing", "Its Programmers", "Code Organization", "Other");
    $possibleValuesProne = array("NO", "MAYBE", "YES");

    $loveMostValid = in_array($loveMost, $possibleValuesLove, true);
    $dislikeMostValid = in_array($dislikeMost, $possibleValuesDislike, true);
    $proneToLeaveValid = in_array($proneToLeave, $possibleValuesProne, true);


    if ($loveMostValid && $dislikeMostValid && $proneToLeaveValid) {
        return "LOOKS GOOD";
    } else if (!$loveMostValid && !$dislikeMostValid && !$proneToLeaveValid) {
        return "All 3 values are invalid";
    } else if (!$loveMostValid && $dislikeMostValid && $proneToLeaveValid) {
        return "Love most has an invalid value";
    } else if ($loveMostValid && !$dislikeMostValid && $proneToLeaveValid) {
        return "Dislike most has an invalid value";
    } else if ($loveMostValid && $dislikeMostValid && !$proneToLeaveValid) {
        return "Prone to leave has an invalid value";
    } else {
        // You would then check combinations of two. I decided to send a more generalized message for the purposes of this assignment.
        return "Two fields have incorrect values";
    }
}


function validatePage4($wouldRecommend)
{
    $possibleValues = array(5, 4, 3, 2, 1);
    $wouldRecommendValid = in_array($wouldRecommend, $possibleValues);

    if ($wouldRecommendValid) {
        return "LOOKS GOOD";
    } else {
        return "The selected value is invalid";
    }
}

function validatePage5($surveyMethod, $futureSurveys, $emailFuture)
{
    $possibleValuesSurvey = array("NEWSPAPER", "EMAIL", "LINK", "OTHER");
    $possibleValuesFuture = array("YES", "NO");

    $surveyMethodValid = in_array($surveyMethod, $possibleValuesSurvey);
    $futureSurveysValid = in_array($futureSurveys, $possibleValuesFuture);
    $emailFutureValid = filter_var($emailFuture, FILTER_VALIDATE_EMAIL);

    if ($surveyMethodValid && $futureSurveysValid && $emailFutureValid) {
        return "LOOKS GOOD";
    } else if (!$surveyMethodValid && !$futureSurveysValid && !$emailFutureValid) {
        return "All 3 values are invalid";
    } else if (!$surveyMethodValid && $futureSurveysValid && $emailFutureValid) {
        return "Survey method has an invalid value";
    } else if ($surveyMethodValid && !$futureSurveysValid && $emailFutureValid) {
        return "Future surveys has an invalid value";
    } else if ($surveyMethodValid && $futureSurveysValid && !$emailFutureValid) {
        return "Email has an invalid value";
    } else {
        // You would then check combinations of two. I decided to send a more generalized message for the purposes of this assignment.
        return "Two fields have incorrect values";
    }
}

//* ADD TO DATABASE HELPER
function addToDatabase()
{
    require "../includes/dbConnect.php";

    $PAGE1 = $_SESSION["PAGE1"];
    $PAGE2 = $_SESSION["PAGE2"];
    $PAGE3 = $_SESSION["PAGE3"];
    $PAGE4 = $_SESSION["PAGE4"];
    $PAGE5 = $_SESSION["PAGE5"];

    $stmt = $conn->prepare("INSERT INTO survey (name, years_programming, server_side_js, es6, love_most, dislike_most, prone_to_leave, would_recommend, survey_method, future_survey, email_future) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");

    $stmt->bind_param("sssssssisss", $P1, $P2, $P3, $P4, $P5, $P6, $P7, $P8, $P9, $P10, $P11);

    $P1 = $PAGE1["name"];
    $P2 = $PAGE1["programmingYears"];
    $P3 = $PAGE2["nodeJS"];
    $P4 = $PAGE2["es6Knowledge"];
    $P5 = $PAGE3["loveMost"];
    $P6 = $PAGE3["dislikeMost"];
    $P7 = $PAGE3["proneToLeave"];
    $P8 = $PAGE4["wouldRecommend"];
    $P9 = $PAGE5["surveyMethod"];
    $P10 = $PAGE5["futureSurveys"];
    $P11 = $PAGE5["emailFuture"];

    if (!$stmt->execute()) {
        require "../includes/dbDisconnect.php";

        return false;
    } else {
        require "../includes/dbDisconnect.php";

        return true;
    }
    //? require "../includes/dbDisconnect.php"; // I think I can't just have it here as return would break execution
}
