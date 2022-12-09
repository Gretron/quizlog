<html>
<head>
    <title>Quizlog: <?= _("Results") ?></title>
</head>

<body>
<?php include_once('app/views/header.php'); ?>

<link href="/css/card.css" rel="stylesheet">

<div class="content">
    <h1><?= _("Results") ?></h1>

    <?php if (isset($_GET['error'])): ?>

    <div class="error"><?= $_GET['error']; ?></div>

    <?php endif; ?>

    <div class="result-cards">
        <?php if (count($data['results']) < 1): ?>

        <h2><?= _("No results found.") ?></h2>

        <?php endif; ?>

        <?php foreach($data['results'] as $result): ?>

        <div class="result-card">
            <img class="card-image" src="<?= !empty($result->ResultImage) ? '/img/' . $result->ResultImage : '/img/pattern.png'; ?>">

            <div class="card-body">
                <h2><?= htmlentities($result->ResultName); ?></h2>

                <div class="card-score">
                    <h3><?= $result->ResultScore; ?>%</h3>

                    <h4><?= "{$result->RightAnswers} ". _("out of") ." {$result->QuestionCount} " . _("Questions") ?></h4>

                    <div class="score-bar">
                        <div style="width: <?= $result->ResultScore; ?>%; background-color: var(--<?= $result->ResultScore < 66 ? ($result->ResultScore < 33 ? 'grey' : 'white') : 'orange'; ?>)"></div>
                    </div>
                </div>

                <div class="card-button">
                    <button class="orange-button" onclick="location.href='/result/details/<?= $result->ResultId; ?>'"><?= _("View Details") ?></button>

                    <button class="grey-button" onclick="location.href='/result/delete/<?= $result->ResultId; ?>'"><?= _("Delete Result") ?></button>
                </div>
            </div>
        </div>

        <?php endforeach; ?>
    </div>
</div>

<?php include_once('app/views/footer.php'); ?>
</body>
</html>