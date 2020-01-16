# Docker

## コマンド

### コンテナの起動

```
$ docker-compose up -d
```

### コンテナの確認

```
$ docker-compose ps
```

### コンテナのログの確認

```
$ docker-compose logs
```

### コンテナの停止

```
$ docker-compose stop
```

### コンテナの削除

```
$ docker-compose down
```

コンテナをビルドし直したい場合。

```
$ docker-compose build --no-cache
```

### コンテナ内のbashを起動

```
$ docker exec -it <コンテナ名> bash
```

phpコンテナの場合。

```
$ docker exec -it php bash
```
