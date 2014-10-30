Montana
============


Media Ads, sistema de advertising basado en API Google Double Click for Publishers, basado en Framework CakePhp


###Instalación base


* Clonar repositorio
* Configurar credenciales MySql en `app/Config/database.php`, utilizar archivo `montana.sql`ubicado en `sql/`
* Se recomienda cambiar los string de seguridad ubicados en `app/Config/core.php`, líneas 215 y 219, [acá un generador](http://www.sethcardoza.com/tools/random_password_generator)
* Una vez configurado lo anterior entrar al dominio definido http://tudominio.com/, donde pedira crear la cuenta de administrador.

###Configuración aplicación DFP [** Documentación oficial **](https://developers.google.com/doubleclick-publishers/docs/start)


####Primera parte

Configuración de credenciales en Google Developers

* Ir a [Google Developers Console](https://cloud.google.com/console)
* Crear un proyecto, guardar el ID de proyecto entreado
* Ir a API's & Auth -> Credentials
* Crear un nuevo cliente, "Create New Client ID"
* Seleccionar tipo aplicación: Installed application -> Other
* Obtener refresh_token
* Más información en: [** Authentication **](https://developers.google.com/doubleclick-publishers/docs/authentication?hl=es)


####Segunda parte

Configuración de credenciales en Montana(obtenidas en Google Developers)

_Mantener comillas a las varibles._


* Editar archivo `auth_dfp.ini` ubicado en `app/webroot/`
* Agregar valor a la variable `applicationName`, el valor a agregar es el ID de Proyecto entregado anteriormente
* Agregar valor a la variable `client_id`
* Agregar valor a la variable `client_secret`
* Agregar valor a la variable `refresh_token`

Voilà, es todo.