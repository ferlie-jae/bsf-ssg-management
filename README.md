<h2 align="center">Binmaley School of Fisheries SSG Mangement System</h2>

<hr>

<p>Installation on Windows with XAMPP:</p>

- Download and install the following:
  - <a href="https://www.apachefriends.org/xampp-files/7.4.24/xampp-windows-x64-7.4.24-0-VC15-installer.exe" target="_blank">XAMPP</a>
  - <a href="https://getcomposer.org/Composer-Setup.exe" target="_blank">Composer</a>
  - <a href="https://git-scm.com/download/win" target="_blank">Git</a>
- Open windows powershell or windows terminal.
- Execute this on shell/terminal: 
  ```PowerShell
  cd C:/xampp/htdocs
  ```
- Execute this on shell/terminal: 
  ```PowerShell
  git clone https://github.com/ferlie-jae/bsf-ssg-management.git
  ```
- Execute this on shell/terminal: 
  ```PowerShell
  cd bsf-ssg-management
  ```
- Execute this on shell/terminal: 
  ```PowerShell
  composer install
  ```
- Execute this on shell/terminal: 
  ```PowerShell
  cp .env.example .env
  ```
- Create database on http://localhost/phpmyadmin
  - Database Name: <code>bsf_ssg_management</code>
  - Collation: <code>utf8mb4_unicode_ci</code>
- Execute this on shell/terminal: 
  ```PowerShell
  php artisan key:generate
  ```
- Execute this on shell/terminal: 
  ```PowerShell
  php artisan config:cache
  ```
- Execute this on shell/terminal: 
  ```PowerShell
  php artisan install
  ```
- Execute this on shell/terminal: 
  ```PowerShell
  php artisan config:cache
  ```
- Open <code>C:/xampp/apache/conf/extra/httpd-vhost.conf</code> and add
  ```ApacheConf
  <VirtualHost *:80>
      DocumentRoot "C:/xampp/htdocs/bsf-ssg-management/public"
      ServerName bsf-ssg-management.me
  </VirtualHost>
  ```
    and save.
- Launch notepad as administrator and open <code>C:\Windows\System32\drivers\etc\hosts</code> file and add
    ```
    127.0.0.1     bsf-ssg-management.me
    ```
    and save
- Restart your Apache in XAMPP Control Panel.
- Open your browser and copy this link http://bsf-ssg-management.me to access the Web Application. Your can login as System Administrator using the credential below:
  - Username: master
  - Password: admin

<hr>

For update just open windows powershell or windows terminal then execute the following
```PowerShell
  cd C:/xampp/htdocs/bsf-ssg-management
```
and
```PowerShell
  git pull
```