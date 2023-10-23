
<?php
$pathPrefix = defined('BASE_PATH') ? BASE_PATH : "";
require_once $pathPrefix . "framework/autoload_static.php";
require_once "Customtest/autoload_static.php";

use Collection\Collection;
use Customtest\App\Http\Controllers\Web\ArticleController;
use Customtest\App\Http\Controllers\Web\WelcomeController;
use framework\Http\Middleware\VerifyCsrfTokenMiddleware;
use framework\Routing\Router;

/** */

/** components */

//param _method="" を指定すると GET PUT DELETE GET PATCH を区別できる

const VIEW_FILE_ROOT = "Customtest/resources";

/** sample */

Router::map("GET", "/", [ArticleController::class , "index"])->name('articles.index');
Router::map("GET", "/create", [ArticleController::class , "create"])->name('articles.create');
Router::map("POST", "/create", [ArticleController::class , "store"])->name('articles.store');

//Router::map("GET", "/:userId", [HogeHogeController:: class , "show"]);
//Router::map("POST", "/user", [HogeHogeController:: class , "create"]);
//Router::map("PATCH", "/:userId", [HogeHogeController:: class , "update"]);
//Router::map("DELETE", "/", [HogeHogeController:: class , "delete"]);

$router = new Router();
//$router->middleware();毎回必ずチェックする場合はこっち
$app = new Customtest\CustomtestApplication();
$exceptionHandler = new Customtest\Exceptions\ExceptionHandler();
$kernel = new \framework\Http\Kernel($app, $router, $exceptionHandler);
$request = new \framework\Http\Request();

$kernel->handle($request);
