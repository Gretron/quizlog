<html>
<head>
    <title>Quizlog: <?= _("Perform") ?></title>
</head>

<body>
<?php include_once('app/views/header.php'); ?>

<link href="/css/card.css" rel="stylesheet">
<link href="/css/perform.css" rel="stylesheet">

<script defer>
    var completedTime = new Date('<?= $data['result']->CompletedTime; ?>').getTime();

    const offset = new Date('<?= $date = date('Y-m-d H:i:s'); ?>').getTime() - new Date().getTime();

    console.log(completedTime);
    console.log(new Date().getTime() + offset);

    function updateCountdown()
    {
        var now = new Date().getTime() + offset;

        var distance = completedTime - now;

        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.querySelector('.countdown').innerHTML = `${hours}h ${minutes}m ${seconds}s`

        if (distance <= 0) 
        {
            clearInterval(update);
            document.querySelector('.countdown').innerHTML = "Time's Up!";

            setTimeout(function()
            {
                document.location.href = '/result';
            }, 3000);
        }
    }

    window.onload = updateCountdown;

    var update = setInterval(updateCountdown, 500);
</script>

<div class="content">
    <div class="navigation">
        <button class="grey-button" onclick="location.href='/perform/previous'" <?= ($data['result']->ResultMode == 'Practice' && $data['result']->CurrentQuestion != 0) ? '' : 'disabled' ?>>Previous</button>

        <div class="countdown">0h 0m 0s</div>

        <?php if ($data['count'] != $data['result']->CurrentQuestion): ?>
            <button class="orange-button" onclick="location.href='/perform/next'"><?= _("Next") ?></button>
        <?php else: ?>
            <button class="orange-button" style="opacity: 0; cursor: default;"><?= _("Next") ?></button>
        <?php endif; ?>
    </div>

    <?php if (isset($_GET['error'])): ?>

    <div class="error"><?= $_GET['error']; ?></div>

    <?php endif; ?>

    <div class="perform-card">
        <img class="card-image" src="<?= !empty($data['question']->QuestionImage) ? '/img/' . $data['question']->QuestionImage : '/img/pattern.png'; ?>">

        <h4><?= htmlentities($data['question']->QuestionText); ?></h3>

        <div class="card-hint">
            <?= $data['result']->ResultMode == 'Practice' ? htmlentities($data['question']->QuestionHint) : '' ?>
        </div>

        <form class="card-answer" method="post">
            <?php if ($data['question']->QuestionType == 'Multiple Choice'): ?>
                <?php foreach($data['answers'] as $answer): ?>
                    <button type="submit" name="choice" value="<?= htmlentities($answer->AnswerText); ?>" class="orange-button <?= $answer->AnswerText == $data['choice']->ChoiceText ? 'selected-button' : ''; ?>"><?= htmlentities($answer->AnswerText); ?></button>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="form-field">
                    <textarea name="text"><?= htmlentities($data['choice']->ChoiceText); ?></textarea>

                    <button name="submit" type="submit" class="orange-button <?= !empty($data['choice']->ChoiceText) ? 'selected-button' : ''; ?>">Submit</button>
                </div>
            <?php endif; ?>
        </form>
    </div>

    <div class="completion">
        <button class="white-button" onclick="location.href='/result/complete/<?= $data['result']->ResultId; ?>'"><?= _("Finish") ?></button>
    </div>
</div>

<?php include_once('app/views/footer.php'); ?>
</body>
</html>
