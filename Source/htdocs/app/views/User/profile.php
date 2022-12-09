<html>
<head>
    <?php

    $user = new \app\models\User();
    $user = $user->selectUserById($data['userId']);

    ?>

    <title>Quizlog: <?= htmlentities($user->Username); ?></title>
</head>

<body>
<?php include_once('app/views/header.php'); ?>

<link href="/css/card.css" rel="stylesheet">

<div class="content">
    <h1><?= htmlentities($user->Username); ?></h1>

    <?php if (count($data['quizzes']) < 1): ?>

    <h2><?= _("No quizzes found."); ?></h2>

    <?php endif; ?>

    <div class="small-cards">
    <?php foreach($data['quizzes'] as $quiz): ?>

        <?php

        // If There Isn't A Quiz, Continue...
        if (!$quiz)
            continue;

        $count = new \app\models\Question();
        $count = $count->selectQuestionCountByQuizId($quiz->QuizId);

        ?>

        <div class="small-card">
            <img class="card-image" src="<?= !empty($quiz->QuizBanner) ? '/img/' . $quiz->QuizBanner : '/img/pattern.png'; ?>">

            <div class="card-body">
                <h3><?= htmlentities($quiz->QuizName); ?></h3>

                <div class="card-information">
                    <?= _("by") ?> <a class="nav-link" href="/user/profile/<?= $user->UserId; ?>"><?= htmlentities($user->Username); ?></a> • <?= $count; ?> Questions</span>
                </div>

                <div class="card-description">
                    <?= htmlentities($quiz->QuizDescription); ?>
                </div>

                <div class="card-button">
                    <button class="orange-button" onclick="location.href='/quiz/details/<?= $quiz->QuizId; ?>'"><?= _("Take"); ?></button>

                    <?php if ($quiz->UserId == $_SESSION['UserId']): ?>

                    <button class="white-button" onclick="location.href='/quiz/modify/<?= $quiz->QuizId; ?>'"><?= _("Modify"); ?></button>

                    <button class="grey-button" onclick="location.href='/quiz/delete/<?= $quiz->QuizId; ?>'"><?= _("Delete"); ?></button>

                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endforeach; ?>
    </div>
</div>

<?php include_once('app/views/footer.php'); ?>
</body>
</html>