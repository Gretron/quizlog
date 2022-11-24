<html>
<head>
    <title>Quizlog: Quiz Details</title>
</head>

<body>
<?php include_once('app/views/header.php'); ?>

<link href="/css/card.css" rel="stylesheet">

<div class="content">
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
        <object class="card-image" data="<?= !empty($quiz->QuizBanner) ? '/img/' . $quiz->QuizBanner : '/img/pattern.png'; ?>" type="image/png">
            <img src="/img/pattern.png">
        </object>

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
</div>

<?php include_once('app/views/footer.php'); ?>
</body>
</html>