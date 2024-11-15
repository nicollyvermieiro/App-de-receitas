document.addEventListener('DOMContentLoaded', function () {
    const userForm = document.getElementById('userForm');
    const userTableBody = document.getElementById('userTableBody');
    const submitButton = document.getElementById('submitButton');

    if (userForm) {
        userForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const id = document.getElementById('userId').value;
            if (id) {
                updateUser(id);
            } else {
                createUser();
            }
        });
    }

    if (userTableBody) {
        fetchUsers();
    }

    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const loginData = {
                email: document.getElementById('loginEmail').value,
                senha: document.getElementById('loginSenha').value,
            };

            fetch('http://localhost/App-de-receitas/public/api/usuarios/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(loginData),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        alert(data.message);
                        sessionStorage.setItem('userId', data.user.id);
                        sessionStorage.setItem('userName', data.user.nome);
                        window.location.href = 'crud_receitas.html';
                    }
                })
                .catch((error) => console.error('Error logging in:', error));
        });
    }
});

function fetchUsers() {
    fetch('http://localhost/App-de-receitas/public/api/usuarios')
        .then(response => response.json())
        .then(data => {
            const userTableBody = document.getElementById('userTableBody');
            if (userTableBody) {
                userTableBody.innerHTML = '';
                data.forEach(user => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${user.id}</td>
                        <td>${user.nome}</td>
                        <td>${user.email}</td>
                        <td>${new Date(user.dataCriacao).toLocaleDateString()}</td>
                        <td>
                            <button onclick="editUser(${user.id})" class="btn btn-sm btn-warning">Edit</button>
                            <button onclick="deleteUser(${user.id})" class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    `;
                    userTableBody.appendChild(row);
                });
            }
        })
        .catch(error => console.error('Error fetching users:', error));
}

function createUser() {
    const userData = {
        nome: document.getElementById('nome').value,
        email: document.getElementById('email').value,
        senha: document.getElementById('senha').value
    };

    fetch('http://localhost/App-de-receitas/public/api/usuarios', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(userData)
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                alert(data.message);
                fetchUsers();
                document.getElementById('userForm').reset();
            }
        })
        .catch(error => console.error('Error creating user:', error));
}

function editUser(id) {
    fetch(`http://localhost/App-de-receitas/public/api/usuarios/${id}`)
        .then(response => response.json())
        .then(user => {
            document.getElementById('userId').value = user.id;
            document.getElementById('nome').value = user.nome;
            document.getElementById('email').value = user.email;
            document.getElementById('senha').value = '';
            document.getElementById('submitButton').innerText = 'Update User';
        })
        .catch(error => console.error('Error fetching user:', error));
}

function updateUser(id) {
    const userData = {
        nome: document.getElementById('nome').value,
        email: document.getElementById('email').value,
        senha: document.getElementById('senha').value
    };

    fetch(`http://localhost/App-de-receitas/public/api/usuarios/${id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(userData)
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                alert(data.message);
                fetchUsers();
                document.getElementById('userForm').reset();
                document.getElementById('submitButton').innerText = 'Create User';
            }
        })
        .catch(error => console.error('Error updating user:', error));
}

function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user?')) {
        fetch(`http://localhost/App-de-receitas/public/api/usuarios/${id}`, {
            method: 'DELETE'
        })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    alert(data.message);
                    fetchUsers();
                }
            })
            .catch(error => console.error('Error deleting user:', error));
    }
}

document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const loginData = {
        email: document.getElementById('loginEmail').value,
        senha: document.getElementById('loginSenha').value
    };

    fetch('http://localhost/App-de-receitas/public/api/usuarios/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(loginData)
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                alert(data.message);
                sessionStorage.setItem('userId', data.user.id);
                sessionStorage.setItem('userName', data.user.nome);
                window.location.href = 'crud_receitas.html';
            }
        })
        .catch(error => console.error('Error logging in:', error));
});
