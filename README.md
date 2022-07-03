# Book Rental System



### 关于本项目

使用 Laravel9 + bootstrap5 编写的简单图书管理系统。

### 如何使用

1.  首先，确保node.js 和 PHP 已经安装。

2.  运行项目根目录中的 `init.bat`（windows下） 或 `init.sh`（linux下）对项目进行自动配置，完成后浏览器中访问127.0.0.1:8000，如果成功加载系统首页则说明配置成功，关闭配置文件。

3.  项目根目录下执行命令 

       ```
       php artisan serve
       ```

       之后浏览器访问127.0.0.1:8000即可测试运行本系统。

### 注意事项

- 本系统在数据库中写入了伪数据用于测试。执行命令 

  ```
  php artisan migrate:refresh
  ```

  以删除这些数据。如果删除后想重新生成测试数据，执行

  ```
  php artisan db:seed
  ```

- 系统中的两个默认账号：

  - 管理员
    - 账号：librarian@brs.com
    - 密码：password
  - 读者
    - 账号：reader@brs.com
    - 密码：password
