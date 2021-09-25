# Laravel6 Sample Visual Studio Code Remote Container

Visual Studio Code の Remote Container を使った Laravel6 のサンプル。

[Visual Studio Code Remote - Containers](https://code.visualstudio.com/docs/remote/containers)

## 開発環境

-   Docker Desktop
-   Visual Studio Code [Remote - Containers]

## 設定

```
git clone https://github.com/horatjp/sample-laravel6-devcontainer.git laravel6
cd laravel6
```

Visual Studio Code を起動。

```
code .
```

環境設定ファイル作成。

```
cp .env.sample .env
```

```
cp .devcontainer/.env.sample .devcontainer/.env
```

`vi .devcontainer/.env`

```env
## Docker Desktop
DOCKER_DESKTOP_IP_ADDRESS_SETTING=127.0.1.11:
```

hosts

```
127.0.1.11 laravel6.test
```

下記コマンドで`Remote - Containers`を起動

```
Remote-Containers: Reopen in Container
```

## Laravel 初期設定

パーミッションを設定。

```
find storage -type d -exec chmod 777 {} \;
find bootstrap/cache -type d -exec chmod 777 {} \;
find public/uploads -type d -exec chmod 777 {} \;
```

```
composer install
```

```
php artisan key:gen
```

```
npm install
```

## サンプル

##### データベース構築

```
php artisan migrate:refresh --seed
```

パーミッションを設定。

```
find storage -type d -exec chmod 777 {} \;
```


##### フロント側

http://laravel6.test/

##### バックエンド側

http://laravel6.test/backend

```
メールアドレス: super-admin@laravel6
パスワード: password
```

### サンプルコマンド

サンプルコマンドが下記にあり。

```
app/Console/Commands/Sample
```

##### テストデータ作成

```
php artisan sample:Factory
```

### テスト

##### 単体・機能テスト

```
./vendor/bin/phpunit
```

##### ブラウザテスト

```
php artisan dusk
```


## その他

キャッシュクリア
```
sudo php artisan cache:clear
```

オートロード最適化
```
composer dump-autoload
```
