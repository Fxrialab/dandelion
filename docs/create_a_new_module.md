# Create new module

Làm sao để tạo một module đơn giản.

Trong app modules chúng ta sẽ tạo một module, ví dụ module post như sau:

Đây là cây thư mục của module post.


```
	---post
	        |---controllers
	        |---views
	        |---webroot
	        |---routeModuleConfig.php
	        |---router.php```

Trong module post gồm những chức năng như sau:

- route.php
- routeModuleConfig.php
- controllers
- views
- webroot

Các mục này đã giải thích ở phần Module.

Router

```
$url            = $_SERVER["REQUEST_URI"]; // get url '/content/group/successGroup'
$params_full    = explode('/',$url);
$lastParams     = explode('?',$params_full[count($params_full)-1]);
$param          = $lastParams[0];

if ($params_full && count($params_full) > 3)
{
    $routeModuleConfigFile = MODULES.$params_full[2]."/RouteModuleConfig.php";
    if (file_exists($routeModuleConfigFile))
    {
        include $routeModuleConfigFile;
        // Call post module route
        $routeModuleConfig  = new RouteModuleConfig;
        $routes             = $routeModuleConfig->route;
        foreach ($routes as $key=>$value)
        {
            $params      = substr($key, 0, strpos($key, '_'));
            $method      = substr($key, strpos($key, '_') + 1);
            $controllers = explode(',', $value);

            if ($params == $param)
            {
                // Set route
                $function = $params;
                $f3->route($method." /content/post/".$params,
                    array(new $controllers[0], $function)
                );
            }
        }
    }
}```

trong route.php sẽ tạo một class RouterMouldeConfig chứa những phương thức _GET, _POST cho từng acion có trong controller.

```
class RouteModuleConfig
{

    public $route = array(

        )
}
```

```
content/post/post?id=1 // get key id

```

Tiếp theo chúng ta sẽ tạo class PostController:

```
modules/post/controllers/PostController.php

class PostController extends AppController
{
     public function __construct()
        {
            parent::__construct();
        }
    }
    public function name()
    {

    }
}
```

Trong controler này bạn sẽ tạo các action mà bạn cần, bạn đặt tên action nào thì bạn quay lại
class RouteModuleConfig để config nó.

Ví dụ:

```
class RouteModuleConfig
{

    public $route = array(
        'actionName_POST|GET' => "PostController",
        )
}```

Bước cuối cùng là render ra view như sau

```
public fuction name(){
    $this->renderModule('post', 'post', array());
}
```
Chúng ta sẽ tạo ra forder views chứa những layout cần tạo.



