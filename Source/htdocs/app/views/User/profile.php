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

                            <span class="card-rating">0</span>
                            <svg width="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000">
                                <path class="fullstar" d="M500,260.08a7.88,7.88,0,0,1,7.17,4.46l72.2,146.28a8,8,0,0,0,6,4.37l161.43,23.46a8,8,0,0,1,4.44,13.65L634.45,566.16a8,8,0,0,0-2.31,7.08L659.72,734a8,8,0,0,1-11.61,8.44L503.72,666.55a8,8,0,0,0-7.44,0L351.89,742.46A8,8,0,0,1,340.28,734l27.58-160.78a8,8,0,0,0-2.31-7.08L248.74,452.3a8,8,0,0,1,4.44-13.65l161.43-23.46a8,8,0,0,0,6-4.37l72.2-146.28a7.88,7.88,0,0,1,7.17-4.46m0-100a107.92,107.92,0,0,0-96.85,60.2L352.36,323.19,238.8,339.69a108,108,0,0,0-59.86,184.22L261.12,604l-19.4,113.11A108,108,0,0,0,398.43,831L500,777.57,601.58,831a108,108,0,0,0,156.7-113.85L738.88,604l82.18-80.1A108,108,0,0,0,761.2,339.69l-113.56-16.5L596.85,220.28A107.92,107.92,0,0,0,500,160.08Z"/>
                            </svg>
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