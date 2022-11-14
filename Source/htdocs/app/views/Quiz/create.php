<html>
<head>

</head>

<body>
<?php include_once('app/views/header.php'); ?>

<script src="/js/quiz.js" defer></script>

<link href="/css/create.css" rel="stylesheet">

<div class="content">
    <div class="h-1 bot-32">Create Quiz</div>

    <?php if (isset($_GET['error'])): ?>

        <div class="error"><?= $_GET['error']; ?></div>

    <?php endif; ?>

    <form method="post" enctype='multipart/form-data'>
        <div class="quiz-name">
            <label class="lbl-s">Quiz Name*</label>

            <input class="field" type="text" name="quiz-name" required />
        </div>

        <div class="quiz-banner">
            <label class="lbl-s">Quiz Banner</label>

            <input type="file" name="quiz-banner" />
        </div>

        <div class="quiz-description">
            <div class="lbl-s">Quiz Description*</div>

            <textarea name="quiz-description" required></textarea>
        </div>

        <div class="quiz-privacy">
            <label class="lbl-s">Quiz Privacy</label>

            <select class="field" name="quiz-privacy">
                <option value="0">Private</option>

                <option value="1">Public</option>
            </select>
        </div>

        <div class="quiz-time">
            <label class="lbl-s">Quiz Time</label>

            <input class="field" type="time" min="00:00:00" max="04:00:00" name="quiz-time" step="1">
        </div>

        <div class="h-2 bot-32">Questions</div>

        <div class="questions">

        </div>

        <button type="button" class="add-que btn-w">Add Question</button><br>

        <button type="submit" name="submit" class="btn-l">Create Quiz</button>
    </form>
</div>

<?php include_once('app/views/footer.php'); ?>
</body>
</html>
