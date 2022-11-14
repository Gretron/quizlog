<html>
<head>

</head>

<body>
<?php include_once('app/views/header.php'); ?>

<link href="/css/cards.css" rel="stylesheet">

<div class="content">
    <?php

    $user = new \app\models\User();
    $user = $user->selectUserById($data['userId']);

    ?>

    <div class="h-1 bot-32"><?= $user->Username; ?></div>

    <ul class="cards">
        <?php foreach($data['quizzes'] as $quiz): ?>

            <?php

            // If There Isn't A Quiz, Continue...
            if (!$quiz)
                continue;

            $count = new \app\models\Question();
            $count = $count->selectQuestionCountByQuizId($quiz->QuizId);

            ?>

            <li>
                <div class="card-s box">
                    <object class="card-img" data="../../../img/pattern.png" type="image/png">
                        <img src="">
                    </object>

                    <div class="card-body pad-16">
                        <div class="card-head">
                            <div class="card-title h-4"><span class="h-4"><?= $quiz->QuizName; ?></span></div>
                        </div>

                        <div class="card-info">
                            <span>by <a class="nav-link" href="/user/profile/<?= $user->UserId; ?>"><?= $user->Username; ?></a> • <?= $count; ?> Questions</span>
                        </div>

                        <div class="card-desc">
                            <p><?= $quiz->QuizDescription; ?></p>
                        </div>

                        <div>
                            <a class="btn-s" href="/quiz/details/<?= $quiz->QuizId; ?>">Take Quiz</a>
                        </div>
                    </div>
                </div>
            </li>

        <?php endforeach; ?>
    </ul>
</div>

<?php include_once('app/views/footer.php'); ?>
</body>
</html>