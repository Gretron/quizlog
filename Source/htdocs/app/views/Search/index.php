<html>
<head>
    <title>Quizlog: <?= _("Search") ?></title>
</head>

<body>
<?php include_once('app/views/header.php'); ?>

<link href="/css/search.css" rel="stylesheet">
<link href="/css/card.css" rel="stylesheet">

<div class="content">
    <form class="search-form">
        <div class="form-field">
            <input type="text" name="q" placeholder="<?= isset($_GET['q']) ? $_GET['q'] : _("Search term..."); ?>">
        </div>

        <button class="orange-button"><?= _("Search") ?></button>
    </form>

    <?php if (isset($_GET['q'])): ?>

    <h2>Search Results for '<?= $_GET['q']; ?>':</h2>

        <?php if (count($data) < 1): ?>

        <h3><?= _("No results found.") ?></h3>

        <?php endif; ?>

    <?php endif; ?>

    <div class="small-cards">
        <?php foreach($data as $quiz): ?>

        <?php
            $user = new \app\models\User();
            $user = $user->selectUserById($quiz->UserId);

            $count = new \app\models\Question();
            $count = $count->selectQuestionCountByQuizId($quiz->QuizId);
        ?>

        <div class="small-card">
            <img class="card-image" src="<?= !empty($quiz->QuizBanner) ? '/img/' . $quiz->QuizBanner : '/img/pattern.png'; ?>">

            <div class="card-body">
                <h3><?= htmlentities($quiz->QuizName); ?></h3>

                <div class="card-information">
                    by <a class="nav-link" href="/user/profile/<?= $user->UserId; ?>"><?= htmlentities($user->Username); ?></a> • <?= $count; ?> <?= _("Questions") ?></span>
                </div>

                <div class="card-description">
                    <?= htmlentities($quiz->QuizDescription); ?>
                </div>

                <div class="card-button">
                    <button class="orange-button" onclick="location.href='/quiz/details/<?= $quiz->QuizId; ?>'"><?= _("Take") ?></button>

                    <?php if ($quiz->UserId == $_SESSION['UserId']): ?>

                    <button class="white-button" onclick="location.href='/quiz/modify/<?= $quiz->QuizId; ?>'"><?= _("Modify") ?></button>

                    <button class="grey-button" onclick="location.href='/quiz/delete/<?= $quiz->QuizId; ?>'"><?= _("Delete") ?></button>

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
