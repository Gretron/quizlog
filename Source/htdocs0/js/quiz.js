window.onload = init()

function init()
{
    const questions = document.querySelector('.questions')

    for (let i = 0; i < 3; i++)
    {
        createQuestion(questions)
    }
}

const addQuestion = document.querySelector('.add-que')

addQuestion.addEventListener('click', (event) =>
{
    const questions = document.querySelector('.questions')

    createQuestion(questions)
})

// Create Question Using Questions Container
function createQuestion(questions)
{
    // Get Count of Existing Questions
    let count = questions.querySelectorAll('.que').length;

    // Create Question
    const id = 'q'.concat(count)

    // Create Container
    let container = document.createElement('div')
    container.id = id
    container.className = 'que box pad-16'
    container.draggable = true

    let hidden = document.createElement('input')
    hidden.className = 'id'
    hidden.type = 'hidden'
    hidden.value = 'set'
    hidden.name = id

    container.appendChild(hidden)

    // Create Question Text Field
    let text = document.createElement('div')

    let textLabel = document.createElement('label')
    textLabel.className = 'lbl-s'
    textLabel.innerHTML = 'Question Text*'

    let textInput = document.createElement('input')
    textInput.className = 'que-txt'
    textInput.type = 'text'
    textInput.name = id.concat('-txt')
    textInput.required = true

    text.appendChild(textLabel)
    text.appendChild(textInput)

    container.appendChild(text)

    // Create Question Image Field
    let image = document.createElement('div')

    let imageLabel = document.createElement('label')
    imageLabel.className = 'lbl-s'
    imageLabel.innerHTML = 'Question Image'

    let imageInput = document.createElement('input')
    imageInput.className = 'que-img'
    imageInput.type = 'file'
    imageInput.name = id.concat('-txt')

    image.appendChild(imageLabel)
    image.appendChild(imageInput)

    container.appendChild(image)

    // Create Question Hint Field
    let hint = document.createElement('div')

    let hintLabel = document.createElement('label')
    hintLabel.className = 'lbl-s'
    hintLabel.innerHTML = 'Question Hint:'

    let hintInput = document.createElement('input')
    hintInput.className = 'que-hint'
    hintInput.type = 'text'
    hintInput.name = id.concat('-hint')

    hint.appendChild(hintLabel)
    hint.appendChild(hintInput)

    container.appendChild(hint)

    // Create Question Answers Heading
    let heading = document.createElement('span')
    heading.className = 'heading-3'
    heading.innerHTML = 'Question Answers'

    let lineBreak1 = document.createElement('br')

    container.appendChild(heading)
    container.appendChild(lineBreak1)

    // Create Answers Area
    let answersArea = document.createElement('div')

    let typeLabel = document.createElement('label')
    typeLabel.className = 'lbl-s'
    typeLabel.innerHTML = 'Answers Type:'

    let lineBreak2 = document.createElement('br')

    let selectType = document.createElement('select')
    selectType.name = id.concat('-type')
    selectType.className = 'ans-type'

    let option0 = document.createElement('option')
    option0.value = 'Multiple Choice'
    option0.innerHTML = 'Multiple Choice'
    option0.selected = true

    let option1 = document.createElement('option')
    option1.value = 'Short Answer'
    option1.innerHTML = 'Short Answer'

    selectType.addEventListener('change', (event) =>
    {
        // Get Question Id
        const id = event.target.closest('.que').id

        // Get Answers Container
        var answers = event.target.parentNode.querySelector('.answers')

        // Clear Child Elements
        answers.innerHTML = '';

        // If Multiple Choice Was Selected...
        if (event.target.value == "Multiple Choice")
        {
            // Create 3 Fields
            for (let i = 0; i < 3; i++)
            {
                createAnswer(answers)
            }

            // Create Add Answer Button
            let add = document.createElement('button')
            add.className = 'add-ans'
            add.type = 'button'
            add.innerHTML = 'Add Answer'
            add.addEventListener('click', (event) =>
            {
                const answers = event.target.closest('.answers')

                createAnswer(answers)
            })

            answers.appendChild(add)
        }

        // If Short Answer Was Selected...
        else
        {
            let container = document.createElement('div')
            container.className = 'ans'

            let label = document.createElement('label')
            label.className = 'lbl-s'
            label.innerHTML = 'Short Answers Keywords (Seperated by Comma ",")*'

            let lineBreak = document.createElement('br')

            let textArea = document.createElement('textarea')
            textArea.className = 'ans-txt'
            textArea.name = id.concat('-a0')
            textArea.required = true

            container.appendChild(label)
            container.appendChild(lineBreak)
            container.appendChild(textArea)

            answers.appendChild(container)
        }
    })

    selectType.appendChild(option0)
    selectType.appendChild(option1)

    let answersBox = document.createElement('div')
    answersBox.className = 'answers box pad-16'

    // Add Add Answer Button
    let addAnswer = document.createElement('button')
    addAnswer.className = 'add-ans'
    addAnswer.innerHTML = 'Add Answer'
    addAnswer.addEventListener('click', (event) =>
    {
        const answers = event.target.closest('.answers')

        createAnswer(answers)
    })

    answersBox.appendChild(addAnswer)

    // Add Components to Answer Area
    answersArea.appendChild(typeLabel)
    answersArea.appendChild(lineBreak2)
    answersArea.appendChild(selectType)
    answersArea.appendChild(answersBox)

    // Add Answer Area to Question
    container.appendChild(answersArea)

    // Add Delete Question Button
    let deleteQuestion = document.createElement('button')
    deleteQuestion.className = 'btn-b del-que'
    deleteQuestion.innerHTML = 'Delete Question'
    deleteQuestion.addEventListener('click', (event) =>
    {
        const questions = event.target.closest('.questions')
        event.target.closest('.que').remove()
        calibrateQuestions(questions)
    })

    container.appendChild(deleteQuestion)

    // Add Question to Questions
    questions.appendChild(container)

    // Add Answers to Answers Box
    for (let i = 0; i < 3; i++)
    {
        createAnswer(answersBox)
    }
}

// Calibrate Question Ids Using Questions Container
function calibrateQuestions(questions)
{
    // Get All Answers in Container
    let items = questions.querySelectorAll('.que')

    // Start Count
    let count = 0;

    // For Each Question...
    items.forEach(question =>
    {
        const id = 'q'.concat(count)

        question.id = id

        let identifier = question.querySelector('.id')
        identifier.name = id

        let text = question.querySelector('.que-txt')
        text.name = id.concat('-txt')

        let image = question.querySelector('.que-img')
        image.name = id.concat('-img')

        let hint = question.querySelector('.que-hint')
        hint.name = id.concat('-hint')

        let type = question.querySelector('.ans-type')
        type.name = id.concat('-type')

        calibrateAnswers(question.querySelector('.answers'))

        count++;
    })
}

// Create Answer Using Answer Container
function createAnswer(answers)
{
    // Get Question Id
    const id = answers.closest('.que').id

    // Get the Add Answer Button
    const add = answers.querySelector('.add-ans')

    // Get Count of Existing Answers
    const count = answers.querySelectorAll('.ans').length

    if (count >= 6)
        return;

    // Create Answer
    let container = document.createElement('div')
    container.className = 'ans'
    container.draggable = true

    let text = document.createElement('input')
    text.className = 'ans-txt'
    text.type = 'text'
    text.name = id.concat('-a', count, '-txt')
    text.required = true

    let radio = document.createElement('input')
    radio.className = 'ans-c'
    radio.type = 'radio'
    radio.name = id.concat('-c')
    radio.value = 'a'.concat(count)
    radio.required = true

    let button = document.createElement('button')
    button.className = 'btn-b del-ans'
    button.innerHTML = 'Delete'
    button.addEventListener('click', (event) =>
    {
        const answers = event.target.closest('.answers')
        event.target.closest('.ans').remove()
        calibrateAnswers(answers)
    })

    container.appendChild(text)
    container.appendChild(radio)
    container.appendChild(button)

    answers.insertBefore(container, add)

    if (count == 5)
        add.disabled = true
}

// Calibrate Answer Ids Using Answers Container
function calibrateAnswers(answers)
{
    // Get All Answers in Container
    let items = answers.querySelectorAll('.ans')

    // Get Question Id
    const id = answers.closest('.que').id

    // Start Count
    let count = 0;

    // For Each Answer...
    items.forEach(answer =>
    {
        let text = answer.querySelector('.ans-txt')
        text.name = id.concat('-a', count, '-txt')

        let radio = answer.querySelector('.ans-c')
        radio.value = 'a'.concat(count)

        // Increment Count
        count++;

        console.log(answer)
    })
}

