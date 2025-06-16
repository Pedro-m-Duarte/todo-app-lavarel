# Laravel Development Setup

Este guia contém as instruções para configurar um ambiente de desenvolvimento Laravel diretamente em sua máquina com o PHP instalado localmente e usando o MySQL e  em contêiner Docker.

## Pré-requisitos para instalação em sistemas debian

- Sistema operacional baseado em Linux
- Acesso à linha de comando
- Permissões de administrador/sudo

## Instalação

### 1. PHP e Composer

1. **Atualize o sistema**:
  ``` bash
  sudo apt update && sudo apt upgrade -y
```


2. **Instale PHP e extensões necessárias**
``` bash
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install -y php8.2-cli php8.2-fpm php8.2-mysql php8.2-xml \
php8.2-mbstring php8.2-zip php8.2-curl php8.2-gd
```
3. **Instale Composer**
```bash
sudo php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
sudo php -r "unlink('composer-setup.php');"
```
4. **Verifique a Instalação**
```bash
php -v
composer --version
```
### 2. lavarel

1. **Instale o instalador do Laravel**:
```bash
composer global require laravel/installer
```
2. **Adicione o Composer ao PATH**: Adicione `~/.composer/vendor/bin` ou `~/.config/composer/vendor/bin` ao `PATH` do seu shell, dependendo do sistema.

### 3. Node.js
1. **Instale Node.js**
```bash
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs
```
2. **Verifique as instalações**
```bash
node -v
npm -v
```
### 4. Docker e  Docker Compose
1. **Instale o Docker**
```bash
sudo apt install -y apt-transport-https ca-certificates curl software-properties-common
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/$(lsb_release -cs) stable"
sudo apt update
sudo apt install -y docker-ce docker-compose
```
1. **Vefifique as instalações**
```bash
docker --version
docker-compose --version
```


## Setup do projeto
### Banco de dados
1. **Inicializar o container mysql**
```bash
docker compose -up -d mysql
```

### Configuração do Lavarel
1. **Gerar o arquivo .env**
```bash
php artisan key:generate
```
2. **Atualizar o arquivo .env com as credenciais do DB**
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=password
```
3. **Instalar  Dependenciais**
```bash
composer install
npm install
```
4. **Executar migration do banco de dados:**
```bash
php artisan migrate:fresh
```

#### Inicialização da aplicação
1. **Inicie o servidor de desenvolvimento Local**
```bash
php artisan serve
```

# Observações
- O frontend do projeto está no repositório https://github.com/Pedro-m-Duarte/frontend-task-manager-advisorh. 
- Somente as rotas de login e register podem ser acessadas sem token
  
