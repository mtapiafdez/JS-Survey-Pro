CREATE TABLE survey (
    id  INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(100) NOT NULL,
	years_programming INT NOT NULL,
    server_side_js VARCHAR(3) NOT NULL,
    es6 VARCHAR(3) NOT NULL,
    love_most VARCHAR(50) NOT NULL,
    dislike_most VARCHAR(50) NOT NULL,
    prone_to_leave VARCHAR(5) NOT NULL,
    would_recommend INT NOT NULL,
    survey_method VARCHAR(10) NOT NULL,
    future_survey VARCHAR(3) NOT NULL,
    email_future VARCHAR(100) NOT NULL
);

-- In a more detailed production application, not a mere assignment, I would add checks here to check set values for dropdown (pre-determined values)