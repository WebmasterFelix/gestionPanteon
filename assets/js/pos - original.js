// Agregar clase al body cuando la página esté completamente cargada
document.addEventListener("DOMContentLoaded", function() {
	document.body.classList.add("sidebar-collapse");
});

const searchInput = document.getElementById('search-input');
const searchList = document.getElementById('search-list');

function fetchConceptos(query = '') {
    fetch('./assets/ajax/pos/search_products.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: query })
    })
    .then(response => response.json())
    .then(data => {
        const ul = searchList.querySelector('ul');
        ul.innerHTML = data.map(concepto => `
            <li data-id="${concepto.concepto_id}" data-price="${concepto.concepto_precio}">
                ${concepto.concepto_nombre} - $${concepto.concepto_precio}
            </li>
        `).join('');
        searchList.classList.remove('hidden');
    });
}

// Mostrar todos los conceptos al hacer clic en el input
searchInput.addEventListener('focus', () => fetchConceptos());

// Búsqueda en tiempo real
searchInput.addEventListener('input', function () {
    const query = this.value.trim();
    fetchConceptos(query);
});

// Manejar selección de concepto
searchList.addEventListener('click', function (event) {
    if (event.target.tagName === 'LI') {
        const conceptoId = event.target.getAttribute('data-id');
        const name = event.target.textContent.split(' - ')[0];
        const price = parseFloat(event.target.getAttribute('data-price'));

        // Obtener la tabla del carrito
        const table = document.querySelector('#carrito tbody');
        let productExists = false;

        // Verificar si el producto ya existe en el carrito
        table.querySelectorAll('tr').forEach(row => {
            if (row.getAttribute('data-id') === conceptoId) {
                const quantityCell = row.cells[2];
                const totalCell = row.cells[3];

                // Incrementar la cantidad
                const quantity = parseInt(quantityCell.textContent) + 1;
                quantityCell.textContent = quantity;

                // Actualizar el total para esta fila
                const newTotal = quantity * price;
                totalCell.textContent = newTotal.toFixed(2);

                productExists = true;
            }
        });

        // Si no existe, agregar una nueva fila
        if (!productExists) {
            table.innerHTML += `
                <tr data-id="${conceptoId}">
                    <td>${name}</td>
                    <td>${price.toFixed(2)}</td>
                    <td>1</td>
                    <td>${price.toFixed(2)}</td>
                    <td><button class="btn btn-danger remove-item">Eliminar</button></td>
                </tr>
            `;
        }

        // Actualizar el total general
        calculateTotal();

        // Ocultar la lista de búsqueda y limpiar el input
        searchList.classList.add('hidden');
        searchInput.value = '';
    }
});

// Calcular el total del carrito
function calculateTotal() {
    let total = 0;
    document.querySelectorAll('#carrito tbody tr').forEach(row => {
        const quantity = parseInt(row.cells[2].textContent);
        const price = parseFloat(row.cells[1].textContent);
        const subtotal = quantity * price;
        row.cells[3].textContent = subtotal.toFixed(2);
        total += subtotal;
    });

    // Restar descuento si está visible
    const descuentoAplicadoDiv = document.getElementById('descuento-aplicado');
    if (!descuentoAplicadoDiv.classList.contains('d-none')) {
        const descuentoTexto = descuentoAplicadoDiv.querySelector('h5 span').textContent;
        const montoDescuento = parseFloat(descuentoTexto.match(/\$(\d+\.\d+)/)[1]);
        total -= montoDescuento;
    }

    document.querySelector('.card-footer h4:last-child').textContent = `$${total.toFixed(2)}`;
}



// Cerrar la lista de búsqueda al hacer clic fuera del input
document.addEventListener('click', function (event) {
    if (!searchList.contains(event.target) && event.target !== searchInput) {
        searchList.classList.add('hidden');
    }
});

// Eliminar un producto del carrito
document.querySelector('#carrito').addEventListener('click', function (event) {
    if (event.target.classList.contains('remove-item')) {
        const row = event.target.closest('tr');
        row.remove(); // Elimina la fila del carrito
        calculateTotal(); // Recalcula el total después de eliminar
    }
});
// Vaciar todo el carrito
document.getElementById('vaciar-carrito').addEventListener('click', function(event) {
    event.preventDefault(); // Evita el comportamiento por defecto del enlace
    const tableBody = document.querySelector('#carrito tbody');
    tableBody.innerHTML = ''; // Elimina todo el contenido del tbody

    // Borrar completamente el descuento
    const descuentoAplicadoDiv = document.getElementById('descuento-aplicado');
    descuentoAplicadoDiv.classList.add('d-none');
    descuentoAplicadoDiv.querySelector('h5 span').textContent = 'Descuento de: ';

    calculateTotal(); // Recalcula el total (debería ser $0.00)
});

// Listar los contribuyentes en la ventana modal
document.addEventListener('DOMContentLoaded', function () {
    // Cargar contribuyentes al abrir el modal
    $('#contribuyentesModal').on('shown.bs.modal', function () {
        fetch('./assets/ajax/pos/get_contribuyentes.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener los datos.');
                }
                return response.json();
            })
            .then(data => {
                const listGroup = document.querySelector('#contribuyentesModal .list-group');
                if (data.length === 0) {
                    listGroup.innerHTML = '<li class="list-group-item text-center">No hay contribuyentes disponibles.</li>';
                } else {
                    listGroup.innerHTML = data.map(contribuyente => `
                        <li class="list-group-item contribuyente-item" 
                            data-id="${contribuyente.contribuyente_id}" 
                            data-nombre="${contribuyente.contribuyente_nombre}">
                            <strong>${contribuyente.contribuyente_nombre}</strong>
                            <br>
                            ${contribuyente.contribuyente_domicilio || ''} - ${contribuyente.contribuyente_ciudad || ''}
                        </li>
                    `).join('');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const listGroup = document.querySelector('#contribuyentesModal .list-group');
                listGroup.innerHTML = '<li class="list-group-item text-danger">Error al cargar los contribuyentes.</li>';
            });
    });
	
	// Manejar el cierre del modal y evitar foco en elementos con aria-hidden 
	$('#contribuyentesModal').on('hide.bs.modal', function () { 
		const activeElement = document.activeElement; 
		if (activeElement && activeElement.closest('#contribuyentesModal')) { 
			activeElement.blur(); 
		}
	});
	
	// Función para filtrar los contribuyentes según la búsqueda
    const searchInput = document.getElementById('contribuyente_search'); // Asegúrate de que este input exista en tu HTML
	
	searchInput.addEventListener('input', function () {
        const filter = searchInput.value.toLowerCase();
        const contribuyentes = document.querySelectorAll('.contribuyente-item');

        contribuyentes.forEach(item => {
            const nombre = item.dataset.nombre.toLowerCase();
            if (nombre.includes(filter)) {
                item.style.display = ''; // Mostrar el contribuyente
            } else {
                item.style.display = 'none'; // Ocultar el contribuyente
            }
        });
    });
});

//Seleccionar un contribuyente y agregar al carrito
document.querySelector('#contribuyentesModal .list-group').addEventListener('click', function (event) {
    if (event.target.classList.contains('contribuyente-item')) {
        const contribuyenteId = event.target.getAttribute('data-id');
        const contribuyenteNombre = event.target.getAttribute('data-nombre');

        // Mostrar el contribuyente en el carrito
        document.getElementById('carrito-contribuyente').textContent = `${contribuyenteNombre} (ID: ${contribuyenteId})`;

        // Cerrar el modal
        $('#contribuyentesModal').modal('hide');
    }
});
//Abrir modal de nuevo contribuyente
document.getElementById('openNuevoContribuyente').addEventListener('click', function () {
    $('#contribuyentesModal').modal('hide'); // Cerrar el modal actual
    $('#nuevoContribuyenteModal').modal('show'); // Mostrar el modal para nuevo contribuyente
});
//Guardar nuevo contribuyente y agregarlo al carrito
document.getElementById('guardarContribuyente').addEventListener('click', function () {
    const formData = new FormData(document.getElementById('formNuevoContribuyente'));
    fetch('./assets/ajax/pos/add_contribuyente.php', { // Ruta del archivo PHP
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mostrar automáticamente el contribuyente en el carrito
            const contribuyenteId = data.id;
            const contribuyenteNombre = formData.get('nombre');

            document.getElementById('carrito-contribuyente').textContent = `${contribuyenteNombre} (ID: ${contribuyenteId})`;

            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Contribuyente agregado exitosamente.',
                showConfirmButton: true
            });

            // Cerrar el modal
            $('#nuevoContribuyenteModal').modal('hide');
            $('#formNuevoContribuyente')[0].reset();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message,
                showConfirmButton: true
            });
        }
    });
});
/**************************************************************/
let tituloDescuentoAplicado = '';
document.getElementById('aplicarDescuento').addEventListener('click', function() {
    // Validar que hay conceptos en el carrito
    const carritoRows = document.querySelectorAll('#carrito tbody tr');
    if (carritoRows.length === 0) {
        // Cerrar la ventana modal con el ID "descuentosModal"
		$('#descuentosModal').modal('hide');
		// Mostrar el mensaje de error
		Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No hay conceptos en el carrito. Agregue conceptos antes de aplicar un descuento.',
            showConfirmButton: true
        });
        return;
    }
    // Validar que no haya un descuento existente
    const descuentoAplicadoDiv = document.getElementById('descuento-aplicado');
    if (!descuentoAplicadoDiv.classList.contains('d-none')) {
        // Cerrar la ventana modal con el ID "descuentosModal"
		$('#descuentosModal').modal('hide');
		// Mostrar el mensaje de error
		Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ya existe un descuento aplicado. Elimine el descuento actual antes de agregar uno nuevo.',
            showConfirmButton: true
        });
        return;
    }

    const descuentoInput = document.getElementById('valorDescuento');
    const tituloDescuento = document.getElementById('tituloDescuento');
    const valorDescuento = parseFloat(descuentoInput.value);
	const titulo = tituloDescuento.value.trim();
    
	// Validar descuento
    if (isNaN(valorDescuento) || valorDescuento < 0 || valorDescuento > 100) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor, ingrese un porcentaje de descuento válido entre 0 y 100.',
            showConfirmButton: true
        });
        return;
    }

    // Obtener el total actual
    const totalElement = document.querySelector('.card-footer h4:last-child');
    const totalActual = parseFloat(totalElement.textContent.replace('$', ''));

    // Calcular el descuento
    const montoDescuento = totalActual * (valorDescuento / 100);
    const totalConDescuento = totalActual - montoDescuento;

    // Actualizar div de descuento
	const descuentoTexto = descuentoAplicadoDiv.querySelector('h5 span'); 
	if (titulo !== '') { 
		descuentoTexto.textContent = `Descuento "${titulo}": ${valorDescuento}% (-$${montoDescuento.toFixed(2)})`; 
	} else { 
		descuentoTexto.textContent = `Descuento de: ${valorDescuento}% (-$${montoDescuento.toFixed(2)})`; 
	} 
	descuentoAplicadoDiv.classList.remove('d-none');

    // Actualizar el total
    calculateTotal();

    // Cerrar el modal
    $('#descuentosModal').modal('hide');

    // Limpiar los campos
    descuentoInput.value = '';
    tituloDescuento.value = '';
	
	// Almacenar el título del descuento en una variable global 
	tituloDescuentoAplicado = titulo;
});

// Eliminar descuento
document.getElementById('eliminar-descuento')?.addEventListener('click', function() {
    const descuentoAplicadoDiv = document.getElementById('descuento-aplicado');
    descuentoAplicadoDiv.classList.add('d-none');
    calculateTotal();
});

/*****************************************************/
document.getElementById('procesar-venta').addEventListener('click', function() {
    // Validate cart has items and contributor is selected
    const carritoRows = document.querySelectorAll('#carrito tbody tr');
    const contribuyente = document.getElementById('carrito-contribuyente').textContent;
    
    if (carritoRows.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'El carrito está vacío',
            showConfirmButton: true
        });
        return;
    }

    if (contribuyente === 'Ninguno Contribuyente') {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Seleccione un contribuyente',
            showConfirmButton: true
        });
        return;
    }

    // Prepare sale data
    const conceptos = Array.from(carritoRows).map(row => ({
        id: row.getAttribute('data-id'),
        cantidad: parseInt(row.cells[2].textContent),
        precio: parseFloat(row.cells[1].textContent)
    }));

    const totalElement = document.querySelector('.card-footer h4:last-child');
    const total = parseFloat(totalElement.textContent.replace('$', ''));

    const descuentoAplicadoDiv = document.getElementById('descuento-aplicado');
    const descuento = !descuentoAplicadoDiv.classList.contains('d-none') 
        ? parseFloat(descuentoAplicadoDiv.querySelector('h5 span').textContent.match(/\d+/)[0]) 
        : 0;
	
	// Log the tituloDescuento to check its value 
	//console.log('Título del descuento al procesar venta:', tituloDescuentoAplicado);
	
    // Send sale data to server
    fetch('./assets/ajax/pos/procesar_venta.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            contribuyente_id: contribuyente.match(/ID: (\d+)/)[1],
            conceptos: conceptos,
            total: total,
            descuento: descuento,
			titulo_descuento: tituloDescuentoAplicado
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Venta Procesada',
                text: `Venta #${data.venta_id} registrada exitosamente`,
                showConfirmButton: true
            }).then(() => {
                // Reset cart and UI
                document.querySelector('#carrito tbody').innerHTML = '';
                document.getElementById('carrito-contribuyente').textContent = 'Ninguno Contribuyente';
                document.getElementById('descuento-aplicado').classList.add('d-none');
                calculateTotal();
				const pdfUrl = `./assets/pdf/procesar_venta.php?venta_id=${data.venta_id}`;
				VentanaCentrada(pdfUrl, 'VentaPDF', '', 800, 600, 'true');
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message,
                showConfirmButton: true
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de Red',
            text: 'No se pudo conectar con el servidor',
            showConfirmButton: true
        });
    });
});