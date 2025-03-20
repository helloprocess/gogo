<?php
// add.php - Bootstrap para UML-Writer
// Si tu proyecto usa un config.php que defina otros valores o constantes,
// inclúyelo. Si ya lo hace, ten en cuenta que puede volver a definir algunas constantes.
// Puedes comentar las definiciones duplicadas en config.php o, si prefieres, cargarlas aquí primero.
require_once __DIR__ . '/config.php';

// Ahora incluye los archivos de la carpeta libs en el orden adecuado.
// Es fundamental cargar primero las dependencias base (por ejemplo, LCPBase) antes que otros archivos.
require_once __DIR__ . '/libs/LCPBase.php';
require_once __DIR__ . '/libs/init.php';

require_once __DIR__ . '/libs/admin_user.php';
require_once __DIR__ . '/libs/annotation.php';
require_once __DIR__ . '/libs/backup.php';
require_once __DIR__ . '/libs/ban.php';

require_once __DIR__ . '/libs/facebook/base_facebook.php';
require_once __DIR__ . '/libs/facebook/facebook.php';

require_once __DIR__ . '/libs/webimages.php'; // para BasicThumb, HtmlImages, WebThumb
require_once __DIR__ . '/libs/blog.php';

require_once __DIR__ . '/libs/ts0.php';
require_once __DIR__ . '/libs/comment.php';
require_once __DIR__ . '/libs/commenttree.php';
require_once __DIR__ . '/libs/db_helper.php';

require_once __DIR__ . '/libs/haanga_mnm.php';

require_once __DIR__ . '/libs/preguntame.php';
require_once __DIR__ . '/libs/sponsor.php';
require_once __DIR__ . '/libs/link.php';
require_once __DIR__ . '/libs/link_validator.php';
require_once __DIR__ . '/libs/log.php';
require_once __DIR__ . '/libs/log_admin.php';
require_once __DIR__ . '/libs/mafia.php';
require_once __DIR__ . '/libs/media.php';
require_once __DIR__ . '/libs/html1.php';

require_once __DIR__ . '/libs/recaptchalib.php';
require_once __DIR__ . '/libs/recaptcha2.php';
require_once __DIR__ . '/libs/post.php';
require_once __DIR__ . '/libs/external_post.php';
require_once __DIR__ . '/libs/favorites.php';
require_once __DIR__ . '/libs/geo.php';
require_once __DIR__ . '/libs/sneak.php';
require_once __DIR__ . '/libs/tags.php';
require_once __DIR__ . '/libs/cabal.php';


require_once __DIR__ . '/libs/mail.php';
require_once __DIR__ . '/libs/report.php';
require_once __DIR__ . '/libs/rgdb.php';
require_once __DIR__ . '/libs/trackback.php';
require_once __DIR__ . '/libs/S3.php';
require_once __DIR__ . '/libs/simpleimage.php';
require_once __DIR__ . '/libs/sphinxapi.php';
require_once __DIR__ . '/libs/strike.php';
require_once __DIR__ . '/libs/tabs.php';
require_once __DIR__ . '/libs/time.php';
require_once __DIR__ . '/libs/upload.php';
require_once __DIR__ . '/libs/user.php';
require_once __DIR__ . '/libs/login.php';
require_once __DIR__ . '/libs/votes.php';
require_once __DIR__ . '/libs/uri.php';
require_once __DIR__ . '/libs/ads-credits-functions.php';
require_once __DIR__ . '/libs/avatars.php';
