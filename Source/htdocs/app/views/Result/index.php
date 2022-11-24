<html>
<head>
    <title>Quizlog: Results</title>
</head>

<body>
<?php include_once('app/views/header.php'); ?>

<link href="/css/card.css" rel="stylesheet">

<div class="content">
    <h1>Results</h1>

    <?php if (isset($_GET['error'])): ?>

    <div class="error"><?= $_GET['error']; ?></div>

    <?php endif; ?>

    <div class="result-cards">
        <?php if (count($data['results']) < 1): ?>

        <h2>No results found.</h2>

        <?php endif; ?>

        <?php foreach($data['results'] as $result): ?>

        <div class="result-card">
            <object class="card-image" data="<?= !empty($result->ResultImage) ? '/img/' . $result->ResultImage : '/img/pattern.png'; ?>" type="image/png">
                <img src="/img/pattern.png">
            </object>

            <div class="card-body">
                <h2><?= $result->ResultName; ?></h2>

                <div class="card-score">
                    <h3><?= $result->ResultScore; ?>%</h3>

                    <h4><?= "{$result->RightAnswers} out of {$result->QuestionCount} Questions" ?></h4>

                    <div class="score-bar">
                        <div style="width: <?= $result->ResultScore; ?>%; background-color: var(--<?= $result->ResultScore < 66 ? ($result->ResultScore < 33 ? 'grey' : 'white') : 'orange'; ?>)"></div>
                    </div>
                </div>

                <div class="card-button">
                    <button class="orange-button" onclick="location.href='/result/details/<?= $result->ResultId; ?>'">View Details</button>

                    <button class="grey-button" onclick="location.href='/result/delete/<?= $result->ResultId; ?>'">Delete Result</button>
                </div>
            </div>
        </div>

        <?php endforeach; ?>
    </div>
</div>

<?php include_once('app/views/footer.php'); ?>
</body>
</html>