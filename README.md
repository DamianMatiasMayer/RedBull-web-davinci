# RedBull Web - E-commerce Management System

## Descripción

Sistema web desarrollado en **PHP, MySQL y JavaScript** que permite administrar productos, categorías y usuarios mediante un panel administrativo.

Este proyecto fue desarrollado como práctica de desarrollo web para implementar funcionalidades comunes de sistemas de gestión.

---

## Problema

Muchos pequeños negocios no cuentan con herramientas simples para gestionar su catálogo de productos y usuarios desde una plataforma web centralizada.

---

## Solución

Este sistema permite:

- Administrar productos
- Administrar categorías
- Gestionar usuarios
- Subir imágenes de productos
- Controlar acceso mediante roles

Todo desde un **panel de administración web**.

---

## Funcionalidades

- Registro de usuarios
- Login con sesiones
- Gestión de roles (sysadmin, admin, usuario)
- CRUD de productos
- CRUD de categorías
- Subida de imágenes de productos
- Panel de administración
- Gestión de contraseña

---

## Tecnologías utilizadas

- PHP
- MySQL
- HTML
- CSS
- JavaScript

---

## Estructura del proyecto

RedBull-web-davinci
│
├── css/ # Estilos del sitio
├── js/ # Scripts de JavaScript
├── imagenes/ # Imágenes del proyecto
├── uploads/products/ # Imágenes subidas de productos
├── videos/ # Videos utilizados en el sitio
├── db_conn.php # Conexión a la base de datos
├── categorias-admin.php # Panel de administración de categorías
├── changePass.php # Cambio de contraseña
├── contacto.php # Página de contacto
├── energizantes.php # Página de productos energizantes
├── eventosYdeportes.php # Página de eventos y deportes

---

## Instalación

1. Clonar el repositorio

git clone https://github.com/DamianMatiasMayer/RedBull-web-davinci.git

2. Copiar el proyecto dentro de la carpeta de tu servidor local (por ejemplo **XAMPP htdocs**)

3. Crear la base de datos en **phpMyAdmin**

4. Importar el archivo `.sql` de la base de datos

5. Configurar la conexión en **db_conn.php**

6. Ejecutar el proyecto desde http://localhost/RedBull-web-davinci

---

## Autor

**Damian Matias Mayer**

Proyecto desarrollado como práctica de desarrollo web.
