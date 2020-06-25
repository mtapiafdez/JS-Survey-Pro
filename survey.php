<?php
include_once "./includes/header.php";
session_name("Survey");
session_start();

// Clean Slate When Starting Back Up
unset($_SESSION['PAGE1']);
unset($_SESSION['PAGE2']);
unset($_SESSION['PAGE3']);
unset($_SESSION['PAGE4']);
unset($_SESSION['PAGE5']);
?>

<!-- 6 Sections -->
<!-- Show all data at end and option to restart which clears all session vars -->
<div class="container">

    <h1 class="text-center my-4 h2">Do you know JS?&nbsp;<i class="fab fa-js-square text-primary"></i></h1>
    <div class="container__smaller">
        <section id="sec-1" class="card p-3">
            <form id="form-sec-1" onsubmit="handleNextPage(event, 1)" novalidate>
                <div class="form-group">
                    <label for="name">What is your name?</label>
                    <input type="text" class="form-control" id="name" required>
                </div>
                <div class="form-group">
                    <label for="programmingYears">How many years have you been programming?</label>
                    <input type="number" class="form-control" id="programmingYears" required>
                </div>
                <div class="form-group d-flex justify-content-between mt-2">
                    <button type="button" onclick="handleLastPage(1)" class="btn btn-danger btn-inv">Clear</button>
                    <button type="submit" class="btn btn-primary">Next</button>
                </div>
            </form>
        </section>
        <section id="sec-2" class="card p-3" style="display:none;">
            <form id="form-sec-2" onsubmit="handleNextPage(event, 2)" novalidate>
                <div class="form-group text-center">
                    <label class="text-left d-block">Did you know JavaScript can be written server side?</label>
                    <div class="form-check-inline">
                        <input class="form-check-input" type="radio" name="nodeJS" id="nodeJSYes" value="YES" required>
                        <label class="form-check-label" for="nodeJSYes">
                            Yes
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <input class="form-check-input ml-3" type="radio" name="nodeJS" id="nodeJSNo" value="NO">
                        <label class="form-check-label" for="nodeJSNo">
                            No
                        </label>
                    </div>
                </div>
                <div class="form-group text-center">
                    <label class="text-left d-block">Do you know about ES6 features like default parameters, template literals, real classes, let/const, arrow functions, hash maps, promises, etc.?</label>
                    <div class="form-check-inline">
                        <input class="form-check-input" type="radio" name="es6Knowledge" id="es6KnowledgeYes" value="YES" required>
                        <label class="form-check-label" for="es6KnowledgeYes">
                            Yes
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <input class="form-check-input ml-3" type="radio" name="es6Knowledge" id="es6KnowledgeNo" value="NO">
                        <label class="form-check-label" for="es6KnowledgeNo">
                            No
                        </label>
                    </div>
                </div>
                <div class="form-group d-flex justify-content-between mt-2">
                    <button type="button" onclick="handleLastPage(2)" class="btn btn-danger">Back</button>
                    <button type="submit" class="btn btn-primary">Next</button>
                </div>
            </form>
        </section>
        <section id="sec-3" class="card p-3" style="display:none;">
            <form id="form-sec-3" onsubmit="handleNextPage(event, 3)" novalidate>
                <div class="form-group">
                    <label for="loveMost">What do you love the most about the language?</label>
                    <select id="loveMost" name="loveMost" class="form-control" required>
                        <option selected='true' disabled='disabled'>Choose one</option>
                        <option value="Dynamic Typing">Dynamic Typing</option>
                        <option value="Client & Server">Ability to write one language client side and server side</option>
                        <option value="Reach & Demand">Reach and Demand</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="dislikeMost">What do you dislike the most about the language?</label>
                    <select id="dislikeMost" name="dislikeMost" class="form-control" required>
                        <option selected='true' disabled='disabled'>Choose one</option>
                        <option value="Dynamic Typing">Dynamic Typing</option>
                        <option value="Its Programmers">Its Programmers</option>
                        <option value="Code Organization">Code Organization</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="proneToLeave">Do you think J.S is going to be replaced in the near future?</label>
                    <select id="proneToLeave" name="proneToLeave" class="form-control" required>
                        <option selected='true' disabled='disabled'>Choose one</option>
                        <option value="NO">No way!</option>
                        <option value="MAYBE">I don't know, maybe?</option>
                        <option value="YES">Absolutely</option>
                    </select>
                </div>
                <div class="form-group d-flex justify-content-between mt-2">
                    <button type="button" onclick="handleLastPage(3)" class="btn btn-danger">Back</button>
                    <button type="submit" class="btn btn-primary">Next</button>
                </div>
            </form>
        </section>
        <section id="sec-4" class="card p-3" style="display:none;">
            <form id="form-sec-4" onsubmit="handleNextPage(event, 4)" novalidate>
                <div class="form-group">
                    <label for="wouldRecommend">How likely are you to recommend JavaScript to someone else?</label>
                    <select id="wouldRecommend" name="wouldRecommend" class="form-control" required>
                        <option selected='true' disabled='disabled'>Choose one</option>
                        <option value="5">Extremely Likely</option>
                        <option value="4">Very Likely</option>
                        <option value="3">Somewhat Likely</option>
                        <option value="2">Slightly Likely</option>
                        <option value="1">Not At All Likely</option>
                    </select>
                </div>
                <div class="form-group d-flex justify-content-between mt-2">
                    <button type="button" onclick="handleLastPage(4)" class="btn btn-danger">Back</button>
                    <button type="submit" class="btn btn-primary">Next</button>
                </div>
            </form>
        </section>
        <section id="sec-5" class="card p-3" style="display:none;">
            <form id="form-sec-5" onsubmit="handleNextPage(event, 5)" novalidate>
                <div class="form-group">
                    <label for="surveyMethod">How did you get to this survey?</label>
                    <select id="surveyMethod" name="surveyMethod" class="form-control" required>
                        <option selected='true' disabled='disabled'>Choose one</option>
                        <option value="NEWSPAPER">Newspaper AD</option>
                        <option value="EMAIL">Email</option>
                        <option value="LINK">Link On Webpage</option>
                        <option value="OTHER">Other</option>
                    </select>
                </div>
                <div class="form-group text-center">
                    <label class="text-left d-block">Would you be okay receiving surveys like this in the future?</label>
                    <div class="form-check-inline">
                        <input onchange="manageEmailFields(this)" class="form-check-input" type="radio" name="futureSurveys" id="futureYes" value="YES" required>
                        <label class="form-check-label" for="futureYes">
                            Yes
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <input onchange="manageEmailFields(this)" class="form-check-input ml-3" type="radio" name="futureSurveys" id="futureNo" value="NO">
                        <label class="form-check-label" for="futureNo">
                            No
                        </label>
                    </div>
                    <input class="mt-3 form-control" type="email" id="emailFuture">
                </div>
                <div class="form-group d-flex justify-content-between mt-2">
                    <button type="button" onclick="handleLastPage(5)" class="btn btn-danger">Back</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </section>
        <!-- Bulk Data Summary Page -->
        <section id="sec-6" class="card p-3" style="display:none;">
            <h1 class="text-center text-primary h3">Success!</h1>
            <h2 class="text-center h5 my-3">Your Submission:</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name: </strong><span id="sub-name">John Doe</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Years Programming: </strong><span id="sub-years">1</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Server-Side JS Knowledge: </strong><span id="sub-server">YES</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>ES6 Knowledge: </strong><span id="sub-es6">YES</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Love Most: </strong><span id="sub-love">Client & Server</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Dislike Most: </strong><span id="sub-dislike">Code Organization</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>JS Prone To Leave: </strong><span id="sub-prone">NO</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Would Recommend Score: </strong><span id="sub-recommend">4</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Survey Discovery Method: </strong><span id="sub-method">LINK</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Surveys In The Future: </strong><span id="sub-future">NO</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Email For Future: </strong><span id="sub-email">test@gmail.com</span></p>
                    </div>
                    <div class="col-md-6 my-auto">
                        <button onclick="restart();" class="btn btn-block btn-primary">Make Another Submission</button>
                    </div>
                </div>
        </section>
        <div id="alert-box" class="alert alert-danger mt-4" role="alert" style="display:none;">
            This is a primary alert—check it out!
        </div>
    </div>
</div>

<?php
include_once "./includes/footer.php"
?>