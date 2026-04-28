const API = "/todos";

async function loadTodos() {
  const res = await fetch(API);
  const data = await res.json();

  const list = document.getElementById("list");
  list.innerHTML = "";

  data.forEach(todo => {
    const li = document.createElement("li");

    li.innerHTML = `
      <input value="${todo.title}" onchange="editTodo(${todo.id}, this.value)">
      <button onclick="deleteTodo(${todo.id})">X</button>
    `;

    list.appendChild(li);
  });
}

async function addTodo() {
  const input = document.getElementById("todoInput");

  await fetch(API, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ title: input.value })
  });

  input.value = "";
  loadTodos();
}

async function editTodo(id, title) {
  await fetch(API, {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id, title })
  });

  loadTodos();
}

async function deleteTodo(id) {
  await fetch(`${API}?id=${id}`, {
    method: "DELETE"
  });

  loadTodos();
}

loadTodos();