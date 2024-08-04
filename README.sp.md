[![Liberapay donations](https://img.shields.io/liberapay/receives/FreshRSS.svg?logo=liberapay)](https://liberapay.com/FreshRSS/donate)

* Lee este documento en [github.com/FreshRSS/FreshRSS/](https://github.com/FreshRSS/FreshRSS/blob/edge/README.md) para obtener los enlaces y las imágenes correctas.
* [Version française](README.fr.md)
* [Versión en inglés](README.md)

# FreshRSS

FreshRSS es un agregador de feeds RSS autoalojado.

Es ligero, fácil de manejar, potente y personalizable.

Es una aplicación multiusuario con un modo de lectura anónimo. Admite etiquetas personalizadas. Hay una API para clientes (móviles), y una [Interfaz de Línea de Comandos](cli/README.md).

Gracias al estándar [WebSub](https://freshrss.github.io/FreshRSS/en/users/WebSub.html),
FreshRSS puede recibir notificaciones instantáneas de fuentes compatibles, como [Friendica](https://friendi.ca), [WordPress](https://wordpress.org/plugins/pubsubhubbub/), Blogger, Medium, etc.

FreshRSS soporta de manera nativa [la extracción básica de datos web](https://freshrss.github.io/FreshRSS/en/users/11_website_scraping.html),
basada en [XPath](https://www.w3.org/TR/xpath-10/), para sitios web que no ofrecen feeds de RSS / Atom.
También admite documentos JSON.

FreshRSS ofrece la capacidad de [volver a compartir selecciones de artículos por HTML, RSS y OPML.](https://freshrss.github.io/FreshRSS/en/users/user_queries.html).

Se admiten diferentes [métodos de inicio de sesión: formulario web](https://freshrss.github.io/FreshRSS/en/admins/09_AccessControl.html), (incluyendo una opción anónima), Autenticación HTTP (compatible con delegación de proxy), y OpenID Connect.

Finalmente, FreshRSS soporta [extensiones](#extensions) para una mayor personalización.

* Sitio web oficial:: <https://freshrss.org>
* Demostración: <https://demo.freshrss.org>
* Licencia: [GNU AGPL 3](https://www.gnu.org/licenses/agpl-3.0.html)

![FreshRSS logo](docs/img/FreshRSS-logo.png)

## Retroalimentación y contribuciones

Las solicitudes de funciones, informes de errores, y otras contribuciones son bienvenidas.  La mejor manera es [abrir un problema en GitHub](https://github.com/FreshRSS/FreshRSS/issues).
Somos una comunidad amigable.

Para facilitar las contribuciones, the [está disponible la siguiente opción:](.devcontainer/README.md)

[![Open in GitHub Codespaces](https://github.com/codespaces/badge.svg)](https://github.com/codespaces/new?hide_repo_select=true&ref=edge&repo=6322699)

## Captura de pantalla

![FreshRSS screenshot](docs/img/FreshRSS-screenshot.png)

## Descargo de responsabilidad

FreshRSS se proporciona sin ningún tipo de garantía.

# [Documentación](https://freshrss.github.io/FreshRSS/en/)

* [Documentación para usuarios](https://freshrss.github.io/FreshRSS/en/users/02_First_steps.html), donde puedes descubrir todas las posibilidades que ofrece FreshRSS
* [Documentación para administradores](https://freshrss.github.io/FreshRSS/en/admins/01_Index.html) para tareas detalladas de instalación y mantenimiento
* [Documentación para desarrolladores](https://freshrss.github.io/FreshRSS/en/developers/01_Index.html) para guiarte en el código fuente de FreshRSS y ayudarte si deseas contribuir
* [Guías para contribuyentes](https://freshrss.github.io/FreshRSS/en/contributing.html) para aquellos que deseen ayudar a mejorar FreshRSS

# Requisitos

* Un navegador reciente como Firefox / IceCat, Edge, Chromium / Chrome, Opera, Safari.
	* Funciona en móviles (excepto algunas funciones)
* Servidor ligero que funcione en Linux o Windows
	* Incluso funciona en Raspberry Pi 1 con tiempos de respuesta menores a un segundo (probado con 150 feeds, 22k artículos)
* Un servidor web: Apache2.4+ (recomendado), nginx, lighttpd (no probado en otros)
* PHP 7.4+
	* Extensiones requeridas: [cURL](https://www.php.net/curl), [DOM](https://www.php.net/dom), [JSON](https://www.php.net/json), [XML](https://www.php.net/xml), [session](https://www.php.net/session), [ctype](https://www.php.net/ctype)
	* Extensiones recomendadas: [PDO_SQLite](https://www.php.net/pdo-sqlite) (para exportar/importar), [GMP](https://www.php.net/gmp) (para acceso a la API en plataformas de 32 bits), [IDN](https://www.php.net/intl.idn) (para nombres de dominio internacionalizados), [mbstring](https://www.php.net/mbstring) (para cadenas Unicode), [iconv](https://www.php.net/iconv) (para conversión de charset), [ZIP](https://www.php.net/zip) (para importar/exportar), [zlib](https://www.php.net/zlib) (para feeds comprimidos)
	* Extensión para base de datos: [PDO_PGSQL](https://www.php.net/pdo-pgsql) o [PDO_SQLite](https://www.php.net/pdo-sqlite) o [PDO_MySQL](https://www.php.net/pdo-mysql)
* PostgreSQL 9.5+ o SQLite or MySQL 5.5.3+ o MariaDB 5.5+

# [Instalación](https://freshrss.github.io/FreshRSS/en/admins/03_Installation.html)

La última versión estable se puede encontrar [aquí](https://github.com/FreshRSS/FreshRSS/releases/latest). Nuevas versiones se lanzan cada dos o tres meses.

Si deseas una versión continua con las características más nuevas, o quieres ayudar probando o desarrollando la próxima versión estable, puedes usar [la rama 'edge'](https://github.com/FreshRSS/FreshRSS/tree/edge/).

## Instalación automatizada

* [<img src="https://www.docker.com/wp-content/uploads/2022/03/horizontal-logo-monochromatic-white.png" width="200" alt="Docker" />](./Docker/)
* [![YunoHost](https://install-app.yunohost.org/install-with-yunohost.png)](https://install-app.yunohost.org/?app=freshrss)
* [![Cloudron](https://cloudron.io/img/button.svg)](https://cloudron.io/button.html?app=org.freshrss.cloudronapp)
* [![PikaPods](https://www.pikapods.com/static/run-button-34.svg)](https://www.pikapods.com/pods?run=freshrss)

## Instalación manual

1. Obtén FreshRSS con git o [descargando el archivo](https://github.com/FreshRSS/FreshRSS/archive/latest.zip)
2. Coloca la aplicación en algún lugar de tu servidor (expone solo la carpeta `./p/` a la Web)
3. Añade acceso de escritura a la carpeta `./data/` para el usuario del servidor web
4. Accede a FreshRSS con tu navegador y sigue el proceso de instalación
	* o usa [la Interfaz de Línea de Comandos](cli/README.md)
5. Todo debería estar funcionando :) Si encuentras algún problema, no dudes en [contactarnos](https://github.com/FreshRSS/FreshRSS/issues).
6. La configuración avanzada se puede encontrar en [config.default.php](config.default.php) y modificarse en `data/config.php`.
7. Cuando uses Apache, habilita [`AllowEncodedSlashes`](https://httpd.apache.org/docs/trunk/mod/core.html#allowencodedslashes) para una mejor compatibilidad con clientes móviles.

Puedes encontrar más información detallada sobre la instalación y configuración del servidor en [nuestra documentación](https://freshrss.github.io/FreshRSS/en/admins/03_Installation.html).

# Consejos

* Para mayor seguridad, expone solo la carpeta `./p/` a la Web.
	* Ten en cuenta que la carpeta `./data/` contiene todos los datos personales, por lo que es una mala idea exponerla.
* El archivo `./constants.php` define el acceso a la carpeta de la aplicación. Si quieres personalizar tu instalación, mira aquí primero.
* Si encuentras algún problema, los registros son accesibles desde la interfaz o manualmente en los archivos `./data/users/*/log*.txt`.
	* La carpeta especial `./data/users/_/` contiene la parte de los registros que son compartidos por todos los usuarios.


# Preguntas frecuentes

* La fecha y hora en la columna de la derecha es la fecha declarada por el feed, no la hora en que el artículo fue recibido por FreshRSS, y no se utiliza para la ordenación.
	* En particular, cuando se importa un nuevo feed, todos sus artículos aparecerán en la parte superior de la lista de feeds, independientemente de su fecha declarada.


# Extensiones

FreshRSS soporta personalizaciones adicionales añadiendo extensiones sobre su funcionalidad básica.
Consulta [el repositorio dedicado a esas extensiones](https://github.com/FreshRSS/Extensions).


# APIs y aplicaciones nativas

FreshRSS soporta el acceso desde aplicaciones móviles/nativas para Linux, Android, iOS, Windows y macOS, a través de dos APIs distintas:
[Google Reader API](https://freshrss.github.io/FreshRSS/en/users/06_Mobile_access.html) (la mejor),
y [Fever API](https://freshrss.github.io/FreshRSS/en/users/06_Fever_API.html) (características limitadas y menos eficiente).

| Aplicación                                                                            | Plataforma   | Software Libre                                               | Mantenida y Desarrollada | API              | Funciona sin conexión | Sincronización rápida | Buscar más en vistas individuales | Buscar artículos leídos | Favoritos | Etiquetas | Podcasts | Gestionar feeds |
|:--------------------------------------------------------------------------------------|:-----------:|:-------------------------------------------------------------:|:----------------------:|:----------------:|:-------------:|:---------:|:------------------------------:|:-------------------:|:----------:|:------:|:--------:|:------------:|
| [News+](https://github.com/noinnion/newsplus/blob/master/apk/NewsPlus_202.apk) with [Google Reader extension](https://github.com/noinnion/newsplus/blob/master/apk/GoogleReaderCloneExtension_101.apk) | Android | [Partially](https://github.com/noinnion/newsplus/blob/master/extensions/GoogleReaderCloneExtension/src/com/noinnion/android/newsplus/extension/google_reader/) | 2015       | GReader | ✔️             | ⭐⭐⭐       | ✔️                    | ✔️                 | ✔️         | ✔️     | ✔️       | ✔️           |
| [FeedMe](https://play.google.com/store/apps/details?id=com.seazon.feedme)*            | Android     | ➖                                                            | ✔️✔️                   | GReader          | ✔️            | ⭐⭐      | ➖                             | ➖                  | ✔️         | ✓     | ✔️       | ✔️           |
| [EasyRSS](https://github.com/Alkarex/EasyRSS)                                         | Android     | [✔️](https://github.com/Alkarex/EasyRSS)                      | ✔️                     | GReader          | Bug           | ⭐⭐      | ➖                             | ➖                  | ✔️         | ➖     | ➖       | ➖           |
| [Readrops](https://github.com/readrops/Readrops)                                      | Android     | [✔️](https://github.com/readrops/Readrops)                    | ✔️✔️                   | GReader          | ✔️            | ⭐⭐⭐    | ➖                             | ➖                  | ➖         | ➖     | ➖       | ✔️           |
| [Fluent Reader Lite](https://hyliu.me/fluent-reader-lite/)                            | Android, iOS| [✔️](https://github.com/yang991178/fluent-reader-lite)        | ✔️✔️                   | GReader, Fever   | ✔️            | ⭐⭐⭐    | ➖                             | ➖                  | ✓         | ➖     | ➖       | ➖           |
| [FocusReader](https://play.google.com/store/apps/details?id=allen.town.focus.reader)  | Android     | ➖                                                            | ✔️✔️                   | GReader          | ✔️            | ⭐⭐⭐    | ➖                             | ➖                  | ✔️         | ➖     | ✓       | ✔️           |
| [Read You](https://github.com/Ashinch/ReadYou/)                                       | Android     | [✔️](https://github.com/Ashinch/ReadYou/)                     | [en desarrollo](https://github.com/Ashinch/ReadYou/discussions/542)        | GReader, Fever   | ➖            | ⭐⭐     | ➖                    | ✔️                   | ✔️             | ➖     | ➖       | ✔️           |
| [ChristopheHenry](https://gitlab.com/christophehenry/freshrss-android)                | Android     | [✔️](https://gitlab.com/christophehenry/freshrss-android)     | en desarrollo        | GReader          | ✔️            | ⭐⭐      | ➖                             | ✔️                  | ✔️         | ➖     | ➖       | ➖           |
| [Fluent Reader](https://hyliu.me/fluent-reader/)                             | Windows, Linux, macOS| [✔️](https://github.com/yang991178/fluent-reader)             | ✔️✔️                   | GReader, Fever   | ✔️            | ⭐        | ➖                             | ✔️                  | ✓         | ➖     | ➖       | ➖           |
| [RSS Guard](https://github.com/martinrotter/rssguard)             | Windows, GNU/Linux, macOS, OS/2 | [✔️](https://github.com/martinrotter/rssguard)                | ✔️✔️                   | GReader          | ✔️            | ⭐⭐      | ➖ | ✔️ | ✔️ | ✔️ | ✔️ | ✔️ |
| [NewsFlash](https://gitlab.com/news-flash/news_flash_gtk)                             | GNU/Linux   | [✔️](https://gitlab.com/news-flash/news_flash_gtk)            | ✔️✔️                   | GReader, Fever | ➖            | ⭐⭐      | ➖                           | ✔️                | ✔️       | ✔️    | ➖      | ➖          |
| [Newsboat 2.24+](https://newsboat.org/)                                 | GNU/Linux, macOS, FreeBSD | [✔️](https://github.com/newsboat/newsboat/)                   | ✔️✔️                   | GReader          | ➖            | ⭐        | ➖                             | ✔️                  | ✔️         | ➖     | ✔️       | ➖           |
| [Vienna RSS](http://www.vienna-rss.com/)                                              | macOS       | [✔️](https://github.com/ViennaRSS/vienna-rss)                 | ✔️✔️                   | GReader          | ❔            | ❔        | ❔                             | ❔                  | ❔         | ❔     | ❔       | ❔           |
| [Readkit](https://apps.apple.com/app/readkit-read-later-rss/id1615798039)             | iOS, macOS  | ➖                                                            | ✔️✔️                   | GReader          | ✔️            | ⭐⭐⭐    | ➖                             | ✔️                  | ✔️         | ➖     | ✓       | 💲           |
| [Reeder](https://www.reederapp.com/)*                                                 | iOS, macOS  | ➖                                                            | ✔️✔️                   | GReader, Fever   | ✔️            | ⭐⭐⭐    | ➖                             | ✔️                  | ✔️         | ➖     | ➖       | ✔️           |
| [lire](https://lireapp.com/)                                                          | iOS, macOS  | ➖                                                            | ✔️✔️                   | GReader          | ❔            | ❔        | ❔                             | ❔                  | ❔         | ❔     | ❔       | ❔           |
| [Unread](https://apps.apple.com/app/unread-2/id1363637349)                            | iOS         | ➖                                                            | ✔️✔️                   | Fever            | ✔️            | ❔        | ❔                             | ❔                  | ✔️         | ➖     | ➖       | ➖           |
| [Fiery Feeds](https://apps.apple.com/app/fiery-feeds-rss-reader/id1158763303)         | iOS         | ➖                                                            | ✔️✔️                   | Fever            | ❔            | ❔        | ❔                             | ❔                  | ❔         | ➖     | ➖       | ➖           |
| [Netnewswire](https://ranchero.com/netnewswire/)                                      | iOS, macOS  | [✔️](https://github.com/Ranchero-Software/NetNewsWire)        | en desarrollo       | GReader          | ✔️            | ❔        | ❔                             | ❔                  | ✔️         | ➖     | ❔       | ✔️           |

\* Instala y habilita la extensión [GReader Redate extension](https://github.com/javerous/freshrss-greader-redate) para tener la fecha de publicación correcta para los artículos de feeds si estás usando Reeder 4 o FeedMe. (Ya no es necesario para Reeder 5)

# Bibliotecas incluidas

* [SimplePie](https://simplepie.org/)
* [MINZ](https://framagit.org/marienfressinaud/MINZ)
* [php-http-304](https://alexandre.alapetite.fr/doc-alex/php-http-304/)
* [lib_opml](https://framagit.org/marienfressinaud/lib_opml)
* [PhpGt/CssXPath](https://github.com/PhpGt/CssXPath)
* [PHPMailer](https://github.com/PHPMailer/PHPMailer)
* [Chart.js](https://www.chartjs.org)

## Solo para algunas opciones o configuraciones

* [bcrypt.js](https://github.com/dcodeIO/bcrypt.js)
* [phpQuery](https://github.com/phpquery/phpquery)

# Alternativas

Si FreshRSS no te conviene por una u otra razón, aquí tienes algunas soluciones alternativas a considerar:

* [Kriss Feed](https://tontof.net/kriss/feed/)
* [Leed](https://github.com/LeedRSS/Leed)
* [Y más…](https://alternativeto.net/software/freshrss/) (¡pero si te gusta FreshRSS, danos un voto!)
