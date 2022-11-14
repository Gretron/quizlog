<html>
<head>

</head>

<body>
<?php include_once('app/views/header.php'); ?>

<link href="/css/cards.css" rel="stylesheet">

<div class="content">
    <div class="bot-32">
        <form class="search-form">
            <input class="field" type="text" name="q" placeholder="<?= isset($_GET['q']) ? $_GET['q'] : 'Search term...'; ?>">
            <button class="btn-l">Search</button>
        </form>
    </div>

    <?php if (isset($_GET['q'])): ?>

    <div class="h-2 bot-32">Search Results for '<?= $_GET['q']; ?>':</div>

    <?php endif; ?>

    <ul class="cards">
        <?php foreach($data as $quiz): ?>

        <?php
            $user = new \app\models\User();
            $user = $user->selectUserById($quiz->UserId);

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
