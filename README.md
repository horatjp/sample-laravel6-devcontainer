# Laravel6 Sample Visual Studio Code Remote Container

Visual Studio CodeのRemote Containeを使ったLaravel6のサンプル。
[Visual Studio Code Remote - Containers](https://code.visualstudio.com/docs/remote/containers)

#### 開発環境1

* Docker Desktop
* Visual Studio Code [Remote - Containers]

#### 開発環境2

* Virtual Box
* Vagrant
* Docker CLI
* Docker Compose
* Visual Studio Code [Remote - Containers]



## 設定


```
git clone ... laravel6
cd laravel6
```
Visual Studio Codeを起動。

```
code .
```

環境設定ファイル作成。

```
cp .env.sample .env
```

`.devcontainer`にコンテナ構成ファイルがある。
`.devcontainer/docker-compose.yml`の環境変数として、`.env`が使われる。
データベースの値はここを参照している。



### 開発環境1


パーミッションを設定。
```
chmod -R 777 storage
chmod -R 777 bootstrap/cache
chmod -R 777 public/uploads
```

下記コマンドで`Remote - Containers`を起動
```
Remote-Containers: Reopen in composer Container
```


### 開発環境2

* Vagrant Plugin

```
vagrant plugin install vagrant-vbguest
vagrant plugin install dotenv
vagrant plugin install vagrant-disksize
vagrant plugin install vagrant-hostsupdater
vagrant plugin install vagrant-hostmanager
vagrant plugin install vagrant-docker-compose
```

コメントアウト。

`vi .env`

```
## VAGRANT
VAGRANT_DEVCONTAINER_PATH=/vagrant/.devcontainer/
VAGRANT_HOST="${APP_NAME}.test"
```

Vagrant起動。

```
vagrant up
```

`.vscode/settings.json` に`docker.host`が設定されているので、それを参考に、SSHでログインできるように公開鍵を登録する。
`known_hosts `に登録。
ログインできるか確認。
```
ssh-keygen -t ed25519 -C ""
cp ~/.ssh/id_ed25519.pub ./
vagrant ssh
cat /vagrant/id_ed25519.pub >> ~/.ssh/authorized_keys
rm /vagrant/id_ed25519.pub
exit

ssh-keygen -R laravel6.test
ssh-keyscan -H laravel6.test >> ~/.ssh/known_hosts
ssh vagrant@laravel6.test
```

`ssh-agent`に鍵を登録する。

```
ssh-add ~/.ssh/id_ed25519
```

拡張機能`Docker`で接続できるか確認。

下記コマンドで`Remote - Containers`を起動

```
Remote-Containers: Reopen in composer Container
```

###### **Tips**

公開鍵がRSAだとDockerホストに接続できない。

---

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

> 開発環境2の場合は`.env` `VAGRANT_HOST`でアクセス。

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
