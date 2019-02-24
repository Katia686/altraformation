<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'altraformation');

/** Имя пользователя MySQL */
define('DB_USER', 'atraformation-dbuser');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'altraformation');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '|4*T<}rce5weRC2Pl)rMEt[c.z (Bv#ab^vJC0xC6TvQZ@OB_?Zc.?[IP_},w*dD');
define('SECURE_AUTH_KEY',  '26~U;RG%=H#r/+~+m<45/$A502$%l&_8qK*NKZLs1;;9XE0ijrPCUSzM4^uJi+ui');
define('LOGGED_IN_KEY',    'tTvb>?vD&Kacov~vxl9N35_qm7>KWHrsd:6k*PH`i$-4R C`viwM~Uq+,84@PyV,');
define('NONCE_KEY',        'mX8h>X;`x$V;BtJi!mGF^`H@sGt^fv~rG7ZDG2cLzp{t$S{vcXhJb2V@u1.7b^>C');
define('AUTH_SALT',        'mx?i,)hkENmbh1ZcuDOZ#e}(-d&$d?q[(ps4#XSf8/B?BvU}A9f$5FK?7hPo.<]I');
define('SECURE_AUTH_SALT', 'B8,B@{HX#Nd98x7D<d)-MK( Ni>hC9z <7:GD w-b#v%98t47r5H4=w]JBmT/`?E');
define('LOGGED_IN_SALT',   'TF)IW!8_l.|**j;T[X_54*T!#MY/qSw-rb^*gMpza*:k)-YNSr#CrJ}0HA#&bF%!');
define('NONCE_SALT',       '*v88ZyPI]_9wzH4J;Q+T=BXfpD/LEfx;Ql~RjW~=INX=x@1xyP5V&R1OO]@ZL}-!');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
