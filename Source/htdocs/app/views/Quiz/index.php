<html>
<head>
    <title>Quizlog: Quizzes</title>
</head>

<body>
<?php include_once('app/views/header.php'); ?>

<link href="/css/card.css" rel="stylesheet">

<div class="content">
    <h1>My Quizzes</h1>

    <?php if (isset($_GET['error'])): ?>

    <div class="error"><?= $_GET['error']; ?></div>

    <?php endif; ?>

    <?php if (count($data['quizzes']) < 1): ?>

    <h2>No quizzes found.</h2>

    <?php endif; ?>

    <?php foreach($data['quizzes'] as $quiz): ?>

    <?php
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

    <div class="big-card">
        <object class="card-image" data="<?= !empty($quiz->QuizBanner) ? '/img/' . $quiz->QuizBanner : '/img/pattern.png'; ?>" type="image/png">
            <img src="/img/pattern.png">
        </object>

        <h3><?= $quiz->QuizName; ?></h3>

        <div class="card-description">
            <?= $quiz->QuizDescription; ?>
        </div>

        <div class="card-information">
            by <a class="nav-link" href="/user/profile/<?= $user->UserId; ?>"><?= $user->Username; ?></a> • <?= $time; ?> • <?= $count; ?> Questions</span>
        </div>

        <div class="card-button">
            <button class="orange-button" onclick="location.href='/quiz/details/<?= $quiz->QuizId; ?>'">Take Quiz</button>

            <?php if ($quiz->UserId == $_SESSION['UserId']): ?>

            <button class="white-button" onclick="location.href='/quiz/modify/<?= $quiz->QuizId; ?>'">Modify Quiz</button>

            <button class="grey-button" onclick="location.href='/quiz/delete/<?= $quiz->QuizId; ?>'">Delete Quiz</button>

            <?php endif; ?>
        </div>
    </div>

    <?php endforeach; ?>
</div>

<?php include_once('app/views/footer.php'); ?>
</body>
</html>
