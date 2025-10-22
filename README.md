# pruebaAdrianGuzman
Repositorio para alojar el proyecto con la prueba requerida.

El proyecto está creado en un Drupal 10 con ddev.
Tiene dos módulos:
- user_comment_stats: Módulo que proporciona un bloque de estadísticas de comentarios del usuario. Si accede al nodo, El bloque solo tendrá en cuenta los comentarios del usuario logueado. Si accedemos a la ficha de cada usuario, nos indicará las estadísticas del id de usuario que le proporciona la url.
- user__generator: Este módulo permite generar usuarios y comentarios de prueba de forma automática.
Al acceder a la ruta /admin/generate-random-users, crea 5 usuarios con nombres aleatorios y un 5 comentarios por cada usuario en el articulo con nodo 1. (Este controlador, se puede lanzar desde el enlace del footer)
