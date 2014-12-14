# Install

Để sử dụng module, đầu tiên chúng ta đặt module vào đúng thư mục của ứng dụng app/modules.

Sau đó chúng ta khai báo trong app/config routeConfig.php để thiết lập path như sau:

```
    public $modules = array(
        /* Route config for modules */
        'post_post' => "PostController"
        ...
    );```

- **post_post**: Vì sao chúng ta phải tạo như vậy, ở đây nó có ý nghĩa như sau, post vừa là tên module, tên của một controller và action, khi bạn tạo như vậy thì nó sẽ có path như sau:

```
post/param```


Config structure.php

```
define('MODULES', DOCUMENT_ROOT . 'apps' . DS . 'modules' . DS);```


Người dùng có thể truy cập đến controller của module giống như controller bình thường. Chúng ta sẽ truy cập đến action trong module như sau:

Ví dụ: module post có controller tên PostController chúng ta sử dụng route content/post để tham chiếu tới action post trong controller này. URL tương ứng cho tuyến đường này sẽ là http://example.com/content/posts.

Đây là class Module của app:

```
class ModuleController extends AppController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function content()
    {
        $url            = $_SERVER["REQUEST_URI"];
        $params_full    = explode('/',$url);
        $lastParams     = explode('?',$params_full[count($params_full)-1]);
        $param          = $lastParams[0];
        $mod            = null;
        $modules        = Register::getAllModule();

        foreach($modules as $module)
        {
            if($module['func'] == $param)
            {
                $mod = $module;
                break;
            }
        }
        if($mod != null)
        {
            $controllerClass = $mod['controller'];
            $modController = new $controllerClass;
            if(method_exists($modController,$mod['func']))
            {
                $viewPath =$mod['viewPath'];
                $modController->$mod['func']($viewPath);
            }
        }
    }
}```

**Vậy chúng ta sẽ lướt qua cấu trúc của Module được viết như thế nào.**

- **controller**: chúng ta có thể tạo những controller khác nhau cho module này, trong controller chúng ta có thể chỉnh sửa những action tùy theo của mỗi dự án.
- **views**: chứa những layout khi bên trong controller render ra, chúng ta có thể chỉnh sửa nó tương ứng với các action trong controller.
- **element**: element cũng là một app nhỏ nó chứa những function, nó cũng render ra view giống như controller, và cách gọi element như sau:

```
$this->element('FriendRequestElement')
```


