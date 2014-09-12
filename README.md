Montana
============


Media Ads, sistema de advertising basado en API Google Double Click for Publishers, basado en Framework CakePhp


###Instalaci�n base


* Clonar repositorio
* Configurar credenciales MySql en `app/Config/database.php`
* Se recomienda cambiar los string de seguridad ubicados en `app/Config/core.php`, l�neas 215 y 219, [ac� un generador](http://www.sethcardoza.com/tools/random_password_generator)
* Una vez configurado lo anterior entrar al dominio definido http://tudominio.com/, donde pedira crear la cuenta de administrador.

###Configuraci�n aplicaci�n DFP [** Documentaci�n oficial **](https://developers.google.com/doubleclick-publishers/docs/start)


####Primera parte

Configuraci�n de credenciales en Google Developers

* Ir a [Google Developers Console](https://cloud.google.com/console)
* Crear un proyecto, guardar el ID de proyecto entreado
* Ir a API's & Auth -> Credentials
* Crear un nuevo cliente, "Create New Client ID"
* Seleccionar tipo aplicaci�n: Web application
* Agregar url de dominio en "AUTHORIZED JAVASCRIPT ORIGINS", ej: http://tudominio.com/
* Agregar url de dominio en "AUTHORIZED REDIRECT URI", ej: http://tudominio.com/callback


####Segunda parte

Configuraci�n de credenciales en Montana(obtenidas en Google Developers)

* Editar archivo `auth_dfp.ini` ubicado en `app/webroot/`
* Agregar valor a la variable `applicationName`, el valor a agregar es el ID de Proyecto entregado anteriormente
* Agregar valor a la variable `client_id`
* Agregar valor a la variable `client_secret`