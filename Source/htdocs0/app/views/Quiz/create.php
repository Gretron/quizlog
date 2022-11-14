<html>
<head>

</head>

<body>
<?php include_once('app/views/header.php'); ?>

<script src="/js/quiz.js" defer></script>

<div class="content">
    <span class="h-1">Create Quiz</span>

    <form method="post" enctype='multipart/form-data'>
        <div>
            <label class="lbl-s" for="quiz-name">Quiz Name*</label>

            <input type="text" name="quiz-name" id="quiz-name" required />
        </div>

        <div>
            <label class="lbl-s" for="quiz-banner">Quiz Banner</label>

            <input type="file" name="quiz-banner" id="quiz-banner" />
        </div>

        <div>
            <label class="lbl-s" for="quiz-description">Quiz Description*</label><br>

            <textarea name="quiz-description" id="quiz-description" required></textarea>
        </div>

        <div>
            <label class="lbl-s" for="quiz-privacy">Quiz Privacy</label>

            <select name="quiz-privacy" id="quiz-privacy">
                <option value="0">Private</option>

                <option value="1">Public</option>
            </select>
        </div>

        <div>
            <label class="lbl-s" for="quiz-time">Quiz Time</label>

            <input type="time" name="quiz-time" id="quiz-time" step="1">
        </div>

        <span class="heading-2">Questions</span>

        <div class="questions">

        </div>

        <button type="button" class="add-que btn-w">Add Question</button><br>

        <button type="submit" name="submit" class="btn-l">Create Quiz</button>
    </form>
</div>

<?php include_once('app/views/footer.php'); ?>
</body>
</html>
