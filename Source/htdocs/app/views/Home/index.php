<html>
<head>

</head>

<body>
<?php include_once('app/views/header.php'); ?>

<link href="/css/cards.css" rel="stylesheet">

<div class="content">
    <div class="h-1 bot-32">Home</div>

    <?php if (isset($_GET['error'])): ?>

        <div class="error"><?= $_GET['error']; ?></div>

    <?php endif; ?>

    <?php foreach($data as $quiz): ?>

    <?php
        $user = new \app\models\User();
        $user = $user->selectUserById($quiz->UserId);

        $date = explode(':', $quiz->QuizTime);
        $hour = $date[0] == '00' ? '' : $date[0] . 'hr ';
        $min = $date[1] == '00' ? '' : $date[1] . 'min ';
        $sec = $date[2] == '00' ? '0sec' : $date[2] . 'sec';
        $date = $hour . $min . $sec;

        $count = new \app\models\Question();
        $count = $count->selectQuestionCountByQuizId($quiz->QuizId);
    ?>

    <div class="card-l box pad-16 bot-32">
        <object class="card-img" data="../../../img/pattern.png" type="image/png">
            <img src="">
        </object>

        <div class="card-head">
            <div class="card-title h-3"><span class="h-3"><?= $quiz->QuizName; ?></span></div>
        </div>

        <div class="card-desc">
            <p><?= $quiz->QuizDescription; ?></p>
        </div>

        <div class="card-info">
            <span>by <a class="nav-link" href="/user/profile/<?= $user->UserId; ?>"><?= $user->Username; ?></a> • <?= $date; ?> • <?= $count; ?> Questions</span>
        </div>

        <div class="card-btns">
            <a class="btn-l">Take Quiz</a>
            <?php if ($quiz->UserId == $_SESSION['UserId']): ?>
                <a class="btn-w" href="/quiz/delete/<?= $quiz->QuizId; ?>">Delete Quiz</a>
            <?php endif; ?>
        </div>
    </div>

    <?php endforeach; ?>
</div>

<?php include_once('app/views/footer.php'); ?>
</body>
</html>
