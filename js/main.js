const handleNextPage = async (event, currentPage) => {
    event.preventDefault();

    const validationData = await validateSection(currentPage);

    if (validationData.type === "SUCCESS") {
        $("#alert-box").hide();
        $(`#sec-${currentPage}`).hide();

        if (currentPage === 5) {
            await fillSuccessPage();
        }

        const nextPage = currentPage + 1;
        $(`#sec-${nextPage}`).show();
    } else {
        $("#alert-box").show();
        $("#alert-box").html(validationData.message);
    }
};

const handleLastPage = currentPage => {
    $("#alert-box").hide();
    $(`#sec-${currentPage}`).hide();

    if (currentPage === 1) {
        alert("at start");
    } else {
        const lastPage = currentPage - 1;
        $(`#sec-${lastPage}`).show();
    }
};

const manageEmailFields = elem => {
    if (elem.value === "YES") {
        $("#emailFuture").show();
        $("#emailFuture").attr("required", "true");
    } else {
        $("#emailFuture").hide();
        $("#emailFuture").removeAttr("required");
    }
};

//* Validate Inputs And Store In Server
const validateSection = async page => {
    let data;
    if (page === 1) {
        const name = $("#name").val();
        const programmingYears = $("#programmingYears").val();

        data = await fetch("./api/processForm.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                page,
                name,
                programmingYears
            })
        });
    } else if (page === 2) {
        const nodeJS = $("#nodeJSYes").is(":checked")
            ? $("#nodeJSYes").val()
            : $("#nodeJSNo").is(":checked")
            ? $("#nodeJSNo").val()
            : "";
        const es6Knowledge = $("#es6KnowledgeYes").is(":checked")
            ? $("#es6KnowledgeYes").val()
            : $("#es6KnowledgeNo").is(":checked")
            ? $("#es6KnowledgeNo").val()
            : "";

        data = await fetch("./api/processForm.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                page,
                nodeJS,
                es6Knowledge
            })
        });
    } else if (page === 3) {
        const loveMost = $("#loveMost").val();
        const dislikeMost = $("#dislikeMost").val();
        const proneToLeave = $("#proneToLeave").val();

        data = await fetch("./api/processForm.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                page,
                loveMost,
                dislikeMost,
                proneToLeave
            })
        });
    } else if (page === 4) {
        const wouldRecommend = $("#wouldRecommend").val();

        data = await fetch("./api/processForm.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                page,
                wouldRecommend
            })
        });
    } else if (page === 5) {
        const surveyMethod = $("#surveyMethod").val();
        const futureSurveys = $("#futureYes").is(":checked")
            ? $("#futureYes").val()
            : $("#futureNo").is(":checked")
            ? $("#futureNo").val()
            : "";
        const emailFuture = $("#emailFuture").val();

        data = await fetch("./api/processForm.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                page,
                surveyMethod,
                futureSurveys,
                emailFuture
            })
        });
    } else if (page === "GET-DATA") {
        data = await fetch("./api/processForm.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                page
            })
        });
    }

    return await data.json();
};

// I use this function on test.php session variable explorer
const pageReloadOnTimer = () => {
    setTimeout(function () {
        window.location.reload(1);
    }, 1000);
};

// Fills Final Page
const fillSuccessPage = async () => {
    const allData = await validateSection("GET-DATA");
    const { PAGE1, PAGE2, PAGE3, PAGE4, PAGE5 } = allData;

    $("#sub-name").html(PAGE1.name);
    $("#sub-years").html(PAGE1.programmingYears);

    $("#sub-server").html(PAGE2.nodeJS);
    $("#sub-es6").html(PAGE2.es6Knowledge);

    $("#sub-love").html(PAGE3.loveMost);
    $("#sub-dislike").html(PAGE3.dislikeMost);
    $("#sub-prone").html(PAGE3.proneToLeave);

    $("#sub-recommend").html(PAGE4.wouldRecommend);

    $("#sub-method").html(PAGE5.surveyMethod);
    $("#sub-future").html(PAGE5.futureSurveys);

    $("#sub-email").html(
        PAGE5.emailFuture !== "noemail@email.com"
            ? PAGE5.emailFuture
            : "No email"
    );
};

const restart = () => {
    location.reload();
};
