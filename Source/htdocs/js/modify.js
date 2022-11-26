var questions = document.querySelectorAll('.question');

questions.forEach((question) => 
{
    var selectType = question.querySelector('.question-type');
    selectType.addEventListener('change', (event) =>
    {
        var answers = question.querySelector('.answers');

        answers.innerHTML = '';

        if (selectType.value == 'Multiple Choice')
        {
            for (let i = 0; i < 3; i++)
            {
                addAnswer(question);
            }

            var addButton = elementFromHtml(`<button class="white-button add-answer" type="button">Add Answer</button>`);
            addButton.addEventListener('click', (event) =>
            {
                addAnswer(question);
            });

            answers.appendChild(addButton);
        }

        else 
        {
            const index = Array.from(document.querySelector('.questions').children).indexOf(question);

            var answerHeading = elementFromHtml(`
            <h3>Short Answers Keywords (Seperated by Comma ",")*</h3>
            `);

            var shortAnswer = elementFromHtml(`
            <div class="form-field">
                <textarea name="question[${index}][answer][text]"></textarea>
            </div>
            `);

            answers.appendChild(answerHeading);
            answers.appendChild(shortAnswer);
        }
    });

    if (selectType.value == 'Multiple Choice')
    {
        var addButton = question.querySelector('.add-answer');
        addButton.addEventListener('click', (event) =>
        {
            addAnswer(question);
        });
    }

    var deleteButton = question.querySelector('.delete-question');
    deleteButton.addEventListener('click', (event) =>
    {
        question.remove();
        calibrateQuestions();
    });
});

var removeQuestionImageButtons = document.querySelectorAll('.remove-question-image');

removeQuestionImageButtons.forEach((button) => 
{
    var question = button.closest('.question');

    button.addEventListener('click', (event) =>
    {
        button.remove();

        var image = question.querySelector('img');
        image.remove();

        var input = question.querySelector('input[type="hidden"]');
        input.value = '';

        console.log(image);
        console.log(input);
    });
});

var removeQuizImageButton = document.querySelector('.remove-quiz-image');

removeQuizImageButton.addEventListener('click', (event) =>
{
    removeQuizImageButton.remove();

    var image = document.querySelector('.quiz-banner');
    image.remove();

    var input = document.querySelector('.banner-input');
    input.value = '';

    console.log(image);
    console.log(input);
});