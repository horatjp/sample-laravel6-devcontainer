# Laravel6 Sample on Visual Studio Code Remote Container

Visual Studio CodeのRemote Containeを使ったLaravel6のサンプル。

[Visual Studio Code Remote - Containers](https://code.visualstudio.com/docs/remote/containers)

* Docker Desktop
* Visual Studio Code
* Visual Studio Code [Remote - Containers]


## 設定


```
git clone ... laravel6
cd laravel6
mv .env.sample .env
```
`.devcontainer`にコンテナ構成ファイルがある。
`.devcontainer/docker-compose.yml`の環境変数として、`.env`が使われる。
データベースの値はここを参照している。


パーミッションを設定。
```
chmod -R 777 storage
chmod -R 777 bootstrap/cache
chmod -R 777 public/uploads
```

Visual Studio Codeを起動。
```
code .
```

下記コマンドで`Remote - Containers`を起動
```
Remote-Containers: Reopen in composer Container
```
コンテナ`workspace`にログインした状態になる。

### Laravel初期設定

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

キャッシュをクリアする。
```
sudo php artisan cache:clear
```

##### フロント側
http://localhost/

##### バックエンド側
http://localhost/backend
```
メールアドレス：super-admin@laravel6
パスワード：password
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

## テスト
##### 単体・機能テスト
```
./vendor/bin/phpunit
```
##### ブラウザテスト
```
php artisan dusk
```
