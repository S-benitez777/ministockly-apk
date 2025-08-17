const API = "http://localhost:8012/miniStocklyApi/backEnd/";

const form = document.getElementById("form-producto");
const tabla = document.getElementById("tabla-productos");

function cargarProductos() {
  fetch(`${API}read.php`)
    .then(res => res.json())
    .then(data => {
      tabla.innerHTML = "";
      if (Array.isArray(data)) {
        data.forEach(producto => {
          const fila = document.createElement("tr");
          fila.innerHTML = `
            <td>${producto.nombre}</td>
            <td>${producto.cantidad}</td>
            <td>${producto.precio}</td>
            <td class="actions">
              <button class="edit-btn" onclick='editar(${JSON.stringify(producto)})'>Editar</button>
              <button class="delete-btn" onclick='eliminar(${producto.id})'>Eliminar</button>
            </td>
          `;
          tabla.appendChild(fila);
        });
      } else {
        tabla.innerHTML = `<tr><td colspan="4">${data.mensaje || "No hay productos"}</td></tr>`;
      }
    });
}

form.addEventListener("submit", e => {
  e.preventDefault();

  const id = document.getElementById("producto-id").value;
  const nombre = document.getElementById("nombre").value;
  const cantidad = document.getElementById("cantidad").value;
  const precio = document.getElementById("precio").value;

  // Incluye el id solo si existe (para update)
  const datos = id
    ? { id, nombre, cantidad, precio }
    : { nombre, cantidad, precio };

  const url = id ? "update.php" : "create.php";

  fetch(`${API}${url}`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(datos)
  })
    .then(res => res.json())
    .then(resp => {
      alert(resp.mensaje);
      form.reset();
      document.getElementById("producto-id").value = "";
      cargarProductos();
    });
});

window.editar = function(producto) {
  document.getElementById("producto-id").value = producto.id;
  document.getElementById("nombre").value = producto.nombre;
  document.getElementById("cantidad").value = producto.cantidad;
  document.getElementById("precio").value = producto.precio;
};

window.eliminar = function(id) {
  if (!confirm("¿Estás seguro de eliminar este producto?")) return;
  fetch(`${API}delete.php`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id })
  })
    .then(res => res.json())
    .then(resp => {
      alert(resp.mensaje);
      cargarProductos();
    });
};

window.onload = cargarProductos;
