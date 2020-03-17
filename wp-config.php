<?php
/**
 * WordPress基础配置文件。
 *
 * 这个文件被安装程序用于自动生成wp-config.php配置文件，
 * 您可以不使用网站，您需要手动复制这个文件，
 * 并重命名为“wp-config.php”，然后填入相关信息。
 *
 * 本文件包含以下配置选项：
 *
 * * MySQL设置
 * * 密钥
 * * 数据库表名前缀
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/zh-cn:%E7%BC%96%E8%BE%91_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL 设置 - 具体信息来自您正在使用的主机 ** //
/** WordPress数据库的名称 */
define( 'DB_NAME', 'wordpress' );

/** MySQL数据库用户名 */
define( 'DB_USER', 'root' );

/** MySQL数据库密码 */
define( 'DB_PASSWORD', 'root' );

/** MySQL主机 */
define( 'DB_HOST', '127.0.0.1' );

/** 创建数据表时默认的文字编码 */
define( 'DB_CHARSET', 'utf8mb4' );

/** 数据库整理类型。如不确定请勿更改 */
define( 'DB_COLLATE', '' );

/**#@+
 * 身份认证密钥与盐。
 *
 * 修改为任意独一无二的字串！
 * 或者直接访问{@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org密钥生成服务}
 * 任何修改都会导致所有cookies失效，所有用户将必须重新登录。
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'XcNS3u1|/%>uuV,[0bJH^F@d+f^x3[OQ0kFrw$hCsqA6rwR}&,)^!)Qy,VQIV??u' );
define( 'SECURE_AUTH_KEY',  'zlvA[<Kfo#U!hg%}{7Kk,wzIxUn&p<}%tk0ce$sAZT2ScJ[.Z<ps;3 69CQ.W~_2' );
define( 'LOGGED_IN_KEY',    '3t2N1QRZ6@L) vi|[Hcx9SAl~-C;]BtjR`oB*;^%X7g5WKU.-WNA:U@C&+.l:eB`' );
define( 'NONCE_KEY',        '1UjUmYzQ6;Z(gK3vpO$Vx(E=8sp)#]z%SFklG*s!FQ#h~eVI.FQg^KJ ]4*_77!@' );
define( 'AUTH_SALT',        ';4dW>{@nbSSEHpX*#0tTcrz5&@PBJB+_G:,VAbF%YcDjI7C.,]q~N[!/!WikF/:f' );
define( 'SECURE_AUTH_SALT', '=|ro4p%Zv+D!Gu|`af7s:Ta=~(8~/k:c:zS4,Ywq6xYt6f.`(MD[q,}_h6U2yd9n' );
define( 'LOGGED_IN_SALT',   'oU!TO<I/kra7n}7E.]#A3HX;UEzG%e{50jmo,.Uv$(;8rup+_b-w^Ryl2MZ5g7k<' );
define( 'NONCE_SALT',       'CyVW|pbJZ7*b>>!l3+PNpQ9pFOCSJ~~`9{<I2s#2&-8~VoK^6%8]q,SprH<lr)+T' );
define("FS_METHOD", "direct");
##金庸ftp
define("FS_CHMOD_DIR", 0777);
define("FS_CHMOD_FILE", 0777);
/**#@-*/

/**
 * WordPress数据表前缀。
 *
 * 如果您有在同一数据库内安装多个WordPress的需求，请为每个WordPress设置
 * 不同的数据表前缀。前缀名只能为数字、字母加下划线。
 */
$table_prefix = 'wp_';

/**
 * 开发者专用：WordPress调试模式。
 *
 * 将这个值改为true，WordPress将显示所有用于开发的提示。
 * 强烈建议插件开发者在开发环境中启用WP_DEBUG。
 *
 * 要获取其他能用于调试的信息，请访问Codex。
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);

/* 好了！请不要再继续编辑。请保存本文件。使用愉快！ */

/** WordPress目录的绝对路径。 */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** 设置WordPress变量和包含文件。 */
require_once( ABSPATH . 'wp-settings.php' );
