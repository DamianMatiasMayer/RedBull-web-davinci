    function openModal(id){ document.getElementById(id).classList.add('is-open'); }
    function closeModal(id){ document.getElementById(id).classList.remove('is-open'); }

    function prefillEdit(id, nombre, padre_id){
      document.getElementById('id_editar').value = id;
      document.getElementById('nombreEditar').value = nombre;
      document.getElementById('padreEditar').value = padre_id || 0;
      openModal('modalEdit');
    }

    function prefillDelete(id, nombre){
      document.getElementById('del_id').textContent = id;
      document.getElementById('del_nombre').textContent = nombre;
      document.getElementById('id_eliminar').value = id;
      openModal('modalDelete');
    }