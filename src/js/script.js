const form = document.querySelector('#form'),
    inputNewTask = form.querySelector('input'),
    tasksList = document.querySelector('#tasks'),
    messageContainer = document.querySelector('.message'),
    messageText = messageContainer.querySelector('p'),
    select = document.querySelector('select'),
    btnSignOut = document.querySelector('.getOutBtn');


const loader = {
    loader: document.querySelector('.loader'),
    show: function () {
        this.loader.classList.add('active');
    },
    hide: function () {
        this.loader.classList.remove('active');
    }
}

// functions
function displayMessage(message, status) {
    messageText.textContent = message;
    messageContainer.classList.add("active");
    messageContainer.classList.add(status);

    setTimeout(function () {
        messageContainer.classList.remove("active");
        messageContainer.classList.remove(status);
    }, 2000);
}

function openEditMode(element) {
    let div = element.parentElement.parentElement.previousElementSibling,
        paragraph = div.previousElementSibling,
        textarea = div.querySelector('textarea');

    div.classList.add('active');
    textarea.value = paragraph.textContent;
    textarea.focus();
}

function closeEditMode(element) {
    let div = element.parentElement.parentElement,
        textarea = div.querySelector('textarea'),
        paragraph = div.previousElementSibling,
        currentDescription = paragraph.textContent;

    div.classList.remove('active');
    textarea.value = currentDescription;
}

function getUserID() {
    // let email = localStorage.getItem('email'),
    //     password = localStorage.getItem('senha');

    // $.ajax({
    //     url: './actions/tasks/user_id.php',
    //     type: 'POST',
    //     data: {
    //         email: email,
    //         password: password
    //     },
    //     success: function (response) {
    //         let data = JSON.parse(response);

    //         if (data.error) return displayMessage(data.error, 'danger');

    //         return data.user_id;
    //     }
    // });

    return localStorage.getItem('idUsuario');
}

console.log(getUserID());

function addTask() {
    let task = inputNewTask.value,
        userId = getUserID();

    $.ajax({
        url: 'actions/tasks/insert.php',
        type: 'POST',
        data: { task: task, user_id: userId },
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

function filterTasks() {
    let filter = select.value;

    localStorage.setItem('filter', filter);
    getTasks(filter);
}

function deleteTask(id) {
    let userId = getUserID();

    $.ajax({
        url: 'actions/tasks/delete.php',
        type: 'POST',
        data: { id: id, user_id: userId },
        success: function (response) {
            response = JSON.parse(response);

            if (response.error) return displayMessage(response.error, 'danger');

            displayMessage(response.success, 'success');
            getTasks();
        }
    });
}

function updateStatus(id, element, status = 2) {
    let statusInput = element.nextElementSibling,
        userId = getUserID();


    status = statusInput.value == 2 ? 1 : 2;

    $.ajax({
        url: 'actions/tasks/update_status.php',
        type: 'POST',
        data: { id: id, status: status, user_id: userId },
        success: function (response) {
            response = JSON.parse(response);

            if (response.error) return displayMessage(response.error, 'danger');

            displayMessage(response.success, 'success');
            getTasks();
        }
    });
}

function editTask(element, id) {
    let div = element.parentElement.parentElement,
        textarea = div.querySelector('textarea'),
        paragraph = div.previousElementSibling,
        newDescription = textarea.value,
        currentDescription = paragraph.textContent;

    newDescription = newDescription == "" ? currentDescription : newDescription;

    $.ajax({
        url: 'actions/tasks/edit.php',
        type: 'POST',
        data: {
            idTarefa: id,
            description: newDescription,
        },
        success: function (response) {
            response = JSON.parse(response);

            if (response.error) return displayMessage(response.error, 'danger');

            console.log(response)

            displayMessage(response.success, 'success');
            getTasks();
        }
    });
}

function createListItem(task) {
    let li = document.createElement('li'),
        doneClass = statusTitle = "";

    doneClass = task.status == 2 ? 'done' : '';

    li.classList.add('task');
    task.status == 2 ? li.classList.add('done') : li.classList.add('not-done');
    task.status == 2 ? statusTitle = 'Marcar como não concluído' : statusTitle = 'Marcar como concluído';

    li.innerHTML = `
        <p class="text">${task.description}</p>
        <div class="edit_content">
            <textarea value="${task.description}"></textarea>
            <div class="buttons">
                <button class="save" onclick="editTask(this, ${task.idTarefa})"> <i class="fas fa-check"></i> </button>
                <button class="cancel" onclick="closeEditMode(this)"> <i class="fas fa-times"></i> </button>
            </div>
        </div>
        <div class="right">
            <div class="actions">
                <button onclick="deleteTask(${task.idTarefa})" title="Deletar tarefa"><i class="fas fa-trash-alt"></i></button>
                <button onclick="openEditMode(this)" title="Editar tarefa"><i class="fas fa-edit"></i></button>
            </div>
            <div class="status ${doneClass}" title="${statusTitle}">
                <i class="fas fa-check" onclick="updateStatus(${task.idTarefa}, this)"></i>
                <input type="hidden" value="${task.status}">
                <input type="hidden" value="${task.idTarefa}">
            </div>
        </div>`;

    tasksList.appendChild(li);
}

function getTasks(filter = "all") {
    filter = localStorage.getItem('filter') ? localStorage.getItem('filter') : filter;
    select.value = filter;
    let userId = getUserID();

    loader.show();

    $.ajax({
        url: 'actions/tasks/select.php',
        type: 'POST',
        data: { filter: filter, user_id: userId },
        success: function (response) {
            tasksList.innerHTML = '';
            response = JSON.parse(response);

            if (response.error) {
                let liHTML = `<li class="task"><p class="text">${response.error}</p></li>`
                tasksList.innerHTML = liHTML;
                loader.hide();
                return;
            }

            loader.hide();
            response.forEach(task => { createListItem(task) });
        }
    });
}

function checkLocalStorage() {
    if (!localStorage.getItem('email') || !localStorage.getItem('senha') || !localStorage.getItem('idUsuario'))
        window.location.href = './pages/login.php';
}

function checkLocalStorageTime() {
    let now = new Date().getTime(),
        lastTime = localStorage.getItem('lastTime');

    if (now - lastTime > 1800000) {
        window.location.href = './pages/login.php';
        removeStorage();
    }

    localStorage.setItem('lastTime', now);
}

function removeStorage() {
    localStorage.removeItem('email');
    localStorage.removeItem('senha');
    localStorage.removeItem('idUsuario');
    localStorage.removeItem('filter');
    window.location.href = './pages/login.php';
}

window.addEventListener('load', function () {
    if (localStorage.getItem('lastTime'))
        localStorage.setItem('lastTime', new Date().getTime());

    checkLocalStorage();
    getTasks();

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        addTask();
    });

    select.addEventListener('change', filterTasks);
    btnSignOut.addEventListener('click', removeStorage);
});