<html>
<head>
    <title>Quizlog: <?= $data['quiz']->QuizName; ?></title>
</head>

<body>
<?php include_once('app/views/header.php'); ?>

<link href="/css/card.css" rel="stylesheet">

<div class="content">
    <?php if (isset($_GET['error'])): ?>

    <div class="error"><?= $_GET['error']; ?></div>

    <?php endif; ?>

    <?php
        $quiz = $data['quiz'];

        $user = new \app\models\User();
        $user = $user->selectUserById($quiz->UserId);

        $time = explode(':', $quiz->QuizTime);
        $hour = $time[0] == '00' ? '' : $time[0] . 'hr ';
        $min = $time[1] == '00' ? '' : $time[1] . 'min ';
        $sec = $time[2] == '00' ? '0sec' : $time[2] . 'sec';
        $time = $hour . $min . $sec;

        $count = new \app\models\Question();
        $count = $count->selectQuestionCountByQuizId($quiz->QuizId);
    ?>

    <div class="detail-card">
        <img class="card-image" src="<?= !empty($quiz->QuizBanner) ? '/img/' . $quiz->QuizBanner : '/img/pattern.png'; ?>">

        <div class="card-body">
            <h2><?= $quiz->QuizName; ?></h2>

            <div class="card-information">
                by <a class="nav-link" href="/user/profile/<?= $user->UserId; ?>"><?= $user->Username; ?></a> • <?= $time; ?> • <?= $count; ?> Questions</span>
            </div>

            <div class="card-description">
                <?= $quiz->QuizDescription; ?>
            </div>

            <div class="card-button">
                <button class="orange-button" onclick="location.href='/perform/practice/<?= $quiz->QuizId; ?>'">Practice Mode</button>

                <button class="white-button" onclick="location.href='/perform/exam/<?= $quiz->QuizId; ?>'">Exam Mode</button>
            </div>
        </div>
    </div>

    <div class="action-card">
        <button class="white-button" onclick="location.href='/quiz/modify/<?= $quiz->QuizId; ?>'">Modify Quiz</button>
        <button class="grey-button" onclick="location.href='/quiz/delete/<?= $quiz->QuizId; ?>'">Delete Delete</button>
    </div>
</div>

<?php include_once('app/views/footer.php'); ?>
</body>
</html>