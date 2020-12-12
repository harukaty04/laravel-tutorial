# README

## このプロジェクトについて

laravelの環境構築用

## 構築手順

### コンテナの起動

```
cd laravel-docker-template
```

```
make build
```

```
make up
```

### Laravelのインストール

```
make create-project
```

### MySQLとの接続を設定

- .envファイルを下記のように設定

```
DB_CONNECTION=mysql
DB_HOST=db（←コンテナ名）
DB_PORT=3306（←コンテナ側のポート番号）
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=password
```

- .envの5行目も下記のように設定

```
APP_URL=http://localhost:8000
```

### artisanコマンドの実行場所

```
make work
```