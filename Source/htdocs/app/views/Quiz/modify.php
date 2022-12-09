<html>
<head>
    <title>Quizlog: <?= _("Modify") ?></title>
</head>

<body>
<?php include_once('app/views/header.php'); ?>

<link href="/css/create.css" rel="stylesheet">

<script type="text/javascript" src="/js/quiz.js" defer></script>
<script type="text/javascript" src="/js/modify.js" defer></script>

<div class="content">
    <h1><?= _("Modify Quiz") ?></h1>

    <?php if (isset($_GET['error'])): ?>

    <div class="error"><?= $_GET['error']; ?></div>

    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="form-field">
            <label>Quiz Name*</label>

            <input type="text" name="quiz-name" pattern="^.{8,128}" value="<?= htmlentities($data['quiz']->QuizName); ?>" required>
        </div>

        <?php if (!empty($data['quiz']->QuizBanner)): ?>

        <img class="quiz-banner" src="<?= !empty($data['quiz']->QuizBanner) ? '/img/' . $data['quiz']->QuizBanner : '/img/pattern.png'; ?>">

        <?php

        $banner = explode('/', $data['quiz']->QuizBanner);

        $banner = $banner[count($banner) - 1]

        ?>

        <button class="grey-button remove-quiz-image" type="button">Remove Existing Image</button>

        <?php endif; ?>

        <input type="hidden" class="banner-input" name="quiz-banner" value="<?= isset($banner) ? $banner : ''; ?>">

        <div class="form-field">
            <label>Quiz Banner</label>

            <input type="file" name="quiz-banner">
        </div>

        <div class="form-field">
            <label>Quiz Description</label>

            <textarea name="quiz-description"><?= htmlentities($data['quiz']->QuizDescription); ?></textarea>
        </div>

        <div class="form-field">
            <label>Quiz Privacy*</label>

            <select name="quiz-privacy">
                <option value="0" <?= $data['quiz']->QuizPrivacy == 1 ? '' : 'selected'; ?>>Private</option>
                <option value="1" <?= $data['quiz']->QuizPrivacy == 1 ? 'selected' : ''; ?>>Public</option>
            </select>
        </div>

        <div class="form-field">
            <?php $time = explode(':', $data['quiz']->QuizTime);  ?>

            <label>Quiz Time*</label>

            <div class="form-time">
                <input type="number" name="quiz-hour" value="<?= $time[0]; ?>" min="0" max="3">

                <label>H</label>
            </div>

            <div class="form-time">
                <input type="number" name="quiz-minute" value="<?= $time[1]; ?>" min="0" max="59">

                <label>M</label>
            </div>

            <div class="form-time">
                <input type="number" name="quiz-second" value="<?= $time[2]; ?>" min="0" max="59">

                <label>S</label>
            </div>
        </div>

        <h2>Questions</h2>

        <div class="questions">

        <?php $questionCount = 0; ?>

        <?php foreach($data['questions'] as $question): ?> 

        <div class="question">
            <div class="form-field">
                <label>Question Text*</label>

                <input type="text" class="question-text" name="question[<?= $questionCount; ?>][text]" pattern="^.{8,}" value="<?= htmlentities($question->QuestionText) ?>" required>
            </div>

            <?php if (!empty($question->QuestionImage)): ?>

                <img src="<?= !empty($question->QuestionImage) ? '/img/' . $question->QuestionImage : '/img/pattern.png'; ?>">

                <?php
                
                $image = explode('/', $question->QuestionImage);

                $image = $image[count($image) - 1]

                ?>

            <button class="grey-button remove-question-image" type="button">Remove Existing Image</button>

            <?php endif; ?>

            <input type="hidden" name="question[<?= $questionCount; ?>][image]" value="<?= isset($image) ? $image : ''; ?>">

            <?php $image = null ?>

            <div class="form-field">
                <label>Question Image</label>

                <input type="file" class="question-image" name="question[<?= $questionCount; ?>][image]">
            </div>

            <div class="form-field">
                <label>Question Hint</label>

                <input type="text" class="question-hint" name="question[<?= $questionCount; ?>][hint]" value="<?= htmlentities($question->QuestionHint) ?>">
            </div>

            <h3>Question Answers</h3>

            <div class="form-field">
                <label>Answer Type*</label>

                <select name="question[<?= $questionCount; ?>][type]" class="question-type" required>
                    <option value="Multiple Choice" <?= $question->QuestionType == 'Multiple Choice' ? 'selected' : ''; ?>>Multiple Choice</option>

                    <option value="Short Answer" <?= $question->QuestionType == 'Short Answer' ? 'selected' : ''; ?>>Short Answer</option>
                </select>
            </div>

            <div class="answers">
                <?php if ($question->QuestionType == 'Multiple Choice'): ?>

                <?php $answerCount = 0; ?>

                <?php foreach($question->Answers as $answer): ?>

                <div class="answer" draggable="true">
                    <input type="text" class="answer-text" name="question[<?= $questionCount; ?>][answer][<?= $answerCount; ?>][text]" value="<?= htmlentities($answer->AnswerText) ?>" required>

                    <label class="radio">
                        <input type="radio" class="answer-radio" name="question[<?= $questionCount; ?>][correct]" <?= $answer->AnswerCorrect == 1 ? 'checked' : ''; ?> value="<?= $answerCount; ?>" required>

                        <div class="checkmark"></div>
                    </label>

                    <button class="grey-button delete-answer" type="button">Delete</button>
                </div>

                <?php $answerCount++; ?>

                <?php endforeach; ?>

                <button class="white-button add-answer" type="button">Add Answer</button>

                <?php else: ?>

                <h3>Short Answers Keywords (Seperated by Comma ",")*</h3>

                <div class="form-field">
                    <textarea name="question[<?= $questionCount; ?>][answer][text]"><?= htmlentities($question->Answers[0]->AnswerText); ?></textarea>
                </div>

                <?php endif; ?>
            </div>

            <button class="grey-button delete-question" type="button">Delete Question</button>
        </div>

        <?php $questionCount++; ?>

        <?php endforeach; ?>

        </div>

        <button class="white-button create-question" type="button">Create Question</button>

        <button class="orange-button" type="submit" name="submit">Modify Quiz</button>
    </form>
</div>

<?php include_once('app/views/footer.php'); ?>
</body>
</html>
