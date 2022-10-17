const form = document.querySelector('#form'),
    input = form.querySelector('input'),
    btn = form.querySelector('button'),
    tasksList = document.querySelector('#tasks'),
    messageContainer = document.querySelector('.message'),
    messageText = messageContainer.querySelector('p'),
    select = document.querySelector('select');


// functions
function displayMessage(message, type) {
    messageText.textContent = message;
    messageContainer.classList.add(type);
    messageContainer.classList.add("active");
    setTimeout(function () {
        messageContainer.classList.remove("active");
        messageContainer.classList.remove(type);
    }, 2000);
}

function addTask() {
    let task = input.value;

    $.ajax({
        url: 'actions/insert.php',
        type: 'POST',
        data: { task: task },
        success: function (response) {
            response = JSON.parse(response);

            if (response.error) {
                displayMessage(response.error, 'danger')
                form.reset();
                return;
            }

            displayMessage(response.success, 'success');
            form.reset();
            getTasks();
        }
    });
}

function getTasks(filter = "all") {

    filter = localStorage.getItem('filter') ? localStorage.getItem('filter') : filter;
    select.value = filter;

    $.ajax({
        url: 'actions/select.php',
        type: 'POST',
        data: { filter: filter },
        success: function (response) {
            tasksList.innerHTML = '';
            response = JSON.parse(response);
            if (response.error) {
                let li = document.createElement('li');
                li.classList.add('task');
                li.innerHTML = `<p class="text">${response.error}</p>`;
                tasksList.appendChild(li);
                return;
            }
                
            console.log(response);

            response.forEach(task => {
                let li = document.createElement('li'),
                    doneClass = statusTitle = "";

                doneClass = task.status == 2 ? 'done' : '';
                task.status == 2 ? li.classList.add('done') : li.classList.add('not-done');
                task.status == 2 ? statusTitle = 'Marcar como não concluído' : statusTitle = 'Marcar como concluído';

                li.classList.add('task');
                li.innerHTML = `
                    <p class="text">${task.description}</p>
                    <textarea onblur="editTask(this, ${task.idTarefa})" value="${task.description}"></textarea>
                    <div class="right">
                        <div class="actions">
                            <button onclick="deleteTask(${task.idTarefa})" title="Deletar tarefa"><i class="fas fa-trash-alt"></i></button>
                            <button onclick="openTextarea(this)" title="Editar tarefa"><i class="fas fa-edit"></i></button>
                        </div>
                        <div class="status ${doneClass}" title="${statusTitle}">
                            <i class="fas fa-check" onclick="updateStatus(${task.idTarefa}, this)"></i>
                            <input type="hidden" value="${task.status}">
                            <input type="hidden" value="${task.idTarefa}">
                        </div>
                    </div>`;

                tasksList.appendChild(li);
            });
        }
    });
}

function deleteTask(id) {
    if (confirm('Tem certeza que deseja excluir?')) {
        $.ajax({
            url: 'actions/delete.php',
            type: 'POST',
            data: { id: id },
            success: function (response) {
                response = JSON.parse(response);

                if (response.error) return displayMessage(response.error, 'danger');

                displayMessage(response.success, 'success');
                getTasks();
            }
        });
    }
}

function updateStatus(id, element, status = 2) {
    let statusInput = element.nextElementSibling;

    status = statusInput.value == 2 ? 1 : 2;

    $.ajax({
        url: 'actions/update_status.php',
        type: 'POST',
        data: { id: id, status: status },
        success: function (response) {
            response = JSON.parse(response);

            if (response.error) return displayMessage(response.error, 'danger');

            displayMessage(response.success, 'success');
            getTasks();
        }
    });
}

function openTextarea(element) {
    let textarea = element.parentElement.parentElement.previousElementSibling,
        p = textarea.previousElementSibling;
    textarea.classList.toggle('active');
    textarea.focus();

    textarea.value = p.textContent;
}

function editTask(element, id) {
    let newDescription = element.value,
        currentDescription = element.previousElementSibling.textContent;

    newDescription = newDescription == "" ? currentDescription : newDescription;

    $.ajax({
        url: 'actions/edit.php',
        type: 'POST',
        data: {
            id: id,
            description: newDescription
        },
        success: function (response) {
            response = JSON.parse(response);

            if (response.error) return displayMessage(response.error, 'danger');

            displayMessage(response.success, 'success');
            getTasks();
        }
    });
}

function filterTasks() {
    let filter = select.value;
    
    localStorage.setItem('filter', filter);
    getTasks(filter);
}

form.addEventListener('submit', function (e) {
    e.preventDefault();
    addTask();
});

select.addEventListener('change', filterTasks);

getTasks();