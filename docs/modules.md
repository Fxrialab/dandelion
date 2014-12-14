# Modules

####Giới thiệu về Modules trong Dandelion

Module trong Dandelion có thể xem như một application thu nhỏ, bao gồm models, views, controller và các elements tương tự như một application cơ bản. Module lớn có thể được triển khai độc lập như một application, hay kết hợp nhiều module với nhau xây dựng thành một application hoàn chỉnh.

Module rất hữu ích khi phát triển ứng dụng, giúp ta chia nhỏ ứng dụng thành các phần nhỏ hơn để dễ dàng phát triển và bảo trì. Những tính năng thường được sử dụng như quản lý người dùng, quản lý bình luận… có thể phát triển thành các module để dễ dàng tái sử dụng trong các dự án sau này.


Đây là cấu trúc của một module:


```
	---post
	        |---controllers
	        |---views
	        |---webroot
	        |---routeModuleConfig.php
	        |---router.php```
- **route.php**: cấu hình đường dẫn của modue.
- **controllers** : Chứa các action được viết cho modules.
- **views**: Chứa layout cho module.
- **webroot**: Chứa các tập tin hình ảnh js, css chỉ sử dụng riêng cho module này.

